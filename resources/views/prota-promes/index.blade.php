@extends('layouts.app')

@section('title', 'Program Tahunan (Prota) & Program Semester (Promes)')

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
            <h1 class="mobile-section-h1 mb-0">Arsip Prota &amp; Promes</h1>
            <span class="mobile-section-eyebrow">Program Tahunan &bull; Semester</span>
        </div>
        <a href="{{ route('generator.index') }}" class="mobile-nav-circle-btn text-primary text-decoration-none" title="Generate 1-Klik">
            <span class="material-symbols-outlined fill-icon" style="font-size: 20px;">auto_awesome</span>
        </a>
    </div>

    <!-- Segment Switcher -->
    <div class="d-flex gap-2 mb-3 bg-white p-1 rounded-pill border shadow-xs">
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 fw-bold {{ request('tab') == 'promes' ? 'btn-light text-secondary' : 'btn-dark' }}" onclick="$('#mobTabProta').show(); $('#mobTabPromes').hide(); $(this).removeClass('btn-light text-secondary').addClass('btn-dark'); $(this).siblings().removeClass('btn-dark').addClass('btn-light text-secondary');" style="font-size: 0.76rem;">
            Prota ({{ $protas->count() }})
        </button>
        <button type="button" class="btn btn-sm rounded-pill flex-grow-1 fw-bold {{ request('tab') == 'promes' ? 'btn-dark' : 'btn-light text-secondary' }}" onclick="$('#mobTabPromes').show(); $('#mobTabProta').hide(); $(this).removeClass('btn-light text-secondary').addClass('btn-dark'); $(this).siblings().removeClass('btn-dark').addClass('btn-light text-secondary');" style="font-size: 0.76rem;">
            Promes ({{ $promeses->count() }})
        </button>
    </div>

    <!-- Mobile Prota Feed -->
    <div id="mobTabProta" class="d-flex flex-column gap-2.5" style="{{ request('tab') == 'promes' ? 'display:none;' : '' }}">
        @if($protas->isEmpty())
            <div class="text-center py-5 bg-white rounded-4 border p-4 shadow-xs">
                <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">calendar_month</span>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada Prota</h5>
                <p class="text-secondary small mb-3">Buat Program Tahunan secara otomatis.</p>
                <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                    <span class="material-symbols-outlined fill-icon" style="font-size: 17px;">bolt</span>
                    <span>Generate Sekarang</span>
                </a>
            </div>
        @else
            @foreach($protas as $prota)
                <div class="mobile-item-card">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                Fase {{ $prota->fase->kode ?? '-' }}
                            </span>
                            <span class="text-secondary small ms-1" style="font-size: 0.72rem;">
                                {{ $prota->mataPelajaran->nama ?? '-' }}
                            </span>
                        </div>
                        <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5 font-monospace" style="font-size: 0.68rem;">
                            Prota
                        </span>
                    </div>
                    <h3 class="mobile-item-title mb-1.5">
                        {{ $prota->judul }}
                    </h3>
                    <div class="d-flex align-items-center gap-2 text-secondary mb-3" style="font-size: 0.72rem;">
                        <span>TA: {{ $prota->tahunAjaran->nama ?? '2026/2027' }}</span>
                        <span>&bull;</span>
                        <span>{{ $prota->user->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top border-slate-100">
                        <a href="{{ route('prota.show', $prota->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 mobile-card-btn fw-bold">
                            <span class="material-symbols-outlined me-1" style="font-size: 14px;">visibility</span> Buka
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('export.prota.pdf', $prota->id) }}?paper=a4" class="mobile-icon-action-btn text-danger" title="Ekspor PDF">
                                <span class="material-symbols-outlined" style="font-size: 17px;">picture_as_pdf</span>
                            </a>
                            <a href="{{ route('export.prota.docx', $prota->id) }}" class="mobile-icon-action-btn text-primary" title="Ekspor Word">
                                <span class="material-symbols-outlined" style="font-size: 17px;">description</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Mobile Promes Feed -->
    <div id="mobTabPromes" class="d-flex flex-column gap-2.5" style="{{ request('tab') == 'promes' ? '' : 'display:none;' }}">
        @if($promeses->isEmpty())
            <div class="text-center py-5 bg-white rounded-4 border p-4 shadow-xs">
                <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">calendar_month</span>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada Promes</h5>
                <p class="text-secondary small mb-3">Buat Program Semester secara otomatis.</p>
                <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                    <span class="material-symbols-outlined fill-icon" style="font-size: 17px;">bolt</span>
                    <span>Generate Sekarang</span>
                </a>
            </div>
        @else
            @foreach($promeses as $promes)
                <div class="mobile-item-card">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                Fase {{ $promes->fase->kode ?? '-' }}
                            </span>
                            <span class="text-secondary small ms-1" style="font-size: 0.72rem;">
                                {{ $promes->mataPelajaran->nama ?? '-' }}
                            </span>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-dark border rounded-pill px-2 py-0.5 font-monospace" style="font-size: 0.68rem;">
                            Semester {{ $promes->semester }}
                        </span>
                    </div>
                    <h3 class="mobile-item-title mb-1.5">
                        {{ $promes->judul }}
                    </h3>
                    <div class="d-flex align-items-center gap-2 text-secondary mb-3" style="font-size: 0.72rem;">
                        <span>Program Semester</span>
                        <span>&bull;</span>
                        <span>{{ $promes->user->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top border-slate-100">
                        <a href="{{ route('promes.show', $promes->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 mobile-card-btn fw-bold">
                            <span class="material-symbols-outlined me-1" style="font-size: 14px;">visibility</span> Buka
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('export.promes.pdf', $promes->id) }}?paper=a4" class="mobile-icon-action-btn text-danger" title="Ekspor PDF">
                                <span class="material-symbols-outlined" style="font-size: 17px;">picture_as_pdf</span>
                            </a>
                            <a href="{{ route('export.promes.docx', $promes->id) }}" class="mobile-icon-action-btn text-primary" title="Ekspor Word">
                                <span class="material-symbols-outlined" style="font-size: 17px;">description</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- ============================================================ -->
