<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Guru - Perangkat Ajar Kurikulum Merdeka (Deep Learning)</title>
    
    @include('layouts.partials.og-meta')
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-glow: #2563eb;
            --accent-cyan: #38bdf8;
            --accent-indigo: #6366f1;
            --card-glass: rgba(15, 23, 42, 0.82);
            --card-border: rgba(255, 255, 255, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #050b18;
            background-image: 
                radial-gradient(circle at 12% 15%, rgba(37, 99, 235, 0.22) 0%, transparent 45%),
                radial-gradient(circle at 88% 85%, rgba(99, 102, 241, 0.20) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.12) 0%, transparent 60%),
                linear-gradient(135deg, #030712 0%, #0b1329 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 14px;
            color: #f8fafc;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient glowing background orbs */
        .ambient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
            animation: pulseOrb 8s ease-in-out infinite alternate;
        }
        .ambient-orb-1 {
            top: 5%;
            left: 8%;
            width: 340px;
            height: 340px;
            background: rgba(37, 99, 235, 0.28);
        }
        .ambient-orb-2 {
            bottom: 5%;
            right: 6%;
            width: 400px;
            height: 400px;
            background: rgba(99, 102, 241, 0.24);
            animation-delay: -4s;
        }

        @keyframes pulseOrb {
            0% { transform: scale(1) translate(0, 0); opacity: 0.5; }
            100% { transform: scale(1.15) translate(20px, 15px); opacity: 0.75; }
        }

        .register-wrapper {
            width: 100%;
            max-width: 560px;
            position: relative;
            z-index: 2;
        }

        /* Luxury Frosted Glass Card */
        .luxury-card {
            background: var(--card-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--card-border);
            border-radius: 26px;
            box-shadow: 
                0 30px 80px -15px rgba(0, 0, 0, 0.8),
                0 0 50px -10px rgba(37, 99, 235, 0.25),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.16);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* Header */
        .luxury-header {
            padding: 32px 24px 22px;
            text-align: center;
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .brand-badge {
            width: 62px;
            height: 62px;
            margin: 0 auto 14px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(56, 189, 248, 0.2) 100%);
            border: 1.5px solid rgba(56, 189, 248, 0.4);
            box-shadow: 0 0 25px rgba(56, 189, 248, 0.35), inset 0 0 12px rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-badge i {
            font-size: 1.85rem;
            color: #ffffff;
            filter: drop-shadow(0 2px 8px rgba(56, 189, 248, 0.6));
        }

        .system-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.4px;
            margin-bottom: 4px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .system-subtitle {
            color: #94a3b8;
            font-size: 0.82rem;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .curriculum-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(30, 41, 59, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 30px;
            padding: 4px 12px;
            font-size: 0.72rem;
            color: #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Form Controls */
        .form-label-custom {
            font-size: 0.8rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .input-glass-group {
            background: rgba(30, 41, 59, 0.65);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            transition: all 0.25s ease;
        }

        .input-glass-group:focus-within {
            background: rgba(30, 41, 59, 0.95);
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.18), 0 0 20px rgba(56, 189, 248, 0.25);
        }

        .input-glass-group .input-icon {
            padding: 10px 10px 10px 12px;
            color: #64748b;
            font-size: 1.05rem;
            transition: color 0.2s;
        }

        .input-glass-group:focus-within .input-icon {
            color: var(--accent-cyan);
        }

        .input-glass-group .form-control {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            padding: 10px 10px 10px 2px;
            font-size: 0.9rem;
            box-shadow: none !important;
        }

        .input-glass-group .form-control::placeholder {
            color: #64748b;
            font-size: 0.82rem;
        }

        .btn-toggle-eye {
            background: transparent;
            border: none;
            color: #64748b;
            padding: 0 12px;
            font-size: 1.05rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .btn-toggle-eye:hover {
            color: #e2e8f0;
        }

        /* Glowing Submit Button */
        .btn-luxury-register {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #4f46e5 100%);
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.94rem;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 18px rgba(37, 99, 235, 0.45);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-luxury-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: all 0.6s ease;
        }

        .btn-luxury-register:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #4338ca 100%);
            box-shadow: 0 6px 24px rgba(37, 99, 235, 0.6);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-luxury-register:hover::before {
            left: 100%;
        }

        .btn-luxury-register:active {
            transform: translateY(0);
        }

        /* Divider */
        .luxury-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 18px 0;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .luxury-divider::before,
        .luxury-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .luxury-divider span {
            padding: 0 10px;
        }

        /* Footer Copyright */
        .luxury-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 0.76rem;
            color: #64748b;
        }
        .luxury-footer .copyright-name {
            color: #94a3b8;
            font-weight: 600;
        }
        .luxury-footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.74rem;
        }
        .luxury-footer-links a:hover {
            color: #38bdf8;
            text-decoration: underline;
        }

        /* Mobile specific enhancements */
        @media (max-width: 575.98px) {
            body {
                padding: 16px 10px;
            }
            .luxury-card {
                border-radius: 20px;
            }
            .luxury-header {
                padding: 24px 16px 16px;
            }
            .brand-badge {
                width: 50px;
                height: 50px;
                margin-bottom: 10px;
            }
            .brand-badge i {
                font-size: 1.45rem;
            }
            .system-title {
                font-size: 1.15rem;
            }
            .curriculum-pill {
                font-size: 0.68rem;
            }
            .card-body-inner {
                padding: 18px 14px !important;
            }
            .form-control {
                font-size: 0.85rem;
            }
            .btn-luxury-register {
                padding: 11px 16px;
                font-size: 0.88rem;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Orbs -->
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>

    <div class="register-wrapper">
        <div class="luxury-card">
            
            <!-- HEADER -->
            <div class="luxury-header">
                <div class="brand-badge">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h3 class="system-title">Pendaftaran Akun Guru Baru</h3>
                <p class="system-subtitle">
                    Sistem Perangkat Ajar Kurikulum Merdeka (Deep Learning)
                </p>
                <div>
                    <span class="curriculum-pill">
                        <i class="bi bi-patch-check-fill text-warning"></i>
                        <span>Akses Penuh Tanpa Batas &bull; Generator 1-Klik</span>
                    </span>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-4 card-body-inner">
                
                @if(session('warning'))
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-20 text-white py-2 px-3 small d-flex align-items-center mb-3 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2 fs-5"></i>
                        <div>{{ session('warning') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-white py-2 px-3 small mb-3 rounded-3">
                        <div class="fw-bold mb-1"><i class="bi bi-x-circle me-1"></i> Mohon perbaiki data berikut:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <!-- NAMA LENGKAP -->
                    <div class="mb-3">
                        <label for="name" class="form-label-custom">
                            <i class="bi bi-person text-info"></i> Nama Lengkap & Gelar <span class="text-danger">*</span>
                        </label>
                        <div class="input-glass-group">
                            <span class="input-icon"><i class="bi bi-person-badge"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso, S.Kom., M.Pd.">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <!-- NIP -->
                        <div class="col-sm-6">
                            <label for="nip" class="form-label-custom">
                                <i class="bi bi-card-text text-info"></i> NIP / NUPTK <span class="text-white-50 fw-normal">(Opsional)</span>
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-hash"></i></span>
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" placeholder="19850101...">
                            </div>
                        </div>
                        <!-- EMAIL -->
                        <div class="col-sm-6">
                            <label for="email" class="form-label-custom">
                                <i class="bi bi-envelope text-info"></i> Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-at"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="email@sekolah.sch.id" autocomplete="email">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <!-- MATA PELAJARAN DIAMPU -->
                        <div class="col-sm-6">
                            <label for="mata_pelajaran_diampu" class="form-label-custom">
                                <i class="bi bi-book text-info"></i> Mapel Diampu
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-journal-text"></i></span>
                                <input type="text" class="form-control" id="mata_pelajaran_diampu" name="mata_pelajaran_diampu" value="{{ old('mata_pelajaran_diampu') }}" placeholder="Contoh: Koding & AI">
                            </div>
                        </div>
                        <!-- JURUSAN / PROGRAM KEAHLIAN -->
                        <div class="col-sm-6">
                            <label for="jurusan" class="form-label-custom">
                                <i class="bi bi-mortarboard text-info"></i> Jurusan / Keahlian
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-gear"></i></span>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: PPLG / TKJ">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <!-- PASSWORD -->
                        <div class="col-sm-6">
                            <label for="password" class="form-label-custom">
                                <i class="bi bi-shield-lock text-info"></i> Kata Sandi <span class="text-danger">*</span>
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Min. 8 karakter" autocomplete="new-password">
                                <button type="button" class="btn-toggle-eye" id="togglePasswordBtn" title="Tampilkan / Sembunyikan Kata Sandi">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>
                        <!-- PASSWORD CONFIRMATION -->
                        <div class="col-sm-6">
                            <label for="password_confirmation" class="form-label-custom">
                                <i class="bi bi-shield-check text-info"></i> Konfirmasi Sandi <span class="text-danger">*</span>
                            </label>
                            <div class="input-glass-group">
                                <span class="input-icon"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi sandi" autocomplete="new-password">
                                <button type="button" class="btn-toggle-eye" id="toggleConfirmPasswordBtn" title="Tampilkan / Sembunyikan Konfirmasi Sandi">
                                    <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-luxury-register w-100 mb-3">
                        <i class="bi bi-check-circle-fill me-1.5"></i> Daftar Akun & Mulai Sekarang
                    </button>

                    <!-- MASUK (SUDAH PUNYA AKUN) -->
                    <div class="text-center mb-3">
                        <span class="text-muted small">Sudah memiliki akun terdaftar? </span>
                        <a href="{{ route('login') }}" class="text-info fw-bold text-decoration-none small">
                            Masuk di Sini <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- DIVIDER -->
                    <div class="luxury-divider">
                        <span>Akses Alternatif</span>
                    </div>

                    <!-- GUEST GENERATOR (MAKS 2X) -->
                    <a href="{{ route('generator.index') }}" class="btn btn-sm btn-outline-light border-opacity-25 w-100 py-2 rounded-3 text-secondary text-decoration-none d-flex align-items-center justify-content-center gap-1" style="border: 1.5px dashed rgba(255,255,255,0.18); color: #cbd5e1 !important; font-size: 0.82rem;">
                        <i class="bi bi-lightning-charge text-warning"></i> Coba Generator Gratis Tanpa Login (Maks. 2x)
                    </a>
                </form>
            </div>
        </div>

        <!-- FOOTER COPYRIGHT & LEGAL -->
        <div class="luxury-footer">
            <div class="mb-2">
                Hak Cipta : <span class="copyright-name">Desain by. Vicky Koroh</span> &bull; &copy; 2026
            </div>
            <div class="luxury-footer-links d-flex flex-wrap justify-content-center gap-2">
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
    </div>

    <!-- SCRIPT TOGGLE PASSWORDS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupToggle(btnId, inputId, iconId) {
                const btn = document.getElementById(btnId);
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (btn && input && icon) {
                    btn.addEventListener('click', function () {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        icon.classList.toggle('bi-eye', !isPassword);
                        icon.classList.toggle('bi-eye-slash', isPassword);
                    });
                }
            }

            setupToggle('togglePasswordBtn', 'password', 'togglePasswordIcon');
            setupToggle('toggleConfirmPasswordBtn', 'password_confirmation', 'toggleConfirmPasswordIcon');
        });
    </script>
</body>
</html>
