$(document).ready(function () {

    let parentSwalOpen = false;
    let modalWidth = $(window).width() <= 768 ? '100%' : '50%';

    function formatDateTime(dateStr) {
        const options = {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        return new Date(dateStr).toLocaleString('en-US', options);
    }



    /* Reroute to Leave Form */
    $(document).on('click', '#createNewLeave', function () {
        window.location.href = lReq;
    });

    /* Viewing Overtime Details per Control Number - Gibs */
    $(document).on('dblclick', '.view-overtime', function () {
        let otID = this.id;
        viewOvertime(otID);

    });

    $(document).on('click', '.view_ot_status', function (e) {
        // Swal.fire({ html: `${$(this).attr('data-record-id')}<br>${window.location.origin}/hris/view-history` }); return false;
        try {
            e.preventDefault();
            let modalWidth = $(window).width() <= 768 ? '100%' : '60%';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `${window.location.origin}/hris/view-othistory`,
                method: 'GET',
                data: { 'otRefID': $(this).attr('data-record-id') },
                success: function (data) {
                    let dLHistory = `<table class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                        <thead class="bg-gray-500 text-white">
                            <tr class="dt-head-center">
                                <th class="py-1">Status</th>
                                <th class="py-1">Action By</th>
                                <th class="py-1">Reason</th>
                                <th class="py-1">Date</th>
                            </tr>
                        </thead>`;

                    data.forEach(item => {
                        // const approvedBy = item['is_head2_approved'] == 1 ? item['head2_approved_by'] : item['head_approved_by'];
                        const actionBy = item['action_by'];

                        dLHistory += `<tr>
                                        <td class="py-1">${item['action']}</td>
                                        <td class="py-1">${actionBy}</td>
                                        <td class="py-1">${item['action_reason']}</td>
                                        <td class="py-1">${item['action_date']}</td>
                                    </tr>`;
                    });

                    dLHistory += `</table>`;

                    Swal.fire({
                        width: modalWidth,
                        showClass: { popup: '' },
                        // hideClass: { popup: '' },
                        showCloseButton: true,
                        showConfirmButton: false,
                        // confirmButtonText: "Close",
                        html: `<div class="banner-blue pl-2 p-1 text-md text-left">
                                    Overtime Status (<strong>${data[0]['ot_control_number']}</strong>)
                                </div>
                                <div class="row text-sm w-full text-left my-2">
                                    <div class="col-md-6"><em>Name:</em> <strong>${data[0]['name']}</strong></div>
                                    <div class="col-md-6"><em>Approver/s:</em> <strong>${data[0]['head_name']}</strong></div>
                                </div>
                                ${dLHistory}`
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching leave history:', error);
                }
            });
        } catch (error) {
            console.log('Error:', error);
        }
    });

    function viewOvertime(otID) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/e-forms/overtime-detailed',
            method: 'get',
            data: { 'id': otID },
            success: function (data) {
                Swal.fire({
                    html: data.html,
                    showCloseButton: true,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    width: modalWidth,
                    showClass: { popup: '' },
                    didOpen: () => {
                        $(document).on('click', '#otApproveRequest', async function () {
                            approveOTRequest($(this).val(), $(this).text());
                        });
                        $(document).on('click', '#otDenyRequest,#otCancelRequest', async function () {
                            // Swal.fire({ html: $(this).text() }); return false;
                            revokeOTRequest(otID, $(this).text(), data.otDtls);
                        });
                    }
                });

            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        }); return false;
    }

    /* $(document).on('click', '#leave_form', function () {
        let leave_id = $('#hid_leave_id').val();
        window.location.href = `/hris/view-leave/form-leave/${leave_id}`;
    }); */

    $("#date_from").change(function () {
        $("#number_of_days").html('');
        let dateFrom = $(this).val();
        $("#date_to").val(dateFrom || $("#date_to").val());
    });



    function revokeOTRequest(otID, otAction, otData) {
        const ot = otData;
        const actionWord = (otAction || '').trim().split(' ')[0].toLowerCase().replace(/^\w/, c => c.toUpperCase());
        const rAction = actionWord == 'Cancel' ? 'Cancelling' : 'Denying';

        Swal.fire({
            allowOutsideClick: false,
            confirmButtonText: 'Confirm ' + actionWord,
            showCancelButton: true,
            cancelButtonText: 'Close',
            showCloseButton: true,
            showClass: { popup: '' },
            html: `<div class="banner-blue pl-2 p-1 text-md text-left mb-2">
                        Confirmation to ${actionWord} (${ot.ot_control_number})
                    </div>
                    <div class="inset-shadow p-1 text-left text-sm">
                        <div>Name: <b>${ot.name}</b></div>
                        <div>Supervisor: <b>${ot.supervisor}</b></div>
                        <div>O.T. Schedule: <b>${ot.begin_date} - ${ot.end_date}</b></div>
                        <div>Total Hours: <b>${ot.total_hours}</b></div>
                        <div>O.T. Reason: <b>${ot.ot_reason}</b></div>
                    </div>
                    <div class="text-left text-sm fw-bold py-1"><em>Reason for ${rAction}:</em></div>
                    <textarea id="confirmDenyLeave" name="confirmDenyLeave"
                    class="border-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-sm block w-full"
                    placeholder="Kindly specify your reason here.."></textarea>`,
            preConfirm: () => {
                let reason = $('#confirmDenyLeave').val();
                if (!reason) {
                    Swal.showVaotIDationMessage('Please enter your reason for denying leave');
                    Swal.getPopup().querySelector('#confirmDenyLeave').focus();
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                handleRevokeConfirmation(otID, result.value, otAction.trim().split(/\s+/)[0].toLowerCase());
            } else {
                viewOvertime(otID);
            }
        });
    }

    function approveOTRequest(otID, btnAction) {
        let otAction = btnAction.trim().split(/\s+/)[0].toLowerCase();
        let otURL = window.location.origin;
        let otData = {
            'otID': otID,
        };

        switch (otAction) {
            case 'approve':
                otURL = otURL + "/hris/approve-overtime";
                break;
            case 'deny':
                otURL = otURL + "/hris/deny-overtime";
                break;
            case 'cancel':
                otURL = otURL + "/hris/cancel-overtime";
                break;

            default:
                break;
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: otURL,
            method: 'post',
            data: otData, // prefer use serialize method
            beforeSend: function () {
                $('#dataProcess').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });
            },
            success: function (data) {
                $('#dataProcess').hide();
                // Swal.fire({ html: JSON.stringify(data) }); return false;
                const { isSuccess, message } = data;
                isSuccess ?
                    (Livewire.emit('refreshComponent'),
                        Swal.fire({
                            icon: 'success',
                            title: message,
                        }))
                    :
                    Swal.fire({
                        icon: 'error',
                        // title: JSON.stringify(message),
                        title: 'Failed!',
                    });
                // email notification here...
            }
        });
    }

    /* function denyOTRequest(otID, lType, lOthers, dLName, dLDate, dHType) {
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
                    Swal.showVaotIDationMessage('Please enter your reason for denying leave');
                    Swal.getPopup().querySelector('#confirmDenyLeave').focus();
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                handleRevokeConfirmation(otID, result.value, "Denied");
            }
        });
    } */

    /* function cancelLeave(otID, lType, lOthers, dLName, dLDate, dHType) {
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
                    Swal.showVaotIDationMessage('Please enter your reason for cancellation of leave');
                    Swal.getPopup().querySelector('#confirmCancelLeave').focus();
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a function to handle the cancellation of the leave
                handleRevokeConfirmation(otID, result.value, "Cancelled");
            }
        });
    } */

    function handleRevokeConfirmation(otID, otReason, otAction) {
        // Swal.fire({ html: otID + ' | ' + otReason + ' | ' + otAction }); return false;
        let url = window.location.origin + (otAction === 'deny' ? '/hris/deny-overtime' : '/hris/cancel-overtime');

        // Swal.fire({ html: url }); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: { otID: otID, otReason: otReason, otAction: otAction },
            beforeSend: function () {
                $('#dataProcess').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

            },
            success: function (data) {

                $('#dataProcess').hide();
                // Swal.fire({ html: JSON.stringify(data) }); return false;
                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        Livewire.emit('refreshComponent');

                        // if (otAction=='Denied') {
                        // $.ajax({
                        //     url: `${window.location.origin}/e-forms/notify-overtime-action`,
                        //     method: 'POST',
                        //     data: {
                        //         'otID': otID,
                        //         'dMail': data.dataLeave,
                        //         'dAction': otAction,
                        //     },
                        //     success: function (dataMail) {
                        //         // Swal.fire({ html: dataMail }); return false
                        //     }
                        // });

                        // if (otAction == 'Cancelled') {
                        //     // Send (API payload) to HRIS using $.ajax / JSON
                        //     $.ajaxSetup({
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //     });
                        //     $.ajax({
                        //         url: `${window.location.origin}/send-leave-to-hris`,
                        //         method: 'POST',
                        //         data: {
                        //             'otID': otID,
                        //         },
                        //         success: function (apiResponse) {
                        //             console.log('API response:', JSON.stringify(apiResponse));
                        //         },
                        //         error: function (xhr) {
                        //             console.error('API error:', xhr.responseText);
                        //         }
                        //     });
                        // }
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

    /* EXPORT TO EXCEL TIMELOGS */
    $(document).on('click', '#exportExcelLeaves', async function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/leaves-excel',
            method: 'GET',
            data: { 'id': $(this).attr('id') },
            success: function (html) {
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
            error: function (xhr, status, error) {
                console.error('Error exporting to Excel:', error);
            }
        });

        return false;
    });

});
