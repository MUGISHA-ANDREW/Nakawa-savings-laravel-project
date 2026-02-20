@extends('layouts.app')

@section('title', 'Reports - NMSG')

@section('header')
    Reports
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reports & Statistics</h1>
        <a href="{{ url('/dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-dark-green">
            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

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
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($stats['total_members']) }}</div>
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
                                Total Deposits
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">UGX {{ number_format($stats['total_deposits'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-down-circle fa-2x text-gray-300"></i>
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
                                Total Withdrawals
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">UGX {{ number_format($stats['total_withdrawals'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-up-circle fa-2x text-gray-300"></i>
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
                                Pending Withdrawals
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($stats['pending_withdrawals']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <!-- Net Savings -->
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark-green">
                        <i class="bi bi-graph-up me-2"></i>Financial Summary
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Total Deposits</td>
                                    <td class="text-success fw-bold">UGX {{ number_format($stats['total_deposits'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Withdrawals</td>
                                    <td class="text-danger fw-bold">UGX {{ number_format($stats['total_withdrawals'], 2) }}</td>
                                </tr>
                                <tr class="table-active">
                                    <td class="fw-bold">Net Savings</td>
                                    <td class="fw-bold text-dark-green">UGX {{ number_format($stats['total_deposits'] - $stats['total_withdrawals'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview -->
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark-green">
                        <i class="bi bi-bar-chart me-2"></i>Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Registered Members</td>
                                    <td>{{ number_format($stats['total_members']) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pending Withdrawal Requests</td>
                                    <td>
                                        @if($stats['pending_withdrawals'] > 0)
                                            <span class="badge bg-warning text-dark">{{ $stats['pending_withdrawals'] }} pending</span>
                                        @else
                                            <span class="badge bg-success">None</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Avg. Deposit per Member</td>
                                    <td>
                                        @if($stats['total_members'] > 0)
                                            UGX {{ number_format($stats['total_deposits'] / $stats['total_members'], 2) }}
                                        @else
                                            UGX 0.00
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
