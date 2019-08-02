@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'License Info',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="content">
        
        		
		<div class="row">
            <div class="col-sm-4">
                <div class="block js-appear-enabled animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-rounded bg-smooth-light text-white mx-auto">
                                <i class="fa fa-2x fa-users"></i>
                            </div>
                            <div class="font-size-h4 font-w600 pt-3 mb-0">Users {{ $info->active->users }}/{{ $info->license->users }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block js-appear-enabled animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-rounded bg-modern-light text-white mx-auto">
                                <i class="fa fa-tablet-alt fa-2x"></i>
                            </div>
                            <div class="font-size-h4 font-w600 pt-3 mb-0">Devices {{ $info->active->devices }}/{{ $info->license->devices }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block js-appear-enabled animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-rounded bg-flat-light text-white mx-auto">
                                <i class="fa fa-store-alt fa-2x"></i>
                            </div>
                            <div class="font-size-h4 font-w600 pt-3 mb-0">Stores {{ $info->active->stores }}/{{ $info->license->stores }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        	
        	
    </div>
    <!-- END Page Content -->
@endsection