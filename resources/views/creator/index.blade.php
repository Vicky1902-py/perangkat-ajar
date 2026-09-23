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

    <!-- ADSENSE VERIFICATION & AUTO ADS -->
    @if(app_setting('adsense_enabled', '0') == '1')
        @if(app_setting('adsense_publisher_id'))
            <meta name="google-adsense-account" content="{{ app_setting('adsense_publisher_id') }}">
        @endif
        @if(app_setting('adsense_code'))
            {!! app_setting('adsense_code') !!}
        @endif
    @endif

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
            --kemendikdasmen-navy: #0b3b60;
            --kemendikdasmen-blue: #0284c7;
            --kemendikdasmen-sky: #e0f2fe;
            --text-main: #1e293b;
            --text-muted-custom: #64748b;
            --bg-canvas: #f8fafc;
            --card-border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Subtle Sky Blue Wash */
        .sky-wash {
            position: fixed;
            border-radius: 50%;
            filter: blur(140px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.5;
        }
        .sky-wash-1 {
            width: 480px;
            height: 480px;
            background: #bae6fd;
            top: -120px;
            left: -120px;
        }
        .sky-wash-2 {
            width: 520px;
            height: 520px;
            background: #e0f2fe;
            top: 25%;
            right: -140px;
        }

        /* Navbar - Clean White with Kemendikdasmen Navy */
        .creator-navbar {
            background: #ffffff;
            border-bottom: 2px solid #e2e8f0;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.05);
        }

        .creator-brand {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--kemendikdasmen-navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.2px;
        }

        /* Hero Profile Card */
        .profile-hero-card {
            background: #ffffff;
            border: 1.5px solid #bae6fd;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(11, 59, 96, 0.08);
            overflow: hidden;
            position: relative;
        }

        .profile-cover-banner {
            height: 150px;
            background: linear-gradient(135deg, #0b3b60 0%, #0284c7 60%, #38bdf8 100%);
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-cover-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
            background-size: 18px 18px;
            opacity: 0.5;
        }

        .profile-avatar-outer {
            width: 145px;
            height: 145px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            box-shadow: 0 8px 25px rgba(2, 132, 199, 0.35);
            position: relative;
            z-index: 2;
            margin: -75px auto 16px;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffffff;
        }

        .avatar-verified-seal {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: #0284c7;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #ffffff;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
            font-size: 0.95rem;
        }

        /* Badges */
        .badge-luxury-gold {
            background: #fffbeb !important;
            border: 1.5px solid #fde68a !important;
            color: #b45309 !important;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 7px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .badge-luxury-cyan {
            background: #e0f2fe !important;
            border: 1.5px solid #bae6fd !important;
            color: #0369a1 !important;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 7px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .creator-title-name {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 900;
            color: var(--kemendikdasmen-navy);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .creator-headline-text {
            color: var(--kemendikdasmen-blue);
            font-size: clamp(0.95rem, 2vw, 1.15rem);
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .creator-quote-card {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 18px;
            padding: 18px 24px;
            max-width: 740px;
            margin: 0 auto 26px;
            color: #334155;
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
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            border: none;
        }
        .btn-whatsapp-custom:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
        }

        .btn-email-custom {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.3);
            border: none;
        }
        .btn-email-custom:hover {
            background: linear-gradient(135deg, #0369a1 0%, #0b3b60 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
        }

        .btn-github-custom {
            background: #ffffff;
            border: 1.5px solid #0b3b60;
            color: #0b3b60;
            box-shadow: 0 2px 10px rgba(11, 59, 96, 0.08);
        }
        .btn-github-custom:hover {
            background: #0b3b60;
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Glass Content Cards */
        .glass-card-info {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 28px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.06);
            color: var(--text-main);
        }

        .glass-card-info:hover {
            transform: translateY(-4px);
            border-color: #7dd3fc;
            box-shadow: 0 12px 30px rgba(11, 59, 96, 0.1);
        }

        .glass-card-info h3, .glass-card-info h4, .glass-card-info h5 {
            color: var(--kemendikdasmen-navy) !important;
        }

        .section-icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #e0f2fe;
            border: 1.5px solid #bae6fd;
            color: #0284c7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 16px;
        }

        /* Skill Badges */
        .skill-badge-item {
            background: #e0f2fe;
            border: 1px solid #bae6fd;
            border-radius: 30px;
            padding: 7px 15px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #0369a1;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.25s ease;
        }

        .skill-badge-item:hover {
            background: #0284c7;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
        }

        /* Social Profile Links */
        .btn-social-outline {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
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
            background: #f0f9ff;
            color: #0284c7;
            border-color: #0284c7;
            transform: translateY(-2px);
        }

        /* Masterpiece Feature Cards */
        .feature-mini-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 12px rgba(11, 59, 96, 0.04);
        }

        .feature-mini-card:hover {
            transform: translateY(-3px);
            border-color: #7dd3fc;
            box-shadow: 0 8px 24px rgba(11, 59, 96, 0.08);
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
            background: linear-gradient(135deg, #0b3b60 0%, #0284c7 100%);
            border: 1.5px solid #0284c7;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(11, 59, 96, 0.15);
            position: relative;
            overflow: hidden;
            color: #ffffff;
        }

        /* Footer */
        .creator-footer {
            background: #0b3b60;
            border-top: 3px solid #0284c7;
            padding: 28px 0;
            margin-top: auto;
            font-size: 0.84rem;
            color: #e2e8f0;
            position: relative;
            z-index: 10;
        }

        .creator-footer a {
            color: #93c5fd;
            text-decoration: none;
            transition: color 0.2s;
        }

        .creator-footer a:hover {
            color: #ffffff;
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

    <!-- Ambient Subtle Sky Blue Wash -->
    <div class="sky-wash sky-wash-1"></div>
    <div class="sky-wash sky-wash-2"></div>

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
                    <h4 class="fw-bold mb-3" style="color: var(--kemendikdasmen-navy);">Tentang Saya & Dedikasi Sistem</h4>
                    <p class="mb-4" style="line-height: 1.85; font-size: 0.94rem; color: #334155 !important;">
                        {{ $creator['bio'] }}
                    </p>
                    <div class="p-3.5 rounded-3 bg-light border" style="border-left: 4px solid #0284c7 !important;">
                        <div class="text-primary fw-bold small mb-1 d-flex align-items-center gap-1.5">
                            <i class="bi bi-mortarboard-fill text-warning"></i> Latar Belakang & Spesialisasi:
                        </div>
                        <div class="small fw-medium" style="color: #475569; line-height: 1.6;">
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
                    <h4 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Keahlian & Pilar Teknologi</h4>
                    <p class="small mb-3" style="color: #64748b;">
                        Kompetensi arsitektur rekayasa sistem yang diterapkan dalam pengembangan platform ini:
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($creator['skills'] as $skill)
                            <div class="skill-badge-item">
                                <i class="bi bi-check-circle-fill text-primary"></i> {{ $skill }}
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-secondary border-opacity-25 my-3">

                    <h6 class="fw-bold small mb-2.5" style="color: var(--kemendikdasmen-navy);">
                        <i class="bi bi-share me-1 text-primary"></i> Jejaring Sosial & Portofolio:
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if(!empty($creator['linkedin']))
                            <a href="{{ $creator['linkedin'] }}" target="_blank" class="btn-social-outline">
                                <i class="bi bi-linkedin text-primary"></i> LinkedIn
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
                <h3 class="fw-bold mt-1" style="color: var(--kemendikdasmen-navy);">Inovasi Unggulan yang Telah Diimplementasikan</h3>
                <p class="small mx-auto" style="max-width: 620px; color: #475569;">
                    Sistem dirancang mandiri dari nol dengan integrasi kecerdasan pedagogi dan ketahanan performa tinggi.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Sistem Pakar Murni (Nol Halusinasi)</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Knowledge-Based Expert System murni berbasis database BSKAP 046/2025 tanpa menggunakan API Key eksternal berbayar, menjamin akurasi 100% dan bebas biaya token bagi seluruh guru.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-info bg-opacity-10 text-primary border border-info border-opacity-25">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Deep Learning 3M</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Mengintegrasikan prinsip pembelajaran mendalam (Mindful, Meaningful, Joyful) berorientasi kebutuhan nyata Dunia Usaha dan Industri (DUDI).
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">BSKAP 046/2025 Ready</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Basis data Capaian Pembelajaran resmi terbaru merevisi No. 032/2024, dilengkapi mesin impor regulasi baru tanpa merusak arsip lama.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                            <i class="bi bi-database-check"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Pure PHP PDO Backup</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Pencadangan database mandiri tanpa ketergantungan utility mysqldump, 100% aman dan bekerja di shared hosting cPanel Rumahweb.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Realtime Traffic Monitor</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Pemantauan aktivitas pengunjung, tamu, user, dan jenis perangkat (Smartphone, Tablet, Desktop) secara langsung dari dasbor admin.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-mini-card">
                        <div class="feature-icon-wrap bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: var(--kemendikdasmen-navy);">Full CMS Control</h6>
                        <p class="small mb-0" style="color: #475569; line-height: 1.6;">
                            Kustomisasi menyeluruh Logo, Favicon, 5 Tema Warna, Landing Page, dan Profil Pembuat langsung melalui akun Superadmin.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <div class="cta-profile-box p-4 p-md-5 text-center">
            <h3 class="fw-bold text-white mb-2">Siap Merasakan Efisiensi Perangkat Ajar Digital?</h3>
            <p class="small mb-4 mx-auto" style="max-width: 560px; color: #f0f9ff;">
                Manfaatkan generator perangkat ajar Kurikulum Merdeka SMK sekarang juga dan rasakan kemudahan mengajar dengan persiapan profesional.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2.5">
                <a href="{{ route('generator.index') }}" class="btn btn-warning rounded-pill px-4 py-2.5 fw-bold text-dark shadow">
                    <i class="bi bi-lightning-charge-fill me-1.5"></i> Coba Generator Gratis (Maks. 2x)
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light rounded-pill px-4 py-2.5 fw-bold">
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
