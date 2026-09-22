@extends('layouts.app')

@section('title', 'Pantau Traffic & Perangkat Pengunjung Realtime')

@section('content')
<div class="container-fluid px-0">
    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold d-inline-flex align-items-center gap-1.5">
                    <span class="spinner-grow spinner-grow-sm text-danger" style="width: 0.6rem; height: 0.6rem;" role="status"></span>
                    LIVE MONITOR 2026
                </span>
                <span class="text-muted small" id="lastUpdatedTime">Terakhir update: {{ now()->format('H:i:s') }}</span>
            </div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-activity text-danger"></i> Pantau Traffic & Perangkat Pengunjung Realtime
            </h3>
            <p class="text-muted small mb-0">
                Memantau secara langsung siapa yang sedang mengakses platform, jenis perangkat yang digunakan (Smartphone/Desktop), serta dokumen perangkat ajar apa yang sedang dibuat baik oleh Guru maupun Tamu publik.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- TOGGLE AUTO REFRESH -->
            <div class="form-check form-switch bg-white px-3 py-2 rounded-pill border shadow-sm d-flex align-items-center gap-2 mb-0">
                <input class="form-check-input ms-0 mt-0" type="checkbox" id="toggleLivePolling" checked>
                <label class="form-check-label small fw-semibold text-secondary" for="toggleLivePolling" id="toggleLabel">
                    Live Polling (5s)
                </label>
            </div>

            <!-- BUTTON MANUAL REFRESH -->
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" id="btnManualRefresh">
                <i class="bi bi-arrow-clockwise me-1" id="refreshIcon"></i> Perbarui
            </button>

            <!-- CLEAR OLD LOGS -->
            <form action="{{ route('cms.traffic.clear-old') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data log yang berusia lebih dari 30 hari?')">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm" title="Bersihkan log lebih dari 30 hari">
                    <i class="bi bi-trash3 me-1"></i> Bersihkan Log Lama
                </button>
            </form>
        </div>
    </div>

    <!-- STAT CARDS ROW -->
    <div class="row g-3 mb-4">
        <!-- AKTIF 15 MENIT TERAKHIR -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%); border-left: 4px solid #ef4444 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Pengunjung Aktif (15m)</span>
                        <div class="rounded-circle p-2 bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-broadcast fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-2">
                        <h2 class="fw-bold text-dark mb-0" id="statActiveNow">{{ $activeNow }}</h2>
                        <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">ONLINE</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small text-secondary">
                        <span><strong class="text-success" id="statActiveUsers">{{ $activeUsers }}</strong> Guru</span>
                        <span>&bull;</span>
                        <span><strong class="text-warning text-dark" id="statActiveGuests">{{ $activeGuests }}</strong> Tamu</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL HITS HARI INI -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Aktivitas Hari Ini</span>
                        <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-cursor-fill fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-2">
                        <h2 class="fw-bold text-dark mb-0" id="statTodayVisits">{{ number_format($todayTotalVisits) }}</h2>
                        <span class="text-muted small">hits</span>
                    </div>
                    <div class="small text-muted">
                        Seluruh kunjungan & navigasi halaman
                    </div>
                </div>
            </div>
        </div>

        <!-- PERANGKAT AJAR DIBUAT HARI INI -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border-left: 4px solid #10b981 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Perangkat Dibuat Hari Ini</span>
                        <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-file-earmark-check-fill fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-2">
                        <h2 class="fw-bold text-dark mb-0" id="statTodayGenerates">{{ number_format($todayGenerates) }}</h2>
                        <span class="text-muted small">paket modul</span>
                    </div>
                    <div class="small text-muted">
                        TP, ATP, Modul Ajar, LKPD, Prota, Promes
                    </div>
                </div>
            </div>
        </div>

        <!-- RASIO PERANGKAT AKSES -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #faf5ff 100%); border-left: 4px solid #8b5cf6 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Perangkat Pengguna</span>
                        <div class="rounded-circle p-2 bg-purple bg-opacity-10 text-purple" style="color: #8b5cf6;">
                            <i class="bi bi-phone-flip fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-1 mb-1">
                        <div class="d-flex justify-content-between small">
                            <span class="text-secondary"><i class="bi bi-phone me-1 text-primary"></i> Smartphone</span>
                            <strong class="text-dark">{{ $deviceBreakdown['Smartphone'] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-secondary"><i class="bi bi-laptop me-1 text-success"></i> Desktop / Laptop</span>
                            <strong class="text-dark">{{ $deviceBreakdown['Desktop / Laptop'] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-secondary"><i class="bi bi-tablet me-1 text-info"></i> Tablet / Lainnya</span>
                            <strong class="text-dark">{{ ($deviceBreakdown['Tablet'] ?? 0) + ($deviceBreakdown['Bot/Crawler'] ?? 0) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DEVICE & OS BREAKDOWN CARDS -->
    <div class="row g-3 mb-4">
        <!-- DETAIL DISTRIBUSI PERANGKAT & OS -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-primary"></i> Distribusi Perangkat & OS
                    </h6>
                    <span class="badge bg-light text-secondary border">Hari Ini</span>
                </div>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="small text-muted fw-semibold mb-2">Jenis Perangkat (Hardware)</label>
                        @php
                            $totalDev = array_sum($deviceBreakdown) ?: 1;
                        @endphp
                        @forelse($deviceBreakdown as $dType => $dCount)
                            @php
                                $dPct = round(($dCount / $totalDev) * 100);
                                $badgeColor = match($dType) {
                                    'Smartphone' => 'bg-info',
                                    'Desktop / Laptop' => 'bg-primary',
                                    'Tablet' => 'bg-warning',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="fw-semibold text-secondary">{{ $dType }}</span>
                                    <span><strong>{{ $dCount }}</strong> ({{ $dPct }}%)</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $badgeColor }}" role="progressbar" style="width: {{ $dPct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted small text-center py-2">Belum ada data perangkat hari ini.</div>
                        @endforelse
                    </div>

                    <hr class="opacity-10 my-3">

                    <div>
                        <label class="small text-muted fw-semibold mb-2">Sistem Operasi (OS) Terbanyak</label>
                        <div class="d-flex flex-wrap gap-1.5">
                            @forelse($osBreakdown as $osName => $osCount)
                                <span class="badge bg-light text-dark border px-2.5 py-1.5 small d-flex align-items-center gap-1.5">
                                    <i class="bi bi-cpu text-primary"></i> {{ $osName }}: <strong>{{ $osCount }}</strong>
                                </span>
                            @empty
                                <span class="text-muted small">Belum ada data OS</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTER & KONTROL STREAM -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-funnel-fill text-primary"></i> Filter Aktivitas Pengunjung
                    </h6>
                    @if(request()->anyFilled(['role', 'device_type', 'action_type']))
                        <a href="{{ route('cms.traffic.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-2.5 py-0.5" style="font-size: 0.78rem;">
                            <i class="bi bi-x-circle me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('cms.traffic.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Status Pengguna</label>
                            <select name="role" class="form-select form-select-sm rounded-3">
                                <option value="">-- Semua Status (Guru & Tamu) --</option>
                                <option value="guest" {{ request('role') === 'guest' ? 'selected' : '' }}>Tamu Publik (Guest)</option>
                                <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru Terdaftar</option>
                                <option value="admin_sekolah" {{ request('role') === 'admin_sekolah' ? 'selected' : '' }}>Admin Sekolah</option>
                                <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Tipe Perangkat (Device)</label>
                            <select name="device_type" class="form-select form-select-sm rounded-3">
                                <option value="">-- Semua Perangkat --</option>
                                <option value="Smartphone" {{ request('device_type') === 'Smartphone' ? 'selected' : '' }}>Smartphone (HP)</option>
                                <option value="Desktop / Laptop" {{ request('device_type') === 'Desktop / Laptop' ? 'selected' : '' }}>Desktop / Laptop</option>
                                <option value="Tablet" {{ request('device_type') === 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="Bot/Crawler" {{ request('device_type') === 'Bot/Crawler' ? 'selected' : '' }}>Bot / Crawler</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">Jenis Aktivitas</label>
                            <select name="action_type" class="form-select form-select-sm rounded-3">
                                <option value="">-- Semua Aktivitas --</option>
                                <option value="generate" {{ request('action_type') === 'generate' ? 'selected' : '' }}>Pembuatan Dokumen (Generate)</option>
                                <option value="view" {{ request('action_type') === 'view' ? 'selected' : '' }}>Kunjungan Halaman (View)</option>
                                <option value="auth" {{ request('action_type') === 'auth' ? 'selected' : '' }}>Login & Daftar</option>
                                <option value="export" {{ request('action_type') === 'export' ? 'selected' : '' }}>Ekspor Dokumen</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="alert alert-light border border-info border-opacity-25 rounded-3 mt-3 mb-0 p-2.5 small d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <span class="text-secondary" style="font-size: 0.82rem;">
                            Live Polling otomatis menyegarkan 20 log teratas setiap 5 detik tanpa perlu reload halaman. Data mendeteksi merk OS, browser, IP, dan spesifik mata pelajaran yang sedang di-generate.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LIVE ACTIVITY TABLE -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-danger"></i> Log Aktivitas Pengunjung Terkini
            </h5>
            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 small">
                Menampilkan {{ $logs->count() }} aktivitas
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="trafficTable">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase" style="font-size: 0.76rem; letter-spacing: 0.5px;">
                            <th width="14%">Waktu</th>
                            <th width="22%">Pengunjung & Status</th>
                            <th width="20%">Perangkat & Browser</th>
                            <th width="12%">Aksi</th>
                            <th>Aktivitas / Dokumen yang Dibuat</th>
                        </tr>
                    </thead>
                    <tbody id="trafficTableBody">
                        @forelse($logs as $log)
                            @php
                                $roleBadge = match($log->role) {
                                    'superadmin' => 'bg-danger',
                                    'admin_sekolah' => 'bg-primary',
                                    'guru' => 'bg-success',
                                    default => 'bg-warning text-dark',
                                };
                                $roleLabel = match($log->role) {
                                    'superadmin' => 'Superadmin',
                                    'admin_sekolah' => 'Admin Sekolah',
                                    'guru' => 'Guru SMK',
                                    default => 'Tamu (Guest)',
                                };
                                $devIcon = match($log->device_type) {
                                    'Smartphone' => 'bi-phone text-info',
                                    'Tablet' => 'bi-tablet text-warning',
                                    'Bot/Crawler' => 'bi-robot text-danger',
                                    default => 'bi-laptop text-primary',
                                };
                                $actionBadge = match($log->action_type) {
                                    'generate' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
                                    'auth' => 'bg-info bg-opacity-10 text-info border border-info border-opacity-25',
                                    'export' => 'bg-purple bg-opacity-10 text-purple border border-purple border-opacity-25',
                                    default => 'bg-light text-secondary border',
                                };
                            @endphp
                            <tr id="log-row-{{ $log->id }}">
                                <td>
                                    <div class="fw-bold text-dark font-monospace" style="font-size: 0.88rem;">
                                        {{ $log->created_at ? $log->created_at->format('H:i:s') : '-' }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.74rem;">
                                        {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1.5 mb-1">
                                        <span class="badge {{ $roleBadge }} px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                                            {{ $roleLabel }}
                                        </span>
                                        <strong class="text-dark small text-truncate" style="max-width: 180px;">
                                            {{ $log->user_name }}
                                        </strong>
                                    </div>
                                    <div class="text-muted small font-monospace" style="font-size: 0.74rem;">
                                        <i class="bi bi-geo-alt me-1"></i>IP: {{ $log->ip_address ?: '127.0.0.1' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                        <i class="bi {{ $devIcon }} fs-6"></i>
                                        <span class="fw-semibold text-dark small">{{ $log->device_type }}</span>
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.74rem;">
                                        {{ $log->device_os ?: 'OS Tidak Diketahui' }} &bull; {{ $log->browser ?: 'Browser' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $actionBadge }} px-2.5 py-1 rounded-pill small fw-semibold text-uppercase" style="font-size: 0.7rem;">
                                        @if($log->action_type === 'generate')
                                            <i class="bi bi-lightning-charge-fill me-1"></i> GENERATE
                                        @elseif($log->action_type === 'auth')
                                            <i class="bi bi-shield-lock me-1"></i> AUTH
                                        @elseif($log->action_type === 'export')
                                            <i class="bi bi-download me-1"></i> EKSPOR
                                        @else
                                            <i class="bi bi-eye me-1"></i> VIEW
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark small mb-1">
                                        {{ $log->activity_description }}
                                    </div>
                                    @if(!empty($log->perangkat_ajar_meta))
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.72rem;">
                                                <i class="bi bi-book me-1"></i> {{ $log->perangkat_ajar_meta['mapel'] ?? '-' }}
                                            </span>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="font-size: 0.72rem;">
                                                {{ $log->perangkat_ajar_meta['fase'] ?? '-' }}
                                            </span>
                                            @if(!empty($log->perangkat_ajar_meta['modul_id']))
                                                <a href="{{ route('modul-ajar.show', $log->perangkat_ajar_meta['modul_id']) }}" target="_blank" class="badge bg-info bg-opacity-10 text-info text-decoration-none border border-info border-opacity-25" style="font-size: 0.72rem;">
                                                    <i class="bi bi-box-arrow-up-right me-0.5"></i> Lihat Modul
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada log traffic yang tercatat. Silakan buka halaman publik atau lakukan generate.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari total {{ $logs->total() }} log
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS UNTUK LIVE POLLING & AUTO REFRESH -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let isPolling = true;
        let pollInterval = null;
        const toggleSwitch = document.getElementById('toggleLivePolling');
        const toggleLabel = document.getElementById('toggleLabel');
        const btnManualRefresh = document.getElementById('btnManualRefresh');
        const refreshIcon = document.getElementById('refreshIcon');
        const lastUpdatedText = document.getElementById('lastUpdatedTime');

        // Toggle state change
        if (toggleSwitch) {
            toggleSwitch.addEventListener('change', function () {
                isPolling = this.checked;
                toggleLabel.textContent = isPolling ? 'Live Polling (5s)' : 'Polling Dijeda';
                toggleLabel.className = isPolling ? 'form-check-label small fw-semibold text-secondary' : 'form-check-label small fw-semibold text-danger';
                if (isPolling) {
                    startPolling();
                } else {
                    stopPolling();
                }
            });
        }

        if (btnManualRefresh) {
            btnManualRefresh.addEventListener('click', function () {
                fetchLiveData(true);
            });
        }

        function startPolling() {
            stopPolling();
            pollInterval = setInterval(fetchLiveData, 5000);
        }

        function stopPolling() {
            if (pollInterval) {
                clearInterval(pollInterval);
                pollInterval = null;
            }
        }

        function fetchLiveData(isManual = false) {
            if (isManual && refreshIcon) {
                refreshIcon.classList.add('spin-animation');
            }

            fetch("{{ route('cms.traffic.live') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update Metrics
                    document.getElementById('statActiveNow').textContent = data.metrics.active_now;
                    document.getElementById('statActiveGuests').textContent = data.metrics.active_guests;
                    document.getElementById('statActiveUsers').textContent = data.metrics.active_users;
                    document.getElementById('statTodayVisits').textContent = new Intl.NumberFormat().format(data.metrics.today_visits);
                    document.getElementById('statTodayGenerates').textContent = new Intl.NumberFormat().format(data.metrics.today_generates);

                    // Update timestamp
                    if (lastUpdatedText) {
                        lastUpdatedText.textContent = 'Terakhir update: ' + data.timestamp.split(' ')[1];
                    }

                    // Update Table Rows
                    if (data.logs && data.logs.length > 0) {
                        renderLogs(data.logs);
                    }
                }
            })
            .catch(err => {
                console.error("Gagal mengambil data live traffic:", err);
            })
            .finally(() => {
                if (isManual && refreshIcon) {
                    setTimeout(() => refreshIcon.classList.remove('spin-animation'), 600);
                }
            });
        }

        function renderLogs(logs) {
            const tbody = document.getElementById('trafficTableBody');
            if (!tbody) return;

            // Generate HTML for each log
            let html = '';
            logs.forEach(log => {
                let actionBadgeClass = 'bg-light text-secondary border';
                let actionIcon = 'bi-eye';
                let actionText = 'VIEW';

                if (log.action_type === 'generate') {
                    actionBadgeClass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25';
                    actionIcon = 'bi-lightning-charge-fill';
                    actionText = 'GENERATE';
                } else if (log.action_type === 'auth') {
                    actionBadgeClass = 'bg-info bg-opacity-10 text-info border border-info border-opacity-25';
                    actionIcon = 'bi-shield-lock';
                    actionText = 'AUTH';
                } else if (log.action_type === 'export') {
                    actionBadgeClass = 'bg-purple bg-opacity-10 text-purple border border-purple border-opacity-25';
                    actionIcon = 'bi-download';
                    actionText = 'EKSPOR';
                }

                let metaBadges = '';
                if (log.perangkat_ajar_meta) {
                    const m = log.perangkat_ajar_meta;
                    metaBadges = `
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.72rem;">
                                <i class="bi bi-book me-1"></i> ${escapeHtml(m.mapel || '-')}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="font-size: 0.72rem;">
                                ${escapeHtml(m.fase || '-')}
                            </span>
                        </div>
                    `;
                }

                html += `
                    <tr id="log-row-${log.id}">
                        <td>
                            <div class="fw-bold text-dark font-monospace" style="font-size: 0.88rem;">
                                ${log.created_time}
                            </div>
                            <div class="text-muted small" style="font-size: 0.74rem;">
                                ${log.time_ago}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1.5 mb-1">
                                <span class="badge ${log.role_badge_class} px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                                    ${log.role_label}
                                </span>
                                <strong class="text-dark small text-truncate" style="max-width: 180px;">
                                    ${escapeHtml(log.user_name)}
                                </strong>
                            </div>
                            <div class="text-muted small font-monospace" style="font-size: 0.74rem;">
                                <i class="bi bi-geo-alt me-1"></i>IP: ${escapeHtml(log.ip_address || '127.0.0.1')}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                <i class="bi ${log.device_icon} fs-6 text-primary"></i>
                                <span class="fw-semibold text-dark small">${escapeHtml(log.device_type)}</span>
                            </div>
                            <div class="text-muted small" style="font-size: 0.74rem;">
                                ${escapeHtml(log.device_os)} &bull; ${escapeHtml(log.browser)}
                            </div>
                        </td>
                        <td>
                            <span class="badge ${actionBadgeClass} px-2.5 py-1 rounded-pill small fw-semibold text-uppercase" style="font-size: 0.7rem;">
                                <i class="bi ${actionIcon} me-1"></i> ${actionText}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark small mb-1">
                                ${escapeHtml(log.activity_description)}
                            </div>
                            ${metaBadges}
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Mulai polling otomatis jika switch aktif
        if (isPolling) {
            startPolling();
        }
    });
</script>

<style>
    .spin-animation {
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
    .text-purple {
        color: #7c3aed !important;
    }
    .bg-purple {
        background-color: #7c3aed !important;
    }
    .border-purple {
        border-color: #7c3aed !important;
    }
</style>
@endpush
@endsection
