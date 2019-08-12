@php

$value = new DateTime($value ? $value : null);
$format = $format ?? 'd M Y';

@endphp

{{ $value->format($format) }}
