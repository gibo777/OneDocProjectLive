<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>

    <x-slot name="header">
            {{ __('APPLICATION FOR OVERTIME') }}
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
                    <div class="col-md-6 pt-1">
                        <x-jet-label for="name" value="{{ __('NAME') }}" class="w-full" />
                        <h6 id="name">{{ join(' ',[Auth::user()->last_name.',',Auth::user()->first_name,Auth::user()->middle_name]) }}</h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="employeeNumber" value="{{ __('EMPLOYEE #') }}" class="w-full" />
                        <h6 id="employeeNumber">{{ Auth::user()->employee_id }}</h6>
                    </div>
                    <div class="col-md-2 pt-1">
                        <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="w-full" />
                        <h6 id="date_applied">{{ date('m/d/Y') }}</h6>
                    </div>
                </div>

                <div class="row inset-shadow rounded mt-1">
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="department" value="{{ __('OFFICE') }}" class="w-full" />
                        <h6 id="department">{{ $department->department }}</h6>
                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" va lue="{{ Auth::user()->department }}" />
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="w-full" />
                        <h6 id="department">{{ $department->department }}</h6>
                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="department" value="{{ __('SUPERVISOR') }}" class="w-full" />
                        <h6 id="department">{{ $department->department }}</h6>
                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-2 p-0">
                        <div class="form-floating">
                            <x-jet-input id="otLocation" type="text" name="otLocation" class="form-control" />
                            <label for="otLocation" class="font-weight-bold w-full">
                                OT LOCATION (Actual Location) <span class="text-danger"> *</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 align-center">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otDateFrom" name="otDateFrom" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateFrom" class="font-weight-bold text-secondary">
                                        OT Begin Date<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otTimeFrom" name="otTimeFrom" type="time" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateFrom" class="font-weight-bold text-secondary">
                                        OT Begin Time<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 mt-2 align-center">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating text-center">
                                    <x-jet-input id="otDateTo" name="otDateTo" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    <label for="otDateTo" class="font-weight-bold text-secondary">
                                        OT End Date<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
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

                <div class="row mt-2">
                    <div class="col-md-6 form-floating text-center w-full p-0">
                        <textarea id="reason" name="reason" class="form-control block w-full" placeholder="REASON" /></textarea>
                        {{-- <x-jet-label for="reason" value="{{ __('REASON') }}" class="w-full" /> --}}
                        <label for="reason" class="font-weight-bold text-secondary text-center w-full">
                            <h6>REASON<span class="text-danger"> *</span></h6>
                        </label>
                        <x-jet-input-error for="reason" class="mt-2" />
                    </div>
                    <div class="col-md-6 text-center">
                        <table class="table table-bordered data-table mx-auto text-center">
                            <tr>
                                <th>Hours</th>
                                <th>Minutes</th>
                                <th>Total Hours</th>
                            </tr>
                            <tr>
                                <td id="thHours">1</td>
                                <td id="thMinutes">30</td>
                                <td id="thTotalHours">1.5</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button id="submitOvertime" name="submitLeave" disabled>
                            {{ __('SUBMIT OVERTIME') }}
                        </x-jet-button>

                    </div>
                </div>
            </div>
                
            </form>
            <!-- FORM end -->
        </div>
    </div>

{{-- PREVIEW MODALS --}}

<div class="modal fade" id="PreviewModal" tabindex="-1" role="dialog" arial-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg" id="modalErrorLabel">LEAVE SUMMARY</h4>
            <button id="truesubmitleave" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
        </div>

        <div class="modal-body bg-gray-50 red-color">
            <x-jet-label id="nameofemp" />
            <x-jet-label id="employeenumofemp" />
            <x-jet-label id="departmentofemp" />
            <x-jet-label id="dateappliedofemp" />
            <x-jet-label id="leavetypeofemp" />
            <x-jet-label id="datecoveredofemp" />
            <x-jet-label id="summary_date_to" />
            <x-jet-label id="notificationofleaveofemp" />
            <x-jet-label id="reasonofemp" />
    </div>
  </div>
</div>
    
<x-jet-input id="holidates" type="hidden" value="{{ $holidays->implode('date', '|') }}"></x-jet-input>
<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="error_dialog">
  <p id="error_dialog_content" class="text-justify px-2"></p>
</div>

<script type="text/javascript">

