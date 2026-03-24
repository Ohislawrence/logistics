@extends('layouts.app')

@section('title', 'AniqueLogistics | Precision Drug Delivery')

@section('content')
<div class="hero-wrapper position-relative overflow-hidden">
    <!-- Soft organic background shapes -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-85 py-5 py-lg-0">

            <!-- Left Content -->
            <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                <div class="hero-content" data-aos="fade-up">
                    <!-- Human-centered headline -->
                    <h1 class="display-4 fw-bold mb-4 text-dark leading-tight">
                        Delivering Hope,
                        <span class="text-gradient">One Package</span>
                        at a Time.
                    </h1>

                    <p class="lead text-secondary mb-4 fs-5 lh-relaxed">
                        Behind every temperature-controlled shipment is a patient waiting.
                        We bridge the gap between life-saving medications and the people who need them most.
                    </p>

                    <!-- CTA Buttons with warmth -->
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 shadow-soft">
                            <i class="bi bi-heart-pulse me-2"></i> Partner Portal
                        </a>
                        <a href="{{ url('track-order') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Track a Delivery
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side - Tracking Card -->
            <div class="col-lg-5 offset-lg-1" id="track">
                <div class="tracking-card-wrapper" data-aos="fade-left" data-aos-delay="200">
                    <div class="card tracking-card border-0 shadow-xl">
                        <!-- Card header with live indicator -->
                        <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="h5 fw-bold mb-1">Track Your Shipment</h3>
                                    <p class="small text-muted mb-0">Real-time location & temperature</p>
                                </div>
                                <div class="live-badge">
                                    <span class="live-dot"></span> LIVE
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">

                            <form action="{{ route('track.order.post') }}" method="POST" class="tracking-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-uppercase text-muted mb-2">
                                        Tracking ID
                                    </label>
                                    <div class="input-group input-group-lg input-soft">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="bi bi-upc-scan text-primary"></i>
                                        </span>
                                             <input type="text"
                                                 name="tracking_id"
                                                 class="form-control bg-light border-0"
                                                 placeholder="e.g., ANQ-78432-PHX"
                                                 required
                                                 id="trackingInput">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark btn-lg w-100 py-3 fw-semibold tracking-btn">
                                    <span class="btn-text">Track Order</span>
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('track.order') }}" class="small text-muted">Or use the full tracking page</a>
                            </div>




                            <div class="mt-4 pt-3 border-top">
                                <p class="small text-muted mb-0 text-center">
                                    <i class="bi bi-headset me-1"></i>
                                    Need help? <a href="#" class="text-primary fw-semibold text-decoration-none">Talk to our team</a>
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trust Section -->
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card p-4 h-100">
                <div class="feature-icon mb-3">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 class="h6 fw-bold mb-2">Patient Safety First</h4>
                <p class="small text-muted mb-0">Every protocol designed with the end patient in mind. Zero compromises on safety.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 h-100">
                <div class="feature-icon mb-3">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h4 class="h6 fw-bold mb-2">24/7 Human Support</h4>
                <p class="small text-muted mb-0">Real people answering your calls, not bots. Because emergencies don't wait.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 h-100">
                <div class="feature-icon mb-3">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h4 class="h6 fw-bold mb-2">Transparent Tracking</h4>
                <p class="small text-muted mb-0">See exactly where your shipment is, with temperature logs updated every 30 seconds.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Organic Design System */
    :root {
        --primary: #2563eb;
        --primary-soft: #dbeafe;
        --primary-dark: #1d4ed8;
        --secondary: #64748b;
        --accent: #0ea5e9;
        --warm: #f59e0b;
        --success: #10b981;
        --surface: #f8fafc;
        --text: #1e293b;
        --text-muted: #64748b;
    }

    /* Soft Background Blobs */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.4;
        z-index: 1;
    }
    .blob-1 {
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        top: -200px;
        left: -200px;
        animation: float 20s infinite ease-in-out;
    }
    .blob-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        bottom: -100px;
        right: -100px;
        animation: float 25s infinite ease-in-out reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* Typography & Spacing */
    .leading-tight { line-height: 1.2; }
    .lh-relaxed { line-height: 1.7; }
    .min-vh-85 { min-height: 85vh; }

    /* Badge with Pulse */
    .badge-wrapper {
        display: inline-block;
    }
    .badge-medical {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid rgba(37, 99, 235, 0.2);
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        background: var(--success);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    /* Gradient Text */
    .text-gradient {
        background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 50%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Impact Stats */
    .impact-stats {
        border-left: 3px solid var(--primary-soft);
        padding-left: 1.5rem;
    }
    .stat-item {
        text-align: left;
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
    }
    .stat-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 4px;
    }

    /* Trust Pill */
    .trust-pill {
        transition: transform 0.3s ease;
    }
    .trust-pill:hover {
        transform: translateY(-2px);
    }
    .avatar-group {
        display: flex;
        padding-left: 8px;
    }
    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 3px solid white;
        margin-left: -12px;
        object-fit: cover;
        transition: transform 0.2s;
    }
    .avatar:hover {
        transform: scale(1.1);
        z-index: 2;
    }

    /* Buttons */
    .shadow-soft {
        box-shadow: 0 10px 40px -10px rgba(37, 99, 235, 0.3);
        transition: all 0.3s ease;
    }
    .shadow-soft:hover {
        box-shadow: 0 20px 60px -15px rgba(37, 99, 235, 0.4);
        transform: translateY(-2px);
    }
    .btn-outline-secondary {
        border-color: #e2e8f0;
        color: var(--text);
    }
    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: var(--text);
    }

    /* Tracking Card */
    .tracking-card-wrapper {
        position: relative;
    }
    .tracking-card {
        border-radius: 24px;
        background: white;
        position: relative;
        overflow: hidden;
    }
    .shadow-xl {
        box-shadow: 0 25px 80px -20px rgba(0, 0, 0, 0.15);
    }
    .live-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--success);
        background: rgba(16, 185, 129, 0.1);
        padding: 4px 10px;
        border-radius: 50px;
    }
    .live-dot {
        width: 6px;
        height: 6px;
        background: var(--success);
        border-radius: 50%;
        animation: blink 1.5s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Tracker Visual */
    .tracker-visual {
        padding: 20px 0;
    }
    .tracker-line {
        position: relative;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        margin: 30px 0;
    }
    .progress-line {
        position: absolute;
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        border-radius: 2px;
        transition: width 1s ease;
    }
    .checkpoint {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: white;
        border: 3px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .checkpoint.active {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-soft);
    }
    .checkpoint.current {
        border-color: var(--accent);
        color: white;
        background: var(--accent);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2);
        animation: pulse-ring 2s infinite;
    }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2); }
        50% { box-shadow: 0 0 0 8px rgba(14, 165, 233, 0); }
        100% { box-shadow: 0 0 0 4px rgba(14, 165, 233, 0); }
    }
    .checkpoint-label {
        position: absolute;
        top: 45px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        white-space: nowrap;
    }
    .checkpoint.current .checkpoint-label {
        color: var(--accent);
    }

    /* Form Styling */
    .input-soft {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .input-soft:focus-within {
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    .form-control:focus {
        box-shadow: none;
        background: white !important;
    }

    /* Temperature Indicator */
    .bg-info-soft {
        background: rgba(14, 165, 233, 0.08);
    }
    .temp-indicator {
        border: 1px solid rgba(14, 165, 233, 0.2);
    }

    /* Tracking Button */
    .tracking-btn {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .tracking-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -10px rgba(30, 41, 59, 0.5);
    }
    .tracking-btn:active {
        transform: translateY(0);
    }

    /* Support Float Card */
    .support-float {
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 280px;
        animation: float-support 6s ease-in-out infinite;
    }
    @keyframes float-support {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .support-avatar {
        position: relative;
        width: 48px;
        height: 48px;
    }
    .support-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: var(--success);
        border: 2px solid white;
        border-radius: 50%;
    }

    /* Feature Cards */
    .feature-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }
    .feature-card:hover {
        border-color: var(--primary-soft);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }
    .feature-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-soft);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .support-float {
            display: none;
        }
        .impact-stats {
            border-left: none;
            padding-left: 0;
            gap: 2rem;
        }
        .min-vh-85 {
            min-height: auto;
            padding-top: 2rem;
        }
    }
</style>

<!-- AOS Animation Library (optional, for smooth entrance) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });
</script>
@endsection
