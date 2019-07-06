@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'User groups',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add user group',
                'url' => route('userGroups.form', 0)
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
		        			<th>{{ __('iPos rights') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($groups as $group)
			        		<tr>
			        			<td>{{ $group->name }}</td>
			        			<td>
			        				<ul class="text-small compact">
									@foreach ($userRights as $userRight)
										<li>
											<span class="">{{ __($userRight->name) }}</span>:
											<span class="text-info">{{ $userRightValues[$userRight->id][$group->ipos_rights[$userRight->id]] ?? '---' }}</span>
										</li>
									@endforeach
									</ul>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('userGroups.form', $group->id), 
											'title' => 'Edit group'])
										@include('helpers.btnDelete', [
											'url' => route('userGroups.delete', $group->id), 
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

