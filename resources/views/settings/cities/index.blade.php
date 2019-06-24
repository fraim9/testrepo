@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Cities',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add city',
                'url' => route('cities.form', 0)
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
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('Code') }}</th>
		        			<th>{{ __('Country') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($cities as $city)
			        		<tr>
			        			<td>{{ $city->name }}</td>
			        			<td>{{ $city->code }}</td>
			        			<td>{{ $city->country->name }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('cities.form', $city->id), 
											'title' => 'Edit city'])
										@include('helpers.btnDelete', [
											'url' => route('cities.delete', $city->id), 
											'title' => 'Remove city',
											'confirm' => 'Remove city?'])
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
					{ "width": "80px", targets: [ 3 ] }
				]
            });

            
        });
    </script>
    
@endsection

