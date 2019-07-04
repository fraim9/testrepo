@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Stores',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add store',
                'url' => route('stores.form', 0)
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
		        			<th>{{ __('External ID') }}</th>
		        			<th>{{ __('Phone') }}</th>
		        			<th>{{ __('Store group') }}</th>
		        			<th>{{ __('Currency') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($stores as $store)
			        		<tr>
			        			<td>
			        				{{ $store->name }}
			        				<div class="text-small text-muted">{{ $store->address }}</div>
			        			</td>
			        			<td>{{ $store->code }}</td>
			        			<td>{{ $store->phone }}</td>
			        			<td>{{ $store->group->name }}</td>
			        			<td>{{ $store->currency }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('stores.form', $store->id), 
											'title' => 'Edit user'])
										@include('helpers.btnDelete', [
											'url' => route('stores.delete', $store->id), 
											'title' => 'Remove store',
											'confirm' => 'Remove store?'])
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

