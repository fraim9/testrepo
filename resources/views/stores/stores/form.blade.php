@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('stores.store', $store ? $store->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($store ? 'Edit store' : 'Add store') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name', 
								'required' => true,
								'value' => $store->name ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code',
								'required' => true,
								'value' => $store->code ?? ''
							])
								
							@include('helpers.formTextarea', [
								'name' => 'description', 
								'label' => 'Description', 
								'value' => $store->description ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'phone', 
								'label' => 'Phone', 
								'value' => $store->phone ?? ''
							])
								
							@include('helpers.formTextarea', [
								'name' => 'address', 
								'label' => 'Address', 
								'value' => $store->address ?? ''
							])
								
							@include('helpers.formSelect', [
								'name' => 'group_id', 
								'label' => 'Store group', 
								'value' => $store->group_id ?? '',
								'options' => array_column($storeGroups->toArray(), 'name', 'id')
							])

							@include('helpers.formSelect', [
								'name' => 'country_id', 
								'label' => 'Country', 
								'value' => $store->country_id ?? '',
								'options' => array_column($countries->toArray(), 'name', 'id')
							])

							@include('helpers.formSelect', [
								'name' => 'city_id', 
								'label' => 'City', 
								'value' => $store->city_id ?? '',
								'options' => array_column($cities->toArray(), 'name', 'id')
							])

							@include('helpers.formSelect', [
								'name' => 'time_zone_id', 
								'label' => 'Time zone', 
								'value' => $store->time_zone_id ?? '',
								'options' => $timeZones
							])

							@include('helpers.formSelect', [
								'name' => 'price_id', 
								'label' => 'Price group', 
								'value' => $store->price_id ?? '',
								'options' => array_column($prices->toArray(), 'name', 'id')
							])
							
							@include('helpers.formSelect', [
								'name' => 'currency', 
								'label' => 'Currency', 
								'value' => $store->currency ?? '',
								'options' => array('RUB' => 'RUB', 'USD' => 'USD', 'EUR' => 'EUR')
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

