<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;
  

class Event extends Model
{
    use HasFactory;

    protected $table = "events";
  
    /*protected $fillable = [
        'title', 'start', 'end'
    ];*/

    protected $fillable = [
    	'title', 'description', 'start', 'end', 'google_calendar_event_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($event) {
            $googleEvent = GoogleCalendarEvent::create([
                'name' 			=> $event->title,
                'description' 	=> $event->description,
                'startDateTime'	=> $event->start,
                'endDateTime'	=> $event->end,
            ]);
            $event->update([
            	'google_calendar_event_id' => $googleEvent->id
            ]);
        });

        static::updated(function ($event) {
            if (!$event->google_calendar_event_id) {
                // No Google Calendar event exists, so create one
                $googleEvent = GoogleCalendarEvent::create([
                    'name' 			=> $event->title,
                    'description' 	=> $event->description,
                    'startDateTime' => $event->start,
                    'endDateTime' 	=> $event->end,
                ]);

                $event->update(['google_calendar_event_id' => $googleEvent->id]);
            } else {
                // Google Calendar event exists, so update it
                $googleEvent = GoogleCalendarEvent::find($event->google_calendar_event_id);

                if ($googleEvent) {
                    $googleEvent->update([
                        'name' 			=> $event->title,
                        'description' 	=> $event->description,
                        'startDateTime' => $event->start,
                        'endDateTime' 	=> $event->end,
                    ]);
                }
            }
        });
    }

}