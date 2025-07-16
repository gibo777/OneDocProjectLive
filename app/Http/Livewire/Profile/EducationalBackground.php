<?php

namespace App\Http\Livewire\Profile;

use Auth;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class EducationalBackground extends Component
{
    public function render()
    {
        // $users = DB::table('users')->get();
        // return view('livewire.profile.educational-background', ['users' => $users]);
        return view('livewire.profile.educational-background');
    }
}
