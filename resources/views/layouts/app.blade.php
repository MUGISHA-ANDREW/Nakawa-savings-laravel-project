<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Nakawa Market Savings Group') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <!-- Custom Styles -->
        <style>
            .bg-dark-green {
                background-color: #1a472a !important;
            }
            .text-dark-green {
                color: #1a472a !important;
            }
            .text-beige {
                color: #f5f5dc !important;
            }
            .btn-dark-green {
                background-color: #1a472a;
                border-color: #1a472a;
                color: #f5f5dc;
            }
            .btn-dark-green:hover {
                background-color: #2d5a3d;
                border-color: #2d5a3d;
                color: #f5f5dc;
            }
            .navbar-dark .navbar-nav .nav-link {
                color: rgba(255, 255, 255, 0.8);
            }
            .navbar-dark .navbar-nav .nav-link:hover {
                color: #fff;
            }
            .sidebar {
                min-height: calc(100vh - 56px);
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar (for admin) -->
                @auth
                    @if(auth()->user()->isAdmin())
                    <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-light">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.members') }}">
                                        <i class="bi bi-people me-2"></i>
                                        Manage Members
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.transactions') }}">
                                        <i class="bi bi-list-check me-2"></i>
                                        All Transactions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reports') }}">
                                        <i class="bi bi-graph-up me-2"></i>
                                        Reports
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    @endif
                @endauth

                <!-- Main content area -->
                <main class="@auth @if(auth()->user()->isAdmin()) col-md-9 ms-sm-auto col-lg-10 px-md-4 @else col-12 @endif @else col-12 @endauth">
                    
                    <!-- Page Header -->
                    @if(isset($header))
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">{{ $header }}</h1>
                        @if(isset($action))
                        <div class="btn-toolbar mb-2 mb-md-0">
                            {{ $action }}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Page Content -->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1050; min-width: 300px;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1050; min-width: 300px;" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 1050; min-width: 300px;" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom Scripts -->
        <script>
            // Auto-hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-hide alerts
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000);
                });

                // Enable Bootstrap tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>

        <!-- Additional scripts from yield -->
        @yield('scripts')
    </body>
</html>