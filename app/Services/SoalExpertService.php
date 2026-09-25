<?php

namespace App\Services;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\PaketSoal;
use App\Models\TujuanPembelajaran;
use Illuminate\Support\Str;

class SoalExpertService
{
    /**
     * Menghasilkan Paket Soal & Kisi-Kisi Lengkap berbasis Sistem Pakar Murni.
     */
    public function generatePaketSoal(array $params): PaketSoal
    {
        $userId       = $params['user_id'] ?? null;
        $sessionId    = $params['guest_session_id'] ?? null;
        $modulId      = $params['modul_ajar_id'] ?? null;
        $mapelId      = $params['mata_pelajaran_id'];
        $faseId       = $params['fase_id'];
        $tpId         = $params['tujuan_pembelajaran_id'] ?? null;
        $tahunAjaranId = $params['tahun_ajaran_id'] ?? null;

        $jenisUjian   = $params['jenis_ujian'] ?? 'sumatif_lingkup_materi';
        $bentukSoal   = $params['bentuk_soal'] ?? 'campuran'; // pg, isian, campuran
        $totalPg      = (int) ($params['total_soal_pg'] ?? ($bentukSoal === 'isian' ? 0 : 10));
        $totalIsian   = (int) ($params['total_soal_isian'] ?? ($bentukSoal === 'pg' ? 0 : 5));
        $alokasiWaktu = (int) ($params['alokasi_waktu_menit'] ?? 60);

        // Ambil data referensi
        $mapel = MataPelajaran::with('programKeahlian')->findOrFail($mapelId);
        $fase  = Fase::findOrFail($faseId);
        $modul = $modulId ? ModulAjar::with('tujuanPembelajaran', 'kegiatans')->find($modulId) : null;
        $tp    = $tpId ? TujuanPembelajaran::find($tpId) : ($modul?->tujuanPembelajaran);

        if (!$tp) {
            $tp = TujuanPembelajaran::whereHas('capaianPembelajaran', function ($q) use ($mapelId, $faseId) {
                $q->where('mata_pelajaran_id', $mapelId)->where('fase_id', $faseId);
            })->first();
        }

        $cp = $tp?->capaianPembelajaran ?? CapaianPembelajaran::where('mata_pelajaran_id', $mapelId)->where('fase_id', $faseId)->first();

        // Judul Paket Soal
        $judulDefault = match ($jenisUjian) {
            'sumatif_lingkup_materi' => 'Naskah Asesmen Sumatif Lingkup Materi: ' . $mapel->nama,
            'sts' => 'Naskah Asesmen Sumatif Tengah Semester (STS) ' . $mapel->nama,
            'sas' => 'Naskah Asesmen Sumatif Akhir Semester (SAS) ' . $mapel->nama,
            'diagnostik' => 'Instrumen Asesmen Diagnostik Awal Kognitif: ' . $mapel->nama,
            'kuis_harian' => 'Kuis Harian / Tes Formatif Vokasi: ' . $mapel->nama,
            default => 'Paket Asesmen Ujian: ' . $mapel->nama,
        };
        $judul = !empty($params['judul']) ? $params['judul'] : $judulDefault . ' (Fase ' . $fase->kode . ')';

        // Petunjuk Umum
        $petunjukUmum = "1. Berdoalah sebelum mengerjakan soal ujian.\n"
            . "2. Tuliskan identitas Anda secara lengkap dan benar pada lembar jawaban yang telah disediakan.\n"
            . "3. Periksa dan bacalah setiap butir soal dengan teliti sebelum Anda menjawabnya.\n"
            . "4. Dahulukan menjawab soal-soal yang Anda anggap mudah.\n"
            . "5. Untuk soal Pilihan Ganda, pilihlah satu jawaban yang paling tepat (A, B, C, D, atau E).\n"
            . "6. Untuk soal Isian/Uraian, jawablah secara sistematis, logis, dan mengacu pada standar prosedur kerja (SOP).\n"
            . "7. Periksa kembali pekerjaan Anda sebelum diserahkan kepada pengawas ujian.";

        // Elemen & Konteks Materi
        $elemenNama = $tp?->elemen ?: ($modul?->kompetensi_awal ?: 'Kompetensi ' . $mapel->nama);
        $topikUtama = $tp?->deskripsi_tp ?: ($modul?->judul ?: 'Penerapan Materi ' . $mapel->nama);
        $cpDeskripsi = $cp?->deskripsi_cp ?? ('Murid menguasai kompetensi esensial materi ' . $elemenNama . ' pada mata pelajaran ' . $mapel->nama);
        $tpDeskripsi = $tp?->deskripsi_tp ?? 'Mampu memahami konsep dan menerapkan kompetensi secara mandiri dan bernalar kritis.';

        // Rumuskan Kisi-Kisi dan Butir Soal
        $kisiKisi = [];
        $butirPg = [];
        $butirIsian = [];

        $noSoalGlobal = 1;

        // 1. Generate Pilihan Ganda (PG)
        if ($totalPg > 0 && ($bentukSoal === 'pg' || $bentukSoal === 'campuran')) {
            for ($i = 1; $i <= $totalPg; $i++) {
                $level = $this->determineLevelKognitif($i, $totalPg);
                $pgItem = $this->generatePgItem($i, $mapel, $fase, $elemenNama, $topikUtama, $level, $cpDeskripsi);
                $butirPg[] = $pgItem;

                $subMateriKisi = \App\Services\CurriculumKnowledgeBase::resolveMateriName($mapel, $elemenNama, $i);

                // Tambahkan ke Kisi-Kisi
                $kisiKisi[] = [
                    'no' => $noSoalGlobal,
                    'nomor_soal' => $i,
                    'elemen' => $elemenNama,
                    'cp' => Str::limit($cpDeskripsi, 120),
                    'tp' => Str::limit($tpDeskripsi, 100),
                    'materi' => $subMateriKisi,
                    'indikator' => $pgItem['indikator_kisi_kisi'],
                    'level_kognitif' => $level['label'],
                    'bentuk_soal' => 'Pilihan Ganda',
                    'skor_maksimal' => 1,
                ];
                $noSoalGlobal++;
            }
        }

        // 2. Generate Isian / Uraian (Essay)
        if ($totalIsian > 0 && ($bentukSoal === 'isian' || $bentukSoal === 'campuran')) {
            for ($j = 1; $j <= $totalIsian; $j++) {
                $level = $this->determineLevelKognitifEssay($j, $totalIsian);
                $nomorTampil = ($bentukSoal === 'campuran') ? ($totalPg + $j) : $j;
                $isianItem = $this->generateIsianItem($nomorTampil, $j, $mapel, $fase, $elemenNama, $topikUtama, $level, $cpDeskripsi);
                $butirIsian[] = $isianItem;

                $subMateriKisiEssay = \App\Services\CurriculumKnowledgeBase::resolveMateriName($mapel, $elemenNama, $j + 2);

                // Tambahkan ke Kisi-Kisi
                $kisiKisi[] = [
                    'no' => $noSoalGlobal,
                    'nomor_soal' => $nomorTampil,
                    'elemen' => $elemenNama,
                    'cp' => Str::limit($cpDeskripsi, 120),
                    'tp' => Str::limit($tpDeskripsi, 100),
                    'materi' => $subMateriKisiEssay,
                    'indikator' => $isianItem['indikator_kisi_kisi'],
                    'level_kognitif' => $level['label'],
                    'bentuk_soal' => 'Isian / Uraian',
                    'skor_maksimal' => $isianItem['skor_maksimal'],
                ];
                $noSoalGlobal++;
            }
        }

        // Simpan ke database
        return PaketSoal::create([
            'user_id' => $userId,
            'guest_session_id' => $sessionId,
            'is_shared' => false,
            'modul_ajar_id' => $modulId,
            'tujuan_pembelajaran_id' => $tp?->id,
            'mata_pelajaran_id' => $mapelId,
            'fase_id' => $faseId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'judul' => $judul,
            'jenis_ujian' => $jenisUjian,
            'bentuk_soal' => $bentukSoal,
            'total_soal_pg' => count($butirPg),
            'total_soal_isian' => count($butirIsian),
            'alokasi_waktu_menit' => $alokasiWaktu,
            'petunjuk_umum' => $petunjukUmum,
            'kisi_kisi_data' => $kisiKisi,
            'butir_soal_pg' => $butirPg,
            'butir_soal_isian' => $butirIsian,
            'bobot_pg_persen' => ($bentukSoal === 'isian') ? 0 : (($bentukSoal === 'pg') ? 100 : 70),
            'bobot_isian_persen' => ($bentukSoal === 'pg') ? 0 : (($bentukSoal === 'isian') ? 100 : 30),
        ]);
    }

