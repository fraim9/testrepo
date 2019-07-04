

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('layouts.backendPageHero', [
    	'title' => 'Stores',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add store',
                'url' => route('stores.form', 0)
            ]
    	]
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Page Content -->
    <div class="content">
        <div class="block">
        	<div class="block-content">
        	
		        <table class="table table-bordered table-hover table-vcenter js-dataTable">
		        	<thead>
		        		<tr>
		        			<th><?php echo e(__('Name')); ?></th>
		        			<th><?php echo e(__('External ID')); ?></th>
		        			<th><?php echo e(__('Phone')); ?></th>
		        			<th><?php echo e(__('Store group')); ?></th>
		        			<th><?php echo e(__('Currency')); ?></th>
		        			<th><?php echo e(__('Action')); ?></th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	<?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        		<tr>
			        			<td>
			        				<?php echo e($store->name); ?>

			        				<div class="text-small text-muted"><?php echo e($store->address); ?></div>
			        			</td>
			        			<td><?php echo e($store->code); ?></td>
			        			<td><?php echo e($store->phone); ?></td>
			        			<td><?php echo e($store->group->name); ?></td>
			        			<td><?php echo e($store->currency); ?></td>
			        			<td class="text-center">
									<div class="btn-group">
										<?php echo $__env->make('helpers.btnEdit', [
											'url' => route('stores.form', $store->id), 
											'title' => 'Edit user'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php echo $__env->make('helpers.btnDelete', [
											'url' => route('stores.delete', $store->id), 
											'title' => 'Remove store',
											'confirm' => 'Remove store?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									</div>
								</td>
			        		</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			        </tbody>
		        </table>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
<?php $__env->stopSection(); ?>




<?php $__env->startSection('css_after'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/dataTables.bootstrap4.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_after'); ?>
	<script src="<?php echo e(asset('js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    
    <script>
        jQuery(function(){

        	// Init full DataTable
            jQuery('.js-dataTable').dataTable({
            	'columnDefs': [
					{ "width": "80px", targets: [ 4 ] }
				]
            });

        });
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>