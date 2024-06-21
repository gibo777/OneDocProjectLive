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
                        <div class="col-sm-1 h-full d-flex justify-content-center align-items-center">
                            <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                        </div>
                        <div class="col-md-2">
                            <!-- FILTER by Office -->
                            <div class="form-floating" id="divfilterEmpOffice">
                                <select name="fTLOffice" id="fTLOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">All Offices</option>
                                    {{-- @foreach ($offices as $office)
                                    <option>{{ $office->company_name }}</option>
                                    @endforeach --}}
                                </select>
                                <x-jet-label for="fTLOffice" value="{{ __('OFFICE') }}" />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <!-- FILTER by Department -->
                            <div class="form-floating" id="divfTLDept">
                                <select name="fTLDept" id="fTLDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">All Departments</option>
                                    {{-- @foreach ($departments as $department)
                                    <option>{{ $department->department }}</option>
                                    @endforeach --}}
                                </select>
                                <x-jet-label for="fTLDept" value="{{ __('DEPARTMENT') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 px-3 text-center mt-1">
                            <x-jet-label class="py-0 my-0" value="{{ __('Search Dates') }}" />
                            <input type="date" id="fTLdtFrom" name="fTLdtFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                            to
                            <input type="date" id="fTLdtTo" name="fTLdtTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                        </div>

                        <div class="col-md-1">
                        </div>

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
                        <div class="d-flex justify-content-center" id="pagination">
                            {{ $timeLogs->links() }}
                        </div>
                        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
                            <thead class="thead">
                                <tr class="dt-head-center">
                                    <th>Name</th>
                                    <th>Emp. ID</th>
                                    <th>Office</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    {{-- <th>Time In</th>
                                    <th>Time Out</th> --}}
                                    <th>Supervisor</th>
                                </tr>
                            </thead>
                            <tbody class="data hover" id="viewEmployee">
                                @foreach ($timeLogs as $record)
                                <tr id="{{ $record->employee_id.'|'.$record->date }}">
                                    <td>{{ $record->full_name }}</td>
                                    {{-- <td>{{ $record->id }}</td> --}}
                                    <td>{{ $record->employee_id }}</td>
                                    <td>{{ $record->office }}</td>
                                    <td>{{ $record->department }}</td>
                                    <td>{{ date('m/d/Y', strtotime($record->date)) }}</td>
                                    {{-- <td>{{ $record->time_in ? date('g:i A', strtotime($record->time_in)) : '' }}</td>
                                    <td>{{ $record->time_out ? date('g:i A', strtotime($record->time_out)) : '' }}</td> --}}
                                    <td>{{ $record->supervisor }}</td>
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