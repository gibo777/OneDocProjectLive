<?php

namespace App\Actions\Fortify;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password'  => [
                'required',
                'string',
                'confirmed',
                Password:: min(8)->letters()->numbers()->mixedCase()->symbols(),
            ],
            'password_confirmation' => 'required',
        ])->validate();
        
        if ($user->email_verified_at){
            $user->forceFill([
                'password' => Hash::make($input['password']),
                'remember_token' =>Str::random(80),
            ])->save();

        }else{
            $user->forceFill([
                'password' => Hash::make($input['password']),
                'remember_token' =>Str::random(80),
                'email_verified_at' => Carbon::now(),
            ])->save();
        }
  
    }
}
