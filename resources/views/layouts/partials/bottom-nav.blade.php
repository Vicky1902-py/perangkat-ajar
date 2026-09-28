<!-- ============================================================ -->
<!-- BOTTOM NAVIGATION BAR (SUPERAPP GRAB/GOJEK FLOATING PILL DOCK) -->
<!-- ============================================================ -->
<nav class="mobile-bottom-nav d-block d-md-none" id="mobileBottomNav" aria-label="Navigasi Aplikasi Mobile">
    <div class="mobile-pill-dock">
        <!-- 1. Beranda -->
        <a href="{{ auth()->check() ? route('dashboard') : route('generator.index') }}" 
           class="dock-item {{ (request()->routeIs('dashboard') || request()->routeIs('home')) ? 'active' : '' }}">
            <span class="material-symbols-outlined {{ (request()->routeIs('dashboard') || request()->routeIs('home')) ? 'fill-icon' : '' }}">dashboard</span>
            <span class="dock-label">Beranda</span>
        </a>

        <!-- 2. Generator -->
        <a href="{{ route('generator.index') }}" 
           class="dock-item {{ request()->routeIs('generator.*') ? 'active' : '' }}">
            <div class="position-relative d-inline-flex">
                <span class="material-symbols-outlined {{ request()->routeIs('generator.*') ? 'fill-icon' : '' }}">auto_awesome</span>
                <span class="dock-dot bg-warning"></span>
            </div>
            <span class="dock-label">Generator</span>
        </a>

        <!-- 3. Smart Soal / Bank Soal -->
        <a href="{{ auth()->check() ? route('paket-soal.index') : route('generator.index') }}" 
           class="dock-item {{ request()->routeIs('paket-soal.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('paket-soal.*') ? 'fill-icon' : '' }}">quiz</span>
            <span class="dock-label">Bank Soal</span>
        </a>

        <!-- 4. Vx Agent (Asisten Kurikulum) -->
        <a href="javascript:void(0)" onclick="showVxAgentWelcomeModal(); return false;" 
           class="dock-item {{ request()->routeIs('pakar-ai.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('pakar-ai.*') ? 'fill-icon' : '' }}">forum</span>
            <span class="dock-label">Vx Agent</span>
        </a>

        <!-- 5. Arsip / Dokumen -->
        <a href="{{ auth()->check() ? route('modul-ajar.index') : route('login') }}" 
           class="dock-item {{ (request()->routeIs('modul-ajar.*') || request()->routeIs('atp.*') || request()->routeIs('prota-promes.*') || request()->routeIs('lkpd.*') || request()->routeIs('asesmen.*') || request()->routeIs('tp.*')) ? 'active' : '' }}">
            <span class="material-symbols-outlined {{ (request()->routeIs('modul-ajar.*') || request()->routeIs('atp.*') || request()->routeIs('prota-promes.*') || request()->routeIs('lkpd.*') || request()->routeIs('asesmen.*') || request()->routeIs('tp.*')) ? 'fill-icon' : '' }}">folder_open</span>
            <span class="dock-label">Arsip</span>
        </a>
    </div>
</nav>

<style>
    /* SuperApp Floating Pill Bottom Navigation Dock (Stitch Android Design) */
    .mobile-bottom-nav {
        position: fixed;
        bottom: 14px;
        left: 0;
        right: 0;
        z-index: 1045;
        pointer-events: none;
        padding: 0 16px;
    }

    .mobile-pill-dock {
        pointer-events: auto;
        display: flex;
        align-items: center;
        justify-content: space-around;
        max-width: 410px;
        margin: 0 auto;
        padding: 5px 8px;
        background: #111827;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 9999px;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.42), 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .dock-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #94a3b8;
        padding: 5px 6px;
        border-radius: 9999px;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        touch-action: manipulation;
        flex: 1 1 0;
        min-width: 0;
        white-space: nowrap;
    }

    .dock-item .material-symbols-outlined {
        font-size: 20px;
        line-height: 1;
        transition: transform 0.18s ease;
    }

    .dock-label {
        font-size: 10px;
        font-weight: 600;
        line-height: 1.1;
        margin-top: 2px;
        letter-spacing: -0.2px;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .dock-item:hover {
        color: #e2e8f0;
    }

    .dock-item:active {
        transform: scale(0.92);
    }

    .dock-item.active {
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        padding: 5px 8px;
    }

    .dock-item.active .dock-label {
        font-weight: 800;
        color: #0f172a;
    }

    .dock-dot {
        position: absolute;
        top: -1px;
        right: -3px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        border: 1.5px solid #111827;
    }

    /* Narrow Android Phone Adjustments (<= 380px) */
    @media (max-width: 380px) {
        .mobile-bottom-nav {
            padding: 0 8px;
            bottom: 8px;
        }
        .mobile-pill-dock {
            padding: 4px 4px;
        }
        .dock-item {
            padding: 4px 2px;
        }
        .dock-item.active {
            padding: 4px 6px;
        }
        .dock-item .material-symbols-outlined {
            font-size: 18px;
        }
        .dock-label {
            font-size: 8.5px;
        }
    }

    /* Bottom padding on mobile so content is never covered by the floating dock */
    @media (max-width: 767.98px) {
        body {
            padding-bottom: 86px !important;
        }
    }
</style>
