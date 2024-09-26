
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
    #dataViewEmployees thead th {
        text-align: center; /* Center-align the header text */
    }

    </style>
    <x-slot name="header">
                {{ __('VIEW ALL EMPLOYEES') }}
    </x-slot>
    <div id="viewLeaves">
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
                                            <option >{{ $dept->department }}</option>
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

                                <div class="col-md-2 mt-2 text-center">
                                    @if(Auth::user()->id==1)
                                    <x-jet-button id="downloadQR" name="downloadQR" value="Scan QR">
                                        <i class="fa-solid fa-qrcode pr-2"></i>
                                        Download QR
                                    </x-jet-button>
                                    @endif
                                </div>
                                <div class="col-md-3 py-2 text-center">
                                    <x-jet-button  id="registerEmployee">
                                        <i class="fa-solid fa-user-plus pr-2"></i>
                                        Register Employee
                                    </x-jet-button>
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
                                                    @if (url('/')=='http://localhost')
                                                    <td>xxx, xxx x.</td>
                                                    @else
                                                    <td>{{ join(' ',[$employee->last_name.' '.$employee->suffix.',',$employee->first_name,$employee->middle_name]) }}</td>
                                                    @endif
                                                    <td>{{ $employee->employee_id}}</td>
                                                    <td>{{ $employee->company_name }}</td>
                                                    <td>{{ $employee->department }}</td>
                                                    <td>{{ $employee->position }}</td>

                                                    @if (url('/')=='http://localhost')
                                                    <td>xxx, xxx x.</td>
                                                    @else
                                                    <td>{{ $employee->head_name }}</td>
                                                    @endif
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

