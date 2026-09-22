<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $modulAjar->judul }}</title>
    <style>
        @page {
            margin: 15mm 15mm 18mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #1a202c;
            line-height: 1.4;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .header-subtitle {
            text-align: center;
            font-size: 9pt;
            color: #4a5568;
            margin-bottom: 16px;
        }
        .section-header {
            background-color: #1e3c72;
            color: white;
            font-weight: bold;
            font-size: 9.5pt;
            padding: 5px 10px;
            margin-top: 14px;
            margin-bottom: 8px;
            border-radius: 3px;
            page-break-after: avoid;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .meta-table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .meta-table tr {
            page-break-inside: avoid;
        }
        .pedatti-box {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            margin-bottom: 8px;
            border-radius: 4px;
            background-color: #f8fafc;
            page-break-inside: avoid;
        }
        .pedatti-title {
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 4px;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 3px;
        }
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $modulAjar->user->satuanPendidikan])

    <div class="header-title">MODUL AJAR KURIKULUM MERDEKA</div>
    <div class="header-subtitle">Pendekatan Pembelajaran Mendalam (Deep Learning) &bull; Permendikdasmen No. 13 Tahun 2025</div>

    <!-- A. INFORMASI UMUM -->
    <div class="section-header">A. INFORMASI UMUM</div>
    <table class="meta-table">
        <tr>
            <td width="28%"><strong>Nama Penyusun</strong></td>
            <td width="3%">:</td>
            <td width="69%">{{ $modulAjar->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Satuan Pendidikan</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->mataPelajaran->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Fase / Kelas</strong></td>
            <td>:</td>
            <td>Fase {{ $modulAjar->fase->kode ?? '-' }} (Kelas {{ $modulAjar->fase->kelas_range ?? '-' }})</td>
        </tr>
        <tr>
            <td><strong>Alokasi Waktu</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->alokasi_waktu_jp ?? 12 }} JP ({{ $modulAjar->jumlah_pertemuan ?? 3 }} Pertemuan)</td>
        </tr>
        <tr>
            <td><strong>Kompetensi Awal</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->kompetensi_awal ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Dimensi Profil Lulusan</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->profil_lulusan_target ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Sarana & Prasarana</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->sarana_prasarana ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Target Peserta Didik</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->target_peserta_didik ?? 'Peserta didik reguler' }}</td>
        </tr>
    </table>

    <!-- B. KOMPONEN INTI -->
    <div class="section-header">B. KOMPONEN INTI</div>
    <table class="meta-table">
        <tr>
            <td width="28%"><strong>Tujuan Pembelajaran (TP)</strong></td>
            <td width="3%">:</td>
            <td width="69%">{{ $modulAjar->tujuanPembelajaran->deskripsi_tp ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Pemahaman Bermakna</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->pemahaman_bermakna ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Pertanyaan Pemantik</strong></td>
            <td>:</td>
            <td>{!! nl2br(e($modulAjar->pertanyaan_pemantik)) !!}</td>
        </tr>
    </table>

    <!-- C. LANGKAH-LANGKAH PEMBELAJARAN (PEDATTI) -->
    <div class="section-header">C. LANGKAH-LANGKAH PEMBELAJARAN (ALUR PEDATTI)</div>
    @foreach($modulAjar->kegiatans as $keg)
        <div class="pedatti-box">
            <div class="pedatti-title">
                {{ strtoupper($keg->tahap_pedatti) }} ({{ $keg->durasi_menit ?? 30 }} Menit) &bull; {{ $keg->prinsip_deep_learning }} &bull; {{ $keg->olah }}
            </div>
            <div>{!! nl2br(e($keg->deskripsi_kegiatan)) !!}</div>
        </div>
    @endforeach

    <!-- D. ASESMEN & EVALUASI -->
    <div class="section-header">D. ASESMEN & EVALUASI HASIL BELAJAR</div>
    <table class="meta-table">
        <tr>
            <td width="28%"><strong>1. Asesmen Awal (Diagnostik)</strong></td>
            <td width="3%">:</td>
            <td width="69%">{{ $modulAjar->asesmen_awal ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>2. Asesmen Formatif (Proses)</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->asesmen_formatif ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>3. Asesmen Sumatif (Akhir)</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->asesmen_sumatif ?? '-' }}</td>
        </tr>
    </table>

    <!-- E. LAMPIRAN -->
    <div class="section-header">E. LAMPIRAN</div>
    <table class="meta-table">
        <tr>
            <td width="28%"><strong>Pengayaan & Remedial</strong></td>
            <td width="3%">:</td>
            <td width="69%">
                <strong>Pengayaan:</strong> {{ $modulAjar->pengayaan ?? '-' }}<br>
                <strong>Remedial:</strong> {{ $modulAjar->remedial ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Glosarium</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->glosarium ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Daftar Pustaka</strong></td>
            <td>:</td>
            <td>{{ $modulAjar->daftar_pustaka ?? '-' }}</td>
        </tr>
    </table>

    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $modulAjar->user->satuanPendidikan, 'guru' => $modulAjar->user])

</body>
</html>
