<?php
$deleteUrl = $deleteUrl ?? false;
?>
<div class="block-footer block-footer-default">
	<div class="row">
        <div class="col-md-5 offset-md-4">
            <button type="submit" class="btn btn-primary btn-lg ladda-button" 
            	data-style="expand-right"><?php echo e(__('Save')); ?></button>
            <button type="reset" class="btn btn-secondary btn-lg ml-1" 
            	onclick="return confirm('Reset form values?');"><?php echo e(__('Reset')); ?></button>
        </div>
        <?php if($deleteUrl): ?>
            <div class="col-md-3 text-right">
                <a href="<?php echo e($deleteUrl); ?>" class="btn btn-outline-dark btn-lg" 
                	onclick="return confirm('Delete?');"><i class="far fa-trash-alt"></i> <?php echo e(__('Delete')); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/helpers/formButtons.blade.php ENDPATH**/ ?>