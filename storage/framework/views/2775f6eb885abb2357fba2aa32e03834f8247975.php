<?php
//* $name
$label = $label ?? '';
$value = $value ?? false;
?>

<div class="form-group row">

    <div class="col-md-8 offset-md-4">
		
		<div class="custom-control custom-switch <?php echo e($errors->has($name) ? ' is-invalid' : ''); ?>">
			<input type="hidden" name="<?php echo e($name); ?>" value="0">
            <input type="checkbox" class="custom-control-input" value="1"
            	id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" <?php echo e(((null !== old($name)) ? old($name) : ($value ?? false)) ? 'checked' : ''); ?>>
            <label class="custom-control-label" for="<?php echo e($name); ?>"><?php echo e(__($label)); ?></label>
		</div>
		
        <?php if($errors->has($name)): ?>
            <span class="invalid-feedback" role="alert">
                <strong><?php echo e($errors->first($name)); ?></strong>
            </span>
        <?php endif; ?>
    </div>
</div>
