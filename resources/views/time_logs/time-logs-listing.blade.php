
<x-app-layout>

    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataTimeLogs thead th {
        text-align: center; /* Center-align the header text */
    }
    </style>

    <x-slot name="header">
                {{ __('TIME LOGS') }}
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
                    <div class="mb-2">
                        From <input type="date" id="dateFrom" name="dateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off"/> to <input type="date" id="dateTo" name="dateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off"/>
                    </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataTimeLogs" class="view-employees table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th>Employee ID</th>
                                                <th>Department</th>
                                                <th>Time-In</th>
                                                <th>Time-Out</th>
                                                <th>Supervisor</th>
                                                {{-- <th>Status</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            @forelse($employees as $employee)
                                                <tr id="{{ $employee->employee_id }}">
                                                    <td>{{ $employee->full_name }}</td>
                                                    <td>{{ $employee->employee_id }}</td>
                                                    <td>{{ $employee->department }}</td>
                                                    <td>{{ $employee->time_in ? date('m/d/Y g:i A',strtotime($employee->time_in)) : '' }}</td>
                                                    <td>{{ $employee->time_out ? date('m/d/Y g:i A',strtotime($employee->time_out)) : '' }}</td>
                                                    <td>{{ $employee->head_name }}</td>
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
                                        {{-- @foreach ($employment_statuses as $key=>$employment_status)
                                        <option value="{{ $employment_status->employment_status }}">{{ $employment_status->employment_status }}</option>
                                        @endforeach --}}
                                    </select>
                                    <x-jet-label for="employment_status" value="{{ __('Employment Status') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

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
                                       {{--  @foreach ($heads as $head)
                                        <option value="{{ $head->employee_id }}">{{ join(' ',[$head->last_name, $head->suffix.', ',$head->first_name,$head->suffix,$head->middle_name]) }}</option>
                                        @endforeach --}}
                                    </select>
                                    <x-jet-label for="supervisor" value="{{ __('Supervisor') }}" class="text-black-50 w-full" />
                                </div>
                        </div>

                        <div class="col-md-12 nopadding mt-2">
                            <div class="row">
                                <div class="col-md-7 w-full pr-0">
                                <div class="form-floating">
                                    <select name="updateRoleType" id="updateRoleType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                                        <option value=""></option>
                                       {{--  @foreach ($roleTypeUsers as $key=>$roleTypeUser)
                                            <option value="{{ $roleTypeUser->role_type }}">{{ $roleTypeUser->role_type }}</option>
                                        @endforeach --}}
                                    </select>
                                    <x-jet-label for="updateRoleType" value="{{ __('Role Type') }}" class="text-black-50 w-full" />
                                </div>
                                </div>
                                <div class="col-md-5 w-full position-relative">
                                    <div class="position-absolute bottom-0">
                                        <label for="isHead">Is Head?</label>
                                        <input type="checkbox" id="isHead">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row mt-1">
                                <div class="col-md-4 px-1">
                                    <div class="form-floating">
                                        <x-jet-input id="last_name" type="text" class="form-control block w-full bg-white border-0 shadow-0" autocomplete="last_name" disabled/>
                                        <x-jet-label for="last_name" value="{{ __('Last Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="last_name" class="mt-2" />
                                    </div>
                                    {{-- <x-jet-field-required>field required</x-jet-field-required> --}}
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class=" form-floating">
                                        <x-jet-input id="first_name" type="text" class="form-control block w-full" autocomplete="first_name" disabled/>
                                        <x-jet-label for="first_name" value="{{ __('First Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="first_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="middle_name" type="text" class="form-control block w-full" autocomplete="middle_name" disabled/>
                                        <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="middle_name" class="mt-2" />
                                </div>
                                <div class="col-md-1 form-floating px-1">
                                        <x-jet-input id="suffix" type="text" class="form-control block w-full" autocomplete="suffix" disabled/>
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
                                    <!-- Department -->
                                        <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">Select Department</option>
                                            {{-- @foreach ($departments as $dept)
                                            <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                            @endforeach --}}
                                        </select>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" />
                                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" /> 

                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="country" type="text" class="form-control block w-full" autocomplete="Country" disabled/>
                                            <x-jet-label for="country" value="{{ __('Country') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="country" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="province" type="text" class="form-control block w-full" autocomplete="Province" disabled/>
                                            <x-jet-label for="province" value="{{ __('Province') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="province" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="city" type="text" class="form-control block w-full" autocomplete="City" disabled/>
                                            <x-jet-label for="city" value="{{ __('City') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="city" class="mt-2" />
                                </div>
                            </div>


                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                            <x-jet-input id="barangay" type="text" class="form-control block w-full" autocomplete="barangay" disabled/>
                                            <x-jet-label for="barangay" value="{{ __('Barangay') }}" class="text-black-50 w-full" />
                                            <x-jet-input-error for="barangay" class="mt-2" />
                                </div>
                                <div class="col-md-6 form-floating px-1">
                                        <x-jet-input id="home_address" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="home_address" value="{{ __('House No./Street') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="home_address" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="zip_code" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="zip_code" value="{{ __('Zip Code') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="zip_code" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-4 form-floating px-1">
                                    <!-- Email -->
                                        <x-jet-input id="email" type="email" class="form-control block w-full" disabled/>
                                        <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="email" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="contact_number" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="contact_number" value="{{ __('Contact Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="contact_number" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="mobile_number" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="mobile_number" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="height" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="height" value="{{ __('Height') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="height" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="weight" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="weight" value="{{ __('Weight') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="weight" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">

                                        <x-jet-input id="gender" type="text" class="form-control block w-full" autocomplete="gender" disabled/>
                                        <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="gender" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="civil_status" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="civil_status" class="mt-2" />
                                </div>
                            </div>

                            <div class="row pt-2">
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="nationality" type="text" class="form-control block w-full" autocomplete="Nationality" disabled/>
                                        <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="nationality" class="mt-2" />
                                </div>
                                <div class="col-md-3 form-floating px-1">
                                        <x-jet-input id="religion" type="text" class="form-control block w-full" autocomplete="religion" disabled/>
                                        <x-jet-label for="relgion" value="{{ __('Religion') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="religion" class="mt-2" />
                                </div>
                                <div class="col-md-2 form-floating px-1">
                                        <x-jet-input id="birthdate" type="text" class="form-control datepicker block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birthdate" class="mt-2" />
                                </div>
                                <div class="col-md-4 form-floating px-1">
                                        <x-jet-input id="birth_place" type="text" class="form-control block w-full" autocomplete="off" disabled/>
                                        <x-jet-label for="birth_place" value="{{ __('Birth Place') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="birth_place" class="mt-2" />
                                </div>
                            </div>
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



<script type="text/javascript">
$(document).ready(function() {


  // Initialize DataTable
  var table = $('#dataTimeLogs').DataTable({
        "lengthMenu": [ 5,10, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 5 // Set the default number of entries per page
  });

    function formatDate(inputDate) {
        var date = new Date(inputDate); // Create a Date object from the input string
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0"); // Pad the month with leading zeros if needed
        var day = String(date.getDate()).padStart(2, "0"); // Pad the day with leading zeros if needed

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month,day,year].join("/");
      }




    /* START - Date From and Date To Searching */
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var searchDateFrom  = formatDate($('#dateFrom').val());
            var searchDateTo    = formatDate($('#dateTo').val());
            var searchTimeIn    = data[3]; //Time-In Column, it may change depending on the exact column
            var searchTimeOut   = data[4]; //Time-Out Column
            if ( ($('#dateFrom').val()==null || $('#dateFrom').val()=='') && ($('#dateTo').val()==null || $('#dateTo').val()=='') ) { return true; }

            if (searchTimeIn.includes(searchDateFrom) || searchTimeOut.includes(searchDateFrom) || searchTimeIn.includes(searchDateTo) || searchTimeOut.includes(searchDateTo)) {
                return true;
            }
            return false;
        }
    );

    $('#dateFrom').on('keyup change', function() {
        if ($('#dateTo').val()=='' || $('#dateTo').val()==null) {
            $('#dateTo').val($(this).val());
        }
        table.draw();
    });
    $('#dateTo').on('keyup change', function() {

        var dateFrom = new Date($('#dateFrom').val());
        var dateTo = new Date($(this).val());
        if( dateTo < dateFrom ) {
            $(this).val($('#dateFrom').val());
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                // text: '',
            });
        }

        table.draw();

    });
    /* END - Date From and Date To Searching */





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

</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>

