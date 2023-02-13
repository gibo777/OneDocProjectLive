<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>
            <div class="drop-shadow">
                <img src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded mx-auto d-block pb-3"/>
                <!-- <x-jet-authentication-card-logo /> -->
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
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-jet-button class="w-full">
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
