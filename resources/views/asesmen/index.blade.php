@extends('layouts.app')

@section('title', 'Instrumen Asesmen')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-check2-square text-success me-2"></i> Instrumen Asesmen</h4>
        <p class="text-muted small mb-0">Penilaian Diagnostik (Awal), Formatif (Proses), dan Sumatif (Akhir) berbasis 8 Dimensi Profil Lulusan.</p>
    </div>
    <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3 shadow-sm">
        <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($asesmens->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-check2-circle fs-1 text-secondary opacity-50 mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada Instrumen Asesmen</h5>
                <p class="small text-muted mb-3">Gunakan fitur Generator Sekali Klik untuk membuat Instrumen Asesmen lengkap.</p>
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
                            <th>Judul Asesmen</th>
                            <th>Jenis & KKTP</th>
                            <th>Mata Pelajaran</th>
                            <th>Fase</th>
                            <th>Penyusun</th>
                            <th width="18%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asesmens as $idx => $a)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <a href="{{ route('asesmen.show', $a->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $a->judul }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Formatif & Sumatif</span>
                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning">KKTP 4 Level</span>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $a->mataPelajaran->nama ?? '-' }}</span></td>
                                <td><span class="badge bg-primary">Fase {{ $a->fase->kode ?? '-' }}</span></td>
                                <td><small class="text-secondary">{{ $a->user->name ?? '-' }}</small></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('asesmen.show', $a->id) }}" class="btn btn-outline-primary" title="Lihat Detail & KKTP">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('export.asesmen.pdf', $a->id) }}" class="btn btn-outline-danger" title="Unduh PDF" target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        <a href="{{ route('export.asesmen.docx', $a->id) }}" class="btn btn-outline-primary" title="Unduh Word">
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>
@endpush
