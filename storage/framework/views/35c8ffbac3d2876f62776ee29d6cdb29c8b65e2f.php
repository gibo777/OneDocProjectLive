<?php foreach($attributes->onlyProps(['submit']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['submit']); ?>
<?php foreach (array_filter((['submit']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'md:grid md:grid-cols-5 md:gap-3'])); ?>>

    <div class="mt-1 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="<?php echo e($submit); ?>">
            <div class="px-3 py-3 bg-white sm:p-3 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
                <div class="grid grid-cols-6 gap-4">
                    <?php echo e($form); ?>

                </div>
            </div>

            <?php if(isset($actions)): ?>
                <div class="flex items-center justify-center px-2 py-2 bg-gray-50 text-right sm:px-3 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <?php echo e($actions); ?>

                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp\OneDocProject\htdocs\OneDocProjectLive\resources\views/vendor/jetstream/components/gilbert.blade.php ENDPATH**/ ?>