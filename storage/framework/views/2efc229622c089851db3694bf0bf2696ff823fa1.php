
<style type="text/css">
    .notification {
      /*text-decoration: none;*/
      padding: 5px 15px;
      position: relative;
      display: inline-block;
      border-radius: 2px;
    }

    /*.notification:hover {
      background: lightblue;
    }*/

    .notification .badge {
      position: absolute;
      top: 2px;
      right: 2px;
      padding: 3px 6px;
      border-radius: 50%;
      /*background: blue;*/
      /*color: white;*/
    }

    .my-popup-class {
      animation: none !important;
      transform: none !important;
    }

    .dropdown-hover-all .dropdown-menu, .dropdown-hover > .dropdown-menu.dropend { 
        margin-left:-1px !important 
    }

    .margin-left-cust {
        left: -3 !important;
    }

    .margin-top-cust {
        top: -2 !important;
    }
</style>


<nav id="nav_header" x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->

    <div id="nav_header" class="w-full mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                
                <div class="flex items-center sm:justify-start">
                    <img class="img-company-logo" src="<?php echo e(asset('/img/company/onedoc-logo.png')); ?>" />
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex p-6">
                    <h6>Accelerating Our Nation’s Progress Through Information Technology.</h6>
                </div>

                <!-- Navigation Links -->
                
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                
                
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-clickable','data' => ['align' => 'right','width' => '48']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dropdown-clickable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                         <?php $__env->slot('trigger', null, []); ?> 
                            <?php if(Laravel\Jetstream\Jetstream::managesProfilePhotos()): ?>
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <?php echo e(join(' ',[Auth::user()->first_name, Auth::user()->middle_name, Auth::user()->last_name])); ?> &nbsp;

                                    <?php if(Auth::user()->profile_photo_path!=NULL): ?>
                                        <img class="h-8 w-8 rounded-full object-cover" src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>" />
                                    <?php else: ?>
                                        <?php if(Auth::user()->gender=='F'): ?> 
                                        <img class="h-8 w-8 rounded-full object-cover" src="<?php echo e(asset('/storage/profile-photos/default-female.png')); ?>"  alt="<?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>" />
                                        <?php elseif(Auth::user()->gender=='M'): ?> 
                                        <img class="h-8 w-8 rounded-full object-cover" src="<?php echo e(asset('/storage/profile-photos/default-formal-male.png')); ?>"  alt="<?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>" />
                                        <?php else: ?> 
                                        <img class="h-8 w-8 rounded-full object-cover" src="<?php echo e(asset('/storage/profile-photos/default-photo.png')); ?>"  alt="<?php echo e(Auth::user()->first_name.' '.Auth::user()->last_name); ?>" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </button>
                            <?php else: ?>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <?php if(Auth::user()->profile_photo_url==NULL): ?>
                                            <?php echo e(join(' ',[Auth::user()->first_name,Auth::user()->last_name])); ?>

                                        <?php endif; ?>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            <?php endif; ?>
                                    
                         <?php $__env->endSlot(); ?>


                         <?php $__env->slot('content', null, []); ?> 
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                <?php echo e(__('Manage Account')); ?>

                            </div>

                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => ['href' => ''.e(route('profile.show')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('profile.show')).'']); ?>
                                <?php echo e(__('Personnel Data')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                            <?php if(Laravel\Jetstream\Jetstream::hasApiFeatures()): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => ['href' => ''.e(route('api-tokens.index')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('api-tokens.index')).'']); ?>
                                    <?php echo e(__('API Tokens')); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                <?php echo csrf_field(); ?>

                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => ['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']); ?>
                                    <?php echo e(__('Log Out')); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </form>

                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu begin -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- navigation menu here -->
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-1 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">

                    <!-- E-LEAVE -->
                    <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        <?php echo e(__('E-FORMS')); ?>

                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('hris.leave.eleave')).'','id' => 'nav_eleave']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('hris.leave.eleave')).'','id' => 'nav_eleave']); ?>
                            <?php echo e(__('E-Leave Form')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('hris.leave.view-leave')).'','id' => 'nav_view_leaves']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('hris.leave.view-leave')).'','id' => 'nav_view_leaves']); ?>
                            <?php echo e(__('View Leaves')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                        <!-- <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('calendar')).'','id' => 'nav_leaves_calendar']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('calendar')).'','id' => 'nav_leaves_calendar']); ?>
                            <?php echo e(__('Leaves Calendar')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> -->
                    </div>
                    <div>
                        <a  class="view_nav block px-4 py-2 text-xs text-gray-400" href="<?php echo e(route('timelogslisting')); ?>"  id="nav_time_logs">
                            <?php echo e(__('TIME-LOGS')); ?>

                        </a>
                    </div>

                    

                    <!-- <div class="view_nav block px-4 py-2 text-xs text-gray-400">
                        <?php echo e(__('REPORTS')); ?>

                    </div>
                    <div class="border-t border-gray-200" hidden>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => '#']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '#']); ?>
                                <?php echo e(__('E-Leave Report')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div> -->

                    

                    <div class="mt-3 space-y-1"></div>
                <hr block px-4 py-2 text-gray-400>
            </div>
            <div class="flex items-center px-4">
                <?php if(Laravel\Jetstream\Jetstream::managesProfilePhotos()): ?>
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->name); ?>" />
                    </div>
                <?php endif; ?>

                <div>
                    <div class="font-medium text-base text-gray-800"><?php echo e(Auth::user()->name); ?></div>
                    <div class="font-medium text-sm text-gray-500"><?php echo e(Auth::user()->email); ?></div>
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <!-- Account Management -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('profile.show')).'','active' => request()->routeIs('profile.show')]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('profile.show')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('profile.show'))]); ?>
                    <?php echo e(__('Personnel Data')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                <?php if(Laravel\Jetstream\Jetstream::hasApiFeatures()): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('api-tokens.index')).'','active' => request()->routeIs('api-tokens.index')]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('api-tokens.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('api-tokens.index'))]); ?>
                        <?php echo e(__('API Tokens')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <!-- Authentication -->
                <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                    <?php echo csrf_field(); ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']); ?>
                        <?php echo e(__('Log Out')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </form>


            </div>
        </div>
    </div>
    <!-- Responsive Settings Options end -->


    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between p-1">

            <div class="hidden sm:flex sm:items-center sm:ml-6 dropdown-hover-all">

                <!-- HOME start-->
                <div class="dropdown mt-3 mx-1">
                    <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" href="<?php echo e(route('dashboard')); ?>" id="nav_home" >HOME</a>
                </div>
                <!-- HOME end  -->


                  <div class="dropdown mt-3 mx-1">
                      <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownEForms" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          E-FORMS
                      </button>
                      <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownEForms">
                          <div class="dropdown dropend">
                              <a class="dropdown-item dropdown-toggle" href="#" id="submenuELeaves" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-Leave</a>
                              <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                  <a class="dropdown-item" href="<?php echo e(route('hris.leave.eleave')); ?>" id="dNavEleave" ><?php echo e(__('E-Leave Form')); ?> </a>
                                  <a class="dropdown-item" href="<?php echo e(route('hris.leave.view-leave')); ?>"  id="nav_view_leaves"><?php echo e(__('View Leaves')); ?> </a>
                                  <a class="dropdown-item" href="<?php echo e(route('calendar')); ?>"  id="nav_leaves_calendar"><?php echo e(__('Leaves Calendar')); ?> </a>
                              </div>
                          </div>

                        <?php if(Auth::user()->role_type=='SUPER ADMIN'): ?>
                                  <div class="dropdown dropend">
                                      <a class="dropdown-item dropdown-toggle" href="#" id="submenuReimbursement" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reimbursement</a>
                                      <?php if(Auth::user()->id==1): ?>
                                      <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                          <a class="dropdown-item" href="<?php echo e(route('hris.reimbursement.reimbursement')); ?>">Reimbursement Form</a>
                                          <a class="dropdown-item" href="#">Sub-menu 2</a>
                                          <div class="dropdown-divider"></div>
                                          <div class="dropdown dropend">
                                              <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub-menu 3</a>
                                              <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                                  <a class="dropdown-item" href="#">Sub-menu 3.1</a>
                                                  <a class="dropdown-item" href="#">Sub-menu 3.2</a>
                                                  <div class="dropdown-divider"></div>
                                                  <a class="dropdown-item" href="#">Sub-menu 3.3</a>
                                              </div>
                                          </div>
                                      </div>
                                      <?php endif; ?>
                                  </div>
                          <?php endif; ?>
                          
                      </div>
                      
                </div>

                <?php if(Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN'): ?>
                    <?php if(str_contains(Auth::user()->department, 'ACCTG')==1 || Auth::user()->id==1): ?>
                    <div class="dropdown mt-3 mx-1">
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownProcess" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        PROCESS
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownProcess">
                            <div class="dropdown dropend">
                              <a class="dropdown-item" href="<?php echo e(route('process.eleave')); ?>">Process e-Leave</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="dropdown mt-3 mx-1">
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        RECORDS MANAGEMENT
                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
                              
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Employee Management </a>
                                  <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="<?php echo e(route('register')); ?>" >
                                            <?php echo e(__('User Registration')); ?>

                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('hr.management.employees')); ?>">
                                            <?php echo e(__('View Employees')); ?>

                                        </a>
                                  </div>
                              </div>
                              <div class="dropdown dropend">
                                  <a class="dropdown-item dropdown-toggle" href="#" id="dropdown-layouts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Time Keeping </a>
                                  <div class="dropdown-menu margin-left-cust" aria-labelledby="dropdown-layouts">
                                        <a class="dropdown-item" href="<?php echo e(route('timelogslisting')); ?>">Time Logs</a>
                                  </div>
                              </div>
                              
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="dropdown mt-3 mx-1">
                        <a class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" href="<?php echo e(route('timelogslisting')); ?>" id="nav_home" >TIME-LOGS</a>
                    </div>
                <?php endif; ?>

                


                <?php if(Auth::user()->role_type=='SUPER ADMIN'): ?>

                    <div class="dropdown mt-3 mx-1">
                        <button class="btn-outline-secondary inline-flex items-center px-3 py-1 m-0 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition hover" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(__('SET-UP')); ?>

                        </button>
                        <div class="dropdown-menu margin-top-cust" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown dropend">
                              
                              <a class="dropdown-item" href="<?php echo e(route('hr.management.offices')); ?>">
                                  <?php echo e(__('Offices')); ?>

                              </a>
                              <a class="dropdown-item" href="<?php echo e(route('hr.management.departments')); ?>">
                                  <?php echo e(__('Departments')); ?>

                              </a>
                              <a class="dropdown-item" href="<?php echo e(route('hr.management.holidays')); ?>">
                                  <?php echo e(__('Holidays')); ?>

                              </a>
                            </div>
                        </div>
                    </div>

                
                <?php endif; ?>

                

                <!-- E-LEAVE MENU start-->
                
                <!-- E-LEAVE MENU end  -->
                
                <?php if(Auth::user()->role_type=='ADMIN' || Auth::user()->role_type=='SUPER ADMIN'): ?>
                <!-- PROCESS start-->
                
                <!-- PROCESS end  -->

                <!-- ACCOUNT MANAGEMENT start-->
                
                <!-- ACCOUNT MANAGEMENT end  -->
                <?php endif; ?>


                
                
                
            </div>
        

            <div class="items-center justify-center">

                <?php if($timeIn): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','id' => 'btnTimeIn','name' => 'btnTimeIn','disabled' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','id' => 'btnTimeIn','name' => 'btnTimeIn','disabled' => true]); ?>
                    <?php echo e(__('Time-In')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','id' => 'btnTimeIn','name' => 'btnTimeIn']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','id' => 'btnTimeIn','name' => 'btnTimeIn']); ?>
                    <?php echo e(__('Time-In')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php if($timeOut): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','id' => 'btnTimeOut','name' => 'btnTimeOut','disabled' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','id' => 'btnTimeOut','name' => 'btnTimeOut','disabled' => true]); ?>
                    <?php echo e(__('Time-Out')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','id' => 'btnTimeOut','name' => 'btnTimeOut']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','id' => 'btnTimeOut','name' => 'btnTimeOut']); ?>
                    <?php echo e(__('Time-Out')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>




<div class="modal fade" id="modalTimeLogCam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header banner-blue">
            <h4 class="modal-title text-lg text-white">Capture Image for Timelog</h4>
            <button id="closeLogCamModal" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
        </div>
      <div class="modal-body">
        <!-- content -->
        <div class="container">
            <form id="formWebCam">
                <?php echo csrf_field(); ?>

                <div id="image-capture-container">
                  <video id="video-element" hidden></video>
                  <canvas id="canvas-element" hidden></canvas>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="logCamera"></div>
                        <input type="hidden" name="image" class="image-tag text-center rounded-md">
                    </div>
                    <div class="col-md-6 text-center">
                        <div id="results" class="hidden rounded-md"></div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-12 text-center">
                        <input id="logEvent" hidden>
                        <input type="button" id="takeSnapshot" value="Take Snapshot" class="btn btn-primary ">
                    </div>
                </div>
                

            </form>
        </div>

      </div>
    </div>
  </div>
</div>


</nav>

    
    <script type="text/javascript" src="<?php echo e(asset('/popper/js/bootstrap.bundle.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/bootstrap-5.0.2-dist/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/nav-bar/bootstrap5-dropdown-ml-hack.js')); ?>"></script>

<!-- NAVIGATOR end -->

<script type="text/javascript">
$(document).ready(function(){

    let has_supervisor = "<?php echo e(Auth::user()->supervisor); ?>";
    let role_type = "<?php echo e(Auth::user()->role_type); ?>";

    Pusher.logToConsole = true;

    var pusher = new Pusher('264cb3116052cba73db3', {
      cluster: 'us2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind("my-event", function(data) {
      // alert(data);
      // alert(JSON.stringify(data));
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          // url: window.location.origin+'/file-preview-memo',
          url: "<?php echo e(route('counts_pusher')); ?>",
          method: 'get',
          data: JSON.stringify(data), // prefer use serialize method
          success:function(data){
            $("#nav-memo-counter").text(data.memo_counts);
            // alert('Hey Gibs');
          }
      });
    }); 


    $("#dNavEleave").on('click', function(e){
        // if  (role_type!='SUPER ADMIN') {
            if ( has_supervisor=='' || has_supervisor==null ) {
                Swal.fire({
                    // icon: 'error',
                    title: 'NOTIFICATION',
                    html: 'Kindly ask HR for the supervisor to be assigned. <br>Thank you!',

                  });
                return false;
            } 
        // }
    });


    /**
    * This will capture temporary photo using webcam
    */
    $("#saveTempPhoto").click(function() {

        var data_uri = $("#capturedPhoto").attr("src");
        Webcam.reset( '#logCamera' );

        $('#divPhotoPreview1').addClass('hidden');
        $('#divPhotoPreview2').empty();
        $('#divPhotoPreview2').css('display','flex');
        $('#divPhotoPreview2').append('<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url('+data_uri+')"></span>');
        // alert("<?php echo e(route('webcam.capture')); ?>"); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "<?php echo e(route('webcam.capture')); ?>",
            method: 'post',
            data: $("#formWebCam").serialize(),
            success:function(data){
                $("#modalWebCam").modal("hide");
                // alert(data); return false;
                Webcam.reset( '#logCamera' );
                $("#divPhotoPreview1").addClass("hidden");
                $("#divPhotoPreview2").addClass("hidden");
                $("#divPhotoPreview3").removeClass("hidden");
                $("#profilePhotoPreview").attr("src",data);

                // $("#modalWebCam").modal("show");

            }
        });
        return false;
    });
});


