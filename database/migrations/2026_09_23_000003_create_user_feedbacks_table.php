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
        Schema::create('user_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama', 255);
            $table->string('email', 255)->nullable();
            $table->string('no_hp', 50)->nullable();
            $table->enum('kategori', [
                'usul_fitur',
                'perbaikan_kekurangan',
                'laporan_bug',
                'pertanyaan',
                'apresiasi',
                'lainnya'
            ])->default('usul_fitur');
            $table->tinyInteger('rating')->default(5);
            $table->string('judul', 255);
            $table->text('pesan');
            $table->enum('status', ['baru', 'ditinjau', 'diterapkan', 'selesai'])->default('baru');
            $table->text('catatan_admin')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->timestamps();
        });

        // Seed default settings for Creator Profile if not exists
        $creatorSettings = [
            [
                'key' => 'creator_avatar',
                'value' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'group' => 'creator_profile',
                'type' => 'image',
                'description' => 'Foto profil atau avatar pencipta aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_headline',
                'value' => 'Software Engineer & Educational Technology Architect',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Gelar atau deskripsi profesi arsitek sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_bio',
                'value' => 'Vicky Koroh adalah pengembang teknologi pendidikan dan arsitek perangkat lunak yang berdedikasi menciptakan inovasi kecerdasan digital untuk memberdayakan para pendidik kejuruan (SMK) di seluruh nusantara. Dengan visi menghadirkan pengalaman belajar yang bermakna (Deep Learning), sistem ini dirancang untuk memangkas beban administratif guru sehingga proses pembelajaran dapat berjalan lebih efektif, inspiratif, dan berorientasi pada masa depan generasi muda Indonesia.',
                'group' => 'creator_profile',
                'type' => 'textarea',
                'description' => 'Biografi lengkap dan visi pencipta aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_education',
                'value' => 'Pakar Rekayasa Perangkat Lunak & Teknologi Pembelajaran Vokasi Modern',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Latar belakang pendidikan dan keahlian spesifik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_skills',
                'value' => 'AI System Engineering, Deep Learning Pedagogy, Cloud Infrastructure, Laravel Architecture, Kurikulum Merdeka SMK, Clean Code & Security',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Daftar keahlian utama dipisahkan dengan tanda koma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_whatsapp',
                'value' => '081234567890',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Nomor WhatsApp resmi untuk komunikasi dan dukungan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_email',
                'value' => 'vicky@vxai.online',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Alamat email kontak resmi pencipta aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_github',
                'value' => 'https://github.com/Vicky1902-py',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Tautan profil GitHub resmi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_linkedin',
                'value' => 'https://linkedin.com/in/vicky-koroh',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Tautan profil LinkedIn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_instagram',
                'value' => 'https://instagram.com/vicky_koroh',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Tautan media sosial Instagram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'creator_website',
                'value' => 'https://guru.vxai.online',
                'group' => 'creator_profile',
                'type' => 'text',
                'description' => 'Situs web resmi atau portofolio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($creatorSettings as $setting) {
            DB::table('app_settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_feedbacks');
        DB::table('app_settings')->where('group', 'creator_profile')->delete();
    }
};
