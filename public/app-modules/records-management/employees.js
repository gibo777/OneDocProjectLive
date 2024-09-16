$(document).ready(function () {
    let parentSwalOpen = false;

    /* EXPORT TO EXCEL TIMELOGS */
    $(document).on('click', '#exportExcelLeaves', async function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/leaves-excel',
            method: 'GET',
            data: { 'id': $(this).attr('id') },
            success: function(html) {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                let currentDateValue = tempDiv.querySelector('#hidCurrentDate').value;
                let filename = `Leaves_${currentDateValue}.xlsx`;

                let blob = new Blob([html], { type: 'application/vnd.ms-excel' });
                let url = window.URL.createObjectURL(blob);

                let a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error('Error exporting to Excel:', error);
            }
        });

        return false;
    });

    /* Reroute to Leave Form */
    $(document).on('click', '#createNewLeave', function() {
        window.location.href = lReq;
    });

    /* Viewing Leave Details per Control Number - Gibs */
    $(document).on('dblclick', '.view-leave', function() {
        let modalWidth = $(window).width() <= 768 ? '100%' : '82%';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/employee-detailed',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            beforeSend: function() {
                $('#dataLoad').css({
                    'display': 'flex',
                    'position': 'absolute',
                    'top': '40%',
                    'left': '40%'
                });
            },
            success:function(data){
                $('#dataLoad').css('display','none');
                Swal.fire({ 
                    width: modalWidth,
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowOutsideClick: false,
                    html: data,
                    didOpen: () => {
                        var sched = $('#hidWeeklySched').val().split('|');
                        $("#update_weekly_schedule").val(sched);
                        $('#update_weekly_schedule').multiselect({
                          enableFiltering: true,
                          enableCaseInsensitiveFiltering: true,
                          buttonWidth: '100%',
                          dropRight: true
                        });
                      },
                });
            }
        });

    });

    $(document).on('click', '#updateEmployee', function(event) {
        event.preventDefault();
        
        // Create FormData object
        var formData = new FormData($('#fUpdateEmployee')[0]);

        // Log FormData contents
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]);
        }

        // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/update-employee-info',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({ 
                    html: response.message,
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error',
                    text: `An error occurred: ${xhr.statusText}`,
                    icon: 'error'
                });
            }
        });
    });



    $(document).on('click', '#leave_form', function() {
        let leave_id = $('#hid_leave_id').val();
        window.location.href = `/hris/view-leave/form-leave/${leave_id}`;
    });




});
