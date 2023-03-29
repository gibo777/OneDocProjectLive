<?php

namespace Laravel\Jetstream\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LeaveFormController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $holidays = DB::table('holidays')->get();
        $departments = DB::table('departments')->get();
        return view('hris.leave.eleave', [
            'request' => $request,
            'user' => $request->user(),
            'holidays'=>$holidays, 
            'departments'=>$departments
        ]);
    }

    public function submitLeave(Request $request)
    {
        echo 'gilbert'; die();
        /*Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_id' => ['required', 'string', 'max:12','unique:users'],
            'department'=>['required','integer'],
            'position'=>['required','string','max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'employee_id' => $input['employee_id'],
                'position' => $input['position'],
                'department' => $input['department'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });*/
    }
}
