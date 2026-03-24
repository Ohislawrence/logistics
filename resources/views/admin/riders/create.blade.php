{{-- resources/views/admin/riders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Rider - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Create New Rider</h1>
        <p class="text-muted mb-0">Add a delivery rider to your team</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.riders.index') }}" class="btn btn-outline-secondary btn-rounded">
            <i class="bi bi-arrow-left me-1"></i> Back to Riders
        </a>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card-glass p-4 p-md-5">
                <form action="{{ route('admin.riders.store') }}" method="POST" id="riderForm">
                    @csrf

                    <!-- Progress Indicator -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">1</div>
                                <span class="fw-semibold">Personal Info</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">2</div>
                                <span class="text-muted">Credentials</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-person-badge me-2 text-primary"></i>Personal Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="name"
                                           class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Enter rider's full name"
                                           required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> Full name as it will appear on the rider's profile
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="rider@example.com"
                                           required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-envelope-check"></i> The rider will use this email to login
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-key me-2 text-primary"></i>Login Credentials
                        </h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                           required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="password">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shield-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror"
                                           required>
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="password_confirmation">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-3" id="passwordStrength">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small text-muted">Password Strength:</span>
                                <span class="small fw-semibold" id="strengthText">Not entered</span>
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" id="strengthBar" style="width: 0%"></div>
                            </div>
                            <div class="small text-muted mt-2" id="strengthHint">
                                <i class="bi bi-info-circle"></i> Use at least 8 characters with letters, numbers, and symbols
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.riders.index') }}" class="btn btn-outline-secondary btn-rounded px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-light btn-rounded px-4" id="resetBtn">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-rounded px-4" id="submitBtn">
                                <i class="bi bi-plus-circle me-1"></i> Create Rider
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Card -->
            <div class="mt-4">
                <div class="alert alert-info alert-modern d-flex align-items-start gap-3">
                    <i class="bi bi-lightbulb fs-4"></i>
                    <div>
                        <strong class="d-block mb-1">Rider Account Information</strong>
                        <ul class="mb-0 ps-3 small">
                            <li>Riders will have access to the rider dashboard after creation</li>
                            <li>They can view and manage assigned deliveries</li>
                            <li>Make sure to provide a secure password that the rider can remember</li>
                            <li>You can manage rider assignments from the orders page</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('riderForm');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const strengthHint = document.getElementById('strengthHint');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = '';

            if (!password) {
                return { strength: 0, feedback: 'Not entered', color: '#6c757d', hint: 'Enter a password' };
            }

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 25;

            if (strength <= 25) feedback = 'Weak';
            else if (strength <= 50) feedback = 'Fair';
            else if (strength <= 75) feedback = 'Good';
            else feedback = 'Strong';

            let color = '#dc3545';
            if (strength > 25) color = '#fd7e14';
            if (strength > 50) color = '#ffc107';
            if (strength > 75) color = '#198754';

            let hint = '';
            if (strength < 50) {
                hint = 'Add uppercase letters, numbers, or symbols to strengthen';
            } else if (strength < 75) {
                hint = 'Almost there! Add special characters for maximum security';
            } else {
                hint = 'Excellent! Strong password';
            }

            return { strength, feedback, color, hint };
        }

        function updateStrengthIndicator() {
            const password = passwordInput.value;
            const result = checkPasswordStrength(password);

            strengthBar.style.width = result.strength + '%';
            strengthBar.style.backgroundColor = result.color;
            strengthText.textContent = result.feedback;
            strengthText.style.color = result.color;
            strengthHint.innerHTML = `<i class="bi bi-info-circle"></i> ${result.hint}`;
        }

        passwordInput.addEventListener('input', updateStrengthIndicator);

        // Password match validation
        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm && password !== confirm) {
                confirmInput.setCustomValidity('Passwords do not match');
                confirmInput.classList.add('is-invalid');
                return false;
            } else {
                confirmInput.setCustomValidity('');
                confirmInput.classList.remove('is-invalid');
                return true;
            }
        }

        confirmInput.addEventListener('input', validatePasswordMatch);
        passwordInput.addEventListener('input', validatePasswordMatch);

        // Real-time validation for all fields
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                    const feedback = this.parentElement?.parentElement?.querySelector('.invalid-feedback');
                    if (feedback) feedback.style.display = 'none';
                }
            });
        });

        // Progress indicator update
        function updateProgress() {
            const fields = {
                name: false,
                email: false,
                password: false,
                password_confirmation: false
            };

            let filled = 0;
            for (let field in fields) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input && input.value.trim() !== '') {
                    filled++;
                }
            }

            const percentage = (filled / 4) * 100;
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = `${percentage}%`;
            }
        }

        const allFields = ['name', 'email', 'password', 'password_confirmation'];
        allFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('input', updateProgress);
            }
        });

        updateProgress();

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        });

        // Reset button confirmation
        const resetBtn = document.getElementById('resetBtn');
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reset the form? All entered data will be cleared.')) {
                form.reset();
                updateProgress();
                updateStrengthIndicator();
                validatePasswordMatch();
            }
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (!validatePasswordMatch()) {
                e.preventDefault();
                alert('Please make sure the passwords match.');
            }
        });

        // Generate suggested password (optional feature)
        const generatePasswordBtn = document.createElement('button');
        generatePasswordBtn.type = 'button';
        generatePasswordBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
        generatePasswordBtn.innerHTML = '<i class="bi bi-shuffle"></i> Generate strong password';
        generatePasswordBtn.addEventListener('click', function() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            passwordInput.value = password;
            confirmInput.value = password;
            updateStrengthIndicator();
            validatePasswordMatch();
            updateProgress();
        });

        const passwordGroup = document.querySelector('input[name="password"]').closest('.col-12');
        if (passwordGroup) {
            passwordGroup.appendChild(generatePasswordBtn);
        }
    });
</script>
@endpush

<style>
    /* Additional styles for create rider form */
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

    .input-group-text {
        background-color: var(--gray-100);
        border: 1px solid var(--gray-300);
        border-right: none;
    }

    .form-control, .form-select {
        border: 1px solid var(--gray-300);
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .input-group .form-control:focus {
        border-left-color: var(--primary);
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

    .alert-modern {
        border: none;
        border-radius: 1rem;
        background: #e7f3ff;
        color: #0a58ca;
    }

    .toggle-password {
        background-color: white;
        border-left: none;
    }

    .toggle-password:hover {
        background-color: var(--gray-100);
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .card-glass {
            padding: 1.25rem !important;
        }

        .btn-rounded {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .form-label {
            font-size: 0.875rem;
        }

        .display-6 {
            font-size: 1.75rem;
        }
    }

    /* Animation */
    @keyframes slideUp {
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
        animation: slideUp 0.4s ease-out forwards;
    }

    /* Password strength transitions */
    #strengthBar {
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    /* Custom checkbox/radio styles */
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    /* Generate password button */
    .btn-outline-secondary {
        border-color: var(--gray-300);
    }

    .btn-outline-secondary:hover {
        background-color: var(--gray-100);
        border-color: var(--gray-400);
    }
</style>
@endsection