    /**
     * Menentukan distribusi tingkat kognitif Taksonomi Bloom untuk soal PG.
     */
    private function determineLevelKognitif(int $index, int $total): array
    {
        // 20% L1 (C1-C2), 40% L2 (C3), 40% L3 (C4-C6 HOTS)
        $ratio = $index / max(1, $total);

        if ($ratio <= 0.25) {
            return [
                'code' => 'L1',
                'bloom' => 'C2 - Memahami',
                'label' => 'L1 (C2 - Pemahaman Konsep)',
                'tipe' => 'Konseptual & Prosedur Awal',
            ];
        } elseif ($ratio <= 0.65) {
            return [
                'code' => 'L2',
                'bloom' => 'C3 - Menerapkan',
                'label' => 'L2 (C3 - Penerapan SOP Vokasi)',
                'tipe' => 'Aplikasi Prosedur Kerja',
            ];
        } else {
            return [
                'code' => 'L3',
                'bloom' => 'C4/C5 - Menganalisis & Mengevaluasi',
                'label' => 'L3 (C4/C5 - HOTS & Troubleshooting)',
                'tipe' => 'Pemecahan Masalah Industri',
            ];
        }
    }

    /**
     * Menentukan distribusi tingkat kognitif untuk soal Isian/Essay (mayoritas HOTS).
     */
    private function determineLevelKognitifEssay(int $index, int $total): array
    {
        $ratio = $index / max(1, $total);

        if ($ratio <= 0.35) {
            return [
                'code' => 'L2',
                'bloom' => 'C3 - Menerapkan Prosedur',
                'label' => 'L2 (C3 - Prosedural)',
            ];
        } else {
            return [
                'code' => 'L3',
                'bloom' => 'C4/C6 - Analisis Masalah & Solusi Inovatif',
                'label' => 'L3 (C4/C6 - HOTS Analitis)',
            ];
        }
    }

