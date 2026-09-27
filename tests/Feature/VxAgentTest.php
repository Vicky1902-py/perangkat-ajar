<?php

namespace Tests\Feature;

use App\Models\Fase;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\User;
use Tests\TestCase;

class VxAgentTest extends TestCase
{
    public function test_vx_agent_complete_field_returns_valid_json(): void
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

        $response = $this->actingAs($superadmin)->postJson(route('vx-agent.complete-field'), [
            'field_type' => 'bahan_ajar',
            'instruksi' => 'Tambahkan materi tentang keamanan siber untuk murid',
            'mata_pelajaran_id' => $mapel?->id,
            'fase_id' => $fase?->id,
            'current_text' => 'Dasar sistem komputer.',
            'action_mode' => 'append',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'field_type',
            'generated_text',
            'combined_text',
            'action_mode',
            'model',
        ]);
        $this->assertTrue($response->json('success'));
        $this->assertNotEmpty($response->json('generated_text'));
        $this->assertStringNotContainsStringIgnoringCase('peserta didik', $response->json('generated_text'));
    }

    public function test_modul_ajar_edit_page_renders_successfully(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $modul = ModulAjar::first();

        if ($superadmin && $modul) {
            $response = $this->actingAs($superadmin)->get(route('modul-ajar.edit', $modul->id));
            $response->assertStatus(200);
            $response->assertSee('Edit Modul Ajar Deep Learning');
            $response->assertSee('Vx Agent Ready');
        }
    }

    public function test_lkpd_edit_page_renders_successfully(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $lkpd = Lkpd::first();

        if ($superadmin && $lkpd) {
            $response = $this->actingAs($superadmin)->get(route('lkpd.edit', $lkpd->id));
            $response->assertStatus(200);
            $response->assertSee('Edit Lembar Kerja Murid (LKPD) Deep Learning');
            $response->assertSee('Vx Agent Ready');
        }
    }

    public function test_vx_agent_chat_returns_valid_response(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        if (!$superadmin) {
            $superadmin = User::factory()->create([
                'role' => 'superadmin',
                'is_profile_completed' => true,
            ]);
        }

        $response = $this->actingAs($superadmin)->postJson(route('vx-agent.chat'), [
            'message' => 'Bagaimana mengaitkan materi ini dengan konteks industri nyata untuk murid?',
            'document_type' => 'modul_ajar',
            'document_title' => 'Instalasi Motor Listrik',
            'mata_pelajaran' => 'Teknik Instalasi Tenaga Listrik',
            'fase' => 'F',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'reply',
            'doc_type',
            'doc_title',
            'mapel',
            'fase',
            'model',
        ]);
        $this->assertTrue($response->json('success'));
        $this->assertNotEmpty($response->json('reply'));
        $this->assertStringNotContainsStringIgnoringCase('peserta didik', $response->json('reply'));
    }

    public function test_modul_ajar_show_page_contains_vx_agent_actions(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $modul = ModulAjar::first();

        if ($superadmin && $modul) {
            $response = $this->actingAs($superadmin)->get(route('modul-ajar.show', $modul->id));
            $response->assertStatus(200);
            $response->assertSee('Konsultasi Vx Agent');
            $response->assertSee('Edit / Lengkapi via Vx Agent');
            $response->assertSee('modalVxAgentChat');
        }
    }

    public function test_lkpd_show_page_contains_vx_agent_actions(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $lkpd = Lkpd::first();

        if ($superadmin && $lkpd) {
            $response = $this->actingAs($superadmin)->get(route('lkpd.show', $lkpd->id));
            $response->assertStatus(200);
            $response->assertSee('Konsultasi Vx Agent');
            $response->assertSee('Edit / Lengkapi via Vx Agent');
            $response->assertSee('modalVxAgentChat');
        }
    }
}

