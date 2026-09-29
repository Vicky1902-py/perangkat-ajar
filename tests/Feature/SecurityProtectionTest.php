<?php

namespace Tests\Feature;

use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\PaketSoal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityProtectionTest extends TestCase
{
    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_login_brute_force_rate_limiting(): void
    {
        RateLimiter::clear('test-brute@example.com|127.0.0.1');

        // Attempt 5 failed logins
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test-brute@example.com',
                'password' => 'wrongpassword123',
            ]);
        }

        // 6th attempt should be blocked with rate limiting error
        $response = $this->post('/login', [
            'email' => 'test-brute@example.com',
            'password' => 'wrongpassword123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $error = session('errors')->first('email');
        $this->assertStringContainsString('Terlalu banyak percobaan masuk yang gagal', $error);
    }

    public function test_unauthorized_user_cannot_delete_other_user_paket_soal(): void
    {
        $owner = User::factory()->create(['role' => 'guru', 'is_profile_completed' => true]);
        $attacker = User::factory()->create(['role' => 'guru', 'is_profile_completed' => true]);

        $mapel = MataPelajaran::first();
        $fase = Fase::first();

        $paketSoal = PaketSoal::create([
            'user_id' => $owner->id,
            'mata_pelajaran_id' => $mapel->id,
            'fase_id' => $fase->id,
            'judul' => 'Soal Rahasia Guru Owner',
            'jenis_ujian' => 'Ulangan Harian',
            'bentuk_soal' => 'pg',
            'total_soal_pg' => 5,
            'total_soal_isian' => 0,
            'alokasi_waktu_menit' => 60,
        ]);

        // Attacker attempts to delete owner's paket soal
        $response = $this->actingAs($attacker)->delete("/paket-soal/{$paketSoal->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('paket_soals', ['id' => $paketSoal->id]);
    }

    public function test_desktop_sidebar_toggle_elements_exist(): void
    {
        $user = User::where('role', 'superadmin')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'superadmin', 'is_profile_completed' => true]);
        }

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('sidebarToggle');
        $response->assertSee('sidebarToggleIcon');
        $response->assertSee('sidebar-mini-expand-btn');
    }
}
