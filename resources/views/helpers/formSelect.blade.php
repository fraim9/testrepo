@php
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

@endphp

<div class="form-group row">
    <label for="iso2" class="col-md-4 col-form-label text-md-right">{!! __($label) . ($required ? ' <span class="required-input-marker">*</span>' : '') !!}</label>

    <div class="col-md-6">
        <select id="{{ $name }}" type="text" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
        	name="{{ $name }}" 
        	{{ $required ? 'required' : '' }} >
        	@if ($emptyValue) 
        		<option value="">{{ __('-- значение не выбрано --') }}</option>
        	@endif
        	
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
