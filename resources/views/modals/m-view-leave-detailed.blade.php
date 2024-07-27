<style type="text/css">
    .swal2-close {
        background-color: #ff0000 !important;
        color: #ffffff !important;
        font-weight: 500;
        height: 22px !important;
        width: 22px !important;
        margin-right: 3px;
        margin-top: 3px;
        transition: background-color 0.3s ease;
    }
    .swal2-close:hover {
        background-color: #ff5555 !important;
        font-weight: 300;
    }

    .modal-body {
        white-space: nowrap;
    }

    .modal-body ol {
        white-space: normal;
        margin-top: 0;
        padding-left: 20px;
    }
</style>

<div class="banner-blue pl-2 p-1 text-md text-left">
    Control No. <strong>{{ $dLeave->control_number }}</strong>
</div>


      <div class="modal-body text-left">

        <div class="row border-1 px-2">
            <div class="col-md-3 px-1 mt-1 text-wrap">
                <x-jet-label class="text-secondary" for="name">
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
                @if ( (Auth::user()->employee_id==$dLeave->supervisor) && $dLeave->leave_status=='Pending')
                    <div class="form-floating">
                        <select name="dLtype" id="dLtype" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" placeholder="LEAVE TYPE">
                            {{-- <option value="">Select Leave Type</option> --}}
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
                    <x-jet-label class="text-secondary text-wrap" for="leave_type">
                        {!! __('<i class="text-sm">Leave Type:</i>&nbsp;<strong>:leave_type</strong>', ['leave_type' => strtoupper($dLeave->leave_type_name) ]) !!}
                    </x-jet-label>
                    @if ($dLeave->leave_type=='Others')
                        <x-jet-label class="text-secondary text-wrap" for="leave_type">
                            {!! __('&nbsp;<strong>:others</strong>', ['others' => $dLeave->others ]) !!}
                        </x-jet-label>
                    @endif
                @endif
            </div>

            <div class="col-md-4 p-1">
                <x-jet-label class="text-secondary text-wrap" for="no_of_days">
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
            <div class="col-md-9 text-center">
                <div class="row">
                    <div class="col-md-6 p-1 text-left rounded border-1 px-2">
                        <x-jet-label class="text-secondary text-wrap" for="reason">
                            {!! __('<i class="text-sm">Reason:</i><br><strong>:reason</strong>', ['reason' => $dLeave->reason]) !!}
                        </x-jet-label>
                    </div>
                    <div class="form-floating col-md-6 p-1">
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
                <div class="row text-left">
                    <div class="col-md-12 sm:col-span-5 sm:justify-center text-sm">
                        INSTRUCTIONS:
                        <ol>
                            <li>
                                1. Application for leave of absence must be filed at the latest, 
                                three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                                it must be filed immediately upon reporting for work.
                            </li>
                            <li>
                                2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                    <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                        <table class="table table-bordered data-table mx-auto text-sm">
                            <tr>
                                <th>STATUS</th>
                                <td class="{{ $dLeave->leave_status!='Pending' ? 'font-weight-bold '.(($dLeave->leave_status == 'Cancelled' || $dLeave->leave_status == 'Denied') ? 'red-color' : 'green-color') : '' }}">
                                    {{ $dLeave->leave_status }}
                                </td>
                            </tr>
                            <tr class="leave-status-field">
                                <th>Available</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Taken</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <td id="td_balance"></td>
                            </tr>
                            <tr>
                                <th>As of:</th>
                                <td id="td_as_of"></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
            </div>
        </div>


<div class="flex items-center justify-center sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
    <div class="row text-center justify-content-center space-y-2">

                @if (Auth::user()->employee_id == $dLeave->supervisor || Auth::user()->id == 1)
                    @if ($dLeave->leave_status == 'Pending')
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="bApproveLeave" class="w-full">
                            Approve Leave
                        </x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="bDenyLeave" class="w-full">
                            Deny Leave
                        </x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="bCancelLeave" class="w-full">
                            Cancel Leave
                        </x-jet-button>
                    </div>
                    @else
                        @if ($dLeave->leave_status == 'Head Approved' && (Auth::user()->employee_id == $dLeave->supervisor || Auth::user()->employee_id == $dLeave->employee_id || Auth::user()->id == 1))
                            <div class="col-md-12 px-1 my-1">
                                <x-jet-button id="bCancelLeave" class="w-full">
                                    Cancel Leave
                                </x-jet-button>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($dLeave->leave_status == 'Head Approved')
                        <div class="col-md-12 px-1 my-1">
                            <x-jet-button id="bCancelLeave" class="w-full">
                                Cancel Leave
                            </x-jet-button>
                        </div>
                    @endif
                @endif


        </div>
    </div>
</div>


{{-- <script type="text/javascript" src="{{ asset('app-modules/e-forms/view-overtime-detailed.js') }}"></script> --}}