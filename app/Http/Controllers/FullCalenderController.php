<?php
  
namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
  
class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
          if($request->ajax()) {
         
                $data = Event::whereDate('date_from', '>=', $request->start)
                         ->whereDate('date_to',   '<=', $request->end);
                $data = $data->where( function($query) {
                  return $query->where ('is_deleted','=', '0')->orWhereNull('is_deleted');
                  });
                $data = $data->where( function($query) {
                  return $query->where ('is_cancelled','=', '0')->orWhereNull('is_cancelled');
                  });
                $data = $data->where( function($query) {
                  return $query->where ('is_denied','=', '0')->orWhereNull('is_denied');
                  });

                $data = $data->get([ 'id', 'leave_status',
                          DB::raw("concat(SUBSTRING_INDEX(name,',',1), ', ',
                          SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(name,',',2),',',-1),2,1), '.',
                          ' (',leave_type,')') as title"), 
                          'date_from as start', 'date_to as end']);

    
               return response()->json($data);
          }
            return view('/utilities/fullcalender');
        } else {
            return redirect('/');
        }

    }
 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
 
        switch ($request->type) {
          case 'view':
               $data = DB::table('leaves as L');
               // $data = $data->leftJoin();
               $data = $data->where('L.id', '=', $request->id)
                         ->get([ 
                          'L.id', 'L.leave_number', 'L.control_number',
                          'L.name', 
                          'L.employee_id',
                          'L.leave_type', 'L.no_of_days', 
                          'L.reason', /*'L.leave_status',*/
                          DB::raw('(CASE WHEN L.is_denied=1 THEN "Denied" WHEN L.is_cancelled=1 THEN "Cancelled" WHEN L.is_taken=1 THEN "Taken" ELSE (CASE WHEN L.is_head_approved=1 THEN "Head Approved" ELSE "Pending" END) END) as leave_status'),
                          DB::raw("DATE_FORMAT(L.date_from, '%b %d, %Y (%a)') as date_from"),
                          DB::raw("DATE_FORMAT(L.date_to, '%b %d, %Y (%a)') as date_to"),
                          DB::raw('concat(L.name," (",L.leave_type,") ") as title'), 
                          'L.date_from as start', 'L.date_to as end']);
                         // return var_dump($data[0]);
               return response()->json($data[0]);
          break;
          case 'add':
            $event = Event::create([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            return response()->json($event);
           break;

          case 'update':
            $event = Event::find($request->id)->update([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            return response()->json($event);
           break;

          case 'delete':
            // $event = Event::find($request->id)->delete();
            // return response()->json($event);
           break;
           
          default:
           # code...
           break;
        }
    }
}