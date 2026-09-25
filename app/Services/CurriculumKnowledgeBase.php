<?php

namespace App\Services;

use App\Models\KurikulumMateri;
use App\Models\MataPelajaran;
use App\Models\Fase;
use App\Models\CapaianPembelajaran;
use Illuminate\Support\Str;

class CurriculumKnowledgeBase
{
    /**
     * Menentukan domain/kategori mapel secara presisi.
     */
    public static function getSubjectCategory(string $mapelName): string
    {
        $name = strtolower($mapelName);
        if (Str::contains($name, ['matematika', 'kalkulus', 'statistika', 'aljabar', 'geometri'])) return 'matematika';
        if (Str::contains($name, ['koding', 'kecerdasan artifisial', 'ai', 'informatika', 'rekayasa perangkat lunak', 'rpl', 'sistem informasi', 'jaringan komputer', 'tkj', 'cyber', 'komputer'])) return 'informatika_ai';
        if (Str::contains($name, ['indonesia', 'inggris', 'bahasa', 'sastra', 'jepang', 'mandarin', 'arab', 'jerman', 'prancis'])) return 'bahasa';
        if (Str::contains($name, ['sejarah', 'pancasila', 'ppkn', 'agama', 'budi pekerti', 'ips', 'sosiologi', 'geografi', 'ekonomi', 'hukum'])) return 'sosial';
        if (Str::contains($name, ['fisika', 'kimia', 'biologi', 'ipas', 'sains', 'alam'])) return 'sains';
        if (Str::contains($name, ['seni', 'budaya', 'musik', 'tari', 'teater', 'rupa', 'pjok', 'jasmani', 'olahraga', 'kesehatan'])) return 'seni_olahraga';
        return 'kejuruan'; // Default untuk kejuruan (Otomotif, Mesin, Listrik, Akuntansi, Kuliner, dll)
    }

    /**
     * Mengambil atau mensintesis materi kurikulum dari Database (KurikulumMateri).
     */
    public static function getMaterial(mixed $mapel, string $namaElemen, ?string $deskripsiCp = null, ?Fase $fase = null): KurikulumMateri
    {
        $mapelNama = is_object($mapel) ? $mapel->nama : (string)$mapel;
        $mapelId = is_object($mapel) ? $mapel->id : null;

        if (!$mapelId) {
            $mModel = MataPelajaran::where('nama', $mapelNama)->first();
            $mapelId = $mModel?->id;
        }

        // 1. Cari di Database terlebih dahulu
        $query = KurikulumMateri::where('nama_elemen', $namaElemen);
        if ($mapelId) {
            $query->where(function ($q) use ($mapelId, $mapelNama) {
                $q->where('mata_pelajaran_id', $mapelId)->orWhere('nama_mapel', $mapelNama);
            });
        } else {
            $query->where('nama_mapel', $mapelNama);
        }

        $materi = $query->first();
        if ($materi && !empty($materi->rangkuman_materi)) {
            return $materi;
        }

        // 2. Jika deskripsi CP kosong, cari dari tabel capaian_pembelajarans
        if (empty($deskripsiCp) && $mapelId) {
            $cp = CapaianPembelajaran::where('mata_pelajaran_id', $mapelId)->first();
            if ($cp && !empty($cp->elemen_cp)) {
                $elemenArr = json_decode($cp->elemen_cp, true);
                if (is_array($elemenArr) && isset($elemenArr[$namaElemen])) {
                    $deskripsiCp = $elemenArr[$namaElemen];
                } else {
                    $deskripsiCp = $cp->deskripsi_cp;
                }
            }
        }

        // 3. Sintesis materi baru berbasis CP dan simpan otomatis ke Database
        return self::synthesizeAndSaveMaterial($mapelId, $mapelNama, $namaElemen, $deskripsiCp, $fase);
    }

    /**
     * Mensintesis data materi kurikulum berkualitas tinggi dan menyimpannya ke tabel kurikulum_materis.
     */
    private static function synthesizeAndSaveMaterial(?int $mapelId, string $mapelNama, string $namaElemen, ?string $deskripsiCp, ?Fase $fase): KurikulumMateri
    {
        $category = self::getSubjectCategory($mapelNama);
        $cpText = !empty($deskripsiCp) ? $deskripsiCp : "Peserta didik menguasai kompetensi esensial, pemahaman konseptual, dan keterampilan terapan pada elemen $namaElemen sesuai Capaian Pembelajaran regulasi BSKAP No. 046/H/KR/2025.";

        // Ekstraksi topik utama dan sub materi
        $topikUtama = $namaElemen;
        $subMateri = self::generateSubMateriList($category, $mapelNama, $namaElemen, $cpText);

        // Susun Rangkuman Materi Pembelajaran (Bahan Ajar) komprehensif
        $rangkuman = self::generateRangkumanMateri($category, $mapelNama, $namaElemen, $topikUtama, $subMateri, $cpText);

        // Susun Pemahaman Bermakna & Pertanyaan Pemantik
        $pemahamanBermakna = "Memahami dan menguasai {$namaElemen} pada mata pelajaran {$mapelNama} membekali peserta didik dengan kecakapan analitis dan praktis yang relevan dengan standar kurikulum nasional serta tuntutan dunia nyata/industri abad ke-21.";
        $pertanyaanPemantik = "1. Bagaimana prinsip dasar {$namaElemen} memengaruhi keberhasilan pemecahan masalah nyata pada {$mapelNama}?\n2. Mengapa kepatuhan terhadap kaidah dan prosedur pada materi ini menjadi kunci pencapaian kompetensi unggul?";

        // Susun Bank Soal PG (5 butir terstruktur)
        $bankSoalPg = self::generateBankSoalPg($category, $mapelNama, $namaElemen, $subMateri, $cpText);

        // Susun Bank Soal Essay (2 butir terstruktur)
        $bankSoalEssay = self::generateBankSoalEssay($category, $mapelNama, $namaElemen, $subMateri, $cpText);

        return KurikulumMateri::updateOrCreate(
            [
                'mata_pelajaran_id' => $mapelId,
                'nama_elemen' => $namaElemen,
            ],
            [
                'fase_id' => $fase?->id,
                'nama_mapel' => $mapelNama,
                'topik_utama' => $topikUtama,
                'sub_materi' => $subMateri,
                'rangkuman_materi' => $rangkuman,
                'pemahaman_bermakna' => $pemahamanBermakna,
                'pertanyaan_pemantik' => $pertanyaanPemantik,
                'kata_kunci' => [strtolower($namaElemen), strtolower($mapelNama), 'konsep esensial', 'penerapan standar', 'evaluasi kritis'],
                'bank_soal_pg' => $bankSoalPg,
                'bank_soal_essay' => $bankSoalEssay,
                'is_active' => true,
            ]
        );
    }

