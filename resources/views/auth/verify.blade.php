@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-5 pl-md-0">
            
        </div>
        <div class="col-md-7 mt-5 pl-md-0">
            <div class="auth-form-wrapper px-4 py-5">
                <img src="{{  asset('images/logo.png')}}" alt="" width="100" height="100" style="
                margin-left: 15rem">
            <div class="card text-center px-5 py-3">
                <h4 class="card-header text-center">{{ __('Verify Your Email Address') }}</h4>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3">{{ __('click here to request another') }}</button>
                    </form>
                </div>
            </div>
        </div>
           
        </div>
    </div>
</div>
@endsection
