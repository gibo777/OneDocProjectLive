<div class="mx-3">
    <ul class="nav nav-pills" id="pills-tab" role="tablist">
        <!-- Personal Data Tab -->
        <li class="nav-item" role="presentation">
            <button id="pills-pd-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-pd" type="button" role="tab" aria-controls="pills-pd" aria-selected="true">
                Personal Data
            </button>
        </li>
        @if (Auth::user()->id == 1)
        <!-- Accounting Data Tab -->
        <li class="nav-item" role="presentation">
            <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
                Accounting Data
            </button>
        </li>
        <!-- Family Background Tab -->
        <li class="nav-item" role="presentation">
            <button id="pills-fb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-fb" type="button" role="tab" aria-controls="pills-fb" aria-selected="false">
                Family Background
            </button>
        </li>
        <!-- Educational Background Tab -->
        <li class="nav-item" role="presentation">
            <button id="pills-eb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eb" type="button" role="tab" aria-controls="pills-eb" aria-selected="false">
                Educational Background
            </button>
        </li>
        <!-- Employment History Tab -->
        <li class="nav-item" role="presentation">
            <button id="pills-eh-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eh" type="button" role="tab" aria-controls="pills-eh" aria-selected="false">
                Employment History
            </button>
        </li>
        @endif
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- Personal Data Tab Content -->
        <div class="tab-pane fade show active" id="pills-pd" role="tabpanel" aria-labelledby="pills-pd-tab">
        <form id="fUpdateEmployee" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="row border-1">
                <div class="col-md-3 my-1 p-2">

                    <!-- Profile Photo -->
                    <div x-data="{ photoName: null, photoPreview: null }" class="text-center">
                        <input id="hidden_profile_photo" type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                        " />
                        <!-- Current Profile Photo Preview -->
                        <div id="divPhotoPreview1" class="flex justify-center mt-1 w-100" x-show="!photoPreview">
                            <img id="imgProfile" 
                            src="{{ $profilePhotoPath }}" 
                            alt="" class="rounded-full h-id w-id object-cover">
                        </div>
                        <!-- New Profile Photo Preview -->
                        <div id="divPhotoPreview2" class="flex justify-center mt-1 w-100" x-show="photoPreview" style="display: none;">
                            <span class="block rounded-full w-id h-id bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                        </div>
                        <x-jet-secondary-button id="uploadPhoto" class="mt-1 mr-1 fa fa-upload" type="button" x-on:click.prevent="$refs.photo.click()" data-bs-toggle="tooltip" title="Upload a New Photo"></x-jet-secondary-button>
                        <x-jet-input-error for="photo" class="mt-2" />
                    </div>


                    <!-- QR Code Section -->
                    <div class="row my-1 mx-3 border-1">
					    <div id="qrCodeContainer" class="flex flex-column align-items-center p-2">
					        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(140)->generate(env('APP_URL').'emp-val/'.$getemployee->employee_id)) !!} " alt="QR Code">
					        <a id="downloadLink" href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->margin(5)->generate(env('APP_URL').'emp-val/'.$getemployee->employee_id)) !!} " download="{{ $getemployee->name }}.png" class="mt-2">Download QR Code</a>
					    </div>
					</div>

                    <div class="col-md-12 nopadding my-1">
                        <div class="row">
                            <div class="col-md-7 form-floating">
                                <select name="updateRoleType" id="updateRoleType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value=""></option>
                                    @foreach ($roleTypeUsers as $key=>$roleTypeUser)
                                        <option value="{{ $roleTypeUser->role_type }}" {{ $roleTypeUser->role_type == $getemployee->role_type ? 'selected' : '' }}>
                                        	{{ $roleTypeUser->role_type }}
                                        </option>
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

                <div class="col-md-9 text-left border-1">
                    <!-- Form Fields -->
                    <div class="row my-1 pt-1 ">
                        <div class="col-md-12 px-1">
                            <x-jet-label id="fullName" value="Name: {{ $getemployee->name }}" class="w-full text-md" />
                        </div>
                        <div class="col-md-7 px-1">
                            <x-jet-label id="homeAddress" value="Address: {{ $getemployee->complete_address }}" class="w-full text-md text-wrap" />
                        </div>
                        <div class="col-md-3 px-1">
                            <x-jet-label id="homeCountry" value="Country: {{ $getemployee->country_name }}" class="w-full text-md" />
                        </div>
                        <div class="col-md-2 px-1">
                            <x-jet-label id="homeZipCode" value="Zip Code: {{ $getemployee->zip_code }}" class="w-full text-md" />
                        </div>
                    </div>
                    <div class="row my-1 pt-1">
                        <div class="col-md-6 form-floating px-1">
                            <x-jet-input id="email" value="{{ $getemployee->email }}" type="email" class="form-control block w-full" placeholder="Email" required />
                            <x-jet-label for="email" value="{{ __('Email') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="email" class="mt-2" />
                        </div>
                        <div class="col-md-3 form-floating px-1">
                            <x-jet-input id="contactNumber" value="{{ $getemployee->contact_number }}" type="text" class="form-control block w-full" placeholder="Contact Number" />
                            <x-jet-label for="contactNumber" value="{{ __('Contact Number') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="contactNumber" class="mt-2" />
                        </div>
                        <div class="col-md-3 form-floating px-1">
                            <x-jet-input id="mobileNumber" value="{{ $getemployee->mobile_number }}" type="text" class="form-control block w-full" placeholder="Mobile Number" />
                            <x-jet-label for="mobileNumber" value="{{ __('Mobile Number') }}" class="text-black-50 w-full" />
                            <x-jet-input-error for="mobileNumber" class="mt-2" />
                        </div>
                    </div>
                    <div class="row my-1 pt-1">
                        <div class="col-md-2 px-1">
                            <div class="form-floating">
                                <select name="gender" id="gender" class="form-control">
                                    <option value=""></option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender->sex_code }}" {{ $gender->sex_code==$getemployee->gender ? 'selected' : '' }}>
                                    	{{ $gender->sex }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                            </div>
                        </div>
                        <div class="col-md-2 px-1">
                            <div class="form-floating">
                                <select name="civilStatus" id="civilStatus" class="form-control">
                                    <option value=""></option>
                                    @foreach ($civilStatuses as $civilStatus)
                                    <option {{ $civilStatus->civil_status==$getemployee->civil_status ? 'selected' : '' }}>
                                    	{{ $civilStatus->civil_status }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-jet-label for="civilStatus" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                            </div>
                        </div>
                        <div class="col-md-2 px-1">
                            <div class="form-floating">
                                <select name="nationality" id="nationality" class="form-control">
                                    <option value=""></option>
                                    @foreach ($nationalities as $nationality)
                                    <option {{ $nationality->nationality==$getemployee->nationality ? 'selected' : '' }}>
                                    	{{ $nationality->nationality }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                            </div>
                        </div>
                        <div class="col-md-2 px-1">
                            <div class="form-floating">
                                <x-jet-input id="birthDate" value="{{ $getemployee->birthdate }}" type="date" class="form-control block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                <x-jet-label for="birthDate" value="{{ __('Birthday') }}" class="pl-4 text-black-50 w-full" />
                                <x-jet-input-error for="birthDate" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-floating">
                                <x-jet-input id="placeOfBirth" value="{{ $getemployee->birth_place }}" type="text" class="form-control block w-full" placeholder="Place of Birth" />
                                <x-jet-label for="placeOfBirth" value="{{ __('Place of Birth') }}" class="text-black-50 w-full" />
                                <x-jet-input-error for="placeOfBirth" class="mt-2" />
                            </div>
                        </div>
                    </div>



                        <div class="row my-1 pt-1">
                            <div class="col-md-3 px-1 my-1">
                                    <div class="form-floating">
                                        <select name="office" id="office" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value=""></option>
                                            @foreach ($offices as $office)
                                            <option value="{{ $office->id }}" {{ $office->id==$getemployee->office ? 'selected' : '' }}>
                                            	{{ $office->company_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="office" value="{{ __('Office') }}" class="text-black-50 w-full" />
                                    </div>
                            </div>
                            <div class="col-md-5 px-1 my-1">
                                    <div class="form-floating">
                                        <select name="department" id="department" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                            <option value="{{ $dept->department_code }}" {{ $dept->department_code==$getemployee->department ? 'selected' : '' }}>
                                            	{{ $dept->department }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="department" value="{{ __('Department') }}" class="text-black-50 w-full" />
                                        <x-jet-input-error for="department" class="mt-2" />
                                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                                    </div>
                            </div>
                            <div class="col-md-4 px-1 my-1">
                                    <div class="form-floating">
                                        <select name="supervisor" id="supervisor" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                            <option value=""></option>
                                            @foreach ($heads as $head)
                                            <option value="{{ $head->employee_id }}" {{ $head->employee_id==$getemployee->supervisor ? 'selected' : '' }}>
                                            	{{ $head->head_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-jet-label for="supervisor" value="{{ __('Supervisor') }}" class="text-black-50 w-full" />
                                    </div>
                            </div>
                        </div>



                        <div class="row my-1 pt-1">
                            <div class="col-md-3 px-1 my-1">
                                <div class="form-floating">
                                    <x-jet-input id="date_hired" value="{{ $getemployee->date_hired }}" type="date" class="form-control block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                    <x-jet-label for="date_hired" value="{{ __('Date Started') }}" class="pl-4 text-black-50 w-full" />
                                    <x-jet-input-error for="date_hired" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3 px-1 my-1">
                                <div class="form-floating">
                                    <select name="employment_status" id="employment_status" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" required>
                                        <option value=""></option>
                                        @foreach ($empStatuses as $key=>$empStat)
                                        <option value="{{ $empStat->employment_status }}" {{ $empStat->employment_status==$getemployee->employment_status ? 'selected' : '' }}>
                                        	{{ $empStat->employment_status }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-jet-label for="employment_status" value="{{ __('Employment Status') }}" class="text-black-50 w-full" />
                                </div>
                            </div>
                            <div class="col-md-3 px-1 my-1">
                                <div class="form-floating">
                                    <x-jet-input id="dateRegularized" value="{{ $getemployee->date_regularized }}" type="date" class="form-control block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                    <x-jet-label for="dateRegularized" value="{{ __('Date Regularized') }}" class="pl-4 text-black-50 w-full" />
                                    <x-jet-input-error for="dateRegularized" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3 text-left align-items-center w-full nopadding">
                                <x-jet-label for="weekly_schedule" value="{{ __('Weekly Schedule') }}" class="nopadding"/>
                                <select id="update_weekly_schedule" name="update_weekly_schedule" multiple class="w-full" required>
                                    <option value="0">Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>
                                <input type="hidden" id="hidWeeklySched" value="{{ $getemployee->weekly_schedule }}">
                            </div>
                        </div>

                        <div class="row my-1 pt-1">
                            <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="employee_id" value="{{ $getemployee->employee_id }}" type="text" class="form-control block w-full"/>
                                    <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="employee_id" class="mt-2" />
                            </div>
                            <div class="col-md-3 form-floating px-1">
                                    <x-jet-input id="bioId" value="{{ $getemployee->biometrics_id }}" type="number" class="form-control block w-full" autocomplete="bio_id" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" placeholder="Biometrics ID"/>
                                    <x-jet-label for="bioId" value="{{ __('Biometrics ID') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="bioId" class="mt-2" />
                            </div>
                            <div class="col-md-6 form-floating px-1">
                                    <x-jet-input id="position" value="{{ $getemployee->position }}" type="text" class="form-control block w-full" autocomplete="position"/>
                                    <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                                    <x-jet-input-error for="position" class="mt-2" />
                            </div>
                        </div>

                </div>
            </div>

			<div class="text-center justify-content-center my-2">
			<x-jet-button id="updateEmployee">Update Information</x-jet-button>
			</div>
		</form>
        </div>


        <!-- Additional Tab Contents -->
        @if (Auth::user()->id == 1)
        <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
            <!-- Content for Accounting Data Tab -->
        </div>
        <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
            <!-- Content for Family Background Tab -->
        </div>
        <div class="tab-pane fade" id="pills-eb" role="tabpanel" aria-labelledby="pills-eb-tab">
            <!-- Content for Educational Background Tab -->
        </div>
        <div class="tab-pane fade" id="pills-eh" role="tabpanel" aria-labelledby="pills-eh-tab">
            <!-- Content for Employment History Tab -->
        </div>
        @endif
    </div>


</div>


<!-- Initialize Tooltip -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
