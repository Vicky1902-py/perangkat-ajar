@extends('layouts.mobile')

@section('title', 'Detail Generator 1-Klik - Kurikulum Merdeka SMK')

@section('header')
    <!-- MOBILE TOP HEADER (STITCH SPEC) -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="mobile-nav-btn text-dark text-decoration-none" title="Kembali ke Beranda">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-gen-title mb-0">Detail Generator 1-Klik</h1>
            <span class="mobile-gen-eyebrow">BSKAP 046/2025</span>
        </div>
        <button type="button" class="mobile-nav-btn text-dark border-0 bg-white" onclick="showVxAgentWelcomeModal(); return false;" title="Bantuan Vx Agent">
            <span class="material-symbols-outlined text-primary" style="font-size: 20px;">support_agent</span>
        </button>
    </header>
@endsection

@section('content')
<div class="mobile-generator-shell mb-4">

    <!-- HERO SHOWCASE CARD (STITCH VISUAL SPECIFICATION) -->
    <section class="mobile-showcase-card mb-3.5 position-relative overflow-hidden">
        <div class="mobile-showcase-overlay"></div>
        <div class="position-relative p-3.5" style="z-index: 2;">
            <!-- Floating Pill Badges Top -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                    <span class="mobile-pill-badge bg-white text-primary">
                        <span class="material-symbols-outlined fill-icon" style="font-size: 13px;">verified</span>
                        <span>Sistem Pakar Murni</span>
                    </span>
                    <span class="mobile-pill-badge bg-warning text-dark">
                        Nol Halusinasi
                    </span>
                </div>
                <span class="mobile-pill-badge bg-dark text-warning">
                    ★ {{ $isGuest ? 'Gratis 2x' : 'Pro Unlimited' }}
                </span>
            </div>

            <!-- Editorial Titles -->
            <div class="text-white mb-2.5">
                <div class="d-inline-flex align-items-center gap-1 text-info small fw-bold mb-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                    <span class="material-symbols-outlined fill-icon" style="font-size: 14px;">auto_awesome</span>
                    Formula 1-Klik Otomatis
                </div>
                <h2 class="mobile-showcase-h2 text-white mb-1">
                    Modul Ajar Deep Learning
                </h2>
                <p class="text-white text-opacity-80 small mb-0" style="font-size: 0.78rem;">
                    3 Pilar Esensial: Mindful, Meaningful, &amp; Joyful
                </p>
            </div>

            <!-- 5-Star Rating Bar -->
            <div class="d-flex align-items-center gap-2 pt-2 border-top border-white border-opacity-15 mb-3">
                <div class="d-flex align-items-center text-warning" style="font-size: 13px;">
                    <span class="material-symbols-outlined fill-icon">star</span>
                    <span class="material-symbols-outlined fill-icon">star</span>
                    <span class="material-symbols-outlined fill-icon">star</span>
                    <span class="material-symbols-outlined fill-icon">star</span>
                    <span class="material-symbols-outlined fill-icon">star</span>
                </div>
                <span class="text-white text-opacity-90 small" style="font-size: 0.72rem;">
                    <strong>5.0 / 5</strong> (1.4k guru SMK terverifikasi)
                </span>
            </div>

            <!-- 3 Pillars Bento Grid -->
            <div class="row g-1.5 text-center">
                <div class="col-4">
                    <div class="mobile-pillar-box bg-white bg-opacity-10 text-white">
                        <span class="mobile-pillar-num bg-primary text-white">1</span>
                        <div class="fw-bold small" style="font-size: 0.75rem;">Mindful</div>
                        <div class="text-white text-opacity-75" style="font-size: 0.65rem;">Berkesadaran</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mobile-pillar-box bg-white bg-opacity-10 text-white">
                        <span class="mobile-pillar-num bg-warning text-dark">2</span>
                        <div class="fw-bold small" style="font-size: 0.75rem;">Meaningful</div>
                        <div class="text-white text-opacity-75" style="font-size: 0.65rem;">DUDI &amp; Nyata</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mobile-pillar-box bg-white bg-opacity-10 text-white">
                        <span class="mobile-pillar-num bg-success text-white">3</span>
                        <div class="fw-bold small" style="font-size: 0.75rem;">Joyful</div>
                        <div class="text-white text-opacity-75" style="font-size: 0.65rem;">Eksperimen</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FORM GENERATOR MOBILE -->
    <form action="{{ route('generator.process') }}" method="POST" id="formGeneratorMobile" novalidate>
        @csrf
        <input type="hidden" name="mata_pelajaran_id" id="mata_pelajaran_id" value="">
        <input type="hidden" name="fase_id" id="fase_id" value="{{ $fases->first()->id ?? '' }}">
        <input type="hidden" name="capaian_pembelajaran_id" id="capaian_pembelajaran_id" value="">
        <input type="hidden" name="alokasi_jp" id="alokasi_jp" value="3">
        <input type="hidden" name="tahun_ajaran_mode" id="tahun_ajaran_mode" value="dropdown">

        <!-- SEGMENTED PILL SELECTOR FOR PHASE / KELAS -->
        <section class="mb-3.5 bg-white p-3 rounded-4 border shadow-xs">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="fw-bold text-dark small mb-0">Pilih Tingkat / Fase SMK</label>
                <span class="text-primary small fw-semibold" style="font-size: 0.75rem;">BSKAP 046/2025</span>
            </div>
            <div class="row g-2">
                @foreach($fases as $f)
                    <div class="col-{{ count($fases) == 2 ? '6' : '4' }}">
                        <button type="button" class="btn-mobile-phase-pill {{ $loop->first ? 'active' : '' }} w-100" data-fase-id="{{ $f->id }}" data-fase-kode="{{ $f->kode }}" onclick="selectMobilePhase('{{ $f->id }}', '{{ $f->kode }}', this)">
                            <span class="material-symbols-outlined me-1 active-check" style="font-size: 15px; {{ $loop->first ? '' : 'display:none;' }}">check_circle</span>
                            Fase {{ $f->kode }} ({{ $f->kelas_range }})
                        </button>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- PROGRAM & MAPEL VOKASI SELECTOR -->
        <section class="mb-3.5 bg-white p-3 rounded-4 border shadow-xs">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="fw-bold text-dark small mb-0">Mata Pelajaran SMK</label>
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size: 0.68rem;">Terstandar</span>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex gap-1.5 overflow-x-auto pb-2 mb-2 no-scrollbar" style="white-space: nowrap;">
                <button type="button" class="btn-mobile-filter-pill active" onclick="filterMobileMapel('all', this)">
                    Semua
                </button>
                <button type="button" class="btn-mobile-filter-pill" onclick="filterMobileMapel('koding', this)">
                    🤖 Koding &amp; AI
                </button>
                <button type="button" class="btn-mobile-filter-pill" onclick="filterMobileMapel('pkk', this)">
                    💼 PKK &amp; PKL
                </button>
                <button type="button" class="btn-mobile-filter-pill" onclick="filterMobileMapel('dasar', this)">
                    📐 Dasar Jurusan
                </button>
                <button type="button" class="btn-mobile-filter-pill" onclick="filterMobileMapel('umum', this)">
                    📚 Mapel Umum
                </button>
            </div>

            <!-- Mobile Dropdown Selector -->
            <select class="form-select form-select-sm rounded-pill shadow-none py-2" id="mata_pelajaran_id_mobile" onchange="syncMobileMapel(this)">
                <option value="" selected disabled>-- Ketuk untuk Memilih Mapel --</option>
                @foreach($mapels as $m)
                    <option value="{{ $m->id }}" data-nama="{{ strtolower($m->nama) }}" data-kelompok="{{ $m->kelompok }}" data-fase-default="{{ str_starts_with($m->nama, 'Dasar-dasar') ? 'E' : ($m->kelompok === 'kejuruan' ? 'F' : 'E') }}">
                        {{ $m->nama }} ({{ ucfirst($m->kelompok) }})
                    </option>
                @endforeach
            </select>

            <!-- Mobile CP Preview Status Card -->
            <div id="mobileCpPreviewCard" class="mt-2.5 p-2.5 rounded-3 bg-light border" style="display: none;">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" id="mobileCpFaseBadge" style="font-size: 0.68rem;">Fase E</span>
                    <span class="text-success small fw-bold d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">verified</span>
                        CP BSKAP Terverifikasi
                    </span>
                </div>
                <div class="text-dark small fw-semibold text-truncate mb-1.5" id="mobileCpTitle" style="font-size: 0.78rem;"></div>
                <div class="d-flex flex-wrap gap-1" id="mobileCpElemenList"></div>
            </div>
            <div id="mobileCpNotFoundCard" class="mt-2.5 p-2 rounded-3 bg-warning bg-opacity-10 border border-warning text-warning-emphasis small" style="display: none; font-size: 0.72rem;">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 14px;">warning</span>
                CP belum tersedia di database untuk kombinasi ini.
            </div>
        </section>

        <!-- TAHUN AJARAN & KOP -->
        <section class="mb-3.5 bg-white p-3 rounded-4 border shadow-xs">
            <div class="d-flex justify-content-between align-items-center mb-1.5">
                <label class="fw-bold text-dark small mb-0">Tahun Ajaran Aktif</label>
                <span class="text-muted small" style="font-size: 0.72rem;">Kop Sekolah</span>
            </div>
            <select class="form-select form-select-sm rounded-pill shadow-none py-1.5" id="tahun_ajaran_id" name="tahun_ajaran_id">
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta->id }}" {{ $ta->is_active ? 'selected' : '' }}>
                        {{ $ta->nama }} &bull; Semester {{ $ta->semester }}
                    </option>
                @endforeach
            </select>
        </section>

        <!-- COLLAPSIBLE ACCORDION REGULASI & OUTPUT (STITCH SPEC) -->
        <div class="accordion accordion-flush mb-3.5 rounded-4 overflow-hidden border bg-white shadow-xs" id="mobileAccordionDetails">
            <!-- Item 1: Regulasi Kedinasan -->
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed py-2.5 px-3 bg-white text-dark fw-bold small shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <span class="material-symbols-outlined text-primary me-2" style="font-size: 18px;">policy</span>
                        Rujukan Regulasi Kedinasan 2026
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#mobileAccordionDetails">
                    <div class="accordion-body p-3 pt-1 text-secondary small" style="font-size: 0.75rem; line-height: 1.5;">
                        <div class="d-flex align-items-start gap-2 mb-2 p-2 rounded-3 bg-light border">
                            <span class="material-symbols-outlined text-primary mt-0.5" style="font-size: 15px;">check</span>
                            <div><strong>BSKAP 046/H/KR/2025:</strong> Capaian Pembelajaran resmi dengan elemen kompetensi nasional.</div>
                        </div>
                        <div class="d-flex align-items-start gap-2 p-2 rounded-3 bg-light border">
                            <span class="material-symbols-outlined text-primary mt-0.5" style="font-size: 15px;">check</span>
                            <div><strong>Permendikdasmen 13/2025:</strong> Distribusi JP, Prota, Promes, &amp; Ekspor DOCX ber-Kop Surat.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2: Output Dokumen 6-in-1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed py-2.5 px-3 bg-white text-dark fw-bold small shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <span class="material-symbols-outlined text-secondary me-2" style="font-size: 18px;">inventory_2</span>
                        Output Dokumen Lengkap (6-in-1)
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#mobileAccordionDetails">
                    <div class="accordion-body p-3 pt-1">
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">1. Modul Ajar PEDATTI</span>
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">2. ATP &amp; CP Resmi</span>
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">3. Lembar Kerja (LKPD)</span>
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">4. Prota &amp; Promes</span>
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">5. Asesmen Diagnostik</span>
                            <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.68rem;">6. Kisi-Kisi 8 Kolom</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRUST NOTE: KEDAULATAN DATA -->
        <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 d-flex align-items-center gap-2.5 mb-4">
            <span class="material-symbols-outlined text-primary" style="font-size: 24px;">shield</span>
            <div class="small">
                <div class="fw-bold text-primary" style="font-size: 0.8rem;">Kedaulatan Data Satuan Pendidikan</div>
                <div class="text-secondary" style="font-size: 0.72rem; line-height: 1.35;">
                    100% sistem pakar server mandiri. Data guru &amp; murid aman tidak diunggah ke pihak asing.
                </div>
            </div>
        </div>

        <!-- FIXED FLOATING BOTTOM ACTION DOCK (STITCH SIGNATURE STEPPER + CTA) -->
        <div class="mobile-gen-floating-dock">
            <div class="mobile-gen-dock-inner">
                <!-- Left Stepper (Alokasi JP per pertemuan) -->
                <div class="d-flex align-items-center gap-1.5 px-2">
                    <button type="button" class="btn-stepper" onclick="decrementMobileJp()" title="Kurang Jam Pelajaran">
                        <span class="material-symbols-outlined" style="font-size: 15px;">remove</span>
                    </button>
                    <div class="text-center" style="min-width: 44px;">
                        <span class="fw-bold text-white block lh-1" id="mobileJpDisplay" style="font-size: 13px;">3 JP</span>
                        <span class="text-secondary" style="font-size: 8px; text-transform: uppercase;">Per Sesi</span>
                    </div>
                    <button type="button" class="btn-stepper" onclick="incrementMobileJp()" title="Tambah Jam Pelajaran">
                        <span class="material-symbols-outlined" style="font-size: 15px;">add</span>
                    </button>
                </div>

                <!-- Right Large Primary Pill CTA -->
                @if($guestLimitReached)
                    <a href="{{ route('register') }}" class="btn-mobile-generate bg-warning text-dark text-decoration-none">
                        <span class="d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined" style="font-size: 16px;">lock</span>
                            Kuota Tamu Habis
                        </span>
                    </a>
                @else
                    <button type="button" class="btn-mobile-generate" id="btnTriggerMobileGenerate" onclick="triggerMobileGenerate()">
                        <span class="d-flex align-items-center gap-1 text-dark">
                            <span class="material-symbols-outlined text-primary fill-icon" style="font-size: 17px;">bolt</span>
                            Generate
                        </span>
                        <span class="fw-bold text-primary font-monospace" style="font-size: 14px;">
                            &gt;&gt;&gt;
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- LUXURY AI GENERATION PROCESSING OVERLAY -->
<div id="aiProcessingOverlay" class="fixed-top vh-100 vw-100 d-none flex-column align-items-center justify-content-center" 
     style="background: radial-gradient(circle at center, rgba(15, 23, 42, 0.96) 0%, rgba(3, 7, 18, 0.98) 100%); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); z-index: 99999;">
    
    <div style="position: absolute; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, rgba(99, 102, 241, 0.15) 50%, transparent 70%); filter: blur(40px); animation: pulseGlow 4s ease-in-out infinite;"></div>

    <div class="text-center position-relative px-4" style="max-width: 440px;">
        <!-- AI CORE ORB ANIMATION -->
        <div class="ai-orb-container mx-auto mb-3 position-relative" style="width: 110px; height: 110px;">
            <div class="ai-orb-ring-outer"></div>
            <div class="ai-orb-ring-inner"></div>
            <div class="ai-orb-core d-flex align-items-center justify-content-center">
                <i class="bi bi-cpu text-white" style="font-size: 2.3rem; filter: drop-shadow(0 0 15px rgba(255,255,255,0.8));"></i>
            </div>
        </div>

        <h5 class="fw-bold text-white mb-1.5" style="letter-spacing: -0.3px;">
            Menyusun Perangkat Ajar Lengkap
        </h5>
        <div class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill mb-3 font-monospace" style="font-size: 0.68rem;">
            <i class="bi bi-cpu-fill me-1 text-warning"></i> MESIN SISTEM PAKAR SMK 2026 (NOL HALUSINASI)
        </div>

        <!-- PROGRESS BAR -->
        <div class="progress mb-3 shadow-lg" style="height: 7px; background: rgba(255,255,255,0.1); border-radius: 999px; overflow: hidden;">
            <div id="aiProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-gradient" 
                 role="progressbar" style="width: 15%; background: linear-gradient(90deg, #38bdf8, #818cf8, #c084fc); transition: width 0.6s ease;"></div>
        </div>

        <!-- ROTATING STATUS MESSAGES -->
        <div class="p-3 rounded-4 border border-white border-opacity-10 mb-2.5" style="background: rgba(255, 255, 255, 0.05); min-height: 68px;">
            <div class="d-flex align-items-center justify-content-center gap-2 text-white-50 small mb-1">
                <span class="spinner-grow spinner-grow-sm text-info" role="status" aria-hidden="true"></span>
                <span id="aiStepBadge" class="fw-semibold text-info font-monospace text-uppercase" style="font-size: 0.72rem;">Tahap 1 dari 6</span>
            </div>
            <div id="aiStatusMessage" class="text-white fw-medium small" style="font-size: 0.75rem; transition: all 0.3s ease;">
                Mengakses Basis Data Capaian Pembelajaran BSKAP No. 046/H/KR/2025...
            </div>
        </div>

        <p class="text-white-50 mb-0" style="font-size: 0.72rem; line-height: 1.4;">
            <i class="bi bi-shield-check text-success me-1"></i>
            Dokumen disusun secara deterministik langsung dari database resmi tanpa pihak asing. Mohon tunggu...
        </p>
    </div>
