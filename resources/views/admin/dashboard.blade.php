@extends('layouts.app')

@section('title', 'Admin Dashboard - NMSG')

@section('header')
    Admin Dashboard
@endsection

@section('content')
<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(26, 71, 42, 0.15) !important;
    }
    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-card .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a472a;
    }
    .stat-card .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .quick-action-card {
        border: 2px solid transparent;
        border-radius: 12px;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }
    .quick-action-card:hover {
        border-color: #1a472a;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.1);
        color: inherit;
    }
    .quick-action-card .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .dashboard-section-header {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #1a472a;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    .member-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: #fff;
        background: linear-gradient(135deg, #1a472a, #2d5a3d);
    }
    .transaction-row {
        transition: background-color 0.15s ease;
    }
    .transaction-row:hover {
        background-color: rgba(26, 71, 42, 0.03);
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-dot.online { background-color: #28a745; }
    .card-header-themed {
        background: linear-gradient(135deg, #1a472a, #2d5a3d);
        color: #f5f5dc;
        border-radius: 12px 12px 0 0 !important;
    }
    .progress-thin {
        height: 4px;
        border-radius: 2px;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 50%, #3a6b4a 100%);
        border-radius: 16px;
        color: #f5f5dc;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(245, 245, 220, 0.05);
        border-radius: 50%;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(245, 245, 220, 0.03);
        border-radius: 50%;
    }
</style>

<div class="container-fluid px-4">
    <!-- Welcome Banner -->
    <div class="welcome-banner shadow-sm p-4 mb-4">
        <div class="row align-items-center position-relative" style="z-index: 1;">
            <div class="col-md-8">
                <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h3>
                <p class="mb-0 opacity-75">Here's an overview of your savings group's performance today.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar3 me-1"></i>{{ now()->format('D, M d, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">Total Members</div>
                            <div class="stat-value">{{ $stats['total_members'] }}</div>
                            <small class="text-muted"><i class="bi bi-people me-1"></i>Registered accounts</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(26, 71, 42, 0.1); color: #1a472a;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">Total Savings</div>
                            <div class="stat-value" style="font-size: 1.25rem;">UGX {{ number_format($stats['total_balance'], 0) }}</div>
                            <small class="text-success"><i class="bi bi-graph-up-arrow me-1"></i>Group pool</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-wallet-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">Total Transactions</div>
                            <div class="stat-value">{{ $stats['total_transactions'] }}</div>
                            <small class="text-muted"><i class="bi bi-arrow-left-right me-1"></i>All time</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">Avg. Balance</div>
                            <div class="stat-value" style="font-size: 1.25rem;">
                                @if($stats['total_members'] > 0)
                                    UGX {{ number_format($stats['total_balance'] / $stats['total_members'], 0) }}
                                @else
                                    UGX 0
                                @endif
                            </div>
                            <small class="text-muted"><i class="bi bi-calculator me-1"></i>Per member</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <div class="dashboard-section-header"><i class="bi bi-lightning-charge-fill me-1"></i> Quick Actions</div>
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.members') }}" class="card quick-action-card shadow-sm h-100 p-3 d-block">
                    <div class="d-flex align-items-center">
                        <div class="action-icon" style="background: rgba(26, 71, 42, 0.1); color: #1a472a;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Manage Members</h6>
                            <small class="text-muted">View & edit accounts</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.transactions') }}" class="card quick-action-card shadow-sm h-100 p-3 d-block">
                    <div class="d-flex align-items-center">
                        <div class="action-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Transactions</h6>
                            <small class="text-muted">All transactions</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports') }}" class="card quick-action-card shadow-sm h-100 p-3 d-block">
                    <div class="d-flex align-items-center">
                        <div class="action-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Reports</h6>
                            <small class="text-muted">Analytics & exports</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.members.register') }}" class="card quick-action-card shadow-sm h-100 p-3 d-block">
                    <div class="d-flex align-items-center">
                        <div class="action-icon" style="background: rgba(111, 66, 193, 0.1); color: #6f42c1;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Register Member</h6>
                            <small class="text-muted">Add new member</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Recent Transactions -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header card-header-themed py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Transactions</h6>
                    <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-light rounded-pill px-3">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr style="background: #f8f9fa;">
                                        <th class="ps-4 py-3 border-0 text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Member</th>
                                        <th class="py-3 border-0 text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                        <th class="py-3 border-0 text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Amount</th>
                                        <th class="py-3 border-0 text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                        <th class="pe-4 py-3 border-0 text-muted" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr class="transaction-row">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="member-avatar">
                                                    {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                                </div>
                                                <div class="ms-3">
                                                    <div class="fw-semibold">{{ $transaction->user->name }}</div>
                                                    <small class="text-muted">{{ $transaction->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge rounded-pill" style="background: rgba(40, 167, 69, 0.1); color: #28a745; font-weight: 600;">
                                                <i class="bi bi-arrow-down-circle me-1"></i>Deposit
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-bold" style="color: #1a472a;">UGX {{ number_format($transaction->amount, 2) }}</div>
                                            @if($transaction->interest_rate > 0)
                                                <small class="text-success fw-semibold">+{{ $transaction->interest_rate }}% interest</small>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            @if($transaction->status == 'completed')
                                                <span class="badge rounded-pill" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                                                    <span class="status-dot online"></span>Completed
                                                </span>
                                            @elseif($transaction->status == 'pending')
                                                <span class="badge rounded-pill" style="background: rgba(255, 193, 7, 0.15); color: #d39e00;">
                                                    <span class="status-dot" style="background: #ffc107;"></span>Pending
                                                </span>
                                            @else
                                                <span class="badge rounded-pill" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                                                    <span class="status-dot" style="background: #17a2b8;"></span>Approved
                                                </span>
                                            @endif
                                        </td>
                                        <td class="pe-4 py-3">
                                            <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $transaction->created_at->format('h:i A') }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 64px; height: 64px; border-radius: 50%; background: rgba(26, 71, 42, 0.08); display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-inbox" style="font-size: 1.75rem; color: #1a472a;"></i>
                            </div>
                            <p class="text-muted mb-0">No transactions recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-xl-4 col-lg-5">
            <!-- Members Overview -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header card-header-themed py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold"><i class="bi bi-people-fill me-2"></i>Top Members</h6>
                    <a href="{{ route('admin.members') }}" class="btn btn-sm btn-light rounded-pill px-3">
                        All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if($members->count() > 0)
                        @foreach($members->take(5) as $member)
                        <div class="d-flex align-items-center justify-content-between {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="member-avatar">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold mb-0" style="font-size: 0.9rem;">{{ $member->name }}</div>
                                    <small class="text-muted">{{ $member->email }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="color: #1a472a; font-size: 0.85rem;">UGX {{ number_format($member->account_balance, 0) }}</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3" style="width: 56px; height: 56px; border-radius: 50%; background: rgba(26, 71, 42, 0.08); display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people" style="font-size: 1.5rem; color: #1a472a;"></i>
                            </div>
                            <p class="text-muted mb-0">No members registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity Timeline -->
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header py-3 bg-white" style="border-radius: 12px 12px 0 0;">
                    <h6 class="m-0 fw-bold" style="color: #1a472a;">
                        <i class="bi bi-activity me-2"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        @foreach($recentTransactions->take(4) as $transaction)
                        <div class="d-flex {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <div class="me-3">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-arrow-down-circle-fill text-success" style="font-size: 1rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold" style="font-size: 0.85rem;">{{ $transaction->user->name }}</div>
                                        <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="fw-bold" style="color: #1a472a; font-size: 0.85rem;">
                                        UGX {{ number_format($transaction->amount, 0) }}
                                    </span>
                                </div>
                                @if($transaction->interest_rate > 0)
                                    <small class="text-success fw-semibold">+{{ $transaction->interest_rate }}% interest earned</small>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <a href="{{ route('admin.transactions') }}" class="btn btn-dark-green w-100 mt-3 rounded-pill text-beige">
                            <i class="bi bi-list-check me-2"></i>View All Transactions
                        </a>
                    @else
                        <div class="text-center py-3">
                            <div class="mb-2" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(26, 71, 42, 0.08); display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-clock-history" style="font-size: 1.25rem; color: #1a472a;"></i>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header card-header-themed py-3">
                    <h6 class="m-0 fw-bold"><i class="bi bi-hdd-stack me-2"></i>System Status</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded-3" style="background: rgba(40, 167, 69, 0.06);">
                                <div class="mb-2" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(40, 167, 69, 0.12); display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-database-fill-check text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Database</h6>
                                <span class="badge rounded-pill bg-success px-3">
                                    <span class="status-dot online" style="margin-right: 4px;"></span>Online
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded-3" style="background: rgba(40, 167, 69, 0.06);">
                                <div class="mb-2" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(40, 167, 69, 0.12); display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shield-fill-check text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Security</h6>
                                <span class="badge rounded-pill bg-success px-3">
                                    <span class="status-dot online" style="margin-right: 4px;"></span>Active
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded-3" style="background: rgba(40, 167, 69, 0.06);">
                                <div class="mb-2" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(40, 167, 69, 0.12); display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-cash-stack text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Savings</h6>
                                <span class="badge rounded-pill bg-success px-3">
                                    <span class="status-dot online" style="margin-right: 4px;"></span>Active
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 rounded-3" style="background: rgba(40, 167, 69, 0.06);">
                                <div class="mb-2" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(40, 167, 69, 0.12); display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-people-fill text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Members</h6>
                                <span class="badge rounded-pill bg-success px-3">
                                    <span class="status-dot online" style="margin-right: 4px;"></span>Active
                                </span>
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
    // Staggered card entrance animation
    const animateElements = document.querySelectorAll('.stat-card, .quick-action-card, .card');
    animateElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(15px)';
        
        setTimeout(() => {
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 60 + index * 60);
    });

    // Animate stat values with count-up effect
    document.querySelectorAll('.stat-value').forEach(el => {
        const text = el.textContent.trim();
        const match = text.match(/[\d,]+/);
        if (match) {
            const target = parseInt(match[0].replace(/,/g, ''));
            if (target > 0 && target < 1000000000) {
                const prefix = text.substring(0, text.indexOf(match[0]));
                const suffix = text.substring(text.indexOf(match[0]) + match[0].length);
                let current = 0;
                const step = Math.ceil(target / 30);
                const interval = setInterval(() => {
                    current = Math.min(current + step, target);
                    el.textContent = prefix + current.toLocaleString() + suffix;
                    if (current >= target) clearInterval(interval);
                }, 30);
            }
        }
    });
});
</script>
@endsection