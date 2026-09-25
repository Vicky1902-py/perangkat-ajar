<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kurikulum_materis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')->nullable()->constrained('mata_pelajarans')->nullOnDelete();
            $table->foreignId('fase_id')->nullable()->constrained('fases')->nullOnDelete();
            $table->string('nama_mapel')->index();
            $table->string('nama_elemen')->index();
            $table->string('topik_utama');
            $table->json('sub_materi')->nullable();
            $table->longText('rangkuman_materi');
            $table->text('pemahaman_bermakna')->nullable();
            $table->text('pertanyaan_pemantik')->nullable();
            $table->json('kegiatan_pedatti')->nullable();
            $table->json('kata_kunci')->nullable();
            $table->json('bank_soal_pg')->nullable();
            $table->json('bank_soal_essay')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum_materis');
    }
};
