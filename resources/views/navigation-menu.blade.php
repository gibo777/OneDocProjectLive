<style type="text/css">
    .notification {
        padding: 5px 15px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
    }

    .notification .badge {
        position: absolute;
        top: 2px;
        right: 2px;
        padding: 3px 6px;
        border-radius: 50%;
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

    #modalTimeLogCam {
        z-index: 1055 !important;
    }

    /* SweetAlert2 timelog popup */
    .swal-timelog-popup {
        overflow: hidden !important;
        padding: 0 !important;
    }

    /* Full-screen on mobile */
    @media (max-width: 768px) {
        .swal-timelog-popup {
            width: 100vw !important;
            max-width: 100vw !important;
            min-height: 100dvh !important;
            margin: 0 !important;
            border-radius: 0 !important;
            display: flex !important;
            flex-direction: column !important;
        }

        /* Swal2 container also needs to be fullscreen */
        .swal2-container.swal2-center {
            align-items: flex-start !important;
            padding: 0 !important;
        }
    }

    .swal-timelog-popup .swal2-title {
        padding: 6px 16px !important;
        margin: 0 !important;
        background-color: #1a56db;
        width: 100%;
        justify-content: center;
        flex-shrink: 0;
    }

    .swal-timelog-popup .swal2-html-container {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .swal-timelog-popup .swal2-close {
        color: white !important;
        font-size: 1.5rem !important;
    }

    /* Camera container fills available space */
    #logCamera {
        display: block;
        width: 100% !important;
        flex: 1;
    }

    #logCamera video,
    #logCamera canvas,
    #logCamera embed,
    #logCamera object {
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }
</style>


<nav id="nav_header" x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div id="nav_header" class="w-full mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex justify-start items-center py-2 space-x-2">
                <div class="flex justify-center items-center">
                    <img class="h-16 md:h-20 lg:h-24 object-contain"
                        src="{{ asset('/img/company/1doc-logo-100px.jpg') }}" />
                </div>
                <div class="flex justify-center items-center">
                    <img class="h-16 md:h-20 lg:h-24 object-contain"
                        src="{{ asset('/img/company/sappi-logo-90px.jpg') }}" />
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

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 flex-shrink-0">
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
                    {{ __('E-Leave Application') }}
                </div>
                <div class="border-t border-gray-200" hidden>
                    <x-jet-responsive-nav-link href="{{ route('hris.leave.eleave') }}" id="nav_eleave">
                        {{ __('E-Leave Form') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('eforms.leaves-listing') }}" id="nav_view_leaves">
                        {{ __('View Leaves') }}
                    </x-jet-responsive-nav-link>
                </div>
                <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                    {{ __('Overtime Request') }}
                </div>
                <div class="border-t border-gray-200" hidden>
                    <x-jet-responsive-nav-link href="{{ route('hris.overtime') }}" id="nav_overtime">
                        {{ __('Overtime Form') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('eforms.overtime-listing') }}" id="nav_view_overtimes">
                        {{ __('View Overtimes') }}
                    </x-jet-responsive-nav-link>
                </div>

                <div>
                    <a class="view_nav block px-4 py-2 text-xs text-gray-400" href="{{ route('timelogs-listing') }}"
                        id="nav_time_logs">
                        {{ __('Time-logs') }}
                    </a>
                </div>
                @if (Auth::user()->id == 1)
                    <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('Records Management') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('hr.management.employees') }}">
                            {{ __('Employee Management') }}
                        </x-jet-responsive-nav-link>
                    </div>

                    <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('Set-up') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('employee-benefits') }}">
                            {{ __('Leave Credits') }}
                        </x-jet-responsive-nav-link>
                        <x-jet-responsive-nav-link href="{{ route('authorize.user.list') }}">
                            {{ __('User Authorization') }}
                        </x-jet-responsive-nav-link>
                        <x-jet-responsive-nav-link href="{{ route('module.list') }}">
                            {{ __('Module Creation') }}
                        </x-jet-responsive-nav-link>
                        <x-jet-responsive-nav-link href="{{ route('server-status') }}"
                            class="dropdown-item hover font-weight-bold {{ $serverStatus ? 'text-success' : 'text-danger' }}">
                            {{ __('Server Status') }}
                        </x-jet-responsive-nav-link>
                    </div>
                @endif

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

                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Personnel Data') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

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

                        @if (Auth::user()->id == 1)
                            <div class="dropdown dropend">
                                <a class="dropdown-item dropdown-toggle" href="#" id="submenuWFH"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">WFH
                                    Setup</a>
                                <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                    <a class="dropdown-item" href="{{ route('hris.wfhsetup') }}"
                                        id="dNavWFH">{{ __('WFH Form') }} </a>
                                    <a class="dropdown-item" href="{{ route('hris.leave.view-leave') }}"
                                        id="nav_view_wfh">{{ __('View WFH') }} </a>
                                </div>
                            </div>
                        @endif

                    </div>
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
                                @if (Auth::user()->role_type == 'SUPER ADMIN')
                                    <div class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Employee Management </a>
                                        <div class="dropdown-menu margin-left-cust"
                                            aria-labelledby="dropdown-layouts">
                                            <a class="dropdown-item" href="{{ route('register') }}">
                                                {{ __('User Registration') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('hr.management.employees') }}">
                                                {{ __('View Employees') }}
                                            </a>
                                        </div>
                                    </div>
                                @endif

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
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dropdown mt-3 mx-1">
                        <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                            href="{{ route('timelogs-listing') }}" id="nav_home">TIME-LOGS</a>
                    </div>
                @endif

                @if (Auth::user()->role_type == 'SUPER ADMIN' && (Auth::user()->id == 1 || Auth::user()->id == 543))
                    <div class="dropdown mt-3 mx-1">
                        <button
                            class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            {{ __('SET-UP') }}
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
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
                                        {{ __('Leave Credits') }}
                                    </a>
                                    <div class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            User Management </a>
                                        <div class="dropdown-menu margin-left-cust"
                                            aria-labelledby="dropdown-layouts">
                                            <a class="dropdown-item" href="#"> {{ __('User Group') }} </a>
                                            <a class="dropdown-item" href="{{ route('authorize.user.list') }}">
                                                {{ __('User Authorization') }}
                                            </a>
                                        </div>
                                    </div>
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


