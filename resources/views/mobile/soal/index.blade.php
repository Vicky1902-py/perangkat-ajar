@extends('layouts.mobile')

@section('title', 'Smart Soal - Bank Soal & Kisi-Kisi Ujian')

@section('header')
    <!-- 1. Mobile Top Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="mobile-soal-nav-btn text-dark text-decoration-none" title="Kembali ke Beranda">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-soal-title mb-0">Smart Soal &amp; Kisi-Kisi</h1>
            <span class="mobile-soal-eyebrow">BSKAP 046/2025</span>
        </div>
        <button type="button" class="mobile-soal-nav-btn text-dark border-0 bg-white" onclick="showSmartSoalGuide(); return false;" title="Panduan Smart Soal">
            <span class="material-symbols-outlined text-primary" style="font-size: 20px;">help</span>
        </button>
    </header>
@endsection

@section('content')
<div class="mobile-soal-shell mb-4">
    <!-- 2. Calm Hero Showcase Card (No garish rainbow colors, sleek dark navy/slate) -->
    <section class="mobile-soal-hero-card mb-3.5 position-relative overflow-hidden">
        <div class="mobile-soal-hero-ambient"></div>
        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex justify-content-between align-items-center mb-2.5">
                <span class="badge bg-white bg-opacity-15 text-white border border-white border-opacity-25 rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.68rem;">
                    <span class="material-symbols-outlined align-middle me-0.5" style="font-size: 13px;">verified</span> Sistem Pakar
                </span>
                <span class="text-white text-opacity-75 small font-monospace" style="font-size: 0.72rem;">
                    {{ $paketSoals->total() }} Paket
                </span>
            </div>
            <h2 class="text-white fw-bold mb-1" style="font-size: 1.15rem; line-height: 1.3;">
                Generator Kisi-Kisi &amp; Bank Soal
            </h2>
            <p class="text-white text-opacity-75 small mb-3" style="font-size: 0.78rem; line-height: 1.45;">
                Penyusunan naskah asesmen otomatis dari kisi-kisi ke butir soal (PG &amp; Isian) tersinkronisasi kurikulum.
            </p>
            <a href="{{ route('paket-soal.create') }}" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.85rem; background: #ffffff; color: #0f172a; border: none;">
                <span class="material-symbols-outlined text-primary" style="font-size: 18px;">add_circle</span>
                <span>Buat Paket Soal Baru</span>
            </a>
        </div>
    </section>

    <!-- 3. Compact 2x2 Stats Grid -->
    <section class="row g-2 mb-3.5">
        <div class="col-6">
            <div class="mobile-stat-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="mobile-stat-label">Total Paket</span>
                    <span class="material-symbols-outlined text-secondary" style="font-size: 18px;">folder</span>
                </div>
                <div class="mobile-stat-value text-dark">{{ $paketSoals->total() }}</div>
                <div class="mobile-stat-desc">Tersimpan di arsip</div>
            </div>
        </div>

        <div class="col-6">
            <div class="mobile-stat-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="mobile-stat-label">Pilihan Ganda</span>
                    <span class="material-symbols-outlined text-secondary" style="font-size: 18px;">checklist</span>
                </div>
                <div class="mobile-stat-value text-dark">{{ $paketSoals->sum('total_soal_pg') }}</div>
                <div class="mobile-stat-desc">Butir opsi A-E &amp; kunci</div>
            </div>
        </div>

        <div class="col-6">
            <div class="mobile-stat-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="mobile-stat-label">Isian &amp; Uraian</span>
                    <span class="material-symbols-outlined text-secondary" style="font-size: 18px;">edit_note</span>
                </div>
                <div class="mobile-stat-value text-dark">{{ $paketSoals->sum('total_soal_isian') }}</div>
                <div class="mobile-stat-desc">Rubrik studi kasus</div>
            </div>
        </div>

        <div class="col-6">
            <div class="mobile-stat-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="mobile-stat-label">Standar Kisi</span>
                    <span class="material-symbols-outlined text-secondary" style="font-size: 18px;">verified_user</span>
                </div>
                <div class="mobile-stat-value text-dark" style="font-size: 1.05rem;">BSKAP 046</div>
                <div class="mobile-stat-desc">Taksonomi Bloom</div>
            </div>
        </div>
    </section>

    <!-- 4. Quick Search & Filter Bar -->
    <section class="mb-3.5">
        <form method="GET" action="{{ route('paket-soal.index') }}">
            <div class="mobile-soal-search-box mb-2">
                <span class="material-symbols-outlined text-secondary me-2" style="font-size: 20px;">search</span>
                <input type="text" name="search" class="mobile-soal-search-input" placeholder="Cari judul soal atau mapel..." value="{{ request('search') }}">
                @if(request('search'))
                    <a href="{{ route('paket-soal.index') }}" class="text-secondary text-decoration-none">
                        <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                    </a>
                @endif
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex gap-1.5 overflow-x-auto pb-1 no-scrollbar" style="white-space: nowrap;">
                <a href="{{ route('paket-soal.index', array_merge(request()->except('bentuk_soal', 'page'))) }}" 
                   class="mobile-filter-chip {{ !request('bentuk_soal') ? 'active' : '' }}">
                    Semua ({{ $paketSoals->total() }})
                </a>
                <a href="{{ route('paket-soal.index', array_merge(request()->except('page'), ['bentuk_soal' => 'campuran'])) }}" 
                   class="mobile-filter-chip {{ request('bentuk_soal') === 'campuran' ? 'active' : '' }}">
                    Campuran
                </a>
                <a href="{{ route('paket-soal.index', array_merge(request()->except('page'), ['bentuk_soal' => 'pg'])) }}" 
                   class="mobile-filter-chip {{ request('bentuk_soal') === 'pg' ? 'active' : '' }}">
                    Pilihan Ganda
                </a>
                <a href="{{ route('paket-soal.index', array_merge(request()->except('page'), ['bentuk_soal' => 'isian'])) }}" 
                   class="mobile-filter-chip {{ request('bentuk_soal') === 'isian' ? 'active' : '' }}">
                    Isian
                </a>
            </div>
        </form>
    </section>

    <!-- 5. Feed of Paket Soal Cards -->
    <section class="d-flex flex-column gap-2.5 mb-4">
        @if($paketSoals->isEmpty())
            <div class="mobile-empty-soal-card text-center py-4">
                <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">quiz</span>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada Paket Soal</h5>
                <p class="text-secondary small mb-3" style="font-size: 0.78rem;">
                    Buat kisi-kisi dan naskah soal otomatis tersinkronisasi kurikulum.
                </p>
                <a href="{{ route('paket-soal.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                    + Buat Paket Baru
                </a>
            </div>
        @else
            @foreach($paketSoals as $item)
                <div class="mobile-soal-card">
                    <!-- Top Row: Badge & Date -->
                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                        <span class="mobile-tag-pill">
                            {{ $item->jenis_ujian_label }}
                        </span>
                        <span class="text-secondary small font-monospace" style="font-size: 0.7rem;">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <a href="{{ route('paket-soal.show', $item->id) }}" class="mobile-soal-card-title text-decoration-none d-block mb-1">
                        {{ $item->judul }}
                    </a>

                    <!-- Mapel & Meta -->
                    <div class="d-flex align-items-center gap-1.5 text-secondary mb-2.5" style="font-size: 0.74rem;">
                        <span class="text-truncate fw-semibold text-dark" style="max-width: 160px;">
                            {{ $item->mataPelajaran->nama ?? 'Kejuruan SMK' }}
                        </span>
                        <span>&bull;</span>
                        <span>Fase {{ $item->fase->kode ?? 'E' }}</span>
                        <span>&bull;</span>
                        <span>{{ $item->alokasi_waktu_menit }}m</span>
                    </div>

                    <!-- Question Counts Pill Bar -->
                    <div class="d-flex align-items-center gap-1.5 mb-3 flex-wrap">
                        @if($item->total_soal_pg > 0)
                            <span class="mobile-count-badge bg-blue-subtle text-primary">
                                <span class="material-symbols-outlined align-middle" style="font-size: 13px;">checklist</span>
                                <span>{{ $item->total_soal_pg }} PG</span>
                            </span>
                        @endif
                        @if($item->total_soal_isian > 0)
                            <span class="mobile-count-badge bg-slate-subtle text-dark">
                                <span class="material-symbols-outlined align-middle" style="font-size: 13px;">edit_note</span>
                                <span>{{ $item->total_soal_isian }} Isian</span>
                            </span>
                        @endif
                        <span class="small text-secondary ms-auto" style="font-size: 0.72rem;">
                            Total <strong>{{ $item->total_soal }}</strong> butir
                        </span>
                    </div>

                    <!-- Action Buttons Row -->
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top border-slate-100">
                        <a href="{{ route('paket-soal.show', $item->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 mobile-card-btn fw-bold">
                            <span class="material-symbols-outlined me-1" style="font-size: 14px;">visibility</span> Buka
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('export.soal.siswa.pdf', $item->id) }}" class="mobile-icon-action-btn" title="PDF Siswa">
                                <span class="material-symbols-outlined" style="font-size: 17px;">person</span>
                            </a>
                            <a href="{{ route('export.soal.guru.pdf', $item->id) }}" class="mobile-icon-action-btn text-danger" title="PDF Guru">
                                <span class="material-symbols-outlined" style="font-size: 17px;">picture_as_pdf</span>
                            </a>
                            <a href="{{ route('export.soal.docx', $item->id) }}" class="mobile-icon-action-btn text-primary" title="Word DOCX">
                                <span class="material-symbols-outlined" style="font-size: 17px;">description</span>
                            </a>
                            <form action="{{ route('paket-soal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket soal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mobile-icon-action-btn text-secondary border-0 bg-transparent" title="Hapus">
                                    <span class="material-symbols-outlined" style="font-size: 17px;">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    @if($paketSoals->hasPages())
        <div class="d-flex justify-content-center mb-4">
            {{ $paketSoals->links() }}
        </div>
    @endif
</div>

<!-- POPUP SELAMAT DATANG DI SMART SOAL BY. VICKY -->
@include('soal.partials.welcome-modal')
@endsection

@push('styles')
<style>
.mobile-soal-shell {
    font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
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
.mobile-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 12px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.mobile-stat-label {
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.mobile-stat-value {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.3rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 2px;
}
.mobile-stat-desc {
    font-size: 10px;
    color: #94a3b8;
    line-height: 1.2;
}
.mobile-soal-search-box {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 8px 14px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.mobile-soal-search-input {
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
    width: 100%;
    color: #0f172a;
}
.mobile-filter-chip {
    padding: 5px 12px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
    background: #ffffff;
    color: #64748b;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.15s ease;
}
.mobile-filter-chip.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.mobile-soal-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.1rem;
    padding: 14px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
.mobile-empty-soal-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 24px 16px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
.mobile-tag-pill {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 9999px;
    background: #f1f5f9;
    color: #334155;
}
.mobile-soal-card-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
}
.mobile-count-badge {
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}
.bg-blue-subtle { background-color: #eff6ff; }
.bg-slate-subtle { background-color: #f8fafc; }
.mobile-icon-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    text-decoration: none;
}
.mobile-card-btn {
    font-size: 12px;
    display: inline-flex;
    align-items: center;
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endpush
