@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Settings',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="container">
    	<div class="row justify-content-center">
       		<div class="col-md-10 px-0">
        		<div class="block my-md-3 my-sm-2 my-0">
        			<div class="block-content">
        		
                		<div class="row">
                			<div class="col-md-4">
                        		<div class="list-group">
                		        	@foreach ($settingsList as $settings)
                		        		
                		        		<a href="{{ route('settings.form', $settings->_id) }}" 
                		        			class="list-group-item list-group-item-action">{{ $settings->_id }}</a>
                		        		
                		        	@endforeach
                        		</div>
                       		</div>
                   		</div>
        		
        				<br><br>
        		
		        	</div>
	        	</div>
        	</div>
        </div>
        
    </div>
    <!-- END Page Content -->
    
@endsection