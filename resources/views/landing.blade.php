@extends('layouts.simple')

@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo36@2x.jpg') }}');">
        <div class="hero bg-white overflow-hidden">
            <div class="hero-inner">
                <div class="content content-full text-center">
                    <div class="mb-5 invisible" data-toggle="appear" data-class="animated fadeInDown">
                        <img src="{{ asset('media/logo.png') }}" class="logo-front-fp">
                    </div>
                    <span class="mt-4 d-inline-block invisible" data-toggle="appear" data-class="animated fadeInUp" data-timeout="600">
                        <a class="btn btn-primary px-4 py-2" href="/admin">
                            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Enter to Back Office
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection
