<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OvertimeRequested;


// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\OvertimeExport;

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
                ['otUser' => $otUser]
            );
        } else {
            return redirect('/');
        }
    }

    public function submitOvertime(Request $request)
    {

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

            $hashId = 'OT-' . Str::random(16);

            try {
                $data = [
                    'name' => $request->otName,
                    'hash_id' => $hashId,
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
                $otID = DB::table('overtimes')->insertGetId($data);

                return response([
                    'isSuccess' => true,
                    'otID' => $otID,
                    'message' => 'OVERTIME REQUEST successfully submitted!'
                ]);
            } catch (\Exception $e) {
                return response([
                    'isSuccess' => false,
                    'message' => $e
                ]);
            }
        }
    }

    public function mailOvertimeRequest(Request $request)
    {
        $insertId = $request->otID;
        $newOvertime = DB::table('overtimes as ot')
            ->where('ot.id', $insertId)
            ->first();
        $hashId = $newOvertime->hash_id;

        ### Generate URLs for approval and denial ###
        $approveUrl = route('overtime.decide', ['action' => 'approve', 'hashId' => $hashId]) . '-' . $insertId;
        $denyUrl = route('overtime.decide', ['action' => 'deny', 'hashId' => $hashId]) . '-' . $insertId;


        ### Fetch the supervisor's email ###
        $defaultSupervisorEmail = DB::table('users')
            ->where('employee_id', Auth::user()->supervisor)
            ->value('email');

        ### Check if the default supervisor's email contains 'jmyulo' ###
        $supervisorEmail = strpos($defaultSupervisorEmail, 'jmyulo') !== false
            ? DB::table('users')->where('id', 32)->value('email')
            : $defaultSupervisorEmail;

        ### Send the email to the supervisor ###
        Mail::to($supervisorEmail)->send(new OvertimeRequested($newOvertime, 'submit', $approveUrl, $denyUrl));
    }

    public function overtimeHeadDecide($action, $hashId)
    {
        $pos = strrpos($hashId, '-');

        if ($pos === false) {
            abort(404, 'Invalid link!');
        }

        $hash = substr($hashId, 0, $pos);
        $id   = substr($hashId, $pos + 1);

        $dOvertime = DB::table('overtimes as ot')
            ->leftJoin('users as u', 'ot.employee_id', 'u.employee_id')
            ->leftJoin('offices as o', 'ot.office', 'o.id')
            ->leftJoin('departments as d', 'ot.department', 'd.department_code')
            ->leftJoin('users as u2', 'ot.head_id', 'u2.employee_id')
            ->select(
                'ot.id',
                'ot.ot_control_number',
                'ot.name',
                'ot.employee_id',
                'ot.head_name as supervisor',
                'o.company_name as office',
                'd.department',
                'ot.date_applied',
                'ot.ot_location',
                'ot.ot_reason',
                'ot.ot_date_from',
                'ot.ot_date_to',
                'ot.ot_time_from',
                'ot.ot_time_to',
                'ot.ot_hours',
                'ot.ot_minutes',
                'ot.ot_hrmins',
                'ot.ot_status'
            )
            ->where('ot.id', $id)
            ->where('ot.hash_id', $hash)
            ->first();


        return view(
            'hris/overtime/head-decide',
            [
                'hashId'        => $hashId,
                'hashId'        => $hashId,
                'action'        => $action,
                'otData'        =>  $dOvertime,
                // 'leaveTypes'    => $leaveTypes,
                // 'leaveCredits'  => $leaveCredits,
            ]
        );
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

            $otDHistory = DB::table('overtimes_history as oh')
                ->leftJoin('users as u', 'u.id', '=', 'oh.u_id')
                ->leftJoin('departments as d', 'd.id', '=', 'oh.department')
                ->leftJoin('users as a1', 'a1.employee_id', 'oh.head_approved_by')
                ->leftJoin('users as a2', 'a2.employee_id', 'oh.head2_approved_by')
                ->leftJoin('users as a3', 'a3.employee_id', 'oh.denied_by')
                ->leftJoin('users as a4', 'a4.employee_id', 'oh.cancelled_by')
                ->select(
                    'oh.name',
                    'oh.ot_control_number',
                    // 'oh.action',
                    DB::raw("
                        CASE
                            WHEN oh.is_denied = 1 THEN 'Denied'
                            WHEN oh.is_cancelled = 1 THEN 'Cancelled'
                            WHEN oh.is_head2_approved = 1 THEN 'Head Approved'
                            WHEN oh.is_head_approved = 1 THEN 'Head Approved'
                        END AS action
                    "),
                    'oh.action_reason',
                    // DB::raw("DATE_FORMAT(oh.created_at,'%m/%d/%Y %h:%i %p') as action_date"),
                    'oh.head_name',
                    DB::raw("DATE_FORMAT(oh.date_applied,'%m/%d/%Y %h:%i %p') as date_applied"),
                    DB::raw("DATE_FORMAT(CONCAT(oh.ot_date_from,' ',oh.ot_time_from), '%m/%d/%Y %h:%i %p') as date_from"),
                    DB::raw("DATE_FORMAT(CONCAT(oh.ot_date_to,' ',oh.ot_time_to), '%m/%d/%Y %h:%i %p') as date_to"),
                    'oh.ot_hours',
                    'oh.ot_minutes',
                    'oh.ot_hrmins',
                    DB::raw("
                        CASE
                            WHEN oh.is_denied = 1 THEN a3.name
                            WHEN oh.is_cancelled = 1 THEN a4.name
                            WHEN oh.is_head2_approved = 1 THEN a2.name
                            WHEN oh.is_head_approved = 1 THEN a1.name
                        END AS action_by
                    "),
                    DB::raw("
                        CASE
                            WHEN oh.is_denied = 1 THEN DATE_FORMAT(oh.denied_at, '%m/%d/%Y %h:%i %p')
                            WHEN oh.is_cancelled = 1 THEN DATE_FORMAT(oh.cancelled_at, '%m/%d/%Y %h:%i %p')
                            WHEN oh.is_head2_approved = 1 THEN DATE_FORMAT(oh.head2_approved_at, '%m/%d/%Y %h:%i %p')
                            WHEN oh.is_head_approved = 1 THEN DATE_FORMAT(oh.head_approved_at, '%m/%d/%Y %h:%i %p')
                        END AS action_date
                    "),
                    'oh.is_head_approved',
                    'a1.name as head_approved_by',
                    'oh.is_head2_approved',
                    'a2.name as head2_approved_by',
                    DB::raw("DATE_FORMAT(oh.created_at, '%m/%d/%Y %h:%i %p') AS created_at")
                )
                ->where('oh.ot_ref', $request->otRefID)
                ->orderBy('oh.id', 'desc')
                ->get();

            return $otDHistory;

            // return response(['isSuccess' => true, 'message' => 'Request cancelled!']);
        }
    }

    public function cancelOvertime(Request $request)
    {
        try {
            $otID = $request->otID;
            $action = "Cancelled";
            $reason = $request->otReason;
            $currentDate = DB::raw('NOW()');
            $message = "";
            $data = array(
                'ot_status'         => 'Cancelled',
                'is_cancelled'      => 1,
                'cancelled_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'cancelled_by'      => Auth::user()->employee_id,
                'cancelled_reason'  => $request->otReason,
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'        => Auth::user()->employee_id
            );
            // return response(['isSuccess' => false, 'otData' => $data]);

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
            $reason = $request->otReason;
            $currentDate = DB::raw('NOW()');
            $message = "";

            $data = array(
                'ot_status'     => 'denied',
                'is_denied'     => 1,
                'denied_at'     => DB::raw('NOW()'),
                'denied_by'     => Auth::user()->employee_id,
                'denied_reason' => $request->otReason,
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
        try {
            $otID = $request->otID;
            $action = "Head Approved";
            $reason = $request->otComment;
            $currentDate = DB::raw('NOW()');
            $message = "";

            $user = DB::table('users as u')
                ->leftJoin('overtimes as o', 'u.id', 'o.u_id')
                ->select('u.supervisor', 'u.manager', 'o.is_head_approved', 'o.is_head2_approved')
                ->where('o.id', $otID)
                // ->whereNotNull('u.manager')
                ->first();

            if ($user->manager != null) {
                if ((Auth::user()->employee_id == $user->supervisor) && ($user->is_head_approved == NULL || $user->is_head_approved == 0)) {
                    $data = array(
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
                } else {
                    $data = array(
                        'ot_status'         => 'Head Approved',
                        'is_head2_approved'  => 1,
                        'head2_approved_at'  => $currentDate,
                        'head2_approved_by'  => Auth::user()->employee_id,
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
                                'is_head2_approved',
                                'head2_approved_at',
                                'head2_approved_by',
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
                                'is_head2_approved',
                                'head2_approved_at',
                                'head2_approved_by',
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
                }
            } else {

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
                            'is_head2_approved',
                            'head2_approved_at',
                            'head2_approved_by',
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
                            'is_head2_approved',
                            'head2_approved_at',
                            'head2_approved_by',
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
            }



            return response(['isSuccess' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    public function linkHeadApproveOvertime(Request $request)
    {
        try {
            $otID = $request->input('otID');
            $otHash = $request->input('otHash');
            $action = "Head Approved";
            $reason = $request->input('otComment');
            $currentDate = Carbon::now();
            $message = "";

            $user = DB::table('users as u')
                ->leftJoin('overtimes as o', 'u.id', 'o.u_id')
                ->select('u.id as uID', 'u.supervisor', 'u.manager', 'o.is_head_approved', 'o.is_head2_approved')
                ->where('o.id', $otID)
                ->where('o.hash_id', $otHash)
                // ->whereNotNull('u.manager')
                ->first();

            // if ($user->manager != null) {
            //     if ($user->is_head_approved == NULL || $user->is_head_approved == 0) {
            //         $data = array(
            //             'ot_status'         => $action,
            //             'is_head_approved'  => 1,
            //             'head_approved_at'  => $currentDate,
            //             'head_approved_by'  => $user->supervisor,
            //             'updated_at'        => $currentDate,
            //             'updated_by'        => $user->supervisor
            //         );

            //         $update = DB::table('overtimes')
            //             ->where('id', $otID)
            //             ->where('hash_id', $otHash)
            //             ->update($data);

            //         if ($update > 0) {
            //             $otData = DB::table('overtimes')
            //                 ->select(
            //                     'id',
            //                     'u_id',
            //                     'name',
            //                     'employee_id',
            //                     'ot_control_number',
            //                     'ot_location',
            //                     'ot_reason',
            //                     'date_applied',
            //                     'ot_date_from',
            //                     'ot_date_to',
            //                     'ot_time_from',
            //                     'ot_time_to',
            //                     'ot_hours',
            //                     'ot_minutes',
            //                     'ot_hrmins',
            //                     'ot_status',
            //                     'office',
            //                     'department',
            //                     'head_id',
            //                     'head_name',
            //                     'is_head_approved',
            //                     'head_approved_at',
            //                     'head_approved_by',
            //                     'is_cancelled',
            //                     'cancelled_at',
            //                     'cancelled_reason',
            //                     'cancelled_by',
            //                     'is_denied',
            //                     'denied_at',
            //                     'denied_reason',
            //                     'denied_by',
            //                     'rcdversion',
            //                     'ip_address',
            //                     'created_at',
            //                     'updated_at',
            //                     'created_by',
            //                     'updated_by',
            //                     DB::raw("'{$action}' as action"),
            //                     DB::raw("'{$reason}' as action_reason")
            //                 )->where('id', $otID)->where('hash_id', $otHash);

            //             $otHistory = DB::table('overtimes_history')
            //                 ->insertUsing([
            //                     'ot_ref',
            //                     'u_id',
            //                     'name',
            //                     'employee_id',
            //                     'ot_control_number',
            //                     'ot_location',
            //                     'ot_reason',
            //                     'date_applied',
            //                     'ot_date_from',
            //                     'ot_date_to',
            //                     'ot_time_from',
            //                     'ot_time_to',
            //                     'ot_hours',
            //                     'ot_minutes',
            //                     'ot_hrmins',
            //                     'ot_status',
            //                     'office',
            //                     'department',
            //                     'head_id',
            //                     'head_name',
            //                     'is_head_approved',
            //                     'head_approved_at',
            //                     'head_approved_by',
            //                     'is_cancelled',
            //                     'cancelled_at',
            //                     'cancelled_reason',
            //                     'cancelled_by',
            //                     'is_denied',
            //                     'denied_at',
            //                     'denied_reason',
            //                     'denied_by',
            //                     'rcdversion',
            //                     'ip_address',
            //                     'created_at',
            //                     'updated_at',
            //                     'created_by',
            //                     'updated_by',
            //                     'action',
            //                     'action_reason'
            //                 ], $otData);

            //             if ($otHistory > 0) {
            //                 $message = "O.T. Request Successfully Approved!";
            //             } else {
            //                 $message = "Failed Approval!";
            //                 DB::rollback();
            //             }
            //         } else {
            //             DB::rollback();
            //         }
            //     } else {
            //         $data = array(
            //             'ot_status'         => $action,
            //             'is_head2_approved' => 1,
            //             'head2_approved_at' => $currentDate,
            //             'head2_approved_by' => $user->supervisor,
            //             'updated_at'        => $currentDate,
            //             'updated_by'        => $user->supervisor
            //         );


            //         //             $update = DB::table('overtimes')
            //         //                 ->where('id', $request->otID)
            //         //                 ->update($data);

            //         //             if ($update > 0) {
            //         //                 $otData = DB::table('overtimes')
            //         //                     ->select(
            //         //                         'id',
            //         //                         'u_id',
            //         //                         'name',
            //         //                         'employee_id',
            //         //                         'ot_control_number',
            //         //                         'ot_location',
            //         //                         'ot_reason',
            //         //                         'date_applied',
            //         //                         'ot_date_from',
            //         //                         'ot_date_to',
            //         //                         'ot_time_from',
            //         //                         'ot_time_to',
            //         //                         'ot_hours',
            //         //                         'ot_minutes',
            //         //                         'ot_hrmins',
            //         //                         'ot_status',
            //         //                         'office',
            //         //                         'department',
            //         //                         'head_id',
            //         //                         'head_name',
            //         //                         'is_head_approved',
            //         //                         'head_approved_at',
            //         //                         'head_approved_by',
            //         //                         'is_head2_approved',
            //         //                         'head2_approved_at',
            //         //                         'head2_approved_by',
            //         //                         'is_cancelled',
            //         //                         'cancelled_at',
            //         //                         'cancelled_reason',
            //         //                         'cancelled_by',
            //         //                         'is_denied',
            //         //                         'denied_at',
            //         //                         'denied_reason',
            //         //                         'denied_by',
            //         //                         'rcdversion',
            //         //                         'ip_address',
            //         //                         'created_at',
            //         //                         'updated_at',
            //         //                         'created_by',
            //         //                         'updated_by',
            //         //                         DB::raw("'{$action}' as action"),
            //         //                         DB::raw("'{$reason}' as action_reason")
            //         //                     )->where('id', '=', $request->otID);

            //         //                 $otHistory = DB::table('overtimes_history')
            //         //                     ->insertUsing([
            //         //                         'ot_ref',
            //         //                         'u_id',
            //         //                         'name',
            //         //                         'employee_id',
            //         //                         'ot_control_number',
            //         //                         'ot_location',
            //         //                         'ot_reason',
            //         //                         'date_applied',
            //         //                         'ot_date_from',
            //         //                         'ot_date_to',
            //         //                         'ot_time_from',
            //         //                         'ot_time_to',
            //         //                         'ot_hours',
            //         //                         'ot_minutes',
            //         //                         'ot_hrmins',
            //         //                         'ot_status',
            //         //                         'office',
            //         //                         'department',
            //         //                         'head_id',
            //         //                         'head_name',
            //         //                         'is_head_approved',
            //         //                         'head_approved_at',
            //         //                         'head_approved_by',
            //         //                         'is_head2_approved',
            //         //                         'head2_approved_at',
            //         //                         'head2_approved_by',
            //         //                         'is_cancelled',
            //         //                         'cancelled_at',
            //         //                         'cancelled_reason',
            //         //                         'cancelled_by',
            //         //                         'is_denied',
            //         //                         'denied_at',
            //         //                         'denied_reason',
            //         //                         'denied_by',
            //         //                         'rcdversion',
            //         //                         'ip_address',
            //         //                         'created_at',
            //         //                         'updated_at',
            //         //                         'created_by',
            //         //                         'updated_by',
            //         //                         'action',
            //         //                         'action_reason'
            //         //                     ], $otData);

            //         //                 if ($otHistory > 0) {
            //         //                     $message = "O.T. Request Successfully Approved!";
            //         //                 } else {
            //         //                     $message = "Failed Approval!";
            //         //                     DB::rollback();
            //         //                 }
            //         //             } else {
            //         //                 DB::rollback();
            //         //             }
            //     }
            // } else {

            $data = array(
                'ot_status'         => $action,
                'is_head_approved'  => 1,
                'head_approved_at'  => $currentDate,
                'head_approved_by'  => $user->supervisor,
                'updated_at'        => $currentDate,
                'updated_by'        => $user->supervisor
            );

            $update = DB::table('overtimes')
                ->where('id', $otID)
                ->where('hash_id', $otHash)
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
                        'is_head2_approved',
                        'head2_approved_at',
                        'head2_approved_by',
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
                    )->where('id', $otID)->where('hash_id', $otHash);


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
                        'is_head2_approved',
                        'head2_approved_at',
                        'head2_approved_by',
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
            // }

            return response(['isSuccess' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    public function linkHeadDenyOvertime(Request $request)
    {
        try {
            $otID = $request->otID;
            $otHash = $request->otHash;
            $action = $request->otAction;
            $reason = $request->otReason;
            $currentDate = Carbon::now();
            $message = "";

            $user = DB::table('users as u')
                ->leftJoin('overtimes as o', 'u.id', 'o.u_id')
                ->select('u.id as uID', 'u.supervisor', 'u.manager', 'o.is_head_approved', 'o.is_head2_approved')
                ->where('o.id', $otID)
                ->where('o.hash_id', $otHash)
                // ->whereNotNull('u.manager')
                ->first();

            $data = array(
                'ot_status'     => $action,
                'is_denied'     => 1,
                'denied_at'     => $currentDate,
                'denied_reason' => $reason,
                'denied_by'     => $user->supervisor,
                'updated_at'    => $currentDate,
                'updated_by'    => $user->supervisor
            );

            $update = DB::table('overtimes')
                ->where('id', $otID)
                ->where('hash_id', $otHash)
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
                        'is_head2_approved',
                        'head2_approved_at',
                        'head2_approved_by',
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
                    )->where('id', $otID)->where('hash_id', $otHash);

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
                        'is_head2_approved',
                        'head2_approved_at',
                        'head2_approved_by',
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
                    $message = "O.T. Request has been " . $action;
                    return response()->json(['isSuccess' => true, 'message' => $message]);
                } else {
                    $message = "Failed!";
                    DB::rollback();
                    return response()->json(['isSuccess' => false, 'message' => $message]);
                }
            }
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

    public function overtimesExcel(Request $request)
    {
        $otData = DB::table('overtimes as ot')
            ->select(
                'ot.id',
                'ot.u_id',
                'ot.name as full_name',
                'o.company_name as office',
                'd.department',
                'u.supervisor',
                'd.department_code as dept',
                'ot.ot_control_number',
                'ot.ot_location',
                DB::raw("CONCAT(
                DATE_FORMAT(ot.ot_date_from, '%m/%d/%Y'), ' ',
                DATE_FORMAT(ot.ot_time_from, '%h:%i %p'), ' - ',
                DATE_FORMAT(ot.ot_date_to, '%m/%d/%Y'), ' ',
                DATE_FORMAT(ot.ot_time_to, '%h:%i %p')
            ) as ot_schedule"),
                'ot.ot_hrmins',
                'ot.ot_status',
                'ot.employee_id',
                'ot.created_at as date_applied',
                'ot.is_head_approved',
                'ot.is_head2_approved',
                DB::raw("CONCAT(u2.first_name, ' ', u2.last_name) as approver1"),
                DB::raw("CONCAT(u3.first_name, ' ', u3.last_name) as approver2")
            )
            ->leftJoin('offices as o', 'ot.office', '=', 'o.id')
            ->leftJoin('departments as d', 'ot.department', '=', 'd.department_code')
            ->leftJoin('users as u', 'u.employee_id', '=', 'ot.employee_id')
            ->leftJoin('users as u2', 'u2.employee_id', '=', 'u.supervisor')
            ->leftJoin('users as u3', function ($join) {
                $join->on('u3.employee_id', '=', 'u.manager')
                    ->whereNotNull('u.manager');
            });

        if (Auth::user()->id <> 1) {
            $otData->where('u.id', '<>', 1);
        }

        if ($request->office) {
            $otData->where('ot.office', $request->office);
        }

        if ($request->department) {
            $otData->where('ot.department', $request->department);
        }

        if ($request->status) {
            $otData->where('ot.ot_status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $otData->whereBetween('ot.ot_date_from', [
                $request->date_from,
                $request->date_to
            ]);
        } elseif ($request->date_from && !$request->date_to) {
            $otData->whereDate('ot.ot_date_from', $request->date_from);
            $otData->whereDate('ot.ot_date_to', $request->date_from);
        }

        if ($request->search) {
            $otData->where(function ($q) use ($request) {
                $q->where('ot.name', 'like', '%' . $request->search . '%')
                    ->orWhere('ot.employee_id', 'like', '%' . $request->search . '%')
                    ->orWhere('ot.ot_control_number', 'like', '%' . $request->search . '%');
            });
        }

        $otData = $otData->orderBy('ot.name', 'desc')->get();

        $fOffice = '';
        if ($request->office) {
            $fOffice = DB::table('offices')
                ->where('id', $request->office)
                ->value('company_name');
        }

        $fileName = 'OT_Report_' . Carbon::now()->format('YmdHi');
        if ($fOffice) {
            $fileName .= '_' . $fOffice;
        }
        $fileName .= '.xls';

        return response()->json([
            'otData' => $otData,
            'fileName' => $fileName
        ]);
    }

    public function sendOvertimeToHRIS(Request $request)
    {
        if (!is_numeric($request->otID)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $overtime = DB::table('overtimes as ot')
            ->leftJoin('offices as o', 'ot.office', 'o.id')
            ->leftJoin('users as u', 'ot.u_id', 'u.id')
            ->select(
                'ot.ot_control_number',
                'ot.name',
                'u.email',
                'u.gender as sex',
                'ot.employee_id',
                'o.company_name as office',
                'ot.ot_status',
                'ot.ot_date_from',
                'ot.ot_date_to',
                'ot.ot_time_from',
                'ot.ot_time_to',
                'ot.ot_reason',
                'ot.ot_hours',
                'ot.ot_minutes',
                'ot.ot_hrmins',
                'ot.created_at',
                DB::raw('(SELECT name FROM users where employee_id = ot.created_by) as created_by'),
                'ot.updated_at',
                DB::raw('(SELECT name FROM users where employee_id = ot.updated_by) as updated_by'),
                'ot.ot_location',
            )
            ->where('ot.id', $request->otID)
            ->where('ot.is_head_approved', 1)
            ->first();

        if ($overtime) {

            $payloads = [
                'ot_control_number' => $overtime->ot_control_number,
                'name'              => $overtime->name,
                'employee_id'       => $overtime->employee_id,
                'office'            => $overtime->office,
                'ot_status'         => strtolower($overtime->ot_status) == 'head approved' ? 1 : 2,

                'ot_date_from'      => $overtime->ot_date_from,
                'ot_date_to'        => $overtime->ot_date_to,
                'ot_time_from'      => Carbon::parse($overtime->ot_time_from)->format('H:i'),
                'ot_time_to'        => Carbon::parse($overtime->ot_time_to)->format('H:i'),

                'ot_reason'         => $overtime->ot_reason,
                'ot_hours'          => $overtime->ot_hours,
                'ot_minute'         => $overtime->ot_minutes,
                'ot_hrmins'         => $overtime->ot_hrmins,

                'ot_location'       => $overtime->ot_location,
                'current_step'      => 0,

                'created_at'        => $overtime->created_at,
                'created_by'        => $overtime->created_by,
                'updated_at'        => $overtime->updated_at,
                'updated_by'        => $overtime->updated_by,
            ];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post(env('HRIS_URL') . '/api/otdata/fetch', $payloads);

            if ($response->successful()) {
                $dataArray = array(
                    'api_sent'  => 1,
                    'api_date'  => Carbon::now(),
                    'api_refno' => $response->json('apiNo')
                );

                $otAPI = DB::table('overtimes')
                    ->where('id', $request->otID)
                    ->update($dataArray);

                Log::channel('hris-api-overtime')->info('HRIS API Response', [
                    'ot_action'         => $request->otAction,
                    'status'            => $response->status(),
                    'ot_control_number' => $overtime->ot_control_number,
                    'body'              => $response->body(),
                    'data_array'        => $dataArray
                ]);

                // Mail::to($overtime->email)->send(new OvertimeRequested($overtime, 'approved', '', ''));

                Mail::to($overtime->email)->send(new OvertimeRequested($overtime, $request->otAction, '', ''));

                return response()->json([
                    'status'    => $response->status(),
                    'response'  => $response->json()
                ]);
            } else {
                Log::channel('hris-api-overtime')->info('Failed or No Response from HRIS API', [
                    'status'            => $response->status(),
                    'ot_control_number' => $overtime->ot_control_number,
                    'payloads'          => json_decode(json_encode($payloads), true)
                ]);
                return response()->json(['response' => '']);
            }
        } else {
            return response()->json(['response' => '']);
        }
    }
}
