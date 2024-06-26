<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\ViewLeaves;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ViewLeavesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_leave()
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;

            $leaves = DB::table('v_leaves');
            if (Auth::user()->id != 1 && Auth::user()->department != '1D-HR') {
                if (Auth::user()->role_type == 'ADMIN' || Auth::user()->role_type == 'SUPER ADMIN') {
                    $leaves = $leaves->where('supervisor', '=', $employee_id)
                        ->orWhere('employee_id', '=', $employee_id);
                } else {
                    $leaves = $leaves->where('employee_id', '=', $employee_id);
                }
            }
            $leaves = $leaves->get();


	        // $leaves = DB::table('leaves as L');
         //    $leaves = $leaves->leftJoin('offices as o', 'L.office', '=', 'o.id');
	        // $leaves = $leaves->leftJoin('departments as d', 'L.department', '=', 'd.department_code');
	        // $leaves = $leaves->leftJoin('users as u', 'u.employee_id', '=', 'L.employee_id');
         //    $leaves = $leaves->leftJoin('leave_balances as b', 'u.employee_id', 'b.employee_id');
	        // $leaves = $leaves->select(
         //        'L.id',
	        // 	'L.leave_number',
         //        'L.control_number',
         //        'L.name',
	        // 	'L.employee_id',
	        // 	'L.leave_type',
	        // 	'L.date_applied',
	        // 	'L.date_from', 'L.date_to',
	        // 	'L.no_of_days', 
         //        'o.company_name',
         //        'd.department',
	        // 	'd.department_code as dept',
	        // 	'u.supervisor',
         //        'L.created_at',
	        // 	DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
         //        DB::raw('L.leave_status as status')
         //    );
	        
         //    if(Auth::user()->id!=1 && Auth::user()->department!='1D-HR') {
         //        if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN'){
         //            $leaves = $leaves->where('u.supervisor','=', $employee_id);
         //            $leaves = $leaves->orWhere('L.employee_id','=', $employee_id);
         //        } else { 
         //            $leaves = $leaves->where('L.employee_id','=', $employee_id);
         //        }
         //    }
	        // $leaves = $leaves->where( function($query) {
	        // 	return $query->where ('L.is_deleted','=', '0')->orWhereNull('L.is_deleted');
	        // 	});
         //    $leaves = $leaves->orderBy('L.created_at','desc');            
         //    // $leaves = $leaves->orderBy('L.name');            
	        // // $leaves = $leaves->orderBy('L.id');
         //    // $leaves = $leaves->paginate(5);
	        // $leaves = $leaves->get();

            // $leaves = DB::select('CALL sp_viewleaves()');

            $departments        = DB::table('departments')->orderBy('department')->get();
            $leave_types        = DB::table('leave_types')/*->orderBy('leave_type_name')*/->get();
            $holidays           = DB::table('holidays')->orderBy('holiday')->get();
            $request_statuses   = DB::table('request_statuses')->orderBy('request_status')->get();

	        return view('hris.leave.view-leave', 
                [
                    'holidays'          => $holidays, 
                    'leaves'            => $leaves, 
                    'departments'       => $departments, 
                    'leave_types'       => $leave_types,
                    'request_statuses'  => $request_statuses,
                ]);
        } else {
            return redirect('/');
        }
    }

    function filter_leave(Request $request) {
        // dd($request);

            $filter_search      = $request->filter_search;
            $filter_leave_type  = $request->filter_leave_type;
            $filter_department  = $request->filter_department;

            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;
            // return $employee_id = Auth::user()->employee_id; die();

            $leaves = DB::table('leaves as L');
            $leaves = $leaves->leftJoin('departments as d', 'L.department', '=', 'd.department_code');
            $leaves = $leaves->leftJoin('users as u', 'u.employee_id', '=', 'L.employee_id');
            $leaves = $leaves->leftJoin('leave_balances as b', 'u.employee_id', 'b.employee_id');
            $leaves = $leaves->select(
                'L.id',
                'L.leave_number',
                'L.name',
                /*'L.first_name',
                'L.last_name',*/
                'L.employee_id',
                'L.leave_type',
                'L.date_applied',
                'L.date_from', 'L.date_to',
                'L.no_of_days', 
                'd.department as dept',
                'u.supervisor',
                DB::raw('(SELECT CONCAT(first_name,last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                DB::raw('(CASE WHEN L.is_denied=1 THEN "Denied" WHEN L.is_cancelled=1 THEN "Cancelled" WHEN L.is_taken=1 THEN "Taken" ELSE (CASE WHEN L.is_head_approved=1 THEN "Head Approved" ELSE "Pending" END) END) as status'));
            if ($filter_search!="") {
                $leaves->where('L.name', 'like', '%'.$filter_search.'%');
            }
            if ($filter_department!="") {
                $leaves->where('L.department', '=', $filter_department);
            } 
            if ($filter_leave_type!="") {
                $leaves->where('L.leave_type', '=', $filter_leave_type);
            } 
            if ($access_code==null) { 
                $leaves = $leaves->where('L.employee_id','=', $employee_id);
            } elseif ($access_code==1 && Auth::user()->department!='HR'){
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

            return view('/hris/leave/filter-leave', ['leaves'=>$leaves, 'departments'=>$departments, 'leave_types'=>$leave_types, 'filter_search'=>$filter_search, 'filter_department'=>$filter_department, 'filter_leave_type'=>$filter_leave_type]);
        /*return view('/hris/leave/filter-leave', 
            [
                'filter_search'=>$request->filter_search,
                'filter_leave_type'=>$request->filter_leave_type,
                'filter_department'=>$request->filter_department
            ]);*/
    }

    function view_leave(Request $request) {
    	// return "gilbert";
    	if($request->ajax()){
    		// return $request->leaveID;
            $holidays = DB::table('holidays')->get();
            $departments = DB::table('departments')->get();
            $leave_types = DB::table('leave_types')->get();

            // Retrieve leave details based on leaveID
            $leaves = DB::table('leaves as L')
                ->leftJoin('departments as d', 'L.department', '=', 'd.department_code')
                ->leftJoin('users as u', 'u.employee_id', '=', 'L.employee_id')
                ->leftJoin('leave_balances as b', 'u.employee_id', '=', 'b.employee_id')
                ->select(
                    'L.id',
                    'L.name',
                    'L.control_number',
                    'L.leave_number',
                    'L.employee_id',
                    'L.department',
                    'L.leave_type',
                    'L.date_applied',
                    'L.date_from',
                    'L.date_to',
                    'L.no_of_days',
                    'L.others',
                    'L.reason',
                    'd.department as dept',
                    'u.access_code',
                    'u.supervisor',
                    'L.is_head_approved',
                    'L.is_hr_approved',
                    'L.is_taken',
                    'L.is_cancelled',
                    DB::raw('CASE 
                        WHEN L.leave_type = "VL" THEN b.VL 
                        WHEN L.leave_type = "SL" THEN b.SL
                        WHEN L.leave_type = "ML" THEN b.ML
                        WHEN L.leave_type = "PL" THEN b.PL
                        WHEN L.leave_type = "EL" THEN b.EL
                        WHEN L.leave_type = "Others" THEN b.Others
                        ELSE 0
                        END AS balance'),
                    DB::raw('CASE 
                        WHEN L.is_denied = 1 THEN "Denied" 
                        WHEN L.is_cancelled = 1 THEN "Cancelled" 
                        WHEN L.is_taken = 1 THEN "Taken" 
                        ELSE (CASE 
                            WHEN L.is_head_approved = 1 THEN "Head Approved" 
                            ELSE "Pending" 
                            END) 
                        END AS status')
                )
                ->where('L.id', '=', $request->leaveID)
                ->where(function ($query) {
                    $query->where('L.is_deleted', '=', 0)
                        ->orWhereNull('L.is_deleted');
                })
                ->first();

            if (!$leaves) {
                // Handle case where no leave is found for the provided ID
                return response()->json(['error' => 'Leave not found'], 404);
            }

            // Retrieve leave credits based on employee_id and year
            $leaveCredits = DB::table('leaves')
                ->select('employee_id',
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "SL" THEN no_of_days ELSE 0 END), 0) as SL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "VL" THEN no_of_days ELSE 0 END), 0) as VL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "EL" THEN no_of_days ELSE 0 END), 0) as EL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "ML" THEN no_of_days ELSE 0 END), 0) as ML'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "PL" THEN no_of_days ELSE 0 END), 0) as PL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "Others" THEN no_of_days ELSE 0 END), 0) as others')
                )
                ->where(function ($query) {
                    $query->whereNull('is_deleted')
                        ->orWhere('is_deleted', 0);
                })
                ->where(function ($query) {
                    $query->whereNull('is_cancelled')
                        ->orWhere('is_cancelled', 0);
                })
                ->where('is_head_approved', 1)
                ->where('employee_id', $leaves->employee_id)
                ->where(DB::raw('YEAR(date_from)'), Carbon::now('Asia/Manila')->format('Y'))
                ->groupBy('employee_id')
                ->first();

            if (!$leaveCredits) {
                // Handle case where no leave credits are found for the employee
                $leaveCredits = ['SL'=>'0.0','VL'=>'0.0','EL'=>'0.0','ML'=>'0.0','PL'=>'0.0','Others'=>'0.0'];  
            }

            // Attach leave credits to $leaves object
            // $leaves->leaveCredits = $leaveCredits;

            // Prepare response and return as JSON
            $response = [
                'leaves' => $leaves,
                'holidays' => $holidays,
                'departments' => $departments,
                'leave_types' => $leave_types,
                'leaveCredits' => $leaveCredits,
            ];

            return response()->json($response);
    	}
    }

    function update_leave (Request $request) {
    	if($request->ajax()){
            try {
        		$name             = $request->name;
        		$employee_number  = $request->employee_number;
        		$department       = $request->department;
                $date_applied     = date('Y-m-d',strtotime($request->date_applied)).' '.date('G:i:s');
        		$leave_type       = $request->leave_type;
        		$others_leave     = $request->others_leave;
        		$reason           = $request->reason;
        		// $notification     = implode('|',$request->leave_notification);
        		$date_from        = date('Y-m-d',strtotime($request->date_from));
        		$date_to          = date('Y-m-d',strtotime($request->date_to));
        		$hid_no_days      = $request->hid_no_days;
        		$leave_id         = $request->leave_id;

                $data_array = array(
                            'date_applied'  => $date_applied,
                            'leave_type'    => $leave_type,
                            'reason'        => $reason,
                            // 'notification'  => $notification,
                            'date_from'     => $date_from,
                            'date_to'       => $date_to,
                            'no_of_days'    => $hid_no_days
                        );

                if ($leave_type=="Others") {
                    $data_array['others'] = $others_leave;
                }

                // $data_array['id']=$leave_id; var_dump($data_array); die();

        		$update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);
            }
            catch(Exception $e){
                return redirect(route('hris.leave.view-leave'))->with('failed',"Operation Failed!");
            }
    	}
    }


    function update_delete_leave (Request $request) {
        if($request->ajax()){
            try {
                $leave_id = $request->leaveID;

                $data_array = array(
                    'leave_status'  => 'Deleted',
                    'is_deleted'    => 1,
                    'deleted_by'    => Auth::user()->employee_id,
                    'date_deleted'  => date('Y-m-d G-i-s')
                );

                $update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);
                
                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
                            'L.control_number', 
                            'L.name', 
                            'L.department', 
                            'L.date_applied', 
                            'L.employee_id', 
                            'L.leave_type',
                            DB::raw('(CASE 
                                WHEN L.leave_type="VL" THEN 
                                    (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                                WHEN L.leave_type="SL" THEN 
                                    (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                                WHEN L.leave_type="ML" THEN 
                                    (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                                WHEN L.leave_type="PL" THEN 
                                    (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                                WHEN L.leave_type="EL" THEN 
                                    (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                                WHEN L.leave_type="Others" THEN 
                                    (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                                ELSE 0
                                END) as leave_balance'), 
                            'L.others', 
                            'L.reason', 
                            // 'L.notification', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("'{$date}' as created_at")
                        )->where('L.id','=',$request->leaveID);

                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'control_number', 
                        'name', 
                        'department',
                        'date_applied', 
                        'employee_id', 
                        'leave_type', 
                        'leave_balance', 
                        'others', 
                        'reason', 
                        // 'notification', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name', 
                        'action', 
                        'action_reason', 
                        'created_at'
                    ],$leaveInsert);

                    if ($history>0) {
                        return "Head Approval Successful!";
                    } else {
                        return "Failed to Approve Leave";
                        DB::rollback();
                    }
                } else {
                    return "Failed to Approve Leave";
                    DB::rollback();
                }

                /*$update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update('is_deleted','1');*/
                // $update = $update->update('deleted_by', Auth::user()->employee_id);
            }
            catch(Exception $e){
                return redirect(route('hris.leave.view-leave'))->with('failed',"operation failed");
            }
        }
    }

    function head_approve_leave (Request $request) {
        if($request->ajax()){
            try {
                $currentDate = Carbon::now();
                $leave_id = $request->leaveID;
                $action = "Head Approved";
                $reason = "N/A";
                $date = DB::raw('NOW()');

                $data_array = array(
                    'leave_status'          => 'Head Approved',
                    'is_head_approved'      => 1,
                    'head_name'             => Auth::user()->first_name.' '. Auth::user()->last_name,
                    'date_approved_head'    => DB::raw('NOW()')
                );


                $update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);
                
                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
                            'L.control_number', 
                            'L.name', 
                            'L.department', 
                            'L.date_applied', 
                            'L.employee_id', 
                            'L.leave_type',
                            DB::raw('(CASE 
                                WHEN L.leave_type="VL" THEN 
                                    (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                                WHEN L.leave_type="SL" THEN 
                                    (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                                WHEN L.leave_type="ML" THEN 
                                    (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                                WHEN L.leave_type="PL" THEN 
                                    (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                                WHEN L.leave_type="EL" THEN 
                                    (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                                WHEN L.leave_type="Others" THEN 
                                    (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                                ELSE 0
                                END) as leave_balance'), 
                            'L.others', 
                            'L.reason', 
                            // 'L.notification', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("{$date} as created_at")
                        )->where('L.id','=',$request->leaveID);

                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'control_number', 
                        'name', 
                        'department',
                        'date_applied', 
                        'employee_id', 
                        'leave_type', 
                        'leave_balance', 
                        'others', 
                        'reason', 
                        // 'notification', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name', 
                        'action', 
                        'action_reason', 
                        'created_at'
                    ],$leaveInsert);

                    if ($history>0) {
                        return "Head Approval Successful!";
                    } else {
                        return "Failed to Approve Leave";
                        DB::rollback();
                    }
                } else {
                    return "Failed to Approve Leave";
                    DB::rollback();
                }
            }
            catch(Exception $e){
                return redirect(route('hris.leave.view-leave'))->with('failed',"operation failed");
            }
        }
    }

    function hr_approve_leave (Request $request) {
        // return var_dump($request->all());
        if($request->ajax()){
            try {
                $leave_id = $request->leaveID;
                $action = $request->action;
                $reason = $request->reason;
                $data_array = array(
                    'leave_status'  => 'Taken',
                    'is_taken'      => 1,
                    'hr_name'       => Auth::user()->first_name.' '. Auth::user()->last_name,
                    'date_taken'    => date('Y-m-d G-i-s')
                );

                $update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);

                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
                            'L.control_number', 
                            'L.name', 
                            'L.department', 
                            'L.date_applied', 
                            'L.employee_id', 
                            'L.leave_type',
                            DB::raw('(CASE 
                                WHEN L.leave_type="VL" THEN 
                                    (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                                WHEN L.leave_type="SL" THEN 
                                    (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                                WHEN L.leave_type="ML" THEN 
                                    (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                                WHEN L.leave_type="PL" THEN 
                                    (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                                WHEN L.leave_type="EL" THEN 
                                    (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                                WHEN L.leave_type="Others" THEN 
                                    (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                                ELSE 0
                                END) as leave_balance'), 
                            'L.others', 
                            'L.reason', 
                            // 'L.notification', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("{$date}' as created_at")
                        )->where('L.id','=',$request->leaveID);

                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'control_number', 
                        'name', 
                        'department',
                        'date_applied', 
                        'employee_id', 
                        'leave_type', 
                        'leave_balance', 
                        'others', 
                        'reason', 
                        // 'notification', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name', 
                        'action', 
                        'action_reason', 
                        'created_at'
                    ],$leaveInsert);
                    
                    if ($history>0) {
                        return "Successfully ".$action;
                    } else {
                        return "Failed";
                        DB::rollback();
                    }
                } else {
                    return "Failed";
                    DB::rollback();
                }
            }
            catch(Exception $e){
                return redirect(route('hris.leave.view-leave'))->with('failed',"operation failed");
            }
        }
    }

    function yes_button_leave (Request $request) {
        if($request->ajax()){
            try {
                $leave_id = $request->leaveID;
                $action = $request->action;
                $reason = $request->reason;
                $date = DB::raw('NOW()');

                if ($action=="Cancelled") {
                    $data_array = array(
                        'leave_status'    => 'Cancelled',
                        'is_cancelled'    => 1,
                        'cancelled_by'    => Auth::user()->employee_id,
                        'date_cancelled'  => DB::raw('NOW()')
                    );
                } else if ($action=="Denied") {
                    $data_array = array(
                        'leave_status' => 'Denied',
                        'is_denied'    => 1,
                        'denied_by'    => Auth::user()->employee_id,
                        'date_denied'  => DB::raw('NOW()')
                    );
                }
                $update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);

                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
                            'L.control_number', 
                            'L.name', 
                            'L.department', 
                            'L.date_applied', 
                            'L.employee_id', 
                            'L.leave_type',
                            DB::raw('(CASE 
                                WHEN L.leave_type="VL" THEN 
                                    (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                                WHEN L.leave_type="SL" THEN 
                                    (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                                WHEN L.leave_type="ML" THEN 
                                    (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                                WHEN L.leave_type="PL" THEN 
                                    (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                                WHEN L.leave_type="EL" THEN 
                                    (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                                WHEN L.leave_type="Others" THEN 
                                    (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                                ELSE 0
                                END) as leave_balance'), 
                            'L.others', 
                            'L.reason', 
                            // 'L.notification', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("{$date} as created_at")
                        )->where('L.id','=',$request->leaveID);

                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'control_number', 
                        'name', 
                        'department',
                        'date_applied', 
                        'employee_id', 
                        'leave_type', 
                        'leave_balance', 
                        'others', 
                        'reason', 
                        // 'notification', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name', 
                        'action', 
                        'action_reason', 
                        'created_at'
                    ],$leaveInsert);

                    if ($history>0) {
                        return "Successfully ".$action;
                    } else {
                        return "Failed";
                        DB::rollback();
                    }
                } else {
                    return "Failed";
                    DB::rollback();
                }
            }
            catch(Exception $e){
                DB::rollback();
                return redirect(route('hris.leave.view-leave'))->with('failed',"operation failed");
            }
        }
    }

    function view_leave_history (Request $request) {
        // return var_dump($request->all());
         if($request->ajax())
         {

            $leaves = DB::table('leave_history as h')
            ->leftJoin('users as u', 'u.employee_id', '=', 'h.employee_id')
            ->leftJoin('departments as d', 'd.id', '=', 'h.department')
            // ->leftJoin('leave_balances as b', 'b.employee_id', '=', 'u.employee_id')
            ->select(
                'h.name', 'u.gender',
                'h.leave_reference', 
                'h.leave_number', 
                'h.control_number',
                'h.action', 
                DB::raw("DATE_FORMAT(h.created_at,'%m/%d/%Y %h:%i %p') as created_at"),
                'h.action_reason', 
                'h.name', 
                'd.department', 
                'u.supervisor',
                DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                'h.date_applied', 
                DB::raw("DATE_FORMAT(h.date_applied,'%m/%d/%Y %h:%i %p') as date_applied"),
                'h.employee_id', 
                'h.leave_type', 
                'h.leave_balance',
                /*DB::raw('(CASE 
                    WHEN h.leave_type="VL" THEN 
                        (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                    WHEN h.leave_type="SL" THEN 
                        (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                    WHEN h.leave_type="ML" THEN 
                        (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                    WHEN h.leave_type="PL" THEN 
                        (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                    WHEN h.leave_type="EL" THEN 
                        (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                    WHEN h.leave_type="Others" THEN 
                        (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                    END) as leave_balance'),*/
                'h.others', 
                'h.reason', 
                // 'h.notification', 
                DB::raw("DATE_FORMAT(h.date_from, '%m/%d/%Y') as date_from"),
                DB::raw("DATE_FORMAT(h.date_to, '%m/%d/%Y') as date_to"),
                'h.no_of_days'
            )
            ->where('h.leave_reference','=',$request->leave_reference)
            ->where(function($query) {
                $query->where('h.is_deleted', '!=', '1')
                      ->orWhereNull('h.is_deleted');
            })
            ->orderBy('h.id')
            ->get();

            return $leaves;
        }
    }

    function fetch_data(Request $request)
    {
	     if($request->ajax())
	     {

		        $leaves = DB::table('leaves as L')
		        ->leftJoin('departments as d', 'L.department', '=', 'd.id')
		        ->select(
		        	'L.id',
		        	'L.name',
		        	'L.leave_type',
		        	'L.date_applied', 
		        	'd.department as dept',
		        	DB::raw('(CASE WHEN L.is_hr_approved=1 THEN "Approved" ELSE (CASE WHEN L.is_head_approved=1 THEN "Head Approved" ELSE "Pending" END) END) as status'))
		        ->paginate(5);
		        return view('hris.leave.view-leave', ['leaves'=>$leaves])->render();
	     }
    }

    function leavesExcel (Request $request) {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL) 
            && (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN') )
            {
            $currentDate = Carbon::now('Asia/Manila');
            $formattedDateTime = $currentDate->format('YmdHis');

            $leavesData = DB::table('leaves as L')
            ->leftJoin('offices as o', 'L.office', '=', 'o.id')
            ->leftJoin('departments as d', 'L.department', '=', 'd.department_code')
            ->leftJoin('users as u', 'u.employee_id', '=', 'L.employee_id')
            ->leftJoin('leave_balances as b', 'u.employee_id', 'b.employee_id')
            ->select(
                'L.id',
                'L.leave_number',
                'L.name',
                'L.employee_id',
                DB::raw('(SELECT company_name FROM offices where id=L.office) as office'),
                'd.department',
                'd.department_code as dept',
                'L.control_number',
                'L.leave_type',
                'L.others',
                'L.date_from', 'L.date_to',
                'L.no_of_days', 
                'L.reason',
                'o.company_name',
                'u.supervisor',
                'L.created_at',
                DB::raw('(SELECT CONCAT(first_name," ",last_name) FROM users WHERE employee_id = u.supervisor) as head_name'),
                DB::raw("DATE_FORMAT(L.date_applied, '%m-%d-%Y %h:%i %p') as date_applied"),
                'L.leave_status as status')
            ->where('u.id','!=',1)
            ->orderBy('L.name')
            ->orderBy('L.id')
            ->get();

            return view('/reports/excel/leaves-excel', 
                [ 
                    'leavesData'    => $leavesData,
                    'currentDate'   => $formattedDateTime
                ]);
        } else {
            return redirect('/');
        }
    }

}
