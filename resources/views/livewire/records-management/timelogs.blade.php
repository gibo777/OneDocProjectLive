<x-slot name="header">
    {{ __('TIME LOGS') }}
</x-slot>


<div id="view_leaves">
    <div class="w-full mx-auto my-1 sm:px-6 lg:px-8">
        <!-- FORM start -->

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div
            class="px-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">

                {{-- Filter bar --}}
                <div class="row pb-1 mx-1 inset-shadow align-items-end py-2">

                    {{-- Office Filter --}}
                    <div class="col-md-2 p-1">
                        <div class="form-floating">
                            <select wire:model="fTLOffice" name="fTLOffice" id="fTLOffice"
                                class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">All Offices</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                @endforeach
                            </select>
                            <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
                        </div>
                    </div>

                    {{-- Department Filter --}}
                    <div class="col-md-2 p-1">
                        <div class="form-floating">
                            <select wire:model="fTLDept" name="fTLDept" id="fTLDept"
                                class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_code }}">{{ $department->department }}
                                    </option>
                                @endforeach
                            </select>
                            <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
                        </div>
                    </div>

                    {{-- Date Filter --}}
                    <div class="col-md-5 p-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <x-jet-label class="mb-0" value="{{ __('Search Dates') }}" />
                            <span id="clearFilter" wire:click="clearDateFilters" class="text-primary text-sm"
                                style="font-weight: 500; cursor: pointer;">
                                {{ __('Clear Date Filter') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 4px;">
                            <x-jet-input wire:model.debounce.500ms="fTLdtFrom" type="date" id="fTLdtFrom"
                                name="fTLdtFrom" autocomplete="off" class="w-50" onkeydown="return false"
                                style="cursor: pointer;" />
                            <span class="text-muted small px-1">to</span>
                            <x-jet-input wire:model.debounce.500ms="fTLdtTo" type="date" id="fTLdtTo"
                                name="fTLdtTo" autocomplete="off" class="w-50" onkeydown="return false"
                                style="cursor: pointer;" />
                        </div>
                    </div>

                    {{-- Export to Excel --}}
                    @if (Auth::user()->role_type === 'SUPER ADMIN')
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="btn btn-outline-success shadow-sm w-100 text-center py-2">
                                <i class="fas fa-table mr-1"></i>
                                <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>


            <div id="table_data">

                {{-- Page size, pagination, and search --}}

                {{-- Top row: Show entries on the left, Search on the right --}}
                <div class="d-flex align-items-center justify-content-between my-2" style="gap: 8px;">

                    {{-- Page size --}}
                    <div class="d-flex align-items-center flex-shrink-0" style="gap: 6px;">
                        <label for="pageSize" class="mb-0 text-nowrap">Show:</label>
                        <select wire:model="pageSize" id="pageSize"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-nowrap">entries</span>
                    </div>

                    {{-- Search --}}
                    <div class="d-flex align-items-center flex-shrink-0" style="gap: 6px;">
                        <x-jet-label for="search" value="{{ __('Search') }}" class="mb-0 text-nowrap" />
                        <x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search"
                            placeholder="Name/Employee ID" style="width: 180px; max-width: 45vw;" />
                    </div>

                </div>

                {{-- Pagination on its own row so it always has full width to scroll across --}}
                <div style="overflow-x: auto; white-space: nowrap; width: 100%; padding: 2px 0; margin-bottom: 8px;">
                    {{ $timeLogs->links('pagination.custom') }}
                </div>

                {{-- Time logs table --}}
                <div style="overflow-x: auto; width: 100%;">
                    <table id="dataTimeLogs"
                        class="view-detailed-timelogs table table-bordered table-striped table-hover text-sm mb-0">
                        <thead class="thead">
                            <tr class="dt-head-center">
                                <th class="py-1">Name</th>
                                <th class="py-1" style="width: 8%">Emp. ID</th>
                                <th class="py-1">Office</th>
                                <th class="py-1" style="width: 20%">Department</th>
                                <th class="py-1" style="width: 8%">Date</th>
                                <th class="py-1" style="width: 8%">Day</th>
                                <th class="py-1" style="width: 8%">Time In</th>
                                <th class="py-1" style="width: 8%">Time Out</th>
                                <th class="py-1">Supervisor</th>
                            </tr>
                        </thead>
                        <tbody class="data hover custom-text-xs" id="viewEmployee">
                            @if ($timeLogs->isNotEmpty())
                                @foreach ($timeLogs as $record)
                                    <tr id="{{ $record->id }}">
                                        {{-- Mask names on localhost --}}
                                        @if (url('/') == 'http://localhost')
                                            <td>xxx, xxx x.</td>
                                        @else
                                            <td>{{ $record->full_name }}</td>
                                        @endif

                                        <td>{{ $record->employee_id }}</td>
                                        <td>{{ $record->office }}</td>
                                        <td>{{ $record->department }}</td>
                                        <td>{{ date('m/d/Y', strtotime($record->log_date)) }}</td>
                                        <td>{{ date('D', strtotime($record->log_date)) }}</td>

                                        {{-- Blank when no time logged --}}
                                        <td>{{ $record->time_in ? date('g:i A', strtotime($record->time_in)) : '' }}
                                        </td>
                                        <td>{{ $record->time_out ? date('g:i A', strtotime($record->time_out)) : '' }}
                                        </td>

                                        @if (url('/') == 'http://localhost')
                                            <td>xxx, xxx x.</td>
                                        @else
                                            <td>{{ $record->supervisor }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="9">No Matching Records Found</td>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Bottom page size and pagination --}}
                <div class="d-flex align-items-center flex-wrap mt-2" style="gap: 6px;">
                    <label for="pageSize" class="mb-0">Show:</label>
                    <select wire:model="pageSize" id="pageSize"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                    <div style="overflow-x: auto; white-space: nowrap; flex: 1 1 0; min-width: 0;">
                        {{ $timeLogs->links('pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- =========================================== -->
<script type="text/javascript">
    const uID = `{{ Auth::user()->id }}`;
</script>
<script type="text/javascript" src="{{ asset('app-modules/timekeeping/timelogs-listings.js') }}"></script>
