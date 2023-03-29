<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\FormSubmitted;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HRMemoController;

class PusherNotificationController extends Controller
{
    //
    public function view_push() {
    	return view('test/counter');
    }
    public function sender_push() {
    	return view('test/sender');
    }
    public function send_push(Request $request) {
    	$text = $request->content;
    	event(new FormSubmitted($text));
    }

    public function notification_count (Request $request) {
        return var_dump($request->all());
        // return "[jmbd] stop it!";
        $values = [];
        $memo_g_counts = 0;
        $memo_s_counts = 0;
        $memo_counter = new HRMemoController;
        $memo_counts = $memo_counter->memo_counter();
        // return var_dump($memo_counts);
        foreach ($memo_counts as $key => $value) {
            // return $value->memo_send_option;
            if ($value->memo_send_option=='g') {
                $memo_g_counts = $value->memo_count;
            } else {
                $memo_s_counts = $value->memo_count;
            }
        }

        $values['memo_counts'] = $memo_g_counts + $memo_s_counts;
        $values['memo_g_counts'] = $memo_g_counts;
        $values['memo_s_counts'] = $memo_s_counts;

        return $values;

        // return event(new FormSubmitted($values));
    }
}
