<!DOCTYPE html>
<html>

<head>
    <title>Overtime Request Submitted</title>
</head>

<body>

    <p>
        <em>Name:</em>&nbsp;<strong>{{ $newOT->name }}</strong>
        <br><em>Reason:</em>&nbsp;<strong>{{ $newOT->ot_reason }}</strong>
        <br><em>OT Request #:</em>&nbsp;<strong>{{ $newOT->ot_control_number }}</strong>
        <br><em>OT Schedule:</em>&nbsp;<strong>
            {{ \Carbon\Carbon::parse($newOT->ot_date_from)->format('D, m/d/Y') }}
            {{ \Carbon\Carbon::parse($newOT->ot_time_from)->format('h:i A') }}
            -
            {{ \Carbon\Carbon::parse($newOT->ot_date_to)->format('D, m/d/Y') }}
            {{ \Carbon\Carbon::parse($newOT->ot_time_to)->format('h:i A') }}
        </strong>
        <br><em>Hours:</em>&nbsp;<strong>{{ $newOT->ot_hours }}</strong>
        <br><em>Minutes:</em>&nbsp;<strong>{{ $newOT->ot_minutes }}</strong>
        <br><em>Total Computed Hours:</em>&nbsp;<strong>{{ $newOT->ot_hrmins }}</strong>
    </p>

    <p>
        Please review the submitted overtime request and proceed with the necessary action by selecting one of the
        following links:
    </p>

    <p>
        <a href="{{ $approveUrl }}" style="color: green; text-decoration: none; font-weight: bold;">Approve
            Overtime</a>
        <br>
        <a href="{{ $approveUrl }}">{{ $approveUrl }}</a>
    </p>

    <p>
        <a href="{{ $denyUrl }}" style="color: red; text-decoration: none; font-weight: bold;">Deny Overtime</a>
        <br>
        <a href="{{ $denyUrl }}">{{ $denyUrl }}</a>
    </p>

    <p>If you have any questions or need further information, feel free to contact HR.</p>

    <p>Thank you!</p>

    <p>
    <h4><em>{{ env('COMPANY_NAME') }}</em></h4>
    </p>

</body>

</html>
