

$(document).ready( function () {

if (countOTS > 0) { 
    var tableLeaves = $('#dataViewOvertimes').DataTable({
    "ordering": false,
    "lengthMenu": [5, 10, 15, 25, 50, 75, 100], // Customize the options in the dropdown
    "iDisplayLength": 15, // Set the default number of entries per page
    "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
    "initComplete": function () {
        // Custom search function
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var sO = $('#fOtOffice').val();
            var sD = $('#fOtDept').val();
            var sS = $('#fReqStatus').val().toUpperCase();

            var cO = data[1]; // Office Column
            var cD = data[2]; // Department Column
            var cS = data[8].toUpperCase(); // Status Column

            // Check if an office filter is selected
            var fOfficeActive = (sO != null && sO !== '');
            // Check if a department filter is selected
            var fDeptActive = (sD != null && sD !== '');
            // Check if a request status filter is selected
            var fReqStatusActive = (sS != null && sS !== '');

            // Apply filters
            if (!fOfficeActive && !fDeptActive && !fReqStatusActive) {
                return true; // No filters applied, show all rows
            }

            var officeMatch = !fOfficeActive || cO.includes(sO);
            var deptMatch = !fDeptActive || cD.includes(sD);
            var statusMatch = !fReqStatusActive || cS.includes(sS);

            return officeMatch && deptMatch && statusMatch;
        });

        // Apply the search
        $('#fOtOffice, #fOtDept, #fReqStatus').on('change', function () {
            tableLeaves.draw();
        });

        /* START - Date From and Date To Searching */
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var searchDateFrom = $('#fOtDateFrom').val();
            var searchDateTo = $('#fOtDateTo').val();

            // Convert search date strings to Date objects
            var dateFrom = new Date(searchDateFrom);
            var dateTo = new Date(searchDateTo);

            // Set the time to the start and end of the selected days
            dateFrom.setHours(0, 0, 0, 0);
            dateTo.setHours(23, 59, 59, 999);

            // Get the time-in and time-out values from columns 3 and 4
            var searchBeginDate = data[5];
            var searchEndDate = data[6];

            // Convert time-in and time-out strings to Date objects (if applicable)
            var timeIn = searchBeginDate ? new Date(searchBeginDate) : null;
            var timeOut = searchEndDate ? new Date(searchEndDate) : null;

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
        $('#fOtDateFrom').on('keyup change', function() {
            if ($('#fOtDateTo').val()=='' || $('#fOtDateTo').val()==null) {
                $('#fOtDateTo').val($(this).val());
            } else {
                var dateFrom = new Date($(this).val());
                var dateTo = new Date($('#fOtDateTo').val());
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
        $('#fOtDateTo').on('keyup change', function() {
            var dateFrom = new Date($('#fOtDateFrom').val());
            var dateTo = new Date($(this).val());
            if( dateTo < dateFrom ) {
                $(this).val($('#fOtDateFrom').val());
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                });
            }
            tableLeaves.draw();
        });
        /* END - Date From and Date To Searching */

    }
});
}


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


/* EXPORT TO EXCEL TIMELOGS */
    $(document).on('click','#exportExcelOvertimes',async function() {
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
$(document).on('click', '#requestNewOvertime', function(event) {
    event.preventDefault(); // Prevent the default action of the button click
    var overtimeUrl = $(this).data('route');
    window.location.href = overtimeUrl;
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
                    var otControlNumber = otDtls.ot_control_number;
                    var modalHeader = "Control No. " + otControlNumber;+

                    (otDtls.is_cancelled==1 || otDtls.is_denied) ? $('#otCancelRequest').hide() : $('#otCancelRequest').show();
                    if (isHead ==1) {

                        if (otDtls.employee_id==supervisor) {
                            $('#otDenyRequest').hide();
                            $('#otApproveRequest').hide();
                        } else {
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

    $(document).on('click','.open_overtime',function(e){
        try{
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/hris/view-othistory',
                method: 'get',
                data: {'otRef': $(this).val() }, // prefer use serialize method
                success:function(data){
                    var historyLabel = "Request Status";
                    $('#otHName').text('Name: '+data[0]['name']);
                    $('#otHSupervisor').text('Supervisor: '+data[0]['head_name']);

                    $("#data_history > tbody").empty();

                    for(var n=0; n<data.length; n++) {
                        $("#data_history > tbody:last-child")
                        .append('<tr>');
                        $("#data_history > tbody:last-child")
                        // .append('<td class="text-nowrap">'+data[n]['name']+'</td>')
                        // .append('<td>'+data[n]['date_applied']+'</td>')
                        // .append('<td>'+data[n]['ot_hours']+'</td>')
                        // .append('<td>'+data[n]['ot_minutes']+'</td>')
                        // .append('<td>'+data[n]['ot_hrmins']+'</td>')
                        .append('<td class="text-nowrap">'+data[n]['action']+'</td>')
                        .append('<td class="text-nowrap" id="title'+n+'" title="'+data[n]['action_reason']+'">'+data[n]['action_reason']/*.slice(0,10)*/+'</td>')
                        .append('<td class="text-nowrap">'+data[n]['action_date']+'</td>')
                        // .append('<td class="text-nowrap">'+data[n]['head_name']+'</td>')
                        ;

                        $("#title"+n).click(function () {
                            $(this).attr('title').show();
                        });
                    }
                    if ($("#hid_access_id").val()==1) {
                        historyLabel = historyLabel+" of "+data[0]['name'];
                    }
                    historyLabel = historyLabel+" (Control #"+data[0]['ot_control_number']+")";
                    $("#otHistoryLabel").html(historyLabel.toUpperCase());
                    $("#myModalOT").modal("show");
                }
            });
        }catch(error){
            console.log(error);
        }
    });
    
});
