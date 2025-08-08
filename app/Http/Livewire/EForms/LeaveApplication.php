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

class LeaveApplication extends Component
{
    use WithPagination;

    public $pageSize = 15;  // Default page size
    public $offices;        // Variable to hold offices
    public $departments;    // Variable to hold departments
    public $search = '';    // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = '';   // Office filter variable
    public $fLType = '';    // Office Leave Type variable
    public $fLStatus = '';  // Office Leave Status variable
    public $fLdtFrom = '';  // Date From filter variable
    public $fLdtTo = '';    // Date To filter variable

    public $lTypes = '';
    public $lStatus = '';

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];


    public function mount()
    {

        $this->loadDropdowns();
    }

    public function render()
    {
        $leaves = $this->fetchLeavesListing();
        $this->loadDropdowns();

        return view('livewire.e-forms.leave-application', [
            'leaves' => $leaves,
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
        $this->fLdtFrom = null;
        $this->fLdtTo = null;
    }

    private function fetchLeavesListing()
    {
        $leaves = DB::table('leaves as l')
            ->select(
                'l.id',
                'u.id as u_id',
                'l.leave_number',
                'l.leave_type',
                'l.control_number',
                'l.name as full_name',
                'l.employee_id',
                'l.date_applied',
                'l.date_from',
                'l.date_to',
                'l.no_of_days',
                'l.time_designator',
                'o.company_name as office',
                'd.department',
                'd.department_code as dept',
                'u.supervisor',
                'l.created_at',
                'u.supervisor',
                DB::raw("CONCAT(u2.first_name, ' ', u2.last_name) as approver1"),
                DB::raw("CONCAT(u3.first_name, ' ', u3.last_name) as approver2"),
                'l.leave_status as status',
                'l.leave_status'
            )
            ->leftJoin('offices as o', 'l.office', '=', 'o.id')
            ->leftJoin('departments as d', 'l.department', '=', 'd.department_code')
            ->leftJoin('users as u', 'u.employee_id', '=', 'l.employee_id')
            ->leftJoin('users as u2', 'u2.employee_id', '=', 'u.supervisor')
            ->leftJoin('users as u3', function ($join) {
                $join->on('u3.employee_id', '=', 'u.manager')
                    ->whereNotNull('u.manager');
            });
        $leaves = $leaves->where(function ($query) {
            $query->where('l.is_deleted', 0)
                ->orWhereNull('l.is_deleted');
        });
        (Auth::user()->id != 1 && Auth::user()->id != 2) ? $leaves = $leaves->where('u.id', '<>', 1) : '';
        $leaves = $leaves->where(function ($query) {

            // Apply office filter if selected
            if (!empty($this->fTLOffice)) {
                $query->where('l.office', $this->fTLOffice);
            }
            // Apply department filter if selected
            if (!empty($this->fTLDept)) {
                $query->where('l.department', $this->fTLDept);
            }
            // Apply Leave Type filter if selected
            if (!empty($this->fLType)) {
                $query->where('l.leave_type', $this->fLType);
            }
            // Apply Leave Status filter if selected
            if (!empty($this->fLStatus)) {
                $query->where('l.leave_status', $this->fLStatus);
            }

            if (Auth::user()->role_type == 'SUPER ADMIN' || Auth::user()->role_type == 'ADMIN') {
                // Apply search query if search term is provided
                if (!empty($this->search)) {
                    $searchTerms = explode(' ', $this->search);
                    $query->where(function ($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $q->where('l.name', 'like', '%' . $term . '%');
                        }
                    })
                        ->orWhere('l.employee_id', 'like', '%' . $this->search . '%')
                        ->orWhere('l.control_number', 'like', '%' . $this->search . '%');
                }
            }
            // Filter by date range
            if (!empty($this->fLdtFrom) && !empty($this->fLdtTo)) {
                $query->where(function ($q) {
                    $q->where('l.date_from', '>=', $this->fLdtFrom)
                        ->where('l.date_to', '<=', $this->fLdtTo);
                });
            } elseif (!empty($this->fLdtFrom)) {
                $query->where('l.date_from', $this->fLdtFrom);
            } elseif (!empty($this->fLdtTo)) {
                $query->where('l.date_to', $this->fLdtTo);
            }

            // Additional conditional check for user role
            /*if (Auth::user()->role_type != 'SUPER ADMIN' && Auth::user()->role_type != 'ADMIN') {
                    $query->where(function ($q) {
                        $q->where('th.employee_id', Auth::user()->employee_id)
                            ->orWhere('u.supervisor', Auth::user()->employee_id);
                    });
                }*/

            // Exclude specific user IDs
            if (Auth::user()->id != 1 && Auth::user()->id != 2) {
                $query->where('u.id', '!=', 1);
            }
            if (Auth::user()->is_head == 1) {
                // This will be changed or removed if a new module for user authorization viewing is created.
                switch (Auth::user()->id) {
                    case 1:
                    case 8:
                    case 18:
                    case 58:
                        break;
                    case 124:
                        $query->where(function ($q) {
                            return $q->where('l.office', Auth::user()->office)
                                ->orWhere('l.office', 6);
                        });
                        break;
                    case 126:
                        $query->where(function ($q) {
                            return $q->whereIn('l.office', [8, 12, 13, 14, 15]);
                        });
                        break;
                    case 337:
                        $query->where(function ($q) {
                            return $q->where('l.office', Auth::user()->office)
                                ->orWhere('l.office', 17);
                        });
                        break;
                    default:
                        $query->where(function ($q) {
                            return $q->where('l.employee_id', Auth::user()->employee_id)
                                ->orWhere('u.supervisor', Auth::user()->employee_id);
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
        $leaves = $leaves->orderBy('l.created_at', 'desc')
            ->paginate($this->pageSize);

        return $leaves;
    }

    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    public function fetchDetailedLeave(Request $request)
    {
        $year = Carbon::now('Asia/Manila')->year;
        $dLeave = DB::table('leaves as l')
            ->select(
                'l.id',
                'l.control_number',
                'l.name',
                'u.gender',
                'l.employee_id',
                'u.supervisor',
                'lt.leave_type_name',
                'l.leave_type',
                'l.others',
                'o.company_name as office',
                'd.department',
                'l.date_applied',
                'l.date_from',
                'l.date_to',
                'l.no_of_days',
                'l.time_designator',
                'l.reason',
                'l.leave_status'
            )
            ->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
            ->leftJoin('offices as o', 'l.office', 'o.id')
            ->leftJoin('departments as d', 'l.department', 'd.department_code')
            ->leftJoin('leave_types as lt', 'l.leave_type', 'lt.leave_type')
            ->where('l.id', $request->id)
            ->first();

        $leaveCredits = DB::table('leaves')
            ->select(
                'employee_id',
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "SL" THEN no_of_days ELSE 0 END), 0) as SL'),
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "VL" THEN no_of_days ELSE 0 END), 0) as VL'),
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "EL" THEN no_of_days ELSE 0 END), 0) as EL'),
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "ML" THEN no_of_days ELSE 0 END), 0) as ML'),
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "PL" THEN no_of_days ELSE 0 END), 0) as PL'),
                DB::raw('COALESCE(SUM(CASE WHEN leave_type = "Others" THEN no_of_days ELSE 0 END), 0) as OTS')
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
            ->where('employee_id', $dLeave->employee_id)
            ->where(function ($q) use ($year) {
                $q->whereYear('date_from', $year)
                    ->orWhereYear('date_to', $year);
            })
            ->where('date_to', '<=', Carbon::now('Asia/Manila')->format('Y-m-d'))
            ->groupBy('employee_id')
            ->first();


        if (!$leaveCredits) {
            $leaveCredits = (object) [
                'SL' => '0.0',
                'VL' => '0.0',
                'EL' => '0.0',
                'ML' => '0.0',
                'PL' => '0.0',
                'OTS' => '0.0'
            ];
        }

        $leaveTypes = DB::table('leave_types');
        ($dLeave->gender == 'F') ? $leaveTypes = $leaveTypes->where('leave_type', '!=', 'PL') : $leaveTypes = $leaveTypes->where('leave_type', '!=', 'ML');
        $leaveTypes = $leaveTypes->get();

        return view(
            'modals/m-view-leave-detailed',
            [
                'dLeave'        => $dLeave,
                'leaveTypes'    => $leaveTypes,
                'leaveCredits'    => $leaveCredits
            ]
        );
    }

    public function headApproveLeave(Request $request)
    {
        if ($request->ajax()) {
            $lData = $request->input('lData', []);

            $lId = $lData['lID'] ?? '';
            $lType = $lData['lType'] ?? '';
            $lOthers = $lData['lOthers'] ?? '';
            $newStatus = 'Head Approved';

            try {
                // $googleEventId = DB::table('leaves')
                // ->where('id', $lId)
                // ->value('google_id');

                // if (!empty($googleEventId)) {
                //     $event = Event::find($googleEventId);
                //     if ($event) {
                //         $description        = $event->description;
                //         $description        = preg_replace('/Status: .*/', "Status: $newStatus", $description);
                //         $event->description = $description;
                //         $event->save();
                //     }
                // }

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
                        $uSex = DB::table('users')
                            ->where('employee_id', $newLeave->employee_id)
                            ->value('gender');
                        $newLeave->sex = $uSex;
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

    public function sendToHRIS(Request $request)
    {
        if (!is_numeric($request->lID)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $leave = DB::table('leaves as l')
            ->select(
                'l.control_number',
                'l.name',
                'l.employee_id',
                'o.company_name as office',
                'l.leave_status',
                'l.leave_type',
                'l.others',
                'l.date_from',
                'l.date_to',
                'l.time_designator',
                'l.reason',
                'l.no_of_days',
                'l.created_at'
            )
            ->leftJoin('offices as o', 'l.office', 'o.id')
            ->where('l.id', $request->lID)
            ->where('l.is_head_approved', 1)
            ->first();

        if ($leave) {
            $payloads = [
                'CONTROL_NO'        => $leave->control_number,
                'name'              => $leave->name,
                'employee_id'       => $leave->employee_id,
                'office'            => $leave->office,
                'leave_status_no'   => $leave->leave_status == 'Head Approved' ? 1 : 2,
                'leave_type'        => $leave->leave_type,
                'others'            => $leave->others,
                'date_from'         => $leave->date_from,
                'date_to'           => $leave->date_to,
                'time_designator'   => $leave->time_designator,
                'reason'            => $leave->reason,
                'no_of_days'        => $leave->no_of_days,
                'created_at'        => $leave->created_at,
                'updated_at'        => now()->format('Y-m-d H:i:s'),
                'updated_by'        => Auth::user()->employee_id,
            ];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post(env('HRIS_URL') . '/api/leaves/fetch', $payloads);

            if ($response->successful()) {
                Log::channel('hris-api')->info('HRIS API Response', [
                    'status'            => $response->status(),
                    'control_number'    => $leave->control_number,
                    'body'              => $response->body(),
                    'json'              => $response->json()
                ]);
                return response()->json([
                    'status'    => $response->status(),
                    'response'  => $response->json()
                ]);
            } else {
                Log::channel('hris-api')->info('Failed or No Response from HRIS API', [
                    'status'            => $response->status(),
                    'control_number'    => $leave->control_number
                ]);
                return response()->json(['response' => '']);
            }
        } else {
            return response()->json(['response' => '']);
        }
    }

    /* public function sendAllToHRIS()
    {
        $leaves = DB::table('leaves as l')
            ->select(
                'l.control_number',
                'l.name',
                'l.employee_id',
                'o.company_name as office',
                'l.leave_status',
                'l.leave_type',
                'l.others',
                'l.date_from',
                'l.date_to',
                'l.time_designator',
                'l.reason',
                'l.no_of_days',
                'l.created_at',
                'l.updated_at'
            )
            ->leftJoin('offices as o', 'l.office', 'o.id')
            ->where('l.is_head_approved', 1)
            ->where(function ($q) {
                return $q->whereNull('l.is_cancelled')
                    ->orWhere('l.is_cancelled', '!=', 1);
            })
            // ->where('l.control_number', '2025-1D-IT-3562')
            ->get();

        // Log::info('Leave data:', $leaves->toArray());

        if ($leaves->isEmpty()) {
            return response()->json(['message' => 'No approved leave data to send.'], 200);
        }

        $success = 0;
        $failed = 0;

        foreach ($leaves as $leave) {
            $payload = [
                'CONTROL_NO'        => $leave->control_number,
                'name'              => $leave->name,
                'employee_id'       => $leave->employee_id,
                'office'            => $leave->office,
                'leave_status_no'   => ($leave->leave_status == 'Head Approved' || $leave->leave_status == 'Processed') ? 1 : 2,
                'leave_type'        => $leave->leave_type,
                'others'            => $leave->others,
                'date_from'         => $leave->date_from,
                'date_to'           => $leave->date_to,
                'time_designator'   => $leave->time_designator,
                'reason'            => $leave->reason,
                'no_of_days'        => $leave->no_of_days,
                'created_at'        => $leave->created_at,
                'updated_at'        => $leave->updated_at,
                'updated_by'        => $leave->employee_id,
            ];

            // Log::debug(json_encode($payload, JSON_PRETTY_PRINT));


            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post(env('HRIS_URL') . '/api/leaves/fetch', $payload);

            if ($response->successful()) {
                $success++;
                Log::channel('hris-api')->info('HRIS API Response', [
                    'status'         => $response->status(),
                    'control_number' => $leave->control_number
                    // 'body'           => $response->body(),
                    // 'json'           => $response->json()
                ]);
            } else {
                $failed++;
                Log::channel('hris-api')->error('Failed to send to HRIS', [
                    'status'         => $response->status(),
                    'control_number' => $leave->control_number
                    // 'json'           => $response->json()
                ]);
            }
        }

        return response()->json([
            'isSuccess'    => true,
            'message' => 'Leave data processing complete.',
        ]);
    } */
    public function sendAllToHRIS()
    {
        $leaves = DB::table('leaves as l')
            ->select(
                'l.control_number',
                'l.name',
                'l.employee_id',
                'o.company_name as office',
                'l.leave_status',
                'l.leave_type',
                'l.others',
                'l.date_from',
                'l.date_to',
                'l.time_designator',
                'l.reason',
                'l.no_of_days',
                'l.created_at',
                'l.updated_at'
            )
            ->leftJoin('offices as o', 'l.office', 'o.id')
            ->where('l.is_head_approved', 1)
            ->where(function ($q) {
                return $q->whereNull('l.is_cancelled')
                    ->orWhere('l.is_cancelled', '!=', 1);
            })
            ->get();

        if ($leaves->isEmpty()) {
            return response()->json(['message' => 'No approved leave data to send.'], 200);
        }

        $success = 0;
        $failed = 0;

        // Recommended: 100 per minute => ~1.5 per second
        $chunkSize = 10; // Process 10 leaves per chunk
        $delayBetweenChunksInSeconds = 5; // Sleep 5 seconds per 10 records

        $leaves->chunk($chunkSize)->each(function ($chunk) use (&$success, &$failed, $delayBetweenChunksInSeconds) {
            foreach ($chunk as $leave) {
                $payload = [
                    'CONTROL_NO'        => $leave->control_number,
                    'name'              => $leave->name,
                    'employee_id'       => $leave->employee_id,
                    'office'            => $leave->office,
                    'leave_status_no'   => ($leave->leave_status == 'Head Approved' || $leave->leave_status == 'Processed') ? 1 : 2,
                    'leave_type'        => $leave->leave_type,
                    'others'            => $leave->others,
                    'date_from'         => $leave->date_from,
                    'date_to'           => $leave->date_to,
                    'time_designator'   => $leave->time_designator,
                    'reason'            => $leave->reason,
                    'no_of_days'        => $leave->no_of_days,
                    'created_at'        => $leave->created_at,
                    'updated_at'        => $leave->updated_at,
                    'updated_by'        => $leave->employee_id,
                ];

                $response = Http::withHeaders([
                    'x-api-key' => env('API_KEY'),
                    'Accept' => 'application/json'
                ])->withOptions([
                    'verify' => false
                ])->post(env('HRIS_URL') . '/api/leaves/fetch', $payload);

                if ($response->successful()) {
                    $success++;
                    Log::channel('hris-api')->info('HRIS API Response', [
                        'status'            => $response->status(),
                        'control_number'    => $leave->control_number,
                        'isExisting'        => $response->json('isExisting')

                    ]);
                } else {
                    $failed++;
                    Log::channel('hris-api')->error('Failed to send to HRIS', [
                        'status'            => $response->status(),
                        'control_number'    => $leave->control_number,
                        'isExisting'        => $response->json('isExisting'),
                        'error_message'     => $response->json('message') ?? $response->body()
                    ]);
                }
            }

            // Wait 5 seconds after each 10 records
            sleep($delayBetweenChunksInSeconds);
        });

        return response()->json([
            'isSuccess' => true,
            'message'   => "Leave data processing complete. Success: {$success}, Failed: {$failed}",
        ]);
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

                // $googleEventId = DB::table('leaves')
                // ->where('id', $lId)
                // ->value('google_id');

                // if (!empty($googleEventId)) {
                //     $event = Event::find($googleEventId);
                //     if ($event) {
                //         $description        = $event->description;
                //         $description        = preg_replace('/Status: .*/', "Status: $newStatus", $description);
                //         $event->description = $description;
                //         if (in_array($newStatus, ['Denied', 'Cancelled'])) {
                //             $event->status = 'cancelled';
                //         }
                //         $event->save();
                //     }
                // }

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
                            $uSex = DB::table('users')
                                ->where('employee_id', $newLeave->employee_id)
                                ->value('gender');
                            $newLeave->sex = $uSex;
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
                        $uSex = DB::table('users')
                            ->where('employee_id', $newLeave->employee_id)
                            ->value('gender');
                        $newLeave->sex = $uSex;
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
                        $uSex = DB::table('users')
                            ->where('employee_id', $newLeave->employee_id)
                            ->value('gender');
                        $newLeave->sex = $uSex;
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
