<x-slot name="header">
    {{ __('EMPLOYEES LISTING') }}
</x-slot>

<div id="view_leaves">
    <div class="w-full mx-auto my-1 sm:px-6 lg:px-8">
        <!-- FORM start -->

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">
                <div class="row mx-1 inset-shadow">

                    <div class="col-md-6 row py-2">
                        <div class="col-md-4 px-1">
                            <div class="form-floating w-full">
                                <select wire:model="fTLOffice" name="fTLOffice" id="fTLOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">All Offices</option>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
                                    @endforeach
                                </select>
                                <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 px-1">
                            <div class="form-floating w-full">
                                <select wire:model="fTLDept" name="fTLDept" id="fTLDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->department_code }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 px-1">
                            <div class="form-floating w-full">
                                <select wire:model="fLStatus" name="fLStatus" id="fLStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">All Statuses</option>
                                    @foreach ($lStatus as $status)
                                        <option>{{ $status->employment_status }}</option>
                                    @endforeach
                                </select>
                                <x-jet-label for="fLStatus" value="{{ __('STATUS') }}" />
                            </div>
                        </div>
                    </div>

	                <div class="col-md-2 p-1 my-1 text-center"></div>
	                <div class="col-md-2 p-1 my-1 text-center">
	                    @if(Auth::user()->id == 1)
	                    <x-jet-button id="downloadQR" >
	                        <i class="fa-solid fa-qrcode"></i>&nbsp;Download QR
	                    </x-jet-button>
	                    @endif
	                </div>
	                <div class="col-md-2 p-1 my-1 text-center">
	                    <x-jet-button id="registerEmployee" >
	                        <i class="fa-solid fa-user-plus"></i>&nbsp;Register Employee
	                    </x-jet-button>
	                </div>
                </div>
            </div>

            <div id="table_data">
                <div class="row">
                    <div class="col-md-8 text-sm">
                        <div class="form-inline mt-1">
                            <label for="pageSize" class="mr-2">Show:</label>
                            <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="mx-2">entries</span>
                            <div class="sm:col-span-7 sm:justify-center scrollable">
                                {{ $users->links('pagination.custom') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mt-2">
                            <div class="col-md-4 mt-2 px-0 text-center">
                                @if (in_array(Auth::user()->id, [1, 8, 18, 58]))
                                <div class="form-group btn btn-outline-success d-inline-block shadow-sm px-1 rounded capitalize hover px-3">
                                    <i class="fas fa-table"></i>
                                    <span id="exportExcel" class="font-weight-bold">Export Excel</span>
                                </div>
                                @endif
                            </div>
                            <div class="row col-md-8 my-2">
                                <div class="col-md-2 text-left">
                                    <x-jet-label for="search" value="{{ __('Search') }}" class="my-0 pt-1 text-sm" />
                                </div>
                                <div class="col-md-10">
                                    <x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search" class="w-full" placeholder="Name/Employee ID" title="Name/Employee ID" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                    <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                        <thead class="thead">
                            <tr class="dt-head-center">
                                <th class="py-1">Name</th>
                                <th class="py-1">Emp. ID</th>
                                <th class="py-1">Office</th>
                                <th class="py-1">Department</th>
                                <th class="py-1">Position</th>
                                <th class="py-1">Supervisor</th>
                                <th class="py-1">Employment Status</th>
                            </tr>
                        </thead>
                        <tbody class="data hover custom-text-xs" id="viewEmployee">
                            @forelse ($users as $record)
                            <tr id="{{ $record->id }}" class="view-leave">
                                <td>{{ url('/') == 'http://localhost' ? 'xxx, xxx x.' : $record->full_name }}</td>
                                <td>{{ $record->employee_id }}</td>
                                <td>{{ $record->office }}</td>
                                <td>{{ $record->department }}</td>
                                <td>{{ $record->position }}</td>
                                <td>{{ url('/') == 'http://localhost' ? 'xxx, xxx x.' : $record->head_name }}</td>
                                <td class="{{ strtolower($record->status) != 'probationary' && strtolower($record->status) != 'on-the-job training' ? (strtolower($record->status) == 'no longer connected' ? 'red-color' : 'green-color') : '' }} items-center text-sm font-medium text-gray-500">
                                    {{ $record->status }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No Matching Records Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center text-sm">
                        <div class="form-inline">
                            <label for="pageSize" class="mr-2">Show:</label>
                            <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="mx-2">entries</span>
                            {{ $users->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Loading Indicator -->
<div id="dataLoad" style="display: none">
    <img src="{{ asset('/img/misc/loading-blue-circle.gif') }}">
</div>

{{-- @include('modals/records-management/m-employee-details') --}}

<!-- JavaScript -->
<script type="text/javascript">
    const uID = `{{ Auth::user()->id }}`;
    const lReq = `{{ route('hris.leave.eleave') }}`;
    const iLoading = `{{ asset('img/misc/loading-blue-circle.gif')}}`;
</script>
<script type="text/javascript" src="{{ asset('app-modules/records-management/employees.js') }}"></script>

