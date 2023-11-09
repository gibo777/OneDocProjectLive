



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
                <?php $__empty_1 = true; $__currentLoopData = $leavesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="text-sm text-lg-lg">
                        <td><?php echo e($data->name); ?></td>
                        <td><?php echo e($data->employee_id); ?></td>
                        <td><?php echo e($data->office); ?></td>
                        <td><?php echo e($data->department); ?></td>
                        <td><?php echo e($data->control_number); ?></td>
                        <td><?php echo e($data->leave_type); ?></td>
                        <td><?php echo e($data->others); ?></td>
                        <td><?php echo e($data->date_from); ?></td>
                        <td><?php echo e($data->date_to); ?></td>
                        <td><?php echo e($data->no_of_days); ?></td>
                        <td><?php echo e($data->reason); ?></td>
                        <td><?php echo e($data->head_name); ?></td>
                        <td><?php echo e($data->date_applied); ?></td>
                        <td><?php echo e($data->status); ?></td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="14" class="text-center">There are no time logs.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views//reports/excel/leaves-excel.blade.php ENDPATH**/ ?>