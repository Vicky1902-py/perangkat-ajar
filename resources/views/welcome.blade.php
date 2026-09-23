<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }} - Kurikulum Merdeka (Deep Learning)</title>
    
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
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230284c7'><path d='M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z'/></svg>">
    @endif
    
    <!-- Open Graph & SEO Meta Tags -->
    @include('layouts.partials.og-meta')
    
    <style>
        :root {
            --kemendikdasmen-navy: #0b3b60;
            --kemendikdasmen-navy-dark: #07253d;
            --kemendikdasmen-blue: #0284c7;
            --kemendikdasmen-sky: #e0f2fe;
            --kemendikdasmen-gold: #f59e0b;
            --text-main: #1e293b;
            --text-muted-custom: #64748b;
            --bg-canvas: #f8fafc;
            --card-border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient subtle sky blue wash */
        .sky-wash {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }
        .sky-wash-1 {
            top: -100px;
            left: 10%;
            width: 500px;
            height: 500px;
            background: #bae6fd;
        }
        .sky-wash-2 {
            top: 25%;
            right: 5%;
            width: 550px;
            height: 550px;
            background: #e0f2fe;
        }

        /* Navbar - Clean White with Kemendikdasmen Navy & Sky Blue Accents */
        .landing-nav {
            background: #ffffff;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1050;
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.04);
        }

        .brand-logo-badge {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #e0f2fe;
            border: 1px solid #7dd3fc;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-title {
            color: var(--kemendikdasmen-navy) !important;
            font-weight: 800;
        }

        /* Clean White Cards */
        .glass-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.06);
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            border-color: #7dd3fc;
            box-shadow: 0 12px 30px rgba(11, 59, 96, 0.1);
        }

        /* Regulation Pill Badge (Kemendikdasmen Sky Blue) */
        .badge-regulasi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e0f2fe;
            border: 1px solid #7dd3fc;
            border-radius: 40px;
            padding: 7px 18px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #0369a1 !important;
            max-width: 100%;
        }

        /* Universal Soft Badges */
        .badge-soft-primary, .badge.bg-primary.bg-opacity-10 {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #bae6fd !important;
            font-weight: 600 !important;
        }
        .badge-soft-success, .badge.bg-success.bg-opacity-10 {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #bbf7d0 !important;
            font-weight: 600 !important;
        }
        .badge-soft-warning, .badge.bg-warning.bg-opacity-10 {
            background-color: #fef3c7 !important;
            color: #92400e !important;
            border: 1px solid #fde68a !important;
            font-weight: 600 !important;
        }
        .badge-soft-danger, .badge.bg-danger.bg-opacity-10 {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
            border: 1px solid #fecaca !important;
            font-weight: 600 !important;
        }
        .badge-soft-info, .badge.bg-info.bg-opacity-10 {
            background-color: #e0e7ff !important;
            color: #4338ca !important;
            border: 1px solid #c7d2fe !important;
            font-weight: 600 !important;
        }

        /* Hero Typography */
        .hero-title {
            font-size: 2.85rem;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -0.8px;
            color: var(--kemendikdasmen-navy);
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 60%, #0b3b60 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.08rem;
            line-height: 1.7;
            color: #334155 !important;
            max-width: 760px;
        }

        /* Buttons */
        .btn-glow-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff !important;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(2, 132, 199, 0.45);
            background: linear-gradient(135deg, #0369a1 0%, #0b3b60 100%);
        }

        .btn-glow-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff !important;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.5);
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }

        .btn-glass-outline {
            background: #ffffff;
            border: 1.5px solid #0284c7;
            color: #0284c7 !important;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glass-outline:hover {
            background: #e0f2fe;
            color: #0369a1 !important;
            transform: translateY(-2px);
        }

        /* Feature Icon Box */
        .feature-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 16px;
        }

        /* Photo Cards */
        .photo-card {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.06);
            transition: all 0.3s ease;
            background: #ffffff;
        }
        .photo-card:hover {
            transform: translateY(-4px);
            border-color: #7dd3fc;
            box-shadow: 0 12px 30px rgba(11, 59, 96, 0.12);
        }
        .photo-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .photo-card:hover img {
            transform: scale(1.04);
        }
        .photo-overlay {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.2) 0%, #ffffff 80%);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 18px;
        }

        /* Document Badge Tag */
        .doc-tag {
            background: #ffffff;
            border: 1px solid #bae6fd;
            border-radius: 9999px;
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--kemendikdasmen-navy) !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(11, 59, 96, 0.05);
        }

        /* Creator Showcase Box */
        .creator-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
            border: 1.5px solid #bae6fd;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(11, 59, 96, 0.06);
        }

        /* Grand Showcase Mockup */
        .mockup-container {
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(11, 59, 96, 0.09);
            overflow: hidden;
        }
        .mockup-header {
            background: #f8fafc;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        /* Floating Badge HUD on Photo */
        .floating-hud {
            position: absolute;
            background: #ffffff;
            border: 1.5px solid #bae6fd;
            border-radius: 12px;
            padding: 10px 16px;
            box-shadow: 0 8px 24px rgba(11, 59, 96, 0.12);
            font-size: 0.8rem;
            color: var(--kemendikdasmen-navy);
            z-index: 3;
        }

        /* Comparison Cards High Contrast Rules */
        .compare-box-expert {
            background: #f0fdf4 !important;
            border: 1.5px solid #86efac !important;
        }
        .compare-box-expert p, .compare-box-expert strong {
            color: #166534 !important;
        }
        .compare-box-ai {
            background: #fef2f2 !important;
            border: 1.5px solid #fca5a5 !important;
        }
        .compare-box-ai p, .compare-box-ai strong {
            color: #991b1b !important;
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
                font-size: 1.75rem !important;
                line-height: 1.25;
            }
            .hero-subtitle {
                font-size: 0.92rem !important;
                line-height: 1.6;
            }
            .btn-glow-primary, .btn-glow-gold, .btn-glass-outline {
                width: 100%;
                padding: 11px 16px;
                font-size: 0.88rem;
            }
            .badge-regulasi {
                font-size: 0.72rem;
                padding: 6px 12px;
                line-height: 1.4;
            }
            .glass-card {
                border-radius: 14px;
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

        /* Footer links & readability */
        .footer-legal-link {
            color: #93c5fd !important;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-legal-link:hover {
            color: #ffffff !important;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Ambient Subtle Sky Blue Wash -->
    <div class="sky-wash sky-wash-1"></div>
    <div class="sky-wash sky-wash-2"></div>

    <!-- NAVIGATION BAR -->
    <nav class="landing-nav">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 gap-sm-3 text-decoration-none">
                @if(app_logo_url())
                    <img src="{{ app_logo_url() }}" alt="{{ app_setting('app_name') }}" style="max-height: 40px; max-width: 140px; object-fit: contain;">
                @else
                    <div class="brand-logo-badge">
                        <i class="bi bi-journal-bookmark-fill text-primary fs-5"></i>
                    </div>
                @endif
                <div>
                    <div class="fw-bold fs-6 mb-0 d-flex align-items-center gap-1.5 brand-title">
                        <span>{{ app_setting('app_name', 'Sistem Perangkat Ajar') }}</span>
                        <span class="badge bg-primary bg-opacity-10 border border-primary border-opacity-25 text-primary px-1.5 py-0.5" style="font-size: 0.65rem;">SMK 2026</span>
                    </div>
                    <div class="text-secondary small d-none d-sm-block" style="font-size: 0.72rem;">{{ app_setting('app_tagline', 'Kurikulum Merdeka • Deep Learning 2026') }}</div>
                </div>
            </a>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-1.5 gap-sm-2">
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 px-sm-3 py-1.5 d-none d-lg-inline-flex align-items-center gap-1.5" onclick="openWelcomePopup('panduan')" style="font-size: 0.8rem;">
                    <i class="bi bi-compass-fill text-primary"></i>
                    <span>Panduan Pengguna</span>
                </button>
                <a href="{{ route('creator.profile') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 px-sm-3 py-1.5 d-none d-xl-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                    <i class="bi bi-person-badge text-primary"></i>
                    <span>Profil Pembuat</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-glow-primary px-3 py-1.5" style="font-size: 0.82rem;">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-warning fw-bold px-2.5 py-1.5 rounded-pill d-none d-md-inline-flex align-items-center gap-1 shadow-sm text-dark" style="font-size: 0.8rem;">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Coba Gratis 2x</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 px-sm-3 py-1.5" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-2.5 px-sm-3 py-1.5 shadow-sm" style="font-size: 0.8rem;">
                        <i class="bi bi-person-plus-fill me-1"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (KEMENDIKDASMEN SKY BLUE CANVAS) -->
    <header class="py-4 py-md-5 py-lg-6 position-relative z-1" style="background: linear-gradient(180deg, #e8f4fc 0%, #f0f8ff 60%, #ffffff 100%);">
        <div class="container text-center">
            
            <!-- REGULATION PILL BADGE -->
            <div class="mb-3 mb-md-4">
                <span class="badge-regulasi">
                    <i class="bi bi-patch-check-fill text-primary fs-6"></i>
                    <span>{{ app_setting('landing_hero_badge', 'Standar Resmi Kurikulum Merdeka 2026 • BSKAP 046/H/KR/2025 • Permendikdasmen 13/2025') }}</span>
                </span>
            </div>

            <!-- MAIN HERO TITLE -->
            <h1 class="hero-title mb-3">
                {!! nl2br(e(app_setting('landing_hero_title', 'Revolusi Penyusunan Perangkat Ajar SMK 2026 Berbasis Deep Learning'))) !!}
            </h1>

            <!-- HERO SUBTITLE -->
            <p class="hero-subtitle mx-auto mb-4">
                {{ app_setting('landing_hero_subtitle', 'Platform cerdas generasi baru Tahun 2026 untuk otomatisasi penyusunan TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes, Asesmen, hingga Smart Soal (Kisi-Kisi & Bank Soal PG/Isian) lengkap dengan Kop Surat Kedinasan Sekolah.') }}
            </p>

            <!-- CALL TO ACTIONS -->
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2.5 gap-sm-3 mb-4 mb-md-5">
                <a href="{{ route('generator.index') }}" class="btn-glow-gold">
                    <i class="bi bi-lightning-charge-fill fs-5"></i>
                    <span>{{ app_setting('landing_hero_cta_primary', 'Coba Generator Gratis (Maks. 2x)') }}</span>
                </a>
                <a href="{{ route('login') }}" class="btn-glow-primary">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk ke Akun Guru</span>
                </a>
                <a href="{{ route('register') }}" class="btn-glass-outline">
                    <i class="bi bi-person-plus-fill fs-5"></i>
                    <span>Daftar Akun Baru</span>
                </a>
            </div>

            <!-- QUICK PILL METRICS -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4 mb-lg-5">
                <span class="doc-tag" style="border-color: #f59e0b; background: #fffbeb; color: #b45309 !important;">
                    <i class="bi bi-shield-check text-warning"></i> 100% Sistem Pakar Murni (Tanpa API Key &bull; Nol Halusinasi)
                </span>
                <span class="doc-tag" style="border-color: #38bdf8; background: #f0f9ff; color: #0369a1 !important;">
                    <i class="bi bi-patch-question-fill text-primary"></i> Smart Soal & Kisi-Kisi Resmi (PG & Isian)
                </span>
                <span class="doc-tag"><i class="bi bi-patch-check-fill text-primary"></i> Basis Database Resmi BSKAP 046/2025</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> 8 Dimensi Profil Lulusan (DPL) 2026</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Sintaks PEDATTI Terintegrasi</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Pilar 3M (Mindful, Meaningful, Joyful)</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Ekspor PDF & Word Ber-Kop Resmi</span>
            </div>

            <!-- HERO VISUAL SHOWCASE MOCKUP (CLEAN TECH PHOTO) -->
            <div class="row justify-content-center">
                <div class="col-lg-10 position-relative">
                    
                    <!-- Floating HUD Badges -->
                    <div class="floating-hud d-none d-md-flex align-items-center gap-2" style="top: -20px; left: 20px;">
                        <i class="bi bi-cpu-fill text-primary fs-5"></i>
                        <div class="text-start">
                            <div class="fw-bold" style="color: #0b3b60;">Sistem Pakar Edukasi</div>
                            <div style="font-size: 0.72rem; color: #0284c7 !important;">Murni Database &bull; Nol Halusinasi AI</div>
                        </div>
                    </div>

                    <div class="floating-hud d-none d-md-flex align-items-center gap-2" style="bottom: 25px; right: 20px;">
                        <i class="bi bi-patch-check-fill text-warning fs-5"></i>
                        <div class="text-start">
                            <div class="fw-bold" style="color: #0b3b60;">Standar Regulasi BSKAP 2026</div>
                            <div style="font-size: 0.72rem; color: #b45309 !important;">Rujukan Resmi Kurikulum Merdeka</div>
                        </div>
                    </div>

                    <div class="mockup-container">
                        <div class="mockup-header">
                            <span class="dot dot-red"></span>
                            <span class="dot dot-yellow"></span>
                            <span class="dot dot-green"></span>
                            <span class="text-secondary small ms-2" style="font-size: 0.75rem;">Sistem Perangkat Ajar SMK 2026 &bull; Kurikulum Merdeka (Deep Learning)</span>
                        </div>
                        <div class="position-relative" style="max-height: 480px; overflow: hidden;">
                            <img src="{{ app_setting('landing_hero_image', 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1200&q=80') }}" 
                                 alt="Pembelajaran Vokasi Modern SMK 2026" 
                                 class="img-fluid w-100" 
                                 style="object-fit: cover; height: 380px;">
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 p-md-4" style="background: linear-gradient(180deg, transparent 0%, rgba(11, 59, 96, 0.92) 85%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="text-start">
                                        <h5 class="fw-bold text-white mb-1"><i class="bi bi-shield-check text-info me-1"></i> Workspace Perangkat Ajar Terintegrasi 2026</h5>
                                        <p class="text-white-50 small mb-0" style="color: #e0f2fe !important;">Dirancang khusus untuk mempermudah guru SMK di era transformasi digital kejuruan.</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('generator.index') }}" class="btn btn-sm btn-warning rounded-pill px-3 py-1.5 fw-bold text-dark">
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
    <section class="py-5 position-relative z-1" style="background-color: #ffffff;">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small fw-bold mb-2">
                    FILOSOFI PEMBELAJARAN 2026
                </span>
                <h2 class="fw-bold fs-2 mb-2" style="color: var(--kemendikdasmen-navy);">Pendekatan Pembelajaran Mendalam (Deep Learning)</h2>
                <p class="text-muted small" style="max-width: 620px; margin: 0 auto; color: #475569 !important;">
                    Kurikulum Merdeka 2026 memprioritaskan kualitas pengalaman belajar siswa SMK melalui tiga pilar esensial (Mindful, Meaningful, dan Joyful).
                </p>
            </div>

            <div class="row g-4">
                <!-- PILAR 1: MINDFUL (WITH PHOTO) -->
                <div class="col-md-4">
                    <div class="photo-card h-100">
                        <img src="{{ app_setting('landing_pilar_mindful_img', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80') }}" 
                             alt="{{ app_setting('landing_pilar_mindful_title', 'Mindful') }}">
                        <div class="p-3 bg-white">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 1</span>
                                <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">{{ app_setting('landing_pilar_mindful_title', 'Mindful') }}</h5>
                            </div>
                            <div class="text-primary fw-semibold small mb-2">{{ app_setting('landing_pilar_mindful_subtitle', 'Pembelajaran Berkesadaran') }}</div>
                            <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.55; color: #475569 !important;">
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
                        <div class="p-3 bg-white">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning bg-opacity-10 text-warning text-dark fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 2</span>
                                <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">{{ app_setting('landing_pilar_meaningful_title', 'Meaningful') }}</h5>
                            </div>
                            <div class="text-warning text-dark fw-semibold small mb-2">{{ app_setting('landing_pilar_meaningful_subtitle', 'Pembelajaran Bermakna') }}</div>
                            <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.55; color: #475569 !important;">
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
                        <div class="p-3 bg-white">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="font-size: 0.7rem;">Pilar 3</span>
                                <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">{{ app_setting('landing_pilar_joyful_title', 'Joyful') }}</h5>
                            </div>
                            <div class="text-success fw-semibold small mb-2">{{ app_setting('landing_pilar_joyful_subtitle', 'Pembelajaran Menggembirakan') }}</div>
                            <p class="text-secondary small mb-0" style="font-size: 0.82rem; line-height: 1.55; color: #475569 !important;">
                                {{ app_setting('landing_pilar_joyful_desc', 'Membangun atmosfer belajar kolaboratif yang menggembirakan, menumbuhkan rasa ingin tahu yang tinggi, dan antusiasme dalam bereksperimen karya kejuruan.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: SHOWCASE TEKNOLOGI & GURU SMK 2026 -->
    <section class="py-5 position-relative z-1" style="background-color: #f8fafc;">
        <div class="container">
            <div class="glass-card p-3 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small fw-bold mb-3">
                            <i class="bi bi-stars text-warning me-1"></i> INOVASI DIGITAL SMK 2026
                        </span>
                        <h2 class="fw-bold mb-3 fs-2" style="color: var(--kemendikdasmen-navy);">
                            Penyusunan Perangkat Ajar Masa Kini yang Cepat, Akurat & Terstandar
                        </h2>
                        <p class="text-secondary small mb-4" style="line-height: 1.7; color: #334155 !important;">
                            Guru SMK kini tidak perlu lagi menghabiskan waktu berminggu-minggu menyusun berkas administrasi ajar. 
                            Dengan engine cerdas edisi <strong>2026</strong>, seluruh sintaks <strong>PEDATTI</strong> dan 
                            <strong>8 Dimensi Profil Lulusan</strong> diformulasikan secara sistematis dan langsung siap diekspor 
                            ke dokumen kedinasan resmi dengan kop surat sekolah.
                        </p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Hemat Waktu Hingga 95%</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Kop Surat & Logo Resmi</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Format PDF & Word Siap Cetak</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <span>Mendukung Mapel AI & Koding</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('generator.index') }}" class="btn-glow-gold">
                                <i class="bi bi-lightning-charge-fill"></i> Coba Generator Sekarang
                            </a>
                            <a href="{{ route('register') }}" class="btn-glass-outline">
                                <i class="bi bi-person-plus"></i> Daftar Akun Guru
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80" 
                                 alt="Guru dan Pembelajaran Modern SMK 2026" 
                                 class="img-fluid rounded-4 shadow-sm border w-100" 
                                 style="max-height: 420px; object-fit: cover;">
                            
                            <div class="position-absolute bottom-0 start-0 m-3 p-3 rounded-3 bg-white shadow-sm border">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-check-fill text-primary fs-4"></i>
                                    <div class="small">
                                        <div class="fw-bold" style="color: var(--kemendikdasmen-navy);">Edisi Terbaru Tahun 2026</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Sesuai Pedoman Kurikulum Merdeka</div>
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
    <section class="py-5 position-relative z-1" id="keunggulan-sistem-pakar" style="background-color: #ffffff;">
        <div class="container">
            <div class="p-4 p-md-5 rounded-4 shadow-sm border position-relative overflow-hidden" 
                 style="background: #ffffff; border-color: #bae6fd !important;">
                
                <div class="text-center mb-4 mb-md-5 position-relative z-1">
                    <div class="d-inline-flex align-items-center gap-2 badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold px-3 py-1.5 rounded-pill mb-3" style="font-size: 0.82rem;">
                        <i class="bi bi-patch-check-fill text-primary"></i>
                        <span>STANDAR REGULASI RESMI KURIKULUM MERDEKA KEMENDIKDASMEN 2026</span>
                    </div>
                    <h2 class="fw-bold fs-2 mb-2" style="color: var(--kemendikdasmen-navy);">
                        Mengapa Sistem Pakar Murni Jauh Lebih Unggul &amp; Aman Dibanding AI Generatif Biasa?
                    </h2>
                    <p class="mx-auto small" style="max-width: 750px; line-height: 1.7; color: #334155 !important;">
                        Aplikasi ini dibangun dengan arsitektur <strong>Knowledge-Based Expert System (Sistem Pakar Berbasis Regulasi)</strong> dengan data rujukan tersimpan langsung di database internal. Murni tanpa ketergantungan API Key berbayar pihak ketiga, menjamin <strong>Nol Halusinasi</strong>, kedaulatan data pendidikan nasional, serta 100% bebas biaya bagi guru di seluruh pelosok Indonesia.
                    </p>
                </div>

                <!-- KOMPARASI 4 PILAR UTAMA -->
                <div class="row g-4 position-relative z-1">
                    
                    <!-- PILAR 1: AKURASI REGULASI -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4 bg-light border">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary fs-4">
                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">1. Akurasi Regulasi &amp; Nol Halusinasi</h5>
                                    <div class="small fw-semibold text-primary">Kepastian hukum dan validitas dokumen ajar</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Database Resmi):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Menyerap Capaian Pembelajaran (CP) dan elemen kompetensi langsung dari database resmi <strong>BSKAP No. 046/H/KR/2025</strong> dan alokasi waktu <strong>Permendikdasmen No. 13/2025</strong>. Tidak ada risiko mengarang.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Sering "berhalusinasi" mencampuradukkan kurikulum lama, memalsukan nomor SK BSKAP, dan menghitung jam pelajaran secara keliru.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 2: TANPA BIAYA API KEY -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4 bg-light border">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success fs-4">
                                    <i class="bi bi-wallet2 text-success"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">2. 100% Tanpa API Key &amp; Bebas Biaya Token</h5>
                                    <div class="small fw-semibold text-success">Aksesibilitas inklusif untuk seluruh guru Indonesia</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Server Mandiri):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Berjalan deterministik tanpa memerlukan saldo kredit, token, atau API Key OpenAI/Claude. Seluruh guru SMK (termasuk di wilayah 3T) dapat menyusun modul ajar tanpa dipungut biaya token.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Mengharuskan guru memiliki kartu kredit, berlangganan API Key berbayar dalam mata uang Dolar ($), dan aplikasi langsung macet saat kuota token habis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 3: KEDAULATAN DATA -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4 bg-light border">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info fs-4">
                                    <i class="bi bi-shield-lock-fill text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">3. Kedaulatan &amp; Keamanan Data Satuan Pendidikan</h5>
                                    <div class="small fw-semibold text-primary">Privasi data guru dan siswa terlindungi utuh</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Lokal &amp; Mandiri):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Semua data sekolah, identitas guru, NIP, dan rancangan ajar tersimpan privat di database lokal. Tidak ada data yang dikirimkan ke server cloud asing di luar negeri.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Seluruh instruksi (prompt), data guru, dan materi ditransmisikan ke server luar negeri dan berisiko dijadikan materi training AI publik tanpa izin sekolah.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PILAR 4: FORMAT KEDINASAN -->
                    <div class="col-lg-6">
                        <div class="h-100 p-4 rounded-4 bg-light border">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning fs-4">
                                    <i class="bi bi-file-earmark-ruled-fill text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: var(--kemendikdasmen-navy);">4. Format Dokumen Kedinasan Langsung Jadi</h5>
                                    <div class="small fw-semibold text-warning text-dark">Siap cetak, ber-Kop Surat, dan lolos supervisi pengawas</div>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3 mb-2 compare-box-expert">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold small mb-1">
                                    <i class="bi bi-check-circle-fill"></i> Sistem Pakar Kami (Siap Ekspor Multi-Format):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Menghasilkan dokumen resmi dengan Kop Surat Sekolah, logo, tanda tangan Kepala Sekolah &amp; Guru, serta margin kedinasan standar dalam format <strong>PDF (A4 &amp; F4)</strong>, <strong>DOCX (Word)</strong>, dan <strong>Excel</strong>.
                                </p>
                            </div>

                            <div class="p-3 rounded-3 compare-box-ai">
                                <div class="d-flex align-items-center gap-2 text-danger fw-semibold small mb-1">
                                    <i class="bi bi-x-circle-fill"></i> AI Generatif Biasa (ChatGPT / LLM API):
                                </div>
                                <p class="small mb-0" style="font-size: 0.84rem; line-height: 1.55;">
                                    Hanya memberikan teks mentah tanpa tabel, tanpa kop surat, dan membutuhkan berjam-jam kerja manual untuk dirapikan ke format pengawas sekolah.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- CALLOUT FOOTER -->
                <div class="mt-4 pt-4 border-top text-center">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 small fw-semibold">
                        <i class="bi bi-shield-fill-check text-success"></i>
                        <span>Inovasi Pembelajaran Digital Kemendikdasmen &bull; Arsitektur oleh {{ app_setting('landing_creator_name', 'Vicky Koroh') }} (2026)</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: SPOTLIGHT INOVASI SMART SOAL BY VICKY -->
    <section class="py-5 position-relative z-1" id="smart-soal" style="background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);">
        <div class="container">
            <div class="glass-card p-4 p-md-5 position-relative overflow-hidden" style="border: 2px solid #7dd3fc !important; box-shadow: 0 16px 40px rgba(2, 132, 199, 0.08);">
                <div class="position-absolute top-0 end-0 m-3 d-none d-md-block">
                    <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold shadow-sm" style="font-size: 0.78rem;">
                        <i class="bi bi-stars me-1 text-warning"></i> FITUR UNGGULAN 2026
                    </span>
                </div>

                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="d-inline-flex align-items-center gap-2 badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold px-3 py-1.5 rounded-pill mb-3" style="font-size: 0.8rem;">
                            <i class="bi bi-patch-question-fill text-primary"></i>
                            <span>GENERATOR KISI-KISI & BANK SOAL RESMI</span>
                        </div>
                        <h2 class="fw-bold mb-3 fs-2" style="color: var(--kemendikdasmen-navy);">
                            Smart Soal by. Vicky Koroh: Dari Blueprint Kisi-Kisi Resmi Sampai Naskah Ujian Siap Pakai
                        </h2>
                        <p class="text-secondary small mb-4" style="line-height: 1.7; color: #334155 !important;">
                            Kini guru SMK tidak perlu lagi bersusah payah menyusun kisi-kisi dan butir soal evaluasi secara terpisah. 
                            <strong>Smart Soal</strong> secara otomatis merumuskan alur evaluasi terpadu mulai dari 
                            <strong>Tabel Kisi-Kisi Resmi Kemendikdasmen (BSKAP 046/H/KR/2025) 8 Kolom</strong> hingga butir soal 
                            <strong>Pilihan Ganda (PG)</strong> dan <strong>Isian / Uraian (Essay)</strong> yang 100% tersinkronisasi langsung dengan Modul Ajar di database.
                        </p>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-white border h-100 shadow-sm" style="border-left: 4px solid #0284c7 !important;">
                                    <div class="fw-bold text-dark small d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-table text-primary fs-5"></i>
                                        <span>Kisi-Kisi Resmi 8 Kolom</span>
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.78rem; line-height: 1.5;">
                                        Standar BSKAP lengkap dengan Elemen, TP, Materi Pokok, Indikator Butir, Level Kognitif (L1-L3 HOTS), dan Skor.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-white border h-100 shadow-sm" style="border-left: 4px solid #10b981 !important;">
                                    <div class="fw-bold text-dark small d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-link-45deg text-success fs-5"></i>
                                        <span>Sinkron Modul Ajar</span>
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.78rem; line-height: 1.5;">
                                        Materi, konteks masalah vokasi, dan indikator butir ditarik langsung dari Modul Ajar yang sudah ada di database.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-white border h-100 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
                                    <div class="fw-bold text-dark small d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-ui-checks text-warning fs-5"></i>
                                        <span>PG & Isian + Rubrik Analitik</span>
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.78rem; line-height: 1.5;">
                                        Soal PG dengan 4 pengecoh homogen dan soal isian disertai kata kunci serta rubrik pedoman penskoran bertingkat.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-white border h-100 shadow-sm" style="border-left: 4px solid #8b5cf6 !important;">
                                    <div class="fw-bold text-dark small d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-file-earmark-pdf-fill fs-5" style="color: #8b5cf6;"></i>
                                        <span>Dual Output Siswa vs Guru</span>
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.78rem; line-height: 1.5;">
                                        Ekspor PDF Naskah Siswa (bersih tanpa kunci) dan PDF Pegangan Guru (lengkap kisi-kisi, kunci & rubrik pengesahan).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <a href="{{ route('login') }}" class="btn-glow-primary">
                                <i class="bi bi-patch-question me-1"></i> Buat Smart Soal Sekarang
                            </a>
                            <span class="text-muted small ms-2 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-shield-check text-success"></i> 100% Sistem Pakar &bull; Tanpa Biaya Token
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="p-3.5 p-md-4 rounded-4 bg-white border shadow-sm position-relative">
                            <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-patch-question-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.92rem;">Smart Soal by. Vicky</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">Kurikulum Merdeka 2026</div>
                                    </div>
                                </div>
                                <span class="badge badge-soft-success rounded-pill px-2.5 py-1" style="font-size: 0.68rem;">SISTEM PAKAR</span>
                            </div>

                            <!-- Alur 3 Langkah Interaktif -->
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.75rem;">1</div>
                                    <div>
                                        <div class="fw-bold text-dark small">Pilih Modul Ajar Sumber</div>
                                        <div class="text-secondary small" style="font-size: 0.78rem;">Sistem membaca Capaian Pembelajaran (CP) dan TP dari modul di database secara otomatis.</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.75rem;">2</div>
                                    <div>
                                        <div class="fw-bold text-dark small">Formulasi Kisi-Kisi & Soal HOTS</div>
                                        <div class="text-secondary small" style="font-size: 0.78rem;">Mesin pakar menyusun blueprint kisi-kisi 8 kolom, stimulus vokasi nyata, opsi A-E homogen, dan rubrik skor.</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.75rem;">3</div>
                                    <div>
                                        <div class="fw-bold text-dark small">Dual Ekspor PDF & Word Ber-Kop</div>
                                        <div class="text-secondary small" style="font-size: 0.78rem;">Naskah siswa siap dibagikan di ruang ujian dan naskah guru siap diarsipkan untuk supervisi kepala sekolah.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-2.5 rounded-3 text-center" style="background: #f0fdf4; border: 1px dashed #86efac;">
                                <span class="text-success fw-semibold small" style="font-size: 0.78rem;">
                                    <i class="bi bi-check-all me-1"></i> Mendukung PG, Isian, & Campuran dengan 1-Klik
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: KEUNGGULAN & FITUR UTAMA -->
    <section class="py-5 position-relative z-1" style="background-color: #f8fafc;">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small fw-bold mb-2">
                    FITUR & KELEBIHAN UNGGULAN 2026
                </span>
                <h2 class="fw-bold fs-2 mb-2" style="color: var(--kemendikdasmen-navy);">Solusi Menyeluruh untuk Guru & Sekolah SMK</h2>
                <p class="text-secondary small" style="max-width: 650px; margin: 0 auto; color: #475569 !important;">
                    Dirancang khusus menghemat waktu administratif guru dari berminggu-minggu menjadi hitungan detik dengan dokumen yang siap cetak dan terakreditasi kedinasan.
                </p>
            </div>

            <div class="row g-4">
                <!-- FITUR 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Sistem Pakar Generator 1-Klik</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Cukup pilih mata pelajaran dan fase, mesin inferensi sistem pakar berbasis database resmi BSKAP otomatis merumuskan TP, ATP, Modul Ajar, LKPD, Prota, Promes, dan Asesmen secara sinkron tanpa ketergantungan API pihak ketiga.
                        </p>
                    </div>
                </div>

                <!-- FITUR 2: SMART SOAL (BARU) -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100 position-relative overflow-hidden" style="border: 2px solid #7dd3fc !important;">
                        <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3 px-2 py-1 small rounded-pill fw-bold" style="font-size: 0.65rem;">
                            BARU 2026
                        </span>
                        <div class="feature-icon-box bg-info bg-opacity-10 text-primary">
                            <i class="bi bi-patch-question-fill text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Smart Soal & Kisi-Kisi Resmi</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Generator kisi-kisi resmi 8 kolom (BSKAP 046/2025) hingga naskah soal PG (dengan pengecoh homogen) dan Isian (dengan rubrik skor analitik). 100% tersinkronisasi otomatis dari Modul Ajar di database.
                        </p>
                    </div>
                </div>

                <!-- FITUR 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-info bg-opacity-10 text-primary">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Sintaks Pembelajaran PEDATTI</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Modul ajar terstruktur sistematis mengikuti alur PEDATTI: <em>Pelajari</em> (eksplorasi konsep), <em>Dalami</em> (bedah teori), <em>Terapkan</em> (praktik riil), dan <em>Evaluasi</em> (refleksi & asesmen).
                        </p>
                    </div>
                </div>

                <!-- FITUR 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">8 Dimensi Profil Lulusan (DPL) 2026</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Terintegrasi penuh menanamkan keimanan, kewargaan, penalaran kritis, kreativitas, kolaborasi, kemandirian, kesehatan jasmani-rohani, dan komunikasi efektif.
                        </p>
                    </div>
                </div>

                <!-- FITUR 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Ekspor PDF Kedinasan Resmi</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Dokumen langsung diekspor dengan kop surat resmi satuan pendidikan, logo sekolah, tanda tangan Kepala Sekolah dan Guru Pengampu ber-NIP/NUPTK.
                        </p>
                    </div>
                </div>

                <!-- FITUR 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Mapel Pilihan Koding & AI 2026</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Mendukung implementasi mata pelajaran pilihan prioritas nasional 2026 Koding & AI untuk Fase E dan F di seluruh program keahlian SMK.
                        </p>
                    </div>
                </div>

                <!-- FITUR 7: MULTI-PERAN -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Multi-Peran & Kolaborasi Sekolah</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Dukungan peran Super Administrator, Admin Sekolah, dan Guru Pengampu untuk monitoring administrasi guru, pembagian dokumen, dan standarisasi mutu ajar.
                        </p>
                    </div>
                </div>

                <!-- FITUR 8: MANAJEMEN RUANG HOSTING & DATABASE -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-hdd-network-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Hosting & Data Space Manager</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Pemantau kapasitas disk SSD hosting & database MySQL secara real-time, dilengkapi bulk delete & quick purge untuk mencegah kelebihan kuota server.
                        </p>
                    </div>
                </div>

                <!-- FITUR 9: 100% BEBAS BIAYA TOKEN & AKSES INKLUSIF -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-3 p-md-4 h-100">
                        <div class="feature-icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Nol Halusinasi & Tanpa Biaya Token</h5>
                        <p class="text-secondary small mb-0" style="color: #475569 !important; line-height: 1.6;">
                            Bebas ketergantungan API pihak ketiga, menjaga kedaulatan data pendidikan nasional, serta memastikan guru di wilayah 3T dapat membuat perangkat tanpa kendala biaya token.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: CREATOR SHOWCASE & COPYRIGHT -->
    <section class="py-5 position-relative z-1" style="background-color: #ffffff;">
        <div class="container">
            <div class="creator-box p-4 p-md-5 text-center">
                <div class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1.5 rounded-pill small fw-bold mb-3">
                    <i class="bi bi-patch-check-fill text-primary me-1"></i> IDENTITAS KARYA & HAK CIPTA RESMI
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">{{ app_setting('app_name', 'Sistem Perangkat Ajar Kurikulum Merdeka 2026') }}</h3>
                <p class="text-secondary mb-3" style="max-width: 600px; margin: 0 auto; font-size: 0.95rem; color: #475569 !important;">
                    {{ app_setting('landing_creator_desc', 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.') }}
                </p>
                <div class="fs-5 fw-bold text-primary mb-1">
                    <i class="bi bi-award me-1"></i> Desain & Pengembangan oleh: <span style="color: var(--kemendikdasmen-navy);">{{ app_setting('landing_creator_name', 'Vicky Koroh') }}</span>
                </div>
                <div class="text-secondary small mb-4" style="color: #64748b !important;">
                    {{ app_setting('landing_creator_role', 'Super Administrator & Lead Architect') }} &bull; Hak Cipta Terlindungi &copy; {{ app_setting('landing_copyright_year', '2026') }}
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-2.5">
                    <a href="{{ route('generator.index') }}" class="btn-glow-gold">
                        <i class="bi bi-lightning-charge-fill"></i> Coba Gratis Sekarang
                    </a>
                    <a href="{{ route('creator.profile') }}" class="btn-glass-outline">
                        <i class="bi bi-person-lines-fill me-1"></i> Profil Pembuat
                    </a>
                    <a href="{{ route('login') }}" class="btn-glow-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER WITH SIGNATURE KEMENDIKDASMEN NAVY & ADSENSE COMPLIANCE LINKS -->
    <footer class="py-4 position-relative z-1 text-center small" style="background: #0b3b60; border-top: 3px solid #0284c7; color: #e2e8f0;">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-3">
                <div style="color: #f1f5f9;">
                    <strong class="text-white">{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}</strong> &bull; Kurikulum Merdeka (Deep Learning).
                </div>
                <div style="color: #f1f5f9;">
                    Hak Cipta : <span class="text-white fw-bold">Desain by. {{ app_setting('landing_creator_name', 'Vicky Koroh') }}</span> &bull; &copy; {{ app_setting('landing_copyright_year', '2026') }}
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2 border-top border-white border-opacity-15" style="font-size: 0.82rem;">
                <a href="{{ route('legal.privacy') }}" class="footer-legal-link">Kebijakan Privasi</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.terms') }}" class="footer-legal-link">Syarat & Ketentuan Layanan</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.about') }}" class="footer-legal-link">Tentang Kami</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.contact') }}" class="footer-legal-link">Hubungi Kami</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('creator.profile') }}" class="footer-legal-link">Profil Pembuat</a>
                <span class="text-white-50">&bull;</span>
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
            style="position: fixed; bottom: 25px; right: 25px; width: 46px; height: 46px; z-index: 999; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4) !important;"
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
