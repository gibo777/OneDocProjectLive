<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-guest-layout>

	<div class="max-w-6xl mx-auto mt-4">
		<div class="banner-blue pl-2 p-1 text-md text-center">
		    <em>Leave Control Number:</em>&nbsp;<strong>{{ $dLeave->control_number }}</strong>
		</div>
	    <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
	    	@if ($dLeave=='')
		        <div class="row border-1 px-2">
		        	<div class="text-center">No record found!</div>
		        </div>
	    	@else
		        <div class="row border-1 px-2">
		            <div class="col-md-3 px-1 mt-1 text-wrap">
		                <x-jet-label id="dLName" class="text-secondary" for="name">
		                    {!! __('<i class="text-sm">Name:</i>&nbsp;<strong>:name</strong>', ['name' => $dLeave->name]) !!}
		                </x-jet-label>
		            </div>
		            <div class="col-md-3 px-1 mt-1">
		                <x-jet-label class="text-secondary" for="employee_number">
		                    {!! __('<i class="text-sm">Employee ID:</i>&nbsp;<strong>:employee_number</strong>', ['employee_number' => $dLeave->employee_id ]) !!}
		                </x-jet-label>
		            </div>
		            <div class="col-md-3 p-1 text-wrap">
		                <x-jet-label class="text-secondary" for="office">
		                    {!! __('<i class="text-sm">Office:</i>&nbsp;<strong>:office</strong>', ['office' => strtoupper($dLeave->office) ]) !!}
		                </x-jet-label>
		            </div>
		            <div class="col-md-3 p-1 text-wrap">
		                <x-jet-label class="text-secondary" for="department">
		                    {!! __('<i class="text-sm">Department:</i>&nbsp;<strong>:department</strong>', ['department' => strtoupper($dLeave->department) ]) !!}
		                </x-jet-label>
		            </div>
		        </div>

		        <div class="row border-1 px-2">
		            <div class="col-md-3 p-1">
		                @if ($action=='approve')
		                	@if ($dLeave->leave_status=='Pending')
			                    <div class="form-floating">
			                        <select name="dLtype" id="dLtype" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" placeholder="LEAVE TYPE">
			                            @foreach ($leaveTypes as $leave_type)
			                                <option value="{{ $leave_type->leave_type }}" @if ($dLeave->leave_type == $leave_type->leave_type) selected @endif>{{ $leave_type->leave_type_name }}</option>
			                            @endforeach
			                        </select>
			                        <x-jet-label class="text-secondary" for="name" value="{{ __('Leave Type') }}" />
			                    </div>
			                    <div id="divLOthers" name="divLOthers" @if ($dLeave->leave_type != 'Others') hidden @endif>
			                        <x-jet-input id="dLOthers" name="dLOthers" class="w-full" type="text" placeholder="Specify leave here..." value="{{ $dLeave->others }}" autocomplete="off"/>
			                    </div>
		                    @else
			                    <x-jet-label class="text-secondary text-wrap" for="leaveType">
			                        {!! __('<i class="text-sm">Leave Type:</i>&nbsp;<strong>:leave_type</strong>', ['leave_type' => strtoupper($dLeave->leave_type_name) ]) !!}
			                    </x-jet-label>
			                    @if ($dLeave->leave_type=='Others')
			                        <x-jet-label class="text-secondary text-wrap" for="leaveOthers">
			                            {!! __('&nbsp;<strong>:others</strong>', ['others' => $dLeave->others ]) !!}
			                        </x-jet-label>
			                    @endif
		                    @endif
		                @else
		                    <x-jet-label class="text-secondary text-wrap" for="leaveType">
		                        {!! __('<i class="text-sm">Leave Type:</i>&nbsp;<strong>:leave_type</strong>', ['leave_type' => strtoupper($dLeave->leave_type_name) ]) !!}
		                    </x-jet-label>
		                    @if ($dLeave->leave_type=='Others')
		                        <x-jet-label class="text-secondary text-wrap" for="leaveOthers">
		                            {!! __('&nbsp;<strong>:others</strong>', ['others' => $dLeave->others ]) !!}
		                        </x-jet-label>
		                    @endif
		                @endif
		            </div>

		            <div class="col-md-4 p-1">
		                <x-jet-label id="dLDate" class="text-secondary text-wrap" for="no_of_days">
		                    {!! __('<i class="text-sm">Date:</i>&nbsp;<strong>:date_covered</strong>', ['date_covered' => '('.
		                        join('<b class="px-1">-</b>',  [ 
		                            date('D, m/d/Y', strtotime($dLeave->date_from)),
		                            date('D, m/d/Y', strtotime($dLeave->date_to))
		                            ]).')' ]) !!}
		                </x-jet-label>
		            </div>
		            <div class="col-md-2 p-1">
		                <x-jet-label class="text-secondary" for="no_of_days">
		                    {!! __('<i class="text-sm">Number of Day/s:</i>&nbsp;<strong>:no_of_days</strong>', ['no_of_days' => strtoupper($dLeave->no_of_days) ]) !!}
		                </x-jet-label>
		            </div>
		            <div class="col-md-2 p-1">
		                <x-jet-label class="text-secondary" for="date_applied">
		                    {!! __('<i class="text-sm">Date Applied:</i><br><strong>:date_applied</strong>', ['date_applied' => date('m/d/Y g:i A',strtotime($dLeave->date_applied))]) !!}
		                </x-jet-label>
		            </div>
		        </div>

		        <div class="row mt-2">
		            <!-- Notification of Leave -->
		            <div class="col-md-8 text-center">
		                <div class="row">
		                    <div class="col-md-6 p-1 text-left rounded border-1 px-2">
		                        <x-jet-label class="text-secondary text-wrap" for="reason">
		                            {!! __('<i class="text-sm">Reason:</i><br><strong>:reason</strong>', ['reason' => $dLeave->reason]) !!}
		                        </x-jet-label>
		                    </div>
		                    <div class="form-floating col-md-6 px-2">
		                        <table class="table table-bordered data-table mx-auto text-sm">
		                            <thead>
		                                <tr class="text-center">
		                                    <th colspan="5" class="py-1">Leaves Consumed</th>
		                                </tr>
		                                <tr class="text-center bg-faded">
		                                    <th class="py-1">VL</th>
		                                    <th class="py-1">SL</th>
		                                    <th class="py-1">EL</th>
		                                    <th class="py-1">ML/PL</th>
		                                    <th class="py-1">Other</th>
		                                </tr>
		                            </thead>
		                            <tbody id="viewLeaveCredits">
		                                <tr class="text-center bg-faded">
		                                    <td>{{ $leaveCredits->VL }}</td>
		                                    <td>{{ $leaveCredits->SL }}</td>
		                                    <td>{{ $leaveCredits->EL }}</td>
		                                    <td>{{ ($dLeave->gender=='M') ? $leaveCredits->PL : $leaveCredits->ML }}</td>
		                                    <td>{{ $leaveCredits->OTS }}</td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		            </div>

		            <div class="col-md-4 px-0">
		                <div class="col-span-5 sm:col-span-1 sm:justify-start">
		                    <table class="table table-bordered mx-auto text-sm">
		                        <tr>
		                            <td><em>Status</em></td>
		                            <th class="{{ $dLeave->leave_status!='Pending' ? 'font-weight-bold '.(($dLeave->leave_status == 'Cancelled' || $dLeave->leave_status == 'Denied') ? 'red-color' : 'green-color') : '' }}">
		                                {{ $dLeave->leave_status }}
		                            </th>
		                        </tr>
		                        <tr>
		                            <td><em>As of:</em></td>
		                            <th>{{ \Carbon\Carbon::now()->format('m/d/Y') }}</th>
		                        </tr>
		                    </table>
		                </div>
		            </div>
		        </div>
		        @if ($dLeave->leave_status=='Pending')
		        <div class="row">
		            <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
		                <x-jet-button id="leaveAction" name="leaveAction">
		                    @if ($action=='approve') {{ __('Approve Leave') }} 
		                    @else {{ __('Deny Leave') }}
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
	const lId = hashId[1];
	const lHash = hashId[0];

	$(document).on('change', '#dLtype', async function() {
		if ($(this).val()=='Others') {
			$('#divLOthers').prop('hidden',false);
		} else {
			$('#dLOthers').val(null);
			$('#divLOthers').prop('hidden',true);
		}
	});

    async function linkApproveLeave(lId, lHash, dLName, dLDate) {
		let lType = $('#dLtype').val();
		let lOthers = $('#dLOthers').val();


        let dataObject = {
            'lId': lId,
            'lHash': lHash,
            'lType': lType,
            'lOthers': lOthers
        };
        
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
            url: `${window.location.origin}/leave-link/head-approve`,
            method: 'POST',
            data: { 'lData': dataObject },
            success: function(data) {
            	$('#dataProcess').hide();
                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        location.reload();
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

    async function linkDenyLeave(lId, lHash, lType, lOthers, dLName, dLDate) {
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
                        <div class="text-left text-sm">Name:&nbsp;<strong>${dLName}</strong></div>
                        <div class="text-left text-sm">Date:&nbsp;<strong>${dLDate}</strong></div>
                        <div class="text-left text-sm">Type:&nbsp;<strong>${lType}</strong></div>
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
                handleRevokeConfirmation(lId, lHash, result.value,"Denied");
            }
        });
    }


    function handleRevokeConfirmation(lId, lHash, lReason, lAction) {
        const url = window.location.origin+"/leave-link/head-deny";

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
                lId: lId,
                lHash: lHash,
                lReason: lReason,
                lAction: lAction
            },
            success: function(data) {
            	$('#dataProcess').hide();
                if (data.isSuccess) {
                    Swal.fire({
                        title: data.message,
                        icon: 'success',
                    }).then(() => {
                        location.reload();
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

    // Function to perform the original action (approve or deny leave)
    function performAction(action) {
        Swal.fire('Action Performed', `Leave has been ${action}`, 'success');
    }

    // Event listener for the leaveAction button
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('#leaveAction').addEventListener('click', function() {
            const action = `{{ $action }}`;
            const lType = `{{ strtoupper($dLeave->leave_type_name) }}`;
            const lOthers = `{{ $dLeave->others }}`;
            const dLName = `{{ $dLeave->name }}`;
            const dLDate = `{{ join(' - ',  [ date('D, m/d/Y', strtotime($dLeave->date_from)), date('D, m/d/Y',  strtotime($dLeave->date_to)) ]) }}`;

            if (action=='approve') {
            	linkApproveLeave(lId, lHash, dLName, dLDate);
            } else {
            	linkDenyLeave(lId, lHash, lType, lOthers, dLName, dLDate);
            }
        });
    });
</script>

