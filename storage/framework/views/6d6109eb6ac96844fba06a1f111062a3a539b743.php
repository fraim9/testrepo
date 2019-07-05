<?php
/*
$title
$btns = [
    [
        'class' => 'btn btn-default',
        'caption' => 'name of action',
        'url' => 'some-url-of-action'
    ],
    [
        ...
    ]
]

*/
?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content py-3">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2"><?php echo e(__($title)); ?></h1>
            <div class="flex-sm-00-auto ml-sm-3">
            	<?php if(isset($btns)): ?>
            		<?php $__currentLoopData = $btns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            			<a href="<?php echo e($btn['url']); ?>" class="<?php echo e($btn['class']); ?>"><?php echo e(__($btn['caption'])); ?></a>
            		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            	<?php endif; ?>
            	
                
            </div>
        </div>
   </div>
</div>
<!-- END Hero -->