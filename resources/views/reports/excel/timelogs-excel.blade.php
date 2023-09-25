

<link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">

<style type="text/css">
#dataTimeLogs thead th {
    text-align: center; /* Center-align the header text */
}

</style>


<div id="table_data">
    <!-- Name -->
    <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
        <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
            <thead class="thead">
                <tr class="dt-head-center">
                    <th>Department</th>
                    <th>Name</th>
                    <th>Staff Code</th>
                    <th>Date</th>
                    <th>Week</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                    <th>Total Work Time</th>
                    {{-- <th>Status</th> --}}
                </tr>
            </thead>
            <tbody class="data hover" id="viewEmployee">
                @forelse($employees as $employee)
                    <tr id="{{ $employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out) }}"
                         class="text-sm text-lg-lg">
                        <td>{{ strtoupper($employee->department) }}</td>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ strtoupper($employee->employee_id) }}</td>
                        <td>{{ $employee->time_in ? date('m/d/Y',strtotime($employee->time_in)) : date('m/d/Y',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('l',strtotime($employee->time_in)) : date('l',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('m/d/Y H:i:s',strtotime($employee->time_in)) : '' }}</td>
                        <td>{{ $employee->time_out ? date('m/d/Y H:i:s',strtotime($employee->time_out)) : '' }}</td>
                        <td></td>
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
