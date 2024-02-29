

<link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">

<style type="text/css">
#dataTimeLogs thead th {
    text-align: center; /* Center-align the header text */
}

</style>


<div id="table_data">
    <x-jet-input id="hidCurrentDate" value="{{ $currentDate }}" hidden></x-jet-input>
    <!-- Name -->
    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
            <thead class="thead">
                <tr class="dt-head-center">
                    <th>Department</th>
                    <th>Name</th>
                    <th>Staff Code</th>
                    {{-- <th>Employee ID</th> --}}
                    <th>Date</th>
                    <th>Week</th>
                    <th>Time1</th>
                    <th>Time2</th>
                    <th>Total Work Time</th>
                    {{-- <th>Employee ID</th> --}}
                </tr>
            </thead>
            <tbody class="data hover" id="viewEmployee">
                @forelse($employees as $employee)
                    <tr id="{{ $employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out) }}"
                         class="text-sm text-lg-lg">
                        <td>{{ strtoupper($employee->dept) }}</td>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->biometrics_id }}</td>
                        {{-- <td>{{ str_pad(strval($employee->biometrics_id), 8, "0", STR_PAD_LEFT) }}</td> --}}
                        {{-- <td>{{ strtoupper($employee->employee_id) }}</td> --}}
                        <td>{{ $employee->time_in ? date('d/m/Y',strtotime($employee->time_in)) : date('m/d/Y',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('l',strtotime($employee->time_in)) : date('l',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('H:i:s',strtotime($employee->time_in)) : '' }}</td>
                        <td>{{ $employee->time_out ? date('H:i:s',strtotime($employee->time_out)) : '' }}</td>
                        <td></td>
                        {{-- <td>{{ strtoupper($employee->employee_id) }}</td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">There are no time logs.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
