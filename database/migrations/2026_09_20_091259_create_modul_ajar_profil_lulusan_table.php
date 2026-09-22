<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul_ajar_profil_lulusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_ajar_id')->constrained('modul_ajars')->cascadeOnDelete();
            $table->foreignId('profil_lulusan_id')->constrained('profil_lulusans')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['modul_ajar_id', 'profil_lulusan_id'], 'ma_pl_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul_ajar_profil_lulusan');
    }
};
