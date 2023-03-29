<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-guest-layout>
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
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="off" />
            </div>

            <div class="mt-4">
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
                <x-jet-button class="w-full">
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

        $(document).on('keyup keydown hover click mouseenter mouseover', function(){
        $("#audio-button").click();
        });
        $("#audio-button").click(function() {
        $("#audio-background")[0].play(); return false;
        });
    });
</script>

</x-guest-layout>



