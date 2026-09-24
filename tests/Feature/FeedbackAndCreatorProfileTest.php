<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Models\UserFeedback;
use Tests\TestCase;

class FeedbackAndCreatorProfileTest extends TestCase
{
    protected User $superadmin;
    protected User $teacher;

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

        $this->teacher = User::firstOrCreate(
            ['email' => 'guru.test@sekolah.sch.id'],
            [
                'name' => 'Guru Penguji',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'is_profile_completed' => true,
            ]
        );
    }

    public function test_welcome_popup_and_shortcuts_rendered_on_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('welcomeGuideModal', false);
        $response->assertSee('Panduan Penggunaan', false);
        $response->assertSee('Usul & Saran', false);
        $response->assertSee('Profil Pembuat', false);
        $response->assertSee('openWelcomePopup', false);
        $response->assertSee(route('creator.profile'));
    }

    public function test_public_can_access_creator_profile_page(): void
    {
        $response = $this->get('/profil-pembuat');
        $response->assertStatus(200);
        $response->assertSee(app_setting('landing_creator_name', 'Vicky Koroh'));
        $response->assertSee(app_setting('landing_copyright_year', '2026'));
        $response->assertSee('Dedikasi Sistem', false);
    }

    public function test_public_guest_can_submit_feedback(): void
    {
        $payload = [
            'nama' => 'Budi Pengunjung',
            'email' => 'budi.tamu@gmail.com',
            'no_hp' => '081299887766',
            'kategori' => 'usul_fitur',
            'rating' => 5,
            'judul' => 'Mohon tambahkan fitur ekspor CSV',
            'pesan' => 'Aplikasi ini sangat bagus. Usul saya tambahkan ekspor nilai dan modul dalam format spreadsheet.',
        ];

        $response = $this->postJson('/feedback', $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('user_feedbacks', [
            'nama' => 'Budi Pengunjung',
            'judul' => 'Mohon tambahkan fitur ekspor CSV',
            'status' => 'baru',
        ]);
    }

    public function test_authenticated_teacher_can_submit_feedback(): void
    {
        $payload = [
            'nama' => $this->teacher->name,
            'email' => $this->teacher->email,
            'kategori' => 'perbaikan_kekurangan',
            'rating' => 4,
            'judul' => 'Masukan alokasi JP otomatis',
            'pesan' => 'Mohon dibuat opsi untuk mengedit minggu efektif sebelum generate modul ajar.',
        ];

        $response = $this->actingAs($this->teacher)->post('/feedback', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('user_feedbacks', [
            'user_id' => $this->teacher->id,
            'judul' => 'Masukan alokasi JP otomatis',
        ]);
    }

    public function test_superadmin_can_view_and_manage_feedbacks(): void
    {
        $feedback = UserFeedback::create([
            'nama' => 'User Feedback Test',
            'email' => 'test@example.com',
            'kategori' => 'laporan_bug',
            'rating' => 3,
            'judul' => 'Tombol cetak kadang lambat',
            'pesan' => 'Ketika mencetak dokumen PDF yang sangat panjang butuh beberapa detik.',
            'status' => 'baru',
        ]);

        // 1. Superadmin buka halaman index
        $indexResponse = $this->actingAs($this->superadmin)->get('/cms/feedbacks');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Tombol cetak kadang lambat');

        // 2. Superadmin update status
        $statusResponse = $this->actingAs($this->superadmin)->post("/cms/feedbacks/{$feedback->id}/status", [
            'status' => 'ditinjau',
            'catatan_admin' => 'Sedang dioptimasi dengan query chunking.',
        ]);
        $statusResponse->assertRedirect(route('cms.feedbacks.index'));

        $this->assertDatabaseHas('user_feedbacks', [
            'id' => $feedback->id,
            'status' => 'ditinjau',
            'catatan_admin' => 'Sedang dioptimasi dengan query chunking.',
        ]);

        // 3. Superadmin hapus feedback
        $deleteResponse = $this->actingAs($this->superadmin)->delete("/cms/feedbacks/{$feedback->id}");
        $deleteResponse->assertRedirect(route('cms.feedbacks.index'));

        $this->assertDatabaseMissing('user_feedbacks', [
            'id' => $feedback->id,
        ]);
    }

    public function test_superadmin_can_update_creator_profile_via_settings(): void
    {
        $updatePayload = [
            'active_tab' => 'creator',
            'landing_creator_name' => 'Vicky Koroh, S.Kom.',
            'creator_headline' => 'Lead AI & Education Architect 2026',
            'creator_skills' => 'AI System Engineering, Deep Learning SMK, Clean Architecture',
            'creator_whatsapp' => '089988776655',
            'creator_email' => 'vicky.lead@vxai.online',
        ];

        $response = $this->actingAs($this->superadmin)->post('/cms/settings', $updatePayload);
        $response->assertRedirect('/cms/settings?tab=creator');
        $response->assertSessionHas('success');

        $this->assertEquals('Vicky Koroh, S.Kom.', Setting::get('landing_creator_name'));
        $this->assertEquals('Lead AI & Education Architect 2026', Setting::get('creator_headline'));

        // Pastikan halaman publik profil langsung merefleksikan perubahan
        $profileResponse = $this->get('/profil-pembuat');
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('Vicky Koroh, S.Kom.');
        $profileResponse->assertSee('Lead AI & Education Architect 2026');
    }

    public function test_android_mobile_view_and_prominent_copyright_notice_rendered(): void
    {
        $response = $this->actingAs($this->teacher)->get('/dashboard');
        $response->assertStatus(200);

        // 1. Verifikasi Bottom Navigation Bar khas Android / Smartphone
        $response->assertSee('mobile-bottom-nav', false);
        $response->assertSee('Smart Soal');
        $response->assertSee('Generator');

        // 2. Verifikasi Shell Android Card Grid ala Gojek / Grab
        $response->assertSee('mobile-app-shell', false);
        $response->assertSee('SISTEM PAKAR MURNI');
        $response->assertSee('BSKAP 046/2025');
        $response->assertSee('Bebas Halusinasi AI');
        $response->assertSee('Bank Soal');
        $response->assertSee('Modul Ajar');
        $response->assertSee('Alur (ATP)');
        $response->assertSee('Prota &amp; Promes', false);

        // 3. Verifikasi Hak Cipta Vicky Koroh tampak jelas dan terdaftar
        $response->assertSee('HAK CIPTA &bull; DESAIN BY. VICKY KOROH', false);
        $response->assertSee('BSKAP No. 046/H/KR/2025', false);
        $response->assertSee('Hak Cipta : Desain by.', false);
    }
}
