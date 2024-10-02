<x-slot name="header">
        @if (Auth::user()->is_head==1)
            @if (Auth::user()->department=='1D-HR' || Auth::user()->id==1)
                {{ __('VIEW ALL LEAVES (HR/ADMIN VIEW)') }}
            @else
                {{ __('VIEW ALL LEAVES (HEAD VIEW)') }}
            @endif
        @else
            {{ __('VIEW ALL LEAVES') }}
        @endif
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

				    	<div class="col-md-7 row py-2">
						        <div class="col-md-3 px-1">
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

						        <div class="col-md-3 px-1">
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

						        <div class="col-md-3 px-1">
						            <div class="form-floating w-full">
						                <select wire:model="fLType" name="fLType" id="fLType" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
						                    <option value="">All Types</option>
						                    @foreach ($lTypes as $type)
						                        <option value="{{ $type->leave_type }}">{{ $type->leave_type_name }}</option>
						                    @endforeach
						                </select>
						                <x-jet-label for="fTLOffice" value="{{ __('TYPE') }}" />
						            </div>
						        </div>

						        <div class="col-md-3 px-1">
						            <div class="form-floating w-full">
						                <select wire:model="fLStatus" name="fLStatus" id="fLStatus" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
						                    <option value="">All Statuses</option>
						                    @foreach ($lStatus as $status)
						                        <option>{{ $status->request_status }}</option>
						                    @endforeach
						                </select>
						                <x-jet-label for="fTLOffice" value="{{ __('STATUS') }}" />
						            </div>
						        </div>
				    	</div>

				    	<div class="col-md-5">
				    		<div class="row px-0 mx-0 w-full">
						        <div class="col-md-8 pt-2 text-center">
								    <div class="flex justify-between items-center">
								        <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
								        <span id="clearFilter" wire:click="clearDateFilters" class="hover text-primary text-sm px-1" style="font-weight: 500;">
									        {{ __('Clear Date Filter') }}
									    </span>
								    </div>

								    <div class="flex justify-center items-center">
							            <x-jet-input wire:model.debounce.500ms="fLdtFrom" type="date" id="fLdtFrom" name="fLdtFrom" placeholder="mm/dd/yyyy" autocomplete="off" class="mx-1" />
							            to
							            <x-jet-input wire:model.debounce.500ms="fLdtTo" type="date" id="fLdtTo" name="fLdtTo" placeholder="mm/dd/yyyy" autocomplete="off" class="mx-1" />
							        </div>
						        </div>

						        <div class="col-md-4 text-center my-2">
                                    <x-jet-button  id="createNewLeave">
                                        <i class="fa-solid fa-sheet-plastic"></i>&nbsp;File a Leave
                                    </x-jet-button>
						        </div>
				    		</div>
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
								        <div class=" sm:col-span-7 sm:justify-center scrollable">
							        	{{ $leaves->links('pagination.custom') }}
								        </div>
						    		</div>
							    </div>
						    	<div class="col-md-4">
						    		<div class="row mt-2">
						        		<div class="col-md-4 mt-2 px-0 text-center">
								            @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58)
								                <div class="form-group btn btn-outline-success d-inline-block shadow-sm px-1 rounded capitalize hover px-3">
								                    <i class="fas fa-table"></i>
								                    <span id="exportExcelLeaves" class="font-weight-bold">Export Excel</span>
								                </div>
								            @endif
		                                </div>
		                                <div class="row col-md-8 my-2">
							        		<div class="col-md-2 text-left">
							            		<x-jet-label for="search" value="{{ __('Search') }}" class="my-0 pt-1 text-sm"/>
							        		</div>
							        		<div class="col-md-10">
							        			<x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search" class="w-full"  placeholder="Name/Employee ID/ Control Number" title="Name/Employee #/ Control #">
							        			</x-jet-input>
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
                                    {{-- <th style="width: 8%">Emp. ID</th> --}}
                                    <th class="py-1">Office</th>
                                    <th class="py-1" style="width: 20%">Department</th>
                                    <th class="py-1" style="width: 10%">Control#</th>
                                    <th class="py-1" style="width: 8%">Type</th>
                                    <th class="py-1" style="width: 8%">Begin Date</th>
                                    <th class="py-1" style="width: 8%">End Date</th>
                                    <th class="py-1" style="width: 5%">Day/s</th>
                                    <th class="py-1">Supervisor</th>
                                    <th class="py-1">Status</th>
                                </tr>
                            </thead>
                            <tbody class="data hover custom-text-xs" id="viewEmployee">
                            	@if ($leaves->isNotEmpty())
                                @foreach ($leaves as $record)
                                <tr id="{{ $record->id }}" class="view-leave">
                                    @if (url('/')=='http://localhost')
                                    	<td>xxx, xxx x.</td>
                                    @else
                                    	<td>{{ $record->full_name }}</td>
                                    @endif
                                    {{-- <td>{{ $record->employee_id }}</td> --}}
                                    <td>{{ $record->office }}</td>
                                    <td>{{ $record->department }}</td>
                                    <td>{{ $record->control_number }}</td>
                                    <td>{{ $record->leave_type }}</td>
                                    <td>{{ $record->date_from ? date('m/d/Y', strtotime($record->date_from)) : '' }}</td>
                                    <td>{{ $record->date_to ? date('m/d/Y', strtotime($record->date_to)) : '' }}</td>
                                    <td>{{ $record->no_of_days }}</td>
                                    @if (url('/')=='http://localhost')
                                    	<td>xxx, xxx x.</td>
                                    @else
                                    	<td>{{ $record->head_name }}</td>
                                    @endif
                                    
								    <td value="{{ $record->id }}" class="open_leave {{ $record->status!='Pending' ? (($record->status == 'Cancelled' || $record->status == 'Denied') ? 'red-color' : 'green-color') : '' }} items-center text-sm font-medium text-gray-500">
								    	{{ $record->status }}
								    </td>

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
						        <select wire:model="pageSize" id="pageSize" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
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