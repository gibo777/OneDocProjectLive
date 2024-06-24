<?php

namespace App\Http\Livewire\RecordsManagement;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Timelogs extends Component
{
    use WithPagination;

    public $pageSize = 15; // Default page size
    public $offices; // Variable to hold offices
    public $departments; // Variable to hold departments
    public $search = ''; // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = ''; // Office filter variable

    protected $listeners = ['pageSizeChanged'];


    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $timeLogs = $this->fetchTimeLogs();
        $this->loadDropdowns();

        return view('livewire.records-management.timelogs', [
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

    private function fetchTimeLogs()
	{
	    $timeLogs = DB::table('time_logs as t')
	        ->select(
	            DB::raw("CONCAT(u.last_name, 
	                    (CASE WHEN u.suffix IS NOT NULL AND u.suffix != '' THEN CONCAT(' ', u.suffix, ', ') ELSE ', ' END), 
	                    u.first_name,
	                    (CASE WHEN u.middle_name IS NOT NULL AND u.middle_name != '' THEN CONCAT(' ', SUBSTRING(u.middle_name, 1, 1)) ELSE '' END)
	                ) AS full_name"),
	            't.employee_id',
	            't.department',
	            'o.company_name as office',
	            DB::raw("IFNULL(DATE(t.time_in), DATE(t.time_out)) AS log_date"),

	            DB::raw("(SELECT time_in FROM time_logs WHERE employee_id = t.employee_id AND DATE(time_in) = log_date ORDER BY time_in ASC LIMIT 1) AS f_time_in"),

        		DB::raw("(SELECT time_out FROM time_logs WHERE employee_id = t.employee_id AND DATE(time_out) = log_date ORDER BY time_out DESC LIMIT 1) AS f_time_out"),
        		
	            DB::raw("DATE(t.created_at) AS created_date"),
	            DB::raw("(SELECT CONCAT(last_name, 
	                       (CASE WHEN suffix IS NOT NULL AND suffix != '' THEN CONCAT(' ', suffix, ', ') ELSE ', ' END), 
	                       first_name, 
	                       ' ', SUBSTRING(middle_name, 1, 1)) 
	                     FROM users 
	                     WHERE employee_id = u.supervisor) AS supervisor")
	        );

	    $timeLogs = $timeLogs->leftJoin('users as u', 't.employee_id', '=', 'u.employee_id')
	        ->leftJoin('departments as d', 't.department', '=', 'd.department_code')
	        ->leftJoin('offices as o', 't.office', '=', 'o.id');

	    // Apply office filter if selected
	    if (!empty($this->fTLOffice)) {
	        $timeLogs->where('t.office', $this->fTLOffice);
	    }

	    // Apply department filter if selected
	    if (!empty($this->fTLDept)) {
	        $timeLogs->where('t.department', $this->fTLDept);
	    }

	    // Apply search query if search term is provided
	    if (!empty($this->search)) {
	        $timeLogs->where(function ($q) {
	            $q->where('u.first_name', 'like', '%' . $this->search . '%')
	              ->orWhere('u.last_name', 'like', '%' . $this->search . '%')
	              ->orWhere('u.middle_name', 'like', '%' . $this->search . '%')
	              ->orWhere('t.employee_id', 'like', '%' . $this->search . '%');
	        });
	    }

	    // Additional conditional check for user role
	    if (Auth::user()->role_type != 'SUPER ADMIN') {
	        $timeLogs->where(function ($query) {
	            $query->where('t.employee_id', Auth::user()->employee_id)
	                  ->orWhere('t.supervisor', Auth::user()->employee_id);
	        });
	    }

	    if (Auth::user()->id != 1 && Auth::user()->id != 2) {
	        $timeLogs->where('t.employee_id', '!=', 1);
	    }

	    $timeLogs = $timeLogs->where(function ($query) {
	            $query->where('u.is_deleted', 0)
	                  ->orWhereNull('u.is_deleted');
	        })
	        ->groupBy(
	            'full_name',
	            't.employee_id',
	            't.department',
	            'o.company_name',
	            'created_date',
	            'log_date',
	            'supervisor'
	        )
	        ->orderBy('created_date', 'desc')
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
