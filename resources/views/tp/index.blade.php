@extends('layouts.app')

@section('title', 'Tujuan Pembelajaran (TP)')

@section('content')
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
