
<style>

    @media print {
            .datazzz{
                text-align: center; font-size:15px; color:black;
            }
            @page {
      size: A4;
      margin: 11mm 17mm 17mm 17mm;

      /* counter-reset: page !important; */
      }
      #printtable{
        width: 100%;
      }
      #nodays{
        width: 10% !important;
      }
       tr:nth-child(even) td {
           background-color: #F0F0F0 !important;
            -webkit-print-color-adjust: exact;
       }
       .head1{
            text-align: center; font-size:24px; color:white;
                /* background-color: #0000cc !important; */
                /*background: url(../img/backgrounds/blue-wave-banner.png) no-repeat !important;*/
            -webkit-print-color-adjust: exact;
            }
            .head2{
                text-align: center; font-size:20px; color:white;
                /* background-color: #0000ff !important; */
                /*background: url(../img/backgrounds/blue-wave-banner.png) no-repeat !important;*/
            -webkit-print-color-adjust: exact;
            }
            .head3{
                text-align: center; font-size:17px;color: white;
                /* background-color: #0080ff !important; */
                /*background: url(../img/backgrounds/blue-wave-banner.png) no-repeat !important;*/
            -webkit-print-color-adjust: exact;
            }

        .dataTables_wrapper thead th {
            padding: 0px 5px !important; /* Adjust the padding value as needed */
        }
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataViewLeaves thead th {
        text-align: center; /* Center-align the header text */
    }
    /* Hide sorting arrows in DataTables */
    /*.dataTables_wrapper .sorting:before,
    .dataTables_wrapper .sorting_asc:before,
    .dataTables_wrapper .sorting_desc:before {
        display: none;
    }*/
    .dataTables_wrapper .dataTables_length label {
        padding-left: 15px;
    }
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }


    /* Custom CSS for inset shadow */
    .inset-shadow {
        /* For providing border to the element */
        border: 1px #b8b8b8 solid;
        /* For Padding */
        padding: 1px;
        /* Defining box-shadow property as inset */
        box-shadow: 0px 0px 3px 3px #f5f5f5 inset;
        background-color: #fcfcfc;
    }
    
    </style>
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <x-slot name="header">
            @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                @if (Auth::user()->department=='1D-HR')
                    {{ __('VIEW ALL LEAVES (HR/ADMIN VIEW)') }}
                @else
                    {{ __('VIEW ALL LEAVES (HEAD VIEW)') }}
                @endif
            @else
                {{ __('VIEW ALL LEAVES') }}
            @endif
    </x-slot>
    <div id="view_leaves">
        {{-- <div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8"> --}}
        <div class="w-full mx-auto py-1 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{-- <form id="leave-form" action="{{ route('hris.leave.view-leave-details') }}" method="POST">
            @csrf --}}

            <div class="px-4 bg-white sm:p-3 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="col-span-8 sm:col-span-8 sm:justify-center">

                        <div class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1" id="filterFields">

                                <div class="col-md-5 text-center mt-1">
                                    <div class="row mx-1">
                                        @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                        <!-- FILTER by Department -->
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <div class="form-floating" id="divfilterDepartment">
                                                <select name="filterDepartment" id="filterDepartment" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Departments</option>
                                                    @foreach ($departments as $dept)
                                                    <option>{{ $dept->department }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="filterDepartment" value="{{ __('DEPARTMENT') }}" />
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <!-- FILTER by Leave Type -->
                                            <div class="form-floating" id="div_filterLeaveType">
                                                <select name="filterLeaveType" id="filterLeaveType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Leave Types</option>
                                                    @foreach ($leave_types as $leave_type)
                                                    <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="filterLeaveType" value="{{ __('LEAVE TYPE') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <!-- FILTER by Leave Type -->
                                            <div class="form-floating" id="div_filterLeaveType">
                                                <select name="filterLeaveStatus" id="filterLeaveStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Leave Statuses</option>
                                                    @foreach ($leave_statuses as $leave_status)
                                                    <option>{{ $leave_status->leave_status }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="filterLeaveStatus" value="{{ __('LEAVE STATUS') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

			                    <div class="col-md-3 px-1 text-center mt-1">
			                    	<x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
			                    	<input type="date" id="dateFrom" name="dateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
			                    	to
			                    	<input type="date" id="dateTo" name="dateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
			                    </div>

                                <div class="col-md-2 pt-2 text-center mt-1 ">
                                    @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58 || Auth::user()->id==124 || Auth::user()->id==126)
                                    <div class="form-group btn btn-outline-success d-inline-block p-2 rounded capitalize hover">
                                        <i class="fas fa-table"></i>
                                        <span id="exportExcelLeaves" class="font-weight-bold">Export to Excel</span>
                                    </div>
                                    @endif
                                </div>

                                {{-- @if (Auth::user()->role_type!='ADMIN' && Auth::user()->role_type!='SUPER ADMIN')
                                <div class="col-md-2"></div>
                                @endif --}}
                                <div class="col-md-2 px-1 py-3 text-center">
                                    <x-jet-button  id="createNewLeave" >Create New Leave</x-jet-button>
                                </div>
		                    </div>
                        </div>


                        {{-- <!-- DIV_GRID4 -->
                        <div class="col-span-8 sm:col-span-1 hidden" id="div_grid4">
                        </div>
                        <!-- DIV_GRID5 -->
                        <div class="col-span-8 sm:col-span-1 hidden" id="div_grid5">
                        </div>
                        <!-- DIV_GRID6 -->
                        <div class="col-span-8 sm:col-span-1 " id="div_grid6">
                        </div> --}}
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataViewLeaves" class="table table-bordered table-striped sm:justify-center table-hover">

                                        <thead class="thead">
                                            <tr>
                                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                <th>Name</th>
                                                {{-- <th>Emp. No.</th> --}}
                                                <th>Office</th>
                                                <th>Department</th>
                                                @endif
                                                <th>Control#</th>
                                                <th>Type</th>
                                                {{-- <th>Date Applied</th> --}}
                                                <th>Begin Date</th>
                                                <th>End Date</th>
                                                <th># of Day/s</th>
                                                <th>Supervisor</th>
                                                <th>Status</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewLeave">
                                            @forelse($leaves as $leave)
                                                <tr class="view-leave text-sm text-lg-lg" id="{{ $leave->id }}">
                                                    @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                    @if (url('/')=='http://localhost')
                                                        <td>xxx, xxx x.</td>
                                                    @else
                                                        <td>{{ $leave->name }}</td>
                                                    @endif
                                                    {{-- <td>{{ $leave->employee_id }}</td> --}}
                                                    <td>{{ $leave->company_name }}</td>
                                                    <td>{{ $leave->department }}</td>
                                                    @endif
                                                    <td>{{ $leave->control_number }}</td>
                                                    <td>{{ $leave->leave_type }}</td>
                                                    {{-- <td>{{ date('m/d/Y g:i A',strtotime($leave->date_applied)) }}</td> --}}
                                                    <td>{{ date('m/d/Y',strtotime($leave->date_from)) }}</td>
                                                    <td>{{ date('m/d/Y',strtotime($leave->date_to)) }}</td>
                                                    <td>{{ $leave->no_of_days }}</td>
                                                    <td>{{ $leave->head_name }}</td>

                                                    @if ($leave->status!="Pending")
                                                    <td id="status_view" class="open_history">
                                                        <button
                                                            id="{{ $leave->id }}"
                                                            value="{{ $leave->id }}"
                                                            title="Show History Leave #{{ $leave->leave_number }}"
                                                            class="open_leave {{ ($leave->status=='Cancelled'||$leave->status=='Denied') ? 'red-color' : 'green-color' }} inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500"
                                                            >
                                                            {{ strtoupper($leave->status) }}
                                                        </button></td>
                                                    @else
                                                    <td>{{ $leave->status }}</td>
                                                    @endif
                                                    {{-- <td id="action_buttons">
                                                        @if ($leave->status!="Taken")
                                                        <button
                                                            id="open-{{ $leave->id }}"
                                                            value="{{ $leave->id }}"
                                                            title="View Leave #{{ $leave->leave_number }}"
                                                            class="open_leave fas fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#myModal">
                                                            {{ __('View') }}
                                                        </button>
                                                        @endif

                                                        @if ($leave->status == "Pending" && Auth::user()->employee_id==$leave->employee_id)
                                                        <button id="delete-{{ $leave->id }}-{{ $leave->name }}"
                                                            value="{{ $leave->id }}"
                                                            title="Delete Leave #{{ $leave->leave_number }}"
                                                            class="fas fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalAlert">
                                                            {{ __('Delete') }}
                                                        </button>
                                                        @endif
                                                    </td> --}}
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">No record found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                <div class="mt-1 hidden">
                                <i class="fa fa-print inline-flex items-center justify-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition hover" onclick="printreport()">&nbsp;print</i>
                                </div>
                                @endif
                    </div>
                </div>
            </div>
            {{-- </form> --}}
            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>

{{-- <button data-toggle="modal" data-target="#myPrintModal">PRINT2</button>
<button onclick="printreport()">PRINT</button> --}}

<!-- =========================================== -->
<!-- Modal dagdag ni MARK FOR PRINTING -->

<div class="modal fade" id="myPrintModal" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header banner-blue">
          <h4 class="modal-title text-white" id="myPrintModalLabel"></h4>
          <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>
        <div class="modal-body">
            <div id="red">
                <div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8">
                    <!-- FORM start -->

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form id="leave-form-modal" action="{{ route('hris.leave.view-leave-details') }}" method="POST">
                    @csrf

                    <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                        <div class="col-span-8 sm:col-span-8 sm:justify-center scrollable">
                                <div id="filter_fields" class="grid grid-cols-6 py-1 gap-2">
                                    <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                                        @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                        <!-- FILTER by Department -->
                                        <div class="col-span-8 sm:col-span-1" id="div_filter_department">
                                            <select name="filter_department" id="filter_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                                <option value="">All Departments</option>
                                                @foreach ($departments as $dept)
                                                <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                                @endforeach
                                            </select>
                                            <x-jet-label for="filter_department" value="{{ __('DEPARTMENT') }}" />
                                        </div>
                                        @endif
                                        <!-- FILTER by Leave Type -->
                                        <div class="col-span-8 sm:col-span-1" id="div_filter_leave_type">
                                            <x-jet-label for="filter_leave_type" value="{{ __('LEAVE TYPE') }}" />
                                            <select name="filter_leave_type" id="filter_leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                                <option value="">All Leave Types</option>
                                                @foreach ($leave_types as $leave_type)
                                                <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>

                                    <div id="table_data">
                                        <!-- Name -->
                                        <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                            <table id="printtable">
                                                <thead>
                                                    <tr>
                                                        <th colspan="8" style="text-align: center; font-size:24px;">LEAVES REPORT</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" style="text-align: center; font-size:20px; ">DEPARTMENTS: ALL DEPARTMENTS </th>
                                                        <th colspan="4" style="text-align: center; font-size:20px;">LEAVE TYPE: ALL LEAVE TYPES </th>

                                                    </tr>
                                                        <tr >
                                                        @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                        <th style="text-align: center; font-size:17px;">Name</th>
                                                        <th style="text-align: center; font-size:17px;">Emp. No.</th>
                                                        <th style="text-align: center; font-size:17px;">Department</th>
                                                        @endif
                                                        {{-- <th style="text-align: center; font-size:14px;">Leave#</th> --}}
                                                        <th style="text-align: center; font-size:17px;">Leave Type</th>
                                                        <th style="text-align: center; font-size:17px;">Date Applied</th>
                                                        <th  style="text-align: center; font-size:17px;">Begin Date</th>
                                                        <th style="text-align: center; font-size:17px;">End Date</th>
                                                        <th id="nodays" style="text-align: center; font-size:17px;"># of Days</th>
                                                        {{-- <th style="text-align: center; font-size:14px;">Supervisor</th>
                                                        <th style="text-align: center; font-size:14px;">Status</th> --}}

                                                    </tr>
                                                </thead>
                                                <tbody class="data" id="data">
                                                    @forelse($leaves as $leave)
                                                        <tr>
                                                            @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                            <td class="datazzz">{{ $leave->name }}</td>
                                                            <td class="datazzz">{{ $leave->employee_id}}</td>
                                                            <td class="datazzz">{{ $leave->dept }}</td>
                                                            @endif
                                                            {{-- <td style="text-align: center; font-size:9px;">{{ $leave->leave_number }}</td> --}}
                                                            <td class="datazzz">{{ $leave->leave_type }}</td>
                                                            <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_applied)) }}</td>
                                                            <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_from)) }}</td>
                                                            <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_to)) }}</td>
                                                            <td id="datadays" class="datazzz">{{ $leave->no_of_days }}</td>
                                                            {{-- <td style="text-align: center; font-size:9px;">{{ $leave->head_name }}</td>


                                                            <td style="text-align: center; font-size:9px;">{{ $leave->status }}</td> --}}

                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">There are no users.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <div>

                                            </div>
                                            <div class="d-flex justify-content-center" id="pagination">
                                                <?php //{!! $leaves->links() !!} ?>
                                            </div>

                                        </div>
                            </div>
                        </div>
                    </div>

                    </form>
                    <!-- FORM end -->
                        </div>
                    </div>

        </div>
      </div>
    </div>
  </div>

  <!-- =========================================== -->
