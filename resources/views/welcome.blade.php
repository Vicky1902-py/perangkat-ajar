<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perangkat Ajar SMK - Kurikulum Merdeka (Deep Learning)</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-glow: #2563eb;
            --accent-cyan: #38bdf8;
            --accent-indigo: #6366f1;
            --accent-amber: #fbbf24;
            --card-glass: rgba(15, 23, 42, 0.75);
            --card-border: rgba(255, 255, 255, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #050b18;
            background-image: 
                radial-gradient(circle at 10% 12%, rgba(37, 99, 235, 0.22) 0%, transparent 45%),
                radial-gradient(circle at 90% 25%, rgba(99, 102, 241, 0.20) 0%, transparent 45%),
                radial-gradient(circle at 50% 60%, rgba(14, 165, 233, 0.12) 0%, transparent 55%),
                linear-gradient(135deg, #030712 0%, #0b1329 50%, #0f172a 100%);
            color: #f8fafc;
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
            opacity: 0.6;
        }
        .ambient-orb-1 {
            top: 5%;
            left: 5%;
            width: 450px;
            height: 450px;
            background: rgba(37, 99, 235, 0.28);
        }
        .ambient-orb-2 {
            top: 35%;
            right: 5%;
            width: 500px;
            height: 500px;
            background: rgba(99, 102, 241, 0.25);
        }
        .ambient-orb-3 {
            bottom: 10%;
            left: 20%;
            width: 550px;
            height: 550px;
            background: rgba(14, 165, 233, 0.2);
        }

        /* Navbar */
        .landing-nav {
            background: rgba(11, 19, 41, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 1050;
            padding: 14px 0;
            transition: all 0.3s;
        }

        .brand-logo-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #38bdf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
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
            border-color: rgba(56, 189, 248, 0.35);
            box-shadow: 0 25px 50px -10px rgba(0, 0, 0, 0.7), 0 0 30px rgba(37, 99, 235, 0.2);
        }

        /* Hero Badges & Texts */
        .badge-regulasi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 40px;
            padding: 6px 16px;
            font-size: 0.82rem;
            color: #e2e8f0;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: -1px;
            color: #ffffff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #38bdf8 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            line-height: 1.7;
            color: #cbd5e1;
            max-width: 760px;
        }

        /* Buttons */
        .btn-glow-primary {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #6366f1 100%);
            color: #ffffff !important;
            border: none;
            padding: 13px 26px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.96rem;
            box-shadow: 0 4px 25px rgba(37, 99, 235, 0.5);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.7);
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #4f46e5 100%);
        }

        .btn-glow-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: #0f172a !important;
            border: none;
            padding: 13px 26px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.96rem;
            box-shadow: 0 4px 25px rgba(245, 158, 11, 0.45);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glow-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.65);
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .btn-glass-outline {
            background: rgba(30, 41, 59, 0.6);
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            color: #ffffff !important;
            padding: 13px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.96rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-glass-outline:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--accent-cyan);
            transform: translateY(-2px);
        }

        /* Feature Icon Box */
        .feature-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 18px;
        }

        /* 3M Deep Learning Pillar Cards */
        .pillar-card {
            border-left: 4px solid;
            background: rgba(15, 23, 42, 0.7);
            border-radius: 16px;
            padding: 20px;
        }
        .pillar-mindful { border-left-color: #38bdf8; }
        .pillar-meaningful { border-left-color: #fbbf24; }
        .pillar-joyful { border-left-color: #34d399; }

        /* Document Badge Tag */
        .doc-tag {
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 0.78rem;
            color: #93c5fd;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Creator Showcase Box */
        .creator-box {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.35) 0%, rgba(15, 23, 42, 0.85) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 24px;
            box-shadow: 0 0 35px rgba(37, 99, 235, 0.25);
        }

        /* Responsive Mobile Tweak */
        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 1.85rem !important;
                line-height: 1.25;
            }
            .hero-subtitle {
                font-size: 0.92rem !important;
            }
            .btn-glow-primary, .btn-glow-gold, .btn-glass-outline {
                width: 100%;
                justify-content: center;
                padding: 11px 18px;
                font-size: 0.88rem;
            }
            .badge-regulasi {
                font-size: 0.72rem;
                padding: 5px 12px;
            }
            .glass-card {
                border-radius: 16px;
                padding: 16px !important;
            }
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
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <div class="brand-logo-badge">
                    <i class="bi bi-journal-bookmark-fill text-white fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-white fs-6 mb-0 d-flex align-items-center gap-2">
                        <span>Sistem Perangkat Ajar</span>
                        <span class="badge bg-primary bg-opacity-25 border border-primary border-opacity-50 text-info px-2 py-0.5" style="font-size: 0.68rem;">SMK 2025</span>
                    </div>
                    <div class="text-white-50 small" style="font-size: 0.72rem;">Kurikulum Merdeka &bull; Deep Learning</div>
                </div>
            </a>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-glow-primary px-3 py-2">
                        <i class="bi bi-speedometer2"></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-warning fw-bold px-3 py-2 rounded-pill d-none d-md-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.82rem;">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Coba Gratis 2x</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light border-opacity-25 rounded-pill px-3 py-2" style="font-size: 0.82rem;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-2 shadow-sm" style="font-size: 0.82rem;">
                        <i class="bi bi-person-plus-fill me-1"></i> Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="py-5 py-lg-6 position-relative z-1">
        <div class="container text-center">
            
            <!-- REGULATION PILL BADGE -->
            <div class="mb-4">
                <span class="badge-regulasi">
                    <i class="bi bi-patch-check-fill text-warning fs-6"></i>
                    <span>Keputusan Kepala BSKAP No. 046/H/KR/2025 &bull; Permendikdasmen No. 13 Tahun 2025</span>
                </span>
            </div>

            <!-- MAIN HERO TITLE -->
            <h1 class="hero-title mb-3">
                Revolusi Penyusunan Perangkat Ajar SMK Berbasis <br class="d-none d-lg-block">
                <span class="gradient-text">Pendekatan Pembelajaran Mendalam</span>
            </h1>

            <!-- HERO SUBTITLE -->
            <p class="hero-subtitle mx-auto mb-4">
                Platform cerdas otomatisasi penyusunan <strong>Tujuan Pembelajaran (TP)</strong>, <strong>Alur Tujuan Pembelajaran (ATP)</strong>, 
                <strong>Modul Ajar PEDATTI</strong>, <strong>LKPD</strong>, <strong>Prota</strong>, <strong>Promes</strong>, hingga 
                <strong>Instrumen Asesmen</strong> lengkap dengan Kop Surat Kedinasan Resmi Sekolah.
            </p>

            <!-- CALL TO ACTIONS -->
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mb-5">
                <a href="{{ route('generator.index') }}" class="btn-glow-gold">
                    <i class="bi bi-lightning-charge-fill fs-5"></i>
                    <span>Coba Generator Gratis (Maks. 2x)</span>
                </a>
                <a href="{{ route('login') }}" class="btn-glow-primary">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk ke Sistem</span>
                </a>
                <a href="{{ route('register') }}" class="btn-glass-outline">
                    <i class="bi bi-person-plus-fill fs-5"></i>
                    <span>Daftar Akun Guru</span>
                </a>
            </div>

            <!-- QUICK PILL METRICS -->
            <div class="d-flex flex-wrap justify-content-center gap-2 pt-2">
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> 8 Dimensi Profil Lulusan (DPL)</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Sintaks PEDATTI Terintegrasi</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Pilar 3M (Mindful, Meaningful, Joyful)</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Ekspor PDF Ber-Kop Surat Resmi</span>
                <span class="doc-tag"><i class="bi bi-check-circle-fill text-success"></i> Prioritas Mapel Koding & AI 2025</span>
            </div>
        </div>
    </header>

    <!-- SECTION: 3 PILAR DEEP LEARNING (3M) -->
    <section class="py-5 position-relative z-1">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill small fw-semibold mb-2">
                    FILOSOFI PEMBELAJARAN
                </span>
                <h2 class="fw-bold text-white fs-2 mb-2">Pendekatan Pembelajaran Mendalam (Deep Learning)</h2>
                <p class="text-white-50 small" style="max-width: 600px; margin: 0 auto;">
                    Bukan sekadar hafalan teknis, pembelajaran di SMK dirancang menyentuh kesadaran, kebermaknaan, dan kegembiraan belajar siswa.
                </p>
            </div>

            <div class="row g-4">
                <!-- MINDFUL -->
                <div class="col-md-4">
                    <div class="pillar-card pillar-mindful h-100">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-compass text-info fs-3"></i>
                            <h4 class="fw-bold text-white mb-0">Mindful</h4>
                        </div>
                        <div class="text-info fw-semibold small mb-2">Pembelajaran Berkesadaran</div>
                        <p class="text-white-50 small mb-0 leading-relaxed">
                            Mendorong peserta didik menyadari tujuan belajar, mengaitkan materi dengan potensi diri, dan hadir secara utuh dalam setiap proses eksplorasi kompetensi kejuruan.
                        </p>
                    </div>
                </div>

                <!-- MEANINGFUL -->
                <div class="col-md-4">
                    <div class="pillar-card pillar-meaningful h-100">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-lightbulb text-warning fs-3"></i>
                            <h4 class="fw-bold text-white mb-0">Meaningful</h4>
                        </div>
                        <div class="text-warning fw-semibold small mb-2">Pembelajaran Bermakna</div>
                        <p class="text-white-50 small mb-0 leading-relaxed">
                            Menghubungkan setiap capaian pembelajaran dengan kebutuhan nyata Dunia Usaha & Dunia Industri (DUDI), pemecahan masalah riil, dan karier masa depan.
                        </p>
                    </div>
                </div>

                <!-- JOYFUL -->
                <div class="col-md-4">
                    <div class="pillar-card pillar-joyful h-100">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-emoji-smile text-success fs-3"></i>
                            <h4 class="fw-bold text-white mb-0">Joyful</h4>
                        </div>
                        <div class="text-success fw-semibold small mb-2">Pembelajaran Menggembirakan</div>
                        <p class="text-white-50 small mb-0 leading-relaxed">
                            Menciptakan ruang belajar kolaboratif yang interaktif, menumbuhkan antusiasme eksperimen, rasa ingin tahu yang tinggi, dan kepuasan atas hasil karya vokasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: KEUNGGULAN & FITUR UTAMA -->
    <section class="py-5 position-relative z-1">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small fw-semibold mb-2">
                    FITUR & KELEBIHAN UNGGULAN
                </span>
                <h2 class="fw-bold text-white fs-2 mb-2">Solusi Menyeluruh untuk Guru & Sekolah SMK</h2>
                <p class="text-white-50 small" style="max-width: 650px; margin: 0 auto;">
                    Dirancang khusus menghemat waktu administratif guru dari berminggu-minggu menjadi hitungan detik dengan dokumen yang siap cetak dan terakreditasi kedinasan.
                </p>
            </div>

            <div class="row g-4">
                <!-- FITUR 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4 h-100">
                        <div class="feature-icon-box bg-primary bg-opacity-20 text-primary border border-primary border-opacity-30">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Generator 1-Klik Otomatis</h5>
                        <p class="text-white-50 small mb-0">
                            Cukup pilih mata pelajaran dan fase, sistem cerdas akan otomatis merumuskan TP, ATP, Modul Ajar, LKPD, Prota, Promes, dan Asesmen secara serentak.
                        </p>
                    </div>
                </div>

                <!-- FITUR 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4 h-100">
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
                    <div class="glass-card p-4 h-100">
                        <div class="feature-icon-box bg-success bg-opacity-20 text-success border border-success border-opacity-30">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">8 Dimensi Profil Lulusan (DPL)</h5>
                        <p class="text-white-50 small mb-0">
                            Terintegrasi penuh menanamkan keimanan, kewargaan, penalaran kritis, kreativitas, kolaborasi, kemandirian, kesehatan jasmani-rohani, dan komunikasi efektif.
                        </p>
                    </div>
                </div>

                <!-- FITUR 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4 h-100">
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
                    <div class="glass-card p-4 h-100">
                        <div class="feature-icon-box bg-danger bg-opacity-20 text-danger border border-danger border-opacity-30">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-2">Mapel Koding & Kecerdasan Buatan (AI)</h5>
                        <p class="text-white-50 small mb-0">
                            Mendukung implementasi mata pelajaran pilihan prioritas nasional 2025 Koding & AI untuk Fase E dan F di seluruh program keahlian SMK.
                        </p>
                    </div>
                </div>

                <!-- FITUR 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4 h-100">
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

    <!-- SECTION: CARA KERJA (WORKFLOW) -->
    <section class="py-5 position-relative z-1">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill small fw-semibold mb-2">
                    ALUR KERJA
                </span>
                <h2 class="fw-bold text-white fs-2 mb-2">Hanya 3 Langkah Mudah</h2>
            </div>

            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="rounded-circle bg-primary text-white fs-4 fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            1
                        </div>
                        <h5 class="fw-bold text-white mb-2">Tentukan Parameter</h5>
                        <p class="text-white-50 small mb-0">Pilih mata pelajaran SMK, jenjang fase (E/F), kelas, semester, dan elemen kompetensi yang dituju.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="rounded-circle bg-info text-white fs-4 fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            2
                        </div>
                        <h5 class="fw-bold text-white mb-2">Generate Sekali Klik</h5>
                        <p class="text-white-50 small mb-0">Engine sistem cerdas memformulasikan seluruh paket TP, ATP, Modul PEDATTI, LKPD, hingga rubrik asesmen.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="rounded-circle bg-success text-white fs-4 fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            3
                        </div>
                        <h5 class="fw-bold text-white mb-2">Review & Cetak PDF</h5>
                        <p class="text-white-50 small mb-0">Periksa instrumen pembelajaran dan cetak dokumen kedinasan resmi siap tandatangan dan siap supervisi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: CREATOR SHOWCASE & COPYRIGHT -->
    <section class="py-5 position-relative z-1">
        <div class="container">
            <div class="creator-box p-4 p-md-5 text-center">
                <div class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill small fw-bold mb-3">
                    <i class="bi bi-patch-check-fill me-1"></i> IDENTITAS KARYA & HAK CIPTA RESMI
                </div>
                <h3 class="fw-bold text-white mb-2">Sistem Perangkat Ajar Kurikulum Merdeka</h3>
                <p class="text-white-50 mb-3" style="max-width: 600px; margin: 0 auto; font-size: 0.95rem;">
                    Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.
                </p>
                <div class="fs-5 fw-bold text-info mb-1">
                    <i class="bi bi-award me-1"></i> Desain & Pengembangan oleh: <span class="text-white">Vicky Koroh</span>
                </div>
                <div class="text-white-50 small mb-4">
                    Super Administrator & Lead Architect &bull; Hak Cipta Terlindungi &copy; {{ date('Y') }}
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-glow-gold px-4 py-2">
                        <i class="bi bi-lightning-charge-fill"></i> Coba Gratis Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-4 py-2 rounded-pill">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 border-top border-white border-opacity-10 position-relative z-1 text-center text-white-50 small">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                <div>
                    <strong>Sistem Perangkat Ajar SMK</strong> &bull; Kurikulum Merdeka (Deep Learning).
                </div>
                <div>
                    Hak Cipta : <span class="text-white fw-semibold">Desain by. Vicky Koroh</span> &bull; &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
