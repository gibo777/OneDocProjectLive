

<script src="{{ asset('/js/hris-jquery.js') }}"></script>

<div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8">
<!-- FORM start -->

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form id="leave-form" action="{{ route('hris.leave.view-leave-details') }}" method="POST">
@csrf


<div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

    <div class="col-span-8 sm:col-span-8 sm:justify-center scrollable">
            <div id="filter_fields" class="grid grid-cols-6 py-2 gap-2">
                    @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                    <!-- <div class="col-span-8 sm:col-span-1">
                        <x-jet-label for="filter_search" value="{{ __('SEARCH') }}" />
                        <x-jet-input id="filter_search" name="filter_search" type="text" class="mt-1 block w-full" placeholder="Name or Employee No."/>
                    </div> -->
                <x-jet-label for="name" id="show_filter" value="{{ __('FILTER') }}" class="hover"/>
                    <!-- FILTER by Department -->
                    <div class="col-span-8 sm:col-span-1" id="div_filter_department">
                        <x-jet-label for="filter_department" value="{{ __('DEPARTMENT') }}" />
                        <select name="filter_department" id="filter_department" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                @if ($dept->id==$filter_department)
                                <option value="{{ $dept->department_code }}" selected>{{ $dept->department }}</option>
                                @else
                                <option value="{{ $dept->department_code }}">{{ $dept->department }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <!-- <div class="col-span-8 sm:col-span-1">
                        <x-jet-label for="name" value="{{ __('NAME') }}" />
                        <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" />
                    </div> -->
                    <!-- FILTER by Leave Type -->
                    <div class="col-span-8 sm:col-span-1" id="div_filter_leave_type">
                        <x-jet-label for="filter_leave_type" value="{{ __('LEAVE TYPE') }}" />
                        <select name="filter_leave_type" id="filter_leave_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            <option value="">All Leave Types</option>
                            @foreach ($leave_types as $leave_type)
                            @if ($leave_type->leave_type==$filter_leave_type)
                            <option value="{{ $leave_type->leave_type }}" selected>{{ $leave_type->leave_type_name }}</option>
                            @else
                            <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type_name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
            </div>

                        <div id="table_data">
                            <!-- Name -->
                            <div class="col-span-8 sm:col-span-8 sm:justify-center text-center scrollable">
                                <table id="data" class="table table-bordered table-striped data-table sm:justify-center table-hover tabledata">
                                    <thead class="thead">
                                        <tr>
                                            @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                            <th>Name</th>
                                            <th>Emp. No.</th>
                                            <th>Department</th>
                                            @endif
                                            <th>Leave#</th>
                                            <th>Leave Type</th>
                                            <th>Date Applied</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
                                            <th># of Days</th>
                                            <th>Supervisor</th>
                                            <th>Status</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="data" id="data">
                                        @forelse($leaves as $leave)
                                            <tr>
                                                @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                                                <td>{{ $leave->name }}</td>
                                                <td>{{ $leave->employee_id}}</td>
                                                <td>{{ $leave->dept }}</td>
                                                @endif
                                                <td>{{ $leave->leave_number }}</td>
                                                <td>{{ $leave->leave_type }}</td>
                                                <td>{{ date('m/d/Y g:i A',strtotime($leave->date_applied)) }}</td>
                                                <td>{{ date('m/d/Y',strtotime($leave->date_from)) }}</td>
                                                <td>{{ date('m/d/Y',strtotime($leave->date_to)) }}</td>
                                                <td>{{ $leave->no_of_days }}</td>
                                                <td>{{ $leave->head_name }}</td>
                                                @if ($leave->status!="Pending")
                                                <td id="status_view">
                                                    <button 
                                                        id="{{ $leave->id }}" 
                                                        value="{{ $leave->id }}" 
                                                        title="Show History Leave #{{ $leave->leave_number }}" 
                                                        class="open_leave green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover" 
                                                        data-toggle="modal" >
                                                        {{ $leave->status }}
                                                    </button></td>
                                                @else
                                                <td>{{ $leave->status }}</td>
                                                @endif
                                                {{-- <td id="action_buttons">
                                                    <button id="open-{{ $leave->id }}" value="{{ $leave->id }}" title="View {{ $leave->leave_number }}" class="open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">View</button>
                                                    @if ($leave->status == "Pending" && Auth::user()->employee_id==$leave->employee_id)
                                                    <button id="delete-{{ $leave->id }}" value="{{ $leave->id }}" title="Delete {{ $leave->leave_number }}" class="fa fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">Delete</button>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">There are no users.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                            @if (Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN')
                            <div class="m-1">
                            <i class="fa fa-print inline-flex items-center justify-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition hover" onclick="printreport()">&nbsp;print</i>
                            </div>
                            @endif
        </div>
    </div>
</div>
    
</form>
<!-- FORM end -->
    </div>
</div>
</div>
<!-- Modal DAGDAG NI MARK FOR PRINT -->
<div class="modal fade" id="myPrintModal" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel"  data-bs-backdrop="static" data-bs-keyboard="false" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myPrintModalLabel"></h4>
          <button type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        </div>
        <div class="modal-body">
            <div id="blue">
                <table id="printtable2">
                    <thead>
                        <tr>
                            <th colspan="8" class="head1" style="text-align: center; font-size:24px; color:white"> FILTERED LEAVES REPORT</th>
                        </tr>
                        <tr>
                            <th colspan="4" id="filterdept2" class="head2" style="text-align: center; font-size:20px; color:white">DEPARTMENTS:{{$filter_department}} </th>

                            <th colspan="4" id="filterlev2" class="head2" style="text-align: center; font-size:20px; color:white">LEAVE TYPE: {{$filter_leave_type}} </th>

                        </tr>
                        <tr class="head3">
                            {{-- <th style="text-align: center; font-size:14px;">Leave#</th> --}}
                            @if (Auth::user()->access_code==1)
                            <th>Name</th>
                            <th>Emp. No.</th>
                            <th>Department</th>
                            @endif
                            <th >Leave Type</th>
                            <th >Date Applied</th>
                            <th >Date From</th>
                            <th >Date To</th>
                            <th ># of Days</th>
                            {{-- <th style="text-align: center; font-size:14px;">Supervisor</th>
                            <th style="text-align: center; font-size:14px;">Status</th> --}}

                        </tr>
                    </thead>
                    <tbody class="data" id="data">
                        @forelse($leaves as $leave)
                            <tr>
                                {{-- <td style="text-align: center; font-size:9px;">{{ $leave->leave_number }}</td> --}}
                                @if (Auth::user()->access_code==1)
                                <td class="datazzz">{{ $leave->name }}</td>
                                <td class="datazzz">{{ $leave->employee_id}}</td>
                                <td class="datazzz">{{ $leave->dept }}</td>
                                @endif
                                <td class="datazzz">{{ $leave->leave_type }}</td>
                                <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_applied)) }}</td>
                                <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_from)) }}</td>
                                <td class="datazzz">{{ date('m/d/Y',strtotime($leave->date_to)) }}</td>
                                <td class="datazzz">{{ $leave->no_of_days }}</td>
                                {{-- <td style="text-align: center; font-size:9px;">{{ $leave->head_name }}</td>

                                <td style="text-align: center; font-size:9px;">{{ $leave->status }}</td> --}}

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There are no users.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
      </div>
    </div>
  </div>

{{-- DAGDAG NI MARK FOR PRINT FUNCTION --}}
    <script>
         function printreport(){
            $("#printtable2").printThis();
            // $("#printVisitModal").modal('show');
            // console.log("PRINT FUNCTION FUNCTIONAL");
        }
    </script>