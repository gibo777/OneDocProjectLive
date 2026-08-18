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

                <div
                    class="px-5 pt-3 sm:p-6 shadow bg-white {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                    {{-- =====================================================
                         EMPLOYEE INFORMATION
                         ===================================================== --}}
                    <div class="row inset-shadow rounded">

                        <div class="col-md-4 pt-1">
                            <x-jet-label for="name" value="{{ __('NAME') }}" class="w-full" />

                            <h6 id="name">
                                {{ join(' ', [
                                    Auth::user()->last_name . ',',
                                    Auth::user()->first_name,
                                    empty(Auth::user()->suffix) ? '' : Auth::user()->suffix . '',
                                    Auth::user()->middle_name,
                                ]) }}
                            </h6>
                        </div>

                        <div class="col-md-2 pt-1">
                            <x-jet-label for="employeeNumber" value="{{ __('EMPLOYEE #') }}" class="w-full" />

                            <h6 id="employeeNumber">
                                {{ Auth::user()->employee_id }}
                            </h6>
                        </div>

                        <div class="col-md-4 pt-1">
                            <x-jet-label for="department" value="{{ __('DEPARTMENT') }}" class="w-full" />

                            <h6 id="department">
                                {{ $department->department }}
                            </h6>

                            <x-jet-input id="hid_dept" name="hid_dept" type="hidden"
                                value="{{ Auth::user()->department }}" />
                        </div>

                        <div class="col-md-2 pt-1">
                            <x-jet-label for="date_applied" value="{{ __('DATE APPLIED') }}" class="w-full" />

                            <h6 id="date_applied">
                                {{ date('m/d/Y') }}
                            </h6>
                        </div>

                    </div>


                    {{-- =====================================================
                         LEAVE TYPE / HALF DAY / DATES
                         ===================================================== --}}
                    <div class="row">

                        {{-- =================================================
                             LEAVE TYPE
                             ================================================= --}}
                        <div class="col-12 col-md-2 p-1">

                            <div class="form-floating">

                                <select name="leaveType" id="leaveType"
                                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="LEAVE TYPE">

                                    <option value=""></option>

                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->leave_type }}">
                                            {{ $leaveType->leave_type_name }}
                                        </option>
                                    @endforeach

                                </select>

                                <label for="leaveType" class="font-weight-bold">
                                    LEAVE TYPE<span class="text-danger"> *</span>
                                </label>

                                <x-jet-input-error for="leaveType" class="mt-2" />

                                <div id="div_others" name="div_others" hidden>
                                    <x-jet-input id="others_leave" name="others_leave" type="text"
                                        class="mt-1 block w-full" placeholder="Specify leave here..." />

                                    <x-jet-input-error for="others_leave" class="mt-2" />
                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             WITH PAY
                             ================================================= --}}
                        <!--
                        <div class="col-md-2 p-1 text-left my-3">
                            {{-- <label class="with-pay hover">{{ __('With Pay?') }}</label>
                            <input id="withPay" name="withPay" type="checkbox" class="hover" disabled />
                            <x-jet-input-error for="withPay" class="mt-2" /> --}}
                        </div>
                        -->


                        {{-- =================================================
                             HALF DAY
                             ================================================= --}}
                        <div class="col-12 col-md-3 p-1 mt-2">

                            <div class="d-flex align-items-center justify-content-start justify-content-md-center">

                                <label for="isHalfDay" class="half-day hover mb-0 mr-2">
                                    {{ __('Halfday?') }}
                                </label>

                                <input id="isHalfDay" name="isHalfDay" type="checkbox" class="hover" />

                            </div>

                            <x-jet-input-error for="isHalfDay" class="mt-2" />

                            <div class="d-flex justify-content-center">

                                <select name="timeDesignator" id="timeDesignator"
                                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="LEAVE TYPE" hidden>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>

                            </div>

                        </div>


                        {{-- =================================================
                             DATES
                             ================================================= --}}
                        <div class="col-12 col-md-7 mt-2">

                            <div class="row align-items-center">

                                {{-- BEGIN DATE --}}
                                <div class="col-12 col-md-4 px-1">

                                    <div class="form-floating">

                                        <x-jet-input id="leaveDateFrom" name="leaveDateFrom" type="date"
                                            class="form-control date-input w-100" placeholder="mm/dd/yyyy"
                                            autocomplete="off" />

                                        {{-- <x-jet-label
                                            for="leaveDateFrom"
                                            value="{{ __('BEGIN DATE') }}"
                                            class="w-full"
                                        /> --}}

                                        <label for="leaveDateFrom" class="font-weight-bold text-secondary w-full">
                                            BEGIN DATE<span class="text-danger"> *</span>
                                        </label>

                                    </div>

                                </div>


                                {{-- TO --}}
                                <div
                                    class="col-12 col-md-1 px-1 d-flex align-items-center justify-content-start justify-content-md-center">
                                    <span>TO</span>
                                </div>


                                {{-- END DATE --}}
                                <div class="col-12 col-md-4 px-1 mt-1 mt-md-0">

                                    <div class="form-floating">

                                        <x-jet-input id="leaveDateTo" name="leaveDateTo" type="date"
                                            class="form-control date-input w-100" placeholder="mm/dd/yyyy"
                                            autocomplete="off" />

                                        {{-- <x-jet-label
                                            for="leaveDateTo"
                                            value="{{ __('END DATE') }}"
                                            class="w-full"
                                        /> --}}

                                        <label for="leaveDateTo" class="font-weight-bold text-secondary w-full">
                                            END DATE<span class="text-danger"> *</span>
                                        </label>

                                    </div>

                                </div>


                                {{-- NUMBER OF DAYS --}}
                                <div class="col-12 col-md-3 px-1 mt-1">
                                    <div class="p-2 w-100 d-flex align-items-center">
                                        <span class="small font-weight-bold text-nowrap"> # OF DAY/S: </span>
                                        <span id="hid_no_days" class="ml-2 flex-grow-1 text-left"></span>
                                    </div>
                                    <x-jet-input id="hid_schedule" name="hid_schedule"
                                        value="{{ Auth::user()->weekly_schedule }}" hidden />
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        REASON / LEAVES CONSUMED
                        ===================================================== --}}
                    <div class="row mt-2">

                        <div class="col-md-9 text-center">

                            <div class="row">

                                {{-- REASON --}}
                                <div class="form-floating col-md-6 p-1">

                                    <textarea id="reason" name="reason" class="form-control block w-full" placeholder="REASON" maxlength="250"></textarea>

                                    <label for="reason" class="font-weight-bold text-secondary text-center w-full">
                                        <h6>
                                            REASON<span class="text-danger"> *</span>
                                        </h6>
                                    </label>

                                    <x-jet-input-error for="reason" class="mt-2" />

                                    <small class="text-muted d-block text-end mt-1">
                                        <span id="reasonCounter">0</span>/250
                                    </small>

                                </div>


                                {{-- LEAVES CONSUMED --}}
                                <div class="form-floating col-md-6 p-1">

                                    <table class="table table-bordered data-table mx-auto text-sm">

                                        <thead>

                                            <tr class="text-center">
                                                <th colspan="5" class="py-1">
                                                    Leaves Consumed
                                                </th>
                                            </tr>

                                            <tr class="text-center bg-faded">
                                                <th class="py-1">VL</th>
                                                <th class="py-1">SL</th>
                                                <th class="py-1">EL</th>
                                                <th class="py-1">ML/PL</th>
                                                <th class="py-1">Other</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr>

                                                @if (empty($leaveCredits))

                                                    @for ($i = 0; $i < 5; $i++)
                                                        <td class="py-1">0.0</td>
                                                    @endfor
                                                @else
                                                    <td class="py-1">
                                                        {{ $leaveCredits->VL }}
                                                    </td>

                                                    <td class="py-1">
                                                        {{ $leaveCredits->SL }}
                                                    </td>

                                                    <td class="py-1">
                                                        {{ $leaveCredits->EL }}
                                                    </td>

                                                    @if (Auth::user()->gender === 'M')
                                                        <td class="py-1">
                                                            {{ $leaveCredits->PL }}
                                                        </td>
                                                    @elseif(Auth::user()->gender === 'F')
                                                        <td class="py-1">
                                                            {{ $leaveCredits->ML }}
                                                        </td>
                                                    @endif

                                                    <td class="py-1">
                                                        {{ $leaveCredits->others }}
                                                    </td>

                                                @endif

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>


                            {{-- =================================================
                                 INSTRUCTIONS
                                 ================================================= --}}
                            <div class="row text-left">

                                <div class="col-md-12 sm:col-span-5 sm:justify-center text-justify">

                                    INSTRUCTIONS:

                                    <h6>

                                        <ol>

                                            <li>
                                                1. Application for leave of absence must be filed at the latest,
                                                three (3) working days prior to the date of leave. &nbsp; In case of
                                                emergency,
                                                it must be filed immediately upon reporting for work.
                                            </li>

                                            <li>
                                                2. Application for sick leave of more than two (2) consecutive days must
                                                be supported by a medical certificate.
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


                        {{-- =================================================
                             STATUS
                             ================================================= --}}
                        <div class="col-md-3">

                            <div class="col-span-5 sm:col-span-1 sm:jusitfy-start">

                                <table class="table table-bordered data-table mx-auto">

                                    <tr>
                                        <th class="text-center" colspan="2">
                                            STATUS
                                        </th>
                                    </tr>

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
                                        <td id="td_as_of">
                                            {{ date('m/d/Y') }}
                                        </td>
                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                         UPLOAD FILE
                         ===================================================== --}}
                    <div class="row">

                        <div id="div_upload" name="div_upload" class="form-floating col-md-4" hidden="true">

                            <x-jet-input id="upload_file" type="file" class="form-control mt-1 block w-full"
                                placeholder="Attach necessary document" />

                            <x-jet-label for="upload_file" value="{{ __('Attach necessary document') }}" />

                            <x-jet-input-error for="name" class="mt-2" />

                        </div>

                    </div>


                    {{-- =====================================================
                         SUBMIT
                         ===================================================== --}}
                    <div class="row">

                        <div
                            class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">

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


    {{-- =========================================================
         HIDDEN / POPUP ELEMENTS
         ========================================================= --}}
    <x-jet-input id="holidates" type="hidden" value="{{ $holidays->implode('date', '|') }}"></x-jet-input>

    <div id="popup">
        <p id="pop_content" class="text-justify px-2"></p>
    </div>

    <div id="error_dialog">
        <p id="error_dialog_content" class="text-justify px-2"></p>
    </div>


    {{-- =========================================================
         SCRIPTS
         ========================================================= --}}
    <script type="text/javascript">
        const curDateLeave = `{{ $department->curDate }}`;
        const empID = `{{ Auth::user()->employee_id }}`;
    </script>

    <script type="text/javascript" src="{{ asset('app-modules/e-forms/eleave-form.js') }}"></script>

</x-app-layout>