{{-- Hidden elements still referenced by JS --}}
<div hidden>
    <input id="logEvent">
</div>


<script type="text/javascript" src="{{ asset('/popper/js/bootstrap.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/nav-bar/bootstrap5-dropdown-ml-hack.js') }}"></script>

<!-- NAVIGATOR end -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const navServerStatus = document.getElementById('navServerStatus');
        if (navServerStatus) {
            let isActive = JSON.parse(navServerStatus.getAttribute('data-is-active'));
            console.log(isActive);
        }
    });

    $(document).ready(function() {

        let has_supervisor = "{{ Auth::user()->supervisor }}";
        let role_type = "{{ Auth::user()->role_type }}";

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
         * This will capture temporary photo using webcam (profile photo)
         */
        $("#saveTempPhoto").click(function() {
            var data_uri = $("#capturedPhoto").attr("src");
            Webcam.reset('#logCamera');
            $('#divPhotoPreview1').addClass('hidden');
            $('#divPhotoPreview2').empty();
            $('#divPhotoPreview2').css('display', 'flex');
            $('#divPhotoPreview2').append(
                '<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url(' +
                data_uri + ')"></span>');
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
                    Webcam.reset('#logCamera');
                    $("#divPhotoPreview1").addClass("hidden");
                    $("#divPhotoPreview2").addClass("hidden");
                    $("#divPhotoPreview3").removeClass("hidden");
                    $("#profilePhotoPreview").attr("src", data);
                }
            });
            return false;
        });

    }); // end first $(document).ready


    /* TIME-LOGS CAPTURE */
    $(document).ready(function() {

        let latitude, longitude;

        function getCoordinates(position) {
            latitude = position.coords.latitude.toFixed(7);
            longitude = position.coords.longitude.toFixed(7);
            startWebcam();
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

        // ─── startWebcam ────────────────────────────────────────────────────────────
        // Uses Webcam.js only (no duplicate getUserMedia call).
        // On mobile the preview fills ~90 vw; on desktop it's 460 px wide.
        // ────────────────────────────────────────────────────────────────────────────
        function startWebcam() {

            const isMobile = window.innerWidth <= 768;

            // On mobile: full viewport. On desktop: fixed 520px popup.
            const vw = window.innerWidth;
            const vh = window.innerHeight;
            const camW = isMobile ? vw : 488; // 520 - 32px padding
            const camH = isMobile ?
                vh - 120 // viewport minus title + bottom bar
                :
                Math.floor(camW * 0.75); // 4:3 on desktop

            var logEventLabel = $("#logEvent").val() === 'TimeIn' ? 'Time-In' : 'Time-Out';

            Swal.fire({
                title: '<span style="font-size:1rem;font-weight:bold;color:white;text-transform:uppercase;">Capture Image for ' +
                    logEventLabel + '</span>',
                background: '#ffffff',
                color: '#000',
                width: isMobile ? '100%' : '520px',
                padding: '0',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'swal-timelog-popup',
                    closeButton: 'swal-timelog-close'
                },
                html: `
                    <div style="display:flex; flex-direction:column; height:100%; padding: 0 0 12px 0;">
                        <form id="formWebCam" style="display:flex; flex-direction:column; flex:1;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {{-- Camera preview fills all available vertical space --}}
                            <div style="flex:1; overflow:hidden; background:#000;">
                                <div id="logCamera"
                                     style="width:${camW}px; height:${camH}px; overflow:hidden;">
                                </div>
                            </div>
                            <input type="hidden" name="image" class="image-tag">

                            {{-- Policy notice --}}
                            <div style="margin: 10px 12px 8px; border:1px solid #dee2e6; border-radius:4px; padding:6px 10px; flex-shrink:0;">
                                <p style="font-size:0.82rem; font-weight:bold; font-style:italic; margin:0; text-align:justify;">
                                    In compliance with company policy, ensure that your picture clearly shows your office location.
                                </p>
                            </div>

                            {{-- Snapshot button --}}
                            <div style="display:flex; justify-content:center; flex-shrink:0;">
                                <input type="button" id="takeSnapshot" value="Take Snapshot" class="btn btn-primary">
                            </div>
                        </form>
                    </div>`,

                didOpen: () => {
                    // ── Webcam.js only – no getUserMedia() here ──────────────────
                    Webcam.set({
                        width: camW,
                        height: camH,
                        image_format: 'jpeg',
                        jpeg_quality: 90,
                        flip_horiz: true, // mirror (replaces CSS scaleX(-1))
                        constraints: {
                            video: {
                                // ideal: front cam on mobile, webcam on desktop
                                facingMode: {
                                    ideal: 'user'
                                },
                                width: {
                                    ideal: camW
                                },
                                height: {
                                    ideal: camH
                                }
                            },
                            audio: false
                        }
                    });

                    Webcam.attach('#logCamera');

                    document.getElementById('takeSnapshot').addEventListener('click', function() {
                        captureImage();
                    });
                },

                willClose: () => {
                    // Detach and release camera
                    Webcam.reset('#logCamera');
                }
            }); // end Swal.fire

        } // end startWebcam


        // ─── captureImage ────────────────────────────────────────────────────────────
        // Uses Webcam.snap() – no manual canvas/video drawing needed.
        // ────────────────────────────────────────────────────────────────────────────
        function captureImage() {
            Webcam.snap(function(data_uri) {

                Swal.fire({
                    imageUrl: data_uri,
                    imageAlt: 'Captured Image',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'Retake',
                    confirmButtonText: 'Save',
                }).then(function(result) {

                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('save.timelogs') }}",
                            method: 'post',
                            data: {
                                'logEvent': $("#logEvent").val(),
                                'latitude': parseFloat(latitude),
                                'longitude': parseFloat(longitude),
                                'image': data_uri
                            },
                            beforeSend: function() {
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

                                    // Send Timelog to HRIS via API
                                    $.ajax({
                                        url: `${window.location.origin}/send-timelogs-to-hris`,
                                        method: 'POST',
                                        data: {
                                            'tID': data.tID
                                        },
                                        success: function(apiResponse) {
                                            console.log('API response:',
                                                JSON.stringify(
                                                    apiResponse));
                                        },
                                        error: function(xhr) {
                                            console.error('API error:',
                                                xhr.responseText);
                                        }
                                    });

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
                        }); // end $.ajax

                    }
                    // On cancel/retake – Webcam.js stream is still live, nothing to do

                }); // end .then
            }); // end Webcam.snap
        } // end captureImage


        // ─── Button click handlers ───────────────────────────────────────────────────
        $('#btnTimeIn').click(function() {
            $("#logEvent").val("TimeIn");
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
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getCoordinates, showError);
            } else {
                Swal.fire({
                    html: "Geolocation is not supported by this browser."
                });
                location.reload();
            }
        });

    }); // end TIME-LOGS CAPTURE $(document).ready
</script>
