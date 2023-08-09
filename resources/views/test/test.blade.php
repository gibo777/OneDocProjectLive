

<nav>
    <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    {{-- <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <style>
        .dropdown-hover-all .dropdown-menu, .dropdown-hover > .dropdown-menu.dropend { 
            margin-left:-1px !important;
            margin-top:-1px !important;
        }
    </style>


    <div class="container" style="padding-top: 3.5rem">
            <div class="col">

                <div class="d-flex dropdown-hover-all">

                    {{-- menu 1 --}}
                    <div class="dropdown mt-3 mx-1">
                        <button class="btn btn-outline-primary border-0" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                        </button>
                    </div>


                        {{-- menu 2 --}}
                      <div class="dropdown mt-3 mx-1">
                          <button class="btn btn-outline-primary dropdown-toggle border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              E-FORMS
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-LEAVE</a>
                                  <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                                      <a class="dropdown-item" href="#">E-LEAVE APPLICATION</a>
                                      <a class="dropdown-item" href="#">VIEW LEAVES</a>
                                      <a class="dropdown-item" href="#">LEAVES CALENDAR</a>
                                  </div>
                              </div>
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">REIMBURSEMENT</a>
                                  <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                                      <a class="dropdown-item" href="#">Basic</a>
                                      <a class="dropdown-item" href="#">Compact Aside</a>
                                      <div class="dropdown-divider"></div>
                                      <div class="dropdown dropend">
                                          <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Custom</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                                              <a class="dropdown-item" href="#">Fullscreen</a>
                                              <a class="dropdown-item" href="#">Empty</a>
                                              <div class="dropdown-divider"></div>
                                              <a class="dropdown-item" href="#">Magic</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>

                    {{-- menu 3 --}}
                    <div class="dropdown mt-3 mx-1">
                        <button class="btn btn-outline-primary dropdown-toggle border-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          PROCESS
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                          <div class="dropdown dropend">
                              <a class="dropdown-item" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-LEAVE</a>
                          </div>
                          
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{-- <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('/popper/js/bootstrap.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/nav-bar/bootstrap5-dropdown-ml-hack.js') }}"></script>
</nav>