@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Store groups',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add store group',
                'url' => route('storeGroups.form', 0)
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
		        			<th>{{ __('iPos settings') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($groups as $group)
			        		<tr>
			        			<td>{{ $group->name }}</td>
			        			<td>
			        				<ul class="text-small compact">
									@foreach ($iposFeatures as $iposFeature)
										<li>
											<span class="">{{ __($iposFeature->name) }}</span>:
											@include('helpers.viewBool', ['value' => $group->ipos_settings[$iposFeature->id]])
										</li>
									@endforeach
									</ul>
								</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('storeGroups.form', $group->id), 
											'title' => 'Edit group'])
										@include('helpers.btnDelete', [
											'url' => route('storeGroups.delete', $group->id), 
											'title' => 'Remove group',
											'confirm' => 'Remove group?'])
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

