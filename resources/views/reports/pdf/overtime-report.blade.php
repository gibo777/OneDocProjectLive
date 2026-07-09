<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 20px 20px 50px 20px;
        }

        body {
            font-family: sans-serif;
            font-size: 9px;
        }

        h2 {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 9px;
            color: #555;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 3px 5px;
            text-align: center;
            word-wrap: break-word;
            vertical-align: top;
        }

        th {
            background-color: #4a4a4a;
            color: #ffffff;
            font-weight: bold;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tbody tr:nth-child(even) {
            background-color: #e9e9e9;
        }

        .ot-reason {
            white-space: pre-wrap;
            overflow-wrap: break-word;
            word-break: break-word;
            max-width: 150px;
        }
    </style>
</head>

<body>
    <h2>Overtime Report</h2>
    <div class="subtitle">Generated: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Office</th>
                <th>Department</th>
                <th>OT Control No.</th>
                <th>OT Reason</th>
                <th>OT Location</th>
                <th>OT Schedule</th>
                <th>OT Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['otData'] as $item)
                <tr>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->office }}</td>
                    <td>{{ $item->department }}</td>
                    <td>{{ $item->ot_control_number }}</td>
                    <td class="ot-reason">{{ $item->ot_reason }}</td>
                    <td>{{ $item->ot_location }}</td>
                    <td>{{ $item->ot_schedule }}</td>
                    <td>{{ $item->ot_hrmins }}</td>
                    <td>{{ $item->ot_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->getFont("sans-serif");
            $size = 8;
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 30;
            $pdf->page_text($x, $y, $text, $font, $size, array(0, 0, 0));
        }
    </script>
</body>

</html>
