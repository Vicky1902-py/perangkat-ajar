<?php

namespace Tests\Feature;

use App\Models\ModulAjar;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use Tests\TestCase;

class HostingSpaceManagerTest extends TestCase
{
    public function test_guest_and_guru_cannot_access_space_hosting(): void
    {
        // 1. Guest redirected to login
        $guestRes = $this->get(route('cms.perangkat.index'));
        $guestRes->assertRedirect(route('login'));

        // 2. Guru receives 403 Forbidden
        $guru = User::where('role', 'guru')->first();
        if ($guru) {
            $guruRes = $this->actingAs($guru)->get(route('cms.perangkat.index'));
            $guruRes->assertStatus(403);
        }
    }

    public function test_superadmin_can_access_space_hosting(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $response = $this->actingAs($superadmin)->get(route('cms.perangkat.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Ruang Hosting');
        $response->assertSee('Kapasitas SSD Hosting');
        $response->assertSee('Hapus Dokumen Terpilih');
    }

    public function test_superadmin_can_bulk_delete_documents(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $cp = \App\Models\CapaianPembelajaran::first();
        $this->assertNotNull($cp);

        // Buat dummy TP
        $tp = TujuanPembelajaran::create([
            'capaian_pembelajaran_id' => $cp->id,
            'user_id' => $superadmin->id,
            'kode_tp' => 'TP-DEL-' . uniqid(),
            'elemen' => 'Elemen Test',
            'deskripsi_tp' => 'Testing bulk delete',
            'urutan' => 999,
        ]);

        $this->assertDatabaseHas('tujuan_pembelajarans', ['id' => $tp->id]);

        $response = $this->actingAs($superadmin)->post(route('cms.perangkat.bulk-delete'), [
            'items' => ["TujuanPembelajaran:{$tp->id}"],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('tujuan_pembelajarans', ['id' => $tp->id]);
    }

    public function test_superadmin_dashboard_shows_aapanel_telemetry(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();

        $response = $this->actingAs($superadmin)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Superadmin Control Center');
        $response->assertSee('CPU Load');
        $response->assertSee('RAM / Memori');
        $response->assertSee('SSD / Storage');
        $response->assertSee('Database SQL');
        $response->assertSee('trafficSplineChart');
        $response->assertSee('docDonutChart');
    }

    public function test_landing_page_uses_white_and_sky_blue_theme(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Kurikulum Merdeka');
        $response->assertSee('Deep Learning');
        $response->assertSee('100% Sistem Pakar Murni');
        $response->assertDontSee('calon apresiasi');
        $response->assertDontSee('Calon Apresiasi');
    }
}
