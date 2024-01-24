<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Overtimes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class OvertimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL) && (Auth::user()->supervisor!=null) )
        {
            $holidays = DB::table('holidays')
            ->where( function($query) {
              return $query->where('holiday_office','')->orWhereNull('holiday_office')->orWhere('holiday_office',Auth::user()->office);
            })->get();

            $department = DB::table('departments')
            ->select(
                'department',
                // DB::raw("DATE_FORMAT(NOW(), '%m/%d/%Y') as curDate")
                DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d') as curDate")

            )
            ->where('department_code',Auth::user()->department)
            ->first();

            $leaveTypes = DB::table('leave_types');
            (Auth::user()->gender=='F') ? $leaveTypes=$leaveTypes->where('leave_type','!=', 'PL') : $leaveTypes=$leaveTypes->where('leave_type','!=', 'ML');
            $leaveTypes =$leaveTypes->get();

            $leave_credits = DB::table('leave_balances')
            ->select(
              DB::raw('FORMAT((CASE WHEN VL is not null THEN VL ELSE 0 END),2) as VL'),
              DB::raw('FORMAT((CASE WHEN SL is not null THEN SL ELSE 0 END),2) as SL'),
              DB::raw('FORMAT((CASE WHEN ML is not null THEN ML ELSE 0 END),2) as ML'),
              DB::raw('FORMAT((CASE WHEN PL is not null THEN PL ELSE 0 END),2) as PL'),
              DB::raw('FORMAT((CASE WHEN EL is not null THEN EL ELSE 0 END),2) as EL'),
              DB::raw('FORMAT((CASE WHEN others is not null THEN others ELSE 0 END),2) as others')
            )
            ->where('employee_id',Auth::user()->employee_id)->get();

            return view('hris.overtime.overtime', 
              [
                'holidays'=>$holidays, 
                'department'=>$department,
                'leaveTypes'=>$leaveTypes,
                'leave_credits'=>$leave_credits
              ]);
        } else {
            return redirect('/');
        }
    }
}
