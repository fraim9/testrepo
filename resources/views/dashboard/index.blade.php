@extends('layouts.backend')

@section('content')
    
    @include('layouts.backendPageHero', [
    	'title' => 'Dashboard',
    	'btns' => []
    ])

    <!-- Page Content -->
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-5">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">Welcome to OmniPOS</h3>
                    </div>
                    <div class="block-content">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
