<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TestController extends Controller
{
	/*public function returnUser(){
	    $user = Auth::user();
	    Javascript::put([ 'user.name' => $user->name, 'email' => $user->email ]);
	    return view('my.user.js');
	}*/
    //
    function test_view (Request $request) {

            $months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

        $countries = DB::table('countries')->get();
    	return view('/test/test', ['months'=>$months, 'countries'=>$countries]);
             /*$access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;
            // return $employee_id = Auth::user()->employee_id; die();

	        $leaves = DB::table('leaves as L');
	        $leaves = $leaves->leftJoin('departments as d', 'L.department', '=', 'd.id');
	        $leaves = $leaves->leftJoin('users as u', 'u.employee_id', '=', 'L.employee_id');
            $leaves = $leaves->leftJoin('leave_balance as b', 'u.employee_id', 'b.employee_id');
	        $leaves = $leaves->select(
                'L.id',
	        	'L.leave_number',
                'L.name',
	        	'L.employee_id',
	        	'L.leave_type',
	        	'L.date_applied',
	        	'L.date_from', 'L.date_to',
	        	'L.no_of_days', 
	        	'd.department as dept',
	        	'u.supervisor',
	        	DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
	        	DB::raw('(CASE WHEN L.is_hr_approved=1 THEN "Approved" ELSE (CASE WHEN L.is_head_approved=1 THEN "Head Approved" ELSE "Pending" END) END) as status'));
	        if ($access_code==null) { 
	        	$leaves = $leaves->where('L.employee_id','=', $employee_id);
	        } elseif ($access_code==1 && Auth::user()->department!=1){
	        	$leaves = $leaves->where('u.supervisor','=', $employee_id);
	        	$leaves = $leaves->orWhere('L.employee_id','=', $employee_id);
	        }
		        $leaves = $leaves->where( function($query) {
		        	return $query->where ('L.is_deleted','=', '0')->orWhereNull('L.is_deleted');
		        	});
            $leaves = $leaves->orderBy('name');            
	        $leaves = $leaves->orderBy('L.id');
            // $leaves = $leaves->paginate(5);
	        $leaves = $leaves->get();

            $departments = DB::table('departments')->get();
            $leave_types = DB::table('leave_types')->get();

	        return view('/test/test', ['leaves'=>$leaves, 'departments'=>$departments, 'leave_types'=>$leave_types]);*/
    }
}
