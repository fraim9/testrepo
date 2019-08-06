

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
		        			<th data-class-name="text-center"><?php echo e(__('A')); ?></th>
		        			<th><?php echo e(__('Display name')); ?></th>
		        			<th><?php echo e(__('E-mail')); ?></th>
		        			<th><?php echo e(__('User group')); ?></th>
		        			<th><?php echo e(__('ACL Role')); ?></th>
		        			<th data-class-name="text-center"><?php echo e(__('Subscribe')); ?></th>
		        			<th data-class-name="text-center"><?php echo e(__('Created')); ?></th>
		        		</tr>
		        		<tr class="table-filter">
		        			<th>
		        				<select id="fActive" type="text" class="form-control form-control-sm" name="fActive">
                                	<option value=""><?php echo e(__('-- all --')); ?></option>
									<option value="1" <?php echo e((1 == $filter->fActive) ? 'selected' : ''); ?>><?php echo e(__('selected')); ?></option>
									<option value="2" <?php echo e((2 == $filter->fActive) ? 'selected' : ''); ?>><?php echo e(__('not selected')); ?></option>
                                </select>
		        			</th>
		        			<th><input type="text" class="form-control" name="fDisplayName" id="display_name_search" value="<?php echo e($filter->fDisplayName); ?>"></th>
		        			<th><input type="text" class="form-control" name="fEmail" id="email_search" value="<?php echo e($filter->fEmail); ?>"></th>
		        			<th>
								<select id="fUserGroupId" type="text" class="form-control" name="fUserGroupId">
                                	<option value=""><?php echo e(__('-- all --')); ?></option>
                                    <?php if($roles): ?>
                                    	<?php $__currentLoopData = $userGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    		<option value="<?php echo e($userGroup->id); ?>" <?php echo e(($userGroup->id == $filter->fUserGroupId) ? 'selected' : ''); ?>><?php echo e($userGroup->name); ?></option>
                                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
							</th>
		        			<th>
		        				<select id="fRoleId" type="text" class="form-control" name="fRoleId">
                                	<option value=""><?php echo e(__('-- all --')); ?></option>
                                    <?php if($roles): ?>
                                    	<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    		<option value="<?php echo e($role->id); ?>" <?php echo e(($role->id == $filter->fRoleId) ? 'selected' : ''); ?>><?php echo e($role->name); ?></option>
                                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
							</th>
		        			<th>
		        				<select id="fEmailSubscribe" type="text" class="form-control" name="fEmailSubscribe">
                                	<option value=""><?php echo e(__('-- all --')); ?></option>
									<option value="1" <?php echo e((1 == $filter->fEmailSubscribe) ? 'selected' : ''); ?>><?php echo e(__('selected')); ?></option>
									<option value="2" <?php echo e((2 == $filter->fEmailSubscribe) ? 'selected' : ''); ?>><?php echo e(__('not selected')); ?></option>
                                </select>
		        			</th>
		        			<th></th>
		        		</tr>
		        	</thead>
		        </table>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
<?php $__env->stopSection(); ?>




<?php $__env->startSection('css_after'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/dataTables.bootstrap4.css')); ?>">

	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/ColReorder-1.5.0/css/colReorder.dataTables.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/ColReorder-1.5.0/css/colReorder.bootstrap4.min.css')); ?>">
	
	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap4.min.css')); ?>">
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_after'); ?>
	<script src="<?php echo e(asset('js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/plugins/datatables/ColReorder-1.5.0/js/dataTables.colReorder.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/ColReorder-1.5.0/js/colReorder.bootstrap4.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.colVis.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.print.min.js')); ?>"></script>

    <script>
        jQuery(function(){

        	// Init full DataTable
            var oTable = jQuery('.js-dataTable').dataTable({
                serverSide: true,
                ajax: '<?php echo route('users.data'); ?>',
                columns: [
                    { data: 'active', name: 'active' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'email', name: 'email' },
                    { data: 'group_id', name: 'group_id' },
                    { data: 'role_id', name: 'role_id' },
                    { data: 'email_subscribe', name: 'email_subscribe' },
                    { data: 'created_date', name: 'created_date' },
                ],
            	columnDefs: [
					{ "width": "40px", targets: [ 0, 5 ] },
				],
            });

        	var timerId = null;
            $('.js-dataTable thead tr input,select').on( 'keyup change clear', function () {
				var control = $(this);
				clearTimeout(timerId);
				timerId = setTimeout(function() {
						var data = {};
						data[control.attr('name')] = control.val();
	                	axios.get('<?php echo route('users.filter'); ?>', {
	                			params: data
	                		})
	                		.then(function (response) {
	                			oTable.fnDraw();
	                		})
	                		.catch(function (error) {
	                	  		console.log(error);
	                		});
					}, 500);
            });

        });
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/users/users/index.blade.php ENDPATH**/ ?>