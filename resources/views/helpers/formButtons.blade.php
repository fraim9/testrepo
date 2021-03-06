@php
$deleteUrl = $deleteUrl ?? false;
@endphp
<div class="block-footer block-footer-default">
	<div class="row">
        <div class="offset-md-4 col-md-4 col-6">
            <button type="submit" class="btn btn-primary btn-lg ladda-button" 
            	data-style="expand-right">{{ __('Save') }}</button>
        </div>
        @if ($deleteUrl)
            <div class="col-md-4 col-6 text-right">
                <a href="{{ $deleteUrl }}" class="btn btn-outline-dark btn-lg" 
                	onclick="return confirm('Delete?');">{{ __('Delete') }}</a>
            </div>
        @endif
    </div>
</div>
