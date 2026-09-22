@extends('layouts.app')

@section('title', 'Manajemen Pengguna (CMS Superadmin)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-people-fill text-danger me-2"></i> Manajemen Pengguna Sistem</h4>
        <p class="text-muted small mb-0">Kelola akun pengguna, filter data guru, serta kontrol hak akses pembagian perangkat ajar.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna Baru
    </a>
</div>

<!-- FORM FILTER SUPERADMIN: MAPEL, JURUSAN, SEKOLAH -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-funnel-fill text-primary me-2"></i> Filter Multi-Kriteria Pengguna (Guru)</span>
            @if(request()->anyFilled(['mapel', 'jurusan', 'satuan_pendidikan_id', 'role', 'search']))
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: 0.75rem;">
                    <i class="bi bi-x-circle me-1"></i> Reset Filter
                </a>
            @endif
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="row g-3">
                <!-- Filter 1: Mata Pelajaran -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Mata Pelajaran Diampu</label>
                    <input type="text" name="mapel" list="mapelListOptions" value="{{ request('mapel') }}" class="form-control form-control-sm" placeholder="Ketik atau pilih mapel...">
                    <datalist id="mapelListOptions">
                        @foreach($allMapels as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Filter 2: Jurusan / Program Keahlian -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Jurusan / Program Keahlian</label>
                    <input type="text" name="jurusan" list="jurusanListOptions" value="{{ request('jurusan') }}" class="form-control form-control-sm" placeholder="Ketik atau pilih jurusan...">
                    <datalist id="jurusanListOptions">
                        @foreach($allJurusans as $j)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Filter 3: Satuan Pendidikan (Sekolah) -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Satuan Pendidikan (Sekolah)</label>
                    <select name="satuan_pendidikan_id" class="form-select form-select-sm">
                        <option value="">-- Semua Sekolah --</option>
                        @foreach($sekolahs as $s)
                            <option value="{{ $s->id }}" {{ request('satuan_pendidikan_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 4: Cari Kata Kunci -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Cari Nama / Email / NIP</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Kata kunci...">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL DATA PENGGUNA -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 datatable">
                <thead class="table-light">
                    <tr>
                        <th width="4%">No</th>
                        <th>Nama & NIP</th>
                        <th>Mapel & Jurusan</th>
                        <th>Satuan Pendidikan</th>
                        <th>Peran (Role)</th>
                        <th>Hak Akses Perangkat</th>
                        <th>Perangkat Ajar</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $idx => $u)
                        @php
                            $totalPerangkat = $u->alur_tujuan_pembelajarans_count + $u->modul_ajars_count + $u->lkpds_count + $u->program_tahunans_count + $u->program_semesters_count + $u->asesmens_count;
                        @endphp
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $u->name }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">NIP: {{ $u->nip ?? '-' }}</div>
                                <div class="text-muted small" style="font-size: 0.72rem;">{{ $u->email }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ $u->mata_pelajaran_diampu ?? '-' }}</div>
                                @if($u->jurusan)
                                    <span class="badge bg-light text-primary border" style="font-size: 0.7rem;">
                                        <i class="bi bi-gear-fill me-1"></i>{{ $u->jurusan }}
                                    </span>
                                @else
                                    <span class="text-muted small" style="font-size: 0.72rem;">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-secondary fw-semibold">{{ $u->satuanPendidikan->nama ?? 'Semua Sekolah' }}</small>
                            </td>
                            <td>
                                @if($u->isSuperAdmin())
                                    <span class="badge badge-role-superadmin">Superadmin</span>
                                @elseif($u->isAdminSekolah())
                                    <span class="badge badge-role-admin_sekolah">Admin Sekolah</span>
                                @else
                                    <span class="badge badge-role-guru">Guru</span>
                                @endif
                            </td>
                            <td>
                                @if($u->isSuperAdmin())
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                        <i class="bi bi-unlock-fill me-1"></i>Semua Perangkat (Superadmin)
                                    </span>
                                @elseif($u->can_view_all_devices)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                        <i class="bi bi-eye-fill me-1"></i>Semua Perangkat Guru
                                    </span>
                                @elseif($u->grantedDeviceUsers->count() > 0)
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                                        <i class="bi bi-people-fill me-1"></i>Izin {{ $u->grantedDeviceUsers->count() }} Guru
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border">
                                        <i class="bi bi-lock-fill me-1"></i>Perangkat Sendiri
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info border">
                                    {{ $totalPerangkat }} Dokumen
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($u->isGuru())
                                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalAccess-{{ $u->id }}" title="Kelola Hak Akses Perangkat">
                                            <i class="bi bi-shield-lock"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-outline-secondary" title="Ubah Profil Pengguna"><i class="bi bi-pencil"></i></a>
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" id="del-user-{{ $u->id }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('del-user-{{ $u->id }}', 'pengguna {{ $u->name }}')" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL PENGATURAN HAK AKSES PERANGKAT GURU -->
                        @if($u->isGuru())
                            <div class="modal fade" id="modalAccess-{{ $u->id }}" tabindex="-1" aria-labelledby="modalAccessLabel-{{ $u->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('users.device-access', $u->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title fs-6 fw-bold text-dark" id="modalAccessLabel-{{ $u->id }}">
                                                    <i class="bi bi-shield-lock-fill text-primary me-2"></i> Hak Akses Perangkat: {{ $u->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <p class="text-muted small mb-3">
                                                    Sesuai kebijakan privasi sistem, secara default guru hanya dapat melihat perangkat ajar miliknya sendiri. 
                                                    Superadmin dapat mengizinkan guru ini melihat perangkat ajar dari seluruh user atau guru-guru tertentu.
                                                </p>

                                                <!-- Pilihan 1: Buka Akses Semua Perangkat -->
                                                <div class="form-check form-switch mb-3 p-3 bg-light rounded border">
                                                    <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="switchAll-{{ $u->id }}" name="can_view_all_devices" value="1" {{ $u->can_view_all_devices ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold text-dark" for="switchAll-{{ $u->id }}">
                                                        Beri Akses Lihat SEMUA Perangkat Seluruh Guru
                                                    </label>
                                                    <div class="text-muted small mt-1 ps-4" style="font-size: 0.75rem;">
                                                        Jika diaktifkan, guru ini dapat melihat seluruh hasil generate TP, ATP, Modul Ajar, LKPD, Prota, Promes, dan Asesmen dari semua guru di sistem.
                                                    </div>
                                                </div>

                                                <!-- Pilihan 2: Izin Per Guru Tertentu -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-secondary small">
                                                        Atau Beri Izin Melihat Perangkat dari Guru Tertentu:
                                                    </label>
                                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                                        @php
                                                            $currentGranted = $u->grantedDeviceUsers->pluck('id')->toArray();
                                                        @endphp
                                                        @foreach($allGurus->where('id', '!=', $u->id) as $guruItem)
                                                            <div class="form-check py-1 border-bottom border-light">
                                                                <input class="form-check-input" type="checkbox" name="granted_user_ids[]" value="{{ $guruItem->id }}" id="grant-{{ $u->id }}-{{ $guruItem->id }}" {{ in_array($guruItem->id, $currentGranted) ? 'checked' : '' }}>
                                                                <label class="form-check-label small text-dark d-flex justify-content-between" for="grant-{{ $u->id }}-{{ $guruItem->id }}">
                                                                    <span>{{ $guruItem->name }}</span>
                                                                    <span class="text-muted" style="font-size: 0.72rem;">{{ $guruItem->mata_pelajaran_diampu ?? $guruItem->satuanPendidikan->nama ?? 'Guru' }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="form-text text-xs" style="font-size: 0.72rem;">Pilih satu atau lebih guru yang dokumennya boleh dilihat oleh {{ $u->name }}.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light py-2">
                                                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">
                                                    <i class="bi bi-save me-1"></i> Simpan Hak Akses
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
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
        if (!$.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable({
                language: {
                    search: "Pencarian Cepat:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    },
                    zeroRecords: "Tidak ditemukan data yang sesuai kriteria pencarian"
                }
            });
        }
    });
</script>
@endpush
