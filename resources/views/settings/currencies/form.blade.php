@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	        
	        	<div class="block">
					<form method="post" action="{{ route('currencies.store', $currency ? $currency->code : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($currency ? 'Edit currency' : 'Add currency') }}</h3>
    	        		</div>
    					<div class="block-content">
							@include('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code', 
								'required' => true,
								'value' => $currency->code ?? ''
							])

							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name',
								'required' => true,
								'value' => $currency->name ?? ''
							])

							@include('helpers.formText', [
								'name' => 'symbol', 
								'label' => 'Symbol', 
								'value' => $currency->symbol ?? ''
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
