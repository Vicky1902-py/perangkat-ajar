<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'Perangkat Ajar') - SuperApp Guru SMK</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Favicon -->
    @if(app_favicon_url())
        <link rel="icon" href="{{ app_favicon_url() }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%232563eb'><path d='M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z'/></svg>">
    @endif

    @php
        $themeColors = app_theme_colors();
    @endphp

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --primary-gradient: linear-gradient(135deg, {{ $themeColors['primary'] }} 0%, {{ $themeColors['indigo'] }} 100%);
            --theme-primary: {{ $themeColors['primary'] }};
            --theme-cyan: {{ $themeColors['cyan'] }};
            --theme-indigo: {{ $themeColors['indigo'] }};
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden !important;
            background-color: #0f172a;
            color: #0f172a;
            font-family: var(--bs-font-sans-serif);
            -webkit-tap-highlight-color: transparent;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            overflow: hidden;
            max-width: 1.5em;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }
        .material-symbols-outlined.fill-icon {
            font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }

        /* Dedicated Mobile Canvas Container */
        .stitch-mobile-viewport {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            background-color: #f8fafc;
            position: relative;
            box-shadow: 0 0 35px rgba(0,0,0,0.25);
            padding: 12px 14px 95px 14px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .stitch-mobile-header {
            padding: 4px 2px 10px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stitch-brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #0f172a;
        }

        .stitch-brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        }

        .stitch-brand-name {
            font-size: 0.88rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .stitch-brand-sub {
            font-size: 0.65rem;
            color: #64748b;
            font-weight: 600;
        }

        /* Switch View Button at Bottom */
        .stitch-desktop-switcher-wrap {
            margin-top: auto;
            padding: 24px 0 10px;
            text-align: center;
        }

        .stitch-btn-desktop-switch {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            background: #e2e8f0;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .stitch-btn-desktop-switch:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        /* Common Stitch Mobile Component Styles */
        .mobile-nav-circle-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            color: #0f172a;
            text-decoration: none;
            transition: transform 0.15s ease;
        }
        .mobile-nav-circle-btn:active {
            transform: scale(0.92);
            background-color: #f1f5f9;
        }
        .mobile-section-h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .mobile-section-eyebrow {
            font-size: 10px;
            font-weight: 700;
            color: #0284c7;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .mobile-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.1rem;
            padding: 14px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
            transition: all 0.2s ease;
        }
        .mobile-item-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.35;
        }
        .mobile-card-btn {
            font-size: 12px !important;
            font-weight: 700 !important;
            padding: 5px 12px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .mobile-icon-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #475569;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .mobile-icon-action-btn:active {
            transform: scale(0.92);
            background: #e2e8f0;
        }

        /* Guarantee floating-guide-btn is safely elevated above the floating pill bottom nav */
        .floating-guide-btn {
            bottom: 74px !important;
            right: 14px !important;
            z-index: 1040 !important;
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="stitch-mobile-viewport">
        <!-- MOBILE TOPBAR (CUSTOMIZABLE PER VIEW OR DEFAULT GLOBAL) -->
        @hasSection('header')
            @yield('header')
        @elseif(empty(trim($__env->yieldContent('no_global_header'))))
            <header class="stitch-mobile-header">
                <a href="{{ auth()->check() ? route('dashboard') : route('generator.index') }}" class="stitch-brand-chip">
                    @if(app_logo_url())
                        <img src="{{ app_logo_url() }}" alt="Logo" style="height: 30px; width: 30px; object-fit: contain;">
                    @else
                        <div class="stitch-brand-logo">
                            <span class="material-symbols-outlined fill-icon" style="font-size: 18px;">menu_book</span>
                        </div>
                    @endif
                    <div>
                        <div class="stitch-brand-name">{{ strtoupper(auth()->check() && auth()->user()->satuanPendidikan ? auth()->user()->satuanPendidikan->nama : 'PERANGKAT AJAR') }}</div>
                        <div class="stitch-brand-sub">Kurikulum Merdeka &bull; Deep Learning</div>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-1.5">
                    <button type="button" class="btn btn-sm btn-light border rounded-circle p-1.5 d-flex align-items-center justify-content-center" onclick="showVxAgentWelcomeModal(); return false;" title="Konsultasi Vx Agent" style="width: 34px; height: 34px;">
                        <span class="material-symbols-outlined text-primary" style="font-size: 19px;">support_agent</span>
                    </button>
                    @auth
                        <a href="{{ route('profile.setup') }}" class="btn btn-sm btn-light border rounded-circle p-1.5 d-flex align-items-center justify-content-center" title="Profil Pengguna" style="width: 34px; height: 34px;">
                            <span class="material-symbols-outlined text-secondary" style="font-size: 19px;">person</span>
                        </a>
                        <button type="button" class="btn btn-sm btn-light border text-danger rounded-circle p-1.5 d-flex align-items-center justify-content-center" onclick="confirmMobileLogout(); return false;" title="Keluar / Logout" style="width: 34px; height: 34px;">
                            <span class="material-symbols-outlined" style="font-size: 19px;">logout</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                            Masuk
                        </a>
                    @endauth
                </div>
            </header>
        @endif

        <!-- FLASH NOTIFICATIONS -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 px-3 small d-flex align-items-center mb-3">
                <i class="bi bi-check-circle-fill fs-5 me-2 flex-shrink-0"></i>
                <div style="font-size: 0.8rem;">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.65rem;"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 small d-flex align-items-center mb-3">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 flex-shrink-0"></i>
                <div style="font-size: 0.8rem;">{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.65rem;"></button>
            </div>
        @endif

        <!-- MAIN MOBILE VIEW CONTENT -->
        <main class="w-100 flex-grow-1">
            @yield('content')
        </main>

        <!-- DESKTOP SWITCHER FOOTER -->
        <div class="stitch-desktop-switcher-wrap">
            <a href="{{ request()->fullUrlWithQuery(['view' => 'desktop']) }}" class="stitch-btn-desktop-switch">
                <i class="bi bi-display"></i>
                <span>Beralih ke Tampilan Komputer (PC / Desktop)</span>
            </a>
            @auth
                <div class="mt-2.5">
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 font-monospace" onclick="confirmMobileLogout(); return false;" style="font-size: 0.72rem;">
                        <span class="material-symbols-outlined align-middle" style="font-size: 14px;">logout</span> Keluar dari Akun (Logout)
                    </button>
                </div>
            @endauth
            <div class="text-muted mt-2" style="font-size: 0.65rem;">
                {{ app_setting('app_name', 'Perangkat Ajar SMK') }} &copy; {{ date('Y') }} &bull; Hak Cipta : Desain by. {{ app_setting('landing_creator_name', 'Vicky Koroh') }}
            </div>
        </div>
    </div>

    <!-- DEDICATED STITCH FLOATING PILL BOTTOM NAVIGATION DOCK -->
    @include('layouts.partials.bottom-nav')

    <!-- POPUP MODAL VX AGENT -->
    @include('components.welcome-popup')

    @auth
        <!-- HIDDEN LOGOUT FORM FOR MOBILE -->
        <form id="mobileLogoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endauth

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function confirmMobileLogout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Keluar dari Akun?',
                    text: 'Sesi Anda di perangkat ini akan diakhiri.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 border-0 shadow-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('mobileLogoutForm');
                        if (form) form.submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari akun?')) {
                    const form = document.getElementById('mobileLogoutForm');
                    if (form) form.submit();
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
