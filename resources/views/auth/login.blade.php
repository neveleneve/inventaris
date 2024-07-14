@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="fw-bold text-center mb-3">Login</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-lg-4 col-form-label text-lg-end fw-bold">{{ __('Email Address') }}</label>

                                <div class="col-lg-6">
                                    <input id="email" type="email"
                                        class="form-control rounded-5 @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-lg-4 col-form-label text-lg-end fw-bold">{{ __('Password') }}</label>

                                <div class="col-lg-6">
                                    <input id="password" type="password"
                                        class="form-control rounded-5 @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6 offset-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-lg-6 offset-lg-4 d-grid gap-2">
                                    <button type="submit" class="btn btn-outline-primary fw-bold rounded-5">
                                        {{ __('Login') }}
                                    </button>

                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="row mb-0">
                                    <div class="col-lg-8 offset-lg-4">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
