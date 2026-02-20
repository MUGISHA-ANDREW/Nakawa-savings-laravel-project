@extends('layouts.app')

@section('title', 'Confirm Password - Nakawa Market Savings Group')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark-green text-beige">
                    <h4 class="mb-0">{{ __('Confirm Password') }}</h4>
                </div>

                <div class="card-body">
                    <p class="mb-3 text-muted">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

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

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark-green btn-lg w-100 text-beige">
                                    {{ __('Confirm') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
