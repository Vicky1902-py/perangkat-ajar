@extends('layouts.app')

@section('title', 'Buat Paket Soal Baru - Smart Soal by. Vicky')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">

    <!-- BREADCRUMB & BACK BUTTON -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <a href="{{ route('paket-soal.index') }}" class="text-secondary small text-decoration-none d-inline-flex align-items-center gap-1 mb-1">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Bank Soal
            </a>
            <h4 class="fw-bold text-dark mb-0" style="color: #0b3b60 !important;">
                Generator Kisi-Kisi & Paket Soal (Sistem Pakar)
            </h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-soft-warning rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.74rem;">
                <i class="bi bi-stars me-1"></i> Smart Soal by. Vicky Koroh
            </span>
        </div>
    </div>

    <!-- NOTIFIKASI ERROR -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan pengisian formulir:</div>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- FORM UTAMA -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3.5 px-4 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-ui-checks-grid text-primary"></i>
                        Konfigurasi Sumber Perangkat Ajar & Spesifikasi Soal
                    </h5>
                    <div class="text-muted small mt-1">
                        Pilih Modul Ajar yang sudah ada di database agar materi, indikator, dan stimulus soal tersinkronisasi 100% secara relevan.
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('paket-soal.store') }}" method="POST" id="formGeneratorSoal">
                        @csrf

                        <!-- LANGKAH 1: SUMBER PERANGKAT AJAR -->
                        <div class="mb-4 pb-3 border-bottom">
                            <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">1</span>
                                Sumber Perangkat Ajar (Sinkronisasi Otomatis)
                            </label>

                            <!-- PILIH DARI MODUL AJAR (DEFAULT / REKOMENDASI) -->
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-semibold">Pilih dari Modul Ajar yang Sudah Ada <span class="text-primary">(Direkomendasikan)</span></label>
                                <select name="modul_ajar_id" id="modulAjarSelect" class="form-select rounded-3">
                                    <option value="">-- Pilih Modul Ajar Sebagai Rujukan --</option>
                                    @foreach($modulAjars as $m)
                                        <option value="{{ $m->id }}" 
                                                data-mapel-id="{{ $m->mata_pelajaran_id }}"
                                                data-fase-id="{{ $m->fase_id }}"
                                                data-tp-id="{{ $m->tujuan_pembelajaran_id }}"
                                                data-judul="{{ $m->judul }}"
                                                {{ (old('modul_ajar_id') == $m->id || ($selectedModul && $selectedModul->id == $m->id)) ? 'selected' : '' }}>
                                            📖 {{ $m->judul }} ({{ $m->mataPelajaran->nama ?? 'Mapel' }} - Fase {{ $m->fase->kode ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small" style="font-size: 0.75rem;">
                                    Saat Modul Ajar dipilih, mata pelajaran, fase, dan topik esensial akan terisi secara otomatis.
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- MATA PELAJARAN -->
                                <div class="col-md-7">
                                    <label class="form-label small text-muted fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select name="mata_pelajaran_id" id="mapelSelect" class="form-select rounded-3" required>
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        @foreach($mapels as $mapel)
                                            <option value="{{ $mapel->id }}" {{ (old('mata_pelajaran_id') == $mapel->id || ($selectedModul && $selectedModul->mata_pelajaran_id == $mapel->id)) ? 'selected' : '' }}>
                                                {{ $mapel->nama }} ({{ $mapel->kelompok ?? 'Kejuruan' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- FASE -->
                                <div class="col-md-5">
                                    <label class="form-label small text-muted fw-semibold">Fase / Kelas <span class="text-danger">*</span></label>
                                    <select name="fase_id" id="faseSelect" class="form-select rounded-3" required>
                                        <option value="">-- Pilih Fase --</option>
                                        @foreach($fases as $f)
                                            <option value="{{ $f->id }}" {{ (old('fase_id') == $f->id || ($selectedModul && $selectedModul->fase_id == $f->id)) ? 'selected' : '' }}>
                                                Fase {{ $f->kode }} (Kelas {{ $f->kelas_range }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- LANGKAH 2: SPESIFIKASI NASKAH ASESMEN -->
                        <div class="mb-4 pb-3 border-bottom">
                            <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">2</span>
                                Konfigurasi Naskah Asesmen & Ujian
                            </label>

                            <!-- JUDUL NASKAH -->
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-semibold">Judul Naskah Asesmen / Ujian</label>
                                <input type="text" name="judul" id="judulInput" class="form-control rounded-3" 
                                       placeholder="Contoh: Asesmen Sumatif Lingkup Materi: Perawatan Mesin Otomotif" 
                                       value="{{ old('judul', $selectedModul ? 'Asesmen Sumatif: ' . $selectedModul->judul : '') }}">
                            </div>

                            <div class="row g-3">
                                <!-- JENIS UJIAN -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted fw-semibold">Jenis Asesmen <span class="text-danger">*</span></label>
                                    <select name="jenis_ujian" class="form-select rounded-3" required>
                                        <option value="sumatif_lingkup_materi" {{ old('jenis_ujian') === 'sumatif_lingkup_materi' ? 'selected' : '' }}>
                                            Sumatif Lingkup Materi (Harian / Bab)
                                        </option>
                                        <option value="sts" {{ old('jenis_ujian') === 'sts' ? 'selected' : '' }}>
                                            Sumatif Tengah Semester (STS)
                                        </option>
                                        <option value="sas" {{ old('jenis_ujian') === 'sas' ? 'selected' : '' }}>
                                            Sumatif Akhir Semester (SAS)
                                        </option>
                                        <option value="diagnostik" {{ old('jenis_ujian') === 'diagnostik' ? 'selected' : '' }}>
                                            Asesmen Diagnostik Awal Kognitif
                                        </option>
                                        <option value="kuis_harian" {{ old('jenis_ujian') === 'kuis_harian' ? 'selected' : '' }}>
                                            Kuis Cepat Vokasi / Formatif
                                        </option>
                                    </select>
                                </div>

                                <!-- ALOKASI WAKTU -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted fw-semibold">Alokasi Waktu Pengerjaan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="alokasi_waktu_menit" class="form-select rounded-start-3" required>
                                            <option value="45" {{ old('alokasi_waktu_menit') == 45 ? 'selected' : '' }}>45 Menit (1 Jam Pelajaran)</option>
                                            <option value="60" {{ old('alokasi_waktu_menit', 60) == 60 ? 'selected' : '' }}>60 Menit (Standar Formatif/Sumatif)</option>
                                            <option value="90" {{ old('alokasi_waktu_menit') == 90 ? 'selected' : '' }}>90 Menit (2 Jam Pelajaran)</option>
                                            <option value="120" {{ old('alokasi_waktu_menit') == 120 ? 'selected' : '' }}>120 Menit (STS / SAS Ujian Penuh)</option>
                                        </select>
                                        <span class="input-group-text bg-light text-muted">Menit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LANGKAH 3: BENTUK SOAL & KOMPOSISI -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark d-flex align-items-center gap-1.5 mb-2">
                                <span class="badge bg-primary text-white rounded-circle p-1" style="width: 22px; height: 22px; font-size: 0.75rem;">3</span>
                                Bentuk Soal & Komposisi Butir
                            </label>

                            <!-- PILIHAN BENTUK SOAL (RADIO CARDS) -->
                            <div class="row g-2 mb-3">
                                <!-- OPSI 1: CAMPURAN (PG + ISIAN) -->
                                <div class="col-md-4">
                                    <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukCampuran" value="campuran" 
                                                   {{ old('bentuk_soal', 'campuran') === 'campuran' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                            <span class="form-check-label fw-bold text-dark small d-block">
                                                Campuran (PG + Isian)
                                            </span>
                                            <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                Pilihan Ganda & Isian studi kasus sekaligus.
                                            </span>
                                        </div>
                                    </label>
                                </div>

                                <!-- OPSI 2: PILIHAN GANDA SAJA -->
                                <div class="col-md-4">
                                    <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukPg" value="pg" 
                                                   {{ old('bentuk_soal') === 'pg' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                            <span class="form-check-label fw-bold text-dark small d-block">
                                                Pilihan Ganda Saja
                                            </span>
                                            <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                Murni soal objektif opsi A, B, C, D, E.
                                            </span>
                                        </div>
                                    </label>
                                </div>

                                <!-- OPSI 3: ISIAN / URAIAN SAJA -->
                                <div class="col-md-4">
                                    <label class="card h-100 p-3 rounded-3 border cursor-pointer hover-shadow" style="border-color: #e2e8f0;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="bentuk_soal" id="bentukIsian" value="isian" 
                                                   {{ old('bentuk_soal') === 'isian' ? 'checked' : '' }} onchange="toggleBentukSoal()">
                                            <span class="form-check-label fw-bold text-dark small d-block">
                                                Isian / Uraian Saja
                                            </span>
                                            <span class="text-muted small d-block" style="font-size: 0.72rem;">
                                                Murni soal analisis kasus & rubrik penskoran.
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- INPUT JUMLAH BUTIR SOAL -->
                            <div class="row g-3">
                                <!-- JUMLAH BUTIR PG -->
                                <div class="col-md-6" id="wrapTotalPg">
                                    <label class="form-label small text-muted fw-semibold">Jumlah Butir Pilihan Ganda (PG)</label>
                                    <select name="total_soal_pg" id="selectTotalPg" class="form-select rounded-3">
                                        <option value="5" {{ old('total_soal_pg') == 5 ? 'selected' : '' }}>5 Butir Soal PG</option>
                                        <option value="10" {{ old('total_soal_pg', 10) == 10 ? 'selected' : '' }}>10 Butir Soal PG (Standar)</option>
                                        <option value="15" {{ old('total_soal_pg') == 15 ? 'selected' : '' }}>15 Butir Soal PG</option>
                                        <option value="20" {{ old('total_soal_pg') == 20 ? 'selected' : '' }}>20 Butir Soal PG (Lengkap)</option>
                                        <option value="25" {{ old('total_soal_pg') == 25 ? 'selected' : '' }}>25 Butir Soal PG</option>
                                    </select>
                                </div>

                                <!-- JUMLAH BUTIR ISIAN -->
                                <div class="col-md-6" id="wrapTotalIsian">
                                    <label class="form-label small text-muted fw-semibold">Jumlah Butir Isian / Uraian</label>
                                    <select name="total_soal_isian" id="selectTotalIsian" class="form-select rounded-3">
                                        <option value="3" {{ old('total_soal_isian') == 3 ? 'selected' : '' }}>3 Butir Soal Isian</option>
                                        <option value="5" {{ old('total_soal_isian', 5) == 5 ? 'selected' : '' }}>5 Butir Soal Isian (Standar)</option>
                                        <option value="8" {{ old('total_soal_isian') == 8 ? 'selected' : '' }}>8 Butir Soal Isian</option>
                                        <option value="10" {{ old('total_soal_isian') == 10 ? 'selected' : '' }}>10 Butir Soal Isian</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL SUBMIT -->
                        <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <a href="{{ route('paket-soal.index') }}" class="btn btn-light rounded-pill px-4 text-muted">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4.5 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" id="btnSubmitSoal" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                                <i class="bi bi-magic"></i>
                                <span>Generate Kisi-Kisi & Soal (Sistem Pakar)</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SIDEBAR PANDUAN & INFORMASI SISTEM PAKAR -->
        <div class="col-lg-4">
            <!-- KARTU JAMINAN SISTEM PAKAR -->
            <div class="card border-0 shadow-sm rounded-4 mb-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%); border: 1.5px solid #bae6fd !important;">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-circle p-1.5 bg-primary bg-opacity-15 text-primary">
                            <i class="bi bi-shield-check fs-5"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">Sistem Pakar Terstruktur</h6>
                    </div>
                    <p class="small text-muted mb-2" style="font-size: 0.8rem; line-height: 1.5;">
                        Seluruh naskah soal dan tabel kisi-kisi disusun menggunakan algoritma sistem pakar murni berbasis Taksonomi Bloom dan elemen BSKAP 046/2025.
                    </p>
                    <ul class="list-unstyled small mb-0 text-dark" style="font-size: 0.78rem;">
                        <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Nol Halusinasi AI:</strong> Tidak memakai token eksternal.</li>
                        <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Distraktor Homogen:</strong> 4 pengecoh logis & edukatif.</li>
                        <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Kunci & Pembahasan:</strong> Alasan rasional untuk guru.</li>
                        <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Rubrik Penskoran:</strong> Pedoman penilaian analitik essay.</li>
                    </ul>
                </div>
            </div>

            <!-- KARTU ALUR KISI-KISI RESMI -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-3.5">
                    <h6 class="fw-bold text-dark mb-2.5 d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-3-fill text-primary"></i>
                        Format Kisi-Kisi Kemendikdasmen
                    </h6>
                    <div class="small text-muted mb-3" style="font-size: 0.78rem;">
                        Tabel spesifikasi memuat 8 parameter resmi yang langsung siap dicetak sebagai lampiran asesmen:
                    </div>
                    <div class="d-flex flex-wrap gap-1.5" style="font-size: 0.72rem;">
                        <span class="badge badge-soft-primary">1. No. Urut</span>
                        <span class="badge badge-soft-primary">2. Elemen Capaian</span>
                        <span class="badge badge-soft-primary">3. Tujuan Ajar (TP)</span>
                        <span class="badge badge-soft-primary">4. Materi / Topik</span>
                        <span class="badge badge-soft-primary">5. Indikator Soal</span>
                        <span class="badge badge-soft-primary">6. Level Bloom (C1-C6)</span>
                        <span class="badge badge-soft-primary">7. Bentuk Soal</span>
                        <span class="badge badge-soft-primary">8. No. Soal</span>
                    </div>
                </div>
            </div>

            <!-- INFO CETAK GURU VS SISWA -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3.5">
                    <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-printer-fill text-secondary"></i>
                        Pemisahan Naskah Ujian
                    </h6>
                    <p class="small text-muted mb-0" style="font-size: 0.78rem; line-height: 1.5;">
                        Setelah di-generate, sistem otomatis memisahkan lembar ujian siswa (bersih tanpa kunci) dan dokumen arsip kurikulum pegangan guru (lengkap dengan kisi-kisi, kunci, dan rubrik).
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JAVASCRIPT LOGIC AUTO-FILL & FORM TOGGLES -->
<script>
    function toggleBentukSoal() {
        const bentuk = document.querySelector('input[name="bentuk_soal"]:checked').value;
        const wrapPg = document.getElementById('wrapTotalPg');
        const wrapIsian = document.getElementById('wrapTotalIsian');

        if (bentuk === 'pg') {
            wrapPg.classList.remove('d-none');
            wrapIsian.classList.add('d-none');
        } else if (bentuk === 'isian') {
            wrapPg.classList.add('d-none');
            wrapIsian.classList.remove('d-none');
        } else {
            wrapPg.classList.remove('d-none');
            wrapIsian.classList.remove('d-none');
        }
    }

    // Auto-fill dari Modul Ajar
    document.getElementById('modulAjarSelect').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected && selected.value) {
            const mapelId = selected.getAttribute('data-mapel-id');
            const faseId = selected.getAttribute('data-fase-id');
            const judul = selected.getAttribute('data-judul');

            if (mapelId) document.getElementById('mapelSelect').value = mapelId;
            if (faseId) document.getElementById('faseSelect').value = faseId;
            if (judul && !document.getElementById('judulInput').value) {
                document.getElementById('judulInput').value = 'Asesmen Sumatif: ' + judul;
            }
        }
    });

    // Loading State pada Tombol Submit
    document.getElementById('formGeneratorSoal').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitSoal');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyusun Kisi-Kisi & Soal...';
    });

    // Inisialisasi saat load
    document.addEventListener('DOMContentLoaded', function() {
        toggleBentukSoal();
    });
</script>
@endsection
