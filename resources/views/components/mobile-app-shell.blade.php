<!-- ===================================================================== -->
<!-- SUPERAPP GURU SMK: ANDROID NATIVE MOBILE EXPERIENCE                   -->
<!-- Terinspirasi dari rancangan SuperApp Guru Vokasi 2026 ala Gojek/Grab -->
<!-- Grounded on BSKAP 046/H/KR/2025 & Deep Learning Framework             -->
<!-- ===================================================================== -->
<div class="superapp-mobile-shell mobile-app-shell d-block d-md-none">

    <!-- 1. TOP APP BAR (HEADER PENGGUNA RESMI) -->
    <header class="superapp-topbar d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2.5 min-w-0">
            <!-- User Avatar with Verified Seal -->
            <a href="{{ route('profile.setup') }}" class="position-relative flex-shrink-0 text-decoration-none" title="Pengaturan Profil & Akun">
                <div class="superapp-avatar-ring">
                    @if(auth()->user()->profile_photo_url ?? false)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-100 h-100 rounded-circle object-fit-cover">
                    @else
                        <div class="superapp-avatar-initial">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <span class="superapp-verified-badge" title="Guru Terverifikasi Kedinasan">
                    <span class="material-symbols-outlined fill-icon" style="font-size: 11px;">verified</span>
                </span>
            </a>

            <!-- User Info & School -->
            <div class="overflow-hidden">
                <div class="d-flex align-items-center gap-1.5">
                    <span class="superapp-eyebrow text-truncate" style="max-width: 155px;">
                        {{ strtoupper(auth()->user()->satuanPendidikan->nama ?? 'SMKN INDONESIA') }}
                    </span>
                    <span class="superapp-amber-dot"></span>
                </div>
                <h1 class="superapp-user-name text-truncate mb-0">
                    <a href="{{ route('profile.setup') }}" class="text-decoration-none text-dark">
                        {{ auth()->user()->name }}
                    </a>
                </h1>
            </div>
        </div>

        <!-- Trailing Action Icons -->
        <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
            <!-- Support / Vx Agent Button -->
            <button type="button" class="superapp-icon-btn" onclick="showVxAgentWelcomeModal(); return false;" title="Konsultasi Vx Agent">
                <span class="material-symbols-outlined text-primary" style="font-size: 19px;">support_agent</span>
            </button>
            <!-- Notifications Bell -->
            <div class="position-relative">
                <button type="button" class="superapp-icon-btn" onclick="openWelcomePopup()" title="Pusat Panduan & Notifikasi">
                    <span class="material-symbols-outlined text-dark" style="font-size: 19px;">notifications</span>
                    @if(isset($appUnreadNotifs) && $appUnreadNotifs->isNotEmpty())
                        <span class="superapp-notif-dot"></span>
                    @endif
                </button>
            </div>
            <!-- Logout Button -->
            <button type="button" class="superapp-icon-btn text-danger border border-danger-subtle bg-danger-subtle" onclick="confirmMobileLogout(); return false;" title="Keluar dari Akun">
                <span class="material-symbols-outlined text-danger" style="font-size: 19px;">logout</span>
            </button>
        </div>
    </header>

    <!-- 2. QUICK SEARCH BAR (SUPERAPP SEARCH) -->
    <div class="superapp-search-wrap mb-3.5">
        <a href="{{ route('generator.index') }}" class="superapp-search-bar text-decoration-none">
            <span class="material-symbols-outlined text-secondary me-2" style="font-size: 21px;">search</span>
            <span class="superapp-search-placeholder text-truncate flex-grow-1">
                Cari Modul SMK, ATP BSKAP 046, Kisi Soal...
            </span>
            <span class="superapp-search-voice-pill">
                <span class="material-symbols-outlined" style="font-size: 14px;">bolt</span>
                <span>1-Klik</span>
            </span>
        </a>
    </div>

    <!-- 3. GOPAY / WALLET STYLE CARD (STATUS LISENSI GURU SMK) -->
    <section class="superapp-wallet-card mb-3.5 position-relative overflow-hidden">
        <!-- Ambient Blur Curve -->
        <div class="superapp-wallet-ambient"></div>

        <div class="position-relative" style="z-index: 2;">
            <!-- Top Row: Status Lisensi & Token BSKAP -->
            <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-white border-opacity-15 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="superapp-wallet-icon-badge">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 18px;">workspace_premium</span>
                    </div>
                    <div>
                        <div class="superapp-card-eyebrow">STATUS LISENSI RESMI</div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="fw-bold text-white small">Pro Kedinasan SMK 2026</span>
                            <span class="superapp-pill-unlimited">UNLIMITED</span>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <div class="superapp-card-eyebrow">TOKEN BSKAP</div>
                    <div class="fw-bold text-warning small d-flex align-items-center justify-content-end gap-0.5">
                        <span class="material-symbols-outlined" style="font-size: 15px;">bolt</span>
                        <span>Bebas Pakai</span>
                    </div>
                </div>
            </div>

            <!-- 4 Wallet Quick Action Icons (Data Sekolah, Kop Resmi, Batch Zip, Riwayat Dok) -->
            <div class="row g-1 text-center">
                <div class="col-3">
                    <a href="{{ route('profile.setup') }}" class="superapp-wallet-btn text-decoration-none">
                        <div class="superapp-wallet-btn-circle">
                            <span class="material-symbols-outlined" style="font-size: 20px;">add_business</span>
                        </div>
                        <span class="superapp-wallet-btn-label">Data Sekolah</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ route('profile.setup') }}" class="superapp-wallet-btn text-decoration-none">
                        <div class="superapp-wallet-btn-circle">
                            <span class="material-symbols-outlined" style="font-size: 20px;">description</span>
                        </div>
                        <span class="superapp-wallet-btn-label">Kop Resmi</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ route('generator.result') }}" class="superapp-wallet-btn text-decoration-none">
                        <div class="superapp-wallet-btn-circle">
                            <span class="material-symbols-outlined" style="font-size: 20px;">upload_file</span>
                        </div>
                        <span class="superapp-wallet-btn-label">Batch Zip</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ route('modul-ajar.index') }}" class="superapp-wallet-btn text-decoration-none">
                        <div class="superapp-wallet-btn-circle">
                            <span class="material-symbols-outlined" style="font-size: 20px;">history_edu</span>
                        </div>
                        <span class="superapp-wallet-btn-label">Riwayat Dok</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. 8 SUPERAPP SERVICE SQUIRCLE GRID (LAYANAN UNGGULAN GURU) -->
    <section class="superapp-service-grid-card mb-3.5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-1.5">
                <span class="material-symbols-outlined text-primary" style="font-size: 20px;">apps</span>
                <h2 class="superapp-section-title mb-0">Layanan Unggulan Guru</h2>
            </div>
            <a href="{{ route('generator.index') }}" class="superapp-link-pill text-decoration-none">
                <span>Atur Cepat</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
            </a>
        </div>

        <div class="row g-2 text-center">
            <!-- 1. PEDATTI (Modul Ajar Deep Learning) -->
            <div class="col-3">
                <a href="{{ route('modul-ajar.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-blue-box position-relative">
                        <span class="material-symbols-outlined fill-icon text-primary" style="font-size: 26px;">auto_awesome</span>
                        <span class="superapp-badge-corner bg-danger">3M</span>
                    </div>
                    <span class="superapp-squircle-label">PEDATTI</span>
                </a>
            </div>

            <!-- 2. Smart Soal (Kisi-Kisi 8 Kolom & Bank Soal) -->
            <div class="col-3">
                <a href="{{ route('paket-soal.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-amber-box">
                        <span class="material-symbols-outlined fill-icon text-warning-custom" style="font-size: 26px;">quiz</span>
                    </div>
                    <span class="superapp-squircle-label">Smart Soal</span>
                </a>
            </div>

            <!-- 3. Prota & Promes -->
            <div class="col-3">
                <a href="{{ route('prota-promes.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-emerald-box">
                        <span class="material-symbols-outlined fill-icon text-success" style="font-size: 26px;">calendar_month</span>
                    </div>
                    <span class="superapp-squircle-label">Prota Promes</span>
                </a>
            </div>

            <!-- 4. Koding & AI (SMK) -->
            <div class="col-3">
                <a href="{{ route('generator.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-purple-box position-relative">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 26px; color: #9333ea;">memory</span>
                        <span class="superapp-badge-corner" style="background-color: #1e3a8a;">SMK</span>
                    </div>
                    <span class="superapp-squircle-label">Koding &amp; AI</span>
                </a>
            </div>

            <!-- 5. LKPD Proyek -->
            <div class="col-3">
                <a href="{{ route('lkpd.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-orange-box">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 26px; color: #ea580c;">assignment</span>
                    </div>
                    <span class="superapp-squircle-label">LKPD Proyek</span>
                </a>
            </div>

            <!-- 6. Asesmen DPL -->
            <div class="col-3">
                <a href="{{ route('asesmen.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-cyan-box">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 26px; color: #0891b2;">verified</span>
                    </div>
                    <span class="superapp-squircle-label">Asesmen DPL</span>
                </a>
            </div>

            <!-- 7. Kop Sekolah -->
            <div class="col-3">
                <a href="{{ route('profile.setup') }}" class="superapp-squircle-item text-decoration-none d-block">
                    <div class="superapp-squircle-box bg-rose-box">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 26px; color: #e11d48;">school</span>
                    </div>
                    <span class="superapp-squircle-label">Kop Sekolah</span>
                </a>
            </div>

            <!-- 8. Lainnya (All Menu Sheet) -->
            <div class="col-3">
                <button type="button" class="superapp-squircle-item text-decoration-none d-block w-100 bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#modalSemuaLayanan">
                    <div class="superapp-squircle-box bg-slate-box">
                        <span class="material-symbols-outlined text-secondary" style="font-size: 26px;">grid_view</span>
                    </div>
                    <span class="superapp-squircle-label">Lainnya</span>
                </button>
            </div>
        </div>
    </section>

    <!-- KHUSUS SUPERADMIN: KONTROL SERVER AAPANEL & HOSTING -->
    @if(auth()->user()->isSuperAdmin())
        <section class="superapp-service-grid-card mb-3.5 border-danger border-opacity-25" style="background-color: #fffafb;">
            <div class="d-flex align-items-center justify-content-between mb-2.5">
                <div class="d-flex align-items-center gap-1.5">
                    <span class="material-symbols-outlined text-danger" style="font-size: 19px;">shield_lock</span>
                    <h3 class="superapp-section-title text-danger mb-0" style="font-size: 13px;">Kontrol Superadmin (aaPanel)</h3>
                </div>
                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25" style="font-size: 0.65rem;">
                    Server Live
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
        </section>
    @endif

    <!-- 5. PROMO & INOVASI REGULASI 2026 CAROUSEL (GRAB/GOJEK STYLE) -->
    <section class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2 px-1">
            <div class="d-flex align-items-center gap-1.5">
                <span class="material-symbols-outlined text-warning-custom" style="font-size: 20px;">campaign</span>
                <h3 class="superapp-section-title mb-0">Wawasan Regulasi 2026</h3>
            </div>
            <span class="text-secondary small" style="font-size: 0.72rem;">Geser &raquo;</span>
        </div>

        <div class="superapp-carousel-container">
            <!-- Banner 1: BSKAP 046/2025 -->
            <div class="superapp-banner-card bg-banner-blue">
                <div class="superapp-banner-ambient"></div>
                <div class="position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center gap-1.5 mb-2">
                        <span class="superapp-badge-amber">BARU 2026</span>
                        <span class="superapp-card-eyebrow text-info">BSKAP 046/2025</span>
                    </div>
                    <h4 class="superapp-banner-title">
                        Sinkronisasi Otomatis TP &amp; ATP
                    </h4>
                    <p class="superapp-banner-desc">
                        Penyusunan modul tanpa halusinasi dengan validasi kurikulum merdeka terbaru resmi BSKAP.
                    </p>
                </div>
                <div class="superapp-banner-footer">
                    <span class="fw-bold small text-info" style="font-size: 0.76rem;">Aktifkan di Modul</span>
                    <a href="{{ route('generator.index') }}" class="superapp-banner-btn-arrow text-decoration-none" title="Buka Generator">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Banner 2: Deep Learning 3M -->
            <div class="superapp-banner-card bg-banner-dark">
                <div class="superapp-banner-ambient-amber"></div>
                <div class="position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center gap-1.5 mb-2">
                        <span class="superapp-badge-emerald">PEDATTI 3M</span>
                        <span class="superapp-card-eyebrow text-secondary">PERMEN NO. 13</span>
                    </div>
                    <h4 class="superapp-banner-title text-white">
                        Mindful, Meaningful, Joyful
                    </h4>
                    <p class="superapp-banner-desc text-secondary">
                        Rancangan 3 pilar pedagogik modern SMK untuk pembelajaran aktif berbasis industri vokasi.
                    </p>
                </div>
                <div class="superapp-banner-footer border-secondary border-opacity-25">
                    <span class="fw-bold small text-warning" style="font-size: 0.76rem;">Lihat Template</span>
                    <a href="{{ route('modul-ajar.index') }}" class="superapp-banner-btn-amber text-decoration-none" title="Lihat Modul Ajar">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. PERANGKAT SIAP EKSPOR (FEED SUPERAPP DOKUMEN GURU) -->
    <section class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2.5 px-1">
            <div class="d-flex align-items-center gap-1.5">
                <span class="material-symbols-outlined text-primary" style="font-size: 20px;">insights</span>
                <h3 class="superapp-section-title mb-0">Perangkat Siap Ekspor</h3>
            </div>
            <span class="superapp-card-eyebrow text-secondary">Semester Genap 2026</span>
        </div>

        <div class="d-flex flex-column gap-2.5">
            @php $hasDocs = false; @endphp

            <!-- Feed Items dari Recent Modul Ajar -->
            @if(isset($recentModul) && $recentModul->count() > 0)
                @foreach($recentModul->take(2) as $rm)
                    @php $hasDocs = true; @endphp
                    <div class="superapp-feed-card">
                        <div class="d-flex align-items-start justify-content-between gap-2.5">
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="superapp-tag-pill-blue">
                                        Fase {{ $rm->fase->kode ?? 'E' }} &bull; Kelas {{ $rm->fase->tingkat_kelas ?? 'X' }}
                                    </span>
                                    <span class="superapp-card-eyebrow text-secondary text-truncate" style="max-width: 140px;">
                                        {{ $rm->mataPelajaran->nama ?? 'Kejuruan SMK' }}
                                    </span>
                                </div>
                                <h4 class="superapp-feed-title text-truncate-2 mb-1">
                                    {{ $rm->materi_pokok ?? ($rm->mataPelajaran->nama ?? 'Modul Ajar Deep Learning') }}
                                </h4>
                                <p class="superapp-feed-desc mb-0">
                                    Tersinkronisasi TP, Sintaks PEDATTI, dan Rubrik Profil Lulusan untuk murid.
                                </p>
                            </div>
                            <div class="superapp-feed-icon-box bg-blue-subtle text-primary flex-shrink-0">
                                <span class="material-symbols-outlined fill-icon" style="font-size: 24px;">description</span>
                            </div>
                        </div>

                        <div class="superapp-feed-footer d-flex align-items-center justify-content-between pt-2.5 mt-2.5 border-top border-slate-100">
                            <div class="d-flex align-items-center gap-1.5 text-secondary" style="font-size: 0.72rem;">
                                <span class="d-flex align-items-center gap-0.5 text-success fw-bold">
                                    <span class="material-symbols-outlined" style="font-size: 15px;">check_circle</span> Terisi 100%
                                </span>
                                <span class="text-slate-300">&bull;</span>
                                <span>{{ $rm->updated_at ? $rm->updated_at->diffForHumans() : 'Baru' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5">
                                <a href="{{ route('modul-ajar.show', $rm->id) }}" class="btn btn-light btn-sm rounded-pill px-3 py-1 superapp-btn-preview">
                                    <span class="material-symbols-outlined me-0.5" style="font-size: 14px;">visibility</span> Pratinjau
                                </a>
                                <a href="{{ route('export.modul-ajar.docx', $rm->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 superapp-btn-docx">
                                    <span class="material-symbols-outlined me-0.5" style="font-size: 14px;">download</span> DOCX
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Feed Items dari Recent ATP -->
            @if(isset($recentAtp) && $recentAtp->count() > 0)
                @foreach($recentAtp->take(1) as $ra)
                    @php $hasDocs = true; @endphp
                    <div class="superapp-feed-card">
                        <div class="d-flex align-items-start justify-content-between gap-2.5">
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="superapp-tag-pill-amber">
                                        Fase {{ $ra->fase->kode ?? 'E' }} &bull; Alur ATP
                                    </span>
                                    <span class="superapp-card-eyebrow text-secondary text-truncate" style="max-width: 140px;">
                                        {{ $ra->mataPelajaran->nama ?? 'Umum/Kejuruan' }}
                                    </span>
                                </div>
                                <h4 class="superapp-feed-title text-truncate-2 mb-1">
                                    Alur Tujuan Pembelajaran: {{ $ra->mataPelajaran->nama ?? 'ATP Terstruktur' }}
                                </h4>
                                <p class="superapp-feed-desc mb-0">
                                    Peta urutan kompetensi murid dari tingkat dasar hingga tingkat mahir.
                                </p>
                            </div>
                            <div class="superapp-feed-icon-box bg-amber-subtle text-warning-custom flex-shrink-0">
                                <span class="material-symbols-outlined fill-icon" style="font-size: 24px;">account_tree</span>
                            </div>
                        </div>

                        <div class="superapp-feed-footer d-flex align-items-center justify-content-between pt-2.5 mt-2.5 border-top border-slate-100">
                            <div class="d-flex align-items-center gap-1.5 text-secondary" style="font-size: 0.72rem;">
                                <span class="d-flex align-items-center gap-0.5 text-success fw-bold">
                                    <span class="material-symbols-outlined" style="font-size: 15px;">check_circle</span> Rujukan BSKAP
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5">
                                <a href="{{ route('atp.show', $ra->id) }}" class="btn btn-light btn-sm rounded-pill px-3 py-1 superapp-btn-preview">
                                    <span class="material-symbols-outlined me-0.5" style="font-size: 14px;">visibility</span> Pratinjau
                                </a>
                                <a href="{{ route('export.atp.docx', $ra->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 superapp-btn-docx">
                                    <span class="material-symbols-outlined me-0.5" style="font-size: 14px;">download</span> DOCX
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Empty State jika belum ada dokumen -->
            @if(!$hasDocs)
                <div class="superapp-feed-card text-center py-4">
                    <div class="superapp-feed-icon-box bg-blue-subtle text-primary mx-auto mb-2" style="width: 50px; height: 50px;">
                        <span class="material-symbols-outlined" style="font-size: 28px;">auto_awesome</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada Dokumen Terbit</h5>
                    <p class="text-secondary small mb-3" style="font-size: 0.78rem;">
                        Gunakan generator 1-klik untuk menghasilkan Modul Ajar, ATP, LKPD, dan Asesmen otomatis.
                    </p>
                    <a href="{{ route('generator.index') }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                        <span class="material-symbols-outlined me-1" style="font-size: 16px;">bolt</span> Buat Sekarang
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- 7. HAK CIPTA & KEPATUHAN REGULASI KEDINASAN -->
    <footer class="superapp-copyright-card mb-4 text-center">
        <div class="superapp-copyright-stripe"></div>
        <div class="pt-2">
            <div class="d-inline-flex align-items-center gap-1.5 px-3 py-1 rounded-pill mb-2 superapp-creator-chip">
                <span class="material-symbols-outlined fill-icon text-primary" style="font-size: 14px;">verified</span>
                <span>HAK CIPTA &bull; DESAIN BY. {{ strtoupper(app_setting('landing_creator_name', 'Vicky Koroh')) }}</span>
            </div>
            <div class="fw-bold text-dark mb-0.5" style="font-size: 0.88rem;">
                {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK') }} &copy; {{ app_setting('landing_copyright_year', '2026') }}
            </div>
            <div class="text-secondary small mb-2" style="font-size: 0.74rem;">
                Kurikulum Merdeka SMK &bull; Pendekatan Pembelajaran Mendalam (Deep Learning)
            </div>
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-1.5">
                <span class="superapp-badge-gray">BSKAP 046/H/KR/2025</span>
                <span class="superapp-badge-gray">Permendikdasmen No. 13/2025</span>
                <span class="superapp-badge-green">
                    <span class="material-symbols-outlined" style="font-size: 13px;">smartphone</span> Android SuperApp
                </span>
            </div>
        </div>
    </footer>

</div>

<!-- ===================================================================== -->
<!-- MODAL BOTTOM SHEET: SEMUA LAYANAN PERANGKAT AJAR                     -->
<!-- ===================================================================== -->
<div class="modal fade" id="modalSemuaLayanan" tabindex="-1" aria-labelledby="modalSemuaLayananLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 border-0 shadow-2xl p-2">
            <div class="modal-header border-0 pb-1">
                <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-1.5" id="modalSemuaLayananLabel">
                    <span class="material-symbols-outlined text-primary" style="font-size: 20px;">apps</span>
                    Semua Layanan &bull; SMK 2026
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-1">
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <a href="{{ route('tp.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-blue-box mx-auto">
                                <span class="material-symbols-outlined text-primary" style="font-size: 22px;">track_changes</span>
                            </div>
                            <span class="superapp-squircle-label">Tujuan (TP)</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('atp.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-purple-box mx-auto">
                                <span class="material-symbols-outlined text-purple" style="font-size: 22px;">account_tree</span>
                            </div>
                            <span class="superapp-squircle-label">Alur (ATP)</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('modul-ajar.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-emerald-box mx-auto">
                                <span class="material-symbols-outlined text-success" style="font-size: 22px;">description</span>
                            </div>
                            <span class="superapp-squircle-label">Modul Ajar</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('lkpd.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-orange-box mx-auto">
                                <span class="material-symbols-outlined text-warning" style="font-size: 22px;">assignment</span>
                            </div>
                            <span class="superapp-squircle-label">LKPD</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('asesmen.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-cyan-box mx-auto">
                                <span class="material-symbols-outlined text-info" style="font-size: 22px;">verified</span>
                            </div>
                            <span class="superapp-squircle-label">Asesmen</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('paket-soal.index') }}" class="superapp-squircle-item text-decoration-none d-block">
                            <div class="superapp-squircle-box bg-amber-box mx-auto">
                                <span class="material-symbols-outlined text-warning-custom" style="font-size: 22px;">quiz</span>
                            </div>
                            <span class="superapp-squircle-label">Smart Soal</span>
                        </a>
                </div>
                <!-- Akun & Logout -->
                <div class="border-top pt-2.5 mt-3 d-flex align-items-center justify-content-between">
                    <a href="{{ route('profile.setup') }}" class="btn btn-sm btn-light border rounded-pill px-3 text-secondary d-inline-flex align-items-center gap-1.5" style="font-size: 0.74rem;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">person</span> Profil Saya
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 d-inline-flex align-items-center gap-1.5" onclick="confirmMobileLogout(); return false;" style="font-size: 0.74rem;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">logout</span> Keluar Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ============================================================ */
    /* SUPERAPP GURU SMK CSS (STITCH ANDROID SPECIFICATION)         */
    /* ============================================================ */
    .superapp-mobile-shell {
        max-width: 480px;
        margin: 0 auto;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* TopBar Avatar */
    .superapp-avatar-ring {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        padding: 2px;
        background: linear-gradient(135deg, #1e3a8a 0%, #00236f 100%);
        box-shadow: 0 0 0 2px #eff6ff;
    }

    .superapp-avatar-initial {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #1e3a8a;
        color: #ffffff;
        font-weight: 800;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .superapp-verified-badge {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 18px;
        height: 18px;
        background-color: #00236f;
        color: #ffffff;
        border-radius: 50%;
        border: 2px solid #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .superapp-eyebrow {
        font-size: 11px;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .superapp-amber-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #f59e0b;
        flex-shrink: 0;
    }

    .superapp-user-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .superapp-icon-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease, background-color 0.15s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .superapp-icon-btn:active {
        transform: scale(0.92);
        background-color: #f1f5f9;
    }

    .superapp-notif-dot {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ba1a1a;
        border: 1.5px solid #ffffff;
    }

    /* Quick Search Bar */
    .superapp-search-bar {
        display: flex;
        align-items: center;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 9999px;
        padding: 9px 14px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
        transition: all 0.2s ease;
    }

    .superapp-search-bar:active {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }

    .superapp-search-placeholder {
        font-size: 13px;
        color: #64748b;
    }

    .superapp-search-voice-pill {
        background-color: #eff6ff;
        color: #1e3a8a;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        gap: 3px;
        flex-shrink: 0;
    }

    /* Wallet Style Quick Card */
    .superapp-wallet-card {
        background-color: #111827;
        color: #ffffff;
        border-radius: 1.5rem;
        padding: 16px;
        box-shadow: 0 12px 30px rgba(17, 24, 39, 0.18);
    }

    .superapp-wallet-ambient {
        position: absolute;
        right: -24px;
        bottom: -24px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(30, 58, 138, 0.5) 0%, rgba(17, 24, 39, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .superapp-wallet-icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #1e3a8a;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .superapp-card-eyebrow {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .superapp-pill-unlimited {
        background-color: #f59e0b;
        color: #111827;
        font-size: 9px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 9999px;
    }

    .superapp-wallet-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        touch-action: manipulation;
    }

    .superapp-wallet-btn:active .superapp-wallet-btn-circle {
        transform: scale(0.92);
    }

    .superapp-wallet-btn-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        margin-bottom: 6px;
        transition: transform 0.15s ease, background 0.15s ease;
    }

    .superapp-wallet-btn-label {
        font-size: 11px;
        color: #ffffff;
        line-height: 1.2;
        font-weight: 500;
    }

    /* 8-Grid Layanan Unggulan Guru */
    .superapp-service-grid-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.5rem;
        padding: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .superapp-section-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .superapp-link-pill {
        color: #1e3a8a;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .superapp-squircle-item {
        touch-action: manipulation;
    }

    .superapp-squircle-item:active .superapp-squircle-box {
        transform: scale(0.92);
    }

    .superapp-squircle-box {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        margin: 0 auto 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .superapp-squircle-label {
        font-size: 11px;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.2;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Squircle Color Themes */
    .bg-blue-box { background-color: #eff6ff; border: 1px solid #dbeafe; }
    .bg-amber-box { background-color: #fffbeb; border: 1px solid #fef3c7; }
    .bg-emerald-box { background-color: #ecfdf5; border: 1px solid #d1fae5; }
    .bg-purple-box { background-color: #faf5ff; border: 1px solid #f3e8ff; }
    .bg-orange-box { background-color: #fff7ed; border: 1px solid #ffedd5; }
    .bg-cyan-box { background-color: #ecfeff; border: 1px solid #cffafe; }
    .bg-rose-box { background-color: #fff1f2; border: 1px solid #ffe4e6; }
    .bg-slate-box { background-color: #f1f5f9; border: 1px solid #e2e8f0; }

    .text-warning-custom { color: #d97706; }

    .superapp-badge-corner {
        position: absolute;
        top: -4px;
        right: -3px;
        color: #ffffff;
        font-size: 9px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 9999px;
        border: 1.5px solid #ffffff;
    }

    /* Carousel Wawasan Regulasi */
    .superapp-carousel-container {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 6px;
        scrollbar-width: none;
    }

    .superapp-carousel-container::-webkit-scrollbar {
        display: none;
    }

    .superapp-banner-card {
        flex: 0 0 280px;
        max-width: 280px;
        scroll-snap-align: start;
        border-radius: 1.5rem;
        padding: 16px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .bg-banner-blue {
        background: linear-gradient(135deg, #1e3a8a 0%, #00236f 100%);
        color: #ffffff;
    }

    .bg-banner-dark {
        background-color: #111827;
        color: #ffffff;
        border: 1px solid #334155;
    }

    .superapp-banner-ambient {
        position: absolute;
        top: -16px;
        right: -16px;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .superapp-banner-ambient-amber {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 90px;
        height: 90px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.25) 0%, transparent 70%);
        border-radius: 50%;
    }

    .superapp-banner-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.25;
        margin-bottom: 4px;
    }

    .superapp-banner-desc {
        font-size: 12px;
        line-height: 1.45;
        color: rgba(255, 255, 255, 0.85);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .superapp-banner-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
    }

    .superapp-banner-btn-arrow {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #ffffff;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .superapp-banner-btn-amber {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #f59e0b;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .superapp-badge-amber {
        background-color: #f59e0b;
        color: #111827;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 9999px;
    }

    .superapp-badge-emerald {
        background-color: #10b981;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 9999px;
    }

    /* Feed Bento Card */
    .superapp-feed-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.25rem;
        padding: 14px 16px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        transition: transform 0.15s ease;
    }

    .superapp-tag-pill-blue {
        background-color: #eff6ff;
        color: #1e3a8a;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 9999px;
    }

    .superapp-tag-pill-amber {
        background-color: #fffbeb;
        color: #b45309;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 9999px;
    }

    .superapp-feed-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
    }

    .superapp-feed-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .superapp-feed-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .superapp-btn-preview {
        font-size: 11px;
        font-weight: 700;
        color: #0f172a;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .superapp-btn-docx {
        font-size: 11px;
        font-weight: 700;
        color: #ffffff;
        background-color: #0f172a;
        border: 1px solid #0f172a;
    }

    /* Footer Copyright Card */
    .superapp-copyright-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.25rem;
        padding: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .superapp-copyright-stripe {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: linear-gradient(90deg, #1e3a8a 0%, #0284c7 50%, #f59e0b 100%);
    }

    .superapp-creator-chip {
        background-color: #eff6ff;
        color: #1e3a8a !important;
        border: 1px solid #bfdbfe;
        font-size: 11px;
        font-weight: 800;
    }

    .superapp-badge-gray {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        border: 1px solid #e2e8f0;
    }

    .superapp-badge-green {
        background-color: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 9999px;
        border: 1px solid #86efac;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
</style>
