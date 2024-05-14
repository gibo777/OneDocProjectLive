<?php

namespace Laravel\Fortify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Fortify::username() => 'required|string',
            'password' => 'required|string',
        ];
    }


    public function authCheckLogin ($email, $password)
    {
        $authLogin = DB::table('users')
        ->select(
            'password',
            'employment_status'
        )
        ->where('email', $email)->first();

        if ($authLogin) {
            $authPass = $authLogin->password;
            $authStatus = $authLogin->employment_status;
            if (Hash::check($password, $authPass)) {
                if ($authStatus=='NO LONGER CONNECTED') {
                    return response(['isSuccess' => false,'message'=>'You are '.$authStatus.'!']);
                } else {
                    return response(['isSuccess' => true,'message'=>'Credentials matched!']);
                }
            } else {
                return response(['isSuccess' => false,'message'=>'Invalid credentials!']);
            }
        } else {
            return response(['isSuccess' => false,'message'=>'Invalid credentials!']);
        }
    }

    /**
     * Verify if there is an existing, non-expired consent.
     *
     * @return count
     */
    public function verifyConsent($email)
    {
        $consentCount = DB::table('login_consent')
        ->where('email', $email)
        ->where('consent_date', '>', now()->subDays(30))
        ->count();
        return $consentCount;
    }

    public function saveConsent($email, $password) 
    {
        try{
            $userConsent = DB::table('users')
            ->select('id','employee_id', 'password')
            ->where('email',$email)
            ->first();

            if ($userConsent) {
                $storedPassword = $userConsent->password;

                if (Hash::check($password, $storedPassword)) {
                    // Passwords match
                    $data = [
                        'ref_id'        => $userConsent->id,
                        'email'         => $email, 
                        'employee_id'   => $userConsent->employee_id,
                        'consent_date'  => DB::raw('NOW()'),
                        'created_at'    => DB::raw('NOW()'),
                        'updated_at'    => DB::raw('NOW()'),
                    ];

                    $insert = DB::table('login_consent')->insert($data);
                    return response(['isSuccess' => true,'message'=>'Login consent saved!']);
                } else {
                    // Passwords do not match
                    return response(['isSuccess' => false,'message'=>'Invalid Password!']);
                }

            } else {
                return response(['isSuccess' => false,'message'=>'Invalid Email!']);
            }
            
        } catch(Exception $e){
            return response(['isSuccess'=>false,'message'=>$e]);
        }     
    }
}
