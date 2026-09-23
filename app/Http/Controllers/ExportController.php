<?php

namespace App\Http\Controllers;

use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\Lkpd;
use App\Models\ModulAjar;
use App\Models\PaketSoal;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class ExportController extends Controller
{
    /**
     * Memeriksa otorisasi ekspor:
     * - Superadmin bisa mengekspor semua dokumen.
     * - Guru bisa mengekspor miliknya, atau yang diberi izin, atau yang is_shared.
     * - Tamu bisa mengekspor jika dokumen milik sesi tamu miliknya atau belum terikat user (user_id null).
     */
    private function authorizeExport($model): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->canAccessDeviceOf($model->user_id, $model->guest_session_id) && !$model->is_shared) {
                abort(403, 'Anda tidak memiliki hak akses untuk mengunduh dokumen ini.');
            }
        } else {
            $sessionId = session()->getId();
            if ($model->user_id !== null && $model->guest_session_id !== $sessionId && !$model->is_shared) {
                abort(403, 'Silakan masuk terlebih dahulu untuk mengunduh dokumen ini.');
            }
        }
    }

    /**
     * Menjamin $model->user dan $model->user->satuanPendidikan selalu terisi (fallback)
     * sehingga ekspor tamu / user tanpa profil lengkap tidak mengalami error null pointer.
     */
    private function ensureUserAndSchool($model): void
    {
        $this->authorizeExport($model);

        if (!$model->user) {
            $sekolah = \App\Models\SatuanPendidikan::first() ?? new \App\Models\SatuanPendidikan([
                'nama' => 'SMK Negeri 1 Kupang Barat',
                'dinas_pendidikan' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                'kop_baris_1' => 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR',
                'kop_baris_2' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                'kop_baris_3' => 'SMK NEGERI 1 KUPANG BARAT',
                'kop_baris_4' => 'Jl. Jurusan Bolok, Desa Oematnunu, Kec. Kupang Barat | NPSN: 69947814',
                'kota' => 'Kupang Barat',
                'kepala_sekolah' => 'Drs. H. Suryadi, M.Pd.',
                'nip_kepala_sekolah' => '196805121994031005',
            ]);
            $guestUser = new \App\Models\User([
                'name' => 'Guru Pengampu (Mode Tamu)',
                'nip' => '-',
                'role' => 'guru',
            ]);
            $guestUser->setRelation('satuanPendidikan', $sekolah);
            $model->setRelation('user', $guestUser);
        } elseif (!$model->user->satuanPendidikan) {
            $sekolah = \App\Models\SatuanPendidikan::first() ?? new \App\Models\SatuanPendidikan([
                'nama' => 'SMK Negeri 1 Kupang Barat',
                'dinas_pendidikan' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                'kop_baris_1' => 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR',
                'kop_baris_2' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                'kop_baris_3' => 'SMK NEGERI 1 KUPANG BARAT',
                'kop_baris_4' => 'Jl. Jurusan Bolok, Desa Oematnunu, Kec. Kupang Barat | NPSN: 69947814',
                'kota' => 'Kupang Barat',
                'kepala_sekolah' => 'Drs. H. Suryadi, M.Pd.',
                'nip_kepala_sekolah' => '196805121994031005',
            ]);
            $model->user->setRelation('satuanPendidikan', $sekolah);
        }
    }

    // ================= EXPORT ATP =================
    public function exportAtpPdf(Request $request, AlurTujuanPembelajaran $atp)
    {
        $atp->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'atpDetails.tujuanPembelajaran']);
        $this->ensureUserAndSchool($atp);
        $paper = $this->resolvePaperSize($request, $atp->user?->satuanPendidikan);
        
        $pdf = Pdf::loadView('exports.pdf.atp', compact('atp'));
        $pdf->setPaper($paper['size'], 'landscape');

        $filename = 'ATP_' . str_replace(' ', '_', $atp->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($atp->fase->kode ?? 'E') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportAtpExcel(AlurTujuanPembelajaran $atp)
    {
        $atp->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'atpDetails.tujuanPembelajaran']);
        $this->ensureUserAndSchool($atp);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title & Header
        $sheet->setCellValue('A1', 'ALUR TUJUAN PEMBELAJARAN (ATP) - KURIKULUM MERDEKA');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Satuan Pendidikan: ' . ($atp->user->satuanPendidikan->nama ?? 'SMK'));
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . ($atp->mataPelajaran->nama ?? '-'));
        $sheet->setCellValue('E3', 'Fase / Kelas: Fase ' . ($atp->fase->kode ?? '-') . ' (' . ($atp->fase->kelas_range ?? '-') . ')');
        $sheet->setCellValue('A4', 'Tahun Ajaran: ' . ($atp->tahunAjaran->nama ?? '2025/2026'));
        $sheet->setCellValue('E4', 'Penyusun: ' . ($atp->user->name ?? '-'));

        // Table Header
        $row = 6;
        $headers = ['No', 'Kode TP', 'Tujuan Pembelajaran (TP)', 'Materi / Topik', 'Dimensi Profil Lulusan (8 Dimensi)', 'Kegiatan Belajar (Alur PEDATTI)', 'Asesmen', 'Alokasi (JP)'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        foreach ($headers as $i => $h) {
            $sheet->setCellValue($cols[$i] . $row, $h);
            $sheet->getStyle($cols[$i] . $row)->getFont()->setBold(true);
            $sheet->getStyle($cols[$i] . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE2E8F0');
        }

        // Table Rows
        $row = 7;
        foreach ($atp->atpDetails as $idx => $d) {
            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->setCellValue('B' . $row, $d->tujuanPembelajaran->kode_tp ?? '-');
            $sheet->setCellValue('C' . $row, $d->tujuanPembelajaran->deskripsi_tp ?? '-');
            $sheet->setCellValue('D' . $row, $d->materi_topik ?? '-');
            $sheet->setCellValue('E' . $row, $d->dimensi_profil_lulusan ?? '-');
            $sheet->setCellValue('F' . $row, $d->kegiatan_pembelajaran ?? '-');
            $sheet->setCellValue('G' . $row, $d->asesmen ?? '-');
            $sheet->setCellValue('H' . $row, $d->alokasi_waktu_jp ?? 12);
            $row++;
        }

        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'ATP_' . str_replace(' ', '_', $atp->mataPelajaran->nama ?? 'Mapel') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportAtpDocx(AlurTujuanPembelajaran $atp)
    {
        $atp->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'atpDetails.tujuanPembelajaran']);
        $this->ensureUserAndSchool($atp);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection(['orientation' => 'landscape']);

        // Kop Surat Kedinasan Resmi (4 Baris)
        $this->addDocxKopSurat($section, $atp->user->satuanPendidikan, 'landscape');

        // Title
        $section->addTitle('ALUR TUJUAN PEMBELAJARAN (ATP)', 1);
        $section->addText('Berdasarkan Keputusan Kepala BSKAP No. 046/H/KR/2025 (Merevisi No. 032/H/KR/2024) - Permendikdasmen No. 13/2025', ['italic' => true]);
        $section->addTextBreak(1);

        // Identitas
        $section->addText('Satuan Pendidikan : ' . ($atp->user->satuanPendidikan->nama ?? 'SMK'));
        $section->addText('Mata Pelajaran    : ' . ($atp->mataPelajaran->nama ?? '-'));
        $section->addText('Fase / Kelas      : Fase ' . ($atp->fase->kode ?? '-') . ' (' . ($atp->fase->kelas_range ?? '-') . ')');
        $section->addText('Guru Pengampu     : ' . ($atp->user->name ?? '-'));
        $section->addTextBreak(1);

        // Table
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '999999', 'afterSpacing' => 100]);
        $table->addRow();
        $table->addCell(800)->addText('No', ['bold' => true]);
        $table->addCell(1500)->addText('Kode TP', ['bold' => true]);
        $table->addCell(3500)->addText('Tujuan Pembelajaran', ['bold' => true]);
        $table->addCell(2500)->addText('Materi / Topik', ['bold' => true]);
        $table->addCell(2500)->addText('Dimensi Profil Lulusan', ['bold' => true]);
        $table->addCell(3000)->addText('Kegiatan PEDATTI', ['bold' => true]);
        $table->addCell(1000)->addText('JP', ['bold' => true]);

        foreach ($atp->atpDetails as $idx => $d) {
            $table->addRow();
            $table->addCell(800)->addText($idx + 1);
            $table->addCell(1500)->addText($d->tujuanPembelajaran->kode_tp ?? '-');
            $table->addCell(3500)->addText($d->tujuanPembelajaran->deskripsi_tp ?? '-');
            $table->addCell(2500)->addText($d->materi_topik ?? '-');
            $table->addCell(2500)->addText($d->dimensi_profil_lulusan ?? '-');
            $table->addCell(3000)->addText($d->kegiatan_pembelajaran ?? '-');
            $table->addCell(1000)->addText($d->alokasi_waktu_jp ?? '12');
        }

        // Form Tanda Tangan Resmi (Kepsek Kiri, Guru Kanan)
        $this->addDocxSignatureTable($section, $atp->user->satuanPendidikan, $atp->user, 'landscape');

        // Hak Cipta Running Footer Resmi
        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $filename = 'ATP_' . str_replace(' ', '_', $atp->mataPelajaran->nama ?? 'Mapel') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    // ================= EXPORT MODUL AJAR =================
    public function exportModulAjarPdf(Request $request, ModulAjar $modulAjar)
    {
        $modulAjar->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'tujuanPembelajaran', 'kegiatans', 'profilLulusans']);
        $this->ensureUserAndSchool($modulAjar);
        $paper = $this->resolvePaperSize($request, $modulAjar->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.modul-ajar', compact('modulAjar'));
        $pdf->setPaper($paper['size'], 'portrait');

        $filename = 'Modul_Ajar_' . str_replace(' ', '_', $modulAjar->mataPelajaran->nama ?? 'Mapel') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportModulAjarDocx(ModulAjar $modulAjar)
    {
        $modulAjar->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'tujuanPembelajaran', 'kegiatans', 'profilLulusans']);
        $this->ensureUserAndSchool($modulAjar);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Kop Surat Kedinasan Resmi (4 Baris)
        $this->addDocxKopSurat($section, $modulAjar->user->satuanPendidikan, 'portrait');

        $section->addTitle($modulAjar->judul, 1);
        $section->addText('Kurikulum Merdeka SMK - Pendekatan Deep Learning', ['italic' => true]);
        $section->addTextBreak(1);

        // A. Informasi Umum
        $section->addTitle('A. INFORMASI UMUM', 2);
        $section->addText('Nama Penyusun      : ' . ($modulAjar->user->name ?? '-'));
        $section->addText('Satuan Pendidikan  : ' . ($modulAjar->user->satuanPendidikan->nama ?? 'SMK'));
        $section->addText('Mata Pelajaran     : ' . ($modulAjar->mataPelajaran->nama ?? '-'));
        $section->addText('Fase / Kelas       : Fase ' . ($modulAjar->fase->kode ?? '-') . ' (' . ($modulAjar->fase->kelas_range ?? '-') . ')');
        $section->addText('Alokasi Waktu      : ' . ($modulAjar->alokasi_waktu_jp ?? 12) . ' JP (' . ($modulAjar->jumlah_pertemuan ?? 3) . ' Pertemuan)');
        $section->addText('Kompetensi Awal    : ' . ($modulAjar->kompetensi_awal ?? '-'));
        $section->addText('Profil Lulusan     : ' . ($modulAjar->profil_lulusan_target ?? '-'));
        $section->addText('Sarana & Prasarana : ' . ($modulAjar->sarana_prasarana ?? '-'));
        $section->addTextBreak(1);

        // B. Komponen Inti
        $section->addTitle('B. KOMPONEN INTI', 2);
        $section->addText('Tujuan Pembelajaran : ' . ($modulAjar->tujuanPembelajaran->deskripsi_tp ?? '-'));
        $section->addText('Pemahaman Bermakna  : ' . ($modulAjar->pemahaman_bermakna ?? '-'));
        $section->addText('Pertanyaan Pemantik : ' . ($modulAjar->pertanyaan_pemantik ?? '-'));
        $section->addTextBreak(1);

        // Kegiatan PEDATTI
        $section->addTitle('C. LANGKAH-LANGKAH PEMBELAJARAN (ALUR PEDATTI)', 2);
        foreach ($modulAjar->kegiatans as $keg) {
            $section->addText(strtoupper($keg->tahap_pedatti) . ' (' . $keg->durasi_menit . ' Menit) - ' . $keg->prinsip_deep_learning, ['bold' => true]);
            $section->addText($keg->deskripsi_kegiatan);
            $section->addTextBreak(1);
        }

        // Asesmen & Refleksi
        $section->addTitle('D. ASESMEN & REFLEKSI', 2);
        $section->addText('Asesmen Awal (Diagnostik) : ' . ($modulAjar->asesmen_awal ?? '-'));
        $section->addText('Asesmen Formatif (Proses) : ' . ($modulAjar->asesmen_formatif ?? '-'));
        $section->addText('Asesmen Sumatif (Akhir)   : ' . ($modulAjar->asesmen_sumatif ?? '-'));
        $section->addText('Refleksi Guru             : ' . ($modulAjar->refleksi_guru ?? '-'));
        $section->addText('Refleksi Siswa            : ' . ($modulAjar->refleksi_siswa ?? '-'));

        // Form Tanda Tangan Resmi (Kepsek Kiri, Guru Kanan)
        $this->addDocxSignatureTable($section, $modulAjar->user->satuanPendidikan, $modulAjar->user, 'portrait');

        // Hak Cipta Running Footer Resmi
        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $filename = 'Modul_Ajar_' . str_replace(' ', '_', $modulAjar->mataPelajaran->nama ?? 'Mapel') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    // ================= EXPORT LKPD =================
    public function exportLkpdPdf(Request $request, Lkpd $lkpd)
    {
        $lkpd->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'kegiatans']);
        $this->ensureUserAndSchool($lkpd);
        $paper = $this->resolvePaperSize($request, $lkpd->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.lkpd', compact('lkpd'));
        $pdf->setPaper($paper['size'], 'portrait');

        $filename = 'LKPD_' . str_replace(' ', '_', $lkpd->mataPelajaran->nama ?? 'Mapel') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportLkpdDocx(Lkpd $lkpd)
    {
        $lkpd->load(['mataPelajaran', 'fase', 'user.satuanPendidikan', 'modulAjar', 'kegiatans']);
        $this->ensureUserAndSchool($lkpd);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Kop Surat Kedinasan Resmi (4 Baris)
        $this->addDocxKopSurat($section, $lkpd->user->satuanPendidikan, 'portrait');

        $section->addTitle($lkpd->judul, 1);
        $section->addText('LEMBAR KERJA PESERTA DIDIK (LKPD) PEMBELAJARAN MENDALAM', ['bold' => true]);
        $section->addTextBreak(1);

        $section->addText('Satuan Pendidikan : ' . ($lkpd->user->satuanPendidikan->nama ?? 'SMK'));
        $section->addText('Mata Pelajaran    : ' . ($lkpd->mataPelajaran->nama ?? '-'));
        $section->addText('Fase / Kelas      : Fase ' . ($lkpd->fase->kode ?? '-') . ' (' . ($lkpd->fase->kelas_range ?? '-') . ')');
        $section->addText('Alokasi Waktu     : ' . ($lkpd->alokasi_waktu_menit ?? 90) . ' Menit');
        $section->addText('Nama Kelompok     : __________________________________________________');
        $section->addText('Anggota Kelompok  : 1. _______________ 2. _______________ 3. _______________ 4. _______________');
        $section->addTextBreak(1);

        $section->addText('Tujuan Pembelajaran: ' . $lkpd->tujuan_pembelajaran, ['bold' => true]);
        $section->addTextBreak(1);

        $section->addText('STIMULUS OTENTIK (STUDI KASUS INDUSTRI):', ['bold' => true]);
        $section->addText($lkpd->stimulus_otentik);
        $section->addTextBreak(1);

        $section->addText('PETUNJUK BELAJAR:', ['bold' => true]);
        $section->addText($lkpd->petunjuk_belajar);
        $section->addTextBreak(1);

        foreach ($lkpd->kegiatans as $keg) {
            $section->addText('TAHAP ' . strtoupper($keg->tahap) . ':', ['bold' => true, 'underline' => 'single']);
            $section->addText('Instruksi : ' . $keg->instruksi);
            $section->addText('Pertanyaan: ' . $keg->pertanyaan);
            $section->addText('Ruang Jawaban:');
            $section->addText('[ ' . $keg->ruang_jawaban . ' ]');
            $section->addTextBreak(1);
        }

        // Form Tanda Tangan Resmi (Kepsek Kiri, Guru Kanan)
        $this->addDocxSignatureTable($section, $lkpd->user->satuanPendidikan, $lkpd->user, 'portrait');

        // Hak Cipta Running Footer Resmi
        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $filename = 'LKPD_' . str_replace(' ', '_', $lkpd->mataPelajaran->nama ?? 'Mapel') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    // ================= EXPORT ASESMEN =================
    public function exportAsesmenPdf(Request $request, Asesmen $asesmen)
    {
        $asesmen->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'tujuanPembelajaran']);
        $this->ensureUserAndSchool($asesmen);
        $paper = $this->resolvePaperSize($request, $asesmen->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.asesmen', compact('asesmen'));
        $pdf->setPaper($paper['size'], 'portrait');

        $filename = 'Asesmen_' . str_replace(' ', '_', $asesmen->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($asesmen->fase->kode ?? 'E') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportAsesmenDocx(Asesmen $asesmen)
    {
        $asesmen->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'tujuanPembelajaran']);
        $this->ensureUserAndSchool($asesmen);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Kop Surat Kedinasan Resmi (4 Baris)
        $this->addDocxKopSurat($section, $asesmen->user->satuanPendidikan, 'portrait');

        $section->addTitle($asesmen->judul, 1);
        $section->addText('INSTRUMEN ASESMEN PEMBELAJARAN MENDALAM (DEEP LEARNING)', ['bold' => true]);
        $section->addText('Panduan Pembelajaran dan Asesmen (PPA) Kemendikdasmen Edisi Revisi 2025/2026', ['italic' => true]);
        $section->addTextBreak(1);

        $section->addText('Satuan Pendidikan : ' . ($asesmen->user->satuanPendidikan->nama ?? 'SMK'));
        $section->addText('Mata Pelajaran    : ' . ($asesmen->mataPelajaran->nama ?? '-'));
        $section->addText('Program Keahlian  : ' . ($asesmen->mataPelajaran?->programKeahlian?->nama ?? 'Umum/Pilihan'));
        $section->addText('Fase / Kelas      : Fase ' . ($asesmen->fase->kode ?? '-') . ' (' . ($asesmen->fase->kelas_range ?? '-') . ')');
        $section->addText('Penyusun          : ' . ($asesmen->user->name ?? 'Guru Pengampu'));
        $section->addTextBreak(1);

        $section->addText('1. ASESMEN DIAGNOSTIK (AWAL PEMBELAJARAN):', ['bold' => true, 'underline' => 'single']);
        $section->addText('Tujuan: Pemetaan kesiapan belajar dan profil murid untuk diferensiasi pembelajaran (TIDAK DIBOBOT untuk nilai rapor).');
        $section->addText('- Non-Kognitif: Kesiapan psikologis, minat kejuruan, dan profil gaya belajar.');
        $section->addText('- Kognitif: Tes pertanyaan pemantik konsep prasyarat.');
        $section->addTextBreak(1);

        $section->addText('2. ASESMEN FORMATIF (PROSES PEMBELAJARAN):', ['bold' => true, 'underline' => 'single']);
        $section->addText('Tujuan: Pemantauan kemajuan belajar, refleksi metakognisi, dan umpan balik (constructive feedback).');
        $section->addText('- Lembar Observasi Keterlibatan Partisipasi & Budaya Kerja 5R.');
        $section->addText('- Lembar Refleksi Diri (Self-Assessment) dan Antarteman.');
        $section->addText('- Umpan Balik Kualitatif Guru.');
        $section->addTextBreak(1);

        $section->addText('3. ASESMEN SUMATIF & UNJUK KERJA VOKASI SMK (STANDAR DUDI):', ['bold' => true, 'underline' => 'single']);
        $section->addText('Standar Acuan: ' . ($asesmen->vokasi_dudi_data['standar_acuan'] ?? 'SKKNI & SOP Industri Mitra'));
        $section->addText('Kategori Kelulusan Vokasi: [ K ] Kompeten  /  [ BK ] Belum Kompeten');
        $section->addTextBreak(1);

        $section->addText('4. RUBRIK KKTP & INTERVAL NILAI RESMI KEMENDIKDASMEN:', ['bold' => true, 'underline' => 'single']);
        $section->addText('- Level 4 (86-100%): Sangat Baik / Mahir -> Pengayaan materi / proyek DUDI lanjutan.');
        $section->addText('- Level 3 (71-85%): Baik / Layak [STANDAR TUNTAS] -> Tuntas materi.');
        $section->addText('- Level 2 (61-70%): Cukup -> Remedial parsial pada indikator belum tuntas.');
        $section->addText('- Level 1 (0-60%): Perlu Bimbingan -> Remedial menyeluruh.');
        $section->addTextBreak(1);

        $section->addText('5. DESKRIPSI RAPOR SISWA (KURIKULUM MERDEKA):', ['bold' => true, 'underline' => 'single']);
        $section->addText('Capaian Tertinggi: ' . ($asesmen->deskripsi_rapor['capaian_tertinggi'] ?? '-'));
        $section->addText('Perlu Ditingkatkan: ' . ($asesmen->deskripsi_rapor['perlu_ditingkatkan'] ?? '-'));

        // Form Tanda Tangan Resmi (Kepsek Kiri, Guru Kanan)
        $this->addDocxSignatureTable($section, $asesmen->user->satuanPendidikan, $asesmen->user, 'portrait');

        // Hak Cipta Running Footer Resmi
        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $filename = 'Asesmen_' . str_replace(' ', '_', $asesmen->mataPelajaran->nama ?? 'Mapel') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    // ================= EXPORT PROGRAM TAHUNAN (PROTA) =================
    public function exportProtaPdf(Request $request, ProgramTahunan $prota)
    {
        $prota->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($prota);
        $paper = $this->resolvePaperSize($request, $prota->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.prota', compact('prota'));
        $pdf->setPaper($paper['size'], 'landscape');

        $filename = 'PROTA_' . str_replace(' ', '_', $prota->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($prota->fase->kode ?? 'E') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportProtaExcel(ProgramTahunan $prota)
    {
        $prota->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($prota);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title & Header
        $sheet->setCellValue('A1', 'PROGRAM TAHUNAN (PROTA) - KURIKULUM MERDEKA');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Satuan Pendidikan: ' . ($prota->user->satuanPendidikan->nama ?? 'SMK'));
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . ($prota->mataPelajaran->nama ?? '-'));
        $sheet->setCellValue('D3', 'Fase / Kelas: Fase ' . ($prota->fase->kode ?? '-') . ' (' . ($prota->fase->kelas_range ?? '-') . ')');
        $sheet->setCellValue('A4', 'Tahun Ajaran: ' . ($prota->tahunAjaran->nama ?? '2026/2027'));
        $sheet->setCellValue('D4', 'Penyusun: ' . ($prota->user->name ?? '-'));

        // Table Header
        $row = 6;
        $headers = ['No', 'Semester', 'Elemen CP / Materi Pokok', 'Kode TP', 'Tujuan Pembelajaran (TP)', 'Alokasi (JP)'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F'];

        foreach ($headers as $i => $h) {
            $sheet->setCellValue($cols[$i] . $row, $h);
            $sheet->getStyle($cols[$i] . $row)->getFont()->setBold(true);
            $sheet->getStyle($cols[$i] . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE2E8F0');
            $sheet->getStyle($cols[$i] . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Table Rows
        $row = 7;
        $items = $prota->data_json ?? [];
        $totalJp = 0;
        foreach ($items as $idx => $d) {
            $semNum = $d['semester'] ?? (($idx < count($items)/2) ? 1 : 2);
            $jpVal = (int)($d['alokasi_jp'] ?? 12);
            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->setCellValue('B' . $row, 'Semester ' . $semNum . ' (' . ($semNum == 1 ? 'Ganjil' : 'Genap') . ')');
            $sheet->setCellValue('C' . $row, $d['elemen'] ?? ($prota->mataPelajaran->nama ?? 'Kompetensi'));
            $sheet->setCellValue('D' . $row, $d['kode_tp'] ?? '-');
            $sheet->setCellValue('E' . $row, $d['tujuan_pembelajaran'] ?? '-');
            $sheet->setCellValue('F' . $row, $jpVal);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $totalJp += $jpVal;
            $row++;
        }

        // Total Row
        $sheet->setCellValue('A' . $row, 'TOTAL ALOKASI JAM PELAJARAN (PROTA):');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('F' . $row, $totalJp);
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);
        $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Auto sizing
        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'PROTA_' . str_replace(' ', '_', $prota->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($prota->fase->kode ?? 'E') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportProtaDocx(ProgramTahunan $prota)
    {
        $prota->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($prota);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginTop' => 700,
            'marginBottom' => 700,
            'marginLeft' => 800,
            'marginRight' => 800,
        ]);

        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $this->addDocxKopSurat($section, $prota->user->satuanPendidikan, 'landscape');

        $section->addText('PROGRAM TAHUNAN (PROTA)', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
        $section->addText('Kurikulum Merdeka (Pendekatan Deep Learning) • Permendikdasmen No. 13/2025', ['size' => 9, 'color' => '555555'], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        $metaTable = $section->addTable();
        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Satuan Pendidikan', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($prota->user->satuanPendidikan->nama ?? 'SMK'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Fase / Kelas', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': Fase ' . ($prota->fase->kode ?? '-') . ' (' . ($prota->fase->kelas_range ?? '-') . ')', ['size' => 9]);

        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Mata Pelajaran', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($prota->mataPelajaran->nama ?? '-'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Tahun Ajaran', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': ' . ($prota->tahunAjaran->nama ?? '2026/2027'), ['size' => 9]);

        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Penyusun', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($prota->user->name ?? '-'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Regulasi CP', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': BSKAP No. 046/H/KR/2025', ['size' => 9]);

        $section->addTextBreak(1);

        $table = $section->addTable(['borderSize' => 6, 'borderColor' => 'CBD5E1', 'cellMargin' => 60]);
        $table->addRow();
        $table->addCell(600, ['bgColor' => 'F1F5F9'])->addText('No', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::CENTER]);
        $table->addCell(1600, ['bgColor' => 'F1F5F9'])->addText('Semester', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::CENTER]);
        $table->addCell(3000, ['bgColor' => 'F1F5F9'])->addText('Elemen CP / Materi Pokok', ['bold' => true, 'size' => 8.5]);
        $table->addCell(1400, ['bgColor' => 'F1F5F9'])->addText('Kode TP', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::CENTER]);
        $table->addCell(6200, ['bgColor' => 'F1F5F9'])->addText('Tujuan Pembelajaran (TP)', ['bold' => true, 'size' => 8.5]);
        $table->addCell(1200, ['bgColor' => 'F1F5F9'])->addText('Alokasi', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::CENTER]);

        $items = $prota->data_json ?? [];
        $totalJp = 0;
        foreach ($items as $idx => $d) {
            $semNum = $d['semester'] ?? (($idx < count($items)/2) ? 1 : 2);
            $jpVal = (int)($d['alokasi_jp'] ?? 12);
            $table->addRow();
            $table->addCell(600)->addText((string)($idx + 1), ['size' => 8], ['alignment' => Jc::CENTER]);
            $table->addCell(1600)->addText('Sem. ' . $semNum, ['size' => 8], ['alignment' => Jc::CENTER]);
            $table->addCell(3000)->addText($d['elemen'] ?? ($prota->mataPelajaran->nama ?? 'Kompetensi'), ['size' => 8]);
            $table->addCell(1400)->addText($d['kode_tp'] ?? '-', ['bold' => true, 'size' => 8], ['alignment' => Jc::CENTER]);
            $table->addCell(6200)->addText($d['tujuan_pembelajaran'] ?? '-', ['size' => 8]);
            $table->addCell(1200)->addText($jpVal . ' JP', ['size' => 8], ['alignment' => Jc::CENTER]);
            $totalJp += $jpVal;
        }

        $table->addRow();
        $table->addCell(12800, ['gridSpan' => 5, 'bgColor' => 'F8FAFC'])->addText('TOTAL ALOKASI JAM PELAJARAN (PROTA):', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::RIGHT]);
        $table->addCell(1200, ['bgColor' => 'F8FAFC'])->addText($totalJp . ' JP', ['bold' => true, 'size' => 8.5], ['alignment' => Jc::CENTER]);

        $this->addDocxSignatureTable($section, $prota->user->satuanPendidikan, $prota->user, 'landscape');

        $filename = 'PROTA_' . str_replace(' ', '_', $prota->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($prota->fase->kode ?? 'E') . '.docx';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    // ================= EXPORT PROGRAM SEMESTER (PROMES) =================
    public function exportPromesPdf(Request $request, ProgramSemester $promes)
    {
        $promes->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($promes);
        $paper = $this->resolvePaperSize($request, $promes->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.promes', compact('promes'));
        $pdf->setPaper($paper['size'], 'landscape');

        $filename = 'PROMES_' . ($promes->semester == 2 ? 'Genap' : 'Ganjil') . '_' . str_replace(' ', '_', $promes->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($promes->fase->kode ?? 'E') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportPromesExcel(ProgramSemester $promes)
    {
        $promes->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($promes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sem = $promes->semester ?? 1;
        $bulanList = ($sem == 2)
            ? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            : ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Title
        $sheet->setCellValue('A1', 'PROGRAM SEMESTER (PROMES) ' . ($sem == 2 ? 'GENAP' : 'GANJIL') . ' - KURIKULUM MERDEKA');
        $sheet->mergeCells('A1:AI1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Satuan Pendidikan: ' . ($promes->user->satuanPendidikan->nama ?? 'SMK'));
        $sheet->setCellValue('A3', 'Mata Pelajaran: ' . ($promes->mataPelajaran->nama ?? '-'));
        $sheet->setCellValue('D3', 'Fase / Kelas: Fase ' . ($promes->fase->kode ?? '-') . ' (' . ($promes->fase->kelas_range ?? '-') . ')');
        $sheet->setCellValue('A4', 'Tahun Ajaran: ' . ($promes->tahunAjaran->nama ?? '2026/2027') . ' (Semester ' . $sem . ')');
        $sheet->setCellValue('D4', 'Penyusun: ' . ($promes->user->name ?? '-'));

        // Table Header
        $row = 6;
        $sheet->setCellValue('A' . $row, 'No');
        $sheet->mergeCells('A' . $row . ':A' . ($row + 1));
        $sheet->setCellValue('B' . $row, 'Kode TP');
        $sheet->mergeCells('B' . $row . ':B' . ($row + 1));
        $sheet->setCellValue('C' . $row, 'Tujuan Pembelajaran & Materi Pokok');
        $sheet->mergeCells('C' . $row . ':C' . ($row + 1));
        $sheet->setCellValue('D' . $row, 'JP');
        $sheet->mergeCells('D' . $row . ':D' . ($row + 1));

        $colIdx = 5; // Column E
        foreach ($bulanList as $b) {
            $colLetterStart = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
            $colLetterEnd = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 4);
            $sheet->setCellValue($colLetterStart . $row, $b);
            $sheet->mergeCells($colLetterStart . $row . ':' . $colLetterEnd . $row);

            for ($m = 1; $m <= 5; $m++) {
                $subCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + $m - 1);
                $sheet->setCellValue($subCol . ($row + 1), $m);
            }
            $colIdx += 5;
        }

        $ketCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
        $sheet->setCellValue($ketCol . $row, 'Ket');
        $sheet->mergeCells($ketCol . $row . ':' . $ketCol . ($row + 1));

        $sheet->getStyle('A' . $row . ':' . $ketCol . ($row + 1))->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':' . $ketCol . ($row + 1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2E8F0');
        $sheet->getStyle('A' . $row . ':' . $ketCol . ($row + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $row . ':' . $ketCol . ($row + 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Body rows
        $items = $promes->data_json ?? [];
        $totalJp = 0;
        $row = 8;
        foreach ($items as $idx => $d) {
            $targetBulan = $d['bulan'] ?? $bulanList[$idx % count($bulanList)];
            $targetMinggu = (int)($d['minggu_ke'] ?? (($idx % 4) + 1));
            $jpVal = (int)($d['alokasi_jp'] ?? 12);
            $totalJp += $jpVal;

            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->setCellValue('B' . $row, $d['kode_tp'] ?? '-');
            $sheet->setCellValue('C' . $row, ($d['elemen'] ? $d['elemen'] . ': ' : '') . ($d['tujuan_pembelajaran'] ?? '-'));
            $sheet->setCellValue('D' . $row, $jpVal);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $cIdx = 5;
            foreach ($bulanList as $b) {
                for ($m = 1; $m <= 5; $m++) {
                    $currCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cIdx);
                    if (strtolower(trim($b)) === strtolower(trim($targetBulan)) && $m === $targetMinggu) {
                        $sheet->setCellValue($currCol . $row, $jpVal);
                        $sheet->getStyle($currCol . $row)->getFont()->setBold(true);
                        $sheet->getStyle($currCol . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    }
                    $cIdx++;
                }
            }
            $sheet->setCellValue($ketCol . $row, 'Efektif');
            $sheet->getStyle($ketCol . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // Total Row
        $sheet->setCellValue('A' . $row, 'TOTAL ALOKASI JP SEMESTER:');
        $sheet->mergeCells('A' . $row . ':C' . $row);
        $sheet->setCellValue('D' . $row, $totalJp);
        $sheet->getStyle('A' . $row . ':' . $ketCol . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(8);
        for ($i = 5; $i < $colIdx; $i++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i))->setWidth(4);
        }
        $sheet->getColumnDimension($ketCol)->setWidth(10);

        $writer = new Xlsx($spreadsheet);
        $filename = 'PROMES_' . ($sem == 2 ? 'Genap' : 'Ganjil') . '_' . str_replace(' ', '_', $promes->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($promes->fase->kode ?? 'E') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportPromesDocx(ProgramSemester $promes)
    {
        $promes->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($promes);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginTop' => 700,
            'marginBottom' => 700,
            'marginLeft' => 700,
            'marginRight' => 700,
        ]);

        $footer = $section->addFooter();
        $footer->addText('Hak Cipta : Desain by. Vicky Koroh', ['size' => 8, 'color' => '666666', 'italic' => true], ['alignment' => Jc::LEFT]);

        $this->addDocxKopSurat($section, $promes->user->satuanPendidikan, 'landscape');

        $sem = $promes->semester ?? 1;
        $bulanList = ($sem == 2)
            ? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            : ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $section->addText('PROGRAM SEMESTER (PROMES) ' . ($sem == 2 ? 'GENAP' : 'GANJIL'), ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER]);
        $section->addText('Kurikulum Merdeka (Pendekatan Deep Learning) • Permendikdasmen No. 13/2025', ['size' => 9, 'color' => '555555'], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        $metaTable = $section->addTable();
        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Satuan Pendidikan', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($promes->user->satuanPendidikan->nama ?? 'SMK'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Fase / Kelas', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': Fase ' . ($promes->fase->kode ?? '-') . ' (' . ($promes->fase->kelas_range ?? '-') . ')', ['size' => 9]);

        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Mata Pelajaran', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($promes->mataPelajaran->nama ?? '-'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Semester / Tahun', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': ' . ($sem == 2 ? 'Genap' : 'Ganjil') . ' (' . ($promes->tahunAjaran->nama ?? '2026/2027') . ')', ['size' => 9]);

        $metaTable->addRow();
        $metaTable->addCell(2500)->addText('Penyusun', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(5000)->addText(': ' . ($promes->user->name ?? '-'), ['size' => 9]);
        $metaTable->addCell(2500)->addText('Regulasi CP', ['bold' => true, 'size' => 9]);
        $metaTable->addCell(4000)->addText(': BSKAP No. 046/H/KR/2025', ['size' => 9]);

        $section->addTextBreak(1);

        $table = $section->addTable(['borderSize' => 6, 'borderColor' => 'CBD5E1', 'cellMargin' => 50]);
        $table->addRow();
        $table->addCell(500, ['bgColor' => 'F1F5F9', 'vMerge' => 'restart'])->addText('No', ['bold' => true, 'size' => 7.5], ['alignment' => Jc::CENTER]);
        $table->addCell(1200, ['bgColor' => 'F1F5F9', 'vMerge' => 'restart'])->addText('Kode TP', ['bold' => true, 'size' => 7.5], ['alignment' => Jc::CENTER]);
        $table->addCell(4000, ['bgColor' => 'F1F5F9', 'vMerge' => 'restart'])->addText('Tujuan Pembelajaran', ['bold' => true, 'size' => 7.5]);
        $table->addCell(700, ['bgColor' => 'F1F5F9', 'vMerge' => 'restart'])->addText('JP', ['bold' => true, 'size' => 7.5], ['alignment' => Jc::CENTER]);
        foreach ($bulanList as $b) {
            $table->addCell(1300, ['bgColor' => 'F1F5F9', 'gridSpan' => 5])->addText(substr($b, 0, 4), ['bold' => true, 'size' => 7], ['alignment' => Jc::CENTER]);
        }
        $table->addCell(700, ['bgColor' => 'F1F5F9', 'vMerge' => 'restart'])->addText('Ket', ['bold' => true, 'size' => 7], ['alignment' => Jc::CENTER]);

        $table->addRow();
        $table->addCell(500, ['vMerge' => 'continue']);
        $table->addCell(1200, ['vMerge' => 'continue']);
        $table->addCell(4000, ['vMerge' => 'continue']);
        $table->addCell(700, ['vMerge' => 'continue']);
        foreach ($bulanList as $b) {
            for ($m = 1; $m <= 5; $m++) {
                $table->addCell(260, ['bgColor' => 'F8FAFC'])->addText((string)$m, ['size' => 6.5], ['alignment' => Jc::CENTER]);
            }
        }
        $table->addCell(700, ['vMerge' => 'continue']);

        $items = $promes->data_json ?? [];
        $totalJp = 0;
        foreach ($items as $idx => $d) {
            $targetBulan = $d['bulan'] ?? $bulanList[$idx % count($bulanList)];
            $targetMinggu = (int)($d['minggu_ke'] ?? (($idx % 4) + 1));
            $jpVal = (int)($d['alokasi_jp'] ?? 12);
            $totalJp += $jpVal;

            $table->addRow();
            $table->addCell(500)->addText((string)($idx + 1), ['size' => 7], ['alignment' => Jc::CENTER]);
            $table->addCell(1200)->addText($d['kode_tp'] ?? '-', ['bold' => true, 'size' => 7], ['alignment' => Jc::CENTER]);
            $table->addCell(4000)->addText(($d['elemen'] ? $d['elemen'] . ': ' : '') . ($d['tujuan_pembelajaran'] ?? '-'), ['size' => 7]);
            $table->addCell(700)->addText((string)$jpVal, ['bold' => true, 'size' => 7], ['alignment' => Jc::CENTER]);

            foreach ($bulanList as $b) {
                for ($m = 1; $m <= 5; $m++) {
                    if (strtolower(trim($b)) === strtolower(trim($targetBulan)) && $m === $targetMinggu) {
                        $table->addCell(260, ['bgColor' => 'E0F2FE'])->addText((string)$jpVal, ['bold' => true, 'size' => 6.5, 'color' => '0369A1'], ['alignment' => Jc::CENTER]);
                    } else {
                        $table->addCell(260)->addText('-', ['size' => 6.5, 'color' => 'CCCCCC'], ['alignment' => Jc::CENTER]);
                    }
                }
            }
            $table->addCell(700)->addText('Efektif', ['size' => 6.5], ['alignment' => Jc::CENTER]);
        }

        $table->addRow();
        $table->addCell(5700, ['gridSpan' => 3, 'bgColor' => 'F8FAFC'])->addText('TOTAL ALOKASI JP SEMESTER:', ['bold' => true, 'size' => 7.5], ['alignment' => Jc::RIGHT]);
        $table->addCell(700, ['bgColor' => 'F8FAFC'])->addText((string)$totalJp, ['bold' => true, 'size' => 7.5], ['alignment' => Jc::CENTER]);
        $table->addCell(8500, ['gridSpan' => 31, 'bgColor' => 'F8FAFC'])->addText('Terjadwal pada minggu efektif semester ' . ($sem == 2 ? 'genap' : 'ganjil'), ['italic' => true, 'size' => 7]);

        $this->addDocxSignatureTable($section, $promes->user->satuanPendidikan, $promes->user, 'landscape');

        $filename = 'PROMES_' . ($sem == 2 ? 'Genap' : 'Ganjil') . '_' . str_replace(' ', '_', $promes->mataPelajaran->nama ?? 'Mapel') . '_Fase_' . ($promes->fase->kode ?? 'E') . '.docx';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    /**
     * Resolusi ukuran kertas PDF (A4 vs F4 / Folio)
     * Standar Folio / F4 di Indonesia = 215mm x 330mm (8.5 x 13 in) => [0, 0, 612.00, 936.00] pt
     */
    private function resolvePaperSize(Request $request, ?\App\Models\SatuanPendidikan $sekolah = null): array
    {
        $paperParam = strtolower($request->query('paper', ''));
        if (!in_array($paperParam, ['a4', 'f4', 'folio'])) {
            $paperParam = strtolower($sekolah->ukuran_kertas_default ?? 'a4');
        }

        if (in_array($paperParam, ['f4', 'folio'])) {
            return [
                'size' => [0, 0, 612.00, 936.00],
                'label' => 'F4',
            ];
        }

        return [
            'size' => 'a4',
            'label' => 'A4',
        ];
    }

    /**
     * Helper privat untuk mencetak Kop Surat resmi 4 Baris pada dokumen Word (DOCX).
     * Baris 1: Pemda
     * Baris 2: Dinas Pendidikan
     * Baris 3: Satuan Pendidikan
     * Baris 4: Kontak & Alamat
     */
    private function addDocxKopSurat($section, $sekolah, $orientation = 'portrait')
    {
        $sekolah = $sekolah ?? new \App\Models\SatuanPendidikan();

        $baris1 = $sekolah->kop_baris_1 ?: 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR';
        if (!empty($sekolah->kop_baris_4)) {
            $baris2 = $sekolah->kop_baris_2 ?: 'DINAS PENDIDIKAN DAN KEBUDAYAAN';
            $baris3 = $sekolah->kop_baris_3 ?: strtoupper($sekolah->nama ?? 'SMKN 1 KUPANG BARAT');
            $baris4 = $sekolah->kop_baris_4;
        } else {
            $baris2 = $sekolah->dinas_pendidikan ?: 'DINAS PENDIDIKAN DAN KEBUDAYAAN';
            $baris3 = $sekolah->kop_baris_2 ?: strtoupper($sekolah->nama ?? 'SMKN 1 KUPANG BARAT');
            $baris4 = $sekolah->kop_baris_3 ?: trim(($sekolah->alamat ?? 'Jl. Budi Utomo No. 7, Jakarta Pusat') . ' | Telp: ' . ($sekolah->telepon ?? '-') . ' | NPSN: ' . ($sekolah->npsn ?? '-'), ' |');
        }

        $section->addText(strtoupper($baris1), ['bold' => true, 'size' => 9.5], ['alignment' => Jc::CENTER, 'spaceAfter' => 15]);
        $section->addText(strtoupper($baris2), ['bold' => true, 'size' => 10.5], ['alignment' => Jc::CENTER, 'spaceAfter' => 15]);
        $section->addText(strtoupper($baris3), ['bold' => true, 'size' => 13], ['alignment' => Jc::CENTER, 'spaceAfter' => 15]);
        $section->addText($baris4, ['size' => 8, 'color' => '444444'], ['alignment' => Jc::CENTER, 'spaceAfter' => 50]);

        $dividerWidth = ($orientation === 'landscape') ? 15000 : 9500;
        $divTable = $section->addTable(['borderBottomSize' => 18, 'borderBottomColor' => '000000', 'afterSpacing' => 180]);
        $divTable->addRow();
        $divTable->addCell($dividerWidth);
        $section->addTextBreak(1);
    }

    /**
     * Helper privat untuk mencetak form tanda tangan resmi pada dokumen Word (DOCX):
     * KIRI: Kepala Sekolah | KANAN: Guru Mata Pelajaran.
     */
    private function addDocxSignatureTable($section, $sekolah, $guru, $orientation = 'portrait')
    {
        $sekolah = $sekolah ?? new \App\Models\SatuanPendidikan();
        $kota = $sekolah->kota ?: 'Jakarta';
        $tanggalStr = \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y');
        $kepsekNama = $sekolah->kepala_sekolah ?: 'Drs. H. Suryadi, M.Pd.';
        $kepsekNip = $sekolah->nip_kepala_sekolah ?: '196805121994031005';
        $guruNama = $guru->name ?? 'Guru Pengampu';
        $guruNip = $guru->nip ?: '-';

        $cellWidth = ($orientation === 'landscape') ? 7000 : 4500;

        $section->addTextBreak(1);
        $table = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF', 'afterSpacing' => 100]);
        $table->addRow();

        // SEBELAH KIRI: KEPALA SEKOLAH
        $cellLeft = $table->addCell($cellWidth);
        $cellLeft->addText('Mengetahui,', ['size' => 10]);
        $cellLeft->addText('Kepala ' . ($sekolah->nama ?: 'Sekolah'), ['bold' => true, 'size' => 10]);
        $cellLeft->addTextBreak(3);
        $cellLeft->addText($kepsekNama, ['bold' => true, 'underline' => 'single', 'size' => 10]);
        $cellLeft->addText('NIP. ' . $kepsekNip, ['size' => 9]);

        // SEBELAH KANAN: GURU MATA PELAJARAN
        $cellRight = $table->addCell($cellWidth);
        $cellRight->addText($kota . ', ' . $tanggalStr, ['size' => 10]);
        $cellRight->addText('Guru Mata Pelajaran,', ['bold' => true, 'size' => 10]);
        $cellRight->addTextBreak(3);
        $cellRight->addText($guruNama, ['bold' => true, 'underline' => 'single', 'size' => 10]);
        $cellRight->addText('NIP. ' . $guruNip, ['size' => 9]);
    }

    // ================= EXPORT SOAL & KISI-KISI =================
    public function exportSoalSiswaPdf(Request $request, PaketSoal $paketSoal)
    {
        $paketSoal->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($paketSoal);
        $paper = $this->resolvePaperSize($request, $paketSoal->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.soal-siswa', compact('paketSoal'));
        $pdf->setPaper($paper['size'], 'portrait');

        $filename = 'Naskah_Soal_Siswa_' . str_replace(' ', '_', $paketSoal->mataPelajaran->nama ?? 'Mapel') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportSoalGuruPdf(Request $request, PaketSoal $paketSoal)
    {
        $paketSoal->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'tujuanPembelajaran', 'modulAjar']);
        $this->ensureUserAndSchool($paketSoal);
        $paper = $this->resolvePaperSize($request, $paketSoal->user?->satuanPendidikan);

        $pdf = Pdf::loadView('exports.pdf.soal-guru', compact('paketSoal'));
        $pdf->setPaper($paper['size'], 'portrait');

        $filename = 'Dokumen_Lengkap_Kisi_dan_Soal_Guru_' . str_replace(' ', '_', $paketSoal->mataPelajaran->nama ?? 'Mapel') . '_' . $paper['label'] . '.pdf';
        return $pdf->download($filename);
    }

    public function exportSoalDocx(PaketSoal $paketSoal)
    {
        $paketSoal->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $this->ensureUserAndSchool($paketSoal);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $this->addDocxKopSurat($section, $paketSoal->user->satuanPendidikan, 'portrait');

        $section->addTitle($paketSoal->judul, 1);
        $section->addText('Bentuk: ' . $paketSoal->bentuk_soal_label . ' | Alokasi Waktu: ' . $paketSoal->alokasi_waktu_menit . ' Menit', ['italic' => true]);
        $section->addTextBreak(1);

        $section->addText('Mata Pelajaran : ' . ($paketSoal->mataPelajaran->nama ?? '-'));
        $section->addText('Fase / Kelas   : Fase ' . ($paketSoal->fase->kode ?? '-') . ' (' . ($paketSoal->fase->kelas_range ?? '-') . ')');
        $section->addText('Nama Siswa     : __________________________________________________');
        $section->addText('Kelas / No. Absen: ________________________ / ___________________');
        $section->addTextBreak(1);

        if ($paketSoal->petunjuk_umum) {
            $section->addText('PETUNJUK UMUM:', ['bold' => true]);
            $section->addText($paketSoal->petunjuk_umum);
            $section->addTextBreak(1);
        }

        if (!empty($paketSoal->butir_soal_pg)) {
            $section->addTitle('BAGIAN I: PILIHAN GANDA', 2);
            foreach ($paketSoal->butir_soal_pg as $pg) {
                $section->addText($pg['nomor'] . '. ' . $pg['pertanyaan'], ['bold' => true]);
                if (!empty($pg['stimulus'])) {
                    $section->addText('Konteks: ' . $pg['stimulus'], ['italic' => true]);
                }
                foreach ($pg['pilihan'] as $opt => $text) {
                    $section->addText('    ' . $opt . '. ' . $text);
                }
                $section->addTextBreak(1);
            }
        }

        if (!empty($paketSoal->butir_soal_isian)) {
            $section->addTitle('BAGIAN II: ISIAN / URAIAN', 2);
            foreach ($paketSoal->butir_soal_isian as $es) {
                $section->addText($es['nomor'] . '. ' . $es['pertanyaan'], ['bold' => true]);
                if (!empty($es['stimulus'])) {
                    $section->addText('Konteks: ' . $es['stimulus'], ['italic' => true]);
                }
                $section->addText('Jawaban:');
                $section->addTextBreak(3);
            }
        }

        $this->addDocxSignatureTable($section, $paketSoal->user->satuanPendidikan, $paketSoal->user, 'portrait');

        $filename = 'Naskah_Soal_' . str_replace(' ', '_', $paketSoal->mataPelajaran->nama ?? 'Mapel') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        return response()->streamDownload(function () use ($objWriter) {
            $objWriter->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }
}
