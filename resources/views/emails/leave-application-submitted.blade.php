<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Submitted</title>
</head>
<body>
    <h4>Employee Leave Application Submitted for Your Review</h4>
    <p><strong><em>Dear 
        @if ($newLeave->head_sex=='F') Ma'am
        @elseif ($newLeave->head_sex=='M') Sir
        @else Sir/Ma'am
        @endif
         {{ $newLeave->head_name }},</em></strong></p>
    <p>The employee's leave request under your supervision has been successfully submitted. Here are the details of the application:</p>
    <ul>
        <li><em>Name:</em>&nbsp;<strong>{{ $newLeave->name }}</strong></li>
        <li><em>Leave Number:</em>&nbsp;<strong>{{ $newLeave->control_number }}</strong></li>
        <li><em>Leave Type:</em>&nbsp;<strong>{{ $newLeave->leave_type }}</strong></li>
        <li><em>From:</em>&nbsp;<strong>{{ \Carbon\Carbon::parse($newLeave->date_from)->format('D, m/d/Y') }}</strong></li>
        <li><em>To:</em>&nbsp;<strong>{{ \Carbon\Carbon::parse($newLeave->date_to)->format('D, m/d/Y') }}</strong></li>
        <li><em>Number of Day/s:</em>&nbsp;<strong>{{ $newLeave->no_of_days }}</strong></li>
        <li><em>Reason:</em><strong> {{ $newLeave->reason }}</strong></li>
    </ul>

    <p>Please review the submitted leave request and proceed with the necessary action by selecting one of the following links:</p>
    <p>
        <a href="{{ $approveUrl }}" style="color: green; text-decoration: none; font-weight: bold;">Approve Leave</a>
        <a href="{{ $approveUrl }}">{{ $approveUrl }}</a>
    </p>
    <p>
        <a href="{{ $denyUrl }}" style="color: red; text-decoration: none; font-weight: bold;">Deny Leave</a>
        <a href="{{ $denyUrl }}">{{ $denyUrl }}</a>
    </p>
    <p>If you have any questions or need further information, feel free to contact HR.</p>
    <p>Thank you!</p>
    <p><h4><em>{{ env('COMPANY_NAME') }}</em></h4></p>
</body>
</html>
