<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use App\Models\Fase;
use App\Models\KurikulumMateri;

class KurikulumMateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faseE = Fase::where('kode', 'E')->first();
        $faseF = Fase::where('kode', 'F')->first();

        $data = [
            // =========================================================================
            // 1. MATEMATIKA (FASE E & F)
            // =========================================================================
            [
                'mapel' => 'Matematika',
                'fase_id' => $faseE?->id,
                'elemen' => 'Bilangan (Eksponen & Logaritma)',
                'topik' => 'Eksponen, Bentuk Akar, dan Logaritma',
                'sub_materi' => [
                    'Sifat-sifat Operasi Pangkat Bulat dan Pecahan',
                    'Merasionalkan Bentuk Akar dan Operasi Aljabar Bentuk Akar',
                    'Definisi dan Sifat-sifat Logaritma Basis 10 dan Basis Natural',
                    'Penerapan Eksponensial dalam Pertumbuhan Mikroba dan Bunga Majemuk Perbankan'
                ],
                'rangkuman' => "RINGKASAN MATERI: EKSPONEN, BENTUK AKAR, DAN LOGARITMA (FASE E)\n\n"
                    . "1. KONSEP DAN SIFAT OPERASI EKSPONEN:\n"
                    . "Eksponen menyatakan perkalian berulang bilangan real yang sama. Secara formal, untuk bilangan real a dan bilangan bulat positif n, a^n = a x a x ... x a sebanyak n faktor. Sifat-sifat mendasar:\n"
                    . "• a^m x a^n = a^(m+n)\n"
                    . "• a^m : a^n = a^(m-n) untuk a != 0\n"
                    . "• (a^m)^n = a^(m.n)\n"
                    . "• (a.b)^n = a^n . b^n\n"
                    . "• a^(-n) = 1 / (a^n) dan a^0 = 1 (a != 0)\n"
                    . "• Pangkat pecahan: a^(m/n) = akar pangkat n dari (a^m).\n\n"
                    . "2. MERASIONALKAN BENTUK AKAR:\n"
                    . "Bentuk akar merupakan bilangan irasional. Penyebut pecahan yang memuat akar dirasionalkan dengan mengalikan bentuk sekawan (akar sekawan):\n"
                    . "• c / sqrt(a) dikalikan sqrt(a)/sqrt(a) = (c/a) sqrt(a)\n"
                    . "• c / (a + sqrt(b)) dikalikan (a - sqrt(b)) / (a - sqrt(b)) = c(a - sqrt(b)) / (a^2 - b).\n\n"
                    . "3. DEFINISI DAN SIFAT LOGARITMA:\n"
                    . "Logaritma merupakan inversi (kebalikan) dari perpangkatan. Jika a^c = b dengan a > 0, a != 1, dan b > 0, maka ^a log(b) = c. Sifat pokok logaritma:\n"
                    . "• ^a log(x.y) = ^a log(x) + ^a log(y)\n"
                    . "• ^a log(x/y) = ^a log(x) - ^a log(y)\n"
                    . "• ^a log(x^n) = n . ^a log(x)\n"
                    . "• ^a log(b) = (^c log b) / (^c log a) = 1 / (^b log a)\n"
                    . "• a^(^a log b) = b.\n\n"
                    . "4. APLIKASI KONTEKSTUAL & REKAYASA KEJURUAN:\n"
                    . "Konsep eksponen dan logaritma diaplikasikan dalam penghitungan skala keasaman pH cairan kimia, peluruhan radioaktif material teknis, skala desibel (dB) intensitas bunyi pada tata suara, perhitungan gempa skala Richter, serta pemodelan pertumbuhan investasi bunga majemuk industri perbankan.",
                'pemahaman_bermakna' => "Peserta didik memahami bahwa pola eksponensial dan skala logaritma memungkinkan manusia menyederhanakan perhitungan angka-angka astronomis dan mikroskopis ke dalam skala terukur yang menjadi dasar teknologi sensor, akustik, dan finansial modern.",
                'pertanyaan_pemantik' => "1. Bagaimana cara para ilmuwan mengukur kekuatan gempa bumi atau kebisingan suara knalpot mesin secara akurat padahal energinya meningkat ribuan kali lipat?\n2. Mengapa bunga pinjaman bank atau peluruhan limbah industri dapat dihitung menggunakan konsep pangkat bilangan?",
                'kata_kunci' => ['basis', 'eksponen', 'akar sekawan', 'irasional', 'logaritma', 'bunga majemuk', 'peluruhan'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Nilai intensitas kebisingan suara di ruang produksi mesin giling diukur menggunakan persamaan logaritma TI = 10 log(I / I0) dB, di mana I adalah intensitas bunyi terukur dan I0 adalah intensitas ambang dengar 10^-12 W/m^2.",
                        'pertanyaan' => "Jika intensitas bunyi yang dihasilkan oleh mesin giling adalah 10^-4 W/m^2, maka taraf intensitas bunyi (TI) di ruang produksi tersebut adalah...",
                        'options' => [
                            'A' => '80 dB',
                            'B' => '70 dB',
                            'C' => '90 dB',
                            'D' => '60 dB',
                            'E' => '100 dB'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "TI = 10 log(10^-4 / 10^-12) = 10 log(10^8) = 10 x 8 = 80 dB.",
                        'indikator' => "Disajikan rumus intensitas bunyi berbasis logaritma, peserta didik dapat menghitung taraf intensitas kebisingan secara akurat."
                    ],
                    [
                        'stimulus' => "Dalam analisis dimensi komponen mekanik presisi, teknisi menemukan pecahan berpangkat akar: P = 12 / (3 + sqrt(3)).",
                        'pertanyaan' => "Bentuk rasional yang paling sederhana dari nilai P tersebut adalah...",
                        'options' => [
                            'A' => '6 - 2sqrt(3)',
                            'B' => '6 + 2sqrt(3)',
                            'C' => '4 - 2sqrt(3)',
                            'D' => '3 - sqrt(3)',
                            'E' => '12 - 4sqrt(3)'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Kalikan dengan bentuk sekawan (3 - sqrt(3))/(3 - sqrt(3)): P = 12(3 - sqrt(3)) / (3^2 - 3) = 12(3 - sqrt(3)) / 6 = 2(3 - sqrt(3)) = 6 - 2sqrt(3).",
                        'indikator' => "Disajikan bentuk pecahan irasional, peserta didik mampu merasionalkan penyebut dengan mengalikan bentuk sekawan secara tepat."
                    ],
                    [
                        'stimulus' => "Suatu bakteri pembusuk limbah organik dalam reaktor biologis membelah diri menjadi 2 setiap 20 menit. Pada awal pengamatan terdapat 150 bakteri.",
                        'pertanyaan' => "Jumlah populasi bakteri tersebut setelah waktu 2 jam inkubasi adalah...",
                        'options' => [
                            'A' => '9.600 bakteri',
                            'B' => '4.800 bakteri',
                            'C' => '7.200 bakteri',
                            'D' => '19.200 bakteri',
                            'E' => '2.400 bakteri'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Waktu t = 2 jam = 120 menit. Jumlah periode pembelahan n = 120 / 20 = 6 kali. Jumlah populasi = 150 x 2^6 = 150 x 64 = 9.600 bakteri.",
                        'indikator' => "Disajikan persoalan pertumbuhan eksponensial kontekstual, peserta didik mampu memodelkan dan menghitung jumlah populasi akhir secara presisi."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Sebuah mesin industri dibeli dengan harga Rp 50.000.000,00. Nilai mesin tersebut mengalami penyusutan eksponensial sebesar 10% setiap tahun dari nilai tahun sebelumnya. Hitunglah taksiran nilai jual mesin tersebut setelah 3 tahun pemakaian dan uraikan langkah perhitungan eksponensialnya secara sistematis!",
                        'kunci' => "Model: Nilai akhir = P(1 - r)^t = 50.000.000 x (1 - 0.10)^3 = 50.000.000 x (0.9)^3 = 50.000.000 x 0.729 = Rp 36.450.000,00.",
                        'indikator' => "Peserta didik dapat merumuskan model peluruhan eksponensial dan menghitung nilai depresiasi aset kejuruan secara tepat."
                    ]
                ]
            ],
            [
                'mapel' => 'Matematika',
                'fase_id' => $faseE?->id,
                'elemen' => 'Aljabar dan Fungsi',
                'topik' => 'Sistem Persamaan Linear & Fungsi Kuadrat',
                'sub_materi' => [
                    'Penyelesaian SPLDV dan SPLTV Metode Eliminasi-Substitusi',
                    'Karakteristik Grafik Fungsi Kuadrat (Diskriminan, Sumbu Simetri, Titik Puncak)',
                    'Aplikasi Fungsi Kuadrat dalam Pemodelan Laba Maksimum dan Lintasan Parabola'
                ],
                'rangkuman' => "RINGKASAN MATERI: SISTEM PERSAMAAN LINEAR & FUNGSI KUADRAT (FASE E)\n\n"
                    . "1. SISTEM PERSAMAAN LINEAR DUA & TIGA VARIABEL (SPLDV / SPLTV):\n"
                    . "Bentuk umum SPLDV: a1x + b1y = c1 dan a2x + b2y = c2. Metode penyelesaian mencakup Eliminasi (menghilangkan salah satu variabel), Substitusi (menggantikan variabel), dan Metode Gabungan.\n\n"
                    . "2. FUNGSI KUADRAT:\n"
                    . "Bentuk umum: f(x) = ax^2 + bx + c dengan a != 0. Karakteristik grafik parabola:\n"
                    . "• Jika a > 0 parabola membuka ke atas (memiliki titik minimum), jika a < 0 parabola membuka ke bawah (memiliki titik maksimum).\n"
                    . "• Diskriminan D = b^2 - 4ac: D > 0 (memotong sumbu X di 2 titik berbeda), D = 0 (menyinggung sumbu X di 1 titik), D < 0 (tidak memotong sumbu X / definit).\n"
                    . "• Sumbu simetri: x = -b / (2a).\n"
                    . "• Nilai ekstrim (optimum): y = -D / (4a).\n"
                    . "• Koordinat titik puncak / balik: (-b/(2a), -D/(4a)).\n\n"
                    . "3. APLIKASI BISNIS DAN REKAYASA TEKNIK:\n"
                    . "Fungsi kuadrat diterapkan dalam menghitung lintasan proyektil / air mancur, kekuatan lengkung jembatan gantung, serta perhitungan optimasi pendapatan usaha (Break-Even Point dan Profit Maksimum) dalam bidang kewirausahaan dan industri.",
                'pemahaman_bermakna' => "Peserta didik memahami bahwa sistem persamaan linear dan fungsi kuadrat adalah bahasa matematika universal untuk memodelkan titik keseimbangan ekonomi, optimalisasi laba, dan rancang bangun struktur rekayasa fisik.",
                'pertanyaan_pemantik' => "1. Bagaimana pengusaha dapat menentukan harga jual produk agar memperoleh laba paling maksimal tanpa kehilangan pembeli?\n2. Mengapa lintasan peluru atau lengkungan jembatan selalu berbentuk kurva lengkung parabola?",
                'kata_kunci' => ['eliminasi', 'substitusi', 'parabola', 'diskriminan', 'sumbu simetri', 'titik optimum', 'keuntungan maksimum'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Sebuah bengkel manufaktur memproduksi komponen dengan fungsi keuntungan harian f(x) = -2x^2 + 80x - 300 (dalam ribuan rupiah), di mana x menyatakan jumlah unit komponen yang diproduksi per hari.",
                        'pertanyaan' => "Jumlah unit komponen yang harus diproduksi setiap hari agar bengkel memperoleh keuntungan maksimal adalah...",
                        'options' => [
                            'A' => '20 unit',
                            'B' => '40 unit',
                            'C' => '25 unit',
                            'D' => '15 unit',
                            'E' => '30 unit'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Keuntungan maksimum dicapai pada absis titik puncak: x = -b / (2a) = -80 / (2 x (-2)) = -80 / -4 = 20 unit.",
                        'indikator' => "Disajikan fungsi kuadrat pemodelan laba, peserta didik mampu menentukan jumlah produksi optimum dengan konsep titik puncak."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Di sebuah toko peralatan teknik, harga 2 set obeng presisi dan 3 unit tang kombinasi adalah Rp 175.000,00, sedangkan harga 3 set obeng presisi dan 2 unit tang kombinasi dari tipe yang sama adalah Rp 190.000,00. Buatlah model persamaan linear (SPLDV) dari situasi tersebut dan tentukan harga 1 unit tang kombinasi!",
                        'kunci' => "Model: 2x + 3y = 175.000 dan 3x + 2y = 190.000. Eliminasi x: 6x + 9y = 525.000 dikurangi 6x + 4y = 380.000 -> 5y = 145.000 -> y = Rp 29.000,00 (harga 1 unit tang). Nilai x = Rp 44.000,00.",
                        'indikator' => "Peserta didik dapat merumuskan SPLDV dari permasalahan transaksi riil dan menyelesaikannya dengan metode aljabar baku."
                    ]
                ]
            ],
            [
                'mapel' => 'Matematika',
                'fase_id' => $faseE?->id,
                'elemen' => 'Geometri dan Trigonometri',
                'topik' => 'Perbandingan Trigonometri & Aplikasi Kemiringan',
                'sub_materi' => [
                    'Perbandingan Trigonometri Segitiga Siku-Siku (Sin, Cos, Tan, Cosec, Sec, Cotan)',
                    'Sudut-sudut Istimewa (0°, 30°, 45°, 60°, 90°)',
                    'Sudut Elevasi dan Depresi dalam Pengukuran Jarak dan Ketinggian Objek',
                    'Aturan Sinus dan Aturan Cosinus pada Segitiga Sembarang'
                ],
                'rangkuman' => "RINGKASAN MATERI: GEOMETRI DAN TRIGONOMETRI (FASE E)\n\n"
                    . "1. PERBANDINGAN TRIGONOMETRI SEGITIGA SIKU-SIKU:\n"
                    . "Pada segitiga siku-siku dengan sudut acuan theta:\n"
                    . "• sin(theta) = sisi depan / sisi miring (de/mi)\n"
                    . "• cos(theta) = sisi samping / sisi miring (sa/mi)\n"
                    . "• tan(theta) = sisi depan / sisi samping (de/sa) = sin(theta)/cos(theta)\n"
                    . "• Teorema Pythagoras: (depan)^2 + (samping)^2 = (miring)^2.\n\n"
                    . "2. NILAI SUDUT ISTIMEWA:\n"
                    . "• 30°: sin = 1/2, cos = 1/2 sqrt(3), tan = 1/3 sqrt(3)\n"
                    . "• 45°: sin = 1/2 sqrt(2), cos = 1/2 sqrt(2), tan = 1\n"
                    . "• 60°: sin = 1/2 sqrt(3), cos = 1/2, tan = sqrt(3).\n\n"
                    . "3. SUDUT ELEVASI DAN DEPRESI:\n"
                    . "Sudut elevasi adalah sudut antara garis pandang ke atas terhadap garis horizontal. Sudut depresi adalah sudut antara garis pandang ke bawah terhadap horizontal. Digunakan teknisi dalam instrumen Theodolite / Total Station untuk mengukur tinggi menara BTS, gedung, atau kemiringan atap konstruksi.",
                'pemahaman_bermakna' => "Peserta didik menyadari bahwa rasio sudut segitiga siku-siku memungkinkan pengukuran jarak dan ketinggian objek raksasa yang mustahil diukur secara manual dengan meteran fisik.",
                'pertanyaan_pemantik' => "1. Bagaimana arsitek dan surveyor mengukur ketinggian gedung pencakar langit tanpa harus memanjat puncaknya?\n2. Mengapa sudut kemiringan atap rumah atau jalan tanjakan pegunungan dirancang dengan rasio sudut tertentu?",
                'kata_kunci' => ['sinus', 'cosinus', 'tangen', 'sudut elevasi', 'sudut depresi', 'theodolite', 'aturan sinus'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Seorang teknisi jaringan telekomunikasi berdiri sejauh 40 meter dari dasar menara pemancar BTS. Menggunakan alat klinometer, teknisi melihat puncak menara dengan sudut elevasi 60°. Tinggi mata teknisi dari permukaan tanah adalah 1,5 meter.",
                        'pertanyaan' => "Tinggi total menara pemancar BTS tersebut dari permukaan tanah adalah...",
                        'options' => [
                            'A' => '(40sqrt(3) + 1,5) meter',
                            'B' => '(20sqrt(3) + 1,5) meter',
                            'C' => '(40/sqrt(3) + 1,5) meter',
                            'D' => '(40 + 1,5sqrt(3)) meter',
                            'E' => '80 meter'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "tan(60°) = tinggi_menara_atas / jarak -> sqrt(3) = y / 40 -> y = 40sqrt(3) meter. Tinggi total = y + tinggi_mata = 40sqrt(3) + 1,5 meter.",
                        'indikator' => "Disajikan persoalan pengukuran tinggi objek dengan klinometer, peserta didik mampu menghitung tinggi objek menggunakan rasio tangen."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Jelaskan perbedaan mendasar antara sudut elevasi dan sudut depresi, serta tuliskan rumus trigonometri yang digunakan untuk mencari panjang tangga minimum jika sebuah dinding setinggi 6 meter harus disandari tangga dengan sudut kemiringan terhadap lantai sebesar 30°!",
                        'kunci' => "Sudut elevasi adalah sudut terbentuk antara garis pandang mata pengamat ke atas dengan garis mendatar (horizontal), sedangkan sudut depresi adalah sudut garis pandang ke bawah terhadap mendatar. Untuk tangga: sin(30°) = tinggi_dinding / panjang_tangga -> 1/2 = 6 / L -> L = 12 meter.",
                        'indikator' => "Peserta didik dapat menguraikan konsep sudut pandang trigonometri dan menghitung panjang sisi miring segitiga siku-siku."
                    ]
                ]
            ],

            // =========================================================================
            // 2. KODING DAN KECERDASAN ARTIFISIAL (AI) (FASE E & F)
            // =========================================================================
            [
                'mapel' => 'Koding dan Kecerdasan Artifisial (AI)',
                'fase_id' => $faseE?->id,
                'elemen' => 'Fondasi AI dan Berpikir Komputasional',
                'topik' => 'Arsitektur Kecerdasan Buatan & Neural Networks',
                'sub_materi' => [
                    'Evolusi AI: Dari Sistem Pakar Berbasis Aturan (Rule-Based) ke Generative AI',
                    'Konsep Perceptron, Bobot (Weights), Bias, dan Fungsi Aktivasi',
                    'Alur Machine Learning: Pengumpulan Data, Preprocessing, Pelatihan, dan Evaluasi',
                    'Dampak Etika, Bias Representasi Data, dan Privasi dalam Pengembangan Model AI'
                ],
                'rangkuman' => "RINGKASAN MATERI: FONDASI AI DAN BERPIKIR KOMPUTASIONAL (FASE E)\n\n"
                    . "1. EVOLUSI DAN TAKSONOMI KECERDASAN ARTIFISIAL:\n"
                    . "Kecerdasan Artifisial (AI) diklasifikasikan menjadi:\n"
                    . "• Narrow AI (Weak AI): Sistem AI spesifik yang dirancang menyelesaikan satu tugas tertentu (contoh: deteksi spam, klasifikasi citra rontgen, pengenal suara Siri/Google Assistant).\n"
                    . "• General AI (AGI): AI teoritis yang memiliki kemampuan kognitif setara manusia di segala bidang.\n"
                    . "• Generative AI: Sub-bidang AI (seperti Transformer & LLM) yang mampu memproduksi konten orisinal baru (teks, gambar, kode program, audio) berdasarkan pola data latih.\n\n"
                    . "2. CARA KERJA NEURAL NETWORK (JARINGAN SARAF TIRUAN):\n"
                    . "Unit dasar model AI terinspirasi biologis adalah Perceptron. Input x dikalikan bobot w (weight), dijumlahkan, ditambahkan bias b, kemudian dilewatkan pada fungsi aktivasi (misal: ReLU, Sigmoid, Softmax) untuk menghasilkan output prediksi. Pelatihan model menggunakan algoritma Gradient Descent dan Backpropagation untuk meminimalkan nilai fungsi kerugian (Loss Function).\n\n"
                    . "3. ETIKA DAN KEAMANAN DATA AI (UU PDP NO. 27 TAHUN 2022):\n"
                    . "Pengembang AI wajib mematuhi etika: menghindari bias data (misal: bias gender atau ras pada algoritma rekrutmen), melindungi privasi data sensitif pengguna, memastikan transparansi model (Explainable AI), dan mencegah halusinasi data.",
                'pemahaman_bermakna' => "Peserta didik menyadari bahwa AI bukanlah keajaiban magis, melainkan perpaduan statistika multivariat, aljabar linier, dan komputasi masif yang bekerja mengekstrak pola dari data empiris.",
                'pertanyaan_pemantik' => "1. Bagaimana sebuah aplikasi ponsel pintar dapat mengenali wajah pemiliknya dalam waktu kurang dari satu detik?\n2. Mengapa model AI terkadang memberikan jawaban yang sangat meyakinkan padahal datanya salah (halusinasi)?",
                'kata_kunci' => ['narrow AI', 'generative AI', 'perceptron', 'weights', 'loss function', 'backpropagation', 'etika AI'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Sebuah startup mengembangkan sistem pendeteksi penyakit tanaman padi berbasis citra digital menggunakan model Convolutional Neural Network (CNN). Saat diuji coba di sawah petani, akurasi model anjlok dari 98% (pada data latih) menjadi 62% (pada data nyata) karena perbedaan pencahayaan matahari.",
                        'pertanyaan' => "Fenomena penurunan drastis performa model AI di atas paling tepat dikategorikan sebagai...",
                        'options' => [
                            'A' => 'Overfitting (model menghafal data latih dan gagal melakukan generalisasi)',
                            'B' => 'Underfitting (model terlalu sederhana sehingga tidak mampu menangkap pola dasar)',
                            'C' => 'Data Leakage (terjadinya kebocoran data uji ke dalam kumpulan data latih)',
                            'D' => 'Gradient Vanishing (turunnya gradien bobot hingga bernilai nol)',
                            'E' => 'Prompt Injection (adanya serangan peretasan perintah tersembunyi)'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Overfitting terjadi ketika model memiliki akurasi sangat tinggi pada data training namun gagal menggeneralisasi ke data baru akibat mempelajari 'noise' dan variasi spesifik data latih (seperti pencahayaan studio tertentu).",
                        'indikator' => "Disajikan studi kasus degradasi performa model AI, peserta didik dapat mendiagnosis fenomena overfitting secara akurat."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Jelaskan peran penting 'Data Cleaning' (Pembersihan Data) sebelum dataset dimasukkan ke dalam algoritma pelatihan Machine Learning, serta sebutkan 3 dampak negatif yang terjadi jika model dilatih menggunakan data yang bias dan tidak terkurasi!",
                        'kunci' => "Peran data cleaning: menghapus data duplikat, menangani missing value, normalisasi skala data, dan eliminasi outlier agar model belajar pola valid. 3 dampak negatif: 1) Akurasi prediksi rendah (Garbage In Garbage Out); 2) Terjadinya diskriminasi/bias algoritma terhadap kelompok tertentu; 3) Kerugian fatal saat diterapkan pada sistem kritis (misal salah diagnosis medis atau sistem rem otonom).",
                        'indikator' => "Peserta didik mampu menganalisis urgensi pra-pemrosesan data dan risiko etika bias pada sistem kecerdasan artifisial."
                    ]
                ]
            ],

            // =========================================================================
            // 3. BAHASA INDONESIA (FASE E & F)
            // =========================================================================
            [
                'mapel' => 'Bahasa Indonesia',
                'fase_id' => $faseE?->id,
                'elemen' => 'Membaca dan Memirsa',
                'topik' => 'Kritik Teks Eksposisi & Negosiasi',
                'sub_materi' => [
                    'Struktur Teks Eksposisi: Tesis, Rangkaian Argumen Berbasis Fakta, dan Penegasan Ulang',
                    'Analisis Kebahasaan: Verba Material, Kalimat Nominal, Adjektiva, dan Konjungsi Kausalitas',
                    'Membedakan Opini Subjektif dan Fakta Empiris dalam Wacana Publik',
                    'Strategi Membaca Kritis terhadap Isu Lingkungan dan Ketahanan Pangan'
                ],
                'rangkuman' => "RINGKASAN MATERI: MEMBACA DAN MEMIRSA TEKS EKSPOSISI (FASE E)\n\n"
                    . "1. HAKIKAT DAN STRUKTUR TEKS EKSPOSISI:\n"
                    . "Teks eksposisi bertujuan menyampaikan gagasan, pandangan, atau pengetahuan kepada pembaca secara logis, jelas, dan lugas tanpa bermaksud memaksa pembaca. Struktur generik:\n"
                    . "• Tesis (Pernyataan Pendapat): Pengenalan isu, masalah, atau pandangan umum penulis.\n"
                    . "• Rangkaian Argumen: Sejumlah alasan logis, data statistik, hasil penelitian, dan fakta objektif yang memperkuat tesis.\n"
                    . "• Penegasan Ulang (Rekomendasi/Simpulan): Perumusan kembali tesis dengan bahasa berbeda secara ringkas dan solutif.\n\n"
                    . "2. KAIDAH KEBAHASAAN TEKS EKSPOSISI:\n"
                    . "• Pronomina (Kata Ganti): Penggunaan kata ganti orang pertama jamak (kita, kami) atau netral.\n"
                    . "• Konjungsi Sebab-Akibat (Kausalitas): jika, sebab, karena, akibatnya, oleh karena itu.\n"
                    . "• Kata Kerja Mental (Verba Mental): meyakini, menduga, berasumsi, memperkirakan.\n"
                    . "• Kalimat Fakta vs Opini: Fakta memuat data numerik dan bukti empiris terverifikasi (dapat dibuktikan), sedangkan opini berisi penilaian subjektif/prediksi penulis.",
                'pemahaman_bermakna' => "Peserta didik menyadari bahwa kemampuan membaca kritis memampukan mereka menyaring membanjirnya informasi di era digital, membedakan hoax/disinformasi dari fakta ilmiah yang kredibel.",
                'pertanyaan_pemantik' => "1. Bagaimana kita bisa memastikan bahwa berita yang viral di media sosial benar-benar fakta ilmiah dan bukan opini yang memanipulasi emosi pembaca?\n2. Mengapa sebuah argumen harus selalu didukung oleh data statistik dan fakta nyata?",
                'kata_kunci' => ['tesis', 'argumen', 'penegasan ulang', 'fakta', 'opini', 'konjungsi kausalitas', 'verba mental'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Bacalah kutipan teks berikut!\n\"(1) Berdasarkan data Kementerian LHK tahun 2024, volume timbulan sampah nasional mencapai 68,5 juta ton per tahun. (2) Dari jumlah tersebut, sampah plastik menyumbang sekitar 18% atau setara 12,3 juta ton. (3) Pemerintah seyogianya segera melarang total pemakaian kantong plastik sekali pakai tanpa kompromi. (4) Pasalnya, penumpukan sampah plastik di perairan mengancam keberlangsungan biota laut dan memicu akumulasi mikroplastik pada ikan konsumsi.\"",
                        'pertanyaan' => "Kalimat yang berisi opini subjektif penulis pada teks eksposisi di atas ditandai oleh nomor...",
                        'options' => [
                            'A' => '(3)',
                            'B' => '(1)',
                            'C' => '(2)',
                            'D' => '(4)',
                            'E' => '(1) dan (2)'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Kalimat (3) memuat kata 'seyogianya' dan 'tanpa kompromi' yang menunjukkan anjuran/penilaian subjektif (opini). Sedangkan kalimat (1) dan (2) memuat data numerik empiris (fakta).",
                        'indikator' => "Disajikan kutipan teks eksposisi, peserta didik mampu mengidentifikasi kalimat opini subjektif dengan tepat."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Uraikan 3 kriteria utama yang membedakan antara fakta empiris dengan opini subjektif dalam sebuah wacana artikel ilmiah populer, serta berikan masing-masing 1 contoh kalimatnya bertemakan teknologi vokasi!",
                        'kunci' => "Kriteria pembeda: 1) Verifiabilitas (fakta dapat dibuktikan kebenarannya oleh pihak ketiga, opini bersifat relatif); 2) Data pendukung (fakta menyertakan angka/waktu/tempat terukur, opini menggunakan kata sifat prediktif seperti 'seharusnya', 'sangat baik'); 3) Objektivitas (fakta bebas dari emosi pribadi). Contoh fakta: Mesin bubut CNC tipe X memiliki kecepatan putar spindel 4.000 RPM. Contoh opini: Mesin CNC tipe X adalah alat praktik paling nyaman digunakan oleh siswa SMK.",
                        'indikator' => "Peserta didik dapat merumuskan kriteria pembeda fakta dan opini serta memproduksi contoh konkretnya."
                    ]
                ]
            ],

            // =========================================================================
            // 4. PENDIDIKAN PANCASILA (FASE E & F)
            // =========================================================================
            [
                'mapel' => 'Pendidikan Pancasila',
                'fase_id' => $faseE?->id,
                'elemen' => 'Pancasila',
                'topik' => 'Keterkaitan Nilai Pancasila dalam Kehidupan Berbangsa',
                'sub_materi' => [
                    'Pancasila sebagai Ideologi Terbuka dan Dasar Falsafah Negara',
                    'Keterpaduan dan Hirarki Sila-Sila Pancasila',
                    'Penerapan Dimensi Profil Lulusan Berbasis Nilai Gotong Royong dan Integritas',
                    'Pencegahan Intoleransi dan Radikalisme di Lingkungan Pendidikan Kejuruan'
                ],
                'rangkuman' => "RINGKASAN MATERI: PANCASILA SEBAGAI FALSAFAH DAN IDEOLOGI TERBUKA (FASE E)\n\n"
                    . "1. PANCASILA SEBAGAI IDEOLOGI TERBUKA:\n"
                    . "Pancasila memiliki sifat dinamis, reformatif, dan terbuka terhadap perkembangan zaman tanpa mengubah nilai-nilai dasarnya. Tiga dimensi ideologi terbuka:\n"
                    . "• Dimensi Realitas: Nilai-nilai dasar bersumber dari tradisi, kearifan lokal, dan kepribadian bangsa Indonesia.\n"
                    . "• Dimensi Idealisme: Memuat cita-cita luhur kemerdekaan bangsa yang adil dan makmur.\n"
                    . "• Dimensi Fleksibilitas: Mampu berinteraksi dengan teknologi modern dan tantangan globalisasi.\n\n"
                    . "2. HIERARKI SILA-SILA PANCASILA:\n"
                    . "Sila-sila Pancasila tersusun secara piramidal-organik; sila pertama menjiwai dan mendasari keempat sila lainnya, dan sila kelima merupakan muara dari terwujudnya keadilan sosial bagi seluruh rakyat.",
                'pemahaman_bermakna' => "Peserta didik memahami bahwa Pancasila adalah pedoman moral dan kompas etika profesi yang menjaga integritas insan kerja dalam menghadapi persaingan industri global.",
                'pertanyaan_pemantik' => "1. Mengapa nilai-nilai Pancasila tetap relevan dan tidak usang meskipun teknologi kecerdasan artifisial dan globalisasi berkembang sangat pesat?\n2. Bagaimana cara mengamalkan nilai keadilan sosial di lingkungan tempat kerja dan sekolah?",
                'kata_kunci' => ['ideologi terbuka', 'hierarki piramidal', 'dimensi realitas', 'gotong royong', 'keadilan sosial', 'integritas'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Dalam pelaksanaan seleksi tenaga kerja magang industri di sebuah perusahaan mitra sekolah, panitia seleksi mendapati kandidat dengan prestasi kompetensi teknis tertinggi berasal dari daerah terpencil dan latar belakang keluarga kurang mampu. Manajemen perusahaan memutuskan tetap meloloskannya tanpa diskriminasi.",
                        'pertanyaan' => "Keputusan manajemen perusahaan di atas merupakan wujud nyata pengamalan nilai Pancasila, khususnya perpaduan antara sila...",
                        'options' => [
                            'A' => 'Kedua (Kemanusiaan yang Adil dan Beradab) dan Kelima (Keadilan Sosial)',
                            'B' => 'Pertama (Ketuhanan Yang Maha Esa) dan Ketiga (Persatuan Indonesia)',
                            'C' => 'Ketiga (Persatuan Indonesia) dan Keempat (Kerakyatan)',
                            'D' => 'Hanya sila Pertama',
                            'E' => 'Hanya sila Keempat'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Memberikan perlakuan adil atas dasar harkat kemanusiaan (Sila ke-2) dan membuka akses kesetaraan kesempatan kerja tanpa diskriminasi status ekonomi merupakan wujud keadilan sosial (Sila ke-5).",
                        'indikator' => "Disajikan studi kasus seleksi industri kerja, peserta didik mampu mengaitkan keputusan etis dengan implementasi sila-sila Pancasila."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Jelaskan mengapa Pancasila disebut sebagai sistem filsafat yang bersifat 'Piramidal dan Organis', serta uraikan 2 contoh konkret penerapan sila Kemanusiaan yang Adil dan Beradab di lingkungan bengkel/laboratorium praktik sekolah!",
                        'kunci' => "Piramidal dan organis bermakna kelima sila tidak berdiri terpisah, melainkan kesatuan bulat yang hierarkis di mana Ketuhanan menjiwai seluruh sila dan berpuncak pada Keadilan Sosial. 2 contoh penerapan di bengkel: 1) Menghormati keselamatan kerja rekan praktik tanpa memandang senioritas (budaya K3); 2) Tidak melakukan perundungan (bullying) terhadap teman yang mengalami kesulitan teknis dalam pengoperasian mesin.",
                        'indikator' => "Peserta didik dapat menguraikan konsep hierarki organis Pancasila dan penerapannya di lingkungan kerja kejuruan."
                    ]
                ]
            ],

            // =========================================================================
            // 5. DASAR-DASAR TEKNIK MESIN / OTOMOTIF / TEKNIK (FASE E KEJURUAN)
            // =========================================================================
            [
                'mapel' => 'Dasar-dasar Teknik Otomotif',
                'fase_id' => $faseE?->id,
                'elemen' => 'Proses Bisnis & Teknologi Otomotif Terkini',
                'topik' => 'Teknologi Kendaraan Listrik (EV) & Manajemen Bengkel',
                'sub_materi' => [
                    'Siklus Kerja Bengkel Otomotif Modern (Service Advisor, Mekanik, Final Check)',
                    'Konsep Kendaraan Listrik (Electric Vehicle / EV): Battery, Inverter, Motor Listrik',
                    'Standar Prosedur Keselamatan Kerja Listrik Tegangan Tinggi (High Voltage Safety)',
                    'Sistem Diagnostic On-Board (OBD-II) dan Scan Tool Elektronik'
                ],
                'rangkuman' => "RINGKASAN MATERI: PROSES BISNIS & TEKNOLOGI OTOMOTIF TERKINI (FASE E)\n\n"
                    . "1. ALUR PROSES BISNIS BENGKEL RESMI OTOMOTIF:\n"
                    . "Siklus pelayanan bengkel profesional terdiri dari: Penerimaan kendaraan oleh Service Advisor (SA) -> Diagnosa awal dan penerbitan Surat Perintah Kerja (SPK) -> Pengerjaan servis berkala oleh teknisi/mekanik berdasar Job Sheet -> Pemeriksaan mutu akhir oleh Foreman/Quality Inspector -> Penjelasan hasil servis kepada pelanggan dan pembayaran kasir.\n\n"
                    . "2. TEKNOLOGI KENDARAAN LISTRIK (ELECTRIC VEHICLE):\n"
                    . "Komponen inti sistem EV:\n"
                    . "• Battery Pack (High Voltage): Media penyimpan energi listrik DC tegangan tinggi (hingga 400V - 800V).\n"
                    . "• Inverter: Mengubah arus searah (DC) baterai menjadi arus bolak-balik (AC) untuk menggerakkan motor traksi serta mengatur regenerasi pengereman (regenerative braking).\n"
                    . "• Motor Traksi (Motor Listrik AC): Penggerak utama roda kendaraan dengan torsi instan.\n\n"
                    . "3. PROTOKOL K3 TEGANGAN TINGGI (HIGH VOLTAGE SAFETY):\n"
                    . "Pekerjaan pada kendaraan hybrid/EV wajib mematikan Service Plug / Manual Disconnect, menunggu disipasi kapasitor inverter (minimal 5-10 menit), memakai sarung tangan isolasi tegangan tinggi (Class 0: 1.000V), dan memastikan tegangan nol dengan multimeter bersertifikat CAT III/IV.",
                'pemahaman_bermakna' => "Peserta didik menyadari bahwa transformasi kendaraan berbasis bahan bakar fosil menuju kendaraan listrik membutuhkan adaptasi kompetensi keselamatan kerja bertegangan tinggi dan literasi diagnostik komputer.",
                'pertanyaan_pemantik' => "1. Mengapa teknisi kendaraan listrik wajib mengenakan perlengkapan khusus sebelum menyentuh kabel berwarna oranye di ruang mesin?\n2. Bagaimana komputer kendaraan (ECU/OBD-II) dapat mendeteksi kerusakan sensor mesin secara mandiri?",
                'kata_kunci' => ['Service Advisor', 'Electric Vehicle', 'Battery Pack', 'Inverter', 'Motor Traksi', 'High Voltage', 'OBD-II Scan Tool'],
                'bank_soal_pg' => [
                    [
                        'stimulus' => "Seorang teknisi otomotif hendak melakukan penggantian komponen kompresor AC elektrik pada mobil jenis Battery Electric Vehicle (BEV) yang menggunakan sistem kabel daya oranye bertegangan 400 Volt DC.",
                        'pertanyaan' => "Langkah pengamanan keselamatan kerja (K3) pertama yang paling krusial sebelum membongkar kabel bertegangan tinggi tersebut adalah...",
                        'options' => [
                            'A' => 'Mencabut Service Disconnect Plug (sakelar pemutus baterai utama) dan mengenakan sarung tangan berinsulasi 1.000V',
                            'B' => 'Menyemprotkan cairan pembersih pelarut pada terminal kabel oranye',
                            'C' => 'Menyalakan mesin kendaraan untuk menghabiskan sisa daya baterai hingga 0%',
                            'D' => 'Langsung melepas baut pengikat kompresor menggunakan kunci pas logam biasa',
                            'E' => 'Menaikkan tekanan udara ban kendaraan'
                        ],
                        'correct' => 'A',
                        'pembahasan' => "Protokol wajib pada kendaraan listrik: matikan sistem pengapian, lepaskan Service Disconnect Plug untuk mengisolasi baterai tegangan tinggi, tunggu waktu pelepasan muatan kapasitor, dan selalu kenakan APD sarung tangan isolasi berstandar minimal 1.000V.",
                        'indikator' => "Disajikan prosedur servis kendaraan listrik tegangan tinggi, peserta didik dapat menentukan urutan K3 isolasi sumber daya secara aman."
                    ]
                ],
                'bank_soal_essay' => [
                    [
                        'pertanyaan' => "Jelaskan fungsi dari Inverter pada sistem transmisi daya kendaraan listrik (EV) serta uraikan bagaimana prinsip 'Regenerative Braking' bekerja dalam memulihkan energi baterai saat kendaraan melakukan perlambatan!",
                        'kunci' => "Inverter berfungsi mengubah arus DC dari baterai tegangan tinggi menjadi arus AC multiphase untuk memutar motor traksi penggerak roda (dan sebaliknya). Saat regenerative braking, motor traksi beralih fungsi menjadi generator akibat putaran roda saat deselerasi/pengereman; energi kinetik diubah menjadi energi listrik AC, disearahkan kembali oleh inverter menjadi DC, lalu disimpan ke baterai penggerak.",
                        'indikator' => "Peserta didik mampu menguraikan prinsip kerja inverter dan teknologi pengereman regeneratif pada kendaraan ramah lingkungan."
                    ]
                ]
            ]
        ];

        foreach ($data as $item) {
            $mapelModel = MataPelajaran::where('nama', $item['mapel'])->first();
            if ($mapelModel) {
                KurikulumMateri::updateOrCreate(
                    [
                        'mata_pelajaran_id' => $mapelModel->id,
                        'nama_elemen' => $item['elemen'],
                    ],
                    [
                        'fase_id' => $item['fase_id'],
                        'nama_mapel' => $item['mapel'],
                        'topik_utama' => $item['topik'],
                        'sub_materi' => $item['sub_materi'],
                        'rangkuman_materi' => $item['rangkuman'],
                        'pemahaman_bermakna' => $item['pemahaman_bermakna'],
                        'pertanyaan_pemantik' => $item['pertanyaan_pemantik'],
                        'kata_kunci' => $item['kata_kunci'],
                        'bank_soal_pg' => $item['bank_soal_pg'],
                        'bank_soal_essay' => $item['bank_soal_essay'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
