@php
/*
$name
$label
$value
$options
*/

$required = $required ?? false;

$value = strlen(old($name)) ? old($name) : ($value ?? '');

@endphp

<div class="form-group row">
    <label for="iso2" class="col-md-4 col-form-label text-md-right">{{ __($label) }}</label>

    <div class="col-md-6">
        <select id="{{ $name }}" type="text" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
        	name="{{ $name }}" 
        	{{ $required ? 'required' : '' }} >
            @if ($options)
            	@foreach ($options as $val => $name)
            		<option value="{{ $val }}" {{ ($val == $value) ? 'selected' : '' }}>{{ $name }}</option>
            	@endforeach
            @endif
        </select>
        	

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
