$(document).ready(function () {
    let parentSwalOpen = false;
    let modalWidth = $(window).width() <= 768 ? '100%' : '900px';

    function isMobile() {
        return $(window).width() < 768;
    }

    $(document).on('dblclick', '.view-user', function () {
        const uID = $(this).attr('id');

        $.ajax({
            url: '/authorize-user-detail',
            method: 'GET',
            data: { uID: uID },
            beforeSend: function () {
                $('#dataLoad').css({
                    display: 'flex',
                    position: 'fixed',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)'
                });
            },
            success: function (html) {
                $('#dataLoad').hide();
                parentSwalOpen = true;

                Swal.fire({
                    html: html,
                    showCloseButton: true,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    width: modalWidth,
                    showClass: { popup: '' },
                    didOpen: () => {

                        // Initialize all multiselects dynamically (based on class now, not id)
                        $('.module-office').each(function () {
                            $(this).multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                buttonWidth: '100%',
                                dropRight: true,
                                maxHeight: 200
                            });
                        });

                        // Save Assigned button (collect values dynamically per module_id)
                        $('#saveAssigned').off('click').on('click', function () {

                            let moduleOfficeMap = {};

                            $('.module-office').each(function () {
                                let moduleId = $(this).data('module-id');   // <-- real module_id
                                let selectedOffices = $(this).val() || [];  // <-- selected offices

                                moduleOfficeMap[moduleId] = selectedOffices;
                            });

                            // Debug (optional — you can remove later)
                            console.log('Saving Map:', moduleOfficeMap);

                            saveAssignedViewing(uID, moduleOfficeMap);
                        });

                        // Make table container scrollable
                        const swalPopup = Swal.getPopup();
                        $(swalPopup).find('div.mx-3 > div.w-full.overflow-x-auto').css({
                            'overflow-y': 'auto',
                            'max-height': '70vh'
                        });
                    },

                    didClose: () => {
                        parentSwalOpen = false;
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching user details:', error);
            }
        });
    });

    function saveAssignedViewing(uID, moduleOfficeMap) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${window.location.origin}/save-authorize-viewing`,
            method: 'POST',
            data: {
                uID: uID,
                moduleOffices: moduleOfficeMap
            },
            beforeSend: function () {
                $('#dataProcess').css({
                    display: 'flex',
                    position: 'fixed',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)'
                });
            },
            success: function (data) {
                $('#dataProcess').hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    html: 'Office assignment updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr, status, error) {
                $('#dataProcess').hide();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'Something went wrong while saving.',
                });
            }
        });
    }

});
