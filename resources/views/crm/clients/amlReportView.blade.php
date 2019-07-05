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
	        	<div class="block-content">
	        		<h3 class="text-center">{{ __('Анкета клиента-физического лица, представителя клиента, выгодоприобретателя – физического лица и бенефициарного владельца') }}</h3>
	        		<table class="table">
	        			<tbody>
        	        		@foreach ($questions as $question)
								<tr>
									<td class="text-right"><strong>{{ $question->num }}</strong></td>
									<td style="width:50%">
										<div class="pb-1"><strong>{!! $question->name !!}</strong></div>
										<div class="text-small text-muted">{!! $question->descr !!}</div>
									</td>
									<td>
										@if ($question->type == 'name')
											
											{{ implode(' ', [$amlReport->last_name, $amlReport->first_name, $amlReport->middle_name]) }}
											
										@endif
										
										
										@if ($question->type == 'birth_date')
											
											@include('helpers.viewDate', [
                								'value' => $amlReport->birth_date,
                							])
                							
										@endif
										
										@if ($question->type == 'citizenhip')
										
											{{ $amlReport->citizenship->name }}
                							
										@endif

										@if ($question->type == 'passport')
										
											@php
											$dataRows = [
												'Passport series' => $amlReport->passport_series,
												'Passport number' => $amlReport->passport_number,
												'Passport issued date' => $amlReport->passport_issued_date,
												'Passport issued by' => $amlReport->passport_issued_by,
												'Passport subdivision code' => $amlReport->passport_subdivision_code,
											];
											@endphp
											
											<table class="table table-sm m-0">
												<tbody>
        											@foreach ($dataRows as $name => $value)
        												<tr>
        													<td class="text-muted text-small text-right {{ $loop->first ? 'no-border' : '' }}">{{ $name }}:</td>
        													<td class="{{ $loop->first ? 'no-border' : '' }}">{{ $value }}</td>
        												</tr>
        											@endforeach
												</tbody>
                							</table>
										@endif
										
										@if ($question->type == 'migration')
										
											@php
											$dataRows = [];
											if ($amlReport->migration_series && $amlReport->migration_number) {
    											$dataRows = [
    												'Migration series' => $amlReport->migration_series,
    												'Migration number' => $amlReport->migration_number,
    												'Migration stay from' => $amlReport->migration_stay_to,
    												'Migration stay to' => $amlReport->migration_stay_to,
    											];
											}
											@endphp
											
											@if (count($dataRows))
    											<table class="table table-sm m-0">
    												<tbody>
            											@foreach ($dataRows as $name => $value)
            												<tr>
            													<td class="text-muted text-small text-right {{ $loop->first ? 'no-border' : '' }}">{{ $name }}:</td>
            													<td class="{{ $loop->first ? 'no-border' : '' }}">{{ $value }}</td>
            												</tr>
            											@endforeach
    												</tbody>
                    							</table>
											@else
												<em class="text-muted">-- no data --</em>
											@endif
										@endif


										@if ($question->type == 'permission')
										
											@php
											$dataRows = [];
											if ($amlReport->permission_series && $amlReport->permission_number) {
    											$dataRows = [
    												'Permission series' => $amlReport->permission_series,
    												'Permission number' => $amlReport->permission_number,
    												'Permission stay from' => $amlReport->permission_stay_to,
    												'Permission stay to' => $amlReport->permission_stay_to,
    											];
											}
											@endphp
											
											@if (count($dataRows))
    											<table class="table table-sm m-0">
    												<tbody>
            											@foreach ($dataRows as $name => $value)
            												<tr>
            													<td class="text-muted text-small text-right {{ $loop->first ? 'no-border' : '' }}">{{ $name }}:</td>
            													<td class="{{ $loop->first ? 'no-border' : '' }}">{{ $value }}</td>
            												</tr>
            											@endforeach
    												</tbody>
                    							</table>
											@else
												<em class="text-muted">-- no data --</em>
											@endif
											
                							
										@endif
										
										@if ($question->type == 'address')

											{{ $amlReport->registration_address }}
                							
										@endif

										@if ($question->type == 'inn')
										
											{{ $amlReport->inn }}
                							
										@endif
										
										@if ($question->type == 'contacts')

											{{ $amlReport->questionnaire[$question->id] }}

										@endif
										
										@if ($question->type == 'employee')
											
											{!! nl2br($amlReport->questionnaire[$question->id]) !!}
                							
										@endif
										
										
										
										@if ($question->type == 'text')
										
											{!! nl2br($amlReport->questionnaire[$question->id]) !!}
                							
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
									{{ $amlReport->status()->name }}
								</td>
							</tr>
							 
    	        		</tbody>
	        		</table>
	        	</div>
	        	<div class="block-footer block-footer-default text-right">
	        		<a href="{{ route('clients.amlReport', $amlReport->id) }}" 
						class="btn btn-primary btn-sm"><i class="fa fa-fw fa-pencil-alt"></i> {{ __(('Редактировать')) }}</a>
	        	</div>
        	</div>
	        
	    </div>
	</div>
	
@endsection

