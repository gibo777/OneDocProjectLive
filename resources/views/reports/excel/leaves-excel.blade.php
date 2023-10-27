

{{-- <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}"> --}}

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
                    <th>Full Name</th>
                    <th>Employee Number</th>
                    <th>Office</th>
                    <th>Department</th>
                    <th>Control Number</th>
                    <th>Leave Type</th>
                    <th>Others</th>
                    <th>Begin Date</th>
                    <th>End Date</th>
                    <th>Number of Day/s</th>
                    <th>Reason</th>
                    <th>Supervisor</th>
                    <th>Date Applied</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leavesData as $data)
                    <tr class="text-sm text-lg-lg">
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->employee_id }}</td>
                        <td>{{ $data->office }}</td>
                        <td>{{ $data->department }}</td>
                        <td>{{ $data->control_number }}</td>
                        <td>{{ $data->leave_type }}</td>
                        <td>{{ $data->others }}</td>
                        <td>{{ $data->date_from }}</td>
                        <td>{{ $data->date_to }}</td>
                        <td>{{ $data->no_of_days }}</td>
                        <td>{{ $data->reason }}</td>
                        <td>{{ $data->head_name }}</td>
                        <td>{{ $data->date_applied }}</td>
                        <td>{{ $data->status }}</td>
                        {{-- <td>{{ $data->full_name }}</td>
                        <td>{{ strtoupper($data->employee_id) }}</td>
                        <td>{{ $employee->time_in ? date('m/d/Y',strtotime($employee->time_in)) : date('m/d/Y',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('l',strtotime($employee->time_in)) : date('l',strtotime($employee->time_out)) }}</td>
                        <td>{{ $employee->time_in ? date('m/d/Y H:i:s',strtotime($employee->time_in)) : '' }}</td>
                        <td>{{ $employee->time_out ? date('m/d/Y H:i:s',strtotime($employee->time_out)) : '' }}</td>
                        <td></td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">There are no time logs.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
