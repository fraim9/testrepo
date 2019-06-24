@php
/*
$name
$label
$value
$required
$rows
$cols
*/

$value = $value ?? '';
$description = $description ?? '';
$required = $required ?? false;
$rows = $rows ?? 3;
$cols = $cols ?? 45;

@endphp

<div class="form-group row">
    <label for="iso2" class="col-md-4 col-form-label text-md-right">{{ __($label) }}</label>

    <div class="col-md-6">
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
