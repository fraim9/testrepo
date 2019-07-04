@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Employees',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add employee',
                'url' => route('employees.form', 0)
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
		        			<th>{{ __('Name') }}</th>
		        			<th>{{ __('External ID') }}</th>
		        			<th>{{ __('Personnel number') }}</th>
		        			<th>{{ __('Div') }}</th>
		        			<th>{{ __('Dep') }}</th>
		        			<th>{{ __('E-mail') }}</th>
		        			<th>{{ __('Phone') }}</th>
		        			<th>{{ __('Action') }}</th>
		        		</tr>
		        	</thead>
		        	<tbody>
			        	@foreach ($employees as $employee)
			        		<tr>
			        			<td class="text-center">
			        				@include('helpers.viewBool', ['value' => $employee->active])
			        			</td>
			        			<td>
			        				{{ $employee->name }}
			        				<div class="text-small text-muted">{{ $employee->position }}</div>
			        			</td>
			        			<td>{{ $employee->code }}</td>
			        			<td>{{ $employee->personnel_number }}</td>
			        			<td>{{ $employee->division ? $employee->division->name : '---' }}</td>
			        			<td>{{ $employee->department }}</td>
			        			<td>{{ $employee->email }}</td>
			        			<td>{{ $employee->phone }}</td>
			        			<td class="text-center">
									<div class="btn-group">
										@include('helpers.btnEdit', [
											'url' => route('employees.form', $employee->id), 
											'title' => 'Edit employee'])
										@include('helpers.btnDelete', [
											'url' => route('employees.delete', $employee->id), 
											'title' => 'Remove employee',
											'confirm' => 'Remove employee?'])
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
					{ "width": "80px", targets: [ 7 ] }
				]
            });

        });
    </script>
    
@endsection

