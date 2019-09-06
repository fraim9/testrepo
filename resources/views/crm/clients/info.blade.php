@extends('layouts.backend')

@section('content')

	@include('layouts.backendPageHero', [
    	'title' => $client->name,
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="">
    	<div class="container-fluid py-md-3">
	    <div class="row">
	        <div class="col-md-5 py-xs-0">
	        	<div class="block">
		        	<div class="block-content">
		        		@php
		        			$datetimeFormat = 'd M Y H:i:s';
		        			$bdText = '';
		        			if ($client->bd_year && $client->bd_month && $client->bd_day) {
		        				$bdDate = new DateTime($client->bd_year . '-' . $client->bd_month . '-' . $client->bd_day);
		        				$bdText = $bdDate->format('d M Y');
		        			}
		        			$yes = '<i class="fa fa-check-square text-success"></i>';
		        			$no = '<i class="fa fa-square"></i>';
		        			
		        			$fileLink = $client->consent_file_id ? 
		        				'<a href="' . route('file.view', $client->consent_file_id) . '" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> ' . __('Просмотр') . '</a>' . 
		        				'<a href="' . route('file.download', $client->consent_file_id) . '" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> ' . __('Скачать') . '</a>' 
		        			: '---';
		        			
		        			$data = [
		        				__('Контакты') => [
		        					__('Телефон') => $client->phone,
		        					__('E-mail') => $client->email,
		        				],
		        				__('Общая информация') => [
		        					__('ID') => $client->id,
		        					__('External ID') => $client->code,
		        					__('Фамилия') => $client->last_name,
		        					__('Имя') => $client->first_name,
		        					__('Отчество') => $client->middle_name,
		        					__('Фамилия (lat)') => $generalSettings['client']['nameLat'] ? $client->last_name_lat : 'hide',
		        					__('Имя (lat)') => $generalSettings['client']['nameLat'] ? $client->first_name_lat : 'hide',
		        					__('Пол') => ($client->gender == 'M') ? __('Мужской') : __('Женский'),
		        					__('День рождения') => $bdText,
		        					__('Место рождения') => $client->birth_place,
		        					__('Примечание') => $client->comment,
		        					__('Discount') => $client->discount . '%',
		        				],
		        				__('Адрес') => [
		        					__('Страна') => $client->country->name,
		        					__('Почтовый индекс') => $client->postcode,
		        					__('Город') => $client->city,
		        					__('Адрес') => $client->address,
		        					__('Time Zone') => $client->timeZone->offset . ' (' . $client->timeZone->name . ')',
		        				],
		        				__('Регистрационная информация') => [
		        					__('ИНН') => $client->inn,
		        					__('Адрес регистрации') => $client->registration_address,
		        				],
		        				__('Opt-Ins') => [
		        					__('на почту') => $client->postal_opt_in ? $yes : $no,
		        					__('по телефону') => $client->voice_opt_in ? $yes : $no,
		        					__('по e-mail') => $client->email_opt_in ? $yes : $no,
		        					__('по SMS') => $client->msg_opt_in ? $yes : $no,
		        				],
		        				__('Consent') => [
		        					__('Consent signed') => $client->consent_signed ? $yes : $no,
		        					__('Файл соглашения (PDF)') => $fileLink,
		        				],
		        				__('Привязки') => [
		        					__('Создал') => $client->created_employee_id ? $client->createdEmployee->name : '---',
		        					__('Ответственный') => $client->responsible_id ? $client->responsible->name : '---',
		        					__('Это сотрудник') => $client->employee_id ? $client->employee->name : __('нет'),
		        					__('Создан в магазине') => $client->created_store_id ? $client->createdStore->name : '---',
		        					__('Закреплен за магазином') => $client->attached_store_id ? $client->attachedStore->name : '---',
		        				],
		        				__('Системная информация') => [
		        					__('Date created') => (new DateTime($client->created_date))->format($datetimeFormat),
		        					__('Created by') => $client->createdBy->display_name,
		        					__('Date modified') => (new DateTime($client->modified_date))->format($datetimeFormat),
		        					__('Modified by') => $client->modifiedBy->display_name,
		        				],
		        			];
		        		
		        		@endphp
		        		
        				@foreach($data as $group => $rows)
        					<h5>{{ $group }}</h5>
        					<table class="table table-sm">
			        			<tbody>
                					@foreach($rows as $name => $value)
                						@if ($value != 'hide') 
                    						<tr>
            		        					<td style="width:45%" class="text-small text-muted">{{ $name }}</td>
            		        					<td class="">{!! $value !!}</td>
            		        				</tr>
            		        			@endif
                					@endforeach
			        			</tbody>
			        		</table>
        				@endforeach
		        		<br>
		        		<hr>
		        		
						<div class="row">
    						<div class="col-6">
        		        		<a href="{{ route('clients.form', $client->id) }}" 
        		        			class="btn btn-sm btn-primary">{{ __('Редактировать информацию по клиенту') }}</a>
    						</div>
    						<div class="col-6 text-right">
        		        		<a href="{{ route('clients.delete', $client->id) }}" 
        		        			class="btn btn-sm btn-outline-dark" onclick="return confirm('{{ __('Delete this client?') }}');"
        		        			>{{ __('Delete') }}</a>
    						</div>
						</div>
		        		<br><br>
		        		
		        	</div>
	        	</div>
	        </div>	
	        
	        <div class="col-md-7 py-xs-0">

	        	<div class="block">
	        		<div class="block-header block-header-default">
    	        		<h3 class="block-title">{{ __('Анкеты') }}</h3>
    	        	</div>
		        	<div class="block-content">
		        		@if ($amlMiniList)
		        			
		        			@foreach ($amlMiniList as $amlMini)
		        				<table class="table mb-4">
    		        				<thead>
    		        					<tr>
    		        						<th>{{ __('Дата') }}</th>
    		        						<th>{{ __('Магазин') }}</th>
    		        						<th>{{ __('Сотрудник') }}</th>
    		        					</tr>
    		        				</thead>
    		        				<tbody>
		        						<tr>
		        							<td>@include('helpers.viewDate', ['value' => $amlMini->created_date])</td>
		        							<td>{{ $amlMini->store->name }}</td>
		        							<td>{{ $amlMini->initiator_id ? $amlMini->initiator->name : '---' }}</td>
		        						</tr>
		        						<tr>
		        							<td colspan="3" class="">
		        								<div class="row">
		        									<div class="col-sm-6">
        												<a href="{{ route('file.view', $amlMini->questionnaire_file_id) }}" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> {{ __('Просмотр') }}</a>
        						        				<a href="{{ route('file.download', $amlMini->questionnaire_file_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> {{ __('Скачать') }}</a>
		        									</div>
		        									<div class="col-sm-6">
		        										<div class="row">
        		        									<div class="col-sm-6 text-right">
        		        										{{ __('Отчет') }}:
        		        									</div>
        		        									<div class="col-sm-6 text-nowrap">
        		        										@if ($amlMini->report->status()->id == \App\AmlReportStatus::COMPLETED)
            		        										<a href="{{ route('clients.amlReportView', $amlMini->report->id) }}" 
            		        											class="btn btn-success btn-sm"><i class="fa fa-file"></i> {{ __($amlMini->report->status()->name) }}</a>
        		        										@else
            		        										<a href="{{ route('clients.amlReport', $amlMini->report->id) }}" 
            		        											class="btn btn-dark btn-sm"><i class="fa fa-file"></i> {{ __($amlMini->report->status()->name) }}</a>
        		        										@endif
        		        									</div>
    		        									</div>
    		        									@if ($amlMini->report->status()->id == \App\AmlReportStatus::COMPLETED)
        		        									<div class="row mt-1">
            		        									<div class="col-sm-6 text-right text-small text-muted">
            		        										{{ __('Ответственный') }}:
            		        									</div>
            		        									<div class="col-sm-6">
            		        										{{ $amlMini->report->responsible_id ? $amlMini->report->responsible->name : '---' }}
            		        									</div>
            		        								</div>
        		        									<div class="row mt-1">
            		        									<div class="col-sm-6 text-right text-small text-muted">
            		        										{{ __('Изменено') }}:
            		        									</div>
            		        									<div class="col-sm-6">
            		        										@include('helpers.viewDate', ['value' => $amlMini->report->modified_date, 'format' => 'd M Y H:i:s'])
            		        									</div>
            		        								</div>
        		        								@endif
            		        									
		        									</div>
		        								</div> 
		        							</td>
		        						</tr>
    		        				</tbody>
    		        			</table>
		        			@endforeach
		        		@else
		        			<div class="text-muted text-small pb-4">{{ __('Связанных анкет не обнаружено') }}</div>
		        		@endif
		        	</div>
	        	</div>

	        	<div class="block">
	        		<div class="block-header block-header-default">
    	        		<h3 class="block-title">{{ __('Активности') }}</h3>
    	        	</div>
		        	<div class="block-content">
		        		<div class="text-muted text-small pb-4">{{ __('Активностей пока нет') }}</div>
		        	</div>
	        	</div>
	        	
	        	<div class="block">
	        		<div class="block-header block-header-default">
    	        		<h3 class="block-title">{{ __('Покупки') }}</h3>
    	        	</div>
		        	<div class="block-content">
		        		<div class="text-muted text-small pb-4">{{ __('Покупок пока нет') }}</div>
		        	</div>
	        	</div>
	        	
	        </div>	
	        
	    </div>
	    </div>
	</div>
	
@endsection

