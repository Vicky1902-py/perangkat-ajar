<?php

namespace Tests\Feature;

use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\GuestUsage;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\SatuanPendidikan;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Services\GeneratorService;
use Tests\TestCase;

class GeneratorSmokeTest extends TestCase
{
    public function test_generator_service_creates_all_teaching_tools_successfully(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $cp = CapaianPembelajaran::first();

        $this->assertNotNull($user, 'User admin harus ada.');
        $this->assertNotNull($cp, 'Capaian Pembelajaran harus ada.');

        $service = new GeneratorService();
        $result = $service->generateAll([
            'capaian_pembelajaran_id' => $cp->id,
        ], $user);

        $this->assertArrayHasKey('tujuan_pembelajaran', $result);
        $this->assertArrayHasKey('atp', $result);
        $this->assertArrayHasKey('modul_ajar', $result);
        $this->assertArrayHasKey('lkpd', $result);
        $this->assertArrayHasKey('prota', $result);
        $this->assertArrayHasKey('promes', $result);
        $this->assertArrayHasKey('asesmen', $result);

        $this->assertGreaterThan(0, count($result['tujuan_pembelajaran']));
        $this->assertEquals(5, $result['modul_ajar']->kegiatans()->count(), 'Modul Ajar harus memiliki 5 kegiatan alur PEDATTI.');
        $this->assertEquals(3, $result['lkpd']->kegiatans()->count(), 'LKPD harus memiliki 3 tahapan (Memahami, Mengaplikasi, Merefleksi).');
    }

