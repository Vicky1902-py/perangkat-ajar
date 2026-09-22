<?php

namespace Tests\Feature;

use App\Models\TrafficLog;
use App\Models\User;
use Tests\TestCase;

class AdSenseAndTrafficTest extends TestCase
{
    public function test_legal_compliance_pages_are_publicly_accessible(): void
    {
        $routes = [
            '/privacy-policy',
            '/terms-of-service',
            '/about-us',
            '/contact',
            '/disclaimer',
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee('2026');
            $response->assertSee('Vicky Koroh');
        }
    }

    public function test_traffic_middleware_logs_public_visits(): void
    {
        $initialCount = TrafficLog::count();

        $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148 Safari/604.1'
        ])->get('/privacy-policy');

        $this->assertGreaterThan($initialCount, TrafficLog::count());

        $latest = TrafficLog::latest('id')->first();
        $this->assertEquals('Smartphone', $latest->device_type);
        $this->assertEquals('iOS 17.0', $latest->device_os);
        $this->assertEquals('Apple Safari', $latest->browser);
        $this->assertEquals('guest', $latest->role);
        $this->assertEquals('view', $latest->action_type);
        $this->assertStringContainsString('Kebijakan Privasi', $latest->activity_description);
    }

    public function test_desktop_traffic_is_properly_detected(): void
    {
        $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0.0.0 Safari/537.36'
        ])->get('/about-us');

        $latest = TrafficLog::latest('id')->first();
        $this->assertEquals('Desktop / Laptop', $latest->device_type);
        $this->assertEquals('Windows 10/11', $latest->device_os);
        $this->assertEquals('Google Chrome', $latest->browser);
    }

    public function test_superadmin_can_access_traffic_monitor(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
                'is_active' => true,
                'is_profile_completed' => true,
            ]
        );

        $response = $this->actingAs($admin)->get('/cms/traffic');
        $response->assertStatus(200);
        $response->assertSee('Pantau Traffic &amp; Perangkat Pengunjung Realtime', false);

        // Test Live API Endpoint
        $liveResponse = $this->actingAs($admin)->getJson('/cms/traffic/live');
        $liveResponse->assertStatus(200);
        $liveResponse->assertJsonStructure([
            'status',
            'timestamp',
            'metrics' => [
                'active_now',
                'active_guests',
                'active_users',
                'today_visits',
                'today_generates',
            ],
            'logs',
        ]);
    }

    public function test_guest_cannot_access_traffic_monitor(): void
    {
        $response = $this->get('/cms/traffic');
        $response->assertRedirect('/login');
    }
}
