<?php
/*
$name
$label
$value
$options
$empty_value
*/

$required = $required ?? false;
$value = strlen(old($name)) ? old($name) : ($value ?? '');
$emptyValue = $emptyValue ?? false;

?>

<div class="form-group row">
    <label for="iso2" class="col-md-4 col-form-label text-md-right"><?php echo e(__($label)); ?></label>

    <div class="col-md-6">
        <select id="<?php echo e($name); ?>" type="text" class="form-control<?php echo e($errors->has($name) ? ' is-invalid' : ''); ?>" 
        	name="<?php echo e($name); ?>" 
        	<?php echo e($required ? 'required' : ''); ?> >
        	<?php if($emptyValue): ?> 
        		<option value=""><?php echo e(__('-- значение не выбрано --')); ?></option>
        	<?php endif; ?>
        	
            <?php if($options): ?>
            	<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            		<option value="<?php echo e($val); ?>" <?php echo e(($val == $value) ? 'selected' : ''); ?>><?php echo e($name); ?></option>
            	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
        	

        <?php if($errors->has($name)): ?>
            <span class="invalid-feedback" role="alert">
                <strong><?php echo e($errors->first($name)); ?></strong>
            </span>
        <?php endif; ?>
    </div>
</div>
