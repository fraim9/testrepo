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
        		
		        <table id="usersTable" class="table table-bordered table-hover table-vcenter js-dataTable">
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

	@include('helpers.datatables.includeCSS')
	
@endsection


@section('js_after')
	
	@include('helpers.datatables.includeJS')
	
    <script>
        jQuery(function(){

        	dtAdapter.init(
                	jQuery('.js-dataTable'), 
                	'{!! route('users.filter') !!}',
                	{
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
            		}
            );

        });
    </script>
    
@endsection

