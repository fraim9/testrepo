@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'ACL Roles',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add role',
                'url' => route('aclRoles.form', 0)
            ]
    	]
    ])

    <!-- Page Content -->
    <div class="content content-full">
        <table class="table table-bordered table-hover table-vcenter js-dataTable">
        	<thead>
        		<tr>
        			<th>{{ __('Name') }}</th>
        			<th>{{ __('Access to resources') }}</th>
        			<th>{{ __('Created') }}</th>
        			<th>{{ __('Action') }}</th>
        		</tr>
        	</thead>
        	<tbody>
	        	@foreach ($roles as $role)
	        		<tr>
	        			<td>{{ $role->name }}</td>
	        			<td>
							@if ($groups)
								@foreach ($groups as $group)
									@if ($resourceByGroup[$group->id])
										<div class="text-small"><strong>{{ $group->name }}</strong>:
            								@foreach ($resourceByGroup[$group->id] as $resource)
            									<span class="{{ (isset($role->rights[$resource->id]) && $role->rights[$resource->id]) ? 'text-success' : 'text-muted' }}">{{ $resource->name }}</span>, 
            								@endforeach
            							</div>
           							@endif
								@endforeach
							@endif
						</td>
	        			<td class="text-center">
	        				@include('helpers.viewDate', ['value' => $role->created_date])
	        			</td>
	        			<td class="text-center">
							<div class="btn-group">
								@include('helpers.btnEdit', [
									'url' => route('aclRoles.form', $role->id), 
									'title' => 'Edit user'])
								@include('helpers.btnDelete', [
									'url' => route('aclRoles.delete', $role->id), 
									'title' => 'Remove role',
									'confirm' => 'Remove role?'])
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
					{ "width": "80px", targets: [ 4 ] }
				]
            });

        });
    </script>
    
@endsection

