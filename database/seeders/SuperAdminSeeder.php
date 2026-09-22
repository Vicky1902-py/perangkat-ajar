<?php

namespace Database\Seeders;

use App\Models\SatuanPendidikan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Sekolah Contoh Resmi
        $sekolah = SatuanPendidikan::updateOrCreate(
            ['npsn' => '20100001'],
            [
                'nama' => 'SMK Negeri 1 Jakarta',
                'jenjang' => 'SMK',
                'alamat' => 'Jl. Budi Utomo No. 7, Pasar Baru, Sawah Besar',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'telepon' => '(021) 3841234',
                'email' => 'info@smkn1jakarta.sch.id',
                'website' => 'www.smkn1jakarta.sch.id',
                'dinas_pendidikan' => 'DINAS PENDIDIKAN',
                'kepala_sekolah' => 'Drs. H. Suryadi, M.Pd.',
                'nip_kepala_sekolah' => '196805121994031005',
                'kop_baris_1' => 'PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA',
                'kop_baris_2' => 'DINAS PENDIDIKAN',
                'kop_baris_3' => 'SEKOLAH MENENGAH KEJURUAN NEGERI 1 JAKARTA',
                'kop_baris_4' => 'Jl. Budi Utomo No. 7, Sawah Besar, Jakarta Pusat | Telp: (021) 3841234 | NPSN: 20100001 | Email: info@smkn1jakarta.sch.id',
                'ukuran_kertas_default' => 'A4',
                'is_active' => true,
            ]
        );

        // 2. Superadmin (Akses Penuh Seluruh Sistem & Kontrol CMS)
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'nip' => '198501012010011001',
                'telepon' => '081234567890',
                'mata_pelajaran_diampu' => 'Pengembangan Perangkat Lunak dan Gim',
                'satuan_pendidikan_id' => $sekolah->id,
                'is_profile_completed' => true,
                'is_active' => true,
            ]
        );

        // 3. Admin Sekolah
        User::updateOrCreate(
            ['email' => 'adminsekolah@smk1.sch.id'],
            [
                'name' => 'Admin SMK Negeri 1',
                'password' => Hash::make('password'),
                'role' => 'admin_sekolah',
                'nip' => '198802022012021002',
                'telepon' => '081234567891',
                'mata_pelajaran_diampu' => 'Manajemen Perkantoran',
                'satuan_pendidikan_id' => $sekolah->id,
                'is_profile_completed' => true,
                'is_active' => true,
            ]
        );

        // 4. Guru Kejuruan PPLG
        User::updateOrCreate(
            ['email' => 'guru@smk1.sch.id'],
            [
                'name' => 'Budi Santoso, S.Kom., M.T.',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip' => '199203032018031003',
                'telepon' => '081234567892',
                'mata_pelajaran_diampu' => 'Koding dan Kecerdasan Artifisial (AI)',
                'satuan_pendidikan_id' => $sekolah->id,
                'is_profile_completed' => true,
                'is_active' => true,
            ]
        );
    }
}
