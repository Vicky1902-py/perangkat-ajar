<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CapaianPembelajaran;
use App\Models\KurikulumMateri;
use App\Services\CurriculumKnowledgeBase;

class PopulateCurriculumMaterials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curriculum:populate-materials {--fresh : Paksa perbarui semua data materi bahkan jika sudah ada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate dan riset mendalam materi kurikulum untuk seluruh mata pelajaran dan elemen CP ke dalam database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("=== MEMULAI RISET & POPULASI MATERI KURIKULUM KE DATABASE ===");
        $this->info("Menghubungkan Capaian Pembelajaran (BSKAP 046/2025) ke Bank Materi...");

        $isFresh = $this->option('fresh');
        $cps = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->get();
        $totalCp = $cps->count();

        $this->info("Ditemukan {$totalCp} data Capaian Pembelajaran lintas Fase dan Mata Pelajaran.");

        $processed = 0;
        $created = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar();
        $bar->start();

        foreach ($cps as $cp) {
            $mapel = $cp->mataPelajaran;
            $fase = $cp->fase;

            if (!$mapel) {
                continue;
            }

            $elemenCp = json_decode($cp->elemen_cp, true) ?? [];
            if (empty($elemenCp)) {
                $elemenCp = [
                    'Kompetensi Inti ' . $mapel->nama => $cp->deskripsi_cp
                ];
            }

            foreach ($elemenCp as $namaElemen => $deskripsiElemen) {
                $processed++;

                if (!$isFresh) {
                    $existing = KurikulumMateri::where('nama_elemen', $namaElemen)
                        ->where(function ($q) use ($mapel) {
                            $q->where('mata_pelajaran_id', $mapel->id)
                              ->orWhere('nama_mapel', $mapel->nama);
                        })
                        ->first();

                    if ($existing && !empty($existing->rangkuman_materi)) {
                        $skipped++;
                        $bar->advance();
                        continue;
                    }
                }

                // Sintesis materi kurikulum mendalam dan simpan ke database
                CurriculumKnowledgeBase::getMaterial($mapel, $namaElemen, $deskripsiElemen, $fase);
                $created++;
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $totalInDb = KurikulumMateri::count();
        $this->table(
            ['Metrik', 'Jumlah'],
            [
                ['Total Elemen Diproses', $processed],
                ['Materi Baru Disimpan / Diperbarui', $created],
                ['Materi Sudah Ada (Dilewati)', $skipped],
                ['Total Bank Materi di Database Saat Ini', $totalInDb],
            ]
        );

        $this->info("SUKSES: Seluruh mata pelajaran dan elemen CP kini memiliki bank materi resmi di database!");
        return Command::SUCCESS;
    }
}
