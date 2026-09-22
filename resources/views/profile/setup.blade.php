@extends('layouts.app')

@section('title', 'Pengaturan Profil Guru & Kop Sekolah')

@section('content')
<div class="container-fluid px-0 px-md-3">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil & Kop Sekolah</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">
                <i class="bi bi-person-badge-fill text-primary me-2"></i>Pengaturan Profil & Kop Surat Sekolah
            </h1>
            <p class="text-muted small mb-0">
                Lengkapi identitas guru dan sekolah untuk standarisasi Kop Surat dan Form Tanda Tangan resmi pada dokumen ekspor.
            </p>
        </div>
    </div>

    @if(!$user->is_profile_completed)
        <!-- Onboarding Notice Banner -->
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4 rounded-3">
            <div class="fs-2 text-warning lh-1">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-1">Langkah Wajib: Onboarding Profil Multi-Sekolah</h5>
                <p class="mb-0 small text-secondary">
                    Selamat datang di <strong>Sistem Perangkat Ajar Kurikulum Merdeka 2026</strong>. Karena aplikasi ini digunakan oleh banyak guru dari berbagai sekolah, <strong>Anda wajib melengkapi data identitas guru dan instansi sekolah</strong> sebelum dapat mengakses menu pembuatan perangkat ajar. Data ini akan otomatis dicetak pada <strong>Kop Surat Kedinasan</strong> dan <strong>Form Tanda Tangan Kepala Sekolah (Kiri) & Guru (Kanan)</strong> di setiap dokumen PDF & Word.
                </p>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Form Kolom Kiri -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-primary"></i> Formulir Data Guru & Sekolah
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        <!-- SECTION 1: DATA GURU PENGAMPU -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge bg-primary rounded-circle px-2 py-1">1</span>
                            <h6 class="fw-bold text-dark mb-0">Data Diri Guru Pengampu</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nama Lengkap Guru & Gelar <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="input_name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required placeholder="Contoh: Budi Santoso, S.Kom., M.T.">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIP / NUPTK Guru</label>
                                <input type="text" name="nip" id="input_nip" class="form-control @error('nip') is-invalid @enderror"
                                       value="{{ old('nip', $user->nip) }}" placeholder="Contoh: 198501012010011012 atau -">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">No. WhatsApp / Telepon</label>
                                <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                       value="{{ old('telepon', $user->telepon) }}" placeholder="Contoh: 081234567890">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Mata Pelajaran yang Diampu</label>
                                <input type="text" name="mata_pelajaran_diampu" class="form-control @error('mata_pelajaran_diampu') is-invalid @enderror"
                                       value="{{ old('mata_pelajaran_diampu', $user->mata_pelajaran_diampu) }}" placeholder="Contoh: Rekayasa Perangkat Lunak">
                                @error('mata_pelajaran_diampu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Jurusan / Program Keahlian SMK</label>
                                <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                                       value="{{ old('jurusan', $user->jurusan) }}" placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim (PPLG)">
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 2: IDENTITAS SEKOLAH -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge bg-primary rounded-circle px-2 py-1">2</span>
                            <h6 class="fw-bold text-dark mb-0">Identitas Satuan Pendidikan (Sekolah)</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label small fw-semibold">Nama Resmi Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="nama_sekolah" id="input_nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror"
                                       value="{{ old('nama_sekolah', $sekolah->nama ?? 'SMK Negeri 1 Jakarta') }}" required placeholder="Contoh: SMK Negeri 1 Jakarta">
                                @error('nama_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">NPSN <span class="text-danger">*</span></label>
                                <input type="text" name="npsn" id="input_npsn" class="form-control @error('npsn') is-invalid @enderror"
                                       value="{{ old('npsn', $sekolah->npsn ?? '20100001') }}" required placeholder="Contoh: 20100001">
                                @error('npsn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Jenjang <span class="text-danger">*</span></label>
                                <select name="jenjang" class="form-select @error('jenjang') is-invalid @enderror" required>
                                    <option value="SMK" {{ old('jenjang', $sekolah->jenjang ?? 'SMK') == 'SMK' ? 'selected' : '' }}>SMK (Kejuruan)</option>
                                    <option value="SMA" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="SMP" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SD" {{ old('jenjang', $sekolah->jenjang ?? '') == 'SD' ? 'selected' : '' }}>SD</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" name="kota" id="input_kota" class="form-control @error('kota') is-invalid @enderror"
                                       value="{{ old('kota', $sekolah->kota ?? 'Jakarta Pusat') }}" required placeholder="Contoh: Jakarta Pusat">
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Digunakan untuk titimangsa tanda tangan.</div>
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Provinsi</label>
                                <input type="text" name="provinsi" id="input_provinsi" class="form-control @error('provinsi') is-invalid @enderror"
                                       value="{{ old('provinsi', $sekolah->provinsi ?? 'DKI Jakarta') }}" placeholder="Contoh: DKI Jakarta">
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Alamat Lengkap Sekolah</label>
                                <textarea name="alamat" id="input_alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                                          placeholder="Contoh: Jl. Budi Utomo No. 7, Pasar Baru, Sawah Besar">{{ old('alamat', $sekolah->alamat ?? 'Jl. Budi Utomo No. 7, Pasar Baru, Sawah Besar') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Telepon Sekolah</label>
                                <input type="text" name="telepon_sekolah" id="input_telepon_sekolah" class="form-control"
                                       value="{{ old('telepon_sekolah', $sekolah->telepon ?? '(021) 3841234') }}" placeholder="Contoh: (021) 3841234">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Email Sekolah</label>
                                <input type="email" name="email_sekolah" id="input_email_sekolah" class="form-control"
                                       value="{{ old('email_sekolah', $sekolah->email ?? 'info@smkn1jakarta.sch.id') }}" placeholder="info@sekolah.sch.id">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Website Sekolah</label>
                                <input type="text" name="website" id="input_website" class="form-control"
                                       value="{{ old('website', $sekolah->website ?? 'www.smkn1jakarta.sch.id') }}" placeholder="www.sekolah.sch.id">
                            </div>
                        </div>

                        <!-- SECTION 3: PEJABAT KEPALA SEKOLAH -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge bg-primary rounded-circle px-2 py-1">3</span>
                            <h6 class="fw-bold text-dark mb-0">Pejabat Kepala Sekolah (Tanda Tangan Kiri)</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nama Lengkap Kepala Sekolah & Gelar <span class="text-danger">*</span></label>
                                <input type="text" name="kepala_sekolah" id="input_kepala_sekolah" class="form-control @error('kepala_sekolah') is-invalid @enderror"
                                       value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah ?? 'Drs. H. Suryadi, M.Pd.') }}" required placeholder="Contoh: Drs. H. Suryadi, M.Pd.">
                                @error('kepala_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIP Kepala Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="nip_kepala_sekolah" id="input_nip_kepala_sekolah" class="form-control @error('nip_kepala_sekolah') is-invalid @enderror"
                                       value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah ?? '196805121994031005') }}" required placeholder="Contoh: 196805121994031005">
                                @error('nip_kepala_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 4: KOP SURAT KEDINASAN & LOGO -->
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge bg-primary rounded-circle px-2 py-1">4</span>
                            <h6 class="fw-bold text-dark mb-0">Konfigurasi Kop Surat Kedinasan & Logo</h6>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Upload Logo Sekolah Resmi</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="border rounded p-2 bg-light d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                        @if($sekolah->logo)
                                            <img src="{{ asset('storage/' . $sekolah->logo) }}" id="logoPreviewImg" alt="Logo Sekolah" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <i class="bi bi-image text-muted fs-3" id="logoPlaceholderIcon"></i>
                                            <img src="" id="logoPreviewImg" class="d-none" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="logo" id="input_logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                        <div class="form-text text-muted" style="font-size: 0.72rem;">Format: PNG, JPG, atau SVG (Maksimal 2MB, latar belakang transparan direkomendasikan).</div>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Kop Baris 1 (Pemerintah Daerah / Provinsi Pembina)</label>
                                <input type="text" name="kop_baris_1" id="input_kop_baris_1" class="form-control"
                                       value="{{ old('kop_baris_1', $sekolah->kop_baris_1 ?? 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR') }}"
                                       placeholder="Contoh: PEMERINTAH PROVINSI NUSA TENGGARA TIMUR">
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Ditampilkan di baris pertama kop surat (huruf kapital).</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Kop Baris 2 (Dinas Pendidikan / Instansi Pembina)</label>
                                <input type="text" name="kop_baris_2" id="input_kop_baris_2" class="form-control"
                                       value="{{ old('kop_baris_2', $sekolah->kop_baris_2 ?? 'DINAS PENDIDIKAN DAN KEBUDAYAAN') }}"
                                       placeholder="Contoh: DINAS PENDIDIKAN DAN KEBUDAYAAN">
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Ditampilkan di baris kedua sebelum nama sekolah.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Kop Baris 3 (Nama Lembaga / Satuan Pendidikan)</label>
                                <input type="text" name="kop_baris_3" id="input_kop_baris_3" class="form-control"
                                       value="{{ old('kop_baris_3', $sekolah->kop_baris_3 ?? ($sekolah->nama ?? 'SMKN 1 KUPANG BARAT')) }}"
                                       placeholder="Contoh: SMKN 1 KUPANG BARAT">
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Ditampilkan tebal & kapital sebagai nama satuan pendidikan.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Kop Baris 4 (Alamat, Kontak, NPSN, Email & Media)</label>
                                <input type="text" name="kop_baris_4" id="input_kop_baris_4" class="form-control"
                                       value="{{ old('kop_baris_4', $sekolah->kop_baris_4 ?? 'Jl. Kiufutu Km.20 Desa Kuanheun Kupang Barat | Telp: (021) 3841234 | Email: smkn1kpgbarat@gmail.com') }}"
                                       placeholder="Jl. ..., Kota ... | Telp: ... | Email: ... | NPSN: ...">
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Ditampilkan di bawah nama sekolah dengan font lebih ringkas.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Ukuran Kertas Cetak Default Dokumen</label>
                                <select name="ukuran_kertas_default" class="form-select">
                                    <option value="A4" {{ old('ukuran_kertas_default', $sekolah->ukuran_kertas_default ?? 'A4') == 'A4' ? 'selected' : '' }}>A4 (210 mm &times; 297 mm)</option>
                                    <option value="F4" {{ old('ukuran_kertas_default', $sekolah->ukuran_kertas_default ?? '') == 'F4' ? 'selected' : '' }}>F4 / Folio (215 mm &times; 330 mm)</option>
                                </select>
                                <div class="form-text text-muted" style="font-size: 0.72rem;">Pilihan standar cetak dokumen (dapat diubah fleksibel saat ekspor).</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('dashboard') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan & Terapkan Kop Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Live Preview Kop Surat & Tanda Tangan -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 80px; z-index: 10;">
                <div class="card border-0 shadow-sm rounded-3 mb-3">
                    <div class="card-header bg-dark text-white py-3 px-4 d-flex align-items-center justify-content-between">
                        <div class="fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-eye-fill text-info"></i> Live Preview Dokumen Kedinasan
                        </div>
                        <span class="badge bg-secondary text-xs">Simulasi Cetak Ekspor</span>
                    </div>
                    <div class="card-body p-3 p-md-4 bg-light">
                        <!-- Paper Sheet Simulation -->
                        <div class="bg-white p-3 p-md-4 shadow-sm border rounded-2" style="min-height: 480px; font-family: 'Times New Roman', Times, serif;">
                            
                            <!-- KOP SURAT PREVIEW -->
                            <div class="d-flex align-items-center pb-2 mb-3" style="border-bottom: 3px double #000;">
                                <div class="pe-2 text-center" style="width: 20%;">
                                    <div id="preview_logo_container">
                                        @if($sekolah->logo)
                                            <img src="{{ asset('storage/' . $sekolah->logo) }}" id="preview_logo_img" alt="Logo" style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                        @else
                                            <svg id="preview_logo_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" fill="#1e3c72">
                                                <path d="M12 3L1 9L12 15L21 10.09V17H23V9M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                                            </svg>
                                            <img src="" id="preview_logo_img" class="d-none" alt="Logo" style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center" style="width: 80%;">
                                    <div id="preview_baris_1" class="fw-bold text-dark" style="font-size: 0.70rem; text-transform: uppercase; line-height: 1.2;">
                                        {{ $sekolah->kop_baris_1 ?? 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR' }}
                                    </div>
                                    <div id="preview_baris_2" class="fw-bold text-dark" style="font-size: 0.75rem; text-transform: uppercase; line-height: 1.2; margin: 1px 0;">
                                        {{ $sekolah->kop_baris_2 ?? 'DINAS PENDIDIKAN DAN KEBUDAYAAN' }}
                                    </div>
                                    <div id="preview_baris_3" class="fw-bold text-dark" style="font-size: 0.90rem; text-transform: uppercase; line-height: 1.25; margin: 2px 0;">
                                        {{ $sekolah->kop_baris_3 ?? ($sekolah->nama ?? 'SMKN 1 KUPANG BARAT') }}
                                    </div>
                                    <div id="preview_baris_4" class="text-secondary" style="font-size: 0.63rem; line-height: 1.2;">
                                        {{ $sekolah->kop_baris_4 ?? 'Jl. Kiufutu Km.20 Desa Kuanheun Kupang Barat | Telp: (021) 3841234 | Email: smkn1kpgbarat@gmail.com' }}
                                    </div>
                                </div>
                            </div>

                            <!-- DUMMY CONTENT HEADER -->
                            <div class="text-center my-3">
                                <div class="fw-bold text-dark" style="font-size: 0.85rem; text-decoration: underline;">
                                    ALUR TUJUAN PEMBELAJARAN (ATP) / MODUL AJAR
                                </div>
                                <div class="text-muted" style="font-size: 0.68rem;">
                                    Kurikulum Merdeka 2026 &bull; Keputusan BSKAP No. 046/H/KR/2025
                                </div>
                            </div>

                            <div class="p-2 border rounded bg-light mb-4 text-secondary" style="font-size: 0.68rem; line-height: 1.4;">
                                <div><strong>Mata Pelajaran:</strong> Rekayasa Perangkat Lunak / Pilihan AI</div>
                                <div><strong>Fase / Kelas:</strong> Fase F (Kelas XI)</div>
                                <div><strong>Tahun Ajaran:</strong> 2025/2026</div>
                                <div class="mt-1 text-muted fst-italic">... (isi substansi ATP / Modul Ajar / LKPD / Asesmen) ...</div>
                            </div>

                            <!-- TANDA TANGAN DUA KOLOM PREVIEW -->
                            <div class="row g-2 pt-2" style="font-size: 0.72rem;">
                                <!-- KIRI: KEPALA SEKOLAH -->
                                <div class="col-6">
                                    <div>Mengetahui,</div>
                                    <div class="fw-semibold">Kepala Sekolah,</div>
                                    <div style="height: 48px;" class="d-flex align-items-center text-muted fst-italic text-xs">
                                        (Tanda Tangan & Stempel)
                                    </div>
                                    <div id="preview_kepsek" class="fw-bold text-dark text-decoration-underline">
                                        {{ $sekolah->kepala_sekolah ?? 'Drs. H. Suryadi, M.Pd.' }}
                                    </div>
                                    <div id="preview_nip_kepsek" class="text-muted">
                                        NIP. {{ $sekolah->nip_kepala_sekolah ?? '196805121994031005' }}
                                    </div>
                                </div>

                                <!-- KANAN: GURU MATA PELAJARAN -->
                                <div class="col-6">
                                    <div id="preview_titimangsa">
                                        {{ $sekolah->kota ?? 'Jakarta Pusat' }}, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                                    </div>
                                    <div class="fw-semibold">Guru Mata Pelajaran,</div>
                                    <div style="height: 48px;" class="d-flex align-items-center text-muted fst-italic text-xs">
                                        (Tanda Tangan Guru)
                                    </div>
                                    <div id="preview_guru" class="fw-bold text-dark text-decoration-underline">
                                        {{ $user->name }}
                                    </div>
                                    <div id="preview_nip_guru" class="text-muted">
                                        NIP. {{ $user->nip ?: '-' }}
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER HAK CIPTA -->
                            <div class="text-center text-muted border-top pt-2 mt-4" style="font-size: 0.65rem;">
                                Hak Cipta : Desain by. Vicky Koroh
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-white border-top py-2 px-3">
                        <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                            <i class="bi bi-shield-check text-success"></i> Standarisasi sesuai regulasi dinas pendidikan & tata naskah dinas kedinasan.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time synchronization elements
    const inputName = document.getElementById('input_name');
    const inputNip = document.getElementById('input_nip');
    const inputKota = document.getElementById('input_kota');
    const inputKepsek = document.getElementById('input_kepala_sekolah');
    const inputNipKepsek = document.getElementById('input_nip_kepala_sekolah');
    const inputBaris1 = document.getElementById('input_kop_baris_1');
    const inputBaris2 = document.getElementById('input_kop_baris_2');
    const inputBaris3 = document.getElementById('input_kop_baris_3');
    const inputBaris4 = document.getElementById('input_kop_baris_4');
    const inputLogo = document.getElementById('input_logo');

    const previewGuru = document.getElementById('preview_guru');
    const previewNipGuru = document.getElementById('preview_nip_guru');
    const previewTitimangsa = document.getElementById('preview_titimangsa');
    const previewKepsek = document.getElementById('preview_kepsek');
    const previewNipKepsek = document.getElementById('preview_nip_kepsek');
    const previewBaris1 = document.getElementById('preview_baris_1');
    const previewBaris2 = document.getElementById('preview_baris_2');
    const previewBaris3 = document.getElementById('preview_baris_3');
    const previewBaris4 = document.getElementById('preview_baris_4');

    const currentDateStr = "{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}";

    if (inputName && previewGuru) {
        inputName.addEventListener('input', function() {
            previewGuru.textContent = this.value || 'Nama Guru Pengampu';
        });
    }

    if (inputNip && previewNipGuru) {
        inputNip.addEventListener('input', function() {
            previewNipGuru.textContent = 'NIP. ' + (this.value || '-');
        });
    }

    if (inputKota && previewTitimangsa) {
        inputKota.addEventListener('input', function() {
            previewTitimangsa.textContent = (this.value || 'Kota') + ', ' + currentDateStr;
        });
    }

    if (inputKepsek && previewKepsek) {
        inputKepsek.addEventListener('input', function() {
            previewKepsek.textContent = this.value || 'Nama Kepala Sekolah';
        });
    }

    if (inputNipKepsek && previewNipKepsek) {
        inputNipKepsek.addEventListener('input', function() {
            previewNipKepsek.textContent = 'NIP. ' + (this.value || '-');
        });
    }

    if (inputBaris1 && previewBaris1) {
        inputBaris1.addEventListener('input', function() {
            previewBaris1.textContent = this.value || 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR';
        });
    }

    if (inputBaris2 && previewBaris2) {
        inputBaris2.addEventListener('input', function() {
            previewBaris2.textContent = this.value || 'DINAS PENDIDIKAN DAN KEBUDAYAAN';
        });
    }

    if (inputBaris3 && previewBaris3) {
        inputBaris3.addEventListener('input', function() {
            previewBaris3.textContent = this.value || 'SMKN 1 KUPANG BARAT';
        });
    }

    if (inputBaris4 && previewBaris4) {
        inputBaris4.addEventListener('input', function() {
            previewBaris4.textContent = this.value || 'Alamat, Kontak, NPSN & Media';
        });
    }

    // Logo image preview
    if (inputLogo) {
        inputLogo.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const formImg = document.getElementById('logoPreviewImg');
                    const formPlaceholder = document.getElementById('logoPlaceholderIcon');
                    if (formImg) {
                        formImg.src = evt.target.result;
                        formImg.classList.remove('d-none');
                    }
                    if (formPlaceholder) {
                        formPlaceholder.classList.add('d-none');
                    }

                    // Live preview in paper sheet
                    const previewImg = document.getElementById('preview_logo_img');
                    const previewSvg = document.getElementById('preview_logo_svg');
                    if (previewImg) {
                        previewImg.src = evt.target.result;
                        previewImg.classList.remove('d-none');
                    }
                    if (previewSvg) {
                        previewSvg.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
