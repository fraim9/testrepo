@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('company.store') }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Edit Company information') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name', 
								'required' => true,
								'value' => $company->name ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'phone', 
								'label' => 'Phone', 
								'value' => $company->phone ?? ''
							])
								
							@include('helpers.formTextarea', [
								'name' => 'description', 
								'label' => 'Description', 
								'value' => $company->description ?? ''
							])
								
							@include('helpers.formTextarea', [
								'name' => 'address', 
								'label' => 'Address', 
								'value' => $company->address ?? ''
							])
								
							@include('helpers.formTextarea', [
								'name' => 'legal_mentions', 
								'label' => 'Legal mentions', 
								'value' => $company->legal_mentions ?? ''
							])
							
							
							@include('helpers.formSelect', [
								'name' => 'time_zone_id', 
								'label' => 'Time zone', 
								'value' => $company->time_zone_id ?? '',
								'options' => $timeZones
							])
							
							@include('helpers.formSelect', [
								'name' => 'country_id', 
								'label' => 'Country', 
								'value' => $company->country_id ?? '',
								'options' => array_column($countries->toArray(), 'name', 'id')
							])
								
							@include('helpers.formSelect', [
								'name' => 'city_id', 
								'label' => 'City', 
								'value' => $company->city_id ?? '',
								'options' => array_column($cities->toArray(), 'name', 'id')
							])
								
							@include('helpers.formSelect', [
								'name' => 'currency', 
								'label' => 'Currency', 
								'value' => $company->currency ?? '',
								'options' => array_column($currencies->toArray(), 'name', 'code')
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

