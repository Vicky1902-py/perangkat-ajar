<!-- STITCH ANDROID ONBOARDING SPEC: ONBOARDING PERANGKAT AJAR SMK 2026 -->
<div class="stitch-onboarding-wrapper">
    <div class="stitch-onboarding-canvas">
        <!-- Cinematic Background Photo with Editorial Vignette -->
        <div class="stitch-bg-asset">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSTU1O5L2PKZkLUM9qNPUAYH7mq3WDKmChDlcJAVIW7ejSQyBlyjd3RsplgXpEwj_uE2uB6A-0EKYIVFAw_3mxtWvAo3ixt-OcmK999ywWSGAuWRqAaPKoCRq8bwuyFQzwjSpFlh4SXGaL5XJ3zIo9TYMBV2G3RCQMlEWwmhKLY2syV4WwsCBhXiexsLi6uUT03hoid2N7yV3EDBnVhv8FkM2hkopNIseibJ68s_6R406aI5YYpAvjhQ"
                 alt="Guru Vokasi Modern SMK"
                 class="stitch-bg-img"
                 onerror="this.style.display='none';">
            <div class="stitch-vignette-bottom"></div>
            <div class="stitch-vignette-top"></div>
        </div>

        <!-- Android Status Bar (9:41 Layout) -->
        <header class="stitch-status-bar">
            <span class="stitch-time" id="stitchLiveClock">09:41</span>
            <div class="stitch-status-icons">
                <span class="material-symbols-outlined" style="font-size: 15px;">signal_cellular_alt</span>
                <span class="material-symbols-outlined" style="font-size: 15px;">wifi</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">battery_full</span>
            </div>
        </header>

        <!-- Center Editorial Typographic Overlay -->
        <section class="stitch-editorial-body">
            <!-- Regulatory Chip -->
            <div class="stitch-reg-chip">
                <span class="stitch-pulse-dot"></span>
                <span>BSKAP 046/2025 &bull; DEEP LEARNING</span>
            </div>

            <!-- Massive Display Title Split -->
            <div class="stitch-title-split">
                <h1 class="stitch-lead-smk">SMK</h1>
                <h2 class="stitch-lead-year">2026</h2>
                <div class="stitch-subtitle-bar">
                    <span class="stitch-amber-line"></span>
                    <span class="stitch-sub-text">Sistem Perangkat Ajar</span>
                </div>
            </div>
        </section>

        <!-- Bottom Action Dock Card -->
        <footer class="stitch-bottom-dock">
            <div class="stitch-dock-inner">
                <!-- Value Proposition -->
                <div class="mb-3">
                    <h3 class="stitch-headline">
                        Elevate Teaching <span class="stitch-headline-accent">Game</span> With Sistem Pakar.
                    </h3>
                    <p class="stitch-desc">
                        Kurikulum Merdeka 2026. Murni database regulasi Kemendikdasmen tanpa token API. Otomatisasi modul PEDATTI, ATP, dan kisi-kisi kedinasan.
                    </p>
                </div>

                <!-- Dual Action Floating Capsule Bar -->
                <div class="stitch-capsule-bar mb-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="stitch-btn-primary">
                            <span>Buka SuperApp Beranda</span>
                            <span class="stitch-badge-tag">Guru</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="stitch-btn-chevron" aria-label="Buka Dashboard">
                            <span class="stitch-chevrons">&rsaquo;&rsaquo;&rsaquo;</span>
                        </a>
                    @else
                        <a href="{{ route('generator.index') }}" class="stitch-btn-primary">
                            <span>Mulai Sekarang</span>
                            <span class="stitch-badge-tag">Gratis</span>
                        </a>
                        <a href="{{ route('generator.index') }}" class="stitch-btn-chevron" aria-label="Lanjutkan ke Generator">
                            <span class="stitch-chevrons">&rsaquo;&rsaquo;&rsaquo;</span>
                        </a>
                    @endauth
                </div>

                <!-- Trust Meta Indicator & Sublink -->
                <div class="stitch-trust-row">
                    <div class="d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined text-warning" style="font-size: 15px;">verified</span>
                        <span>Nol Halusinasi AI</span>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="stitch-sublink">
                            <span>{{ auth()->user()->name }}</span>
                            <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="stitch-sublink">
                            <span>Masuk Akun Guru</span>
                            <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                        </a>
                    @endauth
                </div>

                <!-- Desktop View Override Link -->
                <div class="text-center pt-2">
                    <a href="{{ request()->fullUrlWithQuery(['view' => 'desktop']) }}" class="stitch-desktop-toggle">
                        <span class="material-symbols-outlined" style="font-size: 13px;">desktop_windows</span>
                        <span>Beralih ke Tampilan Desktop Penuh</span>
                    </a>
                </div>
            </div>

            <!-- Android Gesture Home Indicator Bar -->
            <div class="stitch-home-indicator">
                <div class="stitch-gesture-bar"></div>
            </div>
        </footer>
    </div>
</div>

