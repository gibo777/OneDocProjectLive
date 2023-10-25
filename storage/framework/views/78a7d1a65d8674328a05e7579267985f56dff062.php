

<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<style type="text/css">
    /* Hide the "Show" text and adjust layout for DataTables elements */
    .dataTables_wrapper .dataTables_length label {
        padding-left: 15px;
    }

    /* Display the "Show entries" dropdown and "Showing [entries] info" inline */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_info {
        display: inline-block;
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

</style>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['id' => 'exportExcel','class' => 'my-3']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'exportExcel','class' => 'my-3']); ?>Export to Excel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<div id="table-container">
  <table id="exportTable">
    <thead class="thead">
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i=0; $i<5; $i++): ?>
      <tr>
        <td>John</td>
        <td>30</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Jane</td>
        <td>25</td>
        <td>jane@example.com</td>
      </tr>
      <tr>
        <td>Doe</td>
        <td>40</td>
        <td>doe@example.com</td>
      </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</div>




<script type="text/javascript">

 $(document).ready(function() {

    var table = $('#exportTable').DataTable({
        dom: '<<"top"il><"top"p><"top"f>rt<"bottom"ip><"clear">>',
      // "dom": '<"top"lf><"top"i><"top"p>rt<"bottom"i><"bottom"p>',
      // "dom": '<"top"lf><"top"i><"top"p>rt<"clear">',
      // dom: '<"top"lf><"bottom"i>rt<"bottom"flp><"clear">',
        "lengthMenu": [ 5,10, 15, 25, 50, 75, 100 ], // Customize the options in the dropdown
        "iDisplayLength": 5, // Set the default number of entries per page
    });


  // Event listener for button click
  $('#exportExcel').click(function() {
    var blob = new Blob([$('#table-container').html()], { type: 'application/vnd.ms-excel' });
    var url = window.URL.createObjectURL(blob);

    // Create a download link
    var a = document.createElement('a');
    a.href = url;
    a.download = 'data.xls'; // Use .xls extension for Excel files
    document.body.appendChild(a);
    a.click();

    // Clean up
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  });
});


</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views//test/test.blade.php ENDPATH**/ ?>