    /**
     * Menghasilkan daftar sub materi logis berdasarkan CP dan domain mapel.
     */
    public static function generateSubMateriList(string $category, string $mapelNama, string $namaElemen, string $cpText): array
    {
        // 1. Bersihkan teks pembuka CP standar
        $clean = preg_replace('/^(Pada akhir fase [A-F],?\s*)?peserta didik\s+(mampu|dapat|memahami|terampil|menguasai)\s+/iu', '', trim($cpText));
        
        // 2. Pisahkan berdasarkan tanda koma, titik koma, kata hubung 'serta', 'dan'
        $parts = preg_split('/[,;]|\s+serta\s+|\s+dan\s+/iu', $clean);
        $extracted = [];
        
        foreach ($parts as $p) {
            $p = trim($p);
            $p = preg_replace('/^(mampu|dapat|memahami|terampil|menguasai|melakukan|menganalisis|menerapkan|menjelaskan|merancang|membuat)\s+/iu', '', $p);
            $p = trim($p, " \t\n\r\0\x0B.");
            if (strlen($p) >= 6 && strlen($p) <= 80) {
                $extracted[] = Str::title($p);
            }
        }

        $extracted = array_values(array_unique($extracted));

        // Jika berhasil mendapatkan frasa spesifik dari regulasi CP
        if (count($extracted) >= 2) {
            $subMateri = [];
            $subMateri[] = "Konsep Dasar & Prinsip " . ($extracted[0] ?? $namaElemen);
            $subMateri[] = "Prosedur & Analisis " . ($extracted[1] ?? ($extracted[0] ?? $namaElemen));
            $subMateri[] = "Penerapan Terapan " . ($extracted[2] ?? ($extracted[0] ?? $namaElemen));
            $subMateri[] = "Pengujian Mutu & Evaluasi " . ($extracted[3] ?? ($extracted[1] ?? $namaElemen));
            return $subMateri;
        }

        // Fallback domain-spesifik
        if ($category === 'matematika') {
            return [
                "Definisi & Sifat Matematis $namaElemen",
                "Manipulasi Aljabar & Penurunan Rumus $namaElemen",
                "Pemodelan Masalah Kontekstual $namaElemen",
                "Penyelesaian Numerik & Analisis Hasil $namaElemen"
            ];
        } elseif ($category === 'informatika_ai') {
            return [
                "Arsitektur & Konsep Komputasi $namaElemen",
                "Algoritma, Sintaks, & Logika Pemrograman $namaElemen",
                "Implementasi Sistem & Debugging Kode $namaElemen",
                "Pengujian Performa & Keamanan Komputasi $namaElemen"
            ];
        } elseif ($category === 'bahasa') {
            return [
                "Fungsi Komunikatif & Struktur Teks $namaElemen",
                "Kaidah Kebahasaan, Diksi, & Sintaksis $namaElemen",
                "Teknik Analisis Makna & Inferensi Wacana $namaElemen",
                "Produksi Wacana Kritis & Presentasi Ilmiah $namaElemen"
            ];
        } elseif ($category === 'sosial') {
            return [
                "Perspektif Historis & Dinamika Sosial $namaElemen",
                "Analisis Kausalitas & Norma Konstitusional $namaElemen",
                "Kajian Kritis Isu Masyarakat & Kebangsaan $namaElemen",
                "Refleksi Moral & Perumusan Gagasan Solutif $namaElemen"
            ];
        } elseif ($category === 'sains') {
            return [
                "Hukum Alam & Fenomena Ilmiah $namaElemen",
                "Perumusan Hipotesis & Variabel Eksperimen $namaElemen",
                "Analisis Data Pengukuran & Bukti Empiris $namaElemen",
                "Simpulan Saintifik & Dampak Lingkungan $namaElemen"
            ];
        } else {
            return [
                "Standar Teknis & Regulasi K3LH $namaElemen",
                "Standard Operating Procedure (SOP) Praktik $namaElemen",
                "Troubleshooting & Perbaikan Gangguan Sistem $namaElemen",
                "Kendali Mutu (Quality Control) & Hasil Industri $namaElemen"
            ];
        }
    }

    /**
     * Menghasilkan naskah rangkuman materi lengkap (Bahan Ajar) multi-seksi.
     */
    private static function generateRangkumanMateri(string $category, string $mapelNama, string $namaElemen, string $topikUtama, array $subMateri, string $cpText): string
    {
        $header = "MODUL BAHAN AJAR: {$namaElemen} ({$mapelNama})\n"
            . "Regulasi: Keputusan Kepala BSKAP No. 046/H/KR/2025 & Permendikdasmen No. 13 Tahun 2025\n"
            . "Target Capaian Pembelajaran: {$cpText}\n\n";

        $bagian1 = "1. PONDASI TEORETIS DAN KONSEP KUNCI:\n"
            . "Elemen {$namaElemen} merupakan bagian integral dari struktur keilmuan {$mapelNama}. Materi ini menuntut peserta didik memahami hakikat dasar, prinsip operasi, dan batasan teoretis yang berlaku. Pemahaman yang kuat pada tahap ini menjadi prasyarat sebelum melangkah ke analisis komputasional maupun praktikum terapan.\n\n";

        $bagian2 = "2. STRUKTUR KAIDAH DAN ALUR ANALISIS:\n"
            . "Dalam mempelajari {$subMateri[1]}, peserta didik dilatih untuk mengidentifikasi komponen, relasi antar variabel, serta kaidah ilmiah/industri yang baku. Setiap langkah analisis wajib merujuk pada standar prosedur operasional dan literatur kurikulum resmi untuk memastikan akurasi hasil.\n\n";

        $bagian3 = "3. PENERAPAN KONTEKSTUAL & STUDI KASUS:\n"
            . "Aplikasi materi {$topikUtama} diarahkan pada pemecahan tantangan riil di lingkungan masyarakat dan dunia industri. Melalui studi kasus terbimbing, peserta didik mengintegrasikan penalaran kritis untuk merumuskan solusi optimal berbasis data dan fakta empiris.\n\n";

        $bagian4 = "4. STANDAR PENGUJIAN DAN KENDALI MUTU (EVALUASI):\n"
            . "Tahap akhir pembelajaran mencakup pengujian ketercapaian parameter, verifikasi kepatuhan terhadap standar mutu, dan refleksi terhadap proses kerja. Peserta didik dibiasakan melakukan audit mandiri (Self-Reflection) guna menumbuhkan budaya perbaikan berkelanjutan (Continuous Improvement).";

        return $header . $bagian1 . $bagian2 . $bagian3 . $bagian4;
    }