<style>
.stitch-onboarding-wrapper {
    background-color: #0b0f19;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    color: #ffffff;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.stitch-onboarding-canvas {
    width: 100%;
    max-width: 440px;
    height: 100vh;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #111827;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
}
@media (min-width: 576px) {
    .stitch-onboarding-canvas {
        height: 874px;
        min-height: 874px;
        max-height: 920px;
        border-radius: 28px;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }
}
.stitch-bg-asset {
    position: absolute;
    inset: 0;
    z-index: 0;
    background: radial-gradient(circle at 50% 20%, #1e293b 0%, #0f172a 60%, #030712 100%);
}
.stitch-bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: brightness(0.72) contrast(1.18);
}
.stitch-vignette-bottom {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, #111827 0%, rgba(17, 24, 39, 0.85) 45%, rgba(17, 24, 39, 0.25) 100%);
    pointer-events: none;
}
.stitch-vignette-top {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(17, 24, 39, 0.8) 0%, transparent 35%, #111827 100%);
    pointer-events: none;
}
.stitch-status-bar {
    position: relative;
    z-index: 20;
    width: 100%;
    padding: 12px 20px 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    user-select: none;
    color: rgba(255, 255, 255, 0.9);
}
.stitch-time {
    font-size: 0.88rem;
    font-weight: 700;
    letter-spacing: -0.01em;
}
.stitch-status-icons {
    display: flex;
    align-items: center;
    gap: 6px;
    opacity: 0.9;
}
.stitch-editorial-body {
    position: relative;
    z-index: 10;
    padding: 0 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    user-select: none;
    pointer-events: none;
}
.stitch-reg-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 9999px;
    background: rgba(17, 24, 39, 0.75);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.18);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: #ffffff;
    width: fit-content;
    margin-bottom: 12px;
}
.stitch-pulse-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background-color: #F59E0B;
    animation: stitchPulse 2s infinite;
}
@keyframes stitchPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.85); }
}
.stitch-title-split {
    line-height: 0.88;
    letter-spacing: -0.05em;
}
.stitch-lead-smk {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 64px;
    font-weight: 900;
    text-transform: uppercase;
    color: #ffffff;
    margin: 0;
    padding: 0;
    opacity: 0.96;
}
.stitch-lead-year {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 48px;
    font-weight: 900;
    text-transform: uppercase;
    color: #ffffff;
    margin: -6px 0 0 0;
    padding: 0;
    opacity: 0.96;
}
.stitch-subtitle-bar {
    padding-top: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.stitch-amber-line {
    height: 2px;
    width: 32px;
    background-color: #F59E0B;
}
.stitch-sub-text {
    font-style: italic;
    font-weight: 300;
    letter-spacing: 0.04em;
    color: #b6c4ff;
    font-size: 1.1rem;
}
.stitch-bottom-dock {
    position: relative;
    z-index: 20;
    padding: 12px 20px 20px;
}
.stitch-headline {
    font-size: 1.25rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    line-height: 1.3;
    margin-bottom: 6px;
}
.stitch-headline-accent {
    font-weight: 300;
    font-style: italic;
    color: #b6c4ff;
}
.stitch-desc {
    font-size: 0.78rem;
    color: #94a3b8;
    line-height: 1.5;
    margin-bottom: 0;
}
.stitch-capsule-bar {
    background: rgba(17, 24, 39, 0.9);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 9999px;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4);
}
.stitch-btn-primary {
    flex: 1;
    background: #ffffff;
    color: #0f172a;
    font-weight: 800;
    font-size: 0.88rem;
    padding: 13px 20px;
    border-radius: 9999px;
    text-align: center;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}
.stitch-btn-primary:active {
    transform: scale(0.97);
    background: #f1f5f9;
}
.stitch-badge-tag {
    background: #e2e8f0;
    color: #0f172a;
    font-size: 9px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 9999px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.stitch-btn-chevron {
    height: 46px;
    width: 52px;
    margin-left: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    border-radius: 9999px;
    text-decoration: none;
    transition: all 0.15s ease;
}
.stitch-btn-chevron:active {
    transform: scale(0.92);
    background: rgba(255, 255, 255, 0.18);
}
.stitch-chevrons {
    font-size: 1.25rem;
    font-weight: 800;
    letter-spacing: -3px;
    opacity: 0.9;
}
.stitch-trust-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 4px;
    font-size: 0.72rem;
    color: #94a3b8;
}
.stitch-sublink {
    color: #ffffff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 2px;
    font-weight: 600;
    transition: color 0.15s ease;
}
.stitch-sublink:hover {
    color: #b6c4ff;
}
.stitch-desktop-toggle {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: rgba(255, 255, 255, 0.55);
    text-decoration: none;
    font-size: 0.7rem;
    padding: 4px 10px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.2s ease;
}
.stitch-desktop-toggle:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
}
.stitch-home-indicator {
    padding-top: 14px;
    display: flex;
    justify-content: center;
    pointer-events: none;
}
.stitch-gesture-bar {
    width: 120px;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 9999px;
}
</style>

<script>
    (function() {
        function updateClock() {
            const el = document.getElementById('stitchLiveClock');
            if (!el) return;
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            el.textContent = h + ':' + m;
        }
        updateClock();
        setInterval(updateClock, 30000);
    })();
</script>
