$(document).ready(function () {
    let parentSwalOpen = false;

    function isMobile() {
        return $(window).width() < 768;
    }

$(document).on('dblclick', '.view-user', function() {
    const uID = $(this).attr('id');

    $.ajax({
        url: '/authorize-user-detail',
        method: 'GET',
        data: { 'uID': uID },
        beforeSend: function() {
            $('#dataLoad').css({
                'display'   : 'flex',
                'position'  : 'fixed',
                'top'       : '50%',
                'left'      : '50%',
                'transform' : 'translate(-50%, -50%)'
            });

        },
        success: function(html) {
            $('#dataLoad').hide();
            parentSwalOpen = true;
            Swal.fire({
                html: html,
                width: 'auto',
                showCloseButton: true,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                showClass: { popup: '' },
                heightAuto: true,
                customClass: {
                    popup: 'p-0'
                },
                willOpen: () => {
                    $('#m1Office').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '100%',
                        dropRight: true,
                        maxHeight: 200
                    });
                    $('#m2Office').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '100%',
                        dropRight: true,
                        maxHeight: 200
                    });
                    $('#m3Office').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '100%',
                        dropRight: true,
                        maxHeight: 200
                    });
                    $('#saveAssigned').on('click',function() {
                        let offices = [
                            $('#m1Office').val(),
                            $('#m2Office').val(),
                            $('#m3Office').val()
                        ];
                        let moduleNames = [
                            'Leaves Listing',
                            'Timelogs Listing',
                            'Employees Listing',
                        ];
                        saveAssignedViewing(uID,moduleNames,offices);
                    });
                },
                didClose: () => {
                    parentSwalOpen = false;
                }
            });

            const swalPopup = Swal.getPopup();
            swalPopup.style.overflow = 'visible';
            swalPopup.style.maxHeight = 'none';
            swalPopup.style.height = 'auto';
        },
        error: function(xhr, status, error) {
            console.error('Error fetching user details:', error);
        }
    });
});

function saveAssignedViewing(uID,moduleNames,offices) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // let numberOfOffices = offices.length;
    // for (let i = 1; i <= numberOfOffices; i++) {
    //     offices[`m${i}Office`] = `Office ${i}`;
    // }

    let dataObject = {
        'uID'           : uID,
        'offices'       : offices,
        'moduleNames'   : moduleNames
    };

    $.ajax({
        url: `${window.location.origin}/save-authorize-viewing`,
        method: 'POST',
        data: { auData: dataObject },
        beforeSend: function() {
            $('#dataProcess').css({
                'display'   : 'flex',
                'position'  : 'fixed',
                'top'       : '50%',
                'left'      : '50%',
                'transform' : 'translate(-50%, -50%)'
            });

        },
        success: function(data) {
            $('#dataProcess').hide();
            // Swal.fire({ html: JSON.stringify(data.dataUsers) });
            Swal.fire({ html: data });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

}


});
