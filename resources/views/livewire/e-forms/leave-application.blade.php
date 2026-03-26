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
                    <div class="col-6 col-md-2 px-1">
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
                    <div class="col-6 col-md-2 px-1">
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

                    <!-- Type -->
                    <div class="col-6 col-md-2 px-1">
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

                    <!-- Status -->
                    <div class="col-6 col-md-2 px-1">
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

                    <!-- Search Dates -->
                    <div class="col-12 col-md-4 px-1">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center mb-1 fw-bold text-sm">
                                <label class="form-label mb-0 text-sm">{{ __('Search Dates') }}</label>
                                <span wire:click="clearDateFilters" class="text-primary text-sm"
                                    style="cursor:pointer;">
                                    {{ __('Clear Date Filter') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <x-jet-input wire:model.debounce.500ms="fLdtFrom" type="date" id="fLdtFrom"
                                    class="form-control form-control-sm w-100" />
                                <span class="text-sm text-muted mx-1">to</span>
                                <x-jet-input wire:model.debounce.500ms="fLdtTo" type="date" id="fLdtTo"
                                    class="form-control form-control-sm w-100" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- FILTERS AND FORM BUTTON - END --}}

            <div id="table_data">

                <!-- Table Controls Row -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2">

                    <!-- Left: Show entries + Pagination -->
                    <div class="d-flex align-items-center gap-2 text-sm flex-wrap">
                        <label for="pageSize" class="mb-0 text-sm">Show:</label>
                        <select wire:model="pageSize" id="pageSize"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-sm">entries</span>
                        <div>{{ $leaves->links('pagination.custom') }}</div>
                    </div>

                    <!-- Right: Export + Search + File Leave Button -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">

                        @if (Auth::user()->role_type == 'SUPER ADMIN' || Auth::user()->role_type == 'ADMIN')
                            @if (Auth::user()->id == 1 || Auth::user()->id == 8 || Auth::user()->id == 18 || Auth::user()->id == 58)
                                <div id="exportExcelLeaves"
                                    class="btn btn-outline-success btn-sm d-inline-flex align-items-center gap-1 px-3 shadow-sm">
                                    <i class="fas fa-table"></i>
                                    <span class="font-weight-bold">Export Excel</span>
                                </div>
                            @endif

                            <div class="d-flex align-items-center gap-1">
                                <x-jet-label for="search" value="{{ __('Search:') }}"
                                    class="mb-0 text-sm text-nowrap" />
                                <x-jet-input wire:model.debounce.300ms="search" type="text" id="search"
                                    name="search" class="form-control form-control-sm" style="width: 220px;"
                                    placeholder="Name / Employee ID / Control #" title="Name/Employee #/ Control #" />
                            </div>
                        @endif

                        <x-jet-button id="createNewLeave" class="btn-sm d-inline-flex align-items-center gap-1">
                            <i class="fa-solid fa-sheet-plastic"></i>
                            <span>File a Leave</span>
                        </x-jet-button>

                    </div>
                </div>

                <!-- Table -->
                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable mt-2">
                    <table id="dataTimeLogs"
                        class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                        <thead class="thead">
                            <tr class="dt-head-center">
                                <th class="py-1">Name</th>
                                <th class="py-1">Office</th>
                                <th class="py-1" style="width: 16%">Department</th>
                                <th class="py-1" style="width: 12%">Control#</th>
                                <th class="py-1" style="width: 8%">Type</th>
                                <th class="py-1" style="width: 16%">Date Covered</th>
                                <th class="py-1" style="width: 7%">Day/s</th>
                                <th class="py-1">Approver</th>
                                <th class="py-1">Status</th>
                            </tr>
                        </thead>
                        <tbody class="data hover custom-text-xs" id="viewEmployee">
                            @if ($leaves->isNotEmpty())
                                @foreach ($leaves as $record)
                                    <tr id="{{ $record->id }}" class="view-leave">
                                        <td>{{ $record->full_name }}</td>
                                        <td>{{ $record->office }}</td>
                                        <td>{{ $record->department }}</td>
                                        <td>{{ $record->control_number }}</td>
                                        <td>{{ $record->leave_type }}</td>
                                        <td>
                                            {{ $record->date_from ? date('m/d/Y', strtotime($record->date_from)) : '' }}
                                            -
                                            {{ $record->date_to ? date('m/d/Y', strtotime($record->date_to)) : '' }}
                                        </td>
                                        <td>
                                            {{ $record->no_of_days }}
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
                                <td colspan="9">No Matching Records Found</td>
                            @endif
                        </tbody>
                    </table>

                    <!-- Bottom pagination -->
                    <div class="d-flex align-items-center gap-2 text-sm mt-1">
                        <label for="pageSize" class="mb-0">Show:</label>
                        <select wire:model="pageSize"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span>entries</span>
                        {{ $leaves->links('pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        const uID = `{{ Auth::user()->id }}`;
        const lReq = `{{ route('hris.leave.eleave') }}`;
    </script>
    <script type="text/javascript" src="{{ asset('app-modules/e-forms/leaves-application.js') }}"></script>
</div>