<!-- Modal for History -->
<div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="leaveHistoryLabel" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header banner-blue">
          <h4 class="modal-title text-lg text-white" id="leaveHistoryLabel">
              LEAVE HISTORY
          </h4>
          <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>
        <div class="modal-body bg-gray-50">
  
              <div class="grid grid-cols-6 gap-6 pb-3">
                  <div class="col-span-6 sm:col-span-6 sm:justify-center font-medium scrollable">
                  <table id="data_history" class="table table-bordered data-table sm:justify-center table-hover">
                      <thead class="thead">
                          <tr>
                              <th>Supervisor</th>
                              <th>Leave Type</th>
                              <th>Available</th>
                              <th>Action</th>
                              <th>Action Date</th>
                              <th>Reason</th>
                              <th>Date Applied</th>
                              <th>Begin Date</th>
                              <th>End Date</th>
                              <th># of Day/s</th>
                          </tr>
                      </thead>
                      <tbody class="data text-center" id="data">
                      </tbody>
                  </table>
              </div>
  
  
        </div>
      </div>
    </div>
  </div>
  </div>
  
  <!-- =========================================== -->
  

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header banner-blue">
        <h4 class="modal-title text-white" id="myModalLabel"></h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">

        <!--  -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="update-leave-form" method="POST" action="" class="px-2">
        @csrf
                
                <div class="row">
                    <div class="col-md-4 p-1">
                        <!-- Name -->
                        {{-- <div class="form-floating"> --}}
                        {{-- <x-jet-input id="name" name="name" type="text" class="form-control mt-1 block w-full" placeholder="NAME" readonly/> --}}
                        <x-jet-label class="text-secondary" for="name" value="{{ __('NAME') }}" />
                        <x-jet-label id="name" name="name"/>
                        <x-jet-input-error for="name" class="mt-2" />
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-3 p-1">
                        <!-- Employee Number -->
                        {{-- <div class="form-floating"> --}}
                        {{-- <x-jet-input id="employee_number" name="employee_number" type="text" class="form-control mt-1 block" placeholder="EMPLOYEE #" readonly/> --}}
                        <x-jet-label class="text-secondary" for="employee_number" value="{{ __('EMPLOYEE #') }}" />
                        <x-jet-label id="employee_number" name="employee_number"/>
                        <x-jet-input-error for="employee_number" class="mt-2" />
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-3 p-1">
                        <!-- Department -->
                        {{-- <div class="form-floating"> --}}
                        {{-- <x-jet-input id="department" name="department" type="text" class="form-control mt-1 block" placeholder="DEPARTMENT" readonly/> --}}
                        <x-jet-label class="text-secondary" for="department" value="{{ __('DEPARTMENT') }}" />
                        <x-jet-label id="department" name="department"/>
                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-2 p-1">
                        <!-- Date Applied -->
                        {{-- <div class="form-floating"> --}}
                        {{-- <x-jet-input id="date_applied" name="date_applied" type="text" class="form-control mt-1 border-0 bg-white shadow-none block date-input" placeholder="DATE APPLIED" readonly/> --}}
                        <x-jet-label class="text-secondary" for="date_applied" value="{{ __('DATE APPLIED') }}" />
                        <x-jet-label id="date_applied" name="date_applied"/>
                        <x-jet-input-error for="date_applied" class="mt-2" />
                        {{-- </div> --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 p-1">
                        <!--  Leave Type -->
                        <div class="form-floating">
                        <select name="leave_type" id="leave_type" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="LEAVE TYPE" disabled>
                            <option value="">Select Leave Type</option>
                                @foreach ($leave_types as $leave_type)
                                    <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                                @endforeach
                        </select>
                        <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                        <!-- <x-jet-input id="leave_type" name="leave_type" type="text" class="mt-1 block" wire:model.defer="state.leave_type" readonly/> -->

                        <x-jet-input-error for="leave_type" class="mt-2" />
                        <div id="div_others" name="div_others" hidden="true">
                            <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block" hidden="true" wire:model.defer="state.others_leave" placeholder="Specify leave here..." autocomplete="off"/>
                        <x-jet-input-error for="others_leave" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-floating">
                                    <x-jet-input id="date_from" name="date_from" type="text" class="form-control datepicker date-input" placeholder="mm/dd/yyyy" autocomplete="off" disabled/>
                                    <x-jet-label for="date_from" value="{{ __('BEGIN (mm/dd/yyyy)') }}" class="w-full" />
                                </div>
                            </div>
                            TO
                            <div class="col-md-5">
                                <div class="form-floating">
                                    <x-jet-input id="date_to" name="date_to" type="text" class="form-control datepicker date-input" placeholder="mm/dd/yyyy" autocomplete="off" disabled/>
                                    <x-jet-label for="date_to" value="{{ __('END (mm/dd/yyyy)') }}" class="w-full" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-1">
                        <!-- Number of Days -->
                        <div class="form-floating" id="div_number_of_days">
                            <x-jet-input id="hid_no_days" name="hid_no_days" class="form-control font-semibold text-xl text-gray-800 leading-tight items-center sm:justify-center" placeholder="NUMBER OF DAY/S" disabled/>
                            <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" />

                            {{-- <x-jet-input id="hid_no_days" type="text" name="hid_no_days" class="sm-input" hidden/> --}}
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Notification of Leave -->
                    <div class="col-md-9 text-center">
                        <div class="row">
                            {{-- <div class="col-md-5 p-1">
                                <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-xl text-gray-800 leading-tight"/>

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />IN PERSON &nbsp; &nbsp;

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" wire:model.defer="state.leave_notification" />BY SMS &nbsp; &nbsp;

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" wire:model.defer="state.leave_notification" />BY E-MAIL
                            </div> --}}

                            <div class="form-floating col-md-6 p-1">
                                <textarea id="reason" name="reason" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-1/2" placeholder="REASON" disabled/> </textarea>
                                <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight pt-4"/>
                                <x-jet-input-error for="reason" class="mt-2" />
                            </div>

                        </div>
                        <div class="row text-left">
                            <!-- INSTRUCTIONS -->
                            <div class="col-md-12 sm:col-span-5 sm:justify-center">
                                INSTRUCTIONS:
                                <ol>
                                    <li>
                                        1. Application for leave of absence must be filed at the latest, 
                                        three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                                        it must be filed immediately upon reporting for work.
                                    </li>
                                    <li>
                                        2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                                <table class="table table-bordered data-table mx-auto">
                                    <tr><th colspan="2">STATUS</th></tr>
                                    <tr class="leave-status-field">
                                        <th>Available</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Taken</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Balance</th>
                                        <td id="td_balance"></td>
                                    </tr>
                                    <tr>
                                        <th>As of:</th>
                                        <td id="td_as_of">{{ date('m/d/Y') }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-input id="hid_leave_id" name="hid_leave_id" type="hidden" />

                    <!-- <div id="view_button1"> -->
                    <div>
                        <x-jet-button type="button" id="leave_form" name="leave_form">
                            {{ __('Export PDF') }}
                        </x-jet-button>
                        {{-- <x-jet-button type="button" id="update_leave" name="update_leave">
                            {{ __('Update') }}
                        </x-jet-button> --}}
                        @if (Auth::user()->role_type=='SUPER ADMIN' || Auth::user()->role_type=='ADMIN')
                        <x-jet-button type="button" id="cancel_leave" name="cancel_leave">
                            {{ __('CANCEL LEAVE') }}
                        </x-jet-button>
                        @endif
                        <x-jet-button type="button" id="deny_leave" name="deny_leave">
                            {{ __('DENY') }}
                        </x-jet-button>
                        <x-jet-button type="button" id="approve_leave" name="approve_leave">
                            {{ __('APPROVE') }}
                        </x-jet-button>
                        <x-jet-button type="button" id="taken_leave" name="taken_leave">
                            {{ __('TAKEN') }}
                        </x-jet-button>
                    </div>
                </div>
          </form>
        <!--  -->
      </div>
    </div>
  </div>
</div>

<!-- =========================================== -->
<!-- Modal for Cancellation -->
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header banner-blue">
        <h4 class="modal-title text-lg text-white" id="myModalLabel">CONFIRMATION</h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body bg-gray-50">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="update-leave-form" method="POST" action="">
        @csrf
            <div class="grid grid-cols-5 gap-6 pb-3">
                <div class="col-span-6 sm:col-span-4 sm:justify-center font-medium">
                <ol>
                    <li id="confirmation_message">
                    </li>
                </ol>
                <textarea id="confirm_reason" name="confirm_reason"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                wire:model.defer="state.cancel_reason" placeholder="Kindly indicate your reason here.."></textarea>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <x-jet-input id="hid_leave_id" name="hid_leave_id" type="hidden" />

                <div>
                    <x-jet-button type="button" id="btn_yes" name="btn_yes">
                        {{ __('YES') }}
                    </x-jet-button>
                    <x-jet-button type="button" id="btn_no" name="btn_no">
                        {{ __('NO') }}
                    </x-jet-button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- =========================================== -->

<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="{{asset('/img/misc/loading-blue-circle.gif')}}">
</div>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>

<x-jet-input id="hid_access_id" name="hid_access_id" value="{{ Auth::user()->access_code }}" type="text" hidden/>
</x-app-layout>




{{-- DAGDAG NI MARK FOR PRINT FUNCTION --}}
<script>
 function printreport(){
    $("#printtable").printThis();
    // $("#printVisitModal").modal('show');
    // console.log("PRINT FUNCTION FUNCTIONAL");
}

$(document).ready( function () {
    
    if (("{{ count($leaves) }}") == 0) { return false; }
    var tableLeaves = $('#dataViewLeaves').DataTable({
        "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
      });

function formatDates(date) {
    var d = new Date(date),
    month = d.getMonth()+1,
    day = d.getDate();

    var new_date =
    (month<10 ? '0' : '') + month + '/' +
    (day<10 ? '0' : '') + day
    + '/' + d.getFullYear()
    ;
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    new_date = new_date+" "+strTime;
    return new_date;
}



function currentDate() {
    var d = new Date(),
        month = d.getMonth()+1,
        day = d.getDate();

    var current_date =
        (month<10 ? '0' : '') + month + '/' +
        (day<10 ? '0' : '') + day
        + '/' + d.getFullYear()
        ;
    return current_date;
}


	$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

		const aRT = "{{ Auth::user()->role_type }}";
		if (aRT=='SUPER ADMIN' || aRT=='ADMIN') {
		    var sD  = $('#filterDepartment').val();
		    var sLT = $('#filterLeaveType').val();
            var sLS = $('#filterLeaveStatus').val().toUpperCase();
		    var cD  = data[2]; // Department Column
            var cLT = data[4]; // Leave Type Column
		    var cLS = data[9].toUpperCase(); // Leave Status Column
		    
		    // Check if a department filter is selected
		    var departmentFilterActive = (sD != null && sD !== '');

		    // Check if a LeaveType filter is selected
		    var leaveTypeFilterActive = (sLT != null && sLT !== '');

            // Check if a LeaveType filter is selected
            var leaveStatusFilterActive = (sLS != null && sLS !== '');

		    // Apply both filters
		    if (!departmentFilterActive && !leaveTypeFilterActive && !leaveStatusFilterActive) {
		        return true; // No filters applied, show all rows
		    }
		    var departmentMatch = !departmentFilterActive || cD.includes(sD);
            var leaveTypeMatch = !leaveTypeFilterActive || cLT.includes(sLT);
		    var leaveStatusMatch = !leaveStatusFilterActive || cLS.includes(sLS);

		    return departmentMatch && leaveTypeMatch && leaveStatusMatch;
		} else {
		    var sLT = $('#filterLeaveType').val();
		    var cLT = data[2]; // LeaveType Column
		    
		    // Check if a LeaveType filter is selected
		    var leaveTypeFilterActive = (sLT != null && sLT !== '');

		    // Apply both filters
		    if (!leaveTypeFilterActive) {
		        return true; // No filters applied, show all rows
		    }
		    var leaveTypeMatch = !leaveTypeFilterActive || cLT.includes(sLT);

		    return leaveTypeMatch;
		}
	    
	});


    /* START - Date From and Date To Searching */
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var searchDateFrom = $('#dateFrom').val();
        var searchDateTo = $('#dateTo').val();

        // Convert search date strings to Date objects
        var dateFrom = new Date(searchDateFrom);
        var dateTo = new Date(searchDateTo);

        // Set the time to the start and end of the selected days
        dateFrom.setHours(0, 0, 0, 0);
        dateTo.setHours(23, 59, 59, 999);

        // Get the time-in and time-out values from columns 3 and 4
        var searchTimeIn = data[5];
        var searchTimeOut = data[6];

        // Convert time-in and time-out strings to Date objects (if applicable)
        var timeIn = searchTimeIn ? new Date(searchTimeIn) : null;
        var timeOut = searchTimeOut ? new Date(searchTimeOut) : null;

        // Check if the row's time-in or time-out falls within the selected date range
        if (
            (!searchDateFrom || !searchDateTo) || // No date range selected
            (!timeIn && !timeOut) || // No time values available
            (timeIn >= dateFrom && timeIn <= dateTo) ||
            (timeOut >= dateFrom && timeOut <= dateTo)
        ) {
            return true; // Row matches the search criteria
        }

        return false; // Row does not match the search criteria
    });


    /* Triggers Date From Searching of Time-In/Time-Out */
    $('#dateFrom').on('keyup change', function() {
        if ($('#dateTo').val()=='' || $('#dateTo').val()==null) {
            $('#dateTo').val($(this).val());
        } else {
            var dateFrom = new Date($(this).val());
            var dateTo = new Date($('#dateTo').val());
            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                }).then(function() {
                    $(this).val('');
                });
            }
        }
        tableLeaves.draw();
    });

    /* Triggers Date To Searching of Time-In/Time-Out */
    $('#dateTo').on('keyup change', function() {
        var dateFrom = new Date($('#dateFrom').val());
        var dateTo = new Date($(this).val());
        if( dateTo < dateFrom ) {
            $(this).val($('#dateFrom').val());
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
            });
        }
        tableLeaves.draw();
    });
    /* END - Date From and Date To Searching */


