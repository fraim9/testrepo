@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('employees.store', $employee ? $employee->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($employee ? 'Edit employee' : 'Add employee') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'name', 
								'label' => 'Name', 
								'required' => true,
								'value' => $employee->name ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'code', 
								'label' => 'Code',
								'required' => true,
								'value' => $employee->code ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'personnel_number', 
								'label' => 'Personnel number', 
								'value' => $employee->personnel_number ?? ''
							])
								
							@include('helpers.formSelect', [
								'name' => 'division_id', 
								'label' => 'Division', 
								'value' => $employee->division_id ?? '',
								'options' => array_column($divisions->toArray(), 'name', 'id')
							])
							
							@include('helpers.formText', [
								'name' => 'department', 
								'label' => 'Department', 
								'value' => $employee->department ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'position', 
								'label' => 'Position', 
								'value' => $employee->position ?? ''
							])
								
							@include('helpers.formText', [
								'name' => 'birth_day', 
								'label' => 'Birth day', 
								'value' => $employee->birth_day ?? ''
							])
							
							@include('helpers.formSelect', [
								'name' => 'birth_month', 
								'label' => 'Birth month', 
								'value' => $employee->birth_month ?? '',
								'options' => [
									1 => 'Январь', 
									2 => 'Фервраль',
									3 => 'Март',
									4 => 'Апрель',
									5 => 'Май',
									6 => 'Июнь',
									7 => 'Июль',
									8 => 'Август',
									9 => 'Сентябрь',
									10 => 'Октябрь',
									11 => 'Ноябрь',
									12 => 'Декабрь']
							])	
							
							
							@include('helpers.formCheckbox', [
								'name' => 'active', 
								'label' => 'Active',
								'value' => $employee->active ?? ''
							])
							
								
							@include('helpers.formText', [
								'name' => 'email', 
								'label' => 'E-mail', 
								'value' => $employee->email ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'phone', 
								'label' => 'Phone', 
								'value' => $employee->phone ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'phone_mobile', 
								'label' => 'Mobile phone', 
								'value' => $employee->phone_mobile ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'phone_personal', 
								'label' => 'Personal phone', 
								'value' => $employee->phone_personal ?? ''
							])
							
								
							@include('helpers.formCheckbox', [
								'name' => 'publish_on_site', 
								'label' => 'Publish the employee on the site', 
								'value' => $employee->publish_on_site ?? ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'publish_on_fast_contacts', 
								'label' => 'Publish the employee on the site in the fast contact block',
								'value' => $employee->publish_on_fast_contacts ?? ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'publish_phone', 
								'label' => 'Publish the phone on the site',
								'value' => $employee->publish_phone ?? ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'publish_email', 
								'label' => 'Publish the email on the site',
								'value' => $employee->publish_email ?? ''
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

