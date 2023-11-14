<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\PersonnelAccountingData;
use App\Models\Dependents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class PersonnelAccountingDataController extends Controller
{
	/**
	 * Update 
	 *
	 * @return void
	 * @author Gilbert Retiro
	 **/
	public function showAccountingData ()
	{
		return view('personnel.accounting-data');
	}

	/**
	 * Update 
	 *
	 * @return isSuccess, message
	 * @author Christopher Napoles
	 **/
	public function updateAccountingData (Request $request)
	{
		try{
			$accountingData = $request->accountingData??'';
			$dependentDataName = $request->dependentDataName ?? [];
	
			$dependentDataBday = $request->dependentDataBday ?? [];

			$empId = Auth::user()->employee_id;
			$accountingData['passport_expiry'] = Carbon::parse($accountingData['passport_expiry']);
			PersonnelAccountingData::findOrFail(Auth::user()->id)->update($accountingData);
			
			if(sizeof($dependentDataBday) > 0 && sizeof($dependentDataName)){
				for($i = 0; $i < sizeof($dependentDataName); $i++){
					$isRecorded = array_key_exists('id', $dependentDataName[$i] ) ? DB::table('dependents')->select('id')->where(['employee_id' => $empId, 'id' => $dependentDataName[$i]['id']])->first() ?? '' : '';
					if($isRecorded){
						Dependents::findOrFail($isRecorded->id)->update([
							'dependent_name' => $dependentDataName[$i]['dependent_name'],
							'dependent_birthdate' => Carbon::parse($dependentDataBday[$i]['dependent_birthdate']),
						]);
					}else{
						Dependents::create([
							'employee_id' => Auth::user()->employee_id,
							'dependent_name' => $dependentDataName[$i]['dependent_name'],
							'dependent_birthdate' => Carbon::parse($dependentDataBday[$i]['dependent_birthdate']),
						]);
					}
				}
			}
			

			return response(['isSuccess'=>true,'message'=>'Accounting Data Successfully Saved']);

		}catch(\Throwable $e){
			return response(['isSuccess' => false, 'message'=>$e]);
		}
	}
}
