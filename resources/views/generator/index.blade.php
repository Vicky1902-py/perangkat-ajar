@extends('layouts.app')

@section('title', 'Generator 1-Klik Perangkat Ajar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- HEADER TITLE (DESKTOP ONLY) -->
        <div class="d-none d-md-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <span class="p-2 rounded-3 bg-warning bg-opacity-25 text-warning d-inline-flex align-items-center justify-content-center">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </span>
                    Generator Perangkat Ajar Sekali Klik
                </h3>
                <p class="text-muted small mb-0">
                    Otomatis menghasilkan <strong>TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes, dan Asesmen</strong> sesuai <strong>Keputusan Kepala BSKAP Nomor 046/H/KR/2025</strong> & Permendikdasmen No. 13/2025.
                </p>
            </div>
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi {{ auth()->check() ? 'bi-arrow-left' : 'bi-box-arrow-in-right' }}"></i> {{ auth()->check() ? 'Kembali ke Dashboard' : 'Masuk / Login' }}
            </a>
        </div>

        <!-- GUEST QUOTA BANNER -->
        @if($isGuest)
            @if($guestLimitReached)
                <div class="alert alert-warning border-0 shadow-sm p-4 mb-4 rounded-3 text-dark" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 5px solid #d97706 !important;">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="rounded-circle bg-warning p-2 text-white shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-dark mb-1">Kuota Uji Coba Gratis Anda Telah Habis (2/2 Kali)</h5>
                            <p class="small text-dark text-opacity-80 mb-3">
                                Anda telah mencapai batas maksimal 2 kali pembuatan perangkat ajar tanpa login. 
                                Daftarkan akun guru Anda sekarang secara <strong>100% GRATIS</strong> untuk dapat membuat, menyimpan, serta mengekspor seluruh dokumen pembelajaran tanpa batasan!
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="bi bi-person-plus-fill me-1"></i> Daftar Akun Guru (Gratis)
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-4">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Sudah Punya Akun? Masuk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%); border-left: 5px solid #0284c7 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white p-2 shadow-sm text-primary">
                            <i class="bi bi-gift-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Mode Tamu Publik &bull; Kuota Tersisa: <span class="badge bg-primary fs-6">{{ $guestRemaining }} kali</span></h6>
                            <div class="small text-muted">
                                Anda dapat mencoba membuat paket perangkat ajar lengkap maksimal 2 kali tanpa perlu login.
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                            <i class="bi bi-person-plus-fill me-1"></i> Daftar Akun Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    </div>
                </div>
            @endif
        @endif

        <!-- DESKTOP VIEW: PARAMETER PENYUSUNAN DOKUMEN -->
        <div class="desktop-generator-shell">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="fw-bold text-primary">
                        <i class="bi bi-sliders2-vertical me-2"></i> Parameter Penyusunan Dokumen
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('generator.process') }}" method="POST" id="formGenerator" novalidate>
                        @csrf
                        <input type="hidden" name="alokasi_jp" id="alokasi_jp" value="3">

                        <div class="row g-3 mb-4">
                            <!-- PILIH MATA PELAJARAN -->
                            <div class="col-md-7">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold text-secondary small">
                                    1. Pilih Mata Pelajaran SMK <span class="text-danger">*</span>
                                </label>
                                <select class="form-select shadow-sm" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <option value="" selected disabled>-- Pilih Mata Pelajaran --</option>
                                    
                                    <optgroup label="✨ Prioritas Digital Nasional (Permendikdasmen No. 13/2025)">
                                        @foreach($mapels->where('nama', 'Koding dan Kecerdasan Artifisial (AI)') as $m)
                                            <option value="{{ $m->id }}" data-fase-default="E" data-fase-options="E,F">
                                                🤖 {{ $m->nama }} (Fase E & F - Semua Jurusan)
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="💼 Wajib Kejuruan Fase F (Seluruh Jurusan SMK)">
                                        @foreach($mapels->whereIn('nama', ['Projek Kreatif dan Kewirausahaan (PKK)', 'Praktik Kerja Lapangan (PKL)']) as $m)
                                            <option value="{{ $m->id }}" data-fase-default="F" data-fase-options="F">
                                                📌 {{ $m->nama }} (Fase F - Kelas XI/XII)
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="⚙️ Konsentrasi Keahlian (Fase F - Kelas XI & XII)">
                                        @foreach($mapels->where('kelompok', 'kejuruan')->filter(fn($m) => !str_starts_with($m->nama, 'Dasar-dasar') && !in_array($m->nama, ['Koding dan Kecerdasan Artifisial (AI)', 'Projek Kreatif dan Kewirausahaan (PKK)', 'Praktik Kerja Lapangan (PKL)'])) as $m)
                                            <option value="{{ $m->id }}" data-fase-default="F" data-fase-options="F">
                                                {{ $m->nama }} {{ $m->programKeahlian ? '['.$m->programKeahlian->kode.']' : '' }}
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="📐 Dasar-dasar Program Keahlian (Fase E - Kelas X)">
                                        @foreach($mapels->where('kelompok', 'kejuruan')->filter(fn($m) => str_starts_with($m->nama, 'Dasar-dasar')) as $m)
                                            <option value="{{ $m->id }}" data-fase-default="E" data-fase-options="E">
                                                {{ $m->nama }}
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="📚 Mata Pelajaran Kelompok Umum">
                                        @foreach($mapels->where('kelompok', 'umum') as $m)
                                            <option value="{{ $m->id }}" data-fase-default="E" data-fase-options="{{ in_array($m->nama, ['Informatika', 'Projek Ilmu Pengetahuan Alam dan Sosial (IPAS)', 'Seni Budaya']) ? 'E' : 'E,F' }}">
                                                {{ $m->nama }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <!-- PILIH FASE -->
                            <div class="col-md-2">
                                <label for="fase_id" class="form-label fw-semibold text-secondary small">
                                    2. Fase <span class="text-danger">*</span>
                                </label>
                                <select class="form-select shadow-sm" id="fase_id" name="fase_id" required>
                                    <option value="" selected disabled>-- Fase --</option>
                                    @foreach($fases as $f)
                                        <option value="{{ $f->id }}" data-kode="{{ $f->kode }}">Fase {{ $f->kode }} ({{ $f->kelas_range }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- TAHUN AJARAN -->
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label for="tahun_ajaran_id" class="form-label fw-semibold text-secondary small mb-0">
                                        3. Tahun Ajaran
                                    </label>
                                    <button type="button" class="btn btn-link p-0 text-decoration-none small text-primary fw-medium" id="btnToggleTaManual" style="font-size: 0.75rem;">
                                        <i class="bi bi-pencil-square me-1"></i><span id="btnToggleTaText">Ketik Manual</span>
                                    </button>
                                </div>

                                <!-- Pilihan Dropdown -->
                                <div id="taDropdownWrapper">
                                    <select class="form-select shadow-sm" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}" {{ $ta->is_active ? 'selected' : '' }}>
                                                {{ $ta->nama }} (Sem. {{ $ta->semester }}) {{ $ta->is_active ? '★ Aktif' : '' }}
                                            </option>
                                        @endforeach
                                        <option value="manual" class="fw-semibold text-primary">+ Ketik Manual Tahun Ajaran Baru...</option>
                                    </select>
                                </div>

                                <!-- Pilihan Manual Input -->
                                <div id="taManualWrapper" style="display: none;">
                                    <input type="hidden" name="tahun_ajaran_mode" id="tahun_ajaran_mode" value="dropdown">
                                    <div class="input-group input-group-sm shadow-sm mb-1">
                                        <input type="text" class="form-control" name="tahun_ajaran_manual" id="tahun_ajaran_manual" placeholder="Contoh: 2026/2027" maxlength="20">
                                        <select class="form-select" name="semester_manual" id="semester_manual" style="max-width: 110px;">
                                            <option value="1">Sem. 1 (Ganjil)</option>
                                            <option value="2">Sem. 2 (Genap)</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-info-circle"></i> Simpan otomatis ke DB</small>
                                        <button type="button" class="btn btn-link p-0 text-danger text-decoration-none" id="btnCancelTaManual" style="font-size: 0.72rem;">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- HIDDEN FIELD FOR CAPAIAN PEMBELAJARAN ID -->
                        <input type="hidden" name="capaian_pembelajaran_id" id="capaian_pembelajaran_id" value="">

                        <!-- PREVIEW CAPAIAN PEMBELAJARAN BOX -->
                        <div id="cpPreviewBox" class="p-4 rounded-3 border bg-light mb-4" style="display: none;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="fw-bold text-dark small">
                                    <i class="bi bi-file-earmark-text text-primary me-1"></i>
                                    Capaian Pembelajaran Resmi Terpilih (BSKAP No. 046/H/KR/2025):
                                </div>
                                <span class="badge bg-success" id="cpFaseBadge">Fase E</span>
                            </div>
                            <p class="text-secondary small mb-3" id="cpDeskripsiText" style="line-height: 1.5;"></p>

                            <div class="fw-semibold text-dark small mb-2">Elemen CP yang akan di-generate menjadi TP & Modul Ajar:</div>
                            <div id="cpElemenList" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        <div id="cpNotFoundBox" class="alert alert-warning py-3 px-4 mb-4 small" style="display: none;">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Capaian Pembelajaran (CP) untuk kombinasi mata pelajaran dan fase ini belum terdaftar di database. Silakan pilih kombinasi lain atau minta Superadmin menambahkannya pada menu <strong>CMS Capaian Pembelajaran</strong>.
                        </div>

                        <!-- SUBMIT BUTTON DESKTOP -->
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top flex-wrap gap-2">
                            <div class="text-muted small">
                                <i class="bi bi-shield-lock text-success me-1"></i>
                                Sistem secara otomatis menerapkan <strong>Prinsip Mindful-Meaningful-Joyful & Alur PEDATTI</strong>.
                            </div>
                            @if($guestLimitReached)
                                <a href="{{ route('register') }}" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-person-plus-fill me-1"></i> Kuota Tamu Habis &bull; Daftar Akun Gratis
                                </a>
                            @else
                                <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm" id="btnSubmitGenerate" disabled>
                                    <i class="bi bi-lightning-charge-fill me-1"></i> Generate Semua Perangkat Ajar (1-Klik)
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- HIGHLIGHT FITUR GENERATOR -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-check-all fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark">Paket Lengkap Terintegrasi</div>
                            <div class="text-muted" style="font-size: 0.78rem;">
                                Menghasilkan TP, ATP, Modul Ajar, LKPD, Prota, Promes, & Asesmen dalam satu alur utuh yang sinkron.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-file-earmark-arrow-down fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark">Ekspor Multi-Format</div>
                            <div class="text-muted" style="font-size: 0.78rem;">
                                Setiap dokumen dapat diunduh langsung dalam format resmi <strong>PDF, Excel, dan Microsoft Word (DOCX)</strong>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark">Dapat Diedit & Disesuaikan</div>
                            <div class="text-muted" style="font-size: 0.78rem;">
                                Hasil generate tersimpan di database dan dapat diubah secara bebas oleh guru sesuai kebutuhan kelas.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LUXURY AI GENERATION PROCESSING OVERLAY -->
<div id="aiProcessingOverlay" class="fixed-top vh-100 vw-100 d-none flex-column align-items-center justify-content-center" 
     style="background: radial-gradient(circle at center, rgba(15, 23, 42, 0.96) 0%, rgba(3, 7, 18, 0.98) 100%); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); z-index: 99999;">
    
    <!-- AMBIENT GLOW EFFECTS -->
    <div style="position: absolute; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, rgba(99, 102, 241, 0.15) 50%, transparent 70%); filter: blur(40px); animation: pulseGlow 4s ease-in-out infinite;"></div>

    <div class="text-center position-relative px-4" style="max-width: 620px;">
        <!-- AI CORE ORB ANIMATION -->
        <div class="ai-orb-container mx-auto mb-4 position-relative" style="width: 130px; height: 130px;">
            <div class="ai-orb-ring-outer"></div>
            <div class="ai-orb-ring-inner"></div>
            <div class="ai-orb-core d-flex align-items-center justify-content-center">
                <i class="bi bi-cpu text-white" style="font-size: 2.8rem; filter: drop-shadow(0 0 15px rgba(255,255,255,0.8));"></i>
            </div>
        </div>

        <!-- TITLE & SUBTITLE -->
        <h4 class="fw-bold text-white mb-2 tracking-wide" style="letter-spacing: -0.5px;">
            Menyusun Paket Perangkat Ajar Lengkap
        </h4>
        <div class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 px-3 py-1.5 rounded-pill mb-3 font-monospace small">
            <i class="bi bi-cpu-fill me-1 text-warning"></i> MESIN SISTEM PAKAR DEEP LEARNING SMK 2026 (NOL HALUSINASI)
        </div>

        <!-- PROGRESS BAR -->
        <div class="progress mb-3 shadow-lg" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 999px; overflow: hidden;">
            <div id="aiProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-gradient" 
                 role="progressbar" style="width: 15%; background: linear-gradient(90deg, #38bdf8, #818cf8, #c084fc); transition: width 0.6s ease;"></div>
        </div>

        <!-- ROTATING STATUS MESSAGES -->
        <div class="p-3 rounded-4 border border-white border-opacity-10 mb-3" style="background: rgba(255, 255, 255, 0.05); min-height: 72px;">
            <div class="d-flex align-items-center justify-content-center gap-2 text-white-50 small mb-1">
                <span class="spinner-grow spinner-grow-sm text-info" role="status" aria-hidden="true"></span>
                <span id="aiStepBadge" class="fw-semibold text-info font-monospace text-uppercase" style="font-size: 0.75rem;">Tahap 1 dari 6</span>
            </div>
            <div id="aiStatusMessage" class="text-white fw-medium small" style="transition: all 0.3s ease;">
                Mengakses Basis Data Capaian Pembelajaran BSKAP No. 046/H/KR/2025...
            </div>
        </div>

        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">
            <i class="bi bi-shield-check text-success me-1"></i>
            Mesin inferensi sistem pakar menyusun seluruh dokumen secara deterministik langsung dari database resmi tanpa API Key eksternal. Mohon jangan menutup halaman ini.
        </p>
    </div>
</div>

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
    inset: -6px;
    border-radius: 50%;
    border: 2px dashed rgba(56, 189, 248, 0.55);
    animation: spinClockwise 12s linear infinite;
}
.ai-orb-ring-inner {
    position: absolute;
    inset: 4px;
    border-radius: 50%;
    border: 2px solid transparent;
    border-top-color: #818cf8;
    border-bottom-color: #c084fc;
    animation: spinCounterClockwise 5s linear infinite;
}
.ai-orb-core {
    position: absolute;
    inset: 12px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0284c7 0%, #4f46e5 50%, #9333ea 100%);
    box-shadow: 0 0 30px rgba(56, 189, 248, 0.6), inset 0 0 15px rgba(255, 255, 255, 0.4);
    animation: pulseGlow 3s ease-in-out infinite;
}

/* ======================================================== */
/* STITCH MOBILE GENERATOR SPEC STYLES                      */
/* ======================================================== */
.mobile-generator-shell {
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
}
.mobile-showcase-card {
    position: relative;
    border-radius: 1.5rem;
    overflow: hidden;
    background: #111827;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 12px 30px -4px rgba(15, 23, 42, 0.25);
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
    bottom: 78px;
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
</style>
@endsection

@push('scripts')
<script>
    function checkAndFetchCp() {
        const mapelId = $('#mata_pelajaran_id').val();
        const faseId = $('#fase_id').val();
        const faseKode = $('#fase_id option:selected').data('kode') || 'E';

        if (mapelId && faseId) {
            $('#cpPreviewBox').hide();
            $('#cpNotFoundBox').hide();
            $('#mobileCpPreviewCard').hide();
            $('#mobileCpNotFoundCard').hide();
            $('#btnSubmitGenerate').prop('disabled', true);

            $.get('{{ route("generator.ajax-cp") }}', {
                mapel_id: mapelId,
                fase_id: faseId
            }, function(res) {
                if (res.success) {
                    $('#capaian_pembelajaran_id').val(res.id);
                    $('#cpFaseBadge').text('Fase ' + faseKode);
                    $('#cpDeskripsiText').text(res.deskripsi_cp);
                    
                    let elemenHtml = '';
                    let mobileElemenHtml = '';
                    if (res.elemen_cp) {
                        for (const [k, v] of Object.entries(res.elemen_cp)) {
                            elemenHtml += `<span class="badge bg-white text-dark border shadow-sm p-2"><i class="bi bi-check2 text-primary me-1"></i><strong>${k}</strong></span>`;
                            mobileElemenHtml += `<span class="badge bg-white text-dark border py-1 px-2" style="font-size: 0.65rem;">${k}</span>`;
                        }
                    }
                    $('#cpElemenList').html(elemenHtml);
                    $('#cpPreviewBox').fadeIn(200);

                    // Sync Mobile Preview
                    $('#mobileCpFaseBadge').text('Fase ' + faseKode);
                    $('#mobileCpTitle').text(res.deskripsi_cp ? res.deskripsi_cp.substring(0, 110) + '...' : 'CP BSKAP Resmi Terpilih');
                    $('#mobileCpElemenList').html(mobileElemenHtml);
                    $('#mobileCpPreviewCard').fadeIn(200);

                    if (!{{ $guestLimitReached ? 'true' : 'false' }}) {
                        $('#btnSubmitGenerate').prop('disabled', false);
                    }
                } else {
                    $('#capaian_pembelajaran_id').val('');
                    $('#cpNotFoundBox').fadeIn(200);
                    $('#mobileCpNotFoundCard').fadeIn(200);
                }
            }).fail(function() {
                $('#capaian_pembelajaran_id').val('');
                $('#cpNotFoundBox').fadeIn(200);
                $('#mobileCpNotFoundCard').fadeIn(200);
            });
        }
    }

    // MOBILE UI INTERACTION HANDLERS
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
        
        // Auto select default phase if mapped
        const selectedOpt = $(el).find('option:selected');
        const defaultFase = selectedOpt.data('fase-default');
        if (defaultFase) {
            $('#fase_id option').each(function() {
                if ($(this).data('kode') === defaultFase) {
                    $('#fase_id').val($(this).val());
                    // Sync mobile pill
                    $('.btn-mobile-phase-pill').removeClass('active').find('.active-check').hide();
                    const pill = $(`.btn-mobile-phase-pill[data-fase-kode="${defaultFase}"]`).first();
                    pill.addClass('active').find('.active-check').show();
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
            alert('Silakan pilih Mata Pelajaran terlebih dahulu!');
            $('#mata_pelajaran_id_mobile').focus();
            return;
        }
        if (!faseId) {
            alert('Silakan pilih Tingkat / Fase terlebih dahulu!');
            return;
        }
        if (!cpId) {
            alert('Capaian Pembelajaran (CP) sedang dimuat atau belum ditemukan untuk pilihan ini!');
            return;
        }

        $('#formGenerator').submit();
    }

    $('#mata_pelajaran_id').on('change', function() {
        const selectedVal = $(this).val();
        $('#mata_pelajaran_id_mobile').val(selectedVal);
        
        const selectedOpt = $(this).find('option:selected');
        const defaultFase = selectedOpt.data('fase-default');
        
        if (defaultFase) {
            $('#fase_id option').each(function() {
                if ($(this).data('kode') === defaultFase) {
                    $('#fase_id').val($(this).val());
                    // Sync mobile pill
                    $('.btn-mobile-phase-pill').removeClass('active').find('.active-check').hide();
                    const pill = $(`.btn-mobile-phase-pill[data-fase-kode="${defaultFase}"]`).first();
                    pill.addClass('active').find('.active-check').show();
                }
            });
        }
        checkAndFetchCp();
    });

    $('#fase_id').on('change', function() {
        const faseId = $(this).val();
        const faseKode = $(this).find('option:selected').data('kode');
        if (faseKode) {
            $('.btn-mobile-phase-pill').removeClass('active').find('.active-check').hide();
            const pill = $(`.btn-mobile-phase-pill[data-fase-kode="${faseKode}"]`).first();
            pill.addClass('active').find('.active-check').show();
        }
        checkAndFetchCp();
    });

    // Toggle Manual Tahun Ajaran
    function switchToTaManual() {
        $('#taDropdownWrapper').hide();
        $('#taManualWrapper').fadeIn(150);
        $('#tahun_ajaran_mode').val('manual');
        $('#tahun_ajaran_id').prop('disabled', true);
        $('#tahun_ajaran_manual').focus();
        $('#btnToggleTaText').text('Pilih Daftar');
        $('#btnToggleTaManual').find('i').removeClass('bi-pencil-square').addClass('bi-list-ul');
    }

    function switchToTaDropdown() {
        $('#taManualWrapper').hide();
        $('#taDropdownWrapper').fadeIn(150);
        $('#tahun_ajaran_mode').val('dropdown');
        $('#tahun_ajaran_id').prop('disabled', false);
        if ($('#tahun_ajaran_id').val() === 'manual') {
            $('#tahun_ajaran_id').val($('#tahun_ajaran_id option:first').val());
        }
        $('#btnToggleTaText').text('Ketik Manual');
        $('#btnToggleTaManual').find('i').removeClass('bi-list-ul').addClass('bi-pencil-square');
    }

    $('#btnToggleTaManual').on('click', function() {
        if ($('#tahun_ajaran_mode').val() === 'manual') {
            switchToTaDropdown();
        } else {
            switchToTaManual();
        }
    });

    $('#btnCancelTaManual').on('click', switchToTaDropdown);

    $('#tahun_ajaran_id').on('change', function() {
        if ($(this).val() === 'manual') {
            switchToTaManual();
        } else {
            $('#tahun_ajaran_id_mobile').val($(this).val());
        }
    });

    // LUXURY EXPERT SYSTEM PROCESSING OVERLAY ON FORM SUBMIT
    const aiSteps = [
        { progress: 20, badge: 'Tahap 1 dari 6', text: 'Mengakses Basis Data Capaian Pembelajaran BSKAP No. 046/H/KR/2025 & Elemen Terpilih...' },
        { progress: 38, badge: 'Tahap 2 dari 6', text: 'Mesin Inferensi Merumuskan Tujuan Pembelajaran (TP) & Alur ATP Secara Deterministik...' },
        { progress: 56, badge: 'Tahap 3 dari 6', text: 'Menyusun Modul Ajar Sintaks PEDATTI (Penyampaian, Eksplorasi, Diskusi, Aplikasi, Tindak Lanjut)...' },
        { progress: 74, badge: 'Tahap 4 dari 6', text: 'Mengintegrasikan Prinsip Mindful-Meaningful-Joyful & 8 Dimensi Karakter Pancasila...' },
        { progress: 88, badge: 'Tahap 5 dari 6', text: 'Merancang Lembar Kerja Murid (LKPD) & Rubrik Asesmen KKTP 4 Level...' },
        { progress: 96, badge: 'Tahap 6 dari 6', text: 'Menghitung Alokasi Jam Prota/Promes Permendikdasmen 13/2025 & Mengompilasi Berkas Ekspor...' },
    ];

    $('#formGenerator').on('submit', function() {
        if ($('#mata_pelajaran_id').val() && $('#fase_id').val() && $('#capaian_pembelajaran_id').val()) {
            $('#btnSubmitGenerate').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyusun Berkas...');
            
            // Tampilkan Overlay Futuristik
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

    $(document).ready(function() {
        // Initial sync of fase pill
        const curFaseId = $('#fase_id').val();
        if (curFaseId) {
            const curKode = $(`#fase_id option[value="${curFaseId}"]`).data('kode');
            if (curKode) {
                $('.btn-mobile-phase-pill').removeClass('active').find('.active-check').hide();
                $(`.btn-mobile-phase-pill[data-fase-kode="${curKode}"]`).first().addClass('active').find('.active-check').show();
            }
        }
    });
</script>
@endpush
