<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>

    <x-slot name="header">
            {{ __('APPLICATION FOR LEAVE OF ABSENCE') }}
    </x-slot>
    <div>
        <div class="max-w-6xl mx-auto mt-2">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="leave-form" method="POST" action="{{ route('hris.leave.eleave') }}">
            @csrf


            <div class="px-5 pt-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="row inset-shadow rounded">
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="name" value="{{ __('NAME') }}" class="w-full" />
                        <h6 id="name">
                            {{ join(' ',
                                [
                                    Auth::user()->last_name.',',
                                    Auth::user()->first_name,
                                    empty(Auth::user()->suffix) ? '' : Auth::user()->suffix . '',
                                    Auth::user()->middle_name
                                ]) 
                            }}
                        </h6>
                    </div>
                    <div class="col-md-2 pt-1">
                        <x-jet-label for="employeeNumber" value="{{ __('EMPLOYEE #') }}" class="w-full" />
                        <h6 id="employeeNumber">{{ Auth::user()->employee_id }}</h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="w-full" />
                        <h6 id="department">{{ $department->department }}</h6>
                        <x-jet-input id="hid_dept" name="hid_dept" type="hidden" value="{{ Auth::user()->department }}" />
                    </div>
                    <div class="col-md-2 pt-1">
                        <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="w-full" />
                        <h6 id="date_applied">{{ date('m/d/Y') }}</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 p-1">
                        <!--  Leave Type -->
                        <div class="form-floating">
                            <select name="leaveType" id="leaveType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="LEAVE TYPE">
                                <option value=""></option>
                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->leave_type }}">{{ $leaveType->leave_type_name }}</option>
                                    @endforeach
                            </select>
                            {{-- <x-jet-label for="leaveType" value="{{ __('LEAVE TYPE') }}" class="w-full" /> --}}
                            <label for="leaveType" class="font-weight-bold">
                                LEAVE TYPE<span class="text-danger"> *</span>
                            </label>

                            <x-jet-input-error for="leaveType" class="mt-2" />

                            <div id="div_others" name="div_others" hidden="true">
                                <x-jet-input id="others_leave" name="others_leave" type="text" class="mt-1 block w-full" hidden="true" placeholder="Specify leave here..." />
                                <x-jet-input-error for="others_leave" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 text-center my-3">
                            <label class="half-day hover">{{ __('Halfday?') }}</label>
                            <input id="isHalfDay" name="isHalfDay" type="checkbox" class="hover" />
                            <x-jet-input-error for="isHalfDay" class="mt-2" />
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <x-jet-input id="leaveDateFrom" name="leaveDateFrom" type="date" class="form-control date-input" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    {{-- <x-jet-label for="leaveDateFrom" value="{{ __('BEGIN DATE') }}" class="w-full" /> --}}
                                    <label for="leaveDateFrom" class="font-weight-bold text-secondary w-full">
                                        BEGIN DATE<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">TO</div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <x-jet-input id="leaveDateTo" name="leaveDateTo" type="date" class="form-control date-input" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                    {{-- <x-jet-label for="leaveDateTo" value="{{ __('END DATE') }}" class="w-full" /> --}}
                                    <label for="leaveDateTo" class="font-weight-bold text-secondary w-full">
                                        END DATE<span class="text-danger"> *</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Number of Days -->
                                <div class="form-floating" id="div_number_of_days">
                                    <x-jet-input id="hid_no_days" type="text" name="hid_no_days" class="form-control" readonly/>
                                    <x-jet-input id="hid_schedule" name="hid_schedule" value="{{Auth::user()->weekly_schedule }}" hidden/>
                                    <x-jet-label for="number_of_days" value="{{ __('NUMBER OF DAY/S') }}" class="w-full" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Notification of Leave -->
                    <div class="col-md-9 text-center">
                        <div class="row">
                            {{-- <div class="col-md-5 p-1">
                                <x-jet-label value="{{ __('NOTIFICATION OF LEAVE') }}" class="font-semibold text-xl text-gray-800 leading-tight"/>

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="IN PERSON" class="" />IN PERSON &nbsp; &nbsp;

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY SMS" class=""  />BY SMS &nbsp; &nbsp;

                                <x-jet-input id="leave_notification" name="leave_notification[]" type="checkbox" value="BY E-MAIL" class="" />BY E-MAIL
                            </div> --}}

                            <div class="form-floating col-md-6 p-1">
                                <textarea id="reason" name="reason" class="form-control block w-full" placeholder="REASON" /></textarea>
                                {{-- <x-jet-label for="reason" value="{{ __('REASON') }}" class="w-full" /> --}}
                                <label for="reason" class="font-weight-bold text-secondary text-center w-full">
                                    <h6>REASON<span class="text-danger"> *</span></h6>
                                </label>
                                <x-jet-input-error for="reason" class="mt-2" />
                            </div>

                            <div class="form-floating col-md-6 p-1">
                                <table class="table table-bordered data-table mx-auto">
                                    <tr class="text-center">
                                        <th>VL</th>
                                        <th>SL</th>
                                        <th>EL</th>
                                        <th>ML/PL</th>
                                        <th>Other</th>
                                    </tr>
                                    <tr>
                                        @foreach($leave_credits as $leave_balance)
                                        <td>{{ $leave_balance->VL }}</td>
                                        <td>{{ $leave_balance->SL }}</td>
                                        <td>{{ $leave_balance->EL }}</td>
                                        @if(Auth::user()->gender==='M')
                                        <td>{{ $leave_balance->PL }}</td>
                                        @elseif (Auth::user()->gender==='F')
                                        <td>{{ $leave_balance->ML }}</td>
                                        @endif
                                        <td>{{ $leave_balance->others }}</td>
                                        @endforeach
                                    </tr>
                                  </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row text-left">
                            <!-- INSTRUCTIONS -->
                            <div class="col-md-12 sm:col-span-5 sm:justify-center text-justify">
                                INSTRUCTIONS:
                                <h6>
                                <ol>
                                    <li>
                                        1. Application for leave of absence must be filed at the latest, 
                                        three (3) working days prior to the date of leave. &nbsp; In case of emergency,
                                        it must be filed immediately upon reporting for work.
                                    </li>
                                    <li>
                                        2. Application for sick leave of more than two (2) consecutive days must be supported by a medical certificate.
                                    </li>
                                    <li>
                                        3. A Half-day leave should be filed separately.
                                    </li>
                                </ol>
                                <ol>
                                    <li>
                                        <span class="text-danger">*</span> Required field/s
                                    </li>
                                </ol>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">
                                <table class="table table-bordered data-table mx-auto">
                                    <tr><th class="text-center" colspan="2">STATUS</th></tr>
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
                                        <td id="td_balance"></td>
                                    </tr>
                                    <tr>
                                        <th>As of:</th>
                                        <td id="td_as_of">{{ date('m/d/Y') }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Upload File -->
                    <div id="div_upload" name="div_upload" class="form-floating col-md-4" hidden="true">
                        <x-jet-input id="upload_file" type="file" class="form-control mt-1 block w-full" placeholder="Attach necessary document" />
                        <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />

                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>
                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button id="submitLeave" name="submitLeave" disabled>
                            {{ __('SUBMIT LEAVE FORM') }}
                        </x-jet-button>

                    </div>
                </div>
            </div>
                
            </form>
            <!-- FORM end -->
        </div>
    </div>

{{-- PREVIEW MODALS --}}

<div class="modal fade" id="PreviewModal" tabindex="-1" role="dialog" arial-labelledby="modalErrorLabel" data-bs-backdrop="static" data-bs-keyboard="false" >
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-lg" id="modalErrorLabel">LEAVE SUMMARY</h4>
            <button id="truesubmitleave" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
        </div>

        <div class="modal-body bg-gray-50 red-color">
            <x-jet-label id="nameofemp" />
            <x-jet-label id="employeenumofemp" />
            <x-jet-label id="departmentofemp" />
            <x-jet-label id="dateappliedofemp" />
            <x-jet-label id="leavetypeofemp" />
            <x-jet-label id="datecoveredofemp" />
            <x-jet-label id="summary_date_to" />
            <x-jet-label id="notificationofleaveofemp" />
            <x-jet-label id="reasonofemp" />
    </div>
  </div>
</div>
    
<x-jet-input id="holidates" type="hidden" value="{{ $holidays->implode('date', '|') }}"></x-jet-input>
<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="error_dialog">
  <p id="error_dialog_content" class="text-justify px-2"></p>
</div>

<script type="text/javascript" src="{{ asset('/js/modules/eleaves/eleave-form.js') }}"></script>

</x-app-layout>
