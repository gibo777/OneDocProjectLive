<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ServerStatus extends Component
{
    public $serverStatus;

    public function mount()
    {
        $this->serverStatus = DB::table('server_status')->where('id', 1)->value('status') ?? false;
    }

    public function render()
    {
        return view('livewire.server-status');
    }

    public function toggleServer()
    {
        // Toggle server status logic
        $this->serverStatus = !$this->serverStatus;

        // Update status in database
        DB::table('server_status')->where('id', 1)->update(
        	[
        		'status' 		=> $this->serverStatus ? 1 : 0,
        		'updated_by'	=> Auth::user()->employee_id,
        		'updated_at'	=> Carbon::now()
        	]);

    }


}
