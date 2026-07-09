<?php

namespace App\Http\Livewire\RecordsManagement;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class Employees extends Component
{
    use WithPagination;

    public $pageSize = 15;     // Default page size
    public $offices = [];         // Variable to hold offices
    public $departments = [];     // Variable to hold departments
    public $search = '';     // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = '';     // Office filter variable
    public $fLType = '';     // Office Leave Type variable
    public $fLStatus = '';     // Office Leave Status variable
    public $fLdtFrom = ''; // Date From filter variable
    public $fLdtTo = '';     // Date To filter variable

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];


    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $users = $this->fetchUsersListing();
        $this->loadDropdowns();

        return view('livewire.records-management.employees', [
            'users' => $users,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }

    public function refreshComponent()
    {
        $this->reset('page');
    }


    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
        $this->lTypes = DB::table('leave_types')->get();
        $this->lStatus = DB::table('employment_statuses')->get();

        $holidays       = DB::table('holidays')->orderBy('holiday')->get();
        $this->employment_statuses    = DB::table('employment_statuses')->get();
        $this->genders        = DB::table('genders')->get();
        $this->civilStatuses  = DB::table('civil_statuses')->orderBy('id')->get();
        $this->nationalities  = DB::table('nationalities')->orderBy('nationality')->get();

        $this->heads = DB::table('users')
            ->select('employee_id', 'last_name', 'first_name', 'middle_name', 'suffix')
            ->where('is_head', 1)
            ->where('id', '!=', 1)
            ->orderBy('last_name')->orderBy('first_name')->orderBy('middle_name')
            ->get();

        $this->roleTypeUsers = DB::table('role_type_users')
            ->select('role_type')
            ->where('is_deleted', NULL)
            ->orWhere('is_deleted', 0)
            ->get();
    }


    public function clearDateFilters()
    {
        $this->fLdtFrom = null;
        $this->fLdtTo = null;
    }

    private function fetchUsersListing()
    {

        $employees = DB::table('users as u')
            ->select(
                'u.id',
                'u.name as full_name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                'u.position',
                DB::raw("CONCAT(u2.first_name, ' ', u2.last_name) as head_name"),
                'u.employment_status as status'
            )
            ->leftJoin('offices as o', 'u.office', '=', 'o.id')
            ->leftJoin('departments as d', 'u.department', '=', 'd.department_code')
            ->leftJoin('users as u2', 'u2.employee_id', '=', 'u.supervisor');
        // $employees = $employees->where(function ($query) {
        //          $query->where('l.is_deleted', 0)
        //              ->orWhereNull('l.is_deleted');
        //      });
        (Auth::user()->id != 1 && Auth::user()->id != 2) ? $employees = $employees->where('u.id', '<>', 1) : '';
        $employees = $employees->where(function ($query) {

            // Apply office filter if selected
            if (!empty($this->fTLOffice)) {
                $query->where('u.office', $this->fTLOffice);
            }
            // Apply department filter if selected
            if (!empty($this->fTLDept)) {
                $query->where('u.department', $this->fTLDept);
            }
            // Apply Leave Status filter if selected
            if (!empty($this->fLStatus)) {
                $query->where('u.employment_status', $this->fLStatus);
            }
            // Apply search query if search term is provided
            if (!empty($this->search)) {
                $searchTerms = explode(' ', $this->search);
                $query->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where(function ($query) use ($term) {
                            $query->whereRaw("CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) LIKE ?", ['%' . $term . '%'])
                                ->orWhere('u.name', 'like', '%' . $term . '%');
                        });
                    }
                })
                    ->orWhere('u.employee_id', 'like', '%' . $this->search . '%');
            }

            if (Auth::user()->id != 1) {

                $userAccess = DB::table('m_authorize_users')
                    ->where('u_id', Auth::user()->id)
                    ->first();

                if (!$userAccess) {
                    $query->where(function ($q) {
                        $q->where('u.employee_id', Auth::user()->employee_id)
                            ->orWhere('u.supervisor', Auth::user()->employee_id);
                    });
                } else {
                    if (is_null($userAccess->assigned_office)) {
                        $query->where(function ($q) {
                            $q->where('u.employee_id', Auth::user()->employee_id)
                                ->orWhere('u.supervisor', Auth::user()->employee_id);
                        });
                    } else {
                        $assignedOffices = explode('|', $userAccess->assigned_office);

                        $query->where(function ($q) use ($assignedOffices) {
                            $q->where('u.office', Auth::user()->office)
                                ->orWhereIn('u.office', $assignedOffices)
                                ->orWhere('u.supervisor', Auth::user()->employee_id);
                        });
                    }
                }
            }

            // Filter by deleted users
            $query->where(function ($q) {
                return $q->where('u.is_deleted', 0)
                    ->orWhereNull('u.is_deleted');
            });
        });
        $employees = $employees->orderBy('u.name')
            ->paginate($this->pageSize);

        return $employees;
    }



    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    public function fetchDetailedEmployee(Request $request)
    {
        $empid = $request->id;
        $getemployee = DB::table('users as u')
            ->select(
                'u.*',
                DB::raw("DATE_FORMAT(u.birthdate, '%m/%d/%Y') as birthday"),
                'u.date_regularized',
                DB::raw("CONCAT(u.home_address,', ',u.barangay,', ',u.city, ', ',u.province) as complete_address"),
                'p.country_name'
            )
            ->leftJoin('provinces as p', 'u.country', '=', 'p.country_code')
            ->where('u.id', $empid)
            ->first();
        $getLeaves = DB::table('leave_balances')->where('ref_id', $empid)->first();

        switch ($getemployee->gender) {
            case 'M':
                $profilePhoto = asset('storage/profile-photos/default-formal-male.png');
                break;
            case 'F':
                $profilePhoto = asset('storage/profile-photos/default-female.png');
                break;
            default:
                $profilePhoto = asset('storage/profile-photos/default-photo.png');
        }

        $profilePhotoPath  = $getemployee->profile_photo_path ? asset('storage/' . $getemployee->profile_photo_path) : $profilePhoto;

        $offices        = DB::table('offices')->orderBy('company_name')->get();
        $departments    = DB::table('departments')->orderBy('department')->get();
        $empStatuses    = DB::table('employment_statuses')->get();
        $genders        = DB::table('genders')->get();
        $civilStatuses  = DB::table('civil_statuses')->orderBy('id')->get();
        $nationalities  = DB::table('nationalities')->orderBy('nationality')->get();
        $weeklySched    = explode('|', $getemployee->weekly_schedule);

        $heads = DB::table('users')
            ->select(
                'employee_id',
                'last_name',
                'first_name',
                'middle_name',
                'suffix',
                DB::raw("CONCAT(last_name, ', ', first_name,
            		(CASE WHEN suffix IS NOT NULL THEN CONCAT(' ', suffix, ' ') ELSE ' ' END),
            		SUBSTRING(middle_name, 1, 1)) AS head_name")
            )
            ->where('is_head', 1)
            ->where('id', '!=', 1)
            ->orderBy('last_name')->orderBy('first_name')->orderBy('middle_name')
            ->get();

        $roleTypeUsers = DB::table('role_type_users')
            ->select('role_type')
            ->where('is_deleted', NULL)
            ->orWhere('is_deleted', 0)
            ->get();

        return view(
            'modals/records-management/m-employee-details',
            [
                'profilePhotoPath'    => $profilePhotoPath,
                'getemployee'        => $getemployee,
                'getLeaves'         => $getLeaves,
                'offices'            => $offices,
                'departments'        => $departments,
                'empStatuses'       => $empStatuses,
                'heads'                => $heads,
                'roleTypeUsers'        => $roleTypeUsers,
                'genders'            => $genders,
                'civilStatuses'        => $civilStatuses,
                'nationalities'        => $nationalities,
                'weeklySched'        => $weeklySched
            ]
        );
    }

    public function updateEmployeeInfo(Request $request)
    {
        return response()->json(['message' => 'No file uploaded.']);
        $this->validate([
            'photo' => 'nullable|image|max:2048', // Validate the file
        ]);

        // if ($this->photo) {
        //     // Store the file in 'public/photos'
        //     $path = $this->photo->store('photos', 'public');

        //     // Optionally, you can get more information about the file
        //     $originalName = $this->photo->getClientOriginalName();
        //     $extension = $this->photo->getClientOriginalExtension();
        //     $size = $this->photo->getSize();

        //     // Save the path or any other details in the database
        //     // Example: User::find($userId)->update(['profile_photo_path' => $path]);

        //     // Return response or perform further actions
        //     return response()->json([
        //         'path' => $path,
        //         'original_name' => $originalName,
        //         'extension' => $extension,
        //         'size' => $size,
        //         'message' => 'test upload'
        //     ]);
        // }

        // return response()->json(['message' => 'No file uploaded.'], 400);

        return '<pre>' . var_dump($request->all()) . '</pre>';

        /*$data = $request->all();
	    return response()->json(['data' => $data]);*/
    }
}
