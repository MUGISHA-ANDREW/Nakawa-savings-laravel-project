@extends('layouts.app')

@section('title', 'Admin Dashboard - NMSG')

@section('header')
    Admin Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Members</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_members'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Savings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">UGX {{ number_format($stats['total_balance'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Transactions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_transactions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Average Balance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($stats['total_members'] > 0)
                                    UGX {{ number_format($stats['total_balance'] / $stats['total_members'], 2) }}
                                @else
                                    UGX 0.00
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-graph-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark-green text-beige">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-lightning-fill me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.members') }}" class="btn btn-primary w-100">
                                <i class="bi bi-people me-2"></i>Manage Members
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.transactions') }}" class="btn btn-info w-100">
                                <i class="bi bi-list-check me-2"></i>All Transactions
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.reports') }}" class="btn btn-success w-100">
                                <i class="bi bi-graph-up me-2"></i>View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark-green">Recent Transactions</h6>
                    <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-dark-green">View All</a>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Member</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $transaction->user->name }}</h6>
                                                    <small class="text-muted">{{ $transaction->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><i class="bi bi-arrow-down-circle me-1"></i>Deposit</span>
                                        </td>
                                        <td class="fw-bold">
                                            UGX {{ number_format($transaction->amount, 2) }}
                                            @if($transaction->interest_rate > 0)
                                                <br><small class="text-success">+{{ $transaction->interest_rate }}% interest</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($transaction->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-info">Approved</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">No transactions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Members Overview -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark-green">Members Overview</h6>
                    <a href="{{ route('admin.members') }}" class="btn btn-sm btn-dark-green">View All</a>
                </div>
                <div class="card-body">
                    @if($members->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($members->take(6) as $member)
                            <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">{{ substr($member->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $member->name }}</h6>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-dark-green">UGX {{ number_format($member->account_balance, 2) }}</div>
                                    <small class="text-muted">Balance</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-people display-1 text-muted"></i>
                            <p class="text-muted mt-3">No members registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTransactions->take(3) as $transaction)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $transaction->user->name }}</h6>
                                    <span class="fw-bold text-success">UGX {{ number_format($transaction->amount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                    @if($transaction->interest_rate > 0)
                                        <span class="badge bg-success">+{{ $transaction->interest_rate }}% interest</span>
                                    @else
                                        <span class="badge bg-info">Deposit</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-clock-history display-4 text-muted"></i>
                            <p class="text-muted mt-2">No recent activity</p>
                        </div>
                    @endif
                    
                    @if($recentTransactions->count() > 0)
                    <div class="mt-3">
                        <a href="{{ route('admin.transactions') }}" class="btn btn-info w-100">
                            <i class="bi bi-list-check me-2"></i>View All Transactions
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark-green text-beige">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-speedometer2 me-2"></i>System Status</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-database-check display-4 text-success"></i>
                                <h5 class="mt-2">Database</h5>
                                <span class="badge bg-success">Online</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-shield-check display-4 text-success"></i>
                                <h5 class="mt-2">Security</h5>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-cash-stack display-4 text-success"></i>
                                <h5 class="mt-2">Savings</h5>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-people display-4 text-success"></i>
                                <h5 class="mt-2">Members</h5>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh dashboard every 30 seconds
    setInterval(function() {
        window.location.reload();
    }, 30000);

    // Add some basic animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection