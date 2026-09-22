<?php

namespace Database\Seeders;

use App\Models\BidangKeahlian;
use App\Models\KonsentrasiKeahlian;
use App\Models\ProgramKeahlian;
use Illuminate\Database\Seeder;

class AllSpektrumSmkSeeder extends Seeder
{
    public function run(): void
    {
        // Spektrum Keahlian SMK/MAK Lengkap Berdasarkan Kepmendikbudristek No. 244/M/2024
        // Mencakup 10 Bidang Keahlian, seluruh Program Keahlian, dan Konsentrasi Keahlian.

        $spektrumData = [
            // 1. TEKNOLOGI KONSTRUKSI DAN PROPERTI / BANGUNAN
            [
                'bidang' => [
                    'kode' => 'TKP',
                    'nama' => 'Teknologi Konstruksi dan Properti',
                    'deskripsi' => 'Bidang keahlian yang mencakup perancangan arsitektur, konstruksi gedung, jalan jembatan, sanitasi, dan manajemen informasi bangunan.'
                ],
                'programs' => [
                    [
                        'kode' => 'KPB',
                        'nama' => 'Konstruksi dan Perawatan Bangunan Sipil',
                        'deskripsi' => 'Penguasaan teknik konstruksi gedung, perawatan jalan, jembatan, dan irigasi sipil.',
                        'konsentrasi' => [
                            ['kode' => 'KGS', 'nama' => 'Konstruksi Gedung dan Sanitasi', 'deskripsi' => 'Pekerjaan struktur beton, batu, plesteran, dan instalasi perpipaan sanitasi.'],
                            ['kode' => 'KJJ', 'nama' => 'Konstruksi Jalan dan Jembatan', 'deskripsi' => 'Pelaksanaan dan pemeliharaan perkerasan jalan raya dan struktur jembatan.'],
                            ['kode' => 'PIP', 'nama' => 'Perawatan Gedung dan Infrastruktur Sipil', 'deskripsi' => 'Manajemen pemeliharaan sarana gedung dan sarana publik.'],
                        ]
                    ],
                    [
                        'kode' => 'DPIB',
                        'nama' => 'Desain Pemodelan dan Informasi Bangunan',
                        'deskripsi' => 'Perancangan gambar arsitektur 2D/3D berbasis BIM (Building Information Modelling).',
                        'konsentrasi' => [
                            ['kode' => 'DPIB-K', 'nama' => 'Desain Pemodelan dan Informasi Bangunan (BIM)', 'deskripsi' => 'Pemodelan digital bangunan 3D, estimasi biaya RAB, dan dokumentasi arsitektur.'],
                        ]
                    ],
                    [
                        'kode' => 'TGEO',
                        'nama' => 'Teknik Geomatika',
                        'deskripsi' => 'Pemetaan terestrial, fotogrametri drone, dan Sistem Informasi Geografis (SIG).',
                        'konsentrasi' => [
                            ['kode' => 'GEOM', 'nama' => 'Teknik Geomatika dan Survei Pemetaan', 'deskripsi' => 'Pengukuran tanah, penentuan batas wilayah, dan pengolahan data geospasial.'],
                        ]
                    ],
                ]
            ],

            // 2. TEKNOLOGI MANUFAKTUR DAN REKAYASA
            [
                'bidang' => [
                    'kode' => 'TMR',
                    'nama' => 'Teknologi Manufaktur dan Rekayasa',
                    'deskripsi' => 'Bidang keahlian rekayasa mekanik, pemesinan presisi, otomotif, elektronika industri, otomasi, dan manufaktur logam.'
                ],
                'programs' => [
                    [
                        'kode' => 'TMES',
                        'nama' => 'Teknik Mesin',
                        'deskripsi' => 'Pemesinan konvensional dan CNC, perancangan mekanik, dan fabrikasi logam.',
                        'konsentrasi' => [
                            ['kode' => 'TPM', 'nama' => 'Teknik Pemesinan', 'deskripsi' => 'Pengoperasian mesin bubut, frais, gerinda, dan mesin perkakas CNC berstandar industri.'],
                            ['kode' => 'TPL', 'nama' => 'Teknik Pengelasan (Welding)', 'deskripsi' => 'Pengelasan SMAW, GMAW, GTAW, dan pengujian kualitas hasil las NDT/DT.'],
                            ['kode' => 'TFLM', 'nama' => 'Teknik Fabrikasi Logam dan Manufaktur', 'deskripsi' => 'Pembentukan plat logam, perakitan struktur konstruksi, dan perancangan manufaktur.'],
                            ['kode' => 'TPCL', 'nama' => 'Teknik Pengecoran Logam', 'deskripsi' => 'Pembuatan cetakan, peleburan logam, dan finishing coran logam industri.'],
                        ]
                    ],
                    [
                        'kode' => 'TOTO',
                        'nama' => 'Teknik Otomotif',
                        'deskripsi' => 'Perawatan dan perbaikan sistem kendaraan darat konvensional, listrik, dan alat berat.',
                        'konsentrasi' => [
                            ['kode' => 'TKRO', 'nama' => 'Teknik Kendaraan Ringan (TKR)', 'deskripsi' => 'Diagnosis dan servis mesin mobil EFI/hybrid, chasis, pemindah tenaga, dan kelistrikan bodi.'],
                            ['kode' => 'TBSM', 'nama' => 'Teknik Sepeda Motor (TSM)', 'deskripsi' => 'Perawatan dan perbaikan sepeda motor injeksi, transmisi otomatis, dan motor listrik.'],
                            ['kode' => 'TAB', 'nama' => 'Teknik Alat Berat', 'deskripsi' => 'Servis hidrolik, powertrain, dan mesin diesel alat berat pertambangan/konstruksi.'],
                            ['kode' => 'TBOK', 'nama' => 'Teknik Bodi Kendaraan Ringan', 'deskripsi' => 'Perbaikan rangka bodi mobil, pengecatan, dan panel alignment.'],
                            ['kode' => 'TOEV', 'nama' => 'Teknik Kendaraan Listrik (Electric Vehicle)', 'deskripsi' => 'Sistem motor traksi, baterai lithium management, inverter, dan kontrol kendaraan listrik.'],
                        ]
                    ],
                    [
                        'kode' => 'TELK',
                        'nama' => 'Teknik Elektronika',
                        'deskripsi' => 'Perancangan sirkuit analog digital, mikroprosesor, robotika, dan otomasi industri.',
                        'konsentrasi' => [
                            ['kode' => 'TAV', 'nama' => 'Teknik Audio Video', 'deskripsi' => 'Perawatan peralatan audio visual digital, instalasi sound system, dan broadcasting studio.'],
                            ['kode' => 'TEI', 'nama' => 'Teknik Elektronika Industri', 'deskripsi' => 'Pemrograman PLC, sensor industri, pneumatik, dan sistem kontrol mikrokontroler.'],
                            ['kode' => 'TMEK', 'nama' => 'Teknik Mekatronika', 'deskripsi' => 'Integrasi mekanik presisi, sistem elektronik, dan kendali cerdas robotika industri.'],
                            ['kode' => 'TOIN', 'nama' => 'Teknik Otomasi Industri', 'deskripsi' => 'SCADA, DCS, instrumentasi industri, dan otomasi lini perakitan pabrik.'],
                        ]
                    ],
                    [
                        'kode' => 'TLOG',
                        'nama' => 'Teknik Logistik',
                        'deskripsi' => 'Manajemen pergudangan, distribusi rantai pasok material manufaktur, dan inventaris.',
                        'konsentrasi' => [
                            ['kode' => 'MANLOG', 'nama' => 'Manajemen Pergudangan dan Logistik Manufaktur', 'deskripsi' => 'Pengelolaan warehouse, material handling equipment, dan sistem inventori logistik.'],
                        ]
                    ],
                    [
                        'kode' => 'TAER',
                        'nama' => 'Teknik Pesawat Udara',
                        'deskripsi' => 'Pemeliharaan rangka, mesin turbin/piston, dan instrumen kelistrikan pesawat terbang.',
                        'konsentrasi' => [
                            ['kode' => 'APM', 'nama' => 'Airframe and Powerplant', 'deskripsi' => 'Perawatan struktur bodi pesawat udara dan sistem mesin pendorong.'],
                            ['kode' => 'EAV', 'nama' => 'Electrical Avionics', 'deskripsi' => 'Sistem navigasi, komunikasi radio, dan instrumen penerbangan avionik.'],
                        ]
                    ],
                ]
            ],

            // 3. ENERGI DAN PERTAMBANGAN
            [
                'bidang' => [
                    'kode' => 'EP',
                    'nama' => 'Energi dan Pertambangan',
                    'deskripsi' => 'Bidang keahlian instalasi pembangkit tenaga listrik, energi terbarukan, eksplorasi migas, dan geologi tambang.'
                ],
                'programs' => [
                    [
                        'kode' => 'TLIS',
                        'nama' => 'Teknik Ketenagalistrikan',
                        'deskripsi' => 'Pemasangan instalasi listrik tegangan rendah/menengah, motor listrik, dan proteksi jaringan.',
                        'konsentrasi' => [
                            ['kode' => 'TITL', 'nama' => 'Teknik Instalasi Tenaga Listrik', 'deskripsi' => 'Instalasi penerangan dan tenaga gedung/industri, panel distribusi, dan motor 3 fasa.'],
                            ['kode' => 'TJTL', 'nama' => 'Teknik Jaringan Tenaga Listrik', 'deskripsi' => 'Pembangunan dan pemeliharaan jaringan transmisi/distribusi listrik PLN (SUTM/SUTR).'],
                            ['kode' => 'TPTL', 'nama' => 'Teknik Pembangkit Tenaga Listrik', 'deskripsi' => 'Operasional dan perawatan generator turbin uap, gas, dan diesel pembangkit listrik.'],
                        ]
                    ],
                    [
                        'kode' => 'ETEB',
                        'nama' => 'Teknik Energi Terbarukan',
                        'deskripsi' => 'Pemanfaatan sumber energi ramah lingkungan: surya (solar PV), angin, air (mikrohidro), dan biomassa.',
                        'konsentrasi' => [
                            ['kode' => 'TSHA', 'nama' => 'Teknik Energi Surya, Hidro, dan Angin', 'deskripsi' => 'Instalasi PLTS On-Grid/Off-Grid, turbin angin kecil, dan pembangkit listrik mikrohidro.'],
                            ['kode' => 'TEBIO', 'nama' => 'Teknik Energi Biomassa', 'deskripsi' => 'Konversi limbah organik menjadi biogas dan bioenergi terbarukan.'],
                        ]
                    ],
                    [
                        'kode' => 'TGMIN',
                        'nama' => 'Teknik Geologi Pertambangan',
                        'deskripsi' => 'Eksplorasi bahan galian mineral, pemetaan geologi lapangan, dan penambangan terbuka.',
                        'konsentrasi' => [
                            ['kode' => 'GEOTAM', 'nama' => 'Geologi Pertambangan dan Eksplorasi', 'deskripsi' => 'Identifikasi batuan mineral, survei geofisika tambang, dan keselamatan tambang K3.'],
                        ]
                    ],
                    [
                        'kode' => 'TMIG',
                        'nama' => 'Teknik Perminyakan',
                        'deskripsi' => 'Teknik pemboran sumur minyak dan gas bumi, serta pengolahan fluida produksi.',
                        'konsentrasi' => [
                            ['kode' => 'TPB', 'nama' => 'Teknik Pemboran Minyak dan Gas', 'deskripsi' => 'Rig pemboran, lumpur pemboran, dan prosedur pencegahan semburan liar (BOP).'],
                            ['kode' => 'TPMIG', 'nama' => 'Teknik Pengolahan Minyak, Gas, dan Petrokimia', 'deskripsi' => 'Distilasi fraksionasi hidrokarbon dan proses pemurnian produk petrokimia.'],
                        ]
                    ],
                ]
            ],

            // 4. TEKNOLOGI INFORMASI
            [
                'bidang' => [
                    'kode' => 'TI',
                    'nama' => 'Teknologi Informasi',
                    'deskripsi' => 'Bidang keahlian rekayasa software, website, aplikasi mobile, cloud computing, infrastruktur jaringan telekomunikasi, dan kecerdasan artifisial.'
                ],
                'programs' => [
                    [
                        'kode' => 'PPLG',
                        'nama' => 'Pengembangan Perangkat Lunak dan Gim',
                        'deskripsi' => 'Rekayasa perangkat lunak berstandar industri, mobile app development, basis data, dan gim digital interaktif.',
                        'konsentrasi' => [
                            ['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Pemrograman web fullstack (Laravel/Node/React), API RESTful, database SQL/NoSQL, dan clean code.'],
                            ['kode' => 'GIM', 'nama' => 'Pengembangan Gim (Game Development)', 'deskripsi' => 'Desain mekanik gim, game engine (Unity/Godot), asset grafis 2D/3D, dan game physics.'],
                            ['kode' => 'APPMOB', 'nama' => 'Pengembangan Aplikasi Perangkat Bergerak (Mobile)', 'deskripsi' => 'Pemrograman aplikasi Android dan iOS native/hybrid (Flutter/Kotlin/React Native).'],
                        ]
                    ],
                    [
                        'kode' => 'TJKT',
                        'nama' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                        'deskripsi' => 'Infrastruktur routing switching, fiber optik, administrasi server Linux/Windows, dan cyber security.',
                        'konsentrasi' => [
                            ['kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan', 'deskripsi' => 'Konfigurasi Mikrotik/Cisco, firewall security, server virtualization, dan cloud infrastructure.'],
                            ['kode' => 'TTEL', 'nama' => 'Teknik Telekomunikasi dan Fiber Optik', 'deskripsi' => 'Penyambungan kabel fiber optik (splicing), transmisi nirkabel, dan jaringan 4G/5G.'],
                            ['kode' => 'CYBER', 'nama' => 'Keamanan Siber (Cyber Security)', 'deskripsi' => 'Ethical hacking dasar, network defense, penetration testing, dan hardening server.'],
                        ]
                    ],
                    [
                        'kode' => 'SIJA',
                        'nama' => 'Sistem Informasi, Jaringan, dan Aplikasi (4 Tahun)',
                        'deskripsi' => 'Program 4 tahun yang menggabungkan integrasi sistem IT enterprise, IoT, dan cloud management.',
                        'konsentrasi' => [
                            ['kode' => 'SIJA-K', 'nama' => 'Sistem Informasi, Jaringan, dan Aplikasi', 'deskripsi' => 'Integrasi IoT sensor industri, big data pipeline, cloud DevOps, dan audit sistem IT.'],
                        ]
                    ],
                ]
            ],

            // 5. KESEHATAN DAN PEKERJAAN SOSIAL
            [
                'bidang' => [
                    'kode' => 'KPS',
                    'nama' => 'Kesehatan dan Pekerjaan Sosial',
                    'deskripsi' => 'Bidang keahlian pelayanan keperawatan dasar, asisten kefarmasian, analisis laboratorium klinik, dan rehabilitasi sosial.'
                ],
                'programs' => [
                    [
                        'kode' => 'LKBS',
                        'nama' => 'Layanan Kesehatan',
                        'deskripsi' => 'Kebutuhan dasar manusia, perawatan lansia (geriatri), dan asisten tenaga keperawatan terampil.',
                        'konsentrasi' => [
                            ['kode' => 'ASKEP', 'nama' => 'Asisten Keperawatan dan Caregiver', 'deskripsi' => 'Pemeriksaan tanda vital, pemenuhan nutrisi/eliminasi/kebersihan pasien, dan pertolongan pertama.'],
                            ['kode' => 'ASGIG', 'nama' => 'Asisten Dental (Kesehatan Gigi)', 'deskripsi' => 'Bantuan prosedur penambalan/pencabutan gigi, sterilisasi instrumen dental, dan higiene mulut.'],
                        ]
                    ],
                    [
                        'kode' => 'TFAR',
                        'nama' => 'Teknologi Farmasi',
                        'deskripsi' => 'Peracikan obat resep dokter, administrasi apotek, farmakognosi simplisia, dan produksi obat industri.',
                        'konsentrasi' => [
                            ['kode' => 'FARKOM', 'nama' => 'Farmasi Klinis dan Komunitas', 'deskripsi' => 'Peracikan puyer, kapsul, salep, dispensing resep obat di apotek/klinik, dan edukasi pasien.'],
                            ['kode' => 'FARIND', 'nama' => 'Farmasi Industri', 'deskripsi' => 'CPOB (Cara Pembuatan Obat yang Baik), pengujian mutu bahan baku obat di laboratorium QC/QA.'],
                        ]
                    ],
                    [
                        'kode' => 'TLM',
                        'nama' => 'Teknik Laboratorium Medik',
                        'deskripsi' => 'Pengambilan spesimen darah (flebotomi), pemeriksaan hematologi, urinalisis, dan mikrobiologi dasar.',
                        'konsentrasi' => [
                            ['kode' => 'ATLM', 'nama' => 'Asisten Teknologi Laboratorium Medik', 'deskripsi' => 'Pemeriksaan laboratorium kimia klinik, parasitologi, dan pengoperasian fotometer/sentrifus.'],
                        ]
                    ],
                    [
                        'kode' => 'PEKSOS',
                        'nama' => 'Pekerjaan Sosial',
                        'deskripsi' => 'Pelayanan asesmen sosial, pendampingan anak dan lansia, serta penanganan masalah disabilitas.',
                        'konsentrasi' => [
                            ['kode' => 'PKS', 'nama' => 'Pekerjaan Sosial dan Rehabilitasi', 'deskripsi' => 'Case work, advokasi sosial, dan bimbingan psikososial di panti pelayanan sosial.'],
                        ]
                    ],
                ]
            ],

            // 6. AGRIBISNIS DAN AGRITEKNOLOGI
            [
                'bidang' => [
                    'kode' => 'AA',
                    'nama' => 'Agribisnis dan Agriteknologi',
                    'deskripsi' => 'Bidang keahlian budidaya tanaman pertanian modern, smart farming, peternakan unggas/ruminansia, budidaya perikanan, pengolahan pangan, dan kehutanan.'
                ],
                'programs' => [
                    [
                        'kode' => 'AGTAN',
                        'nama' => 'Agribisnis Tanaman',
                        'deskripsi' => 'Teknik pembenihan, budidaya tanaman pangan hortikultura, perkebunan, dan hidroponik/smart farming.',
                        'konsentrasi' => [
                            ['kode' => 'ATPH', 'nama' => 'Agribisnis Tanaman Pangan dan Hortikultura', 'deskripsi' => 'Budidaya sayuran, buah-buahan, tanaman pangan padi/jagung, dan hidroponik greenhouse.'],
                            ['kode' => 'ATPK', 'nama' => 'Agribisnis Tanaman Perkebunan', 'deskripsi' => 'Budidaya kelapa sawit, kakao, kopi, karet, dan manajemen kebun skala komersial.'],
                            ['kode' => 'PEMBEN', 'nama' => 'Agribisnis Perbenihan Tanaman', 'deskripsi' => 'Kultur jaringan tanaman, penyerbukan silang, dan sertifikasi benih unggul.'],
                        ]
                    ],
                    [
                        'kode' => 'AGTER',
                        'nama' => 'Agribisnis Ternak',
                        'deskripsi' => 'Manajemen pemeliharaan, pakan nutrisi, perkandangan, dan kesehatan ternak potong/perah.',
                        'konsentrasi' => [
                            ['kode' => 'ATRUM', 'nama' => 'Agribisnis Ternak Ruminansia (Sapi/Kambing)', 'deskripsi' => 'Penggemukan sapi potong, pemeliharaan sapi perah perah susu, dan inseminasi buatan.'],
                            ['kode' => 'ATUNG', 'nama' => 'Agribisnis Ternak Unggas (Ayam Broiler/Layer)', 'deskripsi' => 'Manajemen closed house kandang ayam pedaging dan petelur modern berstandar industri.'],
                        ]
                    ],
                    [
                        'kode' => 'AGPIK',
                        'nama' => 'Agribisnis Perikanan',
                        'deskripsi' => 'Pembenihan dan pembesaran ikan air tawar, payau, udang vaname, serta budidaya rumput laut.',
                        'konsentrasi' => [
                            ['kode' => 'APAT', 'nama' => 'Agribisnis Perikanan Air Tawar', 'deskripsi' => 'Budidaya ikan lele, nila, gurami menggunakan sistem bioflok dan RAS.'],
                            ['kode' => 'APAPL', 'nama' => 'Agribisnis Perikanan Payau dan Laut', 'deskripsi' => 'Budidaya udang vaname intensif, ikan bandeng, kakap putih, dan kerapu di tambak/KJA.'],
                        ]
                    ],
                    [
                        'kode' => 'APHP',
                        'nama' => 'Agriteknologi Pengolahan Hasil Pertanian',
                        'deskripsi' => 'Teknologi pascapanen, pengolahan makanan/minuman hasil panen, pengemasan, dan HACCP keamanan pangan.',
                        'konsentrasi' => [
                            ['kode' => 'AGPHP', 'nama' => 'Agribisnis Pengolahan Hasil Pertanian', 'deskripsi' => 'Pengolahan roti/pastry, sari buah, fermentasi, pengalengan, dan uji organoleptik makanan.'],
                            ['kode' => 'APHIK', 'nama' => 'Agribisnis Pengolahan Hasil Perikanan', 'deskripsi' => 'Pembuatan surimi, fillet ikan beku, nugget ikan, dan diversifikasi produk hasil laut.'],
                        ]
                    ],
                    [
                        'kode' => 'KEHUT',
                        'nama' => 'Kehutanan',
                        'deskripsi' => 'Perlindungan konservasi hutan, silvikultur persemaian bibit kayu, dan pengukuran kayu inventarisasi.',
                        'konsentrasi' => [
                            ['kode' => 'KESHUT', 'nama' => 'Pengelolaan Hutan dan Konservasi', 'deskripsi' => 'Reboisasi, pencegahan kebakaran hutan, dan pemanfaatan hasil hutan bukan kayu (HHBK).'],
                        ]
                    ],
                ]
            ],

            // 7. KEMARITIMAN
            [
                'bidang' => [
                    'kode' => 'KM',
                    'nama' => 'Kemaritiman',
                    'deskripsi' => 'Bidang keahlian navigasi kapal laut komersial, penangkapan ikan samudra, permesinan kapal, dan logistik pelabuhan.'
                ],
                'programs' => [
                    [
                        'kode' => 'PENGKAP',
                        'nama' => 'Penangkapan Ikan',
                        'deskripsi' => 'Alat tangkap longline, purse seine, oseanografi perikanan, dan navigasi penangkapan ikan samudra.',
                        'konsentrasi' => [
                            ['kode' => 'NKPI', 'nama' => 'Nautika Kapal Penangkap Ikan', 'deskripsi' => 'Olah gerak kapal penangkap ikan, pembacaan radar dan sonar ikan, serta penentuan posisi GPS.'],
                            ['kode' => 'TKPI', 'nama' => 'Teknika Kapal Penangkap Ikan', 'deskripsi' => 'Perawatan mesin diesel induk kapal, generator kelistrikan kapal, dan sistem pendingin palka (freezer).'],
                        ]
                    ],
                    [
                        'kode' => 'PELNIAG',
                        'nama' => 'Pelayaran Niaga (STCW-95)',
                        'deskripsi' => 'Pendidikan pelayaran kapal niaga bersertifikasi internasional (ANT-IV / ATT-IV).',
                        'konsentrasi' => [
                            ['kode' => 'NKN', 'nama' => 'Nautika Kapal Niaga', 'deskripsi' => 'Navigasi pelayaran samudra, aturan pencegahan tubrukan laut (COLREG), dan penanganan muatan cargo.'],
                            ['kode' => 'TKN', 'nama' => 'Teknika Kapal Niaga', 'deskripsi' => 'Pengoperasian mesin penggerak utama kapal niaga, pompa ketel uap, dan separator bahan bakar.'],
                        ]
                    ],
                ]
            ],

            // 8. BISNIS DAN MANAJEMEN
            [
                'bidang' => [
                    'kode' => 'BM',
                    'nama' => 'Bisnis dan Manajemen',
                    'deskripsi' => 'Bidang keahlian akuntansi keuangan, perpajakan, perbankan, administrasi perkantoran modern, dan digital marketing.'
                ],
                'programs' => [
                    [
                        'kode' => 'MPLB',
                        'nama' => 'Manajemen Perkantoran dan Layanan Bisnis',
                        'deskripsi' => 'Tata kelola persuratan dinas, korespondensi bahasa Inggris, public relation, dan otomasi perkantoran digital.',
                        'konsentrasi' => [
                            ['kode' => 'OTKP', 'nama' => 'Manajemen Perkantoran (Otomatisasi Tata Kelola Perkantoran)', 'deskripsi' => 'Pengelolaan arsip elektronik, rapat virtual, keprotokolan, dan aplikasi office spreadsheet tingkat lanjut.'],
                            ['kode' => 'LPBI', 'nama' => 'Layanan Perbankan dan Keuangan Syariah', 'deskripsi' => 'Customer service bank, teller transaction, pembukuan tabungan, dan akad keuangan syariah.'],
                        ]
                    ],
                    [
                        'kode' => 'AKL',
                        'nama' => 'Akuntansi dan Keuangan Lembaga',
                        'deskripsi' => 'Pencatatan siklus akuntansi jasa/dagang/manufaktur, aplikasi Accurate/MYOB, dan pelaporan pajak SPT.',
                        'konsentrasi' => [
                            ['kode' => 'AKUN', 'nama' => 'Akuntansi Keuangan dan Pajak', 'deskripsi' => 'Penyusunan laporan keuangan neraca laba rugi, e-Faktur pajak PPh/PPN, dan audit internal.'],
                            ['kode' => 'PERBANK', 'nama' => 'Perbankan dan Keuangan Mikro', 'deskripsi' => 'Operasional frontliner bank, analisis kelayakan kredit UMKM, dan akuntansi perbankan.'],
                        ]
                    ],
                    [
                        'kode' => 'PMS',
                        'nama' => 'Pemasaran',
                        'deskripsi' => 'Riset pasar, promosi digital marketing (SEO/SEM/Social Media Ads), dan manajemen toko ritel modern.',
                        'konsentrasi' => [
                            ['kode' => 'BISPEM', 'nama' => 'Bisnis Digital dan Pemasaran Ritel', 'deskripsi' => 'Pengelolaan e-commerce marketplace, live streaming commerce, content marketing, dan penataan display visual merchandising.'],
                        ]
                    ],
                ]
            ],

            // 9. PARIWISATA
            [
                'bidang' => [
                    'kode' => 'PAR',
                    'nama' => 'Pariwisata',
                    'deskripsi' => 'Bidang keahlian pelayanan industri perhotelan bintang, kuliner hidangan nusantara/kontinental, bakery pastry, dan biro perjalanan wisata.'
                ],
                'programs' => [
                    [
                        'kode' => 'HOTEL',
                        'nama' => 'Perhotelan',
                        'deskripsi' => 'Pelayanan akomodasi tamu, tata graha (housekeeping), dan kantor depan (front office) hotel bintang.',
                        'konsentrasi' => [
                            ['kode' => 'PERHOT', 'nama' => 'Perhotelan (Akomodasi Perhotelan)', 'deskripsi' => 'Reservasi check-in/check-out tamu, penanganan keluhan, pembersihan kamar hotel, dan public area attendant.'],
                            ['kode' => 'LAUNDRY', 'nama' => 'Layanan Cuci dan Linen (Laundry)', 'deskripsi' => 'Pengoperasian mesin cuci industri (washer extractor), dry cleaning, dan press linen.'],
                        ]
                    ],
                    [
                        'kode' => 'KUL',
                        'nama' => 'Kuliner',
                        'deskripsi' => 'Pengolahan hidangan nusantara, oriental, kontinental, bakery roti, pastry kue, dan barista kafe.',
                        'konsentrasi' => [
                            ['kode' => 'TATBOG', 'nama' => 'Kuliner (Tata Boga)', 'deskripsi' => 'Teknik memasak appetizer, main course, dessert, food plating artistik, dan higienitas sanitasi makanan.'],
                            ['kode' => 'PASTRY', 'nama' => 'Pastry dan Bakery', 'deskripsi' => 'Pembuatan adonan roti manis, croissant, cake dekorasi, cokelat praline, dan kue tradisional.'],
                        ]
                    ],
                    [
                        'kode' => 'ULW',
                        'nama' => 'Usaha Layanan Wisata',
                        'deskripsi' => 'Pemanduan wisata (tour guiding), reservasi tiket pesawat/kereta, dan penyusunan paket tour itinerary.',
                        'konsentrasi' => [
                            ['kode' => 'WISATA', 'nama' => 'Usaha Layanan Wisata (Tour and Travel)', 'deskripsi' => 'MICE (Meeting, Incentive, Convention, Exhibition), ticketing GDS, dan kepemanduan lokal/nasional.'],
                        ]
                    ],
                    [
                        'kode' => 'KECANTIK',
                        'nama' => 'Kecantikan dan Spa',
                        'deskripsi' => 'Perawatan kulit wajah, rias pengantin, penataan rambut, dan pijat relaksasi tubuh (body massage).',
                        'konsentrasi' => [
                            ['kode' => 'TKKR', 'nama' => 'Tata Kecantikan Kulit dan Rambut', 'deskripsi' => 'Facial manual/alat listrik, tata rias make-up artist (MUA), pemangkasan rambut, dan hair coloring.'],
                            ['kode' => 'SPA', 'nama' => 'Spa dan Terapi Relaksasi', 'deskripsi' => 'Hydrotherapy, lulur tradisional boreh, aromatherapy, dan refleksiologi kaki.'],
                        ]
                    ],
                ]
            ],

            // 10. SENI DAN EKONOMI KREATIF
            [
                'bidang' => [
                    'kode' => 'SEK',
                    'nama' => 'Seni dan Ekonomi Kreatif',
                    'deskripsi' => 'Bidang keahlian desain grafis, animasi, broadcasting video perfilman, kriya seni tekstil/kayu, fesyen busana, dan seni pertunjukan.'
                ],
                'programs' => [
                    [
                        'kode' => 'DKV',
                        'nama' => 'Desain Komunikasi Visual',
                        'deskripsi' => 'Perancangan identitas visual branding, tipografi, fotografi, ilustrasi digital, dan desain media cetak/interaktif.',
                        'konsentrasi' => [
                            ['kode' => 'DKV-K', 'nama' => 'Desain Komunikasi Visual (DKV)', 'deskripsi' => 'Software Adobe Illustrator/Photoshop/InDesign, pembuatan logo branding, poster, UI desain, dan packaging.'],
                        ]
                    ],
                    [
                        'kode' => 'ANIM',
                        'nama' => 'Animasi',
                        'deskripsi' => 'Pembuatan animasi 2D cut-out/frame-by-frame, pemodelan 3D aset karakter, rigging, dan render gerak.',
                        'konsentrasi' => [
                            ['kode' => 'ANIM2D', 'nama' => 'Animasi 2D dan Storyboard', 'deskripsi' => 'Prinsip 12 animasi, layout storyboard, inbetweening, dan compositing efek 2D.'],
                            ['kode' => 'ANIM3D', 'nama' => 'Animasi 3D dan Pemodelan Karakter', 'deskripsi' => 'Software Blender/Maya: 3D modeling, texturing UV, rigging kerangka, dan lighting animasi.'],
                        ]
                    ],
                    [
                        'kode' => 'BROADCAST',
                        'nama' => 'Broadcasting dan Perfilman',
                        'deskripsi' => 'Produksi program siaran televisi, tata kamera sinematografi, penulisan skenario naskah, dan editing audio visual.',
                        'konsentrasi' => [
                            ['kode' => 'PSPTV', 'nama' => 'Produksi dan Siaran Program Televisi', 'deskripsi' => 'Tata studio multi-camera, switcher operator, news anchoring, dan live program broadcast.'],
                            ['kode' => 'FILM', 'nama' => 'Produksi Film dan Sinematografi', 'deskripsi' => 'Sutradara, lighting sinematik, tata artistik, sound recording boom, dan color grading DaVinci Resolve.'],
                        ]
                    ],
                    [
                        'kode' => 'BUSANA',
                        'nama' => 'Busana (Tata Busana)',
                        'deskripsi' => 'Desain sketsa fesyen mode, pembuatan pola baju (pattern making), teknik menjahit halus, dan fesyen draping.',
                        'konsentrasi' => [
                            ['kode' => 'DESBUS', 'nama' => 'Desain dan Produksi Busana', 'deskripsi' => 'Pembuatan gaun pesta, busana kerja, kebaya modern, pakaian anak, dan ready-to-wear komersial.'],
                            ['kode' => 'COSTUM', 'nama' => 'Busana Kustom (Custom-Made Fashion)', 'deskripsi' => 'Haute couture, aplikasi bordir payet fesyen tinggi, dan tailoring jas pria.'],
                        ]
                    ],
                    [
                        'kode' => 'KRIYA',
                        'nama' => 'Desain dan Produksi Kriya',
                        'deskripsi' => 'Karya kerajinan tangan bernilai seni tinggi: batik tulis, tekstil tenun, ukir kayu, keramik bakar, dan logam mulia.',
                        'konsentrasi' => [
                            ['kode' => 'KRTEK', 'nama' => 'Kriya Kreatif Batik dan Tekstil', 'deskripsi' => 'Membatik cap dan tulis, pewarnaan alami/sintetis, ikat celup (shibori), dan tenun gedog.'],
                            ['kode' => 'KRKAY', 'nama' => 'Kriya Kreatif Kayu dan Rotan', 'deskripsi' => 'Ukir ornamen tradisional nusantara, bubut kayu, dan pembuatan furnitur kriya artistik.'],
                            ['kode' => 'KRKER', 'nama' => 'Kriya Kreatif Keramik', 'deskripsi' => 'Teknik putar pilin tanah liat, glasir keramik, dan pembakaran tungku suhu tinggi.'],
                            ['kode' => 'KRLOG', 'nama' => 'Kriya Kreatif Logam dan Perhiasan', 'deskripsi' => 'Teknik patri perhiasan perak/tembaga, cetak tuang logam, dan tatah kriya kuningan.'],
                        ]
                    ],
                    [
                        'kode' => 'PERTUNJUK',
                        'nama' => 'Seni Pertunjukan',
                        'deskripsi' => 'Keahlian olah vokal, instrumen musik klasik/tradisional, tari koreografi, dan teater panggung.',
                        'konsentrasi' => [
                            ['kode' => 'SMUSIK', 'nama' => 'Seni Musik Populer dan Klasik', 'deskripsi' => 'Solmisasi partitur not balok, penguasaan instrumen gitar/piano/drum, dan aransemen digital audio workstation (DAW).'],
                            ['kode' => 'STARI', 'nama' => 'Seni Tari Nusantara', 'deskripsi' => 'Penguasaan ragam gerak tari tradisi daerah dan komposisi karya tari kreasi modern.'],
                            ['kode' => 'SKARAW', 'nama' => 'Seni Karawitan dan Pedalangan', 'deskripsi' => 'Tabuhan gamelan pelog slendro, sulukan dalang, dan pertunjukan wayang kulit/golek.'],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($spektrumData as $data) {
            $bidang = BidangKeahlian::updateOrCreate(
                ['kode' => $data['bidang']['kode']],
                $data['bidang']
            );

            foreach ($data['programs'] as $progData) {
                $program = ProgramKeahlian::updateOrCreate(
                    ['kode' => $progData['kode']],
                    [
                        'bidang_keahlian_id' => $bidang->id,
                        'nama' => $progData['nama'],
                        'deskripsi' => $progData['deskripsi'],
                        'is_active' => true,
                    ]
                );

                if (!empty($progData['konsentrasi'])) {
                    foreach ($progData['konsentrasi'] as $konData) {
                        KonsentrasiKeahlian::updateOrCreate(
                            ['kode' => $konData['kode']],
                            [
                                'program_keahlian_id' => $program->id,
                                'nama' => $konData['nama'],
                                'deskripsi' => $konData['deskripsi'],
                                'is_active' => true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
