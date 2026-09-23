@extends('layouts.app')

@section('title', 'Kotak Usul & Saran Pengguna')

@section('content')
<div class="container-fluid px-0">
    
    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                    <i class="bi bi-chat-heart-fill me-1"></i> FEEDBACK & USER VOICE
                </span>
                <span class="text-muted small">Pusat Masukan Pengguna & Tamu</span>
            </div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-chat-quote-fill text-warning"></i> Kotak Usul, Saran & Laporan Kekurangan
            </h3>
            <p class="text-muted small mb-0">
                Pantau langsung ide fitur baru, saran perbaikan, dan laporan kendala yang dikirimkan oleh guru maupun tamu.
            </p>
        </div>
        <div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Landing Page
            </a>
        </div>
    </div>

    <!-- METRICS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary fs-3">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Masukan</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($metrics['total']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger fs-3">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Perlu Ditinjau (Baru)</div>
                        <h3 class="fw-bold mb-0 text-danger">{{ number_format($metrics['baru']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning fs-3">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Sedang Ditinjau</div>
                        <h3 class="fw-bold mb-0 text-warning">{{ number_format($metrics['ditinjau']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success fs-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Telah Diterapkan</div>
                        <h3 class="fw-bold mb-0 text-success">{{ number_format($metrics['diterapkan']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('cms.feedbacks.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Cari nama, email, judul, isi saran...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>🔴 Baru (Belum Ditinjau)</option>
                        <option value="ditinjau" {{ request('status') === 'ditinjau' ? 'selected' : '' }}>🟡 Sedang Ditinjau</option>
                        <option value="diterapkan" {{ request('status') === 'diterapkan' ? 'selected' : '' }}>🟢 Telah Diterapkan</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>⚪ Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        <option value="usul_fitur" {{ request('kategori') === 'usul_fitur' ? 'selected' : '' }}>💡 Usul Fitur Baru</option>
                        <option value="perbaikan_kekurangan" {{ request('kategori') === 'perbaikan_kekurangan' ? 'selected' : '' }}>🛠️ Perbaikan / Kekurangan</option>
                        <option value="laporan_bug" {{ request('kategori') === 'laporan_bug' ? 'selected' : '' }}>⚠️ Laporan Kendala / Bug</option>
                        <option value="pertanyaan" {{ request('kategori') === 'pertanyaan' ? 'selected' : '' }}>❓ Pertanyaan</option>
                        <option value="apresiasi" {{ request('kategori') === 'apresiasi' ? 'selected' : '' }}>⭐ Apresiasi</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'kategori']))
                        <a href="{{ route('cms.feedbacks.index') }}" class="btn btn-outline-secondary rounded-pill" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th width="4%" class="text-center">No</th>
                            <th width="14%">Waktu & Perangkat</th>
                            <th width="18%">Pengirim</th>
                            <th width="15%">Kategori & Rating</th>
                            <th>Judul & Isi Usulan</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $idx => $f)
                            <tr>
                                <td class="text-center text-muted fw-semibold">
                                    {{ $feedbacks->firstItem() + $idx }}
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $f->created_at->format('d M Y') }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        {{ $f->created_at->format('H:i') }} WIB &bull; 
                                        <span class="badge bg-light text-secondary border">{{ $f->device_type ?? 'Desktop' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark d-flex align-items-center gap-1.5">
                                        <i class="bi bi-person-circle text-primary"></i>
                                        <span>{{ $f->nama }}</span>
                                    </div>
                                    @if($f->email)
                                        <div class="text-muted small" style="font-size: 0.78rem;">
                                            <i class="bi bi-envelope me-1"></i>{{ $f->email }}
                                        </div>
                                    @endif
                                    @if($f->no_hp)
                                        <div class="text-muted small" style="font-size: 0.78rem;">
                                            <i class="bi bi-whatsapp text-success me-1"></i>{{ $f->no_hp }}
                                        </div>
                                    @endif
                                    @if($f->user)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.68rem;">
                                            Guru Terdaftar
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border" style="font-size: 0.68rem;">
                                            Tamu (Guest)
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $f->kategori_badge }} mb-1 d-inline-block">
                                        {{ $f->kategori_label }}
                                    </span>
                                    <div class="text-warning small" style="font-size: 0.76rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $f->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                        <span class="text-muted ms-1">({{ $f->rating }}/5)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $f->judul }}</div>
                                    <div class="text-muted small" style="line-height: 1.4;">
                                        {{ Str::limit($f->pesan, 120) }}
                                    </div>
                                    @if($f->catatan_admin)
                                        <div class="mt-1.5 p-1.5 bg-light rounded text-primary small" style="font-size: 0.75rem;">
                                            <strong><i class="bi bi-sticky me-1"></i>Catatan Admin:</strong> {{ $f->catatan_admin }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $f->status_badge }} px-2.5 py-1.5 rounded-pill text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        {{ $f->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalFeedback{{ $f->id }}" title="Lihat & Tindak Lanjuti">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <form action="{{ route('cms.feedbacks.destroy', $f->id) }}" method="POST" id="deleteFeedbackForm{{ $f->id }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('deleteFeedbackForm{{ $f->id }}', 'masukan dari {{ $f->nama }}')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- MODAL DETAIL & TINDAK LANJUT -->
                                    <div class="modal fade" id="modalFeedback{{ $f->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-light">
                                                    <div>
                                                        <h6 class="modal-title fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                                            <span class="badge {{ $f->kategori_badge }}">{{ $f->kategori_label }}</span>
                                                            <span>{{ $f->judul }}</span>
                                                        </h6>
                                                        <div class="text-muted small mt-1" style="font-size: 0.76rem;">
                                                            Dari: <strong>{{ $f->nama }}</strong> &bull; {{ $f->created_at->format('d F Y, H:i') }} WIB &bull; IP: {{ $f->ip_address ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4 text-start">
                                                    <!-- ISI PESAN LENGKAP -->
                                                    <h6 class="fw-bold text-dark small mb-2"><i class="bi bi-card-text me-1 text-primary"></i> Isi Usulan, Masukan & Hal yang Kurang:</h6>
                                                    <div class="p-3 bg-light rounded-3 border text-secondary mb-4" style="line-height: 1.7; font-size: 0.9rem; white-space: pre-line;">
                                                        {{ $f->pesan }}
                                                    </div>

                                                    <!-- FORM UBAH STATUS & CATATAN ADMIN -->
                                                    <form action="{{ route('cms.feedbacks.update-status', $f->id) }}" method="POST">
                                                        @csrf
                                                        <div class="card border border-primary border-opacity-25 bg-primary bg-opacity-10 rounded-3 p-3">
                                                            <h6 class="fw-bold text-primary small mb-3">
                                                                <i class="bi bi-check2-square me-1"></i> Tindak Lanjut Superadmin:
                                                            </h6>
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-sm-6">
                                                                    <label class="form-label small fw-semibold text-dark">Status Masukan:</label>
                                                                    <select name="status" class="form-select form-select-sm" required>
                                                                        <option value="baru" {{ $f->status === 'baru' ? 'selected' : '' }}>🔴 Baru</option>
                                                                        <option value="ditinjau" {{ $f->status === 'ditinjau' ? 'selected' : '' }}>🟡 Sedang Ditinjau</option>
                                                                        <option value="diterapkan" {{ $f->status === 'diterapkan' ? 'selected' : '' }}>🟢 Telah Diterapkan di Sistem</option>
                                                                        <option value="selesai" {{ $f->status === 'selesai' ? 'selected' : '' }}>⚪ Selesai / Ditutup</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label class="form-label small fw-semibold text-dark">Rating yang Diberikan:</label>
                                                                    <div class="text-warning pt-1">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <i class="bi bi-star{{ $i <= $f->rating ? '-fill' : '' }} fs-5"></i>
                                                                        @endfor
                                                                        <span class="text-dark fw-bold ms-1">({{ $f->rating }} / 5)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-semibold text-dark">Catatan Internal Admin:</label>
                                                                <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Tuliskan catatan tindak lanjut, rencana rilis fitur, dll...">{{ $f->catatan_admin }}</textarea>
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                                                                    <i class="bi bi-save me-1"></i> Simpan Status & Catatan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer bg-light py-2">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada usul atau saran yang masuk sesuai filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            @if($feedbacks->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
