<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi (Privacy Policy) - Sistem Perangkat Ajar SMK 2026</title>
    
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
                            DOKUMEN KEBIJAKAN RESMI
                        </span>
                        <h1 class="legal-title mb-2">Kebijakan Privasi (Privacy Policy)</h1>
                        <p class="text-white-50 small mb-0">Terakhir diperbarui: 23 September 2026 &bull; Sistem Perangkat Ajar SMK (guru.vxai.online)</p>
                    </div>

                    <p>
                        Selamat datang di <strong>Sistem Perangkat Ajar SMK 2026</strong> (dapat diakses melalui <a href="{{ url('/') }}" class="text-info text-decoration-none">https://guru.vxai.online</a>). Kami sangat menghargai privasi Anda dan berkomitmen penuh untuk melindungi informasi pribadi pendidik, guru, tenaga kependidikan, serta pengunjung situs kami sesuai dengan standar regulasi perlindungan data yang berlaku di Indonesia (UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi / UU PDP) serta standar kepatuhan program <strong>Google AdSense</strong>.
                    </p>

                    <h4><i class="bi bi-shield-check"></i> 1. Informasi yang Kami Kumpulkan</h4>
                    <p>Kami mengumpulkan data untuk memberikan layanan terbaik dalam penyusunan perangkat ajar, meliputi:</p>
                    <ul>
                        <li><strong>Data Akun Pendidik:</strong> Nama lengkap, gelar, alamat email, NIP/NUPTK (opsional), mata pelajaran yang diampu, serta satuan pendidikan asal ketika Anda mendaftar akun.</li>
                        <li><strong>Data Input Kurikulum:</strong> Elemen Capaian Pembelajaran (CP), Tujuan Pembelajaran (TP), dan parameter fase yang Anda pilih untuk membuat dokumen Modul Ajar dan LKPD.</li>
                        <li><strong>Log Data Teknis:</strong> Alamat Protokol Internet (IP Address), jenis peramban (browser), sistem operasi perangkat (Android, iOS, Windows, macOS), jenis perangkat (Smartphone/Komputer), tanggal/waktu akses, serta halaman rujukan untuk keperluan diagnostik dan keamanan sistem.</li>
                    </ul>

                    <h4><i class="bi bi-cookie"></i> 2. Penggunaan Cookie & Web Beacon</h4>
                    <p>
                        Situs kami menggunakan <em>cookies</em> untuk menyimpan preferensi sesi pengunjung, memastikan keamanan autentikasi login, serta melacak kuota uji coba generator gratis (maksimal 2 kali bagi pengguna tamu). Cookie tidak dapat digunakan untuk menjalankan program atau mengirimkan virus ke perangkat Anda.
                    </p>

                    <h4><i class="bi bi-google"></i> 3. Kebijakan Iklan Google AdSense & Cookie DoubleClick DART</h4>
                    <p>
                        Google, sebagai vendor pihak ketiga, menggunakan cookie untuk menayangkan iklan di situs kami:
                    </p>
                    <ul>
                        <li>Penggunaan cookie DART oleh Google memungkinkannya menampilkan iklan kepada pengguna kami berdasarkan kunjungan mereka ke situs ini dan situs web lain di internet.</li>
                        <li>Pengguna dapat memilih untuk menyisihkan penggunaan cookie DART dengan mengunjungi Kebijakan Privasi jaringan iklan dan konten Google di URL berikut: <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener noreferrer" class="text-info text-decoration-none">https://policies.google.com/technologies/ads</a>.</li>
                        <li>Mitra periklanan kami lainnya juga dapat menggunakan cookie dan web beacon di situs kami untuk mengukur efektivitas kampanye iklan mereka.</li>
                    </ul>

                    <h4><i class="bi bi-lock-fill"></i> 4. Perlindungan & Keamanan Data</h4>
                    <p>
                        Kami menerapkan standar enkripsi Secure Sockets Layer (SSL / HTTPS) dengan enkripsi bcrypt untuk kata sandi akun pengguna. Dokumen perangkat ajar yang disusun guru tersimpan secara terisolasi dan hanya dapat diakses atau diunduh oleh guru yang bersangkutan, admin sekolah terkait, atau Super Administrator. Kami tidak akan pernah menjual, menyewakan, atau menyebarluaskan data pribadi Anda kepada pihak ketiga mana pun tanpa persetujuan Anda.
                    </p>

                    <h4><i class="bi bi-person-check-fill"></i> 5. Hak Pengguna Atas Data</h4>
                    <p>
                        Setiap guru dan pengguna berhak untuk melihat, memperbarui profil, mengubah kata sandi, atau mengajukan permohonan penghapusan akun beserta riwayat dokumen yang telah dibuat melalui menu Profil atau dengan menghubungi tim pengembang kami.
                    </p>

                    <h4><i class="bi bi-envelope-at-fill"></i> 6. Kontak & Narahubung Privasi</h4>
                    <p>
                        Apabila Anda memiliki pertanyaan, saran, atau masukan mengenai Kebijakan Privasi ini, silakan hubungi kami melalui halaman <a href="{{ route('legal.contact') }}" class="text-info text-decoration-none">Kontak Resmi</a> atau email pengembang di: <strong>admin@admin.com</strong> (Arsitek Sistem: <strong>Vicky Koroh</strong>).
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
                <a href="{{ route('legal.privacy') }}" class="text-info text-decoration-none">Kebijakan Privasi</a>
                <a href="{{ route('legal.terms') }}" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a>
                <a href="{{ route('legal.about') }}" class="text-white-50 text-decoration-none">Tentang Kami</a>
                <a href="{{ route('legal.contact') }}" class="text-white-50 text-decoration-none">Kontak</a>
                <a href="{{ route('legal.disclaimer') }}" class="text-white-50 text-decoration-none">Disclaimer</a>
            </div>
        </div>
    </footer>

</body>
</html>
