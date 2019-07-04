@extends('layouts.backend')

@section('content')

	@include('layouts.backendPageHero', [
    	'title' => $client->name,
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="content">
	    <div class="row">
        	<div class="block">
        		<form method="post" action="{{ route('clients.amlReportStore', $amlReport->id) }}">
					@csrf
    	        	<div class="block-content">
    	        		<h3 class="text-center">{{ __('Анкета клиента-физического лица, представителя клиента, выгодоприобретателя – физического лица и бенефициарного владельца') }}</h3>
    	        		<table class="table">
    	        			<tbody>
            	        		@foreach ($questions as $question)
    								<tr>
    									<td class="text-right"><strong>{{ $question->num }}</strong></td>
    									<td style="width:30%">
    										<div class="pb-1"><strong>{!! $question->name !!}</strong></div>
    										<div class="text-small text-muted">{!! $question->descr !!}</div>
    									</td>
    									<td>
    										@if ($question->type == 'name')
    											
    											@include('helpers.formText', [
                    								'name' => 'last_name', 
                    								'label' => 'Last name', 
                    								'required' => true,
                    								'value' => $amlReport->last_name ?: '',
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'first_name', 
                    								'label' => 'First name', 
                    								'required' => true,
                    								'value' => $amlReport->first_name ?: '',
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'middle_name', 
                    								'label' => 'Middle name', 
                    								'value' => $amlReport->middle_name ?: '',
                    							])
    										
    										@endif
    										
    										
    										@if ($question->type == 'birth_date')
    										
    											@include('helpers.formText', [
                    								'name' => 'birth_date', 
                    								'label' => 'Birth date', 
                    								'value' => $amlReport->birth_date ?: '',
                    							])
                    							
    										@endif
    										
    										@if ($question->type == 'citizenhip')
    										
    											@include('helpers.formSelect', [
                    								'name' => 'citizenship_id', 
                    								'label' => 'Citizenship', 
                    								'value' => $amlReport->citizenship_id,
                    								'options' => array_column($countries->toArray(), 'name', 'id')
                    							])
                    							
    										@endif
    
    										@if ($question->type == 'passport')
    										
    											@include('helpers.formText', [
                    								'name' => 'passport_series', 
                    								'label' => 'Passport series', 
                    								'value' => $amlReport->passport_series ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'passport_number', 
                    								'label' => 'Passport number', 
                    								'value' => $amlReport->passport_number ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'passport_issued_date', 
                    								'label' => 'Passport issued date', 
                    								'value' => $amlReport->passport_issued_date ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'passport_issued_by', 
                    								'label' => 'Passport issued by', 
                    								'value' => $amlReport->passport_issued_by ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'passport_subdivision_code', 
                    								'label' => 'Passport subdivision code', 
                    								'value' => $amlReport->passport_subdivision_code ?: ''
                    							])
                    							
    										@endif
    										
    										@if ($question->type == 'migration')
    										
    											@include('helpers.formText', [
                    								'name' => 'migration_series', 
                    								'label' => 'Migration series', 
                    								'value' => $amlReport->migration_series ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'migration_number', 
                    								'label' => 'Migration number', 
                    								'value' => $amlReport->migration_number ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'migration_stay_from', 
                    								'label' => 'Migration stay from',
                    								'value' => $amlReport->migration_stay_from ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'migration_stay_to', 
                    								'label' => 'Migration stay to', 
                    								'value' => $amlReport->migration_stay_to ?: ''
                    							])
                    							
    										@endif
    
    										@if ($question->type == 'permission')
    										
    											@include('helpers.formText', [
                    								'name' => 'permission_series', 
                    								'label' => 'Permission series', 
                    								'value' => $amlReport->permission_series ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'permission_number', 
                    								'label' => 'Permission number', 
                    								'value' => $amlReport->permission_number ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'permission_stay_from', 
                    								'label' => 'Permission stay from',
                    								'value' => $amlReport->permission_stay_from ?: ''
                    							])
                    							
                    							@include('helpers.formText', [
                    								'name' => 'permission_stay_to', 
                    								'label' => 'Permission stay to', 
                    								'value' => $amlReport->permission_stay_to ?: ''
                    							])
                    							
    										@endif
    										
    										@if ($question->type == 'address')
    										
    											@include('helpers.formTextarea', [
                    								'name' => 'registration_address', 
                    								'label' => 'Registration address', 
                    								'value' => $amlReport->registration_address ?: ''
                    							])
                    							
    										@endif
    
    										@if ($question->type == 'inn')
    										
    											@include('helpers.formText', [
                    								'name' => 'inn', 
                    								'label' => 'ИНН', 
                    								'value' => $amlReport->inn ?: $question->default,
                    							])
                    							
    										@endif
    										
    										@if ($question->type == 'contacts')
    										
    											@include('helpers.formTextarea', [
                    								'name' => 'questionnaire[' . $question->id . ']', 
                    								'label' => '', 
                    								'value' => $amlReport->questionnaire[$question->id] ?? ($amlMini->phone . "\n" . $client->email),
                    								'elementClass' => 'col-md-8',
                    							])
                    							
    										@endif
    										
    										@if ($question->type == 'employee')
    										
    											@include('helpers.formTextarea', [
                    								'name' => 'questionnaire[' . $question->id . ']', 
                    								'label' => '', 
                    								'value' => $amlReport->questionnaire[$question->id] ?? ($amlReport->initiator_id ? $amlReport->initiator->position . ' ' . $amlReport->initiator->name : ''),
                    								'elementClass' => 'col-md-8',
                    							])
                    							
    										@endif
    										
    										
    										
    										@if ($question->type == 'text')
    										
    											@include('helpers.formTextarea', [
                    								'name' => 'questionnaire[' . $question->id . ']', 
                    								'label' => '', 
                    								'value' => $amlReport->questionnaire[$question->id] ?? str_replace('%DATE%', $dateText, $question->default),
                    								'elementClass' => 'col-md-8',
                    							])
                    							
    										@endif
    										
    									</td>
    								</tr>        	        			
            	        		@endforeach
            	        		
            	        		<tr>
    								<td class="text-right"></td>
    								<td style="width:30%">
    									{{ __('Статус отчета') }}
    								</td>
    								<td>
    									@include('helpers.formSelect', [
            								'name' => 'status', 
            								'label' => '', 
            								'value' => $amlReport->status ?? '',
            								'options' => array_column($statusList, 'name', 'id'),
            							])
    								</td>
    							</tr>
    							 
        	        		</tbody>
    	        		</table>
    	        	</div>
    	        	@include('helpers.formButtons')
	        	</form>
        	</div>
	        
	    </div>
	</div>
	
@endsection

