<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-guest-layout>

    <div class="max-w-5xl mx-auto mt-4">
        <div class="banner-blue pl-2 p-1 text-md text-center">
            <em>Overtime Control Number:</em>&nbsp;<strong
                id="otLinkControlNumber">{{ $otData->ot_control_number }}</strong>
        </div>
        <div
            class="px-4 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            @if ($otData == '')
                <div class="row border-1 px-2">
                    <div class="text-center">No record found!</div>
                </div>
            @else
                <!-- <div class="table-responsive">
                    <table id="otSummary"
                        class="table table-auto table-hover table-striped table-bordered text-center text-md">
                        <thead class="thead">
                            <tr class="text-center">
                                <th>Overtime Request Summary</th>
                            </tr>
                        </thead>
                        <tbody class="data" id="data">
                            <tr>
                                <td class="text-left">
                                    <h6>Name : {{-- {{ $otData->otName ?? '' }} --}}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <h6>OT Location : {{-- {{ $otData->otLoc ?? '' }} --}}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <h6>OT Begin Date : {{-- {{ \Carbon\Carbon::parse($otData->otDtFr)->format('M d, Y') }}
                                    {{ \Carbon\Carbon::parse($otData->otTFr)->format('h:i A') }} --}}</h6>
                                    <h6>OT End Date : {{-- {{ \Carbon\Carbon::parse($otData->otDtTo)->format('M d, Y') }}
                                    {{ \Carbon\Carbon::parse($otData->otTTo)->format('h:i A') }} --}}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <h6>Reason : {{-- {{ $otData->otReason ?? '' }} --}}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <h6>Hour/s : {{-- {{ $hours ?? 0 }} --}}</h6>
                                    <h6>Minute/s : {{-- {{ $minutes ?? 0 }} --}}</h6>
                                    <h6>Total Hours : {{-- {{ number_format($totalHours ?? 0, 2) }} --}}</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->

                <div class="row border-1 px-2">
                    <div class="col-md-5 pt-1 text-wrap">
                        <x-jet-label id="dOTName" class="text-secondary" for="name">
                            {!! __('<i class="text-sm">Name:</i>&nbsp;<strong id="otLinkName">:name</strong>', ['name' => $otData->name]) !!}
                        </x-jet-label>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label class="text-secondary" for="employee_number">
                            {!! __('<i class="text-sm">Employee ID:</i>&nbsp;<strong id="otLinkEmployeeID">:employee_number</strong>', [
                                'employee_number' => $otData->employee_id,
                            ]) !!}
                        </x-jet-label>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label class="text-secondary" for="date_applied">
                            {!! __('<i class="text-sm">Date Applied:</i>&nbsp;<strong>:date_applied</strong>', [
                                'date_applied' => date('D, m/d/Y g:i A', strtotime($otData->date_applied)),
                            ]) !!}
                        </x-jet-label>
                    </div>
                </div>


                <div class="row border-1 px-2">
                    <div class="col-md-4 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="office">
                            {!! __('<i class="text-sm">Office:</i>&nbsp;<strong>:office</strong>', [
                                'office' => strtoupper($otData->office),
                            ]) !!}
                        </x-jet-label>
                    </div>
                    <div class="col-md-4 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="department">
                            {!! __('<i class="text-sm">Department:</i>&nbsp;<strong>:department</strong>', [
                                'department' => strtoupper($otData->department),
                            ]) !!}
                        </x-jet-label>
                    </div>
                    <div class="col-md-4 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="supervisor">
                            {!! __('<i class="text-sm">Supervisor:</i>&nbsp;<strong id="otLinkSupervisor">:supervisor</strong>', [
                                'supervisor' => strtoupper($otData->supervisor),
                            ]) !!}
                        </x-jet-label>
                    </div>
                </div>


                <div class="row border-1 px-2">
                    <div class="col-md-5 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="ot_location">
                            {!! __('<i class="text-sm">OT Location:</i>&nbsp;<strong>:ot_location</strong>', [
                                'ot_location' => strtoupper($otData->ot_location),
                            ]) !!}
                        </x-jet-label>
                    </div>

                    <div class="col-md-7 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="ot_date_covered">
                            {!! __('<i class="text-sm">OT Date Covered:</i><br><strong id="otLinkDateCovered">:ot_date_covered</strong>', [
                                'ot_date_covered' =>
                                    date('D, m/d/Y g:i A', strtotime($otData->ot_date_from . ' ' . $otData->ot_time_from)) .
                                    ' - ' .
                                    date('D, m/d/Y g:i A', strtotime($otData->ot_date_to . ' ' . $otData->ot_time_to)),
                            ]) !!}
                        </x-jet-label>
                    </div>
                </div>


                <div class="row border-1 px-2">
                    <div class="col-md-5 pt-1 text-wrap">
                        <x-jet-label class="text-secondary" for="ot_reason">
                            {!! __('<i class="text-sm">OT Reason:</i>&nbsp;<p><strong id="otLinkReason">:ot_reason</strong></p>', [
                                'ot_reason' => nl2br(e(strtoupper($otData->ot_reason))),
                            ]) !!}
                        </x-jet-label>
                    </div>

                    <div class="col-md-7 pt-1 text-wrap">
                        <table class="table table-bordered mx-auto text-center">
                            <tr class="text-md">
                                <th class="text-capitalize" style="width:20%;">Hours</th>
                                <th class="text-capitalize" style="width:20%;">Minutes</th>
                                <th class="text-capitalize" style="width:30%;">Total Hours</th>
                                <th class="text-capitalize">Status</th>
                            </tr>

                            <tr>
                                <td id="otLinkHours"> {{ $otData->ot_hours }} </td>
                                <td id="otLinkMinutes"> {{ $otData->ot_minutes }} </td>
                                <td id="otLinkTotalHours"> {{ $otData->ot_hrmins }}</td>
                                <td id="otLinkStatus"> {{ $otData->ot_status }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                @if (strtolower($otData->ot_status) == 'pending')
                    <div class="row">
                        <div
                            class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                            <x-jet-button id="otAction" name="otAction">
                                @if ($action == 'approve')
                                    {{ __('Approve Overtime') }}
                                @else
                                    {{ __('Deny Overtime') }}
                                @endif
                            </x-jet-button>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

</x-guest-layout>

<script type="text/javascript">
    const hashId = `{{ $hashId }}`.split('-');
    const otID = hashId[2];
    const otHash = hashId.slice(0, 2).join('-');


    async function linkApproveOvertime(otID, otHash, dataObject) {
        Swal.fire({
            allowOutsideClick: false,
            confirmButtonText: 'Confirm Approval',
            showCancelButton: true,
            cancelButtonText: 'Close',
            showCloseButton: true,
            showClass: {
                popup: ''
            },
            html: `<div class="banner-blue pl-2 p-1 text-md text-left mb-2">
                    Approval (${$('#otLinkControlNumber').text()})
                </div>
                <div class="inset-shadow p-1 text-left text-sm">
                    <div>Name: <b>${$('#otLinkName').text()}</b></div>
                    <div>O.T. Schedule: <br><b>${$('#otLinkDateCovered').text()}</b></div>
                    <div>Total Hours: <b>${$('#otLinkTotalHours').text()}</b></div>
                    <div>O.T. Reason: <b>${$('#otLinkReason').text()}</b></div>
                </div>
                <div class="text-left text-sm fw-bold py-1"><em>Approval Comment:</em></div>
                <textarea id="otComment" name="otComment"
                class="border-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-sm block w-full"
                placeholder="Kindly specify your comment here.."></textarea>`,
            preConfirm: () => {
                let comment = $('#otComment').val();
                if (!comment) {
                    Swal.showValidationMessage('Please enter your comment for approval');
                    Swal.getPopup().querySelector('#otComment').focus();
                }
                return comment;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `${window.location.origin}/overtime-link/head-approve`;

                $('#dataProcess').css({
                    'display': 'flex',
                    'position': 'absolute',
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        'otID': otID,
                        'otHash': otHash,
                        'otComment': result.value
                    },
                    beforeSend: function() {
                        $('#dataProcess').css({
                            'display': 'flex',
                            'position': 'fixed',
                            'top': '50%',
                            'left': '50%',
                            'transform': 'translate(-50%, -50%)'
                        });
                    },
                    success: function(data) {
                        $('#dataProcess').hide();

                        if (data.isSuccess) {
                            Swal.fire({
                                title: data.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });

                            $.ajaxSetup({
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            });

                            // Send (API payload) to HRIS using $.ajax / JSON
                            $.ajax({
                                url: `${window.location.origin}/send-overtime-to-hris`,
                                method: 'POST',
                                data: {
                                    'otID': otID,
                                },
                                success: function(apiResponse) {
                                    console.log('API response:', JSON.stringify(
                                        apiResponse));

                                },
                                error: function(xhr) {
                                    console.error('API error:', xhr.responseText);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: data.message,
                                icon: 'error'
                            });
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#dataProcess').hide();
                        console.error('Error approving overtime:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong while approving overtime.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }


    async function linkDenyLeave(otID, otHash, otAction) {
        const actionWord = otAction.toLowerCase().replace(/^\w/, c => c.toUpperCase());
        const rAction = actionWord == 'Cancel' ? 'Cancelling' : 'Denying';

        Swal.fire({
            allowOutsideClick: false,
            confirmButtonText: 'Confirm ' + actionWord,
            showCancelButton: true,
            cancelButtonText: 'Close',
            showCloseButton: true,
            showClass: {
                popup: ''
            },
            html: `<div class="banner-blue pl-2 p-1 text-md text-left mb-2">
                        Confirmation to ${actionWord} (${$('#otLinkControlNumber').text()})
                    </div>
                    <div class="inset-shadow p-1 text-left text-sm">
                        <div>Name: <b> ${ $('#otLinkName').text() } </b></div>
                        <div>O.T. Schedule: <br><b> ${$('#otLinkDateCovered').text() } </b></div>
                        <div>Total Hours: <b> ${$('#otLinkTotalHours').text() } </b></div>
                        <div>O.T. Reason: <b> ${$('#otLinkReason').text() } </b></div>
                    </div>
                    <div class="text-left text-sm fw-bold py-1"><em>Reason for ${rAction}:</em></div>
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
                handleRevokeConfirmation(otID, otHash, result.value, "Denied");
            }
        });

    }


    function handleRevokeConfirmation(otID, otHash, otReason, otAction) {
        const url = window.location.origin + "/overtime-link/head-deny";

        $('#dataProcess').css({
            'display': 'flex',
            'position': 'absolute',
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                otID: otID,
                otHash: otHash,
                otReason: otReason,
                otAction: otAction
            },
            beforeSend: function() {
                $('#dataProcess').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

            },
            success: function(data) {
                $('#dataProcess').hide();

                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        // $.ajax({
                        //     url: `${window.location.origin}/e-forms/notify-overtime-action`,
                        //     method: 'POST',
                        //     data: {
                        //         'otID': otID,
                        //         'dMail': data.dataOvertime,
                        //         'dAction': otAction,
                        //     },
                        //     success: function(dataMail) {
                        //         // Swal.fire({ html: dataMail }); return false;
                        //     }
                        // });
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: data.message,
                        icon: 'error',
                    });
                }
            }
        });
    }

    // Function to perform the original action (approve or deny leave)
    function performAction(action) {
        Swal.fire('Action Performed', `Overtime Request has been ${action}`, 'success');
    }

    // Event listener for the otAction button
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('#otAction').addEventListener('click', function() {
            const action = `{{ $action }}`;
            const dOTName = `{{ $otData->name }}`;

            if (action == 'approve') {
                linkApproveOvertime(otID, otHash);
            } else {
                linkDenyLeave(otID, otHash, action);
            }
        });
    });
</script>
