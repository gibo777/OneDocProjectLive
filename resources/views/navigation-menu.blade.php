
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

    .dropdown-hover-all .dropdown-menu, .dropdown-hover > .dropdown-menu.dropend { 
        margin-left:-1px !important 
    }

    .margin-left-cust {
        left: -2 !important;
    }

    .margin-top-cust {
        top: -2 !important;
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
                        {{ __('E-FORMS') }}
                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <x-jet-responsive-nav-link href="{{ route('hris.leave.eleave') }}"  id="nav_eleave">
                            {{ __('E-Leave Form') }}
                        </x-jet-responsive-nav-link>

                        <x-jet-responsive-nav-link href="{{ route('hris.leave.view-leave') }}"  id="nav_view_leaves">
                            {{ __('View Leaves') }}
                        </x-jet-responsive-nav-link>

                        <!-- <x-jet-responsive-nav-link href="{{ route('calendar') }}"  id="nav_leaves_calendar">
                            {{ __('Leaves Calendar') }}
                        </x-jet-responsive-nav-link> -->
                    </div>
                    <div>
                        <a  class="view_nav block px-4 py-2 text-xs text-gray-400" href="{{ route('timelogslisting') }}"  id="nav_time_logs">
                            {{ __('TIME-LOGS') }}
                        </a>
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
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between p-1">

            <div class="hidden sm:flex sm:items-center sm:ml-6 dropdown-hover-all">

                <!-- HOME start-->
                <div class="dropdown mt-3 mx-1">
                    <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" href="{{ route('dashboard') }}" id="nav_home" >HOME</a>
                </div>
                <!-- HOME end  -->


                  <div class="dropdown mt-3 mx-1">
                      <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownEForms" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          E-FORMS
                      </button>
                      <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownEForms">
                          <div class="dropdown dropend">
                              <a class="dropdown-item dropdown-toggle" href="#" id="submenuELeaves" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-Leave</a>
                              <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                  <a class="dropdown-item" href="{{ route('hris.leave.eleave') }}" id="dNavEleave" >{{ __('E-Leave Form') }} </a>
                                  <a class="dropdown-item" href="{{ route('hris.leave.view-leave') }}"  id="nav_view_leaves">{{ __('View Leaves') }} </a>
                                  <a class="dropdown-item" href="{{ route('calendar') }}"  id="nav_leaves_calendar">{{ __('Leaves Calendar') }} </a>
                              </div>
                          </div>

                        @if (Auth::user()->role_type=='SUPER ADMIN')
                                  <div class="dropdown dropend">
                                      <a class="dropdown-item dropdown-toggle" href="#" id="submenuReimbursement" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reimbursement</a>
                                      @if(Auth::user()->id==1)
                                      <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                          <a class="dropdown-item" href="{{ route('hris.reimbursement.reimbursement') }}">Reimbursement Form</a>
                                          <a class="dropdown-item" href="#">Sub-menu 2</a>
                                          <div class="dropdown-divider"></div>
                                          <div class="dropdown dropend">
                                              <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub-menu 3</a>
                                              <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                                  <a class="dropdown-item" href="#">Sub-menu 3.1</a>
                                                  <a class="dropdown-item" href="#">Sub-menu 3.2</a>
                                                  <div class="dropdown-divider"></div>
                                                  <a class="dropdown-item" href="#">Sub-menu 3.3</a>
                                              </div>
                                          </div>
                                      </div>
                                      @endif
                                  </div>
                          @endif
                          
                      </div>
                      {{-- @if ($notification_count>0)
                      <span id="nav-memo-counter" class="badge badge-primary badge-pill">{{ $notification_count }}</span>
                      @endif --}}
                </div>

                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                    @if (str_contains(Auth::user()->department, 'ACCTG')==1 || Auth::user()->id==1)
                    <div class="dropdown mt-3 mx-1">
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownProcess" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        RECORDS MANAGEMENT
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
                              {{-- <a class="dropdown-item" href="{{ route('hr.management.employees') }}" >
                                  {{ __('View Employees') }}
                              </a> --}}
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Employee Management </a>
                                  <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('register') }}" >
                                            {{ __('User Registration') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('hr.management.employees') }}">
                                            {{ __('View Employees') }}
                                        </a>
                                  </div>
                              </div>
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Time Keeping </a>
                                  <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="{{ route('timelogslisting') }}">Time Logs</a>
                                  </div>
                              </div>
                              {{-- <a class="dropdown-item" href="{{ route('hr.management.memos') }}">
                                  {{ __('Memo') }}
                              </a> --}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dropdown mt-3 mx-1">
                        <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" href="{{ route('timelogslisting') }}" id="nav_home" >TIME-LOGS</a>
                    </div>
                @endif

                {{-- <div class="dropdown mt-3 mx-1">
                    <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    TIME KEEPING
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <div class="dropdown dropend">
                          <a class="dropdown-item" href="{{ route('timelogslisting') }}">Time Logs</a>
                        </div>
                    </div>
                </div> --}}


                @if (Auth::user()->role_type=='SUPER ADMIN')

                    <div class="dropdown mt-3 mx-1">
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            </div>
                        </div>
                    </div>

                {{-- <div class="ml-3 mt-3 relative">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('SET-UP') }}
                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('register') }}">
                                {{ __('User Registration') }}
                            </x-jet-dropdown-link>

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
                </div> --}}
                @endif

                {{-- <div class="dropdown mt-3 mx-1">
                    <button class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      PROCESS
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                      <div class="dropdown dropend">
                          <a class="dropdown-item" href="{{ route('process.eleave') }}" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Process e-Leave</a>
                      </div>
                      
                    </div>
                </div> --}}

                <!-- E-LEAVE MENU start-->
                {{-- <div class="ml-3 mt-3 relative">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('E-FORMS') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('hris.leave.eleave') }}" id="dNavEleave" >
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
                </div> --}}
                <!-- E-LEAVE MENU end  -->
                
                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                <!-- PROCESS start-->
                {{-- <div class="ml-3 mt-3 relative">

                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('PROCESS') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- PROCESS E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('process.eleave') }}">
                                {{ __('Process e-Leave Applications') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div> --}}
                <!-- PROCESS end  -->

                <!-- ACCOUNT MANAGEMENT start-->
                {{-- <div class="ml-3 mt-3 relative hidden">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('HR MANAGEMENT') }}

                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('hr.management.employees') }}">
                                {{ __('View Employees') }}
                            </x-jet-dropdown-link>

                            @if (Auth::user()->role_type=='SUPER ADMIN')
                            <x-jet-dropdown-link href="{{ route('hr.management.memos') }}">
                                {{ __('Memo') }}
                            </x-jet-dropdown-link>
                            @endif

                        </x-slot>
                    </x-jet-dropdown>
                </div> --}}
                <!-- ACCOUNT MANAGEMENT end  -->
                @endif


                {{-- ADMIN begin--}}
                {{-- @if (Auth::user()->role_type=='SUPER ADMIN')
                <div class="ml-3 mt-3 relative">
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover">
                                        {{ __('SET-UP') }}
                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- E-LEAVE -->
                            <x-jet-dropdown-link href="{{ route('register') }}">
                                {{ __('User Registration') }}
                            </x-jet-dropdown-link>

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
                @endif --}}
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

            <div class="items-center justify-center">

                @if ($timeIn)
                <x-jet-button type="button" id="btnTimeIn" name="btnTimeIn" disabled>
                    {{ __('Time-In') }}
                </x-jet-button>
                @else
                <x-jet-button type="button" id="btnTimeIn" name="btnTimeIn">
                    {{ __('Time-In') }}
                </x-jet-button>
                @endif

                @if ($timeOut)
                <x-jet-button type="button" id="btnTimeOut" name="btnTimeOut" disabled>
                    {{ __('Time-Out') }}
                </x-jet-button>
                @else
                <x-jet-button type="button" id="btnTimeOut" name="btnTimeOut">
                    {{ __('Time-Out') }}
                </x-jet-button>
                @endif

            </div>
        </div>
    </div>




