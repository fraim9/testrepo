

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('layouts.backendPageHero', [
    	'title' => 'Countries',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add country',
                'url' => route('countries.form', 0)
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
		        			<th><?php echo e(__('ISO 2')); ?></th>
		        			<th><?php echo e(__('ISO 3')); ?></th>
		        			<th><?php echo e(__('Name')); ?></th>
		        			<th><?php echo e(__('Calling code')); ?></th>
		        			<th><?php echo e(__('Action')); ?></th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        		<tr>
			        			<td><?php echo e($country->iso2); ?></td>
			        			<td><?php echo e($country->iso3); ?></td>
			        			<td><?php echo e($country->name); ?></td>
			        			<td><?php echo e($country->calling_code); ?></td>
			        			<td class="text-center">
									<div class="btn-group">
										<?php echo $__env->make('helpers.btnEdit', [
											'url' => route('countries.form', $country->id), 
											'title' => 'Edit country'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php echo $__env->make('helpers.btnDelete', [
											'url' => route('countries.delete', $country->id), 
											'title' => 'Remove country',
											'confirm' => 'Remove country?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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