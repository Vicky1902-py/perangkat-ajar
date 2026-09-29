@extends('layouts.mobile')

@section('title', 'Arsip Prota & Promes')

@section('header')
    <!-- Mobile Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
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
    </header>
@endsection

@section('content')
<div class="mobile-card-shell mb-4">
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
@endsection
