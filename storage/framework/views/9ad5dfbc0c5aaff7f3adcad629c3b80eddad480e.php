<?php

$value = new DateTime($value ? $value : null);
$format = $format ?? 'd M Y';

?>

<?php echo e($value->format($format)); ?>

<?php /**PATH /Users/roman/WebServers/clt-omnipos2/resources/views/helpers/viewDate.blade.php ENDPATH**/ ?>