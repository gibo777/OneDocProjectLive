
$(document).ready( function () {

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

    /* EXPORT TO EXCEL TIMELOGS */
    $(document).on('click','#exportExcelLeaves',async function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/leaves-excel',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(html){
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                // Get the value of hidCurrentDate
                var currentDateValue = tempDiv.querySelector('#hidCurrentDate').value;
                var filename = `Leaves_${currentDateValue}.xlsx`;

                var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = filename; // Use .xls extension for Excel files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            }
        }); 
        return false;

    });

    /* Reroute to Leave Form */
    $(document).on('click','#createNewLeave', async function() {
        window.location.href = lReq;
    });

    /* Viewing Leave Details per Control Number - Gibs */
    $(document).on('dblclick','.view-leave',function(){
        let modalWidth = '75%';
        
        if ($(window).width() <= 768) {
            modalWidth = '100%';
        }
        const lID = $(this).attr('id');
        var lType = '', lOthers='';

        $.ajax({
            url: '/e-forms/leave-detailed',
            method: 'get',
            data: {'id': lID },
            success: function(html) {
                Swal.fire({
                    html: html,
                    showCloseButton: true,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    width: modalWidth,
                });

                $("#bApproveLeave").click(function () {
                    if ($('#dLtype').length) {
                        lType = $('#dLtype').val();
                        if (lType=='Others') {
                            lOthers = $('#dLOthers').val();
                        }
                    }
                    approveLeave(lID,lType,lOthers);
                });

                $('#bDenyLeave').click(function() {
                    alert('test Deny');
                });
                
                $('#bCancelLeave').click(function() {
                    alert('test Cancel');
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

    });

    $(document).on('click', '#leave_form',async function() {
        var leave_id = $('#hid_leave_id').val();
        window.location.href = "/hris/view-leave/form-leave/" + leave_id;
    });

    $("#date_from").change(function(){
        // alert($("#reason").val()); return false;
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
                data: {'leave_reference': $(this).attr('value') }, // prefer use serialize method
                success:function(data){
                    Swal.fire({ 
                        html: `<div class="banner-blue pl-2 p-1 text-md text-left">
                                    Leave History (Control #${data[0]['control_number']})
                                </div>`, 
                    });
                    /*var historyLabel = "Leave History";
                    $('#lHName').text('Name: '+data[0]['name']);
                    $('#lHSupervisor').text('Supervisor: '+data[0]['head_name']);

                    $("#data_history > tbody").empty();

                    for(var n=0; n<data.length; n++) {
                        $("#data_history > tbody:last-child")
                        .append('<tr>');
                        $("#data_history > tbody:last-child")
                        .append('<td>'+data[n]['action']+'</td>')
                        .append('<td class="text-nowrap" id="title'+n+'" title="'+data[n]['action_reason']+'">'+data[n]['action_reason']+'</td>')
                        .append('<td>'+data[n]['created_at']+'</td>')
                        ;

                        $("#title"+n).click(function () {
                            $(this).attr('title').show();
                        });
                    }
                    if ($("#hid_access_id").val()==1) {
                        historyLabel = historyLabel+" of "+data[0]['name'];
                    }
                    historyLabel = historyLabel+" (Control #"+data[0]['control_number']+")";
                    $("#leaveHistoryLabel").html(historyLabel.toUpperCase());
                    $("#modalHistory").modal("show");*/
                }
            });
        }catch(error){
            console.log(error);
        }
    });

    $(document).on('change','#dLtype', async function() {
        if ($(this).val()=='Others') {
            $('#divLOthers').prop('hidden',false);
        } else {
            $('#divLOthers').prop('hidden',true);
        }
    });

    function approveLeave(lID, lType, lOthers) {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var dataObject = {
                'lID'       : lID,
                'lType'     : lType,
                'lOthers'   : lOthers
            };
            $.ajax({
                url: window.location.origin+'/e-forms/head-approve',
                method: 'post',
                data: { 'lData': dataObject },
                success:function(data){
                    Swal.fire({
                        title: 'Approved by Head.',
                        icon: 'success',
                        html: data,
                    }).then(() => {
                        Livewire.emit('pageSizeChanged');
                    });
                    console.log(data);
                }
            });
    }


});