<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Spatie\GoogleCalendar\Event;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TestController extends Controller
{
    /*public function returnUser(){
        $user = Auth::user();
        Javascript::put([ 'user.name' => $user->name, 'email' => $user->email ]);
        return view('my.user.js');
    }*/
    //
    function test_view (Request $request) {

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

        $countries = DB::table('countries')->get();
        return view('/test/test', ['months'=>$months, 'countries'=>$countries]);
      
    }

    public function testCalendar(Request $request) {

        try {
            // Fetch all events from Google Calendar
            $events = Event::get();

            // Convert events to a collection
            $eventsCollection = collect($events);

            // Get current page from the request (default to 1)
            $currentPage = $request->get('page', 1);
            // Set the number of items per page
            $perPage = 10;

            // Slice the collection to get the items for the current page
            $currentPageItems = $eventsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

            // Create a new LengthAwarePaginator instance
            $paginatedEvents = new LengthAwarePaginator(
                $currentPageItems,
                $eventsCollection->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // Return the paginated events to the view
            return view('test/test-calendar', ['events' => $paginatedEvents]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    protected function formatDate($dateString) {
        // Create DateTime object from the date string
        $date = new \DateTime($dateString);

        // Format the date to "D, mm/dd/yyyy"
        return $date->format('D, m/d/Y');
    }

    public function createEventForm()
    {
        return view('google-calendar.create'); // Ensure this view exists
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        try {
            $startDateTime = Carbon::parse($request->start_time . ' 00:00:00');
            $endDateTime = Carbon::parse($request->end_time . ' 23:59:59');

            $description = sprintf(
                "Name: %s\nEmployee #: %s\nLeave Type: %s\n\nDate Covered: %s to %s\nNumber of Day/s: %.1f\nReason: %s\n\nStatus: %s",
                'Test, Test T.', // Replace 'name' with the actual input key for the employee name
                '7777-7777', // Replace 'employee_number' with the actual input key for employee #
                'VL', // Replace 'leave_type' with the actual input key for leave type
                Carbon::parse($request->start_time)->format('M d, Y (D)'),
                Carbon::parse($request->end_time)->format('M d, Y (D)'),
                '0', // Replace 'number_of_days' with the actual input key for number of days
                'Test Only', // Replace 'reason' with the actual input key for reason
                'Pending' // Replace 'status' with the actual input key for approval status
            );

            $googleEvent = Event::create([
                'name' => $request->title,
                'description' => $description,
                'startDateTime' => $startDateTime,
                'endDateTime' => $endDateTime,
                'colorId' => 9, // Light blue
            ]);

            if (!$googleEvent) {
                \Log::error('Failed to create Google Calendar event: No response returned from the API.');
                return redirect()->route('events.create')->with('status', [
                    'message' => 'Failed to create the event on Google Calendar.',
                    'type' => 'error',
                ]);
            }

            $eventId = $googleEvent->id;

            return redirect()->route('events.create')->with('status', [
                'message' => 'Event created successfully! Event ID: ' . $eventId,
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating Google Calendar event: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);
            return redirect()->route('events.create')->with('status', [
                'message' => 'An error occurred while creating the event.',
                'type' => 'error',
            ]);
        }
    }

    public function dumpLeavesToGoogleCalendar() {
        $leaves = DB::table('leaves as l')
        ->leftJoin('users as u','l.employee_id','u.employee_id')
        ->select(
            'l.*', 'u.first_name', 'u.middle_name', 'u.last_name', 'u.suffix'
        )
        ->whereNull('l.google_id')
        ->where(function ($query) {
            $query->whereNull('l.is_deleted')
                  ->orWhere('l.is_deleted', '!=', 1);
        })
        ->where(function ($query) {
            $query->whereYear('l.date_from', 2025)
                  ->orWhereYear('l.date_to', 2025);
        })
        ->where('l.employee_id','!=','7777-7777')
        ->whereNotIn('l.leave_status',['Cancelled','Denied'])
        ->get();

        if ($leaves->isEmpty()) {
            return "No leave records found.";
        } else {
            $google_ids = [];
            $count = 0;
            foreach ($leaves as $key => $value) {
                    $google_ids[] = 
                    'Name: '.$value->name
                    .'<br>Employee #: '.$value->employee_id
                    .'<br>Leave Type:'.$value->leave_type
                    .'<br>Date Covered: ('.$value->date_from.' - '.$value->date_to.')'
                    .'<br>Number of Day/s: '.$value->no_of_days
                    .'<br>Reason: '.$value->reason
                    .'<br>Status: '.$value->leave_status
                    ;

                    if ($value->date_from == $value->date_to) {
                        $startDate = Carbon::parse($value->date_from)->startOfDay();
                        $endDate = Carbon::parse($value->date_to)->endOfDay();
                        $allDay = true; 
                    } else {
                        $startDateTime = Carbon::parse($value->date_from . ' 00:00:00');
                        $endDateTime = Carbon::parse($value->date_to . ' 23:59:59');
                        $allDay = false; 
                    }


                    $namePartsG = [
                        $value->last_name,
                        substr($value->first_name, 0, 1)
                    ];

                    $nameParts = [
                        $value->last_name,
                        $value->first_name
                    ];

                    if ($suffix = $value->suffix) {
                        $namePartsG[] = $suffix;
                        $nameParts[] = $suffix;
                    }

                    if ($middleName = $value->middle_name) {
                        $namePartsG[] = substr($middleName, 0, 1) . '.';
                        $nameParts[] = substr($middleName, 0, 1) . '.';
                    }

                    $lFullNameG = $namePartsG[0] . ', ' . implode(' ', array_slice($namePartsG, 1));
                    $lFullName = $nameParts[0] . ', ' . implode(' ', array_slice($nameParts, 1));


                    # Google Calendar Description
                    $description = sprintf(
                        "Name: %s\nEmployee #: %s\n\nLeave Type: %s\nDate Covered: %s to %s\nNumber of Day/s: %.1f\nReason: %s\n\nStatus: %s",
                        $lFullName,
                        $value->employee_id,
                        $value->leave_type,
                        Carbon::parse($value->date_from)->format('M d, Y (D)'),
                        Carbon::parse($value->date_to)->format('M d, Y (D)'),
                        number_format($value->no_of_days, 2),
                        $value->reason,
                        $value->leave_status
                    );

                    # Google Calendar Data
                    $eventData = [
                        'name'              => $lFullNameG.' ('.$value->leave_type.')',
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
                        $updateLeave = DB::table('leaves')
                        ->where('id', $value->id)
                        ->update(['google_id' => $eventId]);
                    }
                }

                return $google_ids_string = implode("<br><br>", $google_ids);
            
            // return $google_ids_string = implode("<br><br>", $eventData);
        }

    }




}
