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
        $timeLogs = $this->fetchTimelogsAndLeaves();
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

    private function fetchTimelogsAndLeaves()
    {
        $timeLogs = DB::table('users as u')
            ->select(
                DB::raw("COALESCE(th.id, NULL) as id"),
                'u.name as full_name',
                'u.employee_id',
                'o.company_name as office',
                'd.department',
                DB::raw("COALESCE(th.log_date, ?) as log_date"),
                DB::raw("MAX(l.control_number) AS control_number"),
                DB::raw("MAX(l.leave_type) AS leave_type"),
                DB::raw("MAX(l.leave_status) AS leave_status"),
                'th.time_in',
                'th.time_out',
                'u.supervisor',
                'u.employment_status'
            )
            ->addBinding([$this->fTLdtFrom], 'select')
            ->leftJoin('time_logs_header as th', function ($join) {
                $join->on('u.employee_id', '=', 'th.employee_id')
                    ->where('th.log_date', '=', DB::raw("?"));
            })
            ->addBinding($this->fTLdtFrom, 'join')
            ->leftJoin('leaves as l', function ($join) {
                $join->on('u.employee_id', '=', 'l.employee_id')
                    ->whereRaw("? BETWEEN l.date_from AND l.date_to", [$this->fTLdtFrom])
                    ->whereNotIn('l.leave_status', ['Denied', 'Cancelled']);
            })
            ->leftJoin('departments as d', 'u.department', '=', 'd.department_code')
            ->leftJoin('offices as o', 'u.office', '=', 'o.id')
            ->when(Auth::user()->id != 1, function ($query) {
                $query->where(function ($q) {
                    $q->where('u.employee_id', Auth::user()->employee_id)
                        ->orWhere('u.supervisor', Auth::user()->employee_id);
                });
            })

            ->where('u.employment_status', '!=', 'NO LONGER CONNECTED')
            ->where(function ($query) {
                $query->whereNull('u.is_deleted')->orWhere('u.is_deleted', '!=', 1);
            })
            ->groupBy(
                'u.employee_id',
                'u.name',
                'o.company_name',
                'd.department',
                'th.id',
                'th.log_date',
                'th.time_in',
                'th.time_out',
                'u.supervisor'
            )
            ->orderBy('u.name', 'asc')
            ->orderBy('log_date', 'desc')
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
