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

        $userIDs = DB::table('users')
        ->select('id')
        ->whereRaw('DAY(date_regularized) = DAY(CURDATE())')
        ->get();

        // $string = "";
        // foreach ($userIDs as $key => $value) {
        //     $string .= $value->id."<br>";
        // }
        // return $string;

    	$select = DB::table('users')
    	->select(
    		'id',
    		'employee_id',
    		'name',
    		'first_name', 'middle_name', 'last_name', 'suffix',
    		'date_regularized',
    		DB::raw('NOW() as server_datetime'),
    		DB::raw('DATE_FORMAT(NOW(),"%Y-%m-%d") as server_date'),
    		DB::raw('DATE_FORMAT(NOW(),"%H:%i:%s") as server_time'),
            DB::raw('TIMESTAMPDIFF(YEAR, date_regularized, CURDATE()) AS years_since_regularized'),
            DB::raw('TIMESTAMPDIFF(MONTH, date_regularized, CURDATE()) % 12 AS months_since_regularized')
    	)
        ->where('date_regularized','!=', NULL)
    	->where('date_regularized','!=', '1970-01-01')
        ->whereDate('date_regularized', '<=', DB::raw('CURDATE()'))
        ->orderBy('first_name')
        ->orderBy('last_name')
    	->get();

    	$string = '<link rel="shortcut icon" href="'.asset('img/all/onedoc-favicon.png').'">';
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

            $yearsTenure = intval($value->years_since_regularized);
if ($value->employee_id=='2022-0314') {
            if (url('/')=='http://localhost' && $value->id!=1 && $value->id!=2) {
                $string .= "Name: " . implode(' ',['Xxx', 'X', 'Xxx', ucwords(strtolower($value->suffix))]);
            } else {
                $string .= "Name: " . implode(' ',[ucwords(strtolower($value->first_name)), ucwords(strtolower($value->middle_name)), ucwords(strtolower($value->last_name)), ucwords(strtolower($value->suffix))]);
            }
            $string .= " | Employee ID: " . $value->employee_id;
            $string .= " | Date Regularized: " . $regularDate->format('M d, Y');
            $string .= " | Regularized Tenure: ". $value->years_since_regularized . " Year/s and ". $value->months_since_regularized. " Month/s";
            // $string .= "Server Date: " . $serverDate->format('M d, Y') . "<br>";
            // $string .= "Month: " . $serverDate->format('m') . "<br>";
            // $string .= "Year: " . $serverDate->format('Y') . "<br>";
            // $string .= "<br>Difference in Years: " . $diff;


            if ($yearsTenure > 6) {
                $string .= " (More than 6 years)";
                $string .= " | VL Credit Added: " . number_format((15 / 12), 4);
            } elseif ($yearsTenure >= 3 && $yearsTenure < 6) {
                $string .= " (More than 3 years to 6 years)";
                $string .= " | VL Credit Added: " . number_format((12 / 12), 4);
            } else {
                $string .= " (Below 3 years)";
                $string .= " | VL Credit Added: " . number_format((10 / 12), 4);

                // if ($value->employee_id=='2022-0314') {
                //     $addCredits = DB::table('');
                // }
            }

            $string .= "<br>";
            for ($i = 0; $i < 125; $i++) { $string .= "="; }
            $string .= "<br>";
}
            /*==============================*/
    	}

    	return $string;
    }
}
