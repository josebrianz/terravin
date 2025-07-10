@extends('layouts.admin')

@section('title', 'Profile Management - Terravin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4">
                <h1 class="page-title mb-0 fw-bold text-burgundy">
                    <i class="fas fa-user-edit me-2 text-gold"></i>
                    Profile Management
                </h1>
                <span class="text-muted small">Manage your account settings and preferences</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user-circle text-gold me-2"></i>
                        Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
                </div>
            </div>

        <!-- Password Update -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm wine-card mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-lock text-gold me-2"></i>
                        Update Password
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user-times text-gold me-2"></i>
                        Delete Account
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

.wine-card {
    background: linear-gradient(135deg, #ffffff 0%, var(--cream) 100%);
    border: 1px solid rgba(200, 169, 126, 0.2);
    transition: all 0.3s ease;
}

.wine-card:hover {
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15);
    transform: translateY(-2px);
}

.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #ffffff 100%);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(94, 15, 15, 0.1);
}

.page-title {
    color: var(--burgundy);
    font-size: 1.75rem;
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.text-gold {
    color: var(--gold) !important;
}

.btn-burgundy {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
    transition: all 0.3s ease;
}

.btn-burgundy:hover {
    background-color: var(--light-burgundy);
    border-color: var(--light-burgundy);
    color: white;
    transform: translateY(-1px);
}

.btn-gold {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
    transition: all 0.3s ease;
}

.btn-gold:hover {
    background-color: var(--dark-gold);
    border-color: var(--dark-gold);
    color: var(--burgundy);
    transform: translateY(-1px);
}

.btn-outline-burgundy {
    border-color: var(--burgundy);
    color: var(--burgundy);
    transition: all 0.3s ease;
}

.btn-outline-burgundy:hover {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-outline-gold {
    border-color: var(--gold);
    color: var(--gold);
    transition: all 0.3s ease;
}

.btn-outline-gold:hover {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

.form-control:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
}

.form-label {
    color: var(--burgundy);
    font-weight: 600;
}

.card-header {
    background: linear-gradient(135deg, rgba(200, 169, 126, 0.1) 0%, rgba(94, 15, 15, 0.05) 100%);
    border-radius: 15px 15px 0 0;
}

@media (max-width: 768px) {
    .col-lg-8, .col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
