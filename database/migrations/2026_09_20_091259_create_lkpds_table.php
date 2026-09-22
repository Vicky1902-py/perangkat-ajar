<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lkpds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_ajar_id')->nullable()->constrained('modul_ajars')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('fase_id')->constrained('fases')->cascadeOnDelete();
            $table->string('judul');
            $table->text('tujuan_pembelajaran')->nullable();
            $table->text('stimulus_otentik')->nullable();
            $table->text('petunjuk_belajar')->nullable();
            $table->text('alat_bahan')->nullable();
            $table->text('rubrik_penilaian')->nullable();
            $table->integer('alokasi_waktu_menit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lkpds');
    }
};
