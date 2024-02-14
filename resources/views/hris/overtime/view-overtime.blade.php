
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
                                        @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                        <!-- FILTER by Department -->
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <div class="form-floating" id="divfilterDepartment">
                                                <select name="filterDepartment" id="filterDepartment" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Officess</option>
                                                    {{-- @foreach ($departments as $dept)
                                                    <option>{{ $dept->department }}</option>
                                                    @endforeach --}}
                                                </select>
                                                <x-jet-label for="filterDepartment" value="{{ __('OFFICE') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <div class="form-floating" id="divfilterDepartment">
                                                <select name="filterDepartment" id="filterDepartment" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Departments</option>
                                                    {{-- @foreach ($departments as $dept)
                                                    <option>{{ $dept->department }}</option>
                                                    @endforeach --}}
                                                </select>
                                                <x-jet-label for="filterDepartment" value="{{ __('DEPARTMENT') }}" />
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-4 px-1 text-center mt-1">
                                            <!-- FILTER by Leave Type -->
                                            <div class="form-floating" id="div_filterLeaveType">
                                                <select name="filterLeaveStatus" id="filterLeaveStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                                    <option value="">All Overtime Statuses</option>
                                                    {{-- @foreach ($leave_statuses as $leave_status)
                                                    <option>{{ $leave_status->leave_status }}</option>
                                                    @endforeach --}}
                                                </select>
                                                <x-jet-label for="filterLeaveStatus" value="{{ __('OVERTIME STATUS') }}" />
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

                                <div class="col-md-4 pt-2 item-right text-center mt-1 ">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58 || Auth::user()->id==124 || Auth::user()->id==126)
                                            <div class="form-group btn btn-outline-success d-inline-block rounded capitalize hover">
                                                <i class="fas fa-table"></i>
                                                <span id="exportExcelOvertimes" class="font-weight-bold">Export to Excel</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <x-jet-button id="requestNewOvertime">Request New Overtime</x-jet-button>
                                        </div>
                                    </div>
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
                                                    <td>{{ $viewOT->name }}</td>
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
                                                    <td class="open_overtime {{ ($viewOT->ot_status=='cancelled'||$viewOT->ot_status=='denied') ? 'red-color' : 'green-color' }} items-center text-sm leading-4 font-medium">{{ $viewOT->ot_status }}</td>
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

