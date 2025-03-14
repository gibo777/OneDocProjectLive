<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Submitted</title>
</head>
<body>
    <h4>Pending Leave Request{{ $n > 1 ? 's' : '' }}</h4>
    <p><strong><em>Dear 
        @if ($head_sex=='F') Ma'am
        @elseif ($head_sex=='M') Sir
        @else Sir/Ma'am
        @endif
         {{ $head_name }},</em></strong></p>
    <p>This is a friendly reminder that as of this moment, there {!! $n > 1 ? 'are <b><i>' . $n . ' leave requests</i></b>' : 'is <b><i>a leave request</i></b>' !!} awaiting your decision.</p>
    <p>
        Kindly login to our Employee Portal using the link below to view the pending requests:<br>
        <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a>
    </p>
    <p>If you have any questions or need further information, feel free to contact HR.</p>
    <p>Thank you!</p>
    <p><h4><em>{{ env('COMPANY_NAME') }}</em></h4></p>
</body>
</html>
