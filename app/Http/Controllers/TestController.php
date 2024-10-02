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
use Illuminate\Support\Str;
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

    	// $select = DB::table('users')->where('qr_code_link','')->orWhereNull('qr_code_link')->get();
    	
        // return $randomString = Str::random(128);


    	// $select = DB::table('users')->where('qr_code_link','')->orWhereNull('qr_code_link')->get();

    	// return var_dump($select);

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
        // return view('/test/test', ['months'=>$months, 'countries'=>$countries]);
    	return view('/test/test-gps');
      
    }
}
