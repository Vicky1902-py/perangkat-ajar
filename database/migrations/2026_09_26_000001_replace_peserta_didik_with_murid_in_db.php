<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Capaian Pembelajaran
        if (Schema::hasTable('capaian_pembelajarans')) {
            DB::statement("UPDATE capaian_pembelajarans SET 
                deskripsi_cp = REPLACE(REPLACE(REPLACE(deskripsi_cp, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE deskripsi_cp LIKE '%peserta didik%' OR deskripsi_cp LIKE '%Peserta Didik%'");
        }

        // 2. Kurikulum Materi
        if (Schema::hasTable('kurikulum_materis')) {
            DB::statement("UPDATE kurikulum_materis SET 
                topik_utama = REPLACE(REPLACE(REPLACE(topik_utama, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                rangkuman_materi = REPLACE(REPLACE(REPLACE(rangkuman_materi, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                pemahaman_bermakna = REPLACE(REPLACE(REPLACE(pemahaman_bermakna, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                pertanyaan_pemantik = REPLACE(REPLACE(REPLACE(pertanyaan_pemantik, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE rangkuman_materi LIKE '%peserta didik%' OR rangkuman_materi LIKE '%Peserta Didik%'");
        }

        // 3. Template Pedatti
        if (Schema::hasTable('template_pedattis')) {
            DB::statement("UPDATE template_pedattis SET 
                template_kegiatan = REPLACE(REPLACE(REPLACE(template_kegiatan, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE template_kegiatan LIKE '%peserta didik%' OR template_kegiatan LIKE '%Peserta Didik%'");
        }

        // 4. Tujuan Pembelajaran
        if (Schema::hasTable('tujuan_pembelajarans')) {
            DB::statement("UPDATE tujuan_pembelajarans SET 
                deskripsi_tp = REPLACE(REPLACE(REPLACE(deskripsi_tp, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                indikator_ketercapaian = REPLACE(REPLACE(REPLACE(indikator_ketercapaian, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE deskripsi_tp LIKE '%peserta didik%' OR indikator_ketercapaian LIKE '%peserta didik%'
                   OR deskripsi_tp LIKE '%Peserta Didik%' OR indikator_ketercapaian LIKE '%Peserta Didik%'");
        }

        // 5. Modul Ajar
        if (Schema::hasTable('modul_ajars')) {
            DB::statement("UPDATE modul_ajars SET 
                target_peserta_didik = REPLACE(REPLACE(REPLACE(target_peserta_didik, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                kompetensi_awal = REPLACE(REPLACE(REPLACE(kompetensi_awal, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                refleksi_guru = REPLACE(REPLACE(REPLACE(refleksi_guru, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE target_peserta_didik LIKE '%peserta didik%' OR target_peserta_didik LIKE '%Peserta Didik%'
                   OR kompetensi_awal LIKE '%peserta didik%' OR kompetensi_awal LIKE '%Peserta Didik%'");
        }

        // 6. LKPD & Kegiatan
        if (Schema::hasTable('lkpds')) {
            DB::statement("UPDATE lkpds SET 
                petunjuk_belajar = REPLACE(REPLACE(REPLACE(petunjuk_belajar, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                tujuan_pembelajaran = REPLACE(REPLACE(REPLACE(tujuan_pembelajaran, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE petunjuk_belajar LIKE '%peserta didik%' OR petunjuk_belajar LIKE '%Peserta Didik%'");
        }

        if (Schema::hasTable('lkpd_kegiatans')) {
            DB::statement("UPDATE lkpd_kegiatans SET 
                instruksi = REPLACE(REPLACE(REPLACE(instruksi, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                pertanyaan = REPLACE(REPLACE(REPLACE(pertanyaan, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE instruksi LIKE '%peserta didik%' OR instruksi LIKE '%Peserta Didik%'");
        }

        // 7. ATP Details
        if (Schema::hasTable('atp_details')) {
            DB::statement("UPDATE atp_details SET 
                kegiatan_pembelajaran = REPLACE(REPLACE(REPLACE(kegiatan_pembelajaran, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID'),
                indikator_asesmen = REPLACE(REPLACE(REPLACE(indikator_asesmen, 'Peserta Didik', 'Murid'), 'peserta didik', 'murid'), 'PESERTA DIDIK', 'MURID')
                WHERE kegiatan_pembelajaran LIKE '%peserta didik%' OR kegiatan_pembelajaran LIKE '%Peserta Didik%'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tetap menggunakan istilah resmi 'murid'
    }
};
