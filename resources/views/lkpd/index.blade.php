@extends('layouts.app')

@section('title', 'Daftar Lembar Kerja Murid (LKPD)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-text text-info me-2"></i> Lembar Kerja Murid (LKPD)</h4>
        <p class="text-muted small mb-0">LKPD Kurikulum Merdeka berbasis stimulus otentik industri dan 3 tahap belajar mendalam (Memahami, Mengaplikasi, Merefleksi).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($lkpds->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark-x fs-1 text-secondary opacity-50 mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada LKPD</h5>
                <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat LKPD secara otomatis.</p>
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
                            <th>Judul LKPD</th>
                            <th>Mata Pelajaran</th>
                            <th>Fase</th>
                            <th>Alokasi Waktu</th>
                            <th>Penyusun</th>
                            <th width="18%">Aksi & Ekspor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lkpds as $idx => $lkpd)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lkpd->judul }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        {{ $lkpd->kegiatans->count() }} Tahap Belajar (Memahami-Mengaplikasi-Merefleksi)
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $lkpd->mataPelajaran->nama ?? '-' }}</span></td>
                                <td><span class="badge bg-primary">Fase {{ $lkpd->fase->kode ?? '-' }}</span></td>
                                <td>{{ $lkpd->alokasi_waktu_menit ?? 90 }} Menit</td>
                                <td><small class="text-secondary">{{ $lkpd->user->name ?? '-' }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('lkpd.show', $lkpd->id) }}" class="btn btn-outline-secondary" title="Detail"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('export.lkpd.pdf', $lkpd->id) }}" class="btn btn-outline-danger" title="Ekspor PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                        <a href="{{ route('export.lkpd.docx', $lkpd->id) }}" class="btn btn-outline-primary" title="Ekspor Word"><i class="bi bi-file-earmark-word"></i></a>
                                        @if(auth()->user()->isSuperAdmin() || auth()->id() == $lkpd->user_id)
                                            <form action="{{ route('lkpd.destroy', $lkpd->id) }}" method="POST" id="del-lkpd-{{ $lkpd->id }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('del-lkpd-{{ $lkpd->id }}', 'dokumen LKPD ini')" title="Hapus"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
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
