<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
    <x-slot name="header">
            {{ __('USER REGISTRATION') }}
    </x-slot>

        <!-- <x-jet-validation-errors class="mb-1" /> -->

<div class="max-w-5xl mx-auto mt-5">

    <form method="POST" action="{{ route('register') }}">
        @csrf




    <div class="bg-white sm:p-6 shadow text-center {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
        @if (session('status'))
            <div class="font-medium text-center text-green-600">
                {{ session('status') }}
            </div>
        @endif
        {{-- <div class="row mb-3 m-0 p-0">
            <div class="col-md-4">
            </div>
            <div class="col-md-4 flex items-center justify-center mb-2">
                <img id="companyLogo" src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded w-100 mx-auto d-block"/>
            </div>
            <div class="col-md-4">
            </div>
        </div> --}}
        <div class="row mx-2 mt-2">
            <div class="flex items-center">
                <p>Only authorized person can register a new user. Upon clicking "REGISTER USER", there will be a link to be sent on the specified email.</p>
            </div>
        </div>



        {{-- <div class="max-w-5xl mx-auto mt-1"> --}}
        <div class="row mx-2 mt-2 text-center">



            <div class="col-md-4 px-1">
                <div class="form-floating">
                    <x-jet-input id="last_name" class="form-control all-caps block w-full" type="text" name="last_name" :value="old('last_name')" placeholder="Last Name" required autofocus autocomplete="off" />
                    <x-jet-label for="last_name" value="{{ __('Last Name') }}" class="text-black-50 w-full"/>
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
            </div>

            <div class="col-md-4 px-1">
                <div class="form-floating">
                    <x-jet-input id="first_name" class="form-control all-caps block w-full" type="text" name="first_name" :value="old('first_name')" placeholder="First Name" required autofocus autocomplete="off" />
                    <x-jet-label for="first_name" value="{{ __('First Name') }}" class="text-black-50 w-full" />
                    <x-jet-input-error for="first_name" class="mt-2" />
                </div>
            </div>

            <div class="col-md-3 px-1">
                <div class="form-floating">
                    <x-jet-input id="middle_name" class="form-control all-caps block w-full" type="text" name="middle_name" :value="old('middle_name')" placeholder="Middle Name" autofocus autocomplete="off" />
                    <x-jet-label for="middle_name" value="{{ __('MIddle Name') }}" class="text-black-50 w-full" />
                </div>
            </div>

            <div class="col-md-1 px-1">
                <div class="form-floating">
                    <x-jet-input id="suffix" name="suffix" type="text" class="form-control all-caps block w-full" wire:model.defer="state.suffix" placeholder="Ext." autocomplete="suffix" />
                    <x-jet-label for="suffix" value="{{ __('Ext.') }}" class="text-black-50 w-full" />
                    <x-jet-input-error for="suffix" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mx-2 my-2">
            <div class="col-md-3 px-1">
                <div class="form-floating">
                    <x-jet-input id="employee_id" class="form-control all-caps block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" placeholder="Emloyee Number" required autofocus autocomplete="off" />
                    <x-jet-label for="employee_id" value="{{ __('Employee Number') }}" class="text-black-50 w-full" />
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-floating">
                    <select name="employment_status" id="employment_status" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value=""></option>
                        @foreach ($request['employment_statuses'] as $key=>$employment_status)
                        <option value="{{ $employment_status->employment_status }}">{{ $employment_status->employment_status }}</option>
                        @endforeach
                    </select>
                    <x-jet-label for="employment_status" value="{{ __('Employment Status') }}" class="text-black-50 w-full" />
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-floating">
                        <x-jet-input id="start_date" name="start_date" class="form-control datepicker block mt-1 w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                        <x-jet-label for="start_date" value="{{ __('Start Date') }}" class="text-black-50 w-full" />
                        <x-jet-input-error for="start_date" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3 px-1">
                  <div class="text-left align-items-center w-full nopadding">
                    <x-jet-label for="weekly_schedule" value="{{ __('Weekly Schedule') }}" class="nopadding"/>
                    <select id="weekly_schedule" name="weekly_schedule[]" multiple class="multi-select w-full" required>
                      <option value="0">Sunday</option>
                      <option value="1" selected>Monday</option>
                      <option value="2" selected>Tuesday</option>
                      <option value="3" selected>Wednesday</option>
                      <option value="4" selected>Thursday</option>
                      <option value="5" selected>Friday</option>
                      <option value="6">Saturday</option>
                    </select>
                  </div>
            </div>

        </div>

        <div class="row mx-2">
            <div class="col-md-5 px-1">
                <div class="form-floating">
                    <x-jet-input id="position" class="form-control all-caps block mt-1 w-full" type="text" name="position" :value="old('position')" placeholder="Position" required autofocus autocomplete="off"/>
                    <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                </div>
            </div>

            @if (count($request['departments'])>0)
            <div class="col-md-3 px-1">
                <div class="form-floating">
                    <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value=""></option>
                        @foreach ($request['departments'] as $key=>$department)
                        <option value="{{ $department->department_code }}">{{ $department->department }}</option>
                        @endforeach
                    </select>
                    <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                </div>
            </div>
            @endif

            @if (count($request['offices'])>0)
            <div class="col-md-4 px-1">
                <div class="form-floating">
                    <select name="office" id="office" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value=""></option>
                        @foreach ($request['offices'] as $key=>$office)
                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                        @endforeach
                    </select>
                    <x-jet-label for="office" value="{{ __('Office') }}" class="text-black-50 w-full" />
                </div>
            </div>
            @endif
        </div>

        <div class="row mx-2 my-2">
            <div class="col-md-3 px-1">
                <div class="form-floating">
                    <select name="gender" id="gender" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value=""></option>
                        @foreach ($request['genders'] as $key=>$gender)
                            <option value="{{ $gender->sex_code }}" >{{ $gender->sex }} </option>
                        @endforeach
                    </select>
                    <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                    <x-jet-input-error for="gender" class="mt-2" />
                </div>
            </div>

            <div class="col-md-5 px-1">
                <div class="form-floating">
                    <x-jet-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="sample@sample.com" required autofocus autocomplete="off"/>
                    <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                </div>
            </div>

            <div class="col-md-4 px-1">
                <div class="form-floating">
                    <select name="role_type" id="role_type" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value=""></option>
                        @foreach ($request['roleTypeUsers'] as $key=>$roleTypeUser)
                            @if (Auth::user()->role_type=='SUPER ADMIN')
                                <option value="{{ $roleTypeUser->role_type }}">{{ $roleTypeUser->role_type }}</option>
                            @else
                                @if ($roleTypeUser->role_type!='SUPER ADMIN')
                                <option value="{{ $roleTypeUser->role_type }}">{{ $roleTypeUser->role_type }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <x-jet-label for="role_type" value="{{ __('Role Type') }}" class="text-black-50 w-full" />
                </div>
            </div>
            {{-- <div class="col-md-4 p-1 form-floating">
                <select name="role_permission" id="role_permission" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                    <option value="">Select Role Permission</option>
                    @foreach ($request['rolesPermissions'] as $key=>$rolesPermission)
                    <option value="{{ $rolesPermission->permissions_name }}">{{ $rolesPermission->permissions_name }}</option>
                    @endforeach
                </select>
                <x-jet-label for="role_permission" value="{{ __('Role Permission') }}" />
            </div> --}}
{{-- 
            <div class="col-md-4 p-1 form-floating">
                <x-jet-input id="password" class="form-control block mt-1 w-full" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div id="popover-password">
                    <p>Password Strength: <span id="result"> </span></p>
                    <div class="progress">
                        <div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        </div>
                    </div>
                    <ul class="list-unstyled">
                        <li class=""><span class="low-case"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; 1 lowercase </li>
                        <li class=""><span class="upper-case"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; 1 uppercase</li>

                        <li class=""><span class="one-number"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span> &nbsp;1 number (0-9)</li>
                        <li class=""><span class="one-special-char"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span> &nbsp;1 Special Character (!@#$%^&*).</li>
                        <li class=""><span class="eight-character"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Atleast 8 Characters</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <ul class="list-unstyled"><br>
                    
                    <li class="passconfirm"></li>
                 </ul>
            </div> --}}
        </div>
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="row mx-2">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

        <div class="row mx-2 mt-4 item-left">
            <div class="col-md-12 px-2 form-floating">
                <x-jet-button id="btnsubmit" class="ml-4">
                    {{ __('Register User') }}
                </x-jet-button>
            </div>
        </div>
        </form>
    </div>
</div>

    <script type="text/javascript">
       $(".multi-select").multiselect({
            numberDisplayed:1
              // Bootstrap 5 compatibility
        });

        // $(document).ready(function() {
        //     $("#btnsubmit").click(function() {
        //         alert("heyyy"); return false;
        //     });
        // });
        // alert($(window).width());
        /*if ($(window).width() <= 460) {
            $("#companyLogo").removeClass('w-33');
        } else {
            $("#companyLogo").addClass('w-33');
        }*/
        /*if(window.matchMedia("(max-width: 767px)").matches){
            // The viewport is less than 768 pixels wide
            $("#companyLogo").addClass('w-33');
        } else{
            // The viewport is at least 768 pixels wide
            $("#companyLogo").removeClass('w-33');
        }*/
    </script>
</x-app-layout>
