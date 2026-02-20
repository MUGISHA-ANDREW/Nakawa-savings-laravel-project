@extends('layouts.app')

@section('title', 'Reset Password - Nakawa Market Savings Group')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark-green text-beige">
                    <h4 class="mb-0">{{ __('Reset Password') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }} <span class="text-danger">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark-green btn-lg w-100 text-beige">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>

                        <!-- Back to Login -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <p class="mb-0">
                                    <a href="{{ route('login') }}" class="text-dark-green">{{ __('Back to Login') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
