@extends('layouts.app')

@section('title', 'Detail Program Tahunan (Prota) - ' . ($prota->mataPelajaran->nama ?? ''))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <a href="{{ route('prota-promes.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Prota & Promes
        </a>
        <h4 class="fw-bold text-dark mb-1">{{ $prota->judul }}</h4>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                <i class="bi bi-file-earmark-check me-1"></i>Permendikdasmen No. 13/2025 &bull; BSKAP 046/H/KR/2025
            </span>
            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                <i class="bi bi-calendar-check me-1"></i>Tahun Ajaran: {{ $prota->tahunAjaran->nama ?? '2026/2027' }}
            </span>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <div class="dropdown">
            <button class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm dropdown-toggle d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf"></i> <span>Unduh PDF</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Ukuran Kertas</h6></li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.prota.pdf', $prota->id) }}?paper=a4">
                        <span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span>
                        <span class="badge bg-light text-muted border ms-2">210x297 mm</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.prota.pdf', $prota->id) }}?paper=f4">
                        <span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span>
                        <span class="badge bg-light text-muted border ms-2">215x330 mm</span>
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{ route('export.prota.excel', $prota->id) }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-excel"></i> <span>Unduh Excel</span>
        </a>
        <a href="{{ route('export.prota.docx', $prota->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-word"></i> <span>Unduh Word</span>
        </a>
    </div>
</div>

<!-- INFORMASI PROTA -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Satuan Pendidikan</div>
                <div class="fw-semibold text-dark text-truncate">{{ $prota->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Mata Pelajaran</div>
                <div class="fw-semibold text-dark text-truncate">{{ $prota->mataPelajaran->nama ?? '-' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Fase / Kelas</div>
                <div class="fw-semibold text-dark">Fase {{ $prota->fase->kode ?? '-' }} ({{ $prota->fase->kelas_range ?? '-' }})</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Tahun Ajaran</div>
                <div class="fw-semibold text-dark">{{ $prota->tahunAjaran->nama ?? '2026/2027' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Penyusun</div>
                <div class="fw-semibold text-dark text-truncate">{{ $prota->user->name ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

@php
    $items = $prota->data_json ?? [];
    $totalJp = 0;
    foreach ($items as $it) {
        $totalJp += (int)($it['alokasi_jp'] ?? 12);
    }
@endphp

<!-- TABEL DISTRIBUSI ALOKASI PROGRAM TAHUNAN -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <div class="fw-bold text-dark fs-6">
            <i class="bi bi-table text-primary me-2"></i> Rincian Program Tahunan (Prota)
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2 fs-7">Total: {{ $totalJp }} JP</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="12%" class="text-center">Semester</th>
                        <th width="20%">Elemen CP / Materi Pokok</th>
                        <th width="10%" class="text-center">Kode TP</th>
                        <th width="42%">Tujuan Pembelajaran (TP)</th>
                        <th width="12%" class="text-center">Alokasi Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $idx => $d)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">
                                    Semester {{ $d['semester'] ?? ( ($idx < count($items)/2) ? 1 : 2 ) }}
                                </span>
                            </td>
                            <td><strong>{{ $d['elemen'] ?? ($prota->mataPelajaran->nama ?? 'Kompetensi') }}</strong></td>
                            <td class="text-center"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $d['kode_tp'] ?? '-' }}</span></td>
                            <td>{{ $d['tujuan_pembelajaran'] ?? '-' }}</td>
                            <td class="text-center fw-bold">{{ $d['alokasi_jp'] ?? 12 }} JP</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada rincian data pada Program Tahunan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">TOTAL ALOKASI WAKTU TAHUNAN:</th>
                        <th class="text-center text-primary fs-6">{{ $totalJp }} JP</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
