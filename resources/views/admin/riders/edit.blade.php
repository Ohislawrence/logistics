{{-- resources/views/admin/riders/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Rider - ' . ($rider->name ?? 'Rider') . ' - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Edit Rider</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-person-badge me-1"></i>
            {{ $rider->name ?? 'Update rider information' }}
        </p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <a href="{{ route('admin.riders.index') }}" class="btn btn-outline-secondary btn-rounded">
            <i class="bi bi-arrow-left me-1"></i> Back to Riders
        </a>
        @if(isset($rider->id))
            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Delete Rider
            </button>
        @endif
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <!-- Rider Status Banner -->
            <div class="alert alert-modern d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <span>Rider Status:</span>
                    <span class="badge rounded-pill px-3 py-2
                        @if(($rider->status ?? 'active') == 'active') bg-success
                        @elseif(($rider->status ?? '') == 'inactive') bg-secondary
                        @else bg-warning @endif">
                        {{ ucfirst($rider->status ?? 'Active') }}
                    </span>
                </div>
                <div class="text-muted small">
                    <i class="bi bi-bicycle me-1"></i>
                    @if(isset($rider->active_deliveries))
                        {{ $rider->active_deliveries }} active deliveries
                    @else
                        0 active deliveries
                    @endif
                </div>
            </div>

            <div class="card-glass p-4 p-md-5">
                <form action="{{ route('admin.riders.update', $rider) }}" method="POST" id="riderForm">
                    @csrf
                    @method('PUT')

                    <!-- Progress Indicator -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">1</div>
                                <span class="fw-semibold">Personal Info</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">2</div>
                                <span class="text-muted">Password (Optional)</span>
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
                                           value="{{ old('name', $rider->name ?? '') }}"
                                           placeholder="Rider's full name"
                                           required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
                                           value="{{ old('email', $rider->email ?? '') }}"
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

                            @if(isset($rider->phone))
                            <div class="col-12">
                                <label class="form-label fw-semibold">Phone Number <span class="text-muted">(optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-telephone text-muted"></i>
                                    </span>
                                    <input type="tel"
                                           name="phone"
                                           class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $rider->phone ?? '') }}"
                                           placeholder="+234 801 234 5678">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Password Section (Optional) -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-key me-2 text-primary"></i>Change Password
                        </h5>
                        <div class="alert alert-light bg-light border rounded-3 mb-3">
                            <i class="bi bi-info-circle me-2 text-info"></i>
                            <small>Leave password fields blank to keep the current password</small>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                           placeholder="Leave blank to keep current">
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="password">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shield-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Confirm new password">
                                    <button type="button" class="btn btn-outline-secondary border-start-0 toggle-password" data-target="password_confirmation">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Strength Indicator (shown only when password is entered) -->
                        <div class="mt-3" id="passwordStrength" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small text-muted">Password Strength:</span>
                                <span class="small fw-semibold" id="strengthText">Weak</span>
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
                            <button type="submit" class="btn btn-primary btn-rounded px-4">
                                <i class="bi bi-save me-1"></i> Update Rider
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Rider Statistics Card -->
            @if(isset($rider->created_at) || isset($rider->total_deliveries))
            <div class="mt-4">
                <div class="card-glass p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Rider Statistics
                    </h6>
                    <div class="row g-3">
                        @if(isset($rider->created_at))
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-plus text-muted"></i>
                                <div>
                                    <div class="small text-muted">Joined</div>
                                    <div class="fw-semibold">{{ $rider->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($rider->total_deliveries))
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-truck text-muted"></i>
                                <div>
                                    <div class="small text-muted">Total Deliveries</div>
                                    <div class="fw-semibold">{{ $rider->total_deliveries }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($rider->completion_rate))
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-star text-muted"></i>
                                <div>
                                    <div class="small text-muted">Completion Rate</div>
                                    <div class="fw-semibold">{{ $rider->completion_rate }}%</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($rider->last_active))
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock-history text-muted"></i>
                                <div>
                                    <div class="small text-muted">Last Active</div>
                                    <div class="fw-semibold">{{ $rider->last_active->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Help Card -->
            <div class="mt-4">
                <div class="alert alert-info alert-modern d-flex align-items-start gap-3">
                    <i class="bi bi-lightbulb fs-4"></i>
                    <div>
                        <strong class="d-block mb-1">Editing Tips</strong>
                        <ul class="mb-0 ps-3 small">
                            <li>Email address is used for login - make sure it's correct</li>
                            <li>Password fields are optional - leave blank to keep current password</li>
                            <li>Changes will take effect immediately on next login</li>
                            <li>Deactivating a rider will prevent them from accessing the system</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if(isset($rider->id))
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                </div>
                <h5 class="fw-bold mb-2">Delete Rider</h5>
                <p class="text-muted mb-4">
                    Are you sure you want to delete rider <strong>{{ $rider->name ?? 'this rider' }}</strong>?<br>
                    This action cannot be undone. All associated deliveries will be unassigned.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-light btn-rounded px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <form action="{{ route('admin.riders.destroy', $rider->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded px-4">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('riderForm');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthDiv = document.getElementById('passwordStrength');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const strengthHint = document.getElementById('strengthHint');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = '';

            if (!password) {
                return { strength: 0, feedback: 'Not entered', color: '#6c757d', hint: 'Enter a password to change' };
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

            if (password) {
                strengthDiv.style.display = 'block';
                const result = checkPasswordStrength(password);
                strengthBar.style.width = result.strength + '%';
                strengthBar.style.backgroundColor = result.color;
                strengthText.textContent = result.feedback;
                strengthText.style.color = result.color;
                strengthHint.innerHTML = `<i class="bi bi-info-circle"></i> ${result.hint}`;
            } else {
                strengthDiv.style.display = 'none';
            }
        }

        // Show strength indicator only when password is being entered
        passwordInput.addEventListener('input', updateStrengthIndicator);

        // Password match validation (only if password is entered)
        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (password || confirm) {
                if (password !== confirm) {
                    confirmInput.setCustomValidity('Passwords do not match');
                    confirmInput.classList.add('is-invalid');
                    return false;
                } else if (password && confirm && password === confirm) {
                    confirmInput.setCustomValidity('');
                    confirmInput.classList.remove('is-invalid');
                    return true;
                }
            }

            confirmInput.setCustomValidity('');
            confirmInput.classList.remove('is-invalid');
            return true;
        }

        confirmInput.addEventListener('input', validatePasswordMatch);
        passwordInput.addEventListener('input', validatePasswordMatch);

        // Real-time validation for all fields
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Progress indicator update
        function updateProgress() {
            const fields = {
                name: false,
                email: false
            };

            let filled = 0;
            for (let field in fields) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input && input.value.trim() !== '') {
                    filled++;
                }
            }

            const percentage = (filled / 2) * 100;
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = `${percentage}%`;
            }
        }

        const requiredFields = ['name', 'email'];
        requiredFields.forEach(fieldName => {
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
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                    form.reset();
                    updateProgress();
                    if (strengthDiv) strengthDiv.style.display = 'none';
                    validatePasswordMatch();
                }
            });
        }

        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (!validatePasswordMatch()) {
                e.preventDefault();
                alert('Please make sure the passwords match.');
            }
        });

        // Warn before leaving if changes are unsaved
        let formChanged = false;
        const formInputs = form.querySelectorAll('input, select, textarea');
        formInputs.forEach(input => {
            input.addEventListener('change', () => { formChanged = true; });
            input.addEventListener('input', () => { formChanged = true; });
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });

        form.addEventListener('submit', function() {
            formChanged = false;
        });
    });
</script>
@endpush

<style>
    /* Additional styles for edit rider form */
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

    .alert-light {
        background-color: var(--gray-100);
        border-color: var(--gray-200);
    }

    .toggle-password {
        background-color: white;
        border-left: none;
    }

    .toggle-password:hover {
        background-color: var(--gray-100);
    }

    /* Modal styling */
    .modal-content {
        border: none;
        box-shadow: 0 2rem 3rem rgba(0, 0, 0, 0.1);
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

        .modal-body {
            padding: 1.5rem;
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

    /* Badge styling */
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>
@endsection
