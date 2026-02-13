<x-slot name="header">
    @if (Auth::user()->is_head == 1)
        @if (Auth::user()->department == '1D-HR' || Auth::user()->id == 1)
            {{ __('VIEW ALL LEAVES (HR/ADMIN VIEW)') }}
        @else
            {{ __('VIEW ALL LEAVES (HEAD VIEW)') }}
        @endif
    @else
        {{ __('VIEW ALL LEAVES') }}
    @endif
</x-slot>


<div id="view_leaves">
    <div class="w-full {{ Auth::user()->id == 1 ? 'px-0 mx-0' : 'my-1 sm:px-6 lg:px-8' }}">
        <!-- FORM start -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div
            class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

            {{-- FILTERS AND FORM BUTTON - START --}}
            <div class="container-fluid">
                <div class="row g-2 pb-2 px-1 align-items-end inset-shadow">

                    <!-- Office -->
                    <div class="col-12 col-md-2 px-1">
                        <div class="form-floating w-100">
                            <select wire:model="fTLOffice" id="fTLOffice" class="form-select w-100">
                                <option value="">All Offices</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                @endforeach
                            </select>
                            <label for="fTLOffice">{{ __('OFFICE') }}</label>
                        </div>
                    </div>

                    <!-- Department -->
                    <div class="col-12 col-md-2 px-1">
                        <div class="form-floating w-100">
                            <select wire:model="fTLDept" id="fTLDept" class="form-select w-100">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_code }}">
                                        {{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="fTLDept">{{ __('DEPARTMENT') }}</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 px-1">
                        <div class="row g-0">
                            <div class="col-6 pe-1">
                                <div class="form-floating w-100">
                                    <select wire:model="fLType" id="fLType" class="form-select w-100">
                                        <option value="">All Types</option>
                                        @foreach ($lTypes as $type)
                                            <option value="{{ $type->leave_type }}">
                                                {{ $type->leave_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="fLType">{{ __('TYPE') }}</label>
                                </div>
                            </div>

                            <div class="col-6 ps-1">
                                <div class="form-floating w-100">
                                    <select wire:model="fLStatus" id="fLStatus" class="form-select w-100">
                                        <option value="">All Statuses</option>
                                        @foreach ($lStatus as $status)
                                            <option>{{ $status->request_status }}</option>
                                        @endforeach
                                    </select>
                                    <label for="fLStatus">{{ __('STATUS') }}</label>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Search Dates -->
                    <div class="col-12 col-md-3 px-1">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center mb-1 fw-bold text-sm">
                                <label class="form-label mb-0">{{ __('Search Dates') }}</label>
                                <span id="clearFilter" wire:click="clearDateFilters" class="text-primary"
                                    style="cursor:pointer;">
                                    {{ __('Clear Date Filter') }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center">
                                <x-jet-input wire:model.debounce.500ms="fLdtFrom" type="date" id="fLdtFrom"
                                    class="form-control form-control-sm me-1 w-100" />

                                <span class="mx-1">to</span>

                                <x-jet-input wire:model.debounce.500ms="fLdtTo" type="date" id="fLdtTo"
                                    class="form-control form-control-sm ms-1 w-100" />
                            </div>
                        </div>
                    </div>

                    <!-- File Leave Button -->
                    <div class="col-12 col-md-2 text-center px-1">
                        <x-jet-button id="createNewLeave" class="w-100">
                            <i class="fa-solid fa-sheet-plastic"></i>&nbsp;File a Leave
                        </x-jet-button>
                    </div>

                </div>
            </div>
            {{-- FILTERS AND FORM BUTTON - END --}}

            <div id="table_data">
                <div class="row">
                    <div class="col-md-8 text-sm">
                        <div class="form-inline mt-1">
                            <label for="pageSize" class="mr-2">Show:</label>
                            <select wire:model="pageSize" id="pageSize"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="mx-2">entries</span>
                            <div class=" sm:col-span-7 sm:justify-center scrollable">
                                {{ $leaves->links('pagination.custom') }}
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->role_type == 'SUPER ADMIN' || Auth::user()->role_type == 'ADMIN')
                        <div class="col-md-4">
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2 px-0 text-center">
                                    @if (Auth::user()->id == 1 || Auth::user()->id == 8 || Auth::user()->id == 18 || Auth::user()->id == 58)
                                        <div
                                            class="form-group btn btn-outline-success d-inline-block shadow-sm px-1 rounded capitalize hover px-3">
                                            <i class="fas fa-table"></i>
                                            <span id="exportExcelLeaves" class="font-weight-bold">Export Excel</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="row col-md-8 my-2">
                                    <div class="col-md-2 text-left">
                                        <x-jet-label for="search" value="{{ __('Search') }}"
                                            class="my-0 pt-1 text-sm" />
                                    </div>
                                    <div class="col-md-10">
                                        <x-jet-input wire:model.debounce.300ms="search" type="text" id="search"
                                            name="search" class="w-full" placeholder="Name/Employee ID/ Control Number"
                                            title="Name/Employee #/ Control #">
                                        </x-jet-input>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                </div>
                <!-- Table -->
                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">

                    <table id="dataTimeLogs"
                        class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                        <thead class="thead">
                            <tr class="dt-head-center">
                                <th class="py-1">Name</th>
                                {{-- <th style="width: 8%">Emp. ID</th> --}}
                                <th class="py-1">Office</th>
                                <th class="py-1" style="width: 16%">Department</th>
                                <th class="py-1" style="width: 12%">Control#</th>
                                <th class="py-1" style="width: 8%">Type</th>
                                <th class="py-1" style="width: 16%">Date Covered</th>
                                {{-- <th class="py-1" style="width: 8%">Utilized</th> --}}
                                <th class="py-1" style="width: 7%">Day/s</th>
                                <th class="py-1">Approver</th>
                                <th class="py-1">Status</th>
                            </tr>
                        </thead>
                        <tbody class="data hover custom-text-xs" id="viewEmployee">
                            @if ($leaves->isNotEmpty())
                                @foreach ($leaves as $record)
                                    <tr id="{{ $record->id }}" class="view-leave">
                                        {{-- @if (url('/') == 'http://localhost')
                                            <td>xxx, xxx x.</td>
                                        @else --}}
                                        <td>{{ $record->full_name }}</td>
                                        {{-- @endif --}}
                                        {{-- <td>{{ $record->employee_id }}</td> --}}
                                        <td>{{ $record->office }}</td>
                                        <td>{{ $record->department }}</td>
                                        <td>{{ $record->control_number }}</td>
                                        <td>{{ $record->leave_type }}</td>
                                        <td>{{ $record->date_from ? date('m/d/Y', strtotime($record->date_from)) : '' }}
                                            - {{ $record->date_to ? date('m/d/Y', strtotime($record->date_to)) : '' }}
                                        </td>
                                        {{-- <td></td> --}}
                                        <td>{{ $record->no_of_days }}
                                            @if ($record->time_designator != null || $record->time_designator != '')
                                                {{ ' (' . $record->time_designator . ')' }}
                                            @endif
                                        </td>
                                        @if (url('/') == 'http://localhost')
                                            <td>xxx, xxx x.</td>
                                        @else
                                            <td>
                                                @if ($record->approver1)
                                                    {{ $record->approver1 }}
                                                    @if ($record->approver2)
                                                        {{ ' / ' . $record->approver2 }}
                                                    @endif
                                                @endif
                                            </td>
                                        @endif

                                        @if (strtolower($record->status) == 'pending')
                                            <td>{{ $record->status }}</td>
                                        @else
                                            <td value="{{ Auth::user()->id == 1 ? $record->id : '' }}"
                                                class="{{ $record->status != 'Pending' ? ($record->status == 'Cancelled' || $record->status == 'Denied' || $record->status == 'Expired' ? 'red-color' : 'green-color') : '' }} items-center text-sm font-medium text-gray-500 {{ Auth::user()->id == 1 ? 'open_leave' : '' }}">
                                                {{ $record->status }}
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                            @else
                                <td colspan="10">No Matching Records Found</td>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center text-sm">
                        <div class="form-inline">
                            <label for="pageSize" class="mr-2">Show:</label>
                            <select wire:model="pageSize" id="pageSize"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="mx-2">entries</span>
                            {{ $leaves->links('pagination.custom') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Loading Indicator -->
{{-- <div id="dataLoad" style="display: none">
    <img src="{{ asset('/img/misc/loading-blue-circle.gif') }}">
</div> --}}

<!-- =========================================== -->
<script type="text/javascript">
    const uID = `{{ Auth::user()->id }}`;
    const lReq = `{{ route('hris.leave.eleave') }}`;
</script>
<script type="text/javascript" src="{{ asset('app-modules/e-forms/leaves-application.js') }}"></script>
