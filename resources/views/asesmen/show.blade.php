@extends('layouts.app')

@section('title', 'Detail Instrumen Asesmen - ' . $asesmen->judul)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('asesmen.index') }}" class="text-decoration-none">Asesmen</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($asesmen->judul, 40) }}</li>
            </ol>
        </nav>
        <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="badge bg-success bg-opacity-10 text-success p-2 rounded-3">
                <i class="bi bi-clipboard2-check-fill"></i>
            </span>
            {{ $asesmen->judul }}
        </h4>
        <p class="text-muted small mb-0">
            Sesuai <strong>Keputusan Kepala BSKAP No. 046/H/KR/2025</strong> & <strong>Panduan Pembelajaran dan Asesmen (PPA) Revisi 2025/2026 Kemendikdasmen</strong>.
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('asesmen.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div class="dropdown">
            <button class="btn btn-danger btn-sm text-white dropdown-toggle d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh PDF
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Ukuran Kertas</h6></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.asesmen.pdf', $asesmen->id) }}?paper=a4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-danger"></i> PDF (A4 Standar)</span> <span class="badge bg-light text-muted border ms-2">210x297 mm</span></a></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center justify-content-between" href="{{ route('export.asesmen.pdf', $asesmen->id) }}?paper=f4"><span class="d-flex align-items-center gap-2"><i class="bi bi-file-text text-primary"></i> PDF (F4 / Folio)</span> <span class="badge bg-light text-muted border ms-2">215x330 mm</span></a></li>
            </ul>
        </div>
        <a href="{{ route('export.asesmen.docx', $asesmen->id) }}" class="btn btn-primary btn-sm text-white">
            <i class="bi bi-file-earmark-word-fill me-1"></i> Unduh Word (DOCX)
        </a>
    </div>
</div>

<!-- INFORMASI UMUM ASESMEN -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white h-100">
            <div class="text-muted small fw-semibold">Mata Pelajaran</div>
            <div class="fw-bold text-dark fs-6 mt-1">{{ $asesmen->mataPelajaran->nama ?? '-' }}</div>
            @if($asesmen->mataPelajaran?->programKeahlian)
                <span class="badge bg-light text-secondary border mt-2 w-auto align-self-start">
                    {{ $asesmen->mataPelajaran->programKeahlian->nama }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white h-100">
            <div class="text-muted small fw-semibold">Fase & Jenjang</div>
            <div class="fw-bold text-primary fs-5 mt-1">Fase {{ $asesmen->fase->kode ?? '-' }}</div>
            <div class="small text-muted">{{ $asesmen->fase->kelas_range ?? 'Kelas X/XI/XII SMK' }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white h-100">
            <div class="text-muted small fw-semibold">Tujuan Pembelajaran (TP) Terkait</div>
            <div class="fw-bold text-dark small mt-1">
                {{ $asesmen->tujuanPembelajaran ? $asesmen->tujuanPembelajaran->kode_tp : 'TP Utama' }}
            </div>
            <div class="text-muted text-truncate" style="font-size: 0.78rem;" title="{{ $asesmen->tujuanPembelajaran?->deskripsi_tp }}">
                {{ $asesmen->tujuanPembelajaran?->deskripsi_tp ?? 'Kompetensi Inti Lingkup Materi' }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white h-100">
            <div class="text-muted small fw-semibold">Penyusun / Guru Pengampu</div>
            <div class="fw-bold text-dark fs-6 mt-1">{{ $asesmen->user->name ?? 'Guru Pengampu' }}</div>
            <div class="small text-muted">{{ $asesmen->user->satuanPendidikan?->nama ?? 'SMK Mitra Industri' }}</div>
        </div>
    </div>
</div>

<!-- NAV TABS -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom p-0">
        <ul class="nav nav-tabs card-header-tabs m-0 border-0" id="asesmenTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active py-3 px-4 fw-bold text-dark border-0 border-bottom border-3 border-primary" id="tab-ringkasan" data-bs-toggle="tab" data-bs-target="#content-ringkasan" type="button" role="tab">
                    <i class="bi bi-info-circle me-1 text-primary"></i> Ringkasan & Prinsip PPA
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 px-4 fw-bold text-dark border-0" id="tab-diagnostik" data-bs-toggle="tab" data-bs-target="#content-diagnostik" type="button" role="tab">
                    <i class="bi bi-search me-1 text-info"></i> 1. Asesmen Diagnostik (Awal)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 px-4 fw-bold text-dark border-0" id="tab-formatif" data-bs-toggle="tab" data-bs-target="#content-formatif" type="button" role="tab">
                    <i class="bi bi-arrow-repeat me-1 text-success"></i> 2. Asesmen Formatif (Proses)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 px-4 fw-bold text-dark border-0" id="tab-sumatif" data-bs-toggle="tab" data-bs-target="#content-sumatif" type="button" role="tab">
                    <i class="bi bi-mortarboard me-1 text-danger"></i> 3. Sumatif & Vokasi SMK
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 px-4 fw-bold text-dark border-0" id="tab-kktp" data-bs-toggle="tab" data-bs-target="#content-kktp" type="button" role="tab">
                    <i class="bi bi-sliders me-1 text-warning"></i> 4. Rubrik & Interval KKTP
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 px-4 fw-bold text-dark border-0" id="tab-rapor" data-bs-toggle="tab" data-bs-target="#content-rapor" type="button" role="tab">
                    <i class="bi bi-card-text me-1 text-secondary"></i> 5. Deskripsi Rapor
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content" id="asesmenTabContent">

            <!-- TAB 1: RINGKASAN & PRINSIP -->
            <div class="tab-pane fade show active" id="content-ringkasan" role="tabpanel">
                <div class="alert alert-primary bg-primary bg-opacity-10 border-0 text-dark mb-4">
                    <h6 class="fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-primary fs-5"></i>
                        Prinsip Asesmen Resmi Kemendikdasmen (PPA Edisi Revisi 2025/2026):
                    </h6>
                    <ul class="mb-0 small" style="line-height: 1.7;">
                        <li><strong>Asesmen Diagnostik (Awal)</strong>: Digunakan semata-mata untuk mengidentifikasi kesiapan, minat, dan profil belajar murid sebagai dasar diferensiasi pembelajaran, <u>TIDAK DIBOBOT untuk nilai akhir rapor</u>.</li>
                        <li><strong>Asesmen Formatif</strong>: Berfungsi sebagai <em>assessment as & for learning</em> untuk memantau kemajuan, melatih refleksi diri murid, dan memberikan <u>umpan balik deskriptif (feedback)</u> yang bermakna.</li>
                        <li><strong>Asesmen Sumatif</strong>: Dilakukan pada akhir lingkup materi sebagai <em>assessment of learning</em> untuk mengukur ketercapaian tujuan pembelajaran dan dasar penentuan nilai akhir rapor.</li>
                        <li><strong>Kriteria Ketercapaian (KKTP)</strong>: Menggantikan KKM angka tunggal. Menggunakan pendekatan rubrik berkriteria dan interval nilai dengan tindak lanjut terstruktur.</li>
                    </ul>
                </div>

                <h6 class="fw-bold text-dark mb-2">Deskripsi Instrumen:</h6>
                <p class="text-secondary small mb-4">{{ $asesmen->deskripsi }}</p>

                <h6 class="fw-bold text-dark mb-2">Pedoman Penskoran & Penentuan Nilai Akhir:</h6>
                <div class="bg-light p-3 rounded-3 border small text-dark mb-3" style="white-space: pre-line; line-height: 1.6;">
                    {{ $asesmen->pedoman_penskoran }}
                </div>
            </div>

            <!-- TAB 2: ASESMEN DIAGNOSTIK (AWAL) -->
            <div class="tab-pane fade" id="content-diagnostik" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-search text-info me-2"></i> Asesmen Diagnostik Kesiapan Awal</h6>
                    <span class="badge bg-info text-dark">Non-Kognitif & Kognitif Prasyarat</span>
                </div>
                <p class="text-muted small mb-4">
                    Dilaksanakan pada pertemuan awal sebelum materi inti dimulai. Bertujuan memetakan kompetensi awal murid agar guru dapat merancang pembelajaran berdiferensiasi.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border border-info bg-info bg-opacity-10 h-100 p-3">
                            <div class="fw-bold text-dark small mb-2"><i class="bi bi-person-bounding-box me-1"></i> 1. Diagnostik Non-Kognitif (Profil & Emosional):</div>
                            <ul class="small text-secondary mb-0" style="line-height: 1.6;">
                                <li><strong>Motivasi Belajar:</strong> Sejauh mana ketertarikan murid terhadap bidang keahlian {{ $asesmen->mataPelajaran->nama ?? 'vokasi' }}.</li>
                                <li><strong>Gaya Belajar:</strong> Visual (gambar/diagram teknis), Auditori (penjelasan diskusi), atau Kinestetik (praktik langsung di bengkel/lab).</li>
                                <li><strong>Akses & Fasilitas:</strong> Ketersediaan perangkat penunjang belajar di rumah (gawai, komputer, jaringan internet).</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border border-primary bg-primary bg-opacity-10 h-100 p-3">
                            <div class="fw-bold text-dark small mb-2"><i class="bi bi-question-circle me-1"></i> 2. Diagnostik Kognitif (Tes Pemantik Prasyarat):</div>
                            <ol class="small text-secondary mb-0" style="line-height: 1.6;">
                                <li>Jelaskan apa yang Anda ketahui tentang fungsi dan manfaat materi ini dalam dunia kerja industri nyata!</li>
                                <li>Sebutkan peralatan atau konsep dasar yang pernah Anda pelajari sebelumnya yang berhubungan dengan materi ini!</li>
                                <li>Bagaimana pandangan Anda mengenai penerapan keselamatan kerja (K3) saat mengerjakan tugas pada materi ini?</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-light p-3 rounded-3">
                    <div class="fw-bold text-dark small mb-2"><i class="bi bi-diagram-3-fill text-primary me-1"></i> Rencana Tindak Lanjut Diferensiasi Pembelajaran:</div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm bg-white mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Kategori Kesiapan Murid</th>
                                    <th>Ciri-Ciri Kemampuan Awal</th>
                                    <th>Strategi Diferensiasi Pembelajaran Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-danger">Kelompok Perlu Bimbingan</span></td>
                                    <td>Belum menguasai konsep dasar prasyarat, pasif saat apersepsi.</td>
                                    <td>Diberikan pendampingan intensif (scaffolding), modul ringkas bergambar, dan bimbingan tutor sebaya.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">Kelompok Siap / Berkembang</span></td>
                                    <td>Memahami konsep prasyarat secara umum, siap belajar mandiri.</td>
                                    <td>Mengikuti alur pembelajaran reguler sesuai modul ajar dan LKPD otentik industri.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">Kelompok Mahir / Cepat</span></td>
                                    <td>Menguasai materi prasyarat dengan sangat baik dan bernalar kritis.</td>
                                    <td>Diberikan peran sebagai tutor sebaya serta tugas tantangan studi kasus industri lanjutan (pengayaan).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: ASESMEN FORMATIF (PROSES) -->
            <div class="tab-pane fade" id="content-formatif" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-arrow-repeat text-success me-2"></i> Asesmen Formatif (Sepanjang Proses Pembelajaran)</h6>
                    <span class="badge bg-success">Assessment as & for Learning</span>
                </div>
                <p class="text-muted small mb-4">
                    Berfokus pada pemantauan kemajuan belajar, refleksi diri (metakognisi), dan penyampaian <strong>umpan balik kualitatif konstruktif</strong> kepada murid.
                </p>

                <div class="row g-3 mb-4">
                    <!-- Lembar Observasi Partisipasi -->
                    <div class="col-md-6">
                        <div class="card border p-3 h-100 shadow-sm bg-white">
                            <div class="fw-bold text-dark small mb-2 d-flex align-items-center gap-1">
                                <i class="bi bi-eye text-primary"></i> Lembar Observasi Keterlibatan (Olah Pikir & Rasa)
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm small mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Indikator Perilaku</th>
                                            <th width="20%" class="text-center">Ketercapaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Aktif mengajukan pertanyaan analitis saat diskusi konsep.</td>
                                            <td class="text-center"><i class="bi bi-check2-circle text-success"></i> Ya / Tidak</td>
                                        </tr>
                                        <tr>
                                            <td>Bekerja sama secara inklusif dan solutif dalam tim kerja.</td>
                                            <td class="text-center"><i class="bi bi-check2-circle text-success"></i> Ya / Tidak</td>
                                        </tr>
                                        <tr>
                                            <td>Menunjukkan sikap kritis dan keterbukaan menerima saran teman.</td>
                                            <td class="text-center"><i class="bi bi-check2-circle text-success"></i> Ya / Tidak</td>
                                        </tr>
                                        <tr>
                                            <td>Disiplin menjaga kerapian alat dan kebersihan lingkungan kerja (5R).</td>
                                            <td class="text-center"><i class="bi bi-check2-circle text-success"></i> Ya / Tidak</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Lembar Refleksi Diri (Self-Assessment) -->
                    <div class="col-md-6">
                        <div class="card border p-3 h-100 shadow-sm bg-white">
                            <div class="fw-bold text-dark small mb-2 d-flex align-items-center gap-1">
                                <i class="bi bi-person-check text-success"></i> Lembar Refleksi Diri Murid (Mindful Learning)
                            </div>
                            <div class="p-2 rounded bg-light small mb-2">
                                <em>"Pikirkan dan renungkan proses belajar Anda hari ini:"</em>
                            </div>
                            <ol class="small text-secondary mb-0 ps-3" style="line-height: 1.6;">
                                <li>Apa pengetahuan dan keterampilan paling bermanfaat yang saya pelajari hari ini?</li>
                                <li>Langkah mana yang terasa paling menantang dan bagaimana cara saya mengatasinya?</li>
                                <li>Apa komitmen saya untuk meningkatkan kualitas hasil kerja saya pada pertemuan berikutnya?</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Format Umpan Balik Guru -->
                <div class="card border-0 bg-light p-3 rounded-3">
                    <div class="fw-bold text-dark small mb-2"><i class="bi bi-chat-left-quote-fill text-warning me-1"></i> Format Umpan Balik Deskriptif Guru (Constructive Feedback):</div>
                    <div class="bg-white p-3 border rounded small">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <span class="fw-semibold text-success">1. Hal Positif / Kekuatan yang Sudah Dicapai:</span>
                                <p class="text-muted mb-0 mt-1 fst-italic">"Sistematika langkah kerja Anda sudah sangat teratur sesuai urutan SOP industri dan penggunaan APD sangat disiplin."</p>
                            </div>
                            <div class="col-md-6">
                                <span class="fw-semibold text-warning text-dark">2. Rekomendasi / Area yang Perlu Diperbaiki:</span>
                                <p class="text-muted mb-0 mt-1 fst-italic">"Tingkatkan ketelitian pada tahap pengukuran akhir dan pastikan toleransi presisi tercatat rapi di lembar laporan."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: SUMATIF & VOKASI SMK -->
            <div class="tab-pane fade" id="content-sumatif" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-mortarboard text-danger me-2"></i> Asesmen Sumatif & Uji Kinerja Vokasi SMK</h6>
                    <span class="badge bg-danger">Assessment of Learning</span>
                </div>
                <p class="text-muted small mb-4">
                    Pengukuran capaian akhir lingkup materi yang menggabungkan pengujian kognitif HOTS berbasis kasus industri serta unjuk kerja unjuk keterampilan standar DUDI / UKK.
                </p>

                <!-- Job Sheet Unjuk Kerja Vokasi SMK -->
                <div class="card border-0 shadow-sm bg-white mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="fw-bold text-dark small"><i class="bi bi-tools text-primary me-2"></i> Lembar Observasi Unjuk Kerja Praktik Vokasi (Standar DUDI / UKK)</div>
                        <span class="badge bg-secondary">Standar Acuan: {{ $asesmen->vokasi_dudi_data['standar_acuan'] ?? 'SKKNI & SOP Industri' }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th>Komponen Unjuk Kerja</th>
                                        <th width="15%">Bobot Nilai</th>
                                        <th>Kriteria Standar Industri</th>
                                        <th width="15%" class="text-center">Status Vokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($asesmen->vokasi_dudi_data['komponen_penilaian']))
                                        @foreach($asesmen->vokasi_dudi_data['komponen_penilaian'] as $idx => $k)
                                            <tr>
                                                <td class="text-center">{{ $idx + 1 }}</td>
                                                <td class="fw-bold text-dark">{{ $k['komponen'] }}</td>
                                                <td><span class="badge bg-light text-dark border">{{ $k['bobot'] }}</span></td>
                                                <td class="text-secondary">{{ $k['kriteria'] }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-success bg-opacity-25 text-success">K (Kompeten)</span> /
                                                    <span class="badge bg-danger bg-opacity-25 text-danger">BK (Belum)</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Data komponen unjuk kerja vokasi tersedia pada modul ajar terkait.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border bg-light p-3 rounded-3 h-100">
                            <div class="fw-bold text-dark small mb-2"><i class="bi bi-check-circle-fill text-success me-1"></i> Predikat Kelulusan Vokasi SMK:</div>
                            <ul class="small text-secondary mb-0" style="line-height: 1.6;">
                                <li><strong>Kompeten (K):</strong> Murid memenuhi seluruh standar mutu kerja minimal pada semua komponen kritis.</li>
                                <li><strong>Belum Kompeten (BK):</strong> Terdapat salah satu komponen kritis keselamatan atau fungsi yang belum memenuhi standar (wajib mengikuti remedial demonstrasi).</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border bg-light p-3 rounded-3 h-100">
                            <div class="fw-bold text-dark small mb-2"><i class="bi bi-journal-check text-primary me-1"></i> Soal Kasus Industri HOTS (Sumatif Teori):</div>
                            <p class="small text-secondary mb-0" style="line-height: 1.6;">
                                Soal dirancang berbasis pemecahan masalah riil industri (Meaningful Learning): analisis troubleshooting malfungsi sistem, studi kasus kendala produksi, dan usulan optimasi efisiensi biaya/waktu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: RUBRIK & INTERVAL KKTP -->
            <div class="tab-pane fade" id="content-kktp" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-sliders text-warning me-2"></i> Kriteria Ketercapaian Tujuan Pembelajaran (KKTP)</h6>
                    <span class="badge bg-warning text-dark">Pedoman Resmi PPA Kemendikdasmen</span>
                </div>
                <p class="text-muted small mb-4">
                    Instrumen penilaian kualitatif bertingkat untuk mengukur sejauh mana murid mencapai tujuan pembelajaran tanpa bergantung pada KKM tunggal.
                </p>

                <!-- 1. Rubrik 4 Skala Capaian -->
                <div class="card border-0 shadow-sm bg-white mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="fw-bold text-dark small"><i class="bi bi-table text-primary me-2"></i> 1. Rubrik Capaian Kinerja (4 Skala Ketercapaian)</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Aspek Penilaian</th>
                                        <th width="20%" class="bg-danger bg-opacity-10 text-danger text-center">Perlu Bimbingan (0-60)</th>
                                        <th width="20%" class="bg-warning bg-opacity-10 text-dark text-center">Cukup (61-70)</th>
                                        <th width="20%" class="bg-success bg-opacity-10 text-success text-center">Baik / Layak (71-85) <br><small class="text-muted">[STANDAR TUNTAS]</small></th>
                                        <th width="20%" class="bg-primary bg-opacity-10 text-primary text-center">Sangat Baik (86-100)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($asesmen->kktp_data['kriteria']))
                                        @foreach($asesmen->kktp_data['kriteria'] as $crit)
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $crit['aspek'] }}</td>
                                                <td class="text-secondary small">{{ $crit['perlu_bimbingan'] }}</td>
                                                <td class="text-secondary small">{{ $crit['cukup'] }}</td>
                                                <td class="text-secondary small bg-success bg-opacity-10">{{ $crit['baik'] }}</td>
                                                <td class="text-secondary small">{{ $crit['sangat_baik'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Rubrik KKTP detail dimuat dari data generator.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 2. Tabel Interval Nilai & Tindak Lanjut -->
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="fw-bold text-dark small"><i class="bi bi-bar-chart-steps text-success me-2"></i> 2. Tabel Interval Nilai & Tindak Lanjut Resmi Kemendikdasmen</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%" class="text-center">Interval Nilai</th>
                                        <th width="25%">Status Ketercapaian</th>
                                        <th>Rencana Tindak Lanjut Pedagogis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($asesmen->tindak_lanjut_data['interval']))
                                        @foreach($asesmen->tindak_lanjut_data['interval'] as $iv)
                                            <tr>
                                                <td class="text-center fw-bold fs-6">
                                                    <span class="badge bg-{{ $iv['badge'] }}">{{ $iv['rentang'] }}</span>
                                                </td>
                                                <td class="fw-bold text-dark">{{ $iv['status'] }}</td>
                                                <td class="text-secondary">{{ $iv['tindak_lanjut'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center"><span class="badge bg-danger">0% - 40%</span></td>
                                            <td>Belum mencapai tujuan pembelajaran</td>
                                            <td>Remedial menyeluruh di seluruh bagian materi.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><span class="badge bg-warning text-dark">41% - 65%</span></td>
                                            <td>Belum mencapai ketuntasan</td>
                                            <td>Remedial parsial pada indikator yang belum dikuasai.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><span class="badge bg-success">66% - 85%</span></td>
                                            <td>Sudah mencapai ketuntasan</td>
                                            <td>Tuntas. Tidak perlu remedial, dapat lanjut materi berikutnya.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><span class="badge bg-primary">86% - 100%</span></td>
                                            <td>Mencapai ketuntasan sangat baik</td>
                                            <td>Pengayaan materi tingkat lanjut atau proyek kejuruan mandiri.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: DESKRIPSI RAPOR -->
            <div class="tab-pane fade" id="content-rapor" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-card-text text-secondary me-2"></i> Generator Deskripsi Rapor Kurikulum Merdeka</h6>
                    <span class="badge bg-secondary">Format Resmi e-Rapor</span>
                </div>
                <p class="text-muted small mb-4">
                    Sesuai PPA Kemendikdasmen 2025/2026, buku laporan hasil belajar (rapor) wajib memuat deskripsi capaian kompetensi yang menonjolkan kekuatan murid dan area yang memerlukan bimbingan.
                </p>

                <div class="card border-0 shadow-sm p-4 bg-white mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border border-success bg-success bg-opacity-10 h-100">
                                <div class="fw-bold text-success small mb-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-star-fill"></i> Narasi Capaian Tertinggi (Kekuatan Murid):
                                </div>
                                <p class="text-dark small mb-0" style="line-height: 1.6;">
                                    "{{ $asesmen->deskripsi_rapor['capaian_tertinggi'] ?? 'Menunjukkan penguasaan yang sangat baik dalam mengaplikasikan konsep dan mempraktikkan keterampilan pada tujuan pembelajaran ini.' }}"
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border border-warning bg-warning bg-opacity-10 h-100">
                                <div class="fw-bold text-dark small mb-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Narasi Capaian yang Perlu Ditingkatkan:
                                </div>
                                <p class="text-dark small mb-0" style="line-height: 1.6;">
                                    "{{ $asesmen->deskripsi_rapor['perlu_ditingkatkan'] ?? 'Perlu pendampingan dan latihan intensif lebih lanjut dalam penguatan analisis pemecahan masalah teknis.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info bg-light border text-dark small">
                    <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                    <strong>Panduan Guru untuk Pengisian e-Rapor:</strong> Salin narasi capaian di atas ke dalam aplikasi e-Rapor SMK sesuai data capaian aktual portofolio dan nilai sumatif masing-masing siswa.
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
