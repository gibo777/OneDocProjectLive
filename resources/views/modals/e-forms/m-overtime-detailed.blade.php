<div class="banner-blue pl-2 p-1 text-md text-left">
    Control No. <strong>{{ $otDtls->ot_control_number }}</strong>
</div>


<div class="modal-body text-left">
    <div class="row border-1 px-2">
        <div class="col-md-5 px-1 mt-1 text-wrap">
            <x-jet-label id="name" class="text-secondary" for="name">
                {!! __('<i class="text-sm">Name:</i>&nbsp;<strong>:name</strong>', ['name' => $otDtls->name]) !!}
            </x-jet-label>
        </div>
        <div class="col-md-4 px-1 mt-1 text-wrap">
            <x-jet-label class="text-secondary" for="employeeNumber">
                {!! __('<i class="text-sm">Employee ID:</i>&nbsp;<strong>:employeeNumber</strong>', [
                    'employeeNumber' => $otDtls->employee_id,
                ]) !!}
            </x-jet-label>
        </div>
        <div class="col-md-3 p-1 text-wrap">
            <x-jet-label class="text-secondary" for="otDateApplied">
                {!! __('<i class="text-sm">Date Applied:</i><br><strong>:otDateApplied</strong>', [
                    'otDateApplied' => $otDtls->date_applied,
                ]) !!}
            </x-jet-label>
        </div>
    </div>


    <div class="row border-1 px-2">
        <div class="col-md-4 px-1 mt-1 text-wrap">
            <x-jet-label id="otLocation" class="text-secondary" for="otLocation">
                {!! __('<i class="text-sm">O.T. Location:</i>&nbsp;<strong>:otLocation</strong>', [
                    'otLocation' => $otDtls->ot_location,
                ]) !!}
            </x-jet-label>
        </div>
        <div class="col-md-8 px-1 mt-1 text-wrap">
            <x-jet-label class="text-secondary" for="otSchedule">
                {!! __('<i class="text-sm">OT Schedule:</i>&nbsp;<strong>:otSchedule</strong>', [
                    'otSchedule' =>
                        date('D', strtotime($otDtls->ot_date_from)) .
                        ', ' .
                        $otDtls->begin_date .
                        ' - ' .
                        date('D', strtotime($otDtls->ot_date_to)) .
                        ', ' .
                        $otDtls->end_date,
                ]) !!}
            </x-jet-label>
        </div>
    </div>



    <div class="row border-1 px-2">
        <div class="col-md-8 px-1 mt-1 text-wrap">
            <x-jet-label id="otReason" class="text-secondary" for="otReason">
                {!! __('<i class="text-sm">O.T. Reason:</i><br><strong>:otReason</strong>', [
                    'otReason' => nl2br(e($otDtls->ot_reason)),
                ]) !!}
            </x-jet-label>
        </div>

        <div class="col-md-4 px-1 mt-1 border-1">
            <x-jet-label id="otHours" class="text-secondary" for="otHours">
                {!! __('<i class="text-sm">Hours:</i>&nbsp;<strong>:otHours</strong>', [
                    'otHours' => nl2br(e($otDtls->ot_hours)),
                ]) !!}
            </x-jet-label>
            <x-jet-label id="otMinutes" class="text-secondary" for="otMinutes">
                {!! __('<i class="text-sm">Minutes:</i>&nbsp;<strong>:otMinutes</strong>', [
                    'otMinutes' => nl2br(e($otDtls->ot_minutes)),
                ]) !!}
            </x-jet-label>
            <x-jet-label id="otTotalHours" class="text-secondary" for="otTotalHours">
                {!! __('<i class="text-sm">Total Hours:</i>&nbsp;<strong>:otTotalHours</strong>', [
                    'otTotalHours' => nl2br(e($otDtls->total_hours)),
                ]) !!}
            </x-jet-label>
        </div>
    </div>


    <div class="flex items-center justify-center sm:px-2 sm:rounded-bl-md sm:rounded-br-md mt-1">
        <div class="row text-center justify-content-center space-y-2">

            @if ($status === 'pending' && ($isApprover1 || $isApprover2 || $isAdmin))
                @if (($isApprover1 && $otDtls->is_head_approved != 1) || $isAdmin)
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otApproveRequest" value="{{ $otDtls->id }}" class="w-full">Approve
                            O.T.</x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otDenyRequest" value="{{ $otDtls->id }}" class="w-full">Deny
                            O.T.</x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otCancelRequest" value="{{ $otDtls->id }}" class="w-full">Cancel
                            O.T.</x-jet-button>
                    </div>
                @elseif ($isApprover2 && $otDtls->is_head_approved == 1 && $otDtls->is_head2_approved != 1)
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otApproveRequest" value="{{ $otDtls->id }}" class="w-full">Approve
                            O.T.</x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otDenyRequest" value="{{ $otDtls->id }}" class="w-full">Deny
                            O.T.</x-jet-button>
                    </div>
                    <div class="col-md-4 px-1 my-1">
                        <x-jet-button id="otCancelRequest" value="{{ $otDtls->id }}" class="w-full">Cancel
                            O.T.</x-jet-button>
                    </div>
                @else
                    <div class="col-md-12 px-1 my-1">
                        <x-jet-button id="otCancelRequest" value="{{ $otDtls->id }}" class="w-full">Cancel
                            O.T.</x-jet-button>
                    </div>
                @endif
            @elseif ($status === 'head approved' && ($isApprover1 || $isApprover2 || $isOwner || $isAdmin))
                <div class="col-md-12 px-1 my-1">
                    <x-jet-button id="otCancelRequest" value="{{ $otDtls->id }}" class="w-full">Cancel
                        O.T.</x-jet-button>
                </div>
            @endif

        </div>
    </div>

