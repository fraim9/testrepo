@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'User Sessions',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="content">
        <div class="block">
        	<div class="block-content">
        		
		        <table id="usersTable" class="table table-bordered table-hover table-vcenter js-dataTable">
		        	<thead>
		        		<tr>
		        			<th data-class-name="text-center text-nowrap">{{ __('Date') }}</th>
		        			<th data-class-name="text-center ">{{ __('Type') }}</th>
		        			<th>{{ __('User') }}</th>
		        			<th>{{ __('App name') }}</th>
		        			<th>{{ __('App version') }}</th>
		        			<th>{{ __('Device name') }}</th>
		        		</tr>
		        		<tr class="table-filter">
		        			<th></th>
		        			<th>
		        				<select class="form-control form-control-sm" name="fType">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($types)
                                    	@foreach ($types as $type)
                                    		<option value="{{ $type->id + 1 }}" {{ (($type->id + 1) == $filter->fType) ? 'selected' : '' }}>{{ $type->name }}</option>
                                    	@endforeach
                                    @endif
                                </select>
		        			</th>
		        			<th>
		        				<select class="form-control form-control-sm" name="fUser">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($users)
                                    	@foreach ($users as $user)
                                    		<option value="{{ $user->id }}" {{ ($user->id == $filter->fUser) ? 'selected' : '' }}>{{ $user->display_name }}</option>
                                    	@endforeach
                                    @endif
                                </select>
		        			</th>
		        			<th>
		        				<select class="form-control form-control-sm" name="fAppName">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($appNames)
                                    	@foreach ($appNames as $appName)
                                    		<option value="{{ $appName }}" {{ ($appName == $filter->fAppName) ? 'selected' : '' }}>{{ $appName }}</option>
                                    	@endforeach
                                    @endif
                                </select>
		        			</th>
		        			<th>
		        				<select class="form-control form-control-sm" name="fAppVersion">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($appVersions)
                                    	@foreach ($appVersions as $appVersion)
                                    		<option value="{{ $appVersion }}" {{ ($appVersion == $filter->fAppVersion) ? 'selected' : '' }}>{{ $appVersion }}</option>
                                    	@endforeach
                                    @endif
                                </select>
		        			</th>
		        			<th>
		        				<select class="form-control form-control-sm" name="fDeviceName">
                                	<option value="">{{ __('-- all --') }}</option>
                                    @if ($deviceNames)
                                    	@foreach ($deviceNames as $deviceName)
                                    		<option value="{{ $deviceName }}" {{ ($deviceName == $filter->fDeviceName) ? 'selected' : '' }}>{{ $deviceName }}</option>
                                    	@endforeach
                                    @endif
                                </select>
		        			</th>
		        			
		        			
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
                	'{!! route('userSessions.filter') !!}',
                	{
                		serverSide: true,
                		ajax: '{!! route('userSessions.data') !!}',
                        columns: [
                            { data: 'date', name: 'date' },
                            { data: 'type', name: 'type' },
                            { data: 'user', name: 'user' },
                            { data: 'app_name', name: 'app_name' },
                            { data: 'app_version', name: 'app_version' },
                            { data: 'device_name', name: 'device_name' },
                        ],
                    	columnDefs: [
                    		{ "sortable":false, targets: [ 1, 2 ] },
        				],
        				order: [[ 0, 'desc' ]],
            		}
            );

        });
    </script>
    
@endsection

