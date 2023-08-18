<!DOCTYPE html>
<html>
<head>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css"> --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> --}}

{{-- DATA TABLES PLUGIN --}}

<script type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
</head>
<body>

<input type="date" id="startDateInput">
<input type="date" id="endDateInput">

<table id="dataTable table table-bordered table-striped sm:justify-center table-hover">
    <thead>
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2023-08-01</td>
            <td>2023-08-10</td>
        </tr>
        <tr>
            <td>2023-07-15</td>
            <td>2023-07-15</td>
        </tr>
        <tr>
            <td>2023-07-15</td>
            <td>2023-07-16</td>
        </tr>
        <tr>
            <td>2023-07-17</td>
            <td>2023-07-20</td>
        </tr>
        <tr>
            <td>2023-07-15</td>
            <td>2023-07-25</td>
        </tr>
        <tr>
            <td>2023-07-19</td>
            <td>2023-07-25</td>
        </tr>
        <!-- More rows... -->
    </tbody>
</table>

<script>
$(document).ready(function() {
    var dataTable = $('#dataTable').DataTable();
    
    $('#startDateInput, #endDateInput').on('change', function() {
        var startDate = $('#startDateInput').val();
        var endDate = $('#endDateInput').val();
        // alert('startDate: '+startDate+'\nendDate: '+endDate);
        
        dataTable.column(0).search(startDate, true, false).draw();
        dataTable.column(1).search(endDate, true, false).draw();
    });
});
</script>

</body>
</html>
