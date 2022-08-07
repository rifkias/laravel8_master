@extends('layouts.auth')
@section('main')
<div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-5 navbar-light">
    <a href="/dashboard" class="navbar-brand flex-column mb-2 align-items-center mr-0" style="min-width: 0">
        <img class="navbar-brand-icon mr-0 mb-2" src="{{asset('template/images/stack-logo-blue.svg')}}" width="25" alt="Stack">
        <span>Stack</span>
    </a>
    <p class="m-0">Create an account with Stack</p>
</div>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label class="text-label" for="name">{{ __('Name') }}:</label>
        <div class="input-group input-group-merge">
            <input id="name" type="name" name="name" required="" class="form-control form-control-prepended @error('name') is-invalid @enderror" placeholder="Example" value="{{old('name')}}">

            @error('name')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span class="far fa-user"></span>
                </div>
            </div>
        </div>
    </div>
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
        <label class="text-label" for="password_confirm">{{ __('Confirm Password') }}:</label>
        <div class="input-group input-group-merge">
            <input id="password_confirm" name="password_confirmation" type="password" required="" class="form-control form-control-prepended @error('password_confirmation') is-invalid @enderror" placeholder="Enter your password">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span class="fa fa-key"></span>
                </div>
            </div>

            @error('password_confirmation')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group mb-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" checked="" required class="custom-control-input" id="terms">
            <label class="custom-control-label" for="terms">I accept <a href="#">Terms and Conditions</a></label>
        </div>
    </div>
    <div class="form-group text-center">
        <button class="btn btn-primary mb-2" type="submit">Create Account</button><br>
        <a class="text-body text-underline" href="{{route('login')}}">Have an account? Login</a>
    </div>
</form>
@endsection
