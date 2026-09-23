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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- THEME COLORS DINAMIS -->
    @php
        $themeColors = app_theme_colors();
    @endphp
    <style>
        :root {
            --primary-color: {{ $themeColors['primary'] }};
            --accent-cyan: {{ $themeColors['cyan'] }};
            --accent-indigo: {{ $themeColors['indigo'] }};
            --bg-dark: #050b18;
            --bg-card: rgba(15, 23, 42, 0.75);
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
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 55%);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* High contrast overrides for dark theme */
        .text-white-50 {
            color: #cbd5e1 !important;
        }
        .text-secondary {
            color: #cbd5e1 !important;
        }
        .text-muted {
            color: #cbd5e1 !important;
        }

        /* Navbar */
        .creator-navbar {
            background: rgba(5, 11, 24, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .creator-brand {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Hero Profile Card */
        .profile-hero-card {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 28px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 40px rgba(56, 189, 248, 0.15);
            overflow: hidden;
            position: relative;
        }

        .profile-hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.4), rgba(99, 102, 241, 0.3), rgba(56, 189, 248, 0.2));
            z-index: 0;
        }

        .profile-avatar-outer {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            padding: 5px;
            background: linear-gradient(135deg, #38bdf8 0%, #2563eb 50%, #6366f1 100%);
            box-shadow: 0 0 35px rgba(56, 189, 248, 0.4);
            position: relative;
            z-index: 1;
            margin: 30px auto 16px;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #050b18;
        }

        /* Glass Content Cards */
        .glass-card-info {
            background: rgba(30, 41, 59, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 26px;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
            height: 100%;
        }

        .glass-card-info:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .section-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: #38bdf8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 14px;
        }

        /* Skill Badges */
        .skill-badge-item {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 30px;
            padding: 6px 16px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .skill-badge-item:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: #38bdf8;
            color: #38bdf8;
            transform: translateY(-2px);
        }

        /* Contact Action Buttons */
        .btn-contact-custom {
            border-radius: 14px;
            padding: 12px 20px;
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
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.35);
        }
        .btn-whatsapp-custom:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .btn-email-custom {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(37, 99, 235, 0.35);
        }
        .btn-email-custom:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
        }

        .btn-github-custom {
            background: rgba(30, 41, 59, 0.9);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }
        .btn-github-custom:hover {
            background: #ffffff;
            color: #050b18;
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-social-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #cbd5e1;
        }
        .btn-social-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: #38bdf8;
            transform: translateY(-2px);
        }

        /* Footer */
        .creator-footer {
            background: rgba(5, 11, 24, 0.95);
            border-top: 1px solid var(--border-glass);
            padding: 30px 0;
            margin-top: auto;
            font-size: 0.84rem;
            color: #cbd5e1;
        }

        .creator-footer a {
            color: #e2e8f0;
            text-decoration: none;
            transition: color 0.2s;
        }

        .creator-footer a:hover {
            color: #38bdf8;
        }

        @media (max-width: 767.98px) {
            .profile-avatar-outer {
                width: 120px;
                height: 120px;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="creator-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="creator-brand">
                @if(app_logo_url())
                    <img src="{{ app_logo_url() }}" alt="{{ app_setting('app_name') }}" style="max-height: 40px; max-width: 140px; object-fit: contain;">
                @else
                    <i class="bi bi-mortarboard-fill text-info fs-4"></i>
                @endif
                <span class="d-none d-sm-inline">{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK') }}</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-light border-opacity-25 btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('generator.index') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Coba Generator
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="container py-5">

        <!-- HERO PROFILE CARD -->
        <div class="profile-hero-card p-4 p-md-5 mb-5 text-center">
            
            <!-- AVATAR -->
            <div class="profile-avatar-outer">
                <img src="{{ $creator['avatar'] }}" alt="{{ $creator['name'] }}" class="profile-avatar-img">
            </div>

            <!-- BADGES -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill small fw-bold">
                    <i class="bi bi-patch-check-fill me-1"></i> IDENTITAS KARYA & HAK CIPTA RESMI
                </span>
                <span class="badge bg-primary bg-opacity-20 text-info border border-info border-opacity-30 px-3 py-1.5 rounded-pill small fw-bold">
                    <i class="bi bi-shield-lock-fill me-1"></i> ARSITEK & PENGEMBANG UTAMA
                </span>
            </div>

            <!-- NAME & HEADLINE -->
            <h1 class="display-6 fw-extrabold text-white mb-2 fw-bold">
                {{ $creator['name'] }}
            </h1>
            <div class="text-info fs-5 fw-semibold mb-3">
                {{ $creator['headline'] }}
            </div>

            <!-- SUBTITLE DEDIKASI -->
            <p class="text-white-50 mx-auto mb-4" style="max-width: 680px; font-size: 0.96rem; line-height: 1.6;">
                {{ $creator['desc'] }}
            </p>

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

        <div class="row g-4 mb-5">
            <!-- BIOGRAFI & VISI DEDIKASI -->
            <div class="col-lg-7">
                <div class="glass-card-info">
                    <div class="section-icon-badge">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-3">Tentang Saya & Dedikasi Sistem</h4>
                    <p class="text-secondary small mb-3" style="line-height: 1.8; font-size: 0.92rem; color: #cbd5e1 !important;">
                        {{ $creator['bio'] }}
                    </p>
                    <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10 mt-3">
                        <div class="text-info fw-bold small mb-1">
                            <i class="bi bi-mortarboard-fill me-1"></i> Latar Belakang & Spesialisasi:
                        </div>
                        <div class="text-white-50 small">
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
                    <h4 class="fw-bold text-white mb-3">Keahlian & Pilar Teknologi</h4>
                    <p class="text-white-50 small mb-3">
                        Kompetensi arsitektur rekayasa sistem yang diterapkan dalam pengembangan platform ini:
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($creator['skills'] as $skill)
                            <div class="skill-badge-item">
                                <i class="bi bi-check-circle-fill text-info"></i> {{ $skill }}
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-secondary opacity-25 my-3">

                    <h6 class="fw-bold text-white small mb-2"><i class="bi bi-share me-1 text-warning"></i> Jejaring Sosial & Portofolio:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if(!empty($creator['linkedin']))
                            <a href="{{ $creator['linkedin'] }}" target="_blank" class="btn-contact-custom btn-social-outline py-2 px-3 small">
                                <i class="bi bi-linkedin text-info"></i> LinkedIn
                            </a>
                        @endif
                        @if(!empty($creator['instagram']))
                            <a href="{{ $creator['instagram'] }}" target="_blank" class="btn-contact-custom btn-social-outline py-2 px-3 small">
                                <i class="bi bi-instagram text-danger"></i> Instagram
                            </a>
                        @endif
                        @if(!empty($creator['website']))
                            <a href="{{ $creator['website'] }}" target="_blank" class="btn-contact-custom btn-social-outline py-2 px-3 small">
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
                <span class="badge bg-primary bg-opacity-20 text-info border border-info border-opacity-30 px-3 py-1.5 rounded-pill small fw-bold mb-2">
                    <i class="bi bi-stars me-1"></i> MASTERPIECE ARSITEKTUR
                </span>
                <h3 class="fw-bold text-white">Inovasi Unggulan yang Telah Diimplementasikan</h3>
                <p class="text-white-50 small" style="max-width: 600px; margin: 0 auto;">
                    Sistem dirancang mandiri dari nol dengan integrasi kecerdasan pedagogi dan ketahanan performa tinggi.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-lightning-charge-fill text-warning fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">1-Klik All Generator</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Menghasilkan Modul Ajar, ATP, Prota, Promes, LKPD, dan Asesmen sekaligus dalam 1 kali eksekusi dengan dukungan trial tamu (maks. 2x).
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-diagram-3-fill text-info fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">Deep Learning 3M</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Mengintegrasikan prinsip pembelajaran mendalam (Mindful, Meaningful, Joyful) berorientasi kebutuhan nyata Dunia Usaha dan Industri (DUDI).
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-patch-check-fill text-success fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">BSKAP 046/2025 Ready</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Basis data Capaian Pembelajaran resmi terbaru merevisi No. 032/2024, dilengkapi mesin impor regulasi baru tanpa merusak arsip lama.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-database-check text-primary fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">Pure PHP PDO Backup</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Pencadangan database mandiri tanpa ketergantungan utility mysqldump, 100% aman dan bekerja di shared hosting cPanel Rumahweb.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-activity text-danger fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">Realtime Traffic Monitor</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Pemantauan aktivitas pengunjung, tamu, user, dan jenis perangkat (Smartphone, Tablet, Desktop) secara langsung dari dasbor admin.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card-info p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-sliders text-warning fs-4"></i>
                            <h6 class="fw-bold text-white mb-0">Full CMS Control</h6>
                        </div>
                        <p class="text-white-50 small mb-0">
                            Kustomisasi menyeluruh Logo, Favicon, 5 Tema Warna, Landing Page, dan Profil Pembuat langsung melalui akun Superadmin.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <div class="p-4 p-md-5 rounded-4 text-center" style="background: radial-gradient(100% 100% at 50% 50%, rgba(37, 99, 235, 0.25) 0%, rgba(15, 23, 42, 0.8) 100%); border: 1px solid rgba(56, 189, 248, 0.3);">
            <h3 class="fw-bold text-white mb-2">Siap Merasakan Efisiensi Perangkat Ajar Digital?</h3>
            <p class="text-white-50 small mb-4" style="max-width: 540px; margin: 0 auto;">
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
            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2 border-top border-white border-opacity-5" style="font-size: 0.76rem;">
                <a href="{{ route('legal.privacy') }}">Kebijakan Privasi</a>
                <span>&bull;</span>
                <a href="{{ route('legal.terms') }}">Syarat & Ketentuan</a>
                <span>&bull;</span>
                <a href="{{ route('legal.about') }}">Tentang Kami</a>
                <span>&bull;</span>
                <a href="{{ route('legal.contact') }}">Kontak</a>
                <span>&bull;</span>
                <a href="{{ route('legal.disclaimer') }}">Disclaimer</a>
            </div>
        </div>
    </footer>

    <!-- SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
