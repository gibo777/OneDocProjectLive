<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-guest-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> -->
        <h2 class="font-semibold text-xl leading-tight text-center pt-1">
            {{ __('PASSWORD CREATION') }}
        </h2>
    </x-slot>

        <!-- <x-jet-validation-errors class="mb-1" /> -->
    
    @if($isForbidden)
        <div class="max-w-6xl mx-auto py-2 sm:px-6 lg:px-8">
            The current user does not have rights to access this link.
        </div>
    @else
        @if($isExpired)
        <div class="max-w-6xl mx-auto py-2 sm:px-6 lg:px-8">
            Link Expired
        </div>
        @else
        <div class="w-full mx-auto py-2 sm:max-w-md lg:px-8">
            <form method="POST" action="{{ route('verification.verify') }}">
                @csrf

            <div class="px-4 py-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
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
                {{-- <div class="row mb-3 m-0 p-0">
                    <div class="col-md-12 items-left justify-center pt-2 banner-blue">
                        <h5 class="font-weight-bold">{{ __('USER REGISTRATION') }}</h5>
                    </div>
                </div> --}}

                <div class="max-w-6xl mx-auto mt-1">
                {{-- <div class="row">

                    <div class="col-md-4 p-1 form-floating">
                        <x-jet-input id="first_name" class="form-control block w-full" type="text" name="first_name" :value="old('first_name')" placeholder="First Name" required autofocus autocomplete="off" />
                        <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                    </div>

                    <div class="col-md-4 p-1 form-floating">
                        <x-jet-input id="middle_name" class="form-control block w-full" type="text" name="middle_name" :value="old('middle_name')" placeholder="Middle Name" autofocus autocomplete="off" />
                        <x-jet-label for="middle_name" value="{{ __('MIddle Name') }}" />
                    </div>

                    <div class="col-md-4 p-1 form-floating">
                        <x-jet-input id="last_name" class="form-control block w-full" type="text" name="last_name" :value="old('last_name')" placeholder="Last Name" required autofocus autocomplete="off" />
                        <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
                    </div>
                </div> --}}
                {{-- <div class="row mt-3">
                    <div class="col-md-4 p-1 form-floating">
                        <x-jet-input id="employee_id" class="form-control block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" placeholder="Emloyee Number" required autofocus autocomplete="off" />
                        <x-jet-label for="employee_id" value="{{ __('Employee Number') }}" />
                    </div>

                    <div class="col-md-4 p-1 form-floating">
                        <x-jet-input id="position" class="form-control block mt-1 w-full" type="text" name="position" :value="old('position')" placeholder="Position" required autofocus autocomplete="off"/>
                        <x-jet-label for="position" value="{{ __('Position') }}" />
                    </div>

                    @if (count($request['departments'])>0)
                    <div class="col-md-4 p-1 form-floating">
                        <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">Select Department</option>
                            @foreach ($request['departments'] as $key=>$department)
                            <option value="{{ $department->department_code }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                        <x-jet-label for="department" value="{{ __('Department') }}" />
                    </div>
                    @endif
                </div> --}}
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 p-1 form-floating">
                        <x-jet-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="$_GET['email']" placeholder="Email" required autofocus autocomplete="off" readonly/>
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 p-1 form-floating">
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
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <ul class="list-unstyled"><br>
                            
                            <li class="passconfirm"></li>
                        </ul>
                    </div>
                </div>
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
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

                    <div class="flex items-center justify-center mt-2">
                        <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a> -->

                        <x-jet-button id="btnsubmit" class="ml-4">
                            {{ __('Create Password') }}
                        </x-jet-button>
                    </div>
                    <input style="display:none" value="{{$_GET['token']}}" name="remember_token">
                </form>
            </div>
        @endif
    @endif
    







    <script>
        $(function() {
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

            // $('#btnsubmit').attr('disabled','disabled');
            var checkfn=$('#first_name').val();
            let checkln=$('#last_name').val();
            let checkmn=$('#middle_name').val();
            let checkempnum=$('#employee_id').val();
            let checkpos=$('#position').val();
            let checkdept=$('#department').val();
            let checkemail=$('#email').val();
            let checkpass=$('#password').val();
            let checkconfpass=$('#password_confirmation').val();

            // $('#btnsubmit').attr('disabled','disabled');
            // if(checkfn!=""&&checkln!=""&&checkmn!=""&&checkempnum!=""&&checkpos!=""&&checkdept!=""&&checkemail!=""&&checkpass=="Very Strong"&&checkconfpass=="  Password is a match "){
            //     $('#btnsubmit').RemoveAttr('disabled');
            // }

            $('#password').keyup(function() {
        var password = $('#password').val();
        if (checkStrength(password) == false) {
            $('#sign-up').attr('disabled', true);
        }

            if($('#password_confirmation').text()==""){
            $('.passconfirm').empty();

            }
            if ($('#password').val() != $('#password_confirmation').val()) {

            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

            } else {

                $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password is a match ');


            }
                    });

            });

            $('#password_confirmation').keyup(function() {
                    if($('#password_confirmation').text()==""){


            }
                        if ($('#password').val() != $('#password_confirmation').val()) {

                        $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

                        } else {

                            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password is a match ');


                        }
                    });
            function checkStrength(password) {
                        var strength = 0;


                        //If password contains both lower and uppercase characters, increase strength value.
                        if (password.match(/([a-z])/)) {
                            strength += 1;
                            $('.low-case').addClass('text-success');
                            $('.low-case i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
                            $('#popover-password-top').addClass('hide');


                        } else {
                            $('.low-case').removeClass('text-success');

                            $('.low-case i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
                            $('#popover-password-top').removeClass('hide');
                        }
                        if (password.match(/([A-Z])/)) {
                            strength += 1;
                            $('.upper-case').addClass('text-success');
                            $('.upper-case i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
                            $('#popover-password-top').addClass('hide');


                        } else {
                            $('.upper-case').removeClass('text-success');

                            $('.upper-case i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
                            $('#popover-password-top').removeClass('hide');
                        }

                        //If it has numbers and characters, increase strength value.
            if ( password.match(/([0-9])/)) {
                strength += 1;
                $('.one-number').addClass('text-success');
                $('.one-number i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.one-number').removeClass('text-success');
                $('.one-number i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
                $('#popover-password-top').removeClass('hide');
            }

            //If it has one special character, increase strength value.
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                strength += 1;
                $('.one-special-char').addClass('text-success');
                $('.one-special-char i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.one-special-char').removeClass('text-success');
                $('.one-special-char i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
                $('#popover-password-top').removeClass('hide');
            }

            if (password.length > 7) {
                strength += 1;
                $('.eight-character').addClass('text-success');
                $('.eight-character i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.eight-character').removeClass('text-success');
                $('.eight-character i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
                $('#popover-password-top').removeClass('hide');
            }
            if($('#password').val()==""){
                $('#password-strength').removeAttr('width');

            }



            // If value is less than 2
            // if(strength ==0){
            //     $('#result').removeClass()
            //     $('#password-strength').addClass('progress-bar-danger');

            //     $('#result').addClass('text-danger').text('Very Week');
            //     $('#password-strength').css('width', '0%');
            // }
            if (strength ==1) {
                $('#result').removeClass();
                $('#password-strength').addClass('progress-bar-danger');

                $('#result').addClass('text-danger').text('Poor');
                $('#password-strength').css('width', '20%');
                $('#password-strength').css('background-color', 'red');

            }
            else if(strength ==0){
                $('#result').removeClass()
                // $('#password-strength').addClass('progress-bar-danger');

                $('#result').addClass('text-danger').text('');
                $('#password-strength').css('width', '0%');
            } else if (strength == 2) {
                $('#result').addClass('good');
                $('#password-strength').removeClass('progress-bar-danger');
                $('#password-strength').addClass('progress-bar-warning');
                $('#result').addClass('text-danger').text('Weak')
                $('#password-strength').css('width', '40%');
                $('#password-strength').css('background-color', 'red');
                return 'Weak'
            }
            else if (strength == 3) {
                $('#result').addClass('good');
                $('#password-strength').removeClass('progress-bar-danger');
                $('#password-strength').addClass('progress-bar-warning');
                $('#result').addClass('text-success').text('Good');
                $('#password-strength').css('width', '60%');
                $('#password-strength').css('background-color', 'green');
                return 'Week'
            } else if (strength == 4) {
                $('#result').removeClass()
                $('#result').addClass('strong');
                $('#password-strength').removeClass('progress-bar-warning');
                $('#password-strength').addClass('progress-bar-success');
                $('#result').addClass('text-success').text('Strong');
                $('#password-strength').css('width', '80%');
                $('#password-strength').css('background-color', 'green');
                return 'Strong'
            }
            else if (strength == 5) {
                $('#result').removeClass()
                $('#result').addClass('strong');
                $('#password-strength').removeClass('progress-bar-warning');
                $('#password-strength').addClass('progress-bar-success');
                $('#result').addClass('text-success').text('Very Strong');
                $('#password-strength').css('width', '100%');
                $('#password-strength').css('color', 'green');
                return 'Strong'
            }

        }
    </script>

    <script type="text/javascript">
        // alert($(window).width());
        if ($(window).width() <= 460) {
            $("#companyLogo").removeClass('w-33');
        } else {
            $("#companyLogo").addClass('w-33');
        }
        /*if(window.matchMedia("(max-width: 767px)").matches){
            // The viewport is less than 768 pixels wide
            $("#companyLogo").addClass('w-33');
        } else{
            // The viewport is at least 768 pixels wide
            $("#companyLogo").removeClass('w-33');
        }*/
    </script>
</x-guest-layout>
