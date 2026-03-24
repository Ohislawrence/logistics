{{-- resources/views/admin/orders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create New Order - MediSwift')

@section('header')
    <div>
        <h1 class="h2 fw-bold mb-1">Create New Order</h1>
        <p class="text-muted mb-0">Fill in the delivery details below to create a new order</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-rounded">
            <i class="bi bi-arrow-left me-1"></i> Back to Orders
        </a>
    </div>
@endsection

@section('content')
<div class="py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card-glass p-4 p-md-5">
                <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
                    @csrf

                    <!-- Progress Indicator -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">1</div>
                                <span class="fw-semibold">Recipient Info</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">2</div>
                                <span class="text-muted">Address Details</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">3</div>
                                <span class="text-muted">Assignment</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 33%"></div>
                        </div>
                    </div>

                    <!-- Recipient Information Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-person-circle me-2 text-primary"></i>Recipient Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Recipient Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="recipient_name"
                                           class="form-control border-start-0 ps-0 @error('recipient_name') is-invalid @enderror"
                                           value="{{ old('recipient_name') }}"
                                           placeholder="Full name"
                                           required>
                                </div>
                                @error('recipient_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Recipient Phone <span class="text-muted">(optional)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-telephone text-muted"></i>
                                    </span>
                                    <input type="tel"
                                           name="recipient_phone"
                                           class="form-control border-start-0 ps-0 @error('recipient_phone') is-invalid @enderror"
                                           value="{{ old('recipient_phone') }}"
                                           placeholder="+234 801 234 5678">
                                </div>
                                @error('recipient_phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Details Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>Delivery Details
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Pickup Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shop text-muted"></i>
                                    </span>
                                    <textarea name="pickup_address"
                                              class="form-control border-start-0 ps-0 @error('pickup_address') is-invalid @enderror"
                                              rows="2"
                                              placeholder="Enter the pickup location address">{{ old('pickup_address') }}</textarea>
                                </div>
                                @error('pickup_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> Include landmark if available for easier pickup
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Delivery Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-house-door text-muted"></i>
                                    </span>
                                    <textarea name="delivery_address"
                                              class="form-control border-start-0 ps-0 @error('delivery_address') is-invalid @enderror"
                                              rows="2"
                                              placeholder="Enter the delivery destination address">{{ old('delivery_address') }}</textarea>
                                </div>
                                @error('delivery_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cost & Notes Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-calculator me-2 text-primary"></i>Order Details
                        </h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Delivery Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-currency-naira text-muted"></i>
                                    </span>
                                    <input type="number"
                                           step="0.01"
                                           name="cost"
                                           class="form-control border-start-0 ps-0 @error('cost') is-invalid @enderror"
                                           value="{{ old('cost') }}"
                                           placeholder="0.00">
                                </div>
                                @error('cost')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Optional. Leave blank to calculate later</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Assign to Rider <span class="text-muted">(optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-bicycle text-muted"></i>
                                    </span>
                                    <select name="assigned_to" class="form-select border-start-0 ps-0 @error('assigned_to') is-invalid @enderror">
                                        <option value="">-- Select Rider (optional) --</option>
                                        @isset($riders)
                                            @foreach($riders as $rider)
                                                <option value="{{ $rider->id }}" {{ old('assigned_to') == $rider->id ? 'selected' : '' }}>
                                                    {{ $rider->name }} @if(isset($rider->active_deliveries)) ({{ $rider->active_deliveries }} active) @endif
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                @error('assigned_to')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Additional Notes</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-chat-text text-muted"></i>
                            </span>
                            <textarea name="notes"
                                      class="form-control border-start-0 ps-0 @error('notes') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Any special instructions for the rider?">{{ old('notes') }}</textarea>
                        </div>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-rounded px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-light btn-rounded px-4">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-rounded px-4">
                                <i class="bi bi-check-circle me-1"></i> Create Order
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
                        <strong class="d-block mb-1">Quick Tips</strong>
                        <ul class="mb-0 ps-3 small">
                            <li>Double-check the recipient's contact information for successful delivery</li>
                            <li>Provide clear addresses with landmarks if possible</li>
                            <li>You can assign a rider now or do it later from the order details page</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Scripts -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('orderForm');
        const costInput = document.querySelector('input[name="cost"]');

        // Auto-format cost input to 2 decimal places
        if (costInput) {
            costInput.addEventListener('blur', function() {
                if (this.value) {
                    let value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                }
            });
        }

        // Add real-time validation feedback
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                    const feedback = this.parentElement?.querySelector('.invalid-feedback');
                    if (feedback) feedback.style.display = 'none';
                }
            });
        });

        // Progress indicator update based on filled fields
        function updateProgress() {
            const fields = {
                recipient_name: false,
                pickup_address: false,
                delivery_address: false
            };

            let filled = 0;
            for (let field in fields) {
                const input = form.querySelector(`[name="${field}"]`);
                if (input && input.value.trim() !== '') {
                    filled++;
                }
            }

            const percentage = (filled / 3) * 100;
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = `${percentage}%`;
            }
        }

        // Update progress on field changes
        const requiredFields = ['recipient_name', 'pickup_address', 'delivery_address'];
        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('input', updateProgress);
            }
        });

        updateProgress();
    });
</script>
@endpush

<style>
    /* Additional styles for the create form */
    .card-glass {
        background: white;
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
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

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .card-glass {
            padding: 1.25rem !important;
        }

        .btn-rounded {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .progress-indicator {
            font-size: 0.75rem;
        }

        .form-label {
            font-size: 0.875rem;
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

    /* Custom checkbox/radio styles if needed */
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>
@endsection
