<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AccountingData extends Component
{
    public function render()
    {
        $departments = DB::table('departments')->get();
        return view('livewire.profile.accounting-data', ['departments'=>$departments]);
    }
}
