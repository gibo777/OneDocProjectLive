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

<!-- <div style="height: 580px"> -->
<div>
     <?php $__env->slot('header', null, []); ?> 
            <?php echo e(__('WELCOME TO ').strtoupper(env('COMPANY_NAME'))); ?> 
            
     <?php $__env->endSlot(); ?>
<!-- <audio src="<?php echo e(asset('media/videoplayback.mp3')); ?>" autoplay loop controls> -->

<!-- <audio controls autoplay loop>
    <source src="<?php echo e(asset('media/videoplayback.mp3')); ?>" type="audio/mpeg">
</audio> -->

<audio controls autoplay hidden>
  
</audio>


    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="px-2 py-3 bg-white sm:p-6 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
           <div class="row px-3">
                <div class="col-md-5 pt-5">
                    <!-- <div class="grid grid-cols-5 gap-6 text-center sm:justify-center"> -->
                    
                        
                        <ol>
                          <li>
                            <p>WHO WE ARE</p>
                            <p class="h6">
                            One Document Corporation is focused on Information Technology-related project developments and technology-based solutions, on its decade of existence this 2021 is expanding its reach through program-based versatile integrated systems that accelerate progress for any business operations.
                            </p>

                            <p>Mission:</p>
                            <p class="h6">
                            To have the entrepreneurial spirit in the continuous search for project opportunities, vigilant in growing from current businesses focused on our customers, and from new initiatives through ingenuity and reinvention, always committed to deliver dependable goods and services, locally and globally.
                            </p>

                            <p>Vision:</p>
                            <p class="h6">
                            To be a recognized socially-responsible leader in productive and profitabletechnology-based project developments, committed to improve lives, here and/or abroad
                            </p>
                          </li>
                        </ol>
                    <!-- </div> -->
                </div>

            <div class="col-md-7">
                <div id="carouselExampleIndicators" class="carousel slide pt-3" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <?php if(date('a')=='am'): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <?php else: ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                    <?php endif; ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                  </ol>

                  
                  <div class="carousel-inner">
                    <?php if(date('a')=='am'): ?>
                    <div class="carousel-item active" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/goodmorning.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/1.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <?php else: ?>
                    <div class="carousel-item active" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/1.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <?php endif; ?>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/2.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/3.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/4.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/5.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                    <div class="carousel-item" style="height: 450px !important;">
                      <img src="<?php echo e(asset('img/carousel/6.jpg')); ?>" class="d-block w-100 h-100" alt="...">
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                <div class="p-3">
                <ol>
                    <li>
                        Accelerating Our Nation’s Progress Through Information Technology.
                    </li>
                </ol>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<input type="button" id="audio-button" name="" value="button" hidden>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','id' => 'date_compare','value' => ''.e(substr(Auth::user()->birthdate,5,5).'|'.substr(Carbon\Carbon::now(),5,5)).'','hidden' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','id' => 'date_compare','value' => ''.e(substr(Auth::user()->birthdate,5,5).'|'.substr(Carbon\Carbon::now(),5,5)).'','hidden' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<!-- =========================================== -->
<!-- Modal for Greetings -->
<div class="modal fade " id="modalGreetings" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-xl" >
        <div class="modal-dialog-centered">  
            <img src="<?php echo e(asset('/img/misc/Happy_Birthday.gif')); ?>">
        </div>
    </div>
</div>
<!-- =========================================== -->
<script src="<?php echo e(asset('/js/confetti.js')); ?>"></script>
<script type="text/javascript">
  /*$(document).ready(function() {
    $("#audio-button").click(function() {
    $("#audio-background")[0].play(); return false;
    });
  });*/
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\xampp\OneDocProject\htdocs\OneDocProjectLive\resources\views/dashboard.blade.php ENDPATH**/ ?>