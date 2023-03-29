<?php

namespace Laravel\Jetstream\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $departments = DB::table('departments')->get();

        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
            'departments'=>$departments
        ]);
    }
}