</div>



{{-- <div class="table-responsive">
    <table id="otSummary" class="table table-fixed table-bordered text-center text-md">
        <colgroup>
            <col style="width:25%">
            <col style="width:25%">
            <col style="width:20%">
            <col style="width:30%">
        </colgroup>
        <thead class="thead">
            <tr class='text-center text-md py-2'>
                <th colspan=4>Control No. {{ $otDtls->ot_control_number }}</th>
            </tr>
        </thead>
        <tbody class="text-sm" id="data">
            <tr>
                <td class='text-left' colspan=2>Name : <h6>{{ $otDtls->name }}</h6>
                </td>
                <td class='text-left'>Employee # <h6>{{ $otDtls->employee_id }}</h6>
                </td>
                <td class='text-left'>Date Applied <h6>{{ $otDtls->date_applied }}</h6>
                </td>
            </tr>
            <tr>
                <td class='text-left'>OT Location : <h6>{{ $otDtls->ot_location }}</h6>
                </td>
                <td class='text-left' colspan=3>OT Schedule :
                    <h6>
                        {{ date('D', strtotime($otDtls->ot_date_from)) . ', ' . $otDtls->begin_date }} -
                        {{ date('D', strtotime($otDtls->ot_date_to)) . ', ' . $otDtls->end_date }}
                    </h6>
                    </th>
            </tr>
            <tr>
                <td class='text-left' colspan=4>Reason : <h6>{{ $otDtls->ot_reason }}</h6>
                </td>
            </tr>
            <tr>
                <td class='text-left'>Hour/s : <h6>{{ $otDtls->ot_hours }}</h6>
                </td>
                <td class='text-left'>Minute/s : <h6>{{ $otDtls->ot_minutes }}</h6>
                </td>
                <td colspan=2>Total Hours : <h6>{{ $otDtls->total_hours }}</h6>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
        <div>
            @if ($otDtls->ot_status == 'pending')
                <x-jet-button type="button" id="otApproveRequest" name="otApproveRequest" value="{{ $otDtls->id }}">
                    {{ __('APPROVE OT') }}
                </x-jet-button>
                <x-jet-button type="button" id="otDenyRequest" name="otDenyRequest" value="{{ $otDtls->id }}">
                    {{ __('DENY OT') }}
                </x-jet-button>
            @endif
            <x-jet-button type="button" id="otCancelRequest" name="otCancelRequest" value="{{ $otDtls->id }}">
                {{ __('CANCEL OT') }}
            </x-jet-button>
        </div>
    </div>
</div> --}}
