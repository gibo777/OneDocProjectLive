
<x-app-layout>
<!-- <script src="{{ asset('/js/hris-jquery.js') }}"></script> -->

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <x-slot name="header">
                {{ __('DEPARTMENTS') }}
    </x-slot>
    <div id="view_departments">
        <div class="max-w-5xl mx-auto py-8 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="department-form" action="{{ route('hr.management.departments') }}" method="POST">
            @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">

                        <div align="right">
                            <x-jet-button  id="add_department" class="btn btn-primary font-semibold text-xl thead mb-2">Add Department</x-jet-button>
                        </div>
                        
                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="data_departments" class="table table-bordered table-striped sm:justify-center table-hover tabledata">
                                        <thead class="thead">
                                            <tr>
                                                <th>ID</th>
                                                <th>Code</th>
                                                <th>Department</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data" id="data">
                                            @foreach($departments as $department)
                                                <tr
                                                    class="edit_department" 
                                                    value="{{ $department->id.'|'.$department->department_code.'|'.$department->department }}" 
                                                    title="Edit {{ $department->department }}" 
                                                >
                                                    <td class="text-center">{{ $department->id }}</td>
                                                    <td class="text-center">{{ $department->department_code }}</td>
                                                    <td>{{ strtoupper($department->department) }}</td>
                                                    {{-- <td id="action_buttons" class="text-center"> --}}
                                                        {{-- <button 
                                                            id="edit_department-{{ $department->id }}" 
                                                            value="{{ $department->id.'|'.$department->department_code.'|'.$department->department }}" 
                                                            title="Edit {{ $department->department }}" 
                                                            class="open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover" 
                                                            data-toggle="modal" 
                                                            data-target="#myModal">
                                                            {{ __('EDIT') }}
                                                        </button> --}}
                                                        <!-- <button id="delete-{{ $department->id }}" 
                                                            value="{{ $department->id }}" 
                                                            title="Delete {{ $department->department }}" 
                                                            class="fa fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">
                                                            {{ __('Delete') }}
                                                        </button> -->



                                                    {{-- </td> --}}
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
<div class="modal fade" id="departmentAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-white fs-5" id="myModalLabel"></h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <form id="save-department-form" method="POST" action="{{ route('hr.management.save-departments') }}">
        @csrf
        <div class="px-4 py-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-5 gap-6">
                    <!-- Department Description -->
                    <div class="col-span-5 sm:col-span-4 w-full">
                        <x-jet-label for="department_code" value="{{ __('Code') }}" />
                        <x-jet-input id="department_code" name="department_code" type="text" class="mt-1 block w-full" autocomplete="off" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-6">
                    <!-- Department Description -->
                    <div class="col-span-5 sm:col-span-4 w-full">
                        <x-jet-label for="department" value="{{ __('Description') }}" />
                        <x-jet-input id="department" name="department" type="text" class="mt-1 block w-full" autocomplete="off" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>
            </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    
                    <!-- <div id="view_button1"> -->
                    <div>
                        <x-jet-input id="hid_department_id" name="hid_department_id" type="hidden"/>
                        <x-jet-button type="button" id="save_department" name="save_department" disabled>
                            {{ __('SAVE') }}
                        </x-jet-button>
                    </div>

                    <!-- <button type="button" class="btn btn-dark" data-dismiss="modal">CLOSE</button> -->
                </div>
                  <!-- <div class="modal-footer"> -->
                    <!-- <button type="button" class="btn btn btn-success" data-dismiss="modal">Save</button> -->
                    <!-- <button type="button" class="btn btn-orange" data-dismiss="modal">Cancel</button> -->
                  <!-- </div> -->
          </form>
        <!--  -->
      </div>
    </div>
  </div>
</div>

<!-- =========================================== -->


<!-- =========================================== -->
<!-- Modal for Error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" >
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg" id="modalErrorLabel">
                ERROR
            </h4>
            <button type="button" class="close btn btn-primary fa fa-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>

        <div class="modal-body bg-gray-50 red-color">
        <h5>Kindly fill-up all required fields!</h5>

        </div>
    </div>
  </div>
</div>
<!-- =========================================== -->
</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>



