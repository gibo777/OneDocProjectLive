$(document).ready(function () {
    let parentSwalOpen = false;

    function isMobile() {
        return $(window).width() < 768;
    }

$(document).on('dblclick', '.view-user', function() {
    const lID = $(this).attr('id');

    $.ajax({
        url: '/authorize-user-detail',
        method: 'GET',
        data: { 'id': lID },
        success: function(html) {
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




    // $(document).on('click', '#leave_form', function() {
    //     let leave_id = $('#hid_leave_id').val();
    //     window.location.href = `/hris/view-leave/form-leave/${leave_id}`;
    // });


});
