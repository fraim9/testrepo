<?php
$deleteUrl = $deleteUrl ?? false;
?>
<div class="block-footer block-footer-default">
	<div class="row">
        <div class="offset-md-4 col-md-4 col-6">
            <button type="submit" class="btn btn-primary btn-lg ladda-button" 
            	data-style="expand-right"><?php echo e(__('Save')); ?></button>
        </div>
        <?php if($deleteUrl): ?>
            <div class="col-md-4 col-6 text-right">
                <a href="<?php echo e($deleteUrl); ?>" class="btn btn-outline-dark btn-lg" 
                	onclick="return confirm('Delete?');"><?php echo e(__('Delete')); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/helpers/formButtons.blade.php ENDPATH**/ ?>