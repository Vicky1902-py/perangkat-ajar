<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FaseSeeder::class,
            ProfilLulusanSeeder::class,
            AllSpektrumSmkSeeder::class,
            AllMataPelajaranSmkSeeder::class,
            AllCapaianPembelajaranSmkSeeder::class,
            TemplatePedattiSeeder::class,
            TahunAjaranSeeder::class,
            SuperAdminSeeder::class,
            PreseededTeachingToolsSeeder::class,
            KurikulumMateriSeeder::class,
        ]);
    }
}
