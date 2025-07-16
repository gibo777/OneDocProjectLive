<x-slot name="header">
	{{ __('MODULE CREATION') }}
</x-slot>


<div id="view_leaves">
    {{-- <div class="w-full mx-auto my-1 sm:px-6 lg:px-8"> --}}
    <div class="w-full p-0">
        <!-- FORM start -->

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="bg-white sm:p-6 shadow m-0 {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="col-span-8 sm:col-span-8 sm:justify-center">

				    <div class="row mx-1 inset-shadow py-1">

                        <div class="col-md-4 row my-2">
			        		<div class="col-md-2 text-center">
			            		<x-jet-label for="search" value="{{ __('Search') }}" class="my-0 pt-1 text-sm"/>
			        		</div>
			        		<div class="col-md-9">
			        			<x-jet-input wire:model.debounce.300ms="search" type="text" id="search" name="search" class="w-full" placeholder="Name/Employee ID" title="Name/Employee #">
			        			</x-jet-input>
			        		</div>
                        </div>

				        <div class="col-md-2 px-1">
				            <div class="form-floating w-full">
				                <select wire:model="fUserOffice" name="fUserOffice" id="fUserOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
				                    <option value="">All Offices</option>
				                    @foreach ($offices as $office)
				                        <option value="{{ $office->id }}">{{ $office->company_name }}</option>
				                    @endforeach
				                </select>
				                <x-jet-label for="fUserOffice" value="{{ __('OFFICE') }}" />
				            </div>
				        </div>

				        <div class="col-md-2 px-1">
				            <div class="form-floating w-full">
				                <select wire:model="fUserDept" name="fUserDept" id="fUserDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
				                    <option value="">All Departments</option>
				                    @foreach ($departments as $department)
				                        <option value="{{ $department->department_code }}">{{ $department->department }}</option>
				                    @endforeach
				                </select>
				                <x-jet-label for="fUserDept" value="{{ __('DEPARTMENT') }}" />
				            </div>
				        </div>

				        <div class="col-md-2 px-1">
				            <div class="form-floating w-full">
				                <select wire:model="fUserRole" name="fUserRole" id="fUserRole" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
				                    <option value="">All Roles</option>
				                    @foreach ($roleTypes as $roles)
				                        <option value="{{ $roles->role_type }}">{{ $roles->role_type }}</option>
				                    @endforeach
				                </select>
				                <x-jet-label for="fUserRole" value="{{ __('ROLES') }}" />
				            </div>
				        </div>
				        <div class="col-md-2 p-2 d-flex justify-content-center align-items-center">
                            <x-jet-button  id="createNewModule" class="w-full justify-content-center">
                                {{ __('Create New Menu') }}
                            </x-jet-button>
				        </div>

				    </div>
				</div>


                <div id="table_data">
                        <div class="row">
						    	<div class="col-md-12 text-sm pl-4 ">
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
							        	{{ $moduleList->links('pagination.custom') }}
								        </div>
						    		</div>
							    </div>
						    	{{-- <div class="col-md-4">
						    		<div class="row mt-2">
						        		<div class="col-md-4 mt-2 px-0 text-center">
								            @if (Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18 || Auth::user()->id==58)
								                <div class="form-group btn btn-outline-success d-inline-block shadow-sm px-1 rounded capitalize hover px-3">
								                    <i class="fas fa-table"></i>
								                    <span id="exportExcelLeaves" class="font-weight-bold">Export Excel</span>
								                </div>
								            @endif
		                                </div>
						    		</div>
						    	</div> --}}
						</div>
                    <!-- Table -->
                    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">

                        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover text-sm">
                            <thead class="thead">
                                <tr class="dt-head-center">
                                    <th class="py-1">Nav Order</th>
                                    <th class="py-1">Module Name</th>
                                    <th class="py-1">Parent Module</th>
                                    <th class="py-1">Category</th>
                                    <th class="py-1">Status</th>
                                </tr>
                            </thead>
                            <tbody class="data hover custom-text-xs" id="viewEmployee">
                            	@if ($moduleList->isNotEmpty())
	                                @foreach ($moduleList as $record)
	                                <tr id="{{ $record->id }}" class="view-module">
	                                    <td>{{ $record->nav_order }}</td>
	                                	<td>{{ $record->module_name }}</td>
	                                    <td>{{ $record->parent_module }}</td>
	                                    <td>{{ $record->module_category }}</td>
	                                    <td>{{ $record->module_status }}</td>
	                                    {{-- @if (url('/')=='http://localhost')
	                                    	<td>xxx, xxx x.</td>
	                                    @else
	                                        <td>
	                                            @if ($record->approver1)
	                                                {{ $record->approver1 }}
	                                                    @if ($record->approver2)
	                                                    {{ ' / '. $record->approver2 }}
	                                                    @endif
	                                            @endif
	                                        </td>
	                                    @endif --}}
	                                    
									    {{-- <td value="{{ $record->id }}" class="open_leave {{ $record->status!='Pending' ? (($record->status == 'Cancelled' || $record->status == 'Denied') ? 'red-color' : 'green-color') : '' }} items-center text-sm font-medium text-gray-500">
									    	{{ $record->status }}
									    </td> --}}

	                                </tr>
	                                @endforeach
                                @else
                                	<td colspan="10">No Matching Records Found</td>
                                @endif
                            </tbody>
                        </table>


					    	<div class="col-md-12 text-sm">
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
						        	{{ $moduleList->links('pagination.custom') }}
							        </div>
					    		</div>
						    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== -->

{{-- <script type="text/javascript">
    const uID = `{{ Auth::user()->id }}`;
    const lReq = `{{ route('hris.leave.eleave') }}`;
</script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.11/dist/interact.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('app-modules/setup/module-creation.js') }}"></script>