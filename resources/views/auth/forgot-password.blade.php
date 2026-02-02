<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>
        <div class="flex justify-start items-center py-2 space-x-2">
            <div class="flex justify-center items-center">
                <img class="h-16 md:h-20 lg:h-24 object-contain" src="{{ asset('/img/company/1doc-logo-100px.jpg') }}" />
            </div>
            <div class="flex justify-center items-center">
                <img class="h-16 md:h-20 lg:h-24 object-contain" src="{{ asset('/img/company/sappi-logo-90px.jpg') }}" />
            </div>
            <div class="flex justify-center items-center">
                <img class="h-10 md:h-16 lg:h-20 object-contain"
                    src="{{ asset('/img/company/1food-logo-90px.jpg') }}" />
            </div>
            <div class="flex justify-center items-center">
                <img class="h-12 md:h-16 lg:h-20 object-contain"
                    src="{{ asset('/img/company/eagro-logo-100px.jpg') }}" />
            </div>
        </div>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-jet-button class="w-full">
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
