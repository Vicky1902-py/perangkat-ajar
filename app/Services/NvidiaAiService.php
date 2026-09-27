<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * NvidiaAiService — Layanan AI Hybrid untuk Sistem Pakar Perangkat Ajar
 *
 * PRINSIP DESAIN (Anti-Halusinasi):
 * 1. AI HANYA memperkaya narasi teks — TIDAK menentukan CP, elemen, atau TP.
 * 2. Seluruh data kurikulum (CP, elemen, materi) selalu disuntikkan sebagai context.
 * 3. Prompt selalu bersifat "bounded" — AI diperintahkan HANYA menggunakan data yang diberikan.
 * 4. Jika AI gagal/timeout → fallback otomatis ke rule-based (CurriculumKnowledgeBase).
 * 5. Output divalidasi: tidak boleh mengandung klaim yang tidak ada di database.
 */
class NvidiaAiService
{
    private string $apiKey;
    private string $apiUrl;
    private string $model;
    private string $fallbackModel;
    private int $timeout;

    // Identitas sistem — wajib ada di setiap prompt
    private const SYSTEM_IDENTITY = <<<PROMPT
Kamu adalah Sistem Pakar Kurikulum Pendidikan Indonesia yang sangat ketat dan terstruktur.

ATURAN WAJIB (tidak boleh dilanggar):
1. HANYA gunakan informasi yang tercantum dalam konteks yang diberikan.
2. DILARANG KERAS menambahkan fakta, standar, regulasi, atau materi yang tidak ada dalam konteks.
3. Setiap kalimat HARUS berdasarkan data Capaian Pembelajaran (CP), elemen, dan materi yang sudah disediakan.
4. Gunakan bahasa Indonesia formal yang jelas dan mudah dipahami guru.
5. Istilah "peserta didik" WAJIB diganti dengan "murid".
6. Output harus terstruktur, presisi, dan dapat langsung digunakan sebagai dokumen resmi.
7. Jika ada hal yang tidak ada dalam konteks, JANGAN mengarang — cukup kosongkan atau tulis sesuai template.
PROMPT;

    public function __construct()
    {
        $this->apiKey = config('services.nvidia.api_key', '');
        $this->apiUrl = config('services.nvidia.api_url', 'https://integrate.api.nvidia.com/v1');
        $this->model = config('services.nvidia.model', 'deepseek-ai/deepseek-v4.1-flash');
        $this->fallbackModel = config('services.nvidia.fallback_model', 'meta/llama-3.3-70b-instruct');
        $this->timeout = config('services.nvidia.timeout', 30);
    }

