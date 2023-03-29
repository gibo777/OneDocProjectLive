
$(document).ready(function(){

    /*Pusher.logToConsole = true;

    var pusher = new Pusher('264cb3116052cba73db3', {
      cluster: 'us2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind("my-event", function(data) {
      // alert(data);
      // alert(JSON.stringify(data));
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          // url: window.location.origin+'/file-preview-memo',
          url: "{{ route('counts_pusher') }}",
          method: 'get',
          data: JSON.stringify(data), // prefer use serialize method
          success:function(data){
            $("#nav-memo-counter").text(data.memo_counts);
            // alert('Hey Gibs');
          }
      });
    }); */
    // alert('gilbert');

    var name            = $("#name");
    var dept            = $("#department");
    var hid_dept        = $("#hid_dept");
    var leave_type      = $("#leave_type");
    var others          = $("#others");
    var reason          = $("#reason");
    var date_from       = $("#date_from");
    var date_to         = $("#date_to");
    var date_applied    = $("#date_applied");
    var td_as_of        = $("#td_as_of0");


    var empty_fields=0;

    // Divs
    var div_others  = $("#div_others");
    var div_date    = $("#div_date_covered");

    // date_applied.val(currentDate()); // Applied Date - Current Date
    td_as_of.html(currentDate());

    var old_date_from = $("#date_from").val();
    var old_date_to = $("#date_to").val();

    /* MONTHS */
    var month_names = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];
    let id = '';
    var countryHolder ='';
    var provinceHolder = '';
    var cityHolder ='';

    let isEdit = false;
    let isAdd = false;
    let counter = 0;
    var isEditInitialized = false;

    $(function () {
        // $('#date_applied').datepicker({ dateFormat: 'mm/dd/yy' });
        /*$('#date_from').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            // yearRange: "1900:3000",
            autoclose: true
        });
        $('#date_to').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });*/

        $('.datepicker').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2100",
            autoclose: true
        });

        $('#holiday_date').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });

    });

   /*$("#update_weekly_schedule").multiselect({
        numberDisplayed:1
    });*/



    /*$("input").on('keyup keydown change paste focus',function () {
        if ($.trim($(this).val())=="") {
            switch ($(this).attr('id')) {
                case 'suffix': case 'middle_name':
                    $(this).removeClass('empty');
                    break;
                default: $(this).addClass('empty');
            }
        } else {
            $(this).removeClass('empty');
        }
    });*/

       // DAGDAG NI MARK
    if($('#filterdept').text()==""){
        $('#filterdept').text('ALL DEPARTMENTS');
        $('#filterdept2').text('DEPARTMENT:'+$('#filterdept').text());
    }
    if($('#filterlev').text()==""){
        $('#filterlev').text('ALL LEAVE TYPES');
        $('#filterlev2').text('LEAVE TYPE:'+$('#filterlev').text());

    }

    /*$("textbox").on('keyup keydown change paste',function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });*/

    /*$("select").change(function () {
        if ($(this).val()=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });*/



    $("#current_eye_view").on('click', function(e) {
        var x = $("#current_password");
        var show_eye = $("#current_show_eye");
        var hide_eye = $("#current_hide_eye");
        if (x.prop('type') === "password") {
            x.prop('type','text');
            show_eye.addClass("d-none");
            hide_eye.removeClass("d-none");
        } else {
            x.prop('type','password');
            show_eye.removeClass("d-none");
            hide_eye.addClass("d-none");
        }
    });
    $("#eye_view").on('click', function(e) {
        var x = $("#password");
        var show_eye = $("#show_eye");
        var hide_eye = $("#hide_eye");
        if (x.prop('type') === "password") {
            x.prop('type','text');
            show_eye.addClass("d-none");
            hide_eye.removeClass("d-none");
        } else {
            x.prop('type','password');
            show_eye.removeClass("d-none");
            hide_eye.addClass("d-none");
        }
    });
    $("#confirm_eye_view").on('click', function(e) {
        var x = $("#password_confirmation");
        var show_eye = $("#confirm_show_eye");
        var hide_eye = $("#confirm_hide_eye");
        if (x.prop('type') === "password") {
            x.prop('type','text');
            show_eye.addClass("d-none");
            hide_eye.removeClass("d-none");
        } else {
            x.prop('type','password');
            show_eye.removeClass("d-none");
            hide_eye.addClass("d-none");
        }
    });



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



    function isWeekendandHolidays(datefrom, dateto) {
        var holidays = $("#holidates").val().split("|");
        var schedules = $("#hid_schedule").val().split("|");
        var dayoffs = [];
        // alert(holidays.length); return false;
        var d1 = new Date(datefrom),
            d2 = new Date(dateto),
            isWeekend = false;
        var count = 0;



        // for (var d=0; d<7; d++) {
            /*if (schedules.indexOf('5') > -1) {
                alert(d+'\nexists');
                // $("#instance_alert").html("<font color=red>Instance exists. Please try another one.</font>");
            } else {
                alert(d+'\nnot exists');
                // $("#instance_alert").html("<font color=green>Instance does not exists. Please continue</font>");
            }*/
        // }

       /* for (var d=0; d<7; d++) {
            if (jQuery.inArray(d,schedules) === -1) {
                alert(d);
            }
        }*/

        // alert(dayoffs.join('|'));


        while (d1 <= d2) {
            var day = d1.getDay();
            var dday = d1.getDate(),
                dmonth = d1.getMonth()+1,
                dyear = d1.getFullYear();
                if (dmonth<10) { dmonth = "0"+dmonth; }
                if (dday<10) { dday = "0"+dday; }
            var ddate1 = dyear+ "-" +dmonth +"-"+ dday;
            // alert(day);
            // isWeekend = (day === 6) || (day === 0);



            /*if (isWeekend) {
                count++;
            } else {*/
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



    /*function allowedDaysPrior(datefrom, currentdate) {
        var holidays = $("#holidates").val().split("|");
        var d2 = new Date(datefrom),
            d1 = new Date(currentdate),
            isWeekend = false;
        var count = 0;
        // alert("Current Date: "+d1+"\nDate From: "+d2); die();

        while (d1 <= d2) {
            var day = d1.getDay();
            var dday = d1.getDate(),
                dmonth = d1.getMonth()+1,
                dyear = d1.getFullYear();
                if (dmonth<10) { dmonth = "0"+dmonth; }
                if (dday<10) { dday = "0"+dday; }
            var ddate1 = dyear+ "-" +dmonth +"-"+ dday;

            isWeekend = (day === 6) || (day === 0);
            if (isWeekend) {
                count++;
            } else {
                for (var h=0; h<holidays.length; h++) {
                    if (ddate1 == holidays[h]) {
                        count++;
                    }
                }
            }
            d1.setDate(d1.getDate() + 1);
        }
        return count;
        // return false;
    }*/

    function leaveValidation (datefrom, dateto, leavetype="") {
        // alert("Date From: " + datefrom + "\n Date To: " + dateto + "\n Leave Type:" + leavetype); return false;
        var div_upload = $("#div_upload");
        var date_range = (Date.parse(dateto) - Date.parse(datefrom) ) / (1000 * 3600 * 24) +1;
        var weekends_count =  isWeekendandHolidays (datefrom,dateto);
        // alert ('gilbert'); return false;
        var number_of_days = parseInt(date_range) - parseInt(weekends_count);
        if ($('#leave_type').val()=="SL"&& Date.parse(datefrom) > Date.now()){
            $('#date_from').val("");
            $('#date_to').val("");
            $('#hid_no_days').val("");
            Swal.fire({
                icon: 'error',
                title: 'INVALID DATE FOR SICK LEAVE',
                text: '',

              })
        }
        else if ( Date.parse(dateto) < Date.parse(datefrom)) {
            // $("#range_notice").html("Invalid Date Range.");
            // $("#range_notice").css("color","#ff0800");
            $('#date_from').val("");
            $('#date_to').val("");
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
                $("#hid_no_days").val(number_of_days);
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
        // var div_upload = $("#div_upload");
        // alert('gilbert'); return false;
        var date_range = (Date.parse(dateto) - Date.parse(datefrom) ) / (1000 * 3600 * 24) +1;
        var weekends_count =  isWeekendandHolidays ($("#date_from").val(),$("#date_to").val());
        var number_of_days = (parseInt(date_range) - parseInt(weekends_count)) - 1;

        return parseInt(number_of_days);
    }

    function leaveBalance () {
        // alert($("#employee_number").val());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/hris/eleave/balance',
                method: 'get',
                data: { 'emp_id': $("#employee_number").val(), 'type': $("#leave_type").val() }, // prefer use serialize method
                success:function(data){
                    $("#td_balance").html(data);

                }
            });
            return false;
    }

    function filterLeaves (search="", leavetype="", department="") {
        // alert('Gibs...'); return false;
        var search = $("#search").val();

        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#leave-form').serialize()/*+"&leave_type="+leavetype+"&department="+department*/;
            // data.push({'leave_id': $("#leave_id").val()});
            $.ajax({
                url: window.location.origin+'/hris/filter-leave',
                method: 'get',
                data: data, // prefer use serialize method
                success:function(data){
                    // alert(data);

                    $("#view_leaves").html(data);
                    // $("#red").html(data);
                    // $("#blue").html(data);
                    // $("#dialog_content").html("LEAVE FORM successfuly updated.").css('color','#008000');
                    // $("#popup" ).attr('title','NOTIFICATION');

                }
            });
            return false;
    }


    function submitLeaveValidation (leave_type='',others_leave='', date_from='', date_to='',reason='') {

        var empty_fields=0;
        if (leave_type=="Others") {
            if ($.trim(others_leave)=="") {
                empty_fields++;
            }
        }
        if (leave_type=="") { empty_fields++; }
        if (date_from=="") { empty_fields++; }
        if (date_to=="") { empty_fields++; }
        // if (notification==0) { empty_fields++; }
        if ($.trim(reason)=="") { empty_fields++; }

        if (empty_fields>0) {
            $("#submit_leave").attr('disabled',true);
        } else {
            $("#submit_leave").removeAttr('disabled');
        }
    }

    $("#leave_type").change(function(){
        /*if ($(this).val()=="") {
            $(this).addClass('empty');
        } else {*/
            $(this).removeClass('empty');
            leaveValidation(
                $("#date_from").val(),
                $("#date_to").val(),
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
                //$("#others_leave").val('');
            }

            /*if ($("#hid_no_days").val()!=""){ */leaveBalance ();/* }*/

            if ($(this).val()=="SL" || $(this).val()=="EL") {
                return true;
            } else {
                // alert(priorLeaveValidation(currentDate(),$("#date_from").val())); return false;
                if (priorLeaveValidation(currentDate(),$("#date_from").val()) <3 && $(this).val()!="") {
                    $('#date_from').val("");
                    $('#date_to').val("");
                    $('#hid_no_days').val("");
                    // alert('Mak');
                    Swal.fire({
                        icon: 'warning',
                        title: 'INVALID',
                        text: 'Application for leave of absence must be filed at the latest, three (3) working days prior to the date of leave.',

                      })
                    // $("#dialog_content").html("Application for leave of absence must be filed at the latest, <br>three (3) working days prior to the date of leave.").css('color','#FF0000');
                    // $("#dialog" ).dialog({
                    //     modal: true,
                    //     title: "PRIOR DATE",
                    //     width: "auto",
                    //     height: "auto",
                    //     buttons: [
                    //         {
                    //             id: "OK",
                    //             text: "OK",
                    //             click: function () {
                    //                 $(this).dialog('close');
                    //             }
                    //         }
                    //     ]
                    // });
                }
            }
        // }
        submitLeaveValidation (
            $(this).val(),
            $("#others_leave").val(),
            $("#date_from").val(),
            $("#date_to").val(),
            $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });

    $("#others_leave").keyup(function () {
        /*if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }*/
        submitLeaveValidation (
            $("#leave_type").val(),
            $(this).val(),
            $("#date_from").val(),
            $("#date_to").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });


    $("#date_from").change(function(){
        $("#number_of_days").html('');
        $("#date_to").val($(this).val());
        /*$(this).removeClass('empty');
        $("#date_to").removeClass('empty');*/
        /*if ($("#leave_type").val()=="SL" || $("#leave_type").val()=="EL") {
            return true;
        } else {
            var prior = priorLeaveValidation(currentDate(),$("#date_from").val());
            if (prior <3 && $("#leave_type").val()!="") {
                // alert(old_date_from);
                $("#date_from").val(old_date_from);
                $("#dialog_content").html("Application for leave of absence must be filed at the latest, <br>three (3) working days prior to the date of leave.").css('color','#FF0000');
                // $("#popup" ).attr('title','NOTIFICATION');
                $("#dialog" ).dialog({
                    modal: true,
                    title: "PRIOR DATE",
                    width: "auto",
                    height: "auto",
                    buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                            }
                        }
                    ]
                });
            }
        }*/

        leaveValidation(
            $(this).val(),
            $("#date_to").val(),
            $("#leave_type").val()
            );
        submitLeaveValidation (
            $("#leave_type").val(),
            $("#others_leave").val(),
            $(this).val(),
            $("#date_to").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });


    $("#date_to").change(function(){
        $("#number_of_days").html('');
        leaveValidation(
            $("#date_from").val(),
            $(this).val(),
            $("#leave_type").val()
            );
        submitLeaveValidation (
            $("#leave_type").val(),
            $("#others_leave").val(),
            $("#date_from").val(),
            $(this).val(),
            // $("input[name='leave_notification[]']:checked").length,
            $("#reason").val()
            );
    });


    /*$("input[name='leave_notification[]']").each(function() {
        var checked=0;
        $(this).change(function () {
            submitLeaveValidation (
                $("#leave_type").val(),
                $("#others_leave").val(),
                $("#date_from").val(),
                $("#date_to").val(),
                $("input[name='leave_notification[]']:checked").length,
                $("#reason").val()
                );
        });
    });*/

    $("#reason").keyup(function () {
        /*if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }*/
        submitLeaveValidation (
            $("#leave_type").val(),
            $("others_leave").val(),
            $("#date_from").val(),
            $("#date_to").val(),
            // $("input[name='leave_notification[]']:checked").length,
            $(this).val()
            );
    });

    /* SUBMIT LEAVE FORM begin*/
    $("#submit_leave").click(function (){
        /*if ($("input[name='leave_notification[]']:checked").length == 0) {
            $("input[name='leave_notification[]']").each(function() {
                $(this).addClass('empty');
            });
            empty_fields++;
        } else {
            $("input[name='leave_notification[]']").each(function() {
                $(this).removeClass('empty');
            });
        }*/

        if ($("#leave_type").val()==""){
            $("#leave_type").addClass('empty');
            empty_fields++;
        } else {
            $("#leave_type").removeClass('empty');
            if ($("#leave_type").val()=="Others") {
                if ($.trim($("#others_leave").val())=="") {
                    $("#others_leave").addClass('empty');
                    empty_fields++;
                } else {
                    $("#others_leave").removeClass('empty');
                }
            }
        }

        if ($("#date_from").val()=="") {
            $("#date_from").addClass('empty');
            empty_fields++;
        } else {
            $("#date_from").removeClass('empty');
        }

        if ($("#date_to").val()=="") {
            $("#date_to").addClass('empty');
            empty_fields++;
        } else {
            $("#date_to").removeClass('empty');
        }

        if ($.trim($("#reason").val())=="") {
            $("#reason").addClass('empty');
            empty_fields++;
        } else {
            $("#reason").removeClass('empty');
        }
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
                success:function(response){
                // alert(response); return false;
                if (response=='success') {
                    var notificationslev = [];
                    $("input:checkbox[name='leave_notification[]']:checked").each(function(){
                        notificationslev.push($(this).val());
                    });

                    // $('#modaltitle').text("#" +$('#employee_number').val()+" Preview Leave Form");
                    $('#nameofemp').text("Name: "+$('#name').val());
                    $('#employeenumofemp').text("Employee #: "+$('#employee_number').val());
                    $('#departmentofemp').text("Department: "+$('#department').val());
                    $('#dateappliedofemp').text("Date Applied: "+$('#date_applied').val());
                    $('#leavetypeofemp').text("Leave Type: "+$('#leave_type').val());
                    $('#datecoveredofemp').text("Date Covered: "+$('#date_from').val()+" TO " +$('#date_to').val() );
                    $('#notificationofleaveofemp').text("Notification of Leave: "+notificationslev);
                    $('#reasonofemp').text("Reason: "+$('#reason').val());
                    $('#PreviewModal').modal('show');
                    
                        $('#truesubmitleave').click(function(){
                            $('#PreviewModal').modal('hide');
                             Swal.fire(
                            'LEAVE FORM successfully submitted!',
                            '',
                            'success'
                          )
                          $('.swal2-confirm').click(function(){
                            window.location = window.location.origin+"/hris/view-leave";
                          });
                        });
                    } else {

                    }
                }
            });
        }
        return false;
    });
    /* SUBMIT LEAVE FORM end*/

    $("#show_filter").click(function (){
        $("#div_filter_department").toggle();
        $("#div_filter_leave_type").toggle();
        return false;
    });


    /* VIEW HISTORY begin*/
   
    $(document).on('click','.open_leave',function(e){
        try{
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/hris/view-history',
                method: 'get',
                data: {'leave_reference': $(this).val() }, // prefer use serialize method
                success:function(data){
                    // alert('test');
                    // prompt('',data); return false;
                    var historyLabel = "leave history";

                    $("#data_history > tbody").empty();

                    for(var n=0; n<data.length; n++) {
                        $("#data_history > tbody:last-child")
                        .append('<tr>');
                        /*if ($("#hid_access_id").val()==1) {
                            $("#data_history > tbody:last-child")
                            .append('<td>'+data[n]['name']+'</td>')
                            .append('<td>'+data[n]['employee_id']+'</td>')
                            .append('<td>'+data[n]['department']+'</td>')
                        }*/
                        $("#data_history > tbody:last-child")
                        .append('<td>'+data[n]['head_name']+'</td>')
                        // .append('<td>'+data[n]['leave_number']+'</td>')
                        .append('<td>'+data[n]['leave_type']+'</td>')
                        .append('<td>'+data[n]['leave_balance']+'</td>')
                        .append('<td>'+data[n]['action']+'</td>')
                        .append('<td>'+data[n]['created_at']+'</td>')
                        .append('<td id="title'+n+'" title="'+data[n]['action_reason']+'">'+data[n]['action_reason'].slice(0,10)+'</td>')
                        .append('<td>'+data[n]['date_applied']+'</td>')
                        .append('<td>'+data[n]['date_from']+'</td>')
                        .append('<td>'+data[n]['date_to']+'</td>')
                        .append('<td>'+data[n]['no_of_days']+'</td>');

                        $("#title"+n).click(function () {
                            $(this).attr('title').show();
                        });
                    }
                    if ($("#hid_access_id").val()==1) {
                        historyLabel = historyLabel+" of "+data[0]['name'];
                    }
                    historyLabel = historyLabel+" (Leave #"+data[0]['leave_number']+")";
                    // var historyLabel = "leave history of Pangalan"+" (leave #"+7+")";
                    $("#leaveHistoryLabel").html(historyLabel.toUpperCase());
                    $("#modalHistory").modal("show");
                }
            });
        }catch(error){
            console.log(error);
        }
    });
    /* VIEW HISTORY end */

    /* VIEW ALL LEAVES begin */
    $("#action_buttons > button").each(function (){
        $(this).click(function(){
            var actionID = $(this).attr('id').split("-");
            var action = actionID[0];
            var leaveID = actionID[1];
            var nameemp = actionID[2];
            var empid = actionID[1]+"-"+actionID[2];
            $("#popup").show();
            $("#confirm_reason").val('');

            switch (action) {
                // case "view":
                //     // $('#EmployeeModal').modal.show();
                //     $.ajax({
                //         method: "GET",
                //         url: "/getemployees",
                //         data: {'employeeid':empid},
                //         success: function (response) {
                //             // alert('ajdioad');
                //             $('#EmployeesModal').modal('show');

                //         }
                //     });
                // break;

            // case "open": case "history":
            //     // alert(window.location.origin+'/hris/view-leave-details'); return false;
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         url: window.location.origin+'/hris/view-leave-details',
            //         method: 'GET',
            //         data: { 'leaveID': leaveID }, // prefer use serialize method
            //         success:function(data){

            //             // alert(data[0]['employee_id']);
            //             var leave_number = data[0]['control_number'];

            //             var modalHeader = "VIEW LEAVE (Control Number "+leave_number+")";
            //             var dateFrom = data[0]['date_from'].split('-');
            //                 dateFrom = dateFrom[1]+"/"+dateFrom[2]+"/"+dateFrom[0];
            //             var dateTo = data[0]['date_to'].split('-');
            //                 dateTo = dateTo[1]+"/"+dateTo[2]+"/"+dateTo[0];
            //             var notif1 = "", notif2 = "", notif3 = "";
            //             var notification = data[0]['notification'].split('|');

            //             $("#update_leave").hide();
            //             $("#cancel_leave").hide();
            //             $("#deny_leave").hide();
            //             $("#approve_leave").hide();
            //             $("#taken_leave").hide();
            //             $("#date_from").removeAttr('disabled');
            //             $("#date_to").removeAttr('disabled');
            //             $("#leave_type").removeAttr('disabled');
            //             $("#reason").removeAttr('disabled');
            //             $("#div_others").attr('hidden',true);
            //             $("#others_leave").attr('hidden',true);
            //             $("#others_leave").removeAttr('readonly');
            //             $("input[name='leave_notification[]']").each( function() {
            //                 $(this).removeAttr("disabled");
            //             });


            //             $("input[name='leave_notification[]']").each( function() {
            //                 $(this).prop("checked", false);
            //                 for (var i=0; i<notification.length; i++) {
            //                     if (notification[i]==$(this).val()) {
            //                         $(this).prop("checked", true);
            //                     }
            //                 }
            //             });
            //             $("#hid_leave_id").val(data[0]['id']);
            //             $("#myModalLabel").html(modalHeader);
            //             $("#name").val(data[0]['name']);
            //             $("#employee_number").val(data[0]['employee_id']);
            //             $("#hid_dept").val(data[0]['department']);
            //             $("#department").val(data[0]['dept']);
            //             if (data[0]['status']=="Pending") {
            //                 $("#date_applied").val(currentDate());
            //             } else {
            //                 $("#date_applied").val(formatDates(data[0]['date_applied']));
            //             }
            //             $("#leave_type").val(data[0]['leave_type']);
            //             if (data[0]['leave_type']=="Others") {
            //                 $("#div_others").attr('hidden',false);
            //                 $("#others_leave").attr('hidden',false);
            //                 $("#others_leave").val(data[0]['others']);
            //             }
            //             $("#view_date_applied").val(data[0]['date_applied']);
            //             $("#date_from").val(dateFrom);
            //             $("#date_to").val(dateTo);
            //             $("#hid_no_days").val(data[0]['no_of_days']);
            //             $("#reason").val(data[0]['reason']);
            //             $("#td_balance").html(data[0]['balance']);

            //             if (data['role_type']=='ADMIN' || data['role_type']=='SUPER ADMIN') {
            //                 if (data['auth_id']==data[0]['supervisor']) {
            //                     $("#date_from").attr('disabled', true);
            //                     $("#date_to").attr('disabled', true);
            //                     $("#leave_type").attr('disabled', true);
            //                     $("#reason").attr('disabled', true);
            //                     $("#others_leave").attr('readonly', true);
            //                     $("input[name='leave_notification[]']").each( function() {
            //                         $(this).attr("disabled", true);
            //                     });
            //                     if (data[0]['status']=="Pending") {
            //                         $("#deny_leave").show();
            //                         $("#approve_leave").show();
            //                     } else {
            //                         if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied") {
            //                             $("#cancel_leave").hide();
            //                         } else {
            //                             $("#cancel_leave").show();
            //                         }
            //                         /*if (data['auth_department']==1) {
            //                             $("#taken_leave").show();
            //                         }*/
            //                     }
            //                 } else {
            //                     if (data['auth_id']==data[0]['employee_id']) {
            //                         if (data[0]['status']=="Pending") {
            //                             $("#update_leave").show();
            //                         } else {
            //                             $("#date_from").attr('disabled', true);
            //                             $("#date_to").attr('disabled', true);
            //                             $("#leave_type").attr('disabled', true);
            //                             $("#reason").attr('disabled', true);
            //                             $("#others_leave").attr('readonly', true);
            //                             $("input[name='leave_notification[]']").each( function() {
            //                                 $(this).attr("disabled", true);
            //                             });
            //                             if (data[0]['status']=="Cancelled") {
            //                                 $("#cancel_leave").hide();
            //                             } else {
            //                                 $("#cancel_leave").show();
            //                             }
            //                         }
            //                     } else {
            //                         $("#date_from").attr('disabled', true);
            //                         $("#date_to").attr('disabled', true);
            //                         $("#leave_type").attr('disabled', true);
            //                         $("#reason").attr('disabled', true);
            //                         $("#others_leave").attr('readonly', true);
            //                         $("input[name='leave_notification[]']").each( function() {
            //                             $(this).attr("disabled", true);
            //                         });
            //                         /*if (data['auth_department']==1) {
            //                             if (data[0]['status']=="Head Approved") {
            //                                 $("#taken_leave").show();
            //                             }
            //                         }*/
            //                     }
            //                 }
            //             } else {
            //                 // alert(data[0]['status']); return false;
            //                 if (data[0]['status']=="Pending") {
            //                     $("#update_leave").show();
            //                 } else {
            //                     if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied") {
            //                         $("#cancel_leave").hide();
            //                     } else {
            //                         $("#cancel_leave").show();
            //                     }
            //                     $("#date_from").attr('disabled', true);
            //                     $("#date_to").attr('disabled', true);
            //                     $("#leave_type").attr('disabled', true);
            //                     $("#reason").attr('disabled', true);
            //                     $("#others_leave").attr('readonly', true);
            //                     $("input[name='leave_notification[]']").each( function() {
            //                         $(this).attr("disabled", true);
            //                     });
            //                 }
            //             }
            //             /* OPEN MODAL View */
            //             $("#myModal").modal("show");
            //         }
            //     });
            //     break;

            case "delete":
                Swal.fire({
                    title: 'Are you sure you want to delete Leave #' + leaveID+ ' of '+nameemp+'?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#f44336',
                    denyButtonText: `Don't Delete`,
                  }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                        var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
                                // data.push({'leave_id': $("#leave_id").val()});
                        $.ajax({
                            url: window.location.origin+'/hris/delete-leave',
                            method: 'post',
                            data: { 'leaveID': leaveID }, // prefer use serialize method
                            success:function(data){
                                Swal.fire(
                                    'Leave form deleted',
                                    '',
                                    'success'
                                  )
                                  $('.swal2-confirm').click(function(){
                                        return window.location.reload(true);
                                  })

                            }
                        });




                    //   Swal.fire('Saved!', '', 'success')
                    }
                    // else if (result.isDenied) {
                    //   Swal.fire('Changes are not saved', '', 'info')
                    // }
                  })
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             }
        //         });
        //         var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
        //         // data.push({'leave_id': $("#leave_id").val()});
        // $.ajax({
        //     url: window.location.origin+'/hris/delete-leave',
        //     method: 'post',
        //     data: { 'leaveID': leaveID }, // prefer use serialize method
        //     success:function(data){


        //     }
        // });

    //   $('.swal2-confirm').click(function(){
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
    //     // data.push({'leave_id': $("#leave_id").val()});
    //     $.ajax({
    //         url: window.location.origin+'/hris/delete-leave',
    //         method: 'post',
    //         data: { 'leaveID': leaveID }, // prefer use serialize method
    //         success:function(data){
    //             // // $("#dialog_content").html(data).css('color','#008000');
    //             // $("#popup" ).dialog('close');
    //             // $("#dialog_content").html("Leave form deleted").css('color','#008000');
    //             // // $("#dialog" ).removeAttr('hidden');
    //             // $("#dialog" ).dialog({
    //             //     modal: true,
    //             //     width: "auto",
    //             //     height: "auto",
    //             //     buttons: [
    //             //     {
    //             //         id: "OK",
    //             //         text: "OK",
    //             //         click: function () {
    //             //             $(this).dialog('close');
    //             //             location.reload();
    //             //         }
    //             //     }
    //             //     ]
    //             // });
    //             // console.log(data);

    //             // Swal.fire(
    //             //     'Leave form deleted',
    //             //     '',
    //             //     'success'
    //             //   )
    //         }
    //     });
    //     /* UPDATE-DELETE end */

    //     // window.location.href = "{{URL::to('hris/view-leave')}}";
    //             // window.location = window.location.origin+"/hris/view-leave";
    //     // window.location.origin+'/hris/view-leave';
    //     Swal.fire(
    //         'Leave form deleted',
    //         '',
    //         'success'
    //       )
    //   });

                // $("#pop_content").html(" Are you sure you want to delete Leave #" + leaveID + "?").css('color','#FF0000');
                // // $("#popup" ).removeAttr('hidden');
                // $("#popup" ).dialog({
                //     modal: true,
                //     title: "DELETE LEAVE APPLICATION",
                //     width: "auto",
                //     height: "auto",
                //     buttons: [
                //         {
                //             id: "Cancel",
                //             text: "Cancel",
                //             click: function () {
                //                 $(this).dialog('close');
                //             }
                //         },
                //         {
                //             id: "OK",
                //             text: "OK",
                //             click: function () {
                //                 // alert(leaveID); return false;
                //                 /* UPDATE-DELETE begin */
                //                 $.ajaxSetup({
                //                     headers: {
                //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //                     }
                //                 });
                //                 var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
                //                 // data.push({'leave_id': $("#leave_id").val()});
                //                 $.ajax({
                //                     url: window.location.origin+'/hris/delete-leave',
                //                     method: 'post',
                //                     data: { 'leaveID': leaveID }, // prefer use serialize method
                //                     success:function(data){
                //                         // $("#dialog_content").html(data).css('color','#008000');
                //                         $("#popup" ).dialog('close');
                //                         $("#dialog_content").html("Leave form deleted").css('color','#008000');
                //                         // $("#dialog" ).removeAttr('hidden');
                //                         $("#dialog" ).dialog({
                //                             modal: true,
                //                             width: "auto",
                //                             height: "auto",
                //                             buttons: [
                //                             {
                //                                 id: "OK",
                //                                 text: "OK",
                //                                 click: function () {
                //                                     $(this).dialog('close');
                //                                     location.reload();
                //                                 }
                //                             }
                //                             ]
                //                         });
                //                         console.log(data);
                //                     }
                //                 });
                //                 /* UPDATE-DELETE end */
                //             }
                //         }
                //     ]
                // });
                break;

            case "edit_holiday":
                var hS = $(this).val().split('|');
                $("#save_holiday").html('UPDATE');
                $("#save_holiday").attr('disabled',true);
                $("input").removeClass('empty');
                $("select").removeClass('empty');
                $("#hid_holiday_id").val(hS[0]);
                $("#holiday").val(hS[2]);
                $("#holiday_date").val(hS[1]);
                $("#holiday_category").val(hS[3]);
                $("#myModalLabel").html("EDIT HOLIDAY");
                $("#holidayAddModal").modal('show');
                break;
            // case "edit_department":
            //     // alert($(this).val() );
            //     var dS = $(this).val().split('|');
            //     $("#save_department").html('UPDATE');
            //     $("#save_department").attr('disabled',true);
            //     $("input").removeClass('empty');
            //     $("select").removeClass('empty');
            //     $("#hid_department_id").val(dS[0]);
            //     $("#department_code").val(dS[1]);
            //     $("#department").val(dS[2]);
            //     $("#myModalLabel").html("EDIT DEPARTMENT");
            //     $("#departmentAddModal").modal('show');
            //     break;
            default:
                break;
            }
            return false;
        });

    });
    /* VIEW ALL LEAVES end */



    /* FILTER LEAVES beging */
    /*$("#filter_search").keyup(function (event) {
        // var keycode = (event.keyCode ? event.keyCode : event.which);
        // alert($(this).val().length); return false;
        // if ($(this).val().length>=1) {
            filterLeaves ($("#filter_search").val(),$("#filter_leave_type").val(),$("#filter_department").val());
        // }
    });*/
    // $('#searchbtn').click(function(){
    //     filterLeaves ($("#filter_search").val(),$("#filter_leave_type").val(),$("#filter_department").val());

    // });
    $("#filter_leave_type").change(function () {
        filterLeaves ($("#filter_search").val(),$("#filter_leave_type").val(),$("#filter_department").val());
    });
    $("#filter_department").change(function () {
        // alert('Gibs'); return false;
        filterLeaves ($("#filter_search").val(),$("#filter_leave_type").val(),$("#filter_department").val());
    });
    /* FILTER LEAVES end*/

    $("#update_leave").click(function() {
        // alert($("#hid_leave_id").val()); return false;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#hid_leave_id").val();
            // var data = $('#update-leave-form').serialize();
            // alert(data);return false;
            $.ajax({
                url: window.location.origin+'/hris/update-leave',
                method: 'post',
                data: data, // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#myModal").modal("hide");
                    // $("#dialog_content").html(data).css('color','#008000');
                    Swal.fire(
                        'LEAVE FORM successfully updated.',
                        '',
                        'success'
                      )
                      $('.swal2-confirm').click(function(){
                        location.reload();
                      })
                    // $("#dialog_content").html("LEAVE FORM successfully updated.").css('color','#008000');
                    // // $("#popup" ).attr('title','NOTIFICATION');
                    // $("#dialog" ).dialog({
                    //     modal: true,
                    //     // title: "Confirmation",
                    //     width: "auto",
                    //     height: "auto",
                    //     buttons: [
                    //     {
                    //         id: "OK",
                    //         text: "OK",
                    //         click: function () {
                    //             $(this).dialog('close');
                    //             location.reload();
                    //         }
                    //     }
                    //     ]
                    // });
                    console.log(data);
                }
            });
            return false;
    });



    /* HEAD APPROVAL begin */
    $("#approve_leave").click(function () {

        // alert('Gilbert'); return false;
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
            // data.push({'leave_id': $("#leave_id").val()});
            // alert($("#hid_leave_id").val()); return false;
            $.ajax({
                url: window.location.origin+'/head-approve',
                method: 'post',
                data: { 'leaveID': $("#hid_leave_id").val() }, // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#myModal").modal("hide");
                    // $("#dialog_content").html(data);
                    Swal.fire(
                        'Approved by Head.',
                        '',
                        'success'
                      )
                      $('.swal2-confirm').click(function(){
                        location.reload();
                      })
                    // $("#dialog_content").html("Approved by Head.");
                    // $("#dialog" ).dialog({
                    //     modal: true,
                    //     title: "Confirmation",
                    //     width: "auto",
                    //     height: "auto",
                    //     buttons: [
                    //     {
                    //         id: "OK",
                    //         text: "OK",
                    //         click: function () {
                    //             $(this).dialog('close');
                    //             location.reload();
                    //         }
                    //     }
                    //     ]
                    // });
                    console.log(data);
                }
            });
            return false;
    });
    /* HEAD APPROVAL end */


    var btn_clicked = "";
    $("#deny_leave").click(function () {
        var message = "Reason for DENYING leave";
        $("#confirmation_message").html(message);
        $("#confirm_reason").val('');
        $("#confirm_reason").removeClass('placeholder-warning');
        $("#modalConfirm").modal('show');
        $(".modal-dialog").draggable({
            cursor: "move"
        });
        btn_clicked = "Denied";
    });
    $("#cancel_leave").click(function () {
        var message = "Reason for CANCELLATION of Leave";
        $("#confirmation_message").html(message);
        $("#confirm_reason").val('');
        $("#confirm_reason").removeClass('placeholder-warning');
        $("#modalConfirm").modal('show');
        $(".modal-dialog").draggable({
            cursor: "move"
        });
        btn_clicked = "Cancelled";
    });
    $("#btn_no").click(function () {
        $("#modalConfirm").modal('hide');
    });
    $("#btn_yes").click(function () {
        // alert($("#confirm_reason").val());
        if ($("#confirm_reason").val()==""){
            // alert("Indicate your reason");
            $("#confirm_reason").addClass('placeholder-warning');
            $("#confirm_reason").focus();
        } else {
            // var url = window.location.origin;
            var url = window.location.origin+"/hris/yes-button-leave";
            /*if (btn_clicked=="deny") {
                url = url+'/hris/deny-leave';
            } else if (btn_clicked=="cancel"){
                url = url+'/hris/cancel-leave';
            }*/
            var userID = $("#user_id").val();

            // alert(userID);return false;
            // prompt('',"URL: "+url+"\nID: "+$("#hid_leave_id").val());return false;
            // alert('leaveID: '+ $("#hid_leave_id").val()+'\nuserID: '+$("#user_id").val()); return false;
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
                // data.push({'leave_id': $("#leave_id").val()});
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                    'leaveID': $("#hid_leave_id").val(),
                    'action' : btn_clicked,
                    'reason' : $("#confirm_reason").val()
                    }, // prefer use serialize method
                    success:function(data){
                        // alert(data);
                        $("#modalConfirm").modal("hide");
                        $("#myModal").modal("hide");
                        // $("#dialog_content").html(data);
                        // $("#dialog_content").html("Approved by HR/Admin.").css('color','#008000');
                        

                    Swal.fire({
                        icon: 'success',
                        title: '',
                        text: '',
        
                      }).then(function(){
                        window.location.reload();
                      });

                        /*$("#dialog_content").html(data);
                        // $("#popup" ).attr('title','NOTIFICATION');
                        $("#dialog" ).dialog({
                            modal: true,
                            // title: "Confirmation",
                            width: "auto",
                            height: "auto",
                            buttons: [
                            {
                                id: "OK",
                                text: "OK",
                                click: function () {
                                    $(this).dialog('close');
                                    location.reload();
                                }
                            }
                            ]
                        });*/
                        console.log(data);
                    }
                });
        }
        // alert($("#hid_leave_id").val()); return false;
            return false;
    });

    $("#taken_leave").click(function () {
        // alert($("#hid_leave_id").val()); return false;
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
            // data.push({'leave_id': $("#leave_id").val()});
            $.ajax({
                url: window.location.origin+'/hr-approve',
                method: 'post',
                data: { 'leaveID': $("#hid_leave_id").val() }, // prefer use serialize method
                success:function(data){
                    $("#myModal").modal("hide");

                    Swal.fire({
                        icon: 'success',
                        title: 'Leave Taken',
                        text: '',
        
                      }).then(function(){
                        window.location.reload();
                      });

                    /*// $("#dialog_content").html(data);
                    // $("#dialog_content").html("Approved by HR/Admin.").css('color','#008000');
                    $("#dialog_content").html("Leave Taken");
                    // $("#popup" ).attr('title','NOTIFICATION');
                    $("#dialog" ).dialog({
                        modal: true,
                        // title: "Confirmation",
                        width: "auto",
                        height: "auto",
                        buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                                location.reload();
                            }
                        }
                        ]
                    });*/
                    console.log(data);
                }
            });
            return false;
    });

