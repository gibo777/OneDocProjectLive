$(document).ready(function () {
    let parentSwalOpen = false;

    function isMobile() {
        return $(window).width() <= 768;
    }

    function createCategory(moduleName, parentModule, navOrder, moduleCategory) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/create-module',
            method: 'POST',
            data: {
                moduleName,
                parentModule,
                navOrder,
                moduleCategory
            },
            beforeSend: function () {
                $('#dataLoad').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

            },
            success: function (response) {
                $('#dataLoad').hide();
                Livewire.emit('refreshComponent');
                Swal.fire({
                    icon: response.isSuccess ? 'success' : 'error',
                    html: response.message
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching user details:', error);
            }
        });
    }

    $('#createNewModule').on('click', function () {
        let modalWidth = isMobile() ? '100%' : '50%';
        $.ajax({
            url: '/module-creation',
            method: 'GET',
            beforeSend: function () {
                $('#dataLoad').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

            },
            success: function (html) {
                $('#dataLoad').hide();
                parentSwalOpen = true;
                Swal.fire({
                    html: html,
                    width: modalWidth,
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
                        $('#saveModule').on('click', function () {
                            const moduleName = $('#moduleName').val();
                            const parentModule = $('#parentModule').val();
                            const navOrder = $('#navOrder').val();
                            const moduleCategory = $('#moduleCategory').val();
                            createCategory(moduleName, parentModule, navOrder, moduleCategory);
                        });

                        // $('#saveModule').on('click', function() {
                        //     $('#secondMessage').fadeIn();
                        //     setTimeout(function() {
                        //         $('#secondMessage').fadeOut();
                        //     }, 5000);
                        // });
                        // $('#m1Office').multiselect({
                        //     enableFiltering: true,
                        //     enableCaseInsensitiveFiltering: true,
                        //     buttonWidth: '100%',
                        //     dropRight: true,
                        //     maxHeight: 200
                        // });
                        // $('#m2Office').multiselect({
                        //     enableFiltering: true,
                        //     enableCaseInsensitiveFiltering: true,
                        //     buttonWidth: '100%',
                        //     dropRight: true,
                        //     maxHeight: 200
                        // });
                        // $('#m3Office').multiselect({
                        //     enableFiltering: true,
                        //     enableCaseInsensitiveFiltering: true,
                        //     buttonWidth: '100%',
                        //     dropRight: true,
                        //     maxHeight: 200
                        // });
                        // $('#saveAssigned').on('click',function() {
                        //     let offices = [
                        //         $('#m1Office').val(),
                        //         $('#m2Office').val(),
                        //         $('#m3Office').val()
                        //     ];
                        //     let moduleNames = [
                        //         'Leaves Listing',
                        //         'Timelogs Listing',
                        //         'Employees Listing',
                        //     ];
                        //     saveAssignedViewing(uID,moduleNames,offices);
                        // });
                    },
                    didClose: () => {
                        parentSwalOpen = false;
                    }
                });

                // const swalPopup = Swal.getPopup();
                // swalPopup.style.overflow = 'visible';
                // swalPopup.style.maxHeight = 'none';
                // swalPopup.style.height = 'auto';
            },
            error: function (xhr, status, error) {
                console.error('Error fetching user details:', error);
            }
        });
    });

    $(document).on('dblclick', '.view-user', function () {
        const uID = $(this).attr('id');

        // $.ajax({
        //     url: '/authorize-user-detail',
        //     method: 'GET',
        //     data: { 'uID': uID },
        //     beforeSend: function() {
        //         $('#dataLoad').css({
        //             'display'   : 'flex',
        //             'position'  : 'fixed',
        //             'top'       : '50%',
        //             'left'      : '50%',
        //             'transform' : 'translate(-50%, -50%)'
        //         });

        //     },
        //     success: function(html) {
        //         $('#dataLoad').hide();
        //         parentSwalOpen = true;
        //         Swal.fire({
        //             html: html,
        //             width: 'auto',
        //             showCloseButton: true,
        //             showConfirmButton: false,
        //             allowEscapeKey: false,
        //             allowOutsideClick: false,
        //             showClass: { popup: '' },
        //             heightAuto: true,
        //             customClass: {
        //                 popup: 'p-0'
        //             },
        //             willOpen: () => {
        //                 $('#m1Office').multiselect({
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '100%',
        //                     dropRight: true,
        //                     maxHeight: 200
        //                 });
        //                 $('#m2Office').multiselect({
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '100%',
        //                     dropRight: true,
        //                     maxHeight: 200
        //                 });
        //                 $('#m3Office').multiselect({
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '100%',
        //                     dropRight: true,
        //                     maxHeight: 200
        //                 });
        //                 $('#saveAssigned').on('click',function() {
        //                     let offices = [
        //                         $('#m1Office').val(),
        //                         $('#m2Office').val(),
        //                         $('#m3Office').val()
        //                     ];
        //                     let moduleNames = [
        //                         'Leaves Listing',
        //                         'Timelogs Listing',
        //                         'Employees Listing',
        //                     ];
        //                     saveAssignedViewing(uID,moduleNames,offices);
        //                 });
        //             },
        //             didClose: () => {
        //                 parentSwalOpen = false;
        //             }
        //         });

        //         const swalPopup = Swal.getPopup();
        //         swalPopup.style.overflow = 'visible';
        //         swalPopup.style.maxHeight = 'none';
        //         swalPopup.style.height = 'auto';
        //     },
        //     error: function(xhr, status, error) {
        //         console.error('Error fetching user details:', error);
        //     }
        // });
    });

    function saveAssignedViewing(uID, moduleNames, offices) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dataObject = {
            'uID': uID,
            'offices': offices,
            'moduleNames': moduleNames
        };

        $.ajax({
            url: `${window.location.origin}/save-authorize-viewing`,
            method: 'POST',
            data: { auData: dataObject },
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
                $('#dataProcess').hide();
                // Swal.fire({ html: JSON.stringify(data.dataUsers) });
                Swal.fire({ html: data });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    }


});
