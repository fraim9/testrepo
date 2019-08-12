<?php
/*
$name
$label
$value
$required
$rows
$cols
$labelClass
$elementClass
$readonly
*/

$value = $value ?? '';
$description = $description ?? '';
$required = $required ?? false;
$rows = $rows ?? 3;
$cols = $cols ?? 45;
$labelClass = $labelClass ?? 'col-md-4';
$elementClass = $elementClass ?? 'col-md-6';
$readonly = $readonly ?? false;

?>

<div class="form-group row">
    <label for="iso2" class="<?php echo e($labelClass); ?> col-form-label text-md-right"><?php echo __($label) . ($required ? ' <span class="required-input-marker">*</span>' : ''); ?></label>

    <div class="<?php echo e($elementClass); ?>">
        <textarea id="<?php echo e($name); ?>" type="text" class="form-control<?php echo e($errors->has($name) ? ' is-invalid' : ''); ?>" 
        	name="<?php echo e($name); ?>" cols="<?php echo e($cols); ?>" rows="<?php echo e($rows); ?>"
        	<?php echo e($required ? 'required' : ''); ?> 
        	<?php echo e($readonly ? 'readonly' : ''); ?> ><?php echo e(strlen(old($name)) ? old($name) : ($value ?? '')); ?></textarea>
        	
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
