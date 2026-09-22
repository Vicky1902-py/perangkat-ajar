<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atp_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atp_id')->constrained('alur_tujuan_pembelajarans')->cascadeOnDelete();
            $table->foreignId('tujuan_pembelajaran_id')->constrained('tujuan_pembelajarans')->cascadeOnDelete();
            $table->integer('urutan')->default(0);
            $table->text('materi_topik')->nullable();
            $table->text('kegiatan_pembelajaran')->nullable();
            $table->text('asesmen')->nullable();
            $table->text('indikator_asesmen')->nullable();
            $table->text('sumber_belajar')->nullable();
            $table->integer('alokasi_waktu_jp')->nullable();
            $table->text('dimensi_profil_lulusan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atp_details');
    }
};
