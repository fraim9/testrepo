@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Divisions',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add division',
                'url' => route('divisions.form', 0)
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
		        			<th>{{ __('A') }}</th>
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('External ID') }}</th>
		        			<th>{{ __('Sort index') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($divisions as $division)
			        		<tr>
			        			<td class="text-center">
			        				@include('helpers.viewBool', ['value' => $division->active])
			        			</td>
			        			<td>{{ $division->name }}</td>
			        			<td>{{ $division->code }}</td>
			        			<td>{{ $division->sort }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('divisions.form', $division->id), 
											'title' => 'Edit division'])
										@include('helpers.btnDelete', [
											'url' => route('divisions.delete', $division->id), 
											'title' => 'Remove division',
											'confirm' => 'Remove division?'])
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

