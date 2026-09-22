<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul_ajar_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_ajar_id')->constrained('modul_ajars')->cascadeOnDelete();
            $table->enum('tahap_pedatti', ['pendahuluan', 'dalami', 'terapkan', 'tularkan', 'inovasi']);
            $table->text('deskripsi_kegiatan');
            $table->integer('durasi_menit')->nullable();
            $table->string('prinsip_deep_learning')->nullable()->comment('mindful, meaningful, joyful');
            $table->string('olah')->nullable()->comment('olah_pikir, olah_hati, olah_rasa, olah_raga');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul_ajar_kegiatans');
    }
};
