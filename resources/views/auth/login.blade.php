@extends('layouts.app')

@section('content')
<div class="container">
    <br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-offset-5 col-md-4">
            <a href="{{ url('/login') }}">
                <div style="height:20px;width:350px;margin-bottom:110px"><img
                        src="{{asset('assets/images/diu_bus_logo.png')}}" style="width: 125%;margin-top: -30px;" alt="">
                </div> {{--{{ config('app.name', 'Laravel') }}--}}
            </a><br>

        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include("layouts.includes.flash")
            <div class="card shadow-lg ">
                <div class="card-header"
                    style="background:linear-gradient(90deg, rgba(2,177,58,1) 14%, rgb(10, 172, 43) 65%);;color: white;font-weight: bold;;font-size:18px">
                    System Login Portal
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="email" type="eamil" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Email Address">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="User Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-md btn-success">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
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
@endsection
