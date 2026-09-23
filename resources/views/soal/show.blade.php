@extends('layouts.app')

@section('title', 'Naskah Asesmen: ' . $paketSoal->judul)

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">

    <!-- BREADCRUMB & ACTION BUTTONS -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <a href="{{ route('paket-soal.index') }}" class="text-secondary small text-decoration-none d-inline-flex align-items-center gap-1 mb-1">
                <i class="bi bi-arrow-left"></i> Kembali ke Bank Soal
            </a>
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h4 class="fw-bold text-dark mb-0" style="color: #0b3b60 !important;">
                    {{ $paketSoal->judul }}
                </h4>
                <span class="badge badge-soft-primary rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                    {{ $paketSoal->jenis_ujian_label }}
                </span>
            </div>
            <div class="text-muted small">
                {{ $paketSoal->mataPelajaran->nama ?? '-' }} &bull; Fase {{ $paketSoal->fase->kode ?? '-' }} (Kelas {{ $paketSoal->fase->kelas_range ?? '-' }}) &bull; Waktu: {{ $paketSoal->alokasi_waktu_menit }} Menit
            </div>
        </div>

        <!-- TOMBOL AKSI EKSPOR & CETAK -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- MODAL EDIT METADATA -->
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditSoal">
                <i class="bi bi-pencil-square"></i>
                <span>Edit Naskah</span>
            </button>

            <!-- CETAK NASKAH SISWA (PDF) -->
            <a href="{{ route('export.soal.siswa.pdf', $paketSoal->id) }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1.5">
                <i class="bi bi-person-badge"></i>
                <span>PDF Soal Siswa</span>
            </a>

            <!-- CETAK PEGANGAN GURU LENGKAP (PDF) -->
            <a href="{{ route('export.soal.guru.pdf', $paketSoal->id) }}" class="btn btn-danger btn-sm rounded-pill px-3.5 shadow-sm text-white fw-bold d-inline-flex align-items-center gap-1.5" style="background: #dc2626; border: none;">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>PDF Lengkap Guru</span>
            </a>

            <!-- UNDUH WORD -->
            <a href="{{ route('export.soal.docx', $paketSoal->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
                <i class="bi bi-file-earmark-word-fill"></i>
                <span>Unduh Word (.docx)</span>
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TAB NAVIGATION UTAMA -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white p-2 border-bottom">
            <ul class="nav nav-pills gap-2" id="soalTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="kisi-kisi-tab" data-bs-toggle="tab" data-bs-target="#kisi-kisi" type="button" role="tab" aria-controls="kisi-kisi" aria-selected="true">
                        <i class="bi bi-table"></i>
                        <span>1. Tabel Kisi-Kisi Resmi Kemendikdasmen</span>
                        <span class="badge bg-primary bg-opacity-20 text-primary ms-1" style="font-size: 0.68rem;">{{ count($paketSoal->kisi_kisi_data ?? []) }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="soal-siswa-tab" data-bs-toggle="tab" data-bs-target="#soal-siswa" type="button" role="tab" aria-controls="soal-siswa" aria-selected="false">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>2. Naskah Lembar Soal Siswa</span>
                        <span class="badge bg-success bg-opacity-20 text-success ms-1" style="font-size: 0.68rem;">{{ $paketSoal->total_soal }} Butir</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2 small fw-bold d-inline-flex align-items-center gap-2" id="kunci-rubrik-tab" data-bs-toggle="tab" data-bs-target="#kunci-rubrik" type="button" role="tab" aria-controls="kunci-rubrik" aria-selected="false">
                        <i class="bi bi-key-fill text-warning"></i>
                        <span>3. Kunci Jawaban, Pembahasan & Rubrik Guru</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="tab-content" id="soalTabContent">

                <!-- ================= TAB 1: KISI-KISI SOAL RESMI KEMENDIKDASMEN ================= -->
                <div class="tab-pane fade show active" id="kisi-kisi" role="tabpanel" aria-labelledby="kisi-kisi-tab">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Tabel Spesifikasi / Kisi-Kisi Penulisan Soal</h5>
                            <p class="text-muted small mb-0">Disusun berdasarkan Keputusan Kepala BSKAP 046/H/KR/2025 dan Taksonomi Bloom.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-soft-success">PG: {{ $paketSoal->total_soal_pg }} Butir</span>
                            <span class="badge badge-soft-warning">Isian: {{ $paketSoal->total_soal_isian }} Butir</span>
                        </div>
                    </div>

                    @if(!empty($paketSoal->kisi_kisi_data) && count($paketSoal->kisi_kisi_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 0.83rem;">
                                <thead style="background: #f1f5f9; color: #0b3b60;">
                                    <tr class="text-center align-middle">
                                        <th style="width: 40px;">No</th>
                                        <th style="width: 140px;">Elemen Capaian</th>
                                        <th style="width: 200px;">Tujuan Pembelajaran (TP)</th>
                                        <th style="width: 150px;">Materi / Topik</th>
                                        <th>Indikator Butir Soal</th>
                                        <th style="width: 120px;">Level Kognitif</th>
                                        <th style="width: 80px;">Bentuk</th>
                                        <th style="width: 60px;">No. Soal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paketSoal->kisi_kisi_data as $idx => $k)
                                        <tr>
                                            <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                                            <td class="fw-semibold text-dark">{{ $k['elemen'] ?? '-' }}</td>
                                            <td class="text-muted small">{{ $k['tp'] ?? '-' }}</td>
                                            <td><span class="fw-semibold text-primary">{{ $k['materi'] ?? '-' }}</span></td>
                                            <td>{{ $k['indikator'] ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-soft-primary" style="font-size: 0.72rem;">
                                                    {{ $k['level_kognitif'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $k['bentuk_soal'] === 'Pilihan Ganda' ? 'badge-soft-success' : 'badge-soft-warning' }}" style="font-size: 0.72rem;">
                                                    {{ $k['bentuk_soal'] === 'Pilihan Ganda' ? 'PG' : 'Isian' }}
                                                </span>
                                            </td>
                                            <td class="text-center fw-bold text-dark fs-6">{{ $k['nomor_soal'] ?? ($idx + 1) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-light text-center py-4 text-muted">
                            Data kisi-kisi tidak tersedia.
                        </div>
                    @endif
                </div>

                <!-- ================= TAB 2: NASKAH SOAL SISWA ================= -->
                <div class="tab-pane fade" id="soal-siswa" role="tabpanel" aria-labelledby="soal-siswa-tab">
                    <!-- PRATINJAU LEMBAR IDENTITAS SISWA -->
                    <div class="p-3 rounded-3 mb-4 border" style="background: #f8fafc; border-color: #cbd5e1 !important;">
                        <div class="row g-2 small text-dark">
                            <div class="col-sm-6"><strong>Mata Pelajaran:</strong> {{ $paketSoal->mataPelajaran->nama ?? '-' }}</div>
                            <div class="col-sm-6"><strong>Nama Siswa:</strong> ___________________________________</div>
                            <div class="col-sm-6"><strong>Fase / Kelas:</strong> Fase {{ $paketSoal->fase->kode ?? '-' }} ({{ $paketSoal->fase->kelas_range ?? '-' }})</div>
                            <div class="col-sm-6"><strong>Kelas / No. Absen:</strong> ___________ / No: ________</div>
                            <div class="col-sm-6"><strong>Alokasi Waktu:</strong> {{ $paketSoal->alokasi_waktu_menit }} Menit</div>
                            <div class="col-sm-6"><strong>Hari / Tanggal:</strong> ___________________________________</div>
                        </div>
                    </div>

                    <!-- PETUNJUK PENGERJAAN -->
                    @if($paketSoal->petunjuk_umum)
                        <div class="alert alert-light border border-dashed py-2 px-3 small rounded-3 mb-4 text-muted">
                            <strong class="text-dark d-block mb-1"><i class="bi bi-info-circle me-1"></i> PETUNJUK UMUM PENGERJAAN:</strong>
                            {!! nl2br(e($paketSoal->petunjuk_umum)) !!}
                        </div>
                    @endif

                    <!-- BAGIAN I: PILIHAN GANDA -->
                    @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                        <div class="p-2 px-3 rounded-3 fw-bold text-white mb-3" style="background: #0b3b60; font-size: 0.88rem;">
                            BAGIAN I: SOAL PILIHAN GANDA (Pilihlah salah satu jawaban A, B, C, D, atau E yang paling benar)
                        </div>

                        <div class="mb-4">
                            @foreach($paketSoal->butir_soal_pg as $pg)
                                <div class="mb-3 p-3 rounded-3 border bg-white shadow-sm">
                                    <div class="d-flex align-items-start gap-2 mb-1.5">
                                        <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.78rem;">
                                            {{ $pg['nomor'] }}
                                        </span>
                                        <div class="fw-semibold text-dark" style="font-size: 0.92rem; line-height: 1.5;">
                                            {{ $pg['pertanyaan'] }}
                                        </div>
                                    </div>

                                    @if(!empty($pg['stimulus']))
                                        <div class="p-2.5 px-3 rounded-2 small text-secondary mb-2.5" style="background: #f8fafc; border-left: 3px solid #0284c7; font-size: 0.83rem;">
                                            <strong class="text-dark">Konteks/Kasus:</strong> {{ $pg['stimulus'] }}
                                        </div>
                                    @endif

                                    <div class="row g-2 ps-4">
                                        @foreach($pg['pilihan'] as $opt => $text)
                                            <div class="col-12">
                                                <div class="d-flex align-items-start gap-2 small">
                                                    <span class="fw-bold text-primary">{{ $opt }}.</span>
                                                    <span class="text-dark">{{ $text }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- BAGIAN II: ISIAN / URAIAN -->
                    @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                        <div class="p-2 px-3 rounded-3 fw-bold text-white mb-3" style="background: #0284c7; font-size: 0.88rem;">
                            BAGIAN II: SOAL ISIAN / URAIAN (Jawablah dengan terstruktur dan mengacu pada standar SOP)
                        </div>

                        <div>
                            @foreach($paketSoal->butir_soal_isian as $es)
                                <div class="mb-3 p-3 rounded-3 border bg-white shadow-sm">
                                    <div class="d-flex align-items-start gap-2 mb-1.5">
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.78rem;">
                                            {{ $es['nomor'] }}
                                        </span>
                                        <div class="fw-semibold text-dark" style="font-size: 0.92rem; line-height: 1.5;">
                                            {{ $es['pertanyaan'] }}
                                            <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.7rem;">Skor Maks: {{ $es['skor_maksimal'] ?? 10 }}</span>
                                        </div>
                                    </div>

                                    @if(!empty($es['stimulus']))
                                        <div class="p-2.5 px-3 rounded-2 small text-secondary mb-2.5" style="background: #f8fafc; border-left: 3px solid #f59e0b; font-size: 0.83rem;">
                                            <strong class="text-dark">Konteks Masalah:</strong> {{ $es['stimulus'] }}
                                        </div>
                                    @endif

                                    <div class="p-3 rounded-2 border border-dashed text-muted small" style="background: #fafafa; min-height: 80px;">
                                        <em>Ruang lembar jawaban peserta didik...</em>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ================= TAB 3: KUNCI JAWABAN & RUBRIK GURU ================= -->
                <div class="tab-pane fade" id="kunci-rubrik" role="tabpanel" aria-labelledby="kunci-rubrik-tab">
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-15 py-2.5 px-3 small rounded-3 mb-4 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill fs-5 text-warning"></i>
                        <div>
                            <strong>Dokumen Rahasia Pegangan Guru:</strong> Kunci jawaban, analisis pembahasan ilmiah, dan rubrik pedoman penskoran hanya untuk instruktur/guru dan tidak disertakan pada naskah siswa.
                        </div>
                    </div>

                    <!-- KUNCI PILIHAN GANDA -->
                    @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
                        <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-key-fill text-success"></i>
                            Kunci Jawaban & Pembahasan Pilihan Ganda
                        </h5>

                        <div class="row g-3 mb-4">
                            @foreach($paketSoal->butir_soal_pg as $pg)
                                <div class="col-md-6">
                                    <div class="card border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold text-dark small">Nomor {{ $pg['nomor'] }}</span>
                                            <span class="badge badge-soft-success fs-6 px-2.5 py-0.5">
                                                Kunci: {{ $pg['kunci_jawaban'] ?? $pg['kunci'] ?? '-' }}
                                            </span>
                                        </div>
                                        <p class="small text-dark mb-2 fw-semibold" style="font-size: 0.83rem;">
                                            {{ Str::limit($pg['pertanyaan'], 85) }}
                                        </p>
                                        <div class="p-2 rounded bg-white border small text-muted" style="font-size: 0.78rem;">
                                            <strong class="text-success"><i class="bi bi-lightbulb-fill"></i> Pembahasan Analitis:</strong><br>
                                            {{ $pg['pembahasan'] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- RUBRIK PENSKORAN ISIAN -->
                    @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
                        <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-clipboard2-check-fill text-primary"></i>
                            Kriteria Jawaban & Rubrik Pedoman Penskoran Isian / Uraian
                        </h5>

                        <div>
                            @foreach($paketSoal->butir_soal_isian as $es)
                                <div class="card border rounded-3 p-3 mb-3" style="background: #ffffff;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold text-dark">Soal Nomor {{ $es['nomor'] }}</span>
                                        <span class="badge badge-soft-primary">Skor Maksimal: {{ $es['skor_maksimal'] ?? 10 }}</span>
                                    </div>
                                    <div class="small fw-semibold text-dark mb-2">
                                        {{ $es['pertanyaan'] }}
                                    </div>

                                    <div class="p-2.5 rounded-3 mb-2" style="background: #eff6ff; border: 1px solid #bfdbfe; font-size: 0.8rem; color: #1e40af;">
                                        <strong><i class="bi bi-check2-circle"></i> Kata Kunci / Kriteria Jawaban:</strong><br>
                                        {{ $es['kata_kunci'] ?? '-' }}
                                    </div>

                                    <div class="p-2.5 rounded-3" style="background: #fefce8; border: 1px solid #fef08a; font-size: 0.78rem; color: #854d0e;">
                                        <strong><i class="bi bi-rulers"></i> Rubrik Pedoman Penskoran:</strong><br>
                                        {!! nl2br(e($es['pedoman_penskoran'] ?? '-')) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

<!-- MODAL EDIT METADATA SOAL -->
<div class="modal fade" id="modalEditSoal" tabindex="-1" aria-labelledby="modalEditSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('paket-soal.update', $paketSoal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 py-3 px-4 bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalEditSoalLabel">Edit Informasi Naskah Soal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Judul Naskah Asesmen</label>
                        <input type="text" name="judul" class="form-control rounded-3" value="{{ $paketSoal->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Alokasi Waktu (Menit)</label>
                        <input type="number" name="alokasi_waktu_menit" class="form-control rounded-3" value="{{ $paketSoal->alokasi_waktu_menit }}" min="10" max="300" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted">Petunjuk Umum Pengerjaan</label>
                        <textarea name="petunjuk_umum" class="form-control rounded-3" rows="5">{{ $paketSoal->petunjuk_umum }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
