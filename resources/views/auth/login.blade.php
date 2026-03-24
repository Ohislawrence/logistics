{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AniqueLogistics') }} - Login</title>

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

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .login-card:hover {
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

        .form-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
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

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-wrapper input {
            width: 1.1rem;
            height: 1.1rem;
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-wrapper span {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
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
            margin-bottom: 1.5rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider span {
            margin: 0 1rem;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        /* Session Status Alert */
        .session-status {
            background: #d1fae5;
            border: 1px solid #34d399;
            color: #065f46;
            padding: 0.875rem 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .session-status i {
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .login-card {
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

        .login-card {
            animation: slideUp 0.5s ease-out;
        }

        /* Loading state */
        .login-btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .login-btn .spinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .login-btn.loading .spinner {
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
                <div class="login-card">
                    <!-- Logo Section -->
                    <div class="logo-section">
                        <div class="logo-icon">
                            <i class="bi bi-capsule"></i>
                        </div>
                        <h1 class="logo-text">AniqueLogistics</h1>
                        <p class="logo-tagline">Fast & Reliable Drug Delivery</p>
                    </div>

                    <!-- Form Section -->
                    <div class="form-section">
                        <h2 class="form-title">Welcome Back!</h2>
                        <p class="form-subtitle">Sign in to access your account</p>

                        <!-- Session Status -->
                        @if(session('status'))
                            <div class="session-status">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Email Address -->
                            <div class="input-group-custom">
                                <label for="email" class="input-label">Email Address</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="input-field @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus
                                           autocomplete="username"
                                           placeholder="you@example.com">
                                    @error('email')
                                        <span class="input-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="input-group-custom">
                                <label for="password" class="input-label">Password</label>
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
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="form-options">
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" name="remember" id="remember_me">
                                    <span>Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-link">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="login-btn" id="loginBtn">
                                <span class="spinner"></span>
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Sign In</span>
                            </button>

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
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
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

        // Auto-fill detection for better UX
        if (document.getElementById('email').value || document.getElementById('password').value) {
            // Optional: Add any auto-fill detection logic
        }

        // Demo credentials hint (for testing purposes - remove in production)
        // You can add a small helper text for testing
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');

        // Optional: Add demo credentials hint (remove in production)
        const addDemoHint = () => {
            const hint = document.createElement('div');
            hint.className = 'demo-hint';
            hint.style.cssText = `
                margin-top: 0.5rem;
                font-size: 0.75rem;
                color: #9ca3af;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            `;
            hint.innerHTML = `
                <i class="bi bi-info-circle"></i>
                <span>Demo: admin@aniquelogistics.com / password</span>
            `;
            document.querySelector('.register-link').after(hint);
        };

        // Uncomment for demo purposes
        // addDemoHint();
    </script>
</body>
</html>
