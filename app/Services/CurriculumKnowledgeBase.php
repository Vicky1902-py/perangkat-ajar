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
}
