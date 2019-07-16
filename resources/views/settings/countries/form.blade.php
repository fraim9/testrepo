@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	        
	        	<div class="block">
					<form method="post" action="{{ route('countries.store', $country ? $country->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($country ? 'Edit country' : 'Add country') }}</h3>
    	        		</div>
    					<div class="block-content">
							@include('helpers.formText', [
								'name' => 'iso2', 
								'label' => 'Iso 2', 
								'required' => true,
								'value' => $country->iso2 ?? ''
							])

							@include('helpers.formText', [
								'name' => 'iso3', 
								'label' => 'Iso 3', 
								'required' => true,
								'value' => $country->iso3 ?? ''
							])

							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name',
								'required' => true,
								'value' => $country->name ?? ''
							])

							@include('helpers.formText', [
								'name' => 'calling_code', 
								'label' => 'Calling code', 
								'required' => true,
								'value' => $country->calling_code ?? ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'aml_risk', 
								'label' => 'AML Risk', 
								'value' => $country->aml_risk ?? false,
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
