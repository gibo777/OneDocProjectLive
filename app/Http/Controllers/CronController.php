<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Employees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CronController extends Controller
{
    /**
     * Auto Compute Leeave Credits
     *
     * @return \Illuminate\Http\Response
     * @author Gilbert L. Retiro
     */
    public function cronAutoComputeLeaveCredits () {

    	$select = DB::table('users')
    	->select(
    		'id',
    		'employee_id',
    		'name',
    		'first_name', 'middle_name', 'last_name', 'suffix',
    		'date_regularized',
    		DB::raw('NOW() as server_datetime'),
    		DB::raw('DATE_FORMAT(NOW(),"%Y-%m-%d") as server_date'),
    		DB::raw('DATE_FORMAT(NOW(),"%H:%i:%s") as server_time')
    	)
    	->where('date_regularized','!=', NULL)
    	->get();

    	$string = '';
    	foreach ($select as $key => $value) {
    		$selectVL = DB::table('leave_balances')->where('ref_id',$value->id)->first();

    		// return (date('m',strtotime($value->server_date))-date('m',strtotime($value->date_regularized)));

    		$string = $string."Date Today: ".date('m/d/Y',strtotime($value->server_date))."<br>"."Date Regularized: ".date('m/d/Y',strtotime($value->date_regularized))."<br>";
    		$string = $string."ID: ".$selectVL->id."<br>"."Month: ".date('m',strtotime($value->server_date))."<br>";
    		$string = $string."Month Regularized: ".date('m',strtotime($value->date_regularized))."<br>Name: ".$value->name."<br>";

    		
    		if ( date('Y',strtotime($value->server_date))>=date('Y',strtotime($value->date_regularized)) 
    			&& (date('m',strtotime($value->server_date))-date('m',strtotime($value->date_regularized)))>0 ) {
    		$string = $string."Monthly VL Added: 0.8333<br>";
    		}

    		$string = $string."-------<br>";
    	}

    	return $string;
    }
}
