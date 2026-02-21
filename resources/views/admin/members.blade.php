{{-- resources/views/admin/manage-members.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Members - NMSG')

@section('header')
    Manage Members
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Statistics Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Members
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $members->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Savings
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">UGX {{ number_format($members->sum('account_balance'), 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Active This Month
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $activeMembersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-activity fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                New This Month
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $newMembersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus fa-2x text-gray-300"></i>
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
                <div class="card-header bg-dark-green text-beige d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3">
                    <h6 class="m-0 fw-bold mb-2 mb-md-0">
                        <i class="bi bi-lightning-fill me-2"></i>Quick Actions
                    </h6>
                    <a href="{{ route('admin.members.register') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person-plus me-1"></i>Add New Member
                    </a>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-4">
                            <a href="{{ route('admin.members.register') }}" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-person-plus me-2"></i>Register Member
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <button class="btn btn-success w-100 py-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="bi bi-download me-2"></i>Export Data
                            </button>
                        </div>
                        <div class="col-12 col-md-4">
                            <button class="btn btn-info w-100 py-2" onclick="printMemberList()">
                                <i class="bi bi-printer me-2"></i>Print List
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <h6 class="m-0 fw-bold text-dark-green mb-2 mb-md-0">
                    <i class="bi bi-people me-2"></i>All Members ({{ $members->count() }})
                </h6>
                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                    <div class="position-relative flex-fill">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="memberSearch" class="form-control form-control-sm ps-5" placeholder="Search members...">
                    </div>
                    <select id="balanceFilter" class="form-select form-select-sm" style="min-width: 140px;">
                        <option value="">All Balances</option>
                        <option value="high">High Balance</option>
                        <option value="low">Low Balance</option>
                        <option value="zero">Zero Balance</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($members->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="membersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-3 ps-md-4">#</th>
                                <th class="border-0">Member Info</th>
                                <th class="border-0 d-none d-md-table-cell">Contact</th>
                                <th class="border-0">Balance</th>
                                <th class="border-0 d-none d-lg-table-cell">Next of Kin</th>
                                <th class="border-0 d-none d-sm-table-cell">Member Since</th>
                                <th class="border-0 pe-3 pe-md-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr class="align-middle">
                                <td class="ps-3 ps-md-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="member-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                            <span class="text-white fw-bold small">{{ substr($member->name, 0, 1) }}</span>
                                        </div>
                                        <div class="min-w-0 flex-fill">
                                            <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $member->name }}</h6>
                                            <small class="text-muted d-block d-md-none">{{ $member->email }}</small>
                                            <small class="text-muted">ID: {{ $member->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="d-flex flex-column">
                                        <small class="text-truncate" style="max-width: 200px;">
                                            <i class="bi bi-envelope me-1 text-primary"></i>{{ $member->email }}
                                        </small>
                                        <small>
                                            <i class="bi bi-phone me-1 text-success"></i>{{ $member->phone ?? 'N/A' }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark-green">UGX {{ number_format($member->account_balance, 2) }}</span>
                                        <small class="text-muted d-none d-sm-block">
                                            @php
                                                $totalDeposits = $member->transactions()->where('type', 'deposit')->where('status', 'completed')->sum('amount');
                                            @endphp
                                            Deposits: UGX {{ number_format($totalDeposits, 2) }}
                                        </small>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <div class="d-flex flex-column">
                                        <small class="fw-bold text-truncate" style="max-width: 150px;">{{ $member->next_of_kin_name ?? 'N/A' }}</small>
                                        <small class="text-muted">{{ $member->next_of_kin_relationship ?? '' }}</small>
                                        <small class="text-truncate" style="max-width: 150px;">
                                            <i class="bi bi-phone me-1"></i>{{ $member->next_of_kin_phone ?? '' }}
                                        </small>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="d-flex flex-column">
                                        <span class="small">{{ $member->created_at->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ $member->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td class="pe-3 pe-md-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.members.edit', $member->id) }}" 
                                           class="btn btn-primary btn-action rounded-circle" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Member">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-action rounded-circle" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Member"
                                                    onclick="return confirm('Are you sure you want to delete {{ $member->name }}? This action cannot be undone.')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="d-block d-md-none p-3">
                    @foreach($members as $member)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="member-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <span class="text-white fw-bold small">{{ substr($member->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $member->name }}</h6>
                                        <small class="text-muted">ID: {{ $member->id }}</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.members.edit', $member->id) }}" 
                                       class="btn btn-primary btn-action rounded-circle" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Member">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-action rounded-circle" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete Member"
                                                onclick="return confirm('Are you sure you want to delete {{ $member->name }}? This action cannot be undone.')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Email</small>
                                    <small class="fw-semibold text-truncate d-block">{{ $member->email }}</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Phone</small>
                                    <small class="fw-semibold">{{ $member->phone ?? 'N/A' }}</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Balance</small>
                                    <small class="fw-semibold text-dark-green">UGX {{ number_format($member->account_balance, 2) }}</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Joined</small>
                                    <small class="fw-semibold">{{ $member->created_at->format('M d, Y') }}</small>
                                </div>
                                @if($member->next_of_kin_name)
                                <div class="col-12">
                                    <small class="text-muted d-block">Next of Kin</small>
                                    <small class="fw-semibold">{{ $member->next_of_kin_name }} ({{ $member->next_of_kin_relationship }})</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Summary Section -->
                <div class="row g-3 g-md-4 mt-4 px-3 px-md-4 pb-3">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="card-title fw-bold mb-3">Summary</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Total Members</small>
                                        <h6 class="mb-0 fw-bold">{{ $members->count() }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Total Balance</small>
                                        <h6 class="mb-0 fw-bold">UGX {{ number_format($members->sum('account_balance'), 2) }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Average Balance</small>
                                        <h6 class="mb-0 fw-bold">UGX {{ number_format($members->avg('account_balance'), 2) }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Highest Balance</small>
                                        <h6 class="mb-0 fw-bold">UGX {{ number_format($members->max('account_balance'), 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="card-title fw-bold mb-3">Quick Stats</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Active Members</small>
                                        <h6 class="mb-0 fw-bold">{{ $members->where('account_balance', '>', 0)->count() }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">New This Month</small>
                                        <h6 class="mb-0 fw-bold">{{ $newMembersCount }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Zero Balance</small>
                                        <h6 class="mb-0 fw-bold">{{ $members->where('account_balance', 0)->count() }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Total Transactions</small>
                                        <h6 class="mb-0 fw-bold">{{ $totalTransactions }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5 px-3">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No Members Found</h4>
                    <p class="text-muted">There are no members registered in the system yet.</p>
                    <a href="{{ route('admin.members.register') }}" class="btn btn-dark-green mt-2">
                        <i class="bi bi-person-plus me-2"></i>Register First Member
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.members.export') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title">Export Members Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Export Format</label>
                        <select class="form-select" name="format">
                            <option value="csv">CSV (.csv)</option>
                            <option value="pdf">PDF (.pdf)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data to Include</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_basic" checked disabled>
                            <label class="form-check-label">Basic Member Information</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_balances" value="1" checked>
                            <label class="form-check-label">Account Balances</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_transactions" value="1">
                            <label class="form-check-label">Transaction History</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-download me-1"></i>Export Data
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search functionality
    const searchInput = document.getElementById('memberSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#membersTable tbody tr, .d-md-none .card');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Filter functionality
    const balanceFilter = document.getElementById('balanceFilter');

    if (balanceFilter) {
        function applyFilters() {
            const balanceValue = balanceFilter.value;
            const rows = document.querySelectorAll('#membersTable tbody tr, .d-md-none .card');
            
            rows.forEach(row => {
                let showRow = true;
                
                // Extract balance from row (different for table vs card view)
                let balanceText = '';
                if (row.classList.contains('card')) {
                    // Mobile card view
                    const balanceElement = row.querySelector('.text-dark-green');
                    if (balanceElement) {
                        balanceText = balanceElement.textContent;
                    }
                } else {
                    // Table view
                    const balanceCell = row.cells[3];
                    if (balanceCell) {
                        balanceText = balanceCell.textContent;
                    }
                }
                
                const balance = parseFloat(balanceText.replace(/[^\d.]/g, '')) || 0;
                
                // Balance filter
                if (balanceValue === 'high') {
                    if (balance < 100000) showRow = false;
                } else if (balanceValue === 'low') {
                    if (balance >= 10000 || balance === 0) showRow = false;
                } else if (balanceValue === 'zero') {
                    if (balance !== 0) showRow = false;
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }

        balanceFilter.addEventListener('change', applyFilters);
    }

    // Auto-hide table header on mobile when scrolling
    const tableHeader = document.querySelector('.card-header');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        if (window.innerWidth < 768) {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                tableHeader.style.transform = 'translateY(-100%)';
            } else {
                tableHeader.style.transform = 'translateY(0)';
            }
            lastScrollTop = scrollTop;
        }
    });
});

function printMemberList() {
    const table = document.getElementById('membersTable');
    if (!table) {
        alert('No members to print.');
        return;
    }
    
    // Clone the table to remove action buttons
    const clonedTable = table.cloneNode(true);
    
    // Remove the actions column (last column) from header and each row
    const headerRow = clonedTable.querySelector('thead tr');
    if (headerRow && headerRow.lastElementChild) {
        headerRow.lastElementChild.remove();
    }
    const bodyRows = clonedTable.querySelectorAll('tbody tr');
    bodyRows.forEach(row => {
        if (row.lastElementChild) {
            row.lastElementChild.remove();
        }
    });
    
    // Show all hidden columns for print
    clonedTable.querySelectorAll('.d-none').forEach(el => {
        el.classList.remove('d-none', 'd-md-table-cell', 'd-lg-table-cell', 'd-sm-table-cell');
    });
    
    const printContent = clonedTable.outerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>NMSG - Members List</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; font-size: 12px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f8f9fa; font-weight: bold; }
                    .member-avatar { display: none; }
                    @media print {
                        body { margin: 0; }
                        table { font-size: 10px; }
                    }
                </style>
            </head>
            <body>
                <h2>Nakawa Market Savings Group - Members List</h2>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>

<style>
/* Responsive Design */
.member-avatar {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.btn-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

/* Table Responsive */
@media (max-width: 767.98px) {
    .table-responsive {
        border: 0;
    }
    
    .card-header {
        transition: transform 0.3s ease;
    }
    
    .min-w-0 {
        min-width: 0;
    }
}

/* Hover Effects */
.table-hover tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

/* Custom Colors */
.bg-dark-green {
    background-color: #1a472a !important;
}

.text-beige {
    color: #f5f5dc !important;
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

/* Loading States */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Focus States */
.form-control:focus,
.form-select:focus {
    border-color: #1a472a;
    box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
}

/* Smooth Animations */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Print Optimizations */
@media print {
    .btn, .card-header, .quick-actions {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection