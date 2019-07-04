@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Prices',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add price',
                'url' => route('prices.form', 0)
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
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($prices as $price)
			        		<tr>
			        			<td>{{ $price->name }}</td>
			        			<td>{{ $price->code }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('prices.form', $price->id), 
											'title' => 'Edit price'])
										@include('helpers.btnDelete', [
											'url' => route('prices.delete', $price->id), 
											'title' => 'Remove price',
											'confirm' => 'Remove price?'])
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
					{ "width": "80px", targets: [ 2 ] }
				]
            });

        });
    </script>
    
@endsection