/* PAGINATION begin */

    /*$('#data').after ('<div id="nav"></div>');
    var rowsShown = 5;
    var rowsTotal = $('#data tbody tr').length;
    var numPages = rowsTotal/rowsShown;
    if (numPages>1) {
    $('#nav').append ("Pages ");
        for (i = 0;i < numPages;i++) {
            var pageNum = i + 1;
            $('#nav').append ('<a href="#" rel="'+i+'" class="btn hover">'+pageNum+'</a> ');
        }
    }
    $('#data tbody tr').hide();
    $('#data tbody tr').slice (0, rowsShown).show();
    $('#nav a:first').addClass('active');
    $('#nav a').bind('click', function() {
    $('#nav a').removeClass('active');
   $(this).addClass('active');
        var currPage = $(this).attr('rel');
        var startItem = currPage * rowsShown;
        var endItem = startItem + rowsShown;
        $('#data tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
        css('display','table-row').animate({opacity:1}, 300);
    });  */



/* PAGINATION end */

    // $('table').DataTable();
$('.tabledata').DataTable();
    /* NAVIGATIONS begin */
    $(".view_nav").click(function() {
        // alert($(this).html());
        if ($(this).next().attr('hidden')) {
            $(this).next().removeAttr('hidden');
        } else {
            $(this).next().toggle();
        }

    });
    /* NAVIGATIONS end */



    /* PROCESS E-LEAVE begin */
    $("#process_date_from").change(function() {
        if ($(this).val()!="") {
            var pdto = new Date($(this).val());
            pdto.setDate(pdto.getDate()+14);
            var pdm = pdto.getMonth()+1; if (pdm<10) { pdm = "0"+pdm; }
            var pdd = pdto.getDate(); if (pdd<10) { pdd = "0"+pdd; }

            if($(this).val().length>=10) {
                $("#process_date_to").val([pdm,pdd,pdto.getFullYear()].join('/'));
                // $("#process_date_to").removeAttr('disabled');
                // alert($("#process_date_to").val());
                $("#btn_process").removeAttr('disabled');
            }
        }
    });

    /*$("#process_date_from").on('keyup keydown', function(e) {
        // alert($(this).val().length);
        if($(this).val().length<10) {
            $("#btn_process").attr('disabled',true);
        } else {
            $("#btn_process").removeAttr('disabled');
        }
    });*/


    $("#process_date_to").change(function() {
        if ($(this).val()!="") {
            var dt_diff = (Date.parse($(this).val()) - Date.parse($("#process_date_from").val())) / (1000*3600*24) + 1;
            // alert( dt_diff );
            $("#btn_process").removeAttr('disabled');
        }
    });


    $("#btn_process").click(function() {
        // var url = window.location.origin+'/view-processing-leave';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/view-processing-leave',
            method: 'get',
            data: $("#process-leave").serialize(), // prefer use serialize method
            success:function(id){
                // prompt('',id); return false;
                if (id.length==0) {
                    $("#processing_bar").html("NOTHING TO PROCESS").width("100%");
                } else {
                    /*alert(id.length); return false;
                    for (var n=0; n<id.length; n++) {
                        alert("ID: "+id[n]['id']+"\nEnd Date: "+id[n]['date_to']);
                        if (n==3) {return false;}
                    }*/
                    var n_processed = 0;
                    for (var n=0; n<id.length; n++) {
                        // alert(id[n]['id']);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: window.location.origin+'/processing-leave',
                            method: 'post',
                            data: { 'id': id[n]['id'] }, // prefer use serialize method
                            success:function(data){
                                n_processed++;
                                // $("#test_count").html(id[n]['id']);
                                if (n_processed==1) {
                                    move(id);
                                }
                            }
                        });
                    }
                }
            }
        });
        return false;
    });

    var i = 0;
    var ctr = 0;
    function move(leaveID) {
        var counts = leaveID.length;
        if (i == 0) {
        i = 1;
        var elem = $("#processing_bar");
        var width = 0;
        // var done = Math.ceil(counts/100);
        // alert(done); return false;
        var id = setInterval(frame, (counts*1.5));
        var ctr_success=0;
        // alert("INTER: "+id+"\nCOUNTS: "+counts); return false;
        $("#loading").removeAttr('hidden');
        $("#loading").show();
            function frame() {
              if (width >= 100) {
                clearInterval(id);
                i = 0;
              } else {
                    // ctr_success = data;
                    ctr = ctr+(1/counts)*100;
                    width = ctr;
                    // $("#test_count").html(ctr_success+"|"+counts+"|"+ctr.toFixed(2)+"|"+leaveID[n]['id'])
                    elem.width(width + "%");
                    if (Math.round(width)<100) {
                        $("#processing_bar").html(width.toFixed(2) + "%");
                    } else {
                        $("#loading").hide();
                        $("#processing_bar").html(counts+" LEAVE/S PROCESSED");
                    }
              }
            }
        }
    }
    /* PROCESS E-LEAVE end*/



    /* HR MANAGEMENT - HOLIDAYS begin */
    //

    /*var years = $("#filter_years");
    var months = $("#filter_months");
    var currentYear = (new Date()).getFullYear();
    years.val('');
    months.val('');
    for (var y = (currentYear+1); y >= 2000; y--) {
        var option_years = $("<option />");
        option_years.html(y);
        option_years.val(y);
        // if ($("#filter_years").val()!=null) {
        //     if (y==$("#filter_years").val()) {
        //         option_years.attr('selected',true);
        //     }
        // } else {
            if (y==currentYear) {
                option_years.attr('selected',true);
            }
        // }
        years.append(option_years);
    }
    var month="";
    for (var m=0; m<12; m++) {
        var option_month = $("<option />");
        option_month.html(month_names[m]);
        if (m<9) { month = "0"+parseInt(m+1); }
        else {month = parseInt(m+1);}
        option_month.val(month);
        months.append(option_month);
    }*/



    $("#show_filter_holidays").click(function (){

        $("#div_filter_months").toggle();
        $("#div_filter_years").toggle();
        return false;
    });

    $("#filter_months").change(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/filter-holidays',
                // url: "{{ url('/filter-holidays') }}",
                method: 'get',
                data: {
                    'filter_month'  : $(this).val(),
                    'filter_year'   : $("#filter_years").val()
                },
                success:function(data){
                    // alert("Gilbert"); return false;
                     $("#view_holidays").html(data);
                }
            });
        return false;
    });
    $("#filter_years").change(function () {
        // alert($(this).val()); return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/filter-holidays',
                method: 'get',
                data: {
                    'filter_month'  : $("#filter_months").val(),
                    'filter_year'   : $(this).val()
                },
                success:function(data){
                     $("#view_holidays").html(data);
                }
            });
        return false;
    });



    function addHolidayValidation (holiday='', holiday_date='', holiday_category='') {
        empty_fields=0;
        var r = /^(\d{2})\/(\d{2})\/(\d{4})$/;
        if (!r.test(holiday_date)) {
            empty_fields++;
        }
        if ($.trim(holiday)=="") {
            empty_fields++;
        }
        if (holiday_category=="") {
            empty_fields++;
        }
        if (empty_fields>0) {
            $("#save_holiday").attr('disabled',true);
        } else {
            $("#save_holiday").removeAttr('disabled');
        }
    }


    $("#add_holidays").click(function () {
        $("#save_holiday").html('SAVE');
        $("#holiday_date").val('');
        $("#holiday_date").prop('disabled', false);
        $("#holiday").val('');
        $("#holiday_category").val('');
        $("#myModalLabel").html("ADD HOLIDAY");
        $("#holidayAddModal").modal('show');
        $("#holiday_date").val("");
        return false;
    });

    $("#holiday").on('change paste keyup keydown', function() {
        addHolidayValidation ( $(this).val(), $("#holiday_date").val(), $("#holiday_category").val());
    });

    $('#holiday_date').on('paste', function(e){
      var content = '';
      if (isIE()) {
        //IE allows to get the clipboard data of the window object.
        content = window.clipboardData.getData('text');
      } else {
        //This works for Chrome and Firefox.
        content = e.originalEvent.clipboardData.getData('text/plain') || "";
      }
        var d = new Date(content),
        month = (d.getMonth()+1),
        day = d.getDate(),
        year = d.getFullYear();
        if (month<10) {month = "0"+month;}
        if (day<10) {day = "0"+day;}

        if (isNaN(month) || isNaN(day) || isNaN(year) ){
            $(this).val("");
        } else {
            e.preventDefault();
            $(this).val([month,day,year].join('/'));
        }
        addHolidayValidation ( $("#holiday").val(), $(this).val(), $("#holiday_category").val());
    });

    function isIE(){
      var ua = window.navigator.userAgent;
      return ua.indexOf('MSIE ') > 0 || ua.indexOf('Trident/') > 0 || ua.indexOf('Edge/') > 0
    }
    $("#holiday_date").on("keyup keydown",function(e) {
        var code = e.keyCode || e.which;

        if (code!=8) {
            if ($(this).val().length==2 || $(this).val().length==5) {
                if ($(this).val().substring(0,2)>12) {
                    $(this).val("0"+$(this).val().substring(0,1));
                }
                $(this).val($(this).val()+'/');
            }
        }
        addHolidayValidation ( $("#holiday").val(), $(this).val(), $("#holiday_category").val());
    });

    $("#holiday_category").change(function () {
        addHolidayValidation ( $("#holiday").val(), $("#holiday_date").val(), $(this).val());
    });

    

    /* HR MANAGEMENT - HOLIDAYS end */


    /* DEPARTMENT begin */
    function departmentValidation (dept_code='', dept_desc='') {
        empty_fields=0;
        if (dept_code=='') {
            empty_fields++;
        }
        if (dept_desc=='') {
            empty_fields++;
        }
        if (empty_fields>0) {
            $("#save_department").attr('disabled', true);
        } else {
            $("#save_department").removeAttr('disabled');
        }
    }

    $("#department_code").on('change paste keyup keydown', function() {
        departmentValidation ( $(this).val(), $("#department").val() );
    });
    $("#department").on('change paste keyup keydown', function() {
        departmentValidation ( $("#department_code").val(), $(this).val() );
    });

    $("#add_department").click(function () {
        $("#save_department").html('SAVE');
        $("#department_code").val('');
        $("#department").val('');
        $("#department").addClass('empty');
        $("#department_code").addClass('empty');
        $("#myModalLabel").html("ADD DEPARTMENT");
        $("#departmentAddModal").modal('show');
        return false;
    });

    $("#save_department").click(function () {
            // alert($(this).html()); return false;
            var url = "";
            if ($(this).html()=="SAVE") {
                url = window.location.origin+'/save-departments';
                $("#dialog_content").html("New Department successfully added!");
            } else {
                url = window.location.origin+'/update-departments';
                $("#dialog_content").html("Update successful!");
            }
            // prompt('', $('#save-department-form').serialize()); return false;
            // alert(url); return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: $('#save-department-form').serialize(), // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#departmentAddModal").modal('hide');


                    $("#dialog" ).dialog({
                        modal: true,
                        title: "DEPARTMENTS",
                        width: "auto",
                        height: "auto",
                        buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                                location.reload();
                            }
                        }
                        ]
                    });
                    // $(".ui-dialog-titlebar").addClass('banner-blue');
                    console.log(data);
                }
            });
        return false;
    });

    //Naps Edits For Department
    $(document).on('dblclick','.edit_department',function(){
        try{
            // alert($(this).val() );
            var dS = $(this).attr('value').split('|');
            $("#save_department").html('UPDATE');
            $("#save_department").attr('disabled',true);
            $("input").removeClass('empty');
            $("select").removeClass('empty');
            $("#hid_department_id").val(dS[0]);
            $("#department_code").val(dS[1]);
            $("#department").val(dS[2]);
            $("#myModalLabel").html("EDIT DEPARTMENT");
            $("#departmentAddModal").modal('show');
        }catch(error){
            console.log(error);
        }
    });


    /* DEPARTMENT end */

    /* OFFICE begin */
    // $("#office_country").select2({
    //     dropdownParent: $('#officeAddModal'),
    //     width: 'resolve',
    //     height: 'resolve'
    // });
    // $("#office_province").select2({
    //     dropdownParent: $('#officeAddModal'),
    //     width: 'resolve',
    //     height: 'resolve'
    // });
    // $("#office_city").select2({
    //     dropdownParent: $('#officeAddModal'),
    //     width: 'resolve',
    //     height: 'resolve'
    // });
    // $("#office_country").addClass('empty');

    function officeValidation (office_code='', office_address='', office_city='', office_province='', office_country='', office_zipcode='', office_tin='', office_contact='',office_barangay='') {
        empty_fields=0;
        if ($.trim(office_code) =='') {empty_fields++;}
        if ($.trim(office_address)=='') {empty_fields++;}
        if ($.trim(office_city)=='') {empty_fields++;}
        if ($.trim(office_province)=='') {empty_fields++;}
        if ($.trim(office_country)=='') {empty_fields++;}
        if ($.trim(office_zipcode)=='') {empty_fields++;}
        if ($.trim(office_tin)=='') {empty_fields++;}
        if ($.trim(office_contact)=='') {empty_fields++;}
        if ($.trim(office_barangay)=='') {empty_fields++;}
        if (empty_fields>0) {
            $("#save_office").attr('disabled', true);
        } else {
            $("#save_office").removeAttr('disabled');
        }
    }

    $("#office_code").on('change paste keyup keydown', function() {
        officeValidation (
            $(this).val(),
            $("#office_address").val(),
            $("#office_city").val(),
            $("#office_province").val(),
            $("#office_country").val(),
            $("#office_zipcode").val(),
            $("#office_tin").val(),
            $("#office_contact").val(),
            $("#office_barangay").val()
            );
    });
    $("#office_address").on('change paste keyup keydown', function() {
        officeValidation (
            $("#office_code").val(),
            $(this).val(),
            $("#office_city").val(),
            $("#office_province").val(),
            $("#office_country").val(),
            $("#office_zipcode").val(),
            $("#office_tin").val(),
            $("#office_contact").val(),
            $("#office_barangay").val()
            );
    });
    $("#office_city").on('change paste keyup keydown', function() {
        officeValidation (
            $("#office_code").val(),
            $("#office_address").val(),
            $(this).val(),
            $("#office_province").val(),
            $("#office_country").val(),
            $("#office_zipcode").val(),
            $("#office_tin").val(),
            $("#office_contact").val(),
            $("#office_barangay").val()
            );
    });
    //setCity on dropdown
    $("#office_province").on('change paste keyup keydown', function() {
        try{
            console.log($('#cityOption').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/cities',
                method: 'get',
                data: {province: $(this).val(),country_code:$('#office_country').val()},
                success:function(data){
                    // prompt('',data); return false;
                    if(isEdit){
                        if( data.map((d)=>d.municipality).indexOf($('#cityOption').val())==-1 && isEditInitialized == false){
                            $('#cityOption').val('');
                            $('#cityOption').text('-Select City-');
                            $('#office_city').trigger('change');
                        }
                        isEditInitialized = false;
                        $('.cities').remove();
                        for (var n=0; n<data.length; n++) {
                            $("#office_city").append("<option class='cities'>"+data[n].municipality+"</option>");
                        }
                        
                    }
                    if(isAdd){
                        $("#office_city").empty();
                        $("#office_city").append('<option id="cityOption" value="">-Select City-</option>`');
                        for (var n=0; n<data.length; n++) {
                            $("#office_city").append("<option>"+data[n].municipality+"</option>");
                        }
                    }  
                }
            });
            // alert('Gilbert');
            officeValidation (
                $("#office_code").val(),
                $("#office_address").val(),
                $("#office_city").val(),
                $(this).val(),
                $("#office_country").val(),
                $("#office_zipcode").val(),
                $("#office_tin").val(),
                $("#office_contact").val(),
                $("#office_barangay").val()
                );
        }catch(error){
            console.log(error)
        }
      
    });

    $("#office_city").on('change paste keyup keydown', function() {
        try{ 
            console.log($('#barangayOption').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/barangays',
                method: 'get',
                data: {municipality: $(this).val(),country_code:$('#office_country').val(),province:$('#office_province').val()},
                success:function(data){
                    // prompt('',data); return false;
                   if(isEdit){
                        if(data){
                            if( data.map((d)=>{ return d.barangay}).indexOf($('#barangayOption').val())==-1){
                                $('#barangayOption').val('');
                                $('#barangayOption').text('-Select Barangay-');
                                // $('#office_barangay').trigger('change');   
                            }
                            $('.barangays').remove();
                            for (var n=0; n<data.length; n++) {
                                $("#office_barangay").append("<option class='barangays'>"+data[n].barangay+"</option>");
                            }
                        }
                       
                   }
                   if(isAdd){
                        $("#office_barangay").empty();
                        $("#office_barangay").append('<option value="">-Select Barangay-</option>');
                        for (var n=0; n<data.length; n++) {
                            $("#office_barangay").append("<option>"+data[n].barangay+"</option>");
                        }
                   }
                }
            });
            // alert('Gilbert');
            officeValidation (
                $("#office_code").val(),
                $("#office_address").val(),
                $(this).val(),
                $("#office_province").val(),
                $("#office_country").val(),
                $("#office_zipcode").val(),
                $("#office_tin").val(),
                $("#office_contact").val(),
                ''
                );
        }catch(error){
            console.log(error)
        }
      
    });

    $("#office_barangay").on('change paste keyup keydown', async function() {
        try{   
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const res = await $.ajax({
                url: '/zipcodes',
                method: 'get',
                data: {barangay: $(this).val(),municipality: $('#office_city').val(),country_code:$('#office_country').val(),province:$('#office_province').val()},
            });
            if(res){
                $("#office_zipcode").val('');
                $("#office_zipcode").val(res.zip_code);
                officeValidation (
                    $("#office_code").val(),
                    $("#office_address").val(),
                    $("#office_city").val(),
                    $("#office_province").val(),
                    $("#office_country").val(),
                    $("#office_zipcode").val(),
                    $("#office_tin").val(),
                    $("#office_contact").val(),
                    $(this).val(),
                );
            }
           
        }catch(error){
            console.log(error)
        }
      
    });


    $("#office_country").on('change paste keyup keydown', async function() {
        try{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/provinces',
                method: 'get',
                data: {'country_code': $(this).val()},
                success:function(data){
                    // prompt('',data); return false;
                    // console.log($('#countryOption').val());
                    if(isEdit){
                       if( data.map((d)=>d.province).indexOf($('#provinceOption').val())==-1){
                            $('#provinceOption').val('');
                            $('#provinceOption').text('-Select Province-');
                            $('#office_province').trigger('change');
                       }
                        $('.provinces').remove();
                        for (var n=0; n<data.length; n++) {
                            $("#office_province").append("<option class='provinces'>"+data[n]['province']+"</option>");
                        }
                    }
                    if(isAdd){
                        $("#office_province").empty();
                        $("#office_province").append(` <option id="provinceOption" value="">-Select Province-</option>`);
                        for (var n=0; n<data.length; n++) {
                            $("#office_province").append("<option>"+data[n]['province']+"</option>");
                        }
                        // $("#office_city").empty();
                        // $("#office_city").append(`<option value="">-Select City-</option>`);
                    }
                    
    
                }
            });
        }catch(error){
            console.log(error);
        }
       
        // alert('Gilbert');
        officeValidation (
            $("#office_code").val(),
            $("#office_address").val(),
            $("#office_city").val(),
            $("#office_province").val(),
            $(this).val(),
            $("#office_zipcode").val(),
            $("#office_tin").val(),
            $("#office_contact").val(),
            $("#office_barangay").val()
            );
    });
    $("#office_tin").on('change paste keyup keydown', function() {
        officeValidation (
            $("#office_code").val(),
            $("#office_address").val(),
            $("#office_city").val(),
            $("#office_province").val(),
            $("#office_country").val(),
            $("#office_zipcode").val(),
            $(this).val(),
            $("#office_contact").val(),
            $("#office_barangay").val()
            );
    });
    $("#office_contact").on('change paste keyup keydown', function() {
        officeValidation (
            $("#office_code").val(),
            $("#office_address").val(),
            $("#office_city").val(),
            $("#office_province").val(),
            $("#office_country").val(),
            $("#office_zipcode").val(),
            $("#office_tin").val(),
            $(this).val(),
            $("#office_barangay").val()
            );
    });
    function resetFields(){
        $('#office_code').val('');

        $('#countryOption').val('');
        $('#countryOption').text('-Select Country-');
        $('#office_country').val('')
       
        $('#office_province').empty();
        $('#office_province').append('<option id="provinceOption" value="">-Select Province-</option>');
        $('#office_city').empty();
        $('#office_city').append('<option id="cityOption" value="">-Select City-</option>');
        $('#office_barangay').empty();
        $('#office_barangay').append('<option id="barangayOption" value="">-Select Barangay-</option>');
        $('#office_address').val('');
        $('#office_zipcode').val('');
        $('#office_tin').val('');
        $('#office_contact').val('');
        id='';
       
    }
    $("#add_office").click(function () {
        // $("#office_code").val(''); $("#office_code").addClass('empty');
        // $("#office_address").val(''); $("#office_address").addClass('empty');
        // $("#office_city").val(''); $("#office_city").addClass('empty');
        // $("#office_province").val(''); $("#office_province").addClass('empty');
        // $("#office_country").val(''); $("#office_country").addClass('empty');
        // $("#office_zipcode").val(''); $("#office_zipcode").addClass('empty');
        // $("#office_tin").val(''); $("#office_tin").addClass('empty');
        // $("#office_contact").val('');$("#office_contact").addClass('empty');

        $("#save_office").html('SAVE');
        isEdit = false;
        isAdd = true;
        resetFields();
        $("#myModalLabel").html("ADD OFFICE");
        $("#officeAddModal").modal('show');
        $("#save_office").prop('disabled',true);
        return false;
    });

    $(document).on('click','#save_office',async function (e) {
        e.preventDefault();
        try{
            isEditInitialized = false;
            const officeFormData = {
                office_id: id ? id : '',
                office_code : $('#office_code').val(),
                office_country : $('#office_country').val(),
                office_province : $('#office_province').val(),
                office_city : $('#office_city').val(),
                office_barangay : $('#office_barangay').val(),
                office_address : $('#office_address').val(),
                office_zipcode : $('#office_zipcode').val(),
                office_tin : $('#office_tin').val(),
                office_contact : $('#office_contact').val(),
    
            }
            console.log(officeFormData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const result = isEdit ? $.ajax({url:'/update-offices', data:officeFormData,method:'POST'}) : $.ajax({url:'/save-offices',data:officeFormData,method:'POST'})
            if(result){
                resetFields();
                isEdit ?  Swal.fire({
                    icon: 'success',
                    title: 'Office has been updated',
                    text: '',
    
                  }).then(function(){
                    window.location.reload();
                  }) :  Swal.fire({
                    icon: 'success',
                    title: 'Office has been saved',
                    text: '',
    
                  }).then(function(){
                    window.location.reload();
                  });
                // window.location.reload();
            }
        }catch(error){
            alert(error);
        }
        //     alert($(this).html()); return false;
        //     var url = "";
        //     if ($(this).html()=="SAVE") {
        //         url = window.location.origin+'/save-office';
        //         $("#dialog_content").html("New Office successfully added!");
        //     } else {
        //         url = window.location.origin+'/update-office';
        //         $("#dialog_content").html("Update successful!");
        //     }
        //     // alert($('#save-department-form').serialize()); return false;
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: url,
        //         method: 'post',
        //         data: $('#save-office-form').serialize(), // prefer use serialize method
        //         success:function(data){
        //             // prompt('',data); return false;
        //             $("#departmentAddModal").modal('hide');
        //             $("#dialog" ).dialog({
        //                 modal: true,
        //                 title: "OFFICE",
        //                 width: "auto",
        //                 height: "auto",
        //                 buttons: [
        //                 {
        //                     id: "OK",
        //                     text: "OK",
        //                     click: function () {
        //                         $(this).dialog('close');
        //                         location.reload();
        //                     }
        //                 }
        //                 ]
        //             });
        //             // $(".ui-dialog-titlebar").addClass('banner-blue');
        //             console.log(data);
        //         }
        //     });
        // return false;
    });
    $(document).on('dblclick','.office-table tr',async function(){
        isEditInitialized = true;
        isEdit = true;
        isAdd = false;
        id = this.id;
        console.log(this.id);
        
        let country = '';
        console.log('Hello');
        $("#myModalLabel").html('Edit Office');
        $("#save_office").html('UPDATE');
        $('#dataLoad').css('display','flex');
        $('#dataLoad').css('position','absolute');
        $('#dataLoad').css('top','40%');
        $('#dataLoad').css('left','40%');
    
        const result = await $.ajax({url:'/getoffice',data:{id:this.id},method:'GET'});
        if(result){
            const {office} = result;
            if(office.country == 'PH'){
                country = 'Philippines';
            }
            $('#dataLoad').css('display','none');
            
            $('#office_code').val(office.company_name);

            $('#office_country').val(office.country);
            $('#countryOption').val(office.country);
            $('#countryOption').text(country);
            $('#office_country').trigger('change');
            
            $('#provinceOption').val(office.province);
            $('#provinceOption').text(office.province);
            $('#office_province').val(office.province);
            $('#office_province').trigger('change');
          
            $('#cityOption').val(office.city);
            $('#cityOption').text(office.city);
            $('#office_city').val(office.city);
            $('#office_city').trigger('change');

            $('#barangayOption').val(office.barangay);
            $('#barangayOption').text(office.barangay);
            $('#office_barangay').trigger('change');
     

            $('#office_address').val(office.address);
            $('#office_zipcode').val(office.zipcode);
            $('#office_tin').val(office.tin);
            $('#office_contact').val(office.contact);
            $('#officeAddModal').modal('show');
            
        }
    
    });
    /* OFFICE end */



     // var currentRow=$(this).closest("tr");
     // var col1=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
     // var col2=currentRow.find("td:eq(1)").text(); // get current row 2nd TD
     // var col3=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
     // var data=col1+"\n"+col2+"\n"+col3;
     // alert(data);

    /* ======= FULL CALENDAR =======*/
    /*$('#calendar').fullCalendar({
         eventStartEditable : false
    });*/


    /* =========== MEMO ===========*/

    /*$("[name=add_memo]").click(function() {
        // alert('Gilbert');
        $("#modalAddMemo").modal("show");
    });*/


    /*var timeoutId = 0;
    $('#notification_bell').on('mousedown', function(event) {
        alert(event.which); return false;
        timeoutId = setTimeout(myFunction, 1000);
    }).on('mouseup mouseleave', function() {
        clearTimeout(timeoutId);
    });*/

    function webCamModal () {
        // return alert('Gibs...');
    }

});


                                                     