{{-- MODAL --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header banner-blue py-2">
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
                        {{-- <x-jet-button type="button" id="exportOTpdf" name="exportOTpdf">
                            {{ __('Export PDF') }}
                        </x-jet-button> --}}
                        {{-- <x-jet-button type="button" id="otUpdate" name="otUpdate">
                            {{ __('Update') }}
                        </x-jet-button> --}}
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

</x-app-layout>



<script>



$(document).ready( function () {
    
    if (("{{ count($viewOTS) }}") == 0) { return false; }
    var tableLeaves = $('#dataViewOvertimes').DataTable({
        "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
      });


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
    $('#exportExcelOvertimes').click(function() {
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

    /* Reroute to Request Overtime Form */
    $(document).on('click','#requestNewOvertime', async function() {
        window.location.href = "{{ route('hris.overtime') }}";
    });

    /* Viewing Leave Details per Control Number - Gibs */
    $(document).on('dblclick','.view-overtime',function(){
        let otID = this.id;
        // hris/view-overtime-details
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/hris/view-overtime-details',
            method: 'get',
            data: {'id': $(this).attr('id')}, // prefer use serialize method
            success: function (data) {
                const { otDtls } = data;

                // Check if otDtls is not empty
                if (otDtls) {
                    // Additional code (if needed) after displaying the Swal modal
                    var otControlNumber = otDtls.ot_control_number;
                    var modalHeader = "Control No. " + otControlNumber;
                    const supervisor = "{{ Auth::user()->supervisor }}";
                    const isHead = "{{ Auth::user()->is_head }}";
                    const employeeID = "{{ Auth::user()->employee_id }}";

                    otDtls.is_cancelled==1 ? $('#otCancelRequest').hide() : $('#otCancelRequest').show();

                    if (isHead ==1) {
                        if (otDtls.employee_id==supervisor) {
                            $('#otDenyRequest').hide();
                            $('#otApproveRequest').hide();
                        } else {
                        // Swal.fire({ html:otDtls.employee_id+"<br>"+supervisor }); return false;
                            if (otDtls.employee_id==employeeID) {
                                $('#otDenyRequest').hide();
                                $('#otApproveRequest').hide();
                            } else {
                                if (otDtls.ot_status=='pending'){
                                    $('#otDenyRequest').show();
                                    $('#otApproveRequest').show();
                                } else {
                                    $('#otDenyRequest').hide();
                                    $('#otApproveRequest').hide();
                                }
                            }
                        }
                    } else {
                        $('#otDenyRequest').hide()
                        $('#otApproveRequest').hide();
                    }

                    $("#myModalLabel").html(modalHeader);
                    $('#dotName').val(otDtls.name);
                    $('#dotEmployeeNumber').val(otDtls.employee_id);
                    $('#dotDateApplied').val(otDtls.date_applied);
                    $('#dotOffice').val(otDtls.office);
                    $('#dotDepartment').val(otDtls.department);
                    $('#dotSupervisor').val(otDtls.supervisor);
                    $('#dotLocation').val(otDtls.ot_location);
                    $('#dotBeginDate').val(otDtls.begin_date);
                    $('#dotEndDate').val(otDtls.end_date);
                    $('#dotReason').val(otDtls.ot_reason);
                    $('#dtdHours').html(otDtls.ot_hours);
                    $('#dtdMinutes').html(otDtls.ot_minutes);
                    $('#dtdTotalHours').html(otDtls.total_hours);
                    $('#dotHidId').val(otID);
                    $("#myModal").modal("show");
                } else {
                    // Handle the case when otDtls is empty
                    console.log('No data available');
                }
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        }); return false;

    });

    // Cancel Request
    $(document).on('click', '#otCancelRequest', async function() {
        btn_clicked = "cancelled";
        confirmModals(btn_clicked);
    });

    // Deny Request by Head/Supervisor
    $(document).on('click', '#otDenyRequest', async function() {
        btn_clicked = "denied";
        confirmModals(btn_clicked);
    });

    // Approve Request by Head/Supervisor
    $(document).on('click','#otApproveRequest',async function() {
        // Swal.fire({text: 'Approve Request'});
        const otId = $('#dotHidId').val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: window.location.origin+"/hris/approve-overtime",
            method: 'post',
            data: {
            'otId': otId
            }, // prefer use serialize method
            success:function(data){
                // Swal.fire({ html: data }); return false;
                const {isSuccess,message} = data;

                $("#modalConfirm").modal('hide');
                $("#myModal").modal('hide');

                isSuccess ?
                    (Livewire.emit('refetchAcc'),
                    Swal.fire({
                        icon:'success',
                        title:'Success',
                        text:message
                    }))
                :
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text:JSON.stringify(message)
                    })
            }
        });
        return false;
    });

    $(document).on('click','#clostBtn',async function () {
        $('#modalConfirm').modal('hide');
    });

    $(document).on('click','#confirmBtn',async function () {

        if ($('#otConfirmReason').val()==''){
            $('#otConfirmReason').addClass('placeholder-warning');
            $('#otConfirmReason').focus();
        } else {
            const otId = $('#dotHidId').val();
            var url = '';
            if (btn_clicked=='cancelled') {
                url = window.location.origin+"/hris/cancel-overtime";
            } else if (btn_clicked=='denied') {
                url = window.location.origin+"/hris/deny-overtime";
            }
            
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
                url: url,
                method: 'post',
                data: {
                'otId': otId,
                'action' : btn_clicked,
                'reason' : $("#otConfirmReason").val()
                }, // prefer use serialize method
                success:function(data){
                    const {isSuccess,message} = data;

                    $("#modalConfirm").modal('hide');
                    $("#myModal").modal('hide');

                    isSuccess ?
                        (Livewire.emit('refetchAcc'),
                        Swal.fire({
                            icon:'success',
                            title:'Success',
                            text:message
                        }))
                    :
                        Swal.fire({
                            icon:'error',
                            title:'Error',
                            text:JSON.stringify(message)
                        })
                }
            });
        }
        return false;
    });

    function confirmModals(btn) {
        var message='',modalHeader='';
        if (btn=='cancelled') {
            message = "Reason for cancellation of request";
            modalHeader = "Confirm Cancel";
        } else {
            message = "Reason for denying of request";
            modalHeader = "Confirm Deny";
        }

        $('#confirmModalLabel').html(modalHeader);
        $("#confirmMessage").html(message);
        $("#otConfirmReason").val('');
        $("#otConfirmReason").removeClass('placeholder-warning');
        $("#modalConfirm").modal('show');
        $(".modal-dialog").draggable({
            cursor: "move"
        });
    }
    
});



</script>
