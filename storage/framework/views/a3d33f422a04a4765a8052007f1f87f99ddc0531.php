<form action="<?php echo e($url); ?>" method="post"
	onsubmit="return confirm('<?php echo e(__($confirm)); ?>');">
	<?php echo csrf_field(); ?>
	<?php echo method_field('DELETE'); ?>
	<button class="btn btn-sm btn-light" type="submit" title="<?php echo e(__($title)); ?>"
		><i class="fa fa-fw fa-times"></i></button>
</form>