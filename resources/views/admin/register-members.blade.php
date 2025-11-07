@extends('layouts.app')

@section('title', 'Register Member - NMSG')

@section('header')
    Register New Member
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-dark-green text-beige">
                    <h6 class="m-0 font-weight-bold">
                        <i class="bi bi-person-plus me-2"></i>Member Registration Form
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.members.store') }}">
                        @csrf

                        <!-- Hidden role field set to member -->
                        <input type="hidden" name="role" value="member">

                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-dark-green mb-3">
                                    <i class="bi bi-person-vcard me-2"></i>Personal Information
                                </h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                       id="username" name="username" value="{{ old('username') }}" required autocomplete="username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-dark-green mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>Contact Information
                                </h5>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Physical Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City/Town</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', 'Uganda') }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-dark-green mb-3">
                                    <i class="bi bi-wallet2 me-2"></i>Account Information
                                </h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="member_id" class="form-label">Member ID *</label>
                                <input type="text" class="form-control @error('member_id') is-invalid @enderror" 
                                       id="member_id" name="member_id" value="{{ old('member_id') }}" required>
                                <small class="form-text text-muted">Unique identifier for the member</small>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                       id="occupation" name="occupation" value="{{ old('occupation') }}">
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="employment_status" class="form-label">Employment Status</label>
                                <select class="form-control @error('employment_status') is-invalid @enderror" 
                                        id="employment_status" name="employment_status">
                                    <option value="">Select Status</option>
                                    <option value="employed" {{ old('employment_status') == 'employed' ? 'selected' : '' }}>Employed</option>
                                    <option value="self-employed" {{ old('employment_status') == 'self-employed' ? 'selected' : '' }}>Self-Employed</option>
                                    <option value="student" {{ old('employment_status') == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="unemployed" {{ old('employment_status') == 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                                    <option value="retired" {{ old('employment_status') == 'retired' ? 'selected' : '' }}>Retired</option>
                                </select>
                                @error('employment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="monthly_income" class="form-label">Monthly Income (UGX)</label>
                                <input type="number" class="form-control @error('monthly_income') is-invalid @enderror" 
                                       id="monthly_income" name="monthly_income" value="{{ old('monthly_income') }}" 
                                       min="0" step="1000">
                                @error('monthly_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Next of Kin Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-dark-green mb-3">
                                    <i class="bi bi-people me-2"></i>Next of Kin Information
                                </h5>
                                <small class="text-muted">Please provide details of next of kin for emergency contact.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_name" class="form-label">Next of Kin Full Name *</label>
                                <input type="text" class="form-control @error('next_of_kin_name') is-invalid @enderror" 
                                       id="next_of_kin_name" name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" required>
                                @error('next_of_kin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_relationship" class="form-label">Relationship *</label>
                                <select class="form-control @error('next_of_kin_relationship') is-invalid @enderror" 
                                        id="next_of_kin_relationship" name="next_of_kin_relationship" required>
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
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_phone" class="form-label">Next of Kin Phone *</label>
                                <input type="tel" class="form-control @error('next_of_kin_phone') is-invalid @enderror" 
                                       id="next_of_kin_phone" name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" required>
                                @error('next_of_kin_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Security -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-dark-green mb-3">
                                    <i class="bi bi-shield-lock me-2"></i>Account Security
                                </h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required autocomplete="new-password">
                                <small class="form-text text-muted">Minimum 8 characters with letters and numbers</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-dark-green btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>Register Member
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate member ID if field is empty
    const memberIdField = document.getElementById('member_id');
    if (memberIdField && !memberIdField.value) {
        const timestamp = new Date().getTime().toString().slice(-6);
        const random = Math.random().toString(36).substring(2, 5).toUpperCase();
        memberIdField.value = `MEM${timestamp}${random}`;
    }

    // Auto-generate username from email
    const emailField = document.getElementById('email');
    const usernameField = document.getElementById('username');
    
    if (emailField && usernameField && !usernameField.value) {
        emailField.addEventListener('blur', function() {
            if (!usernameField.value && this.value) {
                const username = this.value.split('@')[0];
                usernameField.value = username.toLowerCase().replace(/[^a-z0-9]/g, '');
            }
        });
    }

    // Format phone numbers
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '256' + value.substring(1);
            }
            e.target.value = value;
        });
    });

    // Password strength indicator
    const passwordField = document.getElementById('password');
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            const password = this.value;
            const strengthText = document.getElementById('password-strength') || 
                                document.createElement('small');
            
            if (!document.getElementById('password-strength')) {
                strengthText.id = 'password-strength';
                strengthText.className = 'form-text';
                this.parentNode.appendChild(strengthText);
            }

            let strength = 'Weak';
            let color = 'text-danger';
            
            if (password.length >= 8 && /[a-zA-Z]/.test(password) && /[0-9]/.test(password)) {
                strength = 'Strong';
                color = 'text-success';
            } else if (password.length >= 6) {
                strength = 'Medium';
                color = 'text-warning';
            }

            strengthText.textContent = `Password strength: ${strength}`;
            strengthText.className = `form-text ${color}`;
        });
    }
});
</script>
@endsection