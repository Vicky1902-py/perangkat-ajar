<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Services\NvidiaAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VxAgentController extends Controller
{
    /**
     * Layanan cerdas Vx Agent untuk melengkapi/memperkaya seksi tertentu pada perangkat ajar
     * secara otomatis tanpa merusak skema atau format regulasi yang sudah ada.
     */
    public function completeField(Request $request, NvidiaAiService $aiService): JsonResponse
    {
        $request->validate([
            'field_type'        => 'required|string', // bahan_ajar, pemahaman_bermakna, pertanyaan_pemantik, kegiatan_pedatti, stimulus_lkpd, rubrik, general
            'instruksi'         => 'required|string|min:3|max:1000',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajarans,id',
            'fase_id'           => 'nullable|exists:fases,id',
            'current_text'      => 'nullable|string',
            'action_mode'       => 'nullable|in:append,replace',
        ]);

        $fieldType = $request->field_type;
        $instruksi = trim($request->instruksi);
        $currentText = trim($request->input('current_text', ''));
        $actionMode = $request->input('action_mode', 'append');

        // Resolusi Mapel & Fase
        $mapelNama = 'Mata Pelajaran Umum/Kejuruan';
        $faseKode = 'E/F';
        $deskripsiCp = 'Sesuai Keputusan Kepala BSKAP Nomor 046/H/KR/2025.';
        $elemenList = [];

        if ($request->filled('mata_pelajaran_id')) {
            $mapel = MataPelajaran::find($request->mata_pelajaran_id);
            if ($mapel) {
                $mapelNama = $mapel->nama;
            }
        }

        if ($request->filled('fase_id')) {
            $fase = Fase::find($request->fase_id);
            if ($fase) {
                $faseKode = $fase->kode;
            }
        }

        if ($request->filled('mata_pelajaran_id') && $request->filled('fase_id')) {
            $cp = CapaianPembelajaran::where('mata_pelajaran_id', $request->mata_pelajaran_id)
                ->where('fase_id', $request->fase_id)
                ->first();

            if ($cp) {
                $deskripsiCp = $cp->deskripsi_cp;
                if (!empty($cp->elemen_cp)) {
                    $decoded = json_decode($cp->elemen_cp, true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $elm => $desk) {
                            $elemenList[] = "{$elm}: {$desk}";
                        }
                    }
                }
            }
        }

        $elemenText = !empty($elemenList) ? implode("\n• ", $elemenList) : 'Elemen kompetensi esensial';

        // Konteks Bounded Anti-Halusinasi
        $context = <<<CTX
MATA PELAJARAN: {$mapelNama}
FASE: {$faseKode}
REGULASI: BSKAP No. 046/H/KR/2025 & Permendikdasmen No. 13/2025
CAPAIAN PEMBELAJARAN (CP):
{$deskripsiCp}

ELEMEN CP:
• {$elemenText}

BAGIAN YANG DILENGKAPI: {$fieldType}
TEKS YANG SUDAH ADA SEBELUMNYA:
"{$currentText}"

ATURAN SISTEM:
1. Gunakan HANYA data dan materi yang relevan dengan mata pelajaran di atas.
2. Dilarang menggunakan kata "peserta didik", WAJIB gunakan kata "murid".
3. Teks harus langsung siap disisipkan ke form dokumen resmi, terstruktur, padat, dan berorientasi Deep Learning (Mindful, Meaningful, Joyful).
CTX;

        // Spesifikasi Prompt Berdasarkan Jenis Bagian (Field Type)
        $guideline = match ($fieldType) {
            'bahan_ajar' => 'Tulis materi/bahan ajar pengayaan yang padat, terstruktur, dan jelas. Gunakan sub-judul dan poin-poin yang mudah dipelajari murid.',
            'pemahaman_bermakna' => 'Tulis 1-2 kalimat pemahaman bermakna yang menghubungkan materi dengan relevansi kehidupan nyata/dunia kerja bagi murid.',
            'pertanyaan_pemantik' => 'Tulis 2-3 butir pertanyaan pemantik berpikir kritis (open-ended) yang memancing rasa ingin tahu murid.',
            'kegiatan_pedatti' => 'Tulis rincian langkah kegiatan pembelajaran yang aktif, terstruktur (aktivitas guru & aktivitas murid), dan mencerminkan prinsip Deep Learning.',
            'stimulus_lkpd' => 'Tulis satu wacana atau studi kasus nyata yang memicu pemecahan masalah kontekstual bagi murid dalam LKPD.',
            'rubrik' => 'Tulis rubrik penilaian dengan kriteria ketercapaian yang terukur (Baru Berkembang, Layak, Cakap, Mahir) skala 0-100.',
            default => 'Lengkapi teks ini dengan narasi akademis yang relevan dan mendalam sesuai arahan guru.',
        };

        $userPrompt = <<<PROMPT
ARAHAN DARI GURU:
"{$instruksi}"

PANDUAN KHUSUS UNTUK BAGIAN {$fieldType}:
{$guideline}

Susun teks pelengkap sekarang secara profesional dan siap pakai!
PROMPT;

        $generated = $aiService->generate($userPrompt, $context, 750, 0.4);

        if (!$generated) {
            // Fallback terstruktur jika koneksi AI offline/timeout
            $generated = match ($fieldType) {
                'bahan_ajar' => "Materi Pengayaan {$mapelNama}:\nBerdasarkan arahan pembaruan, murid diajak memahami implementasi terkini terkait materi ini dalam konteks dunia kerja dan teknologi modern.",
                'pertanyaan_pemantik' => "1. Mengapa materi ini penting dalam kehidupan sehari-hari murid?\n2. Bagaimana solusi kreatif yang bisa dirancang murid untuk mengatasi tantangan terkait materi ini?",
                'pemahaman_bermakna' => "Murid memahami bahwa penguasaan materi {$mapelNama} menjadi modal penting untuk berpikir kritis dan menyelesaikan masalah secara mandiri.",
                'stimulus_lkpd' => "Dalam skenario dunia nyata, murid dihadapkan pada studi kasus pemecahan masalah yang menuntut ketelitian analisis dan kolaborasi solutif.",
                default => "Penambahan materi dan penyesuaian strategi pembelajaran {$mapelNama} Fase {$faseKode} sesuai arahan guru berorientasi murid aktif.",
            };
        }

        // Hitung combined text jika mode append
        $combinedText = $generated;
        if ($actionMode === 'append' && !empty($currentText)) {
            $combinedText = $currentText . "\n\n" . $generated;
        }

        return response()->json([
            'success'        => true,
            'field_type'     => $fieldType,
            'generated_text' => $generated,
            'combined_text'  => $combinedText,
            'action_mode'    => $actionMode,
            'model'          => config('services.nvidia.model', 'z-ai/glm-5.3-flash'),
        ]);
    }

    /**
     * Layanan obrolan interaktif langsung dengan Vx Agent mengenai telaah kurikulum,
     * modul ajar, LKPD, saran pengayaan materi, dan pedagogi Deep Learning.
     */
    public function chat(Request $request, NvidiaAiService $aiService): JsonResponse
    {
        $request->validate([
            'message'        => 'required|string|min:2|max:1500',
            'document_type'  => 'nullable|string',
            'document_id'    => 'nullable',
            'document_title' => 'nullable|string',
            'mata_pelajaran' => 'nullable|string',
            'fase'           => 'nullable|string',
        ]);

        $message = trim($request->message);
        $docType = $request->input('document_type', 'general');
        $docTitle = $request->input('document_title', 'Perangkat Ajar Kurikulum Merdeka');
        $mapelNama = $request->input('mata_pelajaran', 'Mata Pelajaran Umum/Kejuruan');
        $faseKode = $request->input('fase', 'E/F');

        // Cari CP jika mata pelajaran dan fase bisa diidentifikasi
        $cpDeskripsi = 'Sesuai Keputusan Kepala BSKAP No. 046/H/KR/2025.';
        $elemenList = [];

        $mapelObj = MataPelajaran::where('nama', 'like', "%{$mapelNama}%")->first();
        $faseObj = Fase::where('kode', 'like', "%{$faseKode}%")->first();

        if ($mapelObj && $faseObj) {
            $cp = CapaianPembelajaran::where('mata_pelajaran_id', $mapelObj->id)
                ->where('fase_id', $faseObj->id)
                ->first();

            if ($cp) {
                $cpDeskripsi = $cp->deskripsi_cp;
                if (!empty($cp->elemen_cp)) {
                    $decoded = json_decode($cp->elemen_cp, true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $elm => $desk) {
                            $elemenList[] = "{$elm}: {$desk}";
                        }
                    }
                }
            }
        }

        $elemenText = !empty($elemenList) ? implode("\n• ", $elemenList) : 'Elemen kompetensi esensial';

        $context = <<<CTX
