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
		        			<th>{{ __('Code') }}</th>
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('E-mail') }}</th>
		        			<th>{{ __('Phone') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($clients as $client)
			        		<tr>
			        			<td>{{ $client->id }}</td>
			        			<td>{{ $client->code }}</td>
			        			<td>{{ $client->name }}</td>
			        			<td>{{ $client->email }}</td>
			        			<td>{{ $client->phone }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('clients.form', $client->id), 
											'title' => 'Edit client'])
										@include('helpers.btnDelete', [
											'url' => route('clients.delete', $client->id), 
											'title' => 'Remove client',
											'confirm' => 'Remove client?'])
									</div>
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
					{ "width": "80px", targets: [ 4 ] }
				]
            });

        });
    </script>
    
@endsection

