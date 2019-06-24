<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	        
	        	<div class="block">
					<form method="post" action="<?php echo e(route('timeZones.store', $zone ? $zone->id : 0)); ?>">
						<?php echo csrf_field(); ?>
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title"><?php echo e(__($zone ? 'Edit time zone' : 'Add time zone')); ?></h3>
    	        		</div>
    					<div class="block-content">
							<?php echo $__env->make('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code', 
								'required' => true,
								'value' => $zone->code ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name',
								'required' => true,
								'value' => $zone->name ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formText', [
								'name' => 'offset', 
								'label' => 'Offset', 
								'required' => true,
								'value' => $zone->offset ?? ''
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