

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('layouts.backendPageHero', [
    	'title' => 'Prices',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add price',
                'url' => route('prices.form', 0)
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
		        			<th><?php echo e(__('Action')); ?></th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	<?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        		<tr>
			        			<td><?php echo e($price->name); ?></td>
			        			<td><?php echo e($price->code); ?></td>
			        			<td class="text-center">
									<div class="btn-group">
										<?php echo $__env->make('helpers.btnEdit', [
											'url' => route('prices.form', $price->id), 
											'title' => 'Edit price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php echo $__env->make('helpers.btnDelete', [
											'url' => route('prices.delete', $price->id), 
											'title' => 'Remove price',
											'confirm' => 'Remove price?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
					{ "width": "80px", targets: [ 2 ] }
				]
            });

        });
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>