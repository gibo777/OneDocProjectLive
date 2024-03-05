<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Clearances;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ClearancesController extends Controller
{
    public function index()
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL) )
        {
        	return view('hris.clearance.clearance');
        }
    }
}
