@extends('layouts.auth')
@section('main')
<div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-5 navbar-light">
    <a href="/dashboard" class="navbar-brand flex-column mb-2 align-items-center mr-0" style="min-width: 0">
        <img class="navbar-brand-icon mr-0 mb-2" src="{{asset('template/images/stack-logo-blue.svg')}}" width="25" alt="Stack">
        <span>Stack</span>
    </a>
    <p class="m-0">Login to access your Stack Account </p>
</div>
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="text-label" for="email">Email Address:</label>
        <div class="input-group input-group-merge">
            <input id="email" type="email" name="email" required="" class="form-control form-control-prepended @error('email') is-invalid @enderror" placeholder="example@email.com" value="{{old('email')}}">

            @error('email')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span class="far fa-envelope"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="text-label" for="password_2">Password:</label>
        <div class="input-group input-group-merge">
            <input id="password_2" name="password" type="password" required="" class="form-control form-control-prepended @error('password') is-invalid @enderror" placeholder="Enter your password">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span class="fa fa-key"></span>
                </div>
            </div>

            @error('password')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-block btn-primary" type="submit">Login</button>
    </div>
    <div class="form-group text-center">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember" checked="" id="remember">
            <label class="custom-control-label" for="remember">Remember me</label>
        </div>
    </div>
    <div class="form-group text-center">
        <a href="{{ route('password.request') }}">Forgot password?</a> <br>
        Don't have an account? <a class="text-body text-underline" href="{{ route('register') }}">Sign up!</a>
    </div>
</form>
@endsection
