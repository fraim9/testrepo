<?php
/*
$name
$label
$value
$required
$labelClass
$elementClass
*/

$value = $value ?? '';
$description = $description ?? '';
$required = $required ?? false;

$labelClass = $labelClass ?? 'col-md-4';
$elementClass = $elementClass ?? 'col-md-6';

?>

<div class="form-group row">
    <label for="iso2" class="<?php echo e($labelClass); ?> col-form-label text-md-right"><?php echo e(__($label)); ?></label>

    <div class="<?php echo e($elementClass); ?>">
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
