@extends('layouts.app')
@section('content')
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="">

                                </div>
                            </div>
                            <div class="col-md-10 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <img src="{{URL::asset('/images/logo.png')}}" alt="" height="90" width="90" style="
                                    margin: 0 auto;
    display: block;
                                ">
                                    <form class="forms-sample" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email" placeholder="Enter Your Email" value="{{ old('email') }}" required autocomplete="email"
                                                   autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" placeholder="Enter Your Password" required autocomplete="current-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                       
                                        <div class="mt-3">
                                            <button type="submit"
                                               class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">  {{ __('Login') }}</button>
                                                
                                        </a>
                                        </div>
                                        <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
