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

    function overlapValidation (datefrom, dateto) {
         return $.ajax({
            url: window.location.origin + '/leave-overlapping',
            method: 'get',
            data: { 'dateFrom': datefrom, 'dateTo': dateto },
            success: function(response) {
                // Check if the response is 'true'
                if (response === 'true') {
                    return 1; // Overlap found
                } else {
                    return 0; // No overlap
                }
            }
        });
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
        var empty_fields = 0;

        if (leaveType == "Others" && $.trim(others_leave) == "") {
            empty_fields++;
        }

        if (leaveType == "") { empty_fields++; }
        if (leaveDateFrom == "") { empty_fields++; }
        if (leaveDateTo == "") { empty_fields++; }
        if ($.trim(reason) == "") { empty_fields++; }

        if (empty_fields > 0) {
            $("#submitLeave").attr('disabled', true);
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
            $("#others_leave").val('');
            $("#others_leave").removeAttr('hidden');
            $("#others_leave").focus();
            $("#submitLeave").attr('disabled', true);
        } else {
            $("#div_others").hide();
        }

        leaveBalance(); // This will show current Leave Balance/s

        if ($(this).val()!="SL" || $(this).val()!="EL" || $(this).val().toUpperCase()=="OTHERS") {
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
            $("#others_leave").val(),
            $("#leaveDateFrom").val(),
            $("#leaveDateTo").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $(this).val()
            );
    });

    /* SUBMIT LEAVE FORM begin*/
    $(document).on('click','#submitLeave',function (){

        overlapValidation($("#leaveDateFrom").val(), $("#leaveDateTo").val())
        .then(function(overlap) {
            // Handle the response asynchronously
            if (overlap==1 || overlap==true) {
                Swal.fire({ icon: 'error', title: 'Overlapping Dates', text: 'Leave date/s already filed' });
            } else {
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
            }
        })
        .catch(function(error) {
            // Handle errors here
            console.error(error);
        });

        return false;
    });
    /* SUBMIT LEAVE FORM end*/
});
