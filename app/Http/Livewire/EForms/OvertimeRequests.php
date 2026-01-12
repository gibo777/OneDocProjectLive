<?php

namespace App\Http\Livewire\EForms;

use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApplicationSubmitted;

use Spatie\GoogleCalendar\Event;

class OvertimeRequests extends Component
{
    use WithPagination;

    public $pageSize = 15;  // Default page size
    public $offices;        // Variable to hold offices
    public $departments;    // Variable to hold departments
    public $search = '';    // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = '';   // Office filter variable
    public $fLType = '';    // Office Leave Type variable
    public $fOTStatus = '';  // Office Leave Status variable
    public $fOTdtFrom = '';  // Date From filter variable
    public $fOTdtTo = '';    // Date To filter variable

    public $lTypes = '';
    public $lStatus = '';

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];


    public function mount()
    {

        $this->loadDropdowns();
    }

    public function render()
    {
        $overtimes = $this->fetchOvertimeListing();
        $this->loadDropdowns();

        return view('livewire.e-forms.overtime-requests', [
            'overtimes' => $overtimes,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }

    public function refreshComponent()
    {
        $this->reset('page');
    }


    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
        $this->lTypes = DB::table('leave_types')->get();
        $this->lStatus = DB::table('request_statuses')->get();
    }


    public function clearDateFilters()
    {
        $this->fOTdtFrom = null;
        $this->fOTdtTo = null;
    }

    private function fetchOvertimeListing()
    {
        $overtimes = DB::table('overtimes as ot')
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

        if (Auth::user()->id != 1 && Auth::user()->id != 2 && Auth::user()->id != 233) {
            $overtimes = $overtimes->where('u.id', '<>', 1);
        }
        $overtimes = $overtimes->where(function ($query) {

            // Apply office filter if selected
            if (!empty($this->fTLOffice)) {
                $query->where('ot.office', $this->fTLOffice);
            }
            // Apply department filter if selected
            if (!empty($this->fTLDept)) {
                $query->where('ot.department', $this->fTLDept);
            }
            // Apply OT Status filter if selected
            if (!empty($this->fOTStatus)) {
                $query->where('ot.ot_status', $this->fOTStatus);
            }

            if (Auth::user()->role_type == 'SUPER ADMIN' || Auth::user()->role_type == 'ADMIN') {
                // Apply search query if search term is provided
                if (!empty($this->search)) {
                    $searchTerms = explode(' ', $this->search);
                    $query->where(function ($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $q->where('ot.name', 'like', '%' . $term . '%');
                        }
                    })
                        ->orWhere('ot.employee_id', 'like', '%' . $this->search . '%')
                        ->orWhere('ot.ot_control_number', 'like', '%' . $this->search . '%');
                }
            }


            // Filter by date range
            if (!empty($this->fOTdtFrom) && !empty($this->fOTdtTo)) {
                $query->where(function ($q) {
                    $q->where('ot.ot_date_from', '>=', $this->fOTdtFrom)
                        ->where('ot.ot_date_to', '<=', $this->fOTdtTo);
                });
            } elseif (!empty($this->fOTdtFrom)) {
                $query->where('ot.ot_date_from', $this->fOTdtFrom);
            } elseif (!empty($this->fOTdtTo)) {
                $query->where('ot.ot_date_to', $this->fOTdtTo);
            }

            if (Auth::user()->is_head == 1) {
                // This will be changed or removed if a new module for user authorization viewing is created.
                switch (Auth::user()->id) {
                    case 1:
                    case 8:
                        break;
                    case 124:
                        $query->where(function ($q) {
                            return $q->where('ot.office', Auth::user()->office)
                                ->orWhere('ot.office', 6);
                        });
                        break;
                    case 126:
                        $query->where(function ($q) {
                            return $q->whereIn('ot.office', [8, 12, 13, 14, 15]);
                        });
                        break;
                    case 337:
                        $query->where(function ($q) {
                            return $q->where('ot.office', Auth::user()->office)
                                ->orWhere('ot.office', 17);
                        });
                        break;
                    default:
                        $query->where(function ($q) {
                            return $q->where('ot.employee_id', Auth::user()->employee_id)
                                ->orWhere('u.supervisor', Auth::user()->employee_id)
                                ->orWhere('u.manager', Auth::user()->employee_id);
                        });
                        break;
                }
            } else {
                $query->where('u.id', Auth::user()->id);
            }

            // Filter by deleted users
            $query->where(function ($q) {
                return $q->where('u.is_deleted', 0)
                    ->orWhereNull('u.is_deleted');
            });
        });
        $overtimes = $overtimes->orderBy('ot.created_at', 'desc')
            ->paginate($this->pageSize);

        return $overtimes;
    }

    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    public function fetchDetailedLeave(Request $request)
    {
        $otData = DB::table('v_overtime_details')
            ->where('id', $request->id)
            ->first();

        $isAdmin = Auth::user()->id == 1;
        $isApprover1 = Auth::user()->employee_id == $otData->approver1;
        $isApprover2 = Auth::user()->employee_id == $otData->approver2 && $otData->approver2 != null;
        $isHead = Auth::user()->employee_id == $otData->head_id;
        $isOwner = Auth::user()->employee_id == $otData->employee_id;
        $status = strtolower($otData->ot_status);

        return response()->json([
            'status' => 'success',
            'html' => view('modals.e-forms.m-overtime-detailed', [
                'otDtls'      => $otData,
                'isAdmin'     => $isAdmin,
                'isApprover1' => $isApprover1,
                'isApprover2' => $isApprover2,
                'isHead'      => $isHead,
                'isOwner'     => $isOwner,
                'status'      => $status,
            ])->render(),
            'otData' => $otData
        ]);

        // $otData = DB::table('v_overtime_details')
        //     ->where('id', $request->id)
        //     ->first();

        // return response()->json([
        //     'status' => 'success',
        //     'html' => view('modals.e-forms.m-overtime-detailed', ['otDtls' => $otData])->render(),
        //     'otDtls' => $otData
        // ]);
    }

    public function headApproveLeave(Request $request)
    {
        // return var_dump($request->all());
        if ($request->ajax()) {
            $lData = $request->input('lData', []);

            $lId = $lData['lID'] ?? '';
            $lType = $lData['lType'] ?? '';
            $lOthers = $lData['lOthers'] ?? '';
            $newStatus = 'Head Approved';

            try {

                $dataArray = array(
                    'leave_status'          => $newStatus,
                    'is_head_approved'      => 1,
                    'head_name'             => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'approved_by'           => Auth::user()->employee_id,
                    'date_approved_head'    => DB::raw('NOW()')
                );
                if ($lType !== '') {
                    $dataArray['leave_type'] = $lType;
                    $dataArray['others']     = $lOthers;
                }

                $update = DB::table('leaves');
                $update = $update->where('id', $lId);
                $update = $update->update($dataArray);

                if ($update > 0) {
                    $action = $newStatus;
                    $reason = "N/A";

                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id', '=', 'L.employee_id')
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
                            'L.date_from',
                            'L.date_to',
                            'L.no_of_days',
                            'L.is_head_approved',
                            'L.date_approved_head',
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("NOW() as created_at")
                        )->where('L.id', '=', $lId)
                        ->where(function ($query) {
                            $query->whereNull('b.is_deleted')
                                ->orWhere('b.is_deleted', '=', NULL);
                        });

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
                            'date_from',
                            'date_to',
                            'no_of_days',
                            'is_head_approved',
                            'date_approved_head',
                            'head_name',
                            'action',
                            'action_reason',
                            'created_at'
                        ], $leaveInsert);

                    if ($history > 0) {
                        $newLeave = $leaveInsert->first();
                        return response()->json([
                            'isSuccess' => true,
                            'message'   => "Head Approval Successful!",
                            'dataLeave' => $newLeave,
                            'apiKey'    => env('API_KEY'),
                            'apiURL'    => env('HRIS_URL') . "/api/leaves/fetch",
                        ]);
                    } else {
                        DB::rollback();
                        return response()->json(['isSuccess' => false, 'message' => "Failed to Approve Leave"]);
                    }
                } else {
                    DB::rollback();
                    return response()->json(['isSuccess' => false, 'message' => "Failed to Approve Leave"]);
                }
            } catch (\Exception $e) {
                return response()->json(['isSuccess' => false, 'message' => $e]);
            }
        }
    }

    public function revokeLeave(Request $request)
    {
        if ($request->ajax()) {
            try {
                $lId = $request->lID;
                $action = $request->lAction;
                $reason = $request->lReason;
                $date = DB::raw('NOW()'); // Carbon::now('Asia/Manila')
                $newStatus = $request->lAction;

                if ($action == "Cancelled") {
                    $data_array = array(
                        'leave_status'    => $action,
                        'is_cancelled'    => 1,
                        'cancelled_by'    => Auth::user()->employee_id,
                        'date_cancelled'  => DB::raw('NOW()')
                    );
                } else if ($action == "Denied") {
                    $data_array = array(
                        'leave_status' => $action,
                        'is_denied'    => 1,
                        'denied_by'    => Auth::user()->employee_id,
                        'date_denied'  => DB::raw('NOW()')
                    );
                }
                $update = DB::table('leaves');
                $update = $update->where('id', $lId);
                $update = $update->update($data_array);

                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id', '=', 'L.employee_id')
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
                            'L.date_from',
                            'L.date_to',
                            'L.no_of_days',
                            'L.is_head_approved',
                            'L.date_approved_head',
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("NOW() as created_at")
                        )->where('L.id', '=', $lId);

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
                            'date_from',
                            'date_to',
                            'no_of_days',
                            'is_head_approved',
                            'date_approved_head',
                            'head_name',
                            'action',
                            'action_reason',
                            'created_at'
                        ], $leaveInsert);

                    if ($history > 0) {
                        if ($action == "Denied") {
                            $newLeave = $leaveInsert->first();
                            $lEmail = DB::table('users')
                                ->where('employee_id', $newLeave->employee_id)
                                ->value('email');
                            // Mail::to($lEmail)->send(new LeaveApplicationSubmitted($newLeave, '', '', 'denied'));
                        } else {
                            $newLeave = '';
                        }
                        return response()->json([
                            'isSuccess' => true,
                            'message'   => "Leave " . $action . " Successfuly!",
                            'dataLeave' => $newLeave,
                            'apiKey'    => env('API_KEY'),
                            'apiURL'    => env('HRIS_URL') . "/api/leaves/fetch",
                        ]);
                    } else {
                        DB::rollback();
                        return response()->json(['isSuccess' => false, 'message' => "Action Failed!"]);
                    }
                } else {
                    return response()->json(['isSuccess' => false, 'message' => "Action Failed!"]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['isSuccess' => false, 'message' => $e]);
            }
        }
    }

    public function linkHeadApproveLeave(Request $request)
    {

        if ($request->ajax()) {
            $lData = $request->input('lData', []);
            $lId = $lData['lId'] ?? '';
            $lHash = $lData['lHash'] ?? '';
            $lType = $lData['lType'] ?? '';
            $lOthers = $lData['lOthers'] ?? '';
            $newStatus = 'Head Approved';

            $headId = DB::table('leaves as l')
                ->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
                ->select('u.supervisor as head_id', 'u.email')
                ->addSelect(DB::raw("(SELECT CONCAT(first_name, ' ', last_name, ' ', suffix) FROM users WHERE employee_id = u.supervisor) as head_name"))
                ->where('l.id', $lId)
                ->where('l.hash_id', $lHash)->first();

            try {
                // $googleEventId = DB::table('leaves')
                // ->where('id', $lId)
                // ->where('hash_id', $lHash)
                // ->value('google_id');

                // $event = Event::find($googleEventId);

                // if ($event) {
                //     $description        = $event->description;
                //     $description        = preg_replace('/Status: .*/', "Status: $newStatus", $description);
                //     $event->description = $description;
                //     $event->save();
                // }

                $dataArray = array(
                    'leave_status'          => $newStatus,
                    'is_head_approved'      => 1,
                    'approved_by'           => $headId->head_id,
                    'head_name'             => $headId->head_name,
                    'date_approved_head'    => DB::raw('NOW()'),
                    'updated_at'            => DB::raw('NOW()')
                );
                if ($lType !== '') {
                    $dataArray['leave_type'] = $lType;
                    $dataArray['others']    = $lOthers;
                }

                $update = DB::table('leaves');
                $update = $update->where('id', $lId);
                $update = $update->update($dataArray);

                if ($update > 0) {
                    $action = $newStatus;
                    $reason = "N/A";

                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id', '=', 'L.employee_id')
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
                            'L.date_from',
                            'L.date_to',
                            'L.no_of_days',
                            'L.is_head_approved',
                            'L.date_approved_head',
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("NOW() as created_at")
                        )->where('L.id', '=', $lId)
                        ->where(function ($query) {
                            $query->whereNull('b.is_deleted')
                                ->orWhere('b.is_deleted', '=', NULL);
                        });

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
                            'date_from',
                            'date_to',
                            'no_of_days',
                            'is_head_approved',
                            'date_approved_head',
                            'head_name',
                            'action',
                            'action_reason',
                            'created_at'
                        ], $leaveInsert);

                    if ($history > 0) {
                        $newLeave = $leaveInsert->first();
                        // Email Notification to User/Employee after approved by the Head/Supervisor
                        // Mail::to($headId->email)->send(new LeaveApplicationSubmitted($newLeave, '', '', 'approved'));
                        return response()->json([
                            'isSuccess' => true,
                            'message'   => "Head Approval Successful!",
                            'dataLeave' => $newLeave,
                            'apiKey'    => env('API_KEY'),
                            'apiURL'    => env('HRIS_URL') . "/api/leaves/fetch",
                        ]);
                    } else {
                        DB::rollback();
                        return response()->json(['isSuccess' => false, 'message' => "Failed to Approve Leave"]);
                    }
                } else {
                    DB::rollback();
                    return response()->json(['isSuccess' => false, 'message' => "Failed to Approve Leave"]);
                }
            } catch (\Exception $e) {
                return response()->json(['isSuccess' => false, 'message' => $e]);
            }
        }
    }

    public function linkHeadDenyLeave(Request $request)
    {
        if ($request->ajax()) {
            try {
                $lId = $request->lId;
                $lHash = $request->lHash;
                $action = $request->lAction;
                $reason = $request->lReason;
                $date = DB::raw('NOW()');
                $newStatus = 'Denied';

                # Google Calendar Integration - Revoke by Head using link from email
                // $googleEventId = DB::table('leaves')
                // ->where('id', $lId)
                // ->where('hash_id', $lHash)
                // ->value('google_id');

                // $event = Event::find($googleEventId);

                // if ($event) {
                //     $description        = $event->description;
                //     $description        = preg_replace('/Status: .*/', "Status: $newStatus", $description);
                //     $event->description = $description;
                //     if (in_array($newStatus, ['Denied', 'Cancelled'])) {
                //         $event->status = 'cancelled';
                //     }
                //     $event->save();
                // }

                $headId = DB::table('leaves as l')
                    ->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
                    ->select('u.supervisor as head_id', 'u.email')
                    ->addSelect(DB::raw("(SELECT CONCAT(first_name, ' ', last_name, ' ', suffix) FROM users WHERE employee_id = u.supervisor) as head_name"))
                    ->where('l.id', $lId)
                    ->where('l.hash_id', $lHash)->first();

                $data_array = array(
                    'leave_status'  => 'Denied',
                    'is_denied'     => 1,
                    'denied_by'     => $headId->head_id,
                    'date_denied'   => DB::raw('NOW()'),
                    'updated_at'    => DB::raw('NOW()')
                );

                $update = DB::table('leaves');
                $update = $update->where('id', $lId);
                $update = $update->update($data_array);

                if ($update > 0) {
                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id', '=', 'L.employee_id')
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
                            'L.date_from',
                            'L.date_to',
                            'L.no_of_days',
                            'L.is_head_approved',
                            'L.date_approved_head',
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("NOW() as created_at")
                        )->where('L.id', '=', $lId);

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
                            'date_from',
                            'date_to',
                            'no_of_days',
                            'is_head_approved',
                            'date_approved_head',
                            'head_name',
                            'action',
                            'action_reason',
                            'created_at'
                        ], $leaveInsert);

                    if ($history > 0) {
                        $newLeave = $leaveInsert->first();
                        // Email Notification to User/Employee after denied by the Head/Supervisor
                        // Mail::to($headId->email)->send(new LeaveApplicationSubmitted($newLeave, '', '', 'denied'));
                        return response()->json([
                            'isSuccess' => true,
                            'message'   => "Leave " . $action . " Successfuly!",
                            'dataLeave' => $newLeave,
                            'apiKey'    => env('API_KEY'),
                            'apiURL'    => env('HRIS_URL') . "/api/leaves/fetch",
                        ]);
                    } else {
                        DB::rollback();
                        return response()->json(['isSuccess' => false, 'message' => "Action Failed!"]);
                    }
                } else {
                    return response()->json(['isSuccess' => false, 'message' => "Action Failed!"]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['isSuccess' => false, 'message' => $e]);
            }
        }
    }

    public function gCalendarAndMail(Request $request)
    {

        $dLinkApprove   = $request->has('dLinkApprove') ? $request->dLinkApprove : '';
        $dLinkDeny      = $request->has('dLinkDeny') ? $request->dLinkDeny : '';
        $dAction = $request->has('dAction') ? ($request->dAction === 'Approved' ? 'Head ' . $request->dAction : $request->dAction) : '';

        $lEmail = DB::table('users')
            ->where('employee_id', $request->input('dMail.employee_id'))
            ->value('email');

        if (strtolower($request->dAction) != 'cancelled') {
            Mail::to($lEmail)->send(new LeaveApplicationSubmitted($request->dMail, $dLinkApprove, $dLinkDeny, $request->dAction));
        }

        $googleEvent = DB::table('leaves as L')
            ->where('L.id', $request->lID)
            ->first();

        if (!empty($googleEvent->google_id)) {
            $event = Event::find($googleEvent->google_id);

            // $namePartsG = [
            //     Auth::user()->last_name,
            //     substr(Auth::user()->first_name, 0, 1)
            // ];
            // if ($suffix = Auth::user()->suffix) {
            //     $namePartsG[] = $suffix;
            // }

            // if ($middleName = Auth::user()->middle_name) {
            //     $namePartsG[] = substr($middleName, 0, 1) . '.';
            // }
            // $lFullNameG = $namePartsG[0] . ', ' . implode(' ', array_slice($namePartsG, 1));

            if ($event) {
                if ($request->dAction === 'Approved') {
                    $description = sprintf(
                        "Name: %s\nEmployee #: %s\n\nLeave Type: %s\nDate Covered: %s to %s\nNumber of Day/s: %.1f\nReason: %s\n\nStatus: %s",
                        $googleEvent->name,
                        $googleEvent->employee_id,
                        $googleEvent->leave_type,
                        Carbon::parse($googleEvent->date_from)->format('M d, Y (D)'),
                        Carbon::parse($googleEvent->date_to)->format('M d, Y (D)'),
                        number_format($googleEvent->no_of_days, 2),
                        strtoupper($googleEvent->reason),
                        $dAction
                    );
                    $event->description = $description;
                    $event->save();
                } else {
                    $event->status = 'cancelled';
                    $event->save();
                }
            }
        }
    }
}
