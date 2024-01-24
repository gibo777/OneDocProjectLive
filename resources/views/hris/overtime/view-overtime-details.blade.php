
<link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css') }}">

<script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js') }}"></script>

<!-- <script src="{{ asset('/js/app.js') }}"></script> -->
<script src="{{ asset('/js/hris-jquery.js') }}"></script>

    <div>
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="update-leave-form" method="POST" action="{{ route('hris.leave.view-leave-details') }}">
            @csrf
                               
            @forelse($leaves as $leave)
            <?php 
            $current_date = date('d/m/Y');
            $notif = explode('|',$leave->notification); 
            $inperson = ""; $bysms = ""; $byemail = "";
            for ($n=0; $n < count($notif); $n++) {
                if ($notif[$n]=="IN PERSON") { $inperson = "checked"; }
                if ($notif[$n]=="BY SMS") { $bysms = "checked"; }
                if ($notif[$n]=="BY E-MAIL") { $byemail = "checked"; }
            }
            ?>

            <x-jet-input id="leave_id" type="hidden" value="{{ $leave->id }}"></x-jet-input>

            @if (Auth::user()->access_code==1)
            <!-- HEAD VIEW begin -->
                @if (Auth::user()->department!=1)
                @if ($leave->is_head_approved != 1 && Auth::user()->employee_id != $leave->employee_id)<div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->name }}
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->employee_id }}
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->dept }}
                        </div>

                        <!-- Date Applied -->

                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-label for="date_applied" value="{{ $leave->date_applied }}" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->leave_type }}
                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-1" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->date_from." to ".$leave->date_to }}
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-2" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->no_of_days }}
                        </div>

                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ implode(', ',explode('|',$leave->notification)) }}
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-2">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ $leave->reason }}

                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <table class="table table-bordered data-table mx-auto">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <!-- <x-jet-button id="update_leave" name="update_leave">
                        {{ __('UPDATE') }}
                    </x-jet-button> -->
                    @if (Auth::user()->employee_id != $leave->employee_id)
                    <x-jet-button id="head_approve" name="head_approve">
                        {{ __('HEAD APPROVE') }}
                    </x-jet-button>
                    @endif

                </div>
                @else

                    <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->name }}
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->employee_id }}
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->dept }}
                        </div>

                        <!-- Date Applied -->

                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-label for="date_applied" value="{{ $leave->date_applied }}" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->leave_type }}
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-2">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ $leave->reason }}

                        </div>


                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ implode(', ',explode('|',$leave->notification)) }}
                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-1" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->date_from." to ".$leave->date_to }}
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-2" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->no_of_days }}
                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <table class="table table-bordered data-table mx-auto">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @endif
            <!-- HR VIEW begin -->
            @else
                @if ($leave->employee_id == Auth::user()->employee_id)
                <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $leave->name }}" />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            <x-jet-input id="employee_number" name="employee_number" type="text" class="mt-1 block w-full" wire:model.defer="state.employee_number" value="{{ $leave->employee_id }}" />
                            <x-jet-input-error for="employee_number" class="mt-2" />
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            <select name="department" id="department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    @if ($leave->department == $dept->id) 
                                    <option value="{{ $dept->id }}" selected="selected">{{ $dept->department }}</option>
                                    @else 
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                    @endif
                                @endforeach
                            <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                        </div>

                        <!-- Date Applied -->
                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-input id="date_applied" name="date_applied" type="date" class="mt-1 block w-full" wire:model.defer="state.date_applied" />
                            <x-jet-input-error for="date_applied" class="mt-2" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            <select name="leave_type" id="leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select Leave Type</option>

                                @foreach ($departments as $dept)
                                    @if ($leave->department == $dept->id) 
                                    <option value="VL">Vacation Leave (VL)</option>
                                    <option value="SL">Sick Leave (SL)</option>
                                    <option value="ML">Maternity Leave (ML)</option>
                                    <option value="PL">Paternity Leave (PL)</option>
                                    <option value="EL">Emergency Leave (EL)</option>
                                    <option value="Others">Others</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-jet-input-error for="leave_type" class="mt-2" />
                            <!-- <div id="div_others" name="div_others" hidden="true">
                                <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block w-full" hidden="true" wire:model.defer="state.others_leave" placeholder="Specify leave here..." />
                            <x-jet-input-error for="others_leave" class="mt-2" />
                            </div> -->
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            <textarea id="reason" name="reason" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="state.reason" 
                            > </textarea>
                            <x-jet-input-error for="reason" class="mt-2" />

                        </div>


                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-2 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>
                            @if ($inperson=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />
                            @endif
                            IN PERSON&nbsp; &nbsp;

                            @if ($bysms=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" wire:model.defer="state.leave_notification" />
                            @endif
                            BY SMS &nbsp; &nbsp;

                            @if ($byemail=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" wire:model.defer="state.leave_notification" />
                            @endif
                            BY E-MAIL



                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-2" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                <x-jet-input id="date_from" name="date_from" type="date" class="mx-auto" wire:model.defer="state.date_from" />

                                <label class="font-semibold text-gray-800 leading-tight">TO</label>

                                <x-jet-input id="date_to" name="date_to" type="date" class="mx-auto" wire:model.defer="state.date_to" />
                                <x-jet-input-error for="date_from" class="mt-2" />
                                <x-jet-input-error for="date_to" class="mt-2" />

                                <label for="range_notice" id="range_notice" name="range_notice"/></label>
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-1" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                <label id="number_of_days" class="font-semibold text-xl text-gray-800 leading-tight items-center sm:justify-center"></label>

                                <x-jet-input id="hid_no_days" name="hid_no_days" type="hidden"/>
                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center text-center">
                            <table class="table table-bordered data-table mx-auto">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>


                        <!-- Upload File -->
                        <div id="div_upload" name="div_upload" class="col-span-5 sm:col-span-2" hidden="true">
                            <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />
                            <x-jet-input id="upload_file" type="file" class="mt-1 block w-full"/>
                            <?php  //value="{{ Auth::user()->name }}" ?>

                            <x-jet-input-error for="name" class="mt-2" />
                        </div>


                        <!-- INSTRUCTIONS -->
                        <div class="col-span-5 sm:col-span-4 sm:justify-center">
                            INSTRUCTIONS:
                            <ol>
                                <li>
                                    1. Application for leave of absence must be filed at the latest, 
                                    three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                                    it must be filed immediately upon reporting for work.
                                </li>
                                <li>
                                    2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-button id="leave_employee" name="leave_employee">
                        {{ __('UPDATE') }}
                    </x-jet-button>

                </div>
                @else

                    <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->name }}
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->employee_id }}
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->dept }}
                        </div>

                        <!-- Date Applied -->

                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-label for="date_applied" value="{{ $leave->date_applied }}" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->leave_type }}
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-2">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ $leave->reason }}

                        </div>


                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ implode(', ',explode('|',$leave->notification)) }}
                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-1" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->date_from." to ".$leave->date_to }}
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-2" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->no_of_days }}
                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <table class="table table-bordered data-table mx-auto">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    @if ($leave->is_head_approved==1 && $leave->is_hr_approved!=1)
                    <!-- <x-jet-button id="hr_approve" name="hr_approve">
                        {{ __('HR APPROVE') }}
                    </x-jet-button> -->
                    @endif

                </div>
                @endif

                @endif