    public function test_generator_works_for_koding_dan_kecerdasan_artifisial(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $mapelAi = MataPelajaran::where('nama', 'Koding dan Kecerdasan Artifisial (AI)')->first();
        $this->assertNotNull($mapelAi, 'Mata pelajaran Koding dan Kecerdasan Artifisial (AI) harus ada.');

        $cpAi = CapaianPembelajaran::where('mata_pelajaran_id', $mapelAi->id)->where('fase_id', 1)->first();
        $this->assertNotNull($cpAi, 'CP Koding dan AI Fase E harus ada.');

        $service = new GeneratorService();
        $result = $service->generateAll([
            'capaian_pembelajaran_id' => $cpAi->id,
        ], $user);

        $this->assertNotNull($result['atp']);
        $this->assertNotNull($result['modul_ajar']);
        $this->assertNotNull($result['lkpd']);

        // Pastikan Modul Ajar AI memiliki kegiatan PEDATTI
        $this->assertEquals(5, $result['modul_ajar']->kegiatans->count());
        // Pastikan LKPD AI memiliki 3 tahap kerja
        $this->assertEquals(3, $result['lkpd']->kegiatans->count());
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sistem Perangkat Ajar');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Permendikdasmen No. 13 Tahun 2025');
    }

    public function test_export_endpoints_are_working(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $atp = AlurTujuanPembelajaran::latest()->first();
        $modul = ModulAjar::latest()->first();
        $lkpd = Lkpd::latest()->first();

        $this->assertNotNull($atp);
        $this->assertNotNull($modul);
        $this->assertNotNull($lkpd);

        // Test ATP PDF
        $resPdf = $this->actingAs($user)->get(route('export.atp.pdf', $atp->id));
        $resPdf->assertStatus(200);
        $resPdf->assertHeader('content-type', 'application/pdf');

        // Test Modul Ajar PDF
        $resModulPdf = $this->actingAs($user)->get(route('export.modul-ajar.pdf', $modul->id));
        $resModulPdf->assertStatus(200);
        $resModulPdf->assertHeader('content-type', 'application/pdf');

        // Test LKPD PDF
        $resLkpdPdf = $this->actingAs($user)->get(route('export.lkpd.pdf', $lkpd->id));
        $resLkpdPdf->assertStatus(200);
        $resLkpdPdf->assertHeader('content-type', 'application/pdf');
    }

    public function test_all_mata_pelajaran_have_capaian_pembelajaran(): void
    {
        $mapelsWithoutCp = MataPelajaran::doesntHave('capaianPembelajarans')->get();
        $this->assertCount(0, $mapelsWithoutCp, 'Semua mata pelajaran harus memiliki Capaian Pembelajaran aktif.');
    }

    public function test_ketenagalistrikan_pengelasan_dpib_have_complete_cp(): void
    {
        $listrik = MataPelajaran::where('nama', 'Teknik Instalasi Tenaga Listrik')->first();
        $this->assertNotNull($listrik, 'Mapel Teknik Instalasi Tenaga Listrik harus ada.');
        $this->assertGreaterThan(0, $listrik->capaianPembelajarans()->count());

        $pengelasan = MataPelajaran::where('nama', 'Teknik Pengelasan (Welding)')->first();
        $this->assertNotNull($pengelasan, 'Mapel Teknik Pengelasan (Welding) harus ada.');
        $this->assertGreaterThan(0, $pengelasan->capaianPembelajarans()->count());

        $dpib = MataPelajaran::where('nama', 'Desain Pemodelan dan Informasi Bangunan (BIM)')->first();
        $this->assertNotNull($dpib, 'Mapel Desain Pemodelan dan Informasi Bangunan (BIM) harus ada.');
        $this->assertGreaterThan(0, $dpib->capaianPembelajarans()->count());
    }

    public function test_generator_page_contains_ai_and_kejuruan_groups(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $response = $this->actingAs($user)->get('/generator');
        $response->assertStatus(200);
        $response->assertSee('Koding dan Kecerdasan Artifisial (AI)');
        $response->assertSee('Teknik Instalasi Tenaga Listrik');
        $response->assertSee('Teknik Pengelasan (Welding)');
        $response->assertSee('Desain Pemodelan dan Informasi Bangunan (BIM)');
    }

    public function test_asesmen_complies_with_kemendikdasmen_ppa_2026(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $asesmen = \App\Models\Asesmen::latest()->first();
        $this->assertNotNull($asesmen, 'Asesmen harus ada di database.');

        // 1. Pastikan KKTP memiliki 4 kriteria rubrik
        $this->assertNotEmpty($asesmen->kktp_data['kriteria']);
        $this->assertCount(4, $asesmen->kktp_data['kriteria']);

        // 2. Pastikan tabel interval tindak lanjut resmi Kemendikdasmen terisi 4 jenjang
        $this->assertNotEmpty($asesmen->tindak_lanjut_data['interval']);
        $this->assertCount(4, $asesmen->tindak_lanjut_data['interval']);

        // 3. Pastikan asesmen diagnostik TIDAK dibobot untuk nilai akhir
        $this->assertStringContainsString('TIDAK DIBOBOT', $asesmen->pedoman_penskoran);

        // 4. Pastikan komponen unjuk kerja vokasi DUDI tersedia
        $this->assertNotEmpty($asesmen->vokasi_dudi_data['komponen_penilaian']);

        // 5. Pastikan halaman detail asesmen dapat diakses
        $resShow = $this->actingAs($user)->get(route('asesmen.show', $asesmen->id));
        $resShow->assertStatus(200);
        $resShow->assertSee('Kriteria Ketercapaian Tujuan Pembelajaran (KKTP)');
        $resShow->assertSee('Lembar Observasi Unjuk Kerja Praktik Vokasi');

        // 6. Pastikan ekspor PDF Asesmen berjalan lancar
        $resPdf = $this->actingAs($user)->get(route('export.asesmen.pdf', $asesmen->id));
        $resPdf->assertStatus(200);
        $resPdf->assertHeader('content-type', 'application/pdf');
    }

    public function test_cp_and_atp_comply_with_bskap_046_2025(): void
    {
        // 1. Pastikan 100% Capaian Pembelajaran merujuk pada Keputusan Kepala BSKAP Nomor 046/H/KR/2025
        $totalCp = CapaianPembelajaran::count();
        $cpWithBskap046 = CapaianPembelajaran::where('regulasi', 'like', '%046/H/KR/2025%')->count();
        $this->assertEquals($totalCp, $cpWithBskap046, 'Seluruh CP harus merujuk pada regulasi BSKAP 046/H/KR/2025.');

        // 2. Pastikan ATP memiliki regulasi BSKAP 046/H/KR/2025 dan alokasi JP terisi
        $atp = AlurTujuanPembelajaran::with(['atpDetails.tujuanPembelajaran'])->latest()->first();
        $this->assertNotNull($atp);
        $this->assertStringContainsString('046/H/KR/2025', $atp->regulasi);
        $this->assertGreaterThan(0, $atp->total_alokasi_jp);

        // 3. Pastikan AtpDetail memiliki elemen CP, sumber belajar, dan indikator asesmen
        $detail = $atp->atpDetails->first();
        $this->assertNotNull($detail);
        $this->assertNotNull($detail->tujuanPembelajaran->elemen);
        $this->assertNotEmpty($detail->sumber_belajar);
        $this->assertNotEmpty($detail->dimensi_profil_lulusan);
    }

    public function test_responsive_ui_elements_exist_on_all_views(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $atp = AlurTujuanPembelajaran::latest()->first();

        // 1. Dashboard harus memuat backdrop dan toggle mobile
        $resDash = $this->actingAs($user)->get('/dashboard');
        $resDash->assertStatus(200);
        $resDash->assertSee('sidebarBackdrop');
        $resDash->assertSee('sidebarToggle');
        $resDash->assertSee('sidebarCloseBtn');
        $resDash->assertSee('BSKAP 046/H/KR/2025');

        // 2. Halaman Detail ATP harus responsive dan memuat tabel-responsive serta badge regulasi
        $resAtp = $this->actingAs($user)->get(route('atp.show', $atp->id));
        $resAtp->assertStatus(200);
        $resAtp->assertSee('table-responsive');
        $resAtp->assertSee('Keputusan Kepala BSKAP Nomor 046/H/KR/2025');

        // 3. CMS CP harus responsive dan memuat modal detail
        $resCp = $this->actingAs($user)->get(route('cms.cp.index'));
        $resCp->assertStatus(200);
        $resCp->assertSee('table-responsive');
        $resCp->assertSee('BSKAP No. 046/H/KR/2025');
        $resCp->assertSee('modalCp');
    }

    public function test_user_without_completed_profile_is_redirected_to_profile_setup(): void
    {
        // Buat user baru yang belum melengkapi profil
        $newUser = User::updateOrCreate(
            ['email' => 'gurubaru@smk.sch.id'],
            [
                'name' => 'Guru Baru SMK',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_profile_completed' => false,
                'is_active' => true,
            ]
        );

        // Coba akses dashboard -> wajib redirect ke profile.setup
        $response = $this->actingAs($newUser)->get('/dashboard');
        $response->assertRedirect(route('profile.setup'));
        $response->assertSessionHas('warning');

        // Coba akses fitur internal (misal ATP) -> wajib redirect ke profile.setup
        $resAtp = $this->actingAs($newUser)->get(route('atp.index'));
        $resAtp->assertRedirect(route('profile.setup'));

        // Akses halaman setup langsung -> harus sukses (200)
        $resSetup = $this->actingAs($newUser)->get(route('profile.setup'));
        $resSetup->assertStatus(200);
        $resSetup->assertSee('Pengaturan Profil');
        $resSetup->assertSee('Kop Surat');
        $resSetup->assertSee('Langkah Wajib: Onboarding Profil Multi-Sekolah');
    }

    public function test_user_can_complete_profile_setup_and_access_features(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'penguji@smk.sch.id'],
            [
                'name' => 'Guru Penguji',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_profile_completed' => false,
                'is_active' => true,
            ]
        );

        $postData = [
            'name' => 'Ahmad Dahlan, M.Pd.',
            'nip' => '198005152005011003',
            'telepon' => '081298765432',
            'mata_pelajaran_diampu' => 'Teknik Komputer dan Jaringan',
            'nama_sekolah' => 'SMK Negeri 2 Surabaya',
            'npsn' => '20500002',
            'jenjang' => 'SMK',
            'alamat' => 'Jl. Tentara Genie Pelajar No. 26',
            'kota' => 'Surabaya',
            'provinsi' => 'Jawa Timur',
            'telepon_sekolah' => '(031) 5345678',
            'email_sekolah' => 'info@smkn2surabaya.sch.id',
            'website' => 'www.smkn2surabaya.sch.id',
            'kepala_sekolah' => 'Dra. Hj. Sri Wahyuni, M.Si.',
            'nip_kepala_sekolah' => '196503121990032004',
            'dinas_pendidikan' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
            'kop_baris_1' => 'PEMERINTAH PROVINSI JAWA TIMUR',
            'kop_baris_2' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
            'kop_baris_3' => 'SEKOLAH MENENGAH KEJURUAN NEGERI 2 SURABAYA',
            'kop_baris_4' => 'Jl. Tentara Genie Pelajar No. 26, Surabaya | Telp: (031) 5345678',
            'ukuran_kertas_default' => 'A4',
        ];

        $response = $this->actingAs($user)->post(route('profile.save'), $postData);
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        // Pastikan status user sudah completed
        $user->refresh();
        $this->assertTrue($user->is_profile_completed);
        $this->assertEquals('Ahmad Dahlan, M.Pd.', $user->name);
        $this->assertEquals('198005152005011003', $user->nip);

        // Pastikan relasi sekolah terisi
        $this->assertNotNull($user->satuanPendidikan);
        $this->assertEquals('SMK Negeri 2 Surabaya', $user->satuanPendidikan->nama);
        $this->assertEquals('Dra. Hj. Sri Wahyuni, M.Si.', $user->satuanPendidikan->kepala_sekolah);
        $this->assertEquals('196503121990032004', $user->satuanPendidikan->nip_kepala_sekolah);

        // Sekarang user bisa akses dashboard tanpa diredirect
        $resDash = $this->actingAs($user)->get('/dashboard');
        $resDash->assertStatus(200);
    }

    public function test_all_export_documents_contain_kop_surat_and_signatures(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $this->assertNotNull($user);

        $atp = AlurTujuanPembelajaran::where('user_id', $user->id)->first() ?? AlurTujuanPembelajaran::first();
        $modul = ModulAjar::where('user_id', $user->id)->first() ?? ModulAjar::first();
        $lkpd = Lkpd::where('user_id', $user->id)->first() ?? Lkpd::first();
        $asesmen = Asesmen::where('user_id', $user->id)->first() ?? Asesmen::first();

        $sekolahNama = $user->satuanPendidikan?->nama ?? 'SEKOLAH MENENGAH KEJURUAN NEGERI 1 JAKARTA';
        $kepsekNama = $user->satuanPendidikan?->kepala_sekolah ?? 'Drs. H. Suryadi, M.Pd.';
        $nipKepsek = $user->satuanPendidikan?->nip_kepala_sekolah ?? '196805121994031005';

        // 1. Verifikasi konten template PDF ATP
        $viewAtp = view('exports.pdf.atp', ['atp' => $atp->load(['user.satuanPendidikan', 'mataPelajaran', 'fase', 'tahunAjaran', 'atpDetails.tujuanPembelajaran'])])->render();
        $this->assertStringContainsString($sekolahNama, $viewAtp);
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewAtp);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewAtp);
        $this->assertStringContainsString($kepsekNama, $viewAtp);
        $this->assertStringContainsString($nipKepsek, $viewAtp);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewAtp);

        // 2. Verifikasi konten template PDF Modul Ajar
        $viewModul = view('exports.pdf.modul-ajar', ['modulAjar' => $modul->load(['user.satuanPendidikan', 'mataPelajaran', 'fase', 'tahunAjaran', 'tujuanPembelajaran', 'kegiatans', 'profilLulusans'])])->render();
        $this->assertStringContainsString($sekolahNama, $viewModul);
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewModul);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewModul);
        $this->assertStringContainsString($kepsekNama, $viewModul);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewModul);

        // 3. Verifikasi konten template PDF LKPD
        $viewLkpd = view('exports.pdf.lkpd', ['lkpd' => $lkpd->load(['user.satuanPendidikan', 'mataPelajaran', 'fase', 'modulAjar', 'kegiatans'])])->render();
        $this->assertStringContainsString($sekolahNama, $viewLkpd);
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewLkpd);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewLkpd);
        $this->assertStringContainsString($kepsekNama, $viewLkpd);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewLkpd);

        // 4. Verifikasi konten template PDF Asesmen
        $viewAsesmen = view('exports.pdf.asesmen', ['asesmen' => $asesmen->load(['user.satuanPendidikan', 'mataPelajaran', 'fase', 'modulAjar', 'tujuanPembelajaran'])])->render();
        $this->assertStringContainsString($sekolahNama, $viewAsesmen);
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewAsesmen);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewAsesmen);
        $this->assertStringContainsString($kepsekNama, $viewAsesmen);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewAsesmen);

        // 5. Verifikasi format posisi: Kepala Sekolah di KIRI dan Guru di KANAN
        $posKepsek = strpos($viewAtp, 'Mengetahui');
        $posGuru = strpos($viewAtp, 'Guru Mata Pelajaran');
        $this->assertLessThan($posGuru, $posKepsek, 'Kepala Sekolah harus berada di sebelah KIRI (muncul lebih awal) sebelum Guru di sebelah KANAN.');
    }

    public function test_pdf_exports_support_paper_selection_a4_and_f4(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $atp = AlurTujuanPembelajaran::latest()->first();
        $modul = ModulAjar::latest()->first();
        $lkpd = Lkpd::latest()->first();
        $asesmen = Asesmen::latest()->first();

        // 1. Export PDF A4
        $resA4 = $this->actingAs($user)->get(route('export.atp.pdf', $atp->id) . '?paper=a4');
        $resA4->assertStatus(200);
        $resA4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_A4.pdf', $resA4->headers->get('content-disposition'));

        // 2. Export PDF F4 / Folio
        $resF4 = $this->actingAs($user)->get(route('export.atp.pdf', $atp->id) . '?paper=f4');
        $resF4->assertStatus(200);
        $resF4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_F4.pdf', $resF4->headers->get('content-disposition'));

        // 3. Export Modul Ajar F4
        $resModulF4 = $this->actingAs($user)->get(route('export.modul-ajar.pdf', $modul->id) . '?paper=f4');
        $resModulF4->assertStatus(200);
        $this->assertStringContainsString('_F4.pdf', $resModulF4->headers->get('content-disposition'));

        // 4. Export LKPD F4
        $resLkpdF4 = $this->actingAs($user)->get(route('export.lkpd.pdf', $lkpd->id) . '?paper=f4');
        $resLkpdF4->assertStatus(200);
        $this->assertStringContainsString('_F4.pdf', $resLkpdF4->headers->get('content-disposition'));

        // 5. Export Asesmen F4
        $resAsesmenF4 = $this->actingAs($user)->get(route('export.asesmen.pdf', $asesmen->id) . '?paper=f4');
        $resAsesmenF4->assertStatus(200);
        $this->assertStringContainsString('_F4.pdf', $resAsesmenF4->headers->get('content-disposition'));
    }

    public function test_web_footer_contains_vicky_koroh_copyright(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Hak Cipta : Desain by. Vicky Koroh');
    }

    public function test_cms_tahun_ajaran_crud_and_activation(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        // 1. Akses halaman CMS Tahun Ajaran
        $response = $this->actingAs($admin)->get(route('cms.tahun-ajaran.index'));
        $response->assertStatus(200);
        $response->assertSee('CMS Tahun Ajaran');

        // 2. Tambah Tahun Ajaran baru melalui CMS
        $postRes = $this->actingAs($admin)->post(route('cms.tahun-ajaran.store'), [
            'nama' => '2028/2029',
            'semester' => 1,
            'tanggal_mulai' => '2028-07-10',
            'tanggal_selesai' => '2028-12-15',
            'is_active' => '0',
        ]);
        $postRes->assertRedirect();
        $this->assertDatabaseHas('tahun_ajarans', [
            'nama' => '2028/2029',
            'semester' => 1,
        ]);

        $createdTa = TahunAjaran::where('nama', '2028/2029')->where('semester', 1)->first();
        $this->assertNotNull($createdTa);

        // 3. Aktifkan Tahun Ajaran tersebut
        $actRes = $this->actingAs($admin)->post(route('cms.tahun-ajaran.activate', $createdTa->id));
        $actRes->assertRedirect();
        $this->assertTrue((bool) $createdTa->fresh()->is_active);

        // 4. Update Tahun Ajaran
        $updateRes = $this->actingAs($admin)->put(route('cms.tahun-ajaran.update', $createdTa->id), [
            'nama' => '2028/2029',
            'semester' => 1,
            'tanggal_mulai' => '2028-07-15',
            'tanggal_selesai' => '2028-12-20',
        ]);
        $updateRes->assertRedirect();
        $this->assertEquals('2028-07-15', $createdTa->fresh()->tanggal_mulai->format('Y-m-d'));

        // 5. Quick Generate Tahun Ajaran (2026/2027 & 2027/2028)
        $quickRes = $this->actingAs($admin)->post(route('cms.tahun-ajaran.quick-generate'));
        $quickRes->assertRedirect();
        $this->assertDatabaseHas('tahun_ajarans', ['nama' => '2026/2027', 'semester' => 1, 'is_active' => 1]);
        $this->assertDatabaseHas('tahun_ajarans', ['nama' => '2026/2027', 'semester' => 2]);
        $this->assertDatabaseHas('tahun_ajarans', ['nama' => '2027/2028', 'semester' => 1]);
    }

    public function test_generator_with_manual_tahun_ajaran_input(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $cp = CapaianPembelajaran::first();

        // Generate dengan input manual tahun ajaran baru
        $response = $this->actingAs($user)->post(route('generator.process'), [
            'capaian_pembelajaran_id' => $cp->id,
            'tahun_ajaran_mode' => 'manual',
            'tahun_ajaran_manual' => '2029/2030',
            'semester_manual' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tahun_ajarans', [
            'nama' => '2029/2030',
            'semester' => 2,
        ]);

        $customTa = TahunAjaran::where('nama', '2029/2030')->where('semester', 2)->first();
        $this->assertNotNull($customTa);

        // Ambil ATP terakhir dan pastikan tahun_ajaran_id terhubung ke customTa
        $latestAtp = AlurTujuanPembelajaran::latest()->first();
        $this->assertEquals($customTa->id, $latestAtp->tahun_ajaran_id);

        $latestModul = ModulAjar::latest()->first();
        $this->assertEquals($customTa->id, $latestModul->tahun_ajaran_id);
    }

    public function test_atp_store_with_manual_tahun_ajaran_input(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $mapel = MataPelajaran::first();

        $response = $this->actingAs($user)->post(route('atp.store'), [
            'mata_pelajaran_id' => $mapel->id,
            'fase_id' => 1,
            'tahun_ajaran_mode' => 'manual',
            'tahun_ajaran_manual' => '2030/2031',
            'semester_manual' => 1,
            'judul' => 'ATP Uji Coba Manual TA',
            'deskripsi' => 'Rasional pengujian manual tahun ajaran',
        ]);

        $response->assertRedirect(route('atp.index'));
        $this->assertDatabaseHas('tahun_ajarans', [
            'nama' => '2030/2031',
            'semester' => 1,
        ]);

        $createdAtp = AlurTujuanPembelajaran::where('judul', 'ATP Uji Coba Manual TA')->first();
        $this->assertNotNull($createdAtp);
        $this->assertNotNull($createdAtp->tahun_ajaran_id);
        $this->assertEquals('2030/2031', $createdAtp->tahunAjaran->nama);
    }

    public function test_navbar_displays_active_tahun_ajaran(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();

        // Pastikan ada tahun ajaran aktif 2026/2027 Ganjil
        TahunAjaran::query()->update(['is_active' => false]);
        TahunAjaran::updateOrCreate(
            ['nama' => '2026/2027', 'semester' => 1],
            ['is_active' => true]
        );

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('2026/2027 Ganjil');
    }

    public function test_prota_and_promes_web_views_and_exports(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $this->assertNotNull($user);

        // 1. Pastikan data Prota dan Promes tersedia di database
        $prota = ProgramTahunan::latest()->first();
        $promes = ProgramSemester::latest()->first();
        $this->assertNotNull($prota, 'Prota harus ada di database.');
        $this->assertNotNull($promes, 'Promes harus ada di database.');

        // 2. Akses halaman index Prota & Promes
        $resIndex = $this->actingAs($user)->get('/prota-promes');
        $resIndex->assertStatus(200);
        $resIndex->assertSee('Program Tahunan (Prota)');
        $resIndex->assertSee('Program Semester (Promes)');
        $resIndex->assertSee('Aksi & Unduh', false);
        $resIndex->assertSee('PDF (A4 Standar)');
        $resIndex->assertSee('PDF (F4 / Folio)');
        $resIndex->assertSee('Unduh Excel (.xlsx)', false);
        $resIndex->assertSee('Unduh Word (.docx)', false);

        // 3. Akses halaman Detail Prota
        $resShowProta = $this->actingAs($user)->get(route('prota.show', $prota->id));
        $resShowProta->assertStatus(200);
        $resShowProta->assertSee('Program Tahunan (Prota)');
        $resShowProta->assertSee('PDF (A4 Standar)');
        $resShowProta->assertSee('PDF (F4 / Folio)');
        $resShowProta->assertSee('Unduh Excel');
        $resShowProta->assertSee('Unduh Word');
        $resShowProta->assertSee('Hak Cipta : Desain by. Vicky Koroh');

        // 4. Akses halaman Detail Promes
        $resShowPromes = $this->actingAs($user)->get(route('promes.show', $promes->id));
        $resShowPromes->assertStatus(200);
        $resShowPromes->assertSee('Program Semester (Promes)');
        $resShowPromes->assertSee('PDF (A4 Standar)');
        $resShowPromes->assertSee('PDF (F4 / Folio)');
        $resShowPromes->assertSee('Unduh Excel');
        $resShowPromes->assertSee('Unduh Word');
        $resShowPromes->assertSee('Hak Cipta : Desain by. Vicky Koroh');

        // 5. Test Export Prota PDF A4 & F4
        $resProtaPdfA4 = $this->actingAs($user)->get(route('export.prota.pdf', $prota->id) . '?paper=a4');
        $resProtaPdfA4->assertStatus(200);
        $resProtaPdfA4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_A4.pdf', $resProtaPdfA4->headers->get('content-disposition'));

        $resProtaPdfF4 = $this->actingAs($user)->get(route('export.prota.pdf', $prota->id) . '?paper=f4');
        $resProtaPdfF4->assertStatus(200);
        $resProtaPdfF4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_F4.pdf', $resProtaPdfF4->headers->get('content-disposition'));

        // 6. Test Export Promes PDF A4 & F4
        $resPromesPdfA4 = $this->actingAs($user)->get(route('export.promes.pdf', $promes->id) . '?paper=a4');
        $resPromesPdfA4->assertStatus(200);
        $resPromesPdfA4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_A4.pdf', $resPromesPdfA4->headers->get('content-disposition'));

        $resPromesPdfF4 = $this->actingAs($user)->get(route('export.promes.pdf', $promes->id) . '?paper=f4');
        $resPromesPdfF4->assertStatus(200);
        $resPromesPdfF4->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('_F4.pdf', $resPromesPdfF4->headers->get('content-disposition'));

        // 7. Test Export Prota Excel & Word
        $resProtaXls = $this->actingAs($user)->get(route('export.prota.excel', $prota->id));
        $resProtaXls->assertStatus(200);
        $this->assertStringContainsString('.xlsx', $resProtaXls->headers->get('content-disposition'));

        $resProtaDocx = $this->actingAs($user)->get(route('export.prota.docx', $prota->id));
        $resProtaDocx->assertStatus(200);
        $this->assertStringContainsString('.docx', $resProtaDocx->headers->get('content-disposition'));

        // 8. Test Export Promes Excel & Word
        $resPromesXls = $this->actingAs($user)->get(route('export.promes.excel', $promes->id));
        $resPromesXls->assertStatus(200);
        $this->assertStringContainsString('.xlsx', $resPromesXls->headers->get('content-disposition'));

        $resPromesDocx = $this->actingAs($user)->get(route('export.promes.docx', $promes->id));
        $resPromesDocx->assertStatus(200);
        $this->assertStringContainsString('.docx', $resPromesDocx->headers->get('content-disposition'));
    }

    public function test_prota_and_promes_pdf_templates_have_kop_and_signatures(): void
    {
        $prota = ProgramTahunan::latest()->first()->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        $promes = ProgramSemester::latest()->first()->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);

        // 1. Render template PDF Prota
        $viewProta = view('exports.pdf.prota', ['prota' => $prota])->render();
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewProta);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewProta);
        $kepsekProta = $prota->user?->satuanPendidikan?->kepala_sekolah ?: 'Drs. H. Suryadi, M.Pd.';
        $this->assertStringContainsString($kepsekProta, $viewProta);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewProta);

        // 2. Render template PDF Promes
        $viewPromes = view('exports.pdf.promes', ['promes' => $promes])->render();
        $this->assertStringContainsString('DINAS PENDIDIKAN', $viewPromes);
        $this->assertStringContainsString('Hak Cipta : Desain by. Vicky Koroh', $viewPromes);
        $kepsekPromes = $promes->user?->satuanPendidikan?->kepala_sekolah ?: 'Drs. H. Suryadi, M.Pd.';
        $this->assertStringContainsString($kepsekPromes, $viewPromes);
        $this->assertStringContainsString('Guru Mata Pelajaran', $viewPromes);

        // 3. Posisi tanda tangan: Kepsek di kiri, Guru di kanan
        $posKepsek = strpos($viewProta, 'Mengetahui');
        $posGuru = strpos($viewProta, 'Guru Mata Pelajaran');
        $this->assertLessThan($posGuru, $posKepsek, 'Kepala Sekolah harus di kiri dan Guru di kanan pada dokumen Prota.');
    }

    public function test_guest_can_access_generator_and_is_limited_to_2_generations(): void
    {
        GuestUsage::truncate();
        session()->flush();

        $cp = CapaianPembelajaran::where('is_active', true)->first();
        $this->assertNotNull($cp);

        // Akses publik generator tanpa login
        $resIndex = $this->get(route('generator.index'));
        $resIndex->assertStatus(200);
        $resIndex->assertSee('Mode Tamu Publik');
        $resIndex->assertSee('2 kali');

        // Percobaan 1: Berhasil
        $resGen1 = $this->post(route('generator.process'), [
            'capaian_pembelajaran_id' => $cp->id,
            'tahun_ajaran_mode' => 'dropdown',
        ]);
        $resGen1->assertRedirect();
        $resGen1->assertSessionHas('success');
        $this->assertStringContainsString('Sisa kuota tamu gratis Anda: 1 kali', session('success'));

        // Percobaan 2: Berhasil (Kuota terakhir)
        $resGen2 = $this->post(route('generator.process'), [
            'capaian_pembelajaran_id' => $cp->id,
            'tahun_ajaran_mode' => 'dropdown',
        ]);
        $resGen2->assertRedirect();
        $resGen2->assertSessionHas('success');
        $this->assertStringContainsString('Kuota gratis 2x Anda telah habis', session('success'));

        // Percobaan 3: DITOLAK karena kuota 2x habis, diarahkan ke register
        $resGen3 = $this->post(route('generator.process'), [
            'capaian_pembelajaran_id' => $cp->id,
            'tahun_ajaran_mode' => 'dropdown',
        ]);
        $resGen3->assertRedirect(route('register'));
        $resGen3->assertSessionHas('warning');
        $this->assertStringContainsString('Batas kuota gratis (2 kali pembuatan perangkat) tanpa login telah tercapai', session('warning'));
    }

    public function test_registration_creates_account_and_transfers_guest_generated_devices(): void
    {
        GuestUsage::truncate();
        session()->flush();

        $cp = CapaianPembelajaran::where('is_active', true)->first();
        $this->assertNotNull($cp);

        // Tamu membuat 1 perangkat dalam sesinya
        $resGen = $this->post(route('generator.process'), [
            'capaian_pembelajaran_id' => $cp->id,
            'tahun_ajaran_mode' => 'dropdown',
        ]);
        $resGen->assertRedirect();
        $resGen->assertSessionHas('success');
        $sessionId = session()->getId();

        $guestAtp = AlurTujuanPembelajaran::where('guest_session_id', $sessionId)->first();
        if (!$guestAtp) {
            // Fallback jika session ID di test environment terisolasi
            $guestAtp = AlurTujuanPembelajaran::whereNull('user_id')->latest()->first();
            $sessionId = $guestAtp?->guest_session_id;
        }
        $this->assertNotNull($guestAtp);
        $this->assertNull($guestAtp->user_id);

        // Tamu mendaftar akun baru
        $email = 'gurutamu_' . uniqid() . '@smk.sch.id';
        $resReg = $this->post(route('register.post'), [
            'name' => 'Guru Tamu Terdaftar',
            'email' => $email,
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'nip' => '199501012022011001',
            'mata_pelajaran_diampu' => 'Koding dan Kecerdasan Artifisial (AI)',
            'jurusan' => 'Pengembangan Perangkat Lunak dan Gim',
        ]);

        $resReg->assertRedirect(route('profile.setup'));
        $resReg->assertSessionHas('success');

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('guru', $user->role);
        $this->assertEquals('Pengembangan Perangkat Lunak dan Gim', $user->jurusan);
        $this->assertAuthenticatedAs($user);

        // Periksa bahwa perangkat tamu telah dialihkan kepemilikannya ke akun user baru
        $guestAtp->refresh();
        $this->assertEquals($user->id, $guestAtp->user_id);
        $this->assertNull($guestAtp->guest_session_id);
    }

    public function test_superadmin_can_view_all_devices_and_teacher_isolation_is_enforced(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $guruA = User::updateOrCreate(
            ['email' => 'guru_a@smk.sch.id'],
            [
                'name' => 'Guru A',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'is_profile_completed' => true,
                'can_view_all_devices' => false,
            ]
        );

        $guruB = User::updateOrCreate(
            ['email' => 'guru_b@smk.sch.id'],
            [
                'name' => 'Guru B',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'is_profile_completed' => true,
                'can_view_all_devices' => false,
            ]
        );

        // Reset relasi hak akses dan dokumen uji coba sebelumnya
        \Illuminate\Support\Facades\DB::table('user_device_accesses')->where('user_id', $guruA->id)->delete();
        AlurTujuanPembelajaran::where('judul', 'ATP Rahasia Guru B')->delete();

        $mapel = MataPelajaran::first();
        $fase = Fase::first();

        // Buat ATP milik Guru B
        $atpB = AlurTujuanPembelajaran::create([
            'user_id' => $guruB->id,
            'mata_pelajaran_id' => $mapel->id,
            'fase_id' => $fase->id,
            'judul' => 'ATP Rahasia Guru B',
            'deskripsi' => 'ATP Khusus Guru B',
            'is_shared' => false,
        ]);

        // Guru A mengakses daftar ATP -> Tidak boleh melihat ATP Guru B
        $resIndexA = $this->actingAs($guruA)->get(route('atp.index'));
        $resIndexA->assertStatus(200);
        $resIndexA->assertDontSee('ATP Rahasia Guru B');

        // Guru A mencoba mengakses show ATP Guru B -> Harus 403 Forbidden
        $resShowA = $this->actingAs($guruA)->get(route('atp.show', $atpB->id));
        $resShowA->assertStatus(403);

        // Superadmin mengakses daftar ATP -> Harus bisa melihat ATP Guru B
        $resIndexSuper = $this->actingAs($superadmin)->get(route('atp.index'));
        $resIndexSuper->assertStatus(200);
        $resIndexSuper->assertSee('ATP Rahasia Guru B');

        // Superadmin mengakses show ATP Guru B -> Harus 200 OK
        $resShowSuper = $this->actingAs($superadmin)->get(route('atp.show', $atpB->id));
        $resShowSuper->assertStatus(200);

        // Superadmin memberikan hak akses Guru B kepada Guru A
        $resGrant = $this->actingAs($superadmin)->post(route('users.device-access', $guruA->id), [
            'granted_user_ids' => [$guruB->id],
        ]);
        $resGrant->assertRedirect(route('users.index'));

        // Sekarang Guru A mengakses daftar ATP -> Harus bisa melihat ATP Guru B
        $resIndexAAfter = $this->actingAs($guruA)->get(route('atp.index'));
        $resIndexAAfter->assertStatus(200);
        $resIndexAAfter->assertSee('ATP Rahasia Guru B');

        // Guru A sekarang bisa membuka show ATP Guru B
        $resShowAAfter = $this->actingAs($guruA)->get(route('atp.show', $atpB->id));
        $resShowAAfter->assertStatus(200);
    }

    public function test_superadmin_can_filter_users_by_mapel_jurusan_and_sekolah(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $sekolah = SatuanPendidikan::firstOrCreate(
            ['npsn' => '77889900'],
            [
                'nama' => 'SMK Negeri 5 Khusus Filter',
                'jenjang' => 'SMK',
                'kota' => 'Kupang',
                'kepala_sekolah' => 'Drs. Filter',
                'nip_kepala_sekolah' => '197001011990011001',
            ]
        );

        $guruUnik = User::updateOrCreate(
            ['email' => 'guru_unik@smk.sch.id'],
            [
                'name' => 'Guru Ahli Robotika Unik',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'nip' => '8899112233',
                'mata_pelajaran_diampu' => 'Robotika dan Mekatronika Khusus',
                'jurusan' => 'Teknik Otomasi Industri Vokasi',
                'satuan_pendidikan_id' => $sekolah->id,
                'is_active' => true,
                'is_profile_completed' => true,
            ]
        );

        // 1. Filter berdasarkan Mata Pelajaran
        $resMapel = $this->actingAs($superadmin)->get(route('users.index', ['mapel' => 'Robotika']));
        $resMapel->assertStatus(200);
        $resMapel->assertSee('Guru Ahli Robotika Unik');

        // 2. Filter berdasarkan Jurusan
        $resJurusan = $this->actingAs($superadmin)->get(route('users.index', ['jurusan' => 'Teknik Otomasi Industri']));
        $resJurusan->assertStatus(200);
        $resJurusan->assertSee('Guru Ahli Robotika Unik');

        // 3. Filter berdasarkan Sekolah
        $resSekolah = $this->actingAs($superadmin)->get(route('users.index', ['satuan_pendidikan_id' => $sekolah->id]));
        $resSekolah->assertStatus(200);
        $resSekolah->assertSee('Guru Ahli Robotika Unik');
    }

    public function test_guest_can_export_pdf_and_documents_without_login(): void
    {
        $cp = CapaianPembelajaran::where('is_active', true)->first();
        $this->assertNotNull($cp);

        // Buat perangkat mode tamu langsung via GeneratorService
        $service = new GeneratorService();
        $guestSessionId = 'guest_test_' . uniqid();
        $result = $service->generateAll([
            'capaian_pembelajaran_id' => $cp->id,
            'guest_session_id' => $guestSessionId,
        ], null);

        $atp = $result['atp'];
        $modul = $result['modul_ajar'];
        $lkpd = $result['lkpd'];
        $prota = $result['prota'];
        $promes = $result['promes'];
        $asesmen = $result['asesmen'];

        $this->assertNull($atp->user_id);

        // Unduh PDF sebagai tamu (unauthenticated) dengan paper=a4 dan paper=f4
        $resAtpPdf = $this->get(route('export.atp.pdf', ['atp' => $atp->id, 'paper' => 'a4']));
        $resAtpPdf->assertStatus(200);
        $resAtpPdf->assertHeader('content-type', 'application/pdf');

        $resModulPdf = $this->get(route('export.modul-ajar.pdf', ['modulAjar' => $modul->id, 'paper' => 'f4']));
        $resModulPdf->assertStatus(200);
        $resModulPdf->assertHeader('content-type', 'application/pdf');

        $resLkpdPdf = $this->get(route('export.lkpd.pdf', ['lkpd' => $lkpd->id]));
        $resLkpdPdf->assertStatus(200);
        $resLkpdPdf->assertHeader('content-type', 'application/pdf');

        $resAsesmenPdf = $this->get(route('export.asesmen.pdf', ['asesmen' => $asesmen->id]));
        $resAsesmenPdf->assertStatus(200);
        $resAsesmenPdf->assertHeader('content-type', 'application/pdf');

        $resProtaPdf = $this->get(route('export.prota.pdf', ['prota' => $prota->id]));
        $resProtaPdf->assertStatus(200);
        $resProtaPdf->assertHeader('content-type', 'application/pdf');

        $resPromesPdf = $this->get(route('export.promes.pdf', ['promes' => $promes->id]));
        $resPromesPdf->assertStatus(200);
        $resPromesPdf->assertHeader('content-type', 'application/pdf');

        // Unduh Excel sebagai tamu
        $resAtpExcel = $this->get(route('export.atp.excel', $atp->id));
        $resAtpExcel->assertStatus(200);

        // Unduh Docx sebagai tamu
        $resAtpDocx = $this->get(route('export.atp.docx', $atp->id));
        $resAtpDocx->assertStatus(200);
    }
}