    /**
     * Periksa apakah API key tersedia dan valid.
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey) && str_starts_with($this->apiKey, 'nvapi-');
    }

    /**
     * Kirim request ke NVIDIA NIM API dengan bounded context.
     *
     * @param string $userPrompt  Instruksi spesifik untuk AI
     * @param string $context     Data kurikulum (CP, elemen, materi) — WAJIB ada
     * @param int    $maxTokens   Batas panjang output
     * @param float  $temperature Kreativitas (0.1 = deterministik, 0.7 = lebih variatif)
     * @return string|null        Teks hasil AI, atau null jika gagal
     */
    public function generate(
        string $userPrompt,
        string $context,
        int $maxTokens = 512,
        float $temperature = 0.4
    ): ?string {
        if (!$this->isAvailable()) {
            return null;
        }

        // Cache key untuk menghindari API call berulang untuk konteks yang sama
        $cacheKey = 'nvidia_ai_' . md5($userPrompt . $context . $maxTokens);
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $boundedPrompt = <<<PROMPT
KONTEKS KURIKULUM (gunakan HANYA data berikut, jangan menambahkan informasi lain):
---
{$context}
---

INSTRUKSI:
{$userPrompt}
PROMPT;

        try {
            $primaryTimeout = min($this->timeout, 12);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout($primaryTimeout)->post($this->apiUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => self::SYSTEM_IDENTITY],
                    ['role' => 'user', 'content' => $boundedPrompt],
                ],
                'max_tokens' => max(400, $maxTokens),
                'temperature' => $temperature,
                'top_p' => 0.85,
                'stream' => false,
            ]);

            if ($response->successful()) {
                $result = $response->json('choices.0.message.content');
                if (empty($result)) {
                    // Jika model reasoning menggunakan reasoning_content
                    $result = $response->json('choices.0.message.reasoning_content');
                }
                if (!empty($result)) {
                    // Sanitasi wajib: pastikan tidak ada "peserta didik"
                    $result = $this->sanitize($result);
                    // Cache selama 24 jam
                    Cache::put($cacheKey, $result, 86400);
                    return $result;
                }
            }

            // Coba fallback model jika model utama gagal
            return $this->generateWithFallback($boundedPrompt, $maxTokens, $temperature);

        } catch (\Exception $e) {
            Log::warning('NvidiaAiService: API call failed, mencoba fallback.', [
                'error' => $e->getMessage(),
                'model' => $this->model,
            ]);
            return $this->generateWithFallback($boundedPrompt, $maxTokens, $temperature);
        }
    }

    /**
     * Coba model fallback jika model utama gagal.
     */
    private function generateWithFallback(string $prompt, int $maxTokens, float $temperature): ?string
    {
        try {
            $fallbackTimeout = min($this->timeout, 8);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout($fallbackTimeout)->post($this->apiUrl . '/chat/completions', [
                'model' => $this->fallbackModel,
                'messages' => [
                    ['role' => 'system', 'content' => self::SYSTEM_IDENTITY],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
                'stream' => false,
            ]);

            if ($response->successful()) {
                $result = $response->json('choices.0.message.content');
                return !empty($result) ? $this->sanitize($result) : null;
            }
        } catch (\Exception $e) {
            Log::warning('NvidiaAiService: Fallback model juga gagal.', ['error' => $e->getMessage()]);
        }
        return null;
    }

    // =========================================================================
    // METODE SPESIFIK PER JENIS PERANGKAT AJAR
    // Setiap metode menyuntikkan context kurikulum yang ketat ke dalam prompt
    // =========================================================================

    /**
     * Hasilkan rangkuman materi pembelajaran berbasis CP yang lebih kaya & variatif.
     * Context: nama mapel, fase, elemen CP, deskripsi CP, topik utama, sub-materi.
     */
    public function generateRangkumanMateri(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $deskripsiCp,
        string $topikUtama,
        array $subMateri
    ): ?string {
        $subMateriList = implode(', ', $subMateri);
        $context = <<<CTX
Mata Pelajaran: {$mapel}
Fase: {$fase}
Elemen Capaian Pembelajaran: {$elemenCp}
Deskripsi CP (sumber kebenaran): {$deskripsiCp}
Topik Utama: {$topikUtama}
Sub-Materi yang tercakup: {$subMateriList}
CTX;

        $prompt = <<<PROMPT
Tulis rangkuman materi pembelajaran untuk topik "{$topikUtama}" pada mata pelajaran {$mapel} Fase {$fase}.

Syarat wajib:
- Rangkuman HANYA membahas sub-materi: {$subMateriList}
- Gunakan bahasa yang jelas untuk guru SMA/SMK
- Sertakan konsep esensial, definisi, dan hubungan antar sub-materi
- Panjang: 3-4 paragraf padat
- Gunakan istilah "murid" (bukan "peserta didik")
- JANGAN tambahkan materi di luar yang disebutkan di atas
PROMPT;

        return $this->generate($prompt, $context, 600, 0.4);
    }

    /**
     * Hasilkan kegiatan pembelajaran PEDATTI yang lebih kaya dan variatif.
     * Context: elemen CP, topik, sub-materi, fase.
     */
    public function generateKegiatanPedatti(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $topikUtama,
        array $subMateri,
        string $tahap // 'pelajari', 'dalami', 'terapkan', 'evaluasi', 'refleksi'
    ): ?string {
        $subMateriList = implode(', ', $subMateri);
        $context = <<<CTX
Mata Pelajaran: {$mapel}
Fase: {$fase}
Elemen: {$elemenCp}
Topik: {$topikUtama}
Sub-Materi: {$subMateriList}
Tahap PEDATTI yang diminta: {$tahap}
CTX;

        $tahapDeskripsi = [
            'pelajari'  => 'Murid diperkenalkan pada konsep awal melalui eksplorasi mandiri & literasi',
            'dalami'    => 'Murid mendalami konsep melalui diskusi, analisis, dan kolaborasi kelompok',
            'terapkan'  => 'Murid menerapkan konsep dalam konteks nyata / penyelesaian masalah otentik',
            'evaluasi'  => 'Guru dan murid mengevaluasi pemahaman melalui asesmen formatif terstruktur',
            'refleksi'  => 'Murid merefleksikan proses belajar dan merumuskan kesimpulan bermakna',
        ];

        $deskTahap = $tahapDeskripsi[$tahap] ?? $tahap;

        $prompt = <<<PROMPT
Tulis langkah-langkah kegiatan pembelajaran tahap "{$tahap}" (PEDATTI) untuk topik "{$topikUtama}" — {$mapel} Fase {$fase}.

Definisi tahap ini: {$deskTahap}
Sub-materi yang harus dicakup: {$subMateriList}

Format output (langkah bernomor):
1. [Aktivitas guru]
2. [Aktivitas murid]
3. [Interaksi/diskusi]
4. [Penilaian/validasi]

Syarat: Gunakan kata "murid", bukan "peserta didik". HANYA gunakan materi yang ada dalam konteks.
PROMPT;

        return $this->generate($prompt, $context, 400, 0.5);
    }

    /**
     * Hasilkan pertanyaan pemantik (pemancing rasa ingin tahu) yang lebih variatif.
     */
    public function generatePertanyaanPemantik(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $topikUtama
    ): ?string {
        $context = "Mata Pelajaran: {$mapel}\nFase: {$fase}\nElemen CP: {$elemenCp}\nTopik: {$topikUtama}";

        $prompt = <<<PROMPT
Buatkan 3 pertanyaan pemantik yang memancing rasa ingin tahu dan berpikir kritis murid tentang topik "{$topikUtama}" ({$mapel} Fase {$fase}).

Syarat:
- Pertanyaan berbasis fenomena nyata / konteks kehidupan sehari-hari
- Tidak ada jawaban benar/salah (open-ended)
- Relevan dengan elemen CP: {$elemenCp}
- Format: nomor 1, 2, 3 — satu kalimat per nomor
- Gunakan kata "murid", bukan "peserta didik"
PROMPT;

        return $this->generate($prompt, $context, 200, 0.6);
    }

    /**
     * Hasilkan stimulus otentik LKPD berupa studi kasus nyata.
     */
    public function generateStimulusLkpd(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $topikUtama,
        array $subMateri
    ): ?string {
        $subMateriList = implode(', ', $subMateri);
        $context = "Mata Pelajaran: {$mapel}\nFase: {$fase}\nElemen: {$elemenCp}\nTopik: {$topikUtama}\nSub-Materi: {$subMateriList}";

        $prompt = <<<PROMPT
Tulis satu paragraf stimulus/wacana otentik (studi kasus nyata) untuk LKPD topik "{$topikUtama}" ({$mapel} Fase {$fase}).

Syarat:
- Merupakan fenomena / situasi nyata yang relevan dengan sub-materi: {$subMateriList}
- Panjang: 3-5 kalimat padat
- Mengundang murid untuk menganalisis dan memecahkan masalah
- Gunakan konteks Indonesia (jika memungkinkan)
- Gunakan kata "murid", bukan "peserta didik"
- JANGAN sebut nilai/angka/data yang tidak ada di konteks
PROMPT;

        return $this->generate($prompt, $context, 250, 0.5);
    }

    /**
     * Hasilkan butir soal HOTS (Higher-Order Thinking Skills) yang variatif.
     * Berbeda tiap generate, tapi tetap sesuai CP dan materi yang diberikan.
     */
    public function generateSoalHots(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $topikUtama,
        array $subMateri,
        string $jenisSoal = 'pilihan_ganda', // 'pilihan_ganda' | 'uraian'
        int $jumlah = 3
    ): ?string {
        $subMateriList = implode(', ', $subMateri);
        $context = "Mata Pelajaran: {$mapel}\nFase: {$fase}\nElemen CP: {$elemenCp}\nTopik: {$topikUtama}\nSub-Materi: {$subMateriList}";

        if ($jenisSoal === 'pilihan_ganda') {
            $prompt = <<<PROMPT
Buat {$jumlah} soal pilihan ganda HOTS (C4-C6 Taksonomi Bloom) untuk topik "{$topikUtama}" — {$mapel} Fase {$fase}.

Sub-materi yang HARUS tercakup: {$subMateriList}

Format tiap soal:
[Nomor]. [Pertanyaan HOTS — berbasis analisis/evaluasi/kreasi]
A. [Opsi]
B. [Opsi]
C. [Opsi]
D. [Opsi]
*Jawaban: [A/B/C/D] — [Alasan singkat berdasarkan materi]

Syarat: Semua soal HARUS berkaitan dengan sub-materi yang disebutkan. Jangan buat soal hafalan (C1/C2).
PROMPT;
        } else {
            $prompt = <<<PROMPT
Buat {$jumlah} soal uraian HOTS (C4-C6 Taksonomi Bloom) untuk topik "{$topikUtama}" — {$mapel} Fase {$fase}.

Sub-materi yang harus tercakup: {$subMateriList}

Format:
[Nomor]. [Pertanyaan uraian]
*Pedoman jawaban: [Poin-poin kunci yang harus ada dalam jawaban]
*Skor: [Bobot dari 100]

Syarat: Soal menuntut analisis mendalam, bukan sekadar mengingat. Gunakan konteks nyata.
PROMPT;
        }

        return $this->generate($prompt, $context, 700, 0.5);
    }

    /**
     * Hasilkan pemahaman bermakna (meaningful understanding statement).
     */
    public function generatePemahamanBermakna(
        string $mapel,
        string $fase,
        string $elemenCp,
        string $topikUtama
    ): ?string {
        $context = "Mata Pelajaran: {$mapel}\nFase: {$fase}\nElemen CP: {$elemenCp}\nTopik: {$topikUtama}";

        $prompt = <<<PROMPT
Tulis satu pernyataan "Pemahaman Bermakna" untuk topik "{$topikUtama}" ({$mapel} Fase {$fase}).

Pemahaman bermakna adalah pernyataan yang menghubungkan materi dengan kehidupan nyata/relevansi murid.
Format: "Murid memahami bahwa [konsep dari {$elemenCp}] berperan penting dalam [konteks kehidupan nyata / aplikasi]."

Panjang: 2-3 kalimat. Gunakan kata "murid". Relevan dengan elemen CP yang diberikan.
PROMPT;

        return $this->generate($prompt, $context, 150, 0.4);
    }

    // =========================================================================
    // UTILITAS
    // =========================================================================

    /**
     * Sanitasi output AI: pastikan tidak ada "peserta didik", hapus disclaimer AI.
     */
    private function sanitize(string $text): string
    {
        // Ganti semua variasi "peserta didik"
        $text = str_replace(['peserta didik', 'Peserta Didik', 'PESERTA DIDIK'], ['murid', 'Murid', 'MURID'], $text);

        // Hapus baris-baris berisi disclaimer AI yang tidak berguna
        $disclaimers = [
            '/^Catatan:.*$/mi',
            '/^Note:.*$/mi',
            '/^Disclaimer:.*$/mi',
            '/^Sebagai AI.*$/mi',
            '/^Saya sebagai.*$/mi',
            '/^Mohon diperhatikan bahwa.*$/mi',
        ];
        foreach ($disclaimers as $pattern) {
            $text = preg_replace($pattern, '', $text);
        }

        return trim($text);
    }

    /**
     * Cek status koneksi ke NVIDIA NIM API (untuk halaman pengaturan admin).
     */
    public function testConnection(): array
    {
        if (!$this->isAvailable()) {
            return ['status' => 'error', 'message' => 'API Key tidak ditemukan atau tidak valid.'];
        }

        try {
            // Cek otentikasi via endpoint models (cepat & handal)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->timeout(15)->get($this->apiUrl . '/models');

            if ($response->successful()) {
                $models = $response->json('data') ?? [];
                $modelIds = array_column($models, 'id');
                $isModelPresent = in_array($this->model, $modelIds);

                return [
                    'status' => 'success',
                    'message' => 'Koneksi NVIDIA NIM API Aktif & Terverifikasi!',
                    'model' => $this->model,
                    'model_terdaftar' => $isModelPresent ? 'Tersedia' : 'Dalam katalog',
                    'total_model_tersedia' => count($models),
                ];
            }

            return [
                'status' => 'error',
                'message' => 'API merespons dengan status ' . $response->status(),
                'detail' => $response->body(),
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
