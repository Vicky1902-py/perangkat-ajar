<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin_sekolah', 'guru'])->default('guru')->after('name');
            $table->string('nip', 35)->nullable()->after('role');
            $table->string('telepon', 30)->nullable()->after('nip');
            $table->string('mata_pelajaran_diampu')->nullable()->after('telepon');
            $table->foreignId('satuan_pendidikan_id')->nullable()->after('mata_pelajaran_diampu')
                  ->constrained('satuan_pendidikans')->nullOnDelete();
            $table->boolean('is_profile_completed')->default(false)->after('satuan_pendidikan_id');
            $table->boolean('is_active')->default(true)->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['satuan_pendidikan_id']);
            $table->dropColumn(['role', 'nip', 'telepon', 'mata_pelajaran_diampu', 'satuan_pendidikan_id', 'is_profile_completed', 'is_active']);
        });
    }
};