/* TIME-LOGS CAPTURE */

$(document).ready(function() {
  // Variables for video element, canvas, and media stream
  var video = document.getElementById('video-element');
  var canvas = document.getElementById('canvas-element');
  var stream = null;

  // Function to start the webcam
  function startWebcam() {
    // Access the user's webcam
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(mediaStream) {
        // Store the media stream for later use
        stream = mediaStream;
        video.srcObject = mediaStream;
        video.play();
      })
      .catch(function(error) {
        // Display an error message using Swal
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to access webcam!',
        });
      });
  }

  // Function to capture an image
  function captureImage() {

    if (stream !== null) {
      // Pause the video playback
      video.pause();

      // Draw the current video frame onto the canvas
      var context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to a data URL
      var dataURL = canvas.toDataURL('image/png');


      // Display the captured image using Swal
      Swal.fire({
        // title: 'Captured Image',
        imageUrl: dataURL,
        imageAlt: 'Captured Image',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonText: 'Save',
      }).then(function(result) {
        if (result.isConfirmed) {
            $("#modalTimeLogCam").modal("hide");
          // Handle saving the image (e.g., send to server, download, etc.)

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "<?php echo e(route('save.timelogs')); ?>",
            method: 'post',
            data: {'logEvent':$("#logEvent").val(), 'image':dataURL},
            success:function(data){
                if (data.isSuccess==true) {
                  // Display a success message using Swal
                  Swal.fire({
                    icon: 'success',
                    title: 'Image saved successfully!',
                    // text: dataURL,
                  });
                  video.currentTime = 0;
                  video.style.display = "none";
                  // alert(window.location.href);
                  setTimeout(function() {
                    location.reload();
                  }, 5000);

                  $("#btnTimeIn").prop('disabled', true);
                  $("#btnTimeOut").prop('disabled', false);
                }
            }
        });


        } else {
          // Resume video playback
          video.play();
        }
      });
    }
  }

  // Event handler for the capture button
    $('#btnTimeIn').click(function() {

        $("#modalTimeLogCam").modal("show");
        $("#logEvent").val("TimeIn");

        Webcam.set({
            width: 430,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                video: {
                    facingMode: "user",
                    mirror: true
                }
            }
        });

        Webcam.attach( '#logCamera' );

        // Start the webcam when the page loads
        startWebcam();
        // $("#modalTimeLogCam").modal("show");

    });

    $('#btnTimeOut').click(function() {
        // alert('Gibs'); return false;

        $("#modalTimeLogCam").modal("show");
        $("#logEvent").val("TimeOut");

        Webcam.set({
            width: 430,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                video: {
                    facingMode: "user",
                    mirror: true
                }
            }
        });

        Webcam.attach( '#logCamera' );

        // Start the webcam when the page loads
        startWebcam();
        // $("#modalTimeLogCam").modal("show");

    });

    // Capture image for Time Logs
    $('#takeSnapshot').click(function() {
        captureImage();
    });

    // Closing Camera Modal
    $("#closeLogCamModal").click(function() {
        Webcam.reset( '#logCamera' );
        location.reload();
    });

});
</script><?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/navigation-menu.blade.php ENDPATH**/ ?>