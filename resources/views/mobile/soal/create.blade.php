@extends('layouts.mobile')

@section('title', 'Buat Paket Soal Baru - Smart Soal SMK')

@section('header')
    <!-- 1. Mobile Top Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ route('paket-soal.index') }}" class="mobile-soal-nav-btn text-dark text-decoration-none" title="Kembali ke Bank Soal">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-soal-title mb-0">Buat Paket Soal</h1>
            <span class="mobile-soal-eyebrow">BSKAP 046/2025</span>
        </div>
        <button type="button" class="mobile-soal-nav-btn text-dark border-0 bg-white" onclick="showSmartSoalGuide(); return false;" title="Panduan Smart Soal">
            <span class="material-symbols-outlined text-primary" style="font-size: 20px;">help</span>
        </button>
    </header>
@endsection

@section('content')
<div class="mobile-soal-create-shell mb-4">

    <!-- ERROR ALERTS -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-3" role="alert">
            <div class="fw-bold mb-1" style="font-size: 0.8rem;"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan formulir:</div>
            <ul class="mb-0 small ps-3" style="font-size: 0.74rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.65rem;"></button>
        </div>
    @endif

    <!-- 2. Calm Hero Showcase Card -->
    <section class="mobile-soal-hero-card mb-3 position-relative overflow-hidden">
        <div class="mobile-soal-hero-ambient"></div>
        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-white bg-opacity-15 text-white border border-white border-opacity-25 rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.68rem;">
                    <span class="material-symbols-outlined align-middle me-0.5" style="font-size: 13px;">verified</span> Sistem Pakar Murni
                </span>
                <span class="badge bg-white bg-opacity-10 text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                    Nol Halusinasi
                </span>
            </div>
            <h2 class="text-white fw-bold mb-1" style="font-size: 1.15rem; line-height: 1.3;">
                Generator Kisi-Kisi &amp; Soal
            </h2>
            <p class="text-white text-opacity-75 small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                Penyusunan naskah asesmen otomatis dari kisi-kisi ke butir soal (PG &amp; Isian) tersinkronisasi kurikulum.
            </p>
        </div>
    </section>

    <!-- FORM GENERATOR SOAL MOBILE -->
    <form action="{{ route('paket-soal.store') }}" method="POST" id="formGeneratorSoalMobile" novalidate>
        @csrf
        <input type="hidden" name="fase_id" id="fase_id" value="{{ old('fase_id', $selectedModul?->fase_id ?? $fases->first()->id) }}">
        <input type="hidden" name="alokasi_waktu_menit" id="alokasi_waktu_menit" value="{{ old('alokasi_waktu_menit', 60) }}">
        <input type="hidden" name="bentuk_soal" id="bentuk_soal" value="{{ old('bentuk_soal', 'campuran') }}">
        <input type="hidden" name="total_soal_pg" id="total_soal_pg" value="{{ old('total_soal_pg', 10) }}">
        <input type="hidden" name="total_soal_isian" id="total_soal_isian" value="{{ old('total_soal_isian', 5) }}">

        <!-- 3. Form Step 1: Sumber Perangkat Ajar -->
        <section class="mobile-soal-form-card mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-slate-100">
                <span class="mobile-form-step-badge">Langkah 1</span>
                <span class="text-dark fw-bold small">Sumber Perangkat Ajar</span>
            </div>

            <!-- Modul Ajar Dropdown -->
            <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold mb-1">
                    Pilih Modul Ajar <span class="text-primary">(Rekomendasi)</span>
                </label>
                <select id="mobileModulAjarSelect" name="modul_ajar_id" class="form-select mobile-form-select shadow-none" onchange="applyMobileModul(this)">
                    <option value="">-- Pilih Modul Sebagai Rujukan --</option>
                    @foreach($modulAjars as $m)
                        <option value="{{ $m->id }}"
                                data-mapel-id="{{ $m->mata_pelajaran_id }}"
                                data-fase-id="{{ $m->fase_id }}"
                                data-tp-id="{{ $m->tujuan_pembelajaran_id }}"
                                data-judul="{{ $m->judul }}"
                                {{ (old('modul_ajar_id') == $m->id || ($selectedModul && $selectedModul->id == $m->id)) ? 'selected' : '' }}>
                            📖 {{ $m->judul }} ({{ $m->mataPelajaran->nama ?? 'Mapel' }} - Fase {{ $m->fase->kode ?? '-' }})
                        </option>
                    @endforeach
                </select>
                <div class="form-text small mt-1" style="font-size: 0.72rem; color: #64748b;">
                    Mata pelajaran, fase, dan topik esensial akan terisi secara otomatis.
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold mb-1">
                    Mata Pelajaran <span class="text-danger">*</span>
                </label>
                <select id="mobileMapelSelect" name="mata_pelajaran_id" class="form-select mobile-form-select shadow-none" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ (old('mata_pelajaran_id') == $mapel->id || ($selectedModul && $selectedModul->mata_pelajaran_id == $mapel->id)) ? 'selected' : '' }}>
                            {{ $mapel->nama }} ({{ $mapel->kelompok ?? 'Kejuruan' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fase / Kelas -->
            <div>
                <label class="form-label small text-secondary fw-semibold mb-1.5">
                    Fase / Kelas <span class="text-danger">*</span>
                </label>
                <div class="d-flex gap-2">
                    @foreach($fases as $f)
                        @php
                            $isSelectedFase = (old('fase_id', $selectedModul?->fase_id) == $f->id || (!$selectedModul && $loop->first));
                        @endphp
                        <button type="button" 
                                class="btn-mobile-soal-pill flex-fill {{ $isSelectedFase ? 'active' : '' }}" 
                                data-fase-id="{{ $f->id }}" 
                                onclick="selectMobileFaseSoal('{{ $f->id }}', this)">
                            Fase {{ $f->kode }} ({{ $f->kelas_range }})
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 4. Form Step 2: Konfigurasi Naskah Asesmen -->
        <section class="mobile-soal-form-card mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-slate-100">
                <span class="mobile-form-step-badge">Langkah 2</span>
                <span class="text-dark fw-bold small">Konfigurasi Naskah Ujian</span>
            </div>

            <!-- Judul Naskah -->
            <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold mb-1">Judul Naskah Asesmen</label>
                <input type="text" id="mobileJudulInput" name="judul" class="form-control mobile-form-input shadow-none" 
                       placeholder="Contoh: Asesmen Sumatif Lingkup Materi..." 
                       value="{{ old('judul', $selectedModul ? 'Asesmen Sumatif: ' . $selectedModul->judul : '') }}">
            </div>

            <!-- Jenis Asesmen -->
            <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold mb-1">
                    Jenis Asesmen <span class="text-danger">*</span>
                </label>
                <select id="mobileJenisUjianSelect" name="jenis_ujian" class="form-select mobile-form-select shadow-none" required>
                    <option value="sumatif_lingkup_materi" {{ old('jenis_ujian') === 'sumatif_lingkup_materi' ? 'selected' : '' }}>
                        Sumatif Lingkup Materi (Harian / Bab)
                    </option>
                    <option value="sts" {{ old('jenis_ujian') === 'sts' ? 'selected' : '' }}>
                        Sumatif Tengah Semester (STS)
                    </option>
                    <option value="sas" {{ old('jenis_ujian') === 'sas' ? 'selected' : '' }}>
                        Sumatif Akhir Semester (SAS)
                    </option>
                    <option value="diagnostik" {{ old('jenis_ujian') === 'diagnostik' ? 'selected' : '' }}>
                        Asesmen Diagnostik Awal Kognitif
                    </option>
                    <option value="kuis_harian" {{ old('jenis_ujian') === 'kuis_harian' ? 'selected' : '' }}>
                        Kuis Cepat Vokasi / Formatif
                    </option>
                </select>
            </div>

            <!-- Alokasi Waktu -->
            <div>
                <label class="form-label small text-secondary fw-semibold mb-1.5">
                    Alokasi Waktu Pengerjaan <span class="text-danger">*</span>
                </label>
                <div class="row g-1.5 text-center">
                    @foreach([45, 60, 90, 120] as $menit)
                        @php
                            $isActiveWaktu = old('alokasi_waktu_menit', 60) == $menit;
                        @endphp
                        <div class="col-3">
                            <button type="button" 
                                    class="btn-mobile-soal-pill btn-waktu-pill w-100 {{ $isActiveWaktu ? 'active' : '' }}" 
                                    data-waktu="{{ $menit }}" 
                                    onclick="selectMobileWaktuSoal({{ $menit }}, this)">
                                {{ $menit }}m
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 5. Form Step 3: Bentuk & Komposisi Butir Soal -->
        <section class="mobile-soal-form-card mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-slate-100">
                <span class="mobile-form-step-badge">Langkah 3</span>
                <span class="text-dark fw-bold small">Bentuk &amp; Komposisi Butir</span>
            </div>

            <!-- Bentuk Soal Segmented Selector -->
            <label class="form-label small text-secondary fw-semibold mb-1.5">Bentuk Soal</label>
            <div class="d-flex flex-column gap-2 mb-3">
                <button type="button" 
                        class="btn-mobile-bentuk-choice {{ old('bentuk_soal', 'campuran') === 'campuran' ? 'active' : '' }}" 
                        data-bentuk="campuran" 
                        onclick="selectMobileBentukSoal('campuran', this)">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold small">Campuran (PG + Isian)</span>
                        <span class="material-symbols-outlined active-icon" style="font-size: 16px;">check_circle</span>
                    </div>
                    <div class="small opacity-75 mt-0.5" style="font-size: 0.72rem;">Pilihan ganda dan studi kasus uraian sekaligus.</div>
                </button>

                <button type="button" 
                        class="btn-mobile-bentuk-choice {{ old('bentuk_soal') === 'pg' ? 'active' : '' }}" 
                        data-bentuk="pg" 
                        onclick="selectMobileBentukSoal('pg', this)">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold small">Pilihan Ganda Saja (PG)</span>
                        <span class="material-symbols-outlined active-icon" style="font-size: 16px;">check_circle</span>
                    </div>
                    <div class="small opacity-75 mt-0.5" style="font-size: 0.72rem;">Murni soal objektif bernomor opsi A, B, C, D, E.</div>
                </button>

                <button type="button" 
                        class="btn-mobile-bentuk-choice {{ old('bentuk_soal') === 'isian' ? 'active' : '' }}" 
                        data-bentuk="isian" 
                        onclick="selectMobileBentukSoal('isian', this)">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold small">Isian / Uraian Saja</span>
                        <span class="material-symbols-outlined active-icon" style="font-size: 16px;">check_circle</span>
                    </div>
                    <div class="small opacity-75 mt-0.5" style="font-size: 0.72rem;">Soal analisis kasus DUDI &amp; rubrik penskoran.</div>
                </button>
            </div>

            <!-- Jumlah Butir PG -->
            <div id="mobileWrapTotalPg" class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1.5">
                    <label class="small text-secondary fw-semibold">Jumlah Butir Pilihan Ganda (PG)</label>
                    <span class="badge bg-light text-dark border" id="mobilePgDisplayBadge">10 Butir</span>
                </div>
                <div class="d-flex gap-1.5 flex-wrap">
                    @foreach([5, 10, 15, 20, 25] as $cnt)
                        <button type="button" 
                                class="btn-mobile-count-pill btn-pg-count {{ old('total_soal_pg', 10) == $cnt ? 'active' : '' }}" 
                                data-count="{{ $cnt }}" 
                                onclick="selectMobileCountPg({{ $cnt }}, this)">
                            {{ $cnt }} Butir
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Jumlah Butir Isian -->
            <div id="mobileWrapTotalIsian" class="mb-1">
                <div class="d-flex justify-content-between align-items-center mb-1.5">
                    <label class="small text-secondary fw-semibold">Jumlah Butir Isian / Uraian</label>
                    <span class="badge bg-light text-dark border" id="mobileIsianDisplayBadge">5 Butir</span>
                </div>
                <div class="d-flex gap-1.5 flex-wrap">
                    @foreach([3, 5, 8, 10] as $cnt)
                        <button type="button" 
                                class="btn-mobile-count-pill btn-isian-count {{ old('total_soal_isian', 5) == $cnt ? 'active' : '' }}" 
                                data-count="{{ $cnt }}" 
                                onclick="selectMobileCountIsian({{ $cnt }}, this)">
                            {{ $cnt }} Butir
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 6. Collapsible Standar Kisi-Kisi & Jaminan Pakar -->
        <div class="accordion accordion-flush mb-4 rounded-4 overflow-hidden border bg-white shadow-xs" id="mobileSoalAccordion">
            <div class="accordion-item border-bottom">
                <h2 class="accordion-header" id="headingSoalOne">
                    <button class="accordion-button collapsed py-2.5 px-3 bg-white text-dark fw-bold small shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSoalOne">
                        <span class="material-symbols-outlined text-primary me-2" style="font-size: 18px;">verified_user</span>
                        Sistem Pakar Murni (Nol Halusinasi)
                    </button>
                </h2>
                <div id="collapseSoalOne" class="accordion-collapse collapse" data-bs-parent="#mobileSoalAccordion">
                    <div class="accordion-body p-3 pt-1 text-secondary small" style="font-size: 0.75rem; line-height: 1.5;">
                        <ul class="mb-0 ps-3">
                            <li class="mb-1"><strong>Tanpa Halusinasi AI:</strong> Menggunakan mesin inferensi lokal deterministik.</li>
                            <li class="mb-1"><strong>Distraktor Homogen:</strong> 4 opsi pengecoh edukatif dan berbobot sama.</li>
                            <li class="mb-1"><strong>Kunci &amp; Pembahasan:</strong> Rujukan ilmiah lengkap untuk pegangan guru.</li>
                            <li><strong>Rubrik Analitik:</strong> Pedoman penskoran terstandar untuk soal uraian.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSoalTwo">
                    <button class="accordion-button collapsed py-2.5 px-3 bg-white text-dark fw-bold small shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSoalTwo">
                        <span class="material-symbols-outlined text-secondary me-2" style="font-size: 18px;">table_chart</span>
                        Tabel Kisi-Kisi 8 Kolom Kemendikdasmen
                    </button>
                </h2>
                <div id="collapseSoalTwo" class="accordion-collapse collapse" data-bs-parent="#mobileSoalAccordion">
                    <div class="accordion-body p-3 pt-1 text-secondary small" style="font-size: 0.75rem;">
                        Tabel memuat 8 parameter resmi: No, Elemen Capaian, Tujuan Ajar (TP), Topik Materi, Indikator Soal, Level Bloom (C1-C6), Bentuk Soal, dan Nomor Soal.
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. Fixed Floating Bottom Action Dock (Stitch Style) -->
        <div class="mobile-soal-floating-dock">
            <div class="mobile-soal-dock-inner">
                <div class="mobile-soal-dock-summary">
                    <div class="text-white fw-bold small" id="mobileDockSummaryText">10 PG + 5 Isian</div>
                    <div class="text-secondary" style="font-size: 9px;" id="mobileDockTimeText">60 Menit &bull; BSKAP 046</div>
                </div>

                <button type="button" class="btn-mobile-soal-generate" id="btnMobileSubmitSoal" onclick="triggerMobileSubmitSoal()">
                    <span class="d-flex align-items-center gap-1 text-dark">
                        <span class="material-symbols-outlined text-primary fill-icon" style="font-size: 17px;">bolt</span>
                        <span>Generate Soal</span>
                    </span>
                    <span class="fw-bold text-primary font-monospace" style="font-size: 14px;">
                        &gt;&gt;&gt;
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- POPUP SELAMAT DATANG DI SMART SOAL BY. VICKY -->
@include('soal.partials.welcome-modal')
@endsection

@push('styles')
<style>
.mobile-soal-create-shell {
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    padding-bottom: 70px;
}
.mobile-soal-nav-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.mobile-soal-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.2;
}
.mobile-soal-eyebrow {
    font-size: 10px;
    font-weight: 800;
    color: #0284c7;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.mobile-soal-hero-card {
    background-color: #0f172a;
    color: #ffffff;
    border-radius: 1.25rem;
    padding: 16px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
}
.mobile-soal-hero-ambient {
    position: absolute;
    top: -30%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, rgba(15, 23, 42, 0) 70%);
    pointer-events: none;
}
.mobile-soal-form-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}
.mobile-form-step-badge {
    font-size: 10px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 9999px;
    background-color: #eff6ff;
    color: #1e3a8a;
    text-transform: uppercase;
}
.mobile-form-select, .mobile-form-input {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    font-size: 13px;
    color: #0f172a;
}
.btn-mobile-soal-pill {
    padding: 8px 12px;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.15s ease;
}
.btn-mobile-soal-pill.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.btn-mobile-bentuk-choice {
    width: 100%;
    text-align: left;
    padding: 12px 14px;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #0f172a;
    transition: all 0.15s ease;
}
.btn-mobile-bentuk-choice .active-icon {
    display: none;
    color: #1e3a8a;
}
.btn-mobile-bentuk-choice.active {
    background: #eff6ff;
    border-color: #93c5fd;
    color: #1e3a8a;
}
.btn-mobile-bentuk-choice.active .active-icon {
    display: inline-block;
}
.btn-mobile-count-pill {
    padding: 5px 12px;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
    transition: all 0.15s ease;
}
.btn-mobile-count-pill.active {
    background: #1e3a8a;
    color: #ffffff;
    border-color: #1e3a8a;
}
.mobile-soal-floating-dock {
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
.mobile-soal-dock-inner {
    pointer-events: auto;
    background: #0f172a;
    color: #ffffff;
    padding: 7px 9px 7px 16px;
    border-radius: 9999px;
    box-shadow: 0 16px 36px rgba(15, 23, 42, 0.45);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    border: 1px solid rgba(255, 255, 255, 0.14);
}
.btn-mobile-soal-generate {
    height: 44px;
    border-radius: 9999px;
    background: #ffffff;
    color: #0f172a;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    font-weight: 800;
    font-size: 0.85rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
    gap: 12px;
}
.btn-mobile-soal-generate:active {
    transform: scale(0.97);
    background: #f1f5f9;
}
</style>
@endpush

@push('scripts')
<script>
    function applyMobileModul(select) {
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const mapelId = selected.getAttribute('data-mapel-id');
            const faseId = selected.getAttribute('data-fase-id');
            const judul = selected.getAttribute('data-judul');

            if (mapelId) {
                const mobMapel = document.getElementById('mobileMapelSelect');
                if (mobMapel) mobMapel.value = mapelId;
            }
            if (faseId) {
                $('#fase_id').val(faseId);
                document.querySelectorAll('.btn-mobile-soal-pill[data-fase-id]').forEach(b => {
                    b.classList.toggle('active', b.getAttribute('data-fase-id') === faseId);
                });
            }
            if (judul) {
                const mobJudul = document.getElementById('mobileJudulInput');
                if (mobJudul && !mobJudul.value) {
                    mobJudul.value = 'Asesmen Sumatif: ' + judul;
                }
            }
        }
    }

    function selectMobileFaseSoal(faseId, btn) {
        $('#fase_id').val(faseId);
        document.querySelectorAll('.btn-mobile-soal-pill[data-fase-id]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function selectMobileWaktuSoal(menit, btn) {
        $('#alokasi_waktu_menit').val(menit);
        document.querySelectorAll('.btn-waktu-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        updateMobileDockSummary();
    }

    function selectMobileBentukSoal(bentuk, btn) {
        $('#bentuk_soal').val(bentuk);
        document.querySelectorAll('.btn-mobile-bentuk-choice').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (bentuk === 'campuran') {
            $('#mobileWrapTotalPg').slideDown(150);
            $('#mobileWrapTotalIsian').slideDown(150);
        } else if (bentuk === 'pg') {
            $('#mobileWrapTotalPg').slideDown(150);
            $('#mobileWrapTotalIsian').slideUp(150);
        } else if (bentuk === 'isian') {
            $('#mobileWrapTotalPg').slideUp(150);
            $('#mobileWrapTotalIsian').slideDown(150);
        }
        updateMobileDockSummary();
    }

    function selectMobileCountPg(cnt, btn) {
        $('#total_soal_pg').val(cnt);
        document.querySelectorAll('.btn-pg-count').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        $('#mobilePgDisplayBadge').text(cnt + ' Butir');
        updateMobileDockSummary();
    }

    function selectMobileCountIsian(cnt, btn) {
        $('#total_soal_isian').val(cnt);
        document.querySelectorAll('.btn-isian-count').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        $('#mobileIsianDisplayBadge').text(cnt + ' Butir');
        updateMobileDockSummary();
    }

    function updateMobileDockSummary() {
        const bentuk = $('#bentuk_soal').val();
        const pg = $('#total_soal_pg').val();
        const isian = $('#total_soal_isian').val();
        const waktu = $('#alokasi_waktu_menit').val();

        let text = '';
        if (bentuk === 'campuran') {
            text = `${pg} PG + ${isian} Isian`;
        } else if (bentuk === 'pg') {
            text = `${pg} Pilihan Ganda`;
        } else {
            text = `${isian} Isian / Uraian`;
        }

        $('#mobileDockSummaryText').text(text);
        $('#mobileDockTimeText').text(`${waktu} Menit • BSKAP 046`);
    }

    function triggerMobileSubmitSoal() {
        const mapelVal = $('#mobileMapelSelect').val();
        const faseVal = $('#fase_id').val();

        if (!mapelVal) {
            Swal.fire({
                icon: 'warning',
                title: 'Mata Pelajaran Kosong',
                text: 'Silakan pilih Mata Pelajaran terlebih dahulu.',
                confirmButtonColor: '#0284c7'
            });
            $('#mobileMapelSelect').focus();
            return;
        }

        if (!faseVal) {
            Swal.fire({
                icon: 'warning',
                title: 'Fase Belum Dipilih',
                text: 'Silakan tentukan Tingkat / Fase terlebih dahulu.',
                confirmButtonColor: '#0284c7'
            });
            return;
        }

        const btn = document.getElementById('btnMobileSubmitSoal');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status"></span><span>Menyusun...</span>';
        }

        $('#formGeneratorSoalMobile').submit();
    }

    $(document).ready(function() {
        updateMobileDockSummary();
    });
</script>
@endpush
