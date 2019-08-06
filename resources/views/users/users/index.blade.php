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
		        			<th data-class-name="text-center">{{ __('A') }}</th>
		        			<th>{{ __('Display name') }}</th>
		        			<th>{{ __('E-mail') }}</th>
		        			<th>{{ __('User group') }}</th>
		        			<th>{{ __('ACL Role') }}</th>
		        			<th data-class-name="text-center">{{ __('Subscribe') }}</th>
		        			<th data-class-name="text-center">{{ __('Created') }}</th>
		        		</tr>
		        		<tr class="table-filter">
		        			<th>
		        				<select id="fActive" type="text" class="form-control form-control-sm" name="fActive">
                                	<option value="">{{ __('-- all --') }}</option>
									<option value="1" {{ (1 == $filter->fActive) ? 'selected' : '' }}>{{ __('selected') }}</option>
									<option value="2" {{ (2 == $filter->fActive) ? 'selected' : '' }}>{{ __('not selected') }}</option>
                                </select>
		        			</th>
		        			<th><input type="text" class="form-control" name="fDisplayName" id="display_name_search" value="{{ $filter->fDisplayName }}"></th>
		        			<th><input type="text" class="form-control" name="fEmail" id="email_search" value="{{ $filter->fEmail }}"></th>
		        			<th>
								<select id="fUserGroupId" type="text" class="form-control" name="fUserGroupId">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($roles)
                                    	@foreach ($userGroups as $userGroup)
                                    		<option value="{{ $userGroup->id }}" {{ ($userGroup->id == $filter->fUserGroupId) ? 'selected' : '' }}>{{ $userGroup->name }}</option>
                                    	@endforeach
                                    @endif
                                </select>
							</th>
		        			<th>
		        				<select id="fRoleId" type="text" class="form-control" name="fRoleId">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($roles)
                                    	@foreach ($roles as $role)
                                    		<option value="{{ $role->id }}" {{ ($role->id == $filter->fRoleId) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    	@endforeach
                                    @endif
                                </select>
							</th>
		        			<th>
		        				<select id="fEmailSubscribe" type="text" class="form-control" name="fEmailSubscribe">
                                	<option value="">{{ __('-- all --') }}</option>
									<option value="1" {{ (1 == $filter->fEmailSubscribe) ? 'selected' : '' }}>{{ __('selected') }}</option>
									<option value="2" {{ (2 == $filter->fEmailSubscribe) ? 'selected' : '' }}>{{ __('not selected') }}</option>
                                </select>
		        			</th>
		        			<th></th>
		        		</tr>
		        	</thead>
		        </table>
        
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
@endsection




@section('css_after')
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">

	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/ColReorder-1.5.0/css/colReorder.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/ColReorder-1.5.0/css/colReorder.bootstrap4.min.css') }}">
	
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap4.min.css') }}">
	
@endsection

@section('js_after')
	<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/datatables/ColReorder-1.5.0/js/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/ColReorder-1.5.0/js/colReorder.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/Buttons-1.5.6/js/buttons.print.min.js') }}"></script>

    <script>
        jQuery(function(){

        	// Init full DataTable
            var oTable = jQuery('.js-dataTable').dataTable({
                serverSide: true,
                ajax: '{!! route('users.data') !!}',
                columns: [
                    { data: 'active', name: 'active' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'email', name: 'email' },
                    { data: 'group_id', name: 'group_id' },
                    { data: 'role_id', name: 'role_id' },
                    { data: 'email_subscribe', name: 'email_subscribe' },
                    { data: 'created_date', name: 'created_date' },
                ],
            	columnDefs: [
					{ "width": "40px", targets: [ 0, 5 ] },
				],
            });

        	var timerId = null;
            $('.js-dataTable thead tr input,select').on( 'keyup change clear', function () {
				var control = $(this);
				clearTimeout(timerId);
				timerId = setTimeout(function() {
						var data = {};
						data[control.attr('name')] = control.val();
	                	axios.get('{!! route('users.filter') !!}', {
	                			params: data
	                		})
	                		.then(function (response) {
	                			oTable.fnDraw();
	                		})
	                		.catch(function (error) {
	                	  		console.log(error);
	                		});
					}, 500);
            });

        });
    </script>
    
@endsection

