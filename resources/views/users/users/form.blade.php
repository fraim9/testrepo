@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
	        	
	        		@if ($token)
    	        		<div class="row justify-content-center">
    	        			<div class="col-md-4 col-sm-6 p-5">
   			        			<img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size('1000')->generate($token)) !!}" width="200" height="200">
    	        			</div>
    	        		</div>
    	        		<div class="text-center" style="color:#fff;">{{ $token }}</div>
	        		@endif
	        	
					<form method="post" action="{{ route('users.store', $user ? $user->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($user ? 'Edit user' : 'Add user') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'username', 
								'label' => 'Username', 
								'required' => true,
								'value' => $user->username ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'display_name', 
								'label' => 'Display name', 
								'required' => true,
								'value' => $user->display_name ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'email', 
								'label' => 'E-mail', 
								'required' => true,
								'value' => $user->email ?? ''
							])
							
							@include('helpers.formSelect', [
								'name' => 'role_id', 
								'label' => 'ACL Role', 
								'value' => $user->role_id ?? '',
								'options' => array_column($roles->toArray(), 'name', 'id'),
								'required' => true,
								'emptyValue' => true,
							])
								
							@include('helpers.formSelect', [
								'name' => 'employee_id', 
								'label' => 'Employee', 
								'value' => $user->employee_id ?? '',
								'options' => array_column($employees->toArray(), 'name', 'id'),
								'emptyValue' => true,
							])
								
							@include('helpers.formSelect', [
								'name' => 'group_id', 
								'label' => 'User group', 
								'required' => true,
								'value' => $user->group_id ?? '',
								'options' => array_column($userGroups->toArray(), 'name', 'id')
							])

							@include('helpers.formCheckbox', [
								'name' => 'email_subscribe', 
								'label' => 'Email subscribe', 
								'value' => $user->email_subscribe ?? true,
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'active', 
								'label' => 'User is active', 
								'value' => $user->active ?? true,
							])
							
							<hr>
							
							<div class="form-group row">
								<div class="col-md-4 text-md-right text-md-right">
									<label class="col-form-label">{{ __('Stores') }}</label>
								</div>
								<div class="col-md-8">
									@if ($stores)
        								@foreach ($stores as $store)
        									<div class="custom-control custom-switch pb-2">
                                                <input type="checkbox" class="custom-control-input" value="{{ $store->id }}"
                                                	id="store_{{ $store->id }}" name="stores[]" {{ isset($userStores[$store->id]) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="store_{{ $store->id }}">{{ $store->name }}</label>
                                    		</div>
        								@endforeach
        							@endif
								</div>
							
							</div>
							
							<hr>
							<h6>{{ __('Set new password') }}</h6>
							
							@include('helpers.formText', [
								'name' => 'password', 
								'label' => 'Password', 
								'description' => 'Here you can set a new password', 
								'value' => ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'qrcode', 
								'label' => 'Generate QR Code', 
								'value' => false,
							])
								
    					</div>
    					
    					@include('helpers.formButtons', array('deleteUrl' => route('users.delete', $user->id)))
						
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

