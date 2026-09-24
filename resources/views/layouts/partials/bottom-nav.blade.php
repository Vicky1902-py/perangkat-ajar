<!-- ============================================================ -->
<!-- BOTTOM NAVIGATION BAR (KHUSUS SMARTPHONE / ANDROID VIEW)     -->
<!-- ============================================================ -->
<nav class="mobile-bottom-nav d-block d-md-none" id="mobileBottomNav" aria-label="Navigasi Aplikasi">
    <div class="mobile-nav-container">
        <!-- TAB 1: BERANDA -->
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" 
           class="mobile-nav-link {{ (request()->routeIs('dashboard') || request()->routeIs('home')) ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="bi bi-house-door-fill"></i>
            </div>
            <span class="nav-label">Beranda</span>
        </a>

        <!-- TAB 2: SMART SOAL -->
        <a href="{{ auth()->check() ? route('paket-soal.index') : route('generator.index') }}" 
           class="mobile-nav-link {{ request()->routeIs('paket-soal.*') ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="bi bi-patch-question-fill"></i>
            </div>
            <span class="nav-label">Smart Soal</span>
        </a>

        <!-- TAB 3: GENERATOR 1-KLIK (FLOATING HERO BUTTON IN CENTER) -->
        <a href="{{ route('generator.index') }}" class="mobile-nav-link center-action" title="Generator 1-Klik">
            <div class="center-fab-btn">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <span class="nav-label text-warning fw-bold">1-Klik</span>
        </a>

        <!-- TAB 4: DOKUMEN / ARSIP -->
        <a href="{{ auth()->check() ? route('modul-ajar.index') : route('generator.index') }}" 
           class="mobile-nav-link {{ (request()->routeIs('modul-ajar.*') || request()->routeIs('atp.*') || request()->routeIs('prota-promes.*') || request()->routeIs('lkpd.*') || request()->routeIs('asesmen.*')) ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="bi bi-folder2-open"></i>
            </div>
            <span class="nav-label">Dokumen</span>
        </a>

        <!-- TAB 5: AKUN / PROFIL / MENU -->
        @auth
            <a href="{{ route('profile.setup') }}" 
               class="mobile-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <i class="bi bi-person-circle"></i>
                </div>
                <span class="nav-label">Akun</span>
            </a>
        @else
            <a href="{{ route('login') }}" 
               class="mobile-nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <span class="nav-label">Masuk</span>
            </a>
        @endauth
    </div>
</nav>

<style>
    /* Mobile Bottom Navigation Bar Styling (Android/Gojek-like) */
    .mobile-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1045;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid #e2e8f0;
        box-shadow: 0 -4px 20px rgba(11, 59, 96, 0.08);
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }

    .mobile-nav-container {
        display: flex;
        align-items: center;
        justify-content: space-around;
        height: 62px;
        max-width: 540px;
        margin: 0 auto;
        padding: 0 8px;
    }

    .mobile-nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        text-decoration: none;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 600;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        padding: 6px 0 4px;
        touch-action: manipulation;
    }

    .mobile-nav-link:hover {
        color: #0284c7;
    }

    .mobile-nav-link.active {
        color: #0284c7;
    }

    .mobile-nav-link.active .nav-icon-wrap {
        transform: translateY(-2px);
    }

    .mobile-nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 16px;
        height: 3px;
        background-color: #0284c7;
        border-radius: 4px;
    }

    .mobile-nav-link .nav-icon-wrap {
        font-size: 1.25rem;
        line-height: 1;
        margin-bottom: 2px;
        transition: transform 0.2s ease;
    }

    .mobile-nav-link .nav-label {
        line-height: 1.1;
        letter-spacing: -0.2px;
    }

    /* Center Raised Action Button (1-Klik Generator) */
    .mobile-nav-link.center-action {
        position: relative;
        top: -12px;
    }

    .center-fab-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0b3b60 0%, #0284c7 60%, #38bdf8 100%);
        color: #fbbf24;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.45);
        border: 3px solid #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mobile-nav-link.center-action:active .center-fab-btn {
        transform: scale(0.92);
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
    }

    /* Give bottom spacing on smartphone screens so content is not obscured by the bottom bar */
    @media (max-width: 767.98px) {
        body {
            padding-bottom: 74px !important;
        }
    }
</style>
