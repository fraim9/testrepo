
<?php $__env->startPush('scripts'); ?>
	
	<script src="<?php echo e(asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
	
	<script>
		jQuery(function(){ 
			
          <?php if(session()->has('success')): ?>
        	  One.helpers("notify", {
            	  type: "success", 
            	  icon: "fa fa-check mr-1", 
            	  message: "<?php echo e(session()->get('success')); ?>",
            	  delay: 2000,
              });
          <?php endif; ?>
        
          <?php if(session()->has('info')): ?>
        	  One.helpers("notify", {
            	  type: "info", 
            	  icon: "fa fa-info-circle mr-1", 
            	  message: "<?php echo e(session()->get('success')); ?>",
            	  delay: 2000,
              });
          <?php endif; ?>
        
          <?php if(session()->has('warning')): ?>
        	  One.helpers("notify", {
            	  type: "warning", 
            	  icon: "fa fa-exclamation mr-1", 
            	  message: "<?php echo e(session()->get('success')); ?>",
            	  delay: 2000,
              });
          <?php endif; ?>
        
          <?php if(session()->has('error')): ?>
        	  One.helpers("notify", {
            	  type: "danger", 
            	  icon: "fa fa-exclamation mr-1", 
            	  message: "<?php echo e(session()->get('success')); ?>",
            	  delay: 2000,
              });
          <?php endif; ?>

		});
	</script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/helpers/notification.blade.php ENDPATH**/ ?>