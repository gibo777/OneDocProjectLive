
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <x-slot name="header">
                {{ __('VIEW ALL EMPLOYEES') }}
    </x-slot>
    <div id="view_leaves">
        <div class="w-full mx-auto py-2 sm:px-6 lg:px-8">
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
                        {{-- <div id="filter_fields" class="grid grid-cols-6 py-1 gap-2">
                            <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                <!-- <div class="col-span-8 sm:col-span-1">
                                    <x-jet-label for="filter_search" value="{{ __('SEARCH') }}" />
                                    <x-jet-input id="filter_search" name="filter_search" type="text" class="mt-1 block w-full" placeholder="Name or Employee No."/>
                                </div> -->
                                <!-- FILTER by Department -->
                                <div class="col-span-8 sm:col-span-1" id="div_filter_department" hidden>
                                    <x-jet-label for="filter_department" value="{{ __('DEPARTMENT') }}" />
                                    <select name="filter_department" id="filter_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="">All Departments</option>
                                        @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                        </div> --}}

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="data_holidays" class="table table-bordered table-striped sm:justify-center table-hover tabledata">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Head ID</th>
                                                {{-- <th>Role</th> --}}
                                                <th>Status</th>
                                                <th>Office</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            @forelse($employees as $employee)
                                                <tr id="{{ $employee->id }}">
                                                    <td>{{ join(' ',[$employee->last_name.',',$employee->first_name,$employee->suffix,$employee->middle_name]) }}</td>
                                                    <td>{{ $employee->employee_id}}</td>
                                                    <td>{{ $employee->dept }}</td>
                                                    <td>{{ $employee->position }}</td>
                                                    <td>{{ $employee->supervisor }}</td>
                                                    {{-- <td>{{ $employee->role_type }}</td> --}}
                                                    <td>{{ $employee->employment_status }}</td>
                                                    <td>{{ $employee->company_name }}</td>
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
    <div class="modal-dialog modal-xl" role="document">
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
                        <div class="flex justify-center mt-1 w-100">
                            <img id="imgProfile" src="" alt="" class="rounded h-id w-id object-cover">
                        </div>
                        <!-- EMPLOYEE STATUS -->
                        <div class="col-md-12 nopadding mt-2">
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
                        <!-- DATE HIRED -->
                        {{-- <div class="col-md-12 nopadding my-2">
                            <div class="form-floating w-full">
                                <x-jet-input id="date_hired" name="date_hired" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                <x-jet-label for="date_hired" value="{{ __('Date Started (mm/dd/yyyy)') }}" class="text-left nopadding" />
                                <x-jet-input-error for="date_hired" class="mt-2" />
                            </div>
                        </div> --}}

                        <div class="col-md-12 form-floating nopadding mt-2">
                                <x-jet-input id="date_hired" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                <x-jet-label for="date_hired" value="{{ __('Date Started (mm/dd/yyyy)') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="date_hired" class="mt-2" />
                        </div>
                        <div class="col-md-12 mt-1">
                              <div class="text-left align-items-center w-full nopadding">
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
                        <div class="col-md-12 nopadding mt-2">
                                <div class="form-floating">
                                    <select name="supervisor" id="supervisor" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                        <option value=""></option>
                                        @foreach ($heads as $head)
                                        <option value="{{ $head->employee_id }}">{{ join(' ',[$head->last_name,$head->first_name,$head->suffix,$head->middle_name]) }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="supervisor" value="{{ __('Head') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

                        {{-- <div class="col-md-12 nopadding w-full sm:justify-center mt-5">
                            <x-jet-button id="PDS" name="PDS">
                                {{ __('Export to PDF') }}
                            </x-jet-button>
                        </div> --}}
                    </div>
                    <div class="col-md-9">
                        <div class="row mt-1">
                                <div class="col-md-4 px-1">
                                    <div class="form-floating">
                                        <x-jet-input id="last_name" type="text" class="form-control block w-full"  placeholder="Last Name" autocomplete="last_name" readonly/>
                                        <x-jet-label for="last_name" value="{{ __('Last Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="last_name" class="mt-2" />
                                    </div>
                                    {{-- <x-jet-field-required>field required</x-jet-field-required> --}}
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class=" form-floating">
                                        <x-jet-input id="first_name" type="text" class="form-control block w-full" placeholder="First Name" autocomplete="first_name" readonly/>
                                        <x-jet-label for="first_name" value="{{ __('First Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="first_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="middle_name" type="text" class="form-control block w-full"  placeholder="Middle Name" autocomplete="middle_name" readonly/>
                                        <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="middle_name" class="mt-2" />
                                </div>
                                <div class="col-md-1 form-floating px-1">
                                        <x-jet-input id="suffix" type="text" class="form-control block w-full"  placeholder="Ext." autocomplete="suffix" readonly/>
                                        <x-jet-label for="suffix" value="{{ __('Ext.') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="suffix" class="mt-2" />
                                </div>

                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Employee ID -->
                                        <x-jet-input id="employee_id" type="text" class="form-control block w-full"  placeholder="Employee ID"/>
                                        <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="employee_id" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="position" type="text" class="form-control block w-full" placeholder="Position" autocomplete="position"/>
                                        <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="position" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Department -->
                                        {{-- <x-jet-input id="department" type="text" class="form-control block w-full"  placeholder="Department" autocomplete="department" readonly/>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" /> --}}
            
                                        <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                            <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" />
                                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" /> 


                                        {{-- <x-jet-input id="department" type="text" class="form-control block w-full"  placeholder="Department" autocomplete="department" readonly/>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" /> --}}
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            {{-- <select id="country" name="country" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                                <option value="">-Select Country-</option>

                                            </select>
                                            <x-jet-label for="country" value="{{ __('Country') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="country" class="mt-2" /> --}}
                                            <x-jet-input id="country" type="text" class="form-control block w-full"  placeholder="Country" autocomplete="Country" readonly/>
                                            <x-jet-label for="country" value="{{ __('Country') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="country" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            {{-- <select id="province" name="province" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                                <option value="">-Select Province-</option>

                                            </select>
                                            <x-jet-label for="province" value="{{ __('Province') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="province" class="mt-2" /> --}}
                                            <x-jet-input id="province" type="text" class="form-control block w-full" placeholder="Province" autocomplete="Province" readonly/>
                                            <x-jet-label for="province" value="{{ __('Province') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="province" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            {{-- <select id="city" name="city" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                                <option value="">-City/Municipality-</option>

                                            </select>
                                            <x-jet-label for="municipality" value="{{ __('City/Municipality') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="city" class="mt-2" /> --}}
                                            <x-jet-input id="city" type="text" class="form-control block w-full" placeholder="City" autocomplete="City" readonly/>
                                            <x-jet-label for="city" value="{{ __('City') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="city" class="mt-2" />
                                </div>
                            </div>


                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            {{-- <select id="barangay" name="barangay" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                                <option value="">-Select Barangay-</option>

                                            </select>
                                            <x-jet-label for="barangay" value="{{ __('Barangay') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="barangay" class="mt-2" /> --}}
                                            <x-jet-input id="barangay" type="text" class="form-control block w-full" placeholder="Barangay" autocomplete="barangay" readonly/>
                                            <x-jet-label for="barangay" value="{{ __('Barangay') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="barangay" class="mt-2" />
                                </div>
                                <div class="col-md-6 form-floating px-1">
                                        <x-jet-input id="home_address" type="text" class="form-control block w-full" placeholder="House No./Street" autocomplete="off" readonly/>
                                        <x-jet-label for="home_address" value="{{ __('House No./Street') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="home_address" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="zip_code" type="text" class="form-control block w-full" placeholder="Zip Code" autocomplete="off" readonly/>
                                        <x-jet-label for="zip_code" value="{{ __('Zip Code') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="zip_code" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Email -->
                                        <x-jet-input id="email" type="email" class="form-control block w-full" placeholder="Email" readonly/>
                                        <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="email" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="contact_number" type="text" class="form-control block w-full" placeholder="Contact Number" autocomplete="off" readonly/>
                                        <x-jet-label for="contact_number" value="{{ __('Contact Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="contact_number" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="mobile_number" type="text" class="form-control block w-full" placeholder="Mobile Number" autocomplete="off" readonly/>
                                        <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="mobile_number" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="height" type="text" class="form-control block w-full" placeholder="Height" autocomplete="off" readonly/>
                                        <x-jet-label for="height" value="{{ __('Height') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="height" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="weight" type="text" class="form-control block w-full" placeholder="Weight" autocomplete="off" readonly/>
                                        <x-jet-label for="weight" value="{{ __('Weight') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="weight" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        {{-- <select name="gender" id="gender" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" >
                                            <option value="">-Gender-</option>

                                        </select>
                                        <x-jet-label for="gender" value="{{ __('Gender') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="gender" class="mt-2" /> --}}

                                        <x-jet-input id="gender" type="text" class="form-control block w-full" placeholder="Sex" autocomplete="gender" readonly/>
                                        <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="gender" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="civil_status" type="text" class="form-control block w-full" placeholder="Civil Status" autocomplete="off" readonly/>
                                        <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-3 form-floating px-1">
                                        {{-- <select name="nationality" id="nationality" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">-Nationality-</option>

                                        </select>
                                        <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="nationality" class="mt-2" /> --}}
                                        <x-jet-input id="nationality" type="text" class="form-control block w-full" placeholder="Nationality" autocomplete="Nationality" readonly/>
                                        <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="nationality" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        {{-- <select name="religion" id="religion" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">-Religion-</option>

                                        </select>
                                        <x-jet-label for="religion" value="{{ __('Religion') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="religion" class="mt-2" /> --}}
                                        <x-jet-input id="religion" type="text" class="form-control block w-full" placeholder="Religion" autocomplete="religion" readonly/>
                                        <x-jet-label for="relgion" value="{{ __('Religion') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="religion" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="birthdate" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" readonly/>
                                        <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birthdate" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="birth_place" type="text" class="form-control block w-full" placeholder="Birth Place" autocomplete="off" />
                                        <x-jet-label for="birth_place" value="{{ __('Birth Place') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birth_place" class="mt-2" />
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="vacation_leaves" type="text" class="form-control block w-full" placeholder="Vacation Leaves" autocomplete="off"/>
                                    <x-jet-label for="vacation_leaves" value="{{ __('Vacation Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="sick_leaves" type="text" class="form-control block w-full" placeholder="Sick Leaves" autocomplete="off"/>
                                    <x-jet-label for="sick_leaves" value="{{ __('Sick Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="maternity_leaves" type="text" class="form-control block w-full" placeholder="Maternity Leaves" autocomplete="off"/>
                                    <x-jet-label for="maternity_leaves" value="{{ __('Maternity Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="paternity_leaves" type="text" class="form-control block w-full" placeholder="Paternity Leaves" autocomplete="off"/>
                                    <x-jet-label for="paternity_leaves" value="{{ __('Paternity Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="emergency_leaves" type="text" class="form-control block w-full" placeholder="Emergency Leaves" autocomplete="off"/>
                                    <x-jet-label for="emergency_leaves" value="{{ __('Emergency Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="other_leaves" type="text" class="form-control block w-full" placeholder="Other Leaves" autocomplete="off"/>
                                    <x-jet-label for="other_leaves" value="{{ __('Other Leaves') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                            </div>

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




<script type="text/javascript">
$(document).ready(function() {

    // $('#update_weekly_schedule').find('option[value=2]').attr("selected", "selected");
    
    /*$('#update_weekly_schedule').multiselect({
    });*/
                    
    $("#viewEmployee > tr").on('dblclick', function() {
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
                const {getemployee,getLeaves} = data;
                var imgProfilePhotoLocation = '';
                var dh = getemployee.date_hired.split('-');
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
                $("#date_hired").val( [dh[1],dh[2],dh[0]].join('/') );
                // $("input[name='weekly_schedule']").val(1);
                $("#supervisor").val(getemployee.supervisor);

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

    $('#updateEmployee > button').on('click', function() {
        const uD = {
            'id' : $(this).attr('id'),
            'employment_status': $("#employment_status").val(),
            'date_hired': $("#date_hired").val(),
            'update_weekly_schedule': $("#update_weekly_schedule").val(),
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


        };
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
                console.log(data);
                if(data.isSuccess==true) {
                    $("#EmployeesModal").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        // text: '',
                    }).then(function() {
                        location.reload();
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

</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>


