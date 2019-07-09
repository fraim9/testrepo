<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
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
								'name' => 'password', 
								'label' => 'Password', 
								'description' => 'Here you can set a new password', 
								'value' => ''
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
							
    					</div>
    					
    					<?php echo $__env->make('helpers.formButtons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>