    /**
     * Menghasilkan bank soal PG autentik sesuai materi.
     */
    private static function generateBankSoalPg(string $category, string $mapelNama, string $namaElemen, array $subMateri, string $cpText): array
    {
        $topikUtama = $namaElemen;
        $sub1 = $subMateri[0] ?? $namaElemen;
        $sub2 = $subMateri[1] ?? ($subMateri[0] ?? $namaElemen);
        $sub3 = $subMateri[2] ?? ($subMateri[0] ?? $namaElemen);
        $sub4 = $subMateri[3] ?? ($subMateri[1] ?? $namaElemen);

        $soal = [];

        // Soal 1 (L1 / C1-C2 - Konsep Dasar)
        $soal[] = [
            'stimulus' => "Dalam pembelajaran kompetensi {$namaElemen} pada mata pelajaran {$mapelNama}, peserta didik menganalisis definisi esensial dan kaidah pokok terkait {$sub1}.",
            'pertanyaan' => "Pernyataan yang paling tepat mendeskripsikan prinsip utama dari {$sub1} berdasarkan regulasi kurikulum adalah...",
            'options' => [
                'A' => "Penerapan konsep fundamental dan prosedur sistematis untuk mencapai pemahaman mendalam pada {$namaElemen}.",
                'B' => "Penggunaan estimasi acak tanpa memverifikasi data dan teori dasar keilmuan.",
                'C' => "Pengabaian kaidah keselamatan dan standar teknis yang telah ditetapkan.",
                'D' => "Pemberian asumsi subjektif tanpa pembuktian empiris maupun logis.",
                'E' => "Peniruan langkah kerja tanpa memahami fungsi dan tujuan setiap tahapan."
            ],
            'correct' => 'A',
            'pembahasan' => "Pembelajaran mendalam (Deep Learning) pada {$namaElemen} menekankan penguasaan prinsip konseptual yang diiringi penerapan prosedur sistematis berbasis bukti empiris dan standar baku.",
            'indikator' => "Disajikan konsep dasar {$namaElemen}, peserta didik mampu mengidentifikasi karakteristik dan prinsip pokok {$sub1} dengan tepat."
        ];

        // Soal 2 (L2 / C3 - Prosedural)
        $soal[] = [
            'stimulus' => "Pada saat melaksanakan tahapan kerja terkait materi {$sub2}, seorang peserta didik menemukan deviasi antara hasil analisis dengan standar target kompetensi.",
            'pertanyaan' => "Tindakan metodis pertama yang paling tepat untuk menginvestigasi sumber deviasi pada {$sub2} adalah...",
            'options' => [
                'A' => "Melakukan penelusuran kembali (traceability) terhadap parameter awal dan instrumen yang digunakan sesuai prosedur baku.",
                'B' => "Mengubah data akhir secara manual agar tampak sesuai dengan standar yang diharapkan.",
                'C' => "Menghentikan seluruh aktivitas tanpa melakukan pencatatan pada lembar kerja.",
                'D' => "Mengabaikan deviasi karena dianggap tidak memengaruhi hasil akhir.",
                'E' => "Mengganti topik materi secara sepihak tanpa berdiskusi dengan pendidik."
            ],
            'correct' => 'A',
            'pembahasan' => "Prosedur ilmiah dan profesional menuntut penelusuran kembali (traceability) variabel dan instrumen ukur untuk menemukan akar penyebab masalah secara transparan dan akuntabel.",
            'indikator' => "Disajikan skenario terjadinya deviasi hasil kerja, peserta didik dapat menentukan langkah investigasi prosedural pada {$sub2} secara tepat."
        ];

        // Soal 3 (L3 / C4 - Analitis & Pemecahan Masalah)
        $soal[] = [
            'stimulus' => "Sebuah tim kerja merancang proyek integrasi {$sub3} guna menyelesaikan tantangan efisiensi pada {$mapelNama}. Dalam pelaksanaannya, tim harus menyeimbangkan antara kecepatan pengerjaan dan akurasi mutu.",
            'pertanyaan' => "Strategi optimasi yang paling rasional dan berdaya guna tinggi untuk diterapkan pada tahapan {$sub3} adalah...",
            'options' => [
                'A' => "Menerapkan standarisasi alur kerja (workflow) dengan titik kendali mutu berkala (checkpoint audit) pada setiap fase kritis.",
                'B' => "Mempercepat durasi pengerjaan dengan meniadakan tahap pengujian dan verifikasi data.",
                'C' => "Menyerahkan seluruh pengerjaan kepada satu anggota tim tanpa adanya pembagian peran yang jelas.",
                'D' => "Menurunkan batas toleransi mutu agar seluruh hasil kerja dapat diterima tanpa seleksi.",
                'E' => "Menghilangkan dokumentasi kerja guna menghemat alokasi waktu praktik."
            ],
            'correct' => 'A',
            'pembahasan' => "Keseimbangan antara produktivitas dan kualitas dicapai melalui standarisasi alur kerja terstruktur yang dilengkapi pos pemeriksaan (quality checkpoints) pada tahapan-tahapan penting.",
            'indikator' => "Disajikan dilema efisiensi kerja proyek, peserta didik mampu merumuskan strategi optimasi alur kerja berbasis kendali mutu pada {$sub3}."
        ];

        // Soal 4 (L2 / C3 - Penerapan Standar Mutu)
        $soal[] = [
            'stimulus' => "Dalam pelaksanaan evaluasi mutu kerja pada materi {$sub4}, peserta didik diwajibkan melakukan validasi kesesuaian antara proses pelaksanaan dengan standar target.",
            'pertanyaan' => "Langkah pengujian yang paling efektif untuk memastikan bahwa luaran dari {$sub4} telah memenuhi kriteria keberhasilan adalah...",
            'options' => [
                'A' => "Melakukan pengukuran terstandar menggunakan instrumen kalibrasi dan membandingkannya terhadap rubrik KKTP resmi.",
                'B' => "Mengandalkan perkiraan kasat mata tanpa melakukan pencatatan metrik terukur.",
                'C' => "Meminta persetujuan tanpa melampirkan bukti fisik atau portofolio hasil pengujian.",
                'D' => "Menilai hasil hanya berdasarkan kecepatan waktu penyelesaian semata.",
                'E' => "Menyamakan hasil dengan kelompok lain tanpa memeriksa keaslian data sendiri."
            ],
            'correct' => 'A',
            'pembahasan' => "Validasi mutu yang valid mewajibkan penggunaan instrumen terkalibrasi dan perbandingan langsung terhadap Kriteria Ketercapaian Tujuan Pembelajaran (KKTP).",
            'indikator' => "Disajikan konteks evaluasi hasil belajar, peserta didik dapat menentukan metode validasi mutu pada {$sub4} secara akurat."
        ];

        // Soal 5 (L3 / C5-C6 - HOTS Inovasi & Mitigasi)
        $soal[] = [
            'stimulus' => "Ditemukan sebuah tantangan kompleks di mana penerapan {$namaElemen} pada {$mapelNama} mengalami kendala akibat perubahan parameter lingkungan dan keterbatasan sarana.",
            'pertanyaan' => "Solusi inovatif dan berkelanjutan yang paling tepat dirumuskan oleh peserta didik untuk mengatasi kendala tersebut adalah...",
            'options' => [
                'A' => "Merekayasa pendekatan adaptif dengan memanfaatkan teknologi penunjang dan mendokumentasikan modifikasi prosedur secara sistematis.",
                'B' => "Membatalkan seluruh kegiatan pembelajaran dan menunggu pergantian materi kurikulum.",
                'C' => "Melanggar protokol keselamatan demi menyelesaikan target dalam waktu singkat.",
                'D' => "Menyalahkan keterbatasan sarana tanpa melakukan upaya perbaikan mandiri.",
                'E' => "Mengurangi beban indikator capaian secara sepihak tanpa konsultasi pembimbing."
            ],
            'correct' => 'A',
            'pembahasan' => "Pendekatan inovatif (Joyful & Mindful) menuntut adaptabilitas dan penalaran kritis untuk merekayasa solusi alternatif yang tetap patuh pada standar keselamatan dan mutu.",
            'indikator' => "Disajikan kendala lingkungan, peserta didik mampu merumuskan solusi inovatif dan adaptif pada materi {$namaElemen}."
        ];

        return $soal;
    }

