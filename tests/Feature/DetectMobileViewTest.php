<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetectMobileViewTest extends TestCase
{
    /**
     * Test mobile User-Agent renders dedicated mobile Stitch layout on generator page.
     */
    public function test_mobile_user_agent_renders_stitch_mobile_view(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36'
        ])->get(route('generator.index'));

        $response->assertStatus(200);
        $response->assertSee('stitch-mobile-viewport', false);
        $response->assertSee('mobile-gen-floating-dock', false);
        $response->assertDontSee('desktop-generator-shell', false);
    }

    /**
     * Test desktop User-Agent renders standard desktop layout.
     */
    public function test_desktop_user_agent_renders_desktop_view(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ])->get(route('generator.index'));

        $response->assertStatus(200);
        $response->assertDontSee('stitch-mobile-viewport', false);
        $response->assertSee('desktop-generator-shell', false);
    }

    /**
     * Test query param ?view=mobile forces mobile view on desktop.
     */
    public function test_query_view_mobile_forces_mobile_view(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ])->get(route('generator.index', ['view' => 'mobile']));

        $response->assertStatus(200);
        $response->assertSee('stitch-mobile-viewport', false);
    }

    /**
     * Test query param ?view=desktop forces desktop view on mobile device.
     */
    public function test_query_view_desktop_forces_desktop_view(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 Mobile Safari/537.36'
        ])->get(route('generator.index', ['view' => 'desktop']));

        $response->assertStatus(200);
        $response->assertDontSee('stitch-mobile-viewport', false);
    }

    /**
     * Test authenticated dashboard renders mobile view with bottom nav dock.
     */
    public function test_authenticated_user_dashboard_mobile_view(): void
    {
        $user = User::factory()->create([
            'role' => 'guru',
            'is_profile_completed' => true,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 Mobile Safari/537.36'
            ])->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('stitch-mobile-viewport', false);
        $response->assertSee('mobile-pill-dock', false);
    }
}
