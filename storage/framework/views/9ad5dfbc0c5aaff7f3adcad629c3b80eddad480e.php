<?php

$value = new DateTime($value ? $value : null);
$format = $format ?? 'd M Y';

?>

<?php echo e($value->format($format)); ?>

