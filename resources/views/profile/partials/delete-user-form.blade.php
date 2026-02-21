<div class="card border-0 shadow-sm mb-4 border-danger">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
        </h5>
        <small class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted.</small>
    </div>
    <div class="card-body">
        <p class="text-muted mb-3">
            Before deleting your account, please download any data or information that you wish to retain.
        </p>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="bi bi-trash me-1"></i>Delete Account
        </button>

        <!-- Delete Account Modal -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold" id="deleteAccountModalLabel">
                                <i class="bi bi-exclamation-triangle text-danger me-2"></i>Are you sure?
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted">
                                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                            </p>
                            <div class="mb-3">
                                <label for="delete_password" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif" id="delete_password" name="password" placeholder="Enter your password">
                                @if($errors->userDeletion->has('password'))
                                    <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        modal.show();
    });
</script>
@endif
