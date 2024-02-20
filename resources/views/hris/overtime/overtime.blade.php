<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
<style type="text/css">
    th,td {
      text-transform: none !important;
    }
</style>

    <x-slot name="header">
            {{ __('REQUEST FOR OVERTIME') }}
    </x-slot>
    <div>
        <div class="max-w-6xl mx-auto mt-2">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="leave-form" method="POST" action="{{ route('hris.leave.eleave') }}">
            @csrf

            <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="row inset-shadow rounded">
                    <div class="col-md-5 pt-1">
                        <x-jet-label for="otName" value="{{ __('NAME') }}" class="w-full" />
                        <h6 id="otName">
                            {{ join(' ',[
                                    Auth::user()->last_name.',',
                                    Auth::user()->first_name,
                                    empty(Auth::user()->suffix) ? '' : Auth::user()->suffix . '',
                                    Auth::user()->middle_name
                                ]) 
                            }}
                        </h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="otEmployeeNumber" value="{{ __('EMPLOYEE #') }}" class="w-full" />
                        <h6 id="otEmployeeNumber">{{ Auth::user()->employee_id }}</h6>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label for="otDateApplied" value="{{ __('DATE APPLIED') }}" class="w-full" />
                        <h6 id="otDateApplied">{{ date('m/d/Y', strtotime($otUser->current_date)) }}</h6>
                    </div>
                </div>

                <div class="row inset-shadow rounded mt-1">
                    <div class="col-md-5 pt-1">
                        <x-jet-label for="otOffice" value="{{ __('OFFICE') }}" class="w-full" />
                        <h6 id="otOffice">{{ $otUser->office }}</h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="otDepartment" value="{{ __('DEPARTMENT') }}" class="w-full" />
                        <h6 id="otDepartment">{{ $otUser->department }}</h6>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label for="otSupervisor" value="{{ __('SUPERVISOR') }}" class="w-full" />
                        <h6 id="otSupervisor">{{ $otUser->supervisor }}</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-2 py-0 px-1">
                        <div class="form-floating">
                            <x-jet-input id="otLocation" type="text" name="otLocation" class="form-control" />
                            <label for="otLocation" class="font-weight-bold w-full">
                                OT LOCATION (Actual Location) <span class="text-danger"> *</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 align-center inset-shadow px-3">
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otDateFrom" name="otDateFrom" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateFrom" class="font-weight-bold text-secondary">
                                        OT Begin Date<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 p-0">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otTimeFrom" name="otTimeFrom" type="time" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateFrom" class="font-weight-bold text-secondary">
                                        OT Begin Time<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 mt-2 align-center inset-shadow px-3">
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otDateTo" name="otDateTo" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateTo" class="font-weight-bold text-secondary">
                                        OT End Date<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 p-0">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otTimeTo" name="otTimeTo" type="time" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateTo" class="font-weight-bold text-secondary">
                                        OT End Time<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-floating text-center w-full p-0 mt-2">
                        <textarea id="otReason" name="otReason" class="form-control block w-full" placeholder="REASON" /></textarea>
                        {{-- <x-jet-label for="reason" value="{{ __('REASON') }}" class="w-full" /> --}}
                        <label for="otReason" class="font-weight-bold text-secondary text-center w-full">
                            <h6>REASON<span class="text-danger"> *</span></h6>
                        </label>
                        <x-jet-input-error for="reason" class="mt-2" />
                    </div>
                    <div class="col-md-6 text-center mt-2">
                        <table class="table table-bordered data-table mx-auto text-center">
                            <tr>
                                <th>Hours</th>
                                <th>Minutes</th>
                                <th>Total Hours</th>
                            </tr>
                            <tr>
                                <td id="thHours">0</td>
                                <td id="thMinutes">0</td>
                                <td id="thTotalHours">0.0</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button id="submitOvertime" name="submitOvertime" disabled>
                            {{ __('SUBMIT OVERTIME') }}
                        </x-jet-button>

                    </div>
                </div>
            </div>
                
            </form>
            <!-- FORM end -->
        </div>
    </div>