/* Filtering Departments - Gibs */
$('#filterDepartment').on('keyup change', function() { 
	tableLeaves.draw(); 
});
/* Filtering Leave Types - Gibs */
$('#filterLeaveType').on('keyup change', function() { 
	tableLeaves.draw(); 
});
/* Filtering Leave Statuses - Gibs */
$('#filterLeaveStatus').on('keyup change', function() { 
    tableLeaves.draw(); 
});

/* EXPORT TO EXCEL TIMELOGS */
    $('#exportExcelLeaves').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/leaves-excel',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){

                var blob = new Blob([data], { type: 'application/vnd.ms-excel' });
                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = 'leaves.xls'; // Use .xls extension for Excel files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            }
        }); 
        return false;

    });

/* Reroute to Leave Form */
$(document).on('click','#createNewLeave', async function() {
    window.location.href = "{{ route('hris.leave.eleave') }}";
});

/* Viewing Leave Details per Control Number - Gibs */
$(document).on('dblclick','.view-leave',function(){
    let leaveID = this.id;
    $("#popup").show();
    $("#confirm_reason").val('');
    $('#dataLoad').css('display','flex');
    $('#dataLoad').css('position','absolute');
    $('#dataLoad').css('top','40%');
    $('#dataLoad').css('left','40%');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin+'/hris/view-leave-details',
        method: 'GET',
        data: { 'leaveID': leaveID }, // prefer use serialize method
        success:function(data){
            // alert(data[0]['is_head_approved']); return false;
            $('#dataLoad').css('display','none');
            var leave_number = data[0]['control_number'];

            var modalHeader = "Control No. "+leave_number;
            var dateFrom = data[0]['date_from'].split('-');
                dateFrom = dateFrom[1]+"/"+dateFrom[2]+"/"+dateFrom[0];
            var dateTo = data[0]['date_to'].split('-');
                dateTo = dateTo[1]+"/"+dateTo[2]+"/"+dateTo[0];
            var notif1 = "", notif2 = "", notif3 = "";
            // var notification = data[0]['notification'].split('|');
            (data[0]['is_head_approved']!=1) ? $("#leave_form").hide() : $("#leave_form").show();
            (data[0]['is_cancelled']==1 || data[0]['is_denied']==1 || data[0]['is_taken']==1 ) ? $("#cancel_leave").hide() : $("#cancel_leave").show();
            $("#update_leave").hide();
            // $("#cancel_leave").hide();
            $("#deny_leave").hide();
            $("#approve_leave").hide();
            $("#taken_leave").hide();
            // $("#date_from").removeAttr('disabled');
            // $("#date_to").removeAttr('disabled');
            // $("#leave_type").removeAttr('disabled');
            // $("#reason").removeAttr('disabled');
            $("#div_others").attr('hidden',true);
            // $("#others_leave").attr('hidden',true);
            $("#others_leave").removeAttr('readonly');
            /*$("input[name='leave_notification[]']").each( function() {
                $(this).removeAttr("disabled");
            });*/


            /*$("input[name='leave_notification[]']").each( function() {
                $(this).prop("checked", false);
                for (var i=0; i<notification.length; i++) {
                    if (notification[i]==$(this).val()) {
                        $(this).prop("checked", true);
                    }
                }
            });*/
            $("#hid_leave_id").val(data[0]['id']);
            $("#myModalLabel").html(modalHeader);
            $("#name").text(data[0]['name']);
            $("#employee_number").text(data[0]['employee_id']);
            $("#hid_dept").val(data[0]['department']);
            $("#department").text(data[0]['dept']);
            $("#date_applied").text(formatDates(data[0]['date_applied']));
            
            $("#leave_type").val(data[0]['leave_type']);
            if (data[0]['leave_type']=="Others") {
                $("#div_others").attr('hidden',false);
                $("#others_leave").attr('hidden',false);
                $("#others_leave").val(data[0]['others']);
            }
            $("#view_date_applied").val(data[0]['date_applied']);
            $("#date_from").val(dateFrom);
            $("#date_to").val(dateTo);
            $("#hid_no_days").val(data[0]['no_of_days']);
            $("#reason").val(data[0]['reason']);
            $("#td_balance").html(data[0]['balance']);

            if (data['role_type']=='ADMIN' || data['role_type']=='SUPER ADMIN') {
                if (data['auth_id']==data[0]['supervisor']) {
                    // $("#date_from").attr('disabled', true);
                    // $("#date_to").attr('disabled', true);
                    // $("#leave_type").attr('disabled', true);
                    // $("#reason").attr('disabled', true);
                    // $("#others_leave").attr('readonly', true);
                    /*$("input[name='leave_notification[]']").each( function() {
                        $(this).attr("disabled", true);
                    });*/
                    if (data[0]['status']=="Pending") {
                        $("#deny_leave").show();
                        $("#approve_leave").show();
                    } /*else {
                        if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                            $("#cancel_leave").hide();
                        } else {
                            $("#cancel_leave").show();
                        }
                    }*/
                } else {
                    if (data['auth_id']==data[0]['employee_id']) {
                        if (data[0]['status']=="Pending") {
                            $("#update_leave").show();
                        } else {
                            // $("#date_from").attr('disabled', true);
                            // $("#date_to").attr('disabled', true);
                            // $("#leave_type").attr('disabled', true);
                            // $("#reason").attr('disabled', true);
                            // $("#others_leave").attr('readonly', true);
                            /*$("input[name='leave_notification[]']").each( function() {
                                $(this).attr("disabled", true);
                            });*/
                            /*if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                                $("#cancel_leave").hide();
                            } else {
                                $("#cancel_leave").show();
                            }*/
                        }
                    } else {
                        // $("#date_from").attr('disabled', true);
                        // $("#date_to").attr('disabled', true);
                        // $("#leave_type").attr('disabled', true);
                        // $("#reason").attr('disabled', true);
                        // $("#others_leave").attr('readonly', true);
                        /*$("input[name='leave_notification[]']").each( function() {
                            $(this).attr("disabled", true);
                        });*/
                        /*if (data['auth_department']==1) {
                            if (data[0]['status']=="Head Approved") {
                                $("#taken_leave").show();
                            }
                        }*/
                    }
                }
            } else {
                // alert(data[0]['status']); return false;
                if (data[0]['status']=="Pending") {
                    $("#update_leave").show();
                } else {
                    /*if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                        $("#cancel_leave").hide();
                    } else {
                        $("#cancel_leave").show();
                    }*/
                    // $("#date_from").attr('disabled', true);
                    // $("#date_to").attr('disabled', true);
                    // $("#leave_type").attr('disabled', true);
                    // $("#reason").attr('disabled', true);
                    // $("#others_leave").attr('readonly', true);
                    /*$("input[name='leave_notification[]']").each( function() {
                        $(this).attr("disabled", true);
                    });*/
                }
            }
            /* OPEN MODAL View */
            $("#myModal").modal("show");
        }
    });

    });
    
});



    $("#date_from").change(function(){
        // alert($("#reason").val()); return false;
        $("#number_of_days").html('');
        $("#date_from").val()=='' ? $("#date_to").val($(this).val()) : $("#date_to").val();
        /*leaveValidation(
            $(this).val(),
            $("#date_to").val(),
            $("#leave_type").val()
            );
        submitLeaveValidation (
            $("#leave_type").val(),
            $("#others_leave").val(),
            $(this).val(),
            $("#date_to").val(),
            $("#reason").val()
            );*/
    });


document.getElementById("leave_form").onclick = function(){
    var $leave_id = document.getElementById('hid_leave_id').value;
    location.href = "/hris/view-leave/form-leave/"+$leave_id;
}

</script>
