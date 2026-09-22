@extends('layouts.app')

@section('title', 'Detail Modul Ajar - ' . $modulAjar->judul)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <a href="{{ route('modul-ajar.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-block">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Modul Ajar
        </a>
        <h4 class="fw-bold text-dark mb-0">{{ $modulAjar->judul }}</h4>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <div class="dropdown">
            <button class="btn btn-danger btn-sm rounded-pill px-3 dropdown-toggle d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Ukuran Kertas</h6></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.modul-ajar.pdf', $modulAjar->id) }}?paper=a4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span> <span class="badge bg-light text-muted border ms-2">210x297 mm</span></a></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.modul-ajar.pdf', $modulAjar->id) }}?paper=f4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span> <span class="badge bg-light text-muted border ms-2">215x330 mm</span></a></li>
            </ul>
        </div>
        <a href="{{ route('export.modul-ajar.docx', $modulAjar->id) }}" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-file-earmark-word me-1"></i> Unduh Word (DOCX)
        </a>
    </div>
</div>

<!-- A. INFORMASI UMUM -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="fw-bold text-primary">
            <i class="bi bi-info-circle me-2"></i> A. Informasi Umum
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Penyusun</div>
                <div class="fw-semibold text-dark">{{ $modulAjar->user->name ?? '-' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Satuan Pendidikan</div>
                <div class="fw-semibold text-dark">{{ $modulAjar->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Mata Pelajaran</div>
                <div class="fw-semibold text-dark">{{ $modulAjar->mataPelajaran->nama ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Fase & Kelas</div>
                <div class="fw-semibold text-dark">Fase {{ $modulAjar->fase->kode ?? '-' }} ({{ $modulAjar->fase->kelas_range ?? '-' }})</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Alokasi Waktu</div>
                <div class="fw-semibold text-dark">{{ $modulAjar->alokasi_waktu_jp ?? 12 }} JP ({{ $modulAjar->jumlah_pertemuan ?? 3 }}x Pertemuan)</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Kompetensi Awal</div>
                <div class="text-secondary small">{{ $modulAjar->kompetensi_awal ?? '-' }}</div>
            </div>
            <div class="col-12">
                <div class="text-muted small mb-1">Dimensi Profil Lulusan yang Dikembangkan (Permendikdasmen 10/2025):</div>
                <div class="d-flex flex-wrap gap-1">
                    @forelse($modulAjar->profilLulusans as $pl)
                        <span class="badge bg-light text-primary border p-2">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ $pl->dimensi }}
                        </span>
                    @empty
                        <span class="text-muted small">{{ $modulAjar->profil_lulusan_target ?? '-' }}</span>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Sarana & Prasarana</div>
                <div class="text-secondary small">{{ $modulAjar->sarana_prasarana ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Target Peserta Didik</div>
                <div class="text-secondary small">{{ $modulAjar->target_peserta_didik ?? 'Peserta didik reguler' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- B. KOMPONEN INTI -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="fw-bold text-success">
            <i class="bi bi-bullseye me-2"></i> B. Komponen Inti
        </div>
    </div>
    <div class="card-body p-4">
        <div class="mb-3">
            <div class="fw-semibold text-dark small mb-1">Tujuan Pembelajaran (TP):</div>
            <div class="p-3 bg-light rounded-3 border small text-dark">
                {{ $modulAjar->tujuanPembelajaran->deskripsi_tp ?? '-' }}
            </div>
        </div>
        <div class="mb-3">
            <div class="fw-semibold text-dark small mb-1">Pemahaman Bermakna (Meaningful Learning):</div>
            <div class="p-3 bg-light rounded-3 border small text-dark">
                {{ $modulAjar->pemahaman_bermakna ?? '-' }}
            </div>
        </div>
        <div class="mb-0">
            <div class="fw-semibold text-dark small mb-1">Pertanyaan Pemantik:</div>
            <div class="p-3 bg-light rounded-3 border small text-dark">
                {!! nl2br(e($modulAjar->pertanyaan_pemantik)) !!}
            </div>
        </div>
    </div>
</div>

<!-- C. LANGKAH-LANGKAH PEMBELAJARAN (PEDATTI) -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="fw-bold text-warning text-dark">
            <i class="bi bi-arrow-repeat me-2"></i> C. Langkah-Langkah Pembelajaran Berbasis Alur PEDATTI
        </div>
    </div>
    <div class="card-body p-4">
        @foreach($modulAjar->kegiatans as $keg)
            <div class="p-3 mb-3 rounded-3 border bg-light">
                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                    <span class="badge bg-primary fs-6 px-3 py-1">
                        Tahap {{ $loop->iteration }}: {{ strtoupper($keg->tahap_pedatti) }}
                    </span>
                    <div class="d-flex gap-2">
                        <span class="badge bg-warning text-dark border">{{ $keg->prinsip_deep_learning }}</span>
                        <span class="badge bg-info text-dark border">{{ $keg->olah }}</span>
                        <span class="badge bg-light text-secondary border">{{ $keg->durasi_menit ?? 30 }} Menit</span>
                    </div>
                </div>
                <div class="small text-dark" style="line-height: 1.6;">
                    {!! nl2br(e($keg->deskripsi_kegiatan)) !!}
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- D. ASESMEN & REFLEKSI -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="fw-bold text-info text-dark">
            <i class="bi bi-check2-square me-2"></i> D. Asesmen & Refleksi Pembelajaran
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border h-100">
                    <div class="fw-bold small text-primary mb-1">1. Asesmen Awal (Diagnostik)</div>
                    <div class="small text-secondary">{{ $modulAjar->asesmen_awal ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border h-100">
                    <div class="fw-bold small text-success mb-1">2. Asesmen Formatif (Proses)</div>
                    <div class="small text-secondary">{{ $modulAjar->asesmen_formatif ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border h-100">
                    <div class="fw-bold small text-danger mb-1">3. Asesmen Sumatif (Akhir)</div>
                    <div class="small text-secondary">{{ $modulAjar->asesmen_sumatif ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="fw-bold small text-dark mb-1"><i class="bi bi-person-video3 me-1"></i> Refleksi Guru:</div>
                    <div class="small text-secondary">{!! nl2br(e($modulAjar->refleksi_guru)) !!}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="fw-bold small text-dark mb-1"><i class="bi bi-people me-1"></i> Refleksi Peserta Didik:</div>
                    <div class="small text-secondary">{!! nl2br(e($modulAjar->refleksi_siswa)) !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
