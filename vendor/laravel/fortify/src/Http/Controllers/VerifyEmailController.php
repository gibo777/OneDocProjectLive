<?php

namespace Laravel\Fortify\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;


class VerifyEmailController extends Controller
{
    // use PasswordValidationRules;
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Laravel\Fortify\Http\Requests\VerifyEmailRequest  $request
     * @return \Laravel\Fortify\Contracts\VerifyEmailResponse
     */
    public function __invoke(VerifyEmailRequest $request)
    {
      
        // if ($request->user()->hasVerifiedEmail()) {
        //     return app(VerifyEmailResponse::class);
        // }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }

        // if ($request->user()->email_verified_at != NULL) {
        //     return app(LoginViewResponse::class);
        // } 
        
        // return app(VerifyEmailResponse::class);
        
    }
    public function configureEmail(Request $request) {
        $currentUser = Auth::user() ?? '';
        $user = '';
        $isExpired = false;
        $isForbidden = false;
        if($currentUser){
            if(($currentUser->email != $request->email) && ($currentUser->remember_token!=$request->token)){
                $isForbidden = true;
            }
        }
        if($request->token && $request->email)
        {
            $user = User::where('email',$request->email)->where('remember_token',$request->token)->first();
        }
        if ($user){
            if(!Carbon::parse($user->expires_at)->gt(Carbon::now())){
                $isExpired = true;
            }
        }else{
            $isExpired = true;
        }
        return view('auth.createPassword',['isExpired' => $isExpired, 'isForbidden' => $isForbidden]);
    }

    public function createPassword(Request $request){
        $valid = $request->validate([
            'email' => 'required|email',
            'password'  => [
                'required',
                'string',
                'confirmed',
                Password:: min(8)->letters()->numbers()->mixedCase()->symbols(),
            ],
            'password_confirmation' => 'required',
        ]);
        $user = User::where('email',$request->email)->where('remember_token',$request->remember_token)->update([
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
            'expires_at' => Carbon::now()
        ]);
        return redirect('/')->with('status','Successfully Created Password and Verified Email');
    }
}
