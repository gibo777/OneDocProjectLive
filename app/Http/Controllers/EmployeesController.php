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
     * @author Gilbert L. Retiro
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
                'u.department as dept',
                'd.department',
                'u.position',
                'u.role_type',
                'u.employment_status',
                'u.supervisor',
                DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                'o.company_name',
            );

            if (Auth::user()->id != 1) {
                $employees = $employees->where('u.id','!=',1);
            }
            $employees = $employees->where( function($query) {
                return $query->where ('u.is_deleted','=', '0')->orWhereNull('u.is_deleted');
                });
            $employees = $employees->orderBy('u.last_name');
            $employees = $employees->orderBy('u.first_name');
            $employees = $employees->get();

            $offices = DB::table('offices')->orderBy('company_name')->get();
            $departments = DB::table('departments')->orderBy('department')->get();
            $leave_types = DB::table('leave_types')->orderBy('leave_type_name')->get();
            $holidays = DB::table('holidays')->orderBy('holiday')->get();
            $employment_statuses = DB::table('employment_statuses')/*->orderBy('employment_status')*/->get();

            $heads = DB::table('users')
                ->select('employee_id','last_name','first_name','middle_name','suffix')
                ->where('is_head',1)/*->orWhere('role_type','SUPER ADMIN')*/
                // ->where('id','!=',Auth::user()->id)->orWhere('employee_id','2000-0001')
                // ->where('employee_id','2000-0001')
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
                    'offices'=>$offices,
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
        $getemployee = DB::table('users as u')
            ->select(
                'u.*', 
                DB::raw("DATE_FORMAT(u.birthdate, '%m/%d/%Y') as birthday"),
                DB::raw("DATE_FORMAT(u.date_regularized, '%m/%d/%Y') as date_regularized"),
                'p.country_name')
            ->leftJoin('provinces as p','u.country','=','p.country_code')
            ->where('u.id',$empid)
            ->first();
        $getLeaves = DB::table('leave_balances')->where('ref_id',$empid)->first();

        // return var_dump($getLeaves);

        return response()->json(['getemployee'=>$getemployee,'getLeaves' => $getLeaves]);
        // return var_dump(response()->json($getemployee));
    }

    


    /**
     * Verify Duplicate Email, Employee ID, etc.
     *
     * @return isSuccess, message
     * @author Gilbert L. Retiro
     **/
    public function verifyDuplicate (Request $request)
    {
        try{
            $selectEmpId = DB::table('users')->where('employee_id',$request->employeeId)->first();
            $selectEmail = DB::table('users')->where('email',$request->email)->first();

            $selectEmpId ? $dupEmpId = true : $dupEmpId = false;
            $selectEmail ? $dupEmail = true : $dupEmail = false;

            ($selectEmpId || $selectEmail) ? $duplicate = true : $duplicate = false;
            ($selectEmpId || $selectEmail) ? $message = '<h4>Duplicate</h4>' : $message = '';
            ($selectEmpId) ? $message = $message . 'Employee Number: '.$selectEmpId->employee_id.'<br>' : null;
            ($selectEmail) ? $message = $message . 'Email: '.$selectEmail->email : null;


            return response(['isError' => true, 'isDuplicate'=>$duplicate, 'message'=>$message]);
        } catch(\Error $e){
            return response(['isError'=>false, 'isDuplicate'=>false, 'message'=>$e]);
        }
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
                'employee_id'       => $request->employee_id,
                'biometrics_id'     => $request->bioId,
                'position'          => $request->position,
                'department'        => $request->department,
                
                'employment_status' => $request->employment_status,
                'date_hired'        => date('Y-m-d',strtotime($request->date_hired)),
                'weekly_schedule'   => join('|',$request->update_weekly_schedule),
                'office'            => $request->office,
                'supervisor'        => $request->supervisor,
                'role_type'         => $request->roleType,
                'is_head'           => $request->is_head,
                'date_regularized'  => date('Y-m-d',strtotime($request->dateRegularized))
            );

            // return var_dump($data_array);
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
   
    /**
     * Listing of Time Logs
     *
     * @return view
     * @author Gilbert L. Retiro
     **/
    public function timeLogsListing (Request $request)
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {

            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;

            if (Auth::user()->is_head == 1 || Auth::user()->role_type=='SUPER ADMIN' ||  Auth::user()->role_type=='ADMIN') {
                $employees = DB::select('CALL sp_timelogs_admins()');
            } else {
                $employees = DB::select('CALL sp_timelogs('.Auth::user()->id.','.Auth::user()->is_head.','.$employee_id.')');
            }

            $offices = DB::table('offices')->orderBy('company_name')->get();
            $departments = DB::table('departments')->orderBy('department')->get();

            return view('/time_logs/time-logs-listing', 
                [
                    'employees'     => $employees, 
                    'offices'       => $offices,
                    'departments'   => $departments,
                ]);
        } else {
            return redirect('/');
        }
    }

    
    /**
     * Timelogs Details
     *
     * @return view for modal
     * @author Gilbert L. Retiro
     **/
    public function timeLogsDetailed (Request $request)
    {
        $data = explode('|', $request->id);
        $employeeId = $data[0];
        $searchDate = $data[1];

        $employees = DB::table('time_logs as t')
            ->select(
                'u.first_name',
                'u.middle_name',
                'u.last_name',
                DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', u.middle_name) as full_name"),
                'u.suffix',
                'u.employee_id',
                'u.department as dept',
                'd.department',
                // 't.profile_photo_path',
                't.image_path',
                DB::raw("(CASE WHEN t.time_in IS NOT NULL THEN DATE_FORMAT(t.time_in, '%Y-%m-%d %h:%i %p') ELSE '' END) as time_in"),
                DB::raw("(CASE WHEN t.time_out IS NOT NULL THEN DATE_FORMAT(t.time_out, '%Y-%m-%d %h:%i %p') ELSE '' END) as time_out"),
                DB::raw("DATE_FORMAT(t.time_in, '%Y-%m-%d') as f_time_in"),
                DB::raw("DATE_FORMAT(t.time_out, '%Y-%m-%d') as f_time_out"),
                'u.supervisor',
                DB::raw("(SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE employee_id = u.supervisor) as head_name")
            )
            ->leftJoin('users as u', 't.employee_id', '=', 'u.employee_id')
            ->leftJoin('departments as d', 'u.department', '=', 'd.department_code')
            ->where('t.employee_id', $employeeId)
            ->where(function ($query) use ($searchDate) {
                $query->whereBetween(DB::raw('DATE(t.time_in)'), ["$searchDate 00:00:00", "$searchDate 23:59:59"])
                    ->orWhereBetween(DB::raw('DATE(t.time_out)'), ["$searchDate 00:00:00", "$searchDate 23:59:59"]);
            })
            ->where(function ($query) {
                $query->where('u.is_deleted', 0)
                    ->orWhereNull('u.is_deleted');
            })
            ->orderBy('t.created_at', 'desc')
            ->get();

        return $employees;
    }

    /**
     * Timelogs Excel Report
     *
     * @return view to generate Excel File
     * @author Gilbert L. Retiro
     **/
    public function timeLogsExcel (Request $request)
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL) 
            && (Auth::user()->role_type=='ADMIN'||Auth::user()->role_type=='SUPER ADMIN') )
        {

            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;

            if (Auth::user()->is_head == 1 || Auth::user()->role_type=='SUPER ADMIN' ||  Auth::user()->role_type=='ADMIN') {
                $employees = DB::select('CALL sp_generated_timelogs_summary()');
            } else {
                $employees = DB::select('CALL sp_timelogs('.Auth::user()->id.','.Auth::user()->is_head.','.$employee_id.')');
            }

            $offices = DB::table('offices')->orderBy('company_name')->get();
            $departments = DB::table('departments')->orderBy('department')->get();

            return view('/reports/excel/timelogs-excel', 
                [
                    'employees'     => $employees, 
                    'offices'       => $offices,
                    'departments'   => $departments,
                ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Display listing of the Employee Benefits.
     *
     * @return \Illuminate\Http\Response
     * @author Gilbert L. Retiro
     */
    public function employeeBenefits () {
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
                'u.department as dept',
                'd.department',
                'u.position',
                'u.role_type',
                'u.employment_status',
                'u.supervisor',
                DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                'o.company_name',
            );

            if (Auth::user()->id != 1) {
                $employees = $employees->where('u.id','!=',1);
            }
            $employees = $employees->where( function($query) {
                return $query->where ('u.is_deleted','=', '0')->orWhereNull('u.is_deleted');
                });
            $employees = $employees->orderBy('u.last_name');
            $employees = $employees->orderBy('u.first_name');
            $employees = $employees->get();

            $offices = DB::table('offices')->orderBy('company_name')->get();
            $departments = DB::table('departments')->orderBy('department')->get();
            $leave_types = DB::table('leave_types')->orderBy('leave_type_name')->get();
            $holidays = DB::table('holidays')->orderBy('holiday')->get();
            $employment_statuses = DB::table('employment_statuses')/*->orderBy('employment_status')*/->get();

            $heads = DB::table('users')
                ->select('employee_id','last_name','first_name','middle_name','suffix')
                ->where('is_head',1)/*->orWhere('role_type','SUPER ADMIN')*/
                // ->where('id','!=',Auth::user()->id)->orWhere('employee_id','2000-0001')
                // ->where('employee_id','2000-0001')
                ->where('id','!=',1)
                ->orderBy('last_name')->orderBy('first_name')->orderBy('middle_name')
                ->get();

            $roleTypeUsers = DB::table('role_type_users')
                ->select('role_type')
                ->where('is_deleted', NULL)
                ->orWhere('is_deleted',0)
                ->get();

            return view('/hris/employee/employee-benefits', 
                [
                    'holidays'=>$holidays, 
                    'employees'=>$employees, 
                    'offices'=>$offices,
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
}
