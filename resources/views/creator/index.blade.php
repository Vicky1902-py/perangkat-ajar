<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pembuat & Arsitek Sistem — {{ $creator['name'] }} | {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK') }}</title>
    
    <!-- FAVICON DINAMIS -->
    <link rel="icon" type="image/x-icon" href="{{ app_favicon_url() }}">
    <link rel="shortcut icon" href="{{ app_favicon_url() }}">

    <!-- META & OPEN GRAPH -->
    <meta name="description" content="Profil resmi {{ $creator['name'] }}, arsitek dan pencipta {{ app_setting('app_name') }} Kurikulum Merdeka Pendekatan Deep Learning.">
    <meta property="og:title" content="Profil Pembuat & Arsitek Sistem — {{ $creator['name'] }}">
    <meta property="og:description" content="{{ $creator['headline'] }} &bull; Hak Cipta Terlindungi &copy; {{ $creator['copyright_year'] }}">
    <meta property="og:image" content="{{ $creator['avatar'] }}">
    <meta property="og:type" content="profile">

    <!-- CSS BOOTSTRAP 5 & ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- THEME COLORS DINAMIS -->
    @php
        $themeColors = app_theme_colors();
    @endphp
    <style>
        :root {
            --primary-color: {{ $themeColors['primary'] }};
            --accent-cyan: {{ $themeColors['cyan'] }};
            --accent-indigo: {{ $themeColors['indigo'] }};
            --bg-dark: #040914;
            --bg-card: rgba(15, 23, 42, 0.78);
            --border-glass: rgba(255, 255, 255, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glowing Background Orbs */
        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.35;
        }
        .ambient-orb-1 {
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, #2563eb 0%, rgba(37, 99, 235, 0) 70%);
            top: -120px;
            left: -120px;
        }
        .ambient-orb-2 {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, #6366f1 0%, rgba(99, 102, 241, 0) 70%);
            top: 25%;
            right: -140px;
        }
        .ambient-orb-3 {
            width: 440px;
            height: 440px;
            background: radial-gradient(circle, #0284c7 0%, rgba(2, 132, 199, 0) 70%);
            bottom: 50px;
            left: 20%;
        }

        /* High contrast overrides */
        .text-white-50 {
            color: #cbd5e1 !important;
        }
        .text-secondary {
            color: #cbd5e1 !important;
        }
        .text-muted {
            color: #94a3b8 !important;
        }

        /* Navbar */
        .creator-navbar {
            background: rgba(4, 9, 20, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-glass);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .creator-brand {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.2px;
        }

        /* Hero Profile Card */
        .profile-hero-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(8, 14, 28, 0.95) 100%);
            border: 1px solid rgba(56, 189, 248, 0.28);
            border-radius: 28px;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 50px rgba(37, 99, 235, 0.15);
            overflow: hidden;
            position: relative;
        }

        .profile-cover-banner {
            height: 150px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.5) 0%, rgba(99, 102, 241, 0.4) 50%, rgba(56, 189, 248, 0.3) 100%);
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-cover-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 18px 18px;
            opacity: 0.5;
        }

        .profile-avatar-outer {
            width: 145px;
            height: 145px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #38bdf8 0%, #2563eb 50%, #818cf8 100%);
            box-shadow: 0 0 35px rgba(56, 189, 248, 0.45);
            position: relative;
            z-index: 2;
            margin: -75px auto 16px;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #080e1c;
        }

        .avatar-verified-seal {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: #2563eb;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #080e1c;
            box-shadow: 0 0 12px rgba(37, 99, 235, 0.8);
            font-size: 0.95rem;
        }

        /* Luxury Badges (100% Readable & Vibrant) */
        .badge-luxury-gold {
            background: rgba(245, 158, 11, 0.14) !important;
            border: 1.5px solid rgba(245, 158, 11, 0.55) !important;
            color: #fbbf24 !important;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 7px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.18);
        }

        .badge-luxury-cyan {
            background: rgba(56, 189, 248, 0.14) !important;
            border: 1.5px solid rgba(56, 189, 248, 0.55) !important;
            color: #38bdf8 !important;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 7px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.18);
        }

        .creator-title-name {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .creator-headline-text {
            color: #38bdf8;
            font-size: clamp(0.95rem, 2vw, 1.15rem);
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .creator-quote-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 16px 24px;
            max-width: 740px;
            margin: 0 auto 26px;
            color: #e2e8f0;
            font-size: 0.95rem;
            line-height: 1.7;
            position: relative;
        }

        /* Action Buttons */
        .btn-contact-custom {
            border-radius: 14px;
            padding: 11px 22px;
            font-weight: 700;
            font-size: 0.88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .btn-whatsapp-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4);
            border: 1px solid rgba(52, 211, 153, 0.3);
        }
        .btn-whatsapp-custom:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6);
        }

        .btn-email-custom {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(37, 99, 235, 0.4);
            border: 1px solid rgba(96, 165, 250, 0.3);
        }
        .btn-email-custom:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.6);
        }

        .btn-github-custom {
            background: rgba(30, 41, 59, 0.9);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
        }
        .btn-github-custom:hover {
            background: #ffffff;
            color: #050b18;
            border-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        /* Glass Content Cards */
        .glass-card-info {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.82) 0%, rgba(30, 41, 59, 0.5) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 22px;
            padding: 28px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .glass-card-info:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.45);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.5), 0 0 25px rgba(56, 189, 248, 0.15);
        }

        .section-icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.2) 0%, rgba(37, 99, 235, 0.2) 100%);
            border: 1.5px solid rgba(56, 189, 248, 0.45);
            color: #38bdf8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 16px;
            box-shadow: 0 0 18px rgba(56, 189, 248, 0.25);
        }

        /* Skill Badges */
        .skill-badge-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(56, 189, 248, 0.28);
            border-radius: 30px;
            padding: 7px 15px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.25s ease;
        }

        .skill-badge-item:hover {
            background: rgba(56, 189, 248, 0.18);
            border-color: #38bdf8;
            color: #38bdf8;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.25);
        }

        /* Social Profile Links */
        .btn-social-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #e2e8f0;
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.25s ease;
        }

        .btn-social-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: #38bdf8;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
        }

        /* Masterpiece Feature Cards */
        .feature-mini-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.75) 0%, rgba(30, 41, 59, 0.4) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            padding: 22px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .feature-mini-card:hover {
            transform: translateY(-3px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), 0 0 20px rgba(56, 189, 248, 0.15);
        }

        .feature-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 12px;
        }

        /* Call To Action Box */
        .cta-profile-box {
            background: radial-gradient(100% 100% at 50% 50%, rgba(37, 99, 235, 0.3) 0%, rgba(10, 16, 31, 0.95) 100%);
            border: 1.5px solid rgba(56, 189, 248, 0.35);
            border-radius: 26px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 40px rgba(37, 99, 235, 0.2);
            position: relative;
            overflow: hidden;
        }

        /* Footer */
        .creator-footer {
            background: rgba(4, 9, 20, 0.96);
            border-top: 1px solid var(--border-glass);
            padding: 28px 0;
            margin-top: auto;
            font-size: 0.84rem;
            color: #cbd5e1;
            position: relative;
            z-index: 10;
        }

        .creator-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .creator-footer a:hover {
            color: #38bdf8;
            text-decoration: underline;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 767.98px) {
            .creator-navbar {
                padding: 10px 0;
            }
            .profile-cover-banner {
                height: 110px;
            }
            .profile-avatar-outer {
                width: 115px;
                height: 115px;
                margin-top: -60px;
                margin-bottom: 12px;
            }
            .avatar-verified-seal {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }
            .creator-title-name {
                font-size: 1.65rem;
            }
            .creator-headline-text {
                font-size: 0.92rem;
            }
            .creator-quote-card {
                padding: 14px 16px;
                font-size: 0.88rem;
                margin-bottom: 20px;
            }
            .glass-card-info {
                padding: 20px 16px;
            }
            .btn-contact-custom {
                width: 100%;
                padding: 12px 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Orbs -->
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>
    <div class="ambient-orb ambient-orb-3"></div>

    <!-- NAVBAR -->
    <nav class="creator-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="creator-brand">
                @if(app_logo_url())
                    <img src="{{ app_logo_url() }}" alt="{{ app_setting('app_name') }}" style="max-height: 38px; max-width: 130px; object-fit: contain;">
                @else
                    <i class="bi bi-mortarboard-fill text-info fs-4"></i>
                @endif
                <span class="d-none d-sm-inline">{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-light border-opacity-25 btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('generator.index') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                    <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Coba Generator
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="container py-4 py-md-5 position-relative z-1">

        <!-- HERO PROFILE CARD -->
        <div class="profile-hero-card mb-5 text-center">
            
            <!-- COVER DECORATIVE BANNER -->
            <div class="profile-cover-banner">
                <div class="profile-cover-pattern"></div>
            </div>

            <div class="px-3 px-md-5 pb-4 pb-md-5">
                <!-- AVATAR -->
                <div class="profile-avatar-outer">
                    <img src="{{ $creator['avatar'] }}" alt="{{ $creator['name'] }}" class="profile-avatar-img">
                    <div class="avatar-verified-seal" title="Arsitek Pengembang Terverifikasi">
                        <i class="bi bi-check-lg"></i>
                    </div>
                </div>

                <!-- BADGES (HIGH CONTRAST & READABLE) -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                    <span class="badge-luxury-gold">
                        <i class="bi bi-patch-check-fill text-warning"></i> IDENTITAS KARYA & HAK CIPTA RESMI
                    </span>
                    <span class="badge-luxury-cyan">
                        <i class="bi bi-shield-lock-fill text-info"></i> ARSITEK & PENGEMBANG UTAMA
                    </span>
                </div>

                <!-- NAME & HEADLINE -->
                <h1 class="creator-title-name">
                    {{ $creator['name'] }}
                    <i class="bi bi-patch-check-fill text-primary ms-1" style="font-size: 0.65em;" title="Arsitek Terverifikasi"></i>
                </h1>
                <div class="creator-headline-text mb-3">
                    {{ $creator['headline'] }}
                </div>

                <!-- DEDICATION QUOTE CARD -->
                <div class="creator-quote-card">
                    <i class="bi bi-quote text-info fs-3 position-absolute top-0 start-0 translate-middle-y ms-3 opacity-50"></i>
                    {{ $creator['desc'] }}
                </div>

                <!-- ACTION BUTTONS -->
                <div class="d-flex flex-wrap justify-content-center gap-2.5">
                    @if(!empty($creator['whatsapp']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $creator['whatsapp']) }}" target="_blank" class="btn-contact-custom btn-whatsapp-custom">
                            <i class="bi bi-whatsapp fs-5"></i> Hubungi WhatsApp
                        </a>
                    @endif
                    @if(!empty($creator['email']))
                        <a href="mailto:{{ $creator['email'] }}" class="btn-contact-custom btn-email-custom">
                            <i class="bi bi-envelope-at-fill fs-5"></i> Kirim Email
                        </a>
                    @endif
                    @if(!empty($creator['github']))
                        <a href="{{ $creator['github'] }}" target="_blank" class="btn-contact-custom btn-github-custom">
                            <i class="bi bi-github fs-5"></i> GitHub Repository
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2-COLUMN PROFILE DETAILS -->
        <div class="row g-4 mb-5">
            <!-- BIOGRAFI & VISI DEDIKASI -->
            <div class="col-lg-7">
                <div class="glass-card-info">
                    <div class="section-icon-badge">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-3">Tentang Saya & Dedikasi Sistem</h4>
                    <p class="text-white-50 mb-4" style="line-height: 1.85; font-size: 0.94rem; color: #e2e8f0 !important;">
                        {{ $creator['bio'] }}
                    </p>
                    <div class="p-3.5 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10" style="border-left: 4px solid #38bdf8 !important;">
                        <div class="text-info fw-bold small mb-1 d-flex align-items-center gap-1.5">
                            <i class="bi bi-mortarboard-fill text-warning"></i> Latar Belakang & Spesialisasi:
                        </div>
                        <div class="small fw-medium" style="color: #cbd5e1; line-height: 1.6;">
                            {{ $creator['education'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- KEAHLIAN & TECH STACK -->
            <div class="col-lg-5">
                <div class="glass-card-info">
                    <div class="section-icon-badge">
                        <i class="bi bi-code-square"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-2">Keahlian & Pilar Teknologi</h4>
                    <p class="small mb-3" style="color: #cbd5e1;">
                        Kompetensi arsitektur rekayasa sistem yang diterapkan dalam pengembangan platform ini:
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($creator['skills'] as $skill)
                            <div class="skill-badge-item">
                                <i class="bi bi-check-circle-fill text-info"></i> {{ $skill }}
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-white border-opacity-10 my-3">

                    <h6 class="fw-bold text-white small mb-2.5">
                        <i class="bi bi-share me-1 text-warning"></i> Jejaring Sosial & Portofolio:
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if(!empty($creator['linkedin']))
                            <a href="{{ $creator['linkedin'] }}" target="_blank" class="btn-social-outline">
                                <i class="bi bi-linkedin text-info"></i> LinkedIn
                            </a>
                        @endif
                        @if(!empty($creator['instagram']))
                            <a href="{{ $creator['instagram'] }}" target="_blank" class="btn-social-outline">
                                <i class="bi bi-instagram text-danger"></i> Instagram
                            </a>
                        @endif
                        @if(!empty($creator['website']))
                            <a href="{{ $creator['website'] }}" target="_blank" class="btn-social-outline">
                                <i class="bi bi-globe text-primary"></i> Website Resmi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- FITUR-FITUR UTAMA YANG DIBANGUN OLEH PENGEMBANG -->
        <div class="mb-5">
            <div class="text-center mb-4">
                <span class="badge-luxury-cyan mb-2">
                    <i class="bi bi-stars"></i> MASTERPIECE ARSITEKTUR
                </span>
                <h3 class="fw-bold text-white mt-1">Inovasi Unggulan yang Telah Diimplementasikan</h3>
                <p class="small mx-auto" style="max-width: 620px; color: #cbd5e1;">
                    Sistem dirancang mandiri dari nol dengan integrasi kecerdasan pedagogi dan ketahanan performa tinggi.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">1-Klik All Generator</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Menghasilkan Modul Ajar, ATP, Prota, Promes, LKPD, dan Asesmen sekaligus dalam 1 kali eksekusi dengan dukungan trial tamu (maks. 2x).
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Deep Learning 3M</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Mengintegrasikan prinsip pembelajaran mendalam (Mindful, Meaningful, Joyful) berorientasi kebutuhan nyata Dunia Usaha dan Industri (DUDI).
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">BSKAP 046/2025 Ready</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Basis data Capaian Pembelajaran resmi terbaru merevisi No. 032/2024, dilengkapi mesin impor regulasi baru tanpa merusak arsip lama.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                            <i class="bi bi-database-check"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Pure PHP PDO Backup</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Pencadangan database mandiri tanpa ketergantungan utility mysqldump, 100% aman dan bekerja di shared hosting cPanel Rumahweb.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Realtime Traffic Monitor</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Pemantauan aktivitas pengunjung, tamu, user, dan jenis perangkat (Smartphone, Tablet, Desktop) secara langsung dari dasbor admin.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Full CMS Control</h6>
                        <p class="small mb-0" style="color: #cbd5e1; line-height: 1.6;">
                            Kustomisasi menyeluruh Logo, Favicon, 5 Tema Warna, Landing Page, dan Profil Pembuat langsung melalui akun Superadmin.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <div class="cta-profile-box p-4 p-md-5 text-center">
            <h3 class="fw-bold text-white mb-2">Siap Merasakan Efisiensi Perangkat Ajar Digital?</h3>
            <p class="small mb-4 mx-auto" style="max-width: 560px; color: #cbd5e1;">
                Manfaatkan generator perangkat ajar Kurikulum Merdeka SMK sekarang juga dan rasakan kemudahan mengajar dengan persiapan profesional.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2.5">
                <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-lg">
                    <i class="bi bi-lightning-charge-fill text-warning me-1.5"></i> Coba Generator Gratis (Maks. 2x)
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light border-opacity-25 rounded-pill px-4 py-2.5 fw-bold">
                    <i class="bi bi-person-plus-fill me-1.5"></i> Daftar Akun Guru (Akses Penuh)
                </a>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="creator-footer">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <strong>{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}</strong> &bull; Kurikulum Merdeka (Deep Learning).
                </div>
                <div>
                    Hak Cipta : <span class="text-white fw-semibold">Desain by. {{ $creator['name'] }}</span> &bull; &copy; {{ $creator['copyright_year'] }}
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2 border-top border-white border-opacity-10" style="font-size: 0.8rem;">
                <a href="{{ route('legal.privacy') }}">Kebijakan Privasi</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.terms') }}">Syarat & Ketentuan Layanan</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.about') }}">Tentang Kami</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.contact') }}">Kontak Kami</a>
                <span class="text-white-50">&bull;</span>
                <a href="{{ route('legal.disclaimer') }}">Pernyataan Penyangkalan (Disclaimer)</a>
            </div>
        </div>
    </footer>

    <!-- SCRIPT BOOTSTRAP 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
