@extends('layouts.app')

@section('title', 'CMS Tahun Ajaran')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-calendar3 text-primary me-2"></i> CMS Tahun Ajaran</h4>
        <p class="text-muted small mb-0">Kelola tahun ajaran aktif dan buat periode akademik baru secara fleksibel.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <form action="{{ route('cms.tahun-ajaran.quick-generate') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-lightning-charge-fill me-1 text-warning"></i> Tambah Cepat (2026/2027 & 2027/2028)
            </button>
        </form>
        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddTahunAjaran">
            <i class="bi bi-plus-circle me-1"></i> Tambah Tahun Ajaran Baru
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Periode Tanggal</th>
                        <th>Status Aktif</th>
                        <th width="24%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAjarans as $idx => $ta)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>
                                <strong class="text-dark fs-6">{{ $ta->nama }}</strong>
                            </td>
                            <td>
                                @if($ta->semester == 1)
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                                        Semester 1 (Ganjil)
                                    </span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1">
                                        Semester 2 (Genap)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-secondary">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $ta->tanggal_mulai ? $ta->tanggal_mulai->format('d M Y') : 'Belum diatur' }} 
                                    s/d 
                                    {{ $ta->tanggal_selesai ? $ta->tanggal_selesai->format('d M Y') : 'Belum diatur' }}
                                </small>
                            </td>
                            <td>
                                @if($ta->is_active)
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sedang Aktif
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                    @if(!$ta->is_active)
                                        <form action="{{ route('cms.tahun-ajaran.activate', $ta->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Jadikan Tahun Ajaran Aktif">
                                                <i class="bi bi-check2"></i> Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1 btn-edit-ta"
                                        data-id="{{ $ta->id }}"
                                        data-nama="{{ $ta->nama }}"
                                        data-semester="{{ $ta->semester }}"
                                        data-mulai="{{ $ta->tanggal_mulai ? $ta->tanggal_mulai->format('Y-m-d') : '' }}"
                                        data-selesai="{{ $ta->tanggal_selesai ? $ta->tanggal_selesai->format('Y-m-d') : '' }}"
                                        data-active="{{ $ta->is_active ? '1' : '0' }}"
                                        title="Edit Tahun Ajaran">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form id="delete-form-{{ $ta->id }}" action="{{ route('cms.tahun-ajaran.destroy', $ta->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" 
                                            onclick="confirmDelete('delete-form-{{ $ta->id }}', 'Tahun Ajaran {{ $ta->nama }} (Sem. {{ $ta->semester }})')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada data tahun ajaran. Silakan tambah tahun ajaran baru atau gunakan tombol Tambah Cepat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH TAHUN AJARAN -->
<div class="modal fade" id="modalAddTahunAjaran" tabindex="-1" aria-labelledby="modalAddTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fs-6 fw-bold" id="modalAddTahunAjaranLabel">
                    <i class="bi bi-calendar-plus me-2"></i> Tambah Tahun Ajaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cms.tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_ta" class="form-label fw-semibold small">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_ta" name="nama" list="listTahunAjaran" placeholder="Contoh: 2026/2027" required>
                        <datalist id="listTahunAjaran">
                            <option value="2026/2027">
                            <option value="2027/2028">
                            <option value="2028/2029">
                            <option value="2029/2030">
                        </datalist>
                        <div class="form-text text-muted small">Format baku: <strong>YYYY/YYYY</strong> (misal: 2026/2027).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Semester <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="sem1" value="1" checked>
                                <label class="form-check-label small" for="sem1">
                                    Semester 1 (Ganjil)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="sem2" value="2">
                                <label class="form-check-label small" for="sem2">
                                    Semester 2 (Genap)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="tanggal_mulai" class="form-label fw-semibold small">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="col-6">
                            <label for="tanggal_selesai" class="form-label fw-semibold small">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active_add" name="is_active" value="1" checked>
                        <label class="form-check-label small fw-semibold" for="is_active_add">
                            Jadikan sebagai Tahun Ajaran Aktif Saat Ini
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Simpan Tahun Ajaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT TAHUN AJARAN -->
<div class="modal fade" id="modalEditTahunAjaran" tabindex="-1" aria-labelledby="modalEditTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fs-6 fw-bold" id="modalEditTahunAjaranLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Data Tahun Ajaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditTahunAjaran" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label fw-semibold small">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Semester <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="edit_sem1" value="1">
                                <label class="form-check-label small" for="edit_sem1">
                                    Semester 1 (Ganjil)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="edit_sem2" value="2">
                                <label class="form-check-label small" for="edit_sem2">
                                    Semester 2 (Genap)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="edit_tanggal_mulai" class="form-label fw-semibold small">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="col-6">
                            <label for="edit_tanggal_selesai" class="form-label fw-semibold small">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="edit_tanggal_selesai" name="tanggal_selesai">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label small fw-semibold" for="edit_is_active">
                            Tahun Ajaran Aktif
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-edit-ta').on('click', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const semester = $(this).data('semester');
            const mulai = $(this).data('mulai');
            const selesai = $(this).data('selesai');
            const active = $(this).data('active');

            $('#formEditTahunAjaran').attr('action', '{{ url("cms/tahun-ajaran") }}/' + id);
            $('#edit_nama').val(nama);
            if (semester == 1) {
                $('#edit_sem1').prop('checked', true);
            } else {
                $('#edit_sem2').prop('checked', true);
            }
            $('#edit_tanggal_mulai').val(mulai);
            $('#edit_tanggal_selesai').val(selesai);
            $('#edit_is_active').prop('checked', active == '1');

            $('#modalEditTahunAjaran').modal('show');
        });
    });
</script>
@endpush
@endsection
