<?php

namespace App\Services;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class CurriculumRegulationService
{
    /**
     * Dapatkan daftar seluruh regulasi yang terdaftar di database beserta statistik jumlah CP.
     */
    public function getRegulationsSummary(): array
    {
        $regulations = CapaianPembelajaran::select('regulasi', DB::raw('count(*) as total_cp'), DB::raw('count(distinct mata_pelajaran_id) as total_mapel'))
            ->groupBy('regulasi')
            ->orderByDesc('total_cp')
            ->get();

        $activeRegulation = CapaianPembelajaran::where('is_active', true)->value('regulasi') 
            ?? 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025';

        return [
            'active_regulation' => $activeRegulation,
            'list' => $regulations,
        ];
    }

    /**
     * Mengimpor atau memperbarui Capaian Pembelajaran dari paket JSON/Array regulasi baru.
     * Menggunakan pola Safe-Upsert (data perangkat ajar lama tetap aman).
     */
    public function importPackage(array $packageData, string $regulationName): array
    {
        $inserted = 0;
        $updated = 0;

        DB::transaction(function () use ($packageData, $regulationName, &$inserted, &$updated) {
            foreach ($packageData as $item) {
                // Cari Mata Pelajaran berdasarkan ID atau Nama
                $mapel = null;
                if (!empty($item['mapel_id'])) {
                    $mapel = MataPelajaran::find($item['mapel_id']);
                }
                if (!$mapel && !empty($item['mapel_nama'])) {
                    $mapel = MataPelajaran::where('nama', $item['mapel_nama'])->first();
                }
                if (!$mapel && !empty($item['mapel'])) {
                    $mapel = MataPelajaran::where('nama', $item['mapel'])->first();
                }
                if (!$mapel && !empty($item['nama'])) {
                    $mapel = MataPelajaran::where('nama', $item['nama'])->first();
                }

                if (!$mapel) {
                    continue;
                }

                // Cari Fase (E = Kelas X, F = Kelas XI & XII)
                $faseKode = strtoupper($item['fase'] ?? 'E');
                $fase = Fase::where('kode', $faseKode)->first();
                if (!$fase) {
                    continue;
                }

                $deskripsiCp = $item['deskripsi_cp'] ?? $item['deskripsi'] ?? ('Capaian Pembelajaran sesuai ' . $regulationName);
                $rawElemen = $item['elemen_cp'] ?? null;
                $formattedElemen = [];
                if (is_array($rawElemen)) {
                    foreach ($rawElemen as $k => $v) {
                        if (is_array($v)) {
                            $elName = $v['elemen'] ?? $v['nama'] ?? $v['title'] ?? ("Elemen " . ($k + 1));
                            $elDesc = $v['deskripsi'] ?? $v['desc'] ?? '';
                            $formattedElemen[$elName] = is_string($elDesc) ? $elDesc : json_encode($elDesc);
                        } else {
                            $formattedElemen[$k] = (string)$v;
                        }
                    }
                    $elemenCp = json_encode($formattedElemen);
                } else {
                    $elemenCp = $rawElemen;
                }

                $cp = CapaianPembelajaran::where([
                    'mata_pelajaran_id' => $mapel->id,
                    'fase_id' => $fase->id,
                    'regulasi' => $regulationName,
                ])->first();

                if ($cp) {
                    $cp->update([
                        'deskripsi_cp' => $deskripsiCp,
                        'elemen_cp' => $elemenCp,
                        'is_active' => true,
                    ]);
                    $updated++;
                } else {
                    CapaianPembelajaran::create([
                        'mata_pelajaran_id' => $mapel->id,
                        'fase_id' => $fase->id,
                        'regulasi' => $regulationName,
                        'deskripsi_cp' => $deskripsiCp,
                        'elemen_cp' => $elemenCp,
                        'is_active' => true,
                    ]);
                    $inserted++;
                }
            }
        });

        return [
            'status' => 'success',
            'regulation' => $regulationName,
            'inserted' => $inserted,
            'updated' => $updated,
            'total' => $inserted + $updated,
        ];
    }

    /**
     * Setel regulasi aktif di sistem.
     */
    public function setActiveRegulation(string $regulationName): int
    {
        // Nonaktifkan semua CP yang tidak termasuk regulasi terpilih
        CapaianPembelajaran::where('regulasi', '!=', $regulationName)->update(['is_active' => false]);
        
        // Aktifkan seluruh CP regulasi terpilih
        return CapaianPembelajaran::where('regulasi', $regulationName)->update(['is_active' => true]);
    }
}
