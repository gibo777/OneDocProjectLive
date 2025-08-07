<x-slot name="header">
    {{ __('ADMIN DASHBOARD') }}
</x-slot>

<style type="text/css">
    .custom-title {
        font-size: 14px;
        line-height: 1.5;
        padding-bottom: 2px;
    }
</style>

<div class="max-w-8xl mx-auto m-1 sm:px-6 lg:px-8 p-2">
    <div class="row">

        {{-- <div class="col-xl-3 col-md-6 mb-1 px-1" @if (Auth::user()->id != 1) hidden @endif >
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    Server Status
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800 py-2">
						            <p class="mb-0">Status:
						                {!! $serverStatus ? '<b class="px-3 py-1 text-dark" style="background-color:rgb(185,255,102)">Server Up</b>' : '<b class="px-3 py-1 text-light" style="background-color:rgb(255,49,49)">Server Down</b>' !!}
						            </p>
                                </div>
                                @if (Auth::user()->id == 1)
                                <div class="text-center">
                                    <x-jet-button wire:click="toggleServer" class="btn btn-primary mt-1">
                                        <i class="fa-solid fa-server"></i>&nbsp;Server Control
                                    </x-jet-button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        <div class="col-xl-3 col-md-6 mb-1 px-1">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <a href="{{ route('eforms.leaves-listing') }}">
                                    Leaves Requested
                                </a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <ul class="list-unstyled">
                                    <li>Pending ({{ $pendingCount }})</li>
                                    <li>Approved ({{ $approvedCount }})</li>
                                    <li>Denied ({{ $deniedCount }})</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i id="gCalendar" class="fa-solid fa-calendar-days fa-4x text-primary hover"></i>
                            {{-- <i class="fa-solid fa-sheet-plastic fa-4x text-primary"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-1 px-1">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <a href="{{ route('timelogs-listing') }}">
                                    Timelogs
                                </a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <ul class="list-unstyled">
                                    <li>Today ({{ $newUsers }})</li>
                                    <li>Total Logs ({{ $totalUsers }})</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto mt-3">
                            <i class="fa-solid fa-clock fa-4x text-gray-dark"></i>
                            {{-- <i class="fa-solid fa-user-plus fa-4x text-info"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-1 px-1">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <a href="{{ route('employees-listing') }}">
                                    Registerd Employees
                                </a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <ul class="list-unstyled">
                                    {{-- <li>New ({{ $newUsers }})</li>
                                      <li>Total ({{ $totalUsers }})</li> --}}
                                    <li>New (12)</li>
                                    <li>Total (221)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto mt-3">
                            <i class="fa-solid fa-user-plus fa-4x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-3 col-md-6 mb-1 px-1">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Export to Excel
                                </div>
                                <div class="mb-0 font-weight-bold text-gray-800">Export Leaves Requested</div>
                                <div class="mb-0 font-weight-bold text-gray-800">Export Timelogs</div>
                                <div class="mb-0 font-weight-bold text-gray-800">Export Employees Listing</div>
                            </div>
                            <div class="col-auto mt-3">
                                <i class="fas fa-table fa-4x text-gray-300 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        <div class="col-xl-3 col-md-6 mb-1 px-1">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Setup and Tools
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('authorize.user.list') }}" class="text-dark">Authorize User</a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('server-status') }}" class="text-dark">Server Status</a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('module.list') }}" class="text-dark">Module Creation</a>
                            </div>
                            <div class="mb-0 font-weight-bold text-gray-800">
                                <a id="sendApiToHRIS" class="text-dark hover">Send Leave to HRIS</a>
                            </div>
                        </div>
                        <div class="col-auto mt-3">
                            <i class="fas fa-tools fa-4x text-gray-700"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-7 mb-1 px-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Leaves Requested</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-7 mb-1 px-1">
            <div class="card shadow mb-4 px-1">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Registered Employees</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px;">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-3 col-lg-5">
            <div class="card shadow mb-4 px-1">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart" style="height: 170px;"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" hidden="">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- Color System -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            Primary
                            <div class="text-white-50 small">#4e73df</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 small">#1cc88a</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            Info
                            <div class="text-white-50 small">#36b9cc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            Warning
                            <div class="text-white-50 small">#f6c23e</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            Danger
                            <div class="text-white-50 small">#e74a3b</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body">
                            Secondary
                            <div class="text-white-50 small">#858796</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-light text-black shadow">
                        <div class="card-body">
                            Light
                            <div class="text-black-50 small">#f8f9fc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            Dark
                            <div class="text-white-50 small">#5a5c69</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="{{ asset('sb-admin/img/undraw_posting_photo.svg') }}" alt="Illustration">
                    </div>
                    <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank"
                            rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of
                        beautiful svg images that you can use completely free and without attribution!</p>
                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw
                        &rarr;</a>
                </div>
            </div>

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and
                        poor page performance. Custom CSS classes are used to create custom components and custom
                        utility classes.</p>
                    <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap
                        framework, especially the utility classes.</p>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <script src="{{ asset('sb-admin/jquery/jquery.min.js') }}"></script> --}}
{{-- <script src="{{ asset('sb-admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<!-- Core plugin JavaScript-->
<script src="{{ asset('sb-admin/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
<!-- Page level plugins -->
<script src="{{ asset('sb-admin/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('sb-admin/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('sb-admin/demo/chart-bar-demo.js') }}"></script>
<script src="{{ asset('sb-admin/demo/chart-pie-demo.js') }}"></script>

<script type="text/javascript">
    $(document).on('click', '#gCalendar', function(e) {
        Swal.fire({
            width: '100%',
            allowOutsideClick: false,
            // confirmButtonText: 'Close Calendar',
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                title: 'custom-title'
            },
            title: 'Google Calendar Integration of Leaves',
            // html: `<iframe src="https://calendar.google.com/calendar/embed?src=5be3de62c935b7c9d0c1a00efc90e540d12911a0fd034b048ce4a6ab0f7e859e%40group.calendar.google.com&ctz=Asia%2FManila" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>`
            html: `<iframe src="https://calendar.google.com/calendar/embed?src=3c87eiuludrrdasrmr3qc0b8hs%40group.calendar.google.com&ctz=Asia%2FManila" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>`
        });
        return false;
    });

    $(document).on('click', '#sendApiToHRIS', function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/send-allleave-to-hris',
            method: 'post',
            /* data: {
                'id': $(this).attr('id')
            },  */
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
                $('#dataProcess').css('display', 'none');
                Swal.fire({
                    title: data.message
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    })
</script>
