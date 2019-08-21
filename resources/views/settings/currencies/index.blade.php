@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Currencies',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add currency',
                'url' => route('currencies.form', 'NEW')
            ]
    	]
    ])

    <!-- Page Content -->
    <div class="content content-full">
        <table class="table table-bordered table-hover table-vcenter js-dataTable">
        	<thead>
        		<tr>
        			<th>{{ __('Code') }}</th>
        			<th>{{ __('Name') }}</th>
        			<th>{{ __('Symbol') }}</th>
        			<th>{{ __('Action') }}</th>
        		</tr>
        	</thead>
        	<tbody>
	        	@foreach ($currencies as $currency)
	        		<tr>
	        			<td>{{ $currency->code }}</td>
	        			<td>{{ $currency->name }}</td>
	        			<td>{{ $currency->symbol }}</td>
	        			<td class="text-center">
							<div class="btn-group">
								@include('helpers.btnEdit', [
									'url' => route('currencies.form', $currency->code), 
									'title' => 'Edit currency'])
								@include('helpers.btnDelete', [
									'url' => route('currencies.delete', $currency->code), 
									'title' => 'Remove currency',
									'confirm' => 'Remove currency?'])
							</div>
						</td>
	        		</tr>
				@endforeach
	        </tbody>
        </table>
        
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
					{ "width": "80px", "sorting": false, targets: [ 3 ] }
				]
            });

            
        });
    </script>
    
@endsection

