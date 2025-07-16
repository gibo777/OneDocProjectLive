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
use Carbon\Carbon;

class OvertimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() && (Auth::user()->email_verified_at != NULL) && (Auth::user()->supervisor != null)) {
            $otUser = DB::table('users as u')
                ->leftJoin('users as u1', 'u1.employee_id', 'u.supervisor')
                ->leftJoin('users as u2', 'u2.employee_id', 'u.manager')
                ->leftJoin('departments as d', 'u.department', 'd.department_code')
                ->leftJoin('offices as o', 'u.office', 'o.id')
                ->select(
                    'u.first_name',
                    'u.middle_name',
                    'u.last_name',
                    'u.suffix',
                    'u.employee_id',
                    DB::raw('NOW() as `current_date`'),
                    'o.company_name as office',
                    'd.department',
                    'u1.name as approver1',
                    'u2.name as approver2',
                )
                ->where('u.id', Auth::user()->id)
                ->first();

            return view(
                'hris.overtime.overtime',
                [
                    'otUser' => $otUser,
                ]
            );
        } else {
            return redirect('/');
        }
    }

    public function submitOvertime(Request $request)
    {
        // return var_dump($request->input());

        $rules = [
            'otLoc'     => 'required',
            'otDtFr'    => 'required',
            'otTFr'     => 'required',
            'otDtTo'    => 'required',
            'otTTo'     => 'required',
            'otReason'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('hris.overtime'))
                ->withInput()
                ->withErrors($validator);
        } else {
            $fromDate = Carbon::parse($request->otDtFr . ' ' . $request->otTFr);
            $toDate = Carbon::parse($request->otDtTo . ' ' . $request->otTTo);

            // Calculate the time difference in seconds
            $timeDifference = $toDate->getTimestamp() - $fromDate->getTimestamp();

            // Convert seconds to hours and minutes
            $totalHours = $timeDifference / 3600;
            $hours = floor($totalHours);
            $minutes = round(($totalHours - $hours) * 60);

            try {
                $data = [
                    'name' => $request->otName,
                    'u_id' => Auth::user()->id,
                    'employee_id' => Auth::user()->employee_id,
                    'ot_location' => $request->otLoc,
                    'ot_reason' => $request->otReason,
                    'ot_date_from' => date('Y-m-d', strtotime($request->otDtFr)),
                    'ot_date_to' => date('Y-m-d', strtotime($request->otDtTo)),
                    'ot_time_from' => Carbon::createFromFormat('H:i', $request->otTFr)->format('H:i:s'),
                    'ot_time_to' => Carbon::createFromFormat('H:i', $request->otTTo)->format('H:i:s'),
                    'ot_hours' => intval($hours),
                    'ot_minutes' => intval($minutes),
                    'ot_hrmins' => round($totalHours, 2),
                    'office' => Auth::user()->office,
                    'department' => Auth::user()->department,
                    'head_id' => Auth::user()->supervisor,
                    'head_name' => $request->otHead,
                    'date_applied' => DB::raw('NOW()'),
                    'ip_address' => $request->ip(),
                    'created_by' => Auth::user()->employee_id,
                    'updated_by' => Auth::user()->employee_id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()')
                ];
                $insert = DB::table('overtimes')->insert($data);

                return response(['isSuccess' => true, 'message' => 'OVERTIME REQUEST successfully submitted!']);
            } catch (\Exception $e) {
                return response(['isSuccess' => false, 'message' => $e]);
            }
        }
    }

    public function viewOvertimes()
    {
        if (Auth::check() && (Auth::user()->email_verified_at != NULL) && (Auth::user()->supervisor != null)) {
            $viewOTS = DB::table('overtimes as ot')
                ->leftJoin('departments as d', 'ot.department', 'd.department_code')
                ->leftJoin('offices as o', 'ot.office', 'o.id')
                ->select(
                    'ot.id',
                    'ot.name',
                    'o.company_name as office',
                    'd.department',
                    'ot.ot_control_number',
                    'ot.ot_location',
                    'ot.ot_date_from',
                    'ot.ot_time_from',
                    'ot.ot_date_to',
                    'ot.ot_time_to',
                    DB::raw("DATE_FORMAT(CONCAT(ot_date_from, ' ', ot_time_from), '%m/%d/%Y %h:%i %p') AS ot_datetime_from"),
                    DB::raw("DATE_FORMAT(CONCAT(ot_date_to, ' ', ot_time_to), '%m/%d/%Y %h:%i %p') AS ot_datetime_to"),
                    'ot.ot_hrmins as total_hours',
                    'ot.ot_status'
                );
            if (Auth::user()->id != 1) {
                if (Auth::user()->is_head == 1) {
                    $viewOTS = $viewOTS->where('ot.employee_id', Auth::user()->employee_id)
                        ->orWhere('ot.head_id', Auth::user()->employee_id);
                } else {
                    $viewOTS = $viewOTS->where('ot.employee_id', Auth::user()->employee_id);
                }
            }
            $viewOTS = $viewOTS->orderBy('ot.created_at', 'desc');
            $viewOTS = $viewOTS->get();

            // return var_dump($otUser);
            $offices = DB::table('offices')->orderBy('company_name')->get();
            $departments = DB::table('departments')->orderBy('department')->get();
            $request_statuses   = DB::table('request_statuses')->orderBy('request_status')->get();

            return view('hris.overtime.view-overtime', [
                'viewOTS'           => $viewOTS,
                'offices'           => $offices,
                'departments'       => $departments,
                'request_statuses'  => $request_statuses
            ]);
        } else {
            return redirect('/');
        }
    }
    public function viewOvertimeDetails(Request $request)
    {
        $otDtls = DB::table('v_overtime_details')
            ->where('id', $request->id)
            ->first();
        return response(['otDtls' => $otDtls]);
    }

    public function viewOvertimeHistory(Request $request)
    {
        if ($request->ajax()) {

            /*$otDHistory = DB::table('overtimes_history as o')
            ->leftJoin('users as u', 'u.id', '=', 'o.ref_id')
            ->leftJoin('departments as d', 'd.id', '=', 'o.department')
            ->select(
                'o.name',
                'o.ot_control_number',
                'o.action',
                'o.action_reason',
                DB::raw("DATE_FORMAT(o.created_at,'%m/%d/%Y %h:%i %p') as action_date"),
                'o.head_name',
                DB::raw("DATE_FORMAT(o.date_applied,'%m/%d/%Y %h:%i %p') as date_applied"),
                DB::raw("DATE_FORMAT(CONCAT(o.ot_date_from,' ',o.ot_time_from), '%m/%d/%Y %h:%i %p') as date_from"),
                DB::raw("DATE_FORMAT(CONCAT(o.ot_date_to,' ',o.ot_time_to), '%m/%d/%Y %h:%i %p') as date_to"),
                'o.ot_hours',
                'o.ot_minutes',
                'o.ot_hrmins'
            )
            ->where('o.ot_reference',$request->otRef)
            ->orderBy('o.id')
            ->get();*/

            $otDHistory = DB::table('v_overtime_history')
                ->where('ot_reference', $request->otRef)
                ->orderBy('id')
                ->get();

            return $otDHistory;
        }
    }

    public function cancelOvertime(Request $request)
    {
        try {
            $leave_id = $request->leaveID;
            $action = "Cancelled";
            $reason = $request->reason;
            $currentDate = DB::raw('NOW()');
            $message = "";
            $data = array(
                'ot_status'         => 'cancelled',
                'is_cancelled'      => 1,
                'cancelled_at'      => DB::raw('NOW()'),
                'cancelled_by'      => Auth::user()->employee_id,
                'cancelled_reason'  => $request->reason,
                'updated_at'        => DB::raw('NOW()'),
                'updated_by'        => Auth::user()->employee_id
            );

            $update = DB::table('overtimes')
                ->where('id', $request->otID)
                ->update($data);

            if ($update > 0) {
                $otData = DB::table('overtimes')
                    ->select(
                        'id',
                        'ref_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        DB::raw("'{$action}' as action"),
                        DB::raw("'{$reason}' as action_reason")
                    )->where('id', '=', $request->otID);

                $otHistory = DB::table('overtimes_history')
                    ->insertUsing([
                        'ot_reference',
                        'ref_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        'action',
                        'action_reason'
                    ], $otData);

                if ($otHistory > 0) {
                    $message = "Head Approval Successful!";
                } else {
                    $message = "Failed Approval";
                    DB::rollback();
                }
            } else {
                DB::rollback();
            }

            return response(['isSuccess' => true, 'message' => 'Request cancelled!']);
        } catch (\Exception $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    public function denyOvertime(Request $request)
    {
        try {
            $otID = $request->otID;
            $action = "Denied";
            $reason = $request->reason;
            $currentDate = DB::raw('NOW()');
            $message = "";

            $data = array(
                'ot_status'     => 'denied',
                'is_denied'     => 1,
                'denied_at'     => DB::raw('NOW()'),
                'denied_by'     => Auth::user()->employee_id,
                // 'denied_reason' => $request->reason,
                'updated_at'    => DB::raw('NOW()'),
                'updated_by'    => Auth::user()->employee_id
            );

            $update = DB::table('overtimes')
                ->where('id', $request->otID)
                ->update($data);

            if ($update > 0) {
                $otData = DB::table('overtimes')
                    ->select(
                        'id',
                        'ref_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        DB::raw("'{$action}' as action"),
                        DB::raw("'{$reason}' as action_reason")
                    )->where('id', '=', $request->otID);

                $otHistory = DB::table('overtimes_history')
                    ->insertUsing([
                        'ot_reference',
                        'ref_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        'action',
                        'action_reason'
                    ], $otData);

                if ($otHistory > 0) {
                    $message = "Head Approval Successful!";
                } else {
                    $message = "Failed Approval";
                    DB::rollback();
                }
            } else {
                DB::rollback();
            }

            return response(['isSuccess' => true, 'message' => 'Request denied!']);
        } catch (\Exception $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    public function approveOvertime(Request $request)
    {
        // return $request->all();
        try {
            $otID = $request->otID;
            $action = "Head Approved";
            $reason = "N/A";
            $currentDate = DB::raw('NOW()');
            $message = "";

            $user = DB::table('users as u')
                ->leftJoin('overtimes as o', 'u.id', 'o.u_id')
                ->where('o.id', $otID)
                // ->whereNotNull('u.manager')
                ->first();

            if ($user->manager != null) {
                return 'Supervisor: ' . $user->supervisor . '<br>Manager: ' . $user->manager;
            } else {
                return 'Supervisor: ' . $user->supervisor;
            }


            $data = array(
                'ot_status'         => 'head approved',
                'is_head_approved'  => 1,
                'head_approved_at'  => $currentDate,
                'head_approved_by'  => Auth::user()->employee_id,
                'updated_at'        => $currentDate,
                'updated_by'        => Auth::user()->employee_id
            );


            $update = DB::table('overtimes')
                ->where('id', $request->otID)
                ->update($data);

            if ($update > 0) {
                $otData = DB::table('overtimes')
                    ->select(
                        'id',
                        'u_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        DB::raw("'{$action}' as action"),
                        DB::raw("'{$reason}' as action_reason")
                    )->where('id', '=', $request->otID);

                $otHistory = DB::table('overtimes_history')
                    ->insertUsing([
                        'ot_ref',
                        'u_id',
                        'name',
                        'employee_id',
                        'ot_control_number',
                        'ot_location',
                        'ot_reason',
                        'date_applied',
                        'ot_date_from',
                        'ot_date_to',
                        'ot_time_from',
                        'ot_time_to',
                        'ot_hours',
                        'ot_minutes',
                        'ot_hrmins',
                        'ot_status',
                        'office',
                        'department',
                        'head_id',
                        'head_name',
                        'is_head_approved',
                        'head_approved_at',
                        'head_approved_by',
                        'is_cancelled',
                        'cancelled_at',
                        'cancelled_reason',
                        'cancelled_by',
                        'is_denied',
                        'denied_at',
                        'denied_reason',
                        'denied_by',
                        'rcdversion',
                        'ip_address',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        'action',
                        'action_reason'
                    ], $otData);

                if ($otHistory > 0) {
                    $message = "O.T. Request Successfully Approved!";
                } else {
                    $message = "Failed Approval!";
                    DB::rollback();
                }
            } else {
                DB::rollback();
            }

            return response(['isSuccess' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    public function otTimeLogsExcel(Request $request)
    {
        if (
            Auth::check() && (Auth::user()->email_verified_at != NULL)
            && (Auth::user()->role_type == 'ADMIN' || Auth::user()->role_type == 'SUPER ADMIN')
        ) {
            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;
            $currentDate = Carbon::now('Asia/Manila');
            $formattedDateTime = $currentDate->format('YmdHis');

            if (Auth::user()->is_head == 1 || Auth::user()->role_type == 'SUPER ADMIN' ||  Auth::user()->role_type == 'ADMIN') {
                $tlSummary = DB::table('v_overtime_details');
                if (Auth::user()->id != 1) {
                    $tlSummary = $tlSummary->where('employee_id', Auth::user()->employee_id)
                        ->orWhere('head_id', Auth::user()->employee_id);
                }
                $tlSummary = $tlSummary->get();
                /* $tlSummary = DB::select("CALL sp_generated_timelogs_summary(?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut
                    // date('Y-m-d', strtotime($request->timeIn)), // Format the date as 'Y-m-d'
                    // date('Y-m-d', strtotime($request->timeOut)) // Format the date as 'Y-m-d'
                ]);*/

                $tlDetailed = DB::select("CALL sp_generated_timelogs_detailed(?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut
                ]);
            } else {
                $tlSummary = DB::select('CALL sp_timelogs(' . Auth::user()->id . ',' . Auth::user()->is_head . ',' . $employee_id . ')');
            }


            return response()->json([
                'tlSummary'     => $tlSummary,
                'tlDetailed'    => $tlDetailed,
                'currentDate'   => $formattedDateTime
            ]);

            // $offices = DB::table('offices')->orderBy('company_name')->get();
            // $departments = DB::table('departments')->orderBy('department')->get();

            // return view('/reports/excel/timelogs-excel',
            //     [
            //         'employees'     => $employees,
            //         'offices'       => $offices,
            //         'departments'   => $departments,
            //         'currentDate'   => $formattedDateTime
            //     ]);
        } else {
            return redirect('/');
        }
    }
}
