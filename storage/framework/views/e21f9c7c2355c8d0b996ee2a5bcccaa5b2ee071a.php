

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('layouts.backendPageHero', [
    	'title' => 'Users',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add user',
                'url' => route('users.form', 0)
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
		        			<th><?php echo e(__('A')); ?></th>
		        			<th><?php echo e(__('Display name')); ?></th>
		        			<th><?php echo e(__('E-mail')); ?></th>
		        			<th><?php echo e(__('User group')); ?></th>
		        			<th><?php echo e(__('ACL Role')); ?></th>
		        			<th><?php echo e(__('Subscribe')); ?></th>
		        			<th><?php echo e(__('Created')); ?></th>
		        			<th><?php echo e(__('Action')); ?></th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			        		<tr>
			        			<td class="text-center">
			        				<?php echo $__env->make('helpers.viewBool', ['value' => $user->active], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			        			</td>
			        			<td>
			        				<?php echo e($user->display_name); ?>

			        				<div class="text-smallest text-flat-light">
			        					<?php echo e(implode(', ', array_column($user->stores->toArray(), 'name', 'id'))); ?>

			        				</div>
			        			</td>
			        			<td><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></td>
			        			<td><?php echo e($user->group->name); ?></td>
			        			<td><?php echo e($user->role ? $user->role->name : '---'); ?></td>
			        			<td class="text-center">
			        				<?php echo $__env->make('helpers.viewBool', ['value' => $user->email_subscribe], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			        			</td>
			        			<td class="text-center">
			        				<?php echo $__env->make('helpers.viewDate', ['value' => $user->created_date], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			        			</td>
			        			<td class="text-center">
									<div class="btn-group">
										<?php echo $__env->make('helpers.btnEdit', [
											'url' => route('users.form', $user->id), 
											'title' => 'Edit user'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										<?php echo $__env->make('helpers.btnDelete', [
											'url' => route('users.delete', $user->id), 
											'title' => 'Remove user',
											'confirm' => 'Remove user?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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