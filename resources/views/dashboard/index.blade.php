@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- HERO WELCOME BANNER -->
    <div class="col-12">
        <div class="card border-0 shadow-sm hero-banner-card" style="background: #1e3c72; background: linear-gradient(135deg, #0f172a 0%, #1e3c72 50%, #2563eb 100%) !important; color: #ffffff !important; border-radius: 16px; overflow: hidden; position: relative;">
            <div class="card-body p-3 p-md-4 p-lg-5 position-relative" style="z-index: 2;">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge fw-bold px-3 py-1.5 mb-2 mb-md-3" style="background-color: #f59e0b !important; color: #0f172a !important; font-size: 0.75rem; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.4);">
                            <i class="bi bi-stars"></i> Permendikdasmen No. 13 Tahun 2025
                        </span>
                        <h2 class="fw-bold mb-2 fs-4 fs-md-3 fs-lg-2" style="color: #ffffff !important; font-weight: 800; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.35);">
                            Selamat Datang, {{ auth()->user()->name }}!
                        </h2>
                        <p class="mb-3 mb-md-4" style="color: #f1f5f9 !important; font-size: 0.88rem; line-height: 1.5; max-width: 650px; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            Sistem penyusunan Perangkat Ajar Kurikulum Merdeka Jenjang SMK berbasis 
                            <strong style="color: #ffffff !important;">Pendekatan Pembelajaran Mendalam (Deep Learning)</strong>: 
                            <em style="color: #fed7aa !important;">Mindful</em>, <em style="color: #fed7aa !important;">Meaningful</em>, dan <em style="color: #fed7aa !important;">Joyful</em> 
                            dengan alur terintegrasi <strong style="color: #ffffff !important;">PEDATTI</strong> dan <strong style="color: #ffffff !important;">8 Dimensi Profil Lulusan</strong>.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="{{ route('generator.index') }}" class="btn fw-bold px-3 px-md-4 py-2 rounded-pill shadow" style="background-color: #fbbf24 !important; color: #0f172a !important; border: none; font-size: 0.85rem;">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Generate Sekali Klik
                            </a>
                            <a href="{{ route('atp.create') }}" class="btn btn-outline-light px-3 px-md-4 py-2 rounded-pill" style="border: 2px solid rgba(255, 255, 255, 0.85); color: #ffffff !important; font-weight: 600; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i> Buat ATP Manual
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                        <div class="p-3 rounded-4 text-start d-inline-block shadow" style="width: 270px; background: rgba(15, 23, 42, 0.65) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; backdrop-filter: blur(6px);">
                            <div class="small fw-bold mb-2 d-flex align-items-center gap-1" style="color: #fde047 !important; font-size: 0.82rem;">
                                <i class="bi bi-shield-check"></i> 8 Dimensi Profil Lulusan:
                            </div>
                            <ol class="small mb-0 ps-3" style="font-size: 0.75rem; line-height: 1.5; color: #ffffff !important;">
                                <li style="color: #ffffff !important;">Keimanan & Ketakwaan</li>
                                <li style="color: #ffffff !important;">Kewargaan</li>
                                <li style="color: #ffffff !important;">Penalaran Kritis</li>
                                <li style="color: #ffffff !important;">Kreativitas</li>
                                <li style="color: #ffffff !important;">Kolaborasi</li>
                                <li style="color: #ffffff !important;">Kemandirian</li>
                                <li style="color: #ffffff !important;">Kesehatan</li>
                                <li style="color: #ffffff !important;">Komunikasi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS CARDS (2x2 GRID ON PHONES) -->
    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                <div class="min-w-0 me-2">
                    <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">TP</div>
                    <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_tp'] }}</div>
                    <a href="{{ route('tp.index') }}" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.76rem;">
                        Lihat <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                    <i class="bi bi-bullseye fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm border-start border-success border-4">
            <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                <div class="min-w-0 me-2">
                    <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">ATP</div>
                    <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_atp'] }}</div>
                    <a href="{{ route('atp.index') }}" class="text-success text-decoration-none fw-semibold" style="font-size: 0.76rem;">
                        Lihat <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                    <i class="bi bi-diagram-3 fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm border-start border-warning border-4">
            <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                <div class="min-w-0 me-2">
                    <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">Modul Ajar</div>
                    <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_modul'] }}</div>
                    <a href="{{ route('modul-ajar.index') }}" class="text-warning text-decoration-none fw-semibold" style="font-size: 0.76rem;">
                        Lihat <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                    <i class="bi bi-journal-richtext fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm border-start border-info border-4">
            <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                <div class="min-w-0 me-2">
                    <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">LKPD</div>
                    <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_lkpd'] }}</div>
                    <a href="{{ route('lkpd.index') }}" class="text-info text-decoration-none fw-semibold" style="font-size: 0.76rem;">
                        Lihat <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                    <i class="bi bi-file-earmark-text fs-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DOKUMEN TERBARU & PANDUAN -->
