
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
        padding: 5px !important; /* Adjust the padding value as needed */
    }
}
</style>
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataViewLeaves thead th {
        text-align: center; /* Center-align the header text */
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
        <div class="w-full mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="leave-form" action="{{ route('hris.leave.view-leave-details') }}" method="POST">
            @csrf

            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                        <div id="filter_fields" class="grid grid-cols-6 py-1 gap-2">
                            <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                <!-- <div class="col-span-8 sm:col-span-1">
                                    <x-jet-label for="filter_search" value="{{ __('SEARCH') }}" />
                                    <x-jet-input id="filter_search" name="filter_search" type="text" class="mt-1 block w-full" placeholder="Name or Employee No."/>
                                </div> -->
                                <!-- FILTER by Department -->
                                <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_department">
                                    <x-jet-label for="filter_department" value="{{ __('DEPARTMENT') }}" />
                                    <select name="filter_department" id="filter_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="">All Departments</option>
                                        @foreach ($departments as $dept)
                                        <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <!-- FILTER by Leave Type -->
                                <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_leave_type">
                                    <x-jet-label for="filter_leave_type" value="{{ __('LEAVE TYPE') }}" />
                                    <select name="filter_leave_type" id="filter_leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="">All Leave Types</option>
                                        @foreach ($leave_types as $leave_type)
                                        <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                  <!-- DIV_GRID4 -->
                                  <div class="col-span-8 sm:col-span-1 hidden" id="div_grid4">
                                   {{-- <h1>dhaodhia</h1> --}}
                                </div>
                                  <!-- DIV_GRID5 -->
                                  <div class="col-span-8 sm:col-span-1 hidden" id="div_grid5">
                                   {{-- <h1>jdaidjai</h1> --}}
                                </div>
                                 <!-- DIV_GRID6 -->
                                 <div class="col-span-8 sm:col-span-1 " id="div_grid6">

                                </div>

                                {{-- <svg xmlns="http://www.w3.org/2000/svg" style="width:11%;" onclick="printreport()" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zm-16-88c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24z"/></svg> --}}
                                {{-- <i class="fa fa-print" style="font-size: 40px;" onclick="printreport()"></i> --}}
                                {{-- <i class="fa fa-print" style="font-size: 40px; margin-left: 81%;" onclick="printreport()"></i> --}}
                                {{-- <img src="/img/printer.png" style="width: 30%;
                                margin-left: 68%;" onclick="printreport()"> --}}

                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataViewLeaves" class="table table-bordered table-striped sm:justify-center table-hover">

                                        <thead class="thead">

                                            <tr>
                                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                <th>Name</th>
                                                <th>Emp. No.</th>
                                                <th>Department</th>
                                                @endif
                                                <th>Control#</th>
                                                <th>Leave Type</th>
                                                <th>Date Applied</th>
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
                                                <tr class="view-leave" id="{{ $leave->id }}">
                                                    @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                    <td>{{ $leave->name }}</td>
                                                    <td>{{ $leave->employee_id }}</td>
                                                    <td>{{ $leave->dept }}</td>
                                                    @endif
                                                    <td>{{ $leave->control_number }}</td>
                                                    <td>{{ $leave->leave_type }}</td>
                                                    <td>{{ date('m/d/Y g:i A',strtotime($leave->date_applied)) }}</td>
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
                                                            class="open_leave green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500"
                                                            >
                                                            {{ $leave->status }}
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
                                <div class="mt-1">
                                <i class="fa fa-print inline-flex items-center justify-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition hover" onclick="printreport()">&nbsp;print</i>
                                </div>
                                @endif
                    </div>
                </div>
            </div>
            </form>
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
        <div class="modal-header">
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
                                        <!-- <div class="col-span-8 sm:col-span-1">
                                            <x-jet-label for="filter_search" value="{{ __('SEARCH') }}" />
                                            <x-jet-input id="filter_search" name="filter_search" type="text" class="mt-1 block w-full" placeholder="Name or Employee No."/>
                                        </div> -->
                                        <!-- FILTER by Department -->
                                        <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_department">
                                            <x-jet-label for="filter_department" value="{{ __('DEPARTMENT') }}" />
                                            <select name="filter_department" id="filter_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                                <option value="">All Departments</option>
                                                @foreach ($departments as $dept)
                                                <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <!-- FILTER by Leave Type -->
                                        <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_leave_type">
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
        <div class="modal-header">
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
                              <th># of Days</th>
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
      <div class="modal-header">
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
                        <select name="leave_type" id="leave_type" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="LEAVE TYPE">
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
                                    <x-jet-input id="date_from" name="date_from" type="text" class="form-control datepicker date-input" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <x-jet-label for="date_from" value="{{ __('BEGIN (mm/dd/yyyy)') }}" class="w-full" />
                                </div>
                            </div>
                            TO
                            <div class="col-md-5">
                                <div class="form-floating">
                                    <x-jet-input id="date_to" name="date_to" type="text" class="form-control datepicker date-input" placeholder="mm/dd/yyyy" autocomplete="off"/>
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
                                <textarea id="reason" name="reason" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-1/2" placeholder="REASON" /> </textarea>
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
                        @if (Auth::user()->is_head==1)
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
      <div class="modal-header">
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


</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>

<x-jet-input id="hid_access_id" name="hid_access_id" value="{{ Auth::user()->access_code }}" type="text" hidden/>


{{-- DAGDAG NI MARK FOR PRINT FUNCTION --}}
<script>
     function printreport(){
        $("#printtable").printThis();
        // $("#printVisitModal").modal('show');
        // console.log("PRINT FUNCTION FUNCTIONAL");
    }
$(document).ready( function () {
    $('#dataViewLeaves').DataTable({
            "lengthMenu": [ 5,10, 25, 50, 75, 100 ], // Customize the options in the dropdown
            "iDisplayLength": 5 // Set the default number of entries per page
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
            $("#update_leave").hide();
            $("#cancel_leave").hide();
            $("#deny_leave").hide();
            $("#approve_leave").hide();
            $("#taken_leave").hide();
            $("#date_from").removeAttr('disabled');
            $("#date_to").removeAttr('disabled');
            $("#leave_type").removeAttr('disabled');
            $("#reason").removeAttr('disabled');
            $("#div_others").attr('hidden',true);
            $("#others_leave").attr('hidden',true);
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
            if (data[0]['status']=="Pending") {
                $("#date_applied").text(currentDate());
            } else {
                $("#date_applied").text(formatDates(data[0]['date_applied']));
            }
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
                    $("#date_from").attr('disabled', true);
                    $("#date_to").attr('disabled', true);
                    $("#leave_type").attr('disabled', true);
                    $("#reason").attr('disabled', true);
                    $("#others_leave").attr('readonly', true);
                    /*$("input[name='leave_notification[]']").each( function() {
                        $(this).attr("disabled", true);
                    });*/
                    if (data[0]['status']=="Pending") {
                        $("#deny_leave").show();
                        $("#approve_leave").show();
                    } else {
                        if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                            $("#cancel_leave").hide();
                        } else {
                            $("#cancel_leave").show();
                        }
                        /*if (data['auth_department']==1) {
                            $("#taken_leave").show();
                        }*/
                    }
                } else {
                    if (data['auth_id']==data[0]['employee_id']) {
                        if (data[0]['status']=="Pending") {
                            $("#update_leave").show();
                        } else {
                            $("#date_from").attr('disabled', true);
                            $("#date_to").attr('disabled', true);
                            $("#leave_type").attr('disabled', true);
                            $("#reason").attr('disabled', true);
                            $("#others_leave").attr('readonly', true);
                            /*$("input[name='leave_notification[]']").each( function() {
                                $(this).attr("disabled", true);
                            });*/
                            if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                                $("#cancel_leave").hide();
                            } else {
                                $("#cancel_leave").show();
                            }
                        }
                    } else {
                        $("#date_from").attr('disabled', true);
                        $("#date_to").attr('disabled', true);
                        $("#leave_type").attr('disabled', true);
                        $("#reason").attr('disabled', true);
                        $("#others_leave").attr('readonly', true);
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
                    if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied" || data[0]['is_taken']==1) {
                        $("#cancel_leave").hide();
                    } else {
                        $("#cancel_leave").show();
                    }
                    $("#date_from").attr('disabled', true);
                    $("#date_to").attr('disabled', true);
                    $("#leave_type").attr('disabled', true);
                    $("#reason").attr('disabled', true);
                    $("#others_leave").attr('readonly', true);
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
        alert($("#reason").val()); return false;
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
