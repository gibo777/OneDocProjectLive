<style type="text/css">
    .notification {
        /*text-decoration: none;*/
        padding: 5px 15px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
    }

    /*.notification:hover {
      background: lightblue;
    }*/

    .notification .badge {
        position: absolute;
        top: 2px;
        right: 2px;
        padding: 3px 6px;
        border-radius: 50%;
        /*background: blue;*/
        /*color: white;*/
    }

    .my-popup-class {
        animation: none !important;
        transform: none !important;
    }

    .dropdown-hover-all .dropdown-menu,
    .dropdown-hover>.dropdown-menu.dropend {
        margin-left: -1px !important
    }

    .margin-left-cust {
        left: -3 !important;
    }

    .margin-top-cust {
        top: -2 !important;
    }

    #logCamera video {
        transform: scaleX(-1);
    }
</style>


<nav id="nav_header" x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->

    <div id="nav_header" class="w-full mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                {{-- <div class="flex items-center sm:justify-start h-8"> --}}
                <div class="flex items-center sm:justify-start">
                    <img class="img-company-logo" src="{{ asset('/img/company/onedoc-logo.png') }}" />
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex p-6">
                    <h6>Accelerating Our Nation’s Progress Through Information Technology.</h6>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
                </x-jet-nav-link>
                <!-- Add more levels as needed -->
                <div class="relative" x-data="{ open: false }">
                    <x-jet-nav-link @click="open = !open" aria-haspopup="true" :active="request()->routeIs('hris.leave.eleave.*')">
                        {{ __('E-Forms') }}
                    </x-jet-nav-link>

                    <div x-show="open" @click.away="open = false" class="absolute z-10 left-0 mt-2 w-32 bg-white rounded-md shadow-lg">
                        <!-- Second-level menu items -->
                        <x-jet-nav-link href="{{ route('hris.leave.eleave') }}" :active="request()->routeIs('hris.leave.eleave')">
                            {{ __('Leave Form') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('hris.leave.view-leave') }}" :active="request()->routeIs('hris.leave.view-leave')">
                            {{ __('View Leaves') }}
                        </x-jet-nav-link>
                        <!-- Add more second-level menu items as needed -->
                    </div>
                </div>
            </div> --}}

            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                {{-- <div class="notification">
                    <a href="{{ route('hr.management.memos') }}" class="btn btn-outline-primary btn-sm border-0 items-center">
            <span>
                <img class="img-icon" src="{{ asset('img/buttons/favpng_icon.png') }}">
            </span>
            <span id="nav-memo-counter" class="badge badge-primary badge-pill">{{ $notification_count.'3' }}</span>
            </a>
        </div> --}}

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown-clickable align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    {{ join(' ', [Auth::user()->first_name, Auth::user()->middle_name, Auth::user()->last_name]) }}
                                    &nbsp;

                                    @if (Auth::user()->profile_photo_path != null)
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}" />
                                    @else
                                        @if (Auth::user()->gender == 'F')
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ asset('/storage/profile-photos/default-female.png') }}"
                                                alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}" />
                                        @elseif (Auth::user()->gender == 'M')
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ asset('/storage/profile-photos/default-formal-male.png') }}"
                                                alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}" />
                                        @else
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ asset('/storage/profile-photos/default-photo.png') }}"
                                                alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}" />
                                        @endif
                                    @endif
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        @if (Auth::user()->profile_photo_url == null)
                                            {{ join(' ', [Auth::user()->first_name, Auth::user()->last_name]) }}
                                        @endif
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif

                        </x-slot>


                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Personnel Data') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>

                        </x-slot>
                    </x-jet-dropdown-clickable>

                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu begin -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- navigation menu here -->
        </div>

        <!-- Responsive Settings Options for Mobile View -->
        <div class="pt-1 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">

                <!-- E-LEAVE -->
                <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                    {{ __('E-FORMS') }}
                </div>
                <div class="border-t border-gray-200" hidden>
                    <x-jet-responsive-nav-link href="{{ route('hris.leave.eleave') }}" id="nav_eleave">
                        {{ __('E-Leave Form') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('eforms.leaves-listing') }}" id="nav_view_leaves">
                        {{ __('View Leaves') }}
                    </x-jet-responsive-nav-link>
                </div>
                <div>
                    <a class="view_nav block px-4 py-2 text-xs text-gray-400" href="{{ route('timelogs-listing') }}"
                        id="nav_time_logs">
                        {{ __('TIME-LOGS') }}
                    </a>
                </div>

                <div class="mt-3 space-y-1"></div>
                <hr block px-4 py-2 text-gray-400>
            </div>
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Personnel Data') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>


            </div>
        </div>
    </div>
    <!-- Responsive Settings Options end -->


    <!-- Primary Navigation Menu for Desktop View -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between p-1">

            <div class="hidden sm:flex sm:items-center sm:ml-6 dropdown-hover-all">

                <!-- HOME start-->
                <div class="dropdown mt-3 mx-1">
                    <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                        href="{{ route('dashboard') }}" id="nav_home">HOME</a>
                </div>
                <!-- HOME end  -->

                <div class="dropdown mt-3 mx-1">
                    <button
                        class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                        type="button" id="dropdownEForms" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        E-FORMS
                    </button>
                    <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownEForms">
                        <div class="dropdown dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" id="submenuELeaves"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-Leave</a>
                            <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                <a class="dropdown-item" href="{{ route('hris.leave.eleave') }}"
                                    id="dNavEleave">{{ __('E-Leave Form') }} </a>
                                <a class="dropdown-item" href="{{ route('eforms.leaves-listing') }}"
                                    id="nav_view_leaves">{{ __('View Leaves') }} </a>
                                <a class="dropdown-item" href="{{ route('calendar') }}"
                                    id="nav_leaves_calendar">{{ __('Leaves Calendar') }} </a>
                            </div>
                        </div>
                        @if (Auth::user()->id == 1)
                            <div class="dropdown dropend">
                                <a class="dropdown-item dropdown-toggle" href="#" id="submenuOvertimes"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Overtime</a>
                                <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                    <a class="dropdown-item" href="{{ route('hris.overtime') }}"
                                        id="dNavOvertime">{{ __('Overtime Form') }} </a>
                                    <a class="dropdown-item" href="{{ route('eforms.overtime-listing') }}"
                                        id="nav_view_leaves">{{ __('View Overtimes') }} </a>
                                </div>
                            </div>
                        @endif

                        {{-- @if (Auth::user()->id == 1)
                                <div class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="submenuWFH" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">WFH Setup</a>
                                    <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('hris.overtime') }}" id="dNavWFH" >{{ __('WFH Form') }} </a>
                        <a class="dropdown-item" href="{{ route('hris.leave.view-leave') }}" id="nav_view_wfh">{{ __('View WFH') }} </a>
                    </div>
                </div>

                <div class="dropdown dropend">
                    <a class="dropdown-item dropdown-toggle" href="#" id="submenuReimbursement" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reimbursement</a>
                    @if (Auth::user()->id == 1)
                    <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                        <a class="dropdown-item" href="{{ route('hris.reimbursement.reimbursement') }}">Reimbursement Form</a>
                    </div>
                    @endif
                </div>
                @endif --}}

                    </div>
                    {{-- @if ($notification_count > 0)
                        <span id="nav-memo-counter" class="badge badge-primary badge-pill">{{ $notification_count }}</span>
            @endif --}}
                </div>

                @if (Auth::user()->role_type == 'ADMIN' || Auth::user()->role_type == 'SUPER ADMIN')
                    @if (str_contains(Auth::user()->department, 'ACCTG') == 1)
                        <div class="dropdown mt-3 mx-1">
                            <button
                                class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                                type="button" id="dropdownProcess" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                PROCESS
                            </button>
                            <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownProcess">
                                <div class="dropdown dropend">
                                    <a class="dropdown-item" href="{{ route('process.eleave') }}">Process e-Leave</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="dropdown mt-3 mx-1">
                        <button
                            class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            RECORDS MANAGEMENT
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
                                {{-- <a class="dropdown-item" href="{{ route('hr.management.employees') }}" >
                    {{ __('View Employees') }}
                    </a> --}}
                                <div class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Employee Management </a>
                                    <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('register') }}">
                                            {{ __('User Registration') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('hr.management.employees') }}">
                                            {{ __('View Employees') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Time Keeping </a>
                                    <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('timelogs-listing') }}">Time Logs</a>
                                        <a class="dropdown-item"
                                            href="{{ route('attendance-monitoring') }}">Attendance Monitoring</a>
                                    </div>
                                </div>
                                @if (Auth::user()->id == 1 || Auth::user()->id == 2)
                                    {{-- <div class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Employee Clearance </a>
                                    <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('clearance.form') }}" >
                    {{ __('Employee Clearance Form') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('hr.management.employees') }}">
                        {{ __('View Clearances') }}
                    </a>
                </div>
            </div> --}}
                                @endif
                                {{-- <a class="dropdown-item" href="{{ route('hr.management.memos') }}">
            {{ __('Memo') }}
            </a> --}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dropdown mt-3 mx-1">
                        <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                            href="{{ route('timelogs-listing') }}" id="nav_home">TIME-LOGS</a>
                    </div>
                @endif



                @if (Auth::user()->role_type == 'SUPER ADMIN')

                    <div class="dropdown mt-3 mx-1">
                        <button
                            class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            {{ __('SET-UP') }}
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
                                {{-- <a class="dropdown-item" href="{{ route('register') }}" >
                {{ __('User Registration') }}
                </a> --}}
                                <a class="dropdown-item" href="{{ route('hr.management.offices') }}">
                                    {{ __('Offices') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('hr.management.departments') }}">
                                    {{ __('Departments') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('hr.management.holidays') }}">
                                    {{ __('Holidays') }}
                                </a>
                                @if (Auth::user()->id == 1)
                                    <a class="dropdown-item" href="{{ route('employee-benefits') }}">
                                        {{ __('Benefits') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('authorize.user.list') }}">
                                        {{ __('Authorize User') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('module.list') }}">
                                        {{ __('Module Creation') }}
                                    </a>
                                    <a id="navServerStatus" href="{{ route('server-status') }}"
                                        class="dropdown-item hover font-weight-bold {{ $serverStatus ? 'text-success' : 'text-danger' }}">
                                        {{ __('Server Status') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                @endif

            </div>

            <div class="items-center justify-center">

                @if ($timeIn)
                    <x-jet-button type="button" disabled>
                        <i class="fa-regular fa-clock"></i>&nbsp;Time-In
                    </x-jet-button>
                @else
                    <x-jet-button type="button" id="btnTimeIn" name="btnTimeIn">
                        <i class="fa-regular fa-clock"></i>&nbsp;Time-In
                    </x-jet-button>
                @endif

                @if ($timeOut)
                    <x-jet-button type="button" disabled>
                        <i class="fa-solid fa-clock"></i>&nbsp;Time-Out
                    </x-jet-button>
                @else
                    <x-jet-button type="button" id="btnTimeOut" name="btnTimeOut">
                        <i class="fa-solid fa-clock"></i>&nbsp;Time-Out
                    </x-jet-button>
                @endif

            </div>
        </div>
    </div>
</nav>



<div class="modal fade" id="modalTimeLogCam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header banner-blue">
                <h4 class="modal-title text-lg text-white">Capture Image for Timelog</h4>
                <button id="closeLogCamModal" type="button" class="close btn btn-primary fa fa-close"
                    data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <!-- content -->
                <div class="container">
                    <form id="formWebCam">
                        @csrf

                        <div id="image-capture-container">
                            <video id="video-element" hidden></video>
                            <canvas id="canvas-element" hidden></canvas>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div id="logCamera"></div>
                                <input type="hidden" name="image" class="image-tag text-center rounded-md">
                            </div>
                            <div class="col-md-6 text-center">
                                <div id="results" class="hidden rounded-md"></div>
                            </div>
                        </div>
                        <div class="row my-1">
                            <div
                                class="col-md-8 text-justify text-sm font-weight-bold font-italic text-wrap w-100 inset-shadow px-2 my-1">
                                &nbsp;&nbsp;In compliance with company policy, ensure that your picture clearly shows
                                your office location.
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <input id="logEvent" hidden>
                                <input type="button" id="takeSnapshot" value="Take Snapshot"
                                    class="btn btn-primary ">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('/popper/js/bootstrap.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/nav-bar/bootstrap5-dropdown-ml-hack.js') }}"></script>

<!-- NAVIGATOR end -->
<script type="text/javascript">
    // scripts.js
    document.addEventListener('DOMContentLoaded', function() {
        let isActive = JSON.parse(document.getElementById('navServerStatus').getAttribute('data-is-active'));
        console.log(isActive); // Logs the current value of isActive
    });

    $(document).ready(function() {

        let has_supervisor = "{{ Auth::user()->supervisor }}";
        let role_type = "{{ Auth::user()->role_type }}";

        /*Pusher.logToConsole = true;
        var pusher = new Pusher('264cb3116052cba73db3', {
        cluster: 'us2',
        forceTLS: true
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind("my-event", function(data) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('counts_pusher') }}",
            method: 'get',
            data: JSON.stringify(data), // prefer use serialize method
            success:function(data){
                $("#nav-memo-counter").text(data.memo_counts);
            }
        });
        }); */


        $(document).on('click', '#dNavEleave, #dNavOvertime', function(e) {
            if (has_supervisor == '' || has_supervisor == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'NOTIFICATION',
                    html: 'Kindly ask HR for the supervisor to be assigned. <br>Thank you!',
                });
                return false;
            }
        });

        /**
         * This will capture temporary photo using webcam
         */
        $("#saveTempPhoto").click(function() {

            Swal.fire({
                html: JSON.stringify($("#formWebCam").serialize())
            });
            return false;

            var data_uri = $("#capturedPhoto").attr("src");
            Webcam.reset('#logCamera');

            $('#divPhotoPreview1').addClass('hidden');
            $('#divPhotoPreview2').empty();
            $('#divPhotoPreview2').css('display', 'flex');
            $('#divPhotoPreview2').append(
                '<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url(' +
                data_uri + ')"></span>');
            // alert("{{ route('webcam.capture') }}"); return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('webcam.capture') }}",
                method: 'post',
                data: $("#formWebCam").serialize(),
                success: function(data) {
                    $("#modalWebCam").modal("hide");
                    // alert(data); return false;
                    Webcam.reset('#logCamera');
                    $("#divPhotoPreview1").addClass("hidden");
                    $("#divPhotoPreview2").addClass("hidden");
                    $("#divPhotoPreview3").removeClass("hidden");
                    $("#profilePhotoPreview").attr("src", data);

                    // $("#modalWebCam").modal("show");

                }
            });
            return false;
        });
    });


    /* TIME-LOGS CAPTURE */
    $(document).ready(function() {
        // Variables for video element, canvas, and media stream
        var video = document.getElementById('video-element');
        var canvas = document.getElementById('canvas-element');
        var stream = null;
        let latitude, longitude;

        function getCoordinates(position) {
            latitude = position.coords.latitude.toFixed(7);
            longitude = position.coords.longitude.toFixed(7);

            // var coords = position.coords.latitude.toFixed(7)+','+position.coords.longitude.toFixed(7);
            // var googleMapsUrl = `https://www.google.com/maps?q=${position.coords.latitude.toFixed(7)},${position.coords.longitude.toFixed(7)}`;
            /*Swal.fire({
            html: `<a id="mapsLink" href="#">${coords}</a>`,
            didOpen: () => {
                document.getElementById('mapsLink').addEventListener('click', () => {
                window.open(googleMapsUrl, '_blank');
                Swal.close(); // Optionally close the modal after opening the link
                });
            }
            });*/

            // Start the webcam when the page loads
            startWebcam();
            // $("#modalTimeLogCam").modal("show")

        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    Swal.fire({
                        html: "User denied the request for Geolocation."
                    });
                    break;
                case error.POSITION_UNAVAILABLE:
                    Swal.fire({
                        html: "Location information is unavailable."
                    });
                    break;
                case error.TIMEOUT:
                    Swal.fire({
                        html: "The request to get user location timed out."
                    });
                    break;
                case error.UNKNOWN_ERROR:
                    Swal.fire({
                        html: "An unknown error occurred."
                    });
                    break;
            }
            return false;
        }

        // Event handler for the capture button
        /*$('#btnTimeIn').click(function() {
            $("#logEvent").val("TimeIn");
            startWebcam();
            // if (navigator.geolocation) {
            //   navigator.geolocation.getCurrentPosition(getCoordinates, showError);
            // }
            // else {
            //   Swal.fire({ html: "Geolocation is not supported by this browser." }); return false;
            // }

        });*/

        // Function to start the webcam
        function startWebcam() {
            /*var googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
            Swal.fire({
                html: `<a id="mapsLink" href="#">${latitude},${longitude}</a>`,
                didOpen: () => {
                    document.getElementById('mapsLink').addEventListener('click', () => {
                    window.open(googleMapsUrl, '_blank');
                    });
                }
            }); return false;*/

            $("#modalTimeLogCam").modal("show");

            const isMobile = window.innerWidth <= 768;
            const webcamWidth = isMobile ? 320 : 430;
            const webcamHeight = isMobile ? 240 : 350;

            Webcam.set({
                width: webcamWidth,
                height: webcamHeight,
                image_format: 'jpeg',
                jpeg_quality: 90,
                constraints: {
                    video: {
                        facingMode: "user",
                        mirror: true
                    }
                }
            });

            Webcam.attach('#logCamera');

            // Access the user's webcam
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(mediaStream) {
                    // Store the media stream for later use
                    stream = mediaStream;
                    video.srcObject = mediaStream;
                    video.play();
                })
                .catch(function(error) {
                    // Display an error message using Swal
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to access webcam!',
                    });
                });
        }

        // Function to capture an image
        function captureImage() {

            if (stream !== null) {
                // Pause the video playback
                video.pause();

                // Assuming 'video' is the video element and 'canvas' is the canvas element
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');

                // Set the desired percentage for the resized image
                var percentageWidth = 50; // Adjust this value as needed
                var percentageHeight = 50; // Adjust this value as needed

                // Calculate the target dimensions based on the percentages
                var targetWidth = (percentageWidth / 100) * video.videoWidth;
                var targetHeight = (percentageHeight / 100) * video.videoHeight;

                // Set the canvas dimensions to the target dimensions
                canvas.width = targetWidth;
                canvas.height = targetHeight;

                // Mirror the canvas horizontally
                context.translate(targetWidth, 0);
                context.scale(-1, 1);

                // Draw the current video frame onto the canvas with the resized dimensions
                context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, targetWidth,
                    targetHeight);

                // Convert the canvas image to a data URL with a desired quality (e.g., 0.8)
                var dataURL = canvas.toDataURL('image/jpeg', 0.8);
                Swal.fire({
                    // title: 'Captured Image',
                    imageUrl: dataURL,
                    imageAlt: 'Captured Image',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    confirmButtonText: 'Save',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $("#modalTimeLogCam").modal("hide");
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('save.timelogs') }}",
                            method: 'post',
                            data: {
                                'logEvent': $("#logEvent").val(),
                                'latitude': parseFloat(latitude),
                                'longitude': parseFloat(longitude),
                                'image': dataURL
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    html: parseFloat(latitude) + ', ' + parseFloat(
                                        longitude),
                                });
                                return false;
                                $('#dataProcess').css({
                                    'display': 'flex',
                                    'position': 'fixed',
                                    'top': '50%',
                                    'left': '50%',
                                    'transform': 'translate(-50%, -50%)'
                                });

                            },
                            success: function(data) {
                                $('#dataProcess').hide();
                                if (data.isSuccess == true) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Image saved successfully!',
                                    });
                                    video.currentTime = 0;
                                    video.style.display = "none";
                                    setTimeout(function() {
                                        location.reload();
                                    }, 5000);

                                    $("#btnTimeIn").prop('disabled', true);
                                    $("#btnTimeOut").prop('disabled', false);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: data.message,
                                    });
                                }
                            }
                        });


                    } else {
                        // Resume video playback
                        video.play();
                    }
                });
            }
        }


        $('#btnTimeIn').click(function() {
            $("#logEvent").val("TimeIn");
            // startWebcam();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getCoordinates, showError);
            } else {
                Swal.fire({
                    html: "Geolocation is not supported by this browser."
                });
                return false;
            }

        });


        $('#btnTimeOut').click(function() {
            $("#logEvent").val("TimeOut");
            // startWebcam();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getCoordinates, showError);
            } else {
                Swal.fire({
                    html: "Geolocation is not supported by this browser."
                });
                location.reload();
            }

            // $("#modalTimeLogCam").modal("show");
            // $("#logEvent").val("TimeOut");

            // const isMobile = window.innerWidth <= 768;
            // const webcamWidth = isMobile ? 320 : 430;
            // const webcamHeight = isMobile ? 240 : 350;

            // Webcam.set({
            //     width: webcamWidth,
            //     height: webcamHeight,
            //     image_format: 'jpeg',
            //     jpeg_quality: 90,
            //     constraints: {
            //         video: {
            //             facingMode: "user",
            //             mirror: true
            //         }
            //     }
            // });

            // Webcam.attach( '#logCamera' );

            // // Start the webcam when the page loads
            // startWebcam();
            // // $("#modalTimeLogCam").modal("show");

        });

        // Capture image for Time Logs
        $('#takeSnapshot').click(function() {

            // if (navigator.geolocation) {
            //   navigator.geolocation.getCurrentPosition(getCoordinates, showError);;
            // }
            // else {
            //   Swal.fire({ html: "Geolocation is not supported by this browser." }); return false;
            // }
            captureImage();
        });

        // Closing Camera Modal
        $("#closeLogCamModal").click(function() {
            closeCam();
        });

        function closeCam() {
            Webcam.reset('#logCamera');
            location.reload();
        }

    });
</script>
