
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
        
    /* Hide the "Show" text and adjust layout for DataTables elements */
    .dataTables_wrapper .dataTables_length label {
        padding-left: 15px;
    }
    /* Display the "Show entries" dropdown and "Showing [entries] info" inline */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_filter {
        margin-top: 10px;
        display: inline-block;
    }
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataLeaveBenefits thead th {
        text-align: center; /* Center-align the header text */
    }

    </style>
    <x-slot name="header">
                {{ __('EMPLOYEE BENEFITS (PAID LEAVES)') }}
    </x-slot>
    <div id="view_leaves">
        <div class="max-w-6xl mx-auto py-1 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                        <div id="filter_fields" class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1">

                                <div class="col-md-9 mt-2 text-center">
                                </div>
                                <div class="col-md-3 py-2 text-center">
                                    <x-jet-button  id="addBenefits">
                                        <i class="fa-solid fa-plus-square pr-2"></i>
                                        Add Benefits
                                    </x-jet-button>
                                </div>
                            </div>
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataLeaveBenefits" class="table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Years of Services</th>
                                                <th>Vacation Leave</th>
                                                <th>Sick Leave</th>
                                                <th>Emergency Leave</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                                <tr id="">
                                                    @if (url('/')=='http://localhost')
                                                    <td>Below 3 years</td>
                                                    @endif
                                                    <td>10</td>
                                                    <td>10</td>
                                                    <td>5</td>
                                                </tr>
                                                <tr id="">
                                                    @if (url('/')=='http://localhost')
                                                    <td>More than 3 years to 6 years</td>
                                                    @endif
                                                    <td>12</td>
                                                    <td>12</td>
                                                    <td>5</td>
                                                </tr>
                                                <tr id="">
                                                    @if (url('/')=='http://localhost')
                                                    <td>More than 6 years</td>
                                                    @endif
                                                    <td>15</td>
                                                    <td>15</td>
                                                    <td>5</td>
                                                </tr>
                                            {{-- @forelse($employees as $employee)
                                                <tr id="{{ $employee->id }}">
                                                    @if (url('/')=='http://localhost')
                                                    <td>xxx</td>
                                                    @endif
                                                    <td>10</td>
                                                    <td>10</td>
                                                    <td>5</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">There are no users.</td>
                                                </tr>
                                            @endforelse --}}
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center" id="pagination">
                                        <?php //{!! $employees->links() !!} ?>
                                    </div>

                                </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

<!-- =========================================== -->

  <!-- EmployeeModal -->
  <div class="modal fade" id="benefitsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md mt-2" role="document">
      <div class="modal-content">
        <div class="modal-header custom-modal-header banner-blue">
          <h5 class="modal-title text-white fs-5" id="benefitsModalLabel">EMPLOYEE DETAILS</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">

                    <div class="col-md-12">

                        <div class="row my-1 pt-1">
                            <div class="col-md-4 form-floating px-1">
                                <!-- Employee ID -->
                                    <x-jet-input id="employee_id" type="text" class="form-control block w-full"/>
                                    <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="employee_id" class="mt-2" />
                            </div>
                            <div class="col-md-8 form-floating px-1">
                                    <x-jet-input id="position" type="text" class="form-control block w-full" autocomplete="position"/>
                                    <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="position" class="mt-2" />
                            </div>
                        </div>

                            @if (strpos(Auth::user()->department, 'ACCTG') || Auth::user()->id=1)
                            <div class="row my-1 pt-1">
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="vacation_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="vacation_leaves" value="{{ __('Vacation Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="sick_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="sick_leaves" value="{{ __('Sick Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="maternity_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="maternity_leaves" value="{{ __('Maternity Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="paternity_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="paternity_leaves" value="{{ __('Paternity Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="emergency_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="emergency_leaves" value="{{ __('Emergency Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                    <x-jet-input id="other_leaves" type="text" class="form-control block w-full" autocomplete="off"/>
                                    <x-jet-label for="other_leaves" value="{{ __('Other Leave') }}" class="text-black-50 text-sm-left w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-md-12 text-center" id="updateEmployee">
                        <x-jet-button>{{ __('Save') }} 
                        </x-jet-button>
                        <!-- <button class="btn btn-success">Submit</button> -->
                    </div>
                </div>

                            
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>
{{-- <a id="downloadLink" href="/storage/qrcodes/qr_codes.zip" download hidden></a> --}}
<!-- =========================================== -->
<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="{{asset('/img/misc/loading-blue-circle.gif')}}">
</div>

<!-- =========================================== -->

<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>




</x-app-layout>

<script type="text/javascript">
$(document).ready(function() {

    $('#dataLeaveBenefits').DataTable({
        "ordering": false,
        "columnDefs": [
          { width: '240px', targets: [0] }, 
        ],
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
    });

    // BenefitsModal
    $(document).on('click', '#addBenefits', function() {
        $('#benefitsModal').modal('show');
    });
});
</script>