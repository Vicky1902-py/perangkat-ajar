<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Alur Tujuan Pembelajaran - {{ $atp->mataPelajaran->nama ?? 'Mapel' }}</title>
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
            font-size: 8pt;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
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
    </style>
</head>
<body>
    @include('exports.pdf.partials.footer-running')

    @include('exports.pdf.partials.kop-surat', ['sekolah' => $atp->user->satuanPendidikan])

    <div class="header-title">ALUR TUJUAN PEMBELAJARAN (ATP)</div>
    <div class="header-subtitle">Berdasarkan Keputusan Kepala BSKAP No. 046/H/KR/2025 (Merevisi No. 032/H/KR/2024) &bull; Permendikdasmen No. 13/2025 &bull; Deep Learning</div>

    <table class="meta-table">
        <tr>
            <td width="18%"><strong>Satuan Pendidikan</strong></td>
            <td width="3%">:</td>
            <td width="35%">{{ $atp->user->satuanPendidikan->nama ?? 'SMK Pusat Keunggulan' }}</td>
            <td width="15%"><strong>Fase / Kelas</strong></td>
            <td width="3%">:</td>
            <td width="26%">Fase {{ $atp->fase->kode ?? '-' }} (Kelas {{ $atp->fase->kelas_range ?? '-' }})</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $atp->mataPelajaran->nama ?? '-' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td>{{ $atp->tahunAjaran->nama ?? '2025/2026' }} (Semester {{ $atp->tahunAjaran->semester ?? '1' }})</td>
        </tr>
        <tr>
            <td><strong>Regulasi CP</strong></td>
            <td>:</td>
            <td>{{ $atp->regulasi ?? 'Keputusan Kepala BSKAP No. 046/H/KR/2025' }}</td>
            <td><strong>Total Alokasi</strong></td>
            <td>:</td>
            <td><strong>{{ $atp->total_alokasi_jp ?: $atp->atpDetails->sum('alokasi_waktu_jp') }} JP</strong></td>
        </tr>
        <tr>
            <td><strong>Program Keahlian</strong></td>
            <td>:</td>
            <td>{{ $atp->mataPelajaran->programKeahlian->nama ?? 'Semua Program Keahlian' }}</td>
            <td><strong>Penyusun</strong></td>
            <td>:</td>
            <td>{{ $atp->user->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="7%">Kode TP</th>
                <th width="12%">Elemen CP</th>
                <th width="22%">Tujuan Pembelajaran (TP) & IKTP</th>
                <th width="14%">Materi / Topik</th>
                <th width="14%">Dimensi Profil Lulusan</th>
                <th width="14%">Kegiatan Belajar (PEDATTI)</th>
                <th width="10%">Asesmen</th>
                <th width="4%">Alokasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($atp->atpDetails as $idx => $d)
                <tr>
                    <td align="center">{{ $idx + 1 }}</td>
                    <td align="center"><strong>{{ $d->tujuanPembelajaran->kode_tp ?? '-' }}</strong></td>
                    <td>{{ $d->tujuanPembelajaran->elemen ?? 'Kompetensi Kejuruan' }}</td>
                    <td>
                        <div><strong>{{ $d->tujuanPembelajaran->deskripsi_tp ?? '-' }}</strong></div>
                        @if($d->tujuanPembelajaran && $d->tujuanPembelajaran->indikator_ketercapaian)
                            <div style="font-size: 7.5pt; color: #475569; margin-top: 4px;">
                                <em>IKTP:</em><br>{!! nl2br(e($d->tujuanPembelajaran->indikator_ketercapaian)) !!}
                            </div>
                        @endif
                    </td>
                    <td>
                        {{ $d->materi_topik ?? '-' }}
                        @if($d->sumber_belajar)
                            <div style="font-size: 7pt; color: #64748b; margin-top: 3px;">Sumber: {{ Str::limit($d->sumber_belajar, 50) }}</div>
                        @endif
                    </td>
                    <td>{{ $d->dimensi_profil_lulusan ?? '-' }}</td>
                    <td>{{ $d->kegiatan_pembelajaran ?? '-' }}</td>
                    <td>{{ $d->asesmen ?? '-' }}</td>
                    <td align="center"><strong>{{ $d->alokasi_waktu_jp ?? 12 }} JP</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" align="center">Belum ada detail tujuan pembelajaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('exports.pdf.partials.tanda-tangan', ['sekolah' => $atp->user->satuanPendidikan, 'guru' => $atp->user])

</body>
</html>