<!-- ====================================================================================== -->
            @else
                <!-- EMPLOYEEE PENDING beging -->
                @if ($leave->is_head_approved !=1 && $leave->is_hr_approved != 1)
                <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $leave->name }}" readonly/>
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            <x-jet-input id="employee_number" name="employee_number" type="text" class="mt-1 block w-full" wire:model.defer="state.employee_number" value="{{ $leave->employee_id }}" readonly/>
                            <x-jet-input-error for="employee_number" class="mt-2" />
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            <select name="department" id="department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    @if ($leave->department == $dept->id) 
                                    <option value="{{ $dept->id }}" selected="selected">{{ $dept->department }}</option>
                                    @else 
                                    <option value="{{ $dept->id }}">{{ $dept->department }}</option>
                                    @endif
                                @endforeach
                            <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                        </div>

                        <!-- Date Applied -->
                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-input id="date_applied" name="date_applied" type="text" class="mt-1 block w-full date-input" wire:model.defer="state.date_applied" value="{{ date('m/d/Y') }}" readonly/>
                            <x-jet-input-error for="date_applied" class="mt-2" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            <select name="leave_type" id="leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select Leave Type</option>
                                @foreach ($leave_types as $leave_type)
                                    @if ($leave->leave_type == $leave_type->leave_type) 
                                    <option value="{{ $leave_type->leave_type }}" selected="selected">{{ $leave_type->leave_type_name }}</option>
                                    @else 
                                    <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-jet-input-error for="leave_type" class="mt-2" />
                            @if ($leave->leave_type=="Others")
                                <div id="div_others" name="div_others">
                                <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block w-full" wire:model.defer="state.others_leave"  value="{{ $leave->others }}" />
                            @else
                                <div id="div_others" name="div_others" hidden="true">
                                <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block w-full" wire:model.defer="state.others_leave" placeholder="Specify leave here..." />
                            @endif
                            <x-jet-input-error for="others_leave" class="mt-2" />
                            </div>
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            <textarea id="reason" name="reason" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="state.reason" 
                            > {{ $leave->reason }} </textarea>
                            <x-jet-input-error for="reason" class="mt-2" />

                        </div>


                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-2 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>

                            @if ($inperson=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" wire:model.defer="state.leave_notification" />
                            @endif
                            IN PERSON&nbsp; &nbsp;

                            @if ($bysms=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" wire:model.defer="state.leave_notification" />
                            @endif
                            BY SMS &nbsp; &nbsp;

                            @if ($byemail=="checked")
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" wire:model.defer="state.leave_notification" checked/>
                            @else
                            <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" wire:model.defer="state.leave_notification" />
                            @endif
                            BY E-MAIL
                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-2" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                <x-jet-input id="date_from" name="date_from" type="date" class="mx-auto" wire:model.defer="state.date_from" value="{{$leave->date_from}}"/>

                                <label class="font-semibold text-gray-800 leading-tight">TO</label>

                                <x-jet-input id="date_to" name="date_to" type="date" class="mx-auto" wire:model.defer="state.date_to" value="{{$leave->date_to}}"/>
                                <x-jet-input-error for="date_from" class="mt-2" />
                                <x-jet-input-error for="date_to" class="mt-2" />

                                <label for="range_notice" id="range_notice" name="range_notice"/></label>
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-1" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                <!-- <label id="number_of_days" class="font-semibold text-xl text-gray-800 leading-tight items-center sm:justify-center">{{ $leave->no_of_days}}</label> -->

                                <x-jet-input id="hid_no_days" name="hid_no_days" type="text" value="{{ $leave->no_of_days}}" class="sm-input" readonly/>
                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center text-center">
                            <table class="table table-bordered data-table leave-status-table">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>


                        <!-- Upload File -->
                        <div id="div_upload" name="div_upload" class="col-span-5 sm:col-span-2" hidden="true">
                            <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />
                            <x-jet-input id="upload_file" type="file" class="mt-1 block w-full"/>
                            <?php  //value="{{ Auth::user()->name }}" ?>

                            <x-jet-input-error for="name" class="mt-2" />
                        </div>


                        <!-- INSTRUCTIONS -->
                        <div class="col-span-5 sm:col-span-4 sm:justify-center">
                            INSTRUCTIONS:
                            <ol>
                                <li>
                                    1. Application for leave of absence must be filed at the latest, 
                                    three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                                    it must be filed immediately upon reporting for work.
                                </li>
                                <li>
                                    2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-button id="update_leave" name="update_leave">
                        {{ __('UPDATE') }}
                    </x-jet-button>
                    <!-- <button id="leave_employee" name="leave_employee">{{ __('UPDATE') }}</button> -->
                </div>
                <!-- EMPLOYEE PENDING end -->
                @else
                    <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-5 gap-6">
                        <!-- Name -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->name }}
                        </div>

                        <!-- Employee Number -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="employee_number" value="{{ __('EMPLOYEE #') }}" class="font-semibold text-gray-800 leading-tight"  />
                            {{ $leave->employee_id }}
                        </div>

                        <!-- Department -->
                        <div class="col-span-5 sm:col-span-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->dept }}
                        </div>

                        <!-- Date Applied -->

                        <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="font-semibold text-gray-800 leading-tight" />
                            <x-jet-label for="date_applied" value="{{ $leave->date_applied }}" />
                        </div>

                        <!--  Leave Type -->
                        <div class="col-span-3 sm:col-span-1">
                            <x-jet-label for="leave_type" value="{{ __('LEAVE TYPE') }}" class="font-semibold text-gray-800 leading-tight" />
                            {{ $leave->leave_type }}
                        </div>

                        <!-- Reason for Leave -->
                        <div class="col-span-5 sm:col-span-2">
                            <x-jet-label for="reason" value="{{ __('REASON') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ $leave->reason }}

                        </div>


                        <!-- Notification of Leave -->
                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <x-jet-label for="leave_notification" value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-gray-800 leading-tight"/>
                            {{ implode(', ',explode('|',$leave->notification)) }}
                        </div>

                        <!-- Date Covered -->
                        <div class="col-span-5 sm:col-span-1" id="div_date_covered">
                                <x-jet-label for="date_from" value="{{ __('DATE COVERED') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->date_from." to ".$leave->date_to }}
                        </div>

                        <!-- Number of Days -->
                        <div class="col-span-5 sm:col-span-2" id="div_number_of_days">
                                <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="font-semibold text-gray-800 leading-tight" />
                                {{ $leave->no_of_days }}
                        </div>

                        <div class="col-span-5 sm:col-span-1 sm:justify-center">
                            <table class="table table-bordered data-table mx-auto">
                                <tr><th colspan="2">STATUS</th></tr>
                                <tr class="leave-status-field">
                                  <th>Available</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Taken</th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th>Balance</th>
                                  <td id="leave_balance">{{ $leave->balance}}</td>
                                </tr>
                                <tr>
                                  <th>As of:</th>
                                  <!-- <td id="td_as_of"></td> -->
                                  <td>{{ date('m/d/Y') }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @endif
            <!-- EMPLOYEE VIEWING end -->
            @endif


            @empty
            @endforelse
            </form>

            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>
    

<x-jet-input id="holidates" type="hidden" value="{{ $holidays->implode('date', '|') }}"></x-jet-input>