    /**
     * Menghasilkan bank soal Essay autentik sesuai materi.
     */
    private static function generateBankSoalEssay(string $category, string $mapelNama, string $namaElemen, array $subMateri, string $cpText): array
    {
        $sub1 = $subMateri[0] ?? $namaElemen;
        $sub2 = $subMateri[1] ?? ($subMateri[0] ?? $namaElemen);

        return [
            [
                'stimulus' => "Penguasaan elemen '{$namaElemen}' pada mata pelajaran {$mapelNama} memerlukan pemahaman komprehensif mulai dari konsep teoretis ({$sub1}) hingga kemampuan implementasi praktis ({$sub2}).",
                'pertanyaan' => "Uraikan prinsip mendasar dari {$sub1} dan jelaskan bagaimana Anda mengaplikasikannya dalam memecahkan masalah kontekstual pada {$sub2}!",
                'kunci' => "Kriteria Jawaban Tuntas:\n1. Menyebutkan dan menjelaskan prinsip kunci {$sub1} secara runut dan logis.\n2. Memberikan contoh konkret penerapan pada konteks nyata/studi kasus {$sub2}.\n3. Menyertakan analisis dampak positif dari kepatuhan terhadap kaidah tersebut.",
                'pedoman_penskoran' => "Skor 9-10: Penjelasan sangat mendalam, mencakup prinsip dan contoh aplikasi kontekstual yang akurat.\nSkor 6-8: Menjelaskan prinsip dengan baik namun contoh aplikasi masih bersifat umum.\nSkor 3-5: Hanya menyebutkan prinsip tanpa uraian penjelasan yang memadai.\nSkor 1-2: Jawaban tidak berfokus pada materi {$namaElemen}.",
                'indikator' => "Peserta didik mampu menguraikan prinsip dasar materi {$sub1} dan merumuskan strategi aplikasinya secara analitis pada {$sub2}."
            ],
            [
                'stimulus' => "Dalam pelaksanaan kendali mutu dan asesmen akhir pada kompetensi {$namaElemen}, evaluasi berkala diperlukan untuk menjamin keandalan hasil kerja.",
                'pertanyaan' => "Jelaskan langkah-langkah sistematis yang Anda lakukan untuk menguji, memverifikasi, dan mendokumentasikan ketercapaian standar kompetensi pada materi {$namaElemen}!",
                'kunci' => "Langkah kerja: 1) Penyiapan instrumen evaluasi terkalibrasi; 2) Pengujian parameter proses dan luaran; 3) Perbandingan hasil ukur terhadap rubrik KKTP/standar industri; 4) Dokumentasi pada logbook/laporan teknis.",
                'pedoman_penskoran' => "Skor 9-10: Uraian langkah kerja sangat komprehensif, mencakup persiapan, pengujian, audit KKTP, dan pelaporan.\nSkor 6-8: Langkah kerja cukup lengkap namun kurang terinci pada tahap audit.\nSkor 3-5: Hanya menyebutkan 1-2 langkah sederhana.\nSkor 1-2: Jawaban tidak terstruktur.",
                'indikator' => "Peserta didik dapat merumuskan prosedur verifikasi mutu dan pelaporan hasil kerja materi {$namaElemen}."
            ]
        ];
    }

    /**
     * Mengambil paket butir soal Pilihan Ganda (PG) terintegrasi Database.
     */
    public static function getSoalPgData(mixed $mapel, string $elemen, int $index, ?string $deskripsiCp = null): array
    {
        $materi = self::getMaterial($mapel, $elemen, $deskripsiCp);
        $bank = $materi->bank_soal_pg ?? [];

        if (!empty($bank)) {
            $count = count($bank);
            $selected = $bank[(($index - 1) % $count)];
            return [
                'stimulus' => $selected['stimulus'] ?? "Perhatikan studi kasus materi {$elemen} berikut.",
                'pertanyaan' => $selected['pertanyaan'],
                'options' => $selected['options'],
                'correct' => $selected['correct'] ?? 'A',
                'pembahasan' => $selected['pembahasan'] ?? 'Pembahasan mengacu pada kaidah materi resmi.',
                'indikator' => $selected['indikator'] ?? "Peserta didik memahami materi {$elemen} dengan tepat.",
            ];
        }

        // Fallback jika bank kosong
        $sub = $materi->sub_materi[($index - 1) % count($materi->sub_materi ?? [1])] ?? $elemen;
        $mapelNama = is_object($mapel) ? $mapel->nama : (string)$mapel;

        return [
            'stimulus' => "Dalam pengkajian materi {$sub} pada ruang lingkup {$elemen} ({$mapelNama}), peserta didik mengamati penerapan konsep berdasarkan prinsip kurikulum.",
            'pertanyaan' => "Simpulan teoretis yang paling akurat terkait karakteristik materi {$sub} adalah...",
            'options' => [
                'A' => "Menerapkan prinsip ilmiah dan prosedur baku secara konsisten untuk menghasilkan capaian teruji.",
                'B' => "Mengandalkan perkiraan spekulatif tanpa pembuktian data faktual.",
                'C' => "Menghilangkan verifikasi parameter guna mempercepat proses kerja.",
                'D' => "Menggunakan metode yang bertentangan dengan kaidah keilmuan {$mapelNama}.",
                'E' => "Menolak pembaruan data dan standar mutu yang telah ditetapkan."
            ],
            'correct' => 'A',
            'pembahasan' => "Setiap pembelajaran pada {$elemen} mewajibkan ketelitian, kepatuhan prosedur ilmiah, dan pembuktian empiris yang konsisten.",
            'indikator' => "Peserta didik mampu menganalisis karakteristik utama {$sub} secara tepat."
        ];
    }

    /**
     * Mengambil paket butir soal Essay terintegrasi Database.
     */
    public static function getSoalIsianData(mixed $mapel, string $elemen, int $index, ?string $deskripsiCp = null): array
    {
        $materi = self::getMaterial($mapel, $elemen, $deskripsiCp);
        $bank = $materi->bank_soal_essay ?? [];

        if (!empty($bank)) {
            $count = count($bank);
            $selected = $bank[(($index - 1) % $count)];
            return [
                'stimulus' => $selected['stimulus'] ?? "Perhatikan konteks materi {$elemen} berikut ini.",
                'pertanyaan' => $selected['pertanyaan'],
                'kunci' => $selected['kunci'] ?? 'Rubrik acuan jawaban benar.',
                'pedoman_penskoran' => $selected['pedoman_penskoran'] ?? 'Rubrik skor maksimal 10.',
                'indikator' => $selected['indikator'] ?? "Peserta didik dapat menguraikan konsep {$elemen} secara analitis.",
            ];
        }

        $mapelNama = is_object($mapel) ? $mapel->nama : (string)$mapel;
        return [
            'stimulus' => "Dalam pelaksanaan tugas mandiri pada kompetensi {$elemen} ({$mapelNama}), peserta didik dituntut melakukan penalaran kritis.",
            'pertanyaan' => "Jelaskan langkah-langkah komprehensif dalam mengkaji, menganalisis, dan memecahkan persoalan yang berkaitan dengan {$elemen}!",
            'kunci' => "Langkah kerja: 1) Identifikasi masalah dan pengumpulan data awal; 2) Penerapan teori dan formula/metode baku yang relevan; 3) Analisis pengujian dan verifikasi hasil; 4) Perumusan simpulan dan rekomendasi perbaikan.",
            'pedoman_penskoran' => "Rubrik Skor Maksimal 10:\n• Skor 9-10: Langkah-langkah sangat sistematis dan terperinci sesuai kaidah ilmu {$mapelNama}.\n• Skor 6-8: Langkah-langkah cukup runtut namun ada aspek pengujian yang terlewat.\n• Skor 3-5: Menjawab secara singkat tanpa penjelasan metodologis.\n• Skor 1-2: Jawaban tidak relevan.",
            'indikator' => "Peserta didik mampu merumuskan langkah sistematis pemecahan masalah materi {$elemen}."
        ];
    }

