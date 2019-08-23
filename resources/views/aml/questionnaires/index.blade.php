@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Questionnaires',
    	'btns' => []
    ])

    <!-- Page Content -->
	<div class="content content-full">
        <table id="amlTable" class="table table-bordered table-hover table-vcenter js-dataTable">
        	<thead>
        		<tr>
        			<th data-class-name="text-center">{{ __('MINI ID') }}</th>
        			<th>{{ __('MINI') }}</th>
        			<th>{{ __('Store') }}</th>
        			<th>{{ __('Initiator') }}</th>
        			<th>{{ __('Created') }}</th>
        			<th data-class-name="text-center">{{ __('ID AML') }}</th>
        			<th>{{ __('AML') }}</th>
        			<th>{{ __('Responsible') }}</th>
        			<th>{{ __('Modified') }}</th>
        			<th data-class-name="text-center">{{ __('Client ID') }}</th>
        			<th>{{ __('Client Name') }}</th>
        		</tr>
        		<tr class="table-filter">
        			<th><input type="search" class="form-control" name="fMiniId" value="{{ $filter->fMiniId }}"></th>
        			<th></th>
        			<th>
        				<select class="js-select2 form-control" name="fStore" style="width: 100%;" data-placeholder="{{ __('-- all --') }}">
                        	<option></option>
                        	<option value="0">{{ __('-- all --') }}</option>
                            @if ($stores)
                            	@foreach ($stores as $store)
                            		<option value="{{ $store->id }}" {{ ($store->id == $filter->fStore) ? 'selected' : '' }}>{{ $store->name }}</option>
                            	@endforeach
                            @endif
                        </select>
        			</th>
        			<th>
        				<select class="js-select2 form-control" name="fInitiator" style="width: 100%;" data-placeholder="{{ __('-- all --') }}">
                        	<option></option>
                        	<option value="0">{{ __('-- all --') }}</option>
                            @if ($employees)
                            	@foreach ($employees as $employee)
                            		<option value="{{ $employee->id }}" {{ ($employee->id == $filter->fInitiator) ? 'selected' : '' }}>{{ $employee->name }}</option>
                            	@endforeach
                            @endif
                        </select>
        			</th>
        			<th></th>
        			<th><input type="search" class="form-control" name="fReportId" value="{{ $filter->fReportId }}"></th>
        			<th></th>
					<th>
        				<select class="js-select2 form-control" name="fResponsible" style="width: 100%;" data-placeholder="{{ __('-- all --') }}">
                        	<option></option>
                        	<option value="0">{{ __('-- all --') }}</option>
                            @if ($employees)
                            	@foreach ($employees as $employee)
                            		<option value="{{ $employee->id }}" {{ ($employee->id == $filter->fResponsible) ? 'selected' : '' }}>{{ $employee->name }}</option>
                            	@endforeach
                            @endif
                        </select>
        			</th>
        			<th></th>
        			<th><input type="search" class="form-control" name="fClientId" value="{{ $filter->fClientId }}"></th>
        			<th>
        				<select class="js-select2 form-control" name="fClient" style="width: 100%;" data-placeholder="{{ __('-- all --') }}">
                        	<option></option>
                        	<option value="0">{{ __('-- all --') }}</option>
                            @if ($employees)
                            	@foreach ($clients as $client)
                            		<option value="{{ $client->id }}" {{ ($client->id == $filter->fClient) ? 'selected' : '' }}>{{ $client->name }}</option>
                            	@endforeach
                            @endif
                        </select>
        			</th>
        		</tr>
        	</thead>
        </table>
        
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
                	jQuery('#amlTable'), 
                	'{!! route('questionnaires.filter') !!}',
                	{
                		serverSide: true,
                		ajax: '{!! route('questionnaires.data') !!}',
                        columns: [
                            { data: 'miniId', name: 'miniId' },
                            { data: 'mini', name: 'mini' },
                            { data: 'store', name: 'store' },
                            { data: 'initiator', name: 'initiator' },
                            { data: 'created', name: 'created' },
                            { data: 'idReport', name: 'idReport' },
                            { data: 'report', name: 'report' },
                            { data: 'responsible', name: 'responsible' },
                            { data: 'modified', name: 'modified' },
                            { data: 'clientId', name: 'clientId' },
                            { data: 'clientName', name: 'clientName' },
                        ],
                    	columnDefs: [
                    		{ "width": "60px", "sortable":false, targets: [ 1, 6 ] },
                    		{ "width": "40px", targets: [ 0, 5, 9 ] },
                    		//{ "sortable":false, targets: [ 2, 3, 7, 10 ] },
                    		//{ "visible": false, targets: [ 4, 5, 6, 11, 15, 16 ] },
        				],
        				order: [[ 0, 'desc' ]],
            		}
            );
        	
        });
    </script>
    
@endsection



