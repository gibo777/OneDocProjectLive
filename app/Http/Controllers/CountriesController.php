<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Http\Requests\StoreCountriesRequest;
use App\Http\Requests\UpdateCountriesRequest;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function countries (Request $request) {
            $countries = DB::table('countries')->orderBY('country')->get();
    }

    public function provinces (Request $request) {
        // return $request->country_code;
        $select = DB::table('provinces');
        $select = $select->select('province');
        $select = $select->distinct();
        $select = $select->where('country_code', '=', $request->country_code);
        // $select = $select->groupBy('province');
        $select = $select->get();
        return $select;
    }

    public function cities (Request $request) {

        $select = DB::table('provinces');
        $select = $select->select('municipality');
        $select = $select->distinct();
        $select = $select->where('country_code', '=', $request->country_code);
        $select = $select->where('province',$request->province)->get();
        return $select;
    }

    public function barangays(Request $request){
        $select = DB::table('provinces');
        $select = $select->select('barangay');
        $select = $select->distinct();
        $select = $select->where('country_code', '=', $request->country_code);
        $select = $select->where('province',$request->province);
        $select = $select->where('municipality',$request->municipality)->get();
        return $select;
    }

    public function zipcodes (Request $request){
        // return var_dump($request->all());
        $select = DB::table('provinces');
        $select = $select->select('zip_code');
        $select = $select->where('country_code', '=', $request->country_code);
        $select = $select->where('province',$request->province);
        $select = $select->where('municipality',$request->municipality);
        $select = $select->where('barangay',$request->barangay)->first();
        return $select;
    }

    

}