    /**
     * Menyusun nama sub-materi kontekstual untuk tabel kisi-kisi soal.
     */
    public static function resolveMateriName(mixed $mapel, string $elemen, int $step): string
    {
        $materi = self::getMaterial($mapel, $elemen);
        $sub = $materi->sub_materi ?? [];
        if (!empty($sub)) {
            $idx = ($step - 1) % count($sub);
            return $sub[$idx];
        }
        return $elemen . " — Sub-kompetensi {$step}";
    }

    /**
     * Mengambil konteks Modul Ajar (TP & ATP) yang terhubung erat ke CP dan Database.
     */
    public static function getModulAjarContext(mixed $mapel, string $namaElemen, ?string $deskripsiCp = null, ?Fase $fase = null): array
    {
        $materi = self::getMaterial($mapel, $namaElemen, $deskripsiCp, $fase);
        $mapelNama = is_object($mapel) ? $mapel->nama : (string)$mapel;
        $category = self::getSubjectCategory($mapelNama);

        // Ekstraksi kata kerja kompetensi dan konten materi nyata
        $tp1Desc = "Peserta didik mampu menganalisis konsep kunci, prinsip kerja, dan struktur teoretis pada materi {$namaElemen} ({$mapelNama}) secara mendalam dan kritis.";
        $tp1Konten = "Konsep dasar, kaidah keilmuan, dan terminologi standar materi {$namaElemen}.";
        $tp1Keterampilan = "Penalaran kritis (Critical Thinking), observasi terstruktur, abstraksi, dan pemahaman konseptual.";
        $tp1Sikap = "Kejujuran akademis, ketelitian, dan rasa ingin tahu ilmiah.";
        $tp1Indikator = "1. Mampu menguraikan prinsip dasar materi {$namaElemen} dengan benar.\n2. Mengidentifikasi hubungan kausalitas dan variabel kunci pada {$namaElemen}.";

        $tp2Desc = "Peserta didik terampil menerapkan, memodelkan, dan mengevaluasi solusi pemecahan masalah kontekstual pada {$namaElemen} sesuai standar operasional yang berlaku.";
        $tp2Konten = "Penerapan terapan, pengujian performa/analisis kasus, dan audit mutu pada {$namaElemen}.";
        $tp2Keterampilan = "Problem solving, unjuk kerja aplikatif, manipulasi data presisi, dan komunikasi hasil kajian.";
        $tp2Sikap = "Tanggung jawab profesional, kemandirian, gotong royong, dan adaptabilitas.";
        $tp2Indikator = "1. Mampu merumuskan solusi terstruktur terhadap studi kasus materi {$namaElemen}.\n2. Melakukan evaluasi dan pengujian hasil kerja secara objektif dan akurat.";

        // Sintaks PEDATTI kontekstual
        $kegiatanAtp = "Alur PEDATTI ({$namaElemen}): (1) Pelajari: Orientasi konsep dasar & stimulasi fenomena riil materi {$namaElemen}, (2) Dalami: Eksplorasi literatur dan bedah kasus kelompok, (3) Terapkan: Unjuk kerja/pemodelan solusi praktis terbimbing, (4) Tularkan: Presentasi pleno dan peer review hasil analisis, (5) Inovasi: Asesmen sumatif pemecahan masalah HOTS dan refleksi mendalam.";

        $sumberBelajar = "Buku Teks {$mapelNama} Kemendikdasmen 2025, Modul Ajar {$namaElemen}, Dokumentasi Regulasi BSKAP 046/2025, dan Referensi Industri/Akademis Terkait.";

        return [
            'materi_model' => $materi,
            'topik_utama' => $materi->topik_utama,
            'sub_materi' => $materi->sub_materi,
            'rangkuman_materi' => $materi->rangkuman_materi,
            'pemahaman_bermakna' => $materi->pemahaman_bermakna,
            'pertanyaan_pemantik' => $materi->pertanyaan_pemantik,
            'tp1_desc' => $tp1Desc,
            'tp1_konten' => $tp1Konten,
            'tp1_keterampilan' => $tp1Keterampilan,
            'tp1_sikap' => $tp1Sikap,
            'tp1_indikator' => $tp1Indikator,
            'tp2_desc' => $tp2Desc,
            'tp2_konten' => $tp2Konten,
            'tp2_keterampilan' => $tp2Keterampilan,
            'tp2_sikap' => $tp2Sikap,
            'tp2_indikator' => $tp2Indikator,
            'kegiatan_atp' => $kegiatanAtp,
            'sumber_belajar' => $sumberBelajar,
            'glosarium' => implode(', ', $materi->sub_materi ?? [$namaElemen]) . ', Standar Kompetensi, Indikator Ketercapaian, Deep Learning.',
            'daftar_pustaka' => "1. Kementerian Pendidikan Dasar dan Menengah. (2025). Keputusan Kepala BSKAP No. 046/H/KR/2025 tentang Capaian Pembelajaran.\n2. Permendikdasmen No. 13 Tahun 2025 tentang Pedoman Kurikulum Nasional.\n3. Buku Panduan Guru & Siswa {$mapelNama} Edisi Revisi Terbaru.",
        ];
    }

