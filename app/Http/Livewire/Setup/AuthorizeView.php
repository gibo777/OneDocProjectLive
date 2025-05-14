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
    	->leftJoin('offices as o','u.office','o.id')
    	->leftJoin('departments as d','u.department','d.department_code');

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
        ->where('u.id',$request->id)
        ->first();

        $this->loadDropdowns();

        return view('modals/setup/m-view-user-details',[
            'userDetails'   => $userDetails,
            'offices'       => $this->offices,
            'departments'   => $this->departments,
        ]);
    }
}
