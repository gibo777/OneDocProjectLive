
<x-app-layout>
    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataOffices thead th {
        text-align: center; /* Center-align the header text */
    }
    </style>
    <x-slot name="header">
                {{ __('OFFICES') }}
    </x-slot>
<div id="view_departments">
    <div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8">
    <!-- FORM start -->

        @if (session('status'))
        <div class="alert alert-success">
        {{ session('status') }}
        </div>
        @endif
        <form id="department-form" action="{{ route('hr.management.offices') }}" method="POST">
        @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

            <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">

            <div align="right">
            <x-jet-button  id="add_office" class="btn btn-primary font-semibold text-xl thead mb-2">Add Office</x-jet-button>
            </div>

            <div id="table_data">
            <!-- Name -->
            <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                <table id="dataOffices" class="office-table table table-bordered table-striped sm:justify-center table-hover">
                <thead class="thead">
                <tr>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>ZIP Code</th>
                    <th>TIN</th>
                    <th>Contact #</th>
                    {{-- <th>Actions</th> --}}
                </tr>
                </thead>
                <tbody class="data hover" id="data">
                @foreach($offices as $office)
                    <tr
                        id="{{ $office->id }}" 
                        value="{{ $office->id.'|'.$office->company_name.'|'.$office->address }}" 
                        title="Edit {{ $office->company_name }}" 
                    >
                        <td class="text-center">{{ $office->company_name }}</td>
                        <td class="text-center">{{ join(', ',[$office->address,$office->city]) }}</td>
                        <td class="text-center">{{ $office->country }}</td>
                        <td class="text-center">{{ $office->zipcode }}</td>
                        <td class="text-center">{{ $office->tin }}</td>
                        <td class="text-center">{{ $office->contact }}</td>
                        {{-- <td class="text-center">{{ $office->department }}</td> --}}
                        {{-- <td id="action_buttons" class="text-center">
                            <button 
                                id="{{ $office->id }}" 
                                value="{{ $office->id.'|'.$office->company_name.'|'.$office->address }}" 
                                title="Edit {{ $office->company_name }}" 
                                class="edit-office-modal open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover" 
                            >
                                {{ __('EDIT') }}
                            </button>
                        
                        </td> --}}
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
            </div>
            </div>
            </div>
            </form>
        <!-- FORM end -->
        </div>
        </div>
    </div>
