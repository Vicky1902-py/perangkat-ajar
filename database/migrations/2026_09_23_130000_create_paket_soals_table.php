<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('guest_session_id', 100)->nullable()->index();
            $table->boolean('is_shared')->default(false);

            $table->foreignId('modul_ajar_id')->nullable()->constrained('modul_ajars')->nullOnDelete();
            $table->foreignId('tujuan_pembelajaran_id')->nullable()->constrained('tujuan_pembelajarans')->nullOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('fase_id')->constrained('fases')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajarans')->nullOnDelete();

            $table->string('judul', 255);
            $table->string('jenis_ujian', 50)->default('sumatif_lingkup_materi'); // sumatif_lingkup_materi, sts, sas, diagnostik, kuis_harian
            $table->string('bentuk_soal', 30)->default('campuran'); // pg, isian, campuran
            $table->unsignedInteger('total_soal_pg')->default(0);
            $table->unsignedInteger('total_soal_isian')->default(0);
            $table->unsignedInteger('alokasi_waktu_menit')->default(60);

            $table->text('petunjuk_umum')->nullable();
            $table->longText('kisi_kisi_data')->nullable(); // JSON array of test blueprint
            $table->longText('butir_soal_pg')->nullable();   // JSON array of PG questions
            $table->longText('butir_soal_isian')->nullable(); // JSON array of Essay/Isian questions

            $table->unsignedInteger('bobot_pg_persen')->default(70);
            $table->unsignedInteger('bobot_isian_persen')->default(30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_soals');
    }
};
