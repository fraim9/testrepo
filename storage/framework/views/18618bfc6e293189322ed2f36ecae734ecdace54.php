<?php $__env->startSection('content'); ?>

	<!-- Hero -->
        <div class="hero bg-white overflow-hidden">
            <div class="hero-inner">
                <div class="content content-full text-center">
                    
					<div class="container invisible" data-toggle="appear" data-class="animated fadeInDown">
					    <div class="row justify-content-center">
					        <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6">
					            <div class="card">
					                
					                <div class="form-group row mb-5">
			                            <div class="col-sm-7 offset-sm-3">
			                                <img src="<?php echo e(asset('media/logo.png')); ?>">
			                            </div>
			                        </div>
									
									
					                <div class="card-body">
					                    <form method="POST" action="<?php echo e(route('login')); ?>">
					                        <?php echo csrf_field(); ?>
					
					                        <div class="form-group row">
					                            <label for="email" class="col-sm-4 col-form-label text-sm-right"><?php echo e(__('E-Mail Address')); ?></label>
					
					                            <div class="col-sm-6">
					                                <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
					
					                                <?php if($errors->has('email')): ?>
					                                    <span class="invalid-feedback" role="alert">
					                                        <strong><?php echo e($errors->first('email')); ?></strong>
					                                    </span>
					                                <?php endif; ?>
					                            </div>
					                        </div>
					
					                        <div class="form-group row">
					                            <label for="password" class="col-sm-4 col-form-label text-sm-right"><?php echo e(__('Password')); ?></label>
					
					                            <div class="col-sm-6">
					                                <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>
					
					                                <?php if($errors->has('password')): ?>
					                                    <span class="invalid-feedback" role="alert">
					                                        <strong><?php echo e($errors->first('password')); ?></strong>
					                                    </span>
					                                <?php endif; ?>
					                            </div>
					                        </div>
					
					                        <div class="form-group row">
					                            <div class="col-sm-6 offset-sm-4  text-left">
					                                <div class="form-check">
					                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
					
					                                    <label class="form-check-label" for="remember">
					                                        <?php echo e(__('Remember Me')); ?>

					                                    </label>
					                                </div>
					                            </div>
					                        </div>
					
					                        <div class="form-group row mb-0">
					                            <div class="col-sm-6 offset-sm-4 text-left">
					                                <button type="submit" class="btn btn-primary btn-block btn-lg">
					                                    <?php echo e(__('Login')); ?>

					                                </button>
					
					                                <?php if(false && Route::has('password.request')): ?>
					                                    <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
					                                        <?php echo e(__('Forgot Your Password?')); ?>

					                                    </a>
					                                <?php endif; ?>
					                            </div>
					                        </div>
					                    </form>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>


                </div>
            </div>
        </div>
    <!-- END Hero -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/auth/login.blade.php ENDPATH**/ ?>