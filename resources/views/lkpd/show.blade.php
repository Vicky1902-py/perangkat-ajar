@extends('layouts.app')

@section('title', 'Detail LKPD - ' . $lkpd->judul)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <a href="{{ route('lkpd.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-block">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar LKPD
        </a>
        <h4 class="fw-bold text-dark mb-0">{{ $lkpd->judul }}</h4>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <div class="dropdown">
            <button class="btn btn-danger btn-sm rounded-pill px-3 dropdown-toggle d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Ukuran Kertas</h6></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.lkpd.pdf', $lkpd->id) }}?paper=a4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span> <span class="badge bg-light text-muted border ms-2">210x297 mm</span></a></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.lkpd.pdf', $lkpd->id) }}?paper=f4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span> <span class="badge bg-light text-muted border ms-2">215x330 mm</span></a></li>
            </ul>
        </div>
        <a href="{{ route('export.lkpd.docx', $lkpd->id) }}" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-file-earmark-word me-1"></i> Unduh Word (DOCX)
        </a>
    </div>
</div>

<!-- INFORMASI UMUM LKPD -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="text-muted small">Mata Pelajaran</div>
                <div class="fw-semibold text-dark">{{ $lkpd->mataPelajaran->nama ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Fase / Kelas</div>
                <div class="fw-semibold text-dark">Fase {{ $lkpd->fase->kode ?? '-' }} ({{ $lkpd->fase->kelas_range ?? '-' }})</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Satuan Pendidikan</div>
                <div class="fw-semibold text-dark">{{ $lkpd->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Alokasi Waktu</div>
                <div class="fw-semibold text-dark">{{ $lkpd->alokasi_waktu_menit ?? 90 }} Menit</div>
            </div>
            <div class="col-12 border-top pt-2 mt-2">
                <div class="text-muted small">Tujuan Pembelajaran:</div>
                <div class="small text-dark fw-medium">{{ $lkpd->tujuan_pembelajaran }}</div>
            </div>
        </div>
    </div>
</div>

<!-- STIMULUS OTENTIK -->
<div class="card border-0 shadow-sm mb-4 border-start border-primary border-4">
    <div class="card-header bg-white py-3">
        <div class="fw-bold text-primary">
            <i class="bi bi-lightbulb-fill text-warning me-2"></i> Stimulus Otentik (Studi Kasus Industri)
        </div>
    </div>
    <div class="card-body p-4 bg-light bg-opacity-50">
        <div class="text-dark small" style="line-height: 1.6;">
            {!! nl2br(e($lkpd->stimulus_otentik)) !!}
        </div>
    </div>
</div>

<!-- PETUNJUK & ALAT BAHAN -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="fw-bold text-dark small mb-1"><i class="bi bi-info-circle text-primary me-1"></i> Petunjuk Belajar:</div>
                <div class="small text-secondary">{!! nl2br(e($lkpd->petunjuk_belajar)) !!}</div>
            </div>
            <div class="col-md-6">
                <div class="fw-bold text-dark small mb-1"><i class="bi bi-tools text-secondary me-1"></i> Alat dan Bahan:</div>
                <div class="small text-secondary">{{ $lkpd->alat_bahan }}</div>
            </div>
        </div>
    </div>
</div>

<!-- TAHAPAN KEGIATAN LKPD -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <div class="fw-bold text-dark">
            <i class="bi bi-list-check text-success me-2"></i> Langkah Kerja Pengalaman Belajar Mendalam
        </div>
    </div>
    <div class="card-body p-4">
        @foreach($lkpd->kegiatans as $keg)
            <div class="p-3 mb-3 rounded-3 border bg-light">
                <div class="fw-bold text-primary mb-2 d-flex align-items-center justify-content-between">
                    <span>Tahap {{ $loop->iteration }}: {{ strtoupper($keg->tahap) }}</span>
                    <span class="badge bg-white text-secondary border">Aktivitas Siswa</span>
                </div>
                <div class="small text-dark mb-2"><strong>Instruksi:</strong> {{ $keg->instruksi }}</div>
                <div class="small text-dark mb-3"><strong>Tugas / Pertanyaan:</strong> {{ $keg->pertanyaan }}</div>
                <div class="p-3 bg-white rounded border text-muted small" style="min-height: 70px;">
                    <em>Ruang Jawaban: {{ $keg->ruang_jawaban }}</em>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
