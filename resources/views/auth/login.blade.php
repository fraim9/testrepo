@extends('layouts.simple')

@section('content')

	<!-- Hero -->
        <div class="hero bg-white overflow-hidden">
            <div class="hero-inner">
                <div class="content content-full text-center">
                    
					<div class="container invisible" data-toggle="appear" data-class="animated fadeInDown">
					    <div class="row justify-content-center">
					        <div class="col-sm-12 col-md-9 col-lg-7 col-xl-6">
					            <div class="card">
					                
					                <div class="form-group row mb-5">
			                            <div class="col-sm-7 offset-sm-3">
			                                <img src="{{ asset('media/logo.png') }}">
			                            </div>
			                        </div>
									
									
					                <div class="card-body">
					                    <form method="POST" action="{{ route('login') }}">
					                        @csrf
					
					                        <div class="form-group row">
					                            <label for="email" class="col-sm-4 col-form-label text-sm-right">{{ __('E-Mail Address') }}</label>
					
					                            <div class="col-sm-6">
					                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
					
					                                @if ($errors->has('email'))
					                                    <span class="invalid-feedback" role="alert">
					                                        <strong>{{ $errors->first('email') }}</strong>
					                                    </span>
					                                @endif
					                            </div>
					                        </div>
					
					                        <div class="form-group row">
					                            <label for="password" class="col-sm-4 col-form-label text-sm-right">{{ __('Password') }}</label>
					
					                            <div class="col-sm-6">
					                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
					
					                                @if ($errors->has('password'))
					                                    <span class="invalid-feedback" role="alert">
					                                        <strong>{{ $errors->first('password') }}</strong>
					                                    </span>
					                                @endif
					                            </div>
					                        </div>
					
					                        <div class="form-group row">
					                            <div class="col-sm-6 offset-sm-4  text-left">
					                                <div class="form-check">
					                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
					
					                                    <label class="form-check-label" for="remember">
					                                        {{ __('Remember Me') }}
					                                    </label>
					                                </div>
					                            </div>
					                        </div>
					
					                        <div class="form-group row mb-0">
					                            <div class="col-sm-6 offset-sm-4 text-left">
					                                <button type="submit" class="btn btn-primary btn-block btn-lg">
					                                    {{ __('Login') }}
					                                </button>
					
					                                @if (false && Route::has('password.request'))
					                                    <a class="btn btn-link" href="{{ route('password.request') }}">
					                                        {{ __('Forgot Your Password?') }}
					                                    </a>
					                                @endif
					                            </div>
					                        </div>
					                    </form>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>


                </div>
            </div>
        </div>
    <!-- END Hero -->
@endsection
