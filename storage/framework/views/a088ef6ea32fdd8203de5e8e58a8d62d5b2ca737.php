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
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.authentication-card','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-authentication-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('logo', null, []); ?> 
         <?php $__env->endSlot(); ?>
            <div class="drop-shadow">
                <img src="<?php echo e(asset('/img/company/onedoc-logo.png')); ?>" class="rounded mx-auto d-block py-2"/>
                <!-- <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.authentication-card-logo','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-authentication-card-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> -->
            </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.validation-errors','data' => ['class' => 'mb-4']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.update')); ?>">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

            <div class="block">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'email','value' => ''.e(__('Email')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email','value' => ''.e(__('Email')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'email','class' => 'block border-0 bg-white shadow-none w-full','type' => 'email','name' => 'email','value' => old('email', $request->email),'readonly' => true,'autofocus' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'email','class' => 'block border-0 bg-white shadow-none w-full','type' => 'email','name' => 'email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email', $request->email)),'readonly' => true,'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>

            <div class="mt-2">
                <!-- <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'password','value' => ''.e(__('Password')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password','value' => ''.e(__('Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'password','class' => 'block mt-1 w-full','type' => 'password','name' => 'password','required' => true,'autocomplete' => 'new-password']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'password','class' => 'block mt-1 w-full','type' => 'password','name' => 'password','required' => true,'autocomplete' => 'new-password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> -->


                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'password','value' => ''.e(__('New Password')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password','value' => ''.e(__('New Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div class="input-group mb-3">
                  <input name="password" type="password" value="" class="input form-control " id="password" placeholder="New Password" required="true" aria-label="password" aria-describedby="basic-addon1" autocomplete="new-password"/>
                  <div class="input-group-append hover" id="eye_view1">
                    <span class="input-group-text">
                      <i class="fas fa-eye hover" id="show_eye1"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye1"></i>
                    </span>
                  </div>
                </div>
                <div id="popover-password">
                    <p>Password Strength: <span id="result"> </span></p>
                    <div class="progress">
                        <div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        </div>
                    </div>
                    <ul class="list-unstyled">
                        <li class=""><span class="low-case"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; 1 lowercase </li>
                        <li class=""><span class="upper-case"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; 1 uppercase</li>

                        <li class=""><span class="one-number"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span> &nbsp;1 number (0-9)</li>
                        <li class=""><span class="one-special-char"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span> &nbsp;1 Special Character (!@#$%^&*).</li>
                        <li class=""><span class="eight-character"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Atleast 8 Characters</li>
                    </ul>
                </div>
            </div>

            <div class="mt-2">
                <!-- <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'password_confirmation','value' => ''.e(__('Confirm Password')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password_confirmation','value' => ''.e(__('Confirm Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'password_confirmation','class' => 'block mt-1 w-full','type' => 'password','name' => 'password_confirmation','required' => true,'autocomplete' => 'new-password']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'password_confirmation','class' => 'block mt-1 w-full','type' => 'password','name' => 'password_confirmation','required' => true,'autocomplete' => 'new-password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> -->


                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'password_confirmation','value' => ''.e(__('Confirm Password')).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password_confirmation','value' => ''.e(__('Confirm Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div class="input-group mb-3">
                  <input name="password_confirmation" type="password" value="" class="input form-control " id="password_confirmation" placeholder="Confirm Password" required="true" aria-label="password" aria-describedby="basic-addon1" autocomplete="current-password"/>
                  <div class="input-group-append hover" id="eye_view2">
                    <span class="input-group-text">
                      <i class="fas fa-eye hover" id="show_eye2"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                    </span>
                  </div>
                </div>
                <ul class="list-unstyled"><br>
                    <li class="passconfirm"></li>
                  </ul>
            </div>

            <div class="flex items-center justify-end mt-4">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['class' => 'w-full']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full']); ?>
                    <?php echo e(__('Reset Password')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function(){

        $("#eye_view1").on('click', function(e) {
            var x = $("#password");
            var show_eye = $("#show_eye1");
            var hide_eye = $("#hide_eye1");
            if (x.prop('type') === "password") {
                x.prop('type','text');
                show_eye.addClass("d-none");
                hide_eye.removeClass("d-none");
            } else {
                x.prop('type','password');
                show_eye.removeClass("d-none");
                hide_eye.addClass("d-none");
            }
          // return false;
        });
        $("#eye_view2").on('click', function(e) {
            var y = $("#password_confirmation");
            var show_eye = $("#show_eye2");
            var hide_eye = $("#hide_eye2");
            if (y.prop('type') === "password") {
                y.prop('type','text');
                show_eye.addClass("d-none");
                hide_eye.removeClass("d-none");
            } else {
                y.prop('type','password');
                show_eye.removeClass("d-none");
                hide_eye.addClass("d-none");
            }
          // return false;
        });

        // $(document).on('keyup keydown hover click mouseenter mouseover', function(){
        // $("#audio-button").click();
        // });
        // $("#audio-button").click(function() {
        // $("#audio-background")[0].play(); return false;
        // });
    });
</script>
<script>
    $(function() {
        /*$('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');*/

        // $('#btnsubmit').attr('disabled','disabled');
        var checkfn=$('#first_name').val();
        let checkln=$('#last_name').val();
        let checkmn=$('#middle_name').val();
        let checkempnum=$('#employee_id').val();
        let checkpos=$('#position').val();
        let checkdept=$('#department').val();
        let checkemail=$('#email').val();
        let checkpass=$('#password').val();
        let checkconfpass=$('#password_confirmation').val();

        // $('#btnsubmit').attr('disabled','disabled');
        // if(checkfn!=""&&checkln!=""&&checkmn!=""&&checkempnum!=""&&checkpos!=""&&checkdept!=""&&checkemail!=""&&checkpass=="Very Strong"&&checkconfpass=="  Password is a match "){
        //     $('#btnsubmit').RemoveAttr('disabled');
        // }

        $('#password').keyup(function() {
    var password = $('#password').val();
    if (checkStrength(password) == false) {
        $('#sign-up').attr('disabled', true);
    }

     if($('#password_confirmation').text()==""){
        $('.passconfirm').empty();

    }
    if ($('#password').val() != $('#password_confirmation').val()) {

    $('.passconfirm').empty();
    $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');

    } else {

    $('.passconfirm').empty();
    $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password matched!');


    }
    });

    });

    $('#password_confirmation').keyup(function() {
    if($('#password_confirmation').text()==""){


    }
        if ($('#password').val() != $('#password_confirmation').val()) {
            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password do not a match!');
        } else {
            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password matched!');
        }
    });
    function checkStrength(password) {
    var strength = 0;


    //If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z])/)) {
        strength += 1;
        $('.low-case').addClass('text-success');
        $('.low-case i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
        $('#popover-password-top').addClass('hide');


    } else {
        $('.low-case').removeClass('text-success');

        $('.low-case i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
        $('#popover-password-top').removeClass('hide');
    }
    if (password.match(/([A-Z])/)) {
        strength += 1;
        $('.upper-case').addClass('text-success');
        $('.upper-case i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
        $('#popover-password-top').addClass('hide');


    } else {
        $('.upper-case').removeClass('text-success');

        $('.upper-case i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
        $('#popover-password-top').removeClass('hide');
    }

    //If it has numbers and characters, increase strength value.
if ( password.match(/([0-9])/)) {
        strength += 1;
        $('.one-number').addClass('text-success');
        $('.one-number i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.one-number').removeClass('text-success');
        $('.one-number i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
        $('#popover-password-top').removeClass('hide');
    }

    //If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        $('.one-special-char').addClass('text-success');
        $('.one-special-char i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.one-special-char').removeClass('text-success');
        $('.one-special-char i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
        $('#popover-password-top').removeClass('hide');
    }

    if (password.length > 7) {
        strength += 1;
        $('.eight-character').addClass('text-success');
        $('.eight-character i').removeClass('fa-exclamation-circle text-danger').addClass('fa-check-circle text-success');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.eight-character').removeClass('text-success');
        $('.eight-character i').addClass('fa-exclamation-circle text-danger').removeClass('fa-check-circle text-success');
        $('#popover-password-top').removeClass('hide');
    }
    if($('#password').val()==""){
        $('#password-strength').removeAttr('width');

    }



    // If value is less than 2
    // if(strength ==0){
    //     $('#result').removeClass()
    //     $('#password-strength').addClass('progress-bar-danger');

    //     $('#result').addClass('text-danger').text('Very Week');
    //     $('#password-strength').css('width', '0%');
    // }
    if (strength ==1) {
        $('#result').removeClass();
        $('#password-strength').addClass('progress-bar-danger');

        $('#result').addClass('text-danger').text('Poor');
        $('#password-strength').css('width', '20%');
        $('#password-strength').css('background-color', 'red');

    }
    else if(strength ==0){
        $('#result').removeClass()
        // $('#password-strength').addClass('progress-bar-danger');

        $('#result').addClass('text-danger').text('');
        $('#password-strength').css('width', '0%');
    } else if (strength == 2) {
        $('#result').addClass('good');
        $('#password-strength').removeClass('progress-bar-danger');
        $('#password-strength').addClass('progress-bar-warning');
        $('#result').addClass('text-danger').text('Weak')
        $('#password-strength').css('width', '40%');
        $('#password-strength').css('background-color', 'red');
        return 'Weak'
    }
    else if (strength == 3) {
        $('#result').addClass('good');
        $('#password-strength').removeClass('progress-bar-danger');
        $('#password-strength').addClass('progress-bar-warning');
        $('#result').addClass('text-success').text('Good');
        $('#password-strength').css('width', '60%');
        $('#password-strength').css('background-color', 'green');
        return 'Week'
    } else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-strength').removeClass('progress-bar-warning');
        $('#password-strength').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Strong');
        $('#password-strength').css('width', '80%');
        $('#password-strength').css('background-color', 'green');
        return 'Strong'
    }
    else if (strength == 5) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-strength').removeClass('progress-bar-warning');
        $('#password-strength').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Very Strong');
        $('#password-strength').css('width', '100%');
        $('#password-strength').css('color', 'green');
        return 'Strong'
    }

}
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>