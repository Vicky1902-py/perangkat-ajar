<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem - Perangkat Ajar Kurikulum Merdeka (Deep Learning)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            --accent-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --card-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.45);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(circle at 15% 20%, rgba(37, 99, 235, 0.18) 0%, transparent 40%),
                        radial-gradient(circle at 85% 80%, rgba(14, 165, 233, 0.15) 0%, transparent 45%),
                        linear-gradient(135deg, #0b1329 0%, #0f172a 40%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
            color: #1e293b;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-header {
            background: var(--primary-gradient);
            padding: 38px 28px 30px;
            text-align: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-icon-wrapper {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .form-floating-custom {
            position: relative;
        }

        .input-group-custom {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.25s ease;
            background-color: #f8fafc;
        }

        .input-group-custom:focus-within {
            border-color: #2563eb;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .input-group-custom .input-group-text {
            background: transparent;
            border: none;
            color: #64748b;
            padding-left: 14px;
            padding-right: 10px;
        }

        .input-group-custom .form-control {
            border: none;
            background: transparent;
            padding: 12px 14px 12px 4px;
            font-size: 0.95rem;
            color: #1e293b;
        }

        .input-group-custom .form-control:focus {
            box-shadow: none;
            background: transparent;
        }

        .input-group-custom .btn-toggle-pwd {
            border: none;
            background: transparent;
            color: #94a3b8;
            padding-right: 14px;
            padding-left: 8px;
            transition: color 0.2s ease;
        }

        .input-group-custom .btn-toggle-pwd:hover {
            color: #334155;
        }

        .btn-login {
            background: var(--accent-gradient);
            border: none;
            padding: 13px;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.2px;
            border-radius: 12px;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
            transition: all 0.25s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0;
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .divider-container::before,
        .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider-container span {
            padding: 0 12px;
        }

        .btn-guest-trial {
            background-color: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            color: #334155;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.25s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-guest-trial:hover {
            background-color: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
            transform: translateY(-1px);
        }

        .footer-copyright {
            color: #94a3b8;
            font-size: 0.78rem;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <!-- HEADER -->
            <div class="login-header">
                <div class="brand-icon-wrapper">
                    <i class="bi bi-journal-bookmark-fill text-white fs-3"></i>
                </div>
                <h4 class="fw-bold mb-1 tracking-tight">Sistem Perangkat Ajar</h4>
                <p class="text-white text-opacity-75 small mb-2">
                    Kurikulum Merdeka SMK &bull; Pendekatan Deep Learning
                </p>
                <div>
                    <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 px-2.5 py-1" style="font-size: 0.72rem; font-weight: 500;">
                        <i class="bi bi-award-fill me-1"></i> Permendikdasmen No. 13/2025 &bull; 8 DPL
                    </span>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-4 p-sm-4">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success py-2 px-3 small d-flex align-items-center mb-3 rounded-3">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2 px-3 small d-flex align-items-center mb-3 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2 px-3 small mb-3 rounded-3">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Periksa kembali data login:</div>
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
                        <label for="email" class="form-label fw-semibold text-secondary small mb-1">
                            Alamat Email Pengguna
                        </label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@sekolah.sch.id" autocomplete="email">
                        </div>
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary small mb-1">
                            Kata Sandi
                        </label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan kata sandi" autocomplete="current-password">
                            <button type="button" class="btn btn-toggle-pwd" id="togglePasswordBtn" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- INGAT SAYA -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary small" for="remember">
                                Ingat saya di perangkat ini
                            </label>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-login w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-1.5"></i> Masuk ke Sistem
                    </button>

                    <!-- DAFTAR AKUN BARU -->
                    <div class="text-center mb-3">
                        <span class="text-muted small">Belum memiliki akun guru? </span>
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none small">
                            Daftar Sekarang
                        </a>
                    </div>

                    <!-- DIVIDER -->
                    <div class="divider-container">
                        <span>Akses Alternatif</span>
                    </div>

                    <!-- GUEST GENERATOR (MAKS 2X) -->
                    <a href="{{ route('generator.index') }}" class="btn-guest-trial w-100">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        <span>Coba Generator Gratis (Maks. 2x)</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- FOOTER COPYRIGHT -->
        <div class="footer-copyright">
            Hak Cipta: Desain by. Vicky Koroh &bull; &copy; {{ date('Y') }}
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
