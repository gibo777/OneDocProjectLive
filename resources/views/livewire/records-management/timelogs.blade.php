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

        <div class="px-3 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">
				    <div class="row pb-1 mx-1 inset-shadow">

				        {{-- Office Filter --}}
				        <div class="col-md-2 py-2">
				            <div class="form-floating w-full" id="divfilterEmpOffice">
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
				        <div class="col-md-2 py-2">
				            <div class="form-floating w-full" id="divfTLDept">
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
				        <div class="col-md-3 pt-2 px-3 text-center">
						    <div class="flex justify-between items-center">
						        <!-- Search Dates label -->
						        <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
						        <!-- Clear Date Filter link -->
						        <span id="clearFilter" wire:click="clearDateFilters" class="hover text-primary text-sm px-1" style="font-weight: 500;">{{ __('Clear Date Filter') }}</span>
						    </div>

						    <!-- Flex container for the date inputs -->
						    <div class="flex justify-center items-center">
					            <x-jet-input wire:model.debounce.500ms="fTLdtFrom" type="date" id="fTLdtFrom" name="fTLdtFrom" placeholder="mm/dd/yyyy" autocomplete="off" class="mx-1" {{-- class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" --}} />
					            to
					            <x-jet-input wire:model.debounce.500ms="fTLdtTo" type="date" id="fTLdtTo" name="fTLdtTo" placeholder="mm/dd/yyyy" autocomplete="off" class="mx-1" {{-- class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" --}} />
					        </div>
				        </div>

			            <div class="col-md-2 py-2"></div>

				        {{-- Export Button --}}
				        <div class="col-md-3 text-center mt-2 py-2">
				            @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58)
				                <div class="form-group btn btn-outline-success d-inline-block shadow-sm p-2 rounded capitalize hover w-75">
				                    <i class="fas fa-table"></i>
				                    <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
				                </div>
				            @endif
				        </div>
				    </div>
				</div>


                <div id="table_data">
                        <div class="row my-1">
						    	<div class="col-md-9">
						    		<div class="form-inline items-center justify-center">
								        <label for="pageSize" class="mr-2">Show:</label>
								        <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
								            <option value="5">5</option>
								            <option value="10">10</option>
								            <option value="15">15</option>
								            <option value="25">25</option>
								            <option value="50">50</option>
								        </select>
								        <span class="mx-2">entries</span>
								        <div class=" sm:col-span-7 sm:justify-center scrollable">
							        	{{ $timeLogs->links('pagination.custom') }}
								        </div>
						    		</div>
							    </div>
						    	<div class="col-md-3">
						    		<div class="row py-2">
						        		<div class="col-md-2">
						            		<x-jet-label for="search" value="{{ __('Search') }}" class="my-0 pt-1"/>
						        		</div>
						        		<div class="col-md-8">
						        			<x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search" class="w-full"  placeholder="Name/Employee ID">
						        			</x-jet-input>
						        		</div>
						    		</div>
						    	</div>
						</div>
                    <!-- Table -->
                    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                        {{-- <div class="d-flex justify-content-between align-items-center">
						    <div class="form-inline">
						        <label for="pageSize" class="mr-2">Show:</label>
						        <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md py-1">
						            <option value="5">5</option>
						            <option value="10">10</option>
						            <option value="15">15</option>
						            <option value="25">25</option>
						            <option value="50">50</option>
						        </select>
						        <span class="mx-2">entries</span>
						        {{ $timeLogs->links('pagination.custom') }}
						    </div>
						</div> --}}

                        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                            <thead class="thead">
                                <tr class="dt-head-center">
                                    <th class="py-1">Name</th>
                                    <th class="py-1" style="width: 8%">Emp. ID</th>
                                    <th class="py-1">Office</th>
                                    <th class="py-1" style="width: 20%">Department</th>
                                    <th class="py-1" style="width: 8%">Date</th>
                                    <th class="py-1" style="width: 8%">Time In</th>
                                    <th class="py-1" style="width: 8%">Time Out</th>
                                    <th class="py-1">Supervisor</th>
                                </tr>
                            </thead>
                            <tbody class="data hover custom-text-xs" id="viewEmployee">
                            	@if ($timeLogs->isNotEmpty())
                                @foreach ($timeLogs as $record)
                                <tr id="{{ $record->id }}">
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
                                    <td>{{ $record->time_in ? date('g:i A', strtotime($record->time_in)) : '' }}</td>
                                    <td>{{ $record->time_out ? date('g:i A', strtotime($record->time_out)) : '' }}</td>
                                    @if (url('/')=='http://localhost')
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
                        <div class="d-flex justify-content-between align-items-center">
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
						    {{-- </div>
						    <div class="d-flex align-items-center"> --}}
						        {{ $timeLogs->links('pagination.custom') }}
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