@extends('layouts.app')

@section('title', 'Naskah Asesmen: ' . $paketSoal->judul)

@section('content')
<div class="container-fluid px-2 px-md-4 py-2 py-md-3">

    <!-- ============================================================ -->
    <!-- NOTIFIKASI SUKSES (TAMPIL DI MOBILE & DESKTOP)               -->
    <!-- ============================================================ -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-4 mb-3" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ============================================================ -->
    <!-- MOBILE VIEW: ANDROID NATIVE SMART SOAL VIEWER (STITCH)       -->
    <!-- ============================================================ -->
    <div class="d-block d-md-none mobile-soal-show-shell mb-4">
        <!-- 1. Mobile Top Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-3 pt-1">
            <a href="{{ route('paket-soal.index') }}" class="mobile-soal-nav-btn text-dark text-decoration-none" title="Kembali ke Bank Soal">
                <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
            </a>
            <div class="text-center px-1 overflow-hidden">
                <h1 class="mobile-soal-title mb-0 text-truncate" style="max-width: 220px;">{{ $paketSoal->judul }}</h1>
                <span class="mobile-soal-eyebrow">{{ $paketSoal->jenis_ujian_label }}</span>
            </div>
            <button type="button" class="mobile-soal-nav-btn text-dark border-0 bg-white" data-bs-toggle="modal" data-bs-target="#modalEditSoal" title="Edit Metadata">
                <span class="material-symbols-outlined text-secondary" style="font-size: 20px;">edit</span>
            </button>
        </div>

        <!-- 2. Calm Hero Showcase Card -->
        <section class="mobile-soal-hero-card mb-3 position-relative overflow-hidden">
            <div class="mobile-soal-hero-ambient"></div>
            <div class="position-relative" style="z-index: 2;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-white bg-opacity-15 text-white border border-white border-opacity-25 rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.68rem;">
                        {{ $paketSoal->mataPelajaran->nama ?? 'Kejuruan SMK' }}
                    </span>
                    <span class="text-white text-opacity-75 small font-monospace" style="font-size: 0.72rem;">
                        Fase {{ $paketSoal->fase->kode ?? '-' }} ({{ $paketSoal->fase->kelas_range ?? '-' }})
                    </span>
                </div>
                <h2 class="text-white fw-bold mb-1" style="font-size: 1.1rem; line-height: 1.35;">
                    {{ $paketSoal->judul }}
                </h2>
                <div class="text-white text-opacity-75 small mb-3" style="font-size: 0.75rem;">
                    Waktu: <strong>{{ $paketSoal->alokasi_waktu_menit }} Menit</strong> &bull; Total: <strong>{{ $paketSoal->total_soal }} Butir</strong> ({{ $paketSoal->total_soal_pg }} PG + {{ $paketSoal->total_soal_isian }} Isian)
                </div>

                <!-- 3 Quick Export Pills Inside Hero -->
                <div class="d-flex gap-1.5 flex-wrap">
                    <a href="{{ route('export.soal.siswa.pdf', $paketSoal->id) }}" class="btn-mobile-hero-export">
                        <span class="material-symbols-outlined text-secondary" style="font-size: 15px;">person</span>
                        <span>PDF Siswa</span>
                    </a>
                    <a href="{{ route('export.soal.guru.pdf', $paketSoal->id) }}" class="btn-mobile-hero-export">
                        <span class="material-symbols-outlined text-danger" style="font-size: 15px;">picture_as_pdf</span>
                        <span>PDF Guru</span>
                    </a>
                    <a href="{{ route('export.soal.docx', $paketSoal->id) }}" class="btn-mobile-hero-export">
                        <span class="material-symbols-outlined text-primary" style="font-size: 15px;">description</span>
                        <span>Word</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- 3. Mobile Segmented Tab Switcher -->
        <div class="d-flex gap-1.5 mb-3 overflow-x-auto pb-1 no-scrollbar" style="white-space: nowrap;">
            <button type="button" class="mobile-subtab-chip active" id="tabMobileKisiBtn" onclick="switchMobileTab('kisi')">
                <span class="material-symbols-outlined align-middle me-0.5" style="font-size: 14px;">table_chart</span>
                1. Kisi-Kisi ({{ count($paketSoal->kisi_kisi_data ?? []) }})
            </button>
            <button type="button" class="mobile-subtab-chip" id="tabMobileSiswaBtn" onclick="switchMobileTab('siswa')">
                <span class="material-symbols-outlined align-middle me-0.5" style="font-size: 14px;">assignment</span>
                2. Soal Siswa ({{ $paketSoal->total_soal }})
            </button>
            <button type="button" class="mobile-subtab-chip" id="tabMobileKunciBtn" onclick="switchMobileTab('kunci')">
                <span class="material-symbols-outlined align-middle me-0.5" style="font-size: 14px;">key</span>
                3. Kunci &amp; Rubrik
            </button>
        </div>

        <!-- 4. TAB CONTENT 1: KISI-KISI CARDS -->
        <div id="mobileTabKisiContent" class="mobile-tab-view">
            <div class="d-flex align-items-center justify-content-between mb-2.5">
                <span class="text-dark fw-bold small">Test Blueprint Kemendikdasmen</span>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5" style="font-size: 0.72rem;" onclick="toggleMobileRawTable()">
                    <span id="btnRawTableText">Lihat Tabel Penuh</span>
                </button>
            </div>

            <!-- Optional Raw Table (Hidden by default on mobile) -->
            <div id="mobileRawTableWrapper" class="table-responsive bg-white border rounded-3 p-2 mb-3" style="display: none;">
                <table class="table table-bordered table-sm mb-0" style="font-size: 0.72rem;">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Elemen</th>
                            <th>Materi</th>
                            <th>Indikator</th>
                            <th>Level</th>
                            <th>Bentuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paketSoal->kisi_kisi_data ?? [] as $idx => $k)
                            <tr>
                                <td class="text-center fw-bold">{{ $k['nomor_soal'] ?? ($idx + 1) }}</td>
                                <td>{{ $k['elemen'] ?? '-' }}</td>
                                <td class="fw-semibold text-primary">{{ $k['materi'] ?? '-' }}</td>
                                <td>{{ $k['indikator'] ?? '-' }}</td>
                                <td class="text-center">{{ $k['level_kognitif'] ?? '-' }}</td>
                                <td class="text-center">{{ ($k['bentuk_soal'] ?? '') === 'Pilihan Ganda' ? 'PG' : 'Isian' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- List of Responsive Kisi-Kisi Cards -->
            <div class="d-flex flex-column gap-2 mb-4">
                @forelse($paketSoal->kisi_kisi_data ?? [] as $idx => $k)
                    <div class="mobile-kisi-card">
                        <!-- Top Header Row -->
                        <div class="d-flex align-items-center justify-content-between mb-1.5">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">
                                    Soal #{{ $k['nomor_soal'] ?? ($idx + 1) }}
                                </span>
                                <span class="badge badge-soft-primary" style="font-size: 0.68rem;">
                                    {{ $k['level_kognitif'] ?? 'C3' }}
                                </span>
                            </div>
                            <span class="badge {{ ($k['bentuk_soal'] ?? '') === 'Pilihan Ganda' ? 'badge-soft-success' : 'badge-soft-warning' }}" style="font-size: 0.68rem;">
                                {{ ($k['bentuk_soal'] ?? '') === 'Pilihan Ganda' ? 'Pilihan Ganda' : 'Isian/Uraian' }}
                            </span>
                        </div>

                        <!-- Materi & Elemen -->
                        <div class="fw-bold text-dark mb-0.5" style="font-size: 0.88rem; line-height: 1.35;">
                            {{ $k['materi'] ?? '-' }}
                        </div>
                        <div class="text-secondary small mb-2" style="font-size: 0.72rem;">
                            Elemen: <strong>{{ $k['elemen'] ?? '-' }}</strong>
                        </div>

                        <!-- Indikator Soal Box -->
                        <div class="p-2 rounded-2 bg-light border text-dark small mb-1.5" style="font-size: 0.78rem; line-height: 1.45;">
                            <strong class="text-primary d-block mb-0.5" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.04em;">Indikator Butir Soal:</strong>
                            {{ $k['indikator'] ?? '-' }}
                        </div>

                        <!-- TP Snippet -->
                        <div class="text-muted small" style="font-size: 0.7rem; line-height: 1.35;">
                            <strong>TP:</strong> {{ $k['tp'] ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light text-center py-4 text-muted small">
                        Data kisi-kisi tidak tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 5. TAB CONTENT 2: NASKAH SOAL SISWA -->
        <div id="mobileTabSiswaContent" class="mobile-tab-view" style="display: none;">
            <!-- Lembar Identitas Siswa -->
            <div class="p-3 rounded-4 mb-3 border bg-white shadow-xs">
                <div class="fw-bold text-dark small mb-2 pb-1 border-bottom d-flex align-items-center justify-content-between">
                    <span>Lembar Identitas Siswa</span>
                    <span class="text-muted" style="font-size: 0.7rem;">Waktu: {{ $paketSoal->alokasi_waktu_menit }}m</span>
                </div>
                <div class="row g-2 small text-secondary" style="font-size: 0.74rem;">
                    <div class="col-6"><strong>Mapel:</strong> {{ $paketSoal->mataPelajaran->nama ?? '-' }}</div>
                    <div class="col-6"><strong>Fase:</strong> Fase {{ $paketSoal->fase->kode ?? '-' }}</div>
                    <div class="col-12"><strong>Nama Siswa:</strong> _____________________________</div>
                    <div class="col-12"><strong>Kelas / Absen:</strong> _____________________________</div>
                </div>
            </div>

            <!-- Petunjuk Umum -->
            @if($paketSoal->petunjuk_umum)
                <div class="alert alert-light border border-dashed py-2 px-3 small rounded-3 mb-3 text-muted" style="font-size: 0.75rem;">
                    <strong class="text-dark d-block mb-0.5"><i class="bi bi-info-circle me-1"></i> Petunjuk Pengerjaan:</strong>
                    {!! nl2br(e($paketSoal->petunjuk_umum)) !!}
                </div>
            @endif

            <!-- Bagian I: PG -->
            @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                <div class="mobile-section-header-pill mb-2.5">
                    BAGIAN I: PILIHAN GANDA ({{ count($paketSoal->butir_soal_pg) }} Butir)
                </div>

                <div class="d-flex flex-column gap-2.5 mb-4">
                    @foreach($paketSoal->butir_soal_pg as $pg)
                        <div class="mobile-question-card">
                            <div class="d-flex align-items-start gap-2 mb-1.5">
                                <span class="mobile-question-num-badge">
                                    {{ $pg['nomor'] }}
                                </span>
                                <div class="fw-semibold text-dark" style="font-size: 0.88rem; line-height: 1.45;">
                                    {{ $pg['pertanyaan'] }}
                                </div>
                            </div>

                            @if(!empty($pg['stimulus']))
                                <div class="mobile-stimulus-box mb-2">
                                    <strong class="text-dark">Konteks/Kasus:</strong> {{ $pg['stimulus'] }}
                                </div>
                            @endif

                            <div class="d-flex flex-column gap-1.5 ps-1">
                                @foreach($pg['pilihan'] as $opt => $text)
                                    <div class="mobile-option-row">
                                        <span class="mobile-option-letter">{{ $opt }}</span>
                                        <span class="text-dark small" style="font-size: 0.82rem;">{{ $text }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Bagian II: Isian / Uraian -->
            @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                <div class="mobile-section-header-pill bg-slate-800 text-white mb-2.5">
                    BAGIAN II: ISIAN / URAIAN ({{ count($paketSoal->butir_soal_isian) }} Butir)
                </div>

                <div class="d-flex flex-column gap-2.5 mb-4">
                    @foreach($paketSoal->butir_soal_isian as $es)
                        <div class="mobile-question-card">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-1.5">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="mobile-question-num-badge bg-secondary text-white">
                                        {{ $es['nomor'] }}
                                    </span>
                                    <div class="fw-semibold text-dark" style="font-size: 0.88rem; line-height: 1.45;">
                                        {{ $es['pertanyaan'] }}
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border flex-shrink-0" style="font-size: 0.68rem;">
                                    Skor {{ $es['skor_maksimal'] ?? 10 }}
                                </span>
                            </div>

                            @if(!empty($es['stimulus']))
                                <div class="mobile-stimulus-box mb-2" style="border-left-color: #64748b;">
                                    <strong class="text-dark">Konteks Masalah:</strong> {{ $es['stimulus'] }}
                                </div>
                            @endif

                            <div class="p-2.5 rounded-2 border border-dashed text-muted small" style="background: #fafafa; min-height: 65px; font-size: 0.74rem;">
                                <em>Ruang lembar jawaban murid...</em>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 6. TAB CONTENT 3: KUNCI JAWABAN & RUBRIK GURU -->
        <div id="mobileTabKunciContent" class="mobile-tab-view" style="display: none;">
            <div class="p-3 rounded-4 bg-light border border-slate-200 mb-3 text-dark small" style="font-size: 0.75rem;">
                <div class="fw-bold mb-0.5"><i class="bi bi-shield-lock-fill text-warning me-1"></i> Dokumen Pegangan Guru</div>
                Kunci jawaban, pembahasan analitis, dan rubrik pedoman penskoran ini hanya untuk instruktur/guru.
            </div>

            <!-- Kunci Pilihan Ganda -->
            @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                <div class="mobile-section-header-pill mb-2.5">
                    KUNCI &amp; PEMBAHASAN PILIHAN GANDA
                </div>

                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($paketSoal->butir_soal_pg as $pg)
                        <div class="mobile-kisi-card">
                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                <span class="fw-bold text-dark small">Nomor {{ $pg['nomor'] }}</span>
                                <span class="badge badge-soft-success px-2 py-0.5 fw-bold" style="font-size: 0.74rem;">
                                    Kunci: {{ $pg['kunci_jawaban'] ?? $pg['kunci'] ?? '-' }}
                                </span>
                            </div>
                            <div class="small text-secondary mb-2" style="font-size: 0.78rem;">
                                {{ Str::limit($pg['pertanyaan'], 90) }}
                            </div>
                            <div class="p-2 rounded-2 bg-light border text-muted small" style="font-size: 0.75rem; line-height: 1.45;">
                                <strong class="text-dark d-block mb-0.5">💡 Pembahasan Analitis:</strong>
                                {{ $pg['pembahasan'] ?? '-' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Rubrik Penskoran Isian -->
            @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                <div class="mobile-section-header-pill bg-slate-800 text-white mb-2.5">
                    RUBRIK PEDOMAN PENSKORAN ISIAN
                </div>

                <div class="d-flex flex-column gap-2.5 mb-4">
                    @foreach($paketSoal->butir_soal_isian as $es)
                        <div class="mobile-kisi-card">
                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                <span class="fw-bold text-dark small">Soal Nomor {{ $es['nomor'] }}</span>
                                <span class="badge badge-soft-primary" style="font-size: 0.7rem;">Skor Maks: {{ $es['skor_maksimal'] ?? 10 }}</span>
                            </div>
                            <div class="small fw-semibold text-dark mb-2" style="font-size: 0.8rem;">
                                {{ $es['pertanyaan'] }}
                            </div>

                            <div class="p-2 rounded-2 mb-2 bg-light border text-dark small" style="font-size: 0.75rem;">
                                <strong class="text-primary d-block mb-0.5">Kata Kunci / Kriteria Jawaban:</strong>
                                {{ $es['kata_kunci'] ?? '-' }}
                            </div>

                            <div class="p-2 rounded-2 bg-light border text-secondary small" style="font-size: 0.73rem; line-height: 1.45;">
                                <strong class="text-dark d-block mb-0.5">Rubrik Penskoran:</strong>
                                {!! nl2br(e($es['pedoman_penskoran'] ?? '-')) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 7. Fixed Floating Bottom Action Dock (Quick Export Bar) -->
        <div class="mobile-soal-show-dock">
            <div class="mobile-soal-show-dock-inner">
                <a href="{{ route('export.soal.siswa.pdf', $paketSoal->id) }}" class="btn-dock-export">
                    <span class="material-symbols-outlined" style="font-size: 16px;">person</span>
                    <span>PDF Siswa</span>
                </a>
                <a href="{{ route('export.soal.guru.pdf', $paketSoal->id) }}" class="btn-dock-export text-danger">
                    <span class="material-symbols-outlined" style="font-size: 16px;">picture_as_pdf</span>
                    <span>PDF Guru</span>
                </a>
                <a href="{{ route('export.soal.docx', $paketSoal->id) }}" class="btn-dock-export text-primary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">description</span>
                    <span>DOCX</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- DESKTOP VIEW: TAMPILAN LENGKAP PC & LAPTOP (TIDAK BERUBAH)   -->
    <!-- ============================================================ -->
    <div class="d-none d-md-block desktop-soal-show-shell">

        <!-- BREADCRUMB & ACTION BUTTONS -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <a href="{{ route('paket-soal.index') }}" class="text-secondary small text-decoration-none d-inline-flex align-items-center gap-1 mb-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Bank Soal
                </a>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <h4 class="fw-bold text-dark mb-0" style="color: #0b3b60 !important;">
                        {{ $paketSoal->judul }}
                    </h4>
                    <span class="badge badge-soft-primary rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                        {{ $paketSoal->jenis_ujian_label }}
                    </span>
                </div>
                <div class="text-muted small">
                    {{ $paketSoal->mataPelajaran->nama ?? '-' }} &bull; Fase {{ $paketSoal->fase->kode ?? '-' }} (Kelas {{ $paketSoal->fase->kelas_range ?? '-' }}) &bull; Waktu: {{ $paketSoal->alokasi_waktu_menit }} Menit
                </div>
            </div>

            <!-- TOMBOL AKSI EKSPOR & CETAK -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- MODAL EDIT METADATA -->
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditSoal">
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Naskah</span>
                </button>

                <!-- CETAK NASKAH SISWA (PDF) -->
                <a href="{{ route('export.soal.siswa.pdf', $paketSoal->id) }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1.5">
                    <i class="bi bi-person-badge"></i>
                    <span>PDF Soal Siswa</span>
                </a>

                <!-- CETAK PEGANGAN GURU LENGKAP (PDF) -->
                <a href="{{ route('export.soal.guru.pdf', $paketSoal->id) }}" class="btn btn-danger btn-sm rounded-pill px-3.5 shadow-sm text-white fw-bold d-inline-flex align-items-center gap-1.5" style="background: #dc2626; border: none;">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>PDF Lengkap Guru</span>
                </a>

                <!-- UNDUH WORD -->
                <a href="{{ route('export.soal.docx', $paketSoal->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                    <i class="bi bi-file-earmark-word-fill"></i>
                    <span>Unduh Word (.docx)</span>
                </a>
            </div>
        </div>

        <!-- TAB NAVIGATION UTAMA -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white p-2 border-bottom">
                <ul class="nav nav-pills gap-2" id="soalTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="kisi-kisi-tab" data-bs-toggle="tab" data-bs-target="#kisi-kisi" type="button" role="tab" aria-controls="kisi-kisi" aria-selected="true">
                            <i class="bi bi-table"></i>
                            <span>1. Tabel Kisi-Kisi Resmi Kemendikdasmen</span>
                            <span class="badge bg-primary bg-opacity-20 text-primary ms-1" style="font-size: 0.68rem;">{{ count($paketSoal->kisi_kisi_data ?? []) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="soal-siswa-tab" data-bs-toggle="tab" data-bs-target="#soal-siswa" type="button" role="tab" aria-controls="soal-siswa" aria-selected="false">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>2. Naskah Lembar Soal Siswa</span>
                            <span class="badge bg-success bg-opacity-20 text-success ms-1" style="font-size: 0.68rem;">{{ $paketSoal->total_soal }} Butir</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="kunci-rubrik-tab" data-bs-toggle="tab" data-bs-target="#kunci-rubrik" type="button" role="tab" aria-controls="kunci-rubrik" aria-selected="false">
                            <i class="bi bi-key-fill text-warning"></i>
                            <span>3. Kunci Jawaban, Pembahasan & Rubrik Guru</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 bg-white">
                <div class="tab-content" id="soalTabContent">

                    <!-- ================= TAB 1: KISI-KISI SOAL RESMI KEMENDIKDASMEN ================= -->
                    <div class="tab-pane fade show active" id="kisi-kisi" role="tabpanel" aria-labelledby="kisi-kisi-tab">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Tabel Spesifikasi / Kisi-Kisi Penulisan Soal</h5>
                                <p class="text-muted small mb-0">Disusun berdasarkan Keputusan Kepala BSKAP 046/H/KR/2025 dan Taksonomi Bloom.</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-soft-success">PG: {{ $paketSoal->total_soal_pg }} Butir</span>
                                <span class="badge badge-soft-warning">Isian: {{ $paketSoal->total_soal_isian }} Butir</span>
                            </div>
                        </div>

                        @if(!empty($paketSoal->kisi_kisi_data) && count($paketSoal->kisi_kisi_data) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 0.83rem;">
                                    <thead style="background: #f1f5f9; color: #0b3b60;">
                                        <tr class="text-center align-middle">
                                            <th style="width: 40px;">No</th>
                                            <th style="width: 140px;">Elemen Capaian</th>
                                            <th style="width: 200px;">Tujuan Pembelajaran (TP)</th>
                                            <th style="width: 150px;">Materi / Topik</th>
                                            <th>Indikator Butir Soal</th>
                                            <th style="width: 120px;">Level Kognitif</th>
                                            <th style="width: 80px;">Bentuk</th>
                                            <th style="width: 60px;">No. Soal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paketSoal->kisi_kisi_data as $idx => $k)
                                            <tr>
                                                <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                                                <td class="fw-semibold text-dark">{{ $k['elemen'] ?? '-' }}</td>
                                                <td class="text-muted small">{{ $k['tp'] ?? '-' }}</td>
                                                <td><span class="fw-semibold text-primary">{{ $k['materi'] ?? '-' }}</span></td>
                                                <td>{{ $k['indikator'] ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-soft-primary" style="font-size: 0.72rem;">
                                                        {{ $k['level_kognitif'] ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $k['bentuk_soal'] === 'Pilihan Ganda' ? 'badge-soft-success' : 'badge-soft-warning' }}" style="font-size: 0.72rem;">
                                                        {{ $k['bentuk_soal'] === 'Pilihan Ganda' ? 'PG' : 'Isian' }}
                                                    </span>
                                                </td>
                                                <td class="text-center fw-bold text-dark fs-6">{{ $k['nomor_soal'] ?? ($idx + 1) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-light text-center py-4 text-muted">
                                Data kisi-kisi tidak tersedia.
                            </div>
                        @endif
                    </div>

                    <!-- ================= TAB 2: NASKAH SOAL SISWA ================= -->
                    <div class="tab-pane fade" id="soal-siswa" role="tabpanel" aria-labelledby="soal-siswa-tab">
                        <!-- PRATINJAU LEMBAR IDENTITAS SISWA -->
                        <div class="p-3 rounded-3 mb-4 border" style="background: #f8fafc; border-color: #cbd5e1 !important;">
                            <div class="row g-2 small text-dark">
                                <div class="col-sm-6"><strong>Mata Pelajaran:</strong> {{ $paketSoal->mataPelajaran->nama ?? '-' }}</div>
                                <div class="col-sm-6"><strong>Nama Siswa:</strong> ___________________________________</div>
                                <div class="col-sm-6"><strong>Fase / Kelas:</strong> Fase {{ $paketSoal->fase->kode ?? '-' }} ({{ $paketSoal->fase->kelas_range ?? '-' }})</div>
                                <div class="col-sm-6"><strong>Kelas / No. Absen:</strong> ___________ / No: ________</div>
                                <div class="col-sm-6"><strong>Alokasi Waktu:</strong> {{ $paketSoal->alokasi_waktu_menit }} Menit</div>
                                <div class="col-sm-6"><strong>Hari / Tanggal:</strong> ___________________________________</div>
                            </div>
                        </div>

                        <!-- PETUNJUK PENGERJAAN -->
                        @if($paketSoal->petunjuk_umum)
                            <div class="alert alert-light border border-dashed py-2 px-3 small rounded-3 mb-4 text-muted">
                                <strong class="text-dark d-block mb-1"><i class="bi bi-info-circle me-1"></i> PETUNJUK UMUM PENGERJAAN:</strong>
                                {!! nl2br(e($paketSoal->petunjuk_umum)) !!}
                            </div>
                        @endif

                        <!-- BAGIAN I: PILIHAN GANDA -->
                        @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                            <div class="p-2 px-3 rounded-3 fw-bold text-white mb-3" style="background: #0b3b60; font-size: 0.88rem;">
                                BAGIAN I: SOAL PILIHAN GANDA (Pilihlah salah satu jawaban A, B, C, D, atau E yang paling benar)
                            </div>

                            <div class="mb-4">
                                @foreach($paketSoal->butir_soal_pg as $pg)
                                    <div class="mb-3 p-3 rounded-3 border bg-white shadow-sm">
                                        <div class="d-flex align-items-start gap-2 mb-1.5">
                                            <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.78rem;">
                                                {{ $pg['nomor'] }}
                                            </span>
                                            <div class="fw-semibold text-dark" style="font-size: 0.92rem; line-height: 1.5;">
                                                {{ $pg['pertanyaan'] }}
                                            </div>
                                        </div>

                                        @if(!empty($pg['stimulus']))
                                            <div class="p-2.5 px-3 rounded-2 small text-secondary mb-2.5" style="background: #f8fafc; border-left: 3px solid #0284c7; font-size: 0.83rem;">
                                                <strong class="text-dark">Konteks/Kasus:</strong> {{ $pg['stimulus'] }}
                                            </div>
                                        @endif

                                        <div class="row g-2 ps-4">
                                            @foreach($pg['pilihan'] as $opt => $text)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-start gap-2 small">
                                                        <span class="fw-bold text-primary">{{ $opt }}.</span>
                                                        <span class="text-dark">{{ $text }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- BAGIAN II: ISIAN / URAIAN -->
                        @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                            <div class="p-2 px-3 rounded-3 fw-bold text-white mb-3" style="background: #0284c7; font-size: 0.88rem;">
                                BAGIAN II: SOAL ISIAN / URAIAN (Jawablah dengan terstruktur dan mengacu pada standar SOP)
                            </div>

                            <div>
                                @foreach($paketSoal->butir_soal_isian as $es)
                                    <div class="mb-3 p-3 rounded-3 border bg-white shadow-sm">
                                        <div class="d-flex align-items-start gap-2 mb-1.5">
                                            <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.78rem;">
                                                {{ $es['nomor'] }}
                                            </span>
                                            <div class="fw-semibold text-dark" style="font-size: 0.92rem; line-height: 1.5;">
                                                {{ $es['pertanyaan'] }}
                                                <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.7rem;">Skor Maks: {{ $es['skor_maksimal'] ?? 10 }}</span>
                                            </div>
                                        </div>

                                        @if(!empty($es['stimulus']))
                                            <div class="p-2.5 px-3 rounded-2 small text-secondary mb-2.5" style="background: #f8fafc; border-left: 3px solid #f59e0b; font-size: 0.83rem;">
                                                <strong class="text-dark">Konteks Masalah:</strong> {{ $es['stimulus'] }}
                                            </div>
                                        @endif

                                        <div class="p-3 rounded-2 border border-dashed text-muted small" style="background: #fafafa; min-height: 80px;">
                                            <em>Ruang lembar jawaban murid...</em>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- ================= TAB 3: KUNCI JAWABAN & RUBRIK GURU ================= -->
                    <div class="tab-pane fade" id="kunci-rubrik" role="tabpanel" aria-labelledby="kunci-rubrik-tab">
                        <div class="alert alert-warning border-0 bg-warning bg-opacity-15 py-2.5 px-3 small rounded-3 mb-4 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill fs-5 text-warning"></i>
                            <div>
                                <strong>Dokumen Rahasia Pegangan Guru:</strong> Kunci jawaban, analisis pembahasan ilmiah, dan rubrik pedoman penskoran hanya untuk instruktur/guru dan tidak disertakan pada naskah siswa.
                            </div>
                        </div>

                        <!-- KUNCI PILIHAN GANDA -->
                        @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-key-fill text-success"></i>
                                Kunci Jawaban & Pembahasan Pilihan Ganda
                            </h5>

                            <div class="row g-3 mb-4">
                                @foreach($paketSoal->butir_soal_pg as $pg)
                                    <div class="col-md-6">
                                        <div class="card border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fw-bold text-dark small">Nomor {{ $pg['nomor'] }}</span>
                                                <span class="badge badge-soft-success fs-6 px-2.5 py-0.5">
                                                    Kunci: {{ $pg['kunci_jawaban'] ?? $pg['kunci'] ?? '-' }}
                                                </span>
                                            </div>
                                            <p class="small text-dark mb-2 fw-semibold" style="font-size: 0.83rem;">
                                                {{ Str::limit($pg['pertanyaan'], 85) }}
                                            </p>
                                            <div class="p-2 rounded bg-white border small text-muted" style="font-size: 0.78rem;">
                                                <strong class="text-success"><i class="bi bi-lightbulb-fill"></i> Pembahasan Analitis:</strong><br>
                                                {{ $pg['pembahasan'] ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- RUBRIK PENSKORAN ISIAN -->
                        @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                <i class="bi bi-clipboard2-check-fill text-primary"></i>
                                Kriteria Jawaban & Rubrik Pedoman Penskoran Isian / Uraian
                            </h5>

                            <div>
                                @foreach($paketSoal->butir_soal_isian as $es)
                                    <div class="card border rounded-3 p-3 mb-3" style="background: #ffffff;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold text-dark">Soal Nomor {{ $es['nomor'] }}</span>
                                            <span class="badge badge-soft-primary">Skor Maksimal: {{ $es['skor_maksimal'] ?? 10 }}</span>
                                        </div>
                                        <div class="small fw-semibold text-dark mb-2">
                                            {{ $es['pertanyaan'] }}
                                        </div>

                                        <div class="p-2.5 rounded-3 mb-2" style="background: #eff6ff; border: 1px solid #bfdbfe; font-size: 0.8rem; color: #1e40af;">
                                            <strong><i class="bi bi-check2-circle"></i> Kata Kunci / Kriteria Jawaban:</strong><br>
                                            {{ $es['kata_kunci'] ?? '-' }}
                                        </div>

                                        <div class="p-2.5 rounded-3" style="background: #fefce8; border: 1px solid #fef08a; font-size: 0.78rem; color: #854d0e;">
                                            <strong><i class="bi bi-rulers"></i> Rubrik Pedoman Penskoran:</strong><br>
                                            {!! nl2br(e($es['pedoman_penskoran'] ?? '-')) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- /d-none d-md-block (DESKTOP) -->

</div>

<!-- ============================================================ -->
<!-- MODAL EDIT METADATA SOAL (SHARED MOBILE & DESKTOP)           -->
<!-- ============================================================ -->
<div class="modal fade" id="modalEditSoal" tabindex="-1" aria-labelledby="modalEditSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('paket-soal.update', $paketSoal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 py-3 px-4 bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalEditSoalLabel">Edit Informasi Naskah Soal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Judul Naskah Asesmen</label>
                        <input type="text" name="judul" class="form-control rounded-3" value="{{ $paketSoal->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Alokasi Waktu (Menit)</label>
                        <input type="number" name="alokasi_waktu_menit" class="form-control rounded-3" value="{{ $paketSoal->alokasi_waktu_menit }}" min="10" max="300" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted">Petunjuk Umum Pengerjaan</label>
                        <textarea name="petunjuk_umum" class="form-control rounded-3" rows="5">{{ $paketSoal->petunjuk_umum }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4 bg-white">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ============================================================ */
/* SMART SOAL SHOW MOBILE STITCH SPECIFICATION                  */
/* Calm, Clean, High Contrast, Readable                         */
/* ============================================================ */
.mobile-soal-show-shell {
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
.btn-mobile-hero-export {
    background: #ffffff;
    color: #0f172a;
    font-size: 11px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 9999px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.btn-mobile-hero-export:active {
    transform: scale(0.95);
    background: #f1f5f9;
}
.mobile-subtab-chip {
    padding: 6px 14px;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    font-size: 11.5px;
    font-weight: 600;
    transition: all 0.15s ease;
    white-space: nowrap;
}
.mobile-subtab-chip.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.18);
}
.mobile-kisi-card,
.mobile-question-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.1rem;
    padding: 14px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
.mobile-question-num-badge {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #0284c7;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
}
.mobile-stimulus-box {
    padding: 10px 12px;
    border-radius: 8px;
    background: #f8fafc;
    border-left: 3px solid #0284c7;
    font-size: 0.8rem;
    color: #334155;
    line-height: 1.45;
}
.mobile-option-row {
    display: flex;
    align-items: baseline;
    gap: 8px;
    padding: 5px 8px;
    border-radius: 8px;
    background: #fafafa;
    border: 1px solid #f1f5f9;
}
.mobile-option-letter {
    font-weight: 800;
    color: #0284c7;
    font-size: 12px;
    min-width: 14px;
}
.mobile-section-header-pill {
    padding: 6px 12px;
    border-radius: 8px;
    background: #0f172a;
    color: #ffffff;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.bg-slate-800 {
    background-color: #1e293b !important;
}
/* Floating Bottom Export Bar */
.mobile-soal-show-dock {
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
.mobile-soal-show-dock-inner {
    pointer-events: auto;
    background: #0f172a;
    color: #ffffff;
    padding: 6px 10px;
    border-radius: 9999px;
    box-shadow: 0 16px 36px rgba(15, 23, 42, 0.45);
    display: flex;
    align-items: center;
    justify-content: space-around;
    border: 1px solid rgba(255, 255, 255, 0.14);
}
.btn-dock-export {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #ffffff;
    text-decoration: none;
    font-size: 11.5px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 9999px;
    transition: all 0.15s ease;
}
.btn-dock-export:hover,
.btn-dock-export:active {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
}
</style>

<script>
    function switchMobileTab(tab) {
        document.querySelectorAll('.mobile-subtab-chip').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.mobile-tab-view').forEach(v => v.style.display = 'none');

        if (tab === 'kisi') {
            document.getElementById('tabMobileKisiBtn')?.classList.add('active');
            const target = document.getElementById('mobileTabKisiContent');
            if (target) target.style.display = 'block';
        } else if (tab === 'siswa') {
            document.getElementById('tabMobileSiswaBtn')?.classList.add('active');
            const target = document.getElementById('mobileTabSiswaContent');
            if (target) target.style.display = 'block';
        } else if (tab === 'kunci') {
            document.getElementById('tabMobileKunciBtn')?.classList.add('active');
            const target = document.getElementById('mobileTabKunciContent');
            if (target) target.style.display = 'block';
        }
    }

    function toggleMobileRawTable() {
        const wrap = document.getElementById('mobileRawTableWrapper');
        const text = document.getElementById('btnRawTableText');
        if (wrap.style.display === 'none') {
            wrap.style.display = 'block';
            if (text) text.textContent = 'Sembunyikan Tabel';
        } else {
            wrap.style.display = 'none';
            if (text) text.textContent = 'Lihat Tabel Penuh';
        }
    }
</script>
@endsection
