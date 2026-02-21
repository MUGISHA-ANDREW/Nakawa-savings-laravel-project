<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-shield-lock me-2 text-dark-green"></i>Update Password
        </h5>
        <small class="text-muted">Ensure your account is using a long, random password to stay secure.</small>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label fw-semibold">Current Password</label>
                <input type="password" class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif" id="update_password_current_password" name="current_password" autocomplete="current-password">
                @if($errors->updatePassword->has('current_password'))
                    <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label fw-semibold">New Password</label>
                <input type="password" class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif" id="update_password_password" name="password" autocomplete="new-password">
                @if($errors->updatePassword->has('password'))
                    <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                @if($errors->updatePassword->has('password_confirmation'))
                    <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-dark-green">
                    <i class="bi bi-check-lg me-1"></i>Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success small fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>Password updated!
                    </span>
                @endif
            </div>
        </form>
    </div>
</div>
