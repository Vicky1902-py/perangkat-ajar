<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Services\NvidiaAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PakarAiController extends Controller
{
    /**
     * Tampilkan halaman utama Konsultasi Sistem Pakar Kurikulum AI (NVIDIA NIM).
     */
    public function index(Request $request, NvidiaAiService $aiService)
    {
        $mapels = MataPelajaran::where('is_active', true)->orderBy('nama')->get();
        $fases = Fase::orderBy('kode')->get();
        $aiStatus = $aiService->testConnection();

        return view('pakar-ai.index', compact('mapels', 'fases', 'aiStatus'));
    }

    /**
     * Proses konsultasi dengan Sistem Pakar AI Kurikulum (NVIDIA NIM).
     */
    public function consult(Request $request, NvidiaAiService $aiService): JsonResponse
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id'           => 'required|exists:fases,id',
            'pertanyaan'        => 'required|string|min:5|max:1000',
            'tipe_konsultasi'   => 'nullable|string',
        ]);

        $mapel = MataPelajaran::findOrFail($request->mata_pelajaran_id);
        $fase = Fase::findOrFail($request->fase_id);

        // Ambil Capaian Pembelajaran resmi dari database (Single Source of Truth)
        $cp = CapaianPembelajaran::where('mata_pelajaran_id', $mapel->id)
            ->where('fase_id', $fase->id)
            ->first();

        $elemenList = [];
        $deskripsiCp = $cp ? $cp->deskripsi_cp : 'Capaian pembelajaran sesuai Keputusan BSKAP No. 046/H/KR/2025.';

        if ($cp && !empty($cp->elemen_cp)) {
            $decoded = json_decode($cp->elemen_cp, true);
            if (is_array($decoded)) {
                foreach ($decoded as $elm => $desk) {
                    $elemenList[] = "• {$elm}: {$desk}";
                }
            }
        }

        $elemenText = !empty($elemenList) ? implode("\n", $elemenList) : '• Elemen kompetensi kejuruan dan umum terpadu.';

        // Bangun konteks ketat kurikulum nasional
        $context = <<<CTX
MATA PELAJARAN: {$mapel->nama} (Kelompok: {$mapel->kelompok})
FASE: {$fase->kode} (Kelas: {$fase->tingkat_kelas})
REGULASI RESMI: Keputusan Kepala BSKAP No. 046/H/KR/2025 & Permendikdasmen No. 13 Tahun 2025
CAPAIAN PEMBELAJARAN (CP):
{$deskripsiCp}

ELEMEN-ELEMEN CP RESMI:
{$elemenText}

KERANGKA PEDAGOGIS:
- Pendekatan Pembelajaran Mendalam (Deep Learning): Mindful Learning (Sadar & Hadir Penuh), Meaningful Learning (Bermakna & Relevan), Joyful Learning (Menyenangkan & Menggembirakan).
- Sintaks Alur Belajar PEDATTI: Pelajari (Orientasi), Dalami (Eksplorasi Konsep), Terapkan (Praktik/Aplikasi), Tularkan (Kolaborasi/Presentasi), Inovasi (Evaluasi & Refleksi).
- 8 Dimensi Profil Lulusan (Permendikdasmen No. 10/2025): Keimanan & Ketaqwaan, Kewarganegaraan & Kebangsaan, Penalaran Kritis, Kreativitas, Kolaborasi & Gotong Royong, Kemandirian, Kesehatan & Kebugaran, Komunikasi.
- TERMINOLOGI WAJIB: Seluruh rujukan kepada pembelajar WAJIB menggunakan istilah "murid" (dilarang menggunakan kata "peserta didik").
CTX;

        $userPrompt = <<<PROMPT
PERTANYAAN GURU:
"{$request->pertanyaan}"

TIPE KONSULTASI: {$request->input('tipe_konsultasi', 'Konsultasi Kurikulum Umum')}

INSTRUKSI SISTEM PAKAR:
Berikan jawaban konsultasi yang komprehensif, terstruktur, praktis, dan langsung dapat dieksekusi di kelas oleh guru.
Struktur jawaban:
1. Analisis Keterkaitan CP & Elemen: Jelaskan bagaimana topik ini terhubung dengan capaian resmi di atas.
2. Rekomendasi Langkah Pedagogis (Deep Learning 3M & Sintaks PEDATTI): Berikan contoh langkah aktivitas nyata untuk murid.
3. Panduan Diferensiasi & Asesmen: Saran asesmen awal, formatif, atau umpan balik bagi murid.
4. Tips Penerapan Praktis di Kelas: 2-3 kiat praktis bagi guru.

Gunakan bahasa formal, hangat, memotivasi, dan berwibawa khas pengawas/pakar kurikulum nasional.
PROMPT;

        try {
            // Eksekusi via AI Service dengan batas token optimal agar respons cepat
            $answer = $aiService->generate($userPrompt, $context, 650, 0.45);
        } catch (\Throwable $e) {
            $answer = null;
        }

        if (!$answer) {
            // Fallback cerdas jika AI lambat/offline
            $answer = "Sistem Pakar Kurikulum mengonfirmasi bahwa materi pembelajaran {$mapel->nama} Fase {$fase->kode} mengacu pada regulasi resmi BSKAP No. 046/H/KR/2025.\n\n" .
                      "Rekomendasi Utama:\n" .
                      "1. Selaraskan tujuan pembelajaran dengan elemen: " . (explode(':', $elemenList[0] ?? $mapel->nama)[0]) . ".\n" .
                      "2. Gunakan tahapan PEDATTI (Pelajari, Dalami, Terapkan, Tularkan, Inovasi) secara runut.\n" .
                      "3. Bangun suasana belajar yang Mindful, Meaningful, dan Joyful agar seluruh murid termotivasi aktif.\n" .
                      "4. Lakukan asesmen formatif berkelanjutan untuk memastikan pemahaman bermakna tercapai.";
        }

        // Sanitasi ketat
        $answer = str_ireplace('peserta didik', 'murid', $answer);

        return response()->json([
            'success' => true,
            'mapel'   => $mapel->nama,
            'fase'    => $fase->kode,
            'answer'  => $answer,
            'model'   => 'Vx Agent',
        ]);
    }
}
