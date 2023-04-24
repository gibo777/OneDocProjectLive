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
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
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
              DB::raw('(CASE WHEN others != null THEN others ELSE 0 END) as others')
            )
            ->where('employee_id',Auth::user()->employee_id)->get();

            return view('hris.leave.eleave', ['holidays'=>$holidays, 'departments'=>$departments, 'leave_types'=>$leave_types,'leave_credits'=>$leave_credits]);
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
        // return var_dump($request->all());

        $rules = [
            'name' => 'required',
            'employee_number' => 'required',
            'hid_dept' => 'required',
            'leave_type' => 'required',
            'reason' => 'required',
            'date_applied' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ];

        // return var_dump($request->all());

        $validator = Validator::make($request->all(),$rules);

        // return var_dump($validator);
        // return $validator->fails();

        if ($validator->fails()) {
            return redirect(route('hris.leave.eleave'))
            ->withInput()
            ->withErrors($validator);
        }
        else{
            // return "gibs";
            // return var_dump($request->input());
            $data = $request->input();
            try{
                // return $data['employee_number'];
                $insert_increment = DB::table('leaves')
                ->select('leave_number')
                ->where('employee_id','=',$data['employee_number'])
                ->orderBy('leave_number','desc')->first();
                
                // return var_dump($insert_increment);
                if ($insert_increment==NULL) {
                    $new_leave_number = 1;
                } else {
                    $new_leave_number = $insert_increment->leave_number+1;
                }
                // return $new_leave_number; die();

                $date = strtotime($data['date_applied'].date('G:i:s'));
                $dateapplied =  date('Y-m-d G:i:s', $date);
                $insert = new LeaveForm;
                $insert->leave_number = $new_leave_number;
                $insert->name = $data['name'];
                $insert->employee_id = $data['employee_number'];
                $insert->department = $data['hid_dept'];
                $insert->date_applied = $dateapplied;
                $insert->leave_type = $data['leave_type'];
                $insert->reason = $data['reason'];
                // $insert->notification = implode('|',$data['leave_notification']);
                $insert->date_from = date('Y-m-d',strtotime($data['date_from']));
                $insert->date_to = date('Y-m-d',strtotime($data['date_to']));
                $insert->no_of_days = $data['hid_no_days'];
                if ($data['leave_type']=='Others') {
                    $insert->others = $data['others_leave'];
                }
                $insert->ip_address = request()->ip();
                $insert->save();
                return "success";
                // return redirect(route('hris.leave.eleave'))->with('status',"Leave application submitted");
            }
            catch(Exception $e){
                return "failed";
                // return redirect(route('hris.leave.eleave'))->with('failed',"operation failed");
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
                case 'VL':
                    return $leaves_balances[0]->VL;
                    break;
                case 'SL':
                    return $leaves_balances[0]->SL;
                    break;
                case 'ML':
                    return $leaves_balances[0]->ML;
                    break;
                case 'PL':
                    return $leaves_balances[0]->PL;
                    break;
                case 'EL':
                    return $leaves_balances[0]->EL;
                    break;
                case 'Others':
                    return $leaves_balances[0]->others;
                    break;
                
                default:
                    # code...
                    break;
            }
            // return $leaves_balances[0]->VL;
            
            // return view('hris.leave.view-leave-details', ['leaves'=>$leaves,'holidays'=>$holidays, 'departments'=>$departments, 'leave_types'=>$leave_types]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveForm  $leaveForm
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveForm $leaveForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveForm  $leaveForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveForm $leaveForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveForm  $leaveForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveForm $leaveForm)
    {
        //
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
