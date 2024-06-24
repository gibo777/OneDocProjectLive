<x-slot name="header">
    {{ __('TIME LOGS') }}
</x-slot>
<div id="view_leaves">
    <div class="w-full mx-auto py-2 sm:px-6 lg:px-8">
        <!-- FORM start -->

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">

                <div id="filterFields" class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
				    <div class="row pb-1">
				        {{-- Office Filter --}}
				        <div class="col-md-2">
				            <div class="form-floating mx-2 w-full" id="divfilterEmpOffice">
				                <select wire:model="fTLOffice" name="fTLOffice" id="fTLOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
				                    <option value="">All Offices</option>
				                    @foreach ($offices as $office)
				                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
				                    @endforeach
				                </select>
				                <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
				            </div>
				        </div>

				        {{-- Department Filter --}}
				        <div class="col-md-2">
				            <div class="form-floating mx-2 w-full" id="divfTLDept">
				                <select wire:model="fTLDept" name="fTLDept" id="fTLDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
				                    <option value="">All Departments</option>
				                    @foreach ($departments as $department)
				                        <option value="{{ $department->department_code }}">{{ $department->department }}</option>
				                    @endforeach
				                </select>
				                <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
				            </div>
				        </div>

				        {{-- Date Filters --}}
				        <div class="col-md-4 px-3 text-center mt-1">
				            <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
				            <input type="date" id="fTLdtFrom" name="fTLdtFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
				            to
				            <input type="date" id="fTLdtTo" name="fTLdtTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
				        </div>

				        {{-- Search Input --}}
				        <div class="col-md-2">
				            <x-jet-label for="search" value="{{ __('Search') }}" />
				            <input wire:model.debounce.300ms="search" type="text" id="search" name="search" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Search...">
				        </div>

				        {{-- Export Button --}}
				        <div class="col-md-2 pt-2 text-center mt-1">
				            @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58)
				                <div class="form-group btn btn-outline-success d-inline-block p-2 rounded capitalize hover">
				                    <i class="fas fa-table"></i>
				                    <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
				                </div>
				            @endif
				        </div>
				    </div>
				</div>


                <div id="table_data">
                    <!-- Table -->
                    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                        <div class="d-flex justify-content-between align-items-center">
						    <div class="form-inline">
						        <label for="pageSize" class="mr-2">Show:</label>
						        <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
						            <option value="5">5</option>
						            <option value="10">10</option>
						            <option value="15">15</option>
						            <option value="25">25</option>
						            <option value="50">50</option>
						        </select>
						        <span class="ml-2">entries</span>
						    </div>
						    <div class="d-flex align-items-center">
						        {{ $timeLogs->links() }}
						    </div>
						</div>

                        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
                            <thead class="thead">
                                <tr class="dt-head-center">
                                    <th>Name</th>
                                    <th>Emp. ID</th>
                                    <th>Office</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Supervisor</th>
                                </tr>
                            </thead>
                            <tbody class="data hover" id="viewEmployee">
                                @foreach ($timeLogs as $record)
                                <tr id="{{ $record->employee_id.'|'.$record->log_date }}">
                                    @if (url('/')=='http://localhost')
                                    	<td>xxx, xxx x.</td>
                                    @else
                                    	<td>{{ $record->full_name }}</td>
                                    @endif
                                    {{-- <td>{{ $record->id }}</td> --}}
                                    <td>{{ $record->employee_id }}</td>
                                    <td>{{ $record->office }}</td>
                                    <td>{{ $record->department }}</td>
                                    <td>{{ date('m/d/Y', strtotime($record->log_date)) }}</td>
                                    <td>{{ $record->f_time_in ? date('g:i A', strtotime($record->f_time_in)) : '' }}</td>
                                    <td>{{ $record->f_time_out ? date('g:i A', strtotime($record->f_time_out)) : '' }}</td>
                                    @if (url('/')=='http://localhost')
                                    	<td>xxx, xxx x.</td>
                                    @else
                                    	<td>{{ $record->supervisor }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center" id="pagination">
                            {{ $timeLogs->links() }}
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

<!-- =========================================== -->
<script type="text/javascript">
    const uID = `{{ Auth::user()->id }}`;
</script>
<script type="text/javascript" src="{{ asset('app-modules/timekeeping/timelogs-listings.js') }}"></script>