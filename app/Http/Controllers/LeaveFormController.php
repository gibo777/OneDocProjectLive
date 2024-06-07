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
                // DB::raw("DATE_FORMAT(NOW(), '%m/%d/%Y') as curDate")
                DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d') as curDate")

            )
            ->where('department_code',Auth::user()->department)
            ->first();

            $leaveTypes = DB::table('leave_types');
            (Auth::user()->gender=='F') ? $leaveTypes=$leaveTypes->where('leave_type','!=', 'PL') : $leaveTypes=$leaveTypes->where('leave_type','!=', 'ML');
            $leaveTypes =$leaveTypes->get();

            /*$leave_credits = DB::table('leave_balances')
            ->select(
              DB::raw('FORMAT((CASE WHEN VL is not null THEN VL ELSE 0 END),2) as VL'),
              DB::raw('FORMAT((CASE WHEN SL is not null THEN SL ELSE 0 END),2) as SL'),
              DB::raw('FORMAT((CASE WHEN ML is not null THEN ML ELSE 0 END),2) as ML'),
              DB::raw('FORMAT((CASE WHEN PL is not null THEN PL ELSE 0 END),2) as PL'),
              DB::raw('FORMAT((CASE WHEN EL is not null THEN EL ELSE 0 END),2) as EL'),
              DB::raw('FORMAT((CASE WHEN others is not null THEN others ELSE 0 END),2) as others')
            )
            ->whereNull('is_deleted')
            ->where('employee_id',Auth::user()->employee_id)->get();*/

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
                        ->orWhere('is_deleted', '!=', 1);
                })
                ->where(function ($query) {
                    $query->whereNull('is_cancelled')
                        ->orWhere('is_cancelled', '!=', 1);
                })
                ->where('employee_id', $employeeId)
                ->groupBy('employee_id')
                ->get();


            return view('hris.leave.eleave', 
              [
                'holidays'=>$holidays, 
                'department'=>$department,
                'leaveTypes'=>$leaveTypes,
                'leave_credits'=>$leaveCredits
              ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create_leave()
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $holidays = DB::table('holidays')
                        ->where( function($query) {
                          return $query->where('holiday_office','')->orWhereNull('holiday_office')->orWhere('holiday_office',Auth::user()->office);
                        })->get();
            $departments = DB::table('departments')->get();
            $leave_types = DB::table('leave_types')->get();
            return view('hris.leave.eleave', ['holidays'=>$holidays, 'departments'=>$departments, 'leave_types'=>$leave_types]);
        } else {
            return redirect('/');
        }
    }*/

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
     */
    public function submit_leave(Request $request)
    {
        $rules = [
            // 'name' => 'required',
            // 'employeeNumber' => 'required',
            // 'hid_dept' => 'required',
            'leaveType' => 'required',
            'reason' => 'required',
            // 'date_applied' => 'required',
            'leaveDateFrom' => 'required',
            'leaveDateTo' => $request->isHalfDay ? '':'required'
        ];

        // return var_dump($request->input());

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
          // return "gibs 1";
            return redirect(route('hris.leave.eleave'))
            ->withInput()
            ->withErrors($validator);
        }
        else{
            // return "gibs 2";
            $inputData = $request->input();
            try{
                $insert_increment = DB::table('leaves')
                ->select('leave_number')
                ->where('employee_id','=',Auth::user()->employee_id)
                ->orderBy('leave_number','desc')->first();
                
                if ($insert_increment==NULL) {
                    $new_leave_number = 1;
                } else {
                    $new_leave_number = $insert_increment->leave_number+1;
                }
                // return $new_leave_number;

                // $date = strtotime($inputData['date_applied'].date('G:i:s'));
                // $dateapplied =  date('Y-m-d H:i:s', $date);



                /*$insert = new LeaveForm;
                $insert->leave_number = $new_leave_number;
                $insert->name = Auth::user()->last_name.' '.Auth::user()->suffix.', '.Auth::user()->first_name.' '.Auth::user()->middle_name;
                $insert->employee_id = Auth::user()->employee_id;
                $insert->department = Auth::user()->department;
                $insert->date_applied = date('Y-m-d H:i:s');
                $insert->leave_type = $inputData['leave_type'];
                $insert->reason = $inputData['reason'];
                // $insert->notification = implode('|',$data['leave_notification']);
                $insert->date_from = date('Y-m-d',strtotime($inputData['leaveDateFrom']));
                $insert->date_to = date('Y-m-d',strtotime($inputData['leaveDateTo']));
                $insert->no_of_days = $inputData['hid_no_days'];
                if ($inputData['leave_type']=='Others') {
                    $insert->others = $inputData['others_leave'];
                }
                $insert->ip_address = request()->ip();
                $insert->save();*/


                // return $request->isHalfDay ? date('Y-m-d',strtotime($inputData['leaveDateFrom'])) : date('Y-m-d',strtotime($inputData['leaveDateTo'])) ;

                $data = [
                    'leave_number' => $new_leave_number, 
                    'name' => Auth::user()->last_name.' '.Auth::user()->suffix.', '.Auth::user()->first_name.' '.Auth::user()->middle_name,
                    'employee_id' => Auth::user()->employee_id,
                    'office' => Auth::user()->office,
                    'department' => Auth::user()->department,
                    'date_applied' => DB::raw('NOW()'),
                    'leave_type' => $inputData['leaveType'],
                    'reason' => $inputData['reason'],
                    'date_from'=>date('Y-m-d',strtotime($inputData['leaveDateFrom'])),
                    'date_to'=> $request->isHalfDay ? date('Y-m-d',strtotime($inputData['leaveDateFrom'])) : date('Y-m-d',strtotime($inputData['leaveDateTo'])),
                    'no_of_days' => $inputData['hid_no_days'],
                    'ip_address' => $request->ip(),
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()')
                ];

                if ($inputData['leaveType']=='Others') {
                    $data['others'] = $inputData['others_leave'];
                }
                // return var_dump($data);
                $insertId = DB::table('leaves')->insertGetId($data);

                $newLeave = DB::table('leaves as l')
                ->leftJoin('departments as d','l.department','d.department_code')
                ->select(
                    'l.control_number',
                    'l.name',
                    'l.employee_id',
                    'd.department',
                    DB::raw("DATE_FORMAT(l.date_applied, '%m/%d/%Y %h:%i %p') as date_applied"),
                    'l.leave_type',
                    DB::raw("DATE_FORMAT(l.date_from, '%m/%d/%Y') as date_from"),
                    DB::raw("DATE_FORMAT(l.date_to, '%m/%d/%Y') as date_to"),
                    'l.no_of_days',
                    'l.reason'
                )
                ->where('l.id',$insertId)->first();




                // dd($insert->toSql());
                return response(['isSuccess' => true,'message'=>'Leave application submitted!','newLeave'=>$newLeave]);
            } catch(Exception $e){
                return response(['isSuccess'=>false,'message'=>$e]);
            }
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
        // return var_dump($request->input());
        $employeeId = $request->employeeId;
        $type = $request->type;
        // return response()->json($emp_id);

            $leaves_balances = DB::table('leave_balances')->where('employee_id','=',$employeeId)->get();
            switch ($type) {
                case 'VL': return number_format($leaves_balances[0]->VL,2); break;
                case 'SL': return number_format($leaves_balances[0]->SL,2); break;
                case 'ML': return number_format($leaves_balances[0]->ML,2); break;
                case 'PL': return number_format($leaves_balances[0]->PL,2); break;
                case 'EL': return number_format($leaves_balances[0]->EL,2); break;
                case 'Others': return number_format($leaves_balances[0]->others,2); break;
                default: 
                    # code...
                    break;
            }
            // return $leaves_balances[0]->VL;
            
            // return view('hris.leave.view-leave-details', ['leaves'=>$leaves,'holidays'=>$holidays, 'departments'=>$departments, 'leave_types'=>$leave_types]);
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
       // dd($data);
      //  return view('reports.leave-form', compact('leave_details'));
        $pdf = PDF::setPaper('letter', 'portrait')
        ->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true])
         ->loadView('reports.leave-form', ['data'=>$data])->setWarnings(false);
         
         $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
         
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(540, 753, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
      //  $canvas->page_text(540, 753, $test, null, 8, array(0, 0, 0));
    
         return $pdf->download('PDS-'. $leave_id .'.pdf');
    }
}
