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

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {

            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;

            $employees = DB::table('users as u');
            $employees = $employees->leftJoin('departments as d', 'u.department', '=', 'd.department_code');
            $employees = $employees->leftJoin('offices as o', 'u.office', '=', 'o.id');
            $employees = $employees->select(
                'u.id',
                'u.first_name',
                'u.middle_name',
                'u.last_name',
                'u.suffix',
                'u.employee_id',
                'd.department as dept',
                'u.position',
                'u.role_type',
                'u.employment_status',
                'u.supervisor',
                DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                'o.company_name',
            );
            $employees = $employees->where( function($query) {
                return $query->where ('u.is_deleted','=', '0')->orWhereNull('u.is_deleted');
                });
            $employees = $employees->orderBy('u.last_name');
            $employees = $employees->orderBy('u.first_name');
            $employees = $employees->get();

            $departments = DB::table('departments')->get();
            $leave_types = DB::table('leave_types')->get();
            $holidays = DB::table('holidays')->get();
            $employment_statuses = DB::table('employment_statuses')->get();
            $heads = DB::table('users')
                ->select('employee_id','last_name','first_name','middle_name','suffix')
                ->where('role_type','ADMIN')->orWhere('role_type','SUPER ADMIN')
                ->get();

            return view('/hris/employee/employees', 
                [
                    'holidays'=>$holidays, 
                    'employees'=>$employees, 
                    'departments'=>$departments, 
                    'leave_types'=>$leave_types, 
                    'employment_statuses'=>$employment_statuses,
                    'heads'=>$heads
                ]);
        } else {
            return redirect('/');
        }
    }
    public function getEmployeeInfo (Request $request){
        $empid = $request->id;
        $getemployee = DB::table('users')->where('id',$empid)->first();

        // return var_dump($getemployee);

        return response()->json($getemployee);
        // return var_dump(response()->json($getemployee));
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function updateEmployee (Request $request)
    {
        return "update...".$request->id;
        /*try{
            $updateUser = DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'last_name' => $request->userLastName,
                    'first_name' => $request->userFirstName,
                    'middle_name' => $request->userMiddleName,
                    'suffix' => $request->userExt,
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'group_id' => $request->userGroup,
                    'role_name' => $request->userRole,
                    'updated_by' => Auth::user()->user_name,
                    'updated_at' => now(),
                ]);

            if ($updateUser) {
                return response(['isSuccess' => true]);
            } 

        }catch(\Exception $e){
            return response(['isSuccess' => false,'message' => $e]);
        }*/
    }
   
}
