@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	        
	        	<div class="block">
					<form method="post" action="{{ route('timeZones.store', $zone ? $zone->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($zone ? 'Edit time zone' : 'Add time zone') }}</h3>
    	        		</div>
    					<div class="block-content">
							@include('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code', 
								'required' => true,
								'value' => $zone->code ?? ''
							])

							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name',
								'required' => true,
								'value' => $zone->name ?? ''
							])

							@include('helpers.formText', [
								'name' => 'offset', 
								'label' => 'Offset', 
								'required' => true,
								'value' => $zone->offset ?? ''
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
