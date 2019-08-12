@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('translations.store') }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Translations') }} [{{ $lang }}]</h3>
    	        		</div>
    					<div class="block-content">
							@include('helpers.formTextarea', [
								'name' => 'translations', 
								'label' => '', 
								'cols' => 70,
								'rows' => 20,
								'labelClass' => ' ',
								'elementClass' => 'col-md-12',
								'value' => $translations ?? ''
							])
							
    					</div>
    					
    					@include('helpers.formButtons')
    					
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection
