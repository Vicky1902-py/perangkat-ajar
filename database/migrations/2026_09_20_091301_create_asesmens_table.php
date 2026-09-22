<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asesmens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('modul_ajar_id')->nullable()->constrained('modul_ajars')->nullOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('fase_id')->constrained('fases')->cascadeOnDelete();
            $table->foreignId('tujuan_pembelajaran_id')->nullable()->constrained('tujuan_pembelajarans')->nullOnDelete();
            $table->string('judul');
            $table->enum('jenis', ['diagnostik', 'formatif', 'sumatif'])->default('formatif');
            $table->text('deskripsi')->nullable();
            $table->text('instrumen')->nullable();
            $table->text('rubrik')->nullable();
            $table->text('pedoman_penskoran')->nullable();
            $table->json('kktp_data')->nullable();
            $table->json('tindak_lanjut_data')->nullable();
            $table->json('vokasi_dudi_data')->nullable();
            $table->json('deskripsi_rapor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmens');
    }
};
