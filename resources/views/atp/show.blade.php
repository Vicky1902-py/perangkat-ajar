@extends('layouts.app')

@section('title', 'Detail ATP - ' . ($atp->mataPelajaran->nama ?? ''))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <a href="{{ route('atp.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar ATP
        </a>
        <h4 class="fw-bold text-dark mb-1">{{ $atp->judul }}</h4>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                <i class="bi bi-file-earmark-check me-1"></i>{{ $atp->regulasi ?? 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025' }}
            </span>
            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                <i class="bi bi-clock-history me-1"></i>Total: {{ $atp->total_alokasi_jp ?: $atp->atpDetails->sum('alokasi_waktu_jp') }} JP
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
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.atp.pdf', $atp->id) }}?paper=a4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span> <span class="badge bg-light text-muted border ms-2">210x297 mm</span></a></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.atp.pdf', $atp->id) }}?paper=f4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span> <span class="badge bg-light text-muted border ms-2">215x330 mm</span></a></li>
            </ul>
        </div>
        <a href="{{ route('export.atp.excel', $atp->id) }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-excel"></i> <span>Unduh Excel</span>
        </a>
        <a href="{{ route('export.atp.docx', $atp->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-word"></i> <span>Unduh Word</span>
        </a>
    </div>
</div>

<!-- INFORMASI UMUM ATP -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Satuan Pendidikan</div>
                <div class="fw-semibold text-dark text-truncate">{{ $atp->user->satuanPendidikan->nama ?? 'SMK Pusat Keunggulan' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Mata Pelajaran</div>
                <div class="fw-semibold text-dark">{{ $atp->mataPelajaran->nama ?? '-' }}</div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="text-muted small">Fase & Kelas</div>
                <div class="fw-semibold text-dark">Fase {{ $atp->fase->kode ?? '-' }} ({{ $atp->fase->kelas_range ?? '-' }})</div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="text-muted small">Tahun Ajaran</div>
                <div class="fw-semibold text-dark">{{ $atp->tahunAjaran->nama ?? '2025/2026' }}</div>
            </div>
            <div class="col-12 col-sm-4 col-lg-2">
                <div class="text-muted small">Penyusun</div>
                <div class="fw-semibold text-dark text-truncate">{{ $atp->user->name ?? '-' }}</div>
            </div>
        </div>
        @if($atp->deskripsi)
            <hr class="my-3 text-muted opacity-25">
            <div class="text-secondary small" style="line-height: 1.5;">
                <i class="bi bi-info-circle text-primary me-1"></i> {{ $atp->deskripsi }}
            </div>
        @endif
    </div>
</div>

<!-- TABEL ALUR TUJUAN PEMBELAJARAN -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-table text-primary"></i>
            <span>Rangkaian Alur Tujuan Pembelajaran (ATP)</span>
        </div>
        <span class="badge bg-light text-secondary border">Keputusan Kepala BSKAP No. 046/H/KR/2025</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-top mb-0" style="font-size: 0.85rem; min-width: 900px;">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th width="3%">No</th>
                        <th width="7%">Kode TP</th>
                        <th width="12%">Elemen CP</th>
                        <th width="22%">Tujuan Pembelajaran (TP)</th>
                        <th width="14%">Materi Pokok & Topik</th>
                        <th width="14%">Dimensi Profil Lulusan</th>
                        <th width="14%">Alur PEDATTI (Deep Learning)</th>
                        <th width="10%">Rencana Asesmen</th>
                        <th width="4%">Alokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($atp->atpDetails as $idx => $d)
                        <tr>
                            <td class="text-center fw-medium">{{ $idx + 1 }}</td>
                            <td class="text-center fw-bold text-primary">{{ $d->tujuanPembelajaran->kode_tp ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border text-wrap text-start w-100">
                                    {{ $d->tujuanPembelajaran->elemen ?? 'Kompetensi Kejuruan' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-medium text-dark mb-1">{{ $d->tujuanPembelajaran->deskripsi_tp ?? '-' }}</div>
                                @if($d->tujuanPembelajaran && $d->tujuanPembelajaran->indikator_ketercapaian)
                                    <div class="small text-muted p-2 rounded bg-light border mt-1" style="font-size: 0.76rem;">
                                        <strong>IKTP:</strong><br>
                                        {!! nl2br(e($d->tujuanPembelajaran->indikator_ketercapaian)) !!}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $d->materi_topik ?? '-' }}</div>
                                @if($d->sumber_belajar)
                                    <div class="text-xs text-secondary mt-1" style="font-size: 0.72rem;">
                                        <i class="bi bi-book me-1"></i>{{ Str::limit($d->sumber_belajar, 70) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border d-inline-block text-wrap text-start">
                                    {{ $d->dimensi_profil_lulusan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-secondary" style="line-height: 1.4;">{{ $d->kegiatan_pembelajaran ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="small text-secondary" style="line-height: 1.4;">{{ $d->asesmen ?? '-' }}</div>
                            </td>
                            <td class="text-center fw-bold text-success">{{ $d->alokasi_waktu_jp ?? 12 }} JP</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada rincian tujuan pembelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
