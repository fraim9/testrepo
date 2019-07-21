@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('authParameters.store') }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Edit auth parameters') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'auth_key', 
								'label' => 'Auth key', 
								'value' => $parameters->auth_key ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'auth_code', 
								'label' => 'Auth code', 
								'value' => $parameters->auth_code ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'api_auth_url', 
								'label' => 'Api auth url', 
								'value' => $parameters->api_auth_url ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'omnipos_secret_key', 
								'label' => 'Omnipos secret key', 
								'value' => $parameters->omnipos_secret_key ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'ipos_secret_key', 
								'label' => 'Ipos secret key', 
								'value' => $parameters->ipos_secret_key ?? ''
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

