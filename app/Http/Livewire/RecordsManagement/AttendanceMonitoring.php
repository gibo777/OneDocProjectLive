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

class AttendanceMonitoring extends Component
{
    use WithPagination;

    public $pageSize = 15; // Default page size
    public $offices; // Variable to hold offices
    public $departments; // Variable to hold departments
    public $search = ''; // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = ''; // Office filter variable
    public $fTLdtFrom = ''; //Date From filter variable

    protected $listeners = ['pageSizeChanged'];


    public function mount()
    {
    	$this->fTLdtFrom = now()->toDateString();
        $this->loadDropdowns();
    }

    public function render()
    {
        $timeLogs = $this->fetchTimeLogs();
        $this->loadDropdowns();

        return view('livewire.records-management.attendance-monitoring', [
            'timeLogs' => $timeLogs,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }


    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
    }

    
    public function clearDateFilters()
    {
        $this->fTLdtFrom = null;
    }

    private function fetchTimeLogs()
	{
		$timeLogs = DB::table('time_logs_header as th')
        ->select(
            'th.id',
            'th.full_name',
            'th.employee_id',
            'o.company_name as office',
            'd.department',
            'th.log_date',
            DB::raw("(SELECT control_number FROM leaves WHERE employee_id=th.employee_id AND '$this->fTLdtFrom' BETWEEN date_from AND date_to) AS control_number"),
            DB::raw("(SELECT leave_type FROM leaves WHERE employee_id=th.employee_id AND '$this->fTLdtFrom' BETWEEN date_from AND date_to) AS leave_type"),
            DB::raw("(SELECT leave_status FROM leaves WHERE employee_id=th.employee_id AND '$this->fTLdtFrom' BETWEEN date_from AND date_to) AS leave_status"),
            'th.time_in',
            'th.time_out',
            'th.supervisor'
        )
        ->leftJoin('users as u', 'th.employee_id', '=', 'u.employee_id')
        ->leftJoin('departments as d', 'th.department', '=', 'd.department_code')
        ->leftJoin('offices as o', 'th.office', '=', 'o.id')
        ->when(!empty($this->fTLdtFrom), fn($q) => $q->where('th.log_date', $this->fTLdtFrom))

        ->when(!in_array(Auth::user()->role_type, ['SUPER ADMIN', 'ADMIN']), function ($q) {
            $q->where(fn($query) => 
                $query->where('th.employee_id', Auth::user()->employee_id)
                      ->orWhere('u.supervisor', Auth::user()->employee_id)
            );
        })
        ->when(!in_array(Auth::user()->id, [1, 2]), fn($q) => $q->where('u.id', '!=', 1))
        ->when(Auth::user()->is_head == 1, function ($q) {
            $q->where(fn($query) => 
                $query->where('u.employee_id', Auth::user()->employee_id)
                      ->orWhere('u.supervisor', Auth::user()->employee_id)
            );
        }, fn($q) => 
            $q->where('u.employee_id', Auth::user()->employee_id)
        )
        
        ->where(fn($q) => $q->where('u.is_deleted', 0)->orWhereNull('u.is_deleted'))
        ->union(
            DB::table('users as u')
            ->select(
                DB::raw("NULL as id"),
                'l.name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                DB::raw("? as log_date"),
                'l.control_number',
                'l.leave_type',
                'l.leave_status',
                DB::raw("NULL as time_in"),
                DB::raw("NULL as time_out"),
                'u.supervisor'
            )
            ->addBinding([$this->fTLdtFrom], 'select')
            ->leftJoin('leaves as l', function ($join) {
                $join->on('u.employee_id', '=', 'l.employee_id')
                     ->whereRaw("? BETWEEN l.date_from AND l.date_to", [$this->fTLdtFrom]);
            })
            ->leftJoin('departments as d', 'u.department', '=', 'd.department_code')
            ->leftJoin('offices as o', 'u.office', '=', 'o.id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('time_logs_header')
                      ->whereColumn('time_logs_header.employee_id', 'u.employee_id')
                      ->where('time_logs_header.log_date', '=', DB::raw("?"))
                      ->addBinding($this->fTLdtFrom);
            })
            ->whereNotIn('l.leave_status', ['Denied', 'Cancelled'])
            ->where(function ($query) {
                $query->whereNull('u.is_deleted')
                      ->orWhere('u.is_deleted', '!=', 1);
            })
            ->when(!in_array(Auth::user()->role_type, ['SUPER ADMIN', 'ADMIN']), function ($q) {
                $q->where(fn($query) => 
                    $query->where('u.employee_id', Auth::user()->employee_id)
                          ->orWhere('u.supervisor', Auth::user()->employee_id)
                );
            })
            ->when(!in_array(Auth::user()->id, [1, 2]), fn($q) => $q->where('u.id', '!=', 1))
            ->when(Auth::user()->is_head == 1, function ($q) {
                $q->where(fn($query) => 
                    $query->where('u.employee_id', Auth::user()->employee_id)
                          ->orWhere('u.supervisor', Auth::user()->employee_id)
                );
            }, fn($q) => 
                $q->where('u.employee_id', Auth::user()->employee_id)
            )
        )
        ->orderBy('log_date', 'desc')
        ->orderBy('full_name', 'asc')
        ->paginate($this->pageSize);

        return $timeLogs;

	}



    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }
}
