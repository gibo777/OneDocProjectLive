<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
<style type="text/css">
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataLineItems thead th {
        text-align: center; /* Center-align the header text */
    }
    /* Hide the "Choose File" button */
    .form-control[type="file"]::-webkit-file-upload-button {
        display: none;
    }
    .form-control[type="file"]::before {
        content: none;
        display: inline-block;
        /*background: #007bff;*/ /* Change the background color if desired */
        /*color: #fff;*/ /* Change the text color if desired */
        padding: 2px 12px;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        /*width: 100%;*/
    }
</style>

    <x-slot name="header">
            {{ __('REIMBURSEMENT REQUEST FORM') }}
    </x-slot>
    <div>
        <div class="max-w-8xl mx-auto mt-2">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form id="reimbursementForm" method="POST" action="">
            @csrf

                <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    {{-- <div class="row">
                        <div class="col-md-12 p-1 text-center">
                            <x-jet-label for="name" value="{{ __('Reimbursement Request') }}" class="w-full" />
                        </div>
                    </div> --}}
                    <div class="row mt-2 border-1 py-2 inset-shadow">
                        <div class="col-md-4 nopadding">
                            <div class="row">
                                <div class="col-md-3 text-center pt-2">
                                    <x-jet-label for="inputField" value="{{ __('Incurred at') }}" />
                                </div>
                                <div class="col-md-8">
                                    <x-jet-input id="rPlace" name="rPlace" type="text" placeholder='Multiple places separated by comma ( , )' class="w-full shadow-none"/>
                                    <x-jet-input-error for="rPlace" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 nopadding">
                            <div class="row items-center">
                                <div class="col-md-3 text-center pt-2">
                                    <x-jet-label value="{{ __('For the Period of ') }}"/>
                                </div>
                                <div class="col-md-2.5 nopadding">
                                        <x-jet-input id="rDateFrom" name="rDateFrom" type="date" placeholder="mm/dd/yyyy" class="shadow-none" autocomplete="off"/>
                                </div>
                                <div class="col-sm-1 nopadding text-center">to</div>
                                <div class="col-md-2.5 p-0 m-0">
                                        <x-jet-input id="rDateTo" name="rDateTo" type="date" placeholder="mm/dd/yyyy" class="shadow-none" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-jet-button id="addRow">Add new row</x-jet-button>
                        </div>
                    </div>

                    <div class="row border-1 mt-2">
                        <table id="dataLineItems" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Document Support</th>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>  

                    <div class="row">
                        <!-- Upload File -->
                        <div id="div_upload" name="div_upload" class="form-floating col-md-4" hidden="true">
                            <x-jet-input id="upload_file" type="file" class="form-control mt-1 block w-full" placeholder="Attach necessary document" />
                            <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />

                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                            <x-jet-button id="submit_leave" name="submit_leave" disabled>
                                {{ __('Submit Reimbursement Request') }}
                            </x-jet-button>

                        </div>
                    </div>
                </div>
            </form>
                
        </div>
    </div>

{{-- PREVIEW MODALS --}}

<div class="modal fade" id="PreviewModal" tabindex="-1" role="dialog" arial-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg" id="modalErrorLabel">LEAVE SUMMARY</h4>
            <button id="truesubmitleave" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
        </div>

        <div class="modal-body bg-gray-50 red-color">
            <x-jet-label id="nameofemp" />
            <x-jet-label id="employeenumofemp" />
            <x-jet-label id="departmentofemp" />
            <x-jet-label id="dateappliedofemp" />
            <x-jet-label id="leavetypeofemp" />
            <x-jet-label id="datecoveredofemp" />
            <x-jet-label id="summary_date_to" />
            <x-jet-label id="notificationofleaveofemp" />
            <x-jet-label id="reasonofemp" />
    </div>
  </div>
</div>
    
</x-app-layout>


<script type="text/javascript">
$(document).ready(function() {
    let counter = 1;
    let addRowButton = $('#addRow');

    function addNewRow() {
        if (validatePreviousRow()) {
            const removeButton = counter > 1 ? `<button name="removeRow[${counter}]" type="button" class="btn btn-danger" value="${counter}"><i class="fa-solid fa-trash-can"></i></button>` : '';
            table.row
                .add([
                    `<input name="rFile[${counter}]" type="file" class="form-control">`,
                    `<input name="rDate[${counter}]" type="date" class="form-control">`,
                    `<input name="rParticulars[${counter}]" class="form-control">`,
                    `<select name="rCategories[${counter}]" class="form-control">
                        <option value="">Select Category</option>
                        <option>Category 1</option>
                        <option>Category 2</option>
                        <option>Category 3</option>
                        <option>Category 4</option>
                        <option>Category 5</option>
                    </select>`,
                    `<input type="number" name="rAmount[${counter}]" class="form-control">`,
                    `<input name="rRemarks[${counter}]" class="form-control">`,
                    removeButton
                ])
                .draw(false);

            counter++;
            // Remove the "Add new row" button after adding a row
            // addRowButton.prop('disabled', true).text('Row added');
        } else {
            Swal.fire({
                icon: "error",
                html:"Please fill all fields in the previous row before adding another row."
            });
        }
        return false;
    }

    function validatePreviousRow() {
        let isValid = true;

        // Select all input fields in the previous row
        const prevRowInputs = $(`#dataLineItems tbody tr:last-child input`);

        // Loop through each input field in the previous row and check if it's empty
        prevRowInputs.each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                return false; // Exit the loop early if any field is empty
            }
        });

        return isValid;
    }

    const table = $('#dataLineItems').DataTable({
        "ordering": false,
        "columnDefs": [
            { "orderable": false, "targets": "_all" }, // Disable sorting for all columns
            { "targets": [3], "orderable": true },
            { "width": '30px', targets: [6] }, // Adjust the width to fit the icon size
            { "width": '120px', targets: [0] },
            { "width": '80px', targets: [1] },
            { "width": '160px', targets: [2] },
            { "width": '120px', targets: [3] },
            { "width": '120px', targets: [4] },
            { "width": '160px', targets: [5] },
        ],
        "lengthMenu": [ -1 ], // Disable the "Show [X] entries" dropdown
        "paging": false, // Disable pagination
        "bLengthChange": false, // Disable "Show entries" dropdown
        "bFilter": false, // Disable search input field
        "language": {
            // "info": "Displaying _START_ to _END_ of _TOTAL_ entries"
            "info": ""
        },
    });

    // Event listener for "Add new row" button
    addRowButton.on('click', addNewRow);

    // Automatically add a first row of data
    addNewRow();

    $(document).on('click', 'button[name^="removeRow["]', function() {
        Swal.fire({ html: $(this).val() }); return false;
    });
});


</script>