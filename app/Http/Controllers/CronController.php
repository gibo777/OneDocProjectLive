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
            // Check Current Date vs Date Regularized (if 0 to 3years, 3years to 6years, and 6years up)
            // Check if already added monthly leave credits for VL, SL, and EL
            // Calculate VL, SL, and EL based on the Year/s of Service
            // (0 to 3 years)
            // VL = 10/12 per month, 
            // SL = 10/12 * month/s remaining until December, 
            // EL = 5/12 * month/s remaining until December)
            // Check the Regularized Day then check the current server month


$regularDate = Carbon::parse($value->date_regularized); 
$serverDate = Carbon::parse($value->server_date); 
$diff = $regularDate->diffInYears($serverDate);

$string .= "Date Regularized: " . $regularDate->format('M d, Y') . "<br>";
$string .= "Server Date: " . $serverDate->format('M d, Y') . "<br>";
$string .= "Month: " . $serverDate->format('m') . "<br>";
$string .= "Year: " . $serverDate->format('Y') . "<br>";
$string .= "Employee ID: " . $value->employee_id . "<br><br>";
$string .= "Difference in Years: " . $diff . "<br>";

switch ($diff) {
    case $diff > 6:
        $string .= "More than 6 years";
        $string .= "VL Credit Added: ". number_format((15/12),4);
        break;

    case $diff >= 3 && $diff < 6:
        $string .= "More than 3 years to 6 years";
        $string .= "VL Credit Added: ". number_format((12/12),4);
        break;

    default:
        $string .= "Below 3 years<br>";
        $string .= "VL Credit Added: ". number_format((10/12),4);
        break;
}

$string .= "<br>==============================<br>";

            /*==============================*/
    	}

    	return $string;
    }
}
