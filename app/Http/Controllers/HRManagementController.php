<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\HRManagement;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class HRManagementController extends Controller
{

    /*======= HOLIDAYS =======*/
    public function view_holidays() {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;

            $holidays = DB::table('holidays as h')
            // ->leftJoin('offices as o', 'h.holiday_office', 'o.id')
            ->select(
                'h.id',
                'h.holiday',
                'h.holiday_type',
                DB::raw('(SELECT company_name from offices WHERE id=h.holiday_office) as holiday_office') ,
                DB::raw("DATE_FORMAT(h.date,'%m/%d/%Y') as date")
            );
            $holidays = $holidays->where( function($query) {
                return $query->where ('h.is_deleted','=', '0')->orWhereNull('h.is_deleted');
                });
            $holidays = $holidays->whereYear('h.date','=',date('Y'));
            $holidays = $holidays->orderBy('h.date');
            $holidays = $holidays->get();


            $offices = DB::table('offices')->get();

            $months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            $years = range(2020, date('Y',strtotime('+5 years')) );

            return view('/hris/hr-management/holidays', 
                [
                    'holidays'          => $holidays, 
                    'holiday_offices'   => $offices,
                    'months'            => $months, 
                    'years'             => $years
                ]);
        } else {
            return redirect('/');
        }
    }

    public function filter_holidays (Request $request) {
        // return var_dump($request->all());

        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;

            $holidays = DB::table('holidays');
            $holidays = $holidays->select(
                'id',
                'holiday',
                'holiday_type',
                'holiday_office',
                DB::raw('(SELECT company_name from offices WHERE id=holiday_office) as holiday_office') ,
                DB::raw("DATE_FORMAT(date,'%m/%d/%Y') as date")
            );
            if ($request->filter_year != null) {
                $holidays = $holidays->whereYear('date','=',$request->filter_year);
            }
            if ($request->filter_month != null) {
                $holidays = $holidays->whereMonth('date','=',$request->filter_month);
            }
            $holidays = $holidays->where( function($query) {
                return $query->where ('is_deleted','=', '0')->orWhereNull('is_deleted');
                });
            $holidays = $holidays->orderBy('date');
            $holidays = $holidays->get();

            $months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            $years = range(2020, date('Y',strtotime('+5 years')) );

            // return var_dump($holidays);

            return view('/hris/hr-management/filter-holidays', 
                [
                    'holidays'      => $holidays, 
                    'filter_month'  => $request->filter_month, 
                    'filter_year'   => $request->filter_year, 
                    'months'        => $months, 
                    'years'         => $years
                ]);


        } else {
            return redirect('/');
        }
    }

    public function save_holidays (Request $request) {
        // return "Gilbert";
        $rules = [
            'holiday' => 'required|string|max:255',
            'holiday_date' => 'required|date',
            'holiday_category' => 'required|string|max:255'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return redirect(route('hr.management.holidays'))
            ->withInput()
            ->withErrors($validator);
        }
        else{
            $data = $request->input();
            // return Auth::user()->employee_id;
            try{
                // return $data['holiday'];
                // return $data['holiday_date'];
                // return $data['holiday_category'];
                $insert = new HRManagement;
                $insert->holiday = $data['holiday'];
                $insert->date = date('Y-m-d',strtotime($data['holiday_date']));
                $insert->holiday_type = $data['holiday_category'];
                $insert->created_by = Auth::user()->employee_id;
                $insert->updated_by = Auth::user()->employee_id;
                // $insert->created_at = date('Y-m-d');
                // $insert->updated_at = date('Y-m-d');
                $insert->save();
                // return var_dump($insert); die();

            } catch (Exception $e) {
                return redirect(route('hr.management.holidays'))->with('failed','Operation Failed!');
            }
        }
    }

    public function update_holidays (Request $request) {
        // return var_dump($request->all());
        // return "Gilbert....";
        if($request->ajax()){
            try {
                // return [$request->holiday,$request->holiday_date,$request->holiday_category];
                $data_array = array(
                    'holiday'       => $request->holiday,
                    'holiday_type'  => $request->holiday_category,
                    // 'date'          => $request->holiday_date,
                    'updated_by'    => Auth::user()->employee_id,
                    'updated_at'    => date('Y-m-d H:i:s')
                );

                $update = DB::table('holidays');
                $update = $update->where('id',$request->hid_holiday_id);
                $update = $update->update($data_array);
            }
            catch(Exception $e){
                return redirect(route('hr.management.holidays'))->with('failed',"operation failed");
            }
        }
    }

    /* ======= DEPARTMENTS ======= */

    public function view_departments() {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;

            $departments = DB::table('departments');
            $departments = $departments->select(
                'id',
                'department_code',
                'department'
            );
            $departments = $departments->get();

            return view('/hris/hr-management/departments', 
                [
                    'departments'  => $departments
                ]);
        } else {
            return redirect('/');
        }
    }

    public function filter_departments (Request $request) {
        // return var_dump($request->all());

        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;

            $holidays = DB::table('holidays');
            $holidays = $holidays->select(
                'id',
                'holiday',
                'holiday_type',
                DB::raw("DATE_FORMAT(date,'%m/%d/%Y') as date")
            );
            if ($request->filter_year != null) {
                $holidays = $holidays->whereYear('date','=',$request->filter_year);
            }
            if ($request->filter_month != null) {
                $holidays = $holidays->whereMonth('date','=',$request->filter_month);
            }
            $holidays = $holidays->orderBy('date');
            $holidays = $holidays->get();

            $months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            $years = range(2020, date('Y',strtotime('+5 years')) );

            // return var_dump($holidays);

            return view('/hris/hr-management/filter-departments', 
                [
                    'holidays'      => $holidays, 
                    'filter_month'  => $request->filter_month, 
                    'filter_year'   => $request->filter_year, 
                    'months'        => $months, 
                    'years'         => $years
                ]);


        } else {
            return redirect('/');
        }
    }

    public function save_departments (Request $request) {
        // return "Gilbert";
        $rules = [
            'department_code' => 'required|string|max:12',
            'department' => 'required|string|max:255'
        ];
        // return var_dump($rules);

        $validator = Validator::make($request->all(),$rules);
        // return $validator->fails();

        if ($validator->fails()) {
            return redirect(route('hr.management.departments'))
            ->withInput()
            ->withErrors($validator);
        }
        else{
            $data = $request->input();
            // return var_dump($data);
            // return Auth::user()->employee_id;
            try{
                $insert = new Departments;
                $insert->department_code = strtoupper($data['department_code']);
                $insert->department = ucwords(strtolower($data['department']));
                $insert->created_by = Auth::user()->employee_id;
                $insert->updated_by = Auth::user()->employee_id;
                // $insert->created_at = date('Y-m-d');
                // $insert->updated_at = date('Y-m-d');
                $insert->save();
                // return var_dump($insert); die();

            } catch (Exception $e) {
                return redirect(route('hr.management.departments'))->with('failed','Operation Failed!');
            }
        }
    }

    public function update_departments (Request $request) {
        // return var_dump($request->all());
        // return "Gilbert....";
        if($request->ajax()){
            try {
                // return [$request->holiday,$request->holiday_date,$request->holiday_category];
                $data_array = array(
                    'department_code'   => $request->department_code,
                    'department'        => $request->department,
                    'updated_by'        => Auth::user()->employee_id,
                    'updated_at'        => date('Y-m-d H:i:s')
                );

                $update = DB::table('departments');
                $update = $update->where('id',$request->hid_department_id);
                $update = $update->update($data_array);
            }
            catch(Exception $e){
                return redirect(route('hr.management.departments'))->with('failed',"operation failed");
            }
        }
    }
}
