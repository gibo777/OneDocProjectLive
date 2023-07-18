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
     * Display listing of the resource.
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
            $employees = $employees->where('u.id','!=',1);
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
                ->where('is_head',1)/*->orWhere('role_type','SUPER ADMIN')*/
                ->where('id','!=',Auth::user()->id)->orWhere('employee_id','2000-0001')
                ->where('id','!=',1)
                ->orderBy('last_name')->orderBy('first_name')->orderBy('middle_name')
                ->get();
            $roleTypeUsers = DB::table('role_type_users')
                ->select('role_type')
                ->where('is_deleted', NULL)
                ->orWhere('is_deleted',0)
                ->get();

            return view('/hris/employee/employees', 
                [
                    'holidays'=>$holidays, 
                    'employees'=>$employees, 
                    'departments'=>$departments,
                    'leave_types'=>$leave_types, 
                    'employment_statuses'=>$employment_statuses,
                    'heads'=>$heads,
                    'roleTypeUsers'=>$roleTypeUsers
                ]);
        } else {
            return redirect('/');
        }
    }
    
    public function getEmployeeInfo (Request $request){
        $empid = $request->id;
        $getemployee = DB::table('users')->where('id',$empid)->first();
        $getLeaves = DB::table('leave_balances')->where('id',$empid)->first();

        // return var_dump($getemployee);

        return response()->json(['getemployee'=>$getemployee,'getLeaves' => $getLeaves]);
        // return var_dump(response()->json($getemployee));
    }

    /**
     * Update Employee Details
     *
     * @return isSuccess, message
     * @author Gilbert L. Retiro
     **/
    public function updateEmployee (Request $request)
    {
        // return var_dump($request->input());
        try{
            $data_array = array(
                'employee_id' => $request->employee_id,
                'position' => $request->position,
                'department' => $request->department,
                
                'employment_status' => $request->employment_status,
                'date_hired' => date('Y-m-d',strtotime($request->date_hired)),
                'weekly_schedule' => join('|',$request->update_weekly_schedule),
                'supervisor' => $request->supervisor,
                'role_type'=> $request->roleType,
                'is_head'=>$request->is_head,
            );
            $leaves = [
                'VL'=>$request->vl,
                'SL'=>$request->sl,
                'ML'=>$request->ml,
                'PL'=>$request->pl,
                'EL'=>$request->el,
                'others'=>$request->others
            ];

            $update = DB::table('users');
            $update = $update->where('id',$request->id);
            $update = $update->update($data_array);

            DB::table('leave_balances')->where('employee_id',$request->employee_id)->update($leaves);

            return response(['isSuccess' => true,'message'=>'Successfully updated!']);
        }catch(\Error $e){
            return response(['isSuccess'=>false,'message'=>$e]);
        }
    }
   
}
