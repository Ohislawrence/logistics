{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.description', 'Fast, reliable drug delivery at your doorstep.'))">

    <title>@yield('title', config('app.name', 'MediSwift'))</title>

    <!-- Preconnect for external resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Fonts: Inter + SF Pro inspired -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons (for crisp icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS - optimized -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Vite Assets (custom CSS/JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')

    <style>
        /* Custom design system - modern, rounded, glassmorphism accents */
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary: #6c757d;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-800: #343a40;
            --border-radius-card: 1.5rem;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 1rem 2rem rgba(0, 0, 0, 0.08);
            --transition-base: all 0.25s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* Modern navbar (glass/light) */
        .navbar-modern {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-link-custom {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            color: #4b5563;
            transition: var(--transition-base);
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: var(--primary);
            color: white;
        }

        /* Avatar & dropdown */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary-dark);
            transition: var(--transition-base);
        }

        .dropdown-menu-modern {
            border: none;
            border-radius: 1.25rem;
            box-shadow: var(--shadow-lg);
            padding: 0.75rem;
            margin-top: 0.75rem;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .dropdown-item-modern {
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-weight: 500;
            transition: var(--transition-base);
        }

        .dropdown-item-modern:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        /* Cards / main container */
        .main-content {
            min-height: 80vh;
            padding: 2rem 0;
        }

        .card-glass {
            background: white;
            border: none;
            border-radius: var(--border-radius-card);
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
        }

        .card-glass:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* Alert styling - pill style */
        .alert-modern {
            border: none;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            font-weight: 500;
            backdrop-filter: blur(8px);
            box-shadow: var(--shadow-sm);
        }

        /* Footer */
        .footer-modern {
            background: white;
            border-top: 1px solid var(--gray-200);
            padding: 1.5rem 0;
            margin-top: 3rem;
        }

        /* Mobile first enhancements */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0;
            }
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .logo-text {
                font-size: 1.35rem;
            }
            .nav-link-custom {
                padding: 0.4rem 0.9rem;
                font-size: 0.9rem;
            }
        }

        /* Utility */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        .text-primary-gradient {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .btn-rounded {
            border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
        }
        .btn-outline-primary-custom {
            border: 1.5px solid var(--primary);
            background: transparent;
            color: var(--primary);
            border-radius: 2rem;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            transition: var(--transition-base);
        }
        .btn-outline-primary-custom:hover {
            background: var(--primary);
            color: white;
        }
    </style>
</head>
<body class="antialiased">

    <div class="d-flex flex-column min-vh-100">
        <!-- Modern Navigation -->
        @include('layouts.navigation')

        <!-- Flash Messages - Modern Dismissible -->
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-modern alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-modern alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-modern alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-diamond-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('warning') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-modern alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('info') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-bug-fill me-2 fs-5 mt-1"></i>
                        <div>
                            <strong class="d-block mb-1">Validation Error</strong>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Page Header (optional, modernized) -->
        @hasSection('header')
            <header class="bg-white border-bottom border-light py-4 mb-2">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        @yield('header')
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Footer - Modern minimal -->
        @hasSection('footer')
            <footer class="footer-modern mt-auto">
                <div class="container">
                    @yield('footer')
                </div>
            </footer>
        @else
            <footer class="footer-modern mt-auto">
                <div class="container text-center">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <span class="text-muted small">&copy; {{ date('Y') }} {{ config('app.name', 'MediSwift') }}. All rights reserved.</span>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-muted text-decoration-none small">Privacy</a>
                            <a href="#" class="text-muted text-decoration-none small">Terms</a>
                            <a href="#" class="text-muted text-decoration-none small">Support</a>
                        </div>
                    </div>
                </div>
            </footer>
        @endif
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Auto-dismiss flash messages after 5 seconds with smooth close -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts after 5 secs
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    let bsAlert = bootstrap.Alert.getInstance(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    } else {
                        // fallback
                        alert.style.transition = 'opacity 0.3s';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }
                });
            }, 5000);

            // Add touch-friendly dropdown close for mobile
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    const menu = this.nextElementSibling;
                    if (menu && window.innerWidth < 768) {
                        e.stopPropagation();
                    }
                });
            });
        });
    </script>
</body>
</html>
