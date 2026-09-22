<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $asesmen->judul }}</title>
    <style>
        @page {
            margin: 12mm 12mm 16mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #1a202c;
            line-height: 1.35;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            margin-bottom: 2px;
            color: #1e3c72;
        }
        .header-subtitle {
            text-align: center;
            font-size: 8pt;
            color: #4a5568;
            margin-bottom: 12px;
            border-bottom: 2px solid #1e3c72;
            padding-bottom: 5px;
        }
        .section-header {
            background-color: #1e3c72;
            color: white;
            font-weight: bold;
            font-size: 8.5pt;
            padding: 4px 8px;
            margin-top: 10px;
            margin-bottom: 6px;
            border-radius: 2px;
            page-break-after: avoid;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
            font-size: 8pt;
        }
        .meta-table tr {
            page-break-inside: avoid;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 8pt;
        }
        .content-table th, .content-table td {
            border: 1px solid #cbd5e1;
            padding: 4px 6px;
            vertical-align: top;
        }
        .content-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #1e293b;
        }
        .content-table tr {
            page-break-inside: avoid;
        }
        .box {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            margin-bottom: 6px;
            border-radius: 3px;
            background-color: #f8fafc;
            font-size: 8pt;
            page-break-inside: avoid;
        }
        .badge {
            display: inline-block;
            padding: 1px 4px;
            font-size: 7.5pt;
            font-weight: bold;
            border-radius: 2px;
        }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        .badge-primary { background-color: #dbeafe; color: #1d4ed8; }
        .signature-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            font-size: 8pt;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $asesmen->user->satuanPendidikan])

    <!-- KOP DOKUMEN -->
    <div class="header-title">INSTRUMEN ASESMEN PEMBELAJARAN MENDALAM (DEEP LEARNING)</div>
    <div class="header-subtitle">
        Keputusan Kepala BSKAP No. 046/H/KR/2025 &bull; Panduan Pembelajaran dan Asesmen (PPA) Revisi 2025/2026 &bull; Permendikdasmen No. 13/2025
    </div>

    <!-- IDENTITAS DOKUMEN -->
    <table class="meta-table">
        <tr>
            <td width="20%"><strong>Satuan Pendidikan</strong></td>
            <td width="2%">:</td>
            <td width="38%">{{ $asesmen->user->satuanPendidikan?->nama ?? 'SMK Negeri / Swasta Mitra Industri' }}</td>
            <td width="18%"><strong>Fase / Jenjang</strong></td>
            <td width="2%">:</td>
            <td width="20%">Fase {{ $asesmen->fase->kode ?? '-' }} ({{ $asesmen->fase->kelas_range ?? 'Kelas X/XI/XII' }})</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $asesmen->mataPelajaran->nama ?? '-' }}</td>
            <td><strong>Program Keahlian</strong></td>
            <td>:</td>
            <td>{{ $asesmen->mataPelajaran?->programKeahlian?->nama ?? 'Umum / Pilihan' }}</td>
        </tr>
        <tr>
            <td><strong>Tujuan Pembelajaran (TP)</strong></td>
            <td>:</td>
            <td>{{ $asesmen->tujuanPembelajaran ? $asesmen->tujuanPembelajaran->kode_tp . ' - ' . $asesmen->tujuanPembelajaran->deskripsi_tp : 'TP Terpilih' }}</td>
            <td><strong>Penyusun</strong></td>
            <td>:</td>
            <td>{{ $asesmen->user->name ?? 'Guru Pengampu' }}</td>
        </tr>
    </table>

    <!-- 1. ASESMEN DIAGNOSTIK (AWAL) -->
    <div class="section-header">1. ASESMEN DIAGNOSTIK (AWAL PEMBELAJARAN - PEMETAAN DIFERENSIASI)</div>
    <div class="box">
        <em>Prinsip PPA 2025/2026: Asesmen Diagnostik digunakan murni untuk memetakan kesiapan, minat, dan gaya belajar murid. <u>TIDAK DIBOBOT untuk nilai akhir rapor</u>.</em>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="30%">Aspek Diagnostik</th>
                <th>Instrumen & Pertanyaan Pemantik Kesiapan</th>
                <th width="30%">Tindak Lanjut Diferensiasi Belajar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Non-Kognitif</strong><br><small class="text-muted">Profil Minat & Gaya Belajar</small></td>
                <td>Kuesioner gaya belajar (Visual, Auditori, Kinestetik) dan motivasi minat terhadap profesi kejuruan {{ $asesmen->mataPelajaran->nama ?? '' }}.</td>
                <td>Guru mengelompokkan model penugasan: demonstrasi fisik (kinestetik), infografis/diagram (visual), presentasi audio (auditori).</td>
            </tr>
            <tr>
                <td><strong>Kognitif Prasyarat</strong><br><small class="text-muted">Konsep Prasyarat</small></td>
                <td>3 Soal pemantik pengetahuan awal mengenai fungsi, peralatan dasar, dan keselamatan kerja (K3) pada materi ini.</td>
                <td>
                    - Murid belum siap: Pendampingan konsep dasar (scaffolding).<br>
                    - Murid siap: Alur belajar reguler.<br>
                    - Murid mahir: Tutor sebaya & pengayaan.
                </td>
            </tr>
        </tbody>
    </table>

    <!-- 2. ASESMEN FORMATIF (PROSES) -->
    <div class="section-header">2. ASESMEN FORMATIF (PROSES PEMBELAJARAN - ASSESSMENT AS & FOR LEARNING)</div>
    <div class="box">
        <em>Prinsip PPA 2025/2026: Mengutamakan <u>umpan balik kualitatif (feedback deskriptif)</u> dan metakognisi murid, bukan pemberian skor angka mutlak.</em>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="25%">Bentuk Asesmen Formatif</th>
                <th>Teknik & Indikator Pengamatan</th>
                <th width="35%">Panduan Umpan Balik Guru (Constructive Feedback)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Observasi Sikap & Partisipasi</strong><br><small class="text-muted">Olah Pikir & Olah Rasa</small></td>
                <td>Keterlibatan aktif bertanya, kerja sama inklusif, kedisiplinan APD, dan kepatuhan budaya kerja 5R.</td>
                <td>Memberikan apresiasi spesifik atas keaktifan dan membimbing secara persuasif jika ada aturan keselamatan kerja yang terabaikan.</td>
            </tr>
            <tr>
                <td><strong>Refleksi Diri & Antarteman</strong><br><small class="text-muted">Mindful Learning</small></td>
                <td>Lembar penilaian metakognitif: Mengidentifikasi bagian yang sudah dikuasai dan kendala yang dihadapi saat praktik.</td>
                <td>Guru memvalidasi refleksi murid dan memberikan arahan strategi perbaikan mandiri.</td>
            </tr>
        </tbody>
    </table>

    <!-- 3. ASESMEN SUMATIF & JOB SHEET VOKASI SMK -->
    <div class="section-header">3. ASESMEN SUMATIF & UNJUK KERJA PRAKTIK VOKASI SMK (STANDAR DUDI)</div>
    <div class="box">
        <em>Standar Acuan: {{ $asesmen->vokasi_dudi_data['standar_acuan'] ?? 'SKKNI & SOP Industri Mitra' }} | Kategori: Kompeten (K) / Belum Kompeten (BK)</em>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="35%">Komponen Unjuk Kerja Vokasi</th>
                <th width="12%" style="text-align: center;">Bobot Nilai</th>
                <th>Kriteria Standar Industri DUDI</th>
                <th width="15%" style="text-align: center;">Hasil Observasi</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($asesmen->vokasi_dudi_data['komponen_penilaian']))
                @foreach($asesmen->vokasi_dudi_data['komponen_penilaian'] as $idx => $k)
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td><strong>{{ $k['komponen'] }}</strong></td>
                        <td style="text-align: center;">{{ $k['bobot'] }}</td>
                        <td>{{ $k['kriteria'] }}</td>
                        <td style="text-align: center;">[ &nbsp; ] K &nbsp;&nbsp; [ &nbsp; ] BK</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>Persiapan Kerja & APD</td>
                    <td style="text-align: center;">15%</td>
                    <td>Alat, bahan, dan APD lengkap sesuai SOP</td>
                    <td style="text-align: center;">[ &nbsp; ] K &nbsp;&nbsp; [ &nbsp; ] BK</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>Proses & Langkah Kerja</td>
                    <td style="text-align: center;">40%</td>
                    <td>Sistematika prosedur kerja berurutan dan aman</td>
                    <td style="text-align: center;">[ &nbsp; ] K &nbsp;&nbsp; [ &nbsp; ] BK</td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td>Hasil Kerja (Kualitas Presisi)</td>
                    <td style="text-align: center;">30%</td>
                    <td>Fungsi optimal dan toleransi presisi tercapai</td>
                    <td style="text-align: center;">[ &nbsp; ] K &nbsp;&nbsp; [ &nbsp; ] BK</td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td>Sikap Kerja 5R & Waktu</td>
                    <td style="text-align: center;">15%</td>
                    <td>Tempat kerja bersih, rapi, dan tepat waktu</td>
                    <td style="text-align: center;">[ &nbsp; ] K &nbsp;&nbsp; [ &nbsp; ] BK</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- 4. RUBRIK & INTERVAL KKTP -->
    <div class="section-header">4. KRITERIA KETERCAPAIAN TUJUAN PEMBELAJARAN (KKTP) RESMI KEMENDIKDASMEN</div>
    
    <div style="font-weight: bold; margin-bottom: 4px; font-size: 8pt;">A. Rubrik Kinerja Capaian Kualitatif (4 Skala):</div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="20%">Aspek Kriteria</th>
                <th width="20%">Perlu Bimbingan (0-60)</th>
                <th width="20%">Cukup (61-70)</th>
                <th width="20%" style="background-color: #dcfce7; color: #15803d;">Baik / Layak (71-85)<br><small>[STANDAR TUNTAS]</small></th>
                <th width="20%">Sangat Baik (86-100)</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($asesmen->kktp_data['kriteria']))
                @foreach($asesmen->kktp_data['kriteria'] as $crit)
                    <tr>
                        <td><strong>{{ $crit['aspek'] }}</strong></td>
                        <td>{{ $crit['perlu_bimbingan'] }}</td>
                        <td>{{ $crit['cukup'] }}</td>
                        <td style="background-color: #f0fdf4;">{{ $crit['baik'] }}</td>
                        <td>{{ $crit['sangat_baik'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td><strong>Konseptual & Prosedural</strong></td>
                    <td>Belum memahami alur dasar kerja.</td>
                    <td>Memahami dengan bantuan guru.</td>
                    <td style="background-color: #f0fdf4;">Menguasai secara mandiri dan benar.</td>
                    <td>Menganalisis dan mengevaluasi kasus industri.</td>
                </tr>
                <tr>
                    <td><strong>Keterampilan Praktik</strong></td>
                    <td>Belum mampu tanpa bimbingan penuh.</td>
                    <td>Mampu sebagian dengan sedikit koreksi.</td>
                    <td style="background-color: #f0fdf4;">Mempraktikkan mandiri sesuai SOP.</td>
                    <td>Presisi, cepat, mandiri, dan berinovasi.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="font-weight: bold; margin-top: 8px; margin-bottom: 4px; font-size: 8pt;">B. Tabel Interval Nilai & Tindak Lanjut Resmi Kemendikdasmen:</div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="15%" style="text-align: center;">Interval Nilai</th>
                <th width="25%">Status Ketercapaian</th>
                <th>Rencana Tindak Lanjut Pedagogis Guru</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($asesmen->tindak_lanjut_data['interval']))
                @foreach($asesmen->tindak_lanjut_data['interval'] as $iv)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $iv['rentang'] }}</td>
                        <td><strong>{{ $iv['status'] }}</strong></td>
                        <td>{{ $iv['tindak_lanjut'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="text-align: center;">0% - 40%</td>
                    <td>Belum Mencapai Tujuan Pembelajaran</td>
                    <td>Remedial menyeluruh di seluruh materi dengan tutor sebaya dan bimbingan intensif.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">41% - 65%</td>
                    <td>Belum Mencapai Ketuntasan</td>
                    <td>Remedial parsial pada indikator kompetensi yang belum tuntas.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">66% - 85%</td>
                    <td>Sudah Mencapai Ketuntasan</td>
                    <td>Tuntas. Tidak perlu remedial, dapat melanjutkan ke materi berikutnya.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">86% - 100%</td>
                    <td>Mencapai Ketuntasan Sangat Baik</td>
                    <td>Pengayaan materi tingkat lanjut atau proyek tantangan kejuruan DUDI mandiri.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- 5. DESKRIPSI RAPOR & PENGOLAHAN NILAI AKHIR -->
    <div class="section-header">5. FORMAT DESKRIPSI BUKU RAPOR SISWA (KURIKULUM MERDEKA)</div>
    <table class="content-table">
        <thead>
            <tr>
                <th width="50%" style="color: #15803d; background-color: #dcfce7;">Capaian Tertinggi (Kekuatan Murid)</th>
                <th width="50%" style="color: #854d0e; background-color: #fef9c3;">Capaian yang Perlu Ditingkatkan (Perlu Bimbingan)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-style: italic;">
                    "{{ $asesmen->deskripsi_rapor['capaian_tertinggi'] ?? 'Menunjukkan penguasaan sangat baik dalam memahami prinsip kerja dan mempraktikkan keterampilan sesuai SOP industri.' }}"
                </td>
                <td style="font-style: italic;">
                    "{{ $asesmen->deskripsi_rapor['perlu_ditingkatkan'] ?? 'Perlu pendampingan dan latihan intensif lebih lanjut dalam meningkatkan ketelitian operasional dan analisis troubleshooting.' }}"
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TANDA TANGAN PENGESAHAN -->
    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $asesmen->user->satuanPendidikan, 'guru' => $asesmen->user])

</body>
</html>
