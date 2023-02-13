<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\SubmitsLeaveApplication;
use Laravel\Jetstream\Jetstream;

class SubmitLeaveApplication implements SubmitsLeaveApplication
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        echo "gilbert"; die();
        
        /*
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
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
