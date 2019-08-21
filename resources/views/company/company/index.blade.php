@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Company info',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-10 px-0">
        		<div class="block my-md-3 my-sm-2 my-0">
		        	<div class="block-content">
		        		@php
			        		$datetimeFormat = 'd M Y H:i:s';
		        			$data = [
		        				__('Общая информация') => [
		        					//__('ID') => $company ? $company->id : '---',
		        					__('Name') => $company ? $company->name : '---',
		        					__('Description') => $company ? nl2br($company->description) : '---',
		        					__('Phone') => $company ? $company->phone : '---',
		        					__('Country') => ($company && $company->country) ? $company->country->name : '---',
		        					__('City') => ($company && $company->city) ? $company->city->name : '---',
		        					__('Address') => $company ? $company->address : '---',
		        					__('Currency') => ($company && $company->currency) ? $company->currencyObj->code . ' [' . $company->currencyObj->name . ', ' . $company->currencyObj->symbol . ']' : '---',
		        					__('Time zone') => ($company && $company->timeZone) ? $company->timeZone->offset . ' [' . $company->timeZone->name . ']' : '---',
		        					__('Logo') => $company ? $company->logo : '---',
		        					__('Legal mentions') => $company ? nl2br($company->legal_mentions) : '---',
		        				],
		        				__('Системная информация') => [
		        					__('Date created') => $company ? (new DateTime($company->created_date))->format($datetimeFormat) : '---',
		        					__('Created by') => ($company && $company->createdBy) ? $company->createdBy->display_name : '---',
		        					__('Date modified') => $company ? (new DateTime($company->modified_date))->format($datetimeFormat) : '---',
		        					__('Modified by') => ($company && $company->modifiedBy) ? $company->modifiedBy->display_name : '---',
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
		        			
		        		<a href="{{ route('company.form') }}" 
		        			class="btn btn-sm btn-primary">{{ __('Edit Company Information') }}</a>
		        		
		        		<br><br>
		        		
		        	</div>
	        	</div>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
@endsection


