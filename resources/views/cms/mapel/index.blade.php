@extends('layouts.app')

@section('title', 'CMS Mata Pelajaran')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-book text-success me-2"></i> CMS Mata Pelajaran SMK</h4>
        <p class="text-muted small mb-0">Daftar mata pelajaran kelompok umum dan kejuruan sesuai Spektrum Keahlian SMK Kurikulum Merdeka.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 datatable">
                <thead class="table-light">
                    <tr>
                        <th width="4%">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Kelompok</th>
                        <th>Program Keahlian</th>
                        <th>Jam/Minggu</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mapels as $idx => $m)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><strong class="text-dark">{{ $m->nama }}</strong></td>
                            <td>
                                @if($m->kelompok === 'kejuruan')
                                    <span class="badge bg-primary">Kejuruan</span>
                                @else
                                    <span class="badge bg-secondary">Umum</span>
                                @endif
                            </td>
                            <td>{{ $m->programKeahlian->nama ?? 'Semua Keahlian (Umum)' }}</td>
                            <td>{{ $m->jam_pelajaran_per_minggu ? $m->jam_pelajaran_per_minggu . ' JP' : '-' }}</td>
                            <td><small class="text-secondary">{{ Str::limit($m->deskripsi, 80) }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