    /**
     * Mengambil konteks Lembar Kerja Peserta Didik (LKPD) yang terhubung erat ke CP, ATP, dan Database Materi.
     */
    public static function getLkpdContext(mixed $mapel, string $namaElemen, ?string $deskripsiCp = null, ?Fase $fase = null): array
    {
        $materi = self::getMaterial($mapel, $namaElemen, $deskripsiCp, $fase);
        $mapelNama = is_object($mapel) ? $mapel->nama : (string)$mapel;
        $category = self::getSubjectCategory($mapelNama);
        $sub = $materi->sub_materi ?? [];

        $sub1 = $sub[0] ?? $namaElemen;
        $sub2 = $sub[1] ?? ($sub[0] ?? $namaElemen);
        $sub3 = $sub[2] ?? ($sub[1] ?? $namaElemen);
        $sub4 = $sub[3] ?? ($sub[2] ?? $namaElemen);

        $faseKode = $fase ? $fase->kode : 'E/F';

        // Tentukan stimulus, petunjuk, alat/bahan, dan rubrik sesuai domain mapel
        switch ($category) {
            case 'matematika':
                $stimulus = "Dalam kehidupan sehari-hari dan pemecahan masalah sains/teknologi, konsep {$namaElemen} (khususnya materi {$sub1} dan {$sub2}) memegang peranan krusial. Peserta didik dihadapkan pada situasi kontekstual yang memerlukan pemodelan matematis, abstraksi kuantitatif, kalkulasi presisi, serta pembuktian logis agar keputusan dan solusi yang diambil akurat dan terverifikasi.";
                $petunjuk = "1. Bentuk kelompok kerja kolaboratif beranggotakan 3-4 peserta didik.\n2. Cermati permasalahan kontekstual dan identifikasi variabel yang diketahui maupun ditanyakan.\n3. Susun model matematika, lakukan kalkulasi sistematis, dan uji keabsahan hasil perhitungan.\n4. Diskusikan tafsiran hasil dalam kehidupan nyata dan konsultasikan dengan guru pembimbing jika menemui hambatan.";
                $alatBahan = "Buku Teks Matematika Fase {$faseKode}, Kertas Berpetak/Milimeter Block, Mistar/Busur Geometri, Kalkulator Saintifik / Software Grafis Dinamis (GeoGebra/Spreadsheet), Alat Tulis.";
                $rubrik = "Rubrik Penilaian Proses (Pemahaman Konsep & Penalaran Matematis: 35%)\nRubrik Penilaian Hasil Kerja (Akurasi Model & Kebenaran Kalkulasi: 45%)\nRubrik Refleksi & Komunikasi (Penyampaian Simpulan & Etika Diskusi: 20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Telaah stimulus permasalahan matematis terkait {$namaElemen} di atas bersama kelompok kalian secara kritis.",
                        'pertanyaan' => "1. Uraikan definisi konseptual, sifat dasar, dan variabel utama yang mendasari materi {$sub1}!\n2. Jelaskan kaitan logis antara {$sub1} dan {$sub2} dalam merumuskan penyelesaian masalah!",
                        'ruang_jawaban' => "[Tuliskan identifikasi konsep, variabel (x, y, dll.), serta dalil/sifat matematis dasar di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Rancang model matematika dan lakukan prosedur kalkulasi sistematis untuk studi kasus materi {$sub3}.",
                        'pertanyaan' => "Tuliskan langkah-langkah penyelesaian secara runtut (diketahui, ditanya, model matematika, operasi aljabar/perhitungan hingga hasil akhir), serta buktikan validitas hasil perhitungannya!",
                        'ruang_jawaban' => "[Tuliskan model persamaan/fungsi, langkah pengerjaan terperinci, dan bukti pengujian hasil perhitungan di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Evaluasi proses penalaran matematis kelompok dan tafsirkan makna solusi numerik terhadap situasi riil.",
                        'pertanyaan' => "1. Apakah solusi matematis yang kalian temukan masuk akal dalam konteks nyata? Apa implikasi hasil ini bagi pemecahan masalah?\n2. Hambatan konsep apa yang kalian alami pada materi {$namaElemen} ini dan bagaimana cara memperbaikinya?",
                        'ruang_jawaban' => "[Tuliskan refleksi kritis proses pemecahan masalah dan simpulan kelompok di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            case 'bahasa':
                $stimulus = "Dalam komunikasi lisan dan tulisan, penguasaan struktur teks, kaidah kebahasaan, dan konteks pragmatik pada materi {$namaElemen} (khususnya kajian {$sub1} dan {$sub2}) menjadi sarana penting dalam menyampaikan ide secara bernalar kritis, santun, dan meyakinkan. Peserta didik disajikan teks/wacana autentik untuk dianalisis dan diproduksi sesuai kaidah bahasa baku.";
                $petunjuk = "1. Bentuk kelompok diskusi literasi beranggotakan 3-4 orang.\n2. Baca teks autentik dengan saksama dan tandai kosakata esensial serta struktur kalimatnya.\n3. Diskusikan makna tersurat maupun tersirat dan susun tanggapan kritis secara kolaboratif.\n4. Mintalah masukan dari rekan sejawat (peer review) dan bimbingan guru.";
                $alatBahan = "Buku Teks Bahasa Fase {$faseKode}, Wacana/Artikel Autentik Terpilih, KBBI/Kamus Daring, Lembar Kerja Analisis Teks, Alat Tulis.";
                $rubrik = "Rubrik Penilaian Membaca/Memirsa (Ketepatan Analisis Struktur & Ciri Kebahasaan: 35%)\nRubrik Penilaian Menulis/Berbicara (Koherensi, Diksi, dan Kreativitas Gagasan: 45%)\nRubrik Penilaian Sikap (Apresiasi Bahasa & Kerjasama Kelompok: 20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Cermati teks/wacana autentik yang berkaitan dengan {$namaElemen}, lalu bedah struktur pembangunnya.",
                        'pertanyaan' => "1. Identifikasi gagasan pokok, struktur retorika, dan ciri kebahasaan yang dominan pada materi {$sub1}!\n2. Jelaskan maksud atau nilai kontekstual yang disampaikan penulis melalui aspek {$sub2}!",
                        'ruang_jawaban' => "[Tuliskan struktur teks, konjungsi, diksi kunci, dan interpretasi makna di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Susunlah draf karya teks, tanggapan kritis, atau dialog kontekstual berdasarkan tema materi {$sub3}.",
                        'pertanyaan' => "Tuliskan karya teks/analisis wacana kalian dengan menerapkan kaidah ejaan, kohesi antarkalimat, dan pilihan kata yang efektif sesuai kaidah kebahasaan {$namaElemen}!",
                        'ruang_jawaban' => "[Tuliskan karya/produk bahasa atau telaah kebahasaan kelompok di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Lakukan penyuntingan (editing) silang antarteman dan renungkan manfaat kemampuan berbahasa ini.",
                        'pertanyaan' => "1. Aspek kebahasaan mana yang masih perlu disempurnakan dari karya kalian? Bagaimana masukan dari teman kelompok?\n2. Bagaimana pembelajaran materi {$namaElemen} ini meningkatkan rasa percaya diri dan kemahiran berkomunikasi kalian?",
                        'ruang_jawaban' => "[Tuliskan catatan revisi penyuntingan dan refleksi personal di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            case 'sosial':
                $stimulus = "Dalam kehidupan bermasyarakat, berbangsa, dan bernegara, pemahaman terhadap fenomena, nilai, dan dinamika materi {$namaElemen} (khususnya materi {$sub1} dan {$sub2}) menumbuhkan kesadaran historis, sosial, dan kewarganegaraan. Peserta didik mengkaji sumber data/studi kasus untuk membangun argumen yang berimbang dan berkeadilan.";
                $petunjuk = "1. Bentuk kelompok telaah kasus sosial beranggotakan 3-4 orang.\n2. Cermati sumber informasi/fakta sosial dan bandingkan berbagai sudut pandang yang ada.\n3. Diskusikan solusi atas problematika sosial dengan mengedepankan nilai persatuan dan integritas.\n4. Paparkan kesimpulan kelompok dan mintalah umpan balik.";
                $alatBahan = "Buku Teks Ilmu Sosial Fase {$faseKode}, Kliping Berita/Data Statistik BPS/Dokumen Sejarah, Peta/Infografis Tematik, Lembar Analisis Kasus, Alat Tulis.";
                $rubrik = "Rubrik Penilaian Penguasaan Fakta & Kausalitas Sejarah/Sosial (35%)\nRubrik Penilaian Kritis & Solusi Pemecahan Masalah (45%)\nRubrik Penilaian Karakter Kebangsaan & Sikap Toleransi (20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Bedah sumber data atau narasi peristiwa terkait materi {$namaElemen} bersama kelompok.",
                        'pertanyaan' => "1. Uraikan fakta kunci, latar belakang kronologis/kausalitas, dan konsep dasar pada materi {$sub1}!\n2. Analisis bagaimana materi {$sub2} memengaruhi tatanan sosial, ekonomi, atau kebangsaan pada masa itu hingga masa kini!",
                        'ruang_jawaban' => "[Tuliskan kronologi fakta, faktor penyebab, dan hubungan sebab-akibat di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Rumuskan kajian kritis dan rekomendasi solusi atas permasalahan nyata yang berkaitan dengan {$sub3}.",
                        'pertanyaan' => "Susunlah argumen tertulis berbasis bukti data empiris dan nilai luhur Pancasila untuk menyikapi problematika materi di atas!",
                        'ruang_jawaban' => "[Tuliskan esai analisis kritis, argumentasi berbasis data, dan alternatif solusi di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Refleksikan makna nilai-nilai yang dipelajari terhadap pembentukan karakter diri sebagai warga negara.",
                        'pertanyaan' => "1. Nilai moral, kearifan sosial, atau keteladanan apa yang dapat diambil dari materi {$namaElemen} ini?\n2. Tindakan nyata apa yang dapat kalian wujudkan dalam kehidupan sehari-hari sebagai cerminan pemahaman materi ini?",
                        'ruang_jawaban' => "[Tuliskan refleksi moral, keteladanan, dan komitmen aksi nyata di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            case 'sains':
                $stimulus = "Pengamatan terhadap gejala alam dan teknologi menuntut pemahaman ilmiah berbasis hukum serta prinsip materi {$namaElemen} (khususnya {$sub1} dan {$sub2}). Melalui penyelidikan ilmiah terstruktur, peserta didik dilatih mengumpulkan data empiris, menganalisis variabel penelitian, serta menguji hipotesis secara objektif.";
                $petunjuk = "1. Bentuk kelompok praktikum sains beranggotakan 3-4 orang dengan pembagian peran yang jelas.\n2. Patuhi keselamatan kerja laboratorium (K3) dan persiapkan instrumen pengukuran.\n3. Lakukan pengamatan/percobaan secara teliti, catat data hasil ukur tanpa memanipulasi angka.\n4. Olah data ke dalam tabel/grafik dan rumuskan simpulan ilmiah.";
                $alatBahan = "Buku Panduan Eksperimen Sains Fase {$faseKode}, Kit Percobaan/Alat Ukur Sains Terkalibrasi, Lembar Observasi Data Praktikum, APD Praktikum (Jas Lab/Sarung Tangan), Alat Tulis.";
                $rubrik = "Rubrik Keterampilan Proses Sains & K3 Laboratorium (35%)\nRubrik Analisis Data & Validitas Simpulan Eksperimen (45%)\nRubrik Sikap Ilmiah (Jujur, Teliti, & Bekerjasama: 20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Kaji landasan teori sains dan rancang hipotesis percobaan terkait materi {$namaElemen}.",
                        'pertanyaan' => "1. Jelaskan hukum/prinsip ilmiah dasar yang mengatur fenomena pada materi {$sub1}!\n2. Tentukan variabel bebas, variabel terikat, dan variabel kontrol dalam penyelidikan {$sub2}!",
                        'ruang_jawaban' => "[Tuliskan konsep hukum sains, rumusan hipotesis awal, dan matriks variabel uji di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Lakukan prosedur eksperimen atau analisis data kuantitatif materi {$sub3} secara sistematis.",
                        'pertanyaan' => "Sajikan tabel data hasil pengamatan, olah perhitungan ralat/analisis grafik, dan jelaskan kecenderungan pola data empiris yang diperoleh!",
                        'ruang_jawaban' => "[Lampirkan tabel data percobaan, perhitungan rumus ilmiah, dan grafik interpretasi data di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Bandingkan kesesuaian data praktikum dengan teori baku dan evaluasi faktor ketidakpastian eksperimen.",
                        'pertanyaan' => "1. Apakah temuan eksperimen kalian sesuai dengan hipotesis awal? Faktor apa yang menyebabkan selisih/galat pengukuran?\n2. Bagaimana prinsip sains pada {$namaElemen} ini dapat dimanfaatkan untuk memecahkan masalah lingkungan atau kehidupan sekitar?",
                        'ruang_jawaban' => "[Tuliskan simpulan ilmiah, analisis sumber kesalahan praktikum, dan gagasan aplikasi praktis di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            case 'informatika_ai':
                $stimulus = "Dalam transformasi teknologi dan era komputasi modern, penguasaan kompetensi materi {$namaElemen} (khususnya {$sub1} dan {$sub2}) menjadi fondasi pengembangan solusi perangkat lunak dan keandalan sistem digital. Peserta didik ditantang memecahkan permasalahan nyata melalui berpikir komputasional, perancangan algoritma efisien, dan penerapan standar teknologi terkini.";
                $petunjuk = "1. Bentuk tim pengembang proyek (developer team) beranggotakan 3-4 orang.\n2. Pahami spesifikasi kebutuhan kasus (use case) dan susun dekomposisi masalah komputasi.\n3. Rancang logika alur, implementasikan algoritma/kode, dan lakukan pengujian sistem (debugging/testing).\n4. Dokumentasikan arsitektur solusi dan lakukan presentasi kode (code review).";
                $alatBahan = "PC/Laptop dengan Editor/IDE Pemrograman, Emulator/Simulator Lingkungan Sistem, Repositori/Platform Kolaborasi Kode, Lembar Desain Algoritma, Koneksi Jaringan.";
                $rubrik = "Rubrik Berpikir Komputasional & Perancangan Arsitektur (35%)\nRubrik Implementasi & Akurasi Pengujian Sistem (45%)\nRubrik Dokumentasi Teknis & Kerjasama Tim (20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Dekomposisi spesifikasi masalah komputasi terkait {$namaElemen} bersama tim pengembang.",
                        'pertanyaan' => "1. Uraikan komponen logika utama, struktur data, dan konsep arsitektur pada materi {$sub1}!\n2. Identifikasi potensi bottleneck performa atau kerentanan logika yang mungkin muncul pada implementasi {$sub2}!",
                        'ruang_jawaban' => "[Tuliskan dekomposisi masalah, pemodelan data/entitas, dan rancangan arsitektur logika di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Konstruksikan algoritma solusi dan uji fungsionalitas sistem pada materi {$sub3}.",
                        'pertanyaan' => "Tuliskan pseudocode/diagram alir, potongan skrip implementasi program/konfigurasi, serta tabel hasil uji coba (test cases) untuk kasus normal maupun ekstrem!",
                        'ruang_jawaban' => "[Tuliskan flowchart/pseudocode, cuplikan kode terstruktur, dan tabel pengujian input-output di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Evaluasi efisiensi kompleksitas algoritma dan integrasikan etika teknologi serta keamanan digital.",
                        'pertanyaan' => "1. Sejauh mana efisiensi dan keandalan sistem yang kalian buat? Apa peluang optimasi refactoring yang dapat dilakukan?\n2. Nilai integritas, ketelitian, dan daya nalar apa yang terasah saat menuntaskan proyek materi {$namaElemen} ini?",
                        'ruang_jawaban' => "[Tuliskan evaluasi teknis, efisiensi waktu komputasi, dan refleksi etika rekayasa perangkat lunak di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            case 'seni_olahraga':
                $stimulus = "Apresiasi estetika, penghayatan rasa, dan penguasaan teknik gerak tubuh pada materi {$namaElemen} (khususnya materi {$sub1} dan {$sub2}) menumbuhkan kebugaran, kedisiplinan gerak, serta kepekaan artistik yang harmonis. Peserta didik dilatih mengeksplorasi teknik dasar dan mempraktikkannya dalam unjuk keterampilan yang proporsional.";
                $petunjuk = "1. Bentuk kelompok latihan gerak/karya beranggotakan 3-4 orang.\n2. Lakukan pemanasan terstruktur (stretching/vocal/warming-up) demi mencegah cedera.\n3. Lakukan eksplorasi gerak/karya secara bertahap dengan saling mengamati dan memberi umpan balik konstruktif.\n4. Catat capaian latihan pada lembar unjuk kerja dan lakukan pendinginan.";
                $alatBahan = "Buku Panduan Praktik PJOK/Seni Fase {$faseKode}, Sarana Olahraga/Instrumen Musik/Media Seni Rupa Standar, Pakaian Olahraga/Praktik, Rubrik Observasi Gerak, Alat Dokumentasi.";
                $rubrik = "Rubrik Penguasaan Teknik Dasar & Kepatuhan Prosedur (35%)\nRubrik Unjuk Kerja, Ketangkasan & Harmonisasi Penampilan (45%)\nRubrik Sportivitas, Disiplin, dan Penghayatan Nilai (20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Pelajari prinsip anatomi/estetika dan mekanisme tahapan teknik pada materi {$namaElemen}.",
                        'pertanyaan' => "1. Uraikan teknik dasar, kaidah biomekanika / unsur pembentuk karya yang menjadi fondasi pada materi {$sub1}!\n2. Jelaskan kesalahan umum (common mistakes) yang sering terjadi saat mengeksekusi {$sub2} serta langkah antisipasinya!",
                        'ruang_jawaban' => "[Tuliskan analisis biomekanika/estetika teknik dasar dan pencegahan kesalahan gerak di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Praktikkan kombinasi rangkaian gerak atau ciptaan karya materi {$sub3} dengan intensitas terukur.",
                        'pertanyaan' => "Lakukan latihan terpadu bersama pasangan/kelompok, dokumentasikan repetisi/irama gerak, dan catat indikator ketercapaian unjuk kerja teknis!",
                        'ruang_jawaban' => "[Tuliskan jurnal sesi latihan, catatan repetisi gerak/komposisi karya, dan tabel observasi pasangan di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Evaluasi kebugaran fisik / nilai keindahan karya serta internalisasi nilai sportivitas kelompok.",
                        'pertanyaan' => "1. Bagaimana akurasi teknik dan kenyamanan gerak/karya yang kalian rasakan saat mempraktikkan materi {$namaElemen}?\n2. Karakter sportivitas, daya juang pantang menyerah, dan respek apa yang tumbuh selama latihan?",
                        'ruang_jawaban' => "[Tuliskan refleksi performa fisik/artistik dan internalisasi nilai sportivitas di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;

            default: // kejuruan (SMK)
                $stimulus = "Dalam lingkungan kerja industri profesional, kepatuhan terhadap Standar Operasional Prosedur (SOP) dan penguasaan keahlian materi {$namaElemen} (terutama materi {$sub1} dan {$sub2}) menentukan keselamatan kerja, keandalan operasional, dan kepuasan pelanggan. Teknisi/praktisi dituntut mampu mendiagnosis kondisi, melakukan penanganan terstandar, dan memastikan kualitas produk sesuai standar industri.";
                $petunjuk = "1. Bentuk tim teknisi bengkel/studio kerja beranggotakan 3-4 orang dengan jobdesc terstruktur.\n2. Kenakan Alat Pelindung Diri (APD) lengkap dan patuhi kaidah K3LH sebelum memulai pekerjaan.\n3. Periksa kondisi instrumen kerja, gunakan manual panduan teknis, dan ikuti langkah kerja pada lembar kerja (Job Sheet).\n4. Lakukan penjaminan mutu (Quality Control) dan kembalikan peralatan sesuai prinsip 5R/5S.";
                $alatBahan = "Alat Pelindung Diri (APD K3LH), Toolkit / Peralatan Praktik Kejuruan Terstandar, Manual Book / Service Guide / Dokumen Transaksi, Job Sheet Praktikum, Lembar Kalibrasi.";
                $rubrik = "Rubrik Kepatuhan K3LH & Kesiapan Alat Bahan (30%)\nRubrik Presisi Prosedur Pengerjaan & Ketelitian Pengukuran (50%)\nRubrik Budaya Kerja 5R & Etika Profesional (20%)";
                $stages = [
                    [
                        'tahap' => 'memahami',
                        'instruksi' => "Pelajari petunjuk manual dan identifikasi potensi bahaya kerja terkait materi {$namaElemen}.",
                        'pertanyaan' => "1. Sebutkan spesifikasi peralatan, instrumen ukur, dan APD wajib untuk mengerjakan kompetensi {$sub1}!\n2. Jelaskan alur prosedur diagnosis awal atau langkah pemeriksaan standar pada materi {$sub2}!",
                        'ruang_jawaban' => "[Tuliskan daftar peralatan K3LH, spesifikasi teknis komponen, dan alur SOP pemeriksaan di sini...]",
                        'urutan' => 1,
                    ],
                    [
                        'tahap' => 'mengaplikasi',
                        'instruksi' => "Laksanakan prosedur pengerjaan/servis/produksi pada materi {$sub3} sesuai standar operasional yang berlaku.",
                        'pertanyaan' => "Catat hasil pengukuran parameter toleransi dengan alat ukur presisi, tuliskan rincian langkah kerja, dan dokumentasikan hasil uji fungsi akhir sistem/produk!",
                        'ruang_jawaban' => "[Lampirkan tabel data pengukuran toleransi, checklist verifikasi komponen, dan bukti uji fungsi di sini...]",
                        'urutan' => 2,
                    ],
                    [
                        'tahap' => 'merefleksi',
                        'instruksi' => "Lakukan audit penjaminan mutu produk dan evaluasi penerapan budaya industri (5R/5S).",
                        'pertanyaan' => "1. Apakah produk/hasil perbaikan kalian memenuhi batas toleransi teknis yang disyaratkan? Bagian mana yang membutuhkan penyempurnaan?\n2. Bagaimana efektivitas penerapan budaya kerja 5R (Ringkas, Rapi, Resik, Rawat, Rajin) selama penuntasan kompetensi {$namaElemen} ini?",
                        'ruang_jawaban' => "[Tuliskan lembar evaluasi QC, catatan tindak lanjut perbaikan, dan refleksi budaya industri di sini...]",
                        'urutan' => 3,
                    ],
                ];
                break;
        }

        return [
            'materi_model' => $materi,
            'stimulus' => $stimulus,
            'petunjuk' => $petunjuk,
            'alat_bahan' => $alatBahan,
            'rubrik' => $rubrik,
            'stages' => $stages,
        ];
    }
}

