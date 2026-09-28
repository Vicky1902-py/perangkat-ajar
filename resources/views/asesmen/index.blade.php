@extends('layouts.app')

@section('title', 'Instrumen Asesmen')

@section('content')
<!-- ============================================================ -->
<!-- MOBILE VIEW: ANDROID NATIVE CARD FEED (STITCH)              -->
<!-- ============================================================ -->
<div class="d-block d-md-none mobile-card-shell mb-4">
    <!-- Mobile Header Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="mobile-nav-circle-btn text-dark text-decoration-none" title="Kembali ke Dashboard">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-section-h1 mb-0">Arsip Asesmen &amp; Rubrik</h1>
            <span class="mobile-section-eyebrow">Diagnostik, Formatif &bull; Sumatif</span>
        </div>
        <a href="{{ route('generator.index') }}" class="mobile-nav-circle-btn text-primary text-decoration-none" title="Generate 1-Klik">
            <span class="material-symbols-outlined fill-icon" style="font-size: 20px;">auto_awesome</span>
        </a>
    </div>

    @if($asesmens->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border p-4 shadow-xs">
            <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">checklist</span>
            <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada Instrumen Asesmen</h5>
            <p class="text-secondary small mb-3">Buat instrumen asesmen dan KKTP 4 level secara otomatis.</p>
            <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                <span class="material-symbols-outlined fill-icon" style="font-size: 17px;">bolt</span>
                <span>Generate Sekarang</span>
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-2.5">
            @foreach($asesmens as $a)
                <div class="mobile-item-card">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                Fase {{ $a->fase->kode ?? '-' }}
                            </span>
                            <span class="text-secondary small ms-1" style="font-size: 0.72rem;">
                                {{ $a->mataPelajaran->nama ?? '-' }}
                            </span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                            KKTP 4 Level
                        </span>
                    </div>
                    <h3 class="mobile-item-title mb-1.5">
                        {{ $a->judul }}
                    </h3>
                    <div class="d-flex align-items-center gap-2 text-secondary mb-3" style="font-size: 0.72rem;">
                        <span>Formatif &amp; Sumatif</span>
                        <span>&bull;</span>
                        <span>{{ $a->user->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top border-slate-100">
                        <a href="{{ route('asesmen.show', $a->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 mobile-card-btn fw-bold">
                            <span class="material-symbols-outlined me-1" style="font-size: 14px;">visibility</span> Buka
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('export.asesmen.pdf', $a->id) }}" class="mobile-icon-action-btn text-danger" title="Ekspor PDF" target="_blank">
                                <span class="material-symbols-outlined" style="font-size: 17px;">picture_as_pdf</span>
                            </a>
                            <a href="{{ route('export.asesmen.docx', $a->id) }}" class="mobile-icon-action-btn text-primary" title="Ekspor Word">
                                <span class="material-symbols-outlined" style="font-size: 17px;">description</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- DESKTOP VIEW: TAMPILAN LENGKAP PC & LAPTOP (TIDAK BERUBAH)   -->
<!-- ============================================================ -->
<div class="d-none d-md-block">
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-check2-square text-success me-2"></i> Instrumen Asesmen</h4>
        <p class="text-muted small mb-0">Penilaian Diagnostik (Awal), Formatif (Proses), dan Sumatif (Akhir) berbasis 8 Dimensi Profil Lulusan.</p>
    </div>
    <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
        <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($asesmens->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-check2-circle fs-1 text-secondary opacity-50 mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada Instrumen Asesmen</h5>
                <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat Instrumen Asesmen lengkap.</p>
                <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Generate Sekarang
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="table-light">
                        <tr>
                            <th width="4%">No</th>
                            <th>Judul Asesmen</th>
                            <th>Jenis & KKTP</th>
                            <th>Mata Pelajaran</th>
                            <th>Fase</th>
                            <th>Penyusun</th>
                            <th width="18%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asesmens as $idx => $a)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <a href="{{ route('asesmen.show', $a->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $a->judul }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Formatif & Sumatif</span>
                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning">KKTP 4 Level</span>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $a->mataPelajaran->nama ?? '-' }}</span></td>
                                <td><span class="badge bg-primary">Fase {{ $a->fase->kode ?? '-' }}</span></td>
                                <td><small class="text-secondary">{{ $a->user->name ?? '-' }}</small></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('asesmen.show', $a->id) }}" class="btn btn-outline-primary" title="Lihat Detail & KKTP">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('export.asesmen.pdf', $a->id) }}" class="btn btn-outline-danger" title="Unduh PDF" target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        <a href="{{ route('export.asesmen.docx', $a->id) }}" class="btn btn-outline-primary" title="Unduh Word">
                                            <i class="bi bi-file-earmark-word"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</div> <!-- /d-none d-md-block (DESKTOP) -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>
@endpush
