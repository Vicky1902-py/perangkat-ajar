<?php

namespace Tests\Feature;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\Setting;
use App\Models\User;
use App\Services\DatabaseBackupService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SettingAndBackupTest extends TestCase
{
    protected User $superadmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
                'is_active' => true,
                'is_profile_completed' => true,
            ]
        );
    }

    protected function tearDown(): void
    {
        CapaianPembelajaran::where('regulasi', 'Standar Regulasi Baru 2026 Test')->delete();
        MataPelajaran::where('nama', 'Mata Pelajaran Uji Coba Regulasi')->delete();
        CapaianPembelajaran::where('regulasi', 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025')->update(['is_active' => true]);

        parent::tearDown();
    }

    public function test_guest_cannot_access_settings_page(): void
    {
        $response = $this->get('/cms/settings');
        $response->assertRedirect('/login');
    }

    public function test_superadmin_can_access_settings_page(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/cms/settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Aplikasi & CMS', false);
        $response->assertSee('Identitas & Logo', false);
        $response->assertSee('Tema & Warna', false);
        $response->assertSee('Full CMS Landing Page', false);
        $response->assertSee('Backup Database', false);
        $response->assertSee('Regulasi Kurikulum', false);
    }

    public function test_superadmin_can_update_settings_and_landing(): void
    {
        $payload = [
            'active_tab' => 'branding',
            'app_name' => 'Perangkat Ajar Pintar 2026',
            'app_tagline' => 'Solusi Cepat Kurikulum Merdeka Terintegrasi AI',
            'landing_creator_name' => 'Vicky Koroh',
            'landing_copyright_year' => '2026',
            'landing_hero_badge' => 'Teknologi AI Pendidikan 2026',
            'landing_hero_title' => 'Revolusi Perangkat Ajar Deep Learning',
            'landing_hero_subtitle' => 'Buat RPP, Modul Ajar, Prota, Promes secara otomatis.',
            'landing_hero_cta_primary' => 'Coba Gratis Sekarang',
        ];

        $response = $this->actingAs($this->superadmin)->post('/cms/settings', $payload);
        $response->assertRedirect('/cms/settings?tab=branding');
        $response->assertSessionHas('success');

        $this->assertEquals('Perangkat Ajar Pintar 2026', Setting::get('app_name'));
        $this->assertEquals('Revolusi Perangkat Ajar Deep Learning', Setting::get('landing_hero_title'));
        $this->assertEquals('Vicky Koroh', Setting::get('landing_creator_name'));
        $this->assertEquals('2026', Setting::get('landing_copyright_year'));
    }

    public function test_superadmin_can_change_and_reset_theme(): void
    {
        // Ubah tema ke emerald
        $themePayload = [
            'active_tab' => 'theme',
            'theme_preset' => 'emerald_aurora',
            'theme_primary_color' => '#059669',
            'theme_accent_cyan' => '#14b8a6',
            'theme_accent_indigo' => '#10b981',
        ];

        $response = $this->actingAs($this->superadmin)->post('/cms/settings', $themePayload);
        $response->assertRedirect('/cms/settings?tab=theme');
        $this->assertEquals('#059669', Setting::get('theme_primary_color'));

        // Reset tema kembali ke Cosmic Sapphire bawaan 2026
        $resetResponse = $this->actingAs($this->superadmin)->post('/cms/settings/reset-theme');
        $resetResponse->assertRedirect('/cms/settings?tab=theme');
        $resetResponse->assertSessionHas('success');

        $this->assertEquals('cosmic_sapphire', Setting::get('theme_preset'));
        $this->assertEquals('#2563eb', Setting::get('theme_primary_color'));
    }

    public function test_database_backup_lifecycle(): void
    {
        $backupService = app(DatabaseBackupService::class);

        // 1. Buat backup via route
        $createResponse = $this->actingAs($this->superadmin)->post('/cms/settings/backup');
        $createResponse->assertRedirect('/cms/settings?tab=backup');
        $createResponse->assertSessionHas('success');

        $backups = $backupService->listBackups();
        $this->assertNotEmpty($backups, 'Backup list should not be empty after creation.');

        $latestFilename = $backups[0]['filename'];
        $this->assertStringEndsWith('.sql', $latestFilename);

        // 2. Unduh backup via route
        $downloadResponse = $this->actingAs($this->superadmin)->get("/cms/settings/backup/download/{$latestFilename}");
        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('Content-Type', 'application/sql');

        // 3. Hapus backup via route
        $deleteResponse = $this->actingAs($this->superadmin)->delete("/cms/settings/backup/{$latestFilename}");
        $deleteResponse->assertRedirect('/cms/settings?tab=backup');
        $deleteResponse->assertSessionHas('success');

        $this->assertFileDoesNotExist(storage_path('app/backups/' . $latestFilename));
    }

    public function test_superadmin_can_sync_regulation_via_json(): void
    {
        $mapel = MataPelajaran::firstOrCreate(
            ['nama' => 'Mata Pelajaran Uji Coba Regulasi']
        );

        $fase = Fase::firstOrCreate(
            ['kode' => 'E'],
            ['nama' => 'Fase E (Kelas X)']
        );

        $jsonContent = json_encode([
            [
                'mapel_nama' => 'Mata Pelajaran Uji Coba Regulasi',
                'fase' => 'E',
                'deskripsi_cp' => 'Murid mampu memahami dasar-dasar regulasi kurikulum baru 2026.',
                'elemen_cp' => [
                    ['elemen' => 'Pemahaman Konseptual', 'deskripsi' => 'Konsep dasar regulasi.']
                ]
            ]
        ]);

        $uploadedFile = UploadedFile::fake()->createWithContent('regulasi_2026.json', $jsonContent);

        $response = $this->actingAs($this->superadmin)->post('/cms/settings/sync-regulation', [
            'regulation_name' => 'Standar Regulasi Baru 2026 Test',
            'regulation_package_file' => $uploadedFile,
        ]);

        $response->assertRedirect('/cms/settings?tab=regulation');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('capaian_pembelajarans', [
            'mata_pelajaran_id' => $mapel->id,
            'fase_id' => $fase->id,
            'regulasi' => 'Standar Regulasi Baru 2026 Test',
        ]);

        // Bersihkan data uji coba regulasi agar tidak mempengaruhi state CMS lainnya
        CapaianPembelajaran::where('regulasi', 'Standar Regulasi Baru 2026 Test')->delete();
        $mapel->delete();

        // Kembalikan regulasi default ke BSKAP 046
        CapaianPembelajaran::where('regulasi', 'Keputusan Kepala BSKAP Nomor 046/H/KR/2025')->update(['is_active' => true]);
    }
}
