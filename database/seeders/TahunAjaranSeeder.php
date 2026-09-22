<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjarans = [
            [
                'nama' => '2025/2026',
                'semester' => 1,
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2025-12-19',
                'is_active' => false,
            ],
            [
                'nama' => '2025/2026',
                'semester' => 2,
                'tanggal_mulai' => '2026-01-05',
                'tanggal_selesai' => '2026-06-19',
                'is_active' => false,
            ],
            [
                'nama' => '2026/2027',
                'semester' => 1,
                'tanggal_mulai' => '2026-07-13',
                'tanggal_selesai' => '2026-12-18',
                'is_active' => true,
            ],
            [
                'nama' => '2026/2027',
                'semester' => 2,
                'tanggal_mulai' => '2027-01-04',
                'tanggal_selesai' => '2027-06-18',
                'is_active' => false,
            ],
            [
                'nama' => '2027/2028',
                'semester' => 1,
                'tanggal_mulai' => '2027-07-12',
                'tanggal_selesai' => '2027-12-17',
                'is_active' => false,
            ],
            [
                'nama' => '2027/2028',
                'semester' => 2,
                'tanggal_mulai' => '2028-01-03',
                'tanggal_selesai' => '2028-06-16',
                'is_active' => false,
            ],
        ];

        // Ensure single active year if we're activating 2026/2027 Semester 1
        TahunAjaran::where('is_active', true)->update(['is_active' => false]);

        foreach ($tahunAjarans as $ta) {
            TahunAjaran::updateOrCreate(
                ['nama' => $ta['nama'], 'semester' => $ta['semester']],
                $ta
            );
        }
    }
}
