<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem - Perangkat Ajar Kurikulum Merdeka (Deep Learning)</title>
    
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
            --card-glass: rgba(15, 23, 42, 0.78);
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
            padding: 24px 14px;
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
            left: 10%;
            width: 320px;
            height: 320px;
            background: rgba(37, 99, 235, 0.28);
        }
        .ambient-orb-2 {
            bottom: 5%;
            right: 8%;
            width: 380px;
            height: 380px;
            background: rgba(99, 102, 241, 0.24);
            animation-delay: -4s;
        }

        @keyframes pulseOrb {
            0% { transform: scale(1) translate(0, 0); opacity: 0.5; }
            100% { transform: scale(1.15) translate(20px, 15px); opacity: 0.75; }
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
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

        /* Header with Iridescent Accent */
        .luxury-header {
            padding: 34px 26px 24px;
            text-align: center;
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .brand-badge {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(56, 189, 248, 0.2) 100%);
            border: 1.5px solid rgba(56, 189, 248, 0.4);
            box-shadow: 0 0 25px rgba(56, 189, 248, 0.35), inset 0 0 12px rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
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

        /* Form Inputs */
        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .input-glass-group {
            background: rgba(30, 41, 59, 0.65);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
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
            padding: 12px 12px 12px 14px;
            color: #64748b;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .input-glass-group:focus-within .input-icon {
            color: var(--accent-cyan);
        }

        .input-glass-group .form-control {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            padding: 12px 12px 12px 2px;
            font-size: 0.92rem;
            box-shadow: none !important;
        }

        .input-glass-group .form-control::placeholder {
            color: #64748b;
            font-size: 0.85rem;
        }

        .btn-toggle-eye {
            background: transparent;
            border: none;
            color: #64748b;
            padding: 0 14px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .btn-toggle-eye:hover {
            color: #e2e8f0;
        }

        /* Checkbox */
        .form-check-input {
            background-color: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .form-check-label {
            color: #94a3b8;
            font-size: 0.82rem;
            cursor: pointer;
        }

        /* Glowing Login Button */
        .btn-luxury-login {
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

        .btn-luxury-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: all 0.6s ease;
        }

        .btn-luxury-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #4338ca 100%);
            box-shadow: 0 6px 24px rgba(37, 99, 235, 0.6);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-luxury-login:hover::before {
            left: 100%;
        }

        .btn-luxury-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .luxury-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
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

        /* Guest Action Button */
        .btn-guest-luxury {
            background: rgba(30, 41, 59, 0.5);
            border: 1.5px dashed rgba(255, 255, 255, 0.18);
            border-radius: 14px;
            padding: 10px 14px;
            color: #cbd5e1;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }
        .btn-guest-luxury:hover {
            background: rgba(37, 99, 235, 0.15);
            border-color: var(--accent-cyan);
            color: #ffffff;
            transform: translateY(-1px);
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

        /* Mobile specific enhancements */
        @media (max-width: 480px) {
            body {
                padding: 14px 10px;
            }
            .luxury-card {
                border-radius: 20px;
            }
            .luxury-header {
                padding: 24px 16px 18px;
            }
            .brand-badge {
                width: 52px;
                height: 52px;
                margin-bottom: 12px;
            }
            .brand-badge i {
                font-size: 1.5rem;
            }
            .system-title {
                font-size: 1.18rem;
            }
            .curriculum-pill {
                font-size: 0.68rem;
            }
            .card-body-inner {
                padding: 18px 16px !important;
            }
            .form-control {
                font-size: 0.86rem;
            }
            .btn-luxury-login {
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

    <div class="login-wrapper">
        <div class="luxury-card">
            
            <!-- HEADER -->
            <div class="luxury-header">
                <div class="brand-badge">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <h3 class="system-title">Sistem Perangkat Ajar</h3>
                <p class="system-subtitle">
                    Kurikulum Merdeka SMK &bull; Pendekatan Deep Learning
                </p>
                <div>
                    <span class="curriculum-pill">
                        <i class="bi bi-patch-check-fill text-warning"></i>
                        <span>Permendikdasmen No. 13/2025 &bull; 8 DPL</span>
                    </span>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-4 card-body-inner">
                
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-20 text-white py-2 px-3 small d-flex align-items-center mb-3 rounded-3">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-white py-2 px-3 small d-flex align-items-center mb-3 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-white py-2 px-3 small mb-3 rounded-3">
                        <div class="fw-bold mb-1"><i class="bi bi-x-circle me-1"></i> Periksa kembali data login:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- INPUT EMAIL -->
                    <div class="mb-3">
                        <label for="email" class="form-label-custom">
                            <i class="bi bi-envelope text-info"></i> Alamat Email Pengguna
                        </label>
                        <div class="input-glass-group">
                            <span class="input-icon"><i class="bi bi-at"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@sekolah.sch.id" autocomplete="email">
                        </div>
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div class="mb-3">
                        <label for="password" class="form-label-custom">
                            <i class="bi bi-shield-lock text-info"></i> Kata Sandi
                        </label>
                        <div class="input-glass-group">
                            <span class="input-icon"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan kata sandi" autocomplete="current-password">
                            <button type="button" class="btn-toggle-eye" id="togglePasswordBtn" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Toggle password visibility">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- INGAT SAYA -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat saya di perangkat ini
                            </label>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-luxury-login w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-1.5"></i> Masuk ke Sistem
                    </button>

                    <!-- DAFTAR AKUN BARU -->
                    <div class="text-center mb-3">
                        <span class="text-muted small">Belum memiliki akun guru? </span>
                        <a href="{{ route('register') }}" class="text-info fw-bold text-decoration-none small">
                            Daftar Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- DIVIDER -->
                    <div class="luxury-divider">
                        <span>Akses Alternatif</span>
                    </div>

                    <!-- GUEST GENERATOR (MAKS 2X) -->
                    <a href="{{ route('generator.index') }}" class="btn-guest-luxury w-100">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        <span>Coba Generator Gratis (Maks. 2x)</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- FOOTER COPYRIGHT -->
        <div class="luxury-footer">
            Hak Cipta : <span class="copyright-name">Desain by. Vicky Koroh</span> &bull; &copy; {{ date('Y') }}
        </div>
    </div>

    <!-- SCRIPT TOGGLE PASSWORD -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const pwdInput = document.getElementById('password');
            const pwdIcon = document.getElementById('togglePasswordIcon');

            if (toggleBtn && pwdInput && pwdIcon) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = pwdInput.type === 'password';
                    pwdInput.type = isPassword ? 'text' : 'password';
                    pwdIcon.classList.toggle('bi-eye', !isPassword);
                    pwdIcon.classList.toggle('bi-eye-slash', isPassword);
                });
            }
        });
    </script>
</body>
</html>
