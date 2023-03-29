<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Offices;
use App\Http\Requests\StoreOfficesRequest;
use App\Http\Requests\UpdateOfficesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class OfficesController extends Controller
{
    public function view_offices() {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $access_code = Auth::user()->access_code;

            $select = DB::table('offices');
            $select = $select->select(
                'id',
                'company_name', 
                'address', 
                'city', 
                'province', 
                'country', 
                'zipcode', 
                'tin', 
                'contact'
            );
            $offices = $select->get();

            $countries = DB::table('countries')->orderBY('country')->get();

            return view('/hris/hr-management/offices', 
                [
                    'offices'  => $offices,
                    'countries' => $countries
                ]);
        } else {
            return redirect('/');
            // return view('/auth/login');
        }
    }

    public function filter_offices (Request $request) {
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

            return view('/hris/hr-management/filter-offices', 
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

    public function save_offices (Request $request) {

        // return "Gilbert";
        $rules = [
            'office_code' => 'required',
            'office_country' => 'required',
            'office_province' => 'required',
            'office_city' => 'required',
            'office_barangay' => 'required',
            'office_address' => 'required',
            'office_zipcode' => 'required',
            'office_tin' => 'required',
            'office_contact' => 'required',
            
        ];
        // return var_dump($rules);

        $validator = Validator::make($request->all(),$rules);
        // return $validator->fails();

        if ($validator->fails()) {
            return redirect(route('hr.management.offices'))
            ->withInput()
            ->withErrors($validator);
        }
        else{
            // return var_dump($data);
            // return Auth::user()->employee_id;
            try{
                $creates = DB::table('offices')->insertGetId([
                    'company_name' => $request->office_code,
                    'address' => $request->office_address,
                    'city' => $request->office_city,
                    'barangay' => $request->office_barangay,
                    'province' => $request->office_province,
                    'country' => $request->office_country,
                    'zipcode' => $request->office_zipcode,
                    'tin'=> $request->office_tin,
                    'contact' => $request->office_contact,
                ]);
                
                if($creates){
                    $data = DB::table('offices')->where('id',$creates)->first();
                    return response(['creates' => $data]);
                }
                // $insert = new Departments;
                // $insert->department_code = strtoupper($data['department_code']);
                // $insert->department = ucwords(strtolower($data['department']));
                // $insert->created_by = Auth::user()->employee_id;
                // $insert->updated_by = Auth::user()->employee_id;
                // // $insert->created_at = date('Y-m-d');
                // // $insert->updated_at = date('Y-m-d');
                // $insert->save();
                // return var_dump($insert); die();

            } catch (Exception $e) {
                return response('Adding of Office Failed');
            }
        }
    }

    public function update_offices (Request $request) {

       // return "Gilbert";
       $rules = [
        'office_id' => 'required',
        'office_code' => 'required',
        'office_country' => 'required',
        'office_province' => 'required',
        'office_city' => 'required',
        'office_barangay' => 'required',
        'office_address' => 'required',
        'office_zipcode' => 'required',
        'office_tin' => 'required',
        'office_contact' => 'required',
        
    ];
    // return var_dump($rules);

    $validator = Validator::make($request->all(),$rules);
    // return $validator->fails();

    if ($validator->fails()) {
        return redirect(route('hr.management.offices'))
        ->withInput()
        ->withErrors($validator);
    }
    else{
        // return var_dump($data);
        // return Auth::user()->employee_id;
        try{
            $updates = DB::table('offices')->where('id',$request->office_id)->update([
                'company_name' => $request->office_code,
                'address' => $request->office_address,
                'city' => $request->office_city,
                'barangay' => $request->office_barangay,
                'province' => $request->office_province,
                'country' => $request->office_country,
                'zipcode' => $request->office_zipcode,
                'tin'=> $request->office_tin,
                'contact' => $request->office_contact,
            ]);
            
            if($updates){
                $data = DB::table('offices')->where('id',$updates)->first();
                return response(['updates' => $data]);
            }
            // $insert = new Departments;
            // $insert->department_code = strtoupper($data['department_code']);
            // $insert->department = ucwords(strtolower($data['department']));
            // $insert->created_by = Auth::user()->employee_id;
            // $insert->updated_by = Auth::user()->employee_id;
            // // $insert->created_at = date('Y-m-d');
            // // $insert->updated_at = date('Y-m-d');
            // $insert->save();
            // return var_dump($insert); die();

        } catch (Exception $e) {
            return response('Adding of Office Failed');
        }
    }
    }

    public function geOfficeDetails(Request $request){
        $id = '';
        $id = $request->id;
        error_log($request);
        $office = DB::table('offices')->where('id',$id)->first()??'';
        return response(['office' => $office]);
    }
}
