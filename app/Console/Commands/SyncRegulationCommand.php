<?php

namespace App\Console\Commands;

use App\Services\CurriculumRegulationService;
use Illuminate\Console\Command;

class SyncRegulationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curriculum:sync {--regulation= : Nama regulasi baru} {--file= : Path file JSON regulasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi dan perbarui standar regulasi kurikulum baru (CP & Elemen)';

    /**
     * Execute the console command.
     */
    public function handle(CurriculumRegulationService $service)
    {
        $this->info("Menjalankan sinkronisasi regulasi kurikulum...");

        $file = $this->option('file');
        $regulation = $this->option('regulation') ?? 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025';

        if ($file && file_exists($file)) {
            $json = json_decode(file_get_contents($file), true);
            if (!is_array($json)) {
                $this->error("Format file JSON tidak valid.");
                return 1;
            }

            $res = $service->importPackage($json, $regulation);
            $this->info("Berhasil mengimpor: {$res['inserted']} data baru, {$res['updated']} diperbarui.");
        } else {
            // Aktifkan regulasi default
            $count = $service->setActiveRegulation($regulation);
            $this->info("Regulasi '{$regulation}' aktif untuk {$count} Capaian Pembelajaran.");
        }

        return 0;
    }
}
