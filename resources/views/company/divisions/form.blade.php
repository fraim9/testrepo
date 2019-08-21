@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('divisions.store', $division ? $division->id : 0) }}">
					@csrf
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __($division ? 'Edit division' : 'Add division') }}</h3>
	        		</div>
					<div class="block-content">
						
						@include('helpers.formText', [
							'name' => 'name', 
							'label' => 'Name', 
							'required' => true,
							'value' => $division->name ?? ''
						])
							
						@include('helpers.formText', [
							'name' => 'code', 
							'label' => 'External ID',
							'required' => true,
							'value' => $division->code ?? ''
						])
							
						@include('helpers.formText', [
							'name' => 'sort', 
							'label' => 'Sort index',
							'required' => true,
							'value' => $division->sort ?? ''
						])
							
						@include('helpers.formCheckbox', [
							'name' => 'active', 
							'label' => 'Active',
							'value' => $division->active ?? ''
						])
						
					</div>
					
					@include('helpers.formButtons')
					
				</form>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

