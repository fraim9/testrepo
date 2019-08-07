@php
$deleteUrl = $deleteUrl ?? false;
@endphp
<div class="block-footer block-footer-default">
	<div class="row">
        <div class="col-md-5  col-sm-7 col-12 offset-md-4">
            <button type="submit" class="btn btn-primary btn-lg ladda-button" 
            	data-style="expand-right">{{ __('Save') }}</button>
            <button type="reset" class="btn btn-secondary btn-lg ml-1" 
            	onclick="return confirm('Reset form values?');">{{ __('Reset') }}</button>
        </div>
        @if ($deleteUrl)
            <div class="col-md-3 col-sm-5 col-12 text-right pt-sm-0 pt-3">
                <a href="{{ $deleteUrl }}" class="btn btn-outline-dark btn-lg" 
                	onclick="return confirm('Delete?');">{{ __('Delete') }}</a>
            </div>
        @endif
    </div>
</div>
