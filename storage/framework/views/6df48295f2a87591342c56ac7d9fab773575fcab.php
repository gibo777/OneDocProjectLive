
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->
    <style type="text/css">
        /*#results { padding:1px;solid; }*/
    </style>



<div class="container">
    <!-- <h1 class="text-center">Laravel webcam capture image and save from camera - ItSolutionStuff.com</h1> -->
     
    <form method="POST" action="<?php echo e(route('webcam.capture')); ?>">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <input type="hidden" name="image" class="image-tag text-center rounded-md">
            </div>
            <div class="col-md-6 text-center">
                <div id="results" class="hidden rounded-md"></div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-md-12 text-center">
                <input type="button" value="Take Snapshot" onClick="take_snapshot()" class="btn btn-primary ">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- <br/> -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Save')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!-- <button class="btn btn-success">Submit</button> -->
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "<?php echo e(route('webcam.capture')); ?>",
            method: 'get',
            success:function(data){
                $("#modalWebCam").modal("show");
            }
        });

</script>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/utilities/webcam.blade.php ENDPATH**/ ?>