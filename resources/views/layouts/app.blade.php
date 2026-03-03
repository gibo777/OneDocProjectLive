<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" /> -->

    <title>{{ config('app.name', 'One Document Corporation') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->

    {{-- Modals / SweetAlert --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('/sweetalert/js/sweetalert.js') }}"></script>
    <link href="{{ asset('/sweetalert/css/sweetalert.css') }}" rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="{{ asset('js/interact.io.js') }}"></script>


    <!-- font awesome  -->
    <link rel="stylesheet" href="{{ asset('/fontawesome-6.2.0/css/all.css') }}">

    <link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css') }}">

    <script type="text/javascript" src="{{ asset('/js/jquery.min-3.6.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>


    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.css') }}">
    <script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.js') }}"></script>


    {{-- MULTIPLE SELECT --}}
    <link rel="stylesheet" href="{{ asset('/multiple-select/css/style.css') }}">
    <script src="{{ asset('/multiple-select/js/popper.js') }}"></script>
    <script src="{{ asset('/multiple-select/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/multiple-select/js/bootstrap-multiselect.js') }}"></script>


    {{-- JQUERY UI --}}
    <script type="text/javascript" src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js') }}"></script>
    <!-- TABLE WITH PAGINATION end -->

    {{-- <script type="text/javascript" src="{{ asset('/js/datetimepicker.js') }}"></script> --}}


    {{-- OTHER PLUGINS --}}
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/js/pusher.min.js') }}"></script>


    {{-- DATA TABLES PLUGIN --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>

    {{-- MAIN CSS/JS --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script type="text/javascript" src="{{ asset('/js/main.js') }}"></script>

    {{-- WEBCAM --}}
    <script src="{{ asset('js/webcam.js') }}"></script>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    {{-- END --}}
</head>


<body class="font-sans antialiased">
    <x-jet-banner />
    <div class="min-h-screen bg-gray-100" id="module_content">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header id="module_header" class="bg-white shadow banner-blue font-white-bold">
                <!-- <div class="max-w-7xl mx-auto py-2 px-2 sm:px-6 lg:px-8"> -->
                <div class="mx-auto px-4 sm:px-6 lg:px-8 text-xl py-1 fw-bold">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="overflow-auto max-h-[500px]">
                {{ $slot }}
            </div>
        </main>
    </div>
    {{-- @endif --}}

    <!-- Loading Indicator -->
    <div id="dataLoad" style="display: none">
        <img src="{{ asset('/img/misc/loading-blue-circle.gif') }}">
    </div>

    <div id="dataProcess" style="display: none">
        <img src="{{ asset('/img/misc/processing.gif') }}">
    </div>

    @stack('modals')

    @livewireScripts


    <script>
        document.addEventListener('livewire:load', function() {

            let sessionLifetimeMinutes = {{ config('session.lifetime') }};
            let timeoutMilliseconds = sessionLifetimeMinutes * 60 * 1000;
            let logoutTimer;

            function startLogoutTimer() {
                clearTimeout(logoutTimer);

                logoutTimer = setTimeout(function() {

                    // Reload current page instead of forcing login route
                    window.location.reload();

                }, timeoutMilliseconds);
            }

            function resetTimer() {
                startLogoutTimer();
            }

            document.addEventListener('click', resetTimer);
            document.addEventListener('keypress', resetTimer);
            document.addEventListener('mousemove', resetTimer);
            document.addEventListener('scroll', resetTimer);

            startLogoutTimer();

        });
    </script>

</body>
