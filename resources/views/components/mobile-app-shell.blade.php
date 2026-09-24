<!-- ============================================================ -->
<!-- MOBILE APP-SHELL INTERFACE (ANDROID / SMARTPHONE NATIVE UI)   -->
<!-- Terinspirasi dari konsep kartu & grid modern Gojek / Grab    -->
<!-- ============================================================ -->
<div class="mobile-app-shell d-block d-md-none">

    <!-- 1. TOP USER BAR (HEADER APLIKASI ANDROID) -->
    <div class="mobile-top-bar mb-3 p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2.5 min-w-0">
            <div class="mobile-user-avatar flex-shrink-0">
                <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="overflow-hidden">
                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                    <span class="text-secondary" style="font-size: 0.72rem;">Selamat datang,</span>
                    @if(auth()->user()->isSuperAdmin())
                        <span class="badge rounded-pill px-2 py-0.5" style="background-color: #dc2626; color: #ffffff !important; font-size: 0.62rem; font-weight: 700;">SUPERADMIN</span>
                    @elseif(auth()->user()->isAdminSekolah())
                        <span class="badge rounded-pill px-2 py-0.5" style="background-color: #0284c7; color: #ffffff !important; font-size: 0.62rem; font-weight: 700;">ADMIN SEKOLAH</span>
                    @else
                        <span class="badge rounded-pill px-2 py-0.5" style="background-color: #10b981; color: #ffffff !important; font-size: 0.62rem; font-weight: 700;">GURU SMK</span>
                    @endif
                </div>
                <h6 class="fw-bold text-dark text-truncate mb-0 mt-0.5" style="font-size: 0.95rem;">
                    {{ auth()->user()->name }}
                </h6>
                <div class="text-secondary text-truncate" style="font-size: 0.72rem;">
                    <i class="bi bi-geo-alt-fill text-danger me-0.5"></i> {{ auth()->user()->satuanPendidikan->nama ?? 'SMK Indonesia' }}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
            <button type="button" class="btn btn-light rounded-circle p-2 border shadow-xs" onclick="openWelcomePopup()" title="Pusat Panduan & Saran">
                <i class="bi bi-stars text-warning fs-5"></i>
            </button>
            <a href="{{ route('profile.setup') }}" class="btn btn-light rounded-circle p-2 border shadow-xs" title="Pengaturan Profil">
                <i class="bi bi-gear-fill text-secondary fs-6"></i>
            </a>
        </div>
    </div>

    <!-- 2. "GOPAY / WALLET" STYLE STATUS CARD (KARTU SISTEM PAKAR) -->
    <div class="mobile-wallet-card mb-3 p-3.5 rounded-4 text-white shadow-sm position-relative overflow-hidden">
        <div class="wallet-background-mesh"></div>
        <div class="position-relative" style="z-index: 2;">
            <!-- Top Badges Row: HIGH CONTRAST & FULLY RESPONSIVE (NO WHITE-ON-WHITE & NO CUTOFF) -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-1.5 mb-2.5">
                <div class="d-flex align-items-center flex-wrap gap-1.5">
                    <span class="badge fw-bold px-2.5 py-1 rounded-pill shadow-xs" style="background-color: #fbbf24; color: #0f172a !important; font-size: 0.68rem; letter-spacing: 0.2px;">
                        <i class="bi bi-patch-check-fill me-1 text-dark"></i> SISTEM PAKAR MURNI
                    </span>
                    <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background-color: rgba(15, 23, 42, 0.45); color: #38bdf8 !important; border: 1px solid rgba(56, 189, 248, 0.4); font-size: 0.68rem;">
                        BSKAP 046/2025
                    </span>
                </div>
                <span class="badge rounded-pill px-2.5 py-1 fw-semibold text-nowrap" style="background-color: rgba(255, 255, 255, 0.15); color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.25); font-size: 0.65rem;">
                    <i class="bi bi-shield-check text-warning me-1"></i> Bebas Halusinasi AI
                </span>
            </div>

            <!-- Middle Headline & Action Row -->
            <div class="row align-items-center g-2 mt-0.5">
                <div class="col-6">
                    <div style="font-size: 0.72rem; color: rgba(255, 255, 255, 0.85);">Total Dokumen Anda:</div>
                    <div class="fw-bold fs-3 text-white lh-1 my-0.5">
                        {{ ($stats['total_modul'] ?? 0) + ($stats['total_atp'] ?? 0) + ($stats['total_tp'] ?? 0) + ($stats['total_lkpd'] ?? 0) }}
                    </div>
                    <div style="font-size: 0.7rem; color: #fde047; font-weight: 600;">
                        <i class="bi bi-check2-all me-0.5"></i> Siap Cetak A4 / F4
                    </div>
                </div>

                <!-- 3 Quick Action Buttons (Gojek Pay/TopUp Style) -->
                <div class="col-6">
                    <div class="d-flex justify-content-end gap-2 text-center">
                        <a href="{{ route('generator.index') }}" class="wallet-quick-btn text-decoration-none">
                            <div class="wallet-btn-icon" style="background-color: #fbbf24; color: #0f172a;">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            <span class="wallet-btn-text text-white">Generate</span>
                        </a>
                        <a href="{{ route('paket-soal.index') }}" class="wallet-quick-btn text-decoration-none">
                            <div class="wallet-btn-icon" style="background-color: #38bdf8; color: #0f172a;">
                                <i class="bi bi-patch-question-fill"></i>
                            </div>
                            <span class="wallet-btn-text text-white">Bank Soal</span>
                        </a>
                        <a href="{{ route('modul-ajar.index') }}" class="wallet-quick-btn text-decoration-none">
                            <div class="wallet-btn-icon" style="background-color: #10b981; color: #ffffff;">
                                <i class="bi bi-folder-fill"></i>
                            </div>
                            <span class="wallet-btn-text text-white">Arsip</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. THE 8-GRID GOJEK / GRAB ICON MENU -->
    <div class="mobile-grid-card mb-4 p-3 rounded-4 bg-white border shadow-sm">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="fw-bold text-dark small d-flex align-items-center">
                <i class="bi bi-grid-fill text-primary me-2 fs-5"></i> Menu Utama Aplikasi
            </span>
            <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #f1f5f9; color: #334155 !important; border: 1px solid #cbd5e1 !important; font-size: 0.65rem;">
                Kurikulum Merdeka 2026
            </span>
        </div>

        <div class="row g-2 g-sm-3 text-center">
            <!-- 1. GENERATOR 1-KLIK -->
            <div class="col-3">
                <a href="{{ route('generator.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-warning-subtle text-warning-emphasis position-relative mx-auto">
                        <i class="bi bi-lightning-charge-fill fs-4 text-warning"></i>
                        <span class="badge bg-danger position-absolute badge-pill-sm">HOT</span>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Generator</span>
                </a>
            </div>

            <!-- 2. SMART SOAL -->
            <div class="col-3">
                <a href="{{ route('paket-soal.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-primary-subtle text-primary position-relative mx-auto">
                        <i class="bi bi-patch-question-fill fs-4 text-primary"></i>
                        <span class="badge bg-primary position-absolute badge-pill-sm">BARU</span>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Smart Soal</span>
                </a>
            </div>

            <!-- 3. MODUL AJAR -->
            <div class="col-3">
                <a href="{{ route('modul-ajar.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-success-subtle text-success mx-auto">
                        <i class="bi bi-journal-richtext fs-4 text-success"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Modul Ajar</span>
                </a>
            </div>

            <!-- 4. ALUR TP (ATP) -->
            <div class="col-3">
                <a href="{{ route('atp.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-purple-subtle text-purple mx-auto" style="background-color: #f3e8ff;">
                        <i class="bi bi-diagram-3-fill fs-4" style="color: #8b5cf6;"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Alur (ATP)</span>
                </a>
            </div>

            <!-- 5. PROTA & PROMES (BALANCED 2-LINE WRAP - ZERO TRUNCATION) -->
            <div class="col-3">
                <a href="{{ route('prota-promes.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-orange-subtle text-orange mx-auto" style="background-color: #ffedd5;">
                        <i class="bi bi-calendar2-range-fill fs-4" style="color: #f97316;"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Prota &amp; Promes</span>
                </a>
            </div>

            <!-- 6. LKPD -->
            <div class="col-3">
                <a href="{{ route('lkpd.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-info-subtle text-info mx-auto" style="background-color: #cffafe;">
                        <i class="bi bi-file-earmark-ruled-fill fs-4" style="color: #06b6d4;"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">LKPD</span>
                </a>
            </div>

            <!-- 7. ASESMEN -->
            <div class="col-3">
                <a href="{{ route('asesmen.index') }}" class="mobile-app-icon-item text-decoration-none d-block">
                    <div class="mobile-icon-box bg-danger-subtle text-danger mx-auto" style="background-color: #ffe4e6;">
                        <i class="bi bi-clipboard2-check-fill fs-4" style="color: #f43f5e;"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Asesmen</span>
                </a>
            </div>

            <!-- 8. PANDUAN & SARAN -->
            <div class="col-3">
                <button type="button" class="mobile-app-icon-item text-decoration-none d-block w-100 bg-transparent border-0 p-0" onclick="openWelcomePopup()">
                    <div class="mobile-icon-box bg-indigo-subtle text-indigo mx-auto" style="background-color: #e0e7ff;">
                        <i class="bi bi-stars fs-4" style="color: #6366f1;"></i>
                    </div>
                    <span class="mobile-icon-label fw-bold text-dark">Panduan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- SPECIAL SHORTCUT FOR SUPERADMIN ON MOBILE -->
    @if(auth()->user()->isSuperAdmin())
        <div class="p-3 rounded-4 bg-white border shadow-sm mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2.5">
                <span class="fw-bold text-danger small d-flex align-items-center">
                    <i class="bi bi-shield-lock-fill me-2 fs-5"></i> Kontrol Superadmin
                </span>
                <span class="badge rounded-pill px-2 py-1 fw-bold" style="background-color: #fee2e2; color: #b91c1c !important; border: 1px solid #fca5a5 !important; font-size: 0.65rem;">
                    aaPanel Server
                </span>
            </div>
            <div class="row g-2">
                <div class="col-4">
                    <a href="{{ route('cms.perangkat.index') }}" class="btn btn-outline-danger btn-sm w-100 rounded-3 py-2 text-decoration-none d-flex flex-column align-items-center">
                        <i class="bi bi-hdd-stack-fill fs-5 mb-1"></i>
                        <span style="font-size: 0.72rem; font-weight: 700; white-space: nowrap;">Space Host</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('cms.traffic.index') }}" class="btn btn-outline-primary btn-sm w-100 rounded-3 py-2 text-decoration-none d-flex flex-column align-items-center">
                        <i class="bi bi-activity fs-5 mb-1"></i>
                        <span style="font-size: 0.72rem; font-weight: 700; white-space: nowrap;">Traffic Live</span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-success btn-sm w-100 rounded-3 py-2 text-decoration-none d-flex flex-column align-items-center">
                        <i class="bi bi-people-fill fs-5 mb-1"></i>
                        <span style="font-size: 0.72rem; font-weight: 700; white-space: nowrap;">Pengguna</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- 4. HORIZONTAL SWIPE PROMO / INSPIRATION CARDS (GOJEK PROMO BANNER) -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2 px-1">
            <span class="fw-bold text-dark small d-flex align-items-center">
                <i class="bi bi-lightbulb-fill text-warning me-2 fs-5"></i> Inspirasi Pembelajaran 2026
            </span>
            <span class="text-muted" style="font-size: 0.72rem;">Geser &raquo;</span>
        </div>

        <div class="mobile-promo-scroll-container">
            <!-- Card 1: Deep Learning -->
            <div class="mobile-promo-card" style="background: linear-gradient(135deg, #0b3b60 0%, #0369a1 100%);">
                <div class="badge fw-bold px-2 py-0.5 rounded-pill mb-1.5" style="background-color: #fbbf24; color: #0f172a !important; font-size: 0.65rem;">
                    3 PILAR UTAMA
                </div>
                <h6 class="fw-bold text-white mb-1">Deep Learning Bermakna</h6>
                <p class="small mb-2" style="font-size: 0.75rem; line-height: 1.4; color: rgba(255,255,255,0.85) !important;">
                    Pilar <strong>Mindful, Meaningful, & Joyful</strong> siap pakai terintegrasi kejuruan DUDI.
                </p>
                <a href="{{ route('generator.index') }}" class="btn btn-light btn-sm rounded-pill px-3 py-1 fw-bold text-primary" style="font-size: 0.72rem;">
                    Coba Sekarang <i class="bi bi-arrow-right ms-0.5"></i>
                </a>
            </div>

            <!-- Card 2: Smart Soal (100% CONTRAST: DARK BLUE ON WHITE) -->
            <div class="mobile-promo-card" style="background: linear-gradient(135deg, #0284c7 0%, #0284c7 50%, #38bdf8 100%);">
                <div class="badge fw-bold px-2 py-0.5 rounded-pill mb-1.5" style="background-color: #ffffff; color: #0369a1 !important; font-size: 0.65rem;">
                    FITUR UNGGULAN
                </div>
                <h6 class="fw-bold text-white mb-1">Smart Soal by. Vicky</h6>
                <p class="small mb-2" style="font-size: 0.75rem; line-height: 1.4; color: #ffffff !important;">
                    Kisi-kisi 8 kolom resmi + Dual PDF (Naskah Siswa vs Pegangan Guru).
                </p>
                <a href="{{ route('paket-soal.index') }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 0.72rem; background-color: #0f172a; border-color: #0f172a;">
                    Buka Bank Soal <i class="bi bi-arrow-right ms-0.5"></i>
                </a>
            </div>

            <!-- Card 3: Deterministic Expert System -->
            <div class="mobile-promo-card" style="background: linear-gradient(135deg, #047857 0%, #10b981 100%);">
                <div class="badge fw-bold px-2 py-0.5 rounded-pill mb-1.5" style="background-color: #fbbf24; color: #0f172a !important; font-size: 0.65rem;">
                    KEDAULATAN DATA
                </div>
                <h6 class="fw-bold text-white mb-1">100% Bebas Token AI</h6>
                <p class="small mb-2" style="font-size: 0.75rem; line-height: 1.4; color: rgba(255,255,255,0.85) !important;">
                    Sistem pakar deterministik berbasis database lokal resmi BSKAP No. 046/2025.
                </p>
                <button type="button" class="btn btn-light btn-sm rounded-pill px-3 py-1 fw-bold text-success" onclick="openWelcomePopup()" style="font-size: 0.72rem;">
                    Pelajari Sistem <i class="bi bi-info-circle ms-0.5"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 5. FEED AKTIVITAS / DOKUMEN TERAKHIR DIBUAT GURU -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2.5 px-1">
            <span class="fw-bold text-dark small d-flex align-items-center">
                <i class="bi bi-clock-history text-primary me-2 fs-5"></i> Dokumen Terakhir Dibuat
            </span>
            <a href="{{ route('modul-ajar.index') }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">
                Lihat Semua <i class="bi bi-chevron-right ms-0.5"></i>
            </a>
        </div>

        <div class="d-flex flex-column gap-2">
            @php
                $hasRecent = false;
            @endphp

            @if(isset($recentModul) && $recentModul->count() > 0)
                @foreach($recentModul->take(2) as $rm)
                    @php $hasRecent = true; @endphp
                    <div class="p-3 rounded-4 bg-white border shadow-xs d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2.5 min-w-0">
                            <div class="rounded-3 p-2 bg-success bg-opacity-10 text-success fs-5 flex-shrink-0">
                                <i class="bi bi-journal-check"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="badge px-2 py-0.5 rounded-pill mb-1 fw-bold" style="background-color: #dcfce7; color: #15803d !important; border: 1px solid #86efac; font-size: 0.65rem;">
                                    MODUL AJAR
                                </div>
                                <div class="fw-bold text-dark text-truncate small" style="max-width: 190px;">
                                    {{ $rm->materi_pokok ?? ($rm->mataPelajaran->nama ?? 'Modul Pembelajaran') }}
                                </div>
                                <div class="text-secondary" style="font-size: 0.7rem;">
                                    {{ $rm->mataPelajaran->nama ?? '-' }} &bull; {{ $rm->fase->nama ?? 'Fase E' }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                            <a href="{{ route('modul-ajar.show', $rm->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                Buka
                            </a>
                            <a href="{{ route('export.modul-ajar.pdf', $rm->id) }}" class="btn btn-light btn-sm rounded-circle p-1.5 border" title="Cetak PDF">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-6"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(isset($recentAtp) && $recentAtp->count() > 0)
                @foreach($recentAtp->take(2) as $ra)
                    @php $hasRecent = true; @endphp
                    <div class="p-3 rounded-4 bg-white border shadow-xs d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2.5 min-w-0">
                            <div class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary fs-5 flex-shrink-0">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="badge px-2 py-0.5 rounded-pill mb-1 fw-bold" style="background-color: #e0f2fe; color: #0369a1 !important; border: 1px solid #7dd3fc; font-size: 0.65rem;">
                                    ALUR TUJUAN (ATP)
                                </div>
                                <div class="fw-bold text-dark text-truncate small" style="max-width: 190px;">
                                    {{ $ra->mataPelajaran->nama ?? 'Alur Pembelajaran' }}
                                </div>
                                <div class="text-secondary" style="font-size: 0.7rem;">
                                    {{ $ra->fase->nama ?? 'Fase E' }} &bull; {{ $ra->created_at ? $ra->created_at->format('d/m/Y') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                            <a href="{{ route('atp.show', $ra->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                Buka
                            </a>
                            <a href="{{ route('export.atp.pdf', $ra->id) }}" class="btn btn-light btn-sm rounded-circle p-1.5 border" title="Cetak PDF">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-6"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(!$hasRecent)
                <div class="p-3.5 rounded-4 bg-white border text-center text-muted">
                    <i class="bi bi-inbox fs-2 text-secondary opacity-50 d-block mb-1"></i>
                    <div class="small fw-semibold text-dark">Belum ada dokumen yang dibuat</div>
                    <div class="x-small text-muted mb-2.5" style="font-size: 0.74rem;">Gunakan generator 1-klik untuk membuat modul & perangkat otomatis.</div>
                    <a href="{{ route('generator.index') }}" class="btn btn-warning btn-sm rounded-pill px-3 py-1 fw-bold text-dark" style="font-size: 0.75rem;">
                        <i class="bi bi-lightning-charge-fill me-1"></i> Mulai Buat Dokumen
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- 6. PROMINENT & VISIBLE COPYRIGHT NOTICE (HAK CIPTA WAJIB)    -->
    <!-- Sesuai instruksi: Hak Cipta tetap tampak jelas pada Android  -->
    <!-- ============================================================ -->
    <div class="mobile-copyright-card my-4 p-3.5 rounded-4 bg-white border text-center shadow-sm position-relative overflow-hidden">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3.5px; background: linear-gradient(90deg, #0b3b60 0%, #0284c7 50%, #f59e0b 100%);"></div>
        <div class="pt-1.5">
            <div class="d-inline-flex align-items-center gap-1.5 px-3 py-1.5 rounded-pill mb-2 shadow-xs" style="background-color: #e0f2fe; color: #0369a1 !important; border: 1.5px solid #7dd3fc !important; font-size: 0.72rem; font-weight: 800;">
                <i class="bi bi-patch-check-fill text-primary"></i>
                <span>HAK CIPTA &bull; DESAIN BY. {{ strtoupper(app_setting('landing_creator_name', 'Vicky Koroh')) }}</span>
            </div>
            <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK') }} &copy; {{ app_setting('landing_copyright_year', '2026') }}
            </div>
            <div class="text-secondary small mb-2" style="font-size: 0.75rem; line-height: 1.5;">
                Kurikulum Merdeka SMK &bull; Pendekatan Pembelajaran Mendalam (Deep Learning)
            </div>
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-1.5">
                <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f1f5f9; color: #334155 !important; border: 1px solid #cbd5e1 !important; font-size: 0.65rem; font-weight: 600;">Permendikdasmen No. 13/2025</span>
                <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f1f5f9; color: #334155 !important; border: 1px solid #cbd5e1 !important; font-size: 0.65rem; font-weight: 600;">BSKAP No. 046/H/KR/2025</span>
                <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background-color: #dcfce7; color: #15803d !important; border: 1px solid #86efac !important; font-size: 0.65rem;">
                    <i class="bi bi-phone-fill me-1"></i> Android Native UI
                </span>
            </div>
        </div>
    </div>

</div>

<style>
    /* Mobile App-Shell Styling */
    .mobile-app-shell {
        max-width: 540px;
        margin: 0 auto;
    }

    .mobile-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0b3b60 0%, #0284c7 100%);
        color: #ffffff;
        font-weight: 800;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(2, 132, 199, 0.25);
    }

    /* Wallet Card (Gojek / Grab Pay Card Style) */
    .mobile-wallet-card {
        background: linear-gradient(135deg, #0b3b60 0%, #0369a1 60%, #0284c7 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .wallet-background-mesh {
        position: absolute;
        top: -30%;
        right: -10%;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.3) 0%, rgba(11, 59, 96, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .wallet-quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        touch-action: manipulation;
    }

    .wallet-btn-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-bottom: 3px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.15s ease;
    }

    .wallet-quick-btn:active .wallet-btn-icon {
        transform: scale(0.92);
    }

    .wallet-btn-text {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: -0.2px;
    }

    /* 8-Grid Gojek/Grab Icon Styling */
    .mobile-app-icon-item {
        touch-action: manipulation;
        transition: transform 0.15s ease;
    }

    .mobile-app-icon-item:active {
        transform: scale(0.92);
    }

    .mobile-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
        box-shadow: 0 4px 10px rgba(11, 59, 96, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .mobile-icon-label {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.68rem;
        letter-spacing: -0.2px;
        white-space: normal;
        line-height: 1.15;
        min-height: 2.2em;
        text-align: center;
        word-break: break-word;
        overflow: hidden;
        color: #1e293b !important;
        font-weight: 700;
        padding: 0 1px;
    }

    .badge-pill-sm {
        font-size: 0.55rem;
        padding: 2px 6px;
        font-weight: 800;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        border: 1.5px solid #ffffff;
        top: -4px;
        right: -4px;
    }

    /* Horizontal Scroll Promo Cards (Gojek Carousel Banner) */
    .mobile-promo-scroll-container {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
        scrollbar-width: none;
    }

    .mobile-promo-scroll-container::-webkit-scrollbar {
        display: none;
    }

    .mobile-promo-card {
        flex: 0 0 85%;
        max-width: 290px;
        scroll-snap-align: start;
        border-radius: 16px;
        padding: 14px 16px;
        box-shadow: 0 4px 14px rgba(11, 59, 96, 0.15);
    }
</style>