$(document).ready(function(){

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

    function isWeekendandHolidays(datefrom, dateto) {
        var holidays = $("#holidates").val().split("|");
        var schedules = $("#hid_schedule").val().split("|");
        var dayoffs = [];
        // alert(holidays.length); return false;
        var d1 = new Date(datefrom),
            d2 = new Date(dateto),
            isWeekend = false;
        var count = 0;

        while (d1 <= d2) {
            var day = d1.getDay();
            var dday = d1.getDate(),
                dmonth = d1.getMonth()+1,
                dyear = d1.getFullYear();
                if (dmonth<10) { dmonth = "0"+dmonth; }
                if (dday<10) { dday = "0"+dday; }
            var ddate1 = dyear+ "-" +dmonth +"-"+ dday;

            for (var h=0; h<holidays.length; h++) {
                if (ddate1 == holidays[h]) {
                    count++;
                }
            }
            for (var d=0; d<7; d++) {
                if(jQuery.inArray(d.toString(), schedules) === -1) {
                    if (day==d) {
                        count++;
                    }
                }
            }
            // alert(count);
            // }
            d1.setDate(d1.getDate() + 1);
        }
        return count;
        // return false;
    }

    function leaveValidation (datefrom, dateto, leavetype="") {
        // alert("Date From: " + datefrom + "\n Date To: " + dateto + "\n Leave Type:" + leavetype);
        var div_upload = $("#div_upload");
        var date_range = (Date.parse(dateto) - Date.parse(datefrom) ) / (1000 * 3600 * 24) +1;
        var weekends_count =  isWeekendandHolidays(datefrom,dateto);
        var number_of_days = parseInt(date_range) - parseInt(weekends_count);
        // alert('test'); return false;

        /*if ($('#leaveType').val()=="SL"&& Date.parse(datefrom) > Date.now()){
            $('#leaveDateFrom').val("");
            $('#leaveDateTo').val("");
            $('#hid_no_days').val("");
            Swal.fire({
                icon: 'error',
                title: 'INVALID DATE FOR SICK LEAVE',
                text: '',

              })
        }
        else*/ if ( Date.parse(dateto) < Date.parse(datefrom)) {
            // $("#range_notice").html("Invalid Date Range.");
            // $("#range_notice").css("color","#ff0800");
            $('#leaveDateFrom').val("");
            $('#leaveDateTo').val("");
            $('#hid_no_days').val("");
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                text: '',

              })

        } else {

            $("#range_notice").html("");
            // $("#number_of_days").html(number_of_days);
            if (isNaN(number_of_days) == false) {
                if (number_of_days>0 && $('#isHalfDay').is(':checked')) {
                    $("#hid_no_days").val(0.5);
                } else {
                    $("#hid_no_days").val(number_of_days);
                }
            }

            if (parseInt(number_of_days) >=3) {
                $("#hid_no_days").css('color','#FF0000');
            } else {
                $("#hid_no_days").css('color','#008000');
            }

            if (leavetype=="SL" && dateto != "" && datefrom != "" && parseInt(number_of_days) >=3) {
                $("#div_upload").attr('hidden',false);
                $("#div_upload").show();
                $("#div_upload").focus();
            } else {
                $("#div_upload").hide();
            }
        }

        // return alert("Current Date: " + output + "\nDate From: " + datefrom + "\nDate To: " + dateto);
    }


    function priorLeaveValidation (datefrom, dateto, leavetype="") {
        var date_range = (Date.parse(dateto) - Date.parse(datefrom) ) / (1000 * 3600 * 24) +1;
        var weekends_count =  isWeekendandHolidays ($("#leaveDateFrom").val(),$("#leaveDateTo").val());
        var number_of_days = (parseInt(date_range) - parseInt(weekends_count)) - 1;

        return parseInt(number_of_days);
    }

    function leaveBalance () {
        // alert($("#employeeNumber").val());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/hris/eleave/balance',
                method: 'get',
                data: { 'employeeId': "{{ Auth::user()->employee_id }}", 'type': $("#leaveType").val() }, // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#td_balance").html(data);

                }
            });
            return false;
    }

    function submitLeaveValidation (leaveType='',others_leave='', leaveDateFrom='', leaveDateTo='',reason='') {

        var empty_fields=0;
        if (leaveType=="Others") {
            if ($.trim(others_leave)=="") {
                empty_fields++;
            }
        }
        if (leaveType=="") { empty_fields++; }
        if (leaveDateFrom=="") { empty_fields++; }
        if (leaveDateTo=="") { empty_fields++; }
        // if (notification==0) { empty_fields++; }
        if ($.trim(reason)=="") { empty_fields++; }

        if (empty_fields>0) {
            $("#submitLeave").attr('disabled',true);
        } else {
            $("#submitLeave").removeAttr('disabled');
        }
    }


    $(document).on('click', '.half-day', function() {
        $('#isHalfDay').is(':checked') ? $('#isHalfDay').prop('checked',false) : $('#isHalfDay').prop('checked',true);
        $('#isHalfDay').is(':checked') ? $('#leaveDateTo').prop('disabled', true) : $('#leaveDateTo').prop('disabled', false);
        if ($('#isHalfDay').is(':checked')) {
            $("#leaveDateTo").val($("#leaveDateFrom").val());
        }
        leaveValidation(
            $('#leaveDateFrom').val(),
            $('#leaveDateTo').val(),
            $('#leaveType').val()
        );
    });
    $(document).on('change', '#isHalfDay', function() {
        $(this).is(':checked') ? $('#leaveDateTo').prop('disabled', true) : $('#leaveDateTo').prop('disabled', false);
        if ($('#isHalfDay').is(':checked')) {
            $("#leaveDateTo").val($("#leaveDateFrom").val());
        }
        leaveValidation(
            $('#leaveDateFrom').val(),
            $('#leaveDateTo').val(),
            $('#leaveType').val()
        );
    });


    $(document).on('change','#leaveType', function(){
        // $(this).removeClass('empty');
        leaveValidation(
            $("#leaveDateFrom").val(),
            $("#leaveDateTo").val(),
            $(this).val()
        );

        if ($(this).val()=="Others") {
            // alert('gilbert'); return false;
            $("#div_others").show();
            $("#div_others").removeAttr('hidden');
            $("#others_leave").removeAttr('hidden');
            $("#others_leave").focus();
        } else {
            $("#div_others").hide();
        }

        leaveBalance(); // This will show current Leave Balance/s

        if ($(this).val()=="SL" || $(this).val()=="EL" || $(this).val().toUpperCase()=="OTHERS") {
            return true;
        } else {
            // alert(priorLeaveValidation('{{ $department->curDate }}',$("#leaveDateFrom").val())); return false;
            if (priorLeaveValidation('{{ $department->curDate }}',$("#leaveDateFrom").val()) <3 && $(this).val()!="") {
                $('#leaveDateFrom').val("");
                $('#leaveDateTo').val("");
                $('#hid_no_days').val("");

                Swal.fire({
                    icon: 'warning',
                    title: 'INVALID',
                    text: 'Application for leave of absence must be filed at the latest, three (3) working days prior to the date of leave.',
                  });
            }
        }
        submitLeaveValidation (
            $(this).val(),
            $("#others_leave").val(),
            $("#leaveDateFrom").val(),
            $("#leaveDateTo").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });

    $(document).on('keyup','#others_leave',function () {
        /*if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }*/
        submitLeaveValidation (
            $("#leaveType").val(),
            $(this).val(),
            $("#leaveDateFrom").val(),
            $("#leaveDateTo").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });


    $(document).on('change','#leaveDateFrom',function(){

        $("#number_of_days").html('');
        if ($('#isHalfDay').is(':checked')) {
            $("#leaveDateTo").val($(this).val());
        } else {
            $("#leaveDateTo").val()=='' ? $("#leaveDateTo").val($(this).val()) : $("#leaveDateTo").val();
        }

        if ($('#leaveType').val()!="SL" && $('#leaveType').val()!="EL" && $('#leaveType').val().toUpperCase()!="OTHERS" && (priorLeaveValidation('{{ $department->curDate }}',$("#leaveDateFrom").val()) <3 && $('#leaveType').val()!="") ) {
            $('#leaveDateFrom').val("");
            $('#leaveDateTo').val("");
            $('#hid_no_days').val("");

            Swal.fire({
                icon: 'warning',
                title: 'INVALID',
                text: 'Application for leave of absence must be filed at the latest, three (3) working days prior to the date of leave.',
              });
        }

        leaveValidation (
            $(this).val(),
            $("#leaveDateTo").val(),
            $("#leaveType").val()
            );
        submitLeaveValidation (
            $("#leaveType").val(),
            $("#others_leave").val(),
            $(this).val(),
            $("#leaveDateTo").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });


    $(document).on('change','#leaveDateTo',function(){
        $("#number_of_days").html('');
        leaveValidation(
            $("#leaveDateFrom").val(),
            $(this).val(),
            $("#leaveType").val()
            );
        submitLeaveValidation (
            $("#leaveType").val(),
            $("#others_leave").val(),
            $("#leaveDateFrom").val(),
            $(this).val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });

    $(document).on('keyup','#reason',function () {
        submitLeaveValidation (
            $("#leaveType").val(),
            $("others_leave").val(),
            $("#leaveDateFrom").val(),
            $("#leaveDateTo").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $(this).val()
            );
    });

    /* SUBMIT LEAVE FORM begin*/
    $(document).on('click','#submitLeave',function (){
        var empty_fields=0;
        if ($("#leaveType").val()==""){
            $("#leaveType").addClass('empty');
            empty_fields++;
        } else {
            $("#leaveType").removeClass('empty');
            if ($("#leaveType").val()=="Others") {
                if ($.trim($("#others_leave").val())=="") {
                    $("#others_leave").addClass('empty');
                    empty_fields++;
                } else {
                    $("#others_leave").removeClass('empty');
                }
            }
        }

        if ($("#leaveDateFrom").val()=="") {
            $("#leaveDateFrom").addClass('empty');
            empty_fields++;
        } else {
            $("#leaveDateFrom").removeClass('empty');
        }

        if ($("#leaveDateTo").val()=="") {
            $("#leaveDateTo").addClass('empty');
            empty_fields++;
        } else {
            $("#leaveDateTo").removeClass('empty');
        }

        if ($.trim($("#reason").val())=="") {
            $("#reason").addClass('empty');
            empty_fields++;
        } else {
            $("#reason").removeClass('empty');
        }

        /*Swal.fire({
            title: empty_fields,
        }); return false;*/
        // alert(empty_fields); return false;

        if (empty_fields>0) {
            Swal.fire({
                icon: 'error',
                title: 'NOTIFICATION',
                text: 'Kindly fill-up all required fields',

              });
        } else {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/hris/eleave',
                method: 'post',
                data: $('#leave-form').serialize(), // prefer use serialize method
                success:function(data){
                    // prompt('', data); return false;
                    console.log(data);
                    const {isSuccess,message,newLeave} = data;

                    if (isSuccess==true) {
                        var notificationslev = [];
                        $("input:checkbox[name='leave_notification[]']:checked").each(function(){
                            notificationslev.push($(this).val());
                        });

                        Swal.fire({
                            // width: '640px',
                            scrollbarPadding: false,
                            html: 
                            `<div class="table-responsive">
                                <table id="leaveSummary" class="table table-bordered data-table sm:justify-center table-hover">
                                <thead class="thead">
                                    <tr class='text-center'>
                                        <th colspan='2'>Control Number: `+newLeave.control_number+`</th>
                                    </tr>
                                </thead>
                                <tbody class="data text-center" id="data">
                                    <tr> <td class='text-right col-4'>Name:</td> <td>`           +newLeave.name+`</td> </tr>
                                    <tr> <td class='text-right col-4'>Employee #:</td> <td>`     +newLeave.employee_id+`</td> </tr>
                                    <tr> <td class='text-right col-4'>Department:</td> <td>`     +newLeave.department+`</td> </tr>
                                    <tr> <td class='text-right col-4'>Date Applied:</td> <td>`   +newLeave.date_applied+`</td> </tr>
                                    <tr> <td class='text-right col-4'>Leave Type:</td> <td>`     +newLeave.leave_type+`</td> </tr>
                                    <tr> <td class='text-right col-4'>Date Covered:</td> <td>`   +newLeave.date_from+` to `+newLeave.date_to+`</td> </tr>
                                    <tr> <td class='text-right'># of Day/s:</td> <td>`+newLeave.no_of_days+`</td> </tr>
                                    <tr> <td class='text-right'>Reason:</td> <td>`         +newLeave.reason+`</td> </tr>
                                </tbody>
                                </table>
                            </div>
                            `,
                        }).then(function(){
                            $('#PreviewModal').modal('hide');
                                 Swal.fire(
                                'LEAVE FORM successfully submitted!',
                                '',
                                'success'
                              ).then(function(){
                                window.location = window.location.origin+"/hris/view-leave";
                              });
                        });

                    } else {
                        Swal.fire({
                            icon:'error',
                            title:'Error',
                            text:JSON.stringify(message)
                        })
                    }
                }
            });
        }
        return false;
    });
    /* SUBMIT LEAVE FORM end*/
});



</script>
</x-app-layout>
