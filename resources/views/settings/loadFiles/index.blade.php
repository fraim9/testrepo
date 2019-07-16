@extends('layouts.backend')

@section('content')

	@include('layouts.backendPageHero', [
    	'title' => 'Load data from files',
    	'btns' => []
    ])
    
    <div class="content content-full">
    	<div class="container">
    	    <div class="row justify-content-center">
    	        <div class="col-md-8">
    	        
    	        	<div class="block">
    					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
    						@csrf
        	        		<div class="block-header block-header-default">
        	        			<h3 class="block-title">{{ __('Person mass destruction (List_Weapons.xml)') }}</h3>
        	        		</div>
        					<div class="block-content">
    							
    							<div class="row">
    								<div class="col-md-4">
    									{{ __('Select a file') }}
    								</div>
    								<div class="col-md-6">
    									<input type="hidden" name="typeOfFile" value="PersonMassDestruction">
    									<input type="file" name="xmlfile" id="xmlfile">
    								</div>
    							</div>
    							
    							
    							<br><br>		
        					</div>
        					
        					<div class="block-footer block-footer-default">
                            	<div class="row">
                                    <div class="col-md-3 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                        	data-style="expand-right">{{ __('Load') }}</button>
                                    </div>
                                    <div class="col-md-5 text-right">
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
                                </div>
                            </div>
        					
    					</form>
    				</div>
    	        
    	        	<div class="block">
    					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
    						@csrf
        	        		<div class="block-header block-header-default">
        	        			<h3 class="block-title">{{ __('Person blocked (List_Accounts_block.xml)') }}</h3>
        	        		</div>
        					<div class="block-content">
    							
    							<div class="row">
    								<div class="col-md-4">
    									{{ __('Select a file') }}
    								</div>
    								<div class="col-md-6">
    									<input type="hidden" name="typeOfFile" value="PersonBlocked">
    									<input type="file" name="xmlfile" id="xmlfile">
    								</div>
    							</div>
    							
    							
    							<br><br>		
        					</div>
        					
        					<div class="block-footer block-footer-default">
                            	<div class="row">
                                    <div class="col-md-3 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                        	data-style="expand-right">{{ __('Load') }}</button>
                                    </div>
                                    <div class="col-md-5 text-right">
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
                                </div>
                            </div>
        					
    					</form>
    				</div>
    	        
    	        	<div class="block">
    					<form method="post" action="{{ route('loadFiles.store') }}" enctype="multipart/form-data">
    						@csrf
        	        		<div class="block-header block-header-default">
        	        			<h3 class="block-title">{{ __('Terrorist (terrorist.xml)') }}</h3>
        	        		</div>
        					<div class="block-content">
    							
    							<div class="row">
    								<div class="col-md-4">
    									{{ __('Select a file') }}
    								</div>
    								<div class="col-md-6">
    									<input type="hidden" name="typeOfFile" value="Terrorist">
    									<input type="file" name="xmlfile" id="xmlfile">
    								</div>
    							</div>
    							
    							
    							<br><br>		
        					</div>
        					
        					<div class="block-footer block-footer-default">
                            	<div class="row">
                                    <div class="col-md-3 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-lg ladda-button" 
                                        	data-style="expand-right">{{ __('Load') }}</button>
                                    </div>
                                    <div class="col-md-5 text-right">
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
                            </div>
        					
    					</form>
    				</div>
    	        
    	        </div>
    	    </div>
    	</div>
    </div>
    
@endsection