</div>
@endsection

@push('styles')
<style>
@keyframes pulseGlow {
    0%, 100% { transform: scale(0.9); opacity: 0.5; }
    50% { transform: scale(1.15); opacity: 0.85; }
}
@keyframes spinClockwise {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes spinCounterClockwise {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}
.ai-orb-ring-outer {
    position: absolute;
    inset: -5px;
    border-radius: 50%;
    border: 2px dashed rgba(56, 189, 248, 0.55);
    animation: spinClockwise 12s linear infinite;
}
.ai-orb-ring-inner {
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    border: 2px solid transparent;
    border-top-color: #818cf8;
    border-bottom-color: #c084fc;
    animation: spinCounterClockwise 5s linear infinite;
}
.ai-orb-core {
    position: absolute;
    inset: 10px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0284c7 0%, #4f46e5 50%, #9333ea 100%);
    box-shadow: 0 0 25px rgba(56, 189, 248, 0.6), inset 0 0 12px rgba(255, 255, 255, 0.4);
    animation: pulseGlow 3s ease-in-out infinite;
}

/* STITCH MOBILE SPECIFIC STYLES */
.mobile-generator-shell {
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    padding-bottom: 70px;
}
.mobile-nav-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.15s ease;
}
.mobile-nav-btn:active {
    transform: scale(0.92);
}
.mobile-gen-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.15;
}
.mobile-gen-eyebrow {
    font-size: 0.65rem;
    font-weight: 700;
    color: #2563eb;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.mobile-showcase-card {
    position: relative;
    border-radius: 1.5rem;
    overflow: hidden;
    background: #111827;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 12px 30px -4px rgba(15, 23, 42, 0.25);
}
.mobile-showcase-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.35) 0%, transparent 60%);
    pointer-events: none;
}
.mobile-showcase-h2 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    letter-spacing: -0.02em;
    font-size: 1.35rem;
    line-height: 1.25;
}
.mobile-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 9999px;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}
.mobile-pillar-box {
    padding: 8px 4px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.12);
}
.mobile-pillar-num {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
    margin-bottom: 3px;
}

