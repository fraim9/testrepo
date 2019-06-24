<?php $__env->startSection('content'); ?>
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="<?php echo e(route('stores.store', $store ? $store->id : 0)); ?>">
						<?php echo csrf_field(); ?>
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title"><?php echo e(__($store ? 'Edit store' : 'Add store')); ?></h3>
    	        		</div>
    					<div class="block-content">
							
							<?php echo $__env->make('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name', 
								'required' => true,
								'value' => $store->name ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code',
								'required' => true,
								'value' => $store->code ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formTextarea', [
								'name' => 'description', 
								'label' => 'Description', 
								'value' => $store->description ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formText', [
								'name' => 'phone', 
								'label' => 'Phone', 
								'value' => $store->phone ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formTextarea', [
								'name' => 'address', 
								'label' => 'Address', 
								'value' => $store->address ?? ''
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'group_id', 
								'label' => 'Store group', 
								'value' => $store->group_id ?? '',
								'options' => array_column($storeGroups->toArray(), 'name', 'id')
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'country_id', 
								'label' => 'Country', 
								'value' => $store->country_id ?? '',
								'options' => array_column($countries->toArray(), 'name', 'id')
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'city_id', 
								'label' => 'City', 
								'value' => $store->city_id ?? '',
								'options' => array_column($cities->toArray(), 'name', 'id')
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'time_zone_id', 
								'label' => 'Time zone', 
								'value' => $store->time_zone_id ?? '',
								'options' => $timeZones
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'price_id', 
								'label' => 'Price group', 
								'value' => $store->price_id ?? '',
								'options' => array_column($prices->toArray(), 'name', 'id')
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<?php echo $__env->make('helpers.formSelect', [
								'name' => 'currency', 
								'label' => 'Currency', 
								'value' => $store->currency ?? '',
								'options' => array('RUB' => 'RUB', 'USD' => 'USD', 'EUR' => 'EUR')
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