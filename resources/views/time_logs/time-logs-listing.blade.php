
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    /* Hide the "Show" text and adjust layout for DataTables elements */
    .dataTables_wrapper .dataTables_length label {
        padding-left: 15px;
    }

    /* Display the "Show entries" dropdown and "Showing [entries] info" inline */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_filter {
        margin-top: 10px;
        display: inline-block;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-right: 50px;
    }

    /* Add padding between "Showing [entries] info" and "Show entries" dropdown */
    .dataTables_wrapper .dataTables_info::after {
        content: "\00a0\00a0"; /* Add non-breaking spaces for spacing */
    }
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
        text-align: center !important;
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    
    .capitalize-first-letter {
      text-transform: capitalize !important;
    }
    
    </style>

    <x-slot name="header">
                {{ __('TIME LOGS') }}
    </x-slot>
    <div id="view_leaves">
        <div class="w-full mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{-- <form id="leave-form" action="{{ route('hris.leave.view-leave-details') }}" method="POST"> --}}
            {{-- @csrf --}}


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                        <div id="filterFields" class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1">
                                <div class="col-sm-1 h-full d-flex justify-content-center align-items-center">
                                    <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                                </div>
                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfilterEmpOffice">
                                        <select name="fTLOffice" id="fTLOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Offices</option>
                                            @foreach ($offices as $office)
                                            <option>{{ $office->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfTLDept">
                                        <select name="fTLDept" id="fTLDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Departments</option>
                                            @foreach ($departments as $department)
                                            {{-- <option value="{{ $department->department_code }}">{{ $department->department }}</option> --}}
                                            <option>{{ $department->department }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
                                    </div>
                                </div>

                                <div class="col-md-4 px-3 text-center mt-1">
                                    <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
                                    <input type="date" id="fTLdtFrom" name="fTLdtFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                    to
                                    <input type="date" id="fTLdtTo" name="fTLdtTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2 pt-2 text-center mt-1 ">
                                    {{-- @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58) --}}
                                    @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58)
                                    <div class="form-group btn btn-outline-success d-inline-block p-2 rounded capitalize hover">
                                        <i class="fas fa-table"></i>
                                        <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
                                    </div>
                                    {{-- <button id="exportExcel" class="my-3 py-3 fas fa-table bg-success d-inline-block p-2 rounded text-white capitalize-first-letter"> Export to Excel</button> --}}
                                    @endif
                                </div>
                            </div>
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th class="p-0">Emp. ID</th>
                                                <th>Office</th>
                                                <th>Department</th>
                                                <th>Time-In</th>
                                                <th>Time-Out</th>
                                                <th>Supervisor</th>
                                                {{-- <th>Status</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            @forelse($employees as $employee)
                                                <tr id="{{ $employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out) }}"
                                                     class="text-sm text-lg-lg">
                                                    @if (url('/')=='http://localhost')
                                                    <td>xxx, xxx x.</td>
                                                    @else
                                                    <td>{{ $employee->full_name }}</td>
                                                    @endif
                                                    <td class="p-0">{{ $employee->employee_id }}</td>
                                                    <td>{{ $employee->office }}</td>
                                                    <td>{{ $employee->department }}</td>
                                                    <td>{{ $employee->time_in ? date('m/d/Y g:i A',strtotime($employee->time_in)) : '' }}</td>
                                                    <td>{{ $employee->time_out ? date('m/d/Y g:i A',strtotime($employee->time_out)) : '' }}</td>
                                                    @if (url('/')=='http://localhost')
                                                    <td>xxx, xxx x.</td>
                                                    @else
                                                    <td>{{ $employee->head_name }}</td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">There are no time logs.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center" id="pagination">
                                        <?php //{!! $employees->links() !!} ?>
                                    </div>

                                </div>
                    </div>
                </div>
            </div>
{{--
            </form> --}}
            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>

<!-- =========================================== -->
<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="{{asset('/img/misc/loading-blue-circle.gif')}}">
</div>

<!-- =========================================== -->
<script type="text/javascript" src="{{ asset('app-modules/timekeeping/timelogs.js') }}"></script>

</x-app-layout>




