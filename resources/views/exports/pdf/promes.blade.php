<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Program Semester - {{ $promes->mataPelajaran->nama ?? 'Mapel' }}</title>
    <style>
        @page {
            margin: 10mm 10mm 14mm 10mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #1a202c;
            line-height: 1.3;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .header-subtitle {
            text-align: center;
            font-size: 8.5pt;
            color: #4a5568;
            margin-bottom: 12px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 8.5pt;
        }
        .meta-table td {
            padding: 2px 4px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 3px 2px;
            vertical-align: middle;
        }
        .data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: center;
        }
        .data-table tr {
            page-break-inside: avoid;
        }
        .cell-check {
            text-align: center;
            font-weight: bold;
            color: #1e3c72;
            background-color: #f0f7ff;
        }
        .total-row {
            background-color: #f8fafc;
            font-weight: bold;
            font-size: 7.5pt;
        }
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $promes->user->satuanPendidikan])

    @php
        $sem = $promes->semester ?? 1;
        $bulanList = ($sem == 2)
            ? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            : ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $items = $promes->data_json ?? [];
        $totalJp = 0;
        foreach ($items as $it) {
            $totalJp += (int)($it['alokasi_jp'] ?? 12);
        }
    @endphp

    <div class="header-title">PROGRAM SEMESTER (PROMES) {{ $sem == 2 ? 'GENAP' : 'GANJIL' }}</div>
    <div class="header-subtitle">Berdasarkan Permendikdasmen No. 13 Tahun 2025 &bull; Keputusan Kepala BSKAP No. 046/H/KR/2025 &bull; Pendekatan Deep Learning</div>

    <table class="meta-table">
        <tr>
            <td width="18%"><strong>Satuan Pendidikan</strong></td>
            <td width="3%">:</td>
            <td width="35%">{{ $promes->user->satuanPendidikan->nama ?? 'SMK Negeri' }}</td>
            <td width="15%"><strong>Fase / Kelas</strong></td>
            <td width="3%">:</td>
            <td width="26%">Fase {{ $promes->fase->kode ?? '-' }} (Kelas {{ $promes->fase->kelas_range ?? '-' }})</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $promes->mataPelajaran->nama ?? '-' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td>{{ $promes->tahunAjaran->nama ?? '2026/2027' }} (Semester {{ $sem }})</td>
        </tr>
        <tr>
            <td><strong>Program Keahlian</strong></td>
            <td>:</td>
            <td>{{ $promes->mataPelajaran->programKeahlian->nama ?? 'Semua Program Keahlian' }}</td>
            <td><strong>Penyusun / Guru</strong></td>
            <td>:</td>
            <td>{{ $promes->user->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%;">No</th>
                <th rowspan="2" style="width: 7%;">Kode TP</th>
                <th rowspan="2" style="width: 28%;">Tujuan Pembelajaran (TP) & Materi Pokok</th>
                <th rowspan="2" style="width: 5%;">Alokasi (JP)</th>
                @foreach($bulanList as $b)
                    <th colspan="5" style="width: 9%;">{{ $b }}</th>
                @endforeach
                <th rowspan="2" style="width: 3%;">Ket</th>
            </tr>
            <tr>
                @foreach($bulanList as $b)
                    @for($m = 1; $m <= 5; $m++)
                        <th style="width: 1.8%; font-size: 6.5pt;">{{ $m }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($items as $idx => $d)
                @php
                    $targetBulan = $d['bulan'] ?? $bulanList[$idx % count($bulanList)];
                    $targetMinggu = $d['minggu_ke'] ?? (($idx % 4) + 1);
                    $jpVal = $d['alokasi_jp'] ?? 12;
                @endphp
                <tr>
                    <td align="center">{{ $idx + 1 }}</td>
                    <td align="center"><strong>{{ $d['kode_tp'] ?? '-' }}</strong></td>
                    <td>
                        <strong>{{ $d['elemen'] ?? ($promes->mataPelajaran->nama ?? 'Kompetensi') }}:</strong>
                        {{ $d['tujuan_pembelajaran'] ?? '-' }}
                    </td>
                    <td align="center"><strong>{{ $jpVal }}</strong></td>

                    @foreach($bulanList as $b)
                        @for($m = 1; $m <= 5; $m++)
                            @if(strtolower(trim($b)) === strtolower(trim($targetBulan)) && (int)$m === (int)$targetMinggu)
                                <td class="cell-check">{{ $jpVal }}</td>
                            @else
                                <td align="center" style="color: #cbd5e1;">-</td>
                            @endif
                        @endfor
                    @endforeach

                    <td align="center" style="font-size: 6.5pt; color: #64748b;">Efektif</td>
                </tr>
            @empty
                <tr>
                    <td colspan="35" align="center">Belum ada data distribusi alokasi waktu pada Program Semester ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" align="right"><strong>JUMLAH ALOKASI JAM PEMBELAJARAN (JP):</strong></td>
                <td align="center"><strong>{{ $totalJp }}</strong></td>
                <td colspan="31" align="left" style="padding-left: 8px; font-size: 7pt; color: #475569;">
                    <em>Distribusi jam pelajaran terjadwal pada minggu efektif pembelajaran semester {{ $sem == 2 ? 'genap' : 'ganjil' }}.</em>
                </td>
            </tr>
        </tfoot>
    </table>

    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $promes->user->satuanPendidikan, 'guru' => $promes->user])

</body>
</html>