PERAN ANDA: Vx Agent - Asisten Pakar Kurikulum Merdeka & Konsultan Deep Learning (Kemendikdasmen RI).
DOKUMEN YANG SEDANG DITELAAH: {$docTitle} (Tipe Dokumen: {$docType})
MATA PELAJARAN: {$mapelNama}
FASE / KELAS: {$faseKode}
REGULASI RESMI: Keputusan Kepala BSKAP No. 046/H/KR/2025, Permendikdasmen No. 10/2025 & No. 13/2025.

CAPAIAN PEMBELAJARAN (CP) RESMI:
{$cpDeskripsi}

ELEMEN CP:
• {$elemenText}

PRINSIP PEDAGOGIS DEEP LEARNING:
1. Mindful Learning (Sadar & Hadir Penuh), Meaningful Learning (Bermakna & Relevan ke Dunia Nyata/Industri), Joyful Learning (Menyenangkan & Menumbuhkan Minat).
2. Sintaks Alur PEDATTI: Pelajari, Dalami, Terapkan, Tularkan, Inovasi.
3. 8 Dimensi Profil Lulusan Permendikdasmen 10/2025.

ATURAN SISTEM SANGAT KETAT:
1. DILARANG menggunakan kata "peserta didik", WAJIB menggunakan kata "murid".
2. Jawaban harus langsung to the point, bersahabat, profesional, dan memberikan saran praktis konkret yang bisa diaplikasikan guru.
3. Jika guru menanyakan cara menambah atau melengkapi materi, ingatkan bahwa guru dapat menggunakan tombol "Edit / Lengkapi via Vx Agent" pada halaman dokumen untuk auto-complete aman tanpa merusak format.
CTX;

        $userPrompt = <<<PROMPT
PERTANYAAN / KONSULTASI DARI GURU:
"{$message}"

Berikan jawaban konsultasi cerdas, rekomendasi praktis untuk kegiatan murid, atau pengayaan materi yang relevan sekarang!
PROMPT;

        $reply = $aiService->generate($userPrompt, $context, 750, 0.45);

        if (!$reply) {
            $reply = "Halo Bapak/Ibu Guru! Terkait **{$docTitle}** ({$mapelNama} Fase {$faseKode}), saya merekomendasikan untuk memperkuat aktivitas murid pada tahap **Terapkan** dan **Tularkan** dengan studi kasus kontekstual. Anda juga dapat mengklik tombol **Edit / Lengkapi via Vx Agent** pada dokumen ini untuk memperkaya materi secara otomatis.";
        }

        // Standardisasi istilah murid
        $reply = str_ireplace('peserta didik', 'murid', $reply);

        return response()->json([
            'success'   => true,
            'reply'     => $reply,
            'doc_type'  => $docType,
            'doc_title' => $docTitle,
            'mapel'     => $mapelNama,
            'fase'      => $faseKode,
            'model'     => config('services.nvidia.model', 'z-ai/glm-5.3-flash'),
        ]);
    }
}

