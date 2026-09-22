<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satuan_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('npsn', 20)->nullable();
            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK'])->default('SMK');
            $table->text('alamat')->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah', 35)->nullable();
            $table->string('logo')->nullable();
            $table->string('dinas_pendidikan')->nullable();
            $table->string('kop_baris_1')->nullable();
            $table->string('kop_baris_2')->nullable();
            $table->string('kop_baris_3')->nullable();
            $table->string('kop_baris_4')->nullable();
            $table->enum('ukuran_kertas_default', ['A4', 'F4'])->default('A4');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satuan_pendidikans');
    }
};
