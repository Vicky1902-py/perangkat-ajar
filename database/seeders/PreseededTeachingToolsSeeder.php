<?php

namespace Database\Seeders;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Services\GeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PreseededTeachingToolsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'superadmin')->first() ?? User::first();
        if (!$user) {
            return;
        }

        $tahunAjaran = TahunAjaran::where('is_active', true)->first();
        $generatorService = new GeneratorService();

        // Daftar Mata Pelajaran Prioritas untuk Pre-Seed Perangkat Ajar Lengkap
        $prioritySubjects = [
            ['mapel' => 'Koding dan Kecerdasan Artifisial (AI)', 'fase' => 'E'],
            ['mapel' => 'Koding dan Kecerdasan Artifisial (AI)', 'fase' => 'F'],
            ['mapel' => 'Dasar-dasar Teknik Ketenagalistrikan', 'fase' => 'E'],
            ['mapel' => 'Teknik Instalasi Tenaga Listrik', 'fase' => 'F'],
            ['mapel' => 'Dasar-dasar Teknik Mesin', 'fase' => 'E'],
            ['mapel' => 'Teknik Pengelasan (Welding)', 'fase' => 'F'],
            ['mapel' => 'Dasar-dasar Desain Pemodelan dan Informasi Bangunan', 'fase' => 'E'],
            ['mapel' => 'Desain Pemodelan dan Informasi Bangunan (BIM)', 'fase' => 'F'],
            ['mapel' => 'Dasar-dasar Pengembangan Perangkat Lunak dan Gim', 'fase' => 'E'],
            ['mapel' => 'Rekayasa Perangkat Lunak', 'fase' => 'F'],
            ['mapel' => 'Teknik Komputer dan Jaringan', 'fase' => 'F'],
            ['mapel' => 'Teknik Kendaraan Ringan Otomotif', 'fase' => 'F'],
            ['mapel' => 'Akuntansi Keuangan dan Lembaga', 'fase' => 'F'],
            ['mapel' => 'Kuliner (Tata Boga)', 'fase' => 'F'],
            ['mapel' => 'Desain Komunikasi Visual', 'fase' => 'F'],
            ['mapel' => 'Projek Kreatif dan Kewirausahaan (PKK)', 'fase' => 'F'],
            ['mapel' => 'Praktik Kerja Lapangan (PKL)', 'fase' => 'F'],
            ['mapel' => 'Informatika', 'fase' => 'E'],
            ['mapel' => 'Projek Ilmu Pengetahuan Alam dan Sosial (IPAS)', 'fase' => 'E'],
            ['mapel' => 'Bahasa Indonesia', 'fase' => 'E'],
            ['mapel' => 'Matematika', 'fase' => 'E'],
        ];

        foreach ($prioritySubjects as $target) {
            $faseObj = Fase::where('kode', $target['fase'])->first();
            $mapelObj = MataPelajaran::where('nama', $target['mapel'])->first();

            if ($faseObj && $mapelObj) {
                $cp = CapaianPembelajaran::where('mata_pelajaran_id', $mapelObj->id)
                    ->where('fase_id', $faseObj->id)
                    ->first();

                if ($cp) {
                    try {
                        $generatorService->generateAll([
                            'capaian_pembelajaran_id' => $cp->id,
                            'tahun_ajaran_id' => $tahunAjaran ? $tahunAjaran->id : null,
                        ], $user);
                    } catch (\Exception $e) {
                        Log::warning("Gagal pre-seed untuk {$target['mapel']} Fase {$target['fase']}: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
