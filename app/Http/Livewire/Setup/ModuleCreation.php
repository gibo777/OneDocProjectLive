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

class ModuleCreation extends Component
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

    public $mCategory='';
    public $mParentModule='';

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];

    public function mount() {
        
        $this->loadDropdowns();
    }

    public function render()
    {
        $moduleList = $this->fetchModuleListing();
        $this->loadDropdowns();

        return view('livewire.setup.module-creation', [
            'offices'       => $this->offices,
            'departments'   => $this->departments,
            'roleTypes'     => $this->roleTypes,
            'moduleList'    => $moduleList,
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

    private function fetchModuleListing() {
    	$moduleList = DB::table('m_navigation as m')
    	->select(
    		'm.id',
    		'm.nav_order',
            'm.module_name',
    		DB::raw('(SELECT module_name FROM m_navigation WHERE id=m.parent_id) AS parent_module'),
    		'm.module_category',
            'm.module_status'
    	);

	    $moduleList = $moduleList->orderBy('m.nav_order')
	    ->paginate($this->pageSize);

	    return $moduleList;
    }

    public function moduleCreation (Request $request) {

        $this->mCategory = DB::table('m_module_categories')->get();
        $this->mParentModule = DB::table('m_navigation')
        ->where('module_category','MAIN')
        ->orderBy('nav_order')
        ->get();

        return view('modals/setup/m-create-module',[
            'moduleCategories'  => $this->mCategory,
            'parentModules'     => $this->mParentModule,
        ]);
    }

    public function createModule (Request $request) {
        // return response()->json($request->all());
        try {
            $moduleData = [
                'nav_order'         => $request->navOrder,
                'module_name'       => strtoupper(preg_replace('/\s+/', ' ', trim($request->moduleName))),
                'parent_id'         => $request->parentModule ?? null,
                'module_category'   => strtoupper($request->moduleCategory),
                'created_by'        => Auth::user()->employee_id,
                'created_at'        => DB::raw('NOW()'),
                'updated_by'        => Auth::user()->employee_id,
                'updated_at'        => DB::raw('NOW()')
            ];

            $createdModule = DB::table('m_navigation')->insert($moduleData);

            if ($createdModule) {
                return response()->json([
                    'isSuccess'     => true,
                    'message'       => 'Module creation successful!',
                    // 'responseData'  => $request->all(),
                ]);
            } else {
                return response()->json(['isSuccess'=>false,'message'=>'Module creation failed.',
                ]);
            }
        } catch(Exception $e){
            return response()->json(['isSuccess'=>false,'message' => $e]);
        }
    }
}

