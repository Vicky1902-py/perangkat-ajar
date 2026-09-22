@extends('layouts.app')

@section('title', 'Buat Alur Tujuan Pembelajaran (ATP)')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('atp.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-block">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar ATP
                </a>
                <h4 class="fw-bold text-dark mb-0">Form Pembuatan ATP</h4>
            </div>
            <a href="{{ route('generator.index') }}" class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold">
                <i class="bi bi-lightning-charge-fill me-1"></i> Gunakan Generator 1-Klik Saja
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('atp.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="judul" class="form-label fw-semibold small">Judul ATP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: ATP Dasar-dasar PPLG Fase E">
                        </div>
                        <div class="col-md-3">
                            <label for="mata_pelajaran_id" class="form-label fw-semibold small">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                <option value="" disabled selected>-- Pilih Mapel --</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fase_id" class="form-label fw-semibold small">Fase / Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="fase_id" name="fase_id" required>
                                <option value="" disabled selected>-- Pilih Fase --</option>
                                @foreach($fases as $f)
                                    <option value="{{ $f->id }}">Fase {{ $f->kode }} ({{ $f->kelas_range }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold small mb-0">Tahun Ajaran</label>
                                <button type="button" class="btn btn-link p-0 text-decoration-none small text-primary fw-medium" id="btnToggleTaManualAtp" style="font-size: 0.75rem;">
                                    <i class="bi bi-pencil-square me-1"></i><span id="btnToggleTaTextAtp">Ketik Manual</span>
                                </button>
                            </div>

                            <!-- Mode Dropdown -->
                            <div id="taDropdownWrapperAtp">
                                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ $ta->is_active ? 'selected' : '' }}>
                                            {{ $ta->nama }} (Sem. {{ $ta->semester }}) {{ $ta->is_active ? '★ Aktif' : '' }}
                                        </option>
                                    @endforeach
                                    <option value="manual" class="fw-semibold text-primary">+ Ketik Manual Tahun Ajaran Baru...</option>
                                </select>
                            </div>

                            <!-- Mode Manual -->
                            <div id="taManualWrapperAtp" style="display: none;">
                                <input type="hidden" name="tahun_ajaran_mode" id="tahun_ajaran_mode_atp" value="dropdown">
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" class="form-control" name="tahun_ajaran_manual" id="tahun_ajaran_manual_atp" placeholder="Contoh: 2026/2027" maxlength="20">
                                    <select class="form-select" name="semester_manual" id="semester_manual_atp" style="max-width: 105px;">
                                        <option value="1">Sem. 1</option>
                                        <option value="2">Sem. 2</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-info-circle"></i> Simpan otomatis</small>
                                    <button type="button" class="btn btn-link p-0 text-danger text-decoration-none" id="btnCancelTaManualAtp" style="font-size: 0.72rem;">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="deskripsi" class="form-label fw-semibold small">Deskripsi / Rasional ATP</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Catatan pengantar atau rasional penyusunan alur...">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('atp.index') }}" class="btn btn-light border rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan ATP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function switchToTaManualAtp() {
        $('#taDropdownWrapperAtp').hide();
        $('#taManualWrapperAtp').fadeIn(150);
        $('#tahun_ajaran_mode_atp').val('manual');
        $('#tahun_ajaran_id').prop('disabled', true);
        $('#tahun_ajaran_manual_atp').focus();
        $('#btnToggleTaTextAtp').text('Pilih Daftar');
        $('#btnToggleTaManualAtp').find('i').removeClass('bi-pencil-square').addClass('bi-list-ul');
    }

    function switchToTaDropdownAtp() {
        $('#taManualWrapperAtp').hide();
        $('#taDropdownWrapperAtp').fadeIn(150);
        $('#tahun_ajaran_mode_atp').val('dropdown');
        $('#tahun_ajaran_id').prop('disabled', false);
        if ($('#tahun_ajaran_id').val() === 'manual') {
            $('#tahun_ajaran_id').val($('#tahun_ajaran_id option:first').val());
        }
        $('#btnToggleTaTextAtp').text('Ketik Manual');
        $('#btnToggleTaManualAtp').find('i').removeClass('bi-list-ul').addClass('bi-pencil-square');
    }

    $('#btnToggleTaManualAtp').on('click', function() {
        if ($('#tahun_ajaran_mode_atp').val() === 'manual') {
            switchToTaDropdownAtp();
        } else {
            switchToTaManualAtp();
        }
    });

    $('#btnCancelTaManualAtp').on('click', switchToTaDropdownAtp);

    $('#tahun_ajaran_id').on('change', function() {
        if ($(this).val() === 'manual') {
            switchToTaManualAtp();
        }
    });
</script>
@endpush
