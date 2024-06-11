

  <!-- EmployeeModal -->
  <div class="modal fade" id="EmployeesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <!-- <div class="modal-header custom-modal-header banner-blue py-2">
          <h5 class="modal-title text-white fs-5" id="EmployeesModalLabel">EMPLOYEE DETAILS</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> -->
        <div class="modal-body">
            <div class="container">

              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

                <div class="max-w-7xl mx-auto">
                    <div class="">
                        
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            {{-- tab 1 | Personal Data --}}
                            <li class="nav-item" role="presentation">
                                <button id="pills-pd-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-pd" type="button" role="tab" aria-controls="pills-pd" aria-selected="true">
                                Personal Data
                                </button>
                            </li>
                            @if (Auth::user()->id==1)
                            {{-- tab 2 | Accounting Data --}}
                            <li class="nav-item" role="presentation">
                                <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
                                Accounting Data
                                </button>
                            </li>
                            {{-- tab 3 | Family Background --}}
                            <li class="nav-item" role="presentation">
                                <button id="pills-fb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-fb" type="button" role="tab" aria-controls="pills-fb" aria-selected="false">
                                Family Background
                                </button>
                            </li>
                            {{-- tab 4 | Educational Background --}}
                            <li class="nav-item" role="presentation">
                                <button id="pills-eb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eb" type="button" role="tab" aria-controls="pills-eb" aria-selected="false">
                                Educational Background
                                </button>
                            </li>
                            {{-- tab 5 | Employment History --}}
                            <li class="nav-item" role="presentation">
                                <button id="pills-eh-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eh" type="button" role="tab" aria-controls="pills-eh" aria-selected="false">
                                Employment History
                                </button>
                            </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-pd" role="tabpanel" aria-labelledby="pills-pd-tab">
                                <div class="row bg-light">
                                    <div class="col-md-3 my-1 p-2">
                                        <div class="flex justify-center my-1 w-100">
                                            <img id="imgProfile" src="" alt="" class="rounded h-id w-id object-cover">
                                        </div>

                                        <div class="row my-1 mx-3 border-1">
                                            <div id="qrCode" class="flex justify-content-center pt-2"></div>
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
                                        <div class="row my-1 pt-1 inset-shadow">
                                                <div class="col-md-6 px-1">
                                                        <x-jet-label id="fullName" class="w-full text-md" />
                                                </div>
                                        </div>
                                        <div class="row my-1 pt-1 inset-shadow">
                                                <div class="col-md-7 px-1">
                                                        <x-jet-label id="homeAddress" class="w-full text-md" />
                                                </div>
                                                <div class="col-md-3 px-1">
                                                        <x-jet-label id="homeCountry" class="w-full text-md" />
                                                </div>
                                                <div class="col-md-2 px-1">
                                                        <x-jet-label id="homeZipCode" class="w-full text-md" />
                                                </div>
                                        </div>

                                        <div class="row my-1 pt-1 inset-shadow">
                                            <div class="col-md-4 px-1">
                                                    <x-jet-label id="email" class="w-full text-md" />
                                            </div>
                                            <div class="col-md-4 px-1">
                                                    <x-jet-label id="contactNumber" class="w-full text-md" />
                                            </div>
                                            <div class="col-md-4 px-1">
                                                    <x-jet-label for="mobile_number" class="w-full text-md" />
                                            </div>
                                        </div>

                                        <div class="row my-1 pt-1">
                                            <div class="col-md-2 px-1">
                                                    {{-- <x-jet-label id="gender" class="w-full text-md" /> --}}
                                                    <div class="form-floating">
                                                        <select name="gender" id="gender" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                                            <option value=""></option>
                                                            @foreach ($genders as $gender)
                                                            <option value="{{ $gender->sex_code }}">{{ $gender->sex }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-jet-label for="gender" value="{{ __('Sex') }}" class="text-black-50 w-full" />
                                                    </div>
                                            </div>
                                            <div class="col-md-2 px-1">
                                                    {{-- <input id="civilStatus" class="w-full text-md" /> --}}
                                                    <div class="form-floating">
                                                        <select name="civilStatus" id="civilStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                                            <option value=""></option>
                                                            @foreach ($civilStatuses as $civilStatus)
                                                            <option>{{ $civilStatus->civil_status }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-jet-label for="civilStatus" value="{{ __('Civil Status') }}" class="text-black-50 w-full" />
                                                    </div>
                                            </div>
                                            <div class="col-md-2 px-1">
                                                    <div class="form-floating">
                                                        <select name="nationality" id="nationality" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                                            <option value=""></option>
                                                            @foreach ($nationalities as $nationality)
                                                            <option>{{ $nationality->nationality }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-jet-label for="nationality" value="{{ __('Nationality') }}" class="text-black-50 w-full" />
                                                    </div>
                                            </div>
                                            <div class="col-md-2 px-1">
                                                {{-- <x-jet-label id="birthDate" class="w-full text-md" /> --}}
                                                <div class="form-floating">
                                                    <x-jet-input id="birthDate" type="date" class="form-control block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                                    <x-jet-label for="birthDate" value="{{ __('Birthday') }}" class="pl-4 text-black-50 w-full" />
                                                    <x-jet-input-error for="birthDate" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                    <x-jet-label id="birthPlace" class="w-full text-md" />
                                            </div>
                                        </div>


                                        <div class="row my-1 pt-1">
                                            <div class="col-md-3 px-1 my-1">
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
                                            <div class="col-md-5 px-1 my-1">
                                                    <div class="form-floating">
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
                                            <div class="col-md-4 px-1 my-1">
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
                                        </div>


                                        <div class="row my-1 pt-1">
                                            <div class="col-md-3 px-1 my-1">
                                                <div class="form-floating">
                                                    <x-jet-input id="date_hired" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                                    <x-jet-label for="date_hired" value="{{ __('Date Started') }}" class="pl-4 text-black-50 w-full" />
                                                    <x-jet-input-error for="date_hired" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 px-1 my-1">
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
                                            <div class="col-md-3 px-1 my-1">
                                                <div class="form-floating">
                                                    <x-jet-input id="dateRegularized" type="text" class="form-control datepicker block w-full" placeholder="mm/dd/yyyy" autocomplete="off" />
                                                    <x-jet-label for="dateRegularized" value="{{ __('Date Regularized') }}" class="pl-4 text-black-50 w-full" />
                                                    <x-jet-input-error for="dateRegularized" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-left align-items-center w-full nopadding">
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

                                        <div class="row my-1 pt-1">
                                            <div class="col-md-3 form-floating px-1">
                                                    <x-jet-input id="employee_id" type="text" class="form-control block w-full"/>
                                                    <x-jet-label for="employee_id" value="{{ __('Employee ID') }}" class="text-black-50 w-full" />
                                                    <x-jet-input-error for="employee_id" class="mt-2" />
                                            </div>
                                            <div class="col-md-3 form-floating px-1">
                                                    <x-jet-input id="bioId" type="number" class="form-control block w-full" autocomplete="bio_id" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" />
                                                    <x-jet-label for="bioId" value="{{ __('Biometrics ID') }}" class="text-black-50 w-full" />
                                                    <x-jet-input-error for="bioId" class="mt-2" />
                                            </div>
                                            <div class="col-md-6 form-floating px-1">
                                                    <x-jet-input id="position" type="text" class="form-control block w-full" autocomplete="position"/>
                                                    <x-jet-label for="position" value="{{ __('Position') }}" class="text-black-50 w-full" />
                                                    <x-jet-input-error for="position" class="mt-2" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
                                <div class="row pb-5">
                                    <div class="col-md-12">
                                            @if (strpos(Auth::user()->department, 'ACCTG') || Auth::user()->id=1)
                                            <div class="row my-1 pt-1">
                                                <div class="col-md-3 form-floating px-1">
                                                    <x-jet-label id="vacationLeaves"/>
                                                    <x-jet-input-error for="vacationLeaves" class="mt-2" />
                                                </div>
                                                <div class="col-md-3 form-floating px-1">
                                                    <x-jet-label id="sickLeaves"/>
                                                    <x-jet-input-error for="sickLeaves" class="mt-2" />
                                                </div>
                                                <div class="col-md-3 form-floating px-1">
                                                    <x-jet-label id="matpatLeaves"/>
                                                    <x-jet-input-error for="matpatLeaves" class="mt-2" />
                                                </div>
                                                <div class="col-md-3 form-floating px-1">
                                                    <x-jet-label id="emergencyLeaves"/>
                                                    <x-jet-input-error for="emergencyLeaves" class="mt-2" />
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
                                {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.family-background')
                                @endif --}}
                            </div>
                            <div class="tab-pane fade" id="pills-eb" role="tabpanel" aria-labelledby="pills-eb-tab">
                                {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.educational-background')
                                @endif --}}
                            </div>
                            <div class="tab-pane fade" id="pills-eh" role="tabpanel" aria-labelledby="pills-eh-tab">
                                {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.employment-history')
                                @endif --}}
                            </div>

                        </div>
                    </div>
</div>