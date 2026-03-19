<?php

namespace App\Http\Livewire\Setup;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;

class ModuleCreation extends Component
{
    use WithPagination;

    public $pageSize = 10;

    public $offices = [];
    public $departments = [];
    public $roleTypes = [];

    public $search = '';
    public $fUserOffice = [];
    public $fUserDept = [];
    public $fUserRole = [];

    public $fNavCategory;

    public $mCategory = [];
    public $mParentModule = [];

    public $createNavCategory;
    public $createNavParent;
    public $createModuleName;
    public $createNavOrder;

    protected $listeners = [
        'pageSizeChanged',
        'refreshComponent',
        'loadParentModules',
    ];

    protected $rules = [
        'createNavCategory' => 'required|string|max:50',
        'createNavParent'   => 'nullable|integer',
        'createModuleName'  => 'required|string|max:255',
        'createNavOrder'    => 'nullable|integer',
    ];

    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        return view('livewire.setup.module-creation', [
            'moduleList' => $this->fetchModuleListing(),
            'mCategory' => $this->mCategory,
            'mParentModule' => collect($this->mParentModule),
        ]);
    }

    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
        $this->roleTypes = DB::table('role_type_users')
            ->whereNull('is_deleted')
            ->orWhere('is_deleted', '!=', 1)
            ->get();

        $this->mCategory = DB::table('m_module_categories')->orderBy('category_name')->get();
        $this->mParentModule = [];
    }

    public function loadParentModules($category)
    {
        $this->createNavCategory = $category;
        $this->createNavParent = null;
        $this->mParentModule = [];

        if (!$category) return;

        $category = strtoupper($category);

        // if ($category === 'MAIN') return;

        if (in_array($category, ['MAIN', 'FORM', 'VIEW', 'PROCESS', 'SETUP'])) {
            $this->mParentModule = DB::table('m_navigation')
                ->where('module_category', 'MAIN')
                ->orderBy('nav_order')
                ->get();
        }

        if ($category === 'REPORT') {
            $this->mParentModule = DB::table('m_navigation')
                ->where('module_category', 'LISTING')
                ->orderBy('nav_order')
                ->get();
        }

        $this->emit('parentModulesUpdated', $this->mParentModule);
    }

    public function moduleCreation()
    {
        if (empty($this->mCategory)) {
            $this->loadDropdowns();
        }

        return view('modals/setup/m-create-module', [
            'moduleCategories' => $this->mCategory,
            'parentModules'    => $this->mParentModule,
        ]);
    }

    public function createModule()
    {
        $this->validate();

        $category = strtoupper($this->createNavCategory);

        return response()->json([
            'category' => $category,
        ]);

        if ($category === 'MAIN') {
            $this->createNavParent = null;
        }

        if (in_array($category, ['FORM', 'VIEW', 'PROCESS', 'SETUP'])) {
            $parent = DB::table('m_navigation')
                ->where('id', $this->createNavParent)
                ->where('module_category', 'MAIN')
                ->first();

            if (!$parent) $this->createNavParent = null;
        }

        if ($category === 'REPORT') {
            $parent = DB::table('m_navigation')
                ->where('id', $this->createNavParent)
                ->where('module_category', 'VIEW')
                ->first();

            if (!$parent) $this->createNavParent = null;
        }

        try {
            $data = [
                'nav_order'       => $this->createNavOrder,
                'module_name'     => strtoupper(trim(preg_replace('/\s+/', ' ', $this->createModuleName))),
                'parent_id'       => $this->createNavParent,
                'module_category' => $category,
                'created_by'      => Auth::user()->employee_id,
                'created_at'      => now(),
                'updated_by'      => Auth::user()->employee_id,
                'updated_at'      => now(),
            ];

            return response()->json([
                'data' => $data,
            ]);

            $result = DB::table('m_navigation')->insert($data);

            \Log::info('m_navigation insert executed', [
                'success' => $result,
                'data' => $data,
                'user' => Auth::user()->employee_id
            ]);
        } catch (\Exception $e) {
            \Log::error('m_navigation insert failed', [
                'error' => $e->getMessage(),
                'data' => $data ?? null,
                'user' => Auth::user()->employee_id
            ]);

            throw $e;
        }

        $this->reset(['createNavCategory', 'createNavParent', 'createModuleName', 'createNavOrder']);
    }

    public function refreshComponent()
    {
        $this->resetPage();
    }

    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    // private function fetchModuleListing()
    // {
    //     return DB::table('m_navigation as m')
    //         ->select(
    //             'm.id',
    //             'm.nav_order',
    //             'm.module_name',
    //             DB::raw('(SELECT module_name FROM m_navigation WHERE id = m.parent_id) AS parent_module'),
    //             'm.module_category',
    //             'm.module_status'
    //         )
    //         ->when($this->fNavCategory, fn($q) => $q->where('module_category', $this->fNavCategory))
    //         ->orderBy('m.nav_order')
    //         ->paginate($this->pageSize);
    // }

    private function fetchModuleListing()
    {
        $modules = DB::table('m_navigation')
            ->select('id', 'module_name', 'parent_id', 'nav_order', 'module_category', 'module_status')
            ->when($this->fNavCategory, fn($q) => $q->where('module_category', $this->fNavCategory))
            ->get()
            ->keyBy('id');

        $buildPath = function ($module) use (&$buildPath, $modules) {
            if (!$module->parent_id) {
                return (string) $module->nav_order;
            }

            $parent = $modules->get($module->parent_id);
            if (!$parent) {
                return (string) $module->nav_order;
            }

            return $buildPath($parent) . '-' . $module->nav_order;
        };

        $collection = $modules->map(function ($module) use ($buildPath) {
            $module->nav_path = $buildPath($module);
            return $module;
        });

        //  NATURAL HIERARCHICAL SORT
        $collection = $collection->sort(function ($a, $b) {
            $aParts = array_map('intval', explode('-', $a->nav_path));
            $bParts = array_map('intval', explode('-', $b->nav_path));

            foreach ($aParts as $i => $part) {
                if (!isset($bParts[$i])) return 1;
                if ($part < $bParts[$i]) return -1;
                if ($part > $bParts[$i]) return 1;
            }

            return count($aParts) <=> count($bParts);
        })->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($this->page, $this->pageSize),
            $collection->count(),
            $this->pageSize,
            $this->page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }


    //  BACK AGAIN: Show all Laravel routes
    public function showRoutes()
    {
        return collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri'    => $route->uri(),
                'name'   => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });
    }
}
