<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>
            <div class="drop-shadow">
                <img src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded mx-auto d-block py-2"/>
                <!-- <x-jet-authentication-card-logo /> -->
            </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block border-0 bg-white shadow-none w-full" type="email" name="email" :value="old('email', $request->email)" readonly autofocus />
            </div>

            <div class="mt-2">
                <!-- <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" /> -->


                <x-jet-label for="password" value="{{ __('New Password') }}" />
                <div class="input-group mb-3">
                  <input name="password" type="password" value="" class="input form-control " id="password" placeholder="New Password" required="true" aria-label="password" aria-describedby="basic-addon1" autocomplete="new-password"/>
                  <div class="input-group-append hover" id="eye_view1">
                    <span class="input-group-text">
                      <i class="fas fa-eye hover" id="show_eye1"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye1"></i>
                    </span>
                  </div>
                </div>
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

            <div class="mt-2">
                <!-- <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" /> -->


                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <div class="input-group mb-3">
                  <input name="password_confirmation" type="password" value="" class="input form-control " id="password_confirmation" placeholder="Confirm Password" required="true" aria-label="password" aria-describedby="basic-addon1" autocomplete="current-password"/>
                  <div class="input-group-append hover" id="eye_view2">
                    <span class="input-group-text">
                      <i class="fas fa-eye hover" id="show_eye2"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                    </span>
                  </div>
                </div>
                <ul class="list-unstyled"><br>
                    <li class="passconfirm"></li>
                  </ul>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="w-full">
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>

<script type="text/javascript">
    $(document).ready(function(){

        $("#eye_view1").on('click', function(e) {
            var x = $("#password");
            var show_eye = $("#show_eye1");
            var hide_eye = $("#hide_eye1");
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
        $("#eye_view2").on('click', function(e) {
            var y = $("#password_confirmation");
            var show_eye = $("#show_eye2");
            var hide_eye = $("#hide_eye2");
            if (y.prop('type') === "password") {
                y.prop('type','text');
                show_eye.addClass("d-none");
                hide_eye.removeClass("d-none");
            } else {
                y.prop('type','password');
                show_eye.removeClass("d-none");
                hide_eye.addClass("d-none");
            }
          // return false;
        });

        // $(document).on('keyup keydown hover click mouseenter mouseover', function(){
        // $("#audio-button").click();
        // });
        // $("#audio-button").click(function() {
        // $("#audio-background")[0].play(); return false;
        // });
    });
</script>
<script>
    $(function() {
        /*$('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');*/

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
    $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');

    } else {

    $('.passconfirm').empty();
    $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password matched!');


    }
    });

    });

    $('#password_confirmation').keyup(function() {
    if($('#password_confirmation').text()==""){


    }
        if ($('#password').val() != $('#password_confirmation').val()) {
            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');
        } else {
            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password matched!');
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
</x-guest-layout>
