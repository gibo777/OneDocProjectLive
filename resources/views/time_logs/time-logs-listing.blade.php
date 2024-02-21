
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
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataTimeLogs thead th {
        text-align: center; /* Center-align the header text */
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
                                        <select name="filterTimeLogsOffice" id="filterTimeLogsOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Offices</option>
                                            @foreach ($offices as $office)
                                            <option>{{ $office->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="filterTimeLogsOffice" value="{{ __('OFFICE') }}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfilterTimeLogsDept">
                                        <select name="filterTimeLogsDept" id="filterTimeLogsDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Departments</option>
                                            @foreach ($departments as $department)
                                            {{-- <option value="{{ $department->department_code }}">{{ $department->department }}</option> --}}
                                            <option>{{ $department->department }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="filterTimeLogsDept" value="{{ __('DEPARTMENT') }}" />
                                    </div>
                                </div>

                                <div class="col-md-4 px-3 text-center mt-1">
                                    <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
                                    <input type="date" id="dateFrom" name="dateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                    to
                                    <input type="date" id="dateTo" name="dateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2 pt-2 text-center mt-1 ">
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
                                                    <td>{{ $employee->full_name }}</td>
                                                    <td class="p-0">{{ $employee->employee_id }}</td>
                                                    <td>{{ $employee->office }}</td>
                                                    <td>{{ $employee->department }}</td>
                                                    <td>{{ $employee->time_in ? date('m/d/Y g:i A',strtotime($employee->time_in)) : '' }}</td>
                                                    <td>{{ $employee->time_out ? date('m/d/Y g:i A',strtotime($employee->time_out)) : '' }}</td>
                                                    <td>{{ $employee->head_name }}</td>
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




<script type="text/javascript">
$(document).ready(function() {

    if (("{{ count($employees) }}") == 0) { return false; }
    // Initialize DataTable
    var table = $('#dataTimeLogs').DataTable({
        /*"order": [
            [3, 'desc'],
            [4, 'desc'],
            [0, 'asc'],
        ],*/
        "order": [],
        /*"columnDefs": [
          { width: '170px', targets: [3] }, 
        ],*/
        // "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
    });

    function formatDate(inputDate) {
        var date = new Date(inputDate); // Create a Date object from the input string
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0"); // Pad the month with leading zeros if needed
        var day = String(date.getDate()).padStart(2, "0"); // Pad the day with leading zeros if needed

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month,day,year].join("/");
      }

    /*$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sD  = $('#filterTimeLogsDept').val();
            var cD  = data[2]; // Department Column
            
            // Check if a department filter is selected
            var departmentFilterActive = (sD != null && sD !== '');

            // Apply both filters
            if (!departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var departmentMatch = !departmentFilterActive || cD.includes(sD);

            return departmentMatch;
        
    });*/

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sTO  = $('#filterTimeLogsOffice').val();
            var sTD = $('#filterTimeLogsDept').val();
            var cTO  = data[2]; // Office Column
            var cTD = data[3]; // Department Column
            // alert(cTD); return false;
            
            // Check if a department filter is selected
            var officeFilterActive = (sTO != null && sTO !== '');

            // Check if a LeaveType filter is selected
            var departmentFilterActive = (sTD != null && sTD !== '');

            // Apply both filters
            if (!officeFilterActive && !departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var officeMatch = !officeFilterActive || cTO.includes(sTO);
            var departmentMatch = !departmentFilterActive || cTD.includes(sTD);

            return officeMatch && departmentMatch;
       
        
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
        var searchTimeIn = data[3];
        var searchTimeOut = data[4];

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


    $('#filterTimeLogsOffice').on('keyup change', function() {
        table.draw();
    });
    $('#filterTimeLogsDept').on('keyup change', function() {
        table.draw();
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
                    // text: '',
                }).then(function() {
                    $(this).val('');
                });
            }
        }
        table.draw();
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
                // text: '',
            });
        }
        table.draw();
    });
    /* END - Date From and Date To Searching */





    /* Double Click event to show Employee details */
    $(document).on('dblclick','.view-detailed-timelogs tr',async function(){
        // alert($(this).attr('id')); return false;


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
            url: '/timelogs-detailed',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){
                let tableStructure = `<table id="dataDetailedTimeLogs" class="table table-bordered data-table sm:justify-center table-hover">
                        <thead class="thead">
                            <tr>
                                <th>Photo</th>
                                <th>Time-In</th>
                                <th>Time-Out</th>
                            </tr>
                        </thead>
                        <tbody class="data text-center" id="data">`;

                // Function to fetch content and return a promise
                function fetchContent(n) {
                    return new Promise((resolve, reject) => {
                        var basePath = '{{ asset('storage/timelogs') }}';
                        var imagePath = data[n]['image_path'];
                        var fullFilePath = basePath + '/' + imagePath + '.txt';

                        fetch(fullFilePath)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Failed to fetch file");
                                }
                                return response.text();
                            })
                            .then(fileContent => {
                                resolve(`<tr>
                                            <td><img width="124px" src="${fileContent}" /></td>
                                            <td>${data[n]['time_in']}</td>
                                            <td>${data[n]['time_out']}</td>
                                        </tr>`);
                            })
                            .catch(error => {
                                console.error("Error reading the file:", error);
                                reject(error);
                            });
                    });
                }

                // Array to store promises
                let promises = [];

                // Loop through data and create promises
                for (let n = 0; n < data.length; n++) {
                    promises.push(fetchContent(n));
                }

                // Wait for all promises to resolve
                Promise.all(promises)
                    .then(rows => {
                        // Append the rows to the table structure
                        tableStructure += rows.join('');
                        tableStructure += `</tbody></table>`;

                        // Show the table using Swal.fire
                        Swal.fire({
                            allowOutsideClick: false,
                            html: tableStructure
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching content:", error);
                    });

                $('#dataLoad').css('display','none');
            }
        });
    });

    /* EXPORT TO EXCEL TIMELOGS */
    $('#exportExcel').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/timelogs-excel',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){

                var blob = new Blob([data], { type: 'application/octet-stream' });
                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = 'SVV_V3.xlsx'; // Use .xls extension for Excel files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
            }
        }); 
        return false;

    });









});
</script>

</x-app-layout>




