@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
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
								'name' => 'password', 
								'label' => 'Password', 
								'description' => 'Here you can set a new password', 
								'value' => ''
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
							
    					</div>
    					
    					@include('helpers.formButtons')
						
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

