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
            $departments = DB::table('departments')->get();
            $leave_types = DB::table('leave_types');
            (Auth::user()->gender=='F') ? $leave_types=$leave_types->where('leave_type','!=', 'PL') : $leave_types=$leave_types->where('leave_type','!=', 'ML');
            $leave_types =$leave_types->get();
            $leave_credits = DB::table('leave_balances')
            ->select(
              DB::raw('(CASE WHEN VL is not null THEN VL ELSE 0 END) as VL'),
              DB::raw('(CASE WHEN SL is not null THEN SL ELSE 0 END) as SL'),
              DB::raw('(CASE WHEN ML is not null THEN ML ELSE 0 END) as ML'),
              DB::raw('(CASE WHEN PL is not null THEN PL ELSE 0 END) as PL'),
              DB::raw('(CASE WHEN EL is not null THEN EL ELSE 0 END) as EL'),
              DB::raw('(CASE WHEN others is not null THEN others ELSE 0 END) as others')
            )
            ->where('employee_id',Auth::user()->employee_id)->get();

            return view('hris.leave.eleave', 
              [
                'holidays'=>$holidays, 
                'departments'=>$departments, 
                'leave_types'=>$leave_types,
                'leave_credits'=>$leave_credits
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit_leave(Request $request)
    {
        $rules = [
            'name' => 'required',
            'employee_number' => 'required',
            'hid_dept' => 'required',
            'leave_type' => 'required',
            'reason' => 'required',
            'date_applied' => 'required',
            'leaveDateFrom' => 'required',
            'leaveDateTo' => 'required'
        ];

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
                // return $data['employee_number'];
                $insert_increment = DB::table('leaves')
                ->select('leave_number')
                ->where('employee_id','=',$inputData['employee_number'])
                ->orderBy('leave_number','desc')->first();
                
                if ($insert_increment==NULL) {
                    $new_leave_number = 1;
                } else {
                    $new_leave_number = $insert_increment->leave_number+1;
                }
                // return $new_leave_number;

                $date = strtotime($inputData['date_applied'].date('G:i:s'));
                $dateapplied =  date('Y-m-d H:i:s', $date);



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



                $data = [
                    'leave_number' => $new_leave_number, 
                    'name' => Auth::user()->last_name.' '.Auth::user()->suffix.', '.Auth::user()->first_name.' '.Auth::user()->middle_name,
                    'employee_id' => Auth::user()->employee_id,
                    'office' => Auth::user()->office,
                    'department' => Auth::user()->department,
                    'date_applied' => date('Y-m-d H:i:s'),
                    'leave_type' => $inputData['leave_type'],
                    'reason' => $inputData['reason'],
                    'date_from'=>date('Y-m-d',strtotime($inputData['leaveDateFrom'])),
                    'date_to'=>date('Y-m-d',strtotime($inputData['leaveDateTo'])),
                    'no_of_days' => $inputData['hid_no_days'],
                    'ip_address' => $request->ip(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // return var_dump($data);
                if ($inputData['leave_type']=='Others') {
                    $data['others'] = $inputData['others_leave'];
                }
                // return var_dump($data);
                $insert = DB::table('leaves')->insert($data);
                // dd($insert->toSql());
                return response(['isSuccess' => true,'message'=>'Leave application submitted!']);
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
     */
    public function show_balance(Request $request)
    {
        $emp_id = $request->emp_id;
        $type = $request->type;
        // return response()->json($emp_id);

            $leaves_balances = DB::table('leave_balances')->where('employee_id','=',$emp_id)->get();
            switch ($type) {
                case 'VL': return $leaves_balances[0]->VL; break;
                case 'SL': return $leaves_balances[0]->SL; break;
                case 'ML': return $leaves_balances[0]->ML; break;
                case 'PL': return $leaves_balances[0]->PL; break;
                case 'EL': return $leaves_balances[0]->EL; break;
                case 'Others': return $leaves_balances[0]->others; break;
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
