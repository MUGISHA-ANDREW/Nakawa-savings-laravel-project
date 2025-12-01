@extends('layouts.app')

@section('title', 'Login - Nakawa Market Savings Group')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark-green text-beige">
                    <h4 class="mb-0">{{ __('Login to NMSG') }}</h4>
                </div>

                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
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

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                @if (Route::has('password.request'))
                                    <a class="text-dark-green" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark-green btn-lg w-100 text-beige">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <p class="mb-0">
                                    {{ __("Don't have an account?") }}
                                    <a href="{{ route('register') }}" class="text-dark-green">{{ __('Register here') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Login Info -->
            {{-- <div class="card mt-4">
                <div class="card-body">
                    <h6 class="text-dark-green">Secure Login Information</h6>
                    <p class="mb-2"><small><i class="bi bi-shield-check text-success me-2"></i>Your login credentials are encrypted and secure</small></p>
                    <p class="mb-2"><small><i class="bi bi-clock-history text-success me-2"></i>Remember me keeps you logged in for 30 days</small></p>
                    <p class="mb-2"><small><i class="bi bi-key text-success me-2"></i>Use strong passwords for account security</small></p>
                    <p class="mb-0"><small><i class="bi bi-person-check text-success me-2"></i>Contact administrators for account assistance</small></p>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alert after 5 seconds
    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    }
});
</script>
@endsection