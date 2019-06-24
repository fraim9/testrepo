@php
//* $name
$label = $label ?? '';
$value = $value ?? false;
@endphp

<div class="form-group row">

    <div class="col-md-8 offset-md-4">
		
		<div class="custom-control custom-switch {{ $errors->has($name) ? ' is-invalid' : '' }}">
			<input type="hidden" name="{{ $name }}" value="0">
            <input type="checkbox" class="custom-control-input" value="1"
            	id="{{ $name }}" name="{{ $name }}" {{ ((null !== old($name)) ? old($name) : ($value ?? false)) ? 'checked' : '' }}>
            <label class="custom-control-label" for="{{ $name }}">{{ __($label) }}</label>
		</div>
		
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
