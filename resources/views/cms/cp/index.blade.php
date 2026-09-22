@extends('layouts.app')

@section('title', 'CMS Capaian Pembelajaran (CP)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-award text-primary me-2"></i> CMS Capaian Pembelajaran (CP)</h4>
        <p class="text-muted small mb-0">Basis data resmi Capaian Pembelajaran dan Elemen Kompetensi berdasarkan <strong>Keputusan Kepala BSKAP Nomor 046/H/KR/2025</strong> (Merevisi Nomor 032/H/KR/2024).</p>
    </div>
    <div>
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
            <i class="bi bi-shield-check me-1"></i> BSKAP No. 046/H/KR/2025
        </span>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 datatable" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th width="4%">No</th>
                        <th width="20%">Mata Pelajaran</th>
                        <th width="8%">Fase</th>
                        <th width="15%">Dasar Regulasi</th>
                        <th>Deskripsi Capaian Pembelajaran</th>
                        <th width="25%">Elemen Kompetensi CP</th>
                        <th width="6%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cps as $idx => $cp)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $cp->mataPelajaran->nama ?? '-' }}</div>
                                <span class="badge bg-light text-secondary border">{{ $cp->mataPelajaran->kelompok ?? 'umum' }}</span>
                            </td>
                            <td><span class="badge bg-primary">Fase {{ $cp->fase->kode ?? '-' }}</span></td>
                            <td>
                                <span class="badge bg-light text-primary border text-wrap text-start" style="font-size: 0.72rem;">
                                    {{ $cp->regulasi ?? 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025' }}
                                </span>
                            </td>
                            <td><div class="small text-secondary" style="line-height: 1.4;">{{ Str::limit($cp->deskripsi_cp, 160) }}</div></td>
                            <td>
                                @php
                                    $elemen = json_decode($cp->elemen_cp, true) ?? [];
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($elemen as $nama => $desc)
                                        <span class="badge bg-light text-dark border small" title="{{ $desc }}">{{ $nama }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCp{{ $cp->id }}" title="Lihat Lengkap">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- MODAL DETAIL CP -->
                                <div class="modal fade" id="modalCp{{ $cp->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-light">
                                                <div>
                                                    <h6 class="modal-title fw-bold text-dark mb-0">{{ $cp->mataPelajaran->nama ?? '-' }} (Fase {{ $cp->fase->kode ?? '-' }})</h6>
                                                    <div class="text-xs text-muted" style="font-size: 0.75rem;">{{ $cp->regulasi ?? 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025' }}</div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-file-text me-1"></i> Deskripsi Capaian Pembelajaran:</h6>
                                                <p class="text-secondary small bg-light p-3 rounded border mb-4" style="line-height: 1.6;">
                                                    {{ $cp->deskripsi_cp }}
                                                </p>

                                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-grid me-1"></i> Rincian Elemen Kompetensi:</h6>
                                                <div class="row g-2">
                                                    @foreach($elemen as $elemenNama => $elemenDesc)
                                                        <div class="col-12">
                                                            <div class="p-3 rounded border bg-white shadow-sm">
                                                                <div class="fw-bold text-dark small mb-1 text-primary">
                                                                    <i class="bi bi-check-circle-fill text-success me-1"></i> {{ $elemenNama }}
                                                                </div>
                                                                <div class="text-secondary small" style="line-height: 1.5;">
                                                                    {{ $elemenDesc }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light py-2">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
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
        $('.datatable').DataTable({
            language: {
                search: "Cari CP:",
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