@include('modals/m-view-employee')

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

    var tableEmployee = $('#dataViewEmployees').DataTable({
        /*"columnDefs": [
          { width: '120px', targets: [0] }, 
        ],*/
        "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
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



    /* Download QR Code */
    $(document).on('click', '#downloadQR', async function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/download-multiple-qrcodes',
            method: 'get',
            // data: {'qrLink':''}, // prefer use serialize method
            success:function(link){
                Swal.fire({ 
                    icon: "success",
                    html: "QR download successful!", 
                });
            }
        });
    });

    /* Reroute to User/Employee Registration */
    $(document).on('click','#registerEmployee', async function() {
        window.location.href = "{{ route('register') }}";
    });

    /* Double Click event to show Employee details */
    $(document).on('dblclick','.view-employees tr',async function(){
        $('#dataLoad').css('display','flex');
        $('#dataLoad').css('position','absolute');
        /*$('#dataLoad').css('top','40%');
        $('#dataLoad').css('left','40%');*/
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

                const {getemployee,getLeaves,qrCodeLink} = data;
                var imgProfilePhotoLocation = '';
                var dh = (getemployee.date_hired!=null && getemployee.date_hired!='1970-01-01') ? getemployee.date_hired.split('-') : '';

                var valDateHired = (getemployee.date_hired!=null && getemployee.date_hired!='1970-01-01') ? getemployee.date_hired : '';
                var sched = getemployee.weekly_schedule.split('|');

                var valDateReg = (getemployee.date_regularized!=null && getemployee.date_regularized!='01/01/1970') ? getemployee.date_regularized : '';

                var labelElement = $("#fullName");
                var fullName = [getemployee.last_name];
                if (getemployee.suffix != null) {
                  fullName.push(getemployee.suffix + ',');
                } else {
                  fullName.push(',');
                }

                $("#qrCode").html(`<img src="{{ asset('img/misc/loading-blue-circle.gif')}}"/>`);
                // $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.ajax({
                    url: '/qr-code',
                    method: 'get',
                    data: {'id':getemployee.id},
                    success:function(qrCode){
                        // prompt('',qrCode);
                        $("#qrCode").html(qrCode);
                    }
                });
                

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
                // $("#qrcode").html(qrCodeLink.qr_code_link);

                $("#employment_status").val(getemployee.employment_status);
                $("#date_hired").val( valDateHired );
                $("#dateRegularized").val( valDateReg );
                // $("input[name='weekly_schedule']").val(1);
                $("#office").val(getemployee.office);
                $("#supervisor").val(getemployee.supervisor);

                $("#updateRoleType").val(getemployee.role_type);
                // $("#EmployeesModal #updateRoleType").val(getemployee.role_type);
                (getemployee.is_head==1) ? $('#isHead').prop('checked', true) : $('#isHead').prop('checked', false);

                // alert(getemployee.weekly_schedule);

                fullName.push(getemployee.first_name, getemployee.middle_name);
                labelElement.html("Name: " + fullName.join(' ').toUpperCase()+"");

                var hAdd = (getemployee.home_address!=null) ? getemployee.home_address+',' : '' ;
                var bAdd = (getemployee.barangay!=null) ? getemployee.barangay+',' : '' ;
                var ctAdd = (getemployee.city!=null) ? getemployee.city+',' : '' ;
                var pAdd = (getemployee.province!=null) ? getemployee.province+',' : '' ;
                var cAdd = (getemployee.country_name!=null) ? getemployee.country_name : '' ;
                var zipCode = (getemployee.zip_code!=null) ? getemployee.zip_code : '';
                var contact = (getemployee.contact_number!=null) ? getemployee.contact_number : '';
                var mobile = (getemployee.mobile_number!=null) ? getemployee.mobile_number : '';
                var civil_status = (getemployee.civil_status!=null) ? getemployee.civil_status.toUpperCase() : '';
                var nationality = (getemployee.nationality!=null) ? getemployee.nationality.toUpperCase() : '';
                var birthPlace = (getemployee.birth_place!=null) ? getemployee.birth_place.toUpperCase() : '';
                var birthday = (getemployee.birthdate!=null) ? getemployee.birthdate : '';

                $("#homeAddress").html("Address: "+ [hAdd, bAdd, ctAdd, pAdd].join(' '));
                $("#homeCountry").html("Country: "+ cAdd);
                $("#homeZipCode").html("ZIP: "+ zipCode);

                $("#employee_id").val(getemployee.employee_id);
                $("#bioId").val(getemployee.biometrics_id);
                $("#position").val(getemployee.position);
                $("#department").val(getemployee.department);

                $("#email").val(getemployee.email);
                $("#contactNumber").val(contact);
                $("#mobileNumber").val(mobile);

                // $("#gender").html("Sex: "+getemployee.gender);
                // $("#civilStatus").html("Civil Status: "+civil_status);
                // $("#nationality").html("Nationality: "+nationality);
                // $("#birthDate").html(birthday);
                $("#gender").val(getemployee.gender);
                $("#civilStatus").val(civil_status);
                $("#nationality").val(nationality);

                $("#birthDate").val(birthday);
                $("#birthPlace").html("Birthplace: "+birthPlace);

                $('#vacationLeaves').html("Vacation Leave : " + (getLeaves.VL ? getLeaves.VL : 0));
                $('#sickLeaves').html("Sick Leave : " + (getLeaves.SL ? getLeaves.SL : 0));
                if (getemployee.gender == 'M') {
                    $('#matpatLeaves').html("Paternity Leave : " + (getLeaves.PL ? getLeaves.PL : 0));
                } else if (getemployee.gender == 'F') {
                    $('#matpatLeaves').html("Maternity Leave : " + (getLeaves.ML ? getLeaves.ML : 0));
                } else {
                    $('#matpatLeaves').html("Parental Leave : " + (getLeaves.ML ? getLeaves.ML : 0));
                }
                $('#emergencyLeaves').html("Emergency Leave : " + (getLeaves.EL ? getLeaves.EL : 0));
                // $('#otherLeaves').html("Other Leaves : " + (getLeaves.others ? getLeaves.others : 0));


                $('#updateEmployee > button').attr('id',getemployee.id);
                $("#EmployeesModal").modal('show');
            }
        });
    });

    $(document).on('change click', '#isHead', async function() {
        ($(this).is(":checked")) ?  $("#updateRoleType").val('ADMIN') : $("#updateRoleType").val('EMPLOYEE') ;
    });

    $(document).on('change', '#updateRoleType', async function() {
        ($(this).val()=='ADMIN' || $(this).val()=='SUPER ADMIN') ? $('#isHead').prop("checked", true) : $('#isHead').prop("checked", false);
    });
                    
   
    /* Button to update Employee details */
    $('#updateEmployee > button').on('click', function() {

        var isHead = 0;
        $("#isHead").is(':checked') ? isHead = 1 : isHead = 0;
        const uD = {
            'id'        : $(this).attr('id'),
            'roleType'  : $("#updateRoleType").val(),
            'is_head'   : isHead,

            'gender'        : $('#gender').val(),
            'civil_status'  : $('#civilStatus').val(),
            'nationality'   : $('#nationality').val(),
            'birthdate'     : $('#birthDate').val(),

            'office'        : $("#office").val(),
            'department'    : $("#department").val(),
            'supervisor'    : $("#supervisor").val(),

            'date_hired'            : $("#date_hired").val(),
            'employment_status'     : $("#employment_status").val(),
            'dateRegularized'       : $("#dateRegularized").val(),
            'update_weekly_schedule': $("#update_weekly_schedule").val(),

            'employee_id'   : $("#employee_id").val(), 
            'bioId'         : $("#bioId").val(), 
            'position'      : $("#position").val(),

            'email'         : $("#email").val(),
            'contact_number': $("#contactNumber").val(),
            'mobile_number' : $("#mobileNumber").val(),

            /*'vl': $('#vacationLeaves').val(),
            'sl':$('#sickLeaves').val(),
            'ml': $('#maternityLeaves').val(),
            'pl': $('#paternityLeaves').val(),
            'el': $('#emergencyLeaves').val(),
            'others':$('#otherLeaves').val(),*/
        };
        // alert(isHead); return false;
        // Swal.fire({ html: JSON.stringify(uD) }); return false;
        // prompt('',JSON.stringify(uD));return false;

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