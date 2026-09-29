@extends('layouts.mobile')

@section('title', 'Naskah Asesmen: ' . $paketSoal->judul)

@section('header')
    <!-- 1. Mobile Top Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ route('paket-soal.index') }}" class="mobile-soal-nav-btn text-dark text-decoration-none" title="Kembali ke Bank Soal">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center px-1 overflow-hidden">
            <h1 class="mobile-soal-title mb-0 text-truncate" style="max-width: 220px;">{{ $paketSoal->judul }}</h1>
            <span class="mobile-soal-eyebrow">{{ $paketSoal->jenis_ujian_label }}</span>
        </div>
        <button type="button" class="mobile-soal-nav-btn text-dark border-0 bg-white" data-bs-toggle="modal" data-bs-target="#modalEditSoalMobile" title="Edit Metadata">
            <span class="material-symbols-outlined text-secondary" style="font-size: 20px;">edit</span>
        </button>
    </header>
@endsection

@section('content')
<div class="mobile-soal-show-shell mb-4">

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
                            <span class="badge bg-light text-primary border" style="font-size: 0.68rem;">
                                {{ $k['level_kognitif'] ?? 'C3' }}
                            </span>
                        </div>
                        <span class="badge bg-light text-dark border" style="font-size: 0.68rem;">
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
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5 fw-bold" style="font-size: 0.74rem;">
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
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.7rem;">Skor Maks: {{ $es['skor_maksimal'] ?? 10 }}</span>
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

<!-- MODAL EDIT METADATA (MOBILE) -->
<div class="modal fade" id="modalEditSoalMobile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('paket-soal.update', $paketSoal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">Edit Informasi Naskah</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Judul Naskah Asesmen</label>
                        <input type="text" name="judul" class="form-control rounded-3" value="{{ $paketSoal->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Alokasi Waktu (Menit)</label>
                        <input type="number" name="alokasi_waktu_menit" class="form-control rounded-3" value="{{ $paketSoal->alokasi_waktu_menit }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-secondary">Petunjuk Umum</label>
                        <textarea name="petunjuk_umum" class="form-control rounded-3" rows="3">{{ $paketSoal->petunjuk_umum }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.mobile-soal-show-shell {
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
.btn-mobile-hero-export {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.15s ease;
}
.btn-mobile-hero-export:hover,
.btn-mobile-hero-export:active {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}
.mobile-subtab-chip {
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 600;
    background: #ffffff;
    color: #64748b;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
}
.mobile-subtab-chip.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.mobile-kisi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.1rem;
    padding: 14px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
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
.mobile-soal-show-dock {
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
@endpush

@push('scripts')
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
@endpush
