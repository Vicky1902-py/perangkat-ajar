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
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->default('Tamu / Guest');
            $table->string('role')->default('guest')->index(); // guest, guru, admin_sekolah, superadmin
            $table->string('device_type', 30)->default('Desktop')->index(); // Smartphone, Tablet, Desktop, Bot/Crawler
            $table->string('device_os', 50)->nullable(); // Android, iOS, Windows, macOS, Linux
            $table->string('browser', 50)->nullable(); // Chrome, Safari, Firefox, Edge, etc.
            $table->text('user_agent')->nullable();
            $table->string('method', 10)->default('GET');
            $table->text('url')->nullable();
            $table->string('route_name')->nullable()->index();
            $table->string('action_type', 30)->default('view')->index(); // view, generate, export, auth
            $table->text('activity_description')->nullable();
            $table->json('perangkat_ajar_meta')->nullable(); // detail perangkat ajar yang dibuat (mapel, fase, jenis dokumen)
            $table->timestamp('last_activity_at')->useCurrent()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_logs');
    }
};
