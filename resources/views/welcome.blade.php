<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perangkat Ajar SMK 2026 - Kurikulum Merdeka (Deep Learning)</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Favicon -->
    @if(app_favicon_url())
        <link rel="icon" href="{{ app_favicon_url() }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%232563eb'><path d='M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z'/></svg>">
    @endif
    
    <!-- Open Graph & SEO Meta Tags -->
    @include('layouts.partials.og-meta')
    
    @php
        $themeColors = app_theme_colors();
    @endphp
    <style>
        :root {
            --kemendikdasmen-navy: #0b3b60;
            --kemendikdasmen-navy-dark: #071a2e;
            --kemendikdasmen-gold: #f59e0b;
            --kemendikdasmen-gold-light: #fbbf24;
            --primary-glow: #0b3b60;
            --accent-cyan: #38bdf8;
            --accent-indigo: #6366f1;
            --accent-amber: #f59e0b;
            --card-glass: rgba(11, 45, 82, 0.88);
            --card-border: rgba(56, 189, 248, 0.28);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #06182c;
            background-image: 
                radial-gradient(circle at 10% 12%, rgba(11, 59, 96, 0.5) 0%, transparent 45%),
                radial-gradient(circle at 90% 25%, rgba(13, 71, 161, 0.4) 0%, transparent 45%),
                radial-gradient(circle at 50% 60%, rgba(2, 132, 199, 0.2) 0%, transparent 55%),
                linear-gradient(135deg, #030d18 0%, #071e36 50%, #0b2d52 100%);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient glowing background orbs */
        .ambient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.5;
        }
        .ambient-orb-1 {
            top: 5%;
            left: 5%;
            width: 450px;
            height: 450px;
            background: rgba(11, 59, 96, 0.45);
        }
        .ambient-orb-2 {
            top: 35%;
            right: 5%;
            width: 500px;
            height: 500px;
            background: rgba(13, 71, 161, 0.35);
        }
        .ambient-orb-3 {
            bottom: 10%;
            left: 20%;
            width: 550px;
            height: 550px;
            background: rgba(2, 132, 199, 0.25);
        }

        /* Navbar - Signature Kemendikdasmen Navy (#0b3b60) with Gold Accent Stripe (#f59e0b) */
        .landing-nav {
            background: #0b3b60;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 3.5px solid #f59e0b;
            position: sticky;
            top: 0;
            z-index: 1050;
            padding: 12px 0;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
        }

        .brand-logo-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0b3b60 0%, #1d4ed8 100%);
            border: 1.5px solid #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.35);
            flex-shrink: 0;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--card-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.6);
            box-shadow: 0 25px 50px -10px rgba(0, 0, 0, 0.7), 0 0 30px rgba(11, 59, 96, 0.4);
        }

        /* High Contrast Overrides to eliminate unreadable faint text */
        .text-white-50 {
            color: #e2e8f0 !important;
        }
        .text-muted, .text-secondary {
            color: #cbd5e1 !important;
        }

        /* Hero Badges & Texts */
        .badge-regulasi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0b3b60;
            border: 1.5px solid #f59e0b;
            border-radius: 40px;
            padding: 7px 18px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #ffffff !important;
            box-shadow: 0 0 22px rgba(245, 158, 11, 0.3);
            max-width: 100%;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: -1px;
            color: #ffffff;
            text-shadow: 0 4px 24px rgba(0, 0, 0, 0.7);
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #38bdf8 45%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.12rem;
            line-height: 1.7;
            color: #f8fafc !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
            max-width: 760px;
        }

        /* Buttons */
        .btn-glow-primary {
            background: linear-gradient(135deg, #0b3b60 0%, #1d4ed8 50%, #2563eb 100%);
            color: #ffffff !important;
            border: 1px solid rgba(56, 189, 248, 0.4);
            padding: 13px 26px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 25px rgba(11, 59, 96, 0.5);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(29, 78, 216, 0.7);
            background: linear-gradient(135deg, #082842 0%, #1e40af 50%, #1d4ed8 100%);
            border-color: #38bdf8;
        }

        .btn-glow-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: #07192d !important;
            border: 1.5px solid #fde047;
            padding: 13px 26px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.95rem;
            box-shadow: 0 4px 25px rgba(245, 158, 11, 0.5);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.75);
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .btn-glass-outline {
            background: rgba(11, 45, 82, 0.75);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            color: #ffffff !important;
            padding: 13px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glass-outline:hover {
            background: rgba(56, 189, 248, 0.2);
            border-color: var(--accent-cyan);
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        /* Feature Icon Box */
        .feature-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }

        /* Photo Cards with Glass Overlays */
        .photo-card {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            transition: all 0.3s ease;
            background: #07192d;
        }
        .photo-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.6);
            box-shadow: 0 25px 50px rgba(0,0,0,0.8), 0 0 30px rgba(11, 59, 96, 0.5);
        }
        .photo-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .photo-card:hover img {
            transform: scale(1.05);
        }
        .photo-overlay {
            background: linear-gradient(180deg, rgba(7, 25, 45, 0.1) 0%, rgba(6, 21, 38, 0.98) 72%);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
        }
        .photo-overlay p {
            color: #e2e8f0 !important;
        }

        /* 3M Deep Learning Pillar Cards */
        .pillar-card {
            border-left: 4px solid;
            background: rgba(11, 45, 82, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 16px;
            padding: 22px;
            height: 100%;
            transition: transform 0.3s ease;
        }
        .pillar-card:hover {
            transform: translateY(-3px);
            border-color: rgba(56, 189, 248, 0.5);
        }
        .pillar-card p {
            color: #e2e8f0 !important;
        }
        .pillar-mindful { border-left-color: #38bdf8; }
        .pillar-meaningful { border-left-color: #fbbf24; }
        .pillar-joyful { border-left-color: #34d399; }

        /* Document Badge Tag - High Contrast Kemendikdasmen Blue */
        .doc-tag {
            background: #0b3b60;
            border: 1.5px solid rgba(56, 189, 248, 0.45);
            border-radius: 9999px;
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35);
        }

        /* Creator Showcase Box - Kemendikdasmen Gold & Navy */
        .creator-box {
            background: linear-gradient(135deg, rgba(11, 59, 96, 0.9) 0%, rgba(7, 26, 48, 0.96) 100%);
            border: 2px solid #f59e0b;
            border-radius: 24px;
            box-shadow: 0 0 40px rgba(245, 158, 11, 0.25);
        }

        /* Grand Showcase Mockup */
        .mockup-container {
            border-radius: 24px;
            border: 1.5px solid rgba(56, 189, 248, 0.35);
            background: #07192d;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.7), 0 0 50px rgba(11, 59, 96, 0.4);
            overflow: hidden;
        }
        .mockup-header {
            background: #0b3b60;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1.5px solid rgba(255, 255, 255, 0.15);
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        /* Floating Badge HUD on Photo */
        .floating-hud {
            position: absolute;
            background: rgba(11, 45, 82, 0.95);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1.5px solid rgba(56, 189, 248, 0.5);
            border-radius: 14px;
            padding: 10px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            font-size: 0.8rem;
            color: #ffffff;
            z-index: 3;
        }

        /* Comparison Cards High Contrast Rules */
        .compare-box-expert {
            background: rgba(6, 78, 59, 0.35) !important;
            border: 1.5px solid rgba(52, 211, 153, 0.55) !important;
        }
        .compare-box-expert p {
            color: #f0fdf4 !important;
        }
        .compare-box-ai {
            background: rgba(127, 29, 29, 0.35) !important;
            border: 1.5px solid rgba(248, 113, 113, 0.45) !important;
        }
        .compare-box-ai p {
            color: #fef2f2 !important;
        }

        /* Responsive Mobile Specific */
        @media (max-width: 767.98px) {
            .landing-nav {
                padding: 10px 0;
            }
            .brand-logo-badge {
                width: 34px;
                height: 34px;
            }
            .brand-title {
                font-size: 0.88rem !important;
            }
            .hero-title {
                font-size: 1.7rem !important;
                line-height: 1.24;
            }
            .hero-subtitle {
                font-size: 0.92rem !important;
                line-height: 1.6;
            }
            .btn-glow-primary, .btn-glow-gold, .btn-glass-outline {
                width: 100%;
                padding: 11px 16px;
                font-size: 0.86rem;
            }
            .badge-regulasi {
                font-size: 0.72rem;
                padding: 6px 12px;
                line-height: 1.4;
            }
            .glass-card {
                border-radius: 16px;
                padding: 16px !important;
            }
            .photo-card img {
                height: 180px;
            }
            .floating-hud {
                display: none !important;
            }
            .creator-box {
                padding: 20px 14px !important;
            }
        }

        /* High contrast footer links & readability */
        .footer-legal-link {
            color: #cbd5e1 !important;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-legal-link:hover {
            color: #38bdf8 !important;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Orbs -->
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>
    <div class="ambient-orb ambient-orb-3"></div>

    <!-- NAVIGATION BAR -->
    <nav class="landing-nav">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 gap-sm-3 text-decoration-none">
                @if(app_logo_url())
                    <img src="{{ app_logo_url() }}" alt="{{ app_setting('app_name') }}" style="max-height: 42px; max-width: 140px; object-fit: contain;">
                @else
                    <div class="brand-logo-badge">
                        <i class="bi bi-journal-bookmark-fill text-white fs-5"></i>
                    </div>
                @endif
                <div>
                    <div class="fw-bold text-white fs-6 mb-0 d-flex align-items-center gap-1.5 brand-title">
                        <span>{{ app_setting('app_name', 'Sistem Perangkat Ajar') }}</span>
                        <span class="badge bg-primary bg-opacity-25 border border-primary border-opacity-50 text-info px-1.5 py-0.5" style="font-size: 0.65rem;">SMK 2026</span>
                    </div>
                    <div class="text-white-50 small d-none d-sm-block" style="font-size: 0.72rem;">{{ app_setting('app_tagline', 'Kurikulum Merdeka • Deep Learning 2026') }}</div>
                </div>
            </a>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-1.5 gap-sm-2">
                <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-2.5 px-sm-3 py-1.5 d-none d-lg-inline-flex align-items-center gap-1.5" onclick="openWelcomePopup('panduan')" style="font-size: 0.8rem;">
                    <i class="bi bi-stars text-warning"></i>
                    <span>Panduan & Saran</span>
                </button>
                <a href="{{ route('creator.profile') }}" class="btn btn-sm btn-outline-light border-opacity-25 rounded-pill px-2.5 px-sm-3 py-1.5 d-none d-xl-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                    <i class="bi bi-person-badge text-info"></i>
                    <span>Profil Pembuat</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-glow-primary px-3 py-1.5" style="font-size: 0.82rem;">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-warning fw-bold px-2.5 py-1.5 rounded-pill d-none d-md-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.8rem;">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Coba Gratis 2x</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light border-opacity-25 rounded-pill px-2.5 px-sm-3 py-1.5" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-2.5 px-sm-3 py-1.5 shadow-sm" style="font-size: 0.8rem;">
                        <i class="bi bi-person-plus-fill me-1"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="py-4 py-md-5 py-lg-6 position-relative z-1">
        <div class="container text-center">
            
            <!-- REGULATION PILL BADGE -->
            <div class="mb-3 mb-md-4">
                <span class="badge-regulasi">
                    <i class="bi bi-patch-check-fill text-warning fs-6"></i>
                    <span>{{ app_setting('landing_hero_badge', 'Standar Resmi Kurikulum Merdeka 2026 • BSKAP 046/H/KR/2025 • Permendikdasmen 13/2025') }}</span>
                </span>
            </div>

            <!-- MAIN HERO TITLE -->
            <h1 class="hero-title mb-3">
                {!! nl2br(e(app_setting('landing_hero_title', 'Revolusi Penyusunan Perangkat Ajar SMK 2026 Berbasis Deep Learning'))) !!}
            </h1>

            <!-- HERO SUBTITLE -->
            <p class="hero-subtitle mx-auto mb-4">
                {{ app_setting('landing_hero_subtitle', 'Platform cerdas generasi baru Tahun 2026 untuk otomatisasi penyusunan TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes, hingga Asesmen lengkap dengan Kop Surat Kedinasan Sekolah.') }}
            </p>

            <!-- CALL TO ACTIONS -->
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2.5 gap-sm-3 mb-4 mb-md-5">
                <a href="{{ route('generator.index') }}" class="btn-glow-gold">
                    <i class="bi bi-lightning-charge-fill fs-5"></i>
                    <span>{{ app_setting('landing_hero_cta_primary', 'Coba Generator Gratis (Maks. 2x)') }}</span>
                </a>
                <a href="{{ route('login') }}" class="btn-glow-primary">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk ke Akun</span>
                </a>
                <a href="{{ route('register') }}" class="btn-glass-outline">
                    <i class="bi bi-person-plus-fill fs-5"></i>
                    <span>Daftar Akun Guru</span>
                </a>
            </div>

            <!-- QUICK PILL METRICS -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4 mb-lg-5">
                <span class="doc-tag" style="border-color: #f59e0b; background: rgba(245, 158, 11, 0.22); color: #ffffff !important;">
                    <i class="bi bi-shield-check text-warning"></i> 100% Sistem Pakar Murni (Tanpa API Key &bull; Nol Halusinasi)
                </span>
                <span class="doc-tag"><i class="bi bi-patch-check-fill text-warning"></i> Basis Database Resmi BSKAP 046/2025</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> 8 Dimensi Profil Lulusan (DPL) 2026</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Sintaks PEDATTI Terintegrasi</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Pilar 3M (Mindful, Meaningful, Joyful)</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Ekspor PDF & Word Ber-Kop Resmi</span>
            </div>

            <!-- HERO VISUAL SHOWCASE MOCKUP (WITH REAL HD TECH PHOTO) -->
            <div class="row justify-content-center">
                <div class="col-lg-10 position-relative">
                    
                    <!-- Floating HUD Badges -->
                    <div class="floating-hud d-none d-md-flex align-items-center gap-2" style="top: -20px; left: 20px;">
                        <i class="bi bi-cpu-fill text-info fs-5"></i>
                        <div class="text-start">
                            <div class="fw-bold text-white">Sistem Pakar Edukasi</div>
                            <div style="font-size: 0.72rem; color: #bae6fd !important;">Murni Database &bull; Nol Halusinasi AI</div>
                        </div>
                    </div>

                    <div class="floating-hud d-none d-md-flex align-items-center gap-2" style="bottom: 25px; right: 20px;">
                        <i class="bi bi-patch-check-fill text-warning fs-5"></i>
                        <div class="text-start">
                            <div class="fw-bold text-white">Standar Regulasi BSKAP 2026</div>
                            <div style="font-size: 0.72rem; color: #fef08a !important;">Rujukan Resmi Kurikulum Merdeka</div>
                        </div>
                    </div>

                    <div class="mockup-container">
                        <div class="mockup-header">
                            <span class="dot dot-red"></span>
                            <span class="dot dot-yellow"></span>
                            <span class="dot dot-green"></span>
                            <span class="text-white-50 small ms-2" style="font-size: 0.72rem;">Sistem Perangkat Ajar SMK 2026 &bull; Kurikulum Merdeka (Deep Learning)</span>
                        </div>
                        <div class="position-relative" style="max-height: 480px; overflow: hidden;">
                            <!-- High Resolution Professional Photo of Modern Vocational & Tech Learning -->
                            <img src="{{ app_setting('landing_hero_image', 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1200&q=80') }}" 
                                 alt="Pembelajaran Vokasi Modern SMK 2026" 
                                 class="img-fluid w-100" 
                                 style="object-fit: cover; height: 380px; filter: brightness(0.92);">
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 p-md-4" style="background: linear-gradient(180deg, transparent 0%, rgba(5, 11, 24, 0.95) 90%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="text-start">
                                        <h5 class="fw-bold text-white mb-1"><i class="bi bi-shield-check text-primary me-1"></i> Workspace Perangkat Ajar Terintegrasi 2026</h5>
                                        <p class="text-white-50 small mb-0">Dirancang khusus untuk mempermudah guru SMK di era transformasi digital kejuruan.</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('generator.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1.5">
                                            <i class="bi bi-play-circle-fill me-1"></i> Mulai Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- SECTION: 3 PILAR DEEP LEARNING (3M) DENGAN FOTO EKSKLUSIF -->
    <section class="py-4 py-md-5 position-relative z-1">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill small fw-semibold mb-2">
                    FILOSOFI PEMBELAJARAN 2026
                </span>
                <h2 class="fw-bold text-white fs-2 mb-2">Pendekatan Pembelajaran Mendalam (Deep Learning)</h2>
                <p class="text-white-50 small" style="max-width: 620px; margin: 0 auto;">
                    Kurikulum Merdeka 2026 memprioritaskan kualitas pengalaman belajar siswa SMK melalui tiga pilar esensial (Mindful, Meaningful, dan Joyful).
                </p>
            </div>

            <div class="row g-4">
                <!-- PILAR 1: MINDFUL (WITH PHOTO) -->
                <div class="col-md-4">
                    <div class="photo-card h-100">
                        <img src="{{ app_setting('landing_pilar_mindful_img', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80') }}" 
                             alt="{{ app_setting('landing_pilar_mindful_title', 'Mindful') }}">
                        <div class="photo-overlay">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-info text-dark fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 1</span>
                                <h4 class="fw-bold text-white mb-0">{{ app_setting('landing_pilar_mindful_title', 'Mindful') }}</h4>
                            </div>
                            <div class="text-info fw-semibold small mb-2">{{ app_setting('landing_pilar_mindful_subtitle', 'Pembelajaran Berkesadaran') }}</div>
                            <p class="text-white-50 small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                                {{ app_setting('landing_pilar_mindful_desc', 'Menuntun peserta didik menyadari tujuan belajar, mengaitkan materi kejuruan dengan potensi diri, dan hadir secara penuh dalam setiap aktivitas vokasi.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- PILAR 2: MEANINGFUL (WITH PHOTO) -->
                <div class="col-md-4">
                    <div class="photo-card h-100">
                        <img src="{{ app_setting('landing_pilar_meaningful_img', 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80') }}" 
                             alt="{{ app_setting('landing_pilar_meaningful_title', 'Meaningful') }}">
                        <div class="photo-overlay">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 2</span>
                                <h4 class="fw-bold text-white mb-0">{{ app_setting('landing_pilar_meaningful_title', 'Meaningful') }}</h4>
                            </div>
                            <div class="text-warning fw-semibold small mb-2">{{ app_setting('landing_pilar_meaningful_subtitle', 'Pembelajaran Bermakna') }}</div>
                            <p class="text-white-50 small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                                {{ app_setting('landing_pilar_meaningful_desc', 'Menghubungkan setiap capaian pembelajaran dengan kebutuhan nyata Dunia Usaha & Industri (DUDI), proyek nyata, dan kesiapan kerja masa depan.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- PILAR 3: JOYFUL (WITH PHOTO) -->
                <div class="col-md-4">
                    <div class="photo-card h-100">
                        <img src="{{ app_setting('landing_pilar_joyful_img', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80') }}" 
                             alt="{{ app_setting('landing_pilar_joyful_title', 'Joyful') }}">
                        <div class="photo-overlay">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-success text-white fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 3</span>
                                <h4 class="fw-bold text-white mb-0">{{ app_setting('landing_pilar_joyful_title', 'Joyful') }}</h4>
                            </div>
                            <div class="text-success fw-semibold small mb-2">{{ app_setting('landing_pilar_joyful_subtitle', 'Pembelajaran Menggembirakan') }}</div>
                            <p class="text-white-50 small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                                {{ app_setting('landing_pilar_joyful_desc', 'Membangun atmosfer belajar kolaboratif yang menggembirakan, menumbuhkan rasa ingin tahu yang tinggi, dan antusiasme dalam bereksperimen karya kejuruan.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: SHOWCASE TEKNOLOGI & GURU SMK 2026 -->
    <section class="py-4 py-md-5 position-relative z-1">
        <div class="container">
            <div class="glass-card p-3 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <span class="badge bg-primary bg-opacity-20 text-info border border-primary border-opacity-30 px-3 py-1 rounded-pill small fw-bold mb-3">
                            <i class="bi bi-stars text-warning me-1"></i> INOVASI DIGITAL SMK 2026
                        </span>
                        <h2 class="fw-bold text-white mb-3 fs-2">
                            Penyusunan Perangkat Ajar Masa Kini yang Cepat, Akurat & Terstandar
                        </h2>
                        <p class="text-white-50 small mb-4 leading-relaxed">
                            Guru SMK kini tidak perlu lagi menghabiskan waktu berminggu-minggu menyusun berkas administrasi ajar. 
                            Dengan engine cerdas edisi <strong>2026</strong>, seluruh sintaks <strong>PEDATTI</strong> dan 
                            <strong>8 Dimensi Profil Lulusan</strong> diformulasikan secara sistematis dan langsung siap diekspor 
                            ke dokumen kedinasan resmi dengan kop surat sekolah.
                        </p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Hemat Waktu Hingga 95%</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Kop Surat & Logo Resmi</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Format PDF & Word Siap Cetak</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Mendukung Mapel AI & Koding</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('generator.index') }}" class="btn btn-glow-gold">
                                <i class="bi bi-lightning-charge-fill"></i> Coba Generator Sekarang
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-glass-outline">
                                <i class="bi bi-person-plus"></i> Daftar Akun Guru
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80" 
                                 alt="Guru dan Pembelajaran Modern SMK 2026" 
                                 class="img-fluid rounded-4 shadow-lg border border-white border-opacity-15 w-100" 
                                 style="max-height: 420px; object-fit: cover;">
                            
                            <div class="position-absolute bottom-0 start-0 m-3 p-3 rounded-3" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(56, 189, 248, 0.4); backdrop-filter: blur(8px);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-check-fill text-warning fs-4"></i>
                                    <div class="small">
                                        <div class="fw-bold text-white">Edisi Terbaru Tahun 2026</div>
                                        <div class="text-white-50" style="font-size: 0.72rem;">Sesuai Pedoman Kurikulum Merdeka</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: SISTEM PAKAR VS AI GENERATIF (STANDAR REGULASI RESMI KEMENDIKDASMEN 2026) -->
    <section class="py-4 py-md-5 position-relative z-1" id="keunggulan-sistem-pakar">
        <div class="container">
            <div class="p-4 p-md-5 rounded-4 shadow-lg border border-warning border-opacity-40 position-relative overflow-hidden" 
                 style="background: radial-gradient(circle at 10% 20%, rgba(11, 59, 96, 0.95) 0%, rgba(6, 26, 48, 0.98) 80%); backdrop-filter: blur(20px);">
                
                <!-- AMBIENT GLOW CORNER -->
                <div style="position: absolute; top: -80px; right: -80px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(245, 158, 11, 0.25) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>

                <div class="text-center mb-4 mb-md-5 position-relative z-1">
                    <div class="d-inline-flex align-items-center gap-2 badge bg-warning text-dark fw-bold px-3 py-1.5 rounded-pill mb-3 shadow-sm" style="font-size: 0.82rem;">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>STANDAR REGULASI RESMI KURIKULUM MERDEKA KEMENDIKDASMEN 2026</span>
                    </div>
                    <h2 class="fw-bold text-white fs-2 mb-2">
                        Mengapa Sistem Pakar Murni Jauh Lebih Unggul &amp; Aman Dibanding AI Generatif Biasa?
                    </h2>
                    <p class="text-white mx-auto small" style="max-width: 750px; line-height: 1.6; color: #f1f5f9 !important;">
                        Aplikasi ini dibangun dengan arsitektur <strong>Knowledge-Based Expert System (Sistem Pakar Berbasis Regulasi)</strong> dengan data rujukan tersimpan langsung di database internal. Murni tanpa ketergantungan API Key berbayar pihak ketiga, menjamin <strong>Nol Halusinasi</strong>, kedaulatan data pendidikan nasional, serta 100% bebas biaya bagi guru di seluruh pelosok Indonesia.
                    </p>
                </div>

                <!-- KOMPARASI 4 PILAR UTAMA -->
                <div class="row g-4 position-relative z-1">
                    
                    <!-- PILAR 1: AKURASI REGULASI -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4" style="background: rgba(11, 45, 82, 0.9); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2.5 rounded-3 bg-primary bg-opacity-25 text-info fs-4">
                                    <i class="bi bi-patch-check-fill text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-0">1. Akurasi Regulasi &amp; Nol Halusinasi</h5>
                                    <div class="small fw-semibold" style="color: #7dd3fc !important;">Kepastian hukum dan validitas dokumen ajar</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Database Resmi):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #f0fdf4 !important;">
                                    Menyerap Capaian Pembelajaran (CP) dan elemen kompetensi langsung dari database resmi <strong>BSKAP No. 046/H/KR/2025</strong> dan alokasi waktu <strong>Permendikdasmen No. 13/2025</strong>. Tidak ada risiko mengarang.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #fee2e2 !important;">
                                    Sering "berhalusinasi" mencampuradukkan kurikulum lama, memalsukan nomor SK BSKAP, dan menghitung jam pelajaran secara keliru.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 2: TANPA BIAYA API KEY -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4" style="background: rgba(11, 45, 82, 0.9); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2.5 rounded-3 bg-success bg-opacity-25 text-success fs-4">
                                    <i class="bi bi-wallet2 text-success"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-0">2. 100% Tanpa API Key &amp; Bebas Biaya Token</h5>
                                    <div class="small fw-semibold" style="color: #86efac !important;">Aksesibilitas inklusif untuk seluruh guru Indonesia</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Server Mandiri):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #f0fdf4 !important;">
                                    Berjalan deterministik tanpa memerlukan saldo kredit, token, atau API Key OpenAI/Claude. Seluruh guru SMK (termasuk di wilayah 3T) dapat menyusun modul ajar tanpa dipungut biaya token.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #fee2e2 !important;">
                                    Mengharuskan guru memiliki kartu kredit, berlangganan API Key berbayar dalam mata uang Dolar ($), dan aplikasi langsung macet saat kuota token habis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 3: KEDAULATAN DATA -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4" style="background: rgba(11, 45, 82, 0.9); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2.5 rounded-3 bg-info bg-opacity-25 text-info fs-4">
                                    <i class="bi bi-shield-lock-fill text-info"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-0">3. Kedaulatan &amp; Keamanan Data Satuan Pendidikan</h5>
                                    <div class="small fw-semibold" style="color: #7dd3fc !important;">Privasi data guru dan siswa terlindungi utuh</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Lokal &amp; Mandiri):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #f0fdf4 !important;">
                                    Semua data sekolah, identitas guru, NIP, dan rancangan ajar tersimpan privat di database lokal. Tidak ada data yang dikirimkan ke server cloud asing di luar negeri.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #fee2e2 !important;">
                                    Seluruh instruksi (prompt), data guru, dan materi ditransmisikan ke server luar negeri dan berisiko dijadikan materi training AI publik tanpa izin sekolah.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 4: FORMAT KEDINASAN -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4" style="background: rgba(11, 45, 82, 0.9); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2.5 rounded-3 bg-warning bg-opacity-25 text-warning fs-4">
                                    <i class="bi bi-file-earmark-ruled-fill text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-0">4. Format Dokumen Kedinasan Langsung Jadi</h5>
                                    <div class="small fw-semibold" style="color: #fef08a !important;">Siap cetak, ber-Kop Surat, dan lolos supervisi pengawas</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Siap Ekspor Multi-Format):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #f0fdf4 !important;">
                                    Menghasilkan dokumen resmi dengan Kop Surat Sekolah, logo, tanda tangan Kepala Sekolah &amp; Guru, serta margin kedinasan standar dalam format <strong>PDF (A4 &amp; F4)</strong>, <strong>DOCX (Word)</strong>, dan <strong>Excel</strong>.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.85rem; line-height: 1.55; color: #fee2e2 !important;">
                                    Hanya memberikan teks mentah tanpa tabel, tanpa kop surat, dan membutuhkan berjam-jam kerja manual untuk dirapikan ke format pengawas sekolah.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- CALLOUT FOOTER -->
                <div class="mt-4 pt-4 border-top border-white border-opacity-10 text-center">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-primary bg-opacity-20 text-info border border-info border-opacity-30 small">
                        <i class="bi bi-shield-fill-check text-success"></i>
                        <span>Inovasi Pembelajaran Digital Kemendikdasmen &bull; Arsitektur oleh {{ app_setting('landing_creator_name', 'Vicky Koroh') }} (2026)</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: KEUNGGULAN & FITUR UTAMA -->
    <section class="py-4 py-md-5 position-relative z-1">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small fw-semibold mb-2">
                    FITUR & KELEBIHAN UNGGULAN 2026
                </span>
                <h2 class="fw-bold text-white fs-2 mb-2">Solusi Menyeluruh untuk Guru & Sekolah SMK</h2>
                <p class="text-white-50 small" style="max-width: 650px; margin: 0 auto;">
                    Dirancang khusus menghemat waktu administratif guru dari berminggu-minggu menjadi hitungan detik dengan dokumen yang siap cetak dan terakreditasi kedinasan.
                </p>
            </div>

            <div class="row g-4">
                <!-- FITUR 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-primary bg-opacity-20 text-primary border border-primary border-opacity-30">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Sistem Pakar Generator 1-Klik</h5>
                        <p class="text-white-50 small mb-0">
                            Cukup pilih mata pelajaran dan fase, mesin inferensi sistem pakar berbasis database resmi BSKAP otomatis merumuskan TP, ATP, Modul Ajar, LKPD, Prota, Promes, dan Asesmen secara sinkron tanpa ketergantungan API pihak ketiga.
                        </p>
                    </div>
                </div>

                <!-- FITUR 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-info bg-opacity-20 text-info border border-info border-opacity-30">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Sintaks Pembelajaran PEDATTI</h5>
                        <p class="text-white-50 small mb-0">
                            Modul ajar terstruktur sistematis mengikuti alur PEDATTI: <em>Pelajari</em> (eksplorasi konsep), <em>Dalami</em> (bedah teori), <em>Terapkan</em> (praktik riil), dan <em>Evaluasi</em> (refleksi & asesmen).
                        </p>
                    </div>
                </div>

                <!-- FITUR 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-success bg-opacity-20 text-success border border-success border-opacity-30">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">8 Dimensi Profil Lulusan (DPL) 2026</h5>
                        <p class="text-white-50 small mb-0">
                            Terintegrasi penuh menanamkan keimanan, kewargaan, penalaran kritis, kreativitas, kolaborasi, kemandirian, kesehatan jasmani-rohani, dan komunikasi efektif.
                        </p>
                    </div>
                </div>

                <!-- FITUR 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Ekspor PDF Kedinasan Resmi</h5>
                        <p class="text-white-50 small mb-0">
                            Dokumen langsung diekspor dengan kop surat resmi satuan pendidikan, logo sekolah, tanda tangan Kepala Sekolah dan Guru Pengampu ber-NIP/NUPTK.
                        </p>
                    </div>
                </div>

                <!-- FITUR 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-danger bg-opacity-20 text-danger border border-danger border-opacity-30">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Prioritas Nasional Mapel Koding & AI 2026</h5>
                        <p class="text-white-50 small mb-0">
                            Mendukung implementasi mata pelajaran pilihan prioritas nasional 2026 Koding & AI untuk Fase E dan F di seluruh program keahlian SMK.
                        </p>
                    </div>
                </div>

                <!-- FITUR 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-secondary bg-opacity-20 text-white border border-secondary border-opacity-30">
                            <i class="bi bi-people-fill text-info"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Multi-Peran & Kolaborasi Sekolah</h5>
                        <p class="text-white-50 small mb-0">
                            Dukungan peran Super Administrator, Admin Sekolah, dan Guru Pengampu untuk monitoring administrasi guru, pembagian dokumen, dan standarisasi mutu ajar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: CREATOR SHOWCASE & COPYRIGHT -->
    <section class="py-4 py-md-5 position-relative z-1">
        <div class="container">
            <div class="creator-box p-4 p-md-5 text-center">
                <div class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill small fw-bold mb-3">
                    <i class="bi bi-patch-check-fill me-1"></i> IDENTITAS KARYA & HAK CIPTA RESMI
                </div>
                <h3 class="fw-bold text-white mb-2">{{ app_setting('app_name', 'Sistem Perangkat Ajar Kurikulum Merdeka 2026') }}</h3>
                <p class="text-white-50 mb-3" style="max-width: 600px; margin: 0 auto; font-size: 0.95rem;">
                    {{ app_setting('landing_creator_desc', 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.') }}
                </p>
                <div class="fs-5 fw-bold text-info mb-1">
                    <i class="bi bi-award me-1"></i> Desain & Pengembangan oleh: <span class="text-white">{{ app_setting('landing_creator_name', 'Vicky Koroh') }}</span>
                </div>
                <div class="text-white-50 small mb-4">
                    {{ app_setting('landing_creator_role', 'Super Administrator & Lead Architect') }} &bull; Hak Cipta Terlindungi &copy; {{ app_setting('landing_copyright_year', '2026') }}
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-2.5">
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-glow-gold px-4 py-2">
                        <i class="bi bi-lightning-charge-fill"></i> Coba Gratis Sekarang
                    </a>
                    <a href="{{ route('creator.profile') }}" class="btn btn-sm btn-info text-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-person-lines-fill me-1"></i> Profil Pembuat
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-4 py-2 rounded-pill">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER WITH ADSENSE COMPLIANCE LINKS -->
    <footer class="py-4 position-relative z-1 text-center small" style="background: #041427; border-top: 3.5px solid #f59e0b !important; color: #cbd5e1;">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-3">
                <div style="color: #e2e8f0;">
                    <strong class="text-white">{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}</strong> &bull; Kurikulum Merdeka (Deep Learning).
                </div>
                <div style="color: #e2e8f0;">
                    Hak Cipta : <span class="text-white fw-bold">Desain by. {{ app_setting('landing_creator_name', 'Vicky Koroh') }}</span> &bull; &copy; {{ app_setting('landing_copyright_year', '2026') }}
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2 border-top border-white border-opacity-10" style="font-size: 0.82rem;">
                <a href="{{ route('legal.privacy') }}" class="footer-legal-link">Kebijakan Privasi</a>
                <span class="text-secondary">&bull;</span>
                <a href="{{ route('legal.terms') }}" class="footer-legal-link">Syarat & Ketentuan Layanan</a>
                <span class="text-secondary">&bull;</span>
                <a href="{{ route('legal.about') }}" class="footer-legal-link">Tentang Kami</a>
                <span class="text-secondary">&bull;</span>
                <a href="{{ route('legal.contact') }}" class="footer-legal-link">Hubungi Kami</a>
                <span class="text-secondary">&bull;</span>
                <a href="{{ route('creator.profile') }}" class="footer-legal-link">Profil Pembuat</a>
                <span class="text-secondary">&bull;</span>
                <a href="{{ route('legal.disclaimer') }}" class="footer-legal-link">Pernyataan Penyangkalan (Disclaimer)</a>
            </div>
        </div>
    </footer>

    <!-- BOOTSTRAP 5 JAVASCRIPT BUNDLE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- POP-UP INFORMATIF & PUSAT PANDUAN -->
    @include('components.welcome-popup')

    <!-- FLOATING SCROLL TO TOP BUTTON -->
    <button type="button" id="btnLandingScrollToTop" class="btn btn-glow-gold rounded-circle d-none align-items-center justify-content-center"
            style="position: fixed; bottom: 25px; right: 25px; width: 46px; height: 46px; z-index: 999; transition: all 0.3s ease; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4) !important;"
            title="Kembali ke Atas">
        <i class="bi bi-chevron-up fs-5"></i>
    </button>
    <script>
        window.addEventListener('scroll', function() {
            var btn = document.getElementById('btnLandingScrollToTop');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.classList.remove('d-none');
                    btn.classList.add('d-flex');
                } else {
                    btn.classList.remove('d-flex');
                    btn.classList.add('d-none');
                }
            }
        });
        document.getElementById('btnLandingScrollToTop')?.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>
