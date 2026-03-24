<?php

namespace App\Http\Livewire\Setup;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AuthorizeView extends Component
{
    use WithPagination;

    public $pageSize = 10;
    public $offices;
    public $departments;
    public $statuses;
    public $roleTypes;
    public $search = '';
    public $fUserOffice = '';
    public $fUserDept = '';
    public $fUserStatus = '';
    public $fUserRole = '';

    // Detail view properties
    public $selectedUserId = null;
    public $selectedUser   = null;
    public $selectedModules = [];

    public $aUserRole = '';

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];

    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $authorizeUser = $this->fetchUsersListing();
        $this->loadDropdowns();

        return view('livewire.setup.authorize-view-list', [
            'offices'         => $this->offices,
            'departments'     => $this->departments,
            'statuses'        => $this->statuses,
            'roleTypes'       => $this->roleTypes,
            'authorizeUser'   => $authorizeUser,
            'selectedUserId'  => $this->selectedUserId,
            'selectedUser'    => $this->selectedUser,
            'selectedModules' => $this->selectedModules,
        ]);
    }

    private function loadDropdowns()
    {
        $this->offices      = DB::table('offices')->orderBy('company_name')->get();
        $this->departments  = DB::table('departments')->orderBy('department')->get();
        $this->statuses     = DB::table('employment_statuses')->where('employment_status', '<>', 'NO LONGER CONNECTED')->get();
        $this->roleTypes    = DB::table('role_type_users')
            ->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', '!=', 1);
            })
            ->get();
    }

    public function refreshComponent()
    {
        $this->reset('page');
    }

    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }


    private function fetchUsersListing()
    {
        $authorizeUser = DB::table('users as u')
            ->leftJoin('offices as o', 'u.office', 'o.id')
            ->leftJoin('departments as d', 'u.department', 'd.department_code')
            ->leftJoin('m_authorize_users as au', 'u.id', '=', 'au.u_id')
            ->select(
                'u.id',
                'u.name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                'u.role_type',
                'u.employment_status',
                DB::raw('(
                SELECT GROUP_CONCAT(off.company_name ORDER BY off.id SEPARATOR ", ")
                FROM offices AS off
                WHERE FIND_IN_SET(off.id, REPLACE(au.assigned_office, "|", ",")) > 0
                ) as assigned_offices')
            );

        if (Auth::user()->id !== 1) {
            $authorizeUser->where('u.id', '<>', 1)
                ->where('u.role_type', '<>', 'SUPER ADMIN');
        }
        /* ->where(function ($query) {
                $query->where('u.role_type', 'ADMIN')
                    ->orWhere('u.role_type', 'SUPER ADMIN');
            }) */
        $authorizeUser->where('u.employment_status', '<>', 'NO LONGER CONNECTED')
            ->where(function ($query) {
                if (!empty($this->search)) {
                    $searchTerms = explode(' ', $this->search);

                    // Name search for all search terms
                    $query->where(function ($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $q->where('u.name', 'like', '%' . $term . '%');
                        }
                    });

                    // Additional search options
                    if (Auth::user()->id == 1) {
                        $query->orWhere('u.id', $this->search);
                    }

                    $query->orWhere('u.employee_id',  $this->search);
                }

                // Filters
                if (!empty($this->fUserOffice)) {
                    $query->where('u.office', $this->fUserOffice);
                }
                if (!empty($this->fUserDept)) {
                    $query->where('u.department', $this->fUserDept);
                }
                if (!empty($this->fUserRole)) {
                    $query->where('u.role_type', $this->fUserRole);
                }
                if (!empty($this->fUserStatus)) {
                    $query->where('u.employment_status', $this->fUserStatus);
                }
            });

        return $authorizeUser->orderBy('u.name')->paginate($this->pageSize);
    }

    /**
     * Called on double-click of a row.
     * Loads the user detail and modules, switches view to detail.
     */
    public function selectUser($id)
    {
        $this->selectedUserId = $id;

        $user = DB::table('users as u')
            ->leftJoin('offices as o', 'u.office', 'o.id')
            ->leftJoin('departments as d', 'u.department', 'd.department_code')
            ->select(
                'u.id',
                'u.name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                'u.role_type'
            )
            ->where('u.id', $id)
            ->where('u.employment_status', '<>', 'NO LONGER CONNECTED')
            ->first();

        $this->selectedUser = $user ? (array) $user : null;

        // Check if record exists, if not create a blank one
        $existing = DB::table('m_authorize_users')->where('u_id', $id)->first();

        if (!$existing) {
            DB::table('m_authorize_users')->insert([
                'u_id'            => $id,
                'assigned_office' => null,
                'created_by'      => Auth::user()->employee_id,
                'created_at'      => DB::raw('NOW()'),
                'updated_by'      => Auth::user()->employee_id,
                'updated_at'      => DB::raw('NOW()'),
            ]);
        }

        $modules = DB::table('m_authorize_users as a')
            ->leftJoin('users as u', 'a.u_id', '=', 'u.id')
            ->select(
                'a.id',
                'a.assigned_office',
                DB::raw('(
                SELECT GROUP_CONCAT(o.company_name ORDER BY o.id SEPARATOR ", ")
                FROM offices as o
                WHERE FIND_IN_SET(o.id, REPLACE(a.assigned_office, "|", ",")) > 0
            ) as assigned_office_names')
            )
            ->where('a.u_id', '=', $id)
            ->get();

        $this->aUserRole = $user->role_type ?? '';
        $this->selectedModules = $modules->map(fn($m) => (array) $m)->toArray();

        $this->dispatchBrowserEvent('detail-view-loaded');
    }

    /**
     * Clears the selected user and returns to the listing view.
     */
    public function clearSelectedUser()
    {
        $this->selectedUserId  = null;
        $this->selectedUser    = null;
        $this->selectedModules = [];
    }

    /* public function saveAssignedViewing(Request $request)
    {
        try {
            $uID     = $request->auData['uID'];
            $modules = $request->auData['modules'];

            foreach ($modules as $module) {

                $moduleID   = $module['module_id'];
                $officeList = !empty($module['offices'])
                    ? implode(',', $module['offices'])
                    : '';

                $existing = DB::table('m_authorize_users')
                    ->where('u_id', $uID)
                    ->where('module_id', $moduleID)
                    ->first();

                $data = [
                    'u_id'            => $uID,
                    'module_id'       => $moduleID,
                    'assigned_office' => $officeList,
                    'updated_by'      => Auth::user()->employee_id,
                    'updated_at'      => DB::raw('NOW()')
                ];

                if ($existing) {
                    DB::table('m_authorize_users')
                        ->where('id', $existing->id)
                        ->update($data);
                } else {
                    $data['created_by'] = Auth::user()->employee_id;
                    $data['created_at'] = DB::raw('NOW()');

                    DB::table('m_authorize_users')->insert($data);
                }
            }

            return response()->json([
                'isSuccess' => true,
                'message'   => 'Office assignment saved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'isSuccess' => false,
                'message'   => $e->getMessage()
            ]);
        }
    } */

    public function saveAssignedViewing(Request $request)
    {
        try {
            $uID       = (int) $request->uID;
            $modules   = $request->moduleOffices ?? [];
            $aUserRole = $request->aUserRole;

            // Get current role from users table
            $currentRole = DB::table('users')->where('id', $uID)->value('role_type');

            // Update role only if changed
            if ($currentRole !== $aUserRole) {
                DB::table('users')
                    ->where('id', $uID)
                    ->update([
                        'role_type' => $aUserRole,
                        'is_head'   => in_array($aUserRole, ['ADMIN', 'SUPER ADMIN']) ? 1 : 0
                    ]);
            }

            foreach ($modules as $moduleID => $offices) {
                $moduleID = (int) $moduleID;

                // Save null if no offices selected, otherwise pipe-separated string
                $officeList = !empty($offices) ? implode('|', $offices) : null;

                $existing = DB::table('m_authorize_users')
                    ->where('u_id', $uID)
                    ->first();

                if ($existing) {
                    DB::table('m_authorize_users')
                        ->where('id', $existing->id)
                        ->update([
                            'assigned_office' => $officeList,
                            'updated_by'      => Auth::user()->employee_id,
                            'updated_at'      => DB::raw('NOW()')
                        ]);
                } else {
                    DB::table('m_authorize_users')->insert([
                        'u_id'            => $uID,
                        'assigned_office' => $officeList,
                        'updated_by'      => Auth::user()->employee_id,
                        'updated_at'      => DB::raw('NOW()'),
                        'created_by'      => Auth::user()->employee_id,
                        'created_at'      => DB::raw('NOW()')
                    ]);
                }
            }

            // If no modules passed at all, still ensure record exists with null
            if (empty($modules)) {
                $existing = DB::table('m_authorize_users')->where('u_id', $uID)->first();

                if ($existing) {
                    DB::table('m_authorize_users')
                        ->where('id', $existing->id)
                        ->update([
                            'assigned_office' => null,
                            'updated_by'      => Auth::user()->employee_id,
                            'updated_at'      => DB::raw('NOW()')
                        ]);
                } else {
                    DB::table('m_authorize_users')->insert([
                        'u_id'            => $uID,
                        'assigned_office' => null,
                        'updated_by'      => Auth::user()->employee_id,
                        'updated_at'      => DB::raw('NOW()'),
                        'created_by'      => Auth::user()->employee_id,
                        'created_at'      => DB::raw('NOW()')
                    ]);
                }
            }

            return response()->json([
                'isSuccess' => true,
                'message'   => 'Office assignment saved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'isSuccess' => false,
                'message'   => $e->getMessage()
            ]);
        }
    }
}
