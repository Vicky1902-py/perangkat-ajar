@extends('layouts.app')

@section('title', 'Tujuan Pembelajaran (TP)')

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
            <h1 class="mobile-section-h1 mb-0">Tujuan Pembelajaran (TP)</h1>
            <span class="mobile-section-eyebrow">Penurunan Capaian Pembelajaran</span>
        </div>
        <a href="{{ route('generator.index') }}" class="mobile-nav-circle-btn text-primary text-decoration-none" title="Generate 1-Klik">
            <span class="material-symbols-outlined fill-icon" style="font-size: 20px;">auto_awesome</span>
        </a>
    </div>

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

<!-- ============================================================ -->
<!-- DESKTOP VIEW: TAMPILAN LENGKAP PC & LAPTOP (TIDAK BERUBAH)   -->
<!-- ============================================================ -->
<div class="d-none d-md-block">
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-bullseye text-primary me-2"></i> Tujuan Pembelajaran (TP)</h4>
        <p class="text-muted small mb-0">Rumusan tujuan pembelajaran hasil penurunan Capaian Pembelajaran (CP) untuk memastikan kedalaman kompetensi.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($tps->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bullseye fs-1 text-secondary opacity-50 mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada Tujuan Pembelajaran</h5>
                <p class="small text-muted mb-3">Gunakan Generator Sekali Klik untuk menurunkan TP secara otomatis dari CP.</p>
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
                            <th width="8%">Kode TP</th>
                            <th width="16%">Mata Pelajaran & Elemen</th>
                            <th width="32%">Deskripsi Tujuan Pembelajaran</th>
                            <th width="24%">Konten & Indikator (IKTP)</th>
                            <th width="10%">Penyusun</th>
                            <th width="6%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tps as $idx => $tp)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td><span class="badge bg-primary fs-6">{{ $tp->kode_tp }}</span></td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $tp->capaianPembelajaran->mataPelajaran->nama ?? '-' }}</div>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        <small class="badge bg-light text-secondary border">Fase {{ $tp->capaianPembelajaran->fase->kode ?? '-' }}</small>
                                        @if($tp->elemen)
                                            <small class="badge bg-info bg-opacity-10 text-dark border">{{ $tp->elemen }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-dark fw-medium">{{ $tp->deskripsi_tp }}</div>
                                </td>
                                <td>
                                    @if($tp->konten_pengetahuan)
                                        <div class="small text-secondary mb-1"><strong>Materi:</strong> {{ Str::limit($tp->konten_pengetahuan, 80) }}</div>
                                    @endif
                                    @if($tp->indikator_ketercapaian)
                                        <div class="small text-muted p-1 rounded bg-light border" style="font-size: 0.74rem;">
                                            <strong>IKTP:</strong> {!! nl2br(e(Str::limit($tp->indikator_ketercapaian, 120))) !!}
                                        </div>
                                    @endif
                                </td>
                                <td><small class="text-secondary">{{ $tp->user->name ?? '-' }}</small></td>
                                <td>
                                    @if(auth()->user()->isSuperAdmin() || auth()->id() == $tp->user_id)
                                        <form action="{{ route('tp.destroy', $tp->id) }}" method="POST" id="del-tp-{{ $tp->id }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('del-tp-{{ $tp->id }}', 'TP ini')" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
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
        $('.datatable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Tidak ditemukan data yang sesuai"
            }
        });
    });
</script>
@endpush