.btn-mobile-phase-pill {
    height: 42px;
    border-radius: 9999px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #111827;
    font-weight: 700;
    font-size: 0.78rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.btn-mobile-phase-pill.active {
    background: #111827 !important;
    color: #ffffff !important;
    border-color: #111827 !important;
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.2);
}
.btn-mobile-filter-pill {
    padding: 5px 13px;
    border-radius: 9999px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #4b5563;
    font-weight: 600;
    font-size: 0.73rem;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.btn-mobile-filter-pill.active {
    background: #1E3A8A;
    color: #ffffff;
    border-color: #1E3A8A;
}

.mobile-gen-floating-dock {
    position: fixed;
    bottom: 74px;
    left: 0;
    right: 0;
    z-index: 1040;
    padding: 0 14px;
    max-width: 480px;
    margin: 0 auto;
    pointer-events: none;
}
.mobile-gen-dock-inner {
    pointer-events: auto;
    background: #111827;
    color: #ffffff;
    padding: 7px 9px;
    border-radius: 9999px;
    box-shadow: 0 16px 36px rgba(17, 24, 39, 0.45);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    border: 1px solid rgba(255, 255, 255, 0.14);
}
.btn-stepper {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}
.btn-stepper:active {
    transform: scale(0.9);
    background: rgba(255, 255, 255, 0.2);
}
.btn-mobile-generate {
    flex: 1;
    height: 44px;
    border-radius: 9999px;
    background: #ffffff;
    color: #111827;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    font-weight: 800;
    font-size: 0.85rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
}
.btn-mobile-generate:active {
    transform: scale(0.97);
    background: #f1f5f9;
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endpush

@push('scripts')
<script>
    function checkAndFetchCp() {
        const mapelId = $('#mata_pelajaran_id').val();
        const faseId = $('#fase_id').val();
        const faseKode = $('.btn-mobile-phase-pill.active').data('fase-kode') || 'E';

        if (mapelId && faseId) {
            $('#mobileCpPreviewCard').hide();
            $('#mobileCpNotFoundCard').hide();

            $.get('{{ route("generator.ajax-cp") }}', {
                mapel_id: mapelId,
                fase_id: faseId
            }, function(res) {
                if (res.success) {
                    $('#capaian_pembelajaran_id').val(res.id);
                    $('#mobileCpFaseBadge').text('Fase ' + faseKode);
                    $('#mobileCpTitle').text(res.deskripsi_cp ? res.deskripsi_cp.substring(0, 110) + '...' : 'CP BSKAP Resmi Terpilih');
                    
                    let mobileElemenHtml = '';
                    if (res.elemen_cp) {
                        for (const [k, v] of Object.entries(res.elemen_cp)) {
                            mobileElemenHtml += `<span class="badge bg-white text-dark border py-1 px-2" style="font-size: 0.65rem;">${k}</span>`;
                        }
                    }
                    $('#mobileCpElemenList').html(mobileElemenHtml);
                    $('#mobileCpPreviewCard').fadeIn(200);
                } else {
                    $('#capaian_pembelajaran_id').val('');
                    $('#mobileCpNotFoundCard').fadeIn(200);
                }
            }).fail(function() {
                $('#capaian_pembelajaran_id').val('');
                $('#mobileCpNotFoundCard').fadeIn(200);
            });
        }
    }

    function selectMobilePhase(faseId, faseKode, el) {
        $('.btn-mobile-phase-pill').removeClass('active');
        $('.btn-mobile-phase-pill .active-check').hide();
        $(el).addClass('active');
        $(el).find('.active-check').show();

        $('#fase_id').val(faseId);
        checkAndFetchCp();
    }

    function syncMobileMapel(el) {
        const val = el.value;
        $('#mata_pelajaran_id').val(val);
        
        const selectedOpt = $(el).find('option:selected');
        const defaultFase = selectedOpt.data('fase-default');
        if (defaultFase) {
            $('.btn-mobile-phase-pill').each(function() {
                if ($(this).data('fase-kode') === defaultFase) {
                    $('.btn-mobile-phase-pill').removeClass('active').find('.active-check').hide();
                    $(this).addClass('active').find('.active-check').show();
                    $('#fase_id').val($(this).data('fase-id'));
                }
            });
        }
        checkAndFetchCp();
    }

    function filterMobileMapel(cat, el) {
        $('.btn-mobile-filter-pill').removeClass('active');
        $(el).addClass('active');

        $('#mata_pelajaran_id_mobile option').each(function() {
            if (!this.value) return;
            const nama = ($(this).data('nama') || '').toLowerCase();
            const kelompok = ($(this).data('kelompok') || '').toLowerCase();
            
            let show = true;
            if (cat === 'koding') {
                show = nama.includes('koding') || nama.includes('artifisial') || nama.includes('ai') || nama.includes('perangkat lunak') || nama.includes('jaringan') || nama.includes('komputer') || nama.includes('sistem');
            } else if (cat === 'pkk') {
                show = nama.includes('kreatif') || nama.includes('kewirausahaan') || nama.includes('pkk') || nama.includes('pkl') || nama.includes('lapangan');
            } else if (cat === 'dasar') {
                show = nama.startsWith('dasar-dasar');
            } else if (cat === 'umum') {
                show = kelompok === 'umum';
            }
            $(this).toggle(show);
        });
    }

    let currentJp = 3;
    function incrementMobileJp() {
        if (currentJp < 12) {
            currentJp++;
            $('#alokasi_jp').val(currentJp);
            $('#mobileJpDisplay').text(currentJp + ' JP');
        }
    }
    function decrementMobileJp() {
        if (currentJp > 1) {
            currentJp--;
            $('#alokasi_jp').val(currentJp);
            $('#mobileJpDisplay').text(currentJp + ' JP');
        }
    }

    function triggerMobileGenerate() {
        const mapelId = $('#mata_pelajaran_id').val();
        const faseId = $('#fase_id').val();
        const cpId = $('#capaian_pembelajaran_id').val();

        if (!mapelId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Mata Pelajaran',
                text: 'Silakan pilih Mata Pelajaran terlebih dahulu!',
                confirmButtonColor: '#1e3a8a'
            });
            $('#mata_pelajaran_id_mobile').focus();
            return;
        }
        if (!faseId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Fase',
                text: 'Silakan pilih Tingkat / Fase terlebih dahulu!',
                confirmButtonColor: '#1e3a8a'
            });
            return;
        }
        if (!cpId) {
            Swal.fire({
                icon: 'info',
                title: 'Memuat Capaian Pembelajaran',
                text: 'Capaian Pembelajaran (CP) sedang dimuat atau belum ditemukan untuk pilihan ini.',
                confirmButtonColor: '#1e3a8a'
            });
            return;
        }

        $('#formGeneratorMobile').submit();
    }

    const aiSteps = [
        { progress: 20, badge: 'Tahap 1 dari 6', text: 'Mengakses Basis Data Capaian Pembelajaran BSKAP No. 046/H/KR/2025 & Elemen Terpilih...' },
        { progress: 38, badge: 'Tahap 2 dari 6', text: 'Mesin Inferensi Merumuskan Tujuan Pembelajaran (TP) & Alur ATP Secara Deterministik...' },
        { progress: 56, badge: 'Tahap 3 dari 6', text: 'Menyusun Modul Ajar Sintaks PEDATTI (Penyampaian, Eksplorasi, Diskusi, Aplikasi, Tindak Lanjut)...' },
        { progress: 74, badge: 'Tahap 4 dari 6', text: 'Mengintegrasikan Prinsip Mindful-Meaningful-Joyful & 8 Dimensi Karakter Pancasila...' },
        { progress: 88, badge: 'Tahap 5 dari 6', text: 'Merancang Lembar Kerja Murid (LKPD) & Rubrik Asesmen KKTP 4 Level...' },
        { progress: 96, badge: 'Tahap 6 dari 6', text: 'Menghitung Alokasi Jam Prota/Promes Permendikdasmen 13/2025 & Mengompilasi Berkas Ekspor...' },
    ];

    $('#formGeneratorMobile').on('submit', function() {
        if ($('#mata_pelajaran_id').val() && $('#fase_id').val() && $('#capaian_pembelajaran_id').val()) {
            $('#btnTriggerMobileGenerate').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyusun...');
            $('#aiProcessingOverlay').removeClass('d-none').addClass('d-flex');

            let stepIdx = 0;
            const stepInterval = setInterval(function() {
                if (stepIdx < aiSteps.length) {
                    const step = aiSteps[stepIdx];
                    $('#aiProgressBar').css('width', step.progress + '%');
                    $('#aiStepBadge').text(step.badge);
                    $('#aiStatusMessage').fadeOut(150, function() {
                        $(this).text(step.text).fadeIn(150);
                    });
                    stepIdx++;
                } else {
                    clearInterval(stepInterval);
                }
            }, 1800);
        }
    });
</script>
@endpush
