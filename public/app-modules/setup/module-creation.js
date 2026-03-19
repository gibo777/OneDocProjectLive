$(document).ready(function () {
    let parentSwalOpen = false;

    function isMobile() {
        return $(window).width() <= 768;
    }

    function createCategory(moduleName, parentModule, navOrder, moduleCategory) {

        Swal.fire({
            html: 'Module Name: ' + moduleName
                + '<br>Parent Module: ' + parentModule
                + '<br>Nav Order: ' + navOrder
                + '<br>Category: ' + moduleCategory
        }); return false;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: '/create-module',
            method: 'POST',
            data: { moduleName, parentModule, navOrder, moduleCategory },
            beforeSend: function () {
                $('#dataProcess').css({
                    'display': 'flex',
                    'position': 'fixed',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });
            },
            success: function (response) {
                $('#dataProcess').hide();
                Swal.fire({ html: JSON.stringify(response) }); return false;
                Livewire.emit('refreshComponent');
                // Swal.fire({ icon: response.isSuccess ? 'success' : 'error', html: response.message });
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
                    customClass: { popup: 'p-0' },
                    willOpen: () => {

                        // Dynamic Parent Modules
                        $('#createNavCategory').on('change', function () {
                            const category = $(this).val();
                            Livewire.emit('loadParentModules', category);

                            // Clear Parent dropdown immediately
                            $('#createNavParent').empty().append('<option value="">-</option>');
                        });

                        // Update Parent Modules when Livewire emits
                        Livewire.on('parentModulesUpdated', function (parents) {
                            const parentSelect = $('#createNavParent');
                            parentSelect.empty().append('<option value="">-</option>');

                            parents.forEach(function (parent) {
                                parentSelect.append('<option value="' + parent.id + '">' + parent.module_name + '</option>');
                            });
                        });

                        $('#saveModule').on('click', function () {
                            const moduleName = $('#createModuleName').val().trim();
                            const parentModule = $('#createNavParent').val();
                            const navOrder = $('#createNavOrder').val();
                            const moduleCategory = $('#createNavCategory').val();

                            const swalPopup = Swal.getPopup();
                            const errorDiv = swalPopup.querySelector('#moduleFormError');
                            errorDiv.textContent = '';

                            if (!moduleCategory) { errorDiv.textContent = 'No Category Selected'; return; }
                            if (!moduleName) { errorDiv.textContent = 'Module Name is empty'; return; }

                            // Swal.fire({
                            //     html: 'Module Name: ' + moduleName
                            //         + '<br>Parent Module: ' + parentModule
                            //         + '<br>Nav Order: ' + navOrder
                            //         + '<br>Category: ' + moduleCategory
                            // }); return false;

                            createCategory(moduleName, parentModule, navOrder, moduleCategory);
                        });

                    },
                    didClose: () => { parentSwalOpen = false; }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching user details:', error);
            }
        });
    });

    $(document).on('dblclick', '.view-nav', function () {
        const uID = $(this).attr('id');
        Swal.fire({ html: uID });
    });

    function saveAssignedViewing(uID, moduleNames, offices) {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
                Swal.fire({ html: data });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});
