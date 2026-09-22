@extends('layouts.app')

@section('title', 'Detail Program Semester (Promes) - ' . ($promes->mataPelajaran->nama ?? ''))

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <a href="{{ route('prota-promes.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Prota & Promes
        </a>
        <h4 class="fw-bold text-dark mb-1">{{ $promes->judul }}</h4>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                <i class="bi bi-file-earmark-check me-1"></i>Permendikdasmen No. 13/2025 &bull; BSKAP 046/H/KR/2025
            </span>
            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                <i class="bi bi-calendar-week me-1"></i>Semester {{ $promes->semester }} ({{ $promes->semester == 2 ? 'Genap' : 'Ganjil' }})
            </span>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <div class="dropdown">
            <button class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm dropdown-toggle d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf"></i> <span>Unduh PDF</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Ukuran Kertas</h6></li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.promes.pdf', $promes->id) }}?paper=a4">
                        <span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span>
                        <span class="badge bg-light text-muted border ms-2">210x297 mm</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.promes.pdf', $promes->id) }}?paper=f4">
                        <span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span>
                        <span class="badge bg-light text-muted border ms-2">215x330 mm</span>
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{ route('export.promes.excel', $promes->id) }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-excel"></i> <span>Unduh Excel</span>
        </a>
        <a href="{{ route('export.promes.docx', $promes->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-word"></i> <span>Unduh Word</span>
        </a>
    </div>
</div>

<!-- INFORMASI PROMES -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Satuan Pendidikan</div>
                <div class="fw-semibold text-dark text-truncate">{{ $promes->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-muted small">Mata Pelajaran</div>
                <div class="fw-semibold text-dark text-truncate">{{ $promes->mataPelajaran->nama ?? '-' }}</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Fase / Kelas</div>
                <div class="fw-semibold text-dark">Fase {{ $promes->fase->kode ?? '-' }} ({{ $promes->fase->kelas_range ?? '-' }})</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Semester / Tahun</div>
                <div class="fw-semibold text-dark">{{ $promes->semester == 2 ? 'Genap' : 'Ganjil' }} ({{ $promes->tahunAjaran->nama ?? '2026/2027' }})</div>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="text-muted small">Penyusun</div>
                <div class="fw-semibold text-dark text-truncate">{{ $promes->user->name ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

@php
    $sem = $promes->semester ?? 1;
    $bulanList = ($sem == 2)
        ? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
        : ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $items = $promes->data_json ?? [];
    $totalJp = 0;
    foreach ($items as $it) {
        $totalJp += (int)($it['alokasi_jp'] ?? 12);
    }
@endphp

<!-- TABEL MATRIKS DISTRIBUSI ALOKASI PROGRAM SEMESTER -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <div class="fw-bold text-dark fs-6">
            <i class="bi bi-calendar3-range text-info me-2"></i> Matriks Jadwal Mingguan Program Semester (Promes)
        </div>
        <span class="badge bg-info text-dark rounded-pill px-3 py-2 fs-7">Total: {{ $totalJp }} JP</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 0.8rem;">
                <thead class="table-light text-center">
                    <tr>
                        <th rowspan="2" class="align-middle" style="width: 3%;">No</th>
                        <th rowspan="2" class="align-middle" style="width: 7%;">Kode TP</th>
                        <th rowspan="2" class="align-middle" style="width: 25%;">Tujuan Pembelajaran & Materi Pokok</th>
                        <th rowspan="2" class="align-middle" style="width: 5%;">JP</th>
                        @foreach($bulanList as $b)
                            <th colspan="5" style="width: 10%;">{{ $b }}</th>
                        @endforeach
                        <th rowspan="2" class="align-middle" style="width: 5%;">Ket</th>
                    </tr>
                    <tr style="font-size: 0.72rem;">
                        @foreach($bulanList as $b)
                            @for($m = 1; $m <= 5; $m++)
                                <th style="width: 2%;">{{ $m }}</th>
                            @endfor
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $idx => $d)
                        @php
                            $targetBulan = $d['bulan'] ?? $bulanList[$idx % count($bulanList)];
                            $targetMinggu = $d['minggu_ke'] ?? (($idx % 4) + 1);
                            $jpVal = $d['alokasi_jp'] ?? 12;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="text-center fw-semibold text-primary">{{ $d['kode_tp'] ?? '-' }}</td>
                            <td>
                                <strong>{{ $d['elemen'] ?? ($promes->mataPelajaran->nama ?? 'Kompetensi') }}:</strong>
                                <div class="text-secondary small">{{ $d['tujuan_pembelajaran'] ?? '-' }}</div>
                            </td>
                            <td class="text-center fw-bold">{{ $jpVal }}</td>

                            @foreach($bulanList as $b)
                                @for($m = 1; $m <= 5; $m++)
                                    @if(strtolower(trim($b)) === strtolower(trim($targetBulan)) && (int)$m === (int)$targetMinggu)
                                        <td class="text-center table-primary fw-bold text-primary">{{ $jpVal }}</td>
                                    @else
                                        <td class="text-center text-muted opacity-25">-</td>
                                    @endif
                                @endfor
                            @endforeach

                            <td class="text-center small text-muted">Efektif</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="35" class="text-center py-4 text-muted">Belum ada rincian data pada Program Semester ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">TOTAL ALOKASI JP SEMESTER:</th>
                        <th class="text-center text-primary fs-6">{{ $totalJp }}</th>
                        <th colspan="31" class="text-muted small fw-normal">
                            <em>Distribusi jam pembelajaran terjadwal pada minggu efektif semester {{ $sem == 2 ? 'genap' : 'ganjil' }}.</em>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
