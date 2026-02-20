@extends('layouts.app')

@section('title', 'Forgot Password - Nakawa Market Savings Group')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark-green text-beige">
                    <h4 class="mb-0">{{ __('Forgot Password') }}</h4>
                </div>

                <div class="card-body">
                    <p class="mb-3 text-muted">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark-green btn-lg w-100 text-beige">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </div>

                        <!-- Back to Login -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <p class="mb-0">
                                    {{ __('Remember your password?') }}
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
