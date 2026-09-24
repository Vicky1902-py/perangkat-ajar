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

    public function test_ads_txt_endpoint_is_publicly_accessible(): void
    {
        $response = $this->get('/ads.txt');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', (string) $response->headers->get('Content-Type'));
        $response->assertSee('google.com');
    }

    public function test_superadmin_can_update_adsense_settings_and_sync_ads_txt(): void
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

        $testPubId = 'ca-pub-8888777766665555';
        $testAdsTxt = "google.com, pub-8888777766665555, DIRECT, f08c47fec0942fa0\n";

        $response = $this->actingAs($admin)->post('/cms/settings', [
            'active_tab' => 'adsense',
            'adsense_enabled' => '1',
            'adsense_publisher_id' => $testPubId,
            'adsense_code' => '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8888777766665555"></script>',
            'ads_txt_content' => $testAdsTxt,
        ]);

        $response->assertRedirect('/cms/settings?tab=adsense');

        // Check /ads.txt has new publisher ID
        $adsResponse = $this->get('/ads.txt');
        $adsResponse->assertStatus(200);
        $adsResponse->assertSee('pub-8888777766665555');

        // Check homepage has meta verification tag
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee($testPubId);
    }

    public function test_superadmin_visits_are_not_logged_in_traffic(): void
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

        $initialCount = TrafficLog::count();

        // Superadmin browsing various pages
        $this->actingAs($admin)->get('/dashboard');
        $this->actingAs($admin)->get('/cms/traffic');
        $this->actingAs($admin)->get('/cms/settings');
        $this->actingAs($admin)->get('/privacy-policy');

        // TrafficLog count must not increase for superadmin
        $this->assertEquals($initialCount, TrafficLog::count());
    }

    public function test_sitemap_xml_is_publicly_accessible(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('<urlset', false);
        $response->assertSee(url('/'), false);
        $response->assertSee(route('generator.index'), false);
        $response->assertSee(route('creator.profile'), false);
        $response->assertSee(route('legal.privacy'), false);
        $response->assertSee(route('legal.terms'), false);
    }

    public function test_robots_txt_is_accessible_and_references_sitemap(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', (string) $response->headers->get('Content-Type'));
        $response->assertSee('User-agent:');
        $response->assertSee('Sitemap:');
    }

    public function test_google_html_verification_endpoint(): void
    {
        $verificationCode = 'abc123xyz789';
        $response = $this->get('/google' . $verificationCode . '.html');
        $response->assertStatus(200);
        $response->assertSee('google-site-verification: google' . $verificationCode . '.html');
    }

    public function test_superadmin_can_update_gsc_and_seo_settings(): void
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

        $testGscCode = 'gsc_verification_token_999';
        $testRobotsTxt = "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml') . "\n";

        $response = $this->actingAs($admin)->post('/cms/settings', [
            'active_tab' => 'seo',
            'gsc_verification_code' => $testGscCode,
            'gsc_html_file_code' => 'google999xyz',
            'robots_txt_content' => $testRobotsTxt,
        ]);

        $response->assertRedirect('/cms/settings?tab=seo');

        // Check homepage has Google Search Console meta verification tag
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<meta name="google-site-verification" content="' . $testGscCode . '">', false);

        // Cleanup test generated file if created
        if (file_exists(public_path('google999xyz.html'))) {
            @unlink(public_path('google999xyz.html'));
        }
    }
}

