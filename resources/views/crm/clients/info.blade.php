@extends('layouts.backend')

@section('content')

	@include('layouts.backendPageHero', [
    	'title' => $client->name,
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add client',
                'url' => route('clients.form', 0)
            ]
    	]
    ])

    <!-- Page Content -->
    <div class="content">
	    <div class="row">
	        <div class="wr30">
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
		        			
		        			$fileLink = $client->consent_file ? 
		        				'<a href="' . route('file.view', $client->consent_file) . '" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> ' . __('просмотр') . '</a>' . 
		        				'<a href="' . route('file.download', $client->consent_file) . '" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> ' . __('скачать') . '</a>' 
		        			: '---';
		        			
		        			$data = [
		        				__('Контакты') => [
		        					__('Телефон') => $client->phone,
		        					__('E-mail') => $client->email,
		        				],
		        				__('Общая информация') => [
		        					__('Фамилия') => $client->last_name,
		        					__('Имя') => $client->first_name,
		        					__('Отчество') => $client->middle_name,
		        					__('Фамилия (lat)') => $client->first_name_lat,
		        					__('Имя (lat)') => $client->last_name_lat,
		        					__('Пол') => ($client->gender == 'M') ? __('Мужской') : __('Женский'),
		        					__('День рождения') => $bdText,
		        					__('Место рождения') => $client->birth_place,
		        					__('Примечание') => $client->comment,
		        				],
		        				__('Адрес') => [
		        					__('Страна') => $client->country->name,
		        					__('Почтовый индекс') => $client->postcode,
		        					__('Город') => $client->city,
		        					__('Адрес') => $client->address,
		        				],
		        				__('Регистрационная информация') => [
		        					__('ИНН') => $client->inn,
		        					__('Адрес регистрации') => $client->registration_address,
		        				],
		        				__('Соглашения') => [
		        					__('Рассылка') => $client->subscribe ? $yes : $no,
		        					__('на почту') => $client->postal_opt_in ? $yes : $no,
		        					__('по телефону') => $client->voice_opt_in ? $yes : $no,
		        					__('по e-mail') => $client->email_opt_in ? $yes : $no,
		        					__('по SMS') => $client->msg_opt_in ? $yes : $no,
		        					__('Соглашение подписано') => $client->agreement_signed ? $yes : $no,
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
		        					__('ID') => $client->id,
		        					__('External ID') => $client->code,
		        					__('Time Zone') => $client->timeZone->offset . ' (' . $client->timeZone->name . ')',
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
                						<tr>
        		        					<td style="width:33%" class="text-small text-muted">{{ $name }}</td>
        		        					<td class="">{!! $value !!}</td>
        		        				</tr>
                					@endforeach
			        			</tbody>
			        		</table>
        				@endforeach
		        		<br>
		        		<hr>
		        			
		        		<a href="{{ route('clients.form', $client->id) }}" 
		        			class="btn btn-sm btn-primary">{{ __('Редактировать информацию по клиенту') }}</a>
		        		
		        		<br><br>
		        		
		        	</div>
	        	</div>
	        </div>	
	        
	        <div class="col">

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
        												<a href="{{ route('file.view', $amlMini->questionnaire_file) }}" target="_blank" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> {{ __('просмотр') }}</a>
        						        				<a href="{{ route('file.download', $amlMini->questionnaire_file) }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> {{ __('скачать') }}</a>
		        									</div>
		        									<div class="col-sm-3 text-right">
		        										{{ __('ОТЧЕТ') }}:
		        									</div>
		        									<div class="col-sm-3">
		        										<a href="{{ route('clients.amlReport', $amlMini->report->id) }}" 
		        											class="btn {{ $amlMini->report->status()->id == 1 ? 'btn-dark' : 'btn-success' }}  btn-sm"><i class="fa fa-file"></i> {{ $amlMini->report->status()->name }}</a>
		        									</div>
		        								</div>
		        								@if ($amlMini->report->status()->id == \App\AmlReportStatus::COMPLETED)
		        									<div class="row mt-1">
    		        									<div class="col-sm-6">
    		        									</div>
    		        									<div class="col-sm-3 text-right text-small text-muted">
    		        										{{ __('Ответственный') }}:
    		        									</div>
    		        									<div class="col-sm-3">
    		        										{{ $amlMini->report->responsible->name }}
    		        									</div>
    		        								</div>
		        								@endif
		        								
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
	
@endsection
