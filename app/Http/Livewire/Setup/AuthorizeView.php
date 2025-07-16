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
    public $roleTypes;
    public $search='';
    public $fUserOffice='';
    public $fUserDept='';
    public $fUserRole='';

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];

    public function mount() {
        
        $this->loadDropdowns();
    }

    public function render()
    {
        $authorizeUser = $this->fetchUsersListing();
        $this->loadDropdowns();

        return view('livewire.setup.authorize-view-list', [
            'offices'       => $this->offices,
            'departments'   => $this->departments,
            'roleTypes'     => $this->roleTypes,
            'authorizeUser' => $authorizeUser,
        ]);
    }

    private function loadDropdowns() {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
        $this->roleTypes = DB::table('role_type_users')
        ->where(function ($query) {
            $query->whereNull('is_deleted')
            ->orWhere('is_deleted','!=',1);
        })
        ->get();
    }

    public function refreshComponent() {
        $this->reset('page');
    }
    public function pageSizeChanged($size) {
        $this->pageSize = $size;
        $this->resetPage();
    }

    private function fetchUsersListing() {
    	$authorizeUser = DB::table('users as u')
        ->leftJoin('offices as o','u.office','o.id')
        ->leftJoin('departments as d','u.department','d.department_code')
    	->select(
    		'u.id',
            'u.name',
    		'u.employee_id',
    		'o.company_name as office',
    		'd.department',
            'u.role_type'
    	)
        ->where(function ($query) {
            if(!empty($this->search)) {
                $searchTerms = explode(' ', $this->search);
                $query->where(function ($q) use ($searchTerms){
                    foreach ($searchTerms as $term) {
                        $q->where('u.name', 'like', '%'.$term.'%');
                    }
                })
                ->orWhere('u.employee_id', 'like', '%' . $this->search . '%');
            }
            if(!empty($this->fUserOffice)) {
                $query->where('u.office',$this->fUserOffice);
            }
            if(!empty($this->fUserDept)) {
                $query->where('u.department',$this->fUserDept);
            }
            if(!empty($this->fUserRole)) {
                $query->where('u.role_type',$this->fUserRole);
            }
        })
        ->where(function($query) {
            $query->where('u.role_type','ADMIN')
            ->orWhere('u.role_type','SUPER ADMIN');
        });

	    $authorizeUser = $authorizeUser->orderBy('u.name')
	    ->paginate($this->pageSize);

	    return $authorizeUser;
    }

    public function fetchDetailedUser (Request $request) {

        $userDetails = DB::table('users as u')
        ->leftJoin('offices as o','u.office','o.id')
        ->leftJoin('departments as d','u.department','d.department_code')
        ->select(
            'u.id',
            'u.name',
            'u.employee_id',
            'o.company_name as office',
            'd.department',
            'u.role_type'
        )
        ->where('u.id',$request->uID)
        ->first();

        $modules = DB::table('m_authorize_users')
        ->select('module_name', 'assigned_office')
        ->where('u_id',$request->uID)
        ->get();

        $this->loadDropdowns();

        return view('modals/setup/m-view-user-details',[
            'userDetails'   => $userDetails,
            'offices'       => $this->offices,
            'departments'   => $this->departments,
            'modules'       => $modules,
        ]);
    }

    public function saveAssignedViewing (Request $request) {
        try {
            $uID = $request->auData['uID'];
            $moduleNames = $request->auData['moduleNames'];
            // $offices = $request->auData['offices'] ?? ;

            // Check if modules and offices existing for authorization
            $userDetails = DB::table('m_authorize_users as a')
            ->select(
                DB::raw('COUNT(*) as n'),
                'a.module_name'
            )
            ->where('a.u_id',$uID)
            ->groupBy('a.module_name')
            ->get();

            if ($userDetails->isNotEmpty()) {
                // Update and/or insert if module not existing yet

            } else {
                // Insert modules and offices
                // return var_dump($request->auData['moduleNames']);
                $string = '';
                for ($i = 0; $i < count($moduleNames); $i++) {
                    $moduleName = $moduleNames[$i];
                    // Check if the office data exists and assign it
                    // If it's empty or not set, make it an empty string (or NULL if preferred)
                    $officeList = isset($request->auData['offices'][$i]) && !empty($request->auData['offices'][$i])
                        ? implode(',', $request->auData['offices'][$i]) // Join array values with a comma
                        : '';  // If no offices are selected, make it an empty string

                    // Prepare the data for insertion
                    $userData = [
                        'u_id'              => $uID,
                        'module_name'       => $moduleName,
                        'assigned_office'   => $officeList,
                        'created_by'        => Auth::user()->employee_id,
                        'created_at'        => DB::raw('NOW()'),
                        'updated_by'        => Auth::user()->employee_id,
                        'updated_at'        => DB::raw('NOW()')
                    ];

                    // // Extract values and convert DB expressions
                    // $values = array_map(function ($value) {
                    //     return ($value instanceof \Illuminate\Database\Query\Expression)
                    //         ? $value->getValue()
                    //         : $value;
                    // }, array_values($userData));

                    // // Prepare the string result in the desired format
                    // $string .= 'u_id: ' . $values[0] . ' | '
                    //     . 'module_name: ' . $values[1] . ' | '
                    //     . 'office: ' . $values[2] . ' | '
                    //     . 'created_by: ' . $values[3] . ' | '
                    //     . 'created_at: ' . $values[4] . ' | '
                    //     . 'updated_by: ' . $values[5] . ' | '
                    //     . 'updated_at: ' . $values[6] . '<br><br>';

                    // Uncomment the line below to actually insert into the database
                    DB::table('m_authorize_users')->insert($userData);
                }
                return response()->json(['isSuccess'=>true,'message' => 'Office assignment saved successfully']);

            }
        } catch(Exception $e){
            return response()->json(['isSuccess'=>false,'message' => $e]);
        }

        // return $dataUsers = var_dump($request->all());

        return response()->json([
            'isSuccess' => true,
            'message'   => 'Office assignment saved successfully.',
            'dataUsers' => $request->all(),
        ]);
    }
}
