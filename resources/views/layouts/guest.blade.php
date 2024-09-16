

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

@livewireStyles
<script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>

<script src="{{ asset('/sweetalert/js/sweetalert.js') }}"></script>
<link href="{{ asset('/sweetalert/css/sweetalert.css') }}" rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <link rel="stylesheet" href="{{ asset('/fontawesome-6.2.0/css/all.css') }}">

        <link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css') }}">

        <script type="text/javascript" src="{{ asset('/js/jquery.min-3.6.0.js') }}"></script>

        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
        <script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery.backstretch.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/scripts.js') }}"></script>

        <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

        {{-- BOOTSTRAP --}}
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.css') }}">
        <script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.js') }}"></script>

    </head>
    <body class="bg-gray-100">
        @if(isset($header))
            <header id="module_header" class="bg-white shadow banner-blue font-white-bold hover">
                <!-- <div class="max-w-7xl mx-auto py-2 px-2 sm:px-6 lg:px-8"> -->
                <div class=" mx-auto py-1 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

    </body>
</html>
