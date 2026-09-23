<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan Server | {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}</title>
    
    <link rel="icon" type="image/x-icon" href="{{ app_favicon_url() }}">
    <link rel="shortcut icon" href="{{ app_favicon_url() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @php
        $themeColors = app_theme_colors();
    @endphp
    <style>
        :root {
            --primary: {{ $themeColors['primary'] }};
            --accent-cyan: {{ $themeColors['cyan'] }};
            --accent-indigo: {{ $themeColors['indigo'] }};
            --bg-dark: #040914;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            margin: 0;
            padding: 2rem 1rem;
        }
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, rgba(249, 115, 22, 0.08) 50%, transparent 70%);
            filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }
        .error-card {
            position: relative;
            z-index: 1;
            max-width: 600px;
            width: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 3rem 2.5rem;
            text-align: center;
        }
        .error-code {
            font-size: 6.5rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #facc15, #f59e0b, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            letter-spacing: -3px;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <div class="error-card">
        <div class="mb-3">
            <span class="badge rounded-pill px-3 py-1.5" style="background: rgba(234, 179, 8, 0.15); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3);">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Error 500 &bull; Kendala Pemrosesan
            </span>
        </div>

        <div class="error-code">500</div>

        <h3 class="fw-bold text-white mb-2">Terjadi Kendala Teknis Pada Server</h3>
        <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
            Sistem mendeteksi adanya kendala sementara saat mengeksekusi instruksi Anda. Tim teknis telah menerima log otomatis untuk penanganan lebih lanjut.
        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <button onclick="window.location.reload()" class="btn btn-warning text-dark rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                <i class="bi bi-arrow-clockwise me-1.5"></i> Muat Ulang Halaman
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4 py-2.5 fw-semibold" style="border-color: rgba(255,255,255,0.2);">
                <i class="bi bi-house-door-fill me-1.5"></i> Kembali ke Beranda
            </a>
        </div>

        <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 small text-white-50">
            {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }} &bull; Arsitektur oleh {{ app_setting('landing_creator_name', 'Vicky Koroh') }}
        </div>
    </div>
</body>
</html>
