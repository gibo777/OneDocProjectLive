
<!-- <script src="<?php echo e(asset('/js/hris-jquery.js')); ?>"></script> -->
<link rel="shortcut icon" href="<?php echo e(asset('img/all/onedoc-favicon.png')); ?>">

<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div>
     <?php $__env->slot('header', null, []); ?> 
            <?php echo e(__('PROCESSING E-LEAVE APPLICATION')); ?>

     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="px-4 py-5 bg-white sm:p-6 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
           
            <form id="process-leave" method="POST" action="<?php echo e(route('process.eleave')); ?>">
                <div class="grid grid-cols-5 gap-6 text-center sm:justify-center">
                    <!-- CUT-OFF DATE -->
                    <div class="col-span-5 sm:col-span-5" id="div_date_covered">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'processDateFrom','value' => ''.e(__('CUT-OFF DATE')).'','class' => 'font-semibold text-xl']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'processDateFrom','value' => ''.e(__('CUT-OFF DATE')).'','class' => 'font-semibold text-xl']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'processDateFrom','name' => 'processDateFrom','type' => 'text','wire:model.defer' => 'state.processDateFrom','class' => 'date-input datepicker','placeholder' => 'mm/dd/yyyy','autocomplete' => 'off']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'processDateFrom','name' => 'processDateFrom','type' => 'text','wire:model.defer' => 'state.processDateFrom','class' => 'date-input datepicker','placeholder' => 'mm/dd/yyyy','autocomplete' => 'off']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                            <label class="font-semibold text-gray-800 leading-tight">TO</label>

                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'processDateTo','name' => 'processDateTo','type' => 'text','wire:model.defer' => 'state.processDateTo','class' => 'date-input datepicker','placeholder' => 'mm/dd/yyyy','autocomplete' => 'off','readonly' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'processDateTo','name' => 'processDateTo','type' => 'text','wire:model.defer' => 'state.processDateTo','class' => 'date-input datepicker','placeholder' => 'mm/dd/yyyy','autocomplete' => 'off','readonly' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'processDateFrom','class' => 'mt-2']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'processDateFrom','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'processDateTo','class' => 'mt-2']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'processDateTo','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div class="col-span-5 sm:col-span-5">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['id' => 'btnProcessEleave','value' => '','disabled' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'btnProcessEleave','value' => '','disabled' => true]); ?><?php echo e(__('PROCESS E-LEAVE')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div id="myProgress" class="col-span-5">
                        <div id="processing_bar" class="myBar"></div>
                        <!-- <div id="test_count" class="myBar"></div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="popup">
  <p id="pop_content" class="text-justify px-2"></p>
</div>

<div id="dialog">
  <p id="dialog_content" class="text-justify px-2"></p>
</div>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'hid_access_id','name' => 'hid_access_id','value' => ''.e(Auth::user()->access_code).'','type' => 'text','hidden' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'hid_access_id','name' => 'hid_access_id','value' => ''.e(Auth::user()->access_code).'','type' => 'text','hidden' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<div id="loading" hidden>
  <img id="loading-image" src="<?php echo e(asset('/img/misc/loading-blue.gif')); ?>" alt="Loading..." />
</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
    
    /* PROCESS E-LEAVE begin */
    $("#processDateFrom").change(function() {

        if ($('#processDateTo').val()=='' || $('#processDateTo').val()==null) {
            var pdto = new Date($(this).val());
            pdto.setDate(pdto.getDate()+14);
            var pdm = pdto.getMonth()+1; if (pdm<10) { pdm = "0"+pdm; }
            var pdd = pdto.getDate(); if (pdd<10) { pdd = "0"+pdd; }

            if($(this).val().length>=10) {
                $("#processDateTo").val([pdm,pdd,pdto.getFullYear()].join('/'));
                // $("#processDateTo").removeAttr('disabled');
                // alert($("#processDateTo").val());
                $("#btnProcessEleave").removeAttr('disabled');
            }
        } else {
            var dateFrom = new Date($(this).val());
            var dateTo = new Date($('#processDateTo').val());

            if( dateTo < dateFrom ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    // text: '',
                }).then(function() {
                    $("#processDateFrom").val('');
                    $("#processDateTo").val('');
                });
            } else {
                $("#btnProcessEleave").removeAttr('disabled');
            }
        }
    });

    /*$("#processDateFrom").on('keyup keydown', function(e) {
        // alert($(this).val().length);
        if($(this).val().length<10) {
            $("#btnProcessEleave").attr('disabled',true);
        } else {
            $("#btnProcessEleave").removeAttr('disabled');
        }
    });*/


    $("#processDateTo").change(function() {
        if ($(this).val()!="" && $("#processDateFrom").val()!="") {
            var dt_diff = (Date.parse($(this).val()) - Date.parse($("#processDateFrom").val())) / (1000*3600*24) + 1;
            // alert( dt_diff );
            $("#btnProcessEleave").removeAttr('disabled');
        }
    });


    $("#btnProcessEleave").click(function() {
        // var url = window.location.origin+'/view-processing-leave';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin+'/view-processing-leave',
            method: 'get',
            data: $("#process-leave").serialize(), // prefer use serialize method
            success:function(id){
                // prompt('',id); return false;
                if (id.length==0) {
                    $("#processing_bar").html("NOTHING TO PROCESS").width("100%");
                } else {
                    /*alert(id.length); return false;
                    for (var n=0; n<id.length; n++) {
                        alert("ID: "+id[n]['id']+"\nEnd Date: "+id[n]['date_to']);
                        if (n==3) {return false;}
                    }*/
                    var n_processed = 0;
                    for (var n=0; n<id.length; n++) {
                        // alert(id[n]['id']);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: window.location.origin+'/processing-leave',
                            method: 'post',
                            data: { 'id': id[n]['id'] }, // prefer use serialize method
                            success:function(data){
                                n_processed++;
                                // $("#test_count").html(id[n]['id']);
                                if (n_processed==1) {
                                    move(id);
                                }
                            }
                        });
                    }
                }
            }
        });
        return false;
    });

    var i = 0;
    var ctr = 0;
    function move(leaveID) {
        var counts = leaveID.length;
        if (i == 0) {
        i = 1;
        var elem = $("#processing_bar");
        var width = 0;
        // var done = Math.ceil(counts/100);
        // alert(done); return false;
        var id = setInterval(frame, (counts*1.5));
        var ctr_success=0;
        // alert("INTER: "+id+"\nCOUNTS: "+counts); return false;
        $("#loading").removeAttr('hidden');
        $("#loading").show();
            function frame() {
              if (width >= 100) {
                clearInterval(id);
                i = 0;
              } else {
                    // ctr_success = data;
                    ctr = ctr+(1/counts)*100;
                    width = ctr;
                    // $("#test_count").html(ctr_success+"|"+counts+"|"+ctr.toFixed(2)+"|"+leaveID[n]['id'])
                    elem.width(width + "%");
                    if (Math.round(width)<100) {
                        $("#processing_bar").html(width.toFixed(2) + "%");
                    } else {
                        $("#loading").hide();
                        $("#processing_bar").html(counts+" LEAVE/S PROCESSED");
                    }
              }
            }
        }
    }
    /* PROCESS E-LEAVE end*/
});
</script>



<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views//process/process-eleave.blade.php ENDPATH**/ ?>