$(document).ready(function () {

    if (("{{ count($leaves) }}") == 0) {
        return false;
    }

    var tableLeaves = $('#dataViewOvertimes').DataTable({
        "ordering": false,
        "lengthMenu": [5, 10, 15, 25, 50, 75, 100], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
    });

    function formatDates(date) {
        var d = new Date(date),
            month = d.getMonth() + 1,
            day = d.getDate();

        var new_date =
            (month < 10 ? '0' : '') + month + '/' +
            (day < 10 ? '0' : '') + day +
            '/' + d.getFullYear();

        var hours = d.getHours();
        var minutes = d.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        new_date = new_date + " " + strTime;
        return new_date;
    }

    function currentDate() {
        var d = new Date(),
            month = d.getMonth() + 1,
            day = d.getDate();

        var current_date =
            (month < 10 ? '0' : '') + month + '/' +
            (day < 10 ? '0' : '') + day +
            '/' + d.getFullYear();

        return current_date;
    }

    // Print Function
    function printreport() {
        $("#printtable").printThis();
    }

    // Custom DataTable Search
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        // Custom DataTable Search Logic
    });

    // Date Filtering Logic
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        // Date Filtering Logic
    });

    // Event Listeners for Date From and Date To inputs
    $('#dateFrom').on('keyup change', function () {
        // Date From Event Listener Logic
    });

    $('#dateTo').on('keyup change', function () {
        // Date To Event Listener Logic
    });

    // Event Listeners for Filtering Departments, Leave Types, and Leave Statuses
    $('#filterDepartment, #filterLeaveType, #filterLeaveStatus').on('keyup change', function () {
        // Filtering Event Listener Logic
    });

    // Export to Excel Logic
    $('#exportExcelLeaves').click(function () {
        // Export to Excel Logic
    });

    // Redirect to Leave Form Logic
    $(document).on('click', '#createNewLeave', async function () {
        // Redirect to Leave Form Logic
    });

    // View Leave Details Logic
    $(document).on('dblclick', '.view-leave', function () {
        // View Leave Details Logic
    });

    // Open Leave Form Logic
    document.getElementById("leave_form").onclick = function () {
        // Open Leave Form Logic
    };

    $("#date_from").change(function () {
        // Date From Change Logic
    });

});
