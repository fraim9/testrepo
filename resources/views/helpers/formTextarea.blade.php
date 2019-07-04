@php
/*
$name
$label
$value
$required
$rows
$cols
$labelClass
$elementClass
*/

$value = $value ?? '';
$description = $description ?? '';
$required = $required ?? false;
$rows = $rows ?? 3;
$cols = $cols ?? 45;
$labelClass = $labelClass ?? 'col-md-4';
$elementClass = $elementClass ?? 'col-md-6';

@endphp

<div class="form-group row">
    <label for="iso2" class="{{ $labelClass }} col-form-label text-md-right">{{ __($label) }}</label>

    <div class="{{ $elementClass }}">
        <textarea id="{{ $name }}" type="text" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
        	name="{{ $name }}" cols="{{ $cols }}" rows="{{ $rows }}"
        	{{ $required ? 'required' : '' }} >{{ strlen(old($name)) ? old($name) : ($value ?? '') }}</textarea>
        	
        @if (strlen($description))
        	<div class="form-control-description">
        		{{ $description }}
        	</div>
        @endif

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
