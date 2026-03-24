{{-- resources/views/auth/confirm-password.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AniqueLogistics') }} - Confirm Password</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            pointer-events: none;
        }

        @keyframes moveBackground {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Floating Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.3), rgba(255,255,255,0));
            pointer-events: none;
            animation: float 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
            animation-delay: 2s;
        }

        .orb-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
            }
            50% {
                transform: translateY(-20px) translateX(20px);
            }
        }

        /* Confirm Card */
        .confirm-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .confirm-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            padding: 2rem 2rem 1rem 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .logo-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .logo-text {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.25rem;
        }

        .logo-tagline {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Form Section */
        .form-section {
            padding: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .security-notice {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: none;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
        }

        .security-notice i {
            font-size: 1.25rem;
            color: #d97706;
            margin-top: 0.125rem;
        }

        .security-notice-content {
            flex: 1;
        }

        .security-notice-title {
            font-weight: 700;
            color: #92400e;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .security-notice-text {
            font-size: 0.875rem;
            color: #b45309;
            line-height: 1.4;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input Groups */
        .input-group-custom {
            margin-bottom: 1.5rem;
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
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-field {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background: white;
        }

        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-field:focus + .input-icon {
            color: #667eea;
        }

        .input-error {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.5rem;
            display: block;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Confirm Button */
        .confirm-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 1rem;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .confirm-btn:active {
            transform: translateY(0);
        }

        /* Back to Dashboard Link */
        .dashboard-link {
            text-align: center;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .dashboard-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .dashboard-link a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .confirm-card {
                max-width: 100%;
            }

            .logo-section {
                padding: 1.5rem 1.5rem 0.75rem 1.5rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
            }

            .logo-icon i {
                font-size: 2rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .form-title {
                font-size: 1.25rem;
            }

            .security-notice {
                padding: 0.875rem;
            }

            .security-notice i {
                font-size: 1rem;
            }

            .security-notice-text {
                font-size: 0.8125rem;
            }

            .input-field {
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                font-size: 0.875rem;
            }
        }

        /* Animation */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confirm-card {
            animation: slideUp 0.5s ease-out;
        }

        /* Loading state */
        .confirm-btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .confirm-btn .spinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .confirm-btn.loading .spinner {
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Password strength indicator (optional) */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.7rem;
        }

        /* Focus visible */
        .input-field:focus-visible {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="confirm-card">
                    <!-- Logo Section -->
                    <div class="logo-section">
                        <div class="logo-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h1 class="logo-text">Secure Area</h1>
                        <p class="logo-tagline">Additional security verification</p>
                    </div>

                    <!-- Form Section -->
                    <div class="form-section">
                        <h2 class="form-title">Confirm Password</h2>

                        <div class="security-notice">
                            <i class="bi bi-shield-exclamation"></i>
                            <div class="security-notice-content">
                                <div class="security-notice-title">Security Verification Required</div>
                                <div class="security-notice-text">
                                    This is a secure area of the application. Please confirm your password before continuing.
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm">
                            @csrf

                            <!-- Password -->
                            <div class="input-group-custom">
                                <label for="password" class="input-label">Your Password</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="input-field @error('password') is-invalid @enderror"
                                           required
                                           autocomplete="current-password"
                                           placeholder="Enter your password">
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                    @error('password')
                                        <span class="input-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="password-strength text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Your password is required to access this secure area</span>
                                </div>
                            </div>

                            <!-- Confirm Button -->
                            <button type="submit" class="confirm-btn" id="confirmBtn">
                                <span class="spinner"></span>
                                <i class="bi bi-check-circle"></i>
                                <span>Confirm Password</span>
                            </button>

                            <!-- Back to Dashboard Link -->
                            <div class="dashboard-link">
                                <a href="{{ route('dashboard') }}">
                                    <i class="bi bi-arrow-left"></i>
                                    Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }

        // Form submission with loading state
        const confirmForm = document.getElementById('confirmForm');
        const confirmBtn = document.getElementById('confirmBtn');

        if (confirmForm) {
            confirmForm.addEventListener('submit', function(e) {
                confirmBtn.classList.add('loading');
                confirmBtn.disabled = true;
            });
        }

        // Input field focus effects
        const inputFields = document.querySelectorAll('.input-field');
        inputFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            field.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Auto-focus on password field
        const passwordField = document.getElementById('password');
        setTimeout(() => {
            if (passwordField) {
                passwordField.focus();
            }
        }, 100);

        // Handle Enter key submission
        passwordField?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                confirmForm?.submit();
            }
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Session timeout warning (optional)
        let sessionTimeout;
        function resetSessionTimer() {
            if (sessionTimeout) clearTimeout(sessionTimeout);
            sessionTimeout = setTimeout(() => {
                // Optional: Show a warning before session expires
                console.log('Session timeout warning');
            }, 5 * 60 * 1000); // 5 minutes warning
        }

        // Reset timer on user activity
        document.addEventListener('keypress', resetSessionTimer);
        document.addEventListener('click', resetSessionTimer);
        resetSessionTimer();

        // Add keyboard shortcut hint (optional)
        const addShortcutHint = () => {
            const hint = document.createElement('div');
            hint.style.cssText = `
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #e5e7eb;
                font-size: 0.7rem;
                color: #9ca3af;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            `;
            hint.innerHTML = `
                <i class="bi bi-keyboard"></i>
                <span>Press Enter to confirm</span>
            `;
            document.querySelector('.dashboard-link').after(hint);
        };

        addShortcutHint();
    </script>
</body>
</html>
