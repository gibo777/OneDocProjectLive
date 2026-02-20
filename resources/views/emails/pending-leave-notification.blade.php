<!DOCTYPE html>
<html>

<head>
    <title>Pending Requests</title>
</head>

<body>
    <h4>Pending Request/s for Your Approval</h4>
    <p><strong><em>Dear
                @if ($head_sex == 'F')
                    Ma'am
                @elseif ($head_sex == 'M')
                    Sir
                @else
                    Sir/Ma'am
                @endif
                {{ $head_name }},
            </em></strong></p>
    <p>This is a friendly reminder that you have pending request/s awaiting your review and approval as of today.</p>
    <p>Pending Request/s for Your Action</p>

    @if ($pendingLeaveCount > 0)
        <p>
            Leave Requests: {{ $pendingLeaveCount }} pending{{ $pendingLeaveCount > 1 ? 's' : '' }}<br>
            <a href="{{ env('APP_URL') . 'e-forms/leaves-listing' }}">{{ env('APP_URL') . 'e-forms/leaves-listing' }}</a>
        </p>
    @else
        <p>
            Leave Requests: No pending<br>
        </p>
    @endif

    @if ($pendingOvertimes > 0)
        <p>
            Overtime Requests: {{ $pendingOvertimes }} pending{{ $pendingOvertimes > 1 ? 's' : '' }}<br>
            <a
                href="{{ env('APP_URL') . 'e-forms/overtime-listing' }}">{{ env('APP_URL') . 'e-forms/overtime-listing' }}</a>
        </p>
    @else
        <p>
            Overtime Requests: No pending<br>
        </p>
    @endif

    <p>If you have any questions or need further assistance, feel free to contact HR.</p>
    <p>Thank you!</p>
    <p>
    <h4><em>{{ env('COMPANY_GROUP') }}</em></h4>
    </p>
    <p>
        <em>
            <h6> This is a system-generated reminder sent every Friday at 5:00PM. </h6>
        </em>
    </p>
</body>

</html>