    /**
     * Resolusi nama materi dinamis per subtopik.
     */
    private function resolveMateriName(string $topikUtama, int $step): string
    {
        $subtopiks = [
            1 => 'Prinsip Dasar & Konsep Utama',
            2 => 'Standar Operasional Prosedur (SOP) & Keselamatan K3',
            3 => 'Identifikasi Komponen, Alat, & Bahan Praktik',
            4 => 'Pengujian Parameter Kualitas & Kelaikan Kerja',
            5 => 'Analisis Gangguan & Troubleshooting Kerusakan',
            6 => 'Optimalisasi Efisiensi Kerja & Penerapan Teknologi',
            7 => 'Evaluasi Kualitas Akhir & Dokumentasi Laporan Industri',
            8 => 'Mitigasi Risiko & Pencegahan Masalah Berulang',
        ];

        $sub = $subtopiks[(($step - 1) % 8) + 1] ?? 'Teknik & Penerapan Operasional';
        return Str::limit($topikUtama, 35) . ' — ' . $sub;
    }

    /**
     * Menghasilkan 1 butir Soal Pilihan Ganda (PG) dengan 1 kunci dan 4 pengecoh homogen.
     */
    private function generatePgItem(int $nomor, MataPelajaran $mapel, Fase $fase, string $elemen, string $topik, array $level, ?string $cpDeskripsi = null): array
    {
        $keys = ['A', 'B', 'C', 'D', 'E'];
        $correctKey = $keys[($nomor - 1) % 5]; // Rotasi kunci jawaban seimbang A-E

        // Ambil data butir soal spesifik dari Knowledge Base & Database
        $kbSoal = \App\Services\CurriculumKnowledgeBase::getSoalPgData($mapel, $elemen, $nomor, $cpDeskripsi);

        // Pertukarkan opsi agar correctKey sesuai rotasi A-E (Shuffling logic)
        $options = $kbSoal['options'];
        $originalCorrect = $kbSoal['correct'] ?? 'A';
        $originalCorrectText = $options[$originalCorrect] ?? array_values($options)[0];
        $targetCorrectText = $options[$correctKey] ?? array_values($options)[0];
        
        $options[$originalCorrect] = $targetCorrectText;
        $options[$correctKey] = $originalCorrectText;

        return [
            'nomor' => $nomor,
            'stimulus' => $kbSoal['stimulus'],
            'pertanyaan' => $kbSoal['pertanyaan'],
            'pilihan' => $options,
            'kunci_jawaban' => $correctKey,
            'pembahasan' => $kbSoal['pembahasan'],
            'level_kognitif' => $level['label'],
            'skor' => 1,
            'indikator_kisi_kisi' => $kbSoal['indikator'],
        ];
    }

