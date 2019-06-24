<?php
/*
$name
$label
$value
$required
*/

$value = $value ?? '';
$description = $description ?? '';
$required = $required ?? false;

?>

<div class="form-group row">
    <label for="iso2" class="col-md-4 col-form-label text-md-right"><?php echo e(__($label)); ?></label>

    <div class="col-md-6">
        <input id="<?php echo e($name); ?>" type="text" class="form-control<?php echo e($errors->has($name) ? ' is-invalid' : ''); ?>" 
        	name="<?php echo e($name); ?>" value="<?php echo e(strlen(old($name)) ? old($name) : ($value ?? '')); ?>" 
        	<?php echo e($required ? 'required' : ''); ?> >
        	
        <?php if(strlen($description)): ?>
        	<div class="form-control-description">
        		<?php echo e($description); ?>

        	</div>
        <?php endif; ?>

        <?php if($errors->has($name)): ?>
            <span class="invalid-feedback" role="alert">
                <strong><?php echo e($errors->first($name)); ?></strong>
            </span>
        <?php endif; ?>
    </div>
</div>
