@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('cities.store', $city ? $city->id : 0) }}">
					@csrf
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __($city ? 'Edit city' : 'Add city') }}</h3>
	        		</div>
					<div class="block-content">

						@include('helpers.formText', [
							'name' => 'name', 
							'label' => 'Name',
							'required' => true,
							'value' => $city->name ?? ''
						])

						@include('helpers.formText', [
							'name' => 'code', 
							'label' => 'External ID',
							'required' => true,
							'value' => $city->code ?? ''
						])

						@include('helpers.formSelect', [
							'name' => 'country_id', 
							'label' => 'Country', 
							'value' => $city->country_id ?? '',
							'options' => array_column($countries->toArray(), 'name', 'id')
						])
							
					</div>
					
					@include('helpers.formButtons')
					
				</form>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection
