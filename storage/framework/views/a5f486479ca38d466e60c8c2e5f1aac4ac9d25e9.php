<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	        
	        	<div class="block">
					<form method="post" action="<?php echo e(route('countries.store', $country ? $country->id : 0)); ?>">
						<?php echo csrf_field(); ?>
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title"><?php echo e(__($country ? 'Edit country' : 'Add country')); ?></h3>
    	        		</div>
    					<div class="block-content">
							<?php echo $__env->make('helpers.formText', [
								'name' => 'iso2', 
								'label' => 'Iso 2', 
								'required' => true,
								'value' => $country->iso2 ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formText', [
								'name' => 'iso3', 
								'label' => 'Iso 3', 
								'required' => true,
								'value' => $country->iso3 ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name',
								'required' => true,
								'value' => $country->name ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formText', [
								'name' => 'calling_code', 
								'label' => 'Calling code', 
								'required' => true,
								'value' => $country->calling_code ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php echo $__env->make('helpers.formCheckbox', [
								'name' => 'aml_risk', 
								'label' => 'AML Risk', 
								'value' => $country->aml_risk ?? false,
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