
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <link rel="shortcut icon" href="<?php echo e(asset('img/all/onedoc-favicon.png')); ?>">
    <style type="text/css">
    /* Hide the "Show" text and adjust layout for DataTables elements */
    .dataTables_wrapper .dataTables_length label {
        padding-left: 15px;
    }

    /* Display the "Show entries" dropdown and "Showing [entries] info" inline */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_filter {
        margin-top: 10px;
        display: inline-block;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-right: 50px;
    }

    /* Add padding between "Showing [entries] info" and "Show entries" dropdown */
    .dataTables_wrapper .dataTables_info::after {
        content: "\00a0\00a0"; /* Add non-breaking spaces for spacing */
    }
    .dataTables_wrapper thead th {
        padding: 1px 5px !important; /* Adjust the padding value as needed */
    }
    .dataTables_length select {
        width: 60px; /* Adjust the width as needed */
    }
    #dataTimeLogs thead th {
        text-align: center; /* Center-align the header text */
    }
    .capitalize-first-letter {
      text-transform: capitalize !important;
    }
    
    </style>

     <?php $__env->slot('header', null, []); ?> 
                <?php echo e(__('TIME LOGS')); ?>

     <?php $__env->endSlot(); ?>
    <div id="view_leaves">
        <div class="w-full mx-auto py-2 sm:px-6 lg:px-8">
            <!-- FORM start -->

            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            
            


            <div class="px-4 bg-white sm:p-6 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">

                <div class="col-span-8 sm:col-span-8 sm:justify-center">
                        <div id="filterFields" class="form-group border-0 col-md-12 py-1 gap-2 inset-shadow">
                            <div class="row pb-1">
                                <div class="col-sm-1 h-full d-flex justify-content-center align-items-center">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'name','id' => 'show_filter','value' => ''.e(__('FILTER')).'','class' => 'hover']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'name','id' => 'show_filter','value' => ''.e(__('FILTER')).'','class' => 'hover']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfilterEmpOffice">
                                        <select name="filterTimeLogsOffice" id="filterTimeLogsOffice" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Offices</option>
                                            <?php $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option><?php echo e($office->company_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'filterTimeLogsOffice','value' => ''.e(__('OFFICE')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'filterTimeLogsOffice','value' => ''.e(__('OFFICE')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <!-- FILTER by Leave Type -->
                                    <div class="form-floating" id="divfilterTimeLogsDept">
                                        <select name="filterTimeLogsDept" id="filterTimeLogsDept" class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                            <option value="">All Departments</option>
                                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <option><?php echo e($department->department); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'filterTimeLogsDept','value' => ''.e(__('DEPARTMENT')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'filterTimeLogsDept','value' => ''.e(__('DEPARTMENT')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-4 px-3 text-center mt-1">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['class' => 'py-0 my-0','value' => ''.e(__('Search Dates')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-0 my-0','value' => ''.e(__('Search Dates')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <input type="date" id="dateFrom" name="dateFrom" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                    to
                                    <input type="date" id="dateTo" name="dateTo" type="text" placeholder="mm/dd/yyyy" autocomplete="off" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md mt-1" />
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2 pt-2 text-center mt-1 ">
                                    <?php if(Auth::user()->id==1 || Auth::user()->id==8 || Auth::user()->id==18): ?>
                                    <div class="form-group btn btn-outline-success d-inline-block p-2 rounded capitalize hover">
                                        <i class="fas fa-table"></i>
                                        <span id="exportExcel" class="font-weight-bold">Export to Excel</span>
                                    </div>
                                    
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                            <div id="table_data">
                                <!-- Name -->
                                <div class="col-span-12 sm:col-span-7 sm:justify-center scrollable">
                                    <table id="dataTimeLogs" class="view-detailed-timelogs table table-bordered table-striped sm:justify-center table-hover">
                                        <thead class="thead">
                                            <tr class="dt-head-center">
                                                <th>Name</th>
                                                <th class="p-0">Emp. ID</th>
                                                <th>Office</th>
                                                <th>Department</th>
                                                <th>Time-In</th>
                                                <th>Time-Out</th>
                                                <th>Supervisor</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="data hover" id="viewEmployee">
                                            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr id="<?php echo e($employee->employee_id.'|'.($employee->f_time_in ? $employee->f_time_in : $employee->f_time_out)); ?>"
                                                     class="text-sm text-lg-lg">
                                                    <td><?php echo e($employee->full_name); ?></td>
                                                    <td class="p-0"><?php echo e($employee->employee_id); ?></td>
                                                    <td><?php echo e($employee->office); ?></td>
                                                    <td><?php echo e($employee->department); ?></td>
                                                    <td><?php echo e($employee->time_in ? date('m/d/Y g:i A',strtotime($employee->time_in)) : ''); ?></td>
                                                    <td><?php echo e($employee->time_out ? date('m/d/Y g:i A',strtotime($employee->time_out)) : ''); ?></td>
                                                    <td><?php echo e($employee->head_name); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="7">There are no time logs.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center" id="pagination">
                                        <?php //{!! $employees->links() !!} ?>
                                    </div>

                                </div>
                    </div>
                </div>
            </div>

            <!-- FORM end -->
                </div>
            </div>
        </div>
    </div>

<!-- =========================================== -->
<!-- Load Data -->
<div id="dataLoad" style="display: none">
    <img src="<?php echo e(asset('/img/misc/loading-blue-circle.gif')); ?>">
</div>

<!-- =========================================== -->




<script type="text/javascript">
$(document).ready(function() {

    if (("<?php echo e(count($employees)); ?>") == 0) { return false; }
    // Initialize DataTable
    var table = $('#dataTimeLogs').DataTable({
        /*"order": [
            [3, 'desc'],
            [4, 'desc'],
            [0, 'asc'],
        ],*/
        "order": [],
        /*"columnDefs": [
          { width: '170px', targets: [3] }, 
        ],*/
        // "ordering": false,
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 15, // Set the default number of entries per page
        "dom": '<<"top"ilpf>rt<"bottom"ilp><"clear">>', // Set Info, Search, and Pagination both top and bottom of the table
    });

    function formatDate(inputDate) {
        var date = new Date(inputDate); // Create a Date object from the input string
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0"); // Pad the month with leading zeros if needed
        var day = String(date.getDate()).padStart(2, "0"); // Pad the day with leading zeros if needed

        // Return the formatted date in the desired format (MM-DD-YYYY)
        return [month,day,year].join("/");
      }

    /*$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sD  = $('#filterTimeLogsDept').val();
            var cD  = data[2]; // Department Column
            
            // Check if a department filter is selected
            var departmentFilterActive = (sD != null && sD !== '');

            // Apply both filters
            if (!departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var departmentMatch = !departmentFilterActive || cD.includes(sD);

            return departmentMatch;
        
    });*/

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var sTO  = $('#filterTimeLogsOffice').val();
            var sTD = $('#filterTimeLogsDept').val();
            var cTO  = data[2]; // Office Column
            var cTD = data[3]; // Department Column
            // alert(cTD); return false;
            
            // Check if a department filter is selected
            var officeFilterActive = (sTO != null && sTO !== '');

            // Check if a LeaveType filter is selected
            var departmentFilterActive = (sTD != null && sTD !== '');

            // Apply both filters
            if (!officeFilterActive && !departmentFilterActive) {
                return true; // No filters applied, show all rows
            }
            var officeMatch = !officeFilterActive || cTO.includes(sTO);
            var departmentMatch = !departmentFilterActive || cTD.includes(sTD);

            return officeMatch && departmentMatch;
       
        
    });


    /* START - Date From and Date To Searching */
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var searchDateFrom = $('#dateFrom').val();
        var searchDateTo = $('#dateTo').val();

        // Convert search date strings to Date objects
        var dateFrom = new Date(searchDateFrom);
        var dateTo = new Date(searchDateTo);

        // Set the time to the start and end of the selected days
        dateFrom.setHours(0, 0, 0, 0);
        dateTo.setHours(23, 59, 59, 999);

        // Get the time-in and time-out values from columns 3 and 4
        var searchTimeIn = data[3];
        var searchTimeOut = data[4];

        // Convert time-in and time-out strings to Date objects (if applicable)
        var timeIn = searchTimeIn ? new Date(searchTimeIn) : null;
        var timeOut = searchTimeOut ? new Date(searchTimeOut) : null;

        // Check if the row's time-in or time-out falls within the selected date range
        if (
            (!searchDateFrom || !searchDateTo) || // No date range selected
            (!timeIn && !timeOut) || // No time values available
            (timeIn >= dateFrom && timeIn <= dateTo) ||
            (timeOut >= dateFrom && timeOut <= dateTo)
        ) {
            return true; // Row matches the search criteria
        }

        return false; // Row does not match the search criteria
    });


    $('#filterTimeLogsOffice').on('keyup change', function() {
        table.draw();
    });
    $('#filterTimeLogsDept').on('keyup change', function() {
        table.draw();
    });


    /* Triggers Date From Searching of Time-In/Time-Out */
    $('#dateFrom').on('keyup change', function() {
        if ($('#dateTo').val()=='' || $('#dateTo').val()==null) {
            $('#dateTo').val($(this).val());
        } else {
            var dateFrom = new Date($(this).val());
            var dateTo = new Date($('#dateTo').val());
            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    // text: '',
                }).then(function() {
                    $(this).val('');
                });
            }
        }
        table.draw();
    });

    /* Triggers Date To Searching of Time-In/Time-Out */
    $('#dateTo').on('keyup change', function() {
        var dateFrom = new Date($('#dateFrom').val());
        var dateTo = new Date($(this).val());
        if( dateTo < dateFrom ) {
            $(this).val($('#dateFrom').val());
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                // text: '',
            });
        }
        table.draw();
    });
    /* END - Date From and Date To Searching */





    /* Double Click event to show Employee details */
    $(document).on('dblclick','.view-detailed-timelogs tr',async function(){
        // alert($(this).attr('id')); return false;


        $('#dataLoad').css('display','flex');
        $('#dataLoad').css('position','absolute');
        $('#dataLoad').css('top','40%');
        $('#dataLoad').css('left','40%');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/timelogs-detailed',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){
                let tDT = `<table id="dataDetailedTimeLogs" class="table table-bordered data-table sm:justify-center table-hover">
                          <thead class="thead">
                              <tr>
                                  <th>Photo</th>
                                  <th>Time-In</th>
                                  <th>Time-Out</th>
                              </tr>
                          </thead>
                          <tbody class="data text-center" id="data">`;


                    for(var n=0; n<data.length; n++) {
                    tDT += `<tr>
                                <td><img width="124px" src="`+data[n]['profile_photo_path']+
                                `"</img></td><td>`+data[n]['time_in']+`</td><td>`+data[n]['time_out']+`</td>`;
                    }

                    tDT +=`</tbody>
                      </table>`;


                    Swal.fire({
                        // icon: 'success',
                        // title: (data[0]['f_time_in']!=null) ? data[0]['f_time_in'] : data[0]['f_time_out'],
                        // text: '',
                        allowOutsideClick: false,
                        html: tDT
                    });
                    $('#dataLoad').css('display','none');
            }
        });
    });

    /* EXPORT TO EXCEL TIMELOGS */

    $('#exportExcel').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/timelogs-excel',
            method: 'get',
            data: {'id':$(this).attr('id')}, // prefer use serialize method
            success:function(data){

                var blob = new Blob([data], { type: 'application/vnd.ms-excel' });
                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = 'timelogs.xls'; // Use .xls extension for Excel files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                /*====*/
                /*var blob = new Blob([data], { type: 'text/csv' }); // Set the content type to 'text/csv'

                var url = window.URL.createObjectURL(blob);

                // Create a download link
                var a = document.createElement('a');
                a.href = url;
                a.download = 'timelogs.csv'; // Use .csv extension for CSV files
                document.body.appendChild(a);
                a.click();

                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);*/
            }
        }); 
        return false;

    });









});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>




<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views//time_logs/time-logs-listing.blade.php ENDPATH**/ ?>