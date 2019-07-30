@extends('layouts.backend')

@section('content')
<div class="content content-full">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	        
	        	<div class="block">
					<form method="post" action="{{ route('clients.store', $client ? $client->id : 0) }}">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __($client ? 'Edit client' : 'Add client') }}</h3>
    	        		</div>
    					<div class="block-content">
							
							@include('helpers.formText', [
								'name' => 'view_id', 
								'label' => 'ID',
								'value' => $client->id ?? '',
								'disabled' => true,
							])
								
							@include('helpers.formText', [
								'name' => 'code', 
								'label' => 'External ID',
								'value' => $client->code ?? ''
							])
								


							@include('helpers.formText', [
								'name' => 'last_name', 
								'label' => 'Last name', 
								'required' => true,
								'value' => $client->last_name ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'first_name', 
								'label' => 'First name', 
								'required' => true,
								'value' => $client->first_name ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'middle_name', 
								'label' => 'Middle name', 
								'value' => $client->middle_name ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'last_name_lat', 
								'label' => 'Last name (Lat)', 
								'required' => true,
								'value' => $client->last_name_lat ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'first_name_lat', 
								'label' => 'First name (Lat)', 
								'required' => true,
								'value' => $client->first_name_lat ?? ''
							])
							
							@include('helpers.formSelect', [
								'name' => 'gender', 
								'label' => 'Gender', 
								'value' => $client->gender ?? '',
								'options' => [
									'M' => 'Male', 
									'F' => 'Female']
							])
							
							
							
							
							@include('helpers.formTextarea', [
								'name' => 'comment', 
								'label' => 'Comment', 
								'value' => $client->comment ?? ''
							])
								
								
							<hr>
								
								
							@include('helpers.formText', [
								'name' => 'email', 
								'label' => 'E-mail', 
								'value' => $client->email ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'phone', 
								'label' => 'Phone', 
								'value' => $client->phone ?? ''
							])
							
								
							<hr>
							
							
							@include('helpers.formText', [
								'name' => 'bd_day', 
								'label' => 'Birth day', 
								'value' => $client->bd_day ?? ''
							])
							
							@include('helpers.formSelect', [
								'name' => 'bd_month', 
								'label' => 'Birth month', 
								'value' => $client->bd_month ?? '',
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
							
							@include('helpers.formText', [
								'name' => 'bd_year', 
								'label' => 'Birth year', 
								'value' => $client->bd_year ?? ''
							])
							
							@include('helpers.formTextarea', [
								'name' => 'birth_place', 
								'label' => 'Birth place', 
								'value' => $client->birth_place ?? ''
							])
							
							
							<hr>
							
							@include('helpers.formSelect', [
								'name' => 'time_zone_id', 
								'label' => 'Time zone', 
								'value' => $client->time_zone_id ?? ($companyInfo->time_zone_id ?? ''),
								'required' => true,
								'options' => $timeZones
							])
							
							@include('helpers.formSelect', [
								'name' => 'country_id', 
								'label' => 'Country', 
								'value' => $client->country_id ?? ($companyInfo->country_id ?? ''),
								'required' => true,
								'options' => array_column($countries->toArray(), 'name', 'id')
							])
							
							@include('helpers.formText', [
								'name' => 'postcode', 
								'label' => 'Postcode', 
								'value' => $client->postcode ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'city', 
								'label' => 'City', 
								'value' => $client->city ?? ''
							])
							
							@include('helpers.formTextarea', [
								'name' => 'address', 
								'label' => 'Address', 
								'value' => $client->address ?? ''
							])
							
							
							<hr>
							
							
							@include('helpers.formSelect', [
								'name' => 'citizenship_id', 
								'label' => 'Citizenship', 
								'value' => $client->citizenship_id ?? ($companyInfo->country_id ?? ''),
								'options' => array_column($countries->toArray(), 'name', 'id')
							])
							
							@include('helpers.formText', [
								'name' => 'passport_series', 
								'label' => 'Passport series', 
								'value' => $client->passport_series ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'passport_number', 
								'label' => 'Passport number', 
								'value' => $client->passport_number ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'passport_issued_date', 
								'label' => 'Passport issued date', 
								'value' => $client->passport_issued_date ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'passport_issued_by', 
								'label' => 'Passport issued by', 
								'value' => $client->passport_issued_by ?? ''
							])
							
							@include('helpers.formText', [
								'name' => 'passport_subdivision_code', 
								'label' => 'Passport subdivision code', 
								'value' => $client->passport_subdivision_code ?? ''
							])
							
							
							
							@include('helpers.formTextarea', [
								'name' => 'registration_address', 
								'label' => 'Registration address', 
								'value' => $client->registration_address ?? ''
							])
							
							
							
							@include('helpers.formText', [
								'name' => 'inn', 
								'label' => 'INN', 
								'value' => $client->inn ?? ''
							])
							
							<hr>
							
							@include('helpers.formText', [
								'name' => 'discount', 
								'label' => 'Discount (%)', 
								'value' => $client->discount ?? ''
							])
							
							@include('helpers.formCheckbox', [
								'name' => 'discount_auto_calc', 
								'label' => 'Discount auto calc',
								'value' => $client->discount_auto_calc ?? ''
							])
							
							<hr>
							
							@include('helpers.formCheckbox', [
								'name' => 'postal_opt_in', 
								'label' => 'Postal opt in',
								'value' => $client->postal_opt_in ?? ''
							])
							@include('helpers.formCheckbox', [
								'name' => 'voice_opt_in', 
								'label' => 'Voice opt in',
								'value' => $client->voice_opt_in ?? ''
							])
							@include('helpers.formCheckbox', [
								'name' => 'email_opt_in', 
								'label' => 'Email opt in',
								'value' => $client->email_opt_in ?? ''
							])
							@include('helpers.formCheckbox', [
								'name' => 'msg_opt_in', 
								'label' => 'Message opt in',
								'value' => $client->msg_opt_in ?? ''
							])

							<hr>

							@include('helpers.formCheckbox', [
								'name' => 'consent_signed', 
								'label' => 'Consent signed',
								'value' => $client->consent_signed ?? ''
							])
							
							<hr>
							
							@include('helpers.formSelect', [
								'name' => 'employee_id', 
								'label' => 'Employee', 
								'value' => $client->employee_id ?? '',
								'options' => array_column($employees->toArray(), 'name', 'id'),
								'emptyValue' => true,
							])
							
							<hr>
							
							@include('helpers.formSelect', [
								'name' => 'created_employee_id', 
								'label' => 'Created employee', 
								'value' => $client->created_employee_id ?? ($currentUser->employee_id ?? ''),
								'options' => array_column($employees->toArray(), 'name', 'id'),
								'emptyValue' => true,
							])
							
							@include('helpers.formSelect', [
								'name' => 'responsible_id', 
								'label' => 'Responsible employee', 
								'value' => $client->responsible_id ?? ($currentUser->employee_id ?? ''),
								'options' => array_column($employees->toArray(), 'name', 'id'),
								'emptyValue' => true,
							])
							
							<hr>
								
								
							@include('helpers.formSelect', [
								'name' => 'created_store_id', 
								'label' => 'Created store', 
								'value' => $client->created_store_id ?? '',
								'options' => array_column($stores->toArray(), 'name', 'id'),
								'emptyValue' => true,
							])
								
							@include('helpers.formSelect', [
								'name' => 'attached_store_id', 
								'label' => 'Attached store', 
								'value' => $client->attached_store_id ?? '',
								'options' => array_column($stores->toArray(), 'name', 'id'),
								'emptyValue' => true,
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

