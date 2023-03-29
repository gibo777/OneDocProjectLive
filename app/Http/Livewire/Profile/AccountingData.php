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
    protected $listeners = ['refetchAcc'=>'accDataRefetcher'];
    public $isRefetch = false;
    public function mount()
    {
        /*$this->accounting = Auth::user()->withoutRelations()->toArray();

        dd($this->accounting);*/

        // $this->accounting = (object) DB::table('accounting_data')->where('employee_id', Auth::user()->employee_id)->get()->toArray();
        // dd($this->accounting);
    }
    public function accDataRefetcher(){
        $this->isRefetch = true;
    }

    /**
     * Render views.
     *
     * @return accounting data view
     */
    public function render()
    {
        $tax_statuses = DB::table('tax_statuses')->get();
        
        $accData = DB::table('accounting_data')->where('employee_id',Auth::user()->employee_id)->first() ?? '';
        $leaves =  DB::table('leave_balances')->where('employee_id',Auth::user()->employee_id)->first() ?? '';
        $taxStatusDesc = '';
        $accData ? (
            $accData->tax_status ?
                $taxStatusDesc = DB::table('tax_statuses')->where('tax_status_code',$accData->tax_status)->pluck('tax_status_description')->first()
            : 
                $taxStatusDesc = ''
         ) : '';
         $dependents = DB::table('dependents')->where('employee_id',Auth::user()->employee_id)->get() ?? [];

        //  dd($taxStatusDesc);
    
    	$this->tax_statuses = $tax_statuses;
    	// $this->accounting['tax_status'] = 'HF';
        return view('livewire.profile.accounting-data',
            [
                'accData'=>$accData, 
                'leaves'=>$leaves,
                'taxStatusDesc'=>$taxStatusDesc,
                'dependents' => $dependents
            ]
        );
    }


}

