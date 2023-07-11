<?php

namespace App\Actions\Fortify;

use Auth;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

// use App\Http\Controllers\Controller;
use App\Models\PersonnelAccountingData;
use App\Models\PersonnelFamilyBackground;
use App\Models\PersonnelEducationalBackground;
use App\Models\PersonnelEmploymentHistory;
use App\Models\LeaveBalances;

class CreateNewUser implements CreatesNewUsers
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
        // dd($input);
        $token = Str::random(80);

        Validator::make($input, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_id'   => ['required', 'string', 'max:12','unique:users'],
            'department'    =>['required','string', 'max:12'],
            'position'      =>['required','string','max:255'],
            'gender'        =>['required','string','max:25'],
            // 'password' => $this->passwordRules(),
            'terms'         => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input,$token) {

        $insertFields = [
                'first_name'    => strtoupper($input['first_name']),
                'last_name'     => strtoupper($input['last_name']),
                'middle_name'   => strtoupper($input['middle_name']),
                'suffix'        => strtoupper($input['suffix']),

                'employee_id'       => $input['employee_id'],
                'employment_status' => $input['employment_status'],
                // 'date_hired'        => Carbon::createFromFormat('Y-m-d', $input['start_date']),
                'date_hired'        => date('Y-m-d',strtotime($input['start_date'])),
                'weekly_schedule'   => join('|',$input['weekly_schedule']),

                'position'          => strtoupper($input['position']),
                'department'        => $input['department'],
                'office'            => $input['office'],

                'gender'    => $input['gender'],
                'email'     => $input['email'],
                'role_type' => $input['role_type'],

                'remember_token' => $token,
                'expires_at' => Carbon::now()->addHour(),
                // 'password' => Hash::make($input['password']),
            ];
            // dd($insertFields);

            return tap(User::create($insertFields), function (User $user) {
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        // dd($user->employee_id);
        /*$insert = new PersonnelAccountingData;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelFamilyBackground;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelEducationalBackground;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelEmploymentHistory;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new LeaveBalances;
        $insert->employee_id = $user->employee_id;
        $insert->save();*/

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            // 'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'name' => $user->first_name."'s Team",
            'personal_team' => true,
        ]));
    }
}
