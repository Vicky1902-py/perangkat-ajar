<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $paketSoal->judul }} - Dokumen Lengkap Pegangan Guru</title>
    <style>
        @page {
            margin: 12mm 12mm 15mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #111827;
            line-height: 1.35;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }

        .doc-title {
            text-align: center;
            font-size: 11pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #0b3b60;
            margin-bottom: 2px;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 8.5pt;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .section-header {
            background-color: #0b3b60;
            color: #ffffff;
            font-weight: 800;
            font-size: 8.5pt;
            padding: 4px 8px;
            margin: 14px 0 8px 0;
            text-transform: uppercase;
            page-break-after: avoid;
            border-radius: 2px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 8pt;
        }
        .meta-table td {
            padding: 2.5px 4px;
            vertical-align: top;
            border: 1px solid #e5e7eb;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8pt;
        }
        .content-table th {
            background-color: #e8f4fc;
            color: #0b3b60;
            border: 1px solid #bce0fd;
            padding: 5px 4px;
            font-weight: bold;
            text-align: center;
        }
        .content-table td {
            border: 1px solid #d1d5db;
            padding: 4px;
            vertical-align: top;
        }

        .item-box {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 6px 8px;
            margin-bottom: 8px;
            page-break-inside: avoid;
            border-radius: 4px;
        }
        .key-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            font-weight: bold;
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 7.5pt;
        }
        .level-badge {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-size: 7pt;
            padding: 1px 5px;
            border-radius: 3px;
        }

        .footer {
            position: fixed;
            bottom: -8mm;
            left: 0;
            right: 0;
            height: 12mm;
            border-top: 1px solid #e5e7eb;
            font-size: 7.5pt;
            color: #6b7280;
            line-height: 1.2;
            padding-top: 2px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    @include('exports.pdf.partials.kop-surat', ['model' => $paketSoal])

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">{{ $paketSoal->judul }}</div>
    <div class="doc-subtitle">DOKUMEN LENGKAP PEGANGAN GURU (KISI-KISI, BUTIR SOAL, KUNCI JAWABAN & RUBRIK PENILAIAN)</div>

    <!-- METADATA ASESMEN -->
    <table class="meta-table">
        <tr>
            <td style="width: 20%; font-weight: bold; background: #f8fafc;">Satuan Pendidikan</td>
            <td style="width: 30%;">{{ $paketSoal->user->satuanPendidikan->nama ?? 'SMK Negeri 1 Kupang Barat' }}</td>
            <td style="width: 20%; font-weight: bold; background: #f8fafc;">Bentuk Soal</td>
            <td style="width: 30%;">{{ $paketSoal->bentuk_soal_label }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #f8fafc;">Mata Pelajaran</td>
            <td>{{ $paketSoal->mataPelajaran->nama ?? '-' }}</td>
            <td style="font-weight: bold; background: #f8fafc;">Total Butir Soal</td>
            <td>PG: {{ $paketSoal->total_soal_pg }} Butir | Isian: {{ $paketSoal->total_soal_isian }} Butir</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #f8fafc;">Fase / Kelas</td>
            <td>Fase {{ $paketSoal->fase->kode ?? '-' }} (Kelas {{ $paketSoal->fase->kelas_range ?? 'X/XI/XII' }})</td>
            <td style="font-weight: bold; background: #f8fafc;">Alokasi Waktu</td>
            <td>{{ $paketSoal->alokasi_waktu_menit }} Menit</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #f8fafc;">Guru Penyusun</td>
            <td>{{ $paketSoal->user->name ?? 'Guru Mata Pelajaran' }}</td>
            <td style="font-weight: bold; background: #f8fafc;">Tahun Ajaran</td>
            <td>{{ $paketSoal->tahunAjaran->nama ?? '2026/2027' }}</td>
        </tr>
    </table>

    <!-- ================= 1. TABEL KISI-KISI SOAL RESMI KEMENDIKDASMEN ================= -->
    <div class="section-header">1. TABEL KISI-KISI SOAL (TEST BLUEPRINT) RESMI KEMENDIKDASMEN</div>

    @if(!empty($paketSoal->kisi_kisi_data) && count($paketSoal->kisi_kisi_data) > 0)
        <table class="content-table">
            <thead>
                <tr>
                    <th style="width: 22px;">No</th>
                    <th style="width: 75px;">Elemen</th>
                    <th style="width: 130px;">Tujuan Pembelajaran (TP)</th>
                    <th style="width: 90px;">Materi / Topik</th>
                    <th>Indikator Butir Soal</th>
                    <th style="width: 75px;">Level Kognitif</th>
                    <th style="width: 45px;">Bentuk</th>
                    <th style="width: 30px;">No. Soal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paketSoal->kisi_kisi_data as $idx => $k)
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td><strong>{{ $k['elemen'] ?? '-' }}</strong></td>
                        <td style="font-size: 7.5pt;">{{ $k['tp'] ?? '-' }}</td>
                        <td>{{ $k['materi'] ?? '-' }}</td>
                        <td style="font-size: 7.5pt;">{{ $k['indikator'] ?? '-' }}</td>
                        <td style="text-align: center; font-size: 7.5pt;"><span class="level-badge">{{ $k['level_kognitif'] ?? '-' }}</span></td>
                        <td style="text-align: center; font-size: 7pt;">{{ $k['bentuk_soal'] === 'Pilihan Ganda' ? 'PG' : 'Isian' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $k['nomor_soal'] ?? ($idx + 1) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Data kisi-kisi tidak ditemukan.</p>
    @endif

    <!-- ================= 2. BUTIR SOAL, KUNCI JAWABAN & PEMBAHASAN PG ================= -->
    @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
        <div class="section-header" style="page-break-before: always;">2. BUTIR SOAL PILIHAN GANDA BESERTA KUNCI & PEMBAHASAN</div>

        @foreach($paketSoal->butir_soal_pg as $pg)
            <div class="item-box">
                <div style="margin-bottom: 3px;">
                    <strong>{{ $pg['nomor'] }}. {{ $pg['pertanyaan'] }}</strong>
                    <span class="level-badge" style="float: right;">{{ $pg['level_kognitif'] ?? 'HOTS' }}</span>
                </div>
                @if(!empty($pg['stimulus']))
                    <div style="font-style: italic; color: #4b5563; background: #f8fafc; padding: 3px 6px; margin-bottom: 4px; font-size: 8pt; border-left: 2px solid #0284c7;">
                        <strong>Konteks/Kasus:</strong> {{ $pg['stimulus'] }}
                    </div>
                @endif
                @php
                    $kunci = $pg['kunci_jawaban'] ?? $pg['kunci'] ?? '';
                @endphp
                <table style="width: 100%; border: none; margin: 3px 0 5px 10px;">
                    @foreach($pg['pilihan'] as $opt => $text)
                        <tr>
                            <td style="width: 18px; font-weight: bold; border: none; padding: 1px 0;">
                                @if($opt === $kunci)
                                    <span class="key-badge">{{ $opt }}.</span>
                                @else
                                    {{ $opt }}.
                                @endif
                            </td>
                            <td style="border: none; padding: 1px 0; {{ $opt === $kunci ? 'font-weight: bold; color: #15803d;' : '' }}">
                                {{ $text }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 4px 6px; font-size: 7.8pt; border-radius: 3px; color: #166534;">
                    <strong>Kunci Jawaban: [ {{ $kunci }} ]</strong> &bull; 
                    <strong>Pembahasan Analitis:</strong> {{ $pg['pembahasan'] ?? '-' }}
                </div>
            </div>
        @endforeach
    @endif

    <!-- ================= 3. BUTIR SOAL ISIAN / URAIAN & RUBRIK PENSKORAN ================= -->
    @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
        <div class="section-header" style="page-break-before: always;">3. BUTIR SOAL ISIAN / URAIAN & RUBRIK PEDOMAN PENSKORAN</div>

        @foreach($paketSoal->butir_soal_isian as $es)
            <div class="item-box">
                <div style="margin-bottom: 3px;">
                    <strong>{{ $es['nomor'] }}. {{ $es['pertanyaan'] }}</strong>
                    <span class="level-badge" style="float: right;">{{ $es['level_kognitif'] ?? 'HOTS' }}</span>
                </div>
                @if(!empty($es['stimulus']))
                    <div style="font-style: italic; color: #4b5563; background: #f8fafc; padding: 3px 6px; margin-bottom: 4px; font-size: 8pt; border-left: 2px solid #0284c7;">
                        <strong>Konteks Masalah:</strong> {{ $es['stimulus'] }}
                    </div>
                @endif
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 4px 6px; font-size: 8pt; border-radius: 3px; margin-bottom: 4px; color: #1e40af;">
                    <strong>Kata Kunci Jawaban:</strong><br>
                    {{ $es['kata_kunci'] ?? '-' }}
                </div>
                <div style="background: #fefce8; border: 1px solid #fef08a; padding: 4px 6px; font-size: 7.8pt; border-radius: 3px; color: #854d0e;">
                    <strong>Pedoman Penskoran (Rubrik Analitik):</strong><br>
                    {!! nl2br(e($es['pedoman_penskoran'] ?? '-')) !!}
                </div>
            </div>
        @endforeach
    @endif

    <!-- FORM TANDA TANGAN RESMI -->
    @php
        $sekolah = $paketSoal->user?->satuanPendidikan;
        $kota = $sekolah?->kota ?: 'Kupang Barat';
        $tanggal = \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y');
    @endphp
    <div style="page-break-inside: avoid; margin-top: 15px;">
        <table style="width: 100%; border: none; font-size: 8.5pt;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: top; border: none; padding-left: 15px;">
                    Mengetahui,<br>
                    <strong>Kepala {{ $sekolah?->nama ?: 'SMK Negeri 1 Kupang Barat' }}</strong>
                    <br><br><br><br>
                    <strong style="text-decoration: underline;">{{ $sekolah?->kepala_sekolah ?: 'Drs. H. Suryadi, M.Pd.' }}</strong><br>
                    <span>NIP. {{ $sekolah?->nip_kepala_sekolah ?: '196805121994031005' }}</span>
                </td>
                <td style="width: 50%; text-align: right; vertical-align: top; border: none; padding-right: 15px;">
                    {{ $kota }}, {{ $tanggal }}<br>
                    <strong>Guru Mata Pelajaran</strong>
                    <br><br><br><br>
                    <strong style="text-decoration: underline;">{{ $paketSoal->user->name ?? 'Guru Pengampu' }}</strong><br>
                    <span>NIP. {{ $paketSoal->user?->nip ?: '-' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- RUNNING FOOTER -->
    <div class="footer">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 70%; text-align: left; border: none;">
                    Smart Soal &bull; Dokumen Pegangan Guru &bull; Kurikulum Merdeka 2026 &bull; Hak Cipta Desain by. Vicky Koroh
                </td>
                <td style="width: 30%; text-align: right; border: none;">
                    Arsip Kurikulum
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
