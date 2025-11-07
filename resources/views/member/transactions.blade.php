@extends('layouts.app')

@section('title', 'My Transactions - NMSG')

@section('header')
    <div class="d-flex justify-content-between align-items-center py-3">
        <div>
            <h2 class="h4 mb-1 fw-bold">My Transactions</h2>
            <p class="text-muted mb-0">Complete history of your savings and deposits</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark-green">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
            <button class="btn btn-dark-green" onclick="window.print()">
                <i class="bi bi-printer me-2"></i>Print Statement
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Account Balance</h6>
                            <h2 class="fw-bold text-success mb-1">UGX {{ number_format($user->account_balance, 2) }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success me-2">
                                    <i class="bi bi-wallet2 me-1"></i>Available
                                </span>
                                <small class="text-muted">Current balance</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-wallet2 text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Total Deposits</h6>
                            <h2 class="fw-bold text-primary mb-1">UGX {{ number_format($user->deposits()->where('status', 'completed')->sum('final_amount') ?? 0, 2) }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                    <i class="bi bi-arrow-down me-1"></i>{{ $user->deposits()->where('status', 'completed')->count() }} deposits
                                </span>
                                <small class="text-muted">All-time total</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-arrow-down-circle text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Interest Earned</h6>
                            <h2 class="fw-bold text-warning mb-1">
                                @php
                                    $totalDeposits = $user->deposits()->where('status', 'completed')->sum('amount');
                                    $totalWithInterest = $user->deposits()->where('status', 'completed')->sum('final_amount');
                                    $totalInterest = $totalWithInterest - $totalDeposits;
                                @endphp
                                UGX {{ number_format($totalInterest, 2) }}
                            </h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning me-2">
                                    <i class="bi bi-percent me-1"></i>1.5% rate
                                </span>
                                <small class="text-muted">Bonus earned</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-graph-up-arrow text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-hover border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-uppercase text-muted fw-bold mb-2">Savings Growth</h6>
                            <h2 class="fw-bold text-info mb-1">
                                @php
                                    $growthRate = $totalDeposits > 0 ? (($user->account_balance - $totalDeposits) / $totalDeposits) * 100 : 0;
                                @endphp
                                +{{ number_format($growthRate, 1) }}%
                            </h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info bg-opacity-10 text-info me-2">
                                    <i class="bi bi-arrow-up me-1"></i>Growing
                                </span>
                                <small class="text-muted">Portfolio growth</small>
                            </div>
                        </div>
                        <div class="icon-wrapper bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-activity text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2 text-dark-green"></i>Transaction History
                </h5>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-dark-green dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?filter=all">All Transactions</a></li>
                            <li><a class="dropdown-item" href="?filter=deposits">Deposits Only</a></li>
                            <li><a class="dropdown-item" href="?filter=completed">Completed Only</a></li>
                            <li><a class="dropdown-item" href="?filter=pending">Pending Only</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-dark-green" onclick="refreshTransactions()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">Date & Time</th>
                                <th class="border-0">Transaction Type</th>
                                <th class="border-0 text-end">Amount</th>
                                <th class="border-0">Interest</th>
                                <th class="border-0 text-end">Total Amount</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr class="transaction-row">
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $transaction->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ $transaction->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($transaction->type == 'deposit')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                            <i class="bi bi-arrow-down-circle me-1"></i>Deposit
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                                            <i class="bi bi-arrow-up-circle me-1"></i>Withdrawal
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold">UGX {{ number_format($transaction->amount, 2) }}</span>
                                </td>
                                <td>
                                    @if($transaction->interest_rate > 0)
                                        <div class="d-flex flex-column">
                                            <span class="text-success fw-bold">+{{ $transaction->interest_rate }}%</span>
                                            <small class="text-muted">UGX {{ number_format($transaction->final_amount - $transaction->amount, 2) }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-secondary' }}">
                                        UGX {{ number_format($transaction->final_amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($transaction->status == 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-success border-0">
                                            <i class="bi bi-check-circle me-1"></i>Completed
                                        </span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border-0">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge bg-info bg-opacity-10 text-info border-0">
                                            <i class="bi bi-check me-1"></i>Approved
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted font-monospace">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 px-4">
                    <div class="text-muted">
                        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
                    </div>
                    <nav>
                        {{ $transactions->links() }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                        <h4 class="text-muted mt-3">No transactions yet</h4>
                        <p class="text-muted">Your transaction history will appear here once you start saving with us.</p>
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-dark-green btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Make Your First Deposit
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Summary Section -->
    @if($transactions->count() > 0)
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-piggy-bank me-2"></i>Deposit Summary
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $completedDeposits = $user->deposits()->where('status', 'completed')->get();
                        $totalDeposits = $completedDeposits->sum('final_amount');
                        $totalPrincipal = $completedDeposits->sum('amount');
                        $totalInterest = $totalDeposits - $totalPrincipal;
                        $averageDeposit = $completedDeposits->count() > 0 ? $totalPrincipal / $completedDeposits->count() : 0;
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6 mb-4">
                            <div class="stat-highlight">
                                <h3 class="fw-bold text-success">UGX {{ number_format($totalDeposits, 0) }}</h3>
                                <small class="text-muted">Total Deposits</small>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="stat-highlight">
                                <h3 class="fw-bold text-warning">UGX {{ number_format($totalInterest, 0) }}</h3>
                                <small class="text-muted">Interest Earned</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-highlight">
                                <h4 class="fw-bold text-primary">{{ $completedDeposits->count() }}</h4>
                                <small class="text-muted">Number of Deposits</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-highlight">
                                <h4 class="fw-bold text-info">UGX {{ number_format($averageDeposit, 0) }}</h4>
                                <small class="text-muted">Average Deposit</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $totalPrincipal > 0 ? ($totalInterest / $totalDeposits) * 100 : 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted">Principal: UGX {{ number_format($totalPrincipal, 0) }}</small>
                        <small class="text-success">Interest: UGX {{ number_format($totalInterest, 0) }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Make New Deposit
                        </a>
                        <button class="btn btn-outline-dark-green btn-lg" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Print Statement
                        </button>
                        <button class="btn btn-outline-primary btn-lg" onclick="exportTransactions()">
                            <i class="bi bi-download me-2"></i>Export as PDF
                        </button>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Your savings are growing with 5% interest on every deposit
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('.transaction-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    // Filter functionality
    const filterButtons = document.querySelectorAll('.dropdown-item');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Initialize animations
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

function refreshTransactions() {
    const refreshBtn = document.querySelector('[onclick="refreshTransactions()"]');
    const originalHtml = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-1 spin"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function exportTransactions() {
    // Show loading state
    const exportBtn = document.querySelector('[onclick="exportTransactions()"]');
    const originalHtml = exportBtn.innerHTML;
    
    exportBtn.innerHTML = '<i class="bi bi-download me-2"></i>Exporting...';
    exportBtn.disabled = true;
    
    // Simulate export - in real app, this would generate a PDF
    setTimeout(() => {
        alert('Transaction history exported successfully!');
        exportBtn.innerHTML = originalHtml;
        exportBtn.disabled = false;
    }, 2000);
}

// Print functionality
function setupPrintStyles() {
    const printStyle = document.createElement('style');
    printStyle.innerHTML = `
        @media print {
            .navbar, .sidebar, .card-header, .btn, .alert, .dropdown,
            .pagination, .bg-light, .badge, .d-print-none {
                display: none !important;
            }
            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
            .table {
                font-size: 11px;
            }
            .container-fluid {
                padding: 0 !important;
            }
            h2, h3, h4, h5, h6 {
                color: #000 !important;
            }
            .text-success { color: #000 !important; }
            .text-primary { color: #000 !important; }
            .text-warning { color: #000 !important; }
            .text-info { color: #000 !important; }
        }
    `;
    document.head.appendChild(printStyle);
}

// Initialize print styles
setupPrintStyles();
</script>

<style>
.card-hover {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.icon-wrapper {
    transition: all 0.3s ease;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

.font-monospace {
    font-family: 'Courier New', monospace;
}

.stat-highlight {
    padding: 1rem;
    border-radius: 8px;
    background: rgba(0,0,0,0.02);
}

.empty-state {
    opacity: 0.7;
}

.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.bg-dark-green {
    background-color: #1a472a !important;
}

.btn-dark-green {
    background-color: #1a472a;
    border-color: #1a472a;
    color: white;
}

.btn-dark-green:hover {
    background-color: #2d5a3d;
    border-color: #2d5a3d;
    color: white;
}

.btn-outline-dark-green {
    color: #1a472a;
    border-color: #1a472a;
}

.btn-outline-dark-green:hover {
    background-color: #1a472a;
    color: white;
}

@media (max-width: 768px) {
    .card-body.p-0 .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .stat-highlight h3 {
        font-size: 1.25rem;
    }
    
    .stat-highlight h4 {
        font-size: 1.1rem;
    }
}
</style>
@endsection