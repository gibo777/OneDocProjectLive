
<script src="{{ asset('/js/hris-jquery.js') }}"></script>
<div id="view_holidays">
        <div class="max-w-8xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form id="holidays-form" action="{{ route('hr.management.holidays') }}" method="POST">
            @csrf

            <div class="px-4 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">

                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">

                        <div align="right">
                            <x-jet-button  id="add_holidays" class="btn btn-primary font-semibold text-xl thead">Add Holiday</x-jet-button>
                        </div>
                        <div id="filter_fields" class="grid grid-cols-6 py-1 gap-2">
                            <x-jet-label for="filter_year" id="show_filter_holidays" value="{{ __('FILTER') }}" class="hover"/>
                                @if (Auth::user()->access_code==1)
                                <!-- FILTER by MONTH/YEAR -->
                                <div class="col-span-8 sm:col-span-1" id="div_filter_months" >
                                    <x-jet-label for="filter_months" value="{{ __('By Month') }}" />
                                    <select name="filter_months" id="filter_months" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                        <option value="" class="text-center" />- All Months -
                                        @foreach ($months as $key => $month)
                                            @if ($key+1==$filter_month)
                                                <option value="{{ str_pad($key+1,2,'0',STR_PAD_LEFT) }}" 
                                                selected>
                                                {{ $month }}</option>
                                            @else
                                                <option value="{{ str_pad($key+1,2,'0',STR_PAD_LEFT) }}" >
                                                {{ $month }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-8 sm:col-span-1" id="div_filter_years" >
                                    <x-jet-label for="filter_years" value="{{ __('By Year') }}" />
                                    <select name="filter_years" id="filter_years" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                                        @foreach ($years as $year)
                                            @if ($year==$filter_year))
                                            <option selected>{{ $year }}</option>
                                            @else
                                            <option>{{ $year }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-8 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="data_holidays" class="table table-bordered table-striped sm:justify-center table-hover tabledata">
                                        <thead class="thead">
                                            <tr>
                                                <th>Date</th>
                                                <th>Holiday</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data" id="data">

                                            @foreach($holidays as $holiday)
                                                <tr>
                                                    <td class="text-center">{{ date('m/d/Y  (D)',strtotime($holiday->date)) }}</td>
                                                    <td>{{ strtoupper($holiday->holiday) }}</td>
                                                    <td class="text-center">{{ strtoupper($holiday->holiday_type) }}</td>
                                                    <td id="action_buttons" class="text-center">
                                                        <button 
                                                            id="edit_holiday-{{ $holiday->id }}" 
                                                            value="{{ $holiday->id.'|'.$holiday->date.'|'.$holiday->holiday.'|'.$holiday->holiday_type }}" 
                                                            title="Edit {{ $holiday->holiday }}" 
                                                            class="open_leave fa fa-edit green-color inline-flex items-center text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover" 
                                                            data-toggle="modal" 
                                                            data-target="#myModal">
                                                            {{ __('EDIT') }}
                                                        </button>
                                                        <!-- <button id="delete-{{ $holiday->id }}" 
                                                            value="{{ $holiday->id }}" 
                                                            title="Delete {{ $holiday->holiday }}" 
                                                            class="fa fa-trash-o red-color inline-flex items-center  text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition hover">
                                                            {{ __('Delete') }}
                                                        </button> -->



                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                    </div>
                </div>
            </div>
                
            </form>
            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>