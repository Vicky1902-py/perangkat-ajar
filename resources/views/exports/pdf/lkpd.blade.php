<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $lkpd->judul }}</title>
    <style>
        @page {
            margin: 15mm 15mm 18mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #1a202c;
            line-height: 1.35;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 12.5pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .header-subtitle {
            text-align: center;
            font-size: 8.5pt;
            color: #4a5568;
            margin-bottom: 12px;
        }
        .meta-box {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            background-color: #f8fafc;
            border-radius: 4px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .section-title {
            font-weight: bold;
            font-size: 9.5pt;
            background-color: #e2e8f0;
            padding: 4px 8px;
            margin-top: 10px;
            margin-bottom: 5px;
            border-left: 4px solid #2563eb;
            page-break-after: avoid;
        }
        .stimulus-box {
            border: 1px dashed #3b82f6;
            background-color: #eff6ff;
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-style: italic;
            page-break-inside: avoid;
        }
        .activity-block {
            margin-bottom: 10px;
            padding-left: 6px;
            page-break-inside: avoid;
        }
        .answer-box {
            border: 1px solid #cbd5e1;
            min-height: 55px;
            background-color: #ffffff;
            padding: 6px 8px;
            margin-top: 4px;
            margin-bottom: 8px;
            border-radius: 4px;
            color: #94a3b8;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $lkpd->user->satuanPendidikan])

    <div class="header-title">LEMBAR KERJA MURID (LKPD)</div>
    <div class="header-subtitle">Kurikulum Merdeka SMK &bull; Pendekatan Pembelajaran Mendalam (Deep Learning)</div>

    <div class="meta-box">
        <table width="100%" style="font-size: 9.5pt;">
            <tr>
                <td width="20%"><strong>Mata Pelajaran</strong></td>
                <td width="3%">:</td>
                <td width="40%">{{ $lkpd->mataPelajaran->nama ?? '-' }}</td>
                <td width="15%"><strong>Fase / Kelas</strong></td>
                <td width="3%">:</td>
                <td width="19%">Fase {{ $lkpd->fase->kode ?? '-' }} ({{ $lkpd->fase->kelas_range ?? '-' }})</td>
            </tr>
            <tr>
                <td><strong>Satuan Pendidikan</strong></td>
                <td>:</td>
                <td>{{ $lkpd->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</td>
                <td><strong>Alokasi Waktu</strong></td>
                <td>:</td>
                <td>{{ $lkpd->alokasi_waktu_menit ?? 90 }} Menit</td>
            </tr>
            <tr>
                <td><strong>Nama Kelompok</strong></td>
                <td>:</td>
                <td colspan="4">_____________________________________________________________</td>
            </tr>
            <tr>
                <td><strong>Anggota</strong></td>
                <td>:</td>
                <td colspan="4">1. __________________ 2. __________________ 3. __________________ 4. __________________</td>
            </tr>
        </table>
    </div>

    <!-- TUJUAN PEMBELAJARAN -->
    <div class="section-title">A. TUJUAN PEMBELAJARAN</div>
    <div style="padding-left: 8px; margin-bottom: 10px;">
        {{ $lkpd->tujuan_pembelajaran }}
    </div>

    <!-- STIMULUS OTENTIK -->
    <div class="section-title">B. STIMULUS OTENTIK (STUDI KASUS INDUSTRI)</div>
    <div class="stimulus-box">
        {!! nl2br(e($lkpd->stimulus_otentik)) !!}
    </div>

    <!-- PETUNJUK KERJA -->
    <div class="section-title">C. PETUNJUK BELAJAR & ALAT BAHAN</div>
    <div style="padding-left: 8px; margin-bottom: 10px; font-size: 9.5pt;">
        <strong>Petunjuk:</strong><br>
        {!! nl2br(e($lkpd->petunjuk_belajar)) !!}<br><br>
        <strong>Alat & Bahan:</strong> {{ $lkpd->alat_bahan }}
    </div>

    <!-- LANGKAH KERJA (3 TAHAP DEEP LEARNING) -->
    <div class="section-title">D. LANGKAH KERJA PENGALAMAN BELAJAR MENDALAM</div>
    @foreach($lkpd->kegiatans as $keg)
        <div class="activity-block">
            <div style="font-weight: bold; color: #1e3c72; margin-bottom: 2px;">
                Tahap {{ $loop->iteration }}: {{ strtoupper($keg->tahap) }}
            </div>
            <div style="font-size: 9pt;"><strong>Instruksi:</strong> {{ $keg->instruksi }}</div>
            <div style="font-size: 9pt;"><strong>Pertanyaan / Tugas:</strong> {{ $keg->pertanyaan }}</div>
            <div class="answer-box">
                <em>Ruang Jawaban / Hasil Kerja Kelompok:</em>
            </div>
        </div>
    @endforeach

    <!-- RUBRIK PENILAIAN -->
    <div class="section-title">E. RUBRIK PENILAIAN PROSES & HASIL</div>
    <div style="padding-left: 8px; font-size: 9pt;">
        {!! nl2br(e($lkpd->rubrik_penilaian)) !!}
    </div>

    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $lkpd->user->satuanPendidikan, 'guru' => $lkpd->user])

</body>
</html>
