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

    protected $listeners = ['pageSizeChanged'];

    public function render()
    {
        $timeLogs = $this->fetchTimeLogs();

        return view('livewire.records-management.timelogs', [
            'timeLogs' => $timeLogs,
        ]);
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
		        DB::raw("IFNULL(DATE(t.time_in), DATE(t.time_out)) AS date"),
		        // DB::raw("COALESCE((SELECT time_in FROM time_logs WHERE employee_id=t.employee_id AND DATE(time_in) = IFNULL(DATE(t.time_in), DATE(t.time_out)) ORDER BY time_in ASC LIMIT 1), NULL) AS time_in"),
		        // DB::raw("COALESCE((SELECT time_out FROM time_logs WHERE employee_id=t.employee_id AND DATE(time_out) = IFNULL(DATE(t.time_out), DATE(t.time_out)) ORDER BY time_out DESC LIMIT 1), NULL) AS time_out"),
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

		// Additional conditional check for user role
		if (Auth::user()->role_type != 'SUPER ADMIN') {
		    $timeLogs = $timeLogs->where(function ($query) {
		        $query->where('t.employee_id', Auth::user()->employee_id)
		              ->orWhere('t.supervisor', Auth::user()->employee_id);
		    });
		}
		if (Auth::user()->id!=1) {
			$timeLogs = $query->where('t.employee_id', '!=',Auth::user()->employee_id);
		}

		$timeLogs = $timeLogs->where(function ($query) {
		        $query->where('u.is_deleted', 0)
		              ->orWhereNull('u.is_deleted');
		    })
		    // ->where('u.id', '!=', 1)
		    ->groupBy(
		        'full_name', 
		        't.employee_id', 
		        't.department', 
		        'o.company_name', 
		        'created_date',
		        'date', 
		        // 'time_in',
		        // 'time_out',
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
