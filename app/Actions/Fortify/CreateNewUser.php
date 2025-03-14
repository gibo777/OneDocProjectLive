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
        $randomString = Str::random(128);

        Validator::make($input, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'employee_id'   => ['required', 'string', 'max:12','unique:users'],
            'department'    =>['required','string', 'max:12'],
            'position'      =>['required','string','max:255'],
            'gender'        =>['required','string','max:25'],
            // 'password' => $this->passwordRules(),
            'terms'         => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input,$token,$randomString) {

            $name = $input['last_name'];

            if (!empty($input['first_name'])) {
                $name .= ', ' . $input['first_name'];
            }

            if (!empty($input['suffix'])) {
                $name .= ' ' . $input['suffix'];
            }

            if (!empty($input['middle_name'])) {
                $middleNameParts = explode(' ', $input['middle_name']);
                $middleInitials = array_map(function($part) {
                    return strtoupper(substr($part, 0, 1)) . '.';
                }, $middleNameParts);
                $name .= ' ' . implode('', $middleInitials);
            }

            $insertFields = [
                'name'              => strtoupper($name),
                'first_name'        => strtoupper($input['first_name']),
                'last_name'         => strtoupper($input['last_name']),
                'middle_name'       => $input['middle_name'] ? strtoupper($input['middle_name']) : '',
                'suffix'            => $input['suffix'] ? strtoupper($input['suffix']) : '',

                'employee_id'       => $input['employee_id'],
                'employment_status' => $input['employment_status'],
                // 'date_hired'        => Carbon::createFromFormat('Y-m-d', $input['start_date']),
                'date_hired'        => date('Y-m-d',strtotime($input['start_date'])),
                'weekly_schedule'   => join('|',$input['weekly_schedule']),

                'position'          => strtoupper($input['position']),
                'department'        => $input['department'],
                'office'            => $input['office'],

                'gender'            => $input['gender'],
                'email'             => preg_replace('/\s+/', '', $input['email']),
                'role_type'         => $input['role_type'],
                // 'role_permission'   => ($input['role_type']=='SUPER ADMIN') ? 1 : 0,
                'is_head'           => ($input['role_type']=='ADMIN' || $input['role_type']=='SUPER ADMIN') ? 1 : 0,

                'remember_token'    => $token,
                'qr_code_link'      => $randomString,
                'expires_at'        => Carbon::now()->addHour(),
                'created_by'        => Auth::user()->employee_id,
                // 'password' => Hash::make($input['password']),
            ];
            // return var_dump($insertFields);
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
        $insert = new PersonnelAccountingData;
        $insert->ref_id = $user->id;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelFamilyBackground;
        $insert->ref_id = $user->id;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelEducationalBackground;
        $insert->ref_id = $user->id;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new PersonnelEmploymentHistory;
        $insert->ref_id = $user->id;
        $insert->employee_id = $user->employee_id;
        $insert->created_by = Auth::user()->employee_id;
        $insert->updated_by = Auth::user()->employee_id;
        $insert->save();

        $insert = new LeaveBalances;
        $insert->ref_id = $user->id;
        $insert->year = Carbon::now()->format('Y');
        $insert->VL = 0;
        $insert->SL = 0;
        $insert->ML = 0;
        $insert->PL = 0;
        $insert->EL = 0;
        $insert->others = 0;
        $insert->employee_id = $user->employee_id;
        $insert->save();

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            // 'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'name' => $user->first_name."'s Team",
            'personal_team' => true,
        ]));
    }
}
