@extends('layouts.app')

@section('title', 'Manajemen Space Hosting & Pembersih Perangkat Ajar')

@section('content')
<div class="container-fluid px-0">
    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold d-inline-flex align-items-center gap-1.5">
                    <i class="bi bi-hdd-stack-fill text-danger"></i>
                    HOSTING STORAGE MANAGER
                </span>
                <span class="text-muted small">Kapasitas Hosting & Database Terpantau</span>
            </div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-trash3-fill text-danger"></i> Manajemen Ruang Hosting & Pembersih Perangkat Ajar
            </h3>
            <p class="text-muted small mb-0">
                Pilih dan hapus berkas perangkat ajar yang sudah terakumulasi di server hosting untuk menjaga kapasitas database dan mencegah *disk quota overflow*.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalQuickPurge">
                <i class="bi bi-lightning-charge-fill me-1"></i> Pembersihan Cepat
            </button>
            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPurgeAll">
                <i class="bi bi-radioactive me-1"></i> Hapus SEMUA Perangkat (Reset Total)
            </button>
            <a href="{{ route('cms.perangkat.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STATS STORAGE & TOTAL DOKUMEN -->
    <div class="row g-3 mb-4">
        <!-- STORAGE DISK HOSTING -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); border-left: 4px solid #0284c7 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Kapasitas SSD Hosting</span>
                        <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-hdd-network fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $diskUsedGB }} GB</h3>
                        <span class="text-muted small">/ {{ $diskTotalGB }} GB</span>
                    </div>
                    <div class="progress mb-2" style="height: 6px;">
                        <div class="progress-bar {{ $diskPercent > 80 ? 'bg-danger' : ($diskPercent > 60 ? 'bg-warning' : 'bg-primary') }}" 
                             role="progressbar" style="width: {{ $diskPercent }}%;"></div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted" style="font-size: 0.72rem;">
                        <span>Terpakai {{ $diskPercent }}%</span>
                        <span>Sisa {{ $diskFreeGB }} GB Bebas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- UKURAN DATABASE MYSQL -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border-left: 4px solid #10b981 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Ukuran Database MySQL</span>
                        <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-database-fill-check fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-2">
                        <h3 class="fw-bold text-dark mb-0">{{ $dbSizeMB }} MB</h3>
                        <span class="badge badge-soft-success rounded-pill px-2" style="font-size: 0.68rem;">OPTIMAL</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Tersimpan di tabel MySQL hosting
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL DOKUMEN PERANGKAT -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #fef3c7 100%); border-left: 4px solid #f59e0b !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Total Dokumen Ajar</span>
                        <div class="rounded-circle p-2 bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-files fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="fw-bold text-dark mb-0">{{ number_format($totalPerangkat) }}</h3>
                        <span class="text-muted small">berkas aktif</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Modul: {{ $counts['modul_ajar'] }} &bull; ATP: {{ $counts['atp'] }} &bull; Soal: {{ $counts['soal'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

        <!-- DOKUMEN TAMU / TRIAL -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%); border-left: 4px solid #ef4444 !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Dokumen Tamu (Trial)</span>
                        <div class="rounded-circle p-2 bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="fw-bold text-danger mb-0">{{ number_format($guestCounts) }}</h3>
                        <span class="text-muted small">percobaan</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Dapat dibersihkan kapan saja tanpa memengaruhi guru
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER PENCARIAN & KATEGORI -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('cms.perangkat.index') }}" class="row g-2 align-items-end">
                <!-- FILTER TIPE DOKUMEN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1 fw-semibold">Tipe Dokumen</label>
                    <select name="type" class="form-select form-select-sm rounded-3">
                        <option value="all" {{ $filterType === 'all' ? 'selected' : '' }}>-- Semua Jenis Dokumen --</option>
                        <option value="modul_ajar" {{ $filterType === 'modul_ajar' ? 'selected' : '' }}>Modul Ajar ({{ $counts['modul_ajar'] }})</option>
                        <option value="atp" {{ $filterType === 'atp' ? 'selected' : '' }}>Alur TP (ATP) ({{ $counts['atp'] }})</option>
                        <option value="tp" {{ $filterType === 'tp' ? 'selected' : '' }}>Tujuan Ajar (TP) ({{ $counts['tp'] }})</option>
                        <option value="lkpd" {{ $filterType === 'lkpd' ? 'selected' : '' }}>Lembar Kerja (LKPD) ({{ $counts['lkpd'] }})</option>
                        <option value="prota" {{ $filterType === 'prota' ? 'selected' : '' }}>Program Tahunan ({{ $counts['prota'] }})</option>
                        <option value="promes" {{ $filterType === 'promes' ? 'selected' : '' }}>Program Semester ({{ $counts['promes'] }})</option>
                        <option value="asesmen" {{ $filterType === 'asesmen' ? 'selected' : '' }}>Instrumen Asesmen ({{ $counts['asesmen'] }})</option>
                        <option value="soal" {{ ($filterType === 'soal' || $filterType === 'paket_soal') ? 'selected' : '' }}>Smart Soal ({{ $counts['soal'] ?? 0 }})</option>
                    </select>
                </div>

                <!-- FILTER GURU / PEMBUAT -->
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1 fw-semibold">Pembuat / Pengguna</label>
                    <select name="user_id" class="form-select form-select-sm rounded-3">
                        <option value="">-- Semua Pengguna & Tamu --</option>
                        <option value="guest" {{ $filterUser === 'guest' ? 'selected' : '' }}>👤 Sesi Tamu Publik (Guest)</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $filterUser == $teacher->id ? 'selected' : '' }}>
                                👨‍🏫 {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- FILTER RENTANG WAKTU -->
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-1 fw-semibold">Rentang Waktu</label>
                    <select name="date_range" class="form-select form-select-sm rounded-3">
                        <option value="">-- Semua Tanggal --</option>
                        <option value="today" {{ $filterDate === 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="this_week" {{ $filterDate === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="this_month" {{ $filterDate === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="older_30" {{ $filterDate === 'older_30' ? 'selected' : '' }}>Lebih dari 30 Hari</option>
                        <option value="older_90" {{ $filterDate === 'older_90' ? 'selected' : '' }}>Lebih dari 90 Hari</option>
                    </select>
                </div>

                <!-- SEARCH KEYWORD -->
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1 fw-semibold">Pencarian Judul / Topik</label>
                    <input type="text" name="search" class="form-control form-control-sm rounded-3" 
                           placeholder="Ketik judul perangkat ajar..." value="{{ $search }}">
                </div>

                <!-- TOMBOL FILTER -->
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3" title="Terapkan Filter">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->anyFilled(['type', 'user_id', 'date_range', 'search']))
                        <a href="{{ route('cms.perangkat.index') }}" class="btn btn-outline-danger btn-sm rounded-3" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- FORM BULK DELETE DENGAN CHECKBOXES -->
    <form id="formBulkDelete" method="POST" action="{{ route('cms.perangkat.bulk-delete') }}">
        @csrf
        
        <!-- FLOATING BAR UNTUK AKSI TERPILIH (MUNCUL OTOMATIS JIKA ADA CHECKBOX TERPILIH) -->
        <div id="floatingActionBar" class="card shadow-lg border-danger border-2 position-sticky top-0 mb-3 d-none" style="z-index: 1040; background: #ffffff;">
            <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                        <i class="bi bi-check2"></i>
                    </div>
                    <span class="fw-bold text-dark" id="selectedCountText">0 dokumen dipilih</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="deselectAll()">
                        Batal Pilih
                    </button>
                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold" onclick="confirmBulkDelete()">
                        <i class="bi bi-trash3-fill me-1"></i> Hapus Dokumen Terpilih
                    </button>
                </div>
            </div>
        </div>

        <!-- TABEL PERANGKAT AJAR -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="fw-bold text-dark mb-0">Daftar Berkas Perangkat Ajar</h5>
                    <span class="badge badge-soft-primary rounded-pill px-2.5">
                        {{ $paginatedItems->total() }} Ditemukan
                    </span>
                </div>
                <div class="text-muted small">
                    Centang baris yang ingin dihapus dari server hosting.
                </div>
            </div>

            <div class="card-body p-0">
                @if($paginatedItems->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder-x fs-1 text-secondary opacity-50 mb-2"></i>
                        <h6 class="fw-bold text-dark mb-1">Tidak Ada Perangkat Ajar Ditemukan</h6>
                        <p class="small text-muted mb-0">Coba ubah kriteria pencarian atau filter di atas.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="text-center">
                                        <input type="checkbox" class="form-check-input" id="checkAll" onclick="toggleSelectAll(this)" title="Pilih Semua di Halaman Ini">
                                    </th>
                                    <th style="width: 155px;">Tipe Dokumen</th>
                                    <th>Judul & Topik Pembelajaran</th>
                                    <th style="width: 180px;">Mata Pelajaran & Fase</th>
                                    <th style="width: 170px;">Pembuat (Author)</th>
                                    <th style="width: 120px;">Dibuat Pada</th>
                                    <th style="width: 80px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginatedItems as $item)
                                    <tr>
                                        <!-- CHECKBOX -->
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_items[]" value="{{ $item['composite_id'] }}" 
                                                   class="form-check-input row-checkbox" onchange="updateSelectedCount()">
                                        </td>

                                        <!-- TIPE DOKUMEN BADGE -->
                                        <td>
                                            @php
                                                $badgeClass = match($item['type_key']) {
                                                    'modul_ajar' => 'badge-soft-warning',
                                                    'atp'        => 'badge-soft-success',
                                                    'tp'         => 'badge-soft-primary',
                                                    'lkpd'       => 'badge-soft-info',
                                                    'prota'      => 'badge-soft-secondary',
                                                    'promes'     => 'badge-soft-purple',
                                                    'asesmen'    => 'badge-soft-danger',
                                                    'paket_soal' => 'badge-soft-cyan',
                                                    default      => 'badge-soft-primary',
                                                };
                                                $badgeIcon = match($item['type_key']) {
                                                    'modul_ajar' => 'bi-journal-bookmark-fill',
                                                    'atp'        => 'bi-diagram-3-fill',
                                                    'tp'         => 'bi-bullseye',
                                                    'lkpd'       => 'bi-file-earmark-spreadsheet-fill',
                                                    'prota'      => 'bi-calendar-range-fill',
                                                    'promes'     => 'bi-calendar-week-fill',
                                                    'asesmen'    => 'bi-clipboard-check-fill',
                                                    'paket_soal' => 'bi-patch-question-fill',
                                                    default      => 'bi-file-earmark-text',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1.5" style="font-size: 0.74rem;">
                                                <i class="bi {{ $badgeIcon }}"></i>
                                                <span>{{ $item['type_label'] }}</span>
                                            </span>
                                        </td>

                                        <!-- JUDUL -->
                                        <td>
                                            <div class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $item['judul'] }}</div>
                                            <div class="text-muted small" style="font-size: 0.7rem;">ID Database: #{{ $item['id'] }}</div>
                                        </td>

                                        <!-- MAPEL & FASE -->
                                        <td>
                                            <div class="text-secondary small fw-semibold">{{ $item['mapel'] }}</div>
                                            <span class="badge bg-light text-dark border" style="font-size: 0.68rem;">{{ $item['fase'] }}</span>
                                        </td>

                                        <!-- PEMBUAT -->
                                        <td>
                                            @if($item['is_guest'])
                                                <span class="badge badge-soft-warning rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                                    <i class="bi bi-person-x"></i>
                                                    <span>Tamu (Guest)</span>
                                                </span>
                                            @else
                                                <div class="d-flex align-items-center gap-1.5 small text-dark fw-semibold">
                                                    <i class="bi bi-person-check-fill text-primary"></i>
                                                    <span>{{ $item['author'] }}</span>
                                                </div>
                                            @endif
                                        </td>

                                        <!-- TANGGAL -->
                                        <td class="small text-muted" style="font-size: 0.76rem;">
                                            <div>{{ $item['created_at']->format('d M Y') }}</div>
                                            <div class="text-xs text-secondary opacity-75">{{ $item['created_at']->format('H:i') }} WIB</div>
                                        </td>

                                        <!-- AKSI LIHAT -->
                                        <td class="text-center">
                                            @if(!empty($item['view_url']))
                                                <a href="{{ $item['view_url'] }}" target="_blank" class="btn btn-sm btn-outline-primary p-1 rounded-circle" title="Lihat Dokumen">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if($paginatedItems->hasPages())
                <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                    {{ $paginatedItems->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL KONFIRMASI PENGHAPUSAN MASSAL -->
        <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-danger text-white border-0 py-3">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="modalConfirmDeleteLabel">
                            <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus Massal
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3 d-inline-flex mb-2">
                                <i class="bi bi-trash3-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark">Hapus Dokumen Terpilih Secara Permanen?</h5>
                            <p class="text-muted small mb-0">
                                Anda akan menghapus <strong id="modalSelectedCountText" class="text-danger">0 dokumen</strong> dari database hosting. Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div class="alert alert-warning border-0 bg-warning bg-opacity-15 py-2 px-3 small rounded-3 mb-0">
                            <i class="bi bi-info-circle-fill text-warning me-1"></i> Seluruh data terkait (kegiatan langkah, relasi modul) akan otomatis ikut dibersihkan untuk membebaskan ruang penyimpanan.
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" onclick="executeBulkDelete()">
                            Ya, Hapus Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- MODAL QUICK PURGE -->
<div class="modal fade" id="modalQuickPurge" tabindex="-1" aria-labelledby="modalQuickPurgeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="modalQuickPurgeLabel">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Pembersihan Cepat Space Hosting
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    Pilih target pembersihan berkas lama atau sesi percobaan publik untuk langsung membebaskan kuota database:
                </p>

                <!-- TARGET 1: DOKUMEN TAMU -->
                <form action="{{ route('cms.perangkat.quick-purge') }}" method="POST" class="mb-3" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh berkas percobaan tamu?')">
                    @csrf
                    <input type="hidden" name="purge_target" value="guest">
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between hover-shadow">
                        <div>
                            <div class="fw-bold text-dark">Hapus Semua Dokumen Tamu (Guest)</div>
                            <div class="text-muted small" style="font-size: 0.75rem;">Saat ini ada <strong>{{ $guestCounts }}</strong> berkas percobaan publik.</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            Bersihkan Tamu
                        </button>
                    </div>
                </form>

                <!-- TARGET 2: LEBIH DARI 30 HARI -->
                <form action="{{ route('cms.perangkat.quick-purge') }}" method="POST" class="mb-3" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas yang lebih dari 30 hari?')">
                    @csrf
                    <input type="hidden" name="purge_target" value="older_30">
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between hover-shadow">
                        <div>
                            <div class="fw-bold text-dark">Hapus Berkas &gt; 30 Hari</div>
                            <div class="text-muted small" style="font-size: 0.75rem;">Membersihkan perangkat ajar lama yang dibuat sebulan lalu.</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3">
                            Bersihkan &gt; 30 Hari
                        </button>
                    </div>
                </form>

                <!-- TARGET 3: LEBIH DARI 90 HARI -->
                <form action="{{ route('cms.perangkat.quick-purge') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas yang lebih dari 90 hari?')">
                    @csrf
                    <input type="hidden" name="purge_target" value="older_90">
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between hover-shadow">
                        <div>
                            <div class="fw-bold text-dark">Hapus Berkas &gt; 90 Hari (3 Bulan)</div>
                            <div class="text-muted small" style="font-size: 0.75rem;">Mengosongkan arsip lama semester terdahulu.</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            Bersihkan &gt; 90 Hari
                        </button>
                    </div>
                </form>

                <!-- TARGET 4: HAPUS SEMUA PERANGKAT (RESET TOTAL) -->
                <div class="p-3 rounded-3 border border-danger border-opacity-50 bg-danger bg-opacity-10 d-flex align-items-center justify-content-between hover-shadow">
                    <div>
                        <div class="fw-bold text-danger"><i class="bi bi-radioactive me-1"></i> Hapus SEMUA Perangkat di Database</div>
                        <div class="text-danger small" style="font-size: 0.75rem;">Mereset semua Modul, ATP, TP, LKPD, Prota, Promes, Asesmen & Soal. Mengirim notifikasi otomatis ke seluruh guru.</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalPurgeAll">
                        Reset Total
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HAPUS SEMUA PERANGKAT (PURGE ALL) -->
<div class="modal fade" id="modalPurgeAll" tabindex="-1" aria-labelledby="modalPurgeAllLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold fs-6" id="modalPurgeAllLabel">
                    <i class="bi bi-radioactive me-2"></i> Konfirmasi Hapus SEMUA Perangkat di Database
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex p-3 mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Tindakan Sangat Kritis & Permanen!</h5>
                    <p class="text-muted small">
                        Anda akan menghapus seluruh data perangkat ajar yang ada di database sistem:
                    </p>
                </div>

                <div class="alert alert-warning py-2 px-3 small border-0 rounded-3 mb-3">
                    <ul class="mb-0 ps-3">
                        <li><strong>{{ number_format($totalPerangkat) }} berkas perangkat ajar</strong> (Modul Ajar, ATP, TP, LKPD, Prota, Promes, Asesmen, Bank Soal) akan dihapus permanen.</li>
                        <li>Sistem akan <strong>secara otomatis mengirimkan notifikasi resmi</strong> kepada seluruh guru/user yang perangkatnya terhapus:</li>
                    </ul>
                </div>

                <div class="p-3 bg-light border border-warning rounded-3 mb-3">
                    <div class="small fw-bold text-dark mb-1"><i class="bi bi-bell-fill text-warning me-1"></i> Pesan Notifikasi Otomatis ke User:</div>
                    <div class="small text-danger fst-italic bg-white p-2 rounded border">
                        "Perangkat dihapus karena ada ketidaksesuaian dengan cp dan atp, mohon generate ulang, by. vicky koroh"
                    </div>
                </div>

                <form id="formPurgeAll" action="{{ route('cms.perangkat.purge-all') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Ketik kata konfirmasi berikut untuk melanjutkan: <code class="text-danger fw-bold">HAPUS-SEMUA</code></label>
                        <input type="text" id="purgeConfirmInput" class="form-control form-control-sm text-center fw-bold text-danger" placeholder="HAPUS-SEMUA" autocomplete="off" onkeyup="checkPurgeConfirmation()">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" id="btnExecutePurgeAll" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold" disabled>
                            <i class="bi bi-trash3-fill me-1"></i> Ya, Hapus SEMUA Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT BULK SELECTION -->
<script>
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateSelectedCount();
    }

    function deselectAll() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const checkAll = document.getElementById('checkAll');
        if (checkAll) checkAll.checked = false;
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;
        const floatingBar = document.getElementById('floatingActionBar');
        const countText = document.getElementById('selectedCountText');

        if (count > 0) {
            floatingBar.classList.remove('d-none');
            countText.innerText = count + ' dokumen perangkat ajar dipilih';
        } else {
            floatingBar.classList.add('d-none');
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;
        if (count === 0) {
            alert('Silakan pilih minimal 1 dokumen terlebih dahulu.');
            return;
        }

        document.getElementById('modalSelectedCountText').innerText = count + ' dokumen perangkat ajar';
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmDelete'));
        modal.show();
    }

    function executeBulkDelete() {
        document.getElementById('formBulkDelete').submit();
    }

    function checkPurgeConfirmation() {
        const val = document.getElementById('purgeConfirmInput').value.trim();
        const btn = document.getElementById('btnExecutePurgeAll');
        if (val === 'HAPUS-SEMUA') {
            btn.removeAttribute('disabled');
        } else {
            btn.setAttribute('disabled', 'disabled');
        }
    }
</script>
@endsection
