<?php

namespace Database\Seeders;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class AllCapaianPembelajaranSmkSeeder extends Seeder
{
    public function run(): void
    {
        $faseE = Fase::where('kode', 'E')->first();
        $faseF = Fase::where('kode', 'F')->first();

        if (!$faseE || !$faseF) {
            return;
        }

        // Data Capaian Pembelajaran Resmi Kurikulum Merdeka (Keputusan BSKAP No. 046/H/KR/2025 & Permendikdasmen No. 13/2025)
        $cpList = [
            // ================= 1. KODING DAN KECERDASAN ARTIFISIAL (AI) =================
            [
                'mapel' => 'Koding dan Kecerdasan Artifisial (AI)',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memiliki pemahaman mendalam tentang prinsip kerja kecerdasan artifisial (Artificial Intelligence), rekayasa prompt (prompt engineering), algoritma machine learning dasar, pemanfaatan generative AI secara produktif dan bertanggung jawab, serta etika, privasi data, dan keamanan siber dalam ekosistem AI.',
                'elemen' => [
                    'Fondasi AI dan Berpikir Komputasional' => 'Murid memahami sejarah, taksonomi AI (Narrow AI, Generative AI), cara kerja neural network secara konseptual, dan logika komputasi.',
                    'Prompt Engineering & Generative AI' => 'Murid mampu merancang prompt terstruktur (role-task-context-constraint) untuk teks, gambar, dan kode program guna meningkatkan produktivitas belajar dan kerja.',
                    'Algoritma Machine Learning Dasar' => 'Murid mampu memahami alur supervised dan unsupervised learning, pengumpulan dan persiapan dataset, pelatihan model sederhana, dan evaluasi akurasi.',
                    'Etika AI, Hak Cipta, dan Keamanan Digital' => 'Murid mampu menganalisis bias data, isu plagiarisme, perlindungan data pribadi (UU PDP), dan dampak sosial kecerdasan artifisial bagi masa depan dunia kerja.',
                ]
            ],
            [
                'mapel' => 'Koding dan Kecerdasan Artifisial (AI)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu membangun aplikasi cerdas terintegrasi API model AI (LLM, vision, speech), menerapkan transfer learning, membangun automasi alur kerja berbasis AI agent, serta mengevaluasi dan menerapkan solusi AI untuk memecahkan problem industri nyata.',
                'elemen' => [
                    'Integrasi AI API & Framework Modern' => 'Murid mampu mengintegrasikan model AI melalui RESTful API / SDK (Python, JavaScript) ke dalam antarmuka web dan mobile.',
                    'Computer Vision & NLP Terapan' => 'Murid mampu mengimplementasikan deteksi objek, klasifikasi citra, sentiment analysis, dan text summarization pada studi kasus kejuruan.',
                    'Pengembangan AI Agent & Otomasi Cerdas' => 'Murid mampu merancang sistem automasi cerdas yang menggabungkan basis data, logic koding, dan model AI untuk menyelesaikan tugas spesifik.',
                    'Deployment dan Evaluasi Model AI' => 'Murid mampu melakukan pengujian performa, latency, monitoring model, dan mempublikasikan aplikasi berbasis AI.',
                ]
            ],

            // ================= 2. PROJEK IPAS =================
            [
                'mapel' => 'Projek Ilmu Pengetahuan Alam dan Sosial (IPAS)',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu menjelaskan fenomena alam dan sosial secara ilmiah, mendesain dan mengevaluasi penyelidikan ilmiah, serta menerjemahkan data dan bukti ilmiah untuk menyelesaikan isu lingkungan, energi, mitigasi bencana, dan interaksi keruangan dalam ekosistem industri.',
                'elemen' => [
                    'Menjelaskan Fenomena Ilmiah' => 'Murid mampu mengidentifikasi dan menjelaskan zat dan perubahannya, energi dan perubahannya, bumi dan antariksa, serta interaksi sosial dan dinamika populasi.',
                    'Mendesain dan Mengevaluasi Penyelidikan' => 'Murid mampu merumuskan hipotesis, memilih instrumen pengukuran, menentukan variabel penelitian, dan melaksanakan prosedur eksperimen ilmiah yang aman.',
                    'Menerjemahkan Data dan Bukti Ilmiah' => 'Murid mampu menyajikan data pengamatan dalam bentuk tabel/grafik, menganalisis korelasi variabel, dan menarik kesimpulan berdasarkan bukti empiris.',
                ]
            ],

            // ================= 3. INFORMATIKA =================
            [
                'mapel' => 'Informatika',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu menerapkan berpikir komputasional dalam menyelesaikan persoalan kompleks yang melibatkan data dan algoritma; memanfaatkan perkakas TIK untuk integrasi konten dan kolaborasi; memahami sistem kerja perangkat keras, sistem operasi, jaringan internet, dan keamanan siber; mengolah dan menganalisis data secara kritis; serta merancang algoritma pemrograman prosedural.',
                'elemen' => [
                    'Berpikir Komputasional (BK)' => 'Murid mampu menerapkan strategi algoritmik standar untuk memecahkan masalah kompleks dengan dekomposisi, pengenalan pola, abstraksi, dan perancangan algoritma.',
                    'Teknologi Informasi dan Komunikasi (TIK)' => 'Murid mahir memanfaatkan fitur lanjut aplikasi perkantoran, pengolah lembar kerja, presentasi, dan kolaborasi cloud storage.',
                    'Sistem Komputer (SK)' => 'Murid memahami arsitektur komputer (CPU, memori, I/O), siklus eksekusi instruksi, dan fungsi sistem operasi.',
                    'Jaringan Komputer dan Internet (JKI)' => 'Murid memahami topologi jaringan, pengalamatan IP, protokol komunikasi TCP/IP, keamanan data enkripsi, dan konektivitas nirkabel.',
                    'Analisis Data (AD)' => 'Murid mampu mengoleksi, membersihkan, mentransformasi, dan memvisualisasikan data bervolume besar menggunakan formula statistik.',
                    'Algoritma dan Pemrograman (AP)' => 'Murid mampu mengimplementasikan variabel, kontrol alur percabangan, perulangan, array, dan fungsi dalam bahasa pemrograman terstruktur.',
                ]
            ],

            // ================= 4. PROJEK KREATIF DAN KEWIRAUSAHAAN (PKK) =================
            [
                'mapel' => 'Projek Kreatif dan Kewirausahaan (PKK)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid memiliki pola pikir wirausaha (entrepreneurial mindset); mampu merancang ide produk kreatif barang/jasa sesuai kebutuhan pasar industri; menyusun proposal bisnis (business plan); melakukan produksi barang/jasa berstandar mutu; menerapkan strategi pemasaran digital; menyusun laporan keuangan usaha; serta memahami hak kekayaan intelektual (HAKI).',
                'elemen' => [
                    'Peluang Usaha dan Desain Produk' => 'Murid mampu mengidentifikasi peluang bisnis dari masalah nyata, merancang konsep purwarupa (prototype) produk kreatif, dan uji kelayakan pasar.',
                    'Produksi Barang dan Jasa' => 'Murid mampu menyusun rencana operasional produksi, manajemen bahan baku, alur kerja efisien, dan standard operating procedure (SOP).',
                    'Pemasaran Digital dan Penjualan' => 'Murid mampu menetapkan harga jual (cost-plus/market pricing), membuat konten promosi omnichannel, dan mengelola transaksi penjualan online/offline.',
                    'Laporan Keuangan dan Legalitas Usaha' => 'Murid mampu menyusun pembukuan sederhana arus kas (cashflow), laba-rugi, titik impas (BEP), dan pengurusan perizinan NIB serta HAKI.',
                ]
            ],

            // ================= 5. PRAKTIK KERJA LAPANGAN (PKL) =================
            [
                'mapel' => 'Praktik Kerja Lapangan (PKL)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu menginternalisasi budaya kerja industri (5R/5S), etika profesi, dan regulasi K3; mengimplementasikan kompetensi teknis kejuruan pada pekerjaan nyata di Dunia Usaha dan Dunia Industri (DUDI); memecahkan masalah praktis di tempat kerja; serta menyusun portofolio dan laporan PKL komprehensif.',
                'elemen' => [
                    'Internalisasi Budaya Kerja Industri' => 'Murid mampu menerapkan kedisiplinan, integritas, komunikasi profesional, dan prinsip kerja 5R (Ringkas, Rapi, Resik, Rawat, Rajin) di lingkungan industri mitra.',
                    'Penerapan Kompetensi Teknis Kejuruan' => 'Murid mampu melaksanakan pekerjaan operasional dan tugas-tugas teknis sesuai standar operasional prosedur (SOP) dunia industri tempat magang.',
                    'Penyelesaian Masalah Operasional Lapangan' => 'Murid mampu mengidentifikasi kendala teknis dalam pekerjaan, berkoordinasi dengan mentor industri, dan mengeksekusi solusi alternatif yang efisien.',
                    'Penyusunan Portofolio & Laporan Magang' => 'Murid mampu mendokumentasikan jurnal kegiatan harian, menganalisis pencapaian kompetensi, dan mempresentasikan laporan hasil PKL secara sistematis.',
                ]
            ],

            // ================= 6. BAHASA INDONESIA =================
            [
                'mapel' => 'Bahasa Indonesia',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memiliki kemampuan berbahasa untuk berkomunikasi dan bernalar sesuai dengan tujuan, konteks sosial, akademis, dan dunia kerja. Murid mampu memahami, mengolah, menginterpretasi, dan mengevaluasi informasi dari berbagai tipe teks fiksi dan nonfiksi.',
                'elemen' => [
                    'Menyimak' => 'Murid mampu mengevaluasi dan mengkreasi informasi berupa gagasan, pikiran, pandangan dari teks lisan, laporan hasil observasi, dan gelar wicara.',
                    'Membaca dan Memirsa' => 'Murid mampu mengevaluasi akurasi fakta, bias informasi, dan pesan tersirat dari teks eksposisi, negosiasi, dan biografi tokoh.',
                    'Berbicara dan Mempresentasikan' => 'Murid mampu menyajikan gagasan dan argumen kritis secara santun dan meyakinkan dalam presentasi laporan teknis dan diskusi formal.',
                    'Menulis' => 'Murid mampu menyusun karya tulis ilmiah populer, proposal kegiatan kejuruan, dan surat lamaran kerja profesional yang sesuai kaidah PUEBI.',
                ]
            ],
            [
                'mapel' => 'Bahasa Indonesia',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu menggunakan bahasa Indonesia secara kritis, kreatif, dan komunikatif untuk bernegosiasi, menyusun karya tulis ilmiah, artikel opini, proposal bisnis, laporan teknis kejuruan, serta merespon berbagai wacana sosial dan profesional dengan argumen yang kokoh.',
                'elemen' => [
                    'Menyimak Kritis' => 'Murid mampu menganalisis akurasi, objektivitas, dan implikasi pesan kompleks dari pidato, debat publik, dan rekaman audio visual profesional.',
                    'Membaca dan Menilai Argumen' => 'Murid mampu mengkritisi struktur argumen, data pendukung, dan asumsi tersirat dalam jurnal ilmiah, buku referensi kejuruan, dan editorial berita.',
                    'Berbicara Negosiasi & Debat' => 'Murid terampil melakukan negosiasi kerja sama bisnis, berdebat secara argumentatif berbasis data empiris, dan memoderatori seminar.',
                    'Menulis Dokumen Profesional' => 'Murid mampu menyusun naskah dinas, dokumen SOP industri, artikel ilmiah populer terpublikasi, dan laporan studi kelayakan bisnis.',
                ]
            ],

            // ================= 7. MATEMATIKA =================
            [
                'mapel' => 'Matematika',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu menggeneralisasi sifat-sifat bilangan berpangkat (eksponen) dan logaritma; menerapkan barisan dan deret aritmetika/geometri; menyelesaikan sistem persamaan dan pertidaksamaan linear; menerapkan perbandingan trigonometri siku-siku; serta menganalisis data statistika dan peluang untuk pemecahan masalah kejuruan.',
                'elemen' => [
                    'Bilangan (Eksponen & Logaritma)' => 'Murid mampu menyederhanakan bentuk akar, eksponen pecahan, dan sifat logaritma dalam perhitungan teknis kejuruan.',
                    'Aljabar dan Fungsi' => 'Murid mampu memodelkan masalah kontekstual ke dalam SPLDV/SPLTV dan fungsi kuadrat serta menentukan himpunan penyelesaiannya.',
                    'Geometri dan Trigonometri' => 'Murid mampu menentukan nilai sinus, cosinus, tangen pada segitiga siku-siku untuk perhitungan kemiringan, jarak, dan sudut elevasi.',
                    'Analisis Data dan Peluang' => 'Murid mampu menghitung ukuran pemusatan (mean, median, modus) dan penyebaran (jangkauan, kuartil, standar deviasi) serta peluang kejadian majemuk.',
                ]
            ],
            [
                'mapel' => 'Matematika',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu memodelkan dan menyelesaikan masalah menggunakan fungsi komposisi dan fungsi invers, matriks dan transformasinya, kalkulus diferensial dan integral sederhana, serta statistika inferensial dalam konteks optimasi proses industri kejuruan.',
                'elemen' => [
                    'Aljabar Lanjut dan Matriks' => 'Murid mampu melakukan operasi matriks (determinan, invers) untuk menyelesaikan transformasi linear dan sistem persamaan multivariabel.',
                    'Kalkulus Terapan' => 'Murid memahami konsep turunan untuk menentukan nilai maksimum/minimum (optimasi biaya/material) dan integral untuk menghitung luas serta volume benda putar.',
                    'Geometri Ruang' => 'Murid mampu menentukan jarak titik ke garis/bidang dan sudut antara dua bidang pada bangun ruang tiga dimensi.',
                    'Statistika Inferensial' => 'Murid mampu melakukan uji hipotesis sederhana dan regresi linear untuk memprediksi tren performa kualitas produk industri.',
                ]
            ],

            // ================= 8. BAHASA INGGRIS =================
            [
                'mapel' => 'Bahasa Inggris',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu menggunakan bahasa Inggris untuk berkomunikasi lisan dan tertulis dalam interaksi sosial dan dunia kerja; memahami teks deskriptif, naratif, prosedur manual book, dan eksposisi; serta menyampaikan opini dan bertukar informasi secara percaya diri.',
                'elemen' => [
                    'Menyimak dan Berbicara (Listening & Speaking)' => 'Murid mampu memahami instruksi kerja berbahasa Inggris, merespon dialog percakapan perkenalan kerja, dan menjelaskan langkah prosedur teknis.',
                    'Membaca dan Memirsa (Reading & Viewing)' => 'Murid mampu mengidentifikasi ide pokok, detail spesifik, dan istilah kejuruan dari brosur teknis, manual book alat industri, dan email formal.',
                    'Menulis dan Mempresentasikan (Writing & Presenting)' => 'Murid mampu menyusun surat permohonan magang (cover letter), resume/CV berbahasa Inggris, serta menyajikan presentasi produk sederhana.',
                ]
            ],
            [
                'mapel' => 'Bahasa Inggris',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu berkomunikasi secara fasih dan profesional dalam konteks bisnis internasional; menyusun korespondensi resmi dan laporan teknis; memahami jurnal dan dokumen spesifikasi global; serta aktif dalam wawancara kerja berbahasa Inggris.',
                'elemen' => [
                    'Komunikasi Bisnis Internasional' => 'Murid mampu memimpin rapat bisnis, bernegosiasi dengan klien internasional, dan menjawab pertanyaan pada sesi tanya jawab profesional.',
                    'Analisis Teks Teknis Global' => 'Murid mampu menganalisis dokumen regulasi internasional (ISO, standard compliance), artikel tren industri global, dan tender dokumen.',
                    'Penulisan Laporan Teknis' => 'Murid terampil menyusun executive summary, progress report teknis, dan memo internal perusahaan dengan struktur formal dan akurat.',
                ]
            ],

            // ================= 9. PENDIDIKAN AGAMA DAN BUDI PEKERTI =================
            [
                'mapel' => 'Pendidikan Agama dan Budi Pekerti',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memperdalam keimanan, ketakwaan, dan akhlak mulia; memahami dalil kitab suci dan nilai-nilai moderasi beragama; membiasakan perilaku jujur, disiplin, peduli lingkungan hidup, dan menjunjung tinggi persaudaraan kemanusiaan dalam kehidupan sehari-hari.',
                'elemen' => [
                    'Keimanan dan Ketakwaan' => 'Murid meyakini rukun iman/ajaran pokok agama, menghayati kehadiran Tuhan dalam kehidupan, dan merefleksikan hikmah penciptaan alam semesta.',
                    'Akhlak dan Integritas' => 'Murid menerapkan integritas moral, amanah dalam pekerjaan, menjaga kehormatan diri, dan membiasakan akhlak terpuji kepada sesama.',
                    'Moderasi Beragama & Kerukunan' => 'Murid mampu bersikap toleran, menghargai perbedaan keyakinan dan budaya, serta aktif mewujudkan kerukunan antarumat beragama di masyarakat.',
                ]
            ],
            [
                'mapel' => 'Pendidikan Agama dan Budi Pekerti',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu mengaktualisasikan nilai-nilai spiritual dan etika keagamaan dalam etos kerja profesional, kepemimpinan transformatif, penegakan keadilan sosial, dan kontribusi nyata bagi kesejahteraan bangsa dan dunia.',
                'elemen' => [
                    'Etos Kerja Spiritual' => 'Murid memandang pekerjaan kejuruan sebagai bentuk ibadah dan pengabdian, mengutamakan kejujuran, dedikasi, dan profesionalitas tinggi.',
                    'Kepemimpinan Moral' => 'Murid menunjukkan keteladanan kepemimpinan yang berakhlak mulia, anti-korupsi, dan bertanggung jawab terhadap amanah publik.',
                    'Tanggung Jawab Sosial' => 'Murid aktif dalam kegiatan filantropi sosial, advokasi kemanusiaan, dan pelestarian ekologi bumi sesuai ajaran agama.',
                ]
            ],

            // ================= 10. PENDIDIKAN PANCASILA =================
            [
                'mapel' => 'Pendidikan Pancasila',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami kedudukan Pancasila sebagai dasar negara, ideologi bangsa, dan pandangan hidup; mengkaji pasal-pasal konstitusi UUD NRI 1945 terkait hak dan kewajiban warga negara; mengapresiasi keberagaman Bhinneka Tunggal Ika; serta memperkokoh keutuhan NKRI.',
                'elemen' => [
                    'Pancasila' => 'Murid mampu menganalisis nilai-nilai ketuhanan, kemanusiaan, persatuan, kerakyatan, dan keadilan sosial dalam perumusan kebijakan publik.',
                    'UUD Negara Republik Indonesia Tahun 1945' => 'Murid memahami jaminan hak asasi manusia (HAM), sistem peradilan hukum, dan kewajiban warga negara dalam UUD 1945.',
                    'Bhinneka Tunggal Ika' => 'Murid mampu mempromosikan persatuan dalam keberagaman suku, agama, ras, antargolongan, dan mencegah diskriminasi sosial.',
                    'Negara Kesatuan Republik Indonesia' => 'Murid mampu mengidentifikasi ancaman disintegrasi bangsa dan berperan aktif dalam bela negara pertahanan nasional.',
                ]
            ],
            [
                'mapel' => 'Pendidikan Pancasila',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu berpikir kritis dan berkontribusi solutif terhadap dinamika tata kelola pemerintahan yang baik (good governance), penegakan supremasi hukum, budaya demokrasi berintegritas, dan perwujudan keadilan sosial nasional.',
                'elemen' => [
                    'Praktik Baik Demokrasi Konstitusional' => 'Murid mengevaluasi pelaksanaan pemilu jujur adil, partisipasi sipil publik, dan transparansi tata kelola negara.',
                    'Penegakan Hukum & Antikorupsi' => 'Murid mampu mengampanyekan gerakan antikorupsi, kepatuhan hukum, dan integritas di lingkungan kerja dan masyarakat.',
                    'Kemandirian Bangsa di Era Global' => 'Murid mampu merumuskan gagasan strategis pemanfaatan potensi nasional untuk kedaulatan ekonomi, pangan, dan teknologi bangsa.',
                ]
            ],

            // ================= 11. PJOK =================
            [
                'mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu mempraktikkan keterampilan gerak spesifik berbagai cabang olahraga permainan bola besar/kecil, atletik, dan bela diri; merancang program latihan kebugaran jasmani mandiri; serta menerapkan pola hidup sehat, pencegahan penyakit, dan P3K.',
                'elemen' => [
                    'Keterampilan Gerak Olahraga' => 'Murid mampu menguasai variasi dan kombinasi gerak teknik dasar cabang olahraga bola voli, basket, sepak bola, bulu tangkis, atau pencak silat.',
                    'Peningkatan Kebugaran Jasmani' => 'Murid mampu mengukur denyut nadi istirahat/latihan, tes kebugaran MFT/beep test, dan merancang circuit training untuk daya tahan jantung-paru.',
                    'Pola Hidup Sehat & Ergonomi Kerja' => 'Murid memahami gizi seimbang, bahaya narkoba/rokok/miras, dan postur ergonomis saat bekerja di bengkel/kantor untuk mencegah cedera fisik.',
                ]
            ],
            [
                'mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang, memodifikasi, dan mengevaluasi taktik serta strategi dalam perlombaan olahraga; memimpin aktivitas jasmani kelompok; mengelola stres mental; dan membiasakan kebugaran jasmani prima sebagai penunjang produktivitas kerja vokasi.',
                'elemen' => [
                    'Taktik dan Strategi Permainan' => 'Murid mampu menganalisis formasi bertahan dan menyerang, serta menerapkan fair play dan sportivitas tinggi dalam kompetisi olahraga.',
                    'Manajemen Kebugaran Kerja Kejuruan' => 'Murid mampu menyusun program pemulihan fisik, peregangan otot kerja berulang (RSI prevention), dan manajemen stres kerja.',
                    'Kepemimpinan & Keselamatan Rekreasi' => 'Murid mampu mengorganisasi kegiatan olahraga rekreasi luar ruangan secara aman dan mematuhi SOP keselamatan air/alam terbuka.',
                ]
            ],

            // ================= 12. SEJARAH =================
            [
                'mapel' => 'Sejarah',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami konsep dasar ilmu sejarah (kronologis, sinkronis, kausalitas, keberlanjutan); menelusuri asal-usul nenek moyang dan jalur rempah nusantara; menganalisis dinamika kerajaan Hindu-Buddha dan Islam; serta merefleksikan nilai-nilai luhur peradaban bangsa.',
                'elemen' => [
                    'Keterampilan Konseptual Sejarah' => 'Murid mampu menggunakan konsep diakronik dan sinkronik untuk menganalisis kontinuitas peristiwa sejarah Indonesia.',
                    'Jalur Rempah & Kerajaan Nusantara' => 'Murid memahami peran strategis kepulauan Indonesia dalam perdagangan maritim dunia kuno dan kejayaan kerajaan-kerajaan maritim nusantara.',
                    'Penelitian Sejarah Sederhana' => 'Murid terampil melakukan heuristik pengumpulan sumber sejarah lisan/tertulis lokal dan historiografi narasi peristiwa daerah.',
                ]
            ],
            [
                'mapel' => 'Sejarah',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu menganalisis pergerakan kebangsaan Indonesia, proklamasi kemerdekaan, revolusi fisik dan diplomasi, dinamika politik Orde Lama, Orde Baru, hingga era Reformasi; serta memaknai peran Indonesia dalam dinamika perdamaian dunia.',
                'elemen' => [
                    'Pergerakan Nasional & Kemerdekaan' => 'Murid menganalisis ideologi pergerakan Budi Utomo, Sumpah Pemuda, pendudukan Jepang, detik-detik Proklamasi 1945, dan perang mempertahankan kemerdekaan.',
                    'Dinamika Ketatanegaraan & Pembangunan' => 'Murid mengkaji transformasi sistem politik demokrasi parlementer, terpimpin, pembangunan ekonomi modern, dan gerakan reformasi 1998.',
                    'Peran Geopolitik Indonesia di Dunia' => 'Murid mampu menganalisis politik luar negeri bebas aktif, Konferensi Asia Afrika (KAA), Gerakan Non-Blok, dan peran aktif ASEAN.',
                ]
            ],

            // ================= 13. SENI BUDAYA =================
            [
                'mapel' => 'Seni Budaya',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid mampu mengapresiasi keragaman karya seni rupa, seni musik, seni tari, atau seni teater nusantara dan mancanegara; mengeksplorasi media dan teknik berkesenian; serta mengekspresikan gagasan estetis melalui penciptaan karya seni yang komunikatif dan bermakna.',
                'elemen' => [
                    'Mengalami dan Mengamati' => 'Murid mampu mengamati unsur-unsur rupa/bunyi/gerak dalam karya seni tradisi dan kontemporer dengan perspektif kritis.',
                    'Menciptakan dan Berkeskpresi' => 'Murid mampu membuat karya seni yang menggabungkan teknik tradisional dengan eksplorasi material modern berorientasi pesan sosial.',
                    'Merefleksikan dan Mempresentasikan' => 'Murid mampu memamerkan atau mementaskan karya seni serta mempresentasikan konsep filosofis di balik karya yang dihasilkan.',
                ]
            ],

            // ================= 14. TEKNIK KETENAGALISTRIKAN =================
            [
                'mapel' => 'Dasar-dasar Teknik Ketenagalistrikan',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis ketenagalistrikan; perkembangan teknologi smart grid dan PLTS; profesi dan kewirausahaan bidang listrik; K3LH kelistrikan; teori dasar listrik dan hukum Ohm/Kirchhoff; alat ukur multimeter/megger; komponen elektronika daya; serta gambar teknik listrik standar PUIL.',
                'elemen' => [
                    'Proses Bisnis & Perkembangan Ketenagalistrikan' => 'Murid memahami rantai pasok industri pembangkitan, transmisi tegangan ekstra tinggi, distribusi listrik, sistem smart metering digital, dan PLTS atap.',
                    'Keselamatan dan Kesehatan Kerja (K3LH)' => 'Murid terampil menerapkan SOP bahaya tegangan sentuh langsung/tak langsung, penggunaan APD helm isolasi/sepatu safety 20kV, lock-out tag-out (LOTO), dan P3K sengatan listrik.',
                    'Teori Dasar Listrik & Pengukuran' => 'Murid menguasai konsep arus AC/DC, tegangan, daya nyata/semu/reaktif, segitiga daya, faktor daya cos phi, dan terampil mengukur tahanan isolasi dengan insulation tester (megger).',
                    'Gambar Teknik & Komponen Kelistrikan' => 'Murid mampu menggambar dan membaca diagram pengawatan (wiring diagram), diagram garis tunggal (single line diagram) instalasi listrik sesuai standar PUIL 2020.',
                ]
            ],
            [
                'mapel' => 'Teknik Instalasi Tenaga Listrik',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang, memasang, menguji, dan memelihara instalasi penerangan gedung bertingkat; instalasi tenaga motor listrik 3 fasa DOL/Star-Delta; perakitan panel distribusi utama (LVMDP/SDP); pemrograman PLC dan kontrol relay cerdas (smart relay); serta sistem otomatisasi smart building.',
                'elemen' => [
                    'Instalasi Penerangan Gedung & Industri' => 'Murid mampu menghitung kebutuhan titik lampu (lux), merancang sirkit cabang, memasang pipa conduit, saklar hotel, fitting, dan sistem grounding pentanahan standar PUIL.',
                    'Instalasi Tenaga & Pengendalian Motor Listrik' => 'Murid terampil merangkai rangkaian daya dan kontrol kontaktor magnetik, thermal overload relay (TOR), pembalik putaran forward-reverse motor 3 fasa, dan soft starter.',
                    'Perakitan Panel Distribusi (LVMDP)' => 'Murid mampu merakit busbar tembaga, MCB/MCCB/ACB, relai proteksi fasa (EOCR), alat ukur power meter digital, dan panel sinkronisasi genset otomatis ATS-AMF.',
                    'Sistem Otomasi PLC & Smart Building' => 'Murid mampu memprogram PLC (Programmable Logic Controller) berbasis ladder diagram, integrasi sensor proximity/photoelectric, dan sistem IoT smart home penerangan.',
                ]
            ],
            [
                'mapel' => 'Teknik Jaringan Tenaga Listrik',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merencanakan dan melaksanakan konstruksi Saluran Udara Tegangan Menengah (SUTM 20 kV), Saluran Udara Tegangan Rendah (SUTR 380/220 V), pemasangan gardu portal/cantol distribusi trafo, pemeliharaan isolator dan lightning arrester, serta manuver proteksi jaringan.',
                'elemen' => [
                    'Konstruksi Saluran Udara Distribusi (SUTM/SUTR)' => 'Murid mampu memasang tiang beton, travers cross-arm, kawat penghantar A3C/AAAC, isolator tumpu/tarik, dan penarikan andongan kabel (sagging).',
                    'Pemasangan & Pemeliharaan Gardu Trafo Distribusi' => 'Murid terampil memasang fuse cut-out (FCO), lightning arrester (LA), transformator step-down 20kV/400V, dan pembumian bodi trafo (grounding resistansi < 5 Ohm).',
                    'Manuver Jaringan & Proteksi Relai' => 'Murid memahami prosedur buka-tutup saklar pemutus beban (LBS), auto-recloser, relay proteksi arus lebih (OCR) dan gangguan tanah (GFR).',
                ]
            ],
            [
                'mapel' => 'Teknik Pembangkit Tenaga Listrik',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid memahami operasional mesin pembangkit listrik termal dan hidro; sistem bahan bakar dan pelumasan; generator sinkron 3 fasa dan sistem eksitasi; sinkronisasi paralel generator ke busbar; serta instrumentasi ruang kontrol boiler dan turbin.',
                'elemen' => [
                    'Operasi Turbin & Generator Pembangkit' => 'Murid mampu mengawasi parameter putaran RPM, frekuensi 50 Hz, temperatur bantalan turbin, dan sistem pendingin hidrogen/air generator.',
                    'Sistem Eksitasi & Sinkronisasi Daya' => 'Murid mampu mengoperasikan automatic voltage regulator (AVR) dan synchroscope saat sinkronisasi generator ke jaringan interkoneksi nasional.',
                    'Pemeliharaan Preventif Mesin Pembangkit' => 'Murid terampil melakukan pengujian getaran (vibration analysis), pembersihan sudu turbin, dan perawatan sistem pelumasan oli hidrolik.',
                ]
            ],

            // ================= 15. TEKNIK MESIN & PENGELASAN =================
            [
                'mapel' => 'Dasar-dasar Teknik Mesin',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis manufaktur mesin; perkembangan teknologi industri 4.0; profesi teknisi mesin; K3LH bengkel mekanik; gambar teknik mesin ISO; alat ukur presisi jangka sorong dan mikrometer sekrup; serta teknik dasar kerja bangku kikir, bor, dan gergaji.',
                'elemen' => [
                    'Proses Bisnis Manufaktur & Industri 4.0' => 'Murid memahami alur perancangan produk mekanik, pemilihan bahan baku logam, pemesinan presisi, kontrol mutu, dan perakitan mesin.',
                    'K3LH Bengkel Mesin' => 'Murid terampil menerapkan standar keselamatan APD kacamata safety, sepatu safety, pencegahan serpihan gram tajam, dan pemadaman api APAR.',
                    'Pengukuran Presisi & Gambar Teknik' => 'Murid mahir membaca alat ukur jangka sorong ketelitian 0.02 mm, mikrometer luar 0.01 mm, dial indikator, dan membaca toleransi geometris gambar teknik ISO.',
                    'Keterampilan Dasar Kerja Bangku' => 'Murid terampil mengikir rata bidang siku presisi, melukis benda kerja, menitik, mengebor meja, mengetap ulir dalam, dan menyenei ulir luar.',
                ]
            ],
            [
                'mapel' => 'Teknik Pengelasan (Welding)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid menguasai pengelasan pelat dan pipa posisi 1G, 2G, 3G, 4G, 5G, dan 6G menggunakan proses SMAW (Shielded Metal Arc Welding), GMAW/MIG-MAG (Gas Metal Arc Welding), dan GTAW/TIG (Gas Tungsten Arc Welding); membaca Welding Procedure Specification (WPS); serta melakukan uji visual dan Non-Destructive Testing (NDT).',
                'elemen' => [
                    'Pengelasan SMAW Pelat dan Pipa' => 'Murid mampu menyetel parameter ampere mesin las busur listrik, memilih elektroda E6013/E7018, mengelas sambungan tumpul (butt joint) dan sudut (fillet joint) posisi 1G s.d. 6G bebas cacat undercut/porosity.',
                    'Pengelasan GMAW / MIG-MAG' => 'Murid terampil menyetel gas pelindung argon/CO2, wire feeder kawat las kontinu, tegangan voltase, dan mengelas baja karbon dan baja paduan sambungan multipass posisi 3G/4G.',
                    'Pengelasan GTAW / TIG Pipa Presisi' => 'Murid mampu mengasah elektroda tungsten, menyetel gas murni argon, menyuapkan kawat filler rod dengan kedua tangan, dan mengelas pipa stainless steel sambungan akar (root pass) tembus merata.',
                    'Inspeksi Kualitas Las & NDT' => 'Murid mampu melakukan uji visual weld bead, uji penetran pewarna cair (dye penetrant test), uji serbuk magnetik (MT), dan uji tekuk (bending test) sesuai standar ASME/AWS.',
                ]
            ],
            [
                'mapel' => 'Teknik Pemesinan',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mengoperasikan mesin bubut konvensional untuk membuat poros bertingkat, ulir segitiga/segiempat, tirus, dan kartel; mengoperasikan mesin frais konvensional membuat roda gigi dan bidang bertingkat; serta memprogram dan mengoperasikan mesin bubut CNC dan frais CNC berbasis kode G & M.',
                'elemen' => [
                    'Pemesinan Bubut Konvensional' => 'Murid terampil menyetel pahat bubut HSS/karbida tepat setinggi senter, membubut muka, membubut lurus bertingkat toleransi h7, membubut tirus sudut, dan memotong alur.',
                    'Pemesinan Frais Konvensional' => 'Murid terampil mengoperasikan dividing head kepala pembagi untuk pembuatan roda gigi lurus (spur gear), roda gigi heliks, meratakan bidang balok siku, dan pengefraisan alur pasak.',
                    'Pemrograman & Pengoperasian Bubut CNC' => 'Murid mampu menulis program kode G (G00, G01, G02, G03, G71 siklus pembubutan kasar, G70 finishing, G76 pembubutan ulir), setting titik nol koordinat benda kerja (work offset), dan running program.',
                    'Pemrograman & Pengoperasian Frais/Milling CNC' => 'Murid mampu menggunakan software CAD/CAM untuk generate kode G permesinan 3 dimensi kontur saku (pocketing), pengeboran siklus kaleng G81, dan kompensasi radius alat potong.',
                ]
            ],
            [
                'mapel' => 'Teknik Fabrikasi Logam dan Manufaktur',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil melakukan pemotongan lembaran pelat baja (shearing/plasma cutting), pembengkokan pelat (bending press brake), perakitan konstruksi rangka baja, dan inspeksi dimensi struktur manufaktur.',
                'elemen' => [
                    'Pemotongan & Pembentukan Pelat Logam' => 'Murid terampil menghitung bentangan pelat (bend allowance), mengoperasikan mesin potong guillotine, mesin rol pelat silinder, dan mesin tekuk press brake hidrolik.',
                    'Perakitan Struktur Konstruksi Baja' => 'Murid mampu membaca gambar rancang bangun konstruksi (shop drawing), merakit sambungan baut mutu tinggi (high strength bolt) dan las konstruksi, serta meluruskan distorsi panas.',
                    'Kontrol Dimensi & Finishing Pelapis' => 'Murid mampu mengukur toleransi geometri rangka menggunakan laser meter dan waterpass optik, serta melakukan sandblasting dan pengecatan pelindung anti-korosi.',
                ]
            ],

            // ================= 16. DESAIN PEMODELAN DAN INFORMASI BANGUNAN (DPIB) =================
            [
                'mapel' => 'Dasar-dasar Desain Pemodelan dan Informasi Bangunan',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis industri konstruksi dan arsitektur; perkembangan teknologi Building Information Modelling (BIM); profesi drafter dan arsitek; K3LH lingkungan konstruksi; gambar proyeksi ortogonal dan isometri manual; serta pengenalan software CAD 2D/3D.',
                'elemen' => [
                    'Proses Bisnis Perencanaan Bangunan' => 'Murid memahami siklus proyek konstruksi mulai dari studi kelayakan, perancangan skematik, dokumen lelang tender, pelaksanaan konstruksi, hingga serah terima bangunan.',
                    'K3LH Konstruksi & Lingkungan' => 'Murid menerapkan standar keselamatan konstruksi, pemakaian APD helm proyek dan safety harness ketinggian, mitigasi bahaya runtuh, dan pengelolaan limbah material.',
                    'Gambar Proyeksi & Arsitektur Manual' => 'Murid mampu menggambar proyeksi Eropa dan Amerika, denah rumah tinggal skala 1:100, tampak depan/samping, potongan melintang/membujur, dan notasi arsitektur.',
                    'Dasar Penggambaran Perangkat Lunak CAD' => 'Murid mampu mengoperasikan perintah dasar software CAD komputer (line, offset, trim, layer, dimension, text, block) untuk membuat denah digital.',
                ]
            ],
            [
                'mapel' => 'Desain Pemodelan dan Informasi Bangunan (BIM)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang model informasi bangunan 3D parametrik (arsitektur, struktur, dan MEP) menggunakan software BIM (Revit/ArchiCAD); menyusun gambar detail kerja (shop drawing); melakukan visualisasi rendering foto-realistis; serta menghitung estimasi volume material dan Rencana Anggaran Biaya (RAB).',
                'elemen' => [
                    'Pemodelan 3D Arsitektur Berbasis BIM' => 'Murid mampu memodelkan dinding bata/partisi, kusen pintu dan jendela, pelat lantai beton, tangga putar, dan struktur atap baja ringan secara parametrik 3 dimensi.',
                    'Pemodelan Struktur & MEP' => 'Murid mampu membuat pemodelan pondasi telapak/batu kali, kolom beton bertulang, balok girder, dan integrasi pipa sanitasi serta saluran kabel elektrikal MEP bebas tabrakan (clash detection).',
                    'Visualisasi Arsitektur & Render Sinematik' => 'Murid terampil menerapkan material tekstur alami, tata cahaya pencahayaan alami/buatan matahari, render eksterior/interior foto-realistis, dan video animasi walkthrough.',
                    'Penyusunan Rencana Anggaran Biaya (RAB)' => 'Murid mampu mengekstrak tabel volume material otomatis (schedule of quantities) dari model BIM, menghitung Analisis Harga Satuan Pekerjaan (AHSP), dan rekapitulasi biaya proyek.',
                ]
            ],

            // ================= 17. TEKNIK OTOMOTIF =================
            [
                'mapel' => 'Dasar-dasar Teknik Otomotif',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis bengkel otomotif dan dealer kendaraan; perkembangan teknologi kendaraan hybrid dan listrik; profesi mekanik dan technopreneur otomotif; K3LH perbengkelan; teori dasar motor bakar 4 langkah dan 2 langkah; peralatan tangan (hand tools), power tools, dan special service tools (SST); serta dasar kelistrikan bodi otomotif.',
                'elemen' => [
                    'Proses Bisnis & Teknologi Otomotif Terkini' => 'Murid memahami operasional bengkel servis resmi (dealership), alur service advisor, suku cadang (spare parts), dan tren teknologi kendaraan ramah lingkungan.',
                    'K3LH Bengkel Otomotif' => 'Murid menerapkan pemakaian kacamata pelindung, sepatu safety anti-licin oli, pemasangan fender cover bodi mobil, pengoperasian car lift hidrolik, dan jack stand pengaman.',
                    'Alat Ukur & Special Service Tools (SST)' => 'Murid terampil menggunakan kunci momen (torque wrench), jangka sorong, micrometer, dial gauge untuk run-out piringan rem, dan SST pembongkar pegas katup.',
                    'Dasar Motor Bakar & Kelistrikan Otomotif' => 'Murid memahami siklus hisap-kompresi-usaha-buang motor 4 tak, cara kerja sistem pengapian konvensional, aki baterai, dan rangkaian lampu kepala mobil.',
                ]
            ],
            [
                'mapel' => 'Teknik Kendaraan Ringan Otomotif',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mendiagnosis dan memperbaiki mesin bensin EFI modern; mesin diesel common rail; sistem pemindah tenaga (kopling, transmisi manual/otomatis CVT/AT, gardan poros propeler); sistem chasis (rem ABS/EBD, power steering EPS, suspensi MacPherson); sistem kelistrikan bodi, lampu penerangan, central lock, dan sistem AC mobil.',
                'elemen' => [
                    'Perawatan & Perbaikan Engine Bensin & Diesel' => 'Murid mampu menggunakan engine scanner scanner OBD-II membaca data stream sensor TPS, MAP, O2 sensor, kode DTC kerusakan mesin, dan kalibrasi injektor common rail diesel.',
                    'Servis Sistem Pemindah Tenaga (Drive Train)' => 'Murid mampu membongkar, mengukur ketebalan kanvas kopling, overhaul transmisi manual gigi sinkromes, dan memeriksa clearance backlash roda gigi gardan differential.',
                    'Diagnosis Sistem Rem, Suspensi, dan Kemudi' => 'Murid terampil melakukan bleeding minyak rem sistem hidrolik ABS, penggantian brake pad cakram, spooring alignment sudut camber/caster/toe-in roda kemudi, dan balancing ban.',
                    'Sistem Kelistrikan Bodi & AC Mobil' => 'Murid mampu melacak kerusakan kabel korsleting menggunakan multitester, penggantian relay modul BCM, flushing oli kompresor AC, vakum dan pengisian gas freon R134a/R1234yf.',
                ]
            ],
            [
                'mapel' => 'Teknik Sepeda Motor',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mendiagnosis dan menyervis sistem injeksi elektronik sepeda motor (PGM-FI, YMJET-FI); sistem transmisi otomatis CVT (Continuously Variable Transmission); sistem kelistrikan starter, pengisian spul stator dan regulator rectifier; sistem rem hidrolik ABS motor; dan rangka chasis suspensi teleskopik/monoshock.',
                'elemen' => [
                    'Engine Injeksi Sepeda Motor' => 'Murid mampu menggunakan scanner motor injeksi (diagnostic tool), membaca MIL (Malfunction Indicator Lamp), menyetel celah katup klep, dan membersihkan throttle body.',
                    'Transmisi Otomatis CVT Matic' => 'Murid terampil membongkar rumah CVT, memeriksa ketebalan v-belt, roller weight pemberat, kampas kopling ganda centrifugal, dan pelumasan grease high-temp CVT.',
                    'Kelistrikan & Pengapian Motor' => 'Murid mampu memeriksa tegangan pengisian aki, tahanan koil pengapian, busi, relay starter, dan lampu LED digital speedometer sepeda motor.',
                    'Sasis, Suspensi, dan Rem Motor' => 'Murid mampu mengganti seal oli shockbreaker teleskopik depan, menyetel kekencangan rantai roda, mengganti kanvas rem cakram, dan penggantian bearing laher roda.',
                ]
            ],
            [
                'mapel' => 'Teknik Kendaraan Listrik (Electric Vehicle)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid memahami dan terampil memelihara sistem motor penggerak listrik traksi (BLDC/PMSM); inverter controller; battery management system (BMS) baterai lithium-ion; sistem pendingin baterai (thermal management); sistem pengereman regeneratif; stasiun pengisian daya (charging station); dan prosedur keselamatan tegangan tinggi kendaraan listrik (High Voltage Safety).',
                'elemen' => [
                    'Keselamatan Tegangan Tinggi (High Voltage Safety)' => 'Murid terampil menggunakan sarung tangan isolasi class 0 (1000V), prosedur pelepasan service plug manual disconnect (MSD), dan pengujian isolasi megger sebelum servis kendaraan EV.',
                    'Baterai Traksi & Battery Management System (BMS)' => 'Murid mampu memeriksa tegangan sel baterai lithium, monitoring parameter State of Charge (SoC), State of Health (SoH), penyeimbangan sel (cell balancing), dan modul pendingin.',
                    'Motor Traksi & Inverter Controller' => 'Murid memahami pengendalian frekuensi gelombang sinus PWM oleh inverter, cara kerja motor sinkron magnet permanen PMSM, dan diagnosis kode gangguan motor controller.',
                    'Sistem Pengisian Daya & Kelistrikan Tambahan' => 'Murid mampu memeriksa soket pengisian AC Type 2 dan DC CCS2/CHAdeMO, konverter DC-DC 12V pendukung sistem kelistrikan aksesoris, dan sistem rem regeneratif.',
                ]
            ],

            // ================= 18. PENGEMBANGAN PERANGKAT LUNAK DAN GIM (PPLG) =================
            [
                'mapel' => 'Dasar-dasar Pengembangan Perangkat Lunak dan Gim',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis industri rekayasa software; profesi developer dan game designer; K3LH ergonomi kerja komputer; berpikir komputasional dekomposisi dan abstraksi; perancangan basis data relasional ERD dan normalisasi; serta pemrograman berorientasi objek (PBO) dasar.',
                'elemen' => [
                    'Proses Bisnis Perangkat Lunak & SDLC' => 'Murid memahami tahapan Software Development Life Cycle (Waterfall, Agile Scrum), analisis kebutuhan pengguna, wireframing mockup, dan pengujian QA.',
                    'K3LH Kerja Komputer & Etika IT' => 'Murid menerapkan postur ergonomis duduk di depan monitor komputer, istirahat mata berkala, etika hak cipta lisensi open source, dan perlindungan privasi data.',
                    'Perancangan Basis Data' => 'Murid terampil membuat Entity Relationship Diagram (ERD), normalisasi tabel 1NF s.d. 3NF, dan menulis query dasar DDL/DML SQL (SELECT, INSERT, UPDATE, JOIN).',
                    'Pemrograman Berorientasi Objek (OOP)' => 'Murid mampu menerapkan konsep class, object, attribute, method, encapsulation, inheritance pewarisan, dan polymorphism dalam bahasa pemrograman modern.',
                ]
            ],
            [
                'mapel' => 'Rekayasa Perangkat Lunak',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu membangun aplikasi web dinamis berskala enterprise berbasis framework modern (Laravel/Node.js); merancang arsitektur backend RESTful API; mengelola basis data relasional MySQL/PostgreSQL dan caching Redis; menerapkan version control Git kolaboratif; serta menerapkan pengujian perangkat lunak dan deployment.',
                'elemen' => [
                    'Pengembangan Backend dengan Framework Modern' => 'Murid mampu mengimplementasikan routing, controller, model Eloquent ORM, middleware otorisasi JWT/Sanctum, validasi form, dan template engine.',
                    'Perancangan & Dokumentasi RESTful API' => 'Murid mampu membangun endpoint API CRUD yang aman, paginasi respons JSON, status code HTTP standar, dan dokumentasi interaktif dengan Postman/Swagger.',
                    'Optimasi Basis Data & Keamanan Web' => 'Murid mampu melakukan indexing database, transaksi database ACID, proteksi serangan SQL Injection, XSS, CSRF, dan enkripsi hashing password bcrypt.',
                    'Version Control Git & Deployment Server' => 'Murid terampil menggunakan alur kerja git commit, branch, merge conflict, pull request di GitHub/GitLab, dan deployment ke server hosting Linux VPS/cloud.',
                ]
            ],
            [
                'mapel' => 'Pemrograman Web dan Perangkat Bergerak',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang antarmuka pengguna interaktif (UI/UX) responsif; membangun frontend aplikasi web single-page (SPA); dan mengembangkan aplikasi mobile Android multiplatform menggunakan framework modern (Flutter/React Native) terintegrasi backend service.',
                'elemen' => [
                    'Desain UI/UX & Prototipe Interaktif' => 'Murid mampu melakukan riset pengguna (user persona), membuat wireframe, merancang user interface interaktif di Figma, dan menerapkan prinsip Design System.',
                    'Frontend Web Modern & Responsif' => 'Murid menguasai HTML5 semantik, CSS3 modern flexbox dan grid, framework TailwindCSS/Bootstrap, serta JavaScript asynchronous fetch API.',
                    'Pengembangan Aplikasi Mobile Multiplatform' => 'Murid mampu membuat tata letak layout widget mobile, navigasi routing antar layar, manajemen state (Provider/Riverpod/Bloc), dan konsumsi API data.',
                    'Akses Fitur Native Perangkat Bergerak' => 'Murid mampu mengintegrasikan fitur native gawai smartphone: kamera, GPS lokasi geolokasi, penyimpanan lokal SQLite, dan push notification.',
                ]
            ],
            [
                'mapel' => 'Pengembangan Gim',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang dokumen desain gim (Game Design Document); memprogram logika dan mekanik permainan pada game engine (Unity/Godot C#); membuat aset grafis sprite 2D dan model 3D gim; mengintegrasikan efek suara latar; serta mempublikasikan gim ke platform digital.',
                'elemen' => [
                    'Game Design & Mechanics' => 'Murid mampu menyusun Game Design Document (GDD), merancang alur gameplay loop, aturan main tantangan, sistem skor poin, dan tingkatan level difficulty.',
                    'Game Programming & Physics' => 'Murid terampil menulis script C#/GDScript untuk pergerakan karakter pemain, deteksi benturan (collision detection), sistem gravitasi fisika, dan kecerdasan buatan musuh (enemy AI pathfinding).',
                    'Pembuatan Aset Grafis & Audio Gim' => 'Murid mampu membuat spritesheet animasi karakter berjalan/melompat, tileset latar lingkungan, efek partikel ledakan, dan mixing audio sound effect SFX.',
                    'Testing, Optimization, and Publishing' => 'Murid terampil melakukan playtesting debugging bug performa frame rate (FPS), optimasi ukuran build, dan ekspor game installer PC/Android.',
                ]
            ],

            // ================= 19. TEKNIK JARINGAN KOMPUTER DAN TELEKOMUNIKASI (TJKT) =================
            [
                'mapel' => 'Dasar-dasar Teknik Jaringan Komputer dan Telekomunikasi',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis industri jaringan dan ISP; profesi network engineer dan cyber security; K3LH instalasi jaringan; model referensi OSI Layer dan TCP/IP; pengkabelan UTP standar T568A/B; pengalamatan IP Address IPv4 dan subnetting CIDR; serta konfigurasi dasar switch dan router.',
                'elemen' => [
                    'Proses Bisnis Telekomunikasi & Perkembangan Jaringan' => 'Murid memahami alur layanan ISP (Internet Service Provider), jaringan seluler 4G/5G, fiber to the home (FTTH), dan cloud computing.',
                    'K3LH Instalasi Jaringan & Server' => 'Murid menerapkan keselamatan kerja panjat tower BTS pemancar, APD full body harness, penataan kabel server rapi (cable management), dan keselamatan listrik rak server.',
                    'OSI Layer & Subnetting IPv4' => 'Murid memahami fungsi 7 layer OSI, perancangan IP address kelas A, B, C, teknik subnetting VLSM / CIDR untuk efisiensi alokasi host jaringan.',
                    'Pengkabelan & Konfigurasi Dasar Jaringan' => 'Murid terampil mengupas kabel UTP, crimping konektor RJ-45, menguji dengan cable tester LAN, dan konfigurasi IP address pada perangkat end-device.',
                ]
            ],
            [
                'mapel' => 'Teknik Komputer dan Jaringan',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mengkonfigurasi routing statis dan dinamis (OSPF, BGP) pada router Mikrotik dan Cisco; membangun Virtual LAN (VLAN) dan inter-VLAN routing; mengelola bandwidth dengan Queue Tree; menginstalasi dan mengadministrasi server Linux (DHCP, DNS, Web, Mail, FTP); serta virtualisasi server.',
                'elemen' => [
                    'Routing Jaringan Skala Menengah & Besar' => 'Murid mampu mengkonfigurasi tabel routing statis failover jalur redundan, routing dinamis OSPF multiarea, dan routing border gateway protocol BGP.',
                    'Switching Tingkat Lanjut & VLAN' => 'Murid terampil membuat VLAN ID pada manageable switch, trunking IEEE 802.1Q, spanning tree protocol (STP) anti-looping, dan port security.',
                    'Manajemen Bandwidth & Keamanan Jaringan' => 'Murid mampu menyetel firewall filter rules, NAT masquerade, web proxy pembatas akses konten, dan pembagian kuota bandwidth merata dengan Simple Queue/PCQ.',
                    'Administrasi Server Linux & Virtualisasi' => 'Murid mampu menginstal sistem operasi server Ubuntu/Debian, konfigurasi layanan bind9 DNS, apache2/nginx web server, database mariadb, dan virtualisasi Proxmox/VMware.',
                ]
            ],
            [
                'mapel' => 'Keamanan Jaringan dan Siber (Cyber Security)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid memahami prinsip keamanan informasi (Confidentiality, Integrity, Availability); menganalisis ancaman siber (malware, phishing, brute force, DDoS); mengkonfigurasi firewall Next-Generation dan Intrusion Detection/Prevention System (IDS/IPS); melakukan vulnerability assessment; serta menerapkan respons insiden keamanan siber.',
                'elemen' => [
                    'Prinsip Keamanan Siber & Kriptografi' => 'Murid memahami mekanisme enkripsi simetris/asimetris AES dan RSA, hashing SHA-256, digital signature, sertifikat SSL/TLS HTTPS, dan autentikasi dua faktor (2FA).',
                    'Vulnerability Assessment & Network Defense' => 'Murid terampil menggunakan software port scanning Nmap, vulnerability scanner Wireshark membaca paket data mencurigakan, dan menutup celah port terbuka.',
                    'Implementasi IDS/IPS & Hardening Server' => 'Murid mampu mengkonfigurasi Snort/Suricata mendeteksi pola serangan hacker secara real-time, mengaktifkan fail2ban penangkal brute force, dan hardening izin akses SSH.',
                    'Incident Response & Digital Forensics Dasar' => 'Murid mampu menganalisis log sistem auth.log, mengisolasi host komputer terinfeksi malware, menyusun laporan kronologi insiden siber, dan prosedur data backup.',
                ]
            ],

            // ================= 20. AKUNTANSI DAN KEUANGAN LEMBAGA (AKL) =================
            [
                'mapel' => 'Dasar-dasar Akuntansi dan Keuangan Lembaga',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis akuntansi di era digital; profesi akuntan dan etika bisnis; K3LH perkantoran; prinsip dasar akuntansi dan persamaan dasar akuntansi; siklus akuntansi perusahaan jasa; serta pengelolaan transaksi kas kecil (petty cash) dan perbankan dasar.',
                'elemen' => [
                    'Proses Bisnis Akuntansi & Fintech' => 'Murid memahami alur transaksi keuangan, bukti transaksi faktur/kuitansi/nota, dan pemanfaatan sistem pembayaran digital serta software akuntansi modern.',
                    'Etika Profesi & K3 Lingkungan Kerja' => 'Murid menjunjung integritas kode etik akuntan, kerahasiaan data keuangan perusahaan, dan kenyamanan ergonomis bekerja di kantor akuntansi.',
                    'Persamaan Dasar & Jurnal Umum' => 'Murid menguasai analisis debit-kredit persamaan akuntansi (Harta = Utang + Modal), pencatatan transaksi ke buku jurnal umum, dan posting ke buku besar.',
                    'Pengelolaan Kas Kecil' => 'Murid terampil menyusun laporan mutasi dana kas kecil menggunakan metode dana tetap (imprest fund system) dan metode fluktuasi (fluctuating fund system).',
                ]
            ],
            [
                'mapel' => 'Akuntansi Keuangan dan Lembaga',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu mengelola siklus akuntansi perusahaan dagang dan manufaktur (metode harga pokok pesanan/proses); mengoperasikan program komputer akuntansi (MYOB/Accurate); mengelola administrasi perpajakan (PPh pasal 21, PPh final, PPN) via e-Faktur dan e-Billing; serta menyusun laporan keuangan lengkap sesuai SAK ETAP.',
                'elemen' => [
                    'Akuntansi Perusahaan Dagang & Manufaktur' => 'Murid mampu mencatat jurnal khusus pembelian/penjualan, kartu persediaan barang dagang FIFO/Moving Average, menghitung HPP (Harga Pokok Penjualan), dan laporan laba-rugi.',
                    'Komputerisasi Akuntansi (Accurate/MYOB)' => 'Murid terampil membuat data awal perusahaan, setup daftar akun (chart of accounts), input saldo awal, entri transaksi harian, dan mencetak laporan neraca saldo otomatis.',
                    'Administrasi Perpajakan' => 'Murid mampu menghitung Pajak Penghasilan (PPh) Pasal 21 karyawan tetap/tidak tetap berdasarkan tarif PTKP terbaru, menghitung PPN 11%, dan membuat surat setoran pajak (SSP).',
                    'Akuntansi Lembaga / Instansi Pemerintah' => 'Murid memahami siklus akuntansi keuangan daerah/desa, pencatatan pendapatan dan belanja anggaran (APBD), serta penyusunan laporan realisasi anggaran (LRA).',
                ]
            ],
            [
                'mapel' => 'Perbankan dan Keuangan Syariah',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid menguasai operasional bank umum dan bank syariah; pelayanan prima front-liner (teller dan customer service); administrasi simpanan tabungan, giro, dan deposito; akad pembiayaan syariah (mudharabah, musyarakah, murabahah, ijarah); serta analisis kelayakan kredit/pembiayaan.',
                'elemen' => [
                    'Operasional Layanan Perbankan Front-liner' => 'Murid terampil melayani nasabah pembukaan rekening tabungan, transaksi setoran dan penarikan tunai teller, verifikasi keaslian uang tunai rupiah, dan penanganan keluhan nasabah.',
                    'Akad Pembiayaan Bank Syariah' => 'Murid memahami rukun dan syarat akad titipan wadiah, pembiayaan bagi hasil mudharabah musyarakah, jual beli murabahah, dan sewa ijarah sesuai fatwa DSN-MUI.',
                    'Analisis Kelayakan Pembiayaan / Kredit' => 'Murid mampu melakukan survei kelayakan nasabah berdasarkan prinsip 5C (Character, Capacity, Capital, Collateral, Condition), penilaian jaminan agunan, dan mitigasi risiko kredit macet.',
                ]
            ],

            // ================= 21. MANAJEMEN PERKANTORAN (MPLB) =================
            [
                'mapel' => 'Dasar-dasar Manajemen Perkantoran dan Layanan Bisnis',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis manajemen perkantoran; perkembangan otomasi kantor dan paperless office; profesi sekretaris dan staf administrasi; K3LH perkantoran; tata kelola dokumen persuratan; teknik mengetik cepat 10 jari; dan pelayanan prima (service excellence).',
                'elemen' => [
                    'Proses Bisnis Perkantoran Digital' => 'Murid memahami fungsi manajemen perencanaan pengorganisasian kantor, penggunaan cloud computing administrasi, dan sistem surat elektronik dinas.',
                    'K3LH & Ergonomi Perkantoran' => 'Murid menerapkan 5R perkantoran, penataan tata ruang kantor (office layout), pencahayaan meja kerja, dan prosedur tanggap darurat gedung kantor.',
                    'Komunikasi Bisnis & Service Excellence' => 'Murid terampil melakukan etika berkomunikasi telepon bisnis secara ramah profesional, menyambut tamu pimpinan kantor, dan koordinasi internal.',
                    'Dasar Pengelolaan Dokumen & Mengetik Cepat' => 'Murid mahir mengetik 10 jari buta (blind typing) minimal kecepatan 200 EPM dengan akurasi 98%, serta pengindeksan surat sistem abjad/nomor.',
                ]
            ],
            [
                'mapel' => 'Manajemen Perkantoran (Otomatisasi Tata Kelola Perkantoran)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mengelola kearsipan digital (electronic records management); menyusun korespondensi bisnis bahasa Indonesia dan Inggris; mengorganisasi rapat offline dan virtual; mengatur jadwal agenda pimpinan; menangani kas kecil pimpinan; serta tata keprotokolan acara resmi instansi.',
                'elemen' => [
                    'Pengelolaan Arsip Digital' => 'Murid mampu melakukan pemindaian dokumen (scanning), penyimpanan metadata arsip berbasis database dokumen elektronik, temu balik arsip cepat, dan retensi pemusnahan arsip.',
                    'Korespondensi Bisnis & Notula Rapat' => 'Murid terampil menyusun surat penawaran, surat pesanan, surat perjanjian kerja sama (MoU), surat undangan dinas, serta membuat notula rapat resmi komprehensif.',
                    'Pengelolaan Agenda Pimpinan & Perjalanan Dinas' => 'Murid mampu menyusun jadwal rapat pimpinan menggunakan Google Calendar/Outlook, pemesanan tiket transportasi akomodasi perjalanan dinas, dan laporan biaya perjalanan.',
                    'Keprotokolan & Hubungan Masyarakat (Humas)' => 'Murid terampil mengatur tata upacara bendera, tata tempat (seating arrangement) pejabat VIP, pembawa acara (MC) formal, dan publikasi siaran pers ke media.',
                ]
            ],

            // ================= 22. KULINER (TATA BOGA) =================
            [
                'mapel' => 'Dasar-dasar Kuliner',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis industri kuliner dan restoran; perkembangan gastronomi modern; profesi chef dan culinary entrepreneur; K3 dan sanitasi hygiene makanan (HACCP); peralatan dapur komersial; teknik dasar memotong sayuran (knife skills); serta teknik dasar pengolahan makanan basah dan kering.',
                'elemen' => [
                    'Proses Bisnis Kuliner & Tren Gastronomi' => 'Murid memahami alur operasional dapur hotel, food delivery digital, tren pangan sehat nabati (plant-based), dan konsep cloud kitchen.',
                    'Sanitasi Higiene Makanan & K3 Dapur' => 'Murid terampil menerapkan personal hygiene juru masak (celemek, topi chef, cuci tangan), penyimpanan suhu dingin chiller/freezer, pencegahan kontaminasi silang, dan K3 pisau/kompor panas.',
                    'Keterampilan Pisau (Knife Skills) & Bumbu Dasar' => 'Murid mahir memotong potongan sayuran standar (julienne, brunoise, chiffonade, mirepoix) dan meracik bumbu dasar putih, kuning, merah nusantara.',
                    'Teknik Dasar Pengolahan Makanan' => 'Murid menguasai metode memasak panas basah (boiling, poaching, steaming) dan panas kering (roasting, grilling, deep frying, sauteing).',
                ]
            ],
            [
                'mapel' => 'Kuliner (Tata Boga)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu mengolah, menata, dan menyajikan hidangan pembuka (appetizer), hidangan utama (main course), dan hidangan penutup (dessert) masakan nusantara, kontinental (Eropa), dan oriental (Asia); merancang menu restoran seimbang; melakukan food plating artistik; serta menghitung food cost dan harga jual hidangan.',
                'elemen' => [
                    'Pengolahan Makanan Kontinental (Western)' => 'Murid mampu membuat kaldu dasar putih (white stock) dan cokelat (brown stock), aneka saus induk (mother sauces), sup krim kental, hidangan daging steak unggas pasta, dan garnish modern.',
                    'Pengolahan Makanan Nusantara Tradisional' => 'Murid terampil mengolah aneka soto nusantara, olahan rendang Minang, nasi tumpeng komplit, aneka olahan ikan laut sambal tradisional, dan kue jajanan pasar.',
                    'Pengolahan Makanan Oriental (Asian Cuisine)' => 'Murid terampil memasak hidangan Chinese wok cooking (capcay, fuyunghai), hidangan Jepang (sushi, teriyaki), dan masakan Thailand tom yum bercita rasa otentik.',
                    'Perencanaan Menu & Cost Control F&B' => 'Murid mampu menyusun standard recipe card, menghitung porsi bahan baku, menetapkan food cost percentage standar 30-35%, dan harga jual menu kompetitif.',
                ]
            ],
            [
                'mapel' => 'Pastry dan Bakery',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil membuat berbagai macam produk roti (bread/bakery: roti manis, roti tawar, sourdough); adonan kue kering (cookies); pastry berlipat (croissant, danish, puff pastry); kue tart modern (cake decorator); serta permen dan cokelat praline confectionery.',
                'elemen' => [
                    'Pembuatan Produk Bakery & Roti Beragi' => 'Murid mampu menghitung persentase formula baker (baker percentage), pengulenan gluten kalis, fermentasi proofing adonan, dan pemanggangan oven suhu presisi.',
                    'Pastry Berlipat (Laminated Dough)' => 'Murid terampil melakukan teknik laminasi melipat mentega korsvet/dry butter, pembuatan lapisan renyah croissant, pain au chocolat, dan fruit danish pastry.',
                    'Dekorasi Cake Modern & Kue Pengantin' => 'Murid terampil membuat sponge cake, gateau, pemolesan butter cream halus, teknik siram cokelat ganache mengkilap (mirror glaze), dan hiasan fondant gula artistik.',
                    'Confectionery & Cokelat Praline' => 'Murid menguasai teknik tempering cokelat couverture pada kurva suhu tepat, pencetakan cokelat praline aneka isian ganache, dan pembuatan permen.',
                ]
            ],

            // ================= 23. PERHOTELAN =================
            [
                'mapel' => 'Dasar-dasar Perhotelan',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis industri perhotelan bintang; karakteristik wisatawan; profesi hotelier; K3LH lingkungan hotel; struktur organisasi departemen hotel; pengenalan tata graha (housekeeping); dan dasar penerima tamu (front office).',
                'elemen' => [
                    'Industri Hospitality & Karakteristik Tamu' => 'Murid memahami klasifikasi hotel melati hingga bintang 5, fasilitas hotel, tipe tamu individual/rombongan, dan etika hospitaliti kelas dunia.',
                    'K3LH & Keamanan Hotel' => 'Murid menerapkan standar sanitasi kamar, penanganan kunci master kamar (key control), jalur evakuasi kebakaran hotel, dan pencegahan kecelakaan kerja housekeeping.',
                    'Dasar Layanan Kantor Depan (Front Office)' => 'Murid memahami siklus tamu (pre-arrival, arrival, occupancy, departure), tata cara menyapa tamu ramah, dan penanganan penitipan barang bawaan koper tamu.',
                    'Dasar Tata Graha (Housekeeping)' => 'Murid mengenal jenis linen hotel, bahan pembersih kimia (cleaning chemical), alat pembersih manual/mesin, dan standar kebersihan kamar tidur.',
                ]
            ],
            [
                'mapel' => 'Perhotelan (Akomodasi Perhotelan)',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mengoperasikan sistem reservasi kantor depan berbasis PMS (Property Management System); registrasi check-in dan pembayaran check-out kasir tamu; layanan telepon operator; pembersihan dan perapian tempat tidur kamar tamu (making bed); pembersihan area publik; serta operasional laundry hotel.',
                'elemen' => [
                    'Reservasi & Operasional Kantor Depan (PMS)' => 'Murid mampu mengoperasikan software hotel PMS, menginput data reservasi individu/online travel agent (OTA), penetapan nomor kamar, dan penanganan check-in tamu VIP.',
                    'Layanan Kasir Kantor Depan (Front Office Cashier)' => 'Murid terampil mencatat tagihan kamar dan konsumsi restoran ke rekening tamu (guest folio), transaksi pembayaran tunai/kartu kredit, dan penukaran valuta asing.',
                    'Pembersihan Kamar Tamu (Making Bed)' => 'Murid mahir menata troli room attendant, teknik perapian tempat tidur 3 lembar sprei sudut segitiga 45 derajat (hospital corner), pembersihan kamar mandi (sanitizing), dan replenishing amenities.',
                    'Tata Graha Area Publik & Laundry' => 'Murid terampil mengoperasikan mesin poles lantai scrubber di lobby hotel, pemilahan linen kotor, pengoperasian mesin cuci komersial/pengering, dan penyetrikaan uap (roller ironer).',
                ]
            ],

            // ================= 24. DESAIN KOMUNIKASI VISUAL (DKV) =================
            [
                'mapel' => 'Dasar-dasar Desain Komunikasi Visual',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami industri kreatif DKV dan agensi periklanan; profesi desainer grafis; K3LH studio desain; unsur rupa dan prinsip tata letak (nirmana dwimatra); tipografi huruf; teknik sketsa gambar bentuk; serta dasar software grafis vektor dan bitmap.',
                'elemen' => [
                    'Industri Kreatif DKV & Hak Cipta' => 'Murid memahami alur kerja agensi kreatif, etika periklanan, hak cipta karya visual, dan pemanfaatan media digital dalam promosi visual.',
                    'Nirmana & Komposisi Visual' => 'Murid menguasai unsur garis, bentuk, bidang, warna (lingkaran warna komplementer/analog), keseimbangan, kontras, ritme, dan kesatuan tata letak.',
                    'Tipografi & Sketsa Manual' => 'Murid mengidentifikasi klasifikasi huruf serif, sans serif, script, display, anatomi huruf, legibility, dan terampil membuat sketsa ide rancang cepat (rough thumbnail sketch).',
                    'Pengenalan Perangkat Lunak Desain Grafis' => 'Murid mampu mengoperasikan perkakas seleksi, shape pen tool, pathfinder, layer, dan palet warna pada software vektor (Adobe Illustrator/CorelDraw) dan bitmap (Adobe Photoshop).',
                ]
            ],
            [
                'mapel' => 'Desain Komunikasi Visual',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid mampu merancang identitas visual merek (logo branding dan Corporate Identity Graphic Standard Manual); desain publikasi cetak dan digital (poster, majalah, billboard); desain kemasan produk 3D (packaging prototype); fotografi produk studio; serta perancangan antarmuka pengguna UI/UX aplikasi digital.',
                'elemen' => [
                    'Branding & Identitas Visual Korporat' => 'Murid mampu merumuskan konsep brand positioning, merancang logo filosofis, warna korporat, kartu nama, kop surat, dan menyusun Graphic Standard Manual (GSM).',
                    'Desain Kemasan Produk (Packaging Design)' => 'Murid mampu membuat jaring-jaring pisau die-cut pola kotak kemasan kardus/label botol, pemilihan material ramah lingkungan, tipografi informasi nilai gizi, dan mockup kemasan 3D realistis.',
                    'Fotografi Komersial & Editing Digital' => 'Murid menguasai teknik pencahayaan studio 3 titik lampu (key, fill, rim light), pengaturan segitiga eksposur kamera DSLR/mirrorless, fotografi produk katalog, dan editing retouching foto.',
                    'Desain Publikasi & Antarmuka UI/UX' => 'Murid terampil merancang desain majalah multipage layout di InDesign, aset konten iklan media sosial Instagram/TikTok, dan antarmuka aplikasi mobile UI/UX Figma.',
                ]
            ],

            // ================= 25. PEMASARAN & BISNIS DIGITAL =================
            [
                'mapel' => 'Dasar-dasar Pemasaran',
                'fase' => 'E',
                'deskripsi' => 'Pada akhir fase E, murid memahami proses bisnis retail dan e-commerce; perkembangan pemasaran digital dan omnichannel; profesi pemasar dan affiliate marketer; K3LH lingkungan toko; bauran pemasaran (Marketing Mix 4P/7P); perilaku konsumen; dan dasar pelayanan pelanggan.',
                'elemen' => [
                    'Proses Bisnis Pemasaran & Era Omnichannel' => 'Murid memahami pergeseran toko fisik konvensional ke platform marketplace digital, integrasi data penjualan daring dan luring, dan sistem logistik drop-shipping.',
                    'Perilaku Konsumen & Bauran Pemasaran' => 'Murid mampu menganalisis faktor motivasi belanja konsumen, segmentasi pasar, penargetan (targeting), penentuan posisi produk (positioning), dan formula 4P (Product, Price, Place, Promotion).',
                    'Komunikasi Negosiasi & Layanan Pelanggan' => 'Murid terampil berkomunikasi persuasif dalam menawarkan produk, menangani penolakan konsumen (handling objection), dan membangun loyalitas pelanggan.',
                    'K3LH Toko Ritel & Penataan Produk' => 'Murid menerapkan standar penataan lorong belanja bebas hambatan, pencegahan kehilangan barang (shoplifting), dan ergonomi kerja kasir kasir ritel.',
                ]
            ],
            [
                'mapel' => 'Bisnis Digital dan Pemasaran Ritel',
                'fase' => 'F',
                'deskripsi' => 'Pada akhir fase F, murid terampil mengelola toko online di marketplace (Shopee/Tokopedia/TikTok Shop); merancang kampanye iklan digital berbayar (Meta Ads, Google Ads); optimasi mesin pencari (SEO); live streaming selling interaktif; pengelolaan visual merchandising toko ritel modern; serta operasional mesin kasir Point of Sale (POS).',
                'elemen' => [
                    'Manajemen Toko Marketplace & Live Selling' => 'Murid mampu membuka toko daring, mengunggah foto produk berdeskripsi copywriting menjual, menyetel diskon voucher toko, dan memandu siaran langsung penjualan live streaming.',
                    'Periklanan Digital (Paid Traffic) & Analitik' => 'Murid terampil merancang target audiens demografi/minat, menyetel budget anggaran iklan harian, menganalisis matriks performa iklan (CTR, CPC, ROAS), dan retargeting pixel.',
                    'Visual Merchandising & Display Produk Ritel' => 'Murid terampil menata produk di rak gondola supermarket sesuai kategori (eye-level display, end-cap gondola, impulse buying area), serta menjaga ketersediaan label harga (price tagging).',
                    'Operasional Kasir & Laporan Penjualan Ritel' => 'Murid mampu mengoperasikan barcode scanner, cash drawer, mesin kasir POS, menerima pembayaran kartu debit/QRIS, cetak struk nota belanja, dan rekonsiliasi kas harian.',
                ]
            ],
        ];

        // Seeding predefined rich CPs
        $seededMapelNames = [];
        foreach ($cpList as $item) {
            $faseObj = ($item['fase'] === 'E') ? $faseE : $faseF;
            $mapelObj = MataPelajaran::where('nama', $item['mapel'])->first();

            if ($mapelObj) {
                CapaianPembelajaran::updateOrCreate(
                    [
                        'mata_pelajaran_id' => $mapelObj->id,
                        'fase_id' => $faseObj->id,
                    ],
                    [
                        'regulasi' => 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025',
                        'deskripsi_cp' => $item['deskripsi'],
                        'elemen_cp' => json_encode($item['elemen']),
                        'is_active' => true,
                    ]
                );
                $seededMapelNames[$mapelObj->id . '_' . $faseObj->id] = true;
            }
        }

        // ================= UNIVERSAL SAFETY FALLBACK =================
        // Menjamin bahwa 100% Mata Pelajaran di database PASTI MEMILIKI CP (Fase E atau F)
        // Jika belum ada di list di atas, generate deskripsi CP dan elemen kompetensi berstandar resmi
        $allMapels = MataPelajaran::with('programKeahlian')->get();
        foreach ($allMapels as $m) {
            // Tentukan Fase yang relevan
            $targetFases = [];
            if (str_starts_with($m->nama, 'Dasar-dasar ') || in_array($m->nama, ['Informatika', 'Projek Ilmu Pengetahuan Alam dan Sosial (IPAS)', 'Seni Budaya'])) {
                $targetFases = [$faseE];
            } elseif ($m->kelompok === 'kejuruan') {
                // Mapel kejuruan konsentrasi, PKK, PKL
                $targetFases = [$faseF];
            } else {
                // Mapel umum wajib (Agama, Pancasila, B. Indo, B. Ing, MTK, Sejarah, PJOK)
                $targetFases = [$faseE, $faseF];
            }

            foreach ($targetFases as $targetFase) {
                $key = $m->id . '_' . $targetFase->id;
                if (!isset($seededMapelNames[$key])) {
                    $existing = CapaianPembelajaran::where('mata_pelajaran_id', $m->id)
                        ->where('fase_id', $targetFase->id)
                        ->first();

                    if (!$existing) {
                        $isDasar = str_starts_with($m->nama, 'Dasar-dasar ');
                        $progName = $m->programKeahlian ? $m->programKeahlian->nama : $m->nama;

                        if ($isDasar) {
                            $desc = "Pada akhir fase E, murid memahami proses bisnis menyeluruh industri pada bidang {$progName}, perkembangan teknologi terkini dan isu-isu global, profesi technopreneur dan peluang usaha/pekerjaan, Keselamatan dan Kesehatan Kerja serta Lingkungan Hidup (K3LH), serta penguasaan keterampilan teknis dasar kejuruan {$progName}.";
                            $elements = [
                                "Proses Bisnis Menyeluruh Industri {$progName}" => "Murid memahami alur perencanaan, rantai pasok, proses produksi, pengelolaan sumber daya, dan kepuasan pelanggan pada industri {$progName}.",
                                "Perkembangan Teknologi & Isu Global" => "Murid memahami transformasi digital, otomatisasi cerdas, revolusi industri 4.0, dan isu keberlanjutan lingkungan pada bidang {$progName}.",
                                "Technopreneurship & Peluang Kerja" => "Murid mengenali profil profesi kerja, peluang kewirausahaan mandiri (technopreneur), dan etika profesi bidang {$progName}.",
                                "Keselamatan dan Kesehatan Kerja (K3LH)" => "Murid mampu menerapkan APD standar, prosedur penanganan bahaya kerja, pencegahan kecelakaan, dan budaya kerja 5R/5S.",
                                "Teknik & Keterampilan Dasar Kejuruan" => "Murid terampil menggunakan peralatan kerja, instrumen pengukuran, membaca gambar/dokumen teknis, dan praktik dasar kejuruan {$progName}.",
                            ];
                        } elseif ($targetFase->kode === 'F') {
                            $desc = "Pada akhir fase F, murid memiliki penguasaan kompetensi keahlian terapan tingkat lanjut, keterampilan teknis vokasional profesional, penyelesaian masalah operasional industri nyata, standar mutu kerja berstandar industri, dan etika kerja pada mata pelajaran {$m->nama}.";
                            $elements = [
                                "Penguasaan Konsep Teknis & Prosedur Lanjut" => "Murid memahami prinsip kerja sistem, standarisasi industri, regulasi operasional, dan metodologi kerja profesional pada {$m->nama}.",
                                "Keterampilan Praktik Operasional Industri" => "Murid terampil melaksanakan pekerjaan teknis, pengoperasian mesin/perangkat lunak/peralatan berstandar industri sesuai SOP pada {$m->nama}.",
                                "Troubleshooting & Pemeliharaan Kinerja" => "Murid mampu mendiagnosis gangguan sistem, melakukan perbaikan teknis secara tepat, dan pemeliharaan preventif pada {$m->nama}.",
                                "Kontrol Kualitas (QC) & Standar Hasil Kerja" => "Murid mampu menguji dan mengevaluasi hasil kerja, memastikan kesesuaian spesifikasi toleransi mutu produk/jasa, dan dokumentasi kerja teknis.",
                            ];
                        } else {
                            $desc = "Pada akhir fase E, murid mampu menguasai kompetensi dasar, keterampilan berpikir analitis, dan penerapan praktis pada mata pelajaran {$m->nama} dalam konteks kehidupan sehari-hari dan dunia kerja kejuruan.";
                            $elements = [
                                "Pemahaman Konsep Inti" => "Murid menguasai konsep teoretis dan prinsip dasar pada mata pelajaran {$m->nama}.",
                                "Keterampilan Penerapan Praktis" => "Murid mampu menerapkan konsep untuk memecahkan persoalan kontekstual kejuruan.",
                                "Refleksi & Komunikasi Hasil Belajar" => "Murid mampu mengomunikasikan ide, argumen, dan solusi secara sistematis dan kritis.",
                            ];
                        }

                        CapaianPembelajaran::create([
                            'mata_pelajaran_id' => $m->id,
                            'fase_id' => $targetFase->id,
                            'regulasi' => 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025',
                            'deskripsi_cp' => $desc,
                            'elemen_cp' => json_encode($elements),
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
