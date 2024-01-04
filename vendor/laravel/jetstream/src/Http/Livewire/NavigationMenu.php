<?php

namespace Laravel\Jetstream\Http\Livewire;

use Auth;
use Livewire\Component;
use App\Http\Controllers\HRMemoController;
use Illuminate\Support\Facades\DB;

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
// return Auth::user()->id;
        $timeCount = DB::table('time_logs')->where('employee_id', Auth::user()->employee_id)->orderBy('id','desc')->count();
        $timeLogs = DB::table('time_logs')->where('employee_id', Auth::user()->employee_id)->orderBy('id','desc')->first();
        if ($timeCount>0) {
            ($timeLogs->time_in !== null) ? $timeIn='disabled' : $timeOut='disabled' ;
        } else {
            $timeIn=''; $timeOut='disabled';
        }
        return view('navigation-menu', ['notification_count'=>$counter, 'timeIn'=>$timeIn, 'timeOut'=>$timeOut, 'timeCount'=> $timeCount ]);
    }
}
