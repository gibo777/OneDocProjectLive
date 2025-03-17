<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\LeaveForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApplicationSubmitted;
use Illuminate\Support\Str;

use Spatie\GoogleCalendar\Event;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class LeaveFormController extends Controller
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
                DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d') as curDate")

            )
            ->where('department_code',Auth::user()->department)
            ->first();

            $leaveTypes = DB::table('leave_types');
            (Auth::user()->gender=='F') ? $leaveTypes=$leaveTypes->where('leave_type','!=', 'PL') : $leaveTypes=$leaveTypes->where('leave_type','!=', 'ML');
            $leaveTypes =$leaveTypes->get();

            $employeeId = Auth::user()->employee_id;
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
                ->where('is_head_approved',1)
                ->where('employee_id', $employeeId)
                ->where(DB::raw('YEAR(date_from)'),Carbon::now('Asia/Manila')->format('Y'))
                ->groupBy('employee_id')
                ->first();


            return view('hris.leave.eleave', 
              [
                'holidays'=>$holidays, 
                'department'=>$department,
                'leaveTypes'=>$leaveTypes,
                'leaveCredits'=>$leaveCredits
              ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Validate if overlapping dates.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public function overlapValidation (Request $request)
    {
        $isOverlap = DB::select('CALL sp_check_leave_overlap(?, ?, ?, @isOverlap)', [Auth::user()->employee_id, $request->dateFrom, $request->dateTo]);
        $overlapResult = DB::select('SELECT @isOverlap as isOverlap');
        return $overlapResult[0]->isOverlap;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Gilbert Retiro
     */
    public function submit_leave(Request $request)
    {
        $rules = [
            'leaveType'     => 'required|string|max:255',
            'reason'        => 'required|string',
            'leaveDateFrom' => 'required|date',
            'leaveDateTo'   => $request->isHalfDay ? '':'required|date|after_or_equal:leaveDateFrom',
        ];

        $overlapping = DB::table('leaves')
            ->where(function ($query) use ($request) {
                $query->whereBetween('date_from', [$request->leaveDateFrom, $request->leaveDateTo])
                      ->orWhereBetween('date_to', [$request->leaveDateFrom, $request->leaveDateTo])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('date_from', '<=', $request->leaveDateFrom)
                                ->where('date_to', '>=', $request->leaveDateTo);
                      });
            })
            ->where('employee_id',Auth::user()->employee_id)
            ->count();

        if ($overlapping > 0) {
            return response()->json([
                'isSuccess' => false, 
                'message'   => 'Your requested leave overlaps with a previously filed leave. Please review your existing leave records.'
            ]);
        } /*else {
            return response()->json([
                'isSuccess' => false, 
                'message'   => 'Success'
            ]);
        }*/

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('hris.leave.eleave'))
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $inputData = $request->input();

            if ($request->leaveDateFrom == $request->leaveDateTo) {
                $startDate = Carbon::parse($request->leaveDateFrom)->startOfDay();
                $endDate = Carbon::parse($request->leaveDateTo)->endOfDay();
                $allDay = true; 
            } else {
                $startDateTime = Carbon::parse($request->leaveDateFrom . ' 00:00:00');
                $endDateTime = Carbon::parse($request->leaveDateTo . ' 23:59:59');
                $allDay = false; 
            }


            $namePartsG = [
                Auth::user()->last_name,
                substr(Auth::user()->first_name, 0, 1)
            ];

            $nameParts = [
                Auth::user()->last_name,
                Auth::user()->first_name
            ];

            if ($suffix = Auth::user()->suffix) {
                $namePartsG[] = $suffix;
                $nameParts[] = $suffix;
            }

            if ($middleName = Auth::user()->middle_name) {
                $namePartsG[] = substr($middleName, 0, 1) . '.';
                $nameParts[] = substr($middleName, 0, 1) . '.';
            }

            $lFullNameG = $namePartsG[0] . ', ' . implode(' ', array_slice($namePartsG, 1));
            $lFullName = $nameParts[0] . ', ' . implode(' ', array_slice($nameParts, 1));


            # Google Calendar Description
            $description = sprintf(
                "Name: %s\nEmployee #: %s\n\nLeave Type: %s\nDate Covered: %s to %s\nNumber of Day/s: %.1f\nReason: %s\n\nStatus: %s",
                $lFullName,
                Auth::user()->employee_id,
                $request->leaveType,
                Carbon::parse($request->leaveDateFrom)->format('M d, Y (D)'),
                Carbon::parse($request->leaveDateTo)->format('M d, Y (D)'),
                number_format($inputData['hid_no_days'], 2),
                strtoupper($request->reason),
                'PENDING'
            );

            # Google Calendar Data
            $eventData = [
                'name'              => $lFullNameG.' ('.$request->leaveType.')',
                'description'       => $description,
                // 'colorId'           => 9, // Background color - Light blue
                'backgroundColor'   => '#06066b',
                'foregroundColor'   => '#FFFFFF',
                'allDay'            => $allDay,
                'transparency'      => 'transparent',
            ];

            if ($allDay) {
                $eventData['startDate'] = $startDate;
                $eventData['endDate'] = $endDate;
            } else {
                $eventData['startDateTime'] = $startDateTime;
                $eventData['endDateTime'] = $endDateTime;
            }

            $googleEvent = Event::create($eventData);

            if (!$googleEvent) {
                \Log::error('Failed to create Google Calendar event: No response returned from the API.');
                return redirect()->route('events.create')->with('status', [
                    'message' => 'Failed to create the event on Google Calendar.',
                    'type' => 'error',
                ]);
            } else {
                $eventId = $googleEvent->id;

                // Increment new leave number
                $insert_increment = DB::table('leaves')
                    ->select('leave_number')
                    ->where('employee_id', '=', Auth::user()->employee_id)
                    ->orderBy('leave_number', 'desc')->first();
                    
                $new_leave_number = $insert_increment ? $insert_increment->leave_number + 1 : 1;
                $hashId = Str::random(16);


                // Prepare leave data
                $data = [
                    'leave_number'  => $new_leave_number,
                    'hash_id'       => $hashId,
                    'google_id'     => $eventId,
                    'name'          => $lFullName,
                    'employee_id'   => Auth::user()->employee_id,
                    'office'        => Auth::user()->office,
                    'department'    => Auth::user()->department,
                    'head_id'       => Auth::user()->supervisor,
                    'date_applied'  => DB::raw('NOW()'),
                    'leave_type'    => $inputData['leaveType'],
                    'reason'        => $inputData['reason'],
                    'date_from'     => date('Y-m-d', strtotime($inputData['leaveDateFrom'])),
                    'date_to'       => $request->isHalfDay ? date('Y-m-d', strtotime($inputData['leaveDateFrom'])) : date('Y-m-d', strtotime($inputData['leaveDateTo'])),
                    'no_of_days'    => number_format($inputData['hid_no_days'], 2),
                    'ip_address'    => $request->ip(),
                    'created_at'    => DB::raw('NOW()'),
                    'updated_at'    => DB::raw('NOW()')
                ];

                if ($inputData['leaveType'] == 'Others') {
                    $data['others'] = $inputData['others_leave'];
                }

                // Insert leave data and get the new leave ID
                $insertId = DB::table('leaves')->insertGetId($data);

                // Fetch leave details for email
                $newLeave = DB::table('leaves as l')
                    ->leftJoin('departments as d', 'l.department', 'd.department_code')
                    ->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
                    ->select(
                        'l.control_number',
                        'l.name',
                        'l.employee_id',
                        'd.department',
                        DB::raw("(SELECT CONCAT(first_name,' ',last_name) FROM users where employee_id=u.supervisor) as head_name"),
                        DB::raw("(SELECT gender FROM users where employee_id=u.supervisor) as head_sex"),
                        DB::raw("DATE_FORMAT(l.date_applied, '%m/%d/%Y %h:%i %p') as date_applied"),
                        'l.leave_type',
                        DB::raw("DATE_FORMAT(l.date_from, '%m/%d/%Y') as date_from"),
                        DB::raw("DATE_FORMAT(l.date_to, '%m/%d/%Y') as date_to"),
                        'l.no_of_days',
                        'l.reason'
                    )
                    ->where('l.id', $insertId)->first();

                // Generate URLs for approval and denial
                $approveUrl = route('leave.decide', ['action'=>'approve', 'hashId' => $hashId]).'-'.$insertId;
                $denyUrl = route('leave.decide', ['action'=>'deny', 'hashId' => $hashId]).'-'.$insertId;

                // Fetch the supervisor's email
                $defaultSupervisorEmail = DB::table('users')
                    ->where('employee_id', Auth::user()->supervisor)
                    ->value('email');

                // Check if the default supervisor's email contains 'jmyulo'
                $supervisorEmail = strpos($defaultSupervisorEmail, 'jmyulo') !== false 
                    ? DB::table('users')->where('id', 32)->value('email') 
                    : $defaultSupervisorEmail;

                // Send the email to the supervisor
                Mail::to($supervisorEmail)->send(new LeaveApplicationSubmitted($newLeave, $approveUrl, $denyUrl, 'submit'));

                return response([
                    'isSuccess' => true, 
                    'message'   => 'Leave application submitted!', 
                    'newLeave'  => $newLeave
                ]);
            }
        } catch (\Exception $e) {
            return response([
                'isSuccess' => false, 
                'message'   => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveForm  $insertForm
     * @return \Illuminate\Http\Response
     * @author Gilbert Retiro
     */
    public function show_balance(Request $request)
    {
        $employeeId = $request->employeeId;
        $type = $request->type;

        $leaves_balances = DB::table('leave_balances')->where('employee_id','=',$employeeId)->get();
        switch ($type) {
            case 'VL': return number_format($leaves_balances[0]->VL,2); break;
            case 'SL': return number_format($leaves_balances[0]->SL,2); break;
            case 'ML': return number_format($leaves_balances[0]->ML,2); break;
            case 'PL': return number_format($leaves_balances[0]->PL,2); break;
            case 'EL': return number_format($leaves_balances[0]->EL,2); break;
            case 'Others': return number_format($leaves_balances[0]->others,2); break;
            default: return 0.0; break;
        }
    }

    public function leaveform(Request $request)
    {
        $leave_id = $request->leave_id;
        $LogoF = public_path().'/img/company/onedoc-logo.jpg';
        $imageLogo = base64_encode(file_get_contents($LogoF));

        $leave_details = DB::table('leaves')
        ->where('id', $leave_id)
        ->get();

        $data = [
            'leave_details' => $leave_details,
            'imageLogo'=>  $imageLogo,
        ];
        $pdf = PDF::setPaper('letter', 'portrait')
        ->setOptions([
            'dpi' => 100, 
            'defaultFont' => 'sans-serif', 
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true, 
            'isJavascriptEnabled' => true
        ])
        ->loadView('reports.leave-form', ['data'=>$data])->setWarnings(false);

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(540, 753, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
        //  $canvas->page_text(540, 753, $test, null, 8, array(0, 0, 0));
    
         return $pdf->download('PDS-'. $leave_id .'.pdf');
    }

    public function leaveHeadDecide ($action,$hashId) {
        $hashString = explode('-', $hashId);

        if (count($hashString)<2) {
            return abort(404, 'Invalid link!');
        }

        $id = $hashString[1];
        $hash = $hashString[0];

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
                'l.reason',
                'l.leave_status'
            )
            ->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
            ->leftJoin('offices as o', 'l.office','o.id')
            ->leftJoin('departments as d', 'l.department','d.department_code')
            ->leftJoin('leave_types as lt', 'l.leave_type', 'lt.leave_type')
            ->where('l.id',$id)
            ->where('l.hash_id',$hash)
            ->first();


        if ($dLeave === null) {
            $dLeave         = '';
            $leaveTypes     = '';
            $leaveCredits   = '';
        } else {
            $leaveCredits = DB::table('leaves')
                ->select('employee_id',
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
                ->where(DB::raw('YEAR(date_from)'), Carbon::now('Asia/Manila')->format('Y'))
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
            ($dLeave->gender=='F') ? $leaveTypes=$leaveTypes->where('leave_type','!=', 'PL') : $leaveTypes=$leaveTypes->where('leave_type','!=', 'ML');
            $leaveTypes =$leaveTypes->get();
        }

        return view('hris/leave/head-decide', 
            [ 
                'hashId'        => $hashId,
                'action'        => $action,
                'dLeave'        => $dLeave,
                'leaveTypes'    => $leaveTypes,
                'leaveCredits'  => $leaveCredits,
            ]);
    }
}
