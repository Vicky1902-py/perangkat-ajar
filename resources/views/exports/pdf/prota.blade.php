<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Program Tahunan - {{ $prota->mataPelajaran->nama ?? 'Mapel' }}</title>
    <style>
        @page {
            margin: 12mm 12mm 16mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
            color: #1a202c;
            line-height: 1.35;
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
            margin-bottom: 14px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 14px;
            font-size: 9pt;
        }
        .meta-table td {
            padding: 2px 4px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 7px;
            vertical-align: top;
        }
        .data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: center;
        }
        .data-table tr {
            page-break-inside: avoid;
        }
        .footer-sign {
            width: 100%;
            margin-top: 25px;
            font-size: 9pt;
            page-break-inside: avoid;
        }
        .total-row {
            background-color: #f8fafc;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $prota->user->satuanPendidikan])

    <div class="header-title">PROGRAM TAHUNAN (PROTA)</div>
    <div class="header-subtitle">Berdasarkan Permendikdasmen No. 13 Tahun 2025 &bull; Keputusan Kepala BSKAP No. 046/H/KR/2025 &bull; Pendekatan Deep Learning</div>

    <table class="meta-table">
        <tr>
            <td width="18%"><strong>Satuan Pendidikan</strong></td>
            <td width="3%">:</td>
            <td width="35%">{{ $prota->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</td>
            <td width="15%"><strong>Fase / Kelas</strong></td>
            <td width="3%">:</td>
            <td width="26%">Fase {{ $prota->fase->kode ?? '-' }} (Kelas {{ $prota->fase->kelas_range ?? '-' }})</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $prota->mataPelajaran->nama ?? '-' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td>{{ $prota->tahunAjaran->nama ?? '2026/2027' }}</td>
        </tr>
        <tr>
            <td><strong>Program Keahlian</strong></td>
            <td>:</td>
            <td>{{ $prota->mataPelajaran->programKeahlian->nama ?? 'Semua Program Keahlian' }}</td>
            <td><strong>Penyusun / Guru</strong></td>
            <td>:</td>
            <td>{{ $prota->user->name ?? '-' }}</td>
        </tr>
    </table>

    @php
        $items = $prota->data_json ?? [];
        $totalJp = 0;
        foreach ($items as $it) {
            $totalJp += (int)($it['alokasi_jp'] ?? 12);
        }
    @endphp

    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Semester</th>
                <th width="20%">Elemen CP / Lingkup Materi</th>
                <th width="10%">Kode TP</th>
                <th width="42%">Tujuan Pembelajaran (TP)</th>
                <th width="12%">Alokasi Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $idx => $d)
                <tr>
                    <td align="center">{{ $idx + 1 }}</td>
                    <td align="center">
                        <strong>Semester {{ $d['semester'] ?? ( ($idx < count($items)/2) ? 1 : 2 ) }}</strong>
                        <div style="font-size: 7.5pt; color: #64748b;">
                            ({{ ($d['semester'] ?? 1) == 1 ? 'Ganjil' : 'Genap' }})
                        </div>
                    </td>
                    <td>{{ $d['elemen'] ?? ($prota->mataPelajaran->nama ?? 'Kompetensi Kejuruan') }}</td>
                    <td align="center"><strong>{{ $d['kode_tp'] ?? '-' }}</strong></td>
                    <td>{{ $d['tujuan_pembelajaran'] ?? '-' }}</td>
                    <td align="center"><strong>{{ $d['alokasi_jp'] ?? 12 }} JP</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Belum ada rincian alokasi tujuan pembelajaran pada Program Tahunan ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" align="right"><strong>TOTAL ALOKASI WAKTU PROGRAM TAHUNAN (PROTA):</strong></td>
                <td align="center"><strong>{{ $totalJp }} JP</strong></td>
            </tr>
        </tfoot>
    </table>

    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $prota->user->satuanPendidikan, 'guru' => $prota->user])

</body>
</html>
