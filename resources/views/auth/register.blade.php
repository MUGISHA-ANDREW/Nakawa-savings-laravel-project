@extends('layouts.app')

@section('title', 'Register - Nakawa Market Savings Group')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark-green text-beige">
                    <h4 class="mb-0">{{ __('Register for NMSG') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Personal Information -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="username" class="form-label">{{ __('Username') }} <span class="text-danger">*</span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                                       name="username" value="{{ old('username') }}" required autocomplete="username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Role (default to member) -->
                        <input type="hidden" name="role" value="member">

                        <!-- Next of Kin Information -->
                        <div class="border-top pt-3 mb-3">
                            <h6 class="text-dark-green">{{ __('Next of Kin Information') }}</h6>
                            <small class="text-muted">Please provide details of your next of kin for emergency contact.</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="next_of_kin_name" class="form-label">{{ __('Next of Kin Full Name') }} <span class="text-danger">*</span></label>
                                <input id="next_of_kin_name" type="text" class="form-control @error('next_of_kin_name') is-invalid @enderror" 
                                       name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" required>
                                @error('next_of_kin_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="next_of_kin_relationship" class="form-label">{{ __('Relationship') }} <span class="text-danger">*</span></label>
                                <select id="next_of_kin_relationship" class="form-control @error('next_of_kin_relationship') is-invalid @enderror" 
                                        name="next_of_kin_relationship" required>
                                    <option value="">Select Relationship</option>
                                    <option value="Spouse" {{ old('next_of_kin_relationship') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Parent" {{ old('next_of_kin_relationship') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                    <option value="Child" {{ old('next_of_kin_relationship') == 'Child' ? 'selected' : '' }}>Child</option>
                                    <option value="Sibling" {{ old('next_of_kin_relationship') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="Relative" {{ old('next_of_kin_relationship') == 'Relative' ? 'selected' : '' }}>Relative</option>
                                    <option value="Friend" {{ old('next_of_kin_relationship') == 'Friend' ? 'selected' : '' }}>Friend</option>
                                    <option value="Other" {{ old('next_of_kin_relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('next_of_kin_relationship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="next_of_kin_phone" class="form-label">{{ __('Next of Kin Phone') }} <span class="text-danger">*</span></label>
                                <input id="next_of_kin_phone" type="tel" class="form-control @error('next_of_kin_phone') is-invalid @enderror" 
                                       name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" required>
                                @error('next_of_kin_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark-green btn-lg w-100 text-beige">
                                    {{ __('Create Account') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <p class="mb-0">
                                    {{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}" class="text-dark-green">{{ __('Login here') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Registration Info -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="text-dark-green">About Nakawa Market Savings Group</h6>
                    <p class="mb-2"><small><i class="bi bi-check-circle text-success me-2"></i>Secure savings with interest on deposits</small></p>
                    <p class="mb-2"><small><i class="bi bi-check-circle text-success me-2"></i>Role-based access control for security</small></p>
                    <p class="mb-2"><small><i class="bi bi-check-circle text-success me-2"></i>Transparent account management</small></p>
                    <p class="mb-0"><small><i class="bi bi-check-circle text-success me-2"></i>Community-focused financial growth</small></p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection