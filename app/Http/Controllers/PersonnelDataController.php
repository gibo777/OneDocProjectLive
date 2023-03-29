<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\PersonnelData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PersonnelDataController extends Controller
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
	 * @return void
	 * @author Gilbert Retiro
	 **/
	public function updateAccountingData (Request $request)
	{
		return var_dump($request->all());
	}
}
