
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
</style>




<nav id="nav_header" x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->

    <div id="nav_header" class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
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
                </div> --}}
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 mt-3">
                {{-- <div class="notification">
                    <a href="{{ route('hr.management.memos') }}" class="btn btn-outline-primary btn-sm border-0 items-center">
                      <span>
                      <img class="img-icon" src="{{ asset('img/buttons/favpng_icon.png') }}">
                      </span>
                      <span id="nav-memo-counter" class="badge badge-primary badge-pill">{{ $notification_count }}</span>
                    </a>
                </div> --}}
                
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown-clickable align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    {{ join(' ',[Auth::user()->first_name, Auth::user()->middle_name, Auth::user()->last_name]) }} &nbsp;

                                    @if(Auth::user()->profile_photo_path!=NULL)
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                    @else
                                        @if (Auth::user()->gender=='F') 
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('/storage/profile-photos/default-female.png')  }}"  alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                        @elseif (Auth::user()->gender=='M') 
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('/storage/profile-photos/default-formal-male.png')  }}"  alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                        @else 
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('/storage/profile-photos/default-photo.png')  }}"  alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                        @endif
                                    @endif
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        @if(Auth::user()->profile_photo_url==NULL)
                                            {{ join(' ',[Auth::user()->first_name,Auth::user()->last_name]) }}
                                        @endif
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>

                        </x-slot>
                    </x-jet-dropdown-clickable>

                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu begin -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- navigation menu here -->
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-1 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">

                    <!-- E-LEAVE -->
                    <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('E-LEAVE APPLICATION') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('hris.leave.eleave') }}"  id="nav_eleave">
                            {{ __('e-Leave Form') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('hris.leave.view-leave') }}"  id="nav_view_leaves">
                            {{ __('View Leaves') }}
                        </x-jet-responsive-nav-link>

                        <!-- <x-jet-responsive-nav-link href="{{ route('calendar') }}"  id="nav_leaves_calendar">
                            {{ __('Leaves Calendar') }}
                        </x-jet-responsive-nav-link> -->
                    </div>

                    {{-- <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('PROCESS') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('process.eleave') }}">
                                {{ __('Process e-Leave Applications') }}
                        </x-jet-responsive-nav-link>
                    </div> --}}

                    <!-- <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('REPORTS') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="#">
                                {{ __('E-Leave Report') }}
                        </x-jet-responsive-nav-link>
                    </div> -->

                    {{-- <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        {{ __('HR MANAGAMENT') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('hr.management.employees') }}">
                            {{ __('View Employees') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('hr.management.offices') }}">
                            {{ __('Offices') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('hr.management.departments') }}">
                            {{ __('Departments') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('hr.management.holidays') }}">
                            {{ __('Holidays') }}
                        </x-jet-responsive-nav-link>
                    </div> --}}

                    <div class="mt-3 space-y-1"></div>
                <hr block px-4 py-2 text-gray-400>
            </div>
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
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

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>


            </div>
        </div>
    </div>
    <!-- Responsive Settings Options end -->


    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between p-1">

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- HOME start-->
                <div class="ml-3 relative inline-flex rounded-md">
                    
                            <x-jet-dropdown-link href="{{ route('dashboard') }}"   class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" id="nav_home">
                                {{ __('HOME') }}
                            </x-jet-dropdown-link>

                            <div class="border-t border-gray-100"></div>
                </div>
                <!-- HOME end  -->
                
                <!-- E-LEAVE MENU start-->
                <div class="ml-3 relative">

                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <!-- <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition hover"> -->
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('E-LEAVE APPLICATION') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            {{-- <x-jet-dropdown-link href="{{ route('hris.leave.eleave') }}"  id="nav_eleave"> --}}
                            <x-jet-dropdown-link href="{{ route('hris.leave.eleave') }}" id="d_nav_eleave" >
                                {{ __('e-Leave Form') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('hris.leave.view-leave') }}"  id="nav_view_leaves">
                                {{ __('View Leaves') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('calendar') }}"  id="nav_leaves_calendar">
                                {{ __('Leaves Calendar') }}
                            </x-jet-dropdown-link>

                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <!-- E-LEAVE MENU end  -->
                
                @if (Auth::user()->department == '1D-HR')
                <!-- PROCESS start-->
                <div class="ml-3 relative">

                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('PROCESS') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <!-- <?php echo route('hris.leave.eleave'); ?> -->
                            <x-jet-dropdown-link href="{{ route('process.eleave') }}">
                                {{ __('Process e-Leave Applications') }}
                            </x-jet-dropdown-link>

                            <!-- <x-jet-dropdown-link href="{{ route('hris.leave.view-leave') }}">
                                {{ __('View Leave') }}
                            </x-jet-dropdown-link> -->

                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <!-- PROCESS end  -->

                <!-- ACCOUNT MANAGEMENT start-->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('HR MANAGEMENT') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('hr.management.employees') }}">
                                {{ __('View Employees') }}
                            </x-jet-dropdown-link>

                            {{-- <x-jet-dropdown-link href="{{ route('hr.management.memos') }}">
                                {{ __('Memo') }}
                            </x-jet-dropdown-link> --}}

                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <!-- ACCOUNT MANAGEMENT end  -->
                @endif


                {{-- ADMIN begin--}}
                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                <div class="ml-3 relative">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('SET-UP') }}
                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('register') }}">
                                {{ __('User Registration') }}
                            </x-jet-dropdown-link>

                            {{-- <x-jet-dropdown-link href="{{ route('register') }}">
                                {{ __('User Define') }}
                            </x-jet-dropdown-link> --}}

                            <x-jet-dropdown-link href="{{ route('hr.management.offices') }}">
                                {{ __('Offices') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('hr.management.departments') }}">
                                {{ __('Departments') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('hr.management.holidays') }}">
                                {{ __('Holidays') }}
                            </x-jet-dropdown-link>

                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif
                {{-- ADMIN end --}}
            </div>
        {{-- <div id="nav_header_hid" class="max-w-7xl py-0 sm:col-span-1 justify-end">
            <div>
                <div class="btn-group dropup justify-end">
                    <a id="hide_nav_header" class="btn btn-outline-secondary btn-sm dropdown-toggle border-0">Hide Header</a>
                </div>
            </div>
        </div>
        <div id="nav_header_showed" class="hidden max-w-7xl py-0 sm:col-span-1 justify-end">
            <div>
                <div class="btn-group dropdown justify-end">
                    <a id="show_nav_header" class="btn btn-outline-secondary btn-sm dropdown-toggle border-0">Show Header</a>
                </div>
            </div>
        </div> --}}

        </div>
    </div>
