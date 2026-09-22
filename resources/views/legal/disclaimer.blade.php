<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pernyataan Penyangkalan (Disclaimer) - Sistem Perangkat Ajar SMK 2026</title>
    
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
        .legal-card ul {
            padding-left: 20px;
            margin-bottom: 16px;
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
                            PERNYATAAN HUKUM EDUKASI
                        </span>
                        <h1 class="legal-title mb-2">Pernyataan Penyangkalan (Disclaimer)</h1>
                        <p class="text-white-50 small mb-0">Sistem Perangkat Ajar SMK 2026 (guru.vxai.online)</p>
                    </div>

                    <p>
                        Dokumen Penyangkalan (*Disclaimer*) ini memuat ketentuan pembatasan tanggung jawab hukum dalam pemanfaatan seluruh materi, algoritma generator, dan berkas administrasi ajar yang disediakan oleh <strong>Sistem Perangkat Ajar SMK 2026</strong>.
                    </p>

                    <h4><i class="bi bi-info-circle-fill"></i> 1. Tujuan Edukatif & Pembantu Administrasi</h4>
                    <p>
                        Platform ini dikembangkan secara independen sebagai alat bantu produktivitas (*productivity tool*) bagi para pendidik vokasi di Indonesia guna menyusun rancangan pembelajaran Kurikulum Merdeka secara efisien. Materi yang dihasilkan merupakan rekomendasi pedagogis berbasis struktur Capaian Pembelajaran resmi.
                    </p>

                    <h4><i class="bi bi-bank"></i> 2. Hubungan dengan Instansi Pemerintah</h4>
                    <p>
                        Situs <strong>guru.vxai.online</strong> adalah platform inovasi mandiri (*independent platform*) yang dirancang oleh <strong>Vicky Koroh</strong>. Meskipun sistem ini mengacu dan menyelaraskan seluruh formulasinya dengan dokumen regulasi <strong>Keputusan Kepala BSKAP No. 046/H/KR/2025</strong> dan <strong>Permendikdasmen No. 13 Tahun 2025</strong>, platform ini tidak berafiliasi secara kelembagaan langsung dengan Kementerian Pendidikan Dasar dan Menengah Republik Indonesia, kecuali dalam kapasitas pematuhan kurikulum nasional.
                    </p>

                    <h4><i class="bi bi-sliders"></i> 3. Penyesuaian Kontekstual oleh Guru</h4>
                    <p>
                        Guru dan satuan pendidikan memiliki kemerdekaan profesional untuk mengadaptasi, menyunting, menambah, atau mengontekstualisasikan modul ajar, rubrik asesmen, dan LKPD yang dihasilkan oleh sistem generator sesuai dengan karakteristik peserta didik, potensi lokal daerah, serta kesiapan fasilitas praktik sekolah masing-masing.
                    </p>

                    <h4><i class="bi bi-link-45deg"></i> 4. Tautan Eksternal & Iklan Pihak Ketiga</h4>
                    <p>
                        Situs web kami mungkin memuat tautan menuju situs eksternal atau menayangkan iklan pihak ketiga (termasuk jaringan Google AdSense). Kami tidak memiliki kendali atas konten, kebijakan privasi, atau praktik situs pihak ketiga tersebut dan tidak bertanggung jawab atas kerugian yang mungkin timbul dari interaksi Anda dengan pihak luar tersebut.
                    </p>
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
                <a href="{{ route('legal.contact') }}" class="text-white-50 text-decoration-none">Kontak</a>
                <a href="{{ route('legal.disclaimer') }}" class="text-info text-decoration-none">Disclaimer</a>
            </div>
        </div>
    </footer>

</body>
</html>
