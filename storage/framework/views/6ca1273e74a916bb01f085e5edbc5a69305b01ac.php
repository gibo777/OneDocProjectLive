

<link rel="stylesheet" href="<?php echo e(asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css')); ?>">

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
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>Week</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                    <th>Total Work Time</th>
                    
                </tr>
            </thead>
            <tbody class="data hover" id="viewEmployee">
                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="<?php echo e($employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out)); ?>"
                         class="text-sm text-lg-lg">
                        <td><?php echo e(strtoupper($employee->department)); ?></td>
                        <td><?php echo e($employee->full_name); ?></td>
                        <td><?php echo e(strtoupper($employee->employee_id)); ?></td>
                        <td><?php echo e($employee->time_in ? date('m/d/Y',strtotime($employee->time_in)) : date('m/d/Y',strtotime($employee->time_out))); ?></td>
                        <td><?php echo e($employee->time_in ? date('l',strtotime($employee->time_in)) : date('l',strtotime($employee->time_out))); ?></td>
                        <td><?php echo e($employee->time_in ? date('m/d/Y H:i:s',strtotime($employee->time_in)) : ''); ?></td>
                        <td><?php echo e($employee->time_out ? date('m/d/Y H:i:s',strtotime($employee->time_out)) : ''); ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">There are no time logs.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views//reports/excel/timelogs-excel.blade.php ENDPATH**/ ?>