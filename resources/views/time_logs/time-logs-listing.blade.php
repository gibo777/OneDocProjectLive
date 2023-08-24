
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataTimeLogs thead th {
        text-align: center; /* Center-align the header text */
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
            @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                    <div class="mb-2">
                        From <input type="date" id="dateFrom" name="dateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off"/> to <input type="date" id="dateTo" name="dateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off"/>
                    </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th>Employee ID</th>
                                                <th>Department</th>
                                                <th>Time-In</th>
                                                <th>Time-Out</th>
                                                <th>Supervisor</th>
                                                {{-- <th>Status</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            @forelse($employees as $employee)
                                                <tr id="{{ $employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out) }}">
                                                    <td>{{ $employee->full_name }}</td>
                                                    <td>{{ $employee->employee_id }}</td>
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
<!-- Modal for History -->
<div class="modal fade" id="detailedTimeLogsModal" tabindex="-1" role="dialog" aria-labelledby="detailedTimelogsLabel" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-lg text-white" id="detailedTimelogsLabel">
              Detailed Timelogs
          </h4>
          <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>
        <div class="modal-body bg-gray-50">
              <div class="grid grid-cols-12 gap-6 pb-3">
                  <div class="col-span-12 sm:col-span-12 sm:justify-center font-medium scrollable">
                      <table id="dataDetailedTimeLogs" class="table table-bordered data-table sm:justify-center table-hover">
                          <thead class="thead">
                              <tr>
                                  <th>Photo</th>
                                  <th>Time-In</th>
                                  <th>Time-Out</th>
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
<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="{{asset('/img/misc/loading-blue-circle.gif')}}">
</div>

<!-- =========================================== -->



<script type="text/javascript">
$(document).ready(function() {


    // Initialize DataTable
    var table = $('#dataTimeLogs').DataTable({
        "order": [
            [3, 'desc'],
            [4, 'desc'],
            [0, 'asc'],
        ],
        "lengthMenu": [ 5,10, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 5 // Set the default number of entries per page
    });

    function formatDate(inputDate) {
        var date = new Date(inputDate); // Create a Date object from the input string
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0"); // Pad the month with leading zeros if needed
        var day = String(date.getDate()).padStart(2, "0"); // Pad the day with leading zeros if needed

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month,day,year].join("/");
      }


// $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
//     var startDateCol1 = $('#start-date-col1').val();
//     var endDateCol1 = $('#end-date-col1').val();
//     var startDateCol2 = $('#start-date-col2').val();
//     var endDateCol2 = $('#end-date-col2').val();
    
//     var currentDateCol1 = data[0]; // Date in the first column
//     var currentDateCol2 = data[1]; // Date in the second column

//     if (
//         // Check if current date is within range for both columns
//         ((startDateCol1 === '' || endDateCol1 === '') ||
//         (currentDateCol1 >= startDateCol1 && currentDateCol1 <= endDateCol1)) &&
//         ((startDateCol2 === '' || endDateCol2 === '') ||
//         (currentDateCol2 >= startDateCol2 && currentDateCol2 <= endDateCol2))
//     ) {
//         return true;
//     }
//     return false;
// });



    /* START - Date From and Date To Searching */
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var searchDateFrom  = formatDate($('#dateFrom').val());
            var searchDateTo    = formatDate($('#dateTo').val());
            var searchTimeIn    = data[3]; //Time-In Column, it may change depending on the exact column
            var searchTimeOut   = data[4]; //Time-Out Column
            if ( ($('#dateFrom').val()==null || $('#dateFrom').val()=='') && ($('#dateTo').val()==null || $('#dateTo').val()=='') ) { return true; }

            if (searchTimeIn.includes(searchDateFrom) || searchTimeOut.includes(searchDateFrom) || searchTimeIn.includes(searchDateTo) || searchTimeOut.includes(searchDateTo)) {
                return true;
            }
            return false;
        }
    );

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


        // $('#dataLoad').css('display','flex');
        // $('#dataLoad').css('position','absolute');
        // $('#dataLoad').css('top','40%');
        // $('#dataLoad').css('left','40%');
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
                // prompt('',data); return false;


                    // $("#dataDetailedTimeLogs > tbody").empty();

                    // for(var n=0; n<data.length; n++) {
                    //     $("#dataDetailedTimeLogs > tbody:last-child")
                    //     .append('<tr>');
                    //     $("#dataDetailedTimeLogs > tbody:last-child")
                    //     .append('<td><img src="'+data[n]['profile_photo_path']+'"></td>')
                    //     .append('<td>'+data[n]['time_in']+'</td>')
                    //     .append('<td>'+data[n]['time_out']+'</td>');
                    // }
                    // $("#detailedTimeLogsModal").modal('show');



                let tDT = `<table id="dataDetailedTimeLogs" class="table table-bordered data-table sm:justify-center table-hover">
                          <thead class="thead">
                              <tr>
                                  <th>Photo</th>
                                  <th>Time-In</th>
                                  <th>Time-Out</th>
                              </tr>
                          </thead>
                          <tbody class="data text-center" id="data">`;


                    for(var n=0; n<data.length; n++) {
                    tDT += `<tr>
                                <td><img src="`+data[n]['profile_photo_path']+
                                `"</img></td><td>`+data[n]['time_in']+`</td><td>`+data[n]['time_out']+`</td>`;
                    }

                    tDT +=`</tbody>
                      </table>`;


                    Swal.fire({
                        // icon: 'success',
                        // title: (data[0]['f_time_in']!=null) ? data[0]['f_time_in'] : data[0]['f_time_out'],
                        // text: '',
                        allowOutsideClick: false,
                        html: tDT
                    });
            }
        });
    });
                    
   
    /* Button to update Employee details */
    $('#updateEmployee > button').on('click', function() {
        var isHead = 0;
        $("#isHead").is(':checked') ? isHead = 1 : isHead = 0;
        const uD = {
            'id' : $(this).attr('id'),
            'employment_status': $("#employment_status").val(),
            'date_hired': $("#date_hired").val(),
            'update_weekly_schedule': $("#update_weekly_schedule").val(),
            'supervisor': $("#supervisor").val(),
            'name': [$("#last_name").val(), $("#first_name").val(),$("#suffix").val(),$("#middle_name").val()].join(' '),
            'employee_id' : $("#employee_id").val(), 
            'position' : $("#position").val(),
            'department' : $("#department").val(),
            'vl': $('#vacation_leaves').val(),
            'sl':$('#sick_leaves').val(),
            'ml': $('#maternity_leaves').val(),
            'pl': $('#paternity_leaves').val(),
            'el': $('#emergency_leaves').val(),
            'others':$('#other_leaves').val(),
            'roleType': $("#updateRoleType").val(),
            'is_head': isHead,
        };
        // alert(isHead); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updateemployees',
            method: 'post',
            data: uD, // prefer use serialize method
            success:function(data){
                // prompt('',data); return false;
                console.log(data);
                if(data.isSuccess==true) {
                    $("#EmployeesModal").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        // text: '',
                    }).then(function() {
                        // location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: JSON.stringify(data.message),
                    });
                }
            }
        });
    });

});
</script>

</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>


