@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Time zones',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add time zone',
                'url' => route('timeZones.form', 0)
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
		        			<th>{{ __('Code') }}</th>
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('Offset') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($zones as $zone)
			        		<tr>
			        			<td>{{ $zone->code }}</td>
			        			<td>{{ $zone->name }}</td>
			        			<td>{{ $zone->offset }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('timeZones.form', $zone->id), 
											'title' => 'Edit time zone'])
										@include('helpers.btnDelete', [
											'url' => route('timeZones.delete', $zone->id), 
											'title' => 'Remove time zone',
											'confirm' => 'Remove time zone?'])
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

