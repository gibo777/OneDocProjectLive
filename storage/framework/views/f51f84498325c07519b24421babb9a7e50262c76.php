<link rel="shortcut icon" href="<?php echo e(asset('img/all/onedoc-favicon.png')); ?>">
<?php if (isset($component)) { $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\GuestLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
	<div class="max-w-5xl mx-auto mt-6 py-3 sm:px-6 lg:px-8">
        <div class="px-2 py-3 bg-white sm:p-6 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
        		<?php if(isset($qrProfile)): ?>
        		<div class="row px-3">
		           	<div class="col-md-3 d-flex align-items-center justify-content-center my-2" x-show="!photoPreview">
		           		<?php if($qrProfile->profile_photo_path!=null): ?>
					    	<img id="imgProfile" src="<?php echo e(asset('/storage/'.$qrProfile->profile_photo_path)); ?>" class="rounded h-id w-id object-cover">
					    <?php else: ?>
					    	<?php if($qrProfile->gender=='M'): ?>
					    	<img id="imgProfile" src="<?php echo e(asset('storage/profile-photos/default-formal-male.png')); ?>" class="rounded h-id w-id object-cover">
					    	<?php elseif($qrProfile->gender=='F'): ?>
					    	<img id="imgProfile" src="<?php echo e(asset('storage/profile-photos/default-female.png')); ?>" class="rounded h-id w-id object-cover">
					    	<?php else: ?>
					    	<img id="imgProfile" src="<?php echo e(asset('storage/profile-photos/default-photo.png')); ?>" class="rounded h-id w-id object-cover">
					    	<?php endif; ?>
					    <?php endif; ?>
					</div>

                    <div class="col-md-9 mt-2">
						<table id="dataViewEmployees" class="view-employees table table-bordered table-striped sm:justify-center table-hover">
						    
						    <tbody class="data" id="viewEmployee">
						            <tr id="<?php echo e($qrProfile->id); ?>">
						            	<td class="thead">Name</td>
						                <td colspan="3"><?php echo e(join(' ',[$qrProfile->last_name.' '.$qrProfile->suffix.',',$qrProfile->first_name,$qrProfile->middle_name])); ?></td>
						            </tr>
						            <tr id="<?php echo e($qrProfile->id); ?>">
						            	<td class="thead">Position</td>
						                <td><?php echo e($qrProfile->position); ?></td>
						            </tr>
						            <tr id="<?php echo e($qrProfile->id); ?>">
						            	<td class="thead">Date Hired</td>
						                
						                <td><?php echo e($qrProfile->date_hired); ?></td>
						            </tr>
						            <tr id="<?php echo e($qrProfile->id); ?>">
						            	<td class="thead">Status</td>
						                <td><?php echo e($qrProfile->employment_status); ?></td>
						            </tr>
						    </tbody>
						</table>
                    </div>

	            </div>
	            <?php else: ?>
        		<div class="row px-3">
        			Invalid Link
        		</div>
	            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?><?php /**PATH C:\xampp\OneDocProject\htdocs\OneDocProjectLive\resources\views/profile/qr-code-profile.blade.php ENDPATH**/ ?>