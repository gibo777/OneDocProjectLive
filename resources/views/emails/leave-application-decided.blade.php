<!DOCTYPE html>
<html>
<head>
    <title>Leave Application {{ ucfirst($decide) }}</title>
</head>
<body>
    <p><strong><em>Dear Mr./Ms. {{ $dLeave->name }}</em></strong>,</p>

    <p>{{ $decide=='denied' ? 'We regret to inform you that your' : 'Your' }} leave application has been {{ $decide }} by your supervisor. Here are the details of the application:</p>
    <ul>
        {{-- <li><em>Name:</em>&nbsp;<strong>{{ $dLeave->name }}</strong></li> --}}
        <li><em>Leave Number:</em>&nbsp;<strong>{{ $dLeave->control_number }}</strong></li>
        <li><em>Leave Type:</em>&nbsp;<strong>{{ $dLeave->leave_type!='Others' ? $dLeave->leave_type : $dLeave->leave_type.' - '.$dLeave->others }}</strong></li>
        <li><em>From:</em>&nbsp;<strong>{{ \Carbon\Carbon::parse($dLeave->date_from)->format('D, m/d/Y') }}</strong></li>
        <li><em>To:</em>&nbsp;<strong>{{ \Carbon\Carbon::parse($dLeave->date_to)->format('D, m/d/Y') }}</strong></li>
        <li><em>Number of Day/s:</em>&nbsp;<strong>{{ $dLeave->no_of_days }}</strong></li>
        <li><em>Reason:</em>&nbsp;<strong>{{ $dLeave->reason }}</strong></li>
        <li><em>Status:</em>&nbsp;<strong>{{ $dLeave->action }}</strong></li>
    </ul>

    @if ($decide=='denied')
    <ul>
        <li><em>Reason for Denial:</em>&nbsp;<p><strong>{{ $dLeave->action_reason }}</strong></p></li>
    </ul>
    @endif
    

    <p>If you have any questions or need further information, feel free to contact HR.</p>
    <p>Thank you!</p>
    <p><h4><em>{{ env('COMPANY_NAME') }}</em></h4></p>
</body>
</html>
