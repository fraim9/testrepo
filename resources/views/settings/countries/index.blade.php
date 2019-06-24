@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Countries',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add country',
                'url' => route('countries.form', 0)
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
		        			<th>{{ __('ISO 2') }}</th>
		        			<th>{{ __('ISO 3') }}</th>
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('Calling code') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($countries as $country)
			        		<tr>
			        			<td>{{ $country->iso2 }}</td>
			        			<td>{{ $country->iso3 }}</td>
			        			<td>{{ $country->name }}</td>
			        			<td>{{ $country->calling_code }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('countries.form', $country->id), 
											'title' => 'Edit country'])
										@include('helpers.btnDelete', [
											'url' => route('countries.delete', $country->id), 
											'title' => 'Remove country',
											'confirm' => 'Remove country?'])
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

