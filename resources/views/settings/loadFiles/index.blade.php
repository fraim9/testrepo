@extends('layouts.backend')

@section('content')

	@include('layouts.backendPageHero', [
    	'title' => 'Load data from files',
    	'btns' => []
    ])
    
	<div class="container py-3">
	    <div class="row">
	        <div class="col-xl-4 col-lg-6">
	        
	        	<div class="block">
					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Person mass destruction') }}</h3>
    	        		</div>
    					<div class="block-content py-3">
							<input type="hidden" name="typeOfFile" value="PersonMassDestruction">
							<input type="file" name="xmlfile" id="xmlfile" required>
    					</div>
    					
    					<div class="block-footer block-footer-default">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                	data-style="expand-right">{{ __('Load') }}</button>
                            </div>
                            <div class="">
                            	@if (isset($data['PersonMassDestructionLoaded']))
                            		@php
                            		$action = $data['PersonMassDestructionLoaded'];
                            		@endphp
                            		<div>
                                    	<span class="text-muted text-small">{{ __('Last update') }}: </span>
                                    	@include('helpers.viewDate', ['value' => $action->date, 'format' => 'd M Y H:i'])
                                	</div>
                                	<div>
                                    	<span class="text-muted text-small">{{ __('User') }}: </span>
                                    	{{ $action->user->display_name }}
                                    </div>
                                @endif
                            </div>
                        </div>
    					
					</form>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6">
	        
	        	<div class="block">
					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Person blocked') }}</h3>
    	        		</div>
    					<div class="block-content py-3">
							
							<input type="hidden" name="typeOfFile" value="PersonBlocked">
							<input type="file" name="xmlfile" id="xmlfile" required>
							
    					</div>
    					
    					<div class="block-footer block-footer-default">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                	data-style="expand-right">{{ __('Load') }}</button>
                            </div>
                        	@if (isset($data['PersonBlokedLoaded']))
                        		@php
                        		$action = $data['PersonBlokedLoaded'];
                        		@endphp
                            	<div>
                                	<span class="text-muted text-small">{{ __('Last update') }}: </span>
                                	@include('helpers.viewDate', ['value' => $action->date, 'format' => 'd M Y H:i'])
                            	</div>
                            	<div>
                                	<span class="text-muted text-small">{{ __('User') }}: </span>
                                	{{ $action->user->display_name }}
                                </div>
                            @endif
                        </div>
    					
					</form>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6">
			
	        	<div class="block">
					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
						@csrf
    	        		<div class="block-header block-header-default">
    	        			<h3 class="block-title">{{ __('Terrorist') }}</h3>
    	        		</div>
    					<div class="block-content py-3">
							<input type="hidden" name="typeOfFile" value="Terrorist">
							<input type="file" name="xmlfile" id="xmlfile" required>
    					</div>
    					
    					<div class="block-footer block-footer-default">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                    	data-style="expand-right">{{ __('Load') }}</button>
                                </div>
                            	@if (isset($data['TerroristLoaded']))
                            		@php
                            		$action = $data['TerroristLoaded'];
                            		@endphp
                                	<div>
                                    	<span class="text-muted text-small">{{ __('Last update') }}: </span>
                                    	@include('helpers.viewDate', ['value' => $action->date, 'format' => 'd M Y H:i'])
                                	</div>
                                	<div>
                                    	<span class="text-muted text-small">{{ __('User') }}: </span>
                                    	{{ $action->user->display_name }}
                                    </div>
                                @endif
                        </div>
    					
					</form>
				</div>
	        
	        </div>
	    </div>
	</div>
    
@endsection
