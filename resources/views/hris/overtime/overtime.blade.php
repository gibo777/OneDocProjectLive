<link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">

<x-app-layout>
<style type="text/css">
    th,td {
      text-transform: none !important;
    }
</style>

    <x-slot name="header">
            {{ __('OVERTIME REQUEST FORM') }}
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
                    <div class="col-md-5 pt-1">
                        <x-jet-label for="otName" value="{{ __('NAME') }}" class="w-full" />
                        <h6 id="otName">
                            {{ join(' ',[
                                    Auth::user()->last_name.',',
                                    Auth::user()->first_name,
                                    empty(Auth::user()->suffix) ? '' : Auth::user()->suffix . '',
                                    Auth::user()->middle_name
                                ]) 
                            }}
                        </h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="otEmployeeNumber" value="{{ __('EMPLOYEE #') }}" class="w-full" />
                        <h6 id="otEmployeeNumber">{{ Auth::user()->employee_id }}</h6>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label for="otDateApplied" value="{{ __('DATE APPLIED') }}" class="w-full" />
                        <h6 id="otDateApplied">{{ date('m/d/Y', strtotime($otUser->current_date)) }}</h6>
                    </div>
                </div>

                <div class="row inset-shadow rounded mt-1">
                    <div class="col-md-5 pt-1">
                        <x-jet-label for="otOffice" value="{{ __('OFFICE') }}" class="w-full" />
                        <h6 id="otOffice">{{ $otUser->office }}</h6>
                    </div>
                    <div class="col-md-4 pt-1">
                        <x-jet-label for="otDepartment" value="{{ __('DEPARTMENT') }}" class="w-full" />
                        <h6 id="otDepartment">{{ $otUser->department }}</h6>
                    </div>
                    <div class="col-md-3 pt-1">
                        <x-jet-label for="otSupervisor" value="{{ __('SUPERVISOR') }}" class="w-full" />
                        <h6 id="otSupervisor">{{ $otUser->supervisor }}</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-2 p-0 mr-3">
                        <div class="form-floating">
                            <x-jet-input id="otLocation" type="text" name="otLocation" class="form-control" />
                            <label for="otLocation" class="font-weight-bold w-full">
                                OT LOCATION (Actual Location) <span class="text-danger"> *</span>
                            </label>
                        </div>
                    </div>
                    <div class="row col-md-8">
                        <div class="col-md-6 mt-2 align-center px-3 inset-shadow">
                            <div class="row">
                                <div class="col-md-6 p-0">
                                    <div class="form-floating text-center">
                                        <x-jet-input id="otDateFrom" name="otDateFrom" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                        <label for="otDateFrom" class="font-weight-bold text-secondary">
                                            OT Begin Date<span class="text-danger"> *</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="form-floating text-center">
                                        <x-jet-input id="otTimeFrom" name="otTimeFrom" type="time" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                        <label for="otDateFrom" class="font-weight-bold text-secondary">
                                            OT Begin Time<span class="text-danger"> *</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2 align-center px-3 inset-shadow">
                            <div class="row">
                                <div class="col-md-6 p-0">
                                    <div class="form-floating text-center">
                                        <x-jet-input id="otDateTo" name="otDateTo" type="date" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                        <label for="otDateTo" class="font-weight-bold text-secondary">
                                            OT End Date<span class="text-danger"> *</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="form-floating text-center">
                                        <x-jet-input id="otTimeTo" name="otTimeTo" type="time" class="form-control w-full" placeholder="mm/dd/yyyy" autocomplete="off"/>
                                        <label for="otDateTo" class="font-weight-bold text-secondary">
                                            OT End Time<span class="text-danger"> *</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <x-jet-label id="errorDateRange" class="text-danger"></x-jet-label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-floating text-center w-full p-0 mt-2">
                        <textarea id="otReason" name="otReason" class="form-control block w-full" placeholder="REASON" /></textarea>
                        {{-- <x-jet-label for="reason" value="{{ __('REASON') }}" class="w-full" /> --}}
                        <label for="otReason" class="font-weight-bold text-secondary text-center w-full">
                            <h6>REASON<span class="text-danger"> *</span></h6>
                        </label>
                        <x-jet-input-error for="reason" class="mt-2" />
                    </div>
                    <div class="col-md-6 text-center mt-2">
                        <table class="table table-bordered data-table mx-auto text-center">
                            <tr>
                                <th>Hours</th>
                                <th>Minutes</th>
                                <th>Total Hours</th>
                            </tr>
                            <tr>
                                <td id="thHours">0</td>
                                <td id="thMinutes">0</td>
                                <td id="thTotalHours">0.0</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="flex items-center justify-center px-4 py-3 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button id="submitOvertime" name="submitOvertime" disabled>
                            {{ __('SUBMIT OVERTIME') }}
                        </x-jet-button>

                    </div>
                </div>
            </div>
                
            </form>
            <!-- FORM end -->
        </div>
    </div>

<script type="text/javascript" src="{{ asset('app-modules/e-forms/form-overtime.js') }}"></script>
</x-app-layout>
