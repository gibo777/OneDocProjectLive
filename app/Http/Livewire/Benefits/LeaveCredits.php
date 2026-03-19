<?php

namespace App\Http\Livewire\Benefits;

use Livewire\Component;
use Carbon\Carbon;

class LeaveCredits extends Component
{
    public $serverTz;       // Server timezone name
    public $serverGmt;      // Server GMT offset
    public $serverTime;     // Server current time

    public $userTz;         // User detected timezone
    public $userGmt;        // User GMT offset
    public $userTime;       // Current time in user's timezone

    public function mount()
    {
        $this->serverTz = config('app.timezone'); // e.g., Asia/Manila
        $this->serverTime = Carbon::now()->timezone($this->serverTz)->format('Y-m-d H:i:s');
        $this->serverGmt = $this->calculateGmtOffset($this->serverTz);

        $this->userTz = '';
        $this->userTime = '';
        $this->userGmt = '';
    }

    public function detectUserTimezone($tz)
    {
        $now = Carbon::now();

        $this->userTz = $tz;
        $this->userGmt = $this->calculateGmtOffset($tz);
        $this->userTime = $now->copy()->timezone($tz)->format('Y-m-d H:i:s');

        $this->serverTime = $now->copy()->timezone($this->serverTz)->format('Y-m-d H:i:s');

        // Trigger SweetAlert
        $this->dispatchBrowserEvent('user-time-detected', [
            'serverTz' => $this->serverTz,
            'serverGmt' => $this->serverGmt,
            'serverTime' => $this->serverTime,
            'userTz' => $this->userTz,
            'userTime' => $this->userTime,
            'userGmt' => $this->userGmt,
        ]);
    }

    private function calculateGmtOffset($tz)
    {
        // Use Carbon format 'P' to get correct GMT like +08:00
        return 'GMT ' . Carbon::now()->timezone($tz)->format('P');
    }

    public function render()
    {
        return view('livewire.benefits.leave-credits');
    }
}
