@extends('layouts.mobile')

@section('title', 'Arsip Lembar Kerja Murid (LKPD)')

@section('header')
    <!-- Mobile Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="mobile-nav-circle-btn text-dark text-decoration-none" title="Kembali ke Dashboard">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-section-h1 mb-0">Arsip Lembar Kerja (LKPD)</h1>
            <span class="mobile-section-eyebrow">Stimulus Industri Otentik</span>
        </div>
        <a href="{{ route('generator.index') }}" class="mobile-nav-circle-btn text-primary text-decoration-none" title="Generate 1-Klik">
            <span class="material-symbols-outlined fill-icon" style="font-size: 20px;">auto_awesome</span>
        </a>
    </header>
@endsection

@section('content')
<div class="mobile-card-shell mb-4">
    @if($lkpds->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border p-4 shadow-xs">
            <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">assignment</span>
            <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada LKPD</h5>
            <p class="text-secondary small mb-3">Buat LKPD proyek mendalam secara otomatis.</p>
            <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                <span class="material-symbols-outlined fill-icon" style="font-size: 17px;">bolt</span>
                <span>Generate Sekarang</span>
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-2.5">
            @foreach($lkpds as $lkpd)
                <div class="mobile-item-card">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                Fase {{ $lkpd->fase->kode ?? '-' }}
                            </span>
                            <span class="text-secondary small ms-1" style="font-size: 0.72rem;">
                                {{ $lkpd->mataPelajaran->nama ?? '-' }}
                            </span>
                        </div>
                        <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5 font-monospace" style="font-size: 0.68rem;">
                            {{ $lkpd->alokasi_waktu_menit ?? 90 }} Mnt
                        </span>
                    </div>
                    <h3 class="mobile-item-title mb-1.5">
                        {{ $lkpd->judul }}
                    </h3>
                    <div class="d-flex align-items-center gap-2 text-secondary mb-3" style="font-size: 0.72rem;">
                        <span>{{ $lkpd->kegiatans->count() }} Tahap Belajar</span>
                        <span>&bull;</span>
                        <span>{{ $lkpd->user->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top border-slate-100">
                        <a href="{{ route('lkpd.show', $lkpd->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 mobile-card-btn fw-bold">
                            <span class="material-symbols-outlined me-1" style="font-size: 14px;">visibility</span> Buka
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('export.lkpd.pdf', $lkpd->id) }}" class="mobile-icon-action-btn text-danger" title="Ekspor PDF">
                                <span class="material-symbols-outlined" style="font-size: 17px;">picture_as_pdf</span>
                            </a>
                            <a href="{{ route('export.lkpd.docx', $lkpd->id) }}" class="mobile-icon-action-btn text-primary" title="Ekspor Word">
                                <span class="material-symbols-outlined" style="font-size: 17px;">description</span>
                            </a>
                            @if(auth()->user()->isSuperAdmin() || auth()->id() == $lkpd->user_id)
                                <form action="{{ route('lkpd.destroy', $lkpd->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen LKPD ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mobile-icon-action-btn text-secondary border-0 bg-transparent" title="Hapus">
                                        <span class="material-symbols-outlined" style="font-size: 17px;">delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
