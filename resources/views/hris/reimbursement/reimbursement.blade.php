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


            <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                {{-- <div class="row">
                    <div class="col-md-12 p-1 text-center">
                        <x-jet-label for="name" value="{{ __('Reimbursement Request') }}" class="w-full" />
                    </div>
                </div> --}}
                <div class="row mt-2 border-1 py-2 inset-shadow">
                    <div class="col-md-6 nopadding">
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
                        <div class="row">
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
                </div>

                <div class="row text-right mt-3">
                    <p><x-jet-button id="addRow">Add new row</x-jet-button></p>
                </div>
                <div class="row border-1">
                    <table id="dataLineItems" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Document Support</th>
                                <th>Date</th>
                                <th>Particulars</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Remarks</th>
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
    
<x-jet-input id="holidates" type="hidden" value="{{ $holidays->implode('date', '|') }}"></x-jet-input>
</x-app-layout>

<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="error_dialog">
  <p id="error_dialog_content" class="text-justify px-2"></p>
</div>

<script type="text/javascript">
$(document).ready(function() {
let counter = 1;

    function addNewRow() {
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
            `<input name="rAmount[${counter}]" class="form-control">`,
            `<input name="rRemarks[${counter}]" class="form-control">`
        ])
        .draw(false);
 
    counter++;
}
 
const table = $('#dataLineItems').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": "_all" }, // Disable sorting for all columns
            { "targets": [3], "orderable": true },
            { "width": '100px', targets: [0] },
            { "width": '80px', targets: [1] },
            { "width": '140px', targets: [2] },
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
 
document.querySelector('#addRow').addEventListener('click', addNewRow);
 
// Automatically add a first row of data
addNewRow();
});

</script>