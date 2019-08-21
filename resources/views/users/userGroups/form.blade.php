@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('userGroups.store', $group ? $group->id : 0) }}">
					@csrf
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __($group ? 'Edit group' : 'Add group') }}</h3>
	        		</div>
					<div class="block-content">
						
						@include('helpers.formText', [
							'name' => 'name', 
							'label' => 'Name', 
							'required' => true,
							'value' => $group->name ?? ''
						])
							
						@if ($userRights)
							@foreach ($userRights as $userRight)
								@include('helpers.formSelect', [
									'name' => 'ipos_rights[' . $userRight->id . ']', 
    								'label' => $userRight->name, 
    								'required' => false,
    								'value' => $group->ipos_rights[$userRight->id] ?? '',
    								'options' => $userRightValues[$userRight->id]
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

