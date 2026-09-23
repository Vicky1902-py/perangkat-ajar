@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">

    @if(isset($superadminData) && auth()->user()->isSuperAdmin())
        <!-- ========================================== -->
        <!-- SUPERADMIN CONTROL CENTER (aaPanel Inspired) -->
        <!-- ========================================== -->
        
        <!-- HEADER STATUS SERVER & QUICK INFO -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold d-inline-flex align-items-center gap-1.5">
                        <span class="spinner-grow spinner-grow-sm text-success" style="width: 0.55rem; height: 0.55rem;" role="status"></span>
                        SERVER STATUS: NORMAL
                    </span>
                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill small">
                        PHP {{ $superadminData['cpu']['php_version'] }} &bull; {{ $superadminData['cpu']['os'] }}
                    </span>
                    <span class="badge bg-light text-primary border px-2.5 py-1 rounded-pill small">
                        MySQL: {{ $superadminData['database']['size_mb'] }} MB
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2 text-primary"></i> Superadmin Control Center
                </h3>
                <p class="text-muted small mb-0">
                    Pemantauan performa server hosting, telemetri kapasitas, lalu lintas real-time, dan manajemen perangkat ajar terpadu.
                </p>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('cms.perangkat.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                    <i class="bi bi-hdd-stack-fill me-1"></i> Kelola Space Hosting
                </a>
                <a href="{{ route('cms.traffic.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                    <i class="bi bi-activity me-1"></i> Traffic Live
                </a>
                <a href="{{ route('generator.index') }}" class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm fw-bold text-dark">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Generator 1-Klik
                </a>
            </div>
        </div>

        <!-- BARIS 1: aaPanel SERVER HARDWARE GAUGES -->
        <div class="row g-3 mb-4">
            <!-- CPU LOAD -->
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white border-top border-4 border-primary">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-bold text-uppercase">CPU Load</span>
                        <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-cpu-fill fs-6"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1 mb-2">
                        <h3 class="fw-bold text-dark mb-0">{{ $superadminData['cpu']['load_percent'] }}%</h3>
                        <span class="text-muted small">beban</span>
                    </div>
                    <div class="progress mb-2" style="height: 6px; background-color: #f1f5f9;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $superadminData['cpu']['load_percent']) }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                        <span>Kondisi Server:</span>
                        <span class="fw-semibold text-success">Optimal</span>
                    </div>
                </div>
            </div>

            <!-- RAM / MEMORY -->
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white border-top border-4 border-info">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-bold text-uppercase">RAM / Memori</span>
                        <div class="rounded-circle p-2 bg-info bg-opacity-10 text-info" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-memory fs-6"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1 mb-2">
                        <h3 class="fw-bold text-dark mb-0">{{ $superadminData['memory']['usage_mb'] }}</h3>
                        <span class="text-muted small">MB / {{ $superadminData['memory']['limit'] }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 6px; background-color: #f1f5f9;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ min(100, $superadminData['memory']['percent']) }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                        <span>Peak: {{ $superadminData['memory']['peak_mb'] }} MB</span>
                        <span class="fw-semibold text-info">{{ $superadminData['memory']['percent'] }}% Terpakai</span>
                    </div>
                </div>
            </div>

            <!-- SSD / STORAGE DISK -->
            <div class="col-6 col-lg-3">
                <a href="{{ route('cms.perangkat.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white border-top border-4 border-danger hover-elevate">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-bold text-uppercase">SSD / Storage</span>
                            <div class="rounded-circle p-2 bg-danger bg-opacity-10 text-danger" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-hdd-fill fs-6"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-1 mb-2">
                            <h3 class="fw-bold text-dark mb-0">{{ $superadminData['disk']['used_gb'] }}</h3>
                            <span class="text-muted small">GB / {{ $superadminData['disk']['total_gb'] }} GB</span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $superadminData['disk']['percent'] }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                            <span>Free: {{ $superadminData['disk']['free_gb'] }} GB</span>
                            <span class="fw-bold text-danger">Kelola Space &rarr;</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- DATABASE MYSQL -->
            <div class="col-6 col-lg-3">
                <a href="{{ route('cms.perangkat.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white border-top border-4 border-success hover-elevate">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-bold text-uppercase">Database SQL</span>
                            <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-database-fill fs-6"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-1 mb-2">
                            <h3 class="fw-bold text-dark mb-0">{{ $superadminData['database']['size_mb'] }}</h3>
                            <span class="text-muted small">MB terpakai</span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, max(5, $superadminData['database']['size_mb'])) }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                            <span>{{ number_format($superadminData['documents']['total']) }} Dokumen</span>
                            <span class="fw-bold text-success">Rincian &rarr;</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- BARIS 2: KARTU PINTASAN INTERAKTIF (CLICKABLE SHORTCUT CARDS) -->
        <div class="row g-3 mb-4">
            <!-- PINTASAN: TRAFFIC REALTIME -->
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('cms.traffic.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white hover-card position-relative overflow-hidden" style="border-left: 5px solid #ef4444 !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-secondary small fw-bold text-uppercase">Traffic Realtime</span>
                            <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                <span class="spinner-grow spinner-grow-sm text-white me-1" style="width: 0.45rem; height: 0.45rem;"></span>LIVE
                            </span>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h2 class="fw-bold text-dark mb-0">{{ number_format($superadminData['traffic']['today_hits']) }}</h2>
                            <span class="text-muted small">hits hari ini</span>
                        </div>
                        <div class="small text-secondary mb-2" style="font-size: 0.78rem;">
                            Aktif 15m: <strong class="text-danger">{{ $superadminData['traffic']['active_now'] }} user</strong> ({{ $superadminData['traffic']['active_users'] }} Guru, {{ $superadminData['traffic']['active_guests'] }} Tamu)
                        </div>
                        <div class="pt-2 border-top d-flex align-items-center justify-content-between text-danger fw-semibold" style="font-size: 0.75rem;">
                            <span>Pantau Traffic & Log IP</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PINTASAN: KELOLA SPACE HOSTING -->
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('cms.perangkat.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white hover-card position-relative overflow-hidden" style="border-left: 5px solid #0284c7 !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-secondary small fw-bold text-uppercase">Space Hosting</span>
                            <div class="rounded-circle p-1.5 bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-hdd-stack-fill fs-6"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h2 class="fw-bold text-dark mb-0">{{ number_format($superadminData['documents']['total']) }}</h2>
                            <span class="text-muted small">total perangkat</span>
                        </div>
                        <div class="small text-secondary mb-2" style="font-size: 0.78rem;">
                            Penyimpanan: <strong class="text-primary">{{ $superadminData['disk']['used_gb'] }} GB</strong> dipakai ({{ $superadminData['disk']['free_gb'] }} GB tersisa)
                        </div>
                        <div class="pt-2 border-top d-flex align-items-center justify-content-between text-primary fw-semibold" style="font-size: 0.75rem;">
                            <span>Bulk Select & Hapus Massal</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PINTASAN: MANAJEMEN PENGGUNA -->
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('users.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white hover-card position-relative overflow-hidden" style="border-left: 5px solid #10b981 !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-secondary small fw-bold text-uppercase">Pengguna Terdaftar</span>
                            <div class="rounded-circle p-1.5 bg-success bg-opacity-10 text-success">
                                <i class="bi bi-people-fill fs-6"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h2 class="fw-bold text-dark mb-0">{{ number_format($superadminData['users']['total']) }}</h2>
                            <span class="text-muted small">akun</span>
                        </div>
                        <div class="small text-secondary mb-2" style="font-size: 0.78rem;">
                            Komposisi: <strong class="text-success">{{ $superadminData['users']['guru'] }} Guru</strong> &bull; {{ $superadminData['users']['admin_sekolah'] }} Admin Sekolah
                        </div>
                        <div class="pt-2 border-top d-flex align-items-center justify-content-between text-success fw-semibold" style="font-size: 0.75rem;">
                            <span>Kelola Hak Akses Akun</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PINTASAN: KOTAK USUL & SARAN -->
            <div class="col-sm-6 col-xl-3">
                <a href="{{ route('cms.feedbacks.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-3 p-3 bg-white hover-card position-relative overflow-hidden" style="border-left: 5px solid #f59e0b !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-secondary small fw-bold text-uppercase">Usul & Saran Guru</span>
                            @if($superadminData['feedback']['baru'] > 0)
                                <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                    {{ $superadminData['feedback']['baru'] }} Baru
                                </span>
                            @else
                                <div class="rounded-circle p-1.5 bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-chat-quote-fill fs-6"></i>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h2 class="fw-bold text-dark mb-0">{{ number_format($superadminData['feedback']['total']) }}</h2>
                            <span class="text-muted small">masukan</span>
                        </div>
                        <div class="small text-secondary mb-2" style="font-size: 0.78rem;">
                            Tindak lanjut: <strong class="text-warning text-dark">{{ $superadminData['feedback']['baru'] }} belum dibaca</strong>
                        </div>
                        <div class="pt-2 border-top d-flex align-items-center justify-content-between text-warning text-dark fw-semibold" style="font-size: 0.75rem;">
                            <span>Tinjau Feedback Guru</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- BARIS 3: GRAFIK KEREN MODEL aaPanel (CHART.JS) -->
        <div class="row g-3 mb-4">
            <!-- GRAFIK TREN 7 HARI (AREA SPLINE) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-graph-up-arrow text-primary"></i> Tren Lalu Lintas & Generasi Perangkat (7 Hari)
                            </h6>
                            <span class="text-muted small" style="font-size: 0.75rem;">Perbandingan aktivitas kunjungan harian vs perangkat ajar yang dibuat</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill small">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Kunjungan (Hits)
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill small">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Generate
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 280px; position: relative;">
                            <canvas id="trafficSplineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRAFIK KOMPOSISI PERANGKAT AJAR (DONUT) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-pie-chart-fill text-info"></i> Komposisi Perangkat
                            </h6>
                            <span class="text-muted small" style="font-size: 0.75rem;">Distribusi dokumen tersimpan</span>
                        </div>
                        <a href="{{ route('cms.perangkat.index') }}" class="btn btn-sm btn-light border py-0 px-2" style="font-size: 0.72rem;">Detail</a>
                    </div>
                    <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                        <div style="width: 100%; max-width: 220px; height: 210px; position: relative;" class="my-auto">
                            <canvas id="docDonutChart"></canvas>
                        </div>
                        <div class="w-100 mt-2 pt-2 border-top d-flex justify-content-between text-muted small" style="font-size: 0.75rem;">
                            <span>Total Tersimpan di DB:</span>
                            <strong class="text-dark">{{ number_format($superadminData['documents']['total']) }} Dokumen</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BARIS 4: PINTASAN CEPAT PENGATURAN SUPERADMIN -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-3 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span class="fw-bold text-secondary small text-uppercase d-flex align-items-center gap-2">
                    <i class="bi bi-grid-fill text-primary"></i> Pintasan Menu Utama:
                </span>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('cms.perangkat.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                        <i class="bi bi-hdd-stack-fill me-1"></i> Space Hosting
                    </a>
                    <a href="{{ route('cms.traffic.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                        <i class="bi bi-activity me-1"></i> Traffic Live
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
                        <i class="bi bi-people-fill me-1"></i> Akun Pengguna
                    </a>
                    <a href="{{ route('cms.feedbacks.index') }}" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-semibold">
                        <i class="bi bi-chat-heart-fill me-1"></i> Usul & Saran
                    </a>
                    <a href="{{ route('cms.settings.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                        <i class="bi bi-sliders2 me-1"></i> Pengaturan Web
                    </a>
                    <a href="{{ route('cms.cp.index') }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-semibold">
                        <i class="bi bi-award me-1"></i> Capaian (CP)
                    </a>
                </div>
            </div>
        </div>

        <div class="hr-divider my-4">
            <span class="badge bg-light text-secondary border px-3 py-1">Area Kerja Guru & Dokumen Terkini</span>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- HERO WELCOME BANNER (GURU & SHARED VIEW)   -->
    <!-- ========================================== -->
    <div class="card border-0 shadow-sm hero-banner-card mb-4" style="background: #1e3c72; background: linear-gradient(135deg, #0b3b60 0%, #0284c7 60%, #38bdf8 100%) !important; color: #ffffff !important; border-radius: 16px; overflow: hidden; position: relative;">
        <div class="card-body p-3 p-md-4 p-lg-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge fw-bold px-3 py-1.5 mb-2 mb-md-3" style="background-color: #fbbf24 !important; color: #0f172a !important; font-size: 0.75rem; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(251, 191, 36, 0.4);">
                        <i class="bi bi-stars"></i> Permendikdasmen No. 13 Tahun 2025
                    </span>
                    <h2 class="fw-bold mb-2 fs-4 fs-md-3 fs-lg-2" style="color: #ffffff !important; font-weight: 800; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.25);">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h2>
                    <p class="mb-3 mb-md-4" style="color: #f0f9ff !important; font-size: 0.88rem; line-height: 1.5; max-width: 650px;">
                        Platform penyusunan Perangkat Ajar SMK Berbasis <strong style="color: #ffffff !important;">Sistem Pakar Terstruktur</strong>:
                        menghasilkan Alur Tujuan, Modul Ajar (PEDATTI), LKPD, Prota, Promes, dan Asesmen sesuai 
                        <strong style="color: #ffffff !important;">8 Dimensi Profil Lulusan</strong> secara otomatis tanpa halusinasi.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="{{ route('generator.index') }}" class="btn fw-bold px-3 px-md-4 py-2 rounded-pill shadow" style="background-color: #fbbf24 !important; color: #0f172a !important; border: none; font-size: 0.85rem;">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Generate 1-Klik
                        </a>
                        <a href="{{ route('atp.create') }}" class="btn btn-outline-light px-3 px-md-4 py-2 rounded-pill" style="border: 2px solid rgba(255, 255, 255, 0.85); color: #ffffff !important; font-weight: 600; font-size: 0.85rem;">
                            <i class="bi bi-plus-circle me-1"></i> Buat ATP Manual
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="p-3 rounded-4 text-start d-inline-block shadow" style="width: 270px; background: rgba(11, 59, 96, 0.65) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; backdrop-filter: blur(6px);">
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

    <!-- STATS CARDS GURU (PINTASAN PERANGKAT AJAR) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <a href="{{ route('tp.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm border-start border-primary border-4 hover-card">
                    <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                        <div class="min-w-0 me-2">
                            <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">Tujuan Ajar (TP)</div>
                            <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_tp'] }}</div>
                            <span class="text-primary fw-semibold" style="font-size: 0.76rem;">
                                Buka Dokumen <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                            <i class="bi bi-bullseye fs-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-3">
            <a href="{{ route('atp.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm border-start border-success border-4 hover-card">
                    <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                        <div class="min-w-0 me-2">
                            <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">Alur TP (ATP)</div>
                            <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_atp'] }}</div>
                            <span class="text-success fw-semibold" style="font-size: 0.76rem;">
                                Buka Dokumen <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                            <i class="bi bi-diagram-3 fs-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-3">
            <a href="{{ route('modul-ajar.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm border-start border-warning border-4 hover-card">
                    <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                        <div class="min-w-0 me-2">
                            <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">Modul Ajar</div>
                            <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_modul'] }}</div>
                            <span class="text-warning text-dark fw-semibold" style="font-size: 0.76rem;">
                                Buka Dokumen <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                            <i class="bi bi-journal-richtext fs-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-3">
            <a href="{{ route('lkpd.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm border-start border-info border-4 hover-card">
                    <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-between">
                        <div class="min-w-0 me-2">
                            <div class="text-muted fw-semibold text-uppercase text-truncate" style="font-size: 0.72rem;">Lembar LKPD</div>
                            <div class="fs-4 fs-md-3 fw-bold text-dark my-1">{{ $stats['total_lkpd'] }}</div>
                            <span class="text-info fw-semibold" style="font-size: 0.76rem;">
                                Buka Dokumen <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 p-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- DOKUMEN TERBARU & PANDUAN PEDATTI -->
    <div class="row g-4">
        <!-- TABEL MODUL AJAR TERBARU -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
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
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-white">
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
</div>

@push('styles')
<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    }
    .hover-elevate {
        transition: transform 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
    }
    .hr-divider {
        display: flex;
        align-items: center;
        text-align: center;
    }
    .hr-divider::before,
    .hr-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px dashed #cbd5e1;
    }
    .hr-divider:not(:empty)::before {
        margin-right: .5em;
    }
    .hr-divider:not(:empty)::after {
        margin-left: .5em;
    }
</style>
@endpush

@if(isset($superadminData) && auth()->user()->isSuperAdmin())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Grafik Area Spline Tren 7 Hari (Traffic vs Generates)
    const trafficCtx = document.getElementById('trafficSplineChart');
    if (trafficCtx) {
        const labels = @json($superadminData['chart']['labels']);
        const visitsData = @json($superadminData['chart']['visits']);
        const generatesData = @json($superadminData['chart']['generates']);

        new Chart(trafficCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Aktivitas Kunjungan (Hits)',
                        data: visitsData,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.12)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0284c7',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Perangkat Ajar Dibuat',
                        data: generatesData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 }, color: '#64748b', precision: 0 }
                    }
                }
            }
        });
    }

    // 2. Inisialisasi Donut Chart Komposisi Perangkat
    const donutCtx = document.getElementById('docDonutChart');
    if (donutCtx) {
        const docBreakdown = @json($superadminData['documents']['breakdown']);
        const docLabels = Object.keys(docBreakdown);
        const docValues = Object.values(docBreakdown);

        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: docLabels,
                datasets: [{
                    data: docValues,
                    backgroundColor: [
                        '#0284c7', // Modul Ajar (Sky Blue)
                        '#3b82f6', // TP (Blue)
                        '#10b981', // ATP (Emerald)
                        '#06b6d4', // LKPD (Cyan)
                        '#8b5cf6', // Prota (Purple)
                        '#f59e0b', // Promes (Amber)
                        '#ec4899', // Asesmen (Pink)
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 8,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.label}: ${context.raw} Dokumen`;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endif
@endsection
