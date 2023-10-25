<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->

     <?php $__env->slot('header', null, []); ?> 
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> -->
        
            <?php echo e(__('PERSONNEL DATA')); ?>

        
     <?php $__env->endSlot(); ?>

    
<div class="max-w-7xl mx-auto mt-1">
    <div class="">
        
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            
            <li class="nav-item" role="presentation">
                <button id="pills-pd-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-pd" type="button" role="tab" aria-controls="pills-pd" aria-selected="true">
                Personal Data
                </button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button id="pills-ad-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ad" type="button" role="tab" aria-controls="pills-ad" aria-selected="false">
                Accounting Data
                </button>
            </li>
            <?php if(Auth::user()->id==1): ?>
            
            <li class="nav-item" role="presentation">
                <button id="pills-fb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-fb" type="button" role="tab" aria-controls="pills-fb" aria-selected="false">
                Family Background
                </button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button id="pills-eb-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eb" type="button" role="tab" aria-controls="pills-eb" aria-selected="false">
                Educational Background
                </button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button id="pills-eh-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-eh" type="button" role="tab" aria-controls="pills-eh" aria-selected="false">
                Employment History
                </button>
            </li>
            <?php endif; ?>
            
            <li class="nav-item" role="presentation">
                <button id="pills-as-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-as" type="button" role="tab" aria-controls="pills-as" aria-selected="false">
                Account Security
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-pd" role="tabpanel" aria-labelledby="pills-pd-tab">
                <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.update-profile-information-form')->html();
} elseif ($_instance->childHasBeenRendered('znRXk9A')) {
    $componentId = $_instance->getRenderedChildComponentId('znRXk9A');
    $componentTag = $_instance->getRenderedChildComponentTagName('znRXk9A');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('znRXk9A');
} else {
    $response = \Livewire\Livewire::mount('profile.update-profile-information-form');
    $html = $response->html();
    $_instance->logRenderedChild('znRXk9A', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
                <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.accounting-data')->html();
} elseif ($_instance->childHasBeenRendered('pnoznoN')) {
    $componentId = $_instance->getRenderedChildComponentId('pnoznoN');
    $componentTag = $_instance->getRenderedChildComponentTagName('pnoznoN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pnoznoN');
} else {
    $response = \Livewire\Livewire::mount('profile.accounting-data');
    $html = $response->html();
    $_instance->logRenderedChild('pnoznoN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="pills-fb" role="tabpanel" aria-labelledby="pills-fb-tab">
                <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.family-background')->html();
} elseif ($_instance->childHasBeenRendered('X3BVDUJ')) {
    $componentId = $_instance->getRenderedChildComponentId('X3BVDUJ');
    $componentTag = $_instance->getRenderedChildComponentTagName('X3BVDUJ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X3BVDUJ');
} else {
    $response = \Livewire\Livewire::mount('profile.family-background');
    $html = $response->html();
    $_instance->logRenderedChild('X3BVDUJ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="pills-eb" role="tabpanel" aria-labelledby="pills-eb-tab">
                <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.educational-background')->html();
} elseif ($_instance->childHasBeenRendered('zHebECj')) {
    $componentId = $_instance->getRenderedChildComponentId('zHebECj');
    $componentTag = $_instance->getRenderedChildComponentTagName('zHebECj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('zHebECj');
} else {
    $response = \Livewire\Livewire::mount('profile.educational-background');
    $html = $response->html();
    $_instance->logRenderedChild('zHebECj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="pills-eh" role="tabpanel" aria-labelledby="pills-eh-tab">
                <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.employment-history')->html();
} elseif ($_instance->childHasBeenRendered('qLrX203')) {
    $componentId = $_instance->getRenderedChildComponentId('qLrX203');
    $componentTag = $_instance->getRenderedChildComponentTagName('qLrX203');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qLrX203');
} else {
    $response = \Livewire\Livewire::mount('profile.employment-history');
    $html = $response->html();
    $_instance->logRenderedChild('qLrX203', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="pills-as" role="tabpanel" aria-labelledby="pills-as-tab">
                
                  <div class="row mt-2">
                    <div class="col-md-4">
                            <?php if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords())): ?>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.update-password-form')->html();
} elseif ($_instance->childHasBeenRendered('acVPAWu')) {
    $componentId = $_instance->getRenderedChildComponentId('acVPAWu');
    $componentTag = $_instance->getRenderedChildComponentTagName('acVPAWu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('acVPAWu');
} else {
    $response = \Livewire\Livewire::mount('profile.update-password-form');
    $html = $response->html();
    $_instance->logRenderedChild('acVPAWu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                            <?php if(Laravel\Fortify\Features::canManageTwoFactorAuthentication()): ?>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.two-factor-authentication-form')->html();
} elseif ($_instance->childHasBeenRendered('CGxL4KX')) {
    $componentId = $_instance->getRenderedChildComponentId('CGxL4KX');
    $componentTag = $_instance->getRenderedChildComponentTagName('CGxL4KX');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CGxL4KX');
} else {
    $response = \Livewire\Livewire::mount('profile.two-factor-authentication-form');
    $html = $response->html();
    $_instance->logRenderedChild('CGxL4KX', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                            <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form')->html();
} elseif ($_instance->childHasBeenRendered('iIiFcGf')) {
    $componentId = $_instance->getRenderedChildComponentId('iIiFcGf');
    $componentTag = $_instance->getRenderedChildComponentTagName('iIiFcGf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iIiFcGf');
} else {
    $response = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form');
    $html = $response->html();
    $_instance->logRenderedChild('iIiFcGf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                  
            </div>
        </div>


              
                

                <?php
                 /*<div id="account_security" class="tab-pane fade max-w-75 ">

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.update-password-form')
                            </div>
                        @endif

                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.two-factor-authentication-form')
                            </div>
                        @endif

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                            @component('Illuminate\View\AnonymousComponent', 'jet-section-border', ['view' => 'jetstream::components.section-border','data' => []])
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
@endComponentClass

                            <div class="mt-3 sm:mt-0">
                                @livewire('profile.delete-user-form')
                            </div>
                        @endif
                       
                </div>*/
                ?>

                
      
    </div>
</div>
    

<script type="text/javascript">

$(document).ready(function() {

    // $("#country").select2();
    // $("#province").select2();
    // $("#municipality").select2();

    $(function () {
        $('[data-bs-toggle="collapse"]').tooltip()
    })

    
    /*$("input").on('keyup keydown change paste',function () {
        if ($.trim($(this).val())=="") {
            $(this).addClass('empty');
        } else {
            $(this).removeClass('empty');
        }
    });*/

    
    $("#hidden_profile_photo").change(function() {
        // var photoName = $refs.photo.files[0].name;
        // const reader = new FileReader();
        // reader.onload = (e) => {
        //     photoPreview = e.target.result;
        // };
        // reader.readAsDataURL($refs.photo.files[0]);
        // alert('Gibs'); return false;
    });

    /*$("#country").on('change', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/provinces',
            method: 'get',
            data: {
                'country_code': $(this).val()
            },
            success:function(data){
                $("#province").empty();
                $("#province").append('<option value="">-Select Province-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#province").append("<option>"+data[n]['province']+"</option>");
                }
                $("#municipality").empty();
                $("#municipality").append('<option value="">-Select City/Municipality-</option>');
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                $("#zip_code").val('');
            }
        });
    });*/

    /*$("#province").on('change', function() {
        // alert('Country: '+$("#country").val()+'\nProvince: '+$(this).val()); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/cities',
            method: 'get',
            data: {
                'country_code': $("#country").val(),
                'province': $(this).val()
            },
            success:function(data){
                // prompt('',data); return false;
                $("#municipality").empty();
                $("#municipality").append('<option value="">-Select City/Municipality-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#municipality").append("<option>"+data[n]['municipality']+"</option>");
                }
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                $("#zip_code").val('');
                
            }
        });
    });*/

    /*$("#municipality").on('change', function() {
        // alert('municipality'); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/barangays',
            method: 'get',
            data: {
                'country_code'  : $("#country").val(),
                'province'      : $("#province").val(),
                'municipality'  : $(this).val()
            },
            success:function(data){
                // prompt('',data); return false;
                $("#barangay").empty();
                $("#barangay").append('<option value="">-Select Barangay-</option>');
                for (var n=0; n<data.length; n++) {
                    $("#barangay").append("<option>"+data[n]['barangay']+"</option>");
                }
                $("#zip_code").val('');
                
            }
        });
    });*/

    /*$("#barangay").on('change', function() {
        // alert('barangay and zip'); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zipcodes',
            method: 'get',
            data: {
                'country_code'  : $("#country").val(),
                'province'      : $("#province").val(),
                'municipality'  : $("#municipality").val(),
                'barangay'      : $(this).val(),
            },
            success:function(data){
                $("#zip_code").val(data['zip_code']);
            }
        });
    });*/




    $("#capturePhoto").click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/webcam',
            method: 'get',
            success:function(data){
                // prompt('',data);
                // $(".modal-body").html(data);
                $("#modalWebCam").modal("show");
            }
        });
    });
    
    /*$("#capturePhoto").click(function() {
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        
        Webcam.attach( '#my_camera' );
        
    });
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            $('#results').removeClass('hidden')
            $('#results').html('<img src="'+data_uri+'"/>');
        } );
    }
    $("#closeWebCamModal").click(function() {
        alert('RNG s');
        Webcam.reset( '#my_camera' );
    });*/

    /* ACCOUNTING DATA - DEPENDENTS */

    $(".btnDependents").each(function(){
        $(this).click(function() {
            var dCounter = $('.dependentsRow').length;
            // console.log(dCounter);
            $(function () {
                // $('#date_applied').datepicker({ dateFormat: 'mm/dd/yy' });
                $('#date_from').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    // yearRange: "1900:3000",
                    autoclose: true
                });
                $('#date_to').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

                $('.datepicker').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

                $('#holiday_date').datepicker({
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });

            });
            if (dCounter < 4) {
            $("#dependents")
            .append(`
                    <div class="row dependentsRow">
                        <div class="col-md-8 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['name' => 'dependent_name','id' => 'dependent_name${dCounter+1}','type' => 'text','class' => 'dependentsName form-control block w-full','wire:model.defer' => 'state.dependent1','autocomplete' => 'off','placeholder' => 'Dependent']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'dependent_name','id' => 'dependent_name${dCounter+1}','type' => 'text','class' => 'dependentsName form-control block w-full','wire:model.defer' => 'state.dependent1','autocomplete' => 'off','placeholder' => 'Dependent']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'dependent_name${dCounter+1}','value' => ''.e(__('Dependent ${dCounter+1}')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'dependent_name${dCounter+1}','value' => ''.e(__('Dependent ${dCounter+1}')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'dependent_name1','class' => 'mt-2']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'dependent_name1','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3 p-1">
                            <div class="form-floating col-span-8 sm:col-span-1">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['name' => 'dependent_birthdate','id' => 'dependent_birthdate${dCounter+1}','type' => 'text','class' => 'dependentsBday form-control datepicker block w-full','wire:model.defer' => 'state.dependent_birthdate${dCounter+1}','placeholder' => 'mm/dd/yyyy']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'dependent_birthdate','id' => 'dependent_birthdate${dCounter+1}','type' => 'text','class' => 'dependentsBday form-control datepicker block w-full','wire:model.defer' => 'state.dependent_birthdate${dCounter+1}','placeholder' => 'mm/dd/yyyy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'dependent_birthdate${dCounter+1}','value' => ''.e(__('Birthdate')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'dependent_birthdate${dCounter+1}','value' => ''.e(__('Birthdate')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'dependent_birthdate${dCounter+1}','class' => 'mt-2']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'dependent_birthdate${dCounter+1}','class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                `);
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
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/profile/show.blade.php ENDPATH**/ ?>