<?php

namespace Laravel\Jetstream\Http\Livewire;

use Auth;
use Livewire\Component;
use App\Http\Controllers\HRMemoController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NavigationMenu extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $counts = new HRMemoController;
        $counts = $counts->memo_counter();
        $counter = 0;
        $timeIn = ''; $timeOut = '';

        foreach ($counts as $count) {
            $counter = $counter + $count->memo_count;
        }
        $timeCount = DB::table('time_logs')
        ->where('employee_id', Auth::user()->employee_id)
        ->whereNotNull('time_in')
        // ->whereDate('time_in', DB::raw('CURDATE()'))
        ->orderBy('id','desc')->count();

        $timeLogs = DB::table('time_logs')
        ->where('employee_id', Auth::user()->employee_id)
        ->orderBy('id','desc')->first();

        if ($timeCount>0) {
            ($timeLogs->time_in !== null) ? $timeIn='disabled' : $timeOut='disabled' ;
        } else {
            $timeIn=''; $timeOut='disabled';
        }

        $serverStatus = DB::table('server_status')->where('id', 1)->value('status');

        // $navMenu = Auth::user()->id == 1 ? 'sample-sidebar' : 'navigation-menu';
        $navMenu = 'navigation-menu';
        return view($navMenu, 
            [
                'notification_count'    => $counter, 
                'timeIn'                => $timeIn, 
                'timeOut'               => $timeOut, 
                'timeCount'             => $timeCount,
                'serverStatus'          => $serverStatus
            ]);
    }
}
