{{-- resources/views/admin/edit-member.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Member - NMSG')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="h4 mb-1">Edit Member</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.members') }}">Manage Members</a></li>
                    <li class="breadcrumb-item active">Edit Member</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.members') }}" class="btn btn-outline-dark-green">
                <i class="bi bi-arrow-left me-2"></i>Back to Members
            </a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Member Information Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-dark-green text-beige py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2"></i>Edit Member Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" id="editMemberForm">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                    <i class="bi bi-person-vcard me-2"></i>Personal Information
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $member->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                       id="username" name="username" value="{{ old('username', $member->username) }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $member->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                    <i class="bi bi-wallet2 me-2"></i>Account Information
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="account_balance" class="form-label fw-semibold">Account Balance (UGX) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">UGX</span>
                                    <input type="number" class="form-control @error('account_balance') is-invalid @enderror" 
                                           id="account_balance" name="account_balance" 
                                           value="{{ old('account_balance', $member->account_balance) }}" 
                                           step="0.01" min="0" required>
                                </div>
                                @error('account_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Current account balance in UGX</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Member Status</label>
                                <div class="d-flex align-items-center">
                                    @if($member->account_balance > 0)
                                        <span class="badge bg-success me-2">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary me-2">
                                            <i class="bi bi-clock me-1"></i>Inactive
                                        </span>
                                    @endif
                                    <small class="text-muted">Based on account balance</small>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Member Since</label>
                                <p class="mb-0 text-muted">
                                    {{ $member->created_at->format('F d, Y') }} 
                                    <small class="text-muted">({{ $member->created_at->diffForHumans() }})</small>
                                </p>
                            </div>
                        </div>

                        <!-- Next of Kin Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                    <i class="bi bi-person-heart me-2"></i>Next of Kin Information
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('next_of_kin_name') is-invalid @enderror" 
                                       id="next_of_kin_name" name="next_of_kin_name" 
                                       value="{{ old('next_of_kin_name', $member->next_of_kin_name) }}" required>
                                @error('next_of_kin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_relationship" class="form-label fw-semibold">Relationship <span class="text-danger">*</span></label>
                                <select class="form-select @error('next_of_kin_relationship') is-invalid @enderror" 
                                        id="next_of_kin_relationship" name="next_of_kin_relationship" required>
                                    <option value="">Select Relationship</option>
                                    <option value="Spouse" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Parent" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Parent' ? 'selected' : '' }}>Parent</option>
                                    <option value="Child" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Child' ? 'selected' : '' }}>Child</option>
                                    <option value="Sibling" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="Relative" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Relative' ? 'selected' : '' }}>Relative</option>
                                    <option value="Friend" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Friend' ? 'selected' : '' }}>Friend</option>
                                    <option value="Other" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('next_of_kin_relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="next_of_kin_phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('next_of_kin_phone') is-invalid @enderror" 
                                       id="next_of_kin_phone" name="next_of_kin_phone" 
                                       value="{{ old('next_of_kin_phone', $member->next_of_kin_phone) }}" required>
                                @error('next_of_kin_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('admin.members') }}" class="btn btn-outline-secondary me-2">
                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                        </a>
                                        <button type="reset" class="btn btn-outline-warning me-2">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-dark-green">
                                            <i class="bi bi-check-circle me-2"></i>Update Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Member Statistics Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-graph-up me-2"></i>Member Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="stat-item p-3 rounded bg-primary bg-opacity-10">
                                <i class="bi bi-arrow-down-circle fs-2 text-primary mb-2"></i>
                                <h4 class="fw-bold text-primary">{{ $member->deposits()->where('status', 'completed')->count() }}</h4>
                                <small class="text-muted">Total Deposits</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-item p-3 rounded bg-warning bg-opacity-10">
                                <i class="bi bi-arrow-up-circle fs-2 text-warning mb-2"></i>
                                <h4 class="fw-bold text-warning">{{ $member->withdrawals()->where('status', 'completed')->count() }}</h4>
                                <small class="text-muted">Total Withdrawals</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-item p-3 rounded bg-info bg-opacity-10">
                                <i class="bi bi-clock-history fs-2 text-info mb-2"></i>
                                <h4 class="fw-bold text-info">{{ $member->transactions()->where('status', 'pending')->count() }}</h4>
                                <small class="text-muted">Pending Requests</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Recent Activity</h6>
                        @php
                            $recentTransactions = $member->transactions()->latest()->take(3)->get();
                        @endphp
                        
                        @if($recentTransactions->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentTransactions as $transaction)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge {{ $transaction->type == 'deposit' ? 'bg-success' : 'bg-warning' }} me-2">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                            <small>UGX {{ number_format($transaction->amount, 2) }}</small>
                                        </div>
                                        <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">No recent activity</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h6 class="alert-heading">Warning!</h6>
                    <p class="mb-0">You are about to delete member <strong>{{ $member->name }}</strong>. This action cannot be undone and will permanently remove all member data including transaction history.</p>
                </div>
                <div class="mb-3">
                    <label for="confirmDelete" class="form-label">Type "DELETE" to confirm:</label>
                    <input type="text" class="form-control" id="confirmDelete" placeholder="Type DELETE here">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                        <i class="bi bi-trash me-2"></i>Delete Member
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const confirmDelete = document.getElementById('confirmDelete');
    const deleteButton = document.getElementById('deleteButton');
    
    if (confirmDelete && deleteButton) {
        confirmDelete.addEventListener('input', function() {
            deleteButton.disabled = this.value !== 'DELETE';
        });
    }

    // Form validation
    const form = document.getElementById('editMemberForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                showToast('Please fill in all required fields.', 'error');
            }
        });
    }

    // Real-time validation
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Account balance formatting
    const balanceInput = document.getElementById('account_balance');
    if (balanceInput) {
        balanceInput.addEventListener('input', function() {
            // Format as user types (optional)
            const value = this.value.replace(/[^\d.]/g, '');
            this.value = value;
        });
    }
});

function showToast(message, type = 'info') {
    // Simple toast implementation
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 1060; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 's':
                e.preventDefault();
                document.querySelector('button[type="submit"]').click();
                break;
        }
    }
    
    if (e.key === 'Escape') {
        window.location.href = "{{ route('admin.members') }}";
    }
});
</script>

<style>
.stat-item {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

/* Custom focus styles */
.form-control:focus {
    border-color: #1a472a;
    box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
}

.form-select:focus {
    border-color: #1a472a;
    box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body.p-4 {
        padding: 1.5rem !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection