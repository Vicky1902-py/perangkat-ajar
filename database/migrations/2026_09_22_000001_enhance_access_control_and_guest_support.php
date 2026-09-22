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
        // 1. TAMBAH GUEST SESSION ID, NULLABLE USER_ID, DAN IS_SHARED KE TABEL PERANGKAT AJAR
        $teachingTables = [
            'tujuan_pembelajarans',
            'alur_tujuan_pembelajarans',
            'modul_ajars',
            'lkpds',
            'program_semesters',
            'program_tahunans',
            'asesmens',
        ];

        foreach ($teachingTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->change();
                $table->string('guest_session_id', 100)->nullable()->after('user_id')->index();
                $table->boolean('is_shared')->default(false)->after('guest_session_id');
            });
        }

        // 2. TABEL PELACAK KUOTA PENGGUNA TAMU (GUEST USAGE)
        Schema::create('guest_usages', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->string('session_id', 100)->nullable()->index();
            $table->unsignedInteger('device_count')->default(0);
            $table->timestamp('last_generated_at')->nullable();
            $table->timestamps();
        });

        // 3. TAMBAH KOLOM JURUSAN DAN IZIN AKSES PADA TABEL USERS
        Schema::table('users', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->after('mata_pelajaran_diampu');
            $table->boolean('can_view_all_devices')->default(false)->after('is_active');
        });

        // 4. TABEL IZIN AKSES PERANGKAT GURU (SHARING PRIVILEGES DARI SUPERADMIN)
        Schema::create('user_device_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('granted_user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'granted_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_device_accesses');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'can_view_all_devices']);
        });

        Schema::dropIfExists('guest_usages');

        $teachingTables = [
            'tujuan_pembelajarans',
            'alur_tujuan_pembelajarans',
            'modul_ajars',
            'lkpds',
            'program_semesters',
            'program_tahunans',
            'asesmens',
        ];

        foreach ($teachingTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['guest_session_id', 'is_shared']);
            });
        }
    }
};
