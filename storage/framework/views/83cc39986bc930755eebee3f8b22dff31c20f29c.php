<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
	        	
	        		<?php if($token): ?>
    	        		<div class="row justify-content-center">
    	        			<div class="col-md-4 col-sm-6 p-5">
   			        			<img src="data:image/png;base64,<?php echo base64_encode(QrCode::format('png')->size('1000')->generate($token)); ?>" width="200" height="200">
    	        			</div>
    	        		</div>
    	        		<div class="text-center" style="color:#fff;"><?php echo e($token); ?></div>
	        		<?php endif; ?>
	        	
					<form method="post" action="<?php echo e(route('users.store', $user ? $user->id : 0)); ?>">
						<?php echo csrf_field(); ?>
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title"><?php echo e(__($user ? 'Edit user' : 'Add user')); ?></h3>
    	        		</div>
    					<div class="block-content">
							
							<?php echo $__env->make('helpers.formText', [
								'name' => 'username', 
								'label' => 'Username', 
								'required' => true,
								'value' => $user->username ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formText', [
								'name' => 'display_name', 
								'label' => 'Display name', 
								'required' => true,
								'value' => $user->display_name ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formText', [
								'name' => 'email', 
								'label' => 'E-mail', 
								'required' => true,
								'value' => $user->email ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'role_id', 
								'label' => 'ACL Role', 
								'value' => $user->role_id ?? '',
								'options' => array_column($roles->toArray(), 'name', 'id'),
								'required' => true,
								'emptyValue' => true,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'employee_id', 
								'label' => 'Employee', 
								'value' => $user->employee_id ?? '',
								'options' => array_column($employees->toArray(), 'name', 'id'),
								'emptyValue' => true,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'group_id', 
								'label' => 'User group', 
								'required' => true,
								'value' => $user->group_id ?? '',
								'options' => array_column($userGroups->toArray(), 'name', 'id')
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formCheckbox', [
								'name' => 'email_subscribe', 
								'label' => 'Email subscribe', 
								'value' => $user->email_subscribe ?? true,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php echo $__env->make('helpers.formCheckbox', [
								'name' => 'active', 
								'label' => 'User is active', 
								'value' => $user->active ?? true,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<hr>
							
							<div class="form-group row">
								<div class="col-md-4 text-md-right text-md-right">
									<label class="col-form-label"><?php echo e(__('Stores')); ?></label>
								</div>
								<div class="col-md-8">
									<?php if($stores): ?>
        								<?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        									<div class="custom-control custom-switch pb-2">
                                                <input type="checkbox" class="custom-control-input" value="<?php echo e($store->id); ?>"
                                                	id="store_<?php echo e($store->id); ?>" name="stores[]" <?php echo e(isset($userStores[$store->id]) ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="store_<?php echo e($store->id); ?>"><?php echo e($store->name); ?></label>
                                    		</div>
        								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        							<?php endif; ?>
								</div>
							
							</div>
							
							<hr>
							<h6><?php echo e(__('Set new password')); ?></h6>
							
							<?php echo $__env->make('helpers.formText', [
								'name' => 'password', 
								'label' => 'Password', 
								'description' => 'Here you can set a new password', 
								'value' => ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php echo $__env->make('helpers.formCheckbox', [
								'name' => 'qrcode', 
								'label' => 'Generate DataMatrix Code', 
								'value' => false,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
    					</div>
    					
    					<?php echo $__env->make('helpers.formButtons', array('deleteUrl' => route('users.delete', $user->id)), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/users/users/form.blade.php ENDPATH**/ ?>