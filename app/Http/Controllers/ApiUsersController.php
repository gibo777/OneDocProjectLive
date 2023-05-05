<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;

class ApiUsersController extends Controller
{
    public function apiUsers (Request $request){
        $empid = $request->id;
        $getemployee = DB::table('users')->where('id',$empid)->first();
        $getLeaves = DB::table('leave_balances')->where('id',$empid)->first();

        return response()->json(['getemployee'=>$getemployee,'getLeaves' => $getLeaves]);
    }
}
