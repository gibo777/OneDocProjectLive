<?php

namespace App\Http\Livewire\RecordsManagement;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Timelogs extends Component
{
    use WithPagination;

    public $pageRows = 10; // Number of rows per page

    public function render()
    {
        $timelogs = DB::table('time_logs as t')
        ->leftJoin('users as u', 't.employee_id', 'u.employee_id')
         ->select(
	        't.id',
	        't.employee_id',
	        't.office',
	        't.department',
	        't.time_in',
	        't.time_out',
	        't.supervisor'
	    )
        ->paginate($this->pageRows);

        return view('livewire.records-management.timelogs', [
            'timelogs' => $timelogs
        ]);
    }
}
