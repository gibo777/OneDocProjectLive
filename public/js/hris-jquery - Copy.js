$(document).ready(function(){
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

    date_applied.val(currentDate()); // Applied Date - Current Date
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

    $(function () {
        // $('#date_applied').datepicker({ dateFormat: 'mm/dd/yy' });
        $('#date_from').datepicker({ 
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true 
        });
        $('#date_to').datepicker({ 
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true 
        });

        $('#holiday_date').datepicker({ 
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true 
        });

    });
    // UPDATE


    /*if (hid_dept.val() != "") {
    $("#department option[value="+hid_dept.val()+"]").attr('selected', 'selected');
    }*/
    

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
        if ( Date.parse(dateto) < Date.parse(datefrom)) {
            $("#range_notice").html("Invalid Date Range.");
            $("#range_notice").css("color","#ff0800");
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
                    // $("#dialog_content").html("LEAVE FORM successfuly updated.").css('color','#008000');
                    // $("#popup" ).attr('title','NOTIFICATION');
                             
                }
            });
            return false;
    }


    $("#leave_type").change(function(){
        // alert('gilbert'); return;
        // alert(leave_type.val()); return false;
            leaveValidation($("#date_from").val(),$("#date_to").val(),$("#leave_type").val());
            if ($("#leave_type").val()=="Others") {
                // alert('gilbert'); return false;
                $("#div_others").show();
                $("#div_others").attr('hidden', false);
                $("#others_leave").attr('hidden',false);
                $("#others_leave").focus();
            } else {
                $("#div_others").hide();
                //$("#others_leave").val('');
            }

            /*if ($("#hid_no_days").val()!=""){ */leaveBalance ();/* }*/

            if ($("#leave_type").val()=="SL" || $("#leave_type").val()=="EL") {
                return true;
            } else {
                // alert(priorLeaveValidation(currentDate(),$("#date_from").val())); return false;
                if (priorLeaveValidation(currentDate(),$("#date_from").val()) <3 && $("#leave_type").val()!="") {
                    $("#dialog_content").html("Application for leave of absence must be filed at the latest, <br>three (3) working days prior to the date of leave.").css('color','#FF0000');
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
            }
    });

    /*$("#date_from").click(function (){
        if ($("#leave_type").val()=="") {
            $("#pop_content").html("Please Select Leave Type").css('color','#FF0000');
                $("#popup" ).dialog({
                    modal: true,
                    title: "NOTICE",
                    width: "auto",
                    height: "auto",
                    buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                                $("#leave_type").focus();
                            }
                        }
                    ]
            });
        }
    });*/

    $("#date_from").change(function(){
        $("#number_of_days").html('');
            if ($("#leave_type").val()=="SL" || $("#leave_type").val()=="EL") {
                return true;
            } else {
                /*var prior = priorLeaveValidation(currentDate(),$("#date_from").val());
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
                } else {*/
                    $("#date_to").val($(this).val());
                    $(this).removeClass('empty');
                    $("#date_to").removeClass('empty');
                /*}*/
            }

        leaveValidation($("#date_from").val(),$("#date_to").val(),$("#leave_type").val());
    });


    $("#date_to").change(function(){
        $("#number_of_days").html('');
        leaveValidation($("#date_from").val(),$("#date_to").val(),$("#leave_type").val());
    });

    $("#leave_type").change(function () {
        if ($(this).val()=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
            $("#others_leave").keyup(function () {
                if ($.trim($(this).val())=="") {
                    $(this).addClass('empty');
                    empty_fields++;
                } else {
                    $(this).removeClass('empty');
                }
            });
        }
    });


    $("input[name='leave_notification[]']").each(function() {
        var checked=0;
        $(this).change(function () {
            if ($("input[name='leave_notification[]']:checked").length == 0) {
                $("input[name='leave_notification[]']").addClass('empty');
            } else {
                $("input[name='leave_notification[]']").removeClass('empty');
            }
        });
    });

    $("#reason").keyup(function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });

    $("input").keyup(function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });

    $("textbox").keyup(function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });

    $("select").change(function () {
        if ($(this).val()=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });

    /* SUBMIT LEAVE FORM begin*/
    $("#submit_leave").click(function (){
        if ($("input[name='leave_notification[]']:checked").length == 0) {
            $("input[name='leave_notification[]']").each(function() {
                $(this).addClass('empty');
            });
            empty_fields++;
        } else {
            $("input[name='leave_notification[]']").each(function() {
                $(this).removeClass('empty');
            });
        }

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
            $("#pop_content").html("Kindly fill-up all required fields").css('color','#FF0000');
            // $("#popup" ).attr('title','NOTIFICATION');
            $("#popup" ).dialog({
                modal: true,
                title: "NOTIFICATION",
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
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/hris/eleave',
                method: 'post',
                data: $('#leave-form').serialize(), // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#pop_content").html("LEAVE FORM successfuly submitted!");
                    $("#popup" ).attr('title','NOTIFICATION');
                    $("#popup" ).dialog({
                        modal: true,
                        title: "Confirmation",
                        width: "auto",
                        height: "auto",
                        buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                                // location.reload();
                                window.location = window.location.origin+"/hris/view-leave";
                            }
                        }
                        ]
                    });
                    console.log(data);          
                }
            });
        }
        return false;
    });
    /* SUBMIT LEAVE FORM end*/

    $("#show_filter").click(function (){
        // alert($("#filter_fields").attr('hidden'));
        if ($("#div_filter_leave_type").attr('hidden')=='hidden') {
            $("#div_filter_department").removeAttr('hidden');
            $("#div_filter_leave_type").removeAttr('hidden');
        } else {
            $("#div_filter_department").attr('hidden','hidden');
            $("#div_filter_leave_type").attr('hidden','hidden');
            // $("#filter_fields").toggle(200);
        }
        return false;
    });


    /* VIEW HISTORY begin*/
    $("#status_view > button").each(function (){
        $(this).click(function() {
        /*alert("Access ID: "+$("#hid_access_id").val()
            +"\nLeave ID: "+$(this).val()); return false;*/
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
                        .append('<td id="title'+n+'" title="'+data[n]['action_reason']+'">'+data[n]['action_reason'].slice(0,10)+'</td>')
                        .append('<td>'+data[n]['date_applied']+'</td>')
                        .append('<td>'+data[n]['date_from']+'</td>')
                        .append('<td>'+data[n]['date_to']+'</td>')
                        .append('<td>'+data[n]['no_of_days']+'</td>');
                        
                        $("#title"+n).click(function () {
                            $(this).attr('title').show();
                        });
                    }
                    var historyLabel = "leave history";
                    if ($("#hid_access_id").val()==1) {
                        historyLabel = historyLabel+" of "+data[0]['name'];
                    }
                    historyLabel = historyLabel+" (Leave #"+data[0]['leave_number']+")";
                    // var historyLabel = "leave history of Pangalan"+" (leave #"+7+")";
                    $("#leaveHistoryLabel").html(historyLabel.toUpperCase());
                    $("#modalHistory").modal("show");
                }
            });

            
            return false;
        });
    });
    /* VIEW HISTORY end */

    /* VIEW ALL LEAVES begin */
    $("#action_buttons > button").each(function (){
        $(this).click(function(){
            var actionID = $(this).attr('id').split("-");
            var action = actionID[0];
            var leaveID = actionID[1];
            $("#popup").show();
            $("#confirm_reason").val('');

            if (action=="open" || action=="history") {
                // alert(window.location.origin+'/hris/view-leave-details'); return false;
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

                        // alert(data[0]['employee_id']);
                        var leave_number = data[0]['leave_number'];
                        var modalHeader = "VIEW LEAVE #"+leave_number;
                        var dateFrom = data[0]['date_from'].split('-');
                            dateFrom = dateFrom[1]+"/"+dateFrom[2]+"/"+dateFrom[0];
                        var dateTo = data[0]['date_to'].split('-');
                            dateTo = dateTo[1]+"/"+dateTo[2]+"/"+dateTo[0];
                        var notif1 = "", notif2 = "", notif3 = "";
                        var notification = data[0]['notification'].split('|');

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
                        $("input[name='leave_notification[]']").each( function() {
                            $(this).removeAttr("disabled");
                        });


                        $("input[name='leave_notification[]']").each( function() {
                            $(this).prop("checked", false);
                            for (var i=0; i<notification.length; i++) {
                                if (notification[i]==$(this).val()) {
                                    $(this).prop("checked", true);
                                } 
                            }
                        });
                        $("#hid_leave_id").val(data[0]['id']);
                        $("#myModalLabel").html(modalHeader);
                        $("#name").val(data[0]['name']);
                        $("#employee_number").val(data[0]['employee_id']);
                        $("#hid_dept").val(data[0]['department']);
                        $("#department").val(data[0]['dept']);
                        if (data[0]['status']=="Pending") {
                            $("#date_applied").val(currentDate());
                        } else {
                            $("#date_applied").val(formatDates(data[0]['date_applied']));
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

                        if (data['auth_access']==1) {
                            if (data['auth_id']==data[0]['supervisor']) {
                                $("#date_from").attr('disabled', true);
                                $("#date_to").attr('disabled', true);
                                $("#leave_type").attr('disabled', true);
                                $("#reason").attr('disabled', true);
                                $("#others_leave").attr('readonly', true);
                                $("input[name='leave_notification[]']").each( function() {
                                    $(this).attr("disabled", true);
                                });
                                if (data[0]['status']=="Pending") {
                                    $("#deny_leave").show();
                                    $("#approve_leave").show();
                                } else {
                                    if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied") {
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
                                        $("input[name='leave_notification[]']").each( function() {
                                            $(this).attr("disabled", true);
                                        });
                                        if (data[0]['status']=="Cancelled") {
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
                                    $("input[name='leave_notification[]']").each( function() {
                                        $(this).attr("disabled", true);
                                    });
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
                                if (data[0]['status']=="Cancelled" || data[0]['status']=="Denied") {
                                    $("#cancel_leave").hide();
                                } else {
                                    $("#cancel_leave").show();
                                }
                                $("#date_from").attr('disabled', true);
                                $("#date_to").attr('disabled', true);
                                $("#leave_type").attr('disabled', true);
                                $("#reason").attr('disabled', true);
                                $("#others_leave").attr('readonly', true);
                                $("input[name='leave_notification[]']").each( function() {
                                    $(this).attr("disabled", true);
                                });
                            }
                        }
                        /* OPEN MODAL View */
                        $("#myModal").modal("show");  
                    }
                });


                
            } else if (action=="delete") {
                $("#pop_content").html(" Are you sure you want to delete Leave #" + leaveID + "?").css('color','#FF0000');
                // $("#popup" ).removeAttr('hidden');
                $("#popup" ).dialog({
                    modal: true,
                    title: "DELETE LEAVE APPLICATION",
                    width: "auto",
                    height: "auto",
                    buttons: [
                        {
                            id: "Cancel",
                            text: "Cancel",
                            click: function () {
                                $(this).dialog('close');
                            }
                        },
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                // alert(leaveID); return false;
                                /* UPDATE-DELETE begin */
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
                                        // $("#dialog_content").html(data).css('color','#008000');
                                        $("#popup" ).dialog('close');
                                        $("#dialog_content").html("Leave form deleted").css('color','#008000');
                                        // $("#dialog" ).removeAttr('hidden');
                                        $("#dialog" ).dialog({
                                            modal: true,
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
                                        console.log(data);          
                                    }
                                });
                                /* UPDATE-DELETE end */
                            }
                        }
                    ]
                });
            } else if (action=="edit_holiday") {
                // alert("Action: "+ action+"\nStrings: "+$(this).val()); return false;
                var hS = $(this).val().split('|');
                var hD = hS[1].split('-');
                $("input").removeClass('empty');
                $("select").removeClass('empty');
                $("#holiday").val(hS[2]);
                $("#holiday_date").val([hD[1],hD[2],hD[0]].join('/'));
                $("#holiday_category").val(hS[3]);
                $("#myModalLabel").html("EDIT HOLIDAY");
                $("#holidayAddModal").modal('show');
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
    $("#filter_leave_type").change(function () {
        filterLeaves ($("#filter_search").val(),$("#filter_leave_type").val(),$("#filter_department").val());
    });
    $("#filter_department").change(function () {
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
                    $("#dialog_content").html("LEAVE FORM successfuly updated.").css('color','#008000');
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
                    });
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
                    $("#myModal").modal("hide");
                    // $("#dialog_content").html(data);
                    $("#dialog_content").html("Approved by Head.");
                    $("#dialog" ).dialog({
                        modal: true,
                        title: "Confirmation",
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
                        $("#dialog_content").html(data);
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
                        });
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
                    // $("#dialog_content").html(data);
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
                    });
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

    $('table').DataTable();

    /* NAVIGATIONS beging */
    /*$("#nav_home").click( function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
        // data.push({'leave_id': $("#leave_id").val()});
        $.ajax({
            url: window.location.origin+'/welcome',
            method: 'get',
            data: { 'leaveID': $("#leave_id").val() }, // prefer use serialize method
            success:function(data){
                // $("#dialog_content").html(data).css('color','#008000');
                // $("#view_header").html("HOME")
                $("#module_content").html(data);
                    
            }
        });
        return false;
    });
    
    $("#nav_eleave").click( function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
        // data.push({'leave_id': $("#leave_id").val()});
        $.ajax({
            url: window.location.origin+'/hris/eleave',
            method: 'get',
            data: { 'leaveID': $("#leave_id").val() }, // prefer use serialize method
            success:function(data){
                // $("#dialog_content").html(data).css('color','#008000');
                $("#view_header").html("APPLICATION FOR LEAVE OF ABSENCE")
                $("#view_modules").html(data);
                    
            }
        });
        return false;
    });


    $("#nav_view_leaves").click( function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
        // data.push({'leave_id': $("#leave_id").val()});
        $.ajax({
            url: window.location.origin+'/hris/view-leave',
            method: 'get',
            data: { 'leaveID': $("#leave_id").val() }, // prefer use serialize method
            success:function(data){
                // $("#dialog_content").html(data).css('color','#008000');
                $("#view_header").html("APPLICATION FOR LEAVE OF ABSENCE")
                $("#view_modules").html(data);
                    
            }
        });
        return false;
    });

    $("#nav_leaves_calendar").click( function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var data = $('#update-leave-form').serialize() + "&leave_id=" + $("#leave_id").val();
        // data.push({'leave_id': $("#leave_id").val()});
        $.ajax({
            url: window.location.origin+'/leave-calendar',
            method: 'get',
            data: { 'leaveID': $("#leave_id").val() }, // prefer use serialize method
            success:function(data){
                // $("#dialog_content").html(data).css('color','#008000');
                $("#view_header").html("APPLICATION FOR LEAVE OF ABSENCE")
                $("#view_modules").html(data);
                    
            }
        });
        return false;
    });*/

    /* NAVIGATIONS end */

    /* PROCESS E-LEAVE begin */
    $("#btn_process").click(function() {
        var url = window.location.origin+'/view-processing-leave';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            data: { 'data': 'data' }, // prefer use serialize method
            success:function(id){
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
                        $("#processing_bar").html(counts+" LEAVES PROCESSED");
                    }
              }
            }
        }
    }
    /* PROCESS E-LEAVE end*/



    /* HR MANAGEMENT - HOLIDAYS begin */
    //

    var years = $("#filter_years");
    var months = $("#filter_months");
    var currentYear = (new Date()).getFullYear();
    // alert(currentYear);
    for (var i = currentYear+5; i >= 2000; i--) {
        var option_years = $("<option />");
        option_years.html(i);
        option_years.val(i);
        if (i==currentYear) {
            option_years.attr('selected',true);
        }
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
    }



    $("#show_filter_holidays").click(function (){
        // alert("Gilbert");
        /*if ($("#div_filter_holidays").attr('hidden')=='hidden') {
            $("#div_filter_holidays").removeAttr('hidden');
        } else {
            $("#div_filter_holidays").attr('hidden','hidden');
            // $("#filter_fields").toggle(200);
        }*/

        $("#div_filter_months").toggle();
        $("#div_filter_years").toggle();
        return false;
    });

    $("#filter_months").change(function () {
        alert($(this).val()); return false;
    });
    $("#filter_years").change(function () {
        // alert('Gilbert'); return false;
        var url = window.location.origin+'/filter-holidays';
        alert(url); return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'get',
                data: $('#holidays-form').serialize(), // prefer use serialize method
                success:function(data){
                    alert("Gilbert"); return false;
                     $("#view_holidays").html(data);
                }
            });
        return false;
    });

    $("#add_holidays").click(function () {
        $("input").val('');
        $("select").val('');
        $("input").removeClass('empty');
        $("select").removeClass('empty');
        $("#myModalLabel").html("ADD HOLIDAY");
        $("#holidayAddModal").modal('show');
        $("#holiday_date").val("");
        return false;
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
                // $(this).val($(this).val()+"/");
            }

            // if ($(this).val().length>=10) {
                // $(this).text(10);
            // }
        } /*else {
            if ($(this).val().length==6 || $(this).val().length==3) {
                $(this).val($(this).val().slice(0,$(this).val().length-1));
            }
            // $("#holiday").val($(this).val().length);
        }*/
    });

    $("#save_holiday").click(function () {
        empty_fields=0;
        if ($("#holiday_category").val()=="") {
            $("#holiday_category").addClass('empty');
            empty_fields++;
        } else { $("#holiday_category").removeClass('empty'); }

        if ($("#holiday_date").val()=="") {
            $("#holiday_date").addClass('empty');
            empty_fields++;
        } else { $("#holiday_date").removeClass('empty'); }

        if ($.trim($("#holiday").val())=="") {
            $("#holiday").addClass('empty');
            empty_fields++;
        } else { $("#holiday").removeClass('empty'); }

        // alert(empty_fields); return false;
        if (empty_fields>0) {
            $("#modalError").modal('show');
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.location.origin+'/save-holidays',
                method: 'post',
                data: $('#save-holiday-form').serialize(), // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    $("#holidayAddModal").modal('hide');
                    $("#dialog_content").html("HOLIDAY ADDED!");
                    // $("#popup" ).attr('title','NOTIFICATION');
                    $("#dialog" ).dialog({
                        modal: true,
                        title: "Confirmation",
                        width: "auto",
                        height: "auto",
                        buttons: [
                        {
                            id: "OK",
                            text: "OK",
                            click: function () {
                                $(this).dialog('close');
                                // location.reload();
                            }
                        }
                        ]
                    });
                    console.log(data);          
                }
            });
        }
        return false;
    });

    /* HR MANAGEMENT - HOLIDAYS end */


});  
