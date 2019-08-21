@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
    			<form method="post" action="{{ route('prices.store', $price ? $price->id : 0) }}">
    				@csrf
            		<div class="block-header block-header-default">
            			<h3 class="block-title">{{ __($price ? 'Edit price group' : 'Add price group') }}</h3>
            		</div>
    				<div class="block-content">
    					
    					@include('helpers.formText', [
    						'name' => 'name', 
    						'label' => 'Name', 
    						'required' => true,
    						'value' => $price->name ?? ''
    					])
    						
    					@include('helpers.formText', [
    						'name' => 'code', 
    						'label' => 'External ID', 
    						'required' => true,
    						'value' => $price->code ?? ''
    					])
    					
    				</div>
    				
    				@include('helpers.formButtons')
    				
    			</form>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

