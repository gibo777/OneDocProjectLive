
<x-jet-gilbert submit="updateProfileInformation">


    @if (session('status'))
    <div class="alert alert-success">
    {{ session('status') }}
    </div>
    @endif

    <x-slot name="form">
        {{-- ================= --}}

    <div class="col-span-12 sm:col-span-12">
        <div class="row nopadding">
            <div class="col-md-3 mt-3 px-2">
                <!-- Profile Photo -->

                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div x-data="{photoName: null, photoPreview: null}" class="col-md-12 d-block nopadding">
                        
                        <!-- START Profile Photo File Input -->
                        <input id="hidden_profile_photo" type="file" class="hidden"
                                    wire:model="photo"
                                    x-ref="photo"
                                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                    " />

                        <!-- <x-jet-label for="photo" value="{{ __('Photo') }}" /> -->

                        <!-- Current Profile Photo -->
                        <div  id="divPhotoPreview1" class="flex justify-center mt-1 w-100" x-show="! photoPreview">
                            <img id="imgProfile" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-id w-id object-cover">
                        </div>
                        <!-- New Profile Photo Preview -->
                        <div id="divPhotoPreview2" class="flex justify-center mt-1 w-100" x-show="photoPreview" style="display: none;">
                            <!-- <span class="block rounded-full w-id h-id bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"> -->
                            <span class="block rounded-full w-id h-id bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>
                        <div id="divPhotoPreview3" class="hidden">
                            <img src="" id="profilePhotoPreview" class="rounded-full h-id w-id object-cover"/>
                        </div>
                        <!-- END Profile Photo File Input -->

                        <div class="col-span-12 w-full btn">
                            <x-jet-secondary-button id="capturePhoto" class="mt-1 mr-1 fa fa-solid fa-camera" type="button" data-bs-toggle="tooltip" title="Capture Photo" hidden>
                            </x-jet-secondary-button>

                            <x-jet-secondary-button id="uploadPhoto" class="mt-1 mr-1 fa fa-upload" type="button" x-on:click.prevent="$refs.photo.click()" data-bs-toggle="tooltip" title="Upload a New Photo">
                            </x-jet-secondary-button>
                            
                        </div>

                        <?php
                        /*@if ($this->user->profile_photo_path)
                            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                        @endif*/
                        ?>
                        <x-jet-input-error for="photo" class="mt-2" />
                    </div>

                    <!-- EMPLOYEE STATUS -->
                    <div class="col-md-12 nopadding mt-2">
                            <x-jet-label for="employee_status" value="{{ __('Employment Status:') }}" class="text-left nopadding" />
                            <x-jet-input id="employee_status" type="text" class="border-0 shadow-none text-capitalize w-full" wire:model="state.employment_status" disabled />
                    </div>
                    <!-- DATE HIRED -->
                    <div class="col-md-12 nopadding my-2">
                            <x-jet-label for="date_hired" value="{{ __('Date Started:') }}" class="text-left nopadding" />
                            <x-jet-input id="date_hired" type="text" class="border-0 shadow-none w-full" wire:model="state.date_hired" disabled />
                    </div>

                    <div class="col-md-12 nopadding w-full sm:justify-center">
                        <x-jet-button id="PDS" name="PDS">
                            {{-- {{ __('Print Personal Data Sheet') }} --}}
                            {{ __('Export to PDF') }}
                        </x-jet-button>
                    </div>
                @endif
                <!-- <div class="row">
                    <div class="col-md-12 nopadding">
                            <x-jet-label for="employee_status" value="{{ __('Status:') }}" class="text-left" />
                            <x-jet-input id="employee_status" type="text" class="border-0 text-capitalize" wire:model="state.status" disabled />
                    </div>
                </div> -->
                <!-- <div class="row">
                    <div class="col-md-12 nopadding">
                            <x-jet-label for="date_hired" value="{{ __('Date Hired:') }}" class="text-left" />
                            <x-jet-input id="date_hired" type="text" class="border-0" wire:model="state.date_hired" disabled />
                    </div>
                </div> -->
            </div>

            <div class="col-md-9 text-center">
                <div class="row my-1">
                    <div class="col-md-4 px-1">
                        <div class="form-floating">
                            <x-jet-input id="last_name" type="text" class="form-control all-caps block w-full" wire:model="state.last_name" placeholder="Last Name" autocomplete="last_name" require/>
                            <x-jet-label for="last_name" value="{{ __('Last Name') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="last_name" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4 form-floating px-1">
                            <x-jet-input id="first_name" type="text" class="form-control all-caps block w-full" wire:model="state.first_name" placeholder="First Name" autocomplete="first_name" require/>
                            <x-jet-label for="first_name" value="{{ __('First Name') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="first_name" class="mt-2" />
                    </div>
                    <div class="col-md-3 form-floating px-1">
                            <x-jet-input id="middle_name" type="text" class="form-control all-caps block w-full" wire:model="state.middle_name" placeholder="Middle Name" autocomplete="middle_name" />
                            <x-jet-label for="middle_name" value="{{ __('Middle Name') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="middle_name" class="mt-2" />
                    </div>
                    <div class="col-md-1 form-floating px-1">
                            <x-jet-input id="suffix" type="text" class="form-control all-caps block w-full" wire:model="state.suffix" placeholder="Ext." autocomplete="suffix" />
                            <x-jet-label for="suffix" value="{{ __('Ext.') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="suffix" class="mt-2" />
                    </div>
                </div>

                <div class="row pt-1">
                    <div class="col-md-4 form-floating px-1">
                        <!-- Employee ID -->
                            <x-jet-input id="employee_id" type="text" class="form-control block w-full" wire:model="state.employee_id" placeholder="Employee ID" readonly/>
                            <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="employee_id" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">
                            <x-jet-input id="position" type="text" class="form-control all-caps block w-full" wire:model="state.position" placeholder="Position" autocomplete="position" readonly/>
                            <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="position" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">

                            <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" disabled>
                                <option value="">Select Department</option>
                                @foreach($departments as $key=>$department)
                                    @if (Auth::user()->department==$department->department_code)
                                    <option value="{{ $department->department_code }}" selected>{{$department->department}}</option>
                                    @else
                                    <option value="{{ $department->department_code }}">{{$department->department}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="department" class="mt-2" />
                            <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-4 form-floating px-1">
                                <select id="country" name="country" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" 
                                wire:model="state.country"
                                wire:change="provinces($event.target.value)"
                                required>
                                    <option value="">-Select Country-</option>
                                    @foreach ($countries as $key=>$country)
                                    <option value="{{ $country->country_code }}" >{{ $country->country }} </option>
                                    @endforeach
                                </select>
                                <x-jet-label for="country" value="{{ __('Country') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="country" class="mt-2" />
                    </div>

                    <div class="col-md-4 form-floating px-1">
                                <select id="province" name="province" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" 
                                wire:model="state.province"
                                wire:change="cities($event.target.value)" 
                                required>
                                    <option value="">-Select Province-</option>
                                    @if ($provinces)
                                    @foreach ($provinces as $key=>$province)
                                    <option value="{{ $province->province }}">{{ $province->province }} </option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-jet-label for="province" value="{{ __('Province') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="province" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">
                                <select id="municipality" name="municipality" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" 
                                wire:model="state.city" 
                                wire:change="barangays($event.target.value)" 
                                required>
                                    <option value="">-Select City/Municipality-</option>
                                    @if ($cities)
                                    @foreach ($cities as $key=>$city)
                                    <option value="{{ $city->municipality }}" >{{ $city->municipality }} </option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-jet-label for="municipality" value="{{ __('City/Municipality') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="municipality" class="mt-2" />
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-4 form-floating px-1">
                                <select id="barangay" name="barangay" placeholder="Search" style="width: 100%;" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" 
                                wire:model="state.barangay" 
                                wire:change="zipCode($event.target.value)"
                                required>
                                    <option value="">-Select Barangay-</option>
                                    @if ($barangays)
                                    @foreach ($barangays as $key=>$barangay)
                                    <option value="{{ $barangay->barangay }}" >{{ $barangay->barangay }} </option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-jet-label for="barangay" value="{{ __('Barangay') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="barangay" class="mt-2" />
                    </div>
                    <div class="col-md-6 form-floating px-1">
                            <x-jet-input id="home_address" type="text" class="form-control all-caps block w-full" 
                            wire:model="state.home_address" 
                            placeholder="House No./Street" autocomplete="off"/>
                            <x-jet-label for="home_address" value="{{ __('House No./Street') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="home_address" class="mt-2" />
                    </div>
                    <div class="col-md-2 form-floating px-1">

                                   {{--  wire:model="photo"
                                    x-ref="photo"
                                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]); --}}

                            <x-jet-input id="zip_code" type="text" 
                            class="form-control block w-full" 
                            placeholder="Zip Code" 
                            wire:model="state.zip_code"
                            autocomplete="off" readonly/>
                            
                            <x-jet-label for="zip_code" value="{{ __('Zip Code') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="zip_code" class="mt-2" />
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-4 form-floating px-1">
                        <!-- Email -->
                            <x-jet-input id="email" type="email" class="form-control block w-full" wire:model.defer="state.email" placeholder="Email" readonly />
                            <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="email" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">
                            <x-jet-input id="contact_number" type="text" class="form-control block w-full" wire:model.defer="state.contact_number" placeholder="Contact Number" autocomplete="off" required/>
                            <x-jet-label for="contact_number" value="{{ __('Contact Number') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="contact_number" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">
                            <x-jet-input id="mobile_number" type="text" class="form-control block w-full" wire:model.defer="state.mobile_number" placeholder="Mobile Number" autocomplete="off" />
                            <x-jet-label for="mobile_number" value="{{ __('Mobile Number') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="mobile_number" class="mt-2" />
                    </div>
                </div>

                <div class="row pt-2">
                    {{-- <div class="col-md-3 form-floating px-1">
                            <x-jet-input id="height" type="text" class="form-control block w-full" wire:model.defer="state.height" placeholder="Height" autocomplete="off" />
                            <x-jet-label for="height" value="{{ __('Height') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="height" class="mt-2" />
                    </div>
                    <div class="col-md-3 form-floating px-1">
                            <x-jet-input id="weight" type="text" class="form-control block w-full" wire:model.defer="state.weight" placeholder="Weight" autocomplete="off" />
                            <x-jet-label for="weight" value="{{ __('Weight') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="weight" class="mt-2" />
                    </div> --}}
                    <div class="col-md-2 form-floating px-1">
                            <select name="gender" id="gender" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" wire:model.defer="state.gender" required>
                                <option value="">-Sex-</option>
                                @foreach ($genders as $key=>$gender)
                                    {{-- @if (Auth::user()->department==$department->department_code)
                                    <option value="{{ $gender->sex_code }}" selected>{{ $gender->sex }} </option>
                                    @else --}}
                                    <option value="{{ $gender->sex_code }}" >{{ $gender->sex }} </option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>
                            <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="gender" class="mt-2" />
                    </div>
                    <div class="col-md-2 form-floating px-1">
                            <select name="civil_status" id="civil_status" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" wire:model.defer="state.civil_status" required>
                                <option value="">-Civil Status-</option>
                                @foreach ($civilStatuses as $key=>$civilStatus)
                                    {{-- @if (Auth::user()->department==$department->department_code)
                                    <option value="{{ $gender->sex_code }}" selected>{{ $gender->sex }} </option>
                                    @else --}}
                                    <option value="{{ $civilStatus->civil_status }}" >{{ $civilStatus->civil_status }} </option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>


                            <x-jet-label for="civil_status" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="civil_status" class="mt-2" />
                    </div>
                {{-- </div>

                <div class="row pt-2"> --}}
                    <div class="col-md-2 form-floating px-1">
                            <select name="nationality" id="nationality" wire:model.defer="state.nationality" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option value="">-Nationality-</option>
                                @foreach ($nationalities as $key=>$nationality)
                                <option value="{{ $nationality->nationality }}" >{{ $nationality->nationality }} </option>
                                @endforeach
                            </select>
                            <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="nationality" class="mt-2" />
                    </div>
                    {{-- <div class="col-md-3 form-floating px-1">
                            <select name="religion" id="religion" wire:model.defer="state.religion" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option value="">-Religion-</option>
                                @foreach ($religions as $key=>$religion)
                                <option value="{{ $religion->religion_name }}" >{{ $religion->religion_name }} </option>
                                @endforeach
                            </select>
                            <x-jet-label for="religion" value="{{ __('Religion') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="religion" class="mt-2" />
                    </div> --}}
                    <div class="col-md-2 form-floating px-1">
                        <input type="text" name="taskduedate" id="taskduedate" 
                        class="form-control datepicker"
                        wire:model="state.birthdate" 
                        placeholder="Birthdate" 
                        onchange="Livewire.emit('setDate',this.value)"
                        data-provide="datepicker" 
                        data-date-autoclose="true" 
                        data-date-today-highlight="true" 
                        autocomplete="off">
                            {{-- <x-jet-input id="birthdate" type="date" class="form-control block w-full" 
                            wire:model="state.birthdate" 
                            placeholder="mm/dd/yyyy" 
                            autocomplete="off" /> --}}
                            <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="birthdate" class="mt-2" />
                    </div>
                    <div class="col-md-4 form-floating px-1">
                            <x-jet-input id="birth_place" type="text" class="form-control all-caps block w-full" wire:model.defer="state.birth_place" placeholder="Birth Place" autocomplete="off" />
                            <x-jet-label for="birth_place" value="{{ __('Birth Place') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="birth_place" class="mt-2" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="enabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>


</x-jet-gilbert>

<!-- =========================================== -->
<!-- Modal for webCam Capture photo -->
<div class="modal fade" id="modalWebCam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document" style="width:1100px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"></h4>
        <button id="closeWebCamModal" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <!-- content -->



    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
    {{-- <script src="{{ asset('js/webcam.js') }}"></script> --}}


<div class="container">
     
    <form id="formWebCam">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <input type="hidden" name="image" class="image-tag text-center rounded-md">
            </div>
            <div class="col-md-6 text-center">
                <div id="results" class="hidden rounded-md"></div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-md-12 text-center">
                <input type="button" value="Take Snapshot" onClick="take_snapshot()" class="btn btn-primary ">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <x-jet-button id="saveTempPhoto">{{ __('Ok') }} 
                </x-jet-button>
                <!-- <button class="btn btn-success">Submit</button> -->
            </div>
        </div>

    </form>
</div>


<script language="JavaScript">
    $("#capturePhoto").click(function() {

        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#my_camera' );

    });
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            $('#results').removeClass('hidden');
            // alert(data_uri); return false;
                // $("#modalWebCam").modal("hide");
            $('#results').html('<img id="capturedPhoto" src="'+data_uri+'"/>');
        } );
    }

    $("#closeWebCamModal").click(function() {
        // alert('RNG u');
        Webcam.reset( '#my_camera' );
    });

    /**
    * This will capture temporary photo using webcam
    */
    $("#saveTempPhoto").click(function() {

        var data_uri = $("#capturedPhoto").attr("src");
        Webcam.reset( '#my_camera' );
        // console.log($('#hidden_profile_photo')[0].files);
        // $("#divPhotoPreview1").addClass("hidden");
        // $("#divPhotoPreview2").addClass("hidden");
        // $("#divPhotoPreview3").removeClass("hidden");
        // $("#modalWebCam").modal("hide");
        // $("#profilePhotoPreview").attr("src",data_uri);

        $('#divPhotoPreview1').addClass('hidden');
        $('#divPhotoPreview2').empty();
        $('#divPhotoPreview2').css('display','flex');
        $('#divPhotoPreview2').append('<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url('+data_uri+')"></span>');
        // alert("{{ route('webcam.capture') }}"); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('webcam.capture') }}",
            method: 'post',
            data: $("#formWebCam").serialize(),
            success:function(data){
                $("#modalWebCam").modal("hide");
                // alert(data); return false;
                Webcam.reset( '#my_camera' );
                $("#divPhotoPreview1").addClass("hidden");
                $("#divPhotoPreview2").addClass("hidden");
                $("#divPhotoPreview3").removeClass("hidden");
                $("#profilePhotoPreview").attr("src",data);

                // $("#modalWebCam").modal("show");

            }
        });
        return false;
    });
    
    $("#hidden_profile_photo").change(function() {
        console.log( $("#hidden_profile_photo")[0].files)
        $('#divPhotoPreview1').removeClass('hidden');
        $('#divPhotoPreview2').removeClass('hidden');
        $('#divPhotoPreview3').addClass('hidden');
    });


    document.getElementById("PDS").onclick = function(){

        Swal.fire({
          title: 'EXPORT TO PDF',
          text: 'Do you want to export your profile to pdf?',
          // icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Export',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            var $test = document.getElementById('employee_id').value;
            location.href = "/user/profile/pds/"+$test;
            Swal.fire({
              title: 'Succesfully Exported',
              // text: 'The form has been successfully submitted!',
              icon: 'success',
              timer: 3000,
            });
          } /*else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'The form submission has been cancelled.', 'error');
          }*/
        });
        
    }
</script>





      </div>
    </div>
  </div>
</div>
<!-- =========================================== -->