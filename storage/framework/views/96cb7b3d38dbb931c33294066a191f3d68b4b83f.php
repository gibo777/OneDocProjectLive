

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

<!-- Fonts -->


<!-- Styles -->
<link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
<!-- <link rel="stylesheet" href="<?php echo e(asset('/font-awesome/css/font-awesome.min.css')); ?>"> -->
<!-- font awesome  -->
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" /> -->

<link rel="stylesheet" href="<?php echo e(asset('/fontawesome-6.2.0/css/all.css')); ?>">

<!-- Scripts -->
<script src="<?php echo e(mix('js/app.js')); ?>" defer></script>





<script type="text/javascript" src="<?php echo e(asset('/js/jquery-3.6.0.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('/css/bootstrap.min.css')); ?>">




<script type="text/javascript" src="<?php echo e(asset('/bootstrap-5.0.2-dist/js/bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('/js/jquery.backstretch.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/scripts.js')); ?>"></script>

    </head>
    <body>
        <?php if(isset($header)): ?>
            <header id="module_header" class="bg-white shadow banner-blue font-white-bold hover">
                <!-- <div class="max-w-7xl mx-auto py-2 px-2 sm:px-6 lg:px-8"> -->
                <div class=" mx-auto py-1 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>
        <div class="font-sans text-gray-900 antialiased">
            <?php echo e($slot); ?>

        </div>

    </body>
</html>
<?php /**PATH C:\xampp\OneDocProject\htdocs\OneDocProjectLive\resources\views/layouts/guest.blade.php ENDPATH**/ ?>