</nav>




<!-- NAVIGATOR end -->

<script type="text/javascript">
$(document).ready(function(){

    let has_supervisor = "{{ Auth::user()->supervisor }}";
    let role_type = "{{ Auth::user()->role_type }}";

    Pusher.logToConsole = true;

    var pusher = new Pusher('264cb3116052cba73db3', {
      cluster: 'us2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind("my-event", function(data) {
      // alert(data);
      // alert(JSON.stringify(data));
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          // url: window.location.origin+'/file-preview-memo',
          url: "{{ route('counts_pusher') }}",
          method: 'get',
          data: JSON.stringify(data), // prefer use serialize method
          success:function(data){
            $("#nav-memo-counter").text(data.memo_counts);
            // alert('Hey Gibs');
          }
      });
    }); 

    /*$("#hide_nav_header").on('click', function(e){
        $("#nav_header").toggle();
        $("#nav_header_showed").removeClass('hidden');
        $("#nav_header_hid").addClass('hidden');
    });
    $("#show_nav_header").on('click', function(e){
        $("#nav_header").toggle();
        $("#nav_header_showed").addClass('hidden');
        $("#nav_header_hid").removeClass('hidden');
    });*/

    $("#d_nav_eleave").on('click', function(e){
        if  (role_type!='SUPER ADMIN') {
            if ( has_supervisor=='' || has_supervisor==null ) {
                Swal.fire({
                    // icon: 'error',
                    title: 'NOTIFICATION',
                    text: 'Kindly ask HR for the supervisor to be assigned',

                  });
                return false;
            } 
        }
    });
});
</script>