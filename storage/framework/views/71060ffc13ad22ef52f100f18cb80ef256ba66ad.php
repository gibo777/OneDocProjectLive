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
     <?php $__env->slot('header', null, []); ?> 
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> -->
        <h2 class="font-semibold text-xl leading-tight text-center pt-1">
            <?php echo e(__('PASSWORD CREATION')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

        <!-- <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.validation-errors','data' => ['class' => 'mb-1']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> -->
    
    <?php if($isForbidden): ?>
        <div class="max-w-6xl mx-auto py-2 sm:px-6 lg:px-8">
            The current user has no rights for this link
        </div>
    <?php else: ?>
        <?php if($isExpired): ?>
        <div class="max-w-6xl mx-auto py-2 sm:px-6 lg:px-8">
            Link Expired
        </div>
        <?php else: ?>
        <div class="w-full mx-auto py-2 sm:max-w-md lg:px-8">
            <form method="POST" action="<?php echo e(route('verification.verify')); ?>">
                <?php echo csrf_field(); ?>

            <div class="px-4 py-4 bg-white sm:p-6 shadow <?php echo e(isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'); ?>">
                <?php if(session('status')): ?>
                    <div class="font-medium text-center text-green-600">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                
                

                <div class="max-w-6xl mx-auto mt-1">
                
                
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 p-1 form-floating">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'email','class' => 'form-control block mt-1 w-full','type' => 'email','name' => 'email','value' => $_GET['email'],'placeholder' => 'Email','required' => true,'autofocus' => true,'autocomplete' => 'off','readonly' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'email','class' => 'form-control block mt-1 w-full','type' => 'email','name' => 'email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($_GET['email']),'placeholder' => 'Email','required' => true,'autofocus' => true,'autocomplete' => 'off','readonly' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 p-1 form-floating">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'password','class' => 'form-control block mt-1 w-full','type' => 'password','name' => 'password','placeholder' => 'Password','required' => true,'autocomplete' => 'new-password']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'password','class' => 'form-control block mt-1 w-full','type' => 'password','name' => 'password','placeholder' => 'Password','required' => true,'autocomplete' => 'new-password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
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
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
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
<?php endif; ?>
                        <ul class="list-unstyled"><br>
                            
                            <li class="passconfirm"></li>
                        </ul>
                    </div>
                </div>
                    <?php if(Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature()): ?>
                        <div class="mt-4">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'terms']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'terms']); ?>
                                <div class="flex items-center">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['name' => 'terms','id' => 'terms']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'terms','id' => 'terms']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                    <div class="ml-2">
                                        <?php echo __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                        ]); ?>

                                    </div>
                                </div>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center justify-center mt-2">
                        <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="<?php echo e(route('login')); ?>">
                            <?php echo e(__('Already registered?')); ?>

                        </a> -->

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['id' => 'btnsubmit','class' => 'ml-4']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'btnsubmit','class' => 'ml-4']); ?>
                            <?php echo e(__('Create Password')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <input style="display:none" value="<?php echo e($_GET['token']); ?>" name="remember_token">
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    







    <script>
        $(function() {
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

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
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

            } else {

                $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password is a match ');


            }
                    });

            });

            $('#password_confirmation').keyup(function() {
                    if($('#password_confirmation').text()==""){


            }
                        if ($('#password').val() != $('#password_confirmation').val()) {

                        $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></span>&nbsp; Password is not a match ');

                        } else {

                            $('.passconfirm').empty();
            $('.passconfirm').append('<span><i class="fa fa-check-circle text-success" aria-hidden="true"></i></span>&nbsp; Password is a match ');


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

    <script type="text/javascript">
        // alert($(window).width());
        if ($(window).width() <= 460) {
            $("#companyLogo").removeClass('w-33');
        } else {
            $("#companyLogo").addClass('w-33');
        }
        /*if(window.matchMedia("(max-width: 767px)").matches){
            // The viewport is less than 768 pixels wide
            $("#companyLogo").addClass('w-33');
        } else{
            // The viewport is at least 768 pixels wide
            $("#companyLogo").removeClass('w-33');
        }*/
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/auth/createPassword.blade.php ENDPATH**/ ?>