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
        $elemenNama = $tp?->elemen ?: ($modul?->kompetensi_awal ?: 'Kompetensi Kejuruan ' . $mapel->nama);
        $topikUtama = $modul?->judul ?: ($tp?->deskripsi_tp ?: 'Penerapan Praktik Vokasi Standar Industri');
        $cpDeskripsi = $cp?->deskripsi ?? 'Peserta didik menguasai kompetensi teknis, nalar kritis, dan etika kerja industri pada mata pelajaran ' . $mapel->nama;
        $tpDeskripsi = $tp?->deskripsi_tp ?? 'Mampu memahami konsep, mempraktikkan keterampilan, dan memecahkan masalah kejuruan secara mandiri dan bertanggung jawab.';

        // Rumuskan Kisi-Kisi dan Butir Soal
        $kisiKisi = [];
        $butirPg = [];
        $butirIsian = [];

        $noSoalGlobal = 1;

        // 1. Generate Pilihan Ganda (PG)
        if ($totalPg > 0 && ($bentukSoal === 'pg' || $bentukSoal === 'campuran')) {
            for ($i = 1; $i <= $totalPg; $i++) {
                $level = $this->determineLevelKognitif($i, $totalPg);
                $pgItem = $this->generatePgItem($i, $mapel, $fase, $elemenNama, $topikUtama, $level);
                $butirPg[] = $pgItem;

                // Tambahkan ke Kisi-Kisi
                $kisiKisi[] = [
                    'no' => $noSoalGlobal,
                    'nomor_soal' => $i,
                    'elemen' => $elemenNama,
                    'cp' => Str::limit($cpDeskripsi, 120),
                    'tp' => Str::limit($tpDeskripsi, 100),
                    'materi' => $this->resolveMateriName($topikUtama, $i),
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
                $isianItem = $this->generateIsianItem($nomorTampil, $j, $mapel, $fase, $elemenNama, $topikUtama, $level);
                $butirIsian[] = $isianItem;

                // Tambahkan ke Kisi-Kisi
                $kisiKisi[] = [
                    'no' => $noSoalGlobal,
                    'nomor_soal' => $nomorTampil,
                    'elemen' => $elemenNama,
                    'cp' => Str::limit($cpDeskripsi, 120),
                    'tp' => Str::limit($tpDeskripsi, 100),
                    'materi' => $this->resolveMateriName($topikUtama, $j + 3),
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
    private function generatePgItem(int $nomor, MataPelajaran $mapel, Fase $fase, string $elemen, string $topik, array $level): array
    {
        $mapelNama = $mapel->nama;
        $keys = ['A', 'B', 'C', 'D', 'E'];
        $correctKey = $keys[($nomor - 1) % 5]; // Rotasi kunci jawaban seimbang A-E

        $scenarios = [
            1 => [
                'stimulus' => "Dalam aktivitas praktik di bengkel/laboratorium kejuruan {$mapelNama}, seorang peserta didik mengamati terjadinya deviasi pada parameter operasional saat alat dijalankan sesuai instruksi awal.",
                'pertanyaan' => "Tindakan pemeriksaan pertama yang paling tepat dan aman sesuai standar prosedur keselamatan kerja (K3) adalah...",
                'options' => [
                    'A' => "Memutuskan sumber arus/daya utama dan melakukan inspeksi visual terhadap seluruh komponen sambungan serta indikator tekanan.",
                    'B' => "Menaikkan beban kerja peralatan secara bertahap untuk memastikan apakah deviasi parameter bersifat sementara.",
                    'C' => "Mengganti komponen utama secara langsung tanpa melakukan pencatatan nilai ukur pada lembar kontrol.",
                    'D' => "Melanjutkan proses kerja hingga batas waktu selesai lalu melaporkan kondisi alat pada instruktur.",
                    'E' => "Mengatur ulang kalibrasi secara acak hingga jarum instrumen kembali menunjukkan angka referensi standar.",
                ],
                'correct' => 'A',
                'pembahasan' => "Langkah isolasi sumber energi (memutuskan arus/daya) dan inspeksi visual merupakan protokol dasar K3LH dan SOP pemeliharaan industri untuk mencegah kecelakaan fatal sebelum dilakukan tindakan teknis lebih lanjut.",
                'indikator' => "Disajikan narasi situasi deviasi parameter operasional alat pada {$mapelNama}, peserta didik dapat menentukan tindakan pemeriksaan awal berbasis SOP K3 dengan tepat.",
            ],
            2 => [
                'stimulus' => "Sebuah industri mitra (DUDI) menetapkan spesifikasi toleransi yang sangat ketat dalam proses pengerjaan elemen {$elemen}. Setiap penyimpangan di atas 0,05 mm dikategorikan sebagai produk cacat (reject).",
                'pertanyaan' => "Faktor teknis yang paling berpotensi menyebabkan penyimpangan dimensi di luar toleransi yang ditentukan pada proses tersebut adalah...",
                'options' => [
                    'A' => "Penggunaan alat ukur presisi yang baru selesai dikalibrasi oleh laboratorium terakreditasi.",
                    'B' => "Adanya getaran berlebih (vibrasi mekanis) dan keausan pada mata pahat/komponen potong yang tidak terdeteksi tepat waktu.",
                    'C' => "Penerapan pendinginan (coolant) secara konsisten dan stabil pada area bidang kontak pengerjaan.",
                    'D' => "Pembersihan berkala terhadap serpihan/geram pada meja landasan kerja sebelum pemasangan benda kerja.",
                    'E' => "Penetapan kecepatan potong (cutting speed) sesuai dengan tabel rekomendasi spesifikasi material pabrikan.",
                ],
                'correct' => 'B',
                'pembahasan' => "Vibrasi mekanis dan keausan elemen pemotong langsung mengubah geometri kontak dan menghasilkan penyimpangan ukuran di luar toleransi toleransi yang diizinkan pada produk presisi industri.",
                'indikator' => "Disajikan studi kasus standar toleransi presisi industri, peserta didik mampu menganalisis faktor teknis penyebab terjadinya cacat dimensi produk secara akurat.",
            ],
            3 => [
                'stimulus' => "Pada saat teknisi melaksanakan pengujian fungsi pada sistem {$topik}, diperoleh data bahwa keluaran sistem tidak mencapai target daya efisiensi yang direncanakan meskipun tegangan pasokan normal.",
                'pertanyaan' => "Berdasarkan prinsip alur kerja kelistrikan dan mekanik pada {$mapelNama}, hipotesis troubleshooting yang paling rasional untuk diperiksa lebih lanjut adalah...",
                'options' => [
                    'A' => "Terjadinya rugi-rugi gesekan internal atau resistansi kontak yang meningkat akibat sambungan kotor atau pelumasan yang terdegradasi.",
                    'B' => "Penurunan temperatur lingkungan kerja di bawah titik beku yang meningkatkan efisiensi hantaran konduktor.",
                    'C' => "Keberadaan sekring pengaman (fuse) yang berfungsi optimal dalam membatasi arus puncak sesaat.",
                    'D' => "Kabel pentanahan (grounding) yang terpasang erat pada kerangka pelindung logam peralatan.",
                    'E' => "Kesesuaian kapasitas beban kerja yang berada 20% di bawah kapasitas nominal rancangan alat.",
                ],
                'correct' => 'A',
                'pembahasan' => "Peningkatan hambatan kontak atau resistansi sambungan serta keausan pelumas menyebabkan disipasi energi menjadi panas (losses), sehingga keluaran daya efektif turun drastis kendati tegangan sumber terpantau normal.",
                'indikator' => "Disajikan data gejala penurunan efisiensi sistem {$mapelNama}, peserta didik mampu merumuskan hipotesis troubleshooting teknis yang paling rasional dan terukur.",
            ],
            4 => [
                'stimulus' => "Dalam rangka mendukung prinsip ramah lingkungan (Green Skills & Circular Economy) pada bidang keahlian {$mapelNama}, unit produksi sekolah merencanakan pengelolaan limbah sisa bahan praktik.",
                'pertanyaan' => "Metode penanganan limbah B3 (Bahan Berbahaya dan Beracun) seperti oli bekas, cairan kimia etsa, atau residu pelarut yang sesuai dengan regulasi lingkungan hidup adalah...",
                'options' => [
                    'A' => "Menampung limbah pada drum khusus bertutup berlabel B3 dan menyerahkannya kepada badan pengolah limbah berizin resmi.",
                    'B' => "Mencampurkan limbah cair tersebut dengan air mengalir bertekanan tinggi langsung menuju saluran drainase umum.",
                    'C' => "Mengubur limbah padat dan cair ke dalam tanah di area belakang bengkel dengan kedalaman minimal 1 meter.",
                    'D' => "Membakar limbah sisa pelarut di tempat terbuka agar tidak mencemari sumber mata air bawah tanah.",
                    'E' => "Menyimpan limbah di wadah terbuka di dekat pintu bengkel agar mudah terpantau oleh instruktur.",
                ],
                'correct' => 'A',
                'pembahasan' => "Pengelolaan limbah B3 wajib mengikuti prinsip penampungan tertutup dengan simbol/label bahaya dan diserahkan kepada pihak pengumpul/pengolah limbah B3 yang memiliki manifest dan izin Kementerian LHK.",
                'indikator' => "Disajikan konteks pengelolaan sisa bahan praktik vokasi, peserta didik dapat mengidentifikasi prosedur penanganan limbah B3 sesuai norma K3LH dan kelestarian lingkungan.",
            ],
            5 => [
                'stimulus' => "Perhatikan tabel tahapan pemeliharaan preventif (preventive maintenance) berkala pada unit {$elemen}: Tahap 1: Inspeksi visual; Tahap 2: Pengukuran kelonggaran (clearance); Tahap 3: Pelumasan; Tahap 4: Uji fungsi dinamis.",
                'pertanyaan' => "Tujuan utama ditetapkannya urutan pengukuran kelonggaran (clearance) SEBELUM dilakukan penambahan pelumas baru adalah...",
                'options' => [
                    'A' => "Mencegah lapisan film pelumas tebal mengaburkan pembacaan celah aktual antara dua bidang gesek komponen.",
                    'B' => "Menghemat pemakaian pelumas agar komponen tidak terlalu licin saat dioperasikan pada beban tinggi.",
                    'C' => "Mempercepat waktu pengerjaan pemeliharaan tanpa perlu membersihkan permukaan logam yang diukur.",
                    'D' => "Memastikan suhu komponen meningkat terlebih dahulu sebelum diberikan pelumas dengan viskositas kental.",
                    'E' => "Menghilangkan kotoran gram sisa gesekan secara mekanis tanpa memerlukan cairan pembersih khusus.",
                ],
                'correct' => 'A',
                'pembahasan' => "Pengukuran clearance mekanis wajib dilakukan saat permukaan kontak bersih dan bebas lapisan minyak tebal agar instrumen ukur (seperti feeler gauge / dial indicator) mencatat celah logam sejati tanpa efek bantalan fluida.",
                'indikator' => "Disajikan tabel prosedur pemeliharaan preventif berkala, peserta didik dapat menganalisis alasan teknis urutan tahapan pengukuran mekanis secara logis.",
            ],
        ];

        $scenarioIndex = (($nomor - 1) % 5) + 1;
        $template = $scenarios[$scenarioIndex];

        // Sesuaikan opsi agar kunci jawaban jatuh pada $correctKey
        $options = $this->shuffleOptionsToKey($template['options'], $template['correct'], $correctKey);

        return [
            'nomor' => $nomor,
            'stimulus' => $template['stimulus'],
            'pertanyaan' => $template['pertanyaan'],
            'pilihan' => $options,
            'kunci_jawaban' => $correctKey,
            'pembahasan' => $template['pembahasan'],
            'level_kognitif' => $level['label'],
            'skor' => 1,
            'indikator_kisi_kisi' => $template['indikator'],
        ];
    }

    /**
     * Menghasilkan 1 butir Soal Isian / Uraian (Essay) dengan kata kunci dan rubrik penskoran analitik.
     */
    private function generateIsianItem(int $nomorTampil, int $nomorUrut, MataPelajaran $mapel, Fase $fase, string $elemen, string $topik, array $level): array
    {
        $mapelNama = $mapel->nama;

        $essayTemplates = [
            1 => [
                'stimulus' => "Dalam sebuah proyek perakitan dan uji kelaikan teknis pada elemen '{$elemen}', tim kerja Anda ditugaskan untuk menyusun alur kerja terstruktur guna mencegah terjadinya kesalahan operasional berulang yang kerap ditemui peserta didik pemula.",
                'pertanyaan' => "Uraikan 4 langkah kerja berurutan (SOP) mulai dari persiapan alat/bahan, proses inti pengerjaan, verifikasi hasil ukur, hingga tahap pembersihan dan keselamatan kerja K3 pada kompetensi {$mapelNama}!",
                'kata_kunci' => "1. Tahap Persiapan (APD, cek kelayakan alat, pembacaan gambar kerja); 2. Tahap Eksekusi (penerapan parameter sesuai standar, monitoring berkala); 3. Tahap Verifikasi (pengukuran presisi, pencatatan deviasi); 4. Tahap Akhir (housekeeping 5S/5R, pembuangan limbah, serah terima alat).",
                'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n"
                    . "• Skor 9 - 10: Menguraikan 4 tahapan secara runtut, logis, menyertakan standar K3 dan verifikasi presisi industri secara komprehensif.\n"
                    . "• Skor 6 - 8: Menguraikan 3-4 tahapan dengan baik, namun penjelasan aspek verifikasi atau K3 kurang mendalam.\n"
                    . "• Skor 3 - 5: Hanya menyebutkan 2 tahapan dasar tanpa rincian prosedur operasional yang jelas.\n"
                    . "• Skor 1 - 2: Menjawab sangat singkat, prosedur tidak sistematis dan tidak mengacu pada kaidah vokasi.\n"
                    . "• Skor 0: Tidak memberikan jawaban sama sekali.",
                'skor_maksimal' => 10,
                'indikator' => "Disajikan skenario penyusunan alur kerja proyek kejuruan, peserta didik dapat merumuskan 4 langkah SOP kerja terstruktur pada {$elemen} lengkap dengan aspek keselamatan kerja K3.",
            ],
            2 => [
                'stimulus' => "Saat melakukan troubleshooting pada unit '{$topik}', teknisi mendeteksi suara dengung abnormal disertai peningkatan panas (overheating) yang signifikan setelah unit bekerja selama 15 menit.",
                'pertanyaan' => "Lakukan analisis kritis mengenai:\n"
                    . "a. Dua kemungkinan penyebab utama timbulnya panas berlebih dan suara abnormal tersebut.\n"
                    . "b. Alat ukur/uji yang digunakan untuk memverifikasi gangguan tersebut.\n"
                    . "c. Dua langkah perbaikan konkret untuk mengatasi masalah tersebut agar tidak terjadi kerusakan permanen.",
                'kata_kunci' => "a. Penyebab: Beban lebih (overload), pelumasan kering, misalignment/ketidaksejajaran poros, atau korsleting parsial belitan; b. Alat uji: Termometer inframerah (thermal gun), vibration tester, multimeter/tang ampere; c. Solusi: Penyesuaian beban kerja, re-alignment komponen, penggantian pelumas standar, dan penggantian bearing/komponen aus.",
                'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n"
                    . "• Skor 9 - 10: Menjawab bagian (a), (b), dan (c) secara tepat, menyertakan nama alat ukur presisi dan analisis kausalitas yang mendalam.\n"
                    . "• Skor 6 - 8: Menjawab 2 dari 3 bagian dengan benar atau analisis penyebab tepat namun langkah perbaikan bersifat umum.\n"
                    . "• Skor 3 - 5: Menjawab sebagian kecil indikator (misal hanya menyebutkan nama alat tanpa langkah perbaikan).\n"
                    . "• Skor 1 - 2: Jawaban spekulatif dan tidak didukung logika teknik kejuruan {$mapelNama}.\n"
                    . "• Skor 0: Lembar jawaban kosong.",
                'skor_maksimal' => 10,
                'indikator' => "Disajikan studi kasus fenomena overheating dan suara abnormal pada unit {$mapelNama}, peserta didik mampu menganalisis penyebab, instrumen uji, dan langkah perbaikan teknis secara komprehensif.",
            ],
            3 => [
                'stimulus' => "Di era industri modern, integrasi konsep Mindful, Meaningful, dan Joyful (Deep Learning) menuntut lulusan SMK memiliki kemandirian dalam melakukan evaluasi kualitas mandiri (Self-Quality Audit) terhadap produk atau jasa yang dihasilkan.",
                'pertanyaan' => "Jika Anda bertindak sebagai Quality Control (QC) pada pengerjaan {$elemen}, jelaskan kriteria apa saja yang Anda gunakan untuk menyatakan bahwa hasil kerja peserta didik dinyatakan 'TUNTAS / KOMPETEN' sesuai tuntutan dunia usaha dan industri (DUDI)!",
                'kata_kunci' => "Kriteria Mutu DUDI: 1. Presisi dan kesesuaian dimensi terhadap toleransi gambar kerja; 2. Fungsionalitas dan kinerja operasional sistem saat diuji beban; 3. Kerapian estetika (finishing, kebersihan tanpa goresan cacat); 4. Efisiensi durasi kerja terhadap waktu standar (Cycle Time); 5. Kepatuhan mutlak terhadap kaidah K3LH.",
                'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n"
                    . "• Skor 9 - 10: Menyebutkan dan menjelaskan minimal 4 kriteria mutu industri secara analitis (dimensi, fungsi, efisiensi waktu, K3).\n"
                    . "• Skor 6 - 8: Menyebutkan 3 kriteria mutu dengan penjelasan yang cukup relevan dengan kebutuhan dunia kerja.\n"
                    . "• Skor 3 - 5: Hanya menyebutkan 1-2 kriteria dasar secara umum (misal hanya 'alat berfungsi').\n"
                    . "• Skor 1 - 2: Jawaban tidak mencerminkan standar mutu industri kejuruan.\n"
                    . "• Skor 0: Tidak menjawab.",
                'skor_maksimal' => 10,
                'indikator' => "Disajikan peran sebagai Quality Control (QC), peserta didik mampu merumuskan kriteria keberhasilan produk/layanan tuntas berbasis standar DUDI.",
            ],
            4 => [
                'stimulus' => "Perkembangan teknologi otomasi dan digitalisasi saat ini mendorong efisiensi tinggi pada pengerjaan bidang {$mapelNama}. Namun demikian, faktor kompetensi manusia (human factor) dan kebiasaan kerja tetap menjadi penentu utama keberhasilan produksi.",
                'pertanyaan' => "Jelaskan mengapa penerapan prinsip 5S/5R (Ringkas, Rapi, Resik, Rawat, Rajin) di lingkungan kerja kejuruan berhubungan langsung dengan penurunan angka kecelakaan kerja (Zero Accident) dan peningkatan produktivitas bengkel!",
                'kata_kunci' => "Hubungan 5S/5R dengan Zero Accident: 1. Ringkas menyingkirkan benda tidak perlu sehingga tidak menghalangi jalur evakuasi; 2. Rapi memastikan penempatan alat di tempatnya (tidak tersandung / salah ambil alat); 3. Resik menghilangkan tumpahan oli/pelumas yang menyebabkan terpeleset; 4. Rawat menjaga standar keselamatan tetap konsisten; 5. Rajin membentuk disiplin mental dan kesadaran K3 spontan.",
                'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n"
                    . "• Skor 9 - 10: Mengaitkan kelima pilar 5S/5R secara spesifik dengan mitigasi kecelakaan kerja dan efisiensi waktu kerja di bengkel {$mapelNama}.\n"
                    . "• Skor 6 - 8: Menjelaskan 3-4 pilar dengan hubungan sebab-akibat yang cukup jelas.\n"
                    . "• Skor 3 - 5: Menjelaskan definisi 5S saja tanpa menghubungkan secara jelas dengan keselamatan kerja.\n"
                    . "• Skor 1 - 2: Jawaban sangat singkat dan kurang relevan.\n"
                    . "• Skor 0: Tidak menjawab.",
                'skor_maksimal' => 10,
                'indikator' => "Disajikan konsep budaya kerja industri, peserta didik mampu menguraikan korelasi penerapan 5S/5R dengan keselamatan kerja Zero Accident dan efisiensi bengkel vokasi.",
            ],
            5 => [
                'stimulus' => "Dalam pelaksanaan evaluasi berkala, ditemukan bahwa pemakaian bahan baku/material pada salah satu sesi praktik melebihi estimasi anggaran hingga 30% tanpa adanya penambahan jumlah unit produk jadi yang dihasilkan.",
                'pertanyaan' => "Lakukan analisis investigatif untuk mengidentifikasi 3 titik kritis pemborosan (waste) yang mungkin terjadi di bengkel dan rumuskan rekomendasi sistematis untuk menghemat pemakaian bahan pada periode berikutnya!",
                'kata_kunci' => "Titik Kritis Pemborosan: 1. Kesalahan pengukuran/pemotongan awal benda kerja (Scrap/Rework); 2. Prosedur penyimpanan material yang tidak tepat (korosi/rusak sebelum dipakai); 3. Kurangnya pengawasan kalibrasi alat potong. Rekomendasi: Pembuatan cutting plan terencana, uji verifikasi gambar sebelum eksekusi, dan pelatihan pra-praktik.",
                'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n"
                    . "• Skor 9 - 10: Mengidentifikasi 3 titik kritis pemborosan secara nyata dan memberikan 3 rekomendasi aplikatif berbasis efisiensi biaya produksi.\n"
                    . "• Skor 6 - 8: Mengidentifikasi 2 titik kritis dan memberikan solusi yang cukup baik.\n"
                    . "• Skor 3 - 5: Hanya menyebutkan pemborosan tanpa analisis akar masalah dan solusi yang terukur.\n"
                    . "• Skor 1 - 2: Jawaban tidak berdasar pada konteks manajemen bengkel.\n"
                    . "• Skor 0: Lembar kosong.",
                'skor_maksimal' => 10,
                'indikator' => "Disajikan persoalan pemborosan material bengkel vokasi, peserta didik mampu menganalisis 3 titik kritis pemborosan serta merumuskan rekomendasi mitigasi efisiensi biaya secara terukur.",
            ],
        ];

        $templateIndex = (($nomorUrut - 1) % 5) + 1;
        $template = $essayTemplates[$templateIndex];

        return [
            'nomor' => $nomorTampil,
            'nomor_urut' => $nomorUrut,
            'stimulus' => $template['stimulus'],
            'pertanyaan' => $template['pertanyaan'],
            'kata_kunci' => $template['kata_kunci'],
            'pedoman_penskoran' => $template['pedoman_penskoran'],
            'skor_maksimal' => $template['skor_maksimal'],
            'level_kognitif' => $level['label'],
            'indikator_kisi_kisi' => $template['indikator'],
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
