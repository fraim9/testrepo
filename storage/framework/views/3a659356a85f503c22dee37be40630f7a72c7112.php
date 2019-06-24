<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="<?php echo e(route('userGroups.store', $group ? $group->id : 0)); ?>">
						<?php echo csrf_field(); ?>
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title"><?php echo e(__($group ? 'Edit group' : 'Add group')); ?></h3>
    	        		</div>
    					<div class="block-content">
							
							<?php echo $__env->make('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name', 
								'required' => true,
								'value' => $group->name ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php if($userRights): ?>
								<?php $__currentLoopData = $userRights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userRight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo $__env->make('helpers.formSelect', [
										'name' => 'ipos_rights[' . $userRight->id . ']', 
        								'label' => $userRight->name, 
        								'required' => false,
        								'value' => $group->ipos_rights[$userRight->id] ?? '',
        								'options' => $userRightValues[$userRight->id]
        							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
							
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