</div>
<!-- =========================================== -->
<!-- Modal -->
<div class="modal fade" id="officeAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-white fs-5" id="myModalLabel"></h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <form id="save-office-form" method="POST" action="{{ route('hr.management.save-offices') }}">
        @csrf
        {{-- <div class="px-3 py-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}"> --}}
                <div class="grid grid-cols-6 gap-4">
                    <!-- Company Name -->
                    <div class="form-floating col-span-6 sm:col-span-6 w-full">
                        <x-jet-input id="office_code" name="office_code" type="text" class="form-control mt-1 block w-full" placeholder="Company Name" autocomplete="off" />
                        <x-jet-label value="{{ __('Company Name') }}" />
                        <x-jet-input-error for="office_code" class="mt-2" />
                    </div>
                    <!-- Company Country -->
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <!-- <x-jet-input id="office_country" name="office_country" type="text" class="mt-1 block w-full" list="country_lists" autocomplete="off" /> -->
                        <select id="office_country" name="office_country" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Country" style="width: 100%; height: 100%;">
                                <option id="countryOption" value="">-Select Country</option>
                            @foreach ($countries as $key=>$country)
                            <option value="{{ $country->country_code }}" >{{ $country->country }} </option>
                            @endforeach
                        </select>
                        <x-jet-label for="office_country" value="{{ __('Country') }}" />
                        <x-jet-input-error for="office_country" class="mt-2" />
                    </div>
                    <!-- Company Provice -->
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <!-- <x-jet-input id="office_province" name="office_province" type="text" class="mt-1 block w-full" autocomplete="off" /> -->
                        <select id="office_province" name="office_province" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Province" style="width: 100%; height: 100%;">
                            <option id="provinceOption" value="">-Select Province-</option>
                        </select>
                        <x-jet-label for="office_province" value="{{ __('Province') }}" />
                        <x-jet-input-error for="office_province" class="mt-2" />
                    </div>
                    <!-- Company City -->
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <!-- <x-jet-input id="office_city" name="office_city" type="text" class="mt-1 block w-full" autocomplete="off" /> -->
                        <select id="office_city" name="office_city" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="City" style="width: 100%; height: 100%;">
                            <option id="cityOption" value="">-Select City-</option>
                        </select>
                        <x-jet-label for="office_city" value="{{ __('City') }}" />
                        <x-jet-input-error for="office_city" class="mt-2" />
                    </div>
                    <!-- Company Barangay -->
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <!-- <x-jet-input id="office_city" name="office_city" type="text" class="mt-1 block w-full" autocomplete="off" /> -->
                        <select id="office_barangay" name="office_barangay" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Barangay" style="width: 100%; height: 100%;">
                            <option id="barangayOption" value="">-Select Barangay-</option>
                        </select>
                        <x-jet-label for="office_barangay" value="{{ __('Barangay') }}" />
                        <x-jet-input-error for="office_barangay" class="mt-2" />
                    </div>
                    <!-- Company Address -->
                    <div class="form-floating col-span-6 sm:col-span-2 w-full">
                        <x-jet-input id="office_address" name="office_address" type="text" class="form-control mt-1 block w-full" placeholder="Address" autocomplete="off" />
                        <x-jet-label for="office_address" value="{{ __('Address') }}" />
                        <x-jet-input-error for="office_address" class="mt-2" />
                    </div>

                    <!-- Company Zip Code -->
                    <div class="form-floating col-span-5 sm:col-span-2 w-full">
                        <x-jet-input id="office_zipcode" name="office_zipcode" type="text" class="form-control mt-1 block w-full" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly/>
                        <x-jet-label for="office_zipcode" value="{{ __('ZIPcode') }}" />
                        <x-jet-input-error for="office_zipcode" class="mt-2" />
                    </div>
                    <!-- Company TIN -->
                    <div class="form-floating col-span-5 sm:col-span-2 w-full">
                        <x-jet-input id="office_tin" name="office_tin" type="text" class="form-control mt-1 block w-full" placeholder="TIN" autocomplete="off" />
                        <x-jet-label for="office_tin" value="{{ __('TIN') }}" />
                        <x-jet-input-error for="office_tin" class="mt-2" />
                    </div>
                    <!-- Company Contact Number/s -->
                    <div class="form-floating col-span-5 sm:col-span-4 w-full">
                        <x-jet-input id="office_contact" name="office_contact" type="text" class="form-control mt-1 block w-full" placeholder="Contact" autocomplete="off" />
                        <x-jet-label for="office_contact" value="{{ __('Contact') }}" />
                        <x-jet-input-error for="office_contact" class="mt-2" />
                    </div>
                </div>
            </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    
                    <!-- <div id="view_button1"> -->
                    <div>
                        <x-jet-input id="hid_office_id" name="hid_office_id" type="hidden"/>
                        <x-jet-button type="button" id="save_office" name="save_office" disabled>
                            {{ __('SAVE') }}
                        </x-jet-button>
                    </div>

                    <!-- <button type="button" class="btn btn-dark" data-dismiss="modal">CLOSE</button> -->
                </div>
                  <!-- <div class="modal-footer"> -->
                    <!-- <button type="button" class="btn btn btn-success" data-dismiss="modal">Save</button> -->
                    <!-- <button type="button" class="btn btn-orange" data-dismiss="modal">Cancel</button> -->
                  <!-- </div> -->
          {{-- </div> --}}
        </form>
        <!--  -->
    </div>
  </div>
</div>

<!-- =========================================== -->
<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="{{asset('/img/misc/loading-blue-circle.gif')}}">
</div>

<!-- =========================================== -->
<!-- Modal for Error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" >
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg" id="modalErrorLabel">ERROR</h4>
            <button type="button" class="close btn btn-primary fa fa-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>

        <div class="modal-body bg-gray-50 red-color">
            <h5>Kindly fill-up all required fields!</h5>
        </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
    // $("#office_country").select2();
    $('#office_country').dataList({return_mask:'text', value_selected_to:'username', clearOnFocus: true});
    // $('#office_country').dataList({return_mask:'text', value_selected_to:'username'});
    });

    $('#dataOffices').DataTable({
        columnDefs: [
          { width: '140px', targets: [0] }, 
          { width: '280px', targets: [1] }, 
          { width: '50px', targets: [3, 4] },
          // { width: '100px', targets: '_all' }
        ],
        "lengthMenu": [ 5,10, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 5 // Set the default number of entries per page
    });

</script>
<!-- =========================================== -->
</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>



