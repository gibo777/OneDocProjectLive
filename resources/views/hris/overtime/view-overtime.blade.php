
<x-app-layout>

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
    #dataViewOvertimes thead th {
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
    .no-border-background {
        border: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-weight: 550 !important;
    }
    
    </style>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <x-slot name="header">
                {{ __('REQUESTED OVERTIMES') }}
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
            {{-- <form id="leave-form" action="{{ route('hris.view-overtime') }}" method="POST">
            @csrf --}}

            <div class="px-4 bg-white sm:p-3 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="col-span-8 sm:col-span-8 sm:justify-center">

                        <div class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1" id="filterFields">

                                <div class="col-md-5 text-center mt-1">
                                    <div class="row mx-1">
                                        {{-- @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN') --}}
                                        <!-- FILTER by Department -->
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <div class="form-floating" id="divFOtOffice">
                                                <select name="fOtOffice" id="fOtOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Officess</option>
                                                    @foreach ($offices as $office)
                                                    <option>{{ $office->company_name }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="fOtOffice" value="{{ __('OFFICE') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <div class="form-floating" id="divFDepartment">
                                                <select name="fOtDept" id="fOtDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Departments</option>
                                                    @foreach ($departments as $dept)
                                                    <option>{{ $dept->department }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="fOtDept" value="{{ __('DEPARTMENT') }}" />
                                            </div>
                                        </div>
                                        {{-- @endif --}}

                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <!-- FILTER by Leave Type -->
                                            <div class="form-floating" id="divFReqStatus">
                                                <select name="fReqStatus" id="fReqStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Statuses</option>
                                                    @foreach ($request_statuses as $request_status)
                                                    <option>{{ $request_status->request_status }}</option>
                                                    @endforeach
                                                </select>
                                                <x-jet-label for="fReqStatus" value="{{ __('OT STATUS') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

			                    <div class="col-md-3 px-1 text-center mt-1">
			                    	<x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
			                    	<input type="date" id="fOtDateFrom" name="fOtDateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
			                    	to
			                    	<input type="date" id="fOtDateTo" name="fOtDateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
			                    </div>

                                <div class="col-md-4 pt-2 item-right text-center mt-1 ">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if (Auth::user()->id==1)
                                            <div class="form-group btn btn-outline-success d-inline-block rounded capitalize hover">
                                                <i class="fas fa-table"></i>
                                                <span id="exportExcelOvertimes" class="font-weight-bold">Export to Excel</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <x-jet-button id="requestNewOvertime" data-route="{{ route('hris.overtime') }}">Request New Overtime</x-jet-button>
                                        </div>
                                    </div>
                                </div>
		                    </div>
                        </div>


                        </div>
                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataViewOvertimes" class="table table-bordered table-striped sm:justify-center table-hover">

                                        <thead class="thead">
                                            <tr>
                                                <th>Name</th>
                                                <th>Office</th>
                                                <th>Department</th>
                                                <th>OT Control#</th>
                                                <th>OT Location</th>
                                                <th>Begin Date</th>
                                                <th>End Date</th>
                                                <th>Total Hours</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewLeave">
                                            @forelse($viewOTS as $viewOT)
                                                <tr class="view-overtime text-sm text-lg-lg" id="{{ $viewOT->id }}">
                                                    @if (url('/')=='http://localhost')
                                                        <td>xxx, xxx x.</td>
                                                    @else
                                                        <td>{{ $viewOT->name }}</td>
                                                    @endif
                                                    <td>{{ $viewOT->office }}</td>
                                                    <td>{{ $viewOT->department }}</td>
                                                    <td>{{ $viewOT->ot_control_number }}</td>
                                                    <td>{{ $viewOT->ot_location }}</td>
                                                    {{-- <td>{{ $viewOT->ot_date_from.' '.$viewOT->ot_time_from }}</td>
                                                    <td>{{ $viewOT->ot_date_to.' '.$viewOT->ot_time_to }}</td> --}}
                                                    <td>{{ $viewOT->ot_datetime_from }}</td>
                                                    <td>{{ $viewOT->ot_datetime_to }}</td>
                                                    <td>{{ $viewOT->total_hours }}</td>
                                                    @if ($viewOT->ot_status!='pending')
                                                    <td id="status_view" class="open_history">
                                                        <button
                                                            id="{{ $viewOT->id }}"
                                                            value="{{ $viewOT->id }}"
                                                            title="Show History #{{ $viewOT->ot_control_number }}"
                                                            class="open_overtime {{ ($viewOT->ot_status=='cancelled'||$viewOT->ot_status=='denied') ? 'red-color' : 'green-color' }} inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500"
                                                            >
                                                            {{ strtoupper($viewOT->ot_status) }}
                                                        </button></td>
                                                    @else
                                                    <td>{{ $viewOT->ot_status }}</td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">No record found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>

{{-- MODAL --}}
{{-- Modal for History --}}
<div class="modal fade" id="myModalOT" tabindex="-1" role="dialog" aria-labelledby="otHistoryLabel" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header banner-blue py-2">
          <h4 class="modal-title text-lg text-white" id="otHistoryLabel"></h4>
          <button type="button" class="close btn fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>
        <div class="modal-body bg-gray-50">
            <div class="row w-full">
                <div class="col-md-6">
                    <x-jet-label id="otHName" class="text-nowrap"></x-jet-label>
                </div>
                <div class="col-md-6">
                    <x-jet-label id="otHSupervisor" class="text-nowrap"></x-jet-label>
                </div>
            </div>
              <div class="col-span-6 sm:col-span-6 sm:justify-center font-medium scrollable">
              <table id="data_history" class="table table-bordered table-striped sm:justify-center table-hover">
                  <thead class="thead">
                      <tr>
                          <th>Status</th>
                          <th class="text-nowrap">Reason</th>
                          <th class="text-nowrap">Action Date</th>
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
<!-- =========================================== -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header banner-blue py-1">
        <h5 class="modal-title text-white" id="myModalLabel"></h5>
        <button type="button" class="close fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body px-4">

                <div class="row inset-shadow rounded">
                    <div class="col-md-5 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotName" name="dotName" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="NAME" disabled/>
                            <x-jet-label for="dotName" value="{{ __('NAME') }}" />
                        </div>
                    </div>

                    <div class="col-md-3 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotEmployeeNumber" name="dotEmployeeNumber" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="EMPLOYEE #" disabled/>
                            <x-jet-label for="dotEmployeeNumber" value="{{ __('EMPLOYEE #') }}" />
                        </div>
                    </div>

                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotDateApplied" name="dotDateApplied" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="DATE APPLIED" disabled/>
                            <x-jet-label for="dotDateApplied" value="{{ __('DATE APPLIED') }}" />
                        </div>
                    </div>

                </div>

                <div class="row inset-shadow rounded mt-1">
                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotOffice" name="dotOffice" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="OFFICE" disabled/>
                            <x-jet-label for="dotOffice" value="{{ __('OFFICE') }}" />
                        </div>
                    </div>
                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotDepartment" name="dotDepartment" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="DEPARTMENT" disabled/>
                            <x-jet-label for="dotDepartment" value="{{ __('DEPARTMENT') }}" />
                        </div>
                    </div>
                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotSupervisor" name="dotSupervisor" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="SUPERVISOR" disabled/>
                            <x-jet-label for="dotSupervisor" value="{{ __('SUPERVISOR') }}" />
                        </div>
                    </div>
                </div>

                <div class="row inset-shadow rounded mt-1">
                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotLocation" name="dotLocation" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="OT LOCATION" disabled/>
                            <x-jet-label for="dotLocation" value="{{ __('OT LOCATION') }}" />
                        </div>
                    </div>

                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotBeginDate" name="dotBeginDate" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="OT Begin" disabled/>
                            <x-jet-label for="dotBeginDate" value="{{ __('OT Begin Date') }}" />
                        </div>
                    </div>
                    <div class="col-md-4 p-1">
                        <div class="form-floating">
                            <x-jet-input id="dotEndDate" name="dotEndDate" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" placeholder="OT End" disabled/>
                            <x-jet-label for="dotEndDate" value="{{ __('OT End Date') }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 p-1 inset-shadow rounded mt-1">
                        <div class="form-floating">
                            <textarea id="dotReason" name="dotReason" class="form-control text-xl text-gray-800 leading-tight items-center sm:justify-center no-border-background" disabled/></textarea>
                            <x-jet-label for="dotReason" value="{{ __('REASON') }}" />
                        </div>
                    </div>
                    <div class="col-md-6 text-center mt-2">
                        <table class="table-bordered data-table mx-auto text-center">
                            <tr>
                                <th>Hours</th>
                                <th>Minutes</th>
                                <th>Total Hours</th>
                            </tr>
                            <tr>
                                <td id="dtdHours"></td>
                                <td id="dtdMinutes"></td>
                                <td id="dtdTotalHours"></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
                

                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <div>
                        <x-jet-button type="button" id="otCancelRequest" name="otCancelRequest">
                            {{ __('CANCEL REQUEST') }}
                        </x-jet-button>
                        <x-jet-button type="button" id="otDenyRequest" name="otDenyRequest">
                            {{ __('DENY') }}
                        </x-jet-button>
                        <x-jet-button type="button" id="otApproveRequest" name="otApproveRequest">
                            {{ __('APPROVE') }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- =========================================== -->
<!-- Modal for Cancellation -->
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header banner-blue py-1">
        <h4 class="modal-title text-lg text-white w-full text-center" id="confirmModalLabel"></h4>
      </div>
      <div class="modal-body bg-gray-50">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="fCancelRequest" method="POST" action="">
        @csrf
            <div class="grid grid-cols-5 gap-6 pb-3">
                <div class="col-span-6 sm:col-span-4 sm:justify-center font-medium">
                <p id="confirmMessage"></p>
                <textarea id="otConfirmReason" name="otConfirmReason"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                wire:model.defer="state.cancel_reason" placeholder="Kindly indicate your reason here.."></textarea>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <x-jet-input id="dotHidId" name="dotHidId" class="hidden" />
                <div>
                    <x-jet-button type="button" id="confirmBtn" name="confirmBtn">
                        {{ __('Confirm') }}
                    </x-jet-button>
                    <x-jet-button type="button" id="clostBtn" name="clostBtn">
                        {{ __('Close') }}
                    </x-jet-button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- =========================================== -->
<script type="text/javascript">
    const supervisor = "{{ Auth::user()->supervisor }}";
    const isHead = "{{ Auth::user()->is_head }}";
    const employeeID = "{{ Auth::user()->employee_id }}";
    const countOTS = "{{ count($viewOTS) }}";
    const dataRoute = $('#requestNewOvertime').attr('data-route');
</script>

<script type="text/javascript" src="{{ asset('app-modules/e-forms/view-overtime.js') }}"></script>
</x-app-layout>



