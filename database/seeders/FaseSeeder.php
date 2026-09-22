<?php

namespace Database\Seeders;

use App\Models\Fase;
use Illuminate\Database\Seeder;

class FaseSeeder extends Seeder
{
    public function run(): void
    {
        $fases = [
            [
                'kode' => 'E',
                'nama' => 'Fase E (Kelas X SMK)',
                'kelas_range' => 'X',
                'deskripsi' => 'Fase pembelajaran untuk kelas X Sekolah Menengah Kejuruan, fokus pada fondasi umum dan dasar-dasar program keahlian.',
            ],
            [
                'kode' => 'F',
                'nama' => 'Fase F (Kelas XI - XII/XIII SMK)',
                'kelas_range' => 'XI - XII',
                'deskripsi' => 'Fase pembelajaran untuk kelas XI, XII, dan program 4 tahun (XIII) SMK, fokus pada konsentrasi keahlian, PKL, dan kewirausahaan.',
            ],
        ];

        foreach ($fases as $fase) {
            Fase::updateOrCreate(['kode' => $fase['kode']], $fase);
        }
    }
}
