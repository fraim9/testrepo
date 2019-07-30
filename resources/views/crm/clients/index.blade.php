@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Clients',
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
        <div class="block">
        	<div class="block-content">
		        <table class="table table-bordered table-hover table-vcenter js-dataTable">
		        	<thead>
		        		<tr>
		        			<th>{{ __('ID') }}</th>
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('E-mail') }}</th>
		        			<th>{{ __('Phone') }}</th>
		        			<th class="text-center"><i class="fa fa-phone-square"></i></th>
		        			<th class="text-center"><i class="fa fa-envelope"></i></th>
		        			<th class="text-center"><i class="fa fa-comment-alt"></i></th>
		        			<th class="text-center"><i class="fa fa-home"></i></th>
		        			<th class="text-center"><i class="fa fa-clipboard-list"></i></th>
		        			<th class="text-center">Mini</th>
		        			<th class="text-center">AML</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($clients as $client)
			        		<tr>
			        			<td>{{ $client->id }}</td>
			        			<td><a href="{{ route('clients.info', $client->id) }}">{{ $client->name }}</a></td>
			        			<td>{{ $client->email }}</td>
			        			<td>{{ $client->phone }}</td>
			        			<td class="text-center {{ $client->voice_opt_in ? 'text-success' : 'text-light-gray' }}"><i class="fa fa-phone-square"></i></td>
			        			<td class="text-center {{ $client->email_opt_in ? 'text-success' : 'text-light-gray' }}"><i class="fa fa-envelope"></i></td>
			        			<td class="text-center {{ $client->msg_opt_in ? 'text-success' : 'text-light-gray' }}"><i class="fa fa-comment-alt"></i></td>
			        			<td class="text-center {{ $client->postal_opt_in ? 'text-success' : 'text-light-gray' }}"><i class="fa fa-home"></i></td>
			        			<td class="text-center text-light-gray">
			        				@if ($client->consent_file_id)
			        					<a href="{{ route('file.view', $client->consent_file_id) }}"
			        						><i class="fa fa-eye"></i></a>
			        					<a href="{{ route('file.download', $client->consent_file_id) }}"
			        						><i class="fa fa-download"></i></a>
			        				@else
			        					---
			        				@endif
			        			</td>
			        			<td class="text-center text-light-gray">
									@if ($client->amlMini)
			        					<a href="{{ route('file.view', $client->amlMini->questionnaire_file_id) }}"
			        						><i class="fa fa-eye"></i></a>
			        					<a href="{{ route('file.download', $client->amlMini->questionnaire_file_id) }}"
			        						><i class="fa fa-download"></i></a>
			        				@else
			        					---
			        				@endif
								</td>
			        			<td class="text-center text-light-gray">
									@if ($client->amlMini)
			        					@if ($client->amlMini->report->status()->id == \App\AmlReportStatus::COMPLETED)
    										<a href="{{ route('clients.amlReportView', $client->amlMini->report->id) }}" 
    											><i class="fa fa-eye"></i></a>
										@else
    										<a href="{{ route('clients.amlReport', $client->amlMini->report->id) }}" 
    											><i class="fa fa-edit"></i></a>
										@endif
			        				@else
			        					---
			        				@endif
								</td>
			        		</tr>
						@endforeach
			        </tbody>
		        </table>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
@endsection




@section('css_after')
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js_after')
	<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    
    <script>
        jQuery(function(){

        	// Init full DataTable
            jQuery('.js-dataTable').dataTable({
            	'columnDefs': [
					{ "width": "40px", "sortable":false, targets: [ 4, 5, 6, 7, 8, 9 ] }
				]
            });

        });
    </script>
    
@endsection

