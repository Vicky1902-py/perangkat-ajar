<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_pedattis', function (Blueprint $table) {
            $table->id();
            $table->enum('tahap', ['pendahuluan', 'dalami', 'terapkan', 'tularkan', 'inovasi']);
            $table->text('template_kegiatan');
            $table->string('prinsip_deep_learning')->nullable();
            $table->string('olah')->nullable();
            $table->integer('durasi_default_menit')->nullable();
            $table->text('contoh_pertanyaan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_pedattis');
    }
};
