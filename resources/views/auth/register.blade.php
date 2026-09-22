<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Guru - Perangkat Ajar Kurikulum Merdeka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0a2540 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: 100%;
            max-width: 520px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .register-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 32px 30px 24px;
            text-align: center;
            color: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15);
        }
        .btn-register {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <!-- HEADER -->
        <div class="register-header">
            <div class="rounded-circle bg-white bg-opacity-20 d-inline-flex align-items-center justify-content-center p-3 mb-2">
                <i class="bi bi-person-plus-fill text-white fs-2"></i>
            </div>
            <h4 class="fw-bold mb-1">Pendaftaran Akun Baru</h4>
            <p class="text-white text-opacity-75 small mb-0">
                Sistem Perangkat Ajar Kurikulum Merdeka (Deep Learning)
            </p>
            <div class="mt-2">
                <span class="badge bg-white bg-opacity-15 text-white" style="font-size: 0.7rem;">
                    Akses Penuh Tanpa Batas &bull; Generator 1-Klik &bull; Export Dokumen Kedinasan
                </span>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-4">
            @if(session('warning'))
                <div class="alert alert-warning py-2 px-3 small d-flex align-items-center mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Mohon perbaiki data berikut:</div>
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
                    <label for="name" class="form-label fw-semibold text-secondary small">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control bg-light border-start-0 ps-0" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso, S.Kom., M.Pd.">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <!-- NIP -->
                    <div class="col-sm-6">
                        <label for="nip" class="form-label fw-semibold text-secondary small">NIP / NUPTK <span class="text-muted fw-normal">(Opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" id="nip" name="nip" value="{{ old('nip') }}" placeholder="19850101...">
                        </div>
                    </div>
                    <!-- EMAIL -->
                    <div class="col-sm-6">
                        <label for="email" class="form-label fw-semibold text-secondary small">Alamat Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.sch.id">
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <!-- MATA PELAJARAN DIAMPU -->
                    <div class="col-sm-6">
                        <label for="mata_pelajaran_diampu" class="form-label fw-semibold text-secondary small">Mata Pelajaran yang Diampu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-book"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" id="mata_pelajaran_diampu" name="mata_pelajaran_diampu" value="{{ old('mata_pelajaran_diampu') }}" placeholder="Contoh: Koding & AI">
                        </div>
                    </div>
                    <!-- JURUSAN / PROGRAM KEAHLIAN -->
                    <div class="col-sm-6">
                        <label for="jurusan" class="form-label fw-semibold text-secondary small">Jurusan / Program Keahlian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-mortarboard"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: PPLG / TKJ">
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <!-- PASSWORD -->
                    <div class="col-sm-6">
                        <label for="password" class="form-label fw-semibold text-secondary small">Kata Sandi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0" id="password" name="password" required placeholder="Min. 8 karakter">
                        </div>
                    </div>
                    <!-- PASSWORD CONFIRMATION -->
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Konfirmasi Sandi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi sandi">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-register w-100 text-white shadow-sm mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> Daftar Akun & Mulai Sekarang
                </button>
            </form>

            <div class="text-center mt-3 pt-3 border-top">
                <p class="text-muted small mb-2">
                    Sudah memiliki akun terdaftar? 
                    <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a>
                </p>
                <p class="text-muted small mb-0">
                    <a href="{{ route('generator.index') }}" class="text-secondary text-decoration-none">
                        <i class="bi bi-lightning-charge me-1"></i> Coba Generator Gratis Tanpa Login (Maks. 2x)
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
