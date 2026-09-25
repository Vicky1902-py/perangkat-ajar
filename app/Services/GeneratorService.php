<?php

namespace App\Services;

use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\AtpDetail;
use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\Lkpd;
use App\Models\LkpdKegiatan;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\ModulAjarKegiatan;
use App\Models\ProfilLulusan;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\TahunAjaran;
use App\Models\TemplatePedatti;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GeneratorService
{
    /**
     * Generate all teaching tools in one single click
     */
    public function generateAll(array $params, ?User $user = null): array
    {
        return DB::transaction(function () use ($params, $user) {
            $userId = $user?->id;
            $sessionId = $user ? null : ($params['guest_session_id'] ?? (session()->isStarted() ? session()->getId() : 'guest_' . uniqid()));

            $cp = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->findOrFail($params['capaian_pembelajaran_id']);
            $mapel = $cp->mataPelajaran;
            $fase = $cp->fase;

            $tahunAjaran = !empty($params['tahun_ajaran_id']) 
                ? TahunAjaran::find($params['tahun_ajaran_id']) 
                : TahunAjaran::where('is_active', true)->first();

            $elemenCp = json_decode($cp->elemen_cp, true) ?? [];
            if (empty($elemenCp)) {
                $elemenCp = [
                    'Kompetensi Inti' => $cp->deskripsi_cp
                ];
            }

            // 1. GENERATE TUJUAN PEMBELAJARAN (TP) MENGGUNAKAN KNOWLEDGE BASE
            $createdTps = [];
            $index = 1;
            $jpDefault = str_starts_with($mapel->nama, 'Dasar-dasar ') ? 12 : ($mapel->kelompok === 'kejuruan' ? 18 : 8);

            foreach ($elemenCp as $namaElemen => $deskripsiElemen) {
                // Ambil konteks pakar dari Knowledge Base yang terhubung ke Database
                $kb = \App\Services\CurriculumKnowledgeBase::getModulAjarContext($mapel, $namaElemen, $deskripsiElemen, $fase);

                // TP 1: Pemahaman Konsep (Sesuai Kategori Mapel)
                $kodeTp1 = 'TP.' . $fase->kode . '.' . str_pad($index, 2, '0', STR_PAD_LEFT);
                $tp1 = TujuanPembelajaran::create([
                    'capaian_pembelajaran_id' => $cp->id,
                    'user_id' => $userId,
                    'guest_session_id' => $sessionId,
                    'kode_tp' => $kodeTp1,
                    'elemen' => $namaElemen,
                    'deskripsi_tp' => $kb['tp1_desc'],
                    'konten_pengetahuan' => $kb['tp1_konten'],
                    'keterampilan' => $kb['tp1_keterampilan'],
                    'sikap' => $kb['tp1_sikap'],
                    'indikator_ketercapaian' => $kb['tp1_indikator'],
                    'urutan' => $index,
                ]);
                $createdTps[] = $tp1;
                $index++;

                // TP 2: Penerapan/Praktik/Pemecahan Masalah (Sesuai Kategori Mapel)
                $kodeTp2 = 'TP.' . $fase->kode . '.' . str_pad($index, 2, '0', STR_PAD_LEFT);
                $tp2 = TujuanPembelajaran::create([
                    'capaian_pembelajaran_id' => $cp->id,
                    'user_id' => $userId,
                    'guest_session_id' => $sessionId,
                    'kode_tp' => $kodeTp2,
                    'elemen' => $namaElemen,
                    'deskripsi_tp' => $kb['tp2_desc'],
                    'konten_pengetahuan' => $kb['tp2_konten'],
                    'keterampilan' => $kb['tp2_keterampilan'],
                    'sikap' => $kb['tp2_sikap'],
                    'indikator_ketercapaian' => $kb['tp2_indikator'],
                    'urutan' => $index,
                ]);
                $createdTps[] = $tp2;
                $index++;
            }

            // 2. GENERATE ALUR TUJUAN PEMBELAJARAN (ATP) SESUAI BSKAP 046/H/KR/2025
            $atp = AlurTujuanPembelajaran::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'judul' => 'ATP ' . $mapel->nama . ' - Fase ' . $fase->kode . ' (Keputusan BSKAP No. 046/H/KR/2025)',
                'regulasi' => 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025',
                'total_alokasi_jp' => 0,
                'deskripsi' => 'Alur Tujuan Pembelajaran (ATP) resmi berdasarkan Keputusan Kepala BSKAP Nomor 046/H/KR/2025 (merevisi Nomor 032/H/KR/2024) dan Permendikdasmen No. 13 Tahun 2025. Disusun secara runtut, logis, dan terpadu berbasis pendekatan Pembelajaran Mendalam (Deep Learning: Mindful, Meaningful, Joyful) serta Kerangka Sintaks PEDATTI.',
            ]);

            $dimensiList = ProfilLulusan::pluck('dimensi')->toArray();
            $dimensiCount = count($dimensiList);
            $totalJpCalc = 0;

            foreach ($createdTps as $idx => $tp) {
                $dimensiSample = [];
                if ($dimensiCount > 0) {
                    $dimensiSample[] = $dimensiList[$idx % $dimensiCount];
                    $dimensiSample[] = $dimensiList[($idx + 2) % $dimensiCount];
                    $dimensiSample[] = 'Penalaran Kritis';
                }
                $dimensiSample = array_unique($dimensiSample);

                $jpItem = ($idx % 2 === 0) ? intval($jpDefault * 0.4) : intval($jpDefault * 0.6);
                if ($jpItem < 4) { $jpItem = 4; }
                $totalJpCalc += $jpItem;

                $kbAtp = \App\Services\CurriculumKnowledgeBase::getModulAjarContext($mapel, $tp->elemen ?? '', null, $fase);
                $subMateriName = \App\Services\CurriculumKnowledgeBase::resolveMateriName($mapel, $tp->elemen ?? $mapel->nama, $idx + 1);

                AtpDetail::create([
                    'atp_id' => $atp->id,
                    'tujuan_pembelajaran_id' => $tp->id,
                    'urutan' => $idx + 1,
                    'materi_topik' => $subMateriName . ' (' . $tp->kode_tp . ')',
                    'kegiatan_pembelajaran' => $kbAtp['kegiatan_atp'],
                    'asesmen' => 'Asesmen Awal: Kuis diagnostik pemetaan kompetensi. Asesmen Formatif: Observasi proses & umpan balik deskriptif. Asesmen Sumatif: Uji pemecahan masalah / unjuk kerja berstandar.',
                    'indikator_asesmen' => $tp->indikator_ketercapaian,
                    'sumber_belajar' => $kbAtp['sumber_belajar'],
                    'alokasi_waktu_jp' => $jpItem,
                    'dimensi_profil_lulusan' => implode(', ', $dimensiSample),
                ]);
            }

            $atp->update(['total_alokasi_jp' => $totalJpCalc]);

            // 3. GENERATE MODUL AJAR (PEDATTI & DEEP LEARNING)
            $firstTp = $createdTps[0] ?? null;
            $firstElemen = $firstTp?->elemen ?? (array_key_first($elemenCp) ?: $mapel->nama);
            $firstDeskripsi = $elemenCp[$firstElemen] ?? $cp->deskripsi_cp;
            $kbModul = \App\Services\CurriculumKnowledgeBase::getModulAjarContext($mapel, $firstElemen, $firstDeskripsi, $fase);

            $modulAjar = ModulAjar::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'tujuan_pembelajaran_id' => $firstTp?->id,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'judul' => 'Modul Ajar: ' . $firstElemen . ' - ' . $mapel->nama . ' (' . ($firstTp ? $firstTp->kode_tp : 'Fase ' . $fase->kode) . ')',
                'kompetensi_awal' => 'Peserta didik memahami konsep dasar dan prasyarat keilmuan pada materi ' . $firstElemen . ' (' . $mapel->nama . ').',
                'profil_lulusan_target' => 'Penalaran Kritis, Kreativitas, Kolaborasi, Kemandirian, dan Komunikasi (Permendikdasmen No. 10/2025).',
                'sarana_prasarana' => $kbModul['sumber_belajar'] . ', Perangkat Komputer/Laptop, Akses Internet, Proyektor, dan Modul Ajar Terkait.',
                'target_peserta_didik' => 'Peserta didik reguler/tipikal, dengan fasilitas pengayaan bagi yang cepat paham dan bimbingan terarah bagi yang memerlukan pendampingan.',
                'pemahaman_bermakna' => $kbModul['pemahaman_bermakna'],
                'pertanyaan_pemantik' => $kbModul['pertanyaan_pemantik'],
                'asesmen_awal' => 'Kuis diagnostik 5 butir soal pilihan ganda interaktif dan wawancara singkat pemetaan kompetensi ' . $firstElemen . '.',
                'asesmen_formatif' => 'Penilaian unjuk kerja selama tahapan Terapkan dan Tularkan menggunakan rubrik observasi ' . $firstElemen . '.',
                'asesmen_sumatif' => 'Tes tertulis pilihan ganda/uraian (Smart Soal) materi ' . $firstElemen . ' dan penugasan proyek terukur skala 1-100.',
                'refleksi_guru' => "1. Apakah seluruh peserta didik mencapai tujuan pembelajaran materi {$firstElemen} dengan gembira (Joyful)?\n2. Bagian mana dari tahapan PEDATTI yang membutuhkan alokasi waktu tambahan?",
                'refleksi_siswa' => "1. Apa hal paling menarik dan bermakna yang saya pelajari dari materi {$firstElemen} hari ini?\n2. Kendala apa yang saya hadapi dan bagaimana saya mengatasinya?",
                'pengayaan' => 'Tantangan eksplorasi implementasi tingkat lanjut (HOTS) terkait ' . $firstElemen . '.',
                'remedial' => 'Pendampingan khusus dan tutor sebaya dengan fokus pada rekonstruksi konsep ' . $firstElemen . ' yang belum tuntas.',
                'bahan_ajar' => $kbModul['rangkuman_materi'],
                'glosarium' => $kbModul['glosarium'],
                'daftar_pustaka' => $kbModul['daftar_pustaka'],
                'alokasi_waktu_jp' => $jpDefault,
                'jumlah_pertemuan' => 3,
            ]);

            // Hubungkan profil lulusan ke modul ajar (8 dimensi)
            $allProfil = ProfilLulusan::take(5)->pluck('id');
            $modulAjar->profilLulusans()->sync($allProfil);

            // Buat 5 Kegiatan PEDATTI dengan Konten Riil
            $subMateriArr = $kbModul['sub_materi'] ?? [$firstElemen];
            $subSample1 = $subMateriArr[0] ?? $firstElemen;
            $subSample2 = $subMateriArr[1] ?? ($subMateriArr[0] ?? $firstElemen);

            $pedattiTemplates = TemplatePedatti::where('is_active', true)->get();
            $tahapOrder = ['pendahuluan' => 1, 'dalami' => 2, 'terapkan' => 3, 'tularkan' => 4, 'inovasi' => 5];

            $pedattiDescriptions = [
                'pendahuluan' => "Tahap Pelajari (Orientasi & Apersepsi):\n• Guru membuka pembelajaran dengan salam, doa bersama, dan presensi (Mindful).\n• Apersepsi: Menampilkan stimulus kontekstual materi {$firstElemen} dan mendiskusikan pertanyaan pemantik.\n• Menyampaikan tujuan pembelajaran, dimensi profil lulusan yang dikembangkan, dan alur sintaks PEDATTI.",
                'dalami' => "Tahap Dalami (Eksplorasi Konsep & Bedah Teori):\n• Peserta didik mengkaji modul bahan ajar materi {$firstElemen} secara berkelompok (Meaningful).\n• Mendiskusikan konsep kunci: {$subSample1} dan {$subSample2}.\n• Guru memfasilitasi tanya jawab kritis dan memberikan penguatan konsep esensial.",
                'terapkan' => "Tahap Terapkan (Aplikasi, Simulasi & Praktik Mandiri):\n• Peserta didik mengerjakan Lembar Kerja (LKPD) / instrumen kerja terkait studi kasus {$firstElemen}.\n• Melakukan perhitungan, analisis data, atau praktikum terarah menggunakan media/alat standar.\n• Guru melakukan asesmen formatif proses menggunakan rubrik observasi keaktifan dan ketelitian.",
                'tularkan' => "Tahap Tularkan (Kolaborasi, Presentasi & Peer Review):\n• Setiap perwakilan kelompok mempresentasikan hasil pemecahan masalah/analisis materi {$firstElemen} di depan kelas.\n• Kelompok lain memberikan tanggapan, pertanyaan kritis, dan umpan balik konstruktif (Peer Review).\n• Guru dan peserta didik menyimpulkan pokok-pokok penting materi pembelajaran.",
                'inovasi' => "Tahap Inovasi (Evaluasi Sumatif & Refleksi Mendalam):\n• Peserta didik menyelesaikan asesmen sumatif kuis/soal evaluasi untuk mengukur penguasaan individu (Joyful).\n• Melakukan refleksi pembelajaran 3M (Mindful, Meaningful, Joyful) terhadap pencapaian kompetensi.\n• Guru memberikan tindak lanjut pengayaan/remedial dan menutup sesi dengan apresiasi.",
            ];

            foreach ($tahapOrder as $tahap => $urutan) {
                $template = $pedattiTemplates->firstWhere('tahap', $tahap);
                ModulAjarKegiatan::create([
                    'modul_ajar_id' => $modulAjar->id,
                    'tahap_pedatti' => $tahap,
                    'deskripsi_kegiatan' => $pedattiDescriptions[$tahap] ?? ($template ? $template->template_kegiatan : 'Aktivitas belajar tahap ' . ucfirst($tahap)),
                    'durasi_menit' => $template?->durasi_default_menit ?? 30,
                    'prinsip_deep_learning' => $template?->prinsip_deep_learning ?? 'Mindful & Meaningful',
                    'olah' => $template?->olah ?? 'Olah Pikir',
                    'urutan' => $urutan,
                ]);
            }

            // 4. GENERATE LEMBAR KERJA PESERTA DIDIK (LKPD)
            $lkpd = Lkpd::create([
                'modul_ajar_id' => $modulAjar->id,
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'judul' => 'LKPD Deep Learning: ' . $firstElemen . ' (' . ($firstTp ? $firstTp->kode_tp : 'Fase ' . $fase->kode) . ')',
                'tujuan_pembelajaran' => $firstTp ? $firstTp->deskripsi_tp : 'Mencapai kompetensi esensial fase ' . $fase->kode,
                'stimulus_otentik' => "Dalam rangka penguasaan kompetensi materi {$firstElemen} pada mata pelajaran {$mapel->nama}, peserta didik dihadapkan pada studi kasus kontekstual untuk menganalisis parameter, merancang alur penyelesaian masalah, dan memverifikasi simpulan sesuai kaidah kurikulum resmi Kemendikdasmen.",
                'petunjuk_belajar' => "1. Bentuk kelompok kerja beranggotakan 3-4 orang secara kolaboratif.\n2. Baca dengan saksama stimulus otentik dan instruksi setiap tahapan.\n3. Lakukan pengujian/analisis dan dokumentasikan langkah kerja kalian.\n4. Konsultasikan dengan guru pembimbing apabila menemui kendala teknis.",
                'alat_bahan' => $kbModul['sumber_belajar'] . ', PC/Laptop, Perangkat Lunak Praktikum, Lembar Kerja Kerja / Buku Catatan Teknis.',
                'rubrik_penilaian' => "Rubrik Penilaian Proses (Keaktifan & Kerjasama: 30%)\nRubrik Penilaian Produk/Hasil Praktik (Akurasi & Standar Teknis: 50%)\nRubrik Refleksi & Presentasi (Komunikasi & Etika: 20%)",
                'alokasi_waktu_menit' => 90,
            ]);

            // 3 Tahap Kerja LKPD (Memahami, Mengaplikasi, Merefleksi)
            $lkpdStages = [
                [
                    'tahap' => 'memahami',
                    'instruksi' => 'Diskusikan bersama kelompok mengenai permasalahan pada stimulus otentik di atas.',
                    'pertanyaan' => 'Identifikasi minimal 3 faktor utama penyebab masalah tersebut dan jelaskan konsep dasar yang relevan untuk menanganinya!',
                    'ruang_jawaban' => '[Tuliskan hasil identifikasi dan analisis konsep di sini...]',
                    'urutan' => 1,
                ],
                [
                    'tahap' => 'mengaplikasi',
                    'instruksi' => 'Rancang dan lakukan prosedur pemecahan masalah sesuai standar operasional industri.',
                    'pertanyaan' => 'Dokumentasikan langkah kerja praktikum, kode program/diagram konfigurasi, serta bukti hasil uji coba sistem!',
                    'ruang_jawaban' => '[Lampirkan dokumentasi konfigurasi, tangkapan layar hasil, atau ringkasan pengujian di sini...]',
                    'urutan' => 2,
                ],
                [
                    'tahap' => 'merefleksi',
                    'instruksi' => 'Lakukan evaluasi diri secara jujur terhadap seluruh proses belajar dan kerja kelompok kalian.',
                    'pertanyaan' => 'Apa nilai karakter Profil Lulusan yang paling kalian rasakan berkembang selama praktikum ini? Apa yang akan kalian perbaiki pada tugas berikutnya?',
                    'ruang_jawaban' => '[Tuliskan refleksi pribadi dan kelompok secara mendalam...]',
                    'urutan' => 3,
                ],
            ];

            foreach ($lkpdStages as $stg) {
                LkpdKegiatan::create([
                    'lkpd_id' => $lkpd->id,
                    'tahap' => $stg['tahap'],
                    'instruksi' => $stg['instruksi'],
                    'pertanyaan' => $stg['pertanyaan'],
                    'ruang_jawaban' => $stg['ruang_jawaban'],
                    'urutan' => $stg['urutan'],
                ]);
            }

            // 5. GENERATE PROGRAM TAHUNAN (PROTA)
            $protaData = [];
            $totalTps = count($createdTps);
            foreach ($createdTps as $tpIdx => $tpItem) {
                $sem = ($totalTps > 1 && $tpIdx >= ceil($totalTps / 2)) ? 2 : 1;
                $protaData[] = [
                    'kode_tp' => $tpItem->kode_tp,
                    'tujuan_pembelajaran' => $tpItem->deskripsi_tp,
                    'elemen' => $tpItem->elemen ?? ($mapel->nama ?? 'Kompetensi Kejuruan'),
                    'semester' => $sem,
                    'alokasi_jp' => 12,
                ];
            }

            $prota = ProgramTahunan::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'judul' => 'Program Tahunan (Prota) ' . $mapel->nama . ' - Fase ' . $fase->kode . ' (' . ($tahunAjaran ? $tahunAjaran->nama : date('Y')) . ')',
                'data_json' => $protaData,
            ]);

            // 6. GENERATE PROGRAM SEMESTER (PROMES)
            $promesData = [];
            $bulanList = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            foreach ($createdTps as $tpIdx => $tpItem) {
                $assignedBulan = $bulanList[$tpIdx % count($bulanList)];
                $promesData[] = [
                    'kode_tp' => $tpItem->kode_tp,
                    'tujuan_pembelajaran' => $tpItem->deskripsi_tp,
                    'elemen' => $tpItem->elemen ?? ($mapel->nama ?? 'Kompetensi Kejuruan'),
                    'bulan' => $assignedBulan,
                    'minggu_ke' => ($tpIdx % 4) + 1,
                    'alokasi_jp' => 12,
                ];
            }

            $promes = ProgramSemester::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'judul' => 'Program Semester (Promes) Ganjil ' . $mapel->nama . ' - Fase ' . $fase->kode,
                'semester' => 1,
                'data_json' => $promesData,
            ]);

            // 7. GENERATE INSTRUMEN ASESMEN SESUAI PANDUAN PEMBELAJARAN DAN ASESMEN KEMENDIKDASMEN 2025/2026
            $firstTp = $createdTps[0] ?? null;
            $namaElemenUtama = array_key_first($elemenCp) ?? 'Kompetensi Kejuruan';

            $kktpRubrik = [
                'tujuan_pembelajaran' => $firstTp ? $firstTp->deskripsi_tp : 'Menguasai kompetensi dasar ' . $mapel->nama,
                'kriteria' => [
                    [
                        'aspek' => 'Pemahaman Konseptual & Prosedural',
                        'perlu_bimbingan' => 'Belum mampu menjelaskan prinsip dasar dan alur kerja.',
                        'cukup' => 'Mampu menjelaskan prinsip dasar dengan bantuan guru.',
                        'baik' => 'Mampu menjelaskan prinsip dasar dan alur kerja secara mandiri dan benar.',
                        'sangat_baik' => 'Mampu menjelaskan, menganalisis, dan mengevaluasi alur kerja serta mengaitkannya dengan kasus industri.',
                    ],
                    [
                        'aspek' => 'Keterampilan Praktik & Unjuk Kerja (SOP Industri)',
                        'perlu_bimbingan' => 'Belum mampu mempraktikkan prosedur kerja tanpa bimbingan penuh.',
                        'cukup' => 'Mampu mempraktikkan sebagian prosedur namun masih terdapat kesalahan teknis ringan.',
                        'baik' => 'Mampu mempraktikkan seluruh langkah kerja sesuai SOP secara mandiri dan aman.',
                        'sangat_baik' => 'Mampu mendemonstrasikan pekerjaan secara presisi, efisien waktu, mandiri, dan berinovasi.',
                    ],
                    [
                        'aspek' => 'Penerapan K3LH & Budaya Kerja 5R',
                        'perlu_bimbingan' => 'Sering mengabaikan penggunaan APD dan kebersihan tempat kerja.',
                        'cukup' => 'Menggunakan APD setelah diingatkan dan membersihkan area kerja sebagian.',
                        'baik' => 'Disiplin menggunakan APD lengkap, menerapkan K3LH, dan membersihkan area kerja (5R).',
                        'sangat_baik' => 'Menjadi teladan dalam K3LH, konsisten budaya 5R, dan tanggap mencegah potensi bahaya.',
                    ],
                    [
                        'aspek' => 'Penalaran Kritis & Pemecahan Masalah (Troubleshooting)',
                        'perlu_bimbingan' => 'Pasif saat menghadapi kendala teknis dan menunggu instruksi.',
                        'cukup' => 'Mampu mengenali adanya kendala teknis namun belum dapat menemukan solusinya.',
                        'baik' => 'Mampu menganalisis akar masalah dan mencari solusi alternatif yang tepat.',
                        'sangat_baik' => 'Cepat dan tepat dalam diagnosis kendala teknis, serta mampu memvalidasi hasil perbaikan.',
                    ],
                ]
            ];

            $tindakLanjutData = [
                'pendekatan' => 'Interval Nilai Resmi Panduan Pembelajaran dan Asesmen Kemendikdasmen (Revisi 2025/2026)',
                'interval' => [
                    [
                        'rentang' => '0% - 40%',
                        'status' => 'Belum Mencapai Tujuan Pembelajaran',
                        'tindak_lanjut' => 'Remedial menyeluruh di seluruh bagian materi dengan pendampingan tutor sebaya dan bimbingan guru secara intensif.',
                        'badge' => 'danger',
                    ],
                    [
                        'rentang' => '41% - 65%',
                        'status' => 'Belum Mencapai Ketuntasan',
                        'tindak_lanjut' => 'Remedial parsial pada indikator kompetensi yang belum dikuasai (latihan terbimbing pada bagian yang salah).',
                        'badge' => 'warning',
                    ],
                    [
                        'rentang' => '66% - 85%',
                        'status' => 'Sudah Mencapai Ketuntasan',
                        'tindak_lanjut' => 'Tuntas. Tidak perlu remedial, dapat melanjutkan ke tujuan pembelajaran atau materi berikutnya.',
                        'badge' => 'success',
                    ],
                    [
                        'rentang' => '86% - 100%',
                        'status' => 'Mencapai Ketuntasan Sangat Baik',
                        'tindak_lanjut' => 'Tuntas dengan predikat Sangat Baik. Diberikan pengayaan materi tingkat lanjut atau proyek tantangan kejuruan DUDI mandiri.',
                        'badge' => 'primary',
                    ],
                ]
            ];

            $vokasiDudiData = [
                'standar_industri' => 'Standar Kompetensi Kerja Nasional Indonesia (SKKNI) & SOP Mitra Industri DUDI ' . ($mapel->programKeahlian->nama ?? 'SMK'),
                'komponen_penilaian' => [
                    ['komponen' => 'Persiapan Alat & K3LH', 'bobot' => '15%', 'kriteria' => 'Pemeriksaan APD, instrumen kerja, dan keselamatan lingkungan kerja'],
                    ['komponen' => 'Proses Operasi & Ketelitian', 'bobot' => '40%', 'kriteria' => 'Sistematika urutan kerja teknis, kepatuhan manual kerja, dan kecakapan alat'],
                    ['komponen' => 'Hasil Kerja / Produk / Layanan', 'bobot' => '30%', 'kriteria' => 'Toleransi presisi dimensi, fungsionalitas sistem, dan kerapian hasil'],
                    ['komponen' => 'Sikap Kerja & Komunikasi', 'bobot' => '10%', 'kriteria' => 'Tanggung jawab, kebersihan area kerja (5R), dan etika kerja tim'],
                    ['komponen' => 'Waktu Pelaksanaan', 'bobot' => '5%', 'kriteria' => 'Penyelesaian sesuai estimasi durasi industri'],
                ],
                'kategori_kelulusan' => [
                    'kompeten' => 'Memenuhi seluruh kriteria minimal pada setiap komponen (K)',
                    'belum_kompeten' => 'Terdapat satu atau lebih komponen kritis yang belum memenuhi standar (BK)',
                ]
            ];

            $deskripsiRapor = [
                'capaian_tertinggi' => 'Menunjukkan penguasaan yang sangat baik dalam memahami prinsip kerja dan mempraktikkan keterampilan pada elemen "' . $namaElemenUtama . '" sesuai dengan SOP industri.',
                'perlu_ditingkatkan' => 'Perlu pendampingan dan latihan intensif lebih lanjut dalam meningkatkan ketelitian operasional dan penguatan analisis troubleshooting pada elemen "' . $namaElemenUtama . '".',
            ];

            $asesmen = Asesmen::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'modul_ajar_id' => $modulAjar->id,
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'tujuan_pembelajaran_id' => $firstTp?->id,
                'judul' => 'Instrumen Asesmen Deep Learning ' . $mapel->nama . ' (' . ($firstTp ? $firstTp->kode_tp : 'Fase ' . $fase->kode) . ')',
                'jenis' => 'formatif',
                'deskripsi' => 'Instrumen asesmen komprehensif berbasis Keputusan Kepala BSKAP Nomor 046/H/KR/2025 dan Panduan Pembelajaran dan Asesmen (PPA) Kemendikdasmen Revisi 2025/2026: Diagnostik Awal (pemetaan diferensiasi tanpa bobot rapor), Formatif Proses (umpan balik bermakna & metakognisi), Sumatif Vokasi (job sheet unjuk kerja SOP DUDI status K/BK), KKTP 4 Level Rubrik, dan Generator Deskripsi Rapor Capaian Tertinggi/Perlu Bimbingan.',
                'instrumen' => "1. ASESMEN DIAGNOSTIK (Awal Pembelajaran):\n   - Lembar Pemetaan Minat, Kesiapan Belajar, dan Profil Gaya Belajar Murid.\n   - 3 Soal Tes Prasyarat Kognitif Pemantik Konsep.\n\n2. ASESMEN FORMATIF (Proses Pembelajaran):\n   - Lembar Observasi Keterlibatan Aktif & Kolaborasi (Olah Pikir & Olah Rasa).\n   - Lembar Refleksi Diri (Self-Assessment) dan Antarteman (Peer-Assessment).\n   - Format Umpan Balik Kualitatif (Constructive Feedback) Guru.\n\n3. ASESMEN SUMATIF (Akhir Lingkup Materi):\n   - Soal Analisis Berbasis Kasus Industri HOTS (Meaningful Learning).\n   - Job Sheet Unjuk Kerja Praktik Vokasi Berstandar DUDI / UKK.",
                'rubrik' => "Rubrik KKTP Resmi Kemendikdasmen:\n- Level 4 (Sangat Baik / 86-100): Menguasai mandiri, mampu troubleshooting, validasi hasil, dan berinovasi.\n- Level 3 (Baik / 71-85 - TUNTAS): Menguasai konsep dan mempraktikkan prosedur sesuai SOP secara mandiri dan aman.\n- Level 2 (Cukup / 61-70): Menguasai sebagian prosedur, masih butuh bimbingan berkala pada kasus spesifik.\n- Level 1 (Perlu Bimbingan / 0-60): Membutuhkan pendampingan intensif pada konsep dasar dan langkah awal.",
                'pedoman_penskoran' => "Prinsip Resmi Panduan Pembelajaran dan Asesmen Kemendikdasmen (Revisi 2025/2026):\n1. Asesmen Diagnostik TIDAK DIBOBOT untuk nilai akhir rapor (murni untuk diferensiasi pembelajaran).\n2. Asesmen Formatif diutamakan sebagai umpan balik deskriptif (feedback) perbaikan kualitas belajar.\n3. Nilai Akhir Rapor diolah murni dari Rerata Asesmen Sumatif Lingkup Materi (dan Sumatif Akhir Semester) serta disajikan bersama Deskripsi Capaian Kompetensi (Capaian Tertinggi & Hal yang Perlu Bimbingan).",
                'kktp_data' => $kktpRubrik,
                'tindak_lanjut_data' => $tindakLanjutData,
                'vokasi_dudi_data' => $vokasiDudiData,
                'deskripsi_rapor' => $deskripsiRapor,
            ]);

            return [
                'tujuan_pembelajaran' => $createdTps,
                'atp' => $atp,
                'modul_ajar' => $modulAjar,
                'lkpd' => $lkpd,
                'prota' => $prota,
                'promes' => $promes,
                'asesmen' => $asesmen,
            ];
        });
    }
}
