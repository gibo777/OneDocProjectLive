<div class="table-responsive">
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
</div>
