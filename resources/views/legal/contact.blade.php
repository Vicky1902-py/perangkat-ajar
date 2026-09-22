<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami (Contact Us) - Sistem Perangkat Ajar SMK 2026</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Open Graph & SEO -->
    @include('layouts.partials.og-meta')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #050b18;
            background-image: 
                radial-gradient(circle at 10% 15%, rgba(37, 99, 235, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 90% 85%, rgba(99, 102, 241, 0.15) 0%, transparent 45%),
                linear-gradient(135deg, #030712 0%, #0b1329 50%, #0f172a 100%);
            color: #f8fafc;
            min-height: 100vh;
        }
        .legal-header {
            background: rgba(11, 19, 41, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 1050;
            padding: 12px 0;
        }
        .legal-card {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            padding: 40px;
        }
        .legal-title {
            color: #38bdf8;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .contact-channel-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
            transition: all 0.25s ease;
        }
        .contact-channel-card:hover {
            border-color: #38bdf8;
            transform: translateY(-2px);
        }
        @media (max-width: 767.98px) {
            .legal-card {
                padding: 22px 16px !important;
                border-radius: 16px;
            }
            .legal-title {
                font-size: 1.4rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header class="legal-header">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="rounded-3 bg-primary p-2 text-white shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div class="fw-bold text-white small">Sistem Perangkat Ajar SMK 2026</div>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 text-white-50" style="font-size: 0.8rem;">
                    <i class="bi bi-arrow-left me-1"></i> Beranda
                </a>
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1" style="font-size: 0.8rem;">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT CONTAINER -->
    <main class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="legal-card">
                    <div class="text-center mb-4 pb-3 border-bottom border-white border-opacity-10">
                        <span class="badge bg-primary bg-opacity-20 text-info border border-primary border-opacity-30 px-3 py-1 rounded-pill small fw-bold mb-2">
                            LAYANAN BANTUAN & NARAHUBUNG
                        </span>
                        <h1 class="legal-title mb-2">Hubungi Kami (Contact Us)</h1>
                        <p class="text-white-50 small mb-0">Tim Pengembang & Dukungan Teknis Sistem Perangkat Ajar SMK 2026</p>
                    </div>

                    <p class="text-center text-white-50 mb-4" style="max-width: 650px; margin: 0 auto;">
                        Kami siap membantu Anda terkait kendala teknis, pertanyaan operasional generator, permohonan kemitraan sekolah, atau masukan pengembangan fitur kurikulum.
                    </p>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="contact-channel-card text-center">
                                <div class="rounded-circle bg-primary bg-opacity-20 text-info mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                    <i class="bi bi-envelope-at-fill fs-4"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-1">Email Resmi</h5>
                                <p class="text-white-50 small mb-2">Layanan respon dalam 1x24 jam</p>
                                <a href="mailto:admin@admin.com" class="text-info fw-semibold small text-decoration-none">admin@admin.com</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="contact-channel-card text-center">
                                <div class="rounded-circle bg-success bg-opacity-20 text-success mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                    <i class="bi bi-whatsapp fs-4"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-1">Dukungan Guru</h5>
                                <p class="text-white-50 small mb-2">Konsultasi cepat guru vokasi</p>
                                <span class="text-success fw-semibold small">+62 821-XXXX-XXXX</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="contact-channel-card text-center">
                                <div class="rounded-circle bg-warning bg-opacity-20 text-warning mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                    <i class="bi bi-person-badge-fill fs-4"></i>
                                </div>
                                <h5 class="text-white fw-bold mb-1">Lead Developer</h5>
                                <p class="text-white-50 small mb-2">Pengembangan & Kemitraan</p>
                                <span class="text-warning fw-semibold small">Vicky Koroh</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 p-md-4 rounded-3 border border-white border-opacity-10 bg-dark bg-opacity-50">
                        <div class="d-flex align-items-center gap-2 mb-2 text-info fw-bold small">
                            <i class="bi bi-clock-history"></i> Jam Layanan & Operasional:
                        </div>
                        <p class="text-white-50 small mb-0">
                            Server dan generator 1-klik online 24 jam sehari, 7 hari seminggu. Dukungan verifikasi akun dan supervisi satuan pendidikan dilayani pada hari Senin &ndash; Jumat pukul 08.00 &ndash; 17.00 WIB.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER LEGAL LINKS -->
    <footer class="py-4 border-top border-white border-opacity-10 text-center text-white-50 small">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
            <div>
                Sistem Perangkat Ajar SMK 2026 &bull; Hak Cipta : <span class="text-white">Desain by. Vicky Koroh</span> &copy; 2026
            </div>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('legal.privacy') }}" class="text-white-50 text-decoration-none">Kebijakan Privasi</a>
                <a href="{{ route('legal.terms') }}" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a>
                <a href="{{ route('legal.about') }}" class="text-white-50 text-decoration-none">Tentang Kami</a>
                <a href="{{ route('legal.contact') }}" class="text-info text-decoration-none">Kontak</a>
                <a href="{{ route('legal.disclaimer') }}" class="text-white-50 text-decoration-none">Disclaimer</a>
            </div>
        </div>
    </footer>

</body>
</html>
