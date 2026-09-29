@extends('layouts.mobile')

@section('title', 'Arsip Instrumen Asesmen')

@section('header')
    <!-- Mobile Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
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
    </header>
@endsection

@section('content')
<div class="mobile-card-shell mb-4">
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
@endsection
