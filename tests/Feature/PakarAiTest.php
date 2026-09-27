<?php

namespace Tests\Feature;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PakarAiTest extends TestCase
{
    public function test_pakar_ai_index_accessible_by_superadmin(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        if (!$superadmin) {
            $superadmin = User::factory()->create([
                'role' => 'superadmin',
                'is_profile_completed' => true,
            ]);
        }

        $response = $this->actingAs($superadmin)->get(route('pakar-ai.index'));
        $response->assertStatus(200);
        $response->assertSee('Konsultasi Sistem Pakar Kurikulum AI');
        $response->assertSee('NVIDIA NIM');
    }

    public function test_pakar_ai_consult_returns_grounded_json(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        if (!$superadmin) {
            $superadmin = User::factory()->create([
                'role' => 'superadmin',
                'is_profile_completed' => true,
            ]);
        }

        $mapel = MataPelajaran::first();
        $fase = Fase::first();

        if ($mapel && $fase) {
            $response = $this->actingAs($superadmin)->postJson(route('pakar-ai.consult'), [
                'mata_pelajaran_id' => $mapel->id,
                'fase_id' => $fase->id,
                'pertanyaan' => 'Bagaimana menyusun aktivitas deep learning untuk materi ini?',
                'tipe_konsultasi' => 'Perancangan Aktivitas Deep Learning',
            ]);

            $response->assertStatus(200);
            $response->assertJsonStructure([
                'success',
                'mapel',
                'fase',
                'answer',
                'model',
            ]);
            $this->assertTrue($response->json('success'));
            $this->assertNotEmpty($response->json('answer'));
            // Pastikan tidak ada "peserta didik" dalam output
            $this->assertStringNotContainsStringIgnoringCase('peserta didik', $response->json('answer'));
        }
    }

    public function test_superadmin_can_test_nvidia_connection(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        if (!$superadmin) {
            $superadmin = User::factory()->create([
                'role' => 'superadmin',
                'is_profile_completed' => true,
            ]);
        }

        $response = $this->actingAs($superadmin)->postJson(route('cms.settings.test-nvidia'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message']);
    }
}
