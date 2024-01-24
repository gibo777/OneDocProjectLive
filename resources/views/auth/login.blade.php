<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
<x-guest-layout>
<style type="text/css">
    /* Default style for SweetAlert */
    /*.swal2-popup {
      width: 62% !important;
    }*/

    /* Media query for mobile devices */
    @media (max-width: 767px) {
      .swal2-popup {
        width: 100% !important;
      }
    }
    .custom-title-class {
      font-size: 18px; /* Adjust the font size as needed */
    }
    .text-xs {
      font-size: 0.75rem; /* Adjust the font size as needed */
    }
    td {
      text-transform: none !important;
    }
    .swal2-popup {
      height: 100% !important;
    }
</style>

    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>
            <div class="drop-shadow">
                <img src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded mx-auto d-block pb-3"/>
                <!-- <x-jet-authentication-card-logo /> -->
            </div>


        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" id="loginForm" action="{{ route('login') }}">
            @csrf

            <div class="text-left">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="off" />
            </div>

            <div class="mt-4 text-left">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div class="input-group mb-3">
                  <input name="password" type="password" value="" class="input form-control " id="password" placeholder="Password" required="true" aria-label="password" aria-describedby="basic-addon1" autocomplete="current-password"/>
                  <div class="input-group-append hover" id="eye_view">
                    <span class="input-group-text">
                      <i class="fas fa-eye hover" id="show_eye"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                  </div>
                </div>
            </div>

            <!-- <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> -->

            <div class="flex items-center justify-center">
                @if (Route::has('password.request'))

                    <a class="underline text-md text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                   <!--  &nbsp;|&nbsp; 
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('Not yet registered?') }}
                    </a> -->
                @endif
            </div>

            <div class="flex items-center justify-center mt-2">
                <x-jet-button class="w-full" id="btnLogin">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>

            <div class="flex items-center justify-center mt-3">
                <span class="text-sm">Copyright © {{ env('COMPANY_NAME') }}</span>
            </div>


        </form>
    </x-jet-authentication-card>



<audio controls autoplay hidden>
  <!-- <source src="horse.ogg" type="audio/ogg"> -->
  {{-- <source id="audio-background" src="{{ asset('media/videoplayback.mp3') }}" type="audio/mpeg"> --}}
</audio>
<input type="button" id="audio-button" name="" value="button" hidden>
<script type="text/javascript">
    $(document).ready(function(){

        $("#eye_view").on('click', function(e) {
            var x = $("#password");
            var show_eye = $("#show_eye");
            var hide_eye = $("#hide_eye");
            if (x.prop('type') === "password") {
                x.prop('type','text');
                show_eye.addClass("d-none");
                hide_eye.removeClass("d-none");
            } else {
                x.prop('type','password');
                show_eye.removeClass("d-none");
                hide_eye.addClass("d-none");
            }
          // return false;
        });

        $(document).on('click', '#btnLogin', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/login-auth',
                method: 'get',
                data: { 'email': $('#email').val(), 'password': $('#password').val() }, // prefer use serialize method
                success:function(auth){
                    if (auth.isSuccess) {
                        $.ajax({
                            url: '/login-consent',
                            method: 'get',
                            data: { 'email': $('#email').val() }, // prefer use serialize method
                            success:function(count){
                                if (count==0) {
                                    loginConsentForm ($('#email').val(), $('#password').val());
                                } else {
                                    $('#loginForm').submit();
                                }
                            }
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: auth.message });
                    }
                }
            });
            return false;
        });



        function loginConsentForm (email, password) {
            var originalWidth = $('.swal2-popup').css('width');
            var originalHeight = $('.swal2-popup').css('height');
            var loginConsentForm = `@include('auth/login-consent')`;

            Swal.fire({
                title: 'Employee Portal Login Consent',
                customClass: {
                    title: 'custom-title-class',
                },
                html: loginConsentForm,
                width: '62%',
                // icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                allowOutsideClick: false,
                preConfirm: () => {
                    // Check the state of the checkbox
                    if ($('#loginCheckbox').prop('checked')) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/login-consent',
                            method: 'post',
                            data: { 'email': email , 'password': password }, // prefer use serialize method
                            success:function(data){
                                if (data.isSuccess==false) 
                                {
                                    Swal.fire({
                                        title: 'Notification',
                                        icon: 'error',
                                        text: data.message,
                                    }).then((childResult) => {
                                        if (childResult.isConfirmed) {
                                            Swal.close();
                                        }
                                    });
                                } else { $('#loginForm').submit(); }
                            }
                        }); return false;
                        // User confirmed login, proceed with the form submission
                        
                    } else {
                        // User did not confirm login
                        Swal.showValidationMessage('Please confirm your login');
                        return false;
                    }
                }
            }).then((result) => {
                // Handling additional actions after the modal is closed (if needed)
                if (result.dismiss === Swal.DismissReason.cancel) {
                    // User clicked "Cancel" or closed the modal
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Login cancelled',
                        icon: 'info',
                        customClass: {
                            title: 'custom-title-class',
                        },
                        width: originalWidth, // Set the original width
                        height: originalHeight, // Set the original height
                    });
                }
            });
        }
    });
</script>

</x-guest-layout>