<div class="row g-4">
    <!-- TABEL MODUL AJAR TERBARU -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <div class="fw-bold text-dark">
                    <i class="bi bi-journal-check text-primary me-2"></i> Modul Ajar Terbaru
                </div>
                <a href="{{ route('modul-ajar.index') }}" class="btn btn-sm btn-light border">Semua Modul</a>
            </div>
            <div class="card-body p-0">
                @if($recentModul->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 text-secondary opacity-50 mb-2"></i>
                        <p class="mb-2">Belum ada modul ajar yang dibuat.</p>
                        <a href="{{ route('generator.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                            <i class="bi bi-lightning-charge"></i> Generate Sekarang
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Modul</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Fase</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentModul as $m)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $m->judul }}</div>
                                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $m->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $m->mataPelajaran->nama ?? '-' }}</span></td>
                                        <td><span class="badge bg-primary">Fase {{ $m->fase->kode ?? '-' }}</span></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('modul-ajar.show', $m->id) }}" class="btn btn-outline-secondary" title="Detail"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('export.modul-ajar.pdf', $m->id) }}" class="btn btn-outline-danger" title="PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                                <a href="{{ route('export.modul-ajar.docx', $m->id) }}" class="btn btn-outline-primary" title="DOCX"><i class="bi bi-file-earmark-word"></i></a>
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
    </div>

    <!-- PANDUAN & ATURAN DEEP LEARNING -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <div class="fw-bold text-dark">
                    <i class="bi bi-book-half text-success me-2"></i> Landasan Kurikulum 2025
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <div class="fw-bold text-primary small mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-check2-circle"></i> 3 Pilar Pembelajaran Mendalam
                    </div>
                    <ul class="small mb-0 ps-3" style="font-size: 0.82rem; color: #1e293b; line-height: 1.5;">
                        <li class="mb-1"><strong class="text-dark">Mindful (Berkesadaran):</strong> Peserta didik sadar tujuan belajar, meregulasi diri, dan fokus.</li>
                        <li class="mb-1"><strong class="text-dark">Meaningful (Bermakna):</strong> Konsep dikaitkan langsung dengan pemecahan masalah nyata & industri.</li>
                        <li><strong class="text-dark">Joyful (Menggembirakan):</strong> Pengalaman belajar menyenangkan, menantang, dan bermakna.</li>
                    </ul>
                </div>

                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <div class="fw-bold text-success small mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-repeat"></i> Alur Belajar PEDATTI
                    </div>
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">1. Pendahuluan</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">2. Dalami</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">3. Terapkan</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">4. Tularkan</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">5. Inovasi</span>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <div class="fw-bold text-info small mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-heart-pulse"></i> 4 Proses Holistik
                    </div>
                    <p class="small mb-0" style="font-size: 0.82rem; color: #1e293b; line-height: 1.5;">
                        Modul ajar dan LKPD memadukan <strong class="text-dark">Olah Pikir</strong> (kognitif HOTS), <strong class="text-dark">Olah Hati</strong> (spiritual & etika), <strong class="text-dark">Olah Rasa</strong> (empati & estetika), dan <strong class="text-dark">Olah Raga</strong> (praktik fisik kejuruan).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
