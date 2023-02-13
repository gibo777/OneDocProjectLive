<?php

namespace Laravel\Fortify\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;


use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    use Notifiable;
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        // $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterViewResponse
     */
    public function create(Request $request): RegisterViewResponse
    {
        $departments = DB::table('departments')->get();
        $roleTypeUsers = DB::table('role_type_users')
            ->select('role_type')
            ->where('is_deleted', NULL)
            ->orWhere('is_deleted',0)
            ->get();
        $rolesPermissions = DB::table('roles_permissions')->get();
        $genders = DB::table('genders')->get();
        $employment_statuses = DB::table('employment_statuses')->get();
        $offices = DB::table('offices')->get();

        $request['offices'] = $offices;
        $request['departments'] = $departments;
        $request['roleTypeUsers'] = $roleTypeUsers;
        $request['rolesPermissions'] = $rolesPermissions;
        $request['genders'] = $genders;
        $request['employment_statuses'] = $employment_statuses;

        if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN') {
            return app(RegisterViewResponse::class);
        }
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        $user = $creator->create($request->all());
        event(new Registered($user));

        // $this->guard->login($user);
        $user->notify(new VerifyEmail($user->remember_token,$user->email));
        return app(RegisterResponse::class);
    }
}
