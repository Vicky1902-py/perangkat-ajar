<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lkpd_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lkpd_id')->constrained('lkpds')->cascadeOnDelete();
            $table->enum('tahap', ['memahami', 'mengaplikasi', 'merefleksi']);
            $table->text('instruksi');
            $table->text('pertanyaan')->nullable();
            $table->text('ruang_jawaban')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lkpd_kegiatans');
    }
};
