<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tujuan_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capaian_pembelajaran_id')->constrained('capaian_pembelajarans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('kode_tp', 20);
            $table->string('elemen')->nullable();
            $table->text('deskripsi_tp');
            $table->text('konten_pengetahuan')->nullable();
            $table->text('keterampilan')->nullable();
            $table->text('sikap')->nullable();
            $table->text('indikator_ketercapaian')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tujuan_pembelajarans');
    }
};
