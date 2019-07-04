@php
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

@endphp

<div class="form-group row">
    <label for="iso2" class="{{ $labelClass }} col-form-label text-md-right">{{ __($label) }}</label>

    <div class="{{ $elementClass }}">
        <input id="{{ $name }}" type="text" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
        	name="{{ $name }}" value="{{ strlen(old($name)) ? old($name) : ($value ?? '') }}" 
        	{{ $required ? 'required' : '' }} >
        	
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
