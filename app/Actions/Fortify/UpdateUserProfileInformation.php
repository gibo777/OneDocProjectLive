<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        // $input = array_map('strtoupper',$input);
        // dd($input);
        Validator::make($input, [
            'first_name'    => ['required', 'string', 'max:255'],
            'middle_name'   => ['nullable', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'suffix'        => ['nullable', 'string', 'max:15'],
            'employee_id'   => ['nullable', 'string', 'max:12'],

            'home_address'  => ['required', 'string', 'max:255'],
            'country'       => ['required', 'string', 'max:100'],
            'province'      => ['required', 'string', 'max:100'],
            'city'          => ['required', 'string', 'max:100'],
            'barangay'      => ['required', 'string', 'max:100'],
            'zip_code'      => ['required'],

            'gender'        => ['required'],
            'civil_status'  => ['required'],

            'email'         => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo'         => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // $input['birthdate'] = strtotime($input['birthdate']);
            // $casts = ['birthdate' => 'date:Y-m-d'];
            $data = [
                'first_name'    => strtoupper($input['first_name']),
                'middle_name'   => strtoupper($input['middle_name']),
                'last_name'     => strtoupper($input['last_name']),
                'suffix'        => strtoupper($input['suffix']),

                'employee_id'   => $input['employee_id'],
                'position'      => strtoupper($input['position']),
                'department'    => $input['department'],

                'home_address'  => strtoupper($input['home_address']),
                'country'       => $input['country'],
                'province'      => $input['province'],
                'city'          => $input['city'],
                'barangay'      => $input['barangay'],
                'zip_code'      => $input['zip_code'],

                'gender'        => $input['gender'],
                'civil_status'  => $input['civil_status'],
                'contact_number'=> $input['contact_number'],

                'nationality'   => $input['nationality'],
                'religion'      => $input['religion'],
                // 'birthdate'     => date('Y-m-d',$input['birthdate']),
                'birthdate'     => $input['birthdate'],
                'birth_place'   => $input['birth_place'],

                'email'         => $input['email'],
                'updated_by'    => Auth::user()->employee_id,
            ];

            $data['birthdate'] = date('Y-m-d',strtotime($data['birthdate']));

            // dd($data);
            $user->forceFill($data)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }



}
