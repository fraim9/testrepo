@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('storeGroups.store', $group ? $group->id : 0) }}">
					@csrf
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __($group ? 'Edit store group' : 'Add store group') }}</h3>
	        		</div>
					<div class="block-content">
						
						@include('helpers.formText', [
							'name' => 'name', 
							'label' => 'Name', 
							'required' => true,
							'value' => $group->name ?? ''
						])
							
						@if ($iposFeatures)
							@foreach ($iposFeatures as $iposFeature)
								@include('helpers.formCheckbox', [
									'name' => 'ipos_settings[' . $iposFeature->id . ']', 
    								'label' => $iposFeature->name, 
    								'value' => $group->ipos_settings[$iposFeature->id] ?? false
    							])
							@endforeach
						@endif
						
					</div>
					
					@include('helpers.formButtons')
					
				</form>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