<script type="text/javascript">

$(document).ready(function(){

    // Function to format time
    function formatTime(timeString) {
      var timeArray = timeString.split(":");
      var hours = parseInt(timeArray[0], 10);
      var minutes = timeArray[1];
      
      // Convert 24-hour format to 12-hour format with AM/PM
      var period = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12 || 12;
      
      var formattedTime = hours + ':' + minutes + ' ' + period;
      return formattedTime;
    }

    function formatDate(date) {
        // Split the original date string into an array
        var dateArray = date.split('-');
        // Rearrange the date parts and join them with '/'
        var convertedDate = dateArray[1] + '/' + dateArray[2] + '/' + dateArray[0];
        return convertedDate;
    }

    function fieldsEmptyCount (otLocation='',otDateFrom='', otTimeFrom='', otDateTo='',otTimeTo='',otReason='') {
        var empty_fields=0;
        if ($.trim(otLocation)=="") {  empty_fields++; }
        if (otDateFrom=="") { empty_fields++; }
        if (otTimeFrom=="") { empty_fields++; }
        if (otDateTo=="") { empty_fields++; }
        if (otTimeTo=="") { empty_fields++; }
        if ($.trim(otReason)=="") { empty_fields++; }

        return empty_fields;
    }

    function isValidDateTime (otDtFr, otTFr, otDtTo, otTTo) {
        if( (otDtFr !== '' && otDtFr !== null) &&
            (otTFr !== '' && otTFr !== null) &&
            (otDtTo !== '' && otDtTo !== null) &&
            (otTTo !== '' && otTTo !== null) )
        {
            var otDateTimeFrom = new Date(otDtFr + 'T' + otTFr);
            var otDateTimeTo = new Date(otDtTo + 'T' + otTTo);

            if (otDateTimeTo < otDateTimeFrom) {
                Swal.fire({ html: 'Invalid Date/Time'});
            } else {
                const [totalHours, hours, minutes] = calculateTimeDifference(otDtFr, otTFr, otDtTo, otTTo);
                $('#thHours').html(hours);
                $('#thMinutes').html(minutes);
                $('#thTotalHours').html(totalHours.toFixed(2));
            }

        }
        return false;
    }

    function calculateTimeDifference(otDtFr, otTFr, otDtTo, otTTo) {
        const fromDate = new Date(otDtFr + ' ' + otTFr);
        const toDate = new Date(otDtTo + ' ' + otTTo);

        // Calculate the time difference in milliseconds
        var timeDifference = toDate - fromDate;

        // Convert milliseconds to hours and minutes
        var totalHours = timeDifference / (1000 * 60 * 60);
        var hours = Math.floor(totalHours);
        var minutes = Math.round((totalHours - hours) * 60);

        return [totalHours, hours, minutes];
    }


    // Key event for OT Location
    $(document).on('keyup','#otLocation',function () {
        if (fieldsEmptyCount (
            $(this).val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });

    // Key event for OT Reason
    $(document).on('keyup','#otReason',function () {
        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $(this).val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });

    // On change event for OT Date From
    $(document).on('change','#otDateFrom',function(){

        isValidDateTime (
            $(this).val(), 
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());

        $("#otDateTo").val()=='' ? $("#otDateTo").val($(this).val()) : $("#otDateTo").val();
        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $(this).val(),
            $("#otTimeFrom").val(),
            $("#otDateTo").val(),
            $("#otTimeTo").val(),
            $('#otReason').val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });

    // On change event for OT Time From
    $(document).on('change','#otTimeFrom',function(){
        // $("#otTimeTo").val()=='' ? $("#otTimeTo").val($(this).val()) : $("#otTimeTo").val();
        isValidDateTime (
            $('#otDateFrom').val(), 
            $(this).val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());

        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $(this).val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });


    // On change event for OT Date To
    $(document).on('change','#otDateTo',function(){
        isValidDateTime (
            $('#otDateFrom').val(), 
            $('#otTimeFrom').val(),
            $(this).val(),
            $('#otTimeTo').val());

        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $(this).val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });

    // On change event for OT Time To
    $(document).on('change','#otTimeTo',function(){

        isValidDateTime (
            $('#otDateFrom').val(), 
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $(this).val());



        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $(this).val(),
            $('#otReason').val()
            )>0) {
            $("#submitOvertime").attr('disabled',true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
    });

    /* SUBMIT OT REQUEST FORM begin */
    $(document).on('click','#submitOvertime',function (){
        
        if (fieldsEmptyCount (
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
            )>0) {
            Swal.fire({
                icon: 'error',
                title: 'NOTIFICATION',
                text: 'Kindly fill-up all required fields',

              });
        } else {
            const otData = {
                otName      : $('#otName').html(),
                otLoc       : $('#otLocation').val(),
                otHead      : $('#otSupervisor').html(),
                otDtFr      : $('#otDateFrom').val(),
                otTFr       : $('#otTimeFrom').val(),
                otDtTo      : $('#otDateTo').val(),
                otTTo       : $('#otTimeTo').val(),
                otReason    : $('#otReason').val(),
            };

            const [totalHours, hours, minutes] = calculateTimeDifference(otData.otDtFr, otData.otTFr, otData.otDtTo, otData.otTTo);

            // const fromDate = new Date(otData.otDtFr+' '+otData.otTFr);
            // const toDate = new Date(otData.otDtTo+' '+otData.otTTo);

            // // Calculate the time difference in milliseconds
            // var timeDifference = toDate - fromDate;

            // // Convert milliseconds to hours and minutes
            // var totalHours = timeDifference / (1000 * 60 * 60);
            // var hours = Math.floor(totalHours);
            // var minutes = Math.round((totalHours - hours) * 60);

            // Swal.fire({ html: otData.otLoc }); return false;
            Swal.fire({
                scrollbarPadding: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit',
                cancelButtonText: 'Close',
                html: 
                `<div class="table-responsive">
                    <table id="otSummary" class="table table-auto table-hover table-striped table-bordered text-center text-md">
                    <thead class="thead">
                        <tr class='text-center'>
                            <th>Overtime Request Summary</th>
                        </tr>
                    </thead>
                    <tbody class="data" id="data">
                        <tr>
                            <td class='text-left''><h6>Name : `+otData.otName+`</h6></td> 
                        </tr>
                        <tr>
                            <td class='text-left''><h6>OT Location : `+otData.otLoc+`</h6></td> 
                        </tr>
                        <tr>
                            <td class='text-left''><h6>OT Date From : `+formatDate(otData.otDtFr)+` `+formatTime(otData.otTFr)
                            +`</h6><h6>OT Date To : `+formatDate(otData.otDtTo)+` `+formatTime(otData.otTTo)+`</h6></th>
                        </tr>
                        <tr>
                            <td class='text-left''><h6>Reason : `+otData.otReason+`</h6></td> 
                        </tr>
                        <tr>
                            <td class='text-left''><h6>Hour/s : `+hours+`</h6>
                            <h6>Minute/s : `+minutes+`</h6>
                            <h6>Total Hours : `+totalHours.toFixed(2)+`</h6></td> 
                        </tr>
                    </tbody>
                    </table>
                </div>
                `,
            }).then((result) => {
                if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/hris/overtime',
                    method: 'post',
                    data: otData, // prefer use serialize method
                    success:function(data){
                        if (data.isSuccess) {
                            Swal.fire({
                                icon: 'success',
                                html: data.message
                            }).then(function(){
                                window.location = window.location.origin+"/hris/view-overtime";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: data.message
                            });
                        }
                    }
                }); return false;
                // Handle the submit action
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Handle the cancel action
                // Swal.fire('Cancelled', 'Your overtime request has been cancelled.', 'info');
                }
            });
        }
        return false;
    });
    /* SUBMIT OT REQUEST FORM end*/
});



</script>
</x-app-layout>
