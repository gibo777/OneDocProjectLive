

<x-slot name="header">
    {{ __('SERVER STATUS') }}
</x-slot>
<div id="view_leaves">
    <div class="max-w-5xl mx-auto pt-3 py-2 sm:px-6 lg:px-8">
        <!-- FORM start -->

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            <div class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow py-2">
			    <div class="row justify-content-center text-center">
			        <div class="col-md-12">
			            <h2>Server Status</h2>
			            
			            <p class="mb-0">Status: 
			                {!! $serverStatus ? '<b class="px-3 py-1 text-dark" style="background-color:rgb(185,255,102)">Server Up</b>' : '<b class="px-3 py-1 text-light" style="background-color:rgb(255,49,49)">Server Down</b>' !!}
			            </p>
			            
			            <x-jet-button wire:click="toggleServer" class="btn btn-primary mt-1">
			                <i class="fa-solid fa-server"></i> {{ $serverStatus ? 'Turn Off Server' : 'Turn On Server' }}
			            </x-jet-button>
			        </div>
			    </div>


                <div id="table_data">
                    <!-- Table -->
                    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">

                        {{-- <div class="d-flex justify-content-between align-items-center">
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
						</div> --}}

                        {{-- <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
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
                            <tbody class="data hover text-sm" id="viewEmployee">
                                @foreach ($timeLogs as $record)
                                <tr id="{{ $record->employee_id.'|'.$record->log_date }}">
                                    @if (url('/')=='http://localhost')
                                    	<td>xxx, xxx x.</td>
                                    @else
                                    	<td>{{ $record->full_name }}</td>
                                    @endif
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
                            </tbody>
                        </table> --}}

                        {{-- <div class="d-flex justify-content-between align-items-center">
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
						</div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

