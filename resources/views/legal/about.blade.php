<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami (About Us) - Sistem Perangkat Ajar SMK 2026</title>
    
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
        .legal-card h4 {
            color: #ffffff;
            font-weight: 700;
            margin-top: 28px;
            margin-bottom: 12px;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .legal-card h4 i {
            color: #38bdf8;
        }
        .legal-card p, .legal-card li {
            color: #cbd5e1;
            font-size: 0.92rem;
            line-height: 1.7;
        }
        .creator-badge-box {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.25) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1.5px solid rgba(56, 189, 248, 0.4);
            border-radius: 20px;
            padding: 24px;
            margin-top: 30px;
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
                            PROFIL RESMI PLATFORM
                        </span>
                        <h1 class="legal-title mb-2">Tentang Kami (About Us)</h1>
                        <p class="text-white-50 small mb-0">Sistem Perangkat Ajar Kurikulum Merdeka Jenjang SMK 2026</p>
                    </div>

                    <p>
                        <strong>Sistem Perangkat Ajar SMK 2026</strong> adalah platform teknologi pendidikan (EdTech) mandiri yang dibangun untuk menjawab tantangan beban administratif guru di Indonesia. Kami menyediakan solusi instan terintegrasi untuk menyusun dokumen perangkat ajar Kurikulum Merdeka berbasis <strong>Pendekatan Pembelajaran Mendalam (Deep Learning)</strong>: <em>Mindful</em> (Berkesadaran), <em>Meaningful</em> (Bermakna), dan <em>Joyful</em> (Menggembirakan).
                    </p>

                    <h4><i class="bi bi-bullseye"></i> Visi & Misi Kami</h4>
                    <ul>
                        <li><strong>Visi:</strong> Mewujudkan ekosistem pendidikan vokasi kejuruan yang unggul, terstandarisasi, dan berorientasi masa depan melalui kemudahan teknologi digital.</li>
                        <li><strong>Misi:</strong>
                            <ol class="mt-2">
                                <li>Memangkas waktu penyusunan perangkat ajar guru dari berminggu-minggu menjadi hitungan detik.</li>
                                <li>Mengintegrasikan sintaks pembelajaran <strong>PEDATTI</strong> (Pelajari, Dalami, Terapkan, Evaluasi) secara otomatis dan kontekstual.</li>
                                <li>Memperkuat pembentukan karakter siswa SMK melalui <strong>8 Dimensi Profil Lulusan (DPL)</strong>.</li>
                                <li>Mendukung penuh adopsi mata pelajaran pilihan prioritas nasional 2026: <strong>Koding dan Kecerdasan Artifisial (AI)</strong> di jenjang SMK.</li>
                            </ol>
                        </li>
                    </ul>

                    <h4><i class="bi bi-book-half"></i> Dasar Hukum & Acuan Regulasi</h4>
                    <p>Seluruh struktur kompetensi dan formulasi dokumen di dalam platform ini berpedoman langsung pada ketetapan pemerintah Republik Indonesia:</p>
                    <ul>
                        <li><strong>Keputusan Kepala BSKAP Kemendikbudristek Nomor 046/H/KR/2025</strong> tentang Capaian Pembelajaran pada Pendidikan Anak Usia Dini, Jenjang Pendidikan Dasar, dan Jenjang Pendidikan Menengah pada Kurikulum Merdeka.</li>
                        <li><strong>Permendikdasmen Nomor 13 Tahun 2025</strong> tentang Pedoman Pembelajaran dan Asesmen Kurikulum Merdeka.</li>
                    </ul>

                    <!-- CREATOR BADGE -->
                    <div class="creator-badge-box">
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-3 text-center text-sm-start">
                            <div class="rounded-circle bg-primary bg-opacity-25 border border-primary p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 64px; height: 64px;">
                                <i class="bi bi-person-fill-gear text-info fs-2"></i>
                            </div>
                            <div>
                                <div class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-2 py-0.5 rounded-pill mb-1" style="font-size: 0.72rem;">
                                    Arsitek & Pengembang Utama
                                </div>
                                <h4 class="text-white fw-bold mb-1 mt-0">Vicky Koroh</h4>
                                <p class="text-white-50 small mb-0">
                                    Didedikasikan secara penuh untuk kemajuan guru vokasi dan sekolah menengah kejuruan (SMK) di seluruh pelosok Tanah Air Indonesia. Hak Cipta Terlindungi &copy; 2026.
                                </p>
                            </div>
                        </div>
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
                <a href="{{ route('legal.about') }}" class="text-info text-decoration-none">Tentang Kami</a>
                <a href="{{ route('legal.contact') }}" class="text-white-50 text-decoration-none">Kontak</a>
                <a href="{{ route('legal.disclaimer') }}" class="text-white-50 text-decoration-none">Disclaimer</a>
            </div>
        </div>
    </footer>

</body>
</html>
