
<x-app-layout>
    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
    <style type="text/css">
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataHolidays thead th {
        text-align: center; /* Center-align the header text */
    }
    </style>
    <x-slot name="header">
                {{ __('HOLIDAYS') }}
    </x-slot>
    <div id="view_holidays">
        <div class="max-w-5xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="holiday-form" action="{{ route('hr.management.holidays') }}" method="POST">
            @csrf


            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">

                        <div align="right">
                            <x-jet-button  id="add_holidays" class="btn btn-primary font-semibold text-xl thead">Add Holiday</x-jet-button>
                        </div>
                        <div id="filter_fields" class="grid grid-cols-6 py-1 gap-2">
                            <x-jet-label for="filter_year" id="show_filter_holidays" value="{{ __('FILTER') }}" class="hover hidden"/>
                                <!-- FILTER by YEAR -->

                                <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_months" >
                                    <x-jet-label for="filter_months" value="{{ __('By Month') }}" />
                                    <select name="filter_months" id="filter_months" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                        <option value="" class="text-center" />- All Months -
                                        @foreach ($months as $key => $month)
                                        <option value="{{ str_pad($key+1,2,'0',STR_PAD_LEFT) }}" >
                                        {{ $month }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="col-span-8 sm:col-span-1 hidden" id="div_filter_years" >
                                    <x-jet-label for="filter_years" value="{{ __('By Year') }}" />
                                    <select name="filter_years" id="filter_years" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                        @foreach ($years as $year)
                                            @if ($year==date('Y'))
                                            <option selected>{{ $year }}</option>
                                            @else
                                            <option>{{ $year }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataHolidays" class="view-holidays table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr>
                                                <th>Date</th>
                                                <th>Holiday</th>
                                                <th>Type</th>
                                                <th>Office</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewHolidays">
                                            @foreach($holidays as $holiday)
                                                <tr id="{{ join('|',[$holiday->id,$holiday->date,$holiday->holiday,$holiday->holiday_type,$holiday->holiday_office_id]) }}">
                                                    <td class="text-center">{{ date('m/d/Y  (D)',strtotime($holiday->date)) }}</td>
                                                    <td>{{ strtoupper($holiday->holiday) }}</td>
                                                    <td class="text-center">{{ strtoupper($holiday->holiday_type) }}</td>
                                                    <td class="text-center">{{ strtoupper($holiday->holiday_office) }}</td>
                                                    {{-- <td id="action_buttons" class="text-center"> --}}
                                                        {{-- <button 
                                                            id="edit_holiday-{{ $holiday->id }}" 
                                                            value="{{ join('|',[$holiday->id,$holiday->date,$holiday->holiday,$holiday->holiday_type]) }}" 
                                                            title="Edit {{ $holiday->holiday }}" 
                                                            class="open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover" 
                                                            data-toggle="modal" 
                                                            data-target="#myModal">
                                                            {{ __('EDIT') }}
                                                        </button> --}}
                                                        {{-- <button id="delete-{{ $holiday->id }}" 
                                                            value="{{ $holiday->id }}" 
                                                            title="Delete {{ $holiday->holiday }}" 
                                                            class="fa fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">
                                                            {{ __('Delete') }}
                                                        </button> --}}
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
<div class="modal fade" id="holidayAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-white fs-5" id="myModalLabel"></h4>
        <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <form id="save-holiday-form" method="POST" action="{{ route('hr.management.save-holidays') }}">
        @csrf

            <div class="row">
                <div class="col-md-12">
                    <!-- Holiday Description -->
                    <div class="form-floating  w-full">
                        <x-jet-input id="holiday" name="holiday" type="text" class="form-control mt-1 block w-full" placeholder="Description" autocomplete="off" />
                        <x-jet-label for="holiday" value="{{ __('Description') }}" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <!-- Holiday Date -->
                    <div class="form-floating w-full">
                            <x-jet-input id="holiday_date" name="holiday_date" type="text" class="form-control date-input w-full" placeholder="mm/dd/yyyy" maxlength="10" autocomplete="off" />
                            <x-jet-label for="holiday_date" value="{{ __('Date (mm/dd/yyyy)') }}" />
                            <x-jet-input-error for="holiday_date" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Holiday Category -->
                    <div class="form-floating  w-full">
                        <select name="holiday_category" id="holiday_category" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" placeholder="Category">
                            <option value="" />-- Select Category --
                            <option value="regular" />Regular Holiday
                            <option value="special-nonworking" />Special Non-working Holiday
                            <option value="special-working" />Special Working Holiday
                        </select>
                        <x-jet-label for="holiday_category" value="{{ __('Category') }}" />
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-floating px-1">
                        <select name="holiday_office" id="holiday_office" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block">
                            <option value="" />-- All Offices --
                            @foreach ($holiday_offices as $holiday_office)
                            <option value="{{ $holiday_office->id }}" />{{ $holiday_office->company_name }}
                            @endforeach
                        </select>
                        <x-jet-label for="holiday_offices" value="{{ __('Office') }}" />
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <x-jet-input id="hid_holiday_id" name="hid_holiday_id" type="hidden"/>
                    <x-jet-button type="button" id="save_holiday" name="save_holiday" disabled>{{ __('Save') }} 
                    </x-jet-button>
                    <!-- <button class="btn btn-success">Submit</button> -->
                </div>
            </div>


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


<script type="text/javascript">
$(document).ready(function() {

    $('#dataHolidays').DataTable({
        columnDefs: [
          { width: '140px', targets: [0] }, 
        ],
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
    });

    $(document).on('dblclick','.view-holidays tr',async function(){
        var hS = $(this).attr('id').split('|');
        $("#save_holiday").html('UPDATE');
        $("#save_holiday").attr('disabled',true);
        $("#holiday_date").attr('disabled',true);
        $("input").removeClass('empty');
        $("select").removeClass('empty');
        $("#hid_holiday_id").val(hS[0]);
        $("#holiday").val(hS[2]);
        $("#holiday_date").val(hS[1]);
        $("#holiday_category").val(hS[3]);
        $("#holiday_office").val(hS[4]);
        $("#myModalLabel").html("EDIT HOLIDAY");
        $("#holidayAddModal").modal('show');
    });

    $("#save_holiday").click(function () {
            var url = "", title="";
            if ($(this).html()=="SAVE") {
                url = window.location.origin+'/save-holidays';
                title = "Holiday successfully added!";
            } else {
                url = window.location.origin+'/update-holidays';
                title = "Update successful!";
            }
            // alert(url); return false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: $('#save-holiday-form').serialize(), // prefer use serialize method
                success:function(data){
                    // prompt('',data); return false;
                    // $("#dialog_content").html("HOLIDAY ADDED!");
                    // $("#popup" ).attr('title','NOTIFICATION');
                    $("#holidayAddModal").modal('hide');
                    
                    Swal.fire({
                        icon: "success",
                        title: title,
                    }).then(function() {
                        location.reload();
                    });
                    console.log(data);
                }
            });
        return false;
    });
                    
    /*$("#viewHolidays > tr").on('dblclick', function() {
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
                var imgProfilePhotoLocation = '';
                var dh = data.date_hired.split('-');
                var sched = data.weekly_schedule.split('|');

                $("#update_weekly_schedule").val(sched);
                $("#update_weekly_schedule").multiselect("refresh");

                var hS = $(this).val().split('|');
                $("#save_holiday").html('UPDATE');
                $("#save_holiday").attr('disabled',true);
                $("input").removeClass('empty');
                $("select").removeClass('empty');
                $("#hid_holiday_id").val(hS[0]);
                $("#holiday").val(hS[2]);
                $("#holiday_date").val(hS[1]);
                $("#holiday_category").val(hS[3]);
                $("#myModalLabel").html("EDIT HOLIDAY");
                $("#holidayAddModal").modal('show');
            }
        });
    });*/

});
</script>
</x-app-layout>


<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>



