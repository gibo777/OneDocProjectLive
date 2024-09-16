<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $serverStatus;
    public $pendingCount;
    public $approvedCount;
    public $deniedCount;
    public $newUsers;
    public $totalUsers;

	public function mount() 
	{
        $this->serverStatus = DB::table('server_status')->where('id', 1)->value('status') ?? false;
	    if (Auth::user()->id != 1) {
	        return redirect('/dashboard');
	    }
	}

    public function render()
    {
    	// $leaveCounts = DB::table('leaves')
    	// ->select(
    	// 	DB::raw('COUNT() as')
    	// )
    	// ->first();
        $this->pendingCount		= 7;
        $this->approvedCount	= 25;
        $this->deniedCount		= 3;
        $this->newUsers 		= 4;
        $this->totalUsers 		= 238;

    	return view('livewire.admin-dashboard');
    }

    public function toggleServer()
    {
        // Toggle server status logic
        $this->serverStatus = !$this->serverStatus;
        DB::table('server_status')->where('id', 1)->update(
        	[
        		'status' 		=> $this->serverStatus ? 1 : 0,
        		'updated_by'	=> Auth::user()->employee_id,
        		'updated_at'	=> Carbon::now()
        	]);

    }

    public function fetchLeavesRequested() {

    }
}
