
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataViewEmployees thead th {
        text-align: center; /* Center-align the header text */
    }
    </style>
    <x-slot name="header">
                {{ __('VIEW ALL EMPLOYEES') }}
    </x-slot>
    <div id="view_leaves">
        <div class="w-full mx-auto py-1 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{-- <form id="leave-form" action="{{ route('hris.leave.view-leave-details') }}" method="POST"> --}}
            @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                        <div id="filter_fields" class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1">
                                <div class="col-sm-1 h-full d-flex justify-content-center align-items-center">
                                    <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                                </div>

                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfilterEmpOffice">
                                        <select name="filterEmpOffice" id="filterEmpOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                            <option value="">All Offices</option>
                                            @foreach ($offices as $office)
                                            <option>{{ $office->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="filterEmpOffice" value="{{ __('OFFICE') }}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                        <!-- FILTER by Department -->
                                    <div class="form-floating" id="divfilterEmpDepartment">
                                        <select name="filterEmpDepartment" id="filterEmpDepartment" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                            <option value="">All Departments</option>
                                            @foreach ($departments as $dept)
                                            <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="filterEmpDepartment" value="{{ __('DEPARTMENT') }}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                        <!-- FILTER by Department -->
                                    <div class="form-floating" id="divfilterEmpDepartment">
                                        <select name="filterEmpStatus" id="filterEmpStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1 block w-full">
                                            <option value="">All Statuses</option>
                                            @foreach ($employment_statuses as $estat)
                                            <option>{{ $estat->employment_status }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="filterEmpStatus" value="{{ __('STATUS') }}" />
                                    </div>
                                </div>

                                <div class="col-md-3"></div>
                                <div class="col-md-2 py-2 text-center">
                                    <x-jet-button  id="registerEmployee">Register Employee</x-jet-button>
                                </div>
                            </div>
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataViewEmployees" class="view-employees table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th>Emp. ID</th>
                                                <th>Office</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Supervisor</th>
                                                {{-- <th>Role</th> --}}
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            @forelse($employees as $employee)
                                                <tr id="{{ $employee->id }}">
                                                    <td>{{ join(' ',[$employee->last_name.' '.$employee->suffix.',',$employee->first_name,$employee->middle_name]) }}</td>
                                                    <td>{{ $employee->employee_id}}</td>
                                                    <td>{{ $employee->company_name }}</td>
                                                    <td>{{ $employee->department }}</td>
                                                    <td>{{ $employee->position }}</td>
                                                    <td>{{ $employee->head_name }}</td>
                                                    {{-- <td>{{ $employee->role_type }}</td> --}}
                                                    <td>{{ $employee->employment_status }}</td>
                                                    {{-- <td id="action_buttons">
                                                        <button
                                                            id="view-{{ $employee->employee_id }}"
                                                            value="{{ $employee->id }}"
                                                            title="View {{ $employee->employee_id }}"
                                                            class="open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover"
                                                            >
                                                            {{ __('View') }}
                                                        </button>
                                                        <!-- <button id="delete-{{ $employee->id }}"
                                                            value="{{ $employee->id }}"
                                                            title="Delete {{ $employee->employee_id }}"
                                                            class="fa fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">
                                                            {{ __('Delete') }}
                                                        </button> -->
                                                    </td> --}}
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">There are no users.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center" id="pagination">
                                        <?php //{!! $employees->links() !!} ?>
                                    </div>

                                </div>
                    </div>
                </div>
            </div>
{{--
            </form> --}}
            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>

<!-- =========================================== -->
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch Modal window
</button> -->


  <!-- EmployeeModal -->
  <div class="modal fade" id="EmployeesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-2" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-white fs-5" id="EmployeesModalLabel">EMPLOYEE DETAILS</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="flex justify-center my-1 w-100">
                            <img id="imgProfile" src="" alt="" class="rounded h-id w-id object-cover">
                        </div>
                        <!-- EMPLOYEE STATUS -->
                        <div class="col-md-12 nopadding my-1">
                                <div class="form-floating">
                                    <select name="employment_status" id="employment_status" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                        <option value=""></option>
                                        @foreach ($employment_statuses as $key=>$employment_status)
                                        <option value="{{ $employment_status->employment_status }}">{{ $employment_status->employment_status }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="employment_status" value="{{ __('Employment Status') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

                        <div class="col-md-12 nopadding my-1">
                            <div class="row">
                                <div class="col-md-6 form-floating">
                                    <x-jet-input id="date_hired" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                    <x-jet-label for="date_hired" value="{{ __('Date Started') }}" class="pl-4 text-black-50 w-full" />
                                    <x-jet-input-error for="date_hired" class="mt-2" />
                                </div>
                                  <div class="col-md-6 text-left align-items-center w-full nopadding">
                                    <x-jet-label for="weekly_schedule" value="{{ __('Weekly Schedule') }}" class="nopadding"/>
                                    <select id="update_weekly_schedule" name="update_weekly_schedule" multiple class="w-full" required>
                                        <option value="0">Sunday</option>
                                        <option value="1" >Monday</option>
                                        <option value="2" >Tuesday</option>
                                        <option value="3" >Wednesday</option>
                                        <option value="4" >Thursday</option>
                                        <option value="5" >Friday</option>
                                        <option value="6" >Saturday</option>
                                    </select>
                                  </div>
                            </div>
                        </div>

                        <div class="col-md-12 nopadding my-1">
                                <div class="form-floating">
                                    <select name="office" id="office" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                        <option value=""></option>
                                        @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="office" value="{{ __('Office') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

                        <div class="col-md-12 nopadding my-1">
                                <div class="form-floating">
                                    <select name="supervisor" id="supervisor" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                        <option value=""></option>
                                        @foreach ($heads as $head)
                                        <option value="{{ $head->employee_id }}">{{ join(' ',[$head->last_name, $head->suffix.', ',$head->first_name,$head->middle_name]) }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="supervisor" value="{{ __('Supervisor') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

                        <div class="col-md-12 nopadding my-1">
                            <div class="row">
                                <div class="col-md-7 form-floating">
                                    <select name="updateRoleType" id="updateRoleType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                                        <option value=""></option>
                                        @foreach ($roleTypeUsers as $key=>$roleTypeUser)
                                            <option value="{{ $roleTypeUser->role_type }}">{{ $roleTypeUser->role_type }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="updateRoleType" value="{{ __('Role Type') }}" class="text-black-50 w-full pl-4" />
                                </div>
                                <div class="col-md-5 d-flex align-items-center justify-content-center">
                                        <label for="isHead" class="pr-1">Is Head?</label>
                                        <input type="checkbox" id="isHead">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row mt-1">
                                <div class="col-md-4 px-1">
                                    <div class="form-floating">
                                        <x-jet-input id="last_name" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="last_name" disabled/>
                                        <x-jet-label for="last_name" value="{{ __('Last Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="last_name" class="mt-2" />
                                    </div>
                                    {{-- <x-jet-field-required>field required</x-jet-field-required> --}}
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class=" form-floating">
                                        <x-jet-input id="first_name" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="first_name" disabled/>
                                        <x-jet-label for="first_name" value="{{ __('First Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="first_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="middle_name" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="middle_name" disabled/>
                                        <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="middle_name" class="mt-2" />
                                </div>
                                <div class="col-md-1 form-floating px-1">
                                        <x-jet-input id="suffix" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="suffix" disabled/>
                                        <x-jet-label for="suffix" value="{{ __('Ext.') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="suffix" class="mt-2" />
                                </div>

                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Employee ID -->
                                        <x-jet-input id="employee_id" type="text" class="form-control block w-full"/>
                                        <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="employee_id" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="position" type="text" class="form-control block w-full" autocomplete="position"/>
                                        <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="position" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                            <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" />
                                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="country" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="Country" disabled/>
                                            <x-jet-label for="country" value="{{ __('Country') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="country" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="province" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="Province" disabled/>
                                            <x-jet-label for="province" value="{{ __('Province') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="province" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="city" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="City" disabled/>
                                            <x-jet-label for="city" value="{{ __('City') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="city" class="mt-2" />
                                </div>
                            </div>


                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="barangay" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="barangay" disabled/>
                                            <x-jet-label for="barangay" value="{{ __('Barangay') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="barangay" class="mt-2" />
                                </div>
                                <div class="col-md-6 form-floating px-1">
                                        <x-jet-input id="home_address" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="home_address" value="{{ __('House No./Street') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="home_address" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="zip_code" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="zip_code" value="{{ __('Zip Code') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="zip_code" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Email -->
                                        <x-jet-input id="email" type="email" class="form-control block w-full border-1 shadow-none" disabled/>
                                        <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="email" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="contact_number" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="contact_number" value="{{ __('Contact Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="contact_number" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="mobile_number" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="mobile_number" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                {{-- <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="height" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="height" value="{{ __('Height') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="height" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="weight" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="weight" value="{{ __('Weight') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="weight" class="mt-2" />
                                </div> --}}
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="gender" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="gender" disabled/>
                                        <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="gender" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="civil_status" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                            {{-- </div>

                            <div class="row pt-2"> --}}
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="nationality" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="Nationality" disabled/>
                                        <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="nationality" class="mt-2" />
                                </div>
                                {{-- <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="religion" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="religion" disabled/>
                                        <x-jet-label for="relgion" value="{{ __('Religion') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="religion" class="mt-2" />
                                </div> --}}
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="birthdate" type="text" class="form-control datepicker block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birthdate" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="birth_place" type="text" class="form-control block w-full border-1 shadow-none" autocomplete="off" disabled/>
                                        <x-jet-label for="birth_place" value="{{ __('Birth Place') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birth_place" class="mt-2" />
                                </div>
                            </div>
                            @if (strpos(Auth::user()->department, 'ACCTG') || Auth::user()->id=1)
                            <div class="row pt-2">
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

    var tableEmployee = $('#dataViewEmployees').DataTable({
            /*"columnDefs": [
              { width: '120px', targets: [0] }, 
            ],*/
            "ordering": false,
            "lengthMenu": [ 5,10, 25, 50, 75, 100 ], // Customize the options in the dropdown
            "iDisplayLength": 5 // Set the default number of entries per page
      });

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var sO = $('#filterEmpOffice').val();
            var sD = $('#filterEmpDepartment').val();
            var sS = $('#filterEmpStatus').val();
            var cO = data[2]; // Office Column
            var cD = data[3]; // Department Column
            var cS = data[6]; // Status Column
            
            // Check if an Office filter is selected
            var officeFilterActive = (sO != null && sO !== '');

            // Check if a Department filter is selected
            var departmentFilterActive = (sD != null && sD !== '');

            // Check if a Department filter is selected
            var statusFilterActive = (sS != null && sS !== '');

            // Apply both filters
            if (!officeFilterActive && !departmentFilterActive && !statusFilterActive) {
                return true; // No filters applied, show all rows
            }
            var officeMatch = !officeFilterActive || cO.includes(sO);
            var departmentMatch = !departmentFilterActive || cD.includes(sD);
            var statusMatch = !statusFilterActive || cS.includes(sS);

            return officeMatch && departmentMatch && statusMatch;
    });

    /* Filtering OFfice - Gibs */
    $('#filterEmpOffice').on('keyup change', function() { 
        tableEmployee.draw(); 
    });
    /* Filtering Department - Gibs */
    $('#filterEmpDepartment').on('keyup change', function() { 
        tableEmployee.draw(); 
    });
    /* Filtering Department - Gibs */
    $('#filterEmpStatus').on('keyup change', function() { 
        tableEmployee.draw(); 
    });

    /* Reroute to User/Employee Registration */
    $(document).on('click','#registerEmployee', async function() {
        window.location.href = "{{ route('register') }}";
    });

    /* Double Click event to show Employee details */
    $(document).on('dblclick','.view-employees tr',async function(){
        $('#dataLoad').css('display','flex');
        $('#dataLoad').css('position','absolute');
        $('#dataLoad').css('top','40%');
        $('#dataLoad').css('left','40%');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/getemployees',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){
                $('#dataLoad').css('display','none');

                const {getemployee,getLeaves} = data;
                var imgProfilePhotoLocation = '';
                var dh = (getemployee.date_hired!=null) ? getemployee.date_hired.split('-') : '';
                var valDateHired = (getemployee.date_hired!=null) ? [dh[1],dh[2],dh[0]].join('/') : '';
                var sched = getemployee.weekly_schedule.split('|');

                $("#update_weekly_schedule").val(sched);
                $("#update_weekly_schedule").multiselect("refresh");

                if (getemployee.profile_photo_path!=null) {
                    imgProfilePhotoLocation = document.location.origin+'/storage/'+getemployee.profile_photo_path;
                } else {
                    switch(getemployee.gender){
                        case 'M':
                        imgProfilePhotoLocation = document.location.origin+'/storage/profile-photos/default-formal-male.png';
                        break;
                        case 'F':
                        imgProfilePhotoLocation = document.location.origin+'/storage/profile-photos/default-female.png';
                        break;
                        default:
                        imgProfilePhotoLocation = document.location.origin+'/storage/profile-photos/default-photo.png';
                    }
                }
                $("#imgProfile").attr('src',imgProfilePhotoLocation);
                $("#employment_status").val(getemployee.employment_status);
                $("#date_hired").val( valDateHired );
                // $("input[name='weekly_schedule']").val(1);
                $("#office").val(getemployee.office);
                $("#supervisor").val(getemployee.supervisor);

                $("#updateRoleType").val(getemployee.role_type);
                // $("#EmployeesModal #updateRoleType").val(getemployee.role_type);
                (getemployee.is_head==1) ? $('#isHead').prop('checked', true) : $('#isHead').prop('checked', false);

                // alert(getemployee.weekly_schedule);
                $("#last_name").val(getemployee.last_name);
                $("#first_name").val(getemployee.first_name);
                $("#middle_name").val(getemployee.middle_name);
                $("#suffix").val(getemployee.suffix);

                $("#employee_id").val(getemployee.employee_id);
                $("#position").val(getemployee.position);
                $("#department").val(getemployee.department);

                $("#country").val(getemployee.country);
                $("#province").val(getemployee.province);
                $("#city").val(getemployee.city);

                $("#barangay").val(getemployee.barangay);
                $("#home_address").val(getemployee.home_address);
                $("#zip_code").val(getemployee.zip_code);

                $("#email").val(getemployee.email);
                $("#contact_number").val(getemployee.contact_number);

                $('#vacation_leaves').val(getLeaves.VL ? getLeaves.VL : 0);
                $('#sick_leaves').val(getLeaves.SL ? getLeaves.SL : 0);
                $('#maternity_leaves').val(getLeaves.ML ? getLeaves.ML : 0);
                $('#paternity_leaves').val(getLeaves.PL ? getLeaves.PL : 0);
                $('#emergency_leaves').val(getLeaves.EL ? getLeaves.EL : 0);
                $('#other_leaves').val(getLeaves.others ? getLeaves.others : 0);


                $('#updateEmployee > button').attr('id',getemployee.id);
                $("#EmployeesModal").modal('show');
            }
        });
    });
                    
   
    /* Button to update Employee details */
    $('#updateEmployee > button').on('click', function() {
        var isHead = 0;
        $("#isHead").is(':checked') ? isHead = 1 : isHead = 0;
        const uD = {
            'id' : $(this).attr('id'),
            'employment_status': $("#employment_status").val(),
            'date_hired': $("#date_hired").val(),
            'update_weekly_schedule': $("#update_weekly_schedule").val(),
            'office': $("#office").val(),
            'supervisor': $("#supervisor").val(),
            'name': [$("#last_name").val(), $("#first_name").val(),$("#suffix").val(),$("#middle_name").val()].join(' '),
            'employee_id' : $("#employee_id").val(), 
            'position' : $("#position").val(),
            'department' : $("#department").val(),
            'vl': $('#vacation_leaves').val(),
            'sl':$('#sick_leaves').val(),
            'ml': $('#maternity_leaves').val(),
            'pl': $('#paternity_leaves').val(),
            'el': $('#emergency_leaves').val(),
            'others':$('#other_leaves').val(),
            'roleType': $("#updateRoleType").val(),
            'is_head': isHead,
        };
        // alert(isHead); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updateemployees',
            method: 'post',
            data: uD, // prefer use serialize method
            success:function(data){
                // prompt('',data); return false;
                console.log(data);
                if(data.isSuccess==true) {
                    $("#EmployeesModal").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        // text: '',
                    }).then(function() {
                        // location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: JSON.stringify(data.message),
                    });
                }
            }
        });
    });
});
</script>