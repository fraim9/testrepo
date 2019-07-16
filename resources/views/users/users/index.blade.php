@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Users',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add user',
                'url' => route('users.form', 0)
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
		        			<th>{{ __('Display name') }}</th>
		        			<th>{{ __('E-mail') }}</th>
		        			<th>{{ __('User group') }}</th>
		        			<th>{{ __('ACL Role') }}</th>
		        			<th>{{ __('Subscribe') }}</th>
		        			<th>{{ __('Created') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($users as $user)
			        		<tr>
			        			<td class="text-center">
			        				@include('helpers.viewBool', ['value' => $user->active])
			        			</td>
			        			<td>
			        				{{ $user->display_name }}
			        				<div class="text-smallest text-flat-light">
			        					{{ implode(', ', array_column($user->stores->toArray(), 'name', 'id')) }}
			        				</div>
			        			</td>
			        			<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
			        			<td>{{ $user->group->name }}</td>
			        			<td>{{ $user->role ? $user->role->name : '---' }}</td>
			        			<td class="text-center">
			        				@include('helpers.viewBool', ['value' => $user->email_subscribe])
			        			</td>
			        			<td class="text-center">
			        				@include('helpers.viewDate', ['value' => $user->created_date])
			        			</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('users.form', $user->id), 
											'title' => 'Edit user'])
										@include('helpers.btnDelete', [
											'url' => route('users.delete', $user->id), 
											'title' => 'Remove user',
											'confirm' => 'Remove user?'])
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

