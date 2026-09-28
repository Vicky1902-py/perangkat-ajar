@extends('layouts.app')

@section('title', 'Buat Paket Soal Baru - Smart Soal by. Vicky')

@section('content')
<div class="container-fluid px-2 px-md-4 py-2 py-md-3">

    <!-- ============================================================ -->
    <!-- NOTIFIKASI ERROR (TAMPIL DI MOBILE & DESKTOP)                -->
    <!-- ============================================================ -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-3" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan pengisian formulir:</div>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ============================================================ -->
    <!-- MOBILE VIEW: ANDROID NATIVE SMART SOAL GENERATOR (STITCH)    -->
    <!-- ============================================================ -->
    <div class="d-block d-md-none mobile-soal-create-shell mb-4">
        <!-- 1. Mobile Top Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-3 pt-1">
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
        </div>

        <!-- 2. Calm Hero Showcase Card (Navy/Slate #0f172a, NO rainbow colors) -->
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
                <select id="mobileModulAjarSelect" class="form-select mobile-form-select shadow-none" onchange="syncMobileModulToDesktop(this)">
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
                <select id="mobileMapelSelect" class="form-select mobile-form-select shadow-none" onchange="syncMobileMapelToDesktop(this)" required>
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
                <input type="text" id="mobileJudulInput" class="form-control mobile-form-input shadow-none" 
                       placeholder="Contoh: Asesmen Sumatif Lingkup Materi..." 
                       value="{{ old('judul', $selectedModul ? 'Asesmen Sumatif: ' . $selectedModul->judul : '') }}"
                       oninput="syncMobileJudulToDesktop(this.value)">
            </div>

            <!-- Jenis Asesmen -->
            <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold mb-1">
                    Jenis Asesmen <span class="text-danger">*</span>
                </label>
                <select id="mobileJenisUjianSelect" class="form-select mobile-form-select shadow-none" onchange="syncMobileJenisUjian(this.value)" required>
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
                                    class="btn-mobile-soal-pill w-100 {{ $isActiveWaktu ? 'active' : '' }}" 
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
                <!-- Campuran -->
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

                <!-- PG Saja -->
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

                <!-- Isian Saja -->
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
                                class="btn-mobile-count-pill {{ old('total_soal_pg', 10) == $cnt ? 'active' : '' }}" 
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
                                class="btn-mobile-count-pill {{ old('total_soal_isian', 5) == $cnt ? 'active' : '' }}" 
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
                <!-- Summary Text -->
                <div class="mobile-soal-dock-summary">
                    <div class="text-white fw-bold small" id="mobileDockSummaryText">10 PG + 5 Isian</div>
                    <div class="text-secondary" style="font-size: 9px;" id="mobileDockTimeText">60 Menit &bull; BSKAP 046</div>
                </div>

                <!-- Large CTA Button -->
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
    </div>

    <!-- ============================================================ -->
    <!-- DESKTOP VIEW: TAMPILAN LENGKAP PC & LAPTOP (TIDAK BERUBAH)   -->
    <!-- ============================================================ -->
    <div class="d-none d-md-block desktop-soal-shell">

        <!-- BREADCRUMB & BACK BUTTON -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <a href="{{ route('paket-soal.index') }}" class="text-secondary small text-decoration-none d-inline-flex align-items-center gap-1 mb-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Bank Soal
                </a>
                <h4 class="fw-bold text-dark mb-0" style="color: #0b3b60 !important;">
                    Generator Kisi-Kisi & Paket Soal (Sistem Pakar)
                </h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-soft-warning rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.74rem;">
                    <i class="bi bi-stars me-1"></i> Smart Soal by. Vicky Koroh
                </span>
            </div>
        </div>

        <div class="row g-4">
            <!-- FORM UTAMA -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3.5 px-4 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-ui-checks-grid text-primary"></i>
                            Konfigurasi Sumber Perangkat Ajar & Spesifikasi Soal
                        </h5>
                        <div class="text-muted small mt-1">
                            Pilih Modul Ajar yang sudah ada di database agar materi, indikator, dan stimulus soal tersinkronisasi 100% secara relevan.
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('paket-soal.store') }}" method="POST" id="formGeneratorSoal">
                            @csrf

                            <!-- LANGKAH 1: SUMBER PERANGKAT AJAR -->
                            <div class="mb-4 pb-3 border-bottom">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                    <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">1</span>
                                    Sumber Perangkat Ajar (Sinkronisasi Otomatis)
                                </label>

                                <!-- PILIH DARI MODUL AJAR (DEFAULT / REKOMENDASI) -->
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-semibold">Pilih dari Modul Ajar yang Sudah Ada <span class="text-primary">(Direkomendasikan)</span></label>
                                    <select name="modul_ajar_id" id="modulAjarSelect" class="form-select rounded-3">
                                        <option value="">-- Pilih Modul Ajar Sebagai Rujukan --</option>
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
                                    <div class="form-text small" style="font-size: 0.75rem;">
                                        Saat Modul Ajar dipilih, mata pelajaran, fase, dan topik esensial akan terisi secara otomatis.
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- MATA PELAJARAN -->
                                    <div class="col-md-7">
                                        <label class="form-label small text-muted fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                        <select name="mata_pelajaran_id" id="mapelSelect" class="form-select rounded-3" required>
                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                            @foreach($mapels as $mapel)
                                                <option value="{{ $mapel->id }}" {{ (old('mata_pelajaran_id') == $mapel->id || ($selectedModul && $selectedModul->mata_pelajaran_id == $mapel->id)) ? 'selected' : '' }}>
                                                    {{ $mapel->nama }} ({{ $mapel->kelompok ?? 'Kejuruan' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- FASE -->
                                    <div class="col-md-5">
                                        <label class="form-label small text-muted fw-semibold">Fase / Kelas <span class="text-danger">*</span></label>
                                        <select name="fase_id" id="faseSelect" class="form-select rounded-3" required>
                                            <option value="">-- Pilih Fase --</option>
                                            @foreach($fases as $f)
                                                <option value="{{ $f->id }}" {{ (old('fase_id') == $f->id || ($selectedModul && $selectedModul->fase_id == $f->id)) ? 'selected' : '' }}>
                                                    Fase {{ $f->kode }} (Kelas {{ $f->kelas_range }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- LANGKAH 2: SPESIFIKASI NASKAH ASESMEN -->
                            <div class="mb-4 pb-3 border-bottom">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                    <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">2</span>
                                    Konfigurasi Naskah Asesmen & Ujian
                                </label>

                                <!-- JUDUL NASKAH -->
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-semibold">Judul Naskah Asesmen / Ujian</label>
                                    <input type="text" name="judul" id="judulInput" class="form-control rounded-3" 
                                           placeholder="Contoh: Asesmen Sumatif Lingkup Materi: Perawatan Mesin Otomotif" 
                                           value="{{ old('judul', $selectedModul ? 'Asesmen Sumatif: ' . $selectedModul->judul : '') }}">
                                </div>

                                <div class="row g-3">
                                    <!-- JENIS UJIAN -->
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-semibold">Jenis Asesmen <span class="text-danger">*</span></label>
                                        <select name="jenis_ujian" id="jenisUjianSelect" class="form-select rounded-3" required>
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

                                    <!-- ALOKASI WAKTU -->
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-semibold">Alokasi Waktu Pengerjaan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="alokasi_waktu_menit" id="alokasiWaktuSelect" class="form-select rounded-start-3" required>
                                                <option value="45" {{ old('alokasi_waktu_menit') == 45 ? 'selected' : '' }}>45 Menit (1 Jam Pelajaran)</option>
                                                <option value="60" {{ old('alokasi_waktu_menit', 60) == 60 ? 'selected' : '' }}>60 Menit (Standar Formatif/Sumatif)</option>
                                                <option value="90" {{ old('alokasi_waktu_menit') == 90 ? 'selected' : '' }}>90 Menit (2 Jam Pelajaran)</option>
                                                <option value="120" {{ old('alokasi_waktu_menit') == 120 ? 'selected' : '' }}>120 Menit (STS / SAS Ujian Penuh)</option>
                                            </select>
                                            <span class="input-group-text bg-light text-muted">Menit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- LANGKAH 3: BENTUK SOAL & KOMPOSISI -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                    <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">3</span>
                                    Bentuk Soal & Komposisi Butir
                                </label>

                                <!-- PILIHAN BENTUK SOAL (RADIO CARDS) -->
                                <div class="row g-2 mb-3">
                                    <!-- OPSI 1: CAMPURAN (PG + ISIAN) -->
                                    <div class="col-md-4">
                                        <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukCampuran" value="campuran" 
                                                       {{ old('bentuk_soal', 'campuran') === 'campuran' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                                <span class="form-check-label fw-bold text-dark small d-block">
                                                    Campuran (PG + Isian)
                                                </span>
                                                <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                    Pilihan Ganda & Isian studi kasus sekaligus.
                                                </span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- OPSI 2: PILIHAN GANDA SAJA -->
                                    <div class="col-md-4">
                                        <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukPg" value="pg" 
                                                       {{ old('bentuk_soal') === 'pg' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                                <span class="form-check-label fw-bold text-dark small d-block">
                                                    Pilihan Ganda Saja
                                                </span>
                                                <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                    Murni soal objektif opsi A, B, C, D, E.
                                                </span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- OPSI 3: ISIAN / URAIAN SAJA -->
                                    <div class="col-md-4">
                                        <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukIsian" value="isian" 
                                                       {{ old('bentuk_soal') === 'isian' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                                <span class="form-check-label fw-bold text-dark small d-block">
                                                    Isian / Uraian Saja
                                                </span>
                                                <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                    Murni soal analisis kasus & rubrik penskoran.
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- INPUT JUMLAH BUTIR SOAL -->
                                <div class="row g-3">
                                    <!-- JUMLAH BUTIR PG -->
                                    <div class="col-md-6" id="wrapTotalPg">
                                        <label class="form-label small text-muted fw-semibold">Jumlah Butir Pilihan Ganda (PG)</label>
                                        <select name="total_soal_pg" id="selectTotalPg" class="form-select rounded-3" onchange="syncTotalPg(this.value)">
                                            <option value="5" {{ old('total_soal_pg') == 5 ? 'selected' : '' }}>5 Butir Soal PG</option>
                                            <option value="10" {{ old('total_soal_pg', 10) == 10 ? 'selected' : '' }}>10 Butir Soal PG (Standar)</option>
                                            <option value="15" {{ old('total_soal_pg') == 15 ? 'selected' : '' }}>15 Butir Soal PG</option>
                                            <option value="20" {{ old('total_soal_pg') == 20 ? 'selected' : '' }}>20 Butir Soal PG (Lengkap)</option>
                                            <option value="25" {{ old('total_soal_pg') == 25 ? 'selected' : '' }}>25 Butir Soal PG</option>
                                        </select>
                                    </div>

                                    <!-- JUMLAH BUTIR ISIAN -->
                                    <div class="col-md-6" id="wrapTotalIsian">
                                        <label class="form-label small text-muted fw-semibold">Jumlah Butir Isian / Uraian</label>
                                        <select name="total_soal_isian" id="selectTotalIsian" class="form-select rounded-3" onchange="syncTotalIsian(this.value)">
                                            <option value="3" {{ old('total_soal_isian') == 3 ? 'selected' : '' }}>3 Butir Soal Isian</option>
                                            <option value="5" {{ old('total_soal_isian', 5) == 5 ? 'selected' : '' }}>5 Butir Soal Isian (Standar)</option>
                                            <option value="8" {{ old('total_soal_isian') == 8 ? 'selected' : '' }}>8 Butir Soal Isian</option>
                                            <option value="10" {{ old('total_soal_isian') == 10 ? 'selected' : '' }}>10 Butir Soal Isian</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- TOMBOL SUBMIT -->
                            <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <a href="{{ route('paket-soal.index') }}" class="btn btn-light rounded-pill px-4 text-muted">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4.5 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" id="btnSubmitSoal" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                                    <i class="bi bi-magic"></i>
                                    <span>Generate Kisi-Kisi & Soal (Sistem Pakar)</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR PANDUAN & INFORMASI SISTEM PAKAR -->
            <div class="col-lg-4">
                <!-- KARTU JAMINAN SISTEM PAKAR -->
                <div class="card border-0 shadow-sm rounded-4 mb-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%); border: 1.5px solid #bae6fd !important;">
                    <div class="card-body p-3.5">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="rounded-circle p-1.5 bg-primary bg-opacity-15 text-primary">
                                <i class="bi bi-shield-check fs-5"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">Sistem Pakar Terstruktur</h6>
                        </div>
                        <p class="small text-muted mb-2" style="font-size: 0.8rem; line-height: 1.5;">
                            Seluruh naskah soal dan tabel kisi-kisi disusun menggunakan algoritma sistem pakar murni berbasis Taksonomi Bloom dan elemen BSKAP 046/2025.
                        </p>
                        <ul class="list-unstyled small mb-0 text-dark" style="font-size: 0.78rem;">
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Nol Halusinasi AI:</strong> Tidak memakai token eksternal.</li>
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Distraktor Homogen:</strong> 4 pengecoh logis & edukatif.</li>
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Kunci & Pembahasan:</strong> Alasan rasional untuk guru.</li>
                            <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Rubrik Penskoran:</strong> Pedoman penilaian analitik essay.</li>
                        </ul>
                    </div>
                </div>

                <!-- KARTU ALUR KISI-KISI RESMI -->
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-3.5">
                        <h6 class="fw-bold text-dark mb-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-diagram-3-fill text-primary"></i>
                            Format Kisi-Kisi Kemendikdasmen
                        </h6>
                        <div class="small text-muted mb-3" style="font-size: 0.78rem;">
                            Tabel spesifikasi memuat 8 parameter resmi yang langsung siap dicetak sebagai lampiran asesmen:
                        </div>
                        <div class="d-flex flex-wrap gap-1.5" style="font-size: 0.72rem;">
                            <span class="badge badge-soft-primary">1. No. Urut</span>
                            <span class="badge badge-soft-primary">2. Elemen Capaian</span>
                            <span class="badge badge-soft-primary">3. Tujuan Ajar (TP)</span>
                            <span class="badge badge-soft-primary">4. Materi / Topik</span>
                            <span class="badge badge-soft-primary">5. Indikator Soal</span>
                            <span class="badge badge-soft-primary">6. Level Bloom (C1-C6)</span>
                            <span class="badge badge-soft-primary">7. Bentuk Soal</span>
                            <span class="badge badge-soft-primary">8. No. Soal</span>
                        </div>
                    </div>
                </div>

                <!-- INFO CETAK GURU VS SISWA -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3.5">
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-printer-fill text-secondary"></i>
                            Pemisahan Naskah Ujian
                        </h6>
                        <p class="small text-muted mb-0" style="font-size: 0.78rem; line-height: 1.5;">
                            Setelah di-generate, sistem otomatis memisahkan lembar ujian siswa (bersih tanpa kunci) dan dokumen arsip kurikulum pegangan guru (lengkap dengan kisi-kisi, kunci, dan rubrik).
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- /d-none d-md-block (DESKTOP) -->

</div>

<style>
/* ============================================================ */
/* SMART SOAL MOBILE STITCH SPECIFICATION                      */
/* Calm, Professional, Clean (No Rainbow Colors)               */
/* ============================================================ */
.mobile-soal-create-shell {
    max-width: 480px;
    margin: 0 auto;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    padding-bottom: 125px; /* Safe padding for floating action dock + bottom nav */
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
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.15rem;
    padding: 14px 15px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
.mobile-form-step-badge {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #0284c7;
    background: #eff6ff;
    padding: 2px 8px;
    border-radius: 9999px;
}
.mobile-form-select,
.mobile-form-input {
    border-radius: 0.75rem;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    padding: 8px 12px;
    color: #0f172a;
    background-color: #ffffff;
}
.mobile-form-select:focus,
.mobile-form-input:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
}
.btn-mobile-soal-pill {
    padding: 7px 10px;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
    transition: all 0.15s ease;
    text-align: center;
}
.btn-mobile-soal-pill.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.18);
}
.btn-mobile-bentuk-choice {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 0.85rem;
    padding: 10px 12px;
    text-align: left;
    color: #0f172a;
    transition: all 0.15s ease;
    width: 100%;
}
.btn-mobile-bentuk-choice .active-icon {
    display: none;
    color: #0284c7;
}
.btn-mobile-bentuk-choice.active {
    border-color: #0284c7;
    background: #f0f9ff;
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
    background: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
}
/* Floating Bottom Action Dock for Generator */
.mobile-soal-floating-dock {
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
.mobile-soal-dock-inner {
    pointer-events: auto;
    background: #0f172a;
    color: #ffffff;
    padding: 7px 9px 7px 14px;
    border-radius: 9999px;
    box-shadow: 0 16px 36px rgba(15, 23, 42, 0.45);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    border: 1px solid rgba(255, 255, 255, 0.14);
}
.mobile-soal-dock-summary {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}
.mobile-soal-dock-summary .small {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.btn-mobile-soal-generate {
    flex: 1;
    max-width: 175px;
    height: 42px;
    border-radius: 9999px;
    background: #ffffff;
    color: #0f172a;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 14px;
    font-weight: 800;
    font-size: 0.82rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn-mobile-soal-generate:active {
    transform: scale(0.97);
    background: #f1f5f9;
}
</style>

<!-- POPUP PANDUAN SMART SOAL -->
@include('soal.partials.welcome-modal')

<!-- ============================================================ -->
<!-- JAVASCRIPT: SYNC MOBILE & DESKTOP STATE + FORM LOGIC         -->
<!-- ============================================================ -->
<script>
    // State management
    let activeBentuk = '{{ old('bentuk_soal', 'campuran') }}';
    let activeWaktu = {{ old('alokasi_waktu_menit', 60) }};
    let activePg = {{ old('total_soal_pg', 10) }};
    let activeIsian = {{ old('total_soal_isian', 5) }};

    function updateDockSummary() {
        const summaryText = document.getElementById('mobileDockSummaryText');
        const timeText = document.getElementById('mobileDockTimeText');

        if (activeBentuk === 'pg') {
            if (summaryText) summaryText.textContent = `${activePg} Soal PG`;
        } else if (activeBentuk === 'isian') {
            if (summaryText) summaryText.textContent = `${activeIsian} Soal Isian`;
        } else {
            if (summaryText) summaryText.textContent = `${activePg} PG + ${activeIsian} Isian`;
        }

        if (timeText) {
            timeText.textContent = `${activeWaktu} Menit • BSKAP 046`;
        }
    }

    // Toggle Bentuk Soal (Desktop & Mobile Sync)
    function toggleBentukSoal() {
        const bentukRadio = document.querySelector('input[name="bentuk_soal"]:checked');
        const bentuk = bentukRadio ? bentukRadio.value : 'campuran';
        activeBentuk = bentuk;

        // Desktop Wrappers
        const wrapPg = document.getElementById('wrapTotalPg');
        const wrapIsian = document.getElementById('wrapTotalIsian');

        // Mobile Wrappers
        const mobWrapPg = document.getElementById('mobileWrapTotalPg');
        const mobWrapIsian = document.getElementById('mobileWrapTotalIsian');

        if (bentuk === 'pg') {
            if (wrapPg) wrapPg.classList.remove('d-none');
            if (wrapIsian) wrapIsian.classList.add('d-none');
            if (mobWrapPg) mobWrapPg.classList.remove('d-none');
            if (mobWrapIsian) mobWrapIsian.classList.add('d-none');
        } else if (bentuk === 'isian') {
            if (wrapPg) wrapPg.classList.add('d-none');
            if (wrapIsian) wrapIsian.classList.remove('d-none');
            if (mobWrapPg) mobWrapPg.classList.add('d-none');
            if (mobWrapIsian) mobWrapIsian.classList.remove('d-none');
        } else {
            if (wrapPg) wrapPg.classList.remove('d-none');
            if (wrapIsian) wrapIsian.classList.remove('d-none');
            if (mobWrapPg) mobWrapPg.classList.remove('d-none');
            if (mobWrapIsian) mobWrapIsian.classList.remove('d-none');
        }

        updateDockSummary();
    }

    // Mobile Select Handlers
    function selectMobileBentukSoal(bentuk, btn) {
        activeBentuk = bentuk;
        document.querySelectorAll('.btn-mobile-bentuk-choice').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Sync Desktop Radio
        if (bentuk === 'campuran') {
            const r = document.getElementById('bentukCampuran');
            if (r) r.checked = true;
        } else if (bentuk === 'pg') {
            const r = document.getElementById('bentukPg');
            if (r) r.checked = true;
        } else if (bentuk === 'isian') {
            const r = document.getElementById('bentukIsian');
            if (r) r.checked = true;
        }

        toggleBentukSoal();
    }

    function selectMobileFaseSoal(faseId, btn) {
        document.querySelectorAll('.btn-mobile-soal-pill[data-fase-id]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const faseSelect = document.getElementById('faseSelect');
        if (faseSelect) faseSelect.value = faseId;
    }

    function selectMobileWaktuSoal(menit, btn) {
        activeWaktu = menit;
        document.querySelectorAll('.btn-mobile-soal-pill[data-waktu]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const waktuSelect = document.getElementById('alokasiWaktuSelect');
        if (waktuSelect) waktuSelect.value = menit;
        updateDockSummary();
    }

    function selectMobileCountPg(cnt, btn) {
        activePg = cnt;
        document.querySelectorAll('.btn-mobile-count-pill[data-count]').forEach(b => {
            if (b.closest('#mobileWrapTotalPg')) b.classList.remove('active');
        });
        btn.classList.add('active');

        const badge = document.getElementById('mobilePgDisplayBadge');
        if (badge) badge.textContent = `${cnt} Butir`;

        const select = document.getElementById('selectTotalPg');
        if (select) select.value = cnt;
        updateDockSummary();
    }

    function selectMobileCountIsian(cnt, btn) {
        activeIsian = cnt;
        document.querySelectorAll('.btn-mobile-count-pill[data-count]').forEach(b => {
            if (b.closest('#mobileWrapTotalIsian')) b.classList.remove('active');
        });
        btn.classList.add('active');

        const badge = document.getElementById('mobileIsianDisplayBadge');
        if (badge) badge.textContent = `${cnt} Butir`;

        const select = document.getElementById('selectTotalIsian');
        if (select) select.value = cnt;
        updateDockSummary();
    }

    // Sync Desktop to Mobile helpers
    function syncTotalPg(val) {
        activePg = parseInt(val) || 10;
        const badge = document.getElementById('mobilePgDisplayBadge');
        if (badge) badge.textContent = `${activePg} Butir`;
        document.querySelectorAll('#mobileWrapTotalPg .btn-mobile-count-pill').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-count') == activePg);
        });
        updateDockSummary();
    }

    function syncTotalIsian(val) {
        activeIsian = parseInt(val) || 5;
        const badge = document.getElementById('mobileIsianDisplayBadge');
        if (badge) badge.textContent = `${activeIsian} Butir`;
        document.querySelectorAll('#mobileWrapTotalIsian .btn-mobile-count-pill').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-count') == activeIsian);
        });
        updateDockSummary();
    }

    function syncMobileModulToDesktop(select) {
        const desktopSelect = document.getElementById('modulAjarSelect');
        if (desktopSelect) {
            desktopSelect.value = select.value;
            // Trigger change event on desktop select to auto-populate Mapel & Fase
            desktopSelect.dispatchEvent(new Event('change'));
        }
        
        // Sync mobile Mapel & Fase from selected option
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

    function syncMobileMapelToDesktop(select) {
        const desktopSelect = document.getElementById('mapelSelect');
        if (desktopSelect) desktopSelect.value = select.value;
    }

    function syncMobileJudulToDesktop(val) {
        const desktopInput = document.getElementById('judulInput');
        if (desktopInput) desktopInput.value = val;
    }

    function syncMobileJenisUjian(val) {
        const desktopSelect = document.getElementById('jenisUjianSelect');
        if (desktopSelect) desktopSelect.value = val;
    }

    // Auto-fill dari Modul Ajar (Desktop trigger)
    document.getElementById('modulAjarSelect')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected && selected.value) {
            const mapelId = selected.getAttribute('data-mapel-id');
            const faseId = selected.getAttribute('data-fase-id');
            const judul = selected.getAttribute('data-judul');

            if (mapelId) {
                const mapelSelect = document.getElementById('mapelSelect');
                if (mapelSelect) mapelSelect.value = mapelId;
                const mobMapel = document.getElementById('mobileMapelSelect');
                if (mobMapel) mobMapel.value = mapelId;
            }
            if (faseId) {
                const faseSelect = document.getElementById('faseSelect');
                if (faseSelect) faseSelect.value = faseId;
                document.querySelectorAll('.btn-mobile-soal-pill[data-fase-id]').forEach(b => {
                    b.classList.toggle('active', b.getAttribute('data-fase-id') === faseId);
                });
            }
            if (judul && !document.getElementById('judulInput').value) {
                document.getElementById('judulInput').value = 'Asesmen Sumatif: ' + judul;
                const mobJudul = document.getElementById('mobileJudulInput');
                if (mobJudul) mobJudul.value = 'Asesmen Sumatif: ' + judul;
            }
        }
    });

    // Mobile Submit Trigger with Pre-validation
    function triggerMobileSubmitSoal() {
        const mapelVal = document.getElementById('mapelSelect')?.value || document.getElementById('mobileMapelSelect')?.value;
        const faseVal = document.getElementById('faseSelect')?.value;

        if (!mapelVal) {
            Swal.fire({
                icon: 'warning',
                title: 'Mata Pelajaran Belum Dipilih',
                text: 'Silakan pilih Mata Pelajaran terlebih dahulu.',
                confirmButtonColor: '#0284c7'
            });
            document.getElementById('mobileMapelSelect')?.focus();
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

        document.getElementById('formGeneratorSoal').submit();
    }

    // Loading State pada Tombol Submit Desktop
    document.getElementById('formGeneratorSoal')?.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitSoal');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyusun Kisi-Kisi & Soal...';
        }
    });

    // Inisialisasi saat load
    document.addEventListener('DOMContentLoaded', function() {
        toggleBentukSoal();
        updateDockSummary();
    });
</script>
@endsection