<div class="modal fade" id="modalTimeLogCam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg text-white">Capture Image for Timelog</h4>
            <button id="closeLogCamModal" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
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
                <div class="row pt-2">
                    <div class="col-md-12 text-center">
                        <input id="logEvent" hidden>
                        <input type="button" id="takeSnapshot" value="Take Snapshot" class="btn btn-primary ">
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12 text-center">
                        <x-jet-button id="saveTempPhoto">{{ __('Ok') }} 
                        </x-jet-button>
                    </div>
                </div> --}}

            </form>
        </div>

      </div>
    </div>
  </div>
</div>


</nav>

    {{-- <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('/popper/js/bootstrap.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/nav-bar/bootstrap5-dropdown-ml-hack.js') }}"></script>

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


    $("#dNavEleave").on('click', function(e){
        // if  (role_type!='SUPER ADMIN') {
            if ( has_supervisor=='' || has_supervisor==null ) {
                Swal.fire({
                    // icon: 'error',
                    title: 'NOTIFICATION',
                    html: 'Kindly ask HR for the supervisor to be assigned. <br>Thank you!',

                  });
                return false;
            } 
        // }
    });


    /**
    * This will capture temporary photo using webcam
    */
    $("#saveTempPhoto").click(function() {

        var data_uri = $("#capturedPhoto").attr("src");
        Webcam.reset( '#logCamera' );

        $('#divPhotoPreview1').addClass('hidden');
        $('#divPhotoPreview2').empty();
        $('#divPhotoPreview2').css('display','flex');
        $('#divPhotoPreview2').append('<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url('+data_uri+')"></span>');
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
            success:function(data){
                $("#modalWebCam").modal("hide");
                // alert(data); return false;
                Webcam.reset( '#logCamera' );
                $("#divPhotoPreview1").addClass("hidden");
                $("#divPhotoPreview2").addClass("hidden");
                $("#divPhotoPreview3").removeClass("hidden");
                $("#profilePhotoPreview").attr("src",data);

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

  // Function to start the webcam
  function startWebcam() {
    // Access the user's webcam
    navigator.mediaDevices.getUserMedia({ video: true })
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

      // Draw the current video frame onto the canvas
      var context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to a data URL
      var dataURL = canvas.toDataURL('image/png');


      // Display the captured image using Swal
      Swal.fire({
        // title: 'Captured Image',
        imageUrl: dataURL,
        imageAlt: 'Captured Image',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonText: 'Save',
      }).then(function(result) {
        if (result.isConfirmed) {
            $("#modalTimeLogCam").modal("hide");
          // Handle saving the image (e.g., send to server, download, etc.)

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('save.timelogs') }}",
            method: 'post',
            data: {'logEvent':$("#logEvent").val(), 'image':dataURL},
            success:function(data){
                if (data.isSuccess==true) {
                  // Display a success message using Swal
                  Swal.fire({
                    icon: 'success',
                    title: 'Image saved successfully!',
                    // text: dataURL,
                  });
                  video.currentTime = 0;
                  video.style.display = "none";
                  // alert(window.location.href);
                  setTimeout(function() {
                    location.reload();
                  }, 5000);

                  $("#btnTimeIn").prop('disabled', true);
                  $("#btnTimeOut").prop('disabled', false);
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

  // Event handler for the capture button
    $('#btnTimeIn').click(function() {

        $("#modalTimeLogCam").modal("show");
        $("#logEvent").val("TimeIn");

        Webcam.set({
            width: 430,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                video: {
                    facingMode: "user",
                    mirror: true
                }
            }
        });

        Webcam.attach( '#logCamera' );

        // Start the webcam when the page loads
        startWebcam();
        // $("#modalTimeLogCam").modal("show");

    });

    $('#btnTimeOut').click(function() {
        // alert('Gibs'); return false;

        $("#modalTimeLogCam").modal("show");
        $("#logEvent").val("TimeOut");

        Webcam.set({
            width: 430,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                video: {
                    facingMode: "user",
                    mirror: true
                }
            }
        });

        Webcam.attach( '#logCamera' );

        // Start the webcam when the page loads
        startWebcam();
        // $("#modalTimeLogCam").modal("show");

    });

    // Capture image for Time Logs
    $('#takeSnapshot').click(function() {
        captureImage();
    });

    // Closing Camera Modal
    $("#closeLogCamModal").click(function() {
        Webcam.reset( '#logCamera' );
        location.reload();
    });

});
</script>