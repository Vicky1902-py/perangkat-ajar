@extends('layouts.mobile')

@section('title', 'Tujuan Pembelajaran (TP)')

@section('header')
    <!-- Mobile Header Bar -->
    <header class="d-flex justify-content-between align-items-center mb-3 pt-1">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="mobile-nav-circle-btn text-dark text-decoration-none" title="Kembali ke Dashboard">
            <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
        </a>
        <div class="text-center">
            <h1 class="mobile-section-h1 mb-0">Tujuan Pembelajaran (TP)</h1>
            <span class="mobile-section-eyebrow">Penurunan Capaian Pembelajaran</span>
        </div>
        <a href="{{ route('generator.index') }}" class="mobile-nav-circle-btn text-primary text-decoration-none" title="Generate 1-Klik">
            <span class="material-symbols-outlined fill-icon" style="font-size: 20px;">auto_awesome</span>
        </a>
    </header>
@endsection

@section('content')
<div class="mobile-card-shell mb-4">
    @if($tps->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 border p-4 shadow-xs">
            <span class="material-symbols-outlined text-secondary opacity-50 mb-2" style="font-size: 36px;">track_changes</span>
            <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Belum Ada TP</h5>
            <p class="text-secondary small mb-3">Gunakan Generator 1-Klik untuk menurunkan TP otomatis dari CP.</p>
            <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                <span class="material-symbols-outlined fill-icon" style="font-size: 17px;">bolt</span>
                <span>Generate Sekarang</span>
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-2.5">
            @foreach($tps as $tp)
                <div class="mobile-item-card">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <div>
                            <span class="badge bg-primary text-white fw-bold rounded-pill px-2 py-0.5" style="font-size: 0.72rem;">
                                {{ $tp->kode_tp }}
                            </span>
                            <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5 ms-1" style="font-size: 0.68rem;">
                                Fase {{ $tp->capaianPembelajaran->fase->kode ?? '-' }}
                            </span>
                        </div>
                        @if($tp->elemen)
                            <span class="badge bg-info bg-opacity-10 text-dark border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                {{ Str::limit($tp->elemen, 16) }}
                            </span>
                        @endif
                    </div>
                    <div class="small fw-semibold text-primary mb-1" style="font-size: 0.76rem;">
                        {{ $tp->capaianPembelajaran->mataPelajaran->nama ?? '-' }}
                    </div>
                    <p class="small text-dark mb-2" style="font-size: 0.82rem; line-height: 1.4;">
                        {{ $tp->deskripsi_tp }}
                    </p>
                    @if($tp->konten_pengetahuan)
                        <div class="bg-light p-2 rounded-3 border mb-2 text-secondary" style="font-size: 0.72rem;">
                            <strong>Materi:</strong> {{ Str::limit($tp->konten_pengetahuan, 100) }}
                        </div>
                    @endif
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top border-slate-100">
                        <span class="text-muted small" style="font-size: 0.72rem;">{{ $tp->user->name ?? '-' }}</span>
                        @if(auth()->user()->isSuperAdmin() || auth()->id() == $tp->user_id)
                            <form action="{{ route('tp.destroy', $tp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus TP ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mobile-icon-action-btn text-secondary border-0 bg-transparent" title="Hapus">
                                    <span class="material-symbols-outlined" style="font-size: 17px;">delete</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
