{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Profile Settings - ' . config('app.name', 'AniqueLogistics'))

@section('header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h1 class="h2 fw-bold mb-1">Profile Settings</h1>
            <p class="text-muted mb-0">Manage your account information and security preferences</p>
        </div>

    </div>
@endsection

@section('content')
<div class="py-4 py-md-5">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar / Profile Overview -->
            <div class="col-12 col-lg-4">
                <div class="card-glass p-4 text-center sticky-top" style="top: 2rem;">
                    <div class="profile-avatar mb-3">
                        <div class="avatar-large rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto">
                            <span class="text-white fw-bold fs-1">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                    </div>
                    <h3 class="h4 fw-bold mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>

                    <div class="profile-stats d-flex justify-content-center gap-4 mb-4">
                        <div class="text-center">
                            <div class="stat-number fw-bold text-primary">{{ Auth::user()->created_at->diffForHumans() }}</div>
                            <div class="stat-label small text-muted">Member since</div>
                        </div>
                        <div class="text-center">
                            <div class="stat-number fw-bold text-primary">{{ Auth::user()->orders_count ?? 0 }}</div>
                            <div class="stat-label small text-muted">Orders</div>
                        </div>
                    </div>

                    <div class="alert alert-info alert-modern small">
                        <i class="bi bi-shield-check me-2"></i>
                        Your account is secure and protected
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-8">
                <div class="space-y-4">
                    <!-- Update Profile Information -->
                    <div class="card-glass p-4 p-md-5 mb-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Update Password -->
                    <div class="card-glass p-4 p-md-5 mb-4">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Delete Account -->
                    <div class="card-glass p-4 p-md-5 border-danger border-opacity-25 mb-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Profile Page Styles */
    .card-glass {
        background: white;
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .avatar-large {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.3);
    }

    .avatar-large span {
        font-size: 2.5rem;
    }

    .profile-stats {
        border-top: 1px solid var(--gray-200);
        border-bottom: 1px solid var(--gray-200);
        padding: 1rem 0;
    }

    .stat-number {
        font-size: 1rem;
    }

    .alert-modern {
        border: none;
        border-radius: 1rem;
        background: #e7f3ff;
        color: #0a58ca;
    }

    /* Form Styles within profile */
    .input-group-custom {
        margin-bottom: 1.25rem;
    }

    .input-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1rem;
        pointer-events: none;
    }

    .input-field {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        background: white;
    }

    .input-field:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .input-field:focus + .input-icon {
        color: #0d6efd;
    }

    .btn-rounded {
        border-radius: 2rem;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-rounded:hover {
        transform: translateY(-1px);
    }

    /* Password strength meter */
    .password-strength {
        margin-top: 0.5rem;
    }

    .strength-meter {
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    /* Delete account section */
    .delete-account-section {
        border-top: 2px solid #fee2e2;
    }

    .btn-danger-outline {
        background: transparent;
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-danger-outline:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
    }

    /* Modal styles */
    .modal-content {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 2rem 3rem rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: none;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .card-glass {
            padding: 1.25rem !important;
        }

        .avatar-large {
            width: 80px;
            height: 80px;
        }

        .avatar-large span {
            font-size: 2rem;
        }

        .btn-rounded {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .input-field {
            padding: 0.65rem 1rem 0.65rem 2.25rem;
            font-size: 0.875rem;
        }

        .profile-stats {
            padding: 0.75rem 0;
        }
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-glass {
        animation: slideIn 0.4s ease-out forwards;
    }

    /* Sticky sidebar adjustment */
    .sticky-top {
        position: sticky;
        top: 2rem;
    }

    @media (max-width: 768px) {
        .sticky-top {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush
