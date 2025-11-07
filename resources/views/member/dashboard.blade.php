@extends('layouts.app')

@section('title', 'Member Dashboard - NMSG')

@section('header')
    <div class="d-flex justify-content-between align-items-center py-3">
        <div>
            <h2 class="h4 mb-1 fw-bold">Member Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Manage your savings journey.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('transactions') }}" class="btn btn-outline-dark-green">
                <i class="bi bi-clock-history me-2"></i>View Transactions
            </a>
            <button class="btn btn-dark-green" onclick="refreshDashboard()">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Account Balance</h6>
                            <h2 class="fw-bold text-success mb-1">UGX {{ number_format(auth()->user()->account_balance, 2) }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success me-2">
                                    <i class="bi bi-wallet2 me-1"></i>Available
                                </span>
                                <small class="text-muted">Includes deposits + interest</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-wallet2 text-success fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>Your total savings balance with 1.5% interest
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Total Deposits</h6>
                            <h2 class="fw-bold text-primary mb-1">UGX {{ number_format($stats['total_deposits'] ?? 0, 2) }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                    <i class="bi bi-arrow-up me-1"></i>{{ $stats['total_deposits_count'] ?? 0 }} deposits
                                </span>
                                <small class="text-muted">Principal amount only</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-arrow-down-circle text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <small class="text-muted">
                        <i class="bi bi-cash-stack me-1"></i>Total principal deposited (excluding interest)
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Section -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Make a Deposit Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-dark-green text-beige py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Make a Deposit
                        </h5>
                        <span class="badge bg-beige text-dark-green">+1.5% Interest</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <form action="{{ route('deposit') }}" method="POST" id="depositForm">
                                @csrf
                                <div class="mb-4">
                                    <label for="deposit_amount" class="form-label fw-semibold">Deposit Amount (UGX) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light">UGX</span>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                               id="deposit_amount" name="amount" 
                                               min="1000" step="1000" 
                                               placeholder="Enter amount" required>
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Minimum deposit: UGX 1,000</div>
                                </div>

                                <!-- Deposit Preview -->
                                <div class="deposit-preview mb-4 p-3 rounded bg-light" id="depositPreview" style="display: none;">
                                    <h6 class="fw-semibold mb-2">Deposit Preview</h6>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Principal Amount</small>
                                            <span class="fw-bold text-primary" id="previewPrincipal">UGX 0</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">+1.5% Interest</small>
                                            <span class="fw-bold text-success" id="previewInterest">UGX 0</span>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2 pt-2 border-top">
                                        <small class="text-muted d-block">Total added to balance</small>
                                        <span class="fw-bold text-dark" id="previewTotal">UGX 0</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark-green btn-lg w-100">
                                    <i class="bi bi-check-circle me-2"></i>Confirm Deposit
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <div class="deposit-benefits">
                                <h6 class="fw-semibold mb-3 text-center">Why Save With Us?</h6>
                                <div class="benefit-item d-flex align-items-center mb-3">
                                    <div class="benefit-icon bg-success bg-opacity-10 text-success rounded-circle me-3">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">Secure Savings</span>
                                        <small class="text-muted d-block">Your money is safe with us</small>
                                    </div>
                                </div>
                                <div class="benefit-item d-flex align-items-center mb-3">
                                    <div class="benefit-icon bg-primary bg-opacity-10 text-primary rounded-circle me-3">
                                        <i class="bi bi-percent"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">1.5% Interest</span>
                                        <small class="text-muted d-block">Bonus on every deposit</small>
                                    </div>
                                </div>
                                <div class="benefit-item d-flex align-items-center mb-3">
                                    <div class="benefit-icon bg-warning bg-opacity-10 text-warning rounded-circle me-3">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">Instant Processing</span>
                                        <small class="text-muted d-block">Deposits added immediately</small>
                                    </div>
                                </div>
                                <div class="benefit-item d-flex align-items-center">
                                    <div class="benefit-icon bg-info bg-opacity-10 text-info rounded-circle me-3">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">Transparent Tracking</span>
                                        <small class="text-muted d-block">Monitor your progress</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Deposit Amounts -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="bi bi-lightning me-2"></i>Quick Deposit Amounts
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6 col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 quick-amount" data-amount="5000">
                                UGX 5,000
                            </button>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 quick-amount" data-amount="10000">
                                UGX 10,000
                            </button>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 quick-amount" data-amount="25000">
                                UGX 25,000
                            </button>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 quick-amount" data-amount="50000">
                                UGX 50,000
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Savings Progress -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up me-2 text-dark-green"></i>Savings Progress
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $currentBalance = auth()->user()->account_balance;
                        $savingsGoals = [
                            ['target' => 100000, 'label' => 'First UGX 100K'],
                            ['target' => 500000, 'label' => 'UGX 500K Milestone'],
                            ['target' => 1000000, 'label' => 'UGX 1M Club']
                        ];
                    @endphp
                    
                    @foreach($savingsGoals as $goal)
                        @php
                            $progress = min(100, ($currentBalance / $goal['target']) * 100);
                            $isCompleted = $currentBalance >= $goal['target'];
                        @endphp
                        <div class="goal-item mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold {{ $isCompleted ? 'text-success' : 'text-dark' }}">
                                    {{ $goal['label'] }}
                                </span>
                                <span class="text-muted small">UGX {{ number_format($goal['target']) }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" 
                                     style="width: {{ $progress }}%">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted">{{ number_format($progress, 1) }}%</small>
                                @if($isCompleted)
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>Achieved!
                                    </small>
                                @else
                                    <small class="text-muted">
                                        UGX {{ number_format($goal['target'] - $currentBalance) }} to go
                                    </small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2 text-dark-green"></i>Recent Activity
                        </h5>
                        <a href="{{ route('transactions') }}" class="btn btn-sm btn-outline-dark-green">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $recentTransactions = auth()->user()->transactions()->latest()->take(5)->get();
                    @endphp
                    
                    @if($recentTransactions->count() > 0)
                        <div class="activity-list">
                            @foreach($recentTransactions as $transaction)
                            <div class="activity-item d-flex align-items-center py-2 border-bottom">
                                <div class="activity-icon me-3">
                                    @if($transaction->type == 'deposit')
                                        <i class="bi bi-arrow-down-circle fs-5 text-success"></i>
                                    @else
                                        <i class="bi bi-arrow-up-circle fs-5 text-warning"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">
                                        {{ ucfirst($transaction->type) }}
                                        @if($transaction->type == 'deposit')
                                            <small class="text-success">(+1.5%)</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                        UGX {{ number_format($transaction->amount, 0) }}
                                    </div>
                                    <small class="badge {{ $transaction->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                            <p class="text-muted mt-3">No transactions yet</p>
                            <small class="text-muted">Make your first deposit to get started!</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick amount buttons
    const quickAmountButtons = document.querySelectorAll('.quick-amount');
    const depositAmountInput = document.getElementById('deposit_amount');
    const depositPreview = document.getElementById('depositPreview');
    
    quickAmountButtons.forEach(button => {
        button.addEventListener('click', function() {
            const amount = this.getAttribute('data-amount');
            depositAmountInput.value = amount;
            depositAmountInput.dispatchEvent(new Event('input'));
            
            // Highlight selected button
            quickAmountButtons.forEach(btn => btn.classList.remove('btn-primary', 'active'));
            this.classList.add('btn-primary', 'active');
        });
    });

    // Deposit preview with interest calculation (for display only)
    if (depositAmountInput) {
        depositAmountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const interestRate = 1.5; // 1.5% interest
            const interestAmount = (amount * interestRate) / 100;
            const totalAmount = amount + interestAmount;

            if (amount >= 1000) {
                document.getElementById('previewPrincipal').textContent = 'UGX ' + amount.toLocaleString();
                document.getElementById('previewInterest').textContent = 'UGX ' + interestAmount.toLocaleString();
                document.getElementById('previewTotal').textContent = 'UGX ' + totalAmount.toLocaleString();
                depositPreview.style.display = 'block';
            } else {
                depositPreview.style.display = 'none';
            }
        });
    }

    // Form validation
    const depositForm = document.getElementById('depositForm');
    if (depositForm) {
        depositForm.addEventListener('submit', function(e) {
            const amount = parseFloat(depositAmountInput.value) || 0;
            if (amount < 1000) {
                e.preventDefault();
                showNotification('Minimum deposit amount is UGX 1,000', 'error');
                depositAmountInput.focus();
            }
        });
    }

    
    animateCards();
});

function animateCards() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

function refreshDashboard() {
    const refreshBtn = document.querySelector('[onclick="refreshDashboard()"]');
    const originalHtml = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2 spin"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 1060; min-width: 300px;';
    notification.innerHTML = `
        <i class="bi ${type === 'error' ? 'bi-exclamation-triangle' : 'bi-info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}
</script>


@endsection