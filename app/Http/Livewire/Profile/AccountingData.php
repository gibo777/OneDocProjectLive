<?php

namespace App\Http\Livewire\Profile;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AccountingData extends Component
{
    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        /*$this->accounting = Auth::user()->withoutRelations()->toArray();

        dd($this->accounting);*/

        // $this->accounting = (object) DB::table('accounting_data')->where('employee_id', Auth::user()->employee_id)->get()->toArray();
        // dd($this->accounting);
    }


    /**
     * Render views.
     *
     * @return accounting data view
     */
    public function render()
    {
        $tax_statuses = DB::table('tax_statuses')->get();
    	$this->tax_statuses = $tax_statuses;
    	// $this->accounting['tax_status'] = 'HF';
        return view('livewire.profile.accounting-data');
    }


}

