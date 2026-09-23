@extends('layouts.app')

@section('title', 'Smart Soal - Bank Soal & Kisi-Kisi Ujian')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">

    <!-- HEADER TITLE & ACTION BUTTONS -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-soft-primary rounded-pill px-3 py-1 fw-bold" style="font-size: 0.76rem;">
                    <i class="bi bi-cpu me-1"></i> SISTEM PAKAR MURNI (ZERO HALLUCINATION)
                </span>
                <span class="badge badge-soft-warning rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.74rem;">
                    <i class="bi bi-c-circle me-1"></i> Smart Soal by. Vicky
                </span>
            </div>
            <h3 class="fw-bold text-dark mb-1" style="color: #0b3b60 !important;">
                Smart Soal: Generator Kisi-Kisi & Bank Soal
            </h3>
            <p class="text-muted small mb-0">
                Penyusunan naskah asesmen otomatis dari kisi-kisi ke butir soal (PG & Isian) yang tersinkronisasi langsung dengan Perangkat Ajar.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1.5" onclick="showSmartSoalGuide()">
                <i class="bi bi-info-circle-fill"></i>
                <span>Panduan Smart Soal</span>
            </button>
            <a href="{{ route('paket-soal.create') }}" class="btn btn-primary btn-sm rounded-pill px-3.5 shadow-sm fw-bold d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Buat Paket Soal Baru</span>
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: #ffffff; border-left: 4px solid #0284c7 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Total Paket Soal</span>
                        <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-collection-fill fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $paketSoals->total() }}</h3>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Tersimpan dalam arsip kurikulum
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: #ffffff; border-left: 4px solid #10b981 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Pilihan Ganda (PG)</span>
                        <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-ui-checks fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $paketSoals->sum('total_soal_pg') }}</h3>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Butir soal bernomor dengan opsi A-E & kunci
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: #ffffff; border-left: 4px solid #f59e0b !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Isian & Uraian</span>
                        <div class="rounded-circle p-2 bg-warning bg-opacity-15 text-warning text-dark">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $paketSoals->sum('total_soal_isian') }}</h3>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Soal studi kasus dengan rubrik penskoran
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: #ffffff; border-left: 4px solid #8b5cf6 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Standar Kisi-Kisi</span>
                        <div class="rounded-circle p-2 bg-purple bg-opacity-10 text-purple" style="color: #8b5cf6;">
                            <i class="bi bi-table fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">BSKAP 046</h3>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Test blueprint resmi Kemendikdasmen
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & PENCARIAN -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('paket-soal.index') }}" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm rounded-3" 
                           placeholder="Cari judul soal atau mata pelajaran..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="mapel_id" class="form-select form-select-sm rounded-3">
                        <option value="">-- Semua Mata Pelajaran --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="bentuk_soal" class="form-select form-select-sm rounded-3">
                        <option value="">-- Semua Bentuk Soal --</option>
                        <option value="pg" {{ request('bentuk_soal') === 'pg' ? 'selected' : '' }}>Pilihan Ganda Saja</option>
                        <option value="isian" {{ request('bentuk_soal') === 'isian' ? 'selected' : '' }}>Isian / Uraian Saja</option>
                        <option value="campuran" {{ request('bentuk_soal') === 'campuran' ? 'selected' : '' }}>Campuran (PG & Isian)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1.5">
                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3" title="Terapkan Filter">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'mapel_id', 'bentuk_soal']))
                        <a href="{{ route('paket-soal.index') }}" class="btn btn-outline-danger btn-sm rounded-3" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL PAKET SOAL -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold text-dark mb-0">Daftar Paket Soal & Asesmen</h5>
                <span class="badge badge-soft-primary rounded-pill px-2.5">
                    {{ $paketSoals->total() }} Paket Ditemukan
                </span>
            </div>
            <div class="text-muted small">
                Naskah soal dapat dicetak terpisah untuk siswa (tanpa kunci) dan pegangan guru.
            </div>
        </div>

        <div class="card-body p-0">
            @if($paketSoals->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-patch-question fs-1 text-secondary opacity-50 mb-2"></i>
                    <h6 class="fw-bold text-dark mb-1">Belum Ada Paket Soal Dibuat</h6>
                    <p class="small text-muted mb-3">Mulai buat paket soal dari modul ajar atau capaian pembelajaran yang ada.</p>
                    <a href="{{ route('paket-soal.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Buat Paket Soal Baru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45px;" class="text-center">No</th>
                                <th>Judul Naskah Ujian & Asesmen</th>
                                <th style="width: 200px;">Mata Pelajaran & Fase</th>
                                <th style="width: 170px;">Komposisi Soal</th>
                                <th style="width: 130px;">Waktu</th>
                                <th style="width: 150px;">Pembuat</th>
                                <th style="width: 180px;" class="text-center">Aksi & Ekspor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paketSoals as $idx => $item)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ $paketSoals->firstItem() + $idx }}
                                    </td>

                                    <!-- JUDUL -->
                                    <td>
                                        <a href="{{ route('paket-soal.show', $item->id) }}" class="fw-bold text-decoration-none text-dark d-block mb-0.5 hover-primary" style="font-size: 0.88rem;">
                                            {{ $item->judul }}
                                        </a>
                                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                            <span class="badge badge-soft-primary" style="font-size: 0.68rem;">
                                                {{ $item->jenis_ujian_label }}
                                            </span>
                                            @if($item->modulAjar)
                                                <span class="badge badge-soft-info" style="font-size: 0.68rem;" title="Terhubung ke Modul Ajar: {{ $item->modulAjar->judul }}">
                                                    <i class="bi bi-link-45deg"></i> Dari Modul
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- MAPEL & FASE -->
                                    <td>
                                        <div class="small fw-semibold text-dark">{{ $item->mataPelajaran->nama ?? '-' }}</div>
                                        <span class="badge bg-light text-secondary border" style="font-size: 0.68rem;">
                                            Fase {{ $item->fase->kode ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- KOMPOSISI SOAL -->
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @if($item->total_soal_pg > 0)
                                                <span class="badge badge-soft-success" style="font-size: 0.7rem;">
                                                    <i class="bi bi-ui-checks me-0.5"></i> {{ $item->total_soal_pg }} PG
                                                </span>
                                            @endif
                                            @if($item->total_soal_isian > 0)
                                                <span class="badge badge-soft-warning" style="font-size: 0.7rem;">
                                                    <i class="bi bi-pencil me-0.5"></i> {{ $item->total_soal_isian }} Isian
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-muted small mt-0.5" style="font-size: 0.7rem;">
                                            Total: {{ $item->total_soal }} Butir
                                        </div>
                                    </td>

                                    <!-- WAKTU -->
                                    <td class="small text-muted">
                                        <i class="bi bi-clock-history me-1"></i> {{ $item->alokasi_waktu_menit }} Menit
                                    </td>

                                    <!-- PEMBUAT -->
                                    <td>
                                        @if($item->user)
                                            <div class="small fw-semibold text-dark">{{ $item->user->name }}</div>
                                        @else
                                            <span class="badge badge-soft-warning" style="font-size: 0.7rem;">
                                                <i class="bi bi-person-x"></i> Tamu (Guest)
                                            </span>
                                        @endif
                                        <div class="text-muted small" style="font-size: 0.7rem;">
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <!-- LIHAT -->
                                            <a href="{{ route('paket-soal.show', $item->id) }}" class="btn btn-sm btn-outline-primary p-1.5 rounded-circle" title="Buka Naskah & Kisi-Kisi">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <!-- CETAK SISWA (PDF) -->
                                            <a href="{{ route('export.soal.siswa.pdf', $item->id) }}" class="btn btn-sm btn-outline-danger p-1.5 rounded-circle" title="Unduh PDF Soal Siswa (Tanpa Kunci)">
                                                <i class="bi bi-person-badge"></i>
                                            </a>

                                            <!-- CETAK GURU (PDF) -->
                                            <a href="{{ route('export.soal.guru.pdf', $item->id) }}" class="btn btn-sm btn-danger p-1.5 rounded-circle text-white" title="Unduh PDF Lengkap Pegangan Guru (Dengan Kisi & Kunci)">
                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                            </a>

                                            <!-- EKSPOR WORD -->
                                            <a href="{{ route('export.soal.docx', $item->id) }}" class="btn btn-sm btn-outline-info p-1.5 rounded-circle text-primary" title="Unduh Microsoft Word (.docx)">
                                                <i class="bi bi-file-earmark-word-fill"></i>
                                            </a>

                                            <!-- HAPUS -->
                                            <form action="{{ route('paket-soal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket soal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary p-1.5 rounded-circle" title="Hapus Paket Soal">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @if($paketSoals->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $paketSoals->links() }}
            </div>
        @endif
    </div>

</div>

<!-- POPUP SELAMAT DATANG DI SMART SOAL BY. VICKY -->
@include('soal.partials.welcome-modal')

@endsection
