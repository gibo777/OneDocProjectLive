<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function show_process () {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            return view('/process/process-eleave');
        } else {
            return redirect('/');
            // return view('/auth/login');
        }
    }

    public function processLeaveCount (Request $request) {
        // return $request->processDateFrom.' | '.$request->processDateTo;
        // return date('Y-m-d', strtotime('-1 day',strtotime($request->process_date_from)));
        $leaves = DB::table('leaves as L');
        $leaves = $leaves->select(
            'L.id', 'L.date_to'
        );
        $leaves = $leaves->where('L.is_head_approved','=',1);
        $leaves = $leaves->where(function ($query) {
            return $query->where('L.is_taken','',0)->orWhereNull('L.is_taken');
        });
        $leaves = $leaves->where(function ($query) {
            return $query->where('L.is_cancelled','',0)->orWhereNull('L.is_cancelled');
        });
        $leaves = $leaves->where(function ($query) {
            return $query->where('L.is_denied','',0)->orWhereNull('L.is_denied');
        });
        $leaves = $leaves->where( function($query) {
            return $query->where ('L.is_deleted','=', 0)->orWhereNull('L.is_deleted');
        });
        // $leaves = $leaves->whereBetween('L.date_to', [date('Y-m-d', strtotime('-1 day',strtotime($request->process_date_from))), date('Y-m-d',strtotime($request->process_date_to))] );
        $leaves = $leaves->whereBetween('L.date_to', [date('Y-m-d', strtotime('-1 day',strtotime($request->processDateFrom))), date('Y-m-d',strtotime($request->processDateTo))] );
        $leaves = $leaves->get();
        return $leaves;
    }

    public function processingLeave (Request $request) {
        if($request->ajax()) {
            try {
                $leave_id = $request->id;
                $action = "Processed";
                $reason = "Taken";
                // $reason = "Processed Leave";

                $data_array = array(
                    'leave_status'  => $action,
                    'is_taken'      => 1,
                    'hr_name'       => Auth::user()->first_name.' '. Auth::user()->last_name,
                    // 'date_taken'    => DB::raw('NOW()')
                    'date_taken'    => date('Y-m-d G-i-s')
                );

                $update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);

                if ($update > 0) {
                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'name', 
                        'department', 
                        'date_applied', 
                        'employee_id', 
                        'leave_type',
                        'leave_balance', 
                        'others', 
                        'reason', 
                        'notification', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name',
                        'action',
                        'action_reason'
                    ],
                        DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
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
                            'L.notification', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason")
                        )
                        ->where('L.id','=',$leave_id)
                    );
                    if ($history>0) {
                        return 1;
                    } else {
                        return 0;
                        DB::rollback();
                    }
                } else {
                    return 0;
                    DB::rollback();
                }
            }
            catch(Exception $e){
                return redirect(route('process.eleave'))->with('failed',"operation failed");
            }
        }
    }


    
}
