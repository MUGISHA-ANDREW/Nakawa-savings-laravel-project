@extends('layouts.app')

@section('title', 'My Profile - NMSG')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-dark-green d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-person-fill text-white fs-4"></i>
                </div>
                <div>
                    <h2 class="h4 mb-0 fw-bold">My Profile</h2>
                    <p class="text-muted mb-0">Manage your account settings and security</p>
                </div>
            </div>

            <!-- Profile Information -->
            @include('profile.partials.update-profile-information-form')

            <!-- Update Password -->
            @include('profile.partials.update-password-form')

            <!-- Delete Account -->
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
