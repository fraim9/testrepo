@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('aclRoles.store', $role ? $role->id : 0) }}">
					@csrf
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __($role ? 'Edit role' : 'Add role') }}</h3>
	        		</div>
					<div class="block-content">
						
						@include('helpers.formText', [
							'name' => 'name', 
							'label' => 'Name', 
							'required' => true,
							'value' => $role->name ?? ''
						])
						
						@if ($groups)
							@foreach ($groups as $group)
								<hr>
								<div class="row">
									<div class="offset-md-4 col-md-8">
										<h6>{{ $group->name }}</h6>
									</div>
								</div>
								@if ($resourceByGroup[$group->id])
    								@foreach ($resourceByGroup[$group->id] as $resource)
    									@include('helpers.formCheckbox', [
    										'name' => 'rights[' . $resource->id . ']', 
            								'label' => $resource->name, 
            								'value' => $role->rights[$resource->id] ?? false
            							])
    								@endforeach
    							@endif
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

