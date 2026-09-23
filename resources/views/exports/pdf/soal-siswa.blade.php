<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $paketSoal->judul }} - Lembar Soal Siswa</title>
    <style>
        @page {
            margin: 12mm 12mm 15mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #111827;
            line-height: 1.4;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }

        .exam-title {
            text-align: center;
            font-size: 11pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #0b3b60;
            margin-bottom: 2px;
        }
        .exam-subtitle {
            text-align: center;
            font-size: 8.5pt;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .meta-box {
            width: 100%;
            border: 1px solid #111827;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8.5pt;
        }
        .meta-box td {
            padding: 3px 6px;
            vertical-align: middle;
            border: 1px solid #d1d5db;
        }

        .section-header {
            background-color: #f3f4f6;
            border-top: 1.5px solid #111827;
            border-bottom: 1.5px solid #111827;
            font-weight: 800;
            font-size: 9pt;
            padding: 4px 6px;
            margin: 12px 0 8px 0;
            text-transform: uppercase;
            page-break-after: avoid;
        }

        .petunjuk-box {
            border: 1px dashed #9ca3af;
            background-color: #f9fafb;
            padding: 5px 8px;
            font-size: 8pt;
            margin-bottom: 10px;
            line-height: 1.35;
        }

        .question-item {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .question-text {
            font-weight: 600;
            margin-bottom: 3px;
        }
        .stimulus-box {
            font-style: italic;
            color: #374151;
            background-color: #f8fafc;
            border-left: 2.5px solid #0284c7;
            padding: 4px 8px;
            margin-bottom: 4px;
            font-size: 8.5pt;
        }

        .options-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
            margin-left: 12px;
        }
        .options-table td {
            padding: 1px 0;
            vertical-align: top;
            font-size: 8.5pt;
        }

        .essay-answer-space {
            border: 1px dashed #d1d5db;
            background: #fafafa;
            border-radius: 4px;
            height: 60px;
            margin-top: 4px;
            padding: 4px;
            color: #9ca3af;
            font-size: 7.5pt;
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

    <!-- JUDUL UJIAN -->
    <div class="exam-title">{{ $paketSoal->judul }}</div>
    <div class="exam-subtitle">Tahun Ajaran {{ $paketSoal->tahunAjaran->nama ?? '2026/2027' }} &bull; Kurikulum Merdeka (Pendekatan Deep Learning)</div>

    <!-- TABEL IDENTITAS SISWA & MATA PELAJARAN -->
    <table class="meta-box">
        <tr>
            <td style="width: 18%; font-weight: bold; background: #f9fafb;">Mata Pelajaran</td>
            <td style="width: 32%;">: {{ $paketSoal->mataPelajaran->nama ?? '-' }}</td>
            <td style="width: 18%; font-weight: bold; background: #f9fafb;">Nama Peserta</td>
            <td style="width: 32%;">: ____________________________________</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #f9fafb;">Fase / Kelas</td>
            <td>: Fase {{ $paketSoal->fase->kode ?? '-' }} (Kelas {{ $paketSoal->fase->kelas_range ?? 'X/XI/XII' }})</td>
            <td style="font-weight: bold; background: #f9fafb;">Kelas / No. Absen</td>
            <td>: ______________ / No: _________</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background: #f9fafb;">Alokasi Waktu</td>
            <td>: {{ $paketSoal->alokasi_waktu_menit }} Menit</td>
            <td style="font-weight: bold; background: #f9fafb;">Hari / Tanggal</td>
            <td>: ____________________________________</td>
        </tr>
    </table>

    <!-- PETUNJUK UMUM -->
    @if($paketSoal->petunjuk_umum)
        <div class="petunjuk-box">
            <strong>PETUNJUK UMUM PENGERJAAN:</strong><br>
            {!! nl2br(e($paketSoal->petunjuk_umum)) !!}
        </div>
    @endif

    <!-- BAGIAN I: PILIHAN GANDA -->
    @if(!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0)
        <div class="section-header">
            BAGIAN I: SOAL PILIHAN GANDA (Pilihlah salah satu jawaban A, B, C, D, atau E yang paling benar)
        </div>

        @foreach($paketSoal->butir_soal_pg as $pg)
            <div class="question-item">
                <div class="question-text">
                    {{ $pg['nomor'] }}. {{ $pg['pertanyaan'] }}
                </div>
                @if(!empty($pg['stimulus']))
                    <div class="stimulus-box">
                        <strong>Konteks/Kasus:</strong> {{ $pg['stimulus'] }}
                    </div>
                @endif
                <table class="options-table">
                    @foreach($pg['pilihan'] as $opt => $text)
                        <tr>
                            <td style="width: 20px; font-weight: bold;">{{ $opt }}.</td>
                            <td>{{ $text }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    @endif

    <!-- BAGIAN II: ISIAN / URAIAN -->
    @if(!empty($paketSoal->butir_soal_isian) && count($paketSoal->butir_soal_isian) > 0)
        <div class="section-header" style="{{ (!empty($paketSoal->butir_soal_pg) && count($paketSoal->butir_soal_pg) > 0) ? 'page-break-before: auto;' : '' }}">
            BAGIAN II: SOAL ISIAN / URAIAN (Jawablah pertanyaan berikut dengan sistematis dan mengacu pada standar SOP)
        </div>

        @foreach($paketSoal->butir_soal_isian as $es)
            <div class="question-item">
                <div class="question-text">
                    {{ $es['nomor'] }}. {{ $es['pertanyaan'] }}
                    <span style="font-weight: normal; font-size: 7.5pt; color: #6b7280;">(Skor Maks: {{ $es['skor_maksimal'] ?? 10 }})</span>
                </div>
                @if(!empty($es['stimulus']))
                    <div class="stimulus-box">
                        <strong>Konteks Masalah:</strong> {{ $es['stimulus'] }}
                    </div>
                @endif
                <div class="essay-answer-space">
                    Ruang Jawaban Peserta Didik:
                </div>
            </div>
        @endforeach
    @endif

    <!-- RUNNING FOOTER -->
    <div class="footer">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 70%; text-align: left; border: none;">
                    Smart Soal &bull; Kurikulum Merdeka 2026 &bull; Hak Cipta Desain by. Vicky Koroh
                </td>
                <td style="width: 30%; text-align: right; border: none;">
                    Naskah Ujian Siswa
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