<!-- DESKTOP VIEW: TAMPILAN LENGKAP PC & LAPTOP (TIDAK BERUBAH)   -->
<!-- ============================================================ -->
<div class="d-none d-md-block">
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-calendar-range text-secondary me-2"></i> Program Tahunan & Program Semester</h4>
        <p class="text-muted small mb-0">Distribusi alokasi waktu capaian dan tujuan pembelajaran per semester serta per minggu efektif.</p>
    </div>
    <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
        <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
    </a>
</div>

<!-- TABS UNTUK PROTA DAN PROMES -->
<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4" id="pills-prota-tab" data-bs-toggle="pill" data-bs-target="#pills-prota" type="button" role="tab">
            <i class="bi bi-calendar-check me-1"></i> Program Tahunan (Prota)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4" id="pills-promes-tab" data-bs-toggle="pill" data-bs-target="#pills-promes" type="button" role="tab">
            <i class="bi bi-calendar-week me-1"></i> Program Semester (Promes)
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <!-- TAB PROTA -->
    <div class="tab-pane fade show active" id="pills-prota" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($protas->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-1 text-secondary opacity-50 mb-2"></i>
                        <h5 class="fw-bold text-dark">Belum Ada Program Tahunan</h5>
                        <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat Prota dan Promes secara instan.</p>
                        <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Generate Sekarang
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Program Tahunan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Fase</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Penyusun</th>
                                    <th class="text-center" width="24%">Aksi & Unduh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($protas as $idx => $prota)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ $prota->judul }}</strong></td>
                                        <td><span class="badge bg-light text-dark border">{{ $prota->mataPelajaran->nama ?? '-' }}</span></td>
                                        <td><span class="badge bg-primary">Fase {{ $prota->fase->kode ?? '-' }}</span></td>
                                        <td>{{ $prota->tahunAjaran->nama ?? '2026/2027' }}</td>
                                        <td><small class="text-secondary">{{ $prota->user->name ?? '-' }}</small></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                                <a href="{{ route('prota.show', $prota->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" title="Lihat Detail Prota">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                                        <li><a class="dropdown-item py-1 small" href="{{ route('export.prota.pdf', $prota->id) }}?paper=a4"><i class="bi bi-file-text text-danger me-2"></i> PDF (A4 Standar)</a></li>
                                                        <li><a class="dropdown-item py-1 small" href="{{ route('export.prota.pdf', $prota->id) }}?paper=f4"><i class="bi bi-file-text text-primary me-2"></i> PDF (F4 / Folio)</a></li>
                                                    </ul>
                                                </div>
                                                <a href="{{ route('export.prota.excel', $prota->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Unduh Excel (.xlsx)">
                                                    <i class="bi bi-file-earmark-excel"></i>
                                                </a>
                                                <a href="{{ route('export.prota.docx', $prota->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Unduh Word (.docx)">
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
    </div>

    <!-- TAB PROMES -->
    <div class="tab-pane fade" id="pills-promes" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($promeses->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-1 text-secondary opacity-50 mb-2"></i>
                        <h5 class="fw-bold text-dark">Belum Ada Program Semester</h5>
                        <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat Promes secara otomatis.</p>
                        <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Generate Sekarang
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Program Semester</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Fase</th>
                                    <th>Semester</th>
                                    <th>Penyusun</th>
                                    <th class="text-center" width="24%">Aksi & Unduh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promeses as $idx => $promes)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ $promes->judul }}</strong></td>
                                        <td><span class="badge bg-light text-dark border">{{ $promes->mataPelajaran->nama ?? '-' }}</span></td>
                                        <td><span class="badge bg-primary">Fase {{ $promes->fase->kode ?? '-' }}</span></td>
                                        <td><span class="badge bg-info text-dark">Semester {{ $promes->semester }}</span></td>
                                        <td><small class="text-secondary">{{ $promes->user->name ?? '-' }}</small></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                                <a href="{{ route('promes.show', $promes->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" title="Lihat Detail Promes">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                                        <li><a class="dropdown-item py-1 small" href="{{ route('export.promes.pdf', $promes->id) }}?paper=a4"><i class="bi bi-file-text text-danger me-2"></i> PDF (A4 Standar)</a></li>
                                                        <li><a class="dropdown-item py-1 small" href="{{ route('export.promes.pdf', $promes->id) }}?paper=f4"><i class="bi bi-file-text text-primary me-2"></i> PDF (F4 / Folio)</a></li>
                                                    </ul>
                                                </div>
                                                <a href="{{ route('export.promes.excel', $promes->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Unduh Excel (.xlsx)">
                                                    <i class="bi bi-file-earmark-excel"></i>
                                                </a>
                                                <a href="{{ route('export.promes.docx', $promes->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Unduh Word (.docx)">
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
    </div>
</div>
</div> <!-- /d-none d-md-block (DESKTOP) -->
@endsection
