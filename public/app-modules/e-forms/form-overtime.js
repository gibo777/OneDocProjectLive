
$(document).ready(function () {

    // Function to format time
    function formatTime(timeString) {
        var timeArray = timeString.split(":");
        var hours = parseInt(timeArray[0], 10);
        var minutes = timeArray[1];

        // Convert 24-hour format to 12-hour format with AM/PM
        var period = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        var formattedTime = hours + ':' + minutes + ' ' + period;
        return formattedTime;
    }

    function formatDate(date) {
        // Split the original date string into an array
        var dateArray = date.split('-');
        // Rearrange the date parts and join them with '/'
        var convertedDate = dateArray[1] + '/' + dateArray[2] + '/' + dateArray[0];
        return convertedDate;
    }

    function fieldsEmptyCount(otLocation = '', otDateFrom = '', otTimeFrom = '', otDateTo = '', otTimeTo = '', otReason = '') {
        var empty_fields = 0;
        if ($.trim(otLocation) == "") { empty_fields++; }
        if (otDateFrom == "") { empty_fields++; }
        if (otTimeFrom == "") { empty_fields++; }
        if (otDateTo == "") { empty_fields++; }
        if (otTimeTo == "") { empty_fields++; }
        if ($.trim(otReason) == "") { empty_fields++; }

        return empty_fields;
    }

    function isValidDateTime(otDtFr, otTFr, otDtTo, otTTo) {
        if ((otDtFr !== '' && otDtFr !== null) &&
            (otTFr !== '' && otTFr !== null) &&
            (otDtTo !== '' && otDtTo !== null) &&
            (otTTo !== '' && otTTo !== null)) {
            var otDateTimeFrom = new Date(otDtFr + 'T' + otTFr);
            var otDateTimeTo = new Date(otDtTo + 'T' + otTTo);

            if (otDateTimeTo < otDateTimeFrom) {
                $('#errorDateRange').html('Invalid Date/Time Range');
                $("#submitOvertime").attr('disabled', true);
                return false;
            } else {
                $('#errorDateRange').html('');
                $("#submitOvertime").removeAttr('disabled');
                const [totalHours, hours, minutes] = calculateTimeDifference(otDtFr, otTFr, otDtTo, otTTo);
                $('#thHours').html(hours);
                $('#thMinutes').html(minutes);
                $('#thTotalHours').html(totalHours.toFixed(2));
            }

        }
        return false;
    }

    function calculateTimeDifference(otDtFr, otTFr, otDtTo, otTTo) {
        const fromDate = new Date(otDtFr + ' ' + otTFr);
        const toDate = new Date(otDtTo + ' ' + otTTo);

        // Calculate the time difference in milliseconds
        var timeDifference = toDate - fromDate;

        // Convert milliseconds to hours and minutes
        var totalHours = timeDifference / (1000 * 60 * 60);
        var hours = Math.floor(totalHours);
        var minutes = Math.round((totalHours - hours) * 60);

        return [totalHours, hours, minutes];
    }


    // Key event for OT Location
    $(document).on('keyup', '#otLocation', function () {
        if (fieldsEmptyCount(
            $(this).val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());
    });

    // Key event for OT Reason
    $(document).on('keyup', '#otReason', function () {
        if (fieldsEmptyCount(
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $(this).val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());
    });

    // On change event for OT Date From
    $(document).on('change', '#otDateFrom', function () {
        ($("#otDateTo").val() == '' || $(this).val() > $("#otDateTo").val()) ? $("#otDateTo").val($(this).val()) : $("#otDateTo").val();

        if (fieldsEmptyCount(
            $('#otLocation').val(),
            $(this).val(),
            $("#otTimeFrom").val(),
            $("#otDateTo").val(),
            $("#otTimeTo").val(),
            $('#otReason').val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $(this).val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());
    });

    // On change event for OT Time From
    $(document).on('change', '#otTimeFrom', function () {
        // $("#otTimeTo").val()=='' ? $("#otTimeTo").val($(this).val()) : $("#otTimeTo").val();
        if (fieldsEmptyCount(
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $(this).val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $('#otDateFrom').val(),
            $(this).val(),
            $('#otDateTo').val(),
            $('#otTimeTo').val());
    });


    // On change event for OT Date To
    $(document).on('change', '#otDateTo', function () {
        ($("#otDateFrom").val() > $(this).val()) ? $("#otDateFrom").val($(this).val()) : $("#otDateFrom").val();

        if (fieldsEmptyCount(
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $(this).val(),
            $('#otTimeTo').val(),
            $('#otReason').val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $(this).val(),
            $('#otTimeTo').val());
    });

    // On change event for OT Time To
    $(document).on('change', '#otTimeTo', function () {
        if (fieldsEmptyCount(
            $('#otLocation').val(),
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $(this).val(),
            $('#otReason').val()
        ) > 0) {
            $("#submitOvertime").attr('disabled', true);
        } else {
            $("#submitOvertime").removeAttr('disabled');
        }
        isValidDateTime(
            $('#otDateFrom').val(),
            $('#otTimeFrom').val(),
            $('#otDateTo').val(),
            $(this).val());
    });

    /* SUBMIT OT REQUEST FORM begin */
    $(document).on('click', '#submitOvertime', function () {

        if (fieldsEmptyCount($('#otLocation').val(), $('#otDateFrom').val(), $('#otTimeFrom').val(),
            $('#otDateTo').val(), $('#otTimeTo').val(), $('#otReason').val()) > 0) {
            Swal.fire({
                icon: 'error',
                title: 'NOTIFICATION',
                text: 'Kindly fill-up all required fields',

            });
        } else {

            var otDateTimeFrom = new Date($('#otDateFrom').val() + 'T' + $('#otTimeFrom').val());
            var otDateTimeTo = new Date($('#otDateTo').val() + 'T' + $('#otTimeTo').val());

            if (otDateTimeTo < otDateTimeFrom) {
                Swal.fire({ html: 'Invalid Date Range', icon: 'error' });
                return false;
            }

            const otData = {
                otName: $('#otName').html(),
                otLoc: $('#otLocation').val(),
                otHead: $('#otSupervisor').html(),
                otDtFr: $('#otDateFrom').val(),
                otTFr: $('#otTimeFrom').val(),
                otDtTo: $('#otDateTo').val(),
                otTTo: $('#otTimeTo').val(),
                otReason: $('#otReason').val(),
            };

            const [totalHours, hours, minutes] = calculateTimeDifference(otData.otDtFr, otData.otTFr, otData.otDtTo, otData.otTTo);

            Swal.fire({
                scrollbarPadding: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit Request',
                cancelButtonText: 'Close',
                allowOutsideClick: false,
                html:
                    `<div class="table-responsive">
                    <table id="otSummary" class="table table-auto table-hover table-striped table-bordered text-center text-md">
                    <thead class="thead">
                        <tr class='text-center'>
                            <th>Overtime Request Summary</th>
                        </tr>
                    </thead>
                    <tbody class="data" id="data">
                        <tr>
                            <td class='text-left''><h6>Name : `+ otData.otName + `</h6></td>
                        </tr>
                        <tr>
                            <td class='text-left''><h6>OT Location : `+ otData.otLoc + `</h6></td>
                        </tr>
                        <tr>
                            <td class='text-left''><h6>OT Begin Date : `+ formatDate(otData.otDtFr) + ` ` + formatTime(otData.otTFr)
                    + `</h6><h6>OT End Date : ` + formatDate(otData.otDtTo) + ` ` + formatTime(otData.otTTo) + `</h6></th>
                        </tr>
                        <tr>
                            <td class='text-left''><h6>Reason : `+ otData.otReason + `</h6></td>
                        </tr>
                        <tr>
                            <td class='text-left''><h6>Hour/s : `+ hours + `</h6>
                            <h6>Minute/s : `+ minutes + `</h6>
                            <h6>Total Hours : `+ totalHours.toFixed(2) + `</h6></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                `,
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/hris/overtime',
                        method: 'post',
                        data: otData, // prefer use serialize method
                        beforeSend: function () {
                            $('#dataProcess').css({
                                'display': 'flex',
                                'position': 'fixed',
                                'top': '50%',
                                'left': '50%',
                                'transform': 'translate(-50%, -50%)'
                            });

                        },
                        success: function (data) {
                            if (data.isSuccess) {
                                $('#dataProcess').hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                }).then(function () {
                                    window.location = window.location.origin + "/e-forms/overtime-listing";
                                });
                                sendOTNotification(data.otID);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    html: data.message
                                });
                            }
                        }
                    }); return false;
                    // Handle the submit action
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Swal.fire('Cancelled', 'Your overtime request has been cancelled.', 'info');
                }
            });
        }
        return false;
    });
    function sendOTNotification(otID) {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            url: '/e-forms/notify-overtime-action',
            method: 'post',
            data: { 'otID': otID }, // prefer use serialize method
            success: function (data) { }
        });
    }
    /* SUBMIT OT REQUEST FORM end*/
});
