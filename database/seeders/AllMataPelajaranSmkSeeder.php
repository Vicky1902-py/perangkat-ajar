<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\ProgramKeahlian;
use Illuminate\Database\Seeder;

class AllMataPelajaranSmkSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KELOMPOK UMUM (Wajib untuk Seluruh Jenjang dan Jurusan SMK - Fase E & F)
        $mapelUmum = [
            [
                'nama' => 'Pendidikan Agama dan Budi Pekerti',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 3,
                'deskripsi' => 'Pengembangan nilai spiritual, keimanan, ketakwaan, moralitas, akhlak mulia, dan toleransi antarumat beragama sesuai ajaran agama masing-masing.'
            ],
            [
                'nama' => 'Pendidikan Pancasila',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 2,
                'deskripsi' => 'Penguatan ideologi Pancasila, konstitusi UUD NRI 1945, komitmen NKRI, Bhinneka Tunggal Ika, dan pembentukan karakter kewargaan yang berintegritas.'
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 4,
                'deskripsi' => 'Pengembangan kemampuan berkomunikasi lisan dan tulis, berpikir kritis, literasi teks fiksi/nonfiksi, serta penulisan karya ilmiah dan dokumen profesional/teknis.'
            ],
            [
                'nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 3,
                'deskripsi' => 'Kebugaran jasmani, kesehatan fisik dan mental, pola hidup bersih dan sehat, sportivitas, kepemimpinan, dan kerja sama tim (Olah Raga).'
            ],
            [
                'nama' => 'Sejarah',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 2,
                'deskripsi' => 'Pemahaman sejarah perjuangan bangsa Indonesia, kesadaran sejarah masa lampau, masa kini, dan masa depan dalam dinamika peradaban global.'
            ],
            [
                'nama' => 'Seni Budaya',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 2,
                'deskripsi' => 'Apresiasi dan ekspresi kreatif seni rupa, seni musik, seni tari, atau seni teater untuk memupuk kepekaan estetika dan Olah Rasa.'
            ],
            [
                'nama' => 'Matematika',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 4,
                'deskripsi' => 'Penalaran logis, pemodelan matematis, analisis aljabar, kalkulus dasar, geometri, statistika, dan pemecahan masalah kuantitatif di dunia kerja kejuruan.'
            ],
            [
                'nama' => 'Bahasa Inggris',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 4,
                'deskripsi' => 'Komunikasi global lisan dan tulisan, penguasaan istilah teknis kejuruan (English for Specific Purposes), dan korespondensi bisnis internasional.'
            ],
            [
                'nama' => 'Informatika',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 4,
                'deskripsi' => 'Mata pelajaran wajib Fase E (Kelas X): Berpikir komputasional, literasi digital, analisis data, arsitektur komputer, jaringan internet, dan pemrograman dasar.'
            ],
            [
                'nama' => 'Projek Ilmu Pengetahuan Alam dan Sosial (IPAS)',
                'kelompok' => 'umum',
                'jam_pelajaran_per_minggu' => 6,
                'deskripsi' => 'Mata pelajaran wajib Fase E (Kelas X): Integrasi sains alam dan sosial untuk menganalisis fenomena kehidupan sehari-hari, energi, materi, dan ekosistem industri.'
            ],
        ];

        foreach ($mapelUmum as $m) {
            MataPelajaran::updateOrCreate(
                ['nama' => $m['nama'], 'kelompok' => 'umum'],
                array_merge($m, ['program_keahlian_id' => null, 'is_active' => true])
            );
        }

        // 2. MATA PELAJARAN PILIHAN BARU & WAJIB KEJURUAN NASIONAL (Permendikdasmen No. 13 Tahun 2025)
        // Dapat diambil oleh seluruh siswa dari semua jurusan SMK
        $mapelLintasJurusan = [
            [
                'nama' => 'Koding dan Kecerdasan Artifisial (AI)',
                'kelompok' => 'kejuruan',
                'jam_pelajaran_per_minggu' => 4,
                'deskripsi' => 'Mata pelajaran prioritas digital Permendikdasmen 13/2025: Algoritma pemrograman modern, prompt engineering, generative AI, machine learning dasar, computer vision, dan etika kecerdasan artifisial.'
            ],
            [
                'nama' => 'Projek Kreatif dan Kewirausahaan (PKK)',
                'kelompok' => 'kejuruan',
                'jam_pelajaran_per_minggu' => 5,
                'deskripsi' => 'Mata pelajaran wajib Fase F (Kelas XI & XII): Perancangan produk kreatif, riset pasar, penyusunan business plan, pemasaran digital omnichannel, laporan laba-rugi, dan HAKI.'
            ],
            [
                'nama' => 'Praktik Kerja Lapangan (PKL)',
                'kelompok' => 'kejuruan',
                'jam_pelajaran_per_minggu' => 44,
                'deskripsi' => 'Mata pelajaran wajib magang industri 1-2 semester pada Fase F (Kelas XII): Pengalaman kerja nyata di industri mitra berstandar kerja profesional dan budaya kerja 5R.'
            ],
        ];

        foreach ($mapelLintasJurusan as $mb) {
            MataPelajaran::updateOrCreate(
                ['nama' => $mb['nama'], 'kelompok' => 'kejuruan'],
                array_merge($mb, ['program_keahlian_id' => null, 'is_active' => true])
            );
        }

        // 3. DASAR-DASAR PROGRAM KEAHLIAN (Fase E - Kelas X SMK) untuk SELURUH Program Keahlian
        $allPrograms = ProgramKeahlian::all();
        foreach ($allPrograms as $prog) {
            $namaDasarMapel = 'Dasar-dasar ' . $prog->nama;
            MataPelajaran::updateOrCreate(
                ['nama' => $namaDasarMapel, 'program_keahlian_id' => $prog->id],
                [
                    'nama' => $namaDasarMapel,
                    'kelompok' => 'kejuruan',
                    'program_keahlian_id' => $prog->id,
                    'jam_pelajaran_per_minggu' => 12,
                    'deskripsi' => 'Mata pelajaran fondasi kejuruan Fase E (Kelas X) untuk Program Keahlian ' . $prog->nama . ': Proses bisnis industri, perkembangan teknologi terkini, profesi technopreneur, K3LH, dan keterampilan teknik dasar.',
                    'is_active' => true,
                ]
            );
        }

        // 4. KONSENTRASI KEAHLIAN (Fase F - Kelas XI & XII SMK)
        $konsentrasiMapel = [
            // TEKNIK KETENAGALISTRIKAN
            ['prog' => 'TLIS', 'nama' => 'Teknik Instalasi Tenaga Listrik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Instalasi penerangan dan tenaga gedung/industri, panel PLC, instalasi motor 3 fasa, dan sistem smart home.'],
            ['prog' => 'TLIS', 'nama' => 'Teknik Jaringan Tenaga Listrik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Konstruksi saluran udara tegangan menengah/rendah (SUTM/SUTR), gardu distribusi trafo, dan proteksi jaringan.'],
            ['prog' => 'TLIS', 'nama' => 'Teknik Pembangkit Tenaga Listrik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Operasi generator turbin uap/gas/air/diesel, sistem eksitasi, sinkronisasi daya, dan pemeliharaan pembangkit.'],

            // TEKNIK MESIN & PENGELASAN
            ['prog' => 'TMES', 'nama' => 'Teknik Pemesinan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemrograman CNC Bubut/Frais CAM, toleransi geometris presisi ISO, dan permesinan bubut konvensional.'],
            ['prog' => 'TMES', 'nama' => 'Teknik Pengelasan (Welding)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengelasan pipa dan plat posisi 1G-6G SMAW/GMAW/GTAW, welding procedure specification (WPS), dan uji NDT/DT.'],
            ['prog' => 'TMES', 'nama' => 'Teknik Fabrikasi Logam dan Manufaktur', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pembentukan lembaran plat logam (sheet metal), pemotongan laser/plasma, perakitan konstruksi baja, dan inspeksi QC.'],
            ['prog' => 'TMES', 'nama' => 'Teknik Pengecoran Logam', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pembuatan pola pasir cetak, peleburan logam besi/non-besi di tungku induksi/kupola, dan perlakuan panas (heat treatment).'],

            // TEKNIK BANGUNAN & SIPIL (TKP)
            ['prog' => 'DPIB', 'nama' => 'Desain Pemodelan dan Informasi Bangunan (BIM)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perancangan model 3D arsitektur dan struktur berbasis Revit BIM, AutoCAD 2D detail shop drawing, dan volume RAB.'],
            ['prog' => 'KPB', 'nama' => 'Konstruksi Gedung dan Sanitasi', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pekerjaan pembesian beton bertulang, pasangan bata plesteran, instalasi perpipaan air bersih dan kotor sanitasi gedung.'],
            ['prog' => 'KPB', 'nama' => 'Konstruksi Jalan dan Jembatan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengukuran elevasi leveling, perkerasan aspal lentur/kaku beton, struktur girder jembatan, dan uji kuat tekan tanah.'],
            ['prog' => 'TGEO', 'nama' => 'Teknik Geomatika dan Survei Pemetaan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemetaan terestrial total station, survei drone fotogrametri UAV, pengolahan citra satelit, dan Sistem Informasi Geografis (GIS).'],

            // TEKNIK OTOMOTIF
            ['prog' => 'TOTO', 'nama' => 'Teknik Kendaraan Ringan Otomotif', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Diagnosis scanner OBD-II mesin bensin/diesel common rail, transmisi otomatis/CVT, sistem rem ABS/ESP, EPS, dan AC mobil.'],
            ['prog' => 'TOTO', 'nama' => 'Teknik Sepeda Motor', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perawatan sistem injeksi elektronik PGM-FI/YMJET-FI, transmisi CVT matic, sistem suspensi sasis, dan kelistrikan motor.'],
            ['prog' => 'TOTO', 'nama' => 'Teknik Kendaraan Listrik (Electric Vehicle)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Motor traksi listrik BLDC/PMSM, inverter controller PWM, battery management system (BMS) lithium, regenerative braking, dan safety EV.'],
            ['prog' => 'TOTO', 'nama' => 'Teknik Alat Berat', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemeliharaan sistem hidrolik tekanan tinggi, powertrain transmisi powershift, dan engine diesel heavy-duty alat tambang/konstruksi.'],
            ['prog' => 'TOTO', 'nama' => 'Teknik Bodi Kendaraan Ringan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perbaikan ketuk bodi, penarikan sasis dozer, pendempulan, pengecatan oven spray booth, dan detailing polishing cat mobil.'],

            // TEKNIK ELEKTRONIKA
            ['prog' => 'TELK', 'nama' => 'Teknik Audio Video', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perancangan amplifier audio Hi-Fi, sistem akustik ruang, pengolahan sinyal digital audio/video, dan instalasi studio siaran.'],
            ['prog' => 'TELK', 'nama' => 'Teknik Elektronika Industri', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemrograman PLC ladder diagram, perancangan sirkuit kontrol sensorik, sistem elektro-pneumatik, dan elektronika daya thyristor.'],
            ['prog' => 'TELK', 'nama' => 'Teknik Mekatronika', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Integrasi mekanik presisi, motor servo stepper, embedded microcontroller, dan perancangan lengan robot industri.'],
            ['prog' => 'TELK', 'nama' => 'Teknik Otomasi Industri', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Sistem kontrol SCADA, Distributed Control System (DCS), instrumentasi transmitter suhu/tekanan/aliran, dan kalibrasi sensor.'],

            // TEKNIK PESAWAT UDARA & LOGISTIK
            ['prog' => 'TAER', 'nama' => 'Airframe and Powerplant', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemeliharaan struktur badan pesawat (airframe sheet metal/komposit) dan perbaikan mesin turbin gas/jet piston propulsi.'],
            ['prog' => 'TAER', 'nama' => 'Electrical Avionics', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Kalibrasi radar cuaca, komunikasi VHF/HF, instrumen navigasi autopilot, flight management system (FMS), dan wiring avionik.'],
            ['prog' => 'TLOG', 'nama' => 'Manajemen Pergudangan dan Logistik Manufaktur', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Manajemen sistem WMS (Warehouse Management System), pengendalian persediaan barang ABC, material handling, dan distribusi ekspor-impor.'],

            // ENERGI TERBARUKAN & PERTAMBANGAN
            ['prog' => 'ETEB', 'nama' => 'Teknik Energi Surya, Hidro, dan Angin', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perancangan sistem panel surya PLTS fotovoltaik on/off-grid, turbin angin sumbu horizontal/vertikal, dan pembangkit mikrohidro.'],
            ['prog' => 'ETEB', 'nama' => 'Teknik Energi Biomassa', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Proses fermentasi anaerobik biodigester biogas, pembuatan briket pelet biomassa limbah pertanian, dan pirolisis biofuel.'],
            ['prog' => 'TGMIN', 'nama' => 'Geologi Pertambangan dan Eksplorasi', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemetaan singkapan geologi, identifikasi batuan mineral petrografi, pemboran inti eksplorasi (core drilling), dan estimasi cadangan tambang.'],
            ['prog' => 'TMIG', 'nama' => 'Teknik Pemboran Minyak dan Gas', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Operasi rig pemboran migas, sirkulasi lumpur pemboran (drilling mud), pencegahan blow-out preventer (BOP), dan komplesi sumur.'],
            ['prog' => 'TMIG', 'nama' => 'Teknik Pengolahan Minyak, Gas, dan Petrokimia', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Operasi kolom distilasi fraksionasi minyak mentah (refinery), proses catalytic cracking, dan pemurnian produk gas LPG/LNG.'],

            // PENGEMBANGAN PERANGKAT LUNAK DAN GIM (PPLG)
            ['prog' => 'PPLG', 'nama' => 'Rekayasa Perangkat Lunak', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemrograman web modern fullstack (Laravel/Vue/React), perancangan RESTful API, arsitektur basis data relasional/NoSQL, dan clean code agile.'],
            ['prog' => 'PPLG', 'nama' => 'Pemrograman Web dan Perangkat Bergerak', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Desain antarmuka UI/UX Figma, pengembangan aplikasi mobile Android native/cross-platform (Flutter), dan responsive frontend modern.'],
            ['prog' => 'PPLG', 'nama' => 'Pengembangan Gim', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Desain level gim (game mechanics), pemrograman logika gim engine Unity/Godot C#, pembuatan aset grafis 2D/3D, dan publishing gim.'],

            // TEKNIK JARINGAN KOMPUTER DAN TELEKOMUNIKASI (TJKT & SIJA)
            ['prog' => 'TJKT', 'nama' => 'Teknik Komputer dan Jaringan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Konfigurasi routing protokol OSPF/BGP Mikrotik & Cisco, firewall security, Linux system administration, dan virtualisasi cloud server.'],
            ['prog' => 'TJKT', 'nama' => 'Keamanan Jaringan dan Siber (Cyber Security)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Vulnerability assessment, ethical hacking defensif, konfigurasi IDS/IPS Snort, SIEM log analysis, dan penanganan insiden siber.'],
            ['prog' => 'TJKT', 'nama' => 'Teknik Telekomunikasi dan Fiber Optik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penyambungan kabel fiber optik fusion splicer, pengukuran redaman kabel OTDR, teknologi transmisi gelombang mikro, dan jaringan 5G/FTTH.'],
            ['prog' => 'SIJA', 'nama' => 'Sistem Informasi, Jaringan, dan Aplikasi', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Arsitektur cloud computing AWS/GCP, Internet of Things (IoT) sensorik enterprise, pipeline DevOps CI/CD, dan audit sistem IT.'],

            // KESEHATAN DAN PEKERJAAN SOSIAL
            ['prog' => 'LKBS', 'nama' => 'Asisten Keperawatan dan Caregiver', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemeriksaan tanda-tanda vital, pemenuhan kebutuhan dasar personal hygiene pasien, pemberian nutrisi enteral NGT, dan perawatan lansia geriatri.'],
            ['prog' => 'TFAR', 'nama' => 'Farmasi Klinis dan Komunitas', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Skrining administrasi resep dokter, peracikan sediaan obat pulvis/kapsul/salep/sirup, perhitungan dosis lazim maksimum, dan KIE obat di apotek.'],
            ['prog' => 'TFAR', 'nama' => 'Farmasi Industri', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penerapan Cara Pembuatan Obat yang Baik (CPOB), proses formulasi granulasi tablet, kontrol kualitas uji disolusi/kekerasan, dan sterilisasi.'],
            ['prog' => 'TLM', 'nama' => 'Asisten Teknik Laboratorium Medik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Flebotomi pengambilan darah vena/kapiler, pemeriksaan hematologi sel darah, kimia klinik gula darah/kolesterol, urinalisis, dan mikrobiologi.'],
            ['prog' => 'PEKSOS', 'nama' => 'Pekerjaan Sosial', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Asesmen masalah sosial individu/keluarga/kelompok, penanganan trauma healing, advokasi anak dan disabilitas, serta pemberdayaan komunitas.'],

            // AGRIBISNIS DAN AGRITEKNOLOGI
            ['prog' => 'AGTAN', 'nama' => 'Agribisnis Tanaman Pangan dan Hortikultura', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Budidaya sayuran daun/buah, hidroponik greenhouse sistem DFT/NFT, pengendalian hama terpadu (PHT), pemupukan presisi, dan pascapanen.'],
            ['prog' => 'AGTAN', 'nama' => 'Agribisnis Tanaman Perkebunan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengelolaan pembibitan dan pemeliharaan kelapa sawit/kopi/kakao, pemangkasan tajuk, pemanenan tandan buah segar, dan pengolahan getah/biji.'],
            ['prog' => 'AGTER', 'nama' => 'Agribisnis Ternak Unggas dan Ruminansia', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Manajemen brooding ayam broiler/layer closed house, formulasi ransum pakan ternak, inseminasi buatan (IB) sapi, dan sanitasi biosekuriti.'],
            ['prog' => 'AGPIK', 'nama' => 'Agribisnis Perikanan Air Tawar dan Laut', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemijahan ikan lele/nila/patin, teknologi bioflok kolam bundar, budidaya udang vaname intensif, manajemen pakan pelet, dan kualitas air.'],
            ['prog' => 'APHP', 'nama' => 'Agribisnis Pengolahan Hasil Pertanian', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengolahan produk pangan nabati/hewani (roti, sirup, nugget, selai), pengujian mutu organoleptik mikrobiologi, HACCP, dan pengemasan vakum.'],
            ['prog' => 'KEHUT', 'nama' => 'Kehutanan dan Konservasi Sumber Daya Hutan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Inventarisasi tegakan hutan, persemaian bibit kayu hutan jati/mahoni, pemetaan batas kawasan lindung GIS, dan pencegahan kebakaran hutan.'],

            // KEMARITIMAN
            ['prog' => 'PENGKAP', 'nama' => 'Nautika Kapal Penangkap Ikan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Olah gerak kapal penangkap ikan, navigasi radar/GPS/fish finder, pengoperasian alat tangkap pukat cincin/rawai, dan keselamatan SOLAS STCW-F.'],
            ['prog' => 'PENGKAP', 'nama' => 'Teknika Kapal Penangkap Ikan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perawatan mesin penggerak utama diesel kapal, sistem pendingin cold storage ruang palka ikan, kompresor udara, dan instalasi listrik kapal.'],
            ['prog' => 'PELNIAG', 'nama' => 'Nautika Kapal Niaga', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Navigasi astronomi dan elektronik ECDIS, aturan pencegahan tubrukan di laut (COLREG), dinas jaga anjungan pelayaran samudra, dan SAR maritim.'],
            ['prog' => 'PELNIAG', 'nama' => 'Teknika Kapal Niaga', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengoperasian mesin diesel turbin kapal kargo/tangki, sistem purifier bahan bakar, ketel uap uap boiler, dan penanganan darurat kamar mesin.'],

            // BISNIS DAN MANAJEMEN
            ['prog' => 'AKL', 'nama' => 'Akuntansi Keuangan dan Lembaga', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Siklus akuntansi perusahaan jasa/dagang/manufaktur, komputer akuntansi Accurate/MYOB, pelaporan perpajakan SPT PPh/PPN, dan audit kas.'],
            ['prog' => 'AKL', 'nama' => 'Perbankan dan Keuangan Syariah', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Operasional perbankan teller dan customer service, tabungan giro deposito, administrasi akad syariah (mudharabah, murabahah), dan microfinance.'],
            ['prog' => 'MPLB', 'nama' => 'Manajemen Perkantoran (Otomatisasi Tata Kelola Perkantoran)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengelolaan arsip elektronik digital, korespondensi bisnis resmi, pengaturan rapat virtual dan keprotokolan, serta pelayanan prima tamu kantor.'],
            ['prog' => 'PMS', 'nama' => 'Bisnis Digital dan Pemasaran Ritel', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pemasaran digital media sosial, Google Ads, SEO, manajemen live streaming penjualan toko online, visual merchandising, dan kasir POS ritel.'],

            // PARIWISATA & KULINER
            ['prog' => 'KUL', 'nama' => 'Kuliner (Tata Boga)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pengolahan hidangan nusantara, masakan kontinental eropa, masakan oriental asia, teknik plating modern, food safety hygiene, dan cost control F&B.'],
            ['prog' => 'KUL', 'nama' => 'Pastry dan Bakery', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pembuatan adonan roti manis/sourdough, croissant puff pastry, cake dekorasi wedding modern, cokelat praline, dan dessert etalase patisserie.'],
            ['prog' => 'HOTEL', 'nama' => 'Perhotelan (Akomodasi Perhotelan)', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Operasional front office check-in/check-out sistem PMS hotel, housekeeping perapian kamar tamu, public area cleaning, dan laundry dry clean.'],
            ['prog' => 'ULW', 'nama' => 'Usaha Layanan Wisata dan Ekowisata', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penyusunan paket tur wisata domestik/mancanegara, reservasi tiket penerbangan dan hotel GDS, pemanduan wisata (tour guiding), dan mice event.'],
            ['prog' => 'KECANTIK', 'nama' => 'Tata Kecantikan Kulit dan Rambut', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perawatan kulit wajah facial manual dan mesin elektrik, make up rias pengantin adat/internasional, pemangkasan rambut stylist, dan pewarnaan rambut.'],
            ['prog' => 'KECANTIK', 'nama' => 'Spa Therapy dan Wellness', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Teknik pemijatan tubuh tradisional nusantara (body massage), lulur scrub herbal rempah, aromaterapi relaksasi, hidroterapi, dan hidro bath.'],

            // SENI DAN EKONOMI KREATIF
            ['prog' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Perancangan corporate identity brand logo, desain grafis kemasan produk (packaging), tipografi, ilustrasi digital, dan antarmuka UI/UX mobile.'],
            ['prog' => 'ANIM', 'nama' => 'Animasi 3D dan Pemodelan Karakter', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Modeling aset karakter dan lingkungan 3D Blender/Maya, texturing UV unwrap, rigging skeleton gerak, animasi prinsip gerak, dan rendering sinematik.'],
            ['prog' => 'BROADCAST', 'nama' => 'Produksi Siaran Program Televisi dan Film', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penulisan skenario naskah film, tata kamera sinematografi video, tata pencahayaan lighting, rekaman audio sound recording, dan editing Adobe Premiere.'],
            ['prog' => 'BUSANA', 'nama' => 'Desain dan Produksi Busana', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pembuatan pola gaun pesta wanita, teknik draping dressform, penjahitan tailoring kemeja jas berfuring, aplikasi payet bordir, dan koleksi fesyen.'],
            ['prog' => 'KRIYA', 'nama' => 'Kriya Kreatif Batik, Tekstil, dan Kayu', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Proses pembatikan canting tulis dan cap lilin, pewarnaan indigosol/napthol, ukiran kayu ornamen nusantara, dan pembuatan cinderamata kriya artistik.'],
            ['prog' => 'PERTUNJUK', 'nama' => 'Seni Musik Populer dan Klasik', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Pembacaan partitur notasi balok solfeggio, penguasaan instrumen musik mayor/minor, aransemen lagu ensemble, dan rekaman audio studio digital DAW.'],
            ['prog' => 'PERTUNJUK', 'nama' => 'Seni Tari Nusantara', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penguasaan ragam gerak tari tradisi berbagai etnis nusantara, teknik wiraga wirama wirasa, koreografi tari kreasi baru, dan penataan busana pentas tari.'],
            ['prog' => 'PERTUNJUK', 'nama' => 'Seni Karawitan dan Pedalangan', 'jp' => 18, 'desc' => 'Konsentrasi keahlian Fase F: Penabuhan instrumen gamelan laras pelog dan slendro, vokal sindhen gerong, teknik sulukan pedalangan, dan pergelaran wayang berdurasi.'],
        ];

        foreach ($konsentrasiMapel as $km) {
            $prog = ProgramKeahlian::where('kode', $km['prog'])->first();
            if ($prog) {
                MataPelajaran::updateOrCreate(
                    ['nama' => $km['nama'], 'program_keahlian_id' => $prog->id],
                    [
                        'nama' => $km['nama'],
                        'kelompok' => 'kejuruan',
                        'program_keahlian_id' => $prog->id,
                        'jam_pelajaran_per_minggu' => $km['jp'],
                        'deskripsi' => $km['desc'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
