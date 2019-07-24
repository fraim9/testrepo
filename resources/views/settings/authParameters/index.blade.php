@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Auth Parameters',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="content">
        <div class="block">
        	<div class="block-content">
        	
		        <div class="block">
		        	<div class="block-content">
		        		@php
			        		$datetimeFormat = 'd M Y H:i:s';
		        			$data = [
		        				__('Общая информация') => [
		        					__('Auth key') => $parameters ? $parameters->auth_key : '---',
		        					__('Auth code') => $parameters ? $parameters->auth_code : '---',
		        					__('Api auth url') => $parameters ? $parameters->api_auth_url : '---',
		        					__('Omnipos secret key') => $parameters ? $parameters->omnipos_secret_key : '---',
		        					__('Ipos secret key') => $parameters ? $parameters->ipos_secret_key : '---',
		        				],
		        				__('Системная информация') => [
		        					__('Date created') => $parameters ? (new DateTime($parameters->created_date))->format($datetimeFormat) : '---',
		        					__('Created by') => ($parameters && $parameters->createdBy) ? $parameters->createdBy->display_name : '---',
		        					__('Date modified') => $parameters ? (new DateTime($parameters->modified_date))->format($datetimeFormat) : '---',
		        					__('Modified by') => ($parameters && $parameters->modifiedBy) ? $parameters->modifiedBy->display_name : '---',
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
		        			
		        		<a href="{{ route('authParameters.form') }}" 
		        			class="btn btn-sm btn-primary">{{ __('Edit parameters') }}</a>
		        		
		        		<br><br>
		        		
		        	</div>
	        	</div>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
@endsection

