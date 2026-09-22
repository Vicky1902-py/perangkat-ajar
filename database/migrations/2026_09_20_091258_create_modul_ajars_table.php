<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul_ajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tujuan_pembelajaran_id')->nullable()->constrained('tujuan_pembelajarans')->nullOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('fase_id')->constrained('fases')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajarans')->nullOnDelete();
            $table->string('judul');
            $table->text('kompetensi_awal')->nullable();
            $table->text('profil_lulusan_target')->nullable();
            $table->text('sarana_prasarana')->nullable();
            $table->text('target_peserta_didik')->nullable();
            $table->text('pemahaman_bermakna')->nullable();
            $table->text('pertanyaan_pemantik')->nullable();
            $table->text('asesmen_awal')->nullable();
            $table->text('asesmen_formatif')->nullable();
            $table->text('asesmen_sumatif')->nullable();
            $table->text('refleksi_guru')->nullable();
            $table->text('refleksi_siswa')->nullable();
            $table->text('pengayaan')->nullable();
            $table->text('remedial')->nullable();
            $table->text('bahan_ajar')->nullable();
            $table->text('glosarium')->nullable();
            $table->text('daftar_pustaka')->nullable();
            $table->integer('alokasi_waktu_jp')->nullable();
            $table->integer('jumlah_pertemuan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul_ajars');
    }
};