    /**
     * Menghasilkan 1 butir Soal Isian / Uraian (Essay) dengan kata kunci dan rubrik penskoran analitik.
     */
    private function generateIsianItem(int $nomorTampil, int $nomorUrut, MataPelajaran $mapel, Fase $fase, string $elemen, string $topik, array $level, ?string $cpDeskripsi = null): array
    {
        // Ambil data soal Isian dari Knowledge Base & Database
        $kbIsian = \App\Services\CurriculumKnowledgeBase::getSoalIsianData($mapel, $elemen, $nomorUrut, $cpDeskripsi);

        return [
            'nomor' => $nomorTampil,
            'nomor_urut' => $nomorUrut,
            'stimulus' => $kbIsian['stimulus'] ?? 'Perhatikan studi kasus atau fenomena berikut untuk menjawab pertanyaan di bawah ini dengan kritis.',
            'pertanyaan' => $kbIsian['pertanyaan'],
            'kata_kunci' => $kbIsian['kunci'],
            'pedoman_penskoran' => $kbIsian['pedoman_penskoran'] ?? "Rubrik Skor Maksimal 10:\n• Skor 9 - 10: Menguraikan jawaban secara komprehensif, logis, dan runtut.\n• Skor 6 - 8: Menjawab dengan baik namun ada aspek minor yang terlewat.\n• Skor 3 - 5: Menjawab secara singkat tanpa rincian konsep.\n• Skor 1 - 2: Jawaban kurang relevan.\n• Skor 0: Lembar kosong.",
            'skor_maksimal' => 10,
            'level_kognitif' => $level['label'],
            'indikator_kisi_kisi' => $kbIsian['indikator'] ?? "Murid mampu menguraikan konsep materi {$elemen} secara analitis.",
        ];
    }

    /**
     * Mengacak dan memindahkan kunci jawaban ke posisi huruf yang ditargetkan ($targetKey).
     */
    private function shuffleOptionsToKey(array $originalOptions, string $currentCorrectKey, string $targetKey): array
    {
        $correctText = $originalOptions[$currentCorrectKey];
        $wrongTexts = [];
        foreach ($originalOptions as $k => $v) {
            if ($k !== $currentCorrectKey) {
                $wrongTexts[] = $v;
            }
        }

        $result = [];
        $letters = ['A', 'B', 'C', 'D', 'E'];
        $wrongIdx = 0;

        foreach ($letters as $letter) {
            if ($letter === $targetKey) {
                $result[$letter] = $correctText;
            } else {
                $result[$letter] = $wrongTexts[$wrongIdx] ?? 'Pilihan jawaban alternatif lainnya.';
                $wrongIdx++;
            }
        }

        return $result;
    }
}
