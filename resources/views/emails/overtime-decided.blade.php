<!DOCTYPE html>
<html>

<head>
    <title>Overtime Request {{ ucfirst($action) }}</title>
</head>

<body>
    <p><strong><em>Dear
                @if ($dOvertime->sex == 'F')
                    Ma'am
                @elseif ($dOvertime->sex == 'M')
                    Sir
                @else
                    Sir/Ma'am
                @endif
                {{ $dOvertime->name }}
            </em></strong>,</p>

    <p>{{ $action == 'denied' ? 'We regret to inform you that your' : 'Your' }} overtime request has been
        {{ $action }} by your supervisor. Here are the details of the request:
    </p>

    <p>
        <em>Name:</em>&nbsp;<strong>{{ $dOvertime->name }}</strong>
        <br><em>Reason:</em>&nbsp;<strong>{{ $dOvertime->ot_reason }}</strong>
        <br><em>OT Request #:</em>&nbsp;<strong>{{ $dOvertime->ot_control_number }}</strong>
        <br><em>OT Schedule:</em>&nbsp;<strong>
            {{ \Carbon\Carbon::parse($dOvertime->ot_date_from)->format('D, m/d/Y') }}
            {{ \Carbon\Carbon::parse($dOvertime->ot_time_from)->format('h:i A') }}
            -
            {{ \Carbon\Carbon::parse($dOvertime->ot_date_to)->format('D, m/d/Y') }}
            {{ \Carbon\Carbon::parse($dOvertime->ot_time_to)->format('h:i A') }}
        </strong>
        <br><em>Hours:</em>&nbsp;<strong>{{ $dOvertime->ot_hours }}</strong>
        <br><em>Minutes:</em>&nbsp;<strong>{{ $dOvertime->ot_minutes }}</strong>
        <br><em>Total Computed Hours:</em>&nbsp;<strong>{{ $dOvertime->ot_hrmins }}</strong>
        <br><em>OT Status:</em>&nbsp;<strong>{{ $dOvertime->ot_status }}</strong>
    </p>

    {{-- <ul>
        <li><em>Reason / Comment:</em>&nbsp;<p><strong>{{ $dOvertime->action_reason }}</strong></p>
        </li>
    </ul> --}}

    <p>If you have any questions or need further information, feel free to contact HR.</p>
    <p>Thank you!</p>
    <p>
    <h4><em>{{ env('COMPANY_NAME') }}</em></h4>
    </p>
</body>

</html>
