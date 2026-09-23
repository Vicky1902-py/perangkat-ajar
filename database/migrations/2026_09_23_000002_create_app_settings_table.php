<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index();
            $table->longText('value')->nullable();
            $table->string('group', 50)->default('general')->index();
            $table->string('type', 30)->default('text'); // text, textarea, image, color, boolean, json
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed data awal pengaturan aplikasi
        $defaultSettings = [
            // BRANDING
            [
                'key' => 'app_name',
                'value' => 'Sistem Perangkat Ajar SMK 2026',
                'group' => 'branding',
                'type' => 'text',
                'label' => 'Nama Aplikasi',
                'description' => 'Nama platform yang tampil pada header, title tab, dan dokumen.',
            ],
            [
                'key' => 'app_tagline',
                'value' => 'Kurikulum Merdeka (Pendekatan Pembelajaran Mendalam / Deep Learning)',
                'group' => 'branding',
                'type' => 'text',
                'label' => 'Tagline / Slogan',
                'description' => 'Slogan kurikulum atau deskripsi singkat sistem.',
            ],
            [
                'key' => 'app_logo',
                'value' => null,
                'group' => 'branding',
                'type' => 'image',
                'label' => 'Logo Aplikasi',
                'description' => 'Logo utama untuk navbar, welcome page, dan login (Format PNG/SVG/WebP).',
            ],
            [
                'key' => 'app_favicon',
                'value' => null,
                'group' => 'branding',
                'type' => 'image',
                'label' => 'Favicon Browser',
                'description' => 'Ikon kecil tab browser (Format ICO/PNG).',
            ],

            // TEMA & WARNA
            [
                'key' => 'theme_preset',
                'value' => 'cosmic_sapphire',
                'group' => 'theme',
                'type' => 'text',
                'label' => 'Preset Tema Visual',
                'description' => 'Pilihan palet warna visual sistem.',
            ],
            [
                'key' => 'theme_primary_color',
                'value' => '#2563eb',
                'group' => 'theme',
                'type' => 'color',
                'label' => 'Warna Utama (Primary Glow)',
                'description' => 'Kode HEX warna primer navigasi & tombol.',
            ],
            [
                'key' => 'theme_accent_cyan',
                'value' => '#38bdf8',
                'group' => 'theme',
                'type' => 'color',
                'label' => 'Warna Aksen 1 (Cyan / Highlight)',
                'description' => 'Kode HEX warna aksen cerah.',
            ],
            [
                'key' => 'theme_accent_indigo',
                'value' => '#6366f1',
                'group' => 'theme',
                'type' => 'color',
                'label' => 'Warna Aksen 2 (Indigo / Glow)',
                'description' => 'Kode HEX pendaran cahaya sekunder.',
            ],

            // LANDING PAGE: HERO
            [
                'key' => 'landing_hero_badge',
                'value' => 'STANDAR RESMI KURIKULUM MERDEKA 2026 • BSKAP 046/2025',
                'group' => 'landing_hero',
                'type' => 'text',
                'label' => 'Lencana / Badge Hero',
                'description' => 'Pita teks lencana pada bagian atas judul utama.',
            ],
            [
                'key' => 'landing_hero_title',
                'value' => 'Revolusi Penyusunan Perangkat Ajar SMK 2026 Berbasis Deep Learning',
                'group' => 'landing_hero',
                'type' => 'text',
                'label' => 'Judul Utama (Hero Title)',
                'description' => 'Judul besar pada halaman muka / welcome page.',
            ],
            [
                'key' => 'landing_hero_subtitle',
                'value' => 'Platform komputasi cerdas yang mengotomatisasi penyusunan TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes, dan Asesmen ber-Kop Surat Resmi Kedinasan sesuai Keputusan Kepala BSKAP Nomor 046/H/KR/2025 & Permendikdasmen No. 13/2025.',
                'group' => 'landing_hero',
                'type' => 'textarea',
                'label' => 'Deskripsi / Subjudul Hero',
                'description' => 'Penjelasan ringkas fungsi platform di bawah judul utama.',
            ],
            [
                'key' => 'landing_hero_cta_primary',
                'value' => 'Coba Generator Gratis (Maks. 2x)',
                'group' => 'landing_hero',
                'type' => 'text',
                'label' => 'Teks Tombol Aksi Utama',
                'description' => 'Teks tombol uji coba tamu gratis.',
            ],
            [
                'key' => 'landing_hero_image',
                'value' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                'group' => 'landing_hero',
                'type' => 'image',
                'label' => 'Foto / Gambar Hero Mockup',
                'description' => 'URL atau file foto siswa/guru di sisi kanan hero.',
            ],

            // LANDING PAGE: 3 PILAR DEEP LEARNING
            [
                'key' => 'landing_pilar_mindful_title',
                'value' => 'Mindful',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Judul Pilar 1',
                'description' => 'Nama pilar pembelajaran pertama.',
            ],
            [
                'key' => 'landing_pilar_mindful_subtitle',
                'value' => 'Pembelajaran Berkesadaran',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Subjudul Pilar 1',
                'description' => 'Fokus pilar pertama.',
            ],
            [
                'key' => 'landing_pilar_mindful_desc',
                'value' => 'Menuntun peserta didik menyadari tujuan belajar, mengaitkan materi kejuruan dengan potensi diri, dan hadir secara penuh dalam setiap aktivitas vokasi.',
                'group' => 'landing_pilar',
                'type' => 'textarea',
                'label' => 'Deskripsi Pilar 1',
                'description' => 'Penjabaran filosofi pilar pertama.',
            ],
            [
                'key' => 'landing_pilar_mindful_img',
                'value' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80',
                'group' => 'landing_pilar',
                'type' => 'image',
                'label' => 'Foto Pilar 1',
                'description' => 'Foto ilustrasi pilar pertama.',
            ],
            [
                'key' => 'landing_pilar_meaningful_title',
                'value' => 'Meaningful',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Judul Pilar 2',
                'description' => 'Nama pilar pembelajaran kedua.',
            ],
            [
                'key' => 'landing_pilar_meaningful_subtitle',
                'value' => 'Pembelajaran Bermakna',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Subjudul Pilar 2',
                'description' => 'Fokus pilar kedua.',
            ],
            [
                'key' => 'landing_pilar_meaningful_desc',
                'value' => 'Menghubungkan setiap capaian pembelajaran dengan kebutuhan nyata Dunia Usaha & Industri (DUDI), proyek nyata, dan kesiapan kerja masa depan.',
                'group' => 'landing_pilar',
                'type' => 'textarea',
                'label' => 'Deskripsi Pilar 2',
                'description' => 'Penjabaran filosofi pilar kedua.',
            ],
            [
                'key' => 'landing_pilar_meaningful_img',
                'value' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80',
                'group' => 'landing_pilar',
                'type' => 'image',
                'label' => 'Foto Pilar 2',
                'description' => 'Foto ilustrasi pilar kedua.',
            ],
            [
                'key' => 'landing_pilar_joyful_title',
                'value' => 'Joyful',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Judul Pilar 3',
                'description' => 'Nama pilar pembelajaran ketiga.',
            ],
            [
                'key' => 'landing_pilar_joyful_subtitle',
                'value' => 'Pembelajaran Menggembirakan',
                'group' => 'landing_pilar',
                'type' => 'text',
                'label' => 'Subjudul Pilar 3',
                'description' => 'Fokus pilar ketiga.',
            ],
            [
                'key' => 'landing_pilar_joyful_desc',
                'value' => 'Membangun atmosfer belajar kolaboratif yang menggembirakan, menumbuhkan rasa ingin tahu yang tinggi, dan antusiasme dalam bereksperimen karya kejuruan.',
                'group' => 'landing_pilar',
                'type' => 'textarea',
                'label' => 'Deskripsi Pilar 3',
                'description' => 'Penjabaran filosofi pilar ketiga.',
            ],
            [
                'key' => 'landing_pilar_joyful_img',
                'value' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80',
                'group' => 'landing_pilar',
                'type' => 'image',
                'label' => 'Foto Pilar 3',
                'description' => 'Foto ilustrasi pilar ketiga.',
            ],

            // LANDING PAGE: CREATOR & COPYRIGHT
            [
                'key' => 'landing_creator_name',
                'value' => 'Vicky Koroh',
                'group' => 'landing_creator',
                'type' => 'text',
                'label' => 'Nama Pembuat / Arsitek',
                'description' => 'Nama pemegang hak cipta dan pengembang resmi sistem.',
            ],
            [
                'key' => 'landing_creator_role',
                'value' => 'Super Administrator & Lead Architect',
                'group' => 'landing_creator',
                'type' => 'text',
                'label' => 'Jabatan / Peran Pembuat',
                'description' => 'Gelar atau peran pembuat sistem.',
            ],
            [
                'key' => 'landing_creator_desc',
                'value' => 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.',
                'group' => 'landing_creator',
                'type' => 'textarea',
                'label' => 'Keterangan Karya',
                'description' => 'Kutipan resmi filosofi pengembangan sistem.',
            ],
            [
                'key' => 'landing_copyright_year',
                'value' => '2026',
                'group' => 'landing_creator',
                'type' => 'text',
                'label' => 'Tahun Hak Cipta',
                'description' => 'Tahun hak cipta aktif (misal 2026).',
            ],
        ];

        $now = now();
        foreach ($defaultSettings as &$setting) {
            $setting['created_at'] = $now;
            $setting['updated_at'] = $now;
        }

        DB::table('app_settings')->insert($defaultSettings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
