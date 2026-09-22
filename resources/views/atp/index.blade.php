@extends('layouts.app')

@section('title', 'Daftar Alur Tujuan Pembelajaran (ATP)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-diagram-3 text-primary me-2"></i> Alur Tujuan Pembelajaran (ATP)</h4>
        <p class="text-muted small mb-0">Rangkaian tujuan pembelajaran yang disusun secara sistematis dan logis dalam satu fase.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
        </a>
        <a href="{{ route('atp.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Buat ATP Manual
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($atps->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-diagram-3 fs-1 text-secondary opacity-50 mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada Dokumen ATP</h5>
                <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat ATP secara otomatis.</p>
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
                            <th>Judul ATP</th>
                            <th>Mata Pelajaran</th>
                            <th>Fase</th>
                            <th>Tahun Ajaran</th>
                            <th>Penyusun</th>
                            <th width="20%">Aksi & Ekspor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atps as $idx => $atp)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $atp->judul }}</div>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border" style="font-size: 0.7rem;">
                                            <i class="bi bi-shield-check me-1"></i>{{ $atp->regulasi ?? 'BSKAP 046/2025' }}
                                        </span>
                                        <span class="badge bg-light text-secondary border" style="font-size: 0.7rem;">
                                            {{ $atp->atpDetails->count() }} TP &bull; {{ $atp->total_alokasi_jp ?: $atp->atpDetails->sum('alokasi_waktu_jp') }} JP
                                        </span>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $atp->mataPelajaran->nama ?? '-' }}</span></td>
                                <td><span class="badge bg-primary">Fase {{ $atp->fase->kode ?? '-' }}</span></td>
                                <td>{{ $atp->tahunAjaran->nama ?? '2025/2026' }}</td>
                                <td><small class="text-secondary">{{ $atp->user->name ?? '-' }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('atp.show', $atp->id) }}" class="btn btn-outline-secondary" title="Detail & Review"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('export.atp.pdf', $atp->id) }}" class="btn btn-outline-danger" title="Ekspor PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                        <a href="{{ route('export.atp.excel', $atp->id) }}" class="btn btn-outline-success" title="Ekspor Excel"><i class="bi bi-file-earmark-excel"></i></a>
                                        <a href="{{ route('export.atp.docx', $atp->id) }}" class="btn btn-outline-primary" title="Ekspor Word"><i class="bi bi-file-earmark-word"></i></a>
                                        @if(auth()->user()->isSuperAdmin() || auth()->id() == $atp->user_id)
                                            <form action="{{ route('atp.destroy', $atp->id) }}" method="POST" id="del-atp-{{ $atp->id }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('del-atp-{{ $atp->id }}', 'dokumen ATP ini')" title="Hapus"><i class="bi bi-trash"></i></button>
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
