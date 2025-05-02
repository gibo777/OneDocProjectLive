$(document).ready(function () {
    let parentSwalOpen = false;

    /* EXPORT TO EXCEL TIMELOGS */
    $(document).on('click', '#exportExcelLeaves', async function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/leaves-excel',
            method: 'GET',
            data: { 'id': $(this).attr('id') },
            success: function(html) {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                let currentDateValue = tempDiv.querySelector('#hidCurrentDate').value;
                let filename = `Leaves_${currentDateValue}.xlsx`;

                let blob = new Blob([html], { type: 'application/vnd.ms-excel' });
                let url = window.URL.createObjectURL(blob);

                let a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error('Error exporting to Excel:', error);
            }
        });

        return false;
    });

    /* Reroute to Leave Form */
    $(document).on('click', '#createNewLeave', function() {
        window.location.href = lReq;
    });

    /* Viewing Leave Details per Control Number - Gibs */
    $(document).on('dblclick', '.view-leave', function() {
        let modalWidth = $(window).width() <= 768 ? '100%' : '75%';
        let clickCtr = 0;
        const lID = $(this).attr('id');

        $.ajax({
            url: '/e-forms/leave-detailed',
            method: 'GET',
            data: { 'id': lID },
            success: function(html) {
                parentSwalOpen = true;
                Swal.fire({
                    html: html,
                    showCloseButton: true,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    width: modalWidth,
                    didOpen: () => {
                        $("#bApproveLeave").click(function() {
                            const lType = $('#dLtype').val() || '';
                            const lOthers = lType === 'Others' ? $('#dLOthers').val() : '';
                            approveLeave(lID, lType, lOthers);
                        });

                        $('#bDenyLeave').click(function() {
                            if (clickCtr === 0) {
                                const lType = $('#dLtype').val() || '';
                                const lOthers = lType === 'Others' ? $('#dLOthers').val() : '';
                                denyLeave(lID, lType, lOthers, $('#dLName').html(), $('#dLDate').html(), $('#dHType').html());
                            }
                            clickCtr++;
                        });

                        $('#bCancelLeave').click(function() {
                            if (clickCtr === 0) {
                                const lType = $('#dLtype').val() || '';
                                const lOthers = lType === 'Others' ? $('#dLOthers').val() : '';
                                cancelLeave(lID, lType, lOthers, $('#dLName').html(), $('#dLDate').html(), $('#dHType').html());
                            }
                            clickCtr++;
                        });
                    },
                    didClose: () => {
                        parentSwalOpen = false;
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching leave details:', error);
            }
        });
    });

    $(document).on('click', '#leave_form', function() {
        let leave_id = $('#hid_leave_id').val();
        window.location.href = `/hris/view-leave/form-leave/${leave_id}`;
    });

    $("#date_from").change(function() {
        $("#number_of_days").html('');
        let dateFrom = $(this).val();
        $("#date_to").val(dateFrom || $("#date_to").val());
    });

    $(document).on('click', '.open_leave', function(e) {
        try {
            e.preventDefault();
            let modalWidth = $(window).width() <= 768 ? '100%' : '50%';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `${window.location.origin}/hris/view-history`,
                method: 'GET',
                data: { 'leave_reference': $(this).attr('value') },
                success: function(data) {
                    let dLHistory = `<table class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                        <thead class="thead">
                            <tr class="dt-head-center">
                                <th class="py-1">Status</th>
                                <th class="py-1">Reason</th>
                                <th class="py-1">Date</th>
                            </tr>
                        </thead>`;

                    data.forEach(item => {
                        dLHistory += `<tr>
                            <td class="py-1">${item['action']}</td>
                            <td class="py-1">${item['action_reason']}</td>
                            <td class="py-1">${item['created_at']}</td>
                        </tr>`;
                    });
                    dLHistory += `</table>`;

                    Swal.fire({
                        width: modalWidth,
                        confirmButtonText: "Close",
                        html: `<div class="banner-blue pl-2 p-1 text-md text-left">
                                    Leave History (<strong>${data[0]['control_number']}</strong>)
                                </div>
                                <div class="row text-sm w-full text-left my-2">
                                    <div class="col-md-6"><em>Name:</em> <strong>${data[0]['name']}</strong></div>
                                    <div class="col-md-6"><em>Supervisor:</em> <strong>${data[0]['head_name']}</strong></div>
                                </div>
                                ${dLHistory}`
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching leave history:', error);
                }
            });
        } catch (error) {
            console.log('Error:', error);
        }
    });

    $(document).on('change', '#dLtype', function() {
        $('#divLOthers').prop('hidden', $(this).val() !== 'Others');
    });

    function approveLeave(lID, lType, lOthers) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dataObject = {
            'lID': lID,
            'lType': lType,
            'lOthers': lOthers
        };

        $.ajax({
            url: `${window.location.origin}/e-forms/head-approve`,
            method: 'POST',
            data: { 'lData': dataObject },
            beforeSend: function() {
                $('#dataProcess').css({
                    'display'   : 'flex',
                    'position'  : 'fixed',
                    'top'       : '50%',
                    'left'      : '50%',
                    'transform' : 'translate(-50%, -50%)'
                });

            },
            success: function(data) {
                $('#dataProcess').hide();
                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        let leaveData = data.dataLeave;
                        Livewire.emit('refreshComponent');
                        // Email Notification
                        $.ajax({
                            url     : `${window.location.origin}/e-forms/notify-leave-action`,
                            method  : 'POST',
                            data    : { 
                                'lID'       : lID,
                                'dMail'     : data.dataLeave,
                                'dAction'   : 'Approved',
                            },
                            success : function(dataMail) {
                                // Swal.fire({ html: dataMail }); return false;
                            }
                        });
                    });
                    console.log('Approve Leave Data:', data);
                } else {
                    Swal.fire({
                        title: data.message,
                        icon: 'error',
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error approving leave:', error);
            }
        });
    }

    function denyLeave(lID, lType, lOthers, dLName, dLDate, dHType) {
        Swal.fire({
            allowOutsideClick: false,
            confirmButtonText: 'Confirm Deny',
            showCancelButton: true,
            cancelButtonText: 'Close',
            showCloseButton: true,
            html: `<div class="banner-blue pl-2 p-1 text-md text-left mb-2">
                        Confirmation to Deny Leave
                    </div>
                    <div class="inset-shadow p-1">
                        <div class="text-left text-sm">${dLName}</div>
                        <div class="text-left text-sm">${dLDate}</div>
                        <div class="text-left text-sm">${dHType}</div>
                    </div>
                    <div class="text-left text-sm fw-bold py-1"><em>Reason for denying leave:</em></div>
                    <textarea id="confirmDenyLeave" name="confirmDenyLeave"
                    class="border-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-sm block w-full"
                    placeholder="Kindly specify your reason here.."></textarea>`,
            preConfirm: () => {
                let reason = $('#confirmDenyLeave').val();
                if (!reason) {
                    Swal.showValidationMessage('Please enter your reason for denying leave');
                    Swal.getPopup().querySelector('#confirmDenyLeave').focus();
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                handleRevokeConfirmation(lID, result.value,"Denied");
            }
        });
    }

    function cancelLeave(lID, lType, lOthers, dLName, dLDate, dHType) {
        Swal.fire({
            allowOutsideClick: false,
            confirmButtonText: 'Confirm Cancel',
            showCancelButton: true,
            cancelButtonText: 'Close',
            showCloseButton: true,
            html: `<div class="banner-blue pl-2 p-1 text-md text-left mb-2">
                        Confirmation to Cancel Leave
                    </div>
                    <div class="inset-shadow p-1">
                        <div class="text-left text-sm">${dLName}</div>
                        <div class="text-left text-sm">${dLDate}</div>
                        <div class="text-left text-sm">${dHType}</div>
                    </div>
                    <div class="text-left text-sm fw-bold py-1"><em>Reason for cancellation of leave:</em></div>
                    <textarea id="confirmCancelLeave" name="confirmCancelLeave"
                    class="border-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-sm block w-full"
                    placeholder="Kindly specify your reason here.."></textarea>`,
            preConfirm: () => {
                let reason = $('#confirmCancelLeave').val();
                if (!reason) {
                    Swal.showValidationMessage('Please enter your reason for cancellation of leave');
                    Swal.getPopup().querySelector('#confirmCancelLeave').focus();
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a function to handle the cancellation of the leave
                handleRevokeConfirmation(lID, result.value,"Cancelled");
            }
        });
    }

    function handleRevokeConfirmation(lID, lReason, lAction) {
        // Swal.fire({ html: lAction }); return false;
        const url = window.location.origin+"/e-forms/revoke-leave";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: { lID: lID, lReason: lReason, lAction: lAction },
            beforeSend: function() {
                $('#dataProcess').css({
                    'display'   : 'flex',
                    'position'  : 'fixed',
                    'top'       : '50%',
                    'left'      : '50%',
                    'transform' : 'translate(-50%, -50%)'
                });

            },
            success: function(data) {
                $('#dataProcess').hide();
                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        Livewire.emit('refreshComponent');
                        if (lAction=='Denied') {
                            $.ajax({
                                url     : `${window.location.origin}/e-forms/notify-leave-action`,
                                method  : 'POST',
                                data    : {
                                    'lID'       : lID,
                                    'dMail'     : data.dataLeave,
                                    'dAction'   : lAction,
                                },
                                success : function(dataMail) {
                                    // Swal.fire({ html: dataMail }); return false
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: data.message,
                        icon: 'error',
                    });
                }
            }
        });
    }

});
