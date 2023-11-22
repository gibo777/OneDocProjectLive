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
    		$string = $string."Month: ".date('m',strtotime($value->server_date))."<br>ID: ".$selectVL->id."";
    	}

    	return $string;
    }
}
