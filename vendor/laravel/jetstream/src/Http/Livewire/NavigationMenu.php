<?php

namespace Laravel\Jetstream\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\HRMemoController;

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
        foreach ($counts as $count) {
            $counter = $counter + $count->memo_count;
        }
        return view('navigation-menu', ['notification_count'=>$counter]);
    }
}
