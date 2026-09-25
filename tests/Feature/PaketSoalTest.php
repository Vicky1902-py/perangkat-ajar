<?php

namespace Tests\Feature;

use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\PaketSoal;
use App\Models\User;
use Tests\TestCase;

class PaketSoalTest extends TestCase
{
    protected $guru;
    protected $mapel;
    protected $fase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guru = User::where('role', 'guru')->first() ?? User::first();
        $this->mapel = MataPelajaran::first();
        $this->fase = Fase::first();
    }

    public function test_guest_is_redirected_from_smart_soal_index(): void
    {
        $response = $this->get(route('paket-soal.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guru_can_access_smart_soal_index_and_welcome_modal(): void
    {
        $response = $this->actingAs($this->guru)->get(route('paket-soal.index'));
        $response->assertStatus(200);
        $response->assertSee('Smart Soal');
        $response->assertSee('Selamat Datang di Smart Soal by. Vicky');
    }

    public function test_guru_can_access_smart_soal_create_page(): void
    {
        $response = $this->actingAs($this->guru)->get(route('paket-soal.create'));
        $response->assertStatus(200);
        $response->assertSee('Generator Kisi-Kisi');
        $response->assertSee('Sistem Pakar');
    }

    public function test_expert_system_generates_campuran_questions_and_blueprint(): void
    {
        $response = $this->actingAs($this->guru)->post(route('paket-soal.store'), [
            'judul' => 'Penilaian Harian Teori & Praktik Kejuruan',
            'mata_pelajaran_id' => $this->mapel->id,
            'fase_id' => $this->fase->id,
            'bentuk_soal' => 'campuran',
            'jenis_ujian' => 'sumatif_lingkup_materi',
            'total_soal_pg' => 5,
            'total_soal_isian' => 3,
            'tingkat_kesulitan' => 'sedang',
            'topik_materi' => 'Algoritma Pemrograman dan Troubleshooting Jaringan Komputer',
            'alokasi_waktu_menit' => 90,
        ]);

        $this->assertDatabaseHas('paket_soals', [
            'judul' => 'Penilaian Harian Teori & Praktik Kejuruan',
            'bentuk_soal' => 'campuran',
            'total_soal_pg' => 5,
            'total_soal_isian' => 3,
            'user_id' => $this->guru->id,
        ]);

        $paket = PaketSoal::where('judul', 'Penilaian Harian Teori & Praktik Kejuruan')->latest('id')->first();
        $this->assertNotNull($paket);
        $this->assertNotEmpty($paket->kisi_kisi_data);
        $this->assertCount(5, $paket->butir_soal_pg);
        $this->assertCount(3, $paket->butir_soal_isian);

        $response->assertRedirect(route('paket-soal.show', $paket->id));
        $response->assertSessionHas('success');
    }

    public function test_show_smart_soal_displays_tabs_and_data(): void
    {
        $paket = PaketSoal::create([
            'user_id' => $this->guru->id,
            'mata_pelajaran_id' => $this->mapel->id,
            'fase_id' => $this->fase->id,
            'judul' => 'Soal Uji Coba Unit Test',
            'bentuk_soal' => 'pg',
            'total_soal_pg' => 2,
            'total_soal_isian' => 0,
            'alokasi_waktu_menit' => 60,
            'kisi_kisi_data' => [
                [
                    'nomor_urut' => 1,
                    'bentuk_soal' => 'PG',
                    'materi' => 'Testing Dasar',
                    'indikator_soal' => 'Disajikan kasus, murid mampu menganalisis solusi.',
                    'level_kognitif' => 'L3 (C4 - Menganalisis)',
                    'deep_learning' => 'Mindful (Sadar)',
                ]
            ],
            'butir_soal_pg' => [
                [
                    'nomor' => 1,
                    'stimulus' => 'Sebuah sistem mengalami kendala konektivitas.',
                    'pertanyaan' => 'Langkah verifikasi awal apa yang paling tepat dilakukan?',
                    'pilihan' => [
                        'A' => 'Memeriksa konfigurasi IP dan gateway',
                        'B' => 'Mengganti seluruh kabel',
                        'C' => 'Mematikan komputer',
                        'D' => 'Menghapus sistem operasi',
                        'E' => 'Memformat harddisk',
                    ],
                    'kunci_jawaban' => 'A',
                    'pembahasan' => 'Pemeriksaan IP dan gateway adalah langkah verifikasi diagnostik pertama.',
                    'level_kognitif' => 'L3',
                    'deep_learning' => 'Mindful',
                ]
            ],
            'butir_soal_isian' => [],
        ]);

        $response = $this->actingAs($this->guru)->get(route('paket-soal.show', $paket->id));
        $response->assertStatus(200);
        $response->assertSee('Soal Uji Coba Unit Test');
        $response->assertSee('Tabel Kisi-Kisi Resmi Kemendikdasmen');
        $response->assertSee('Naskah Lembar Soal Siswa');
        $response->assertSee('Kunci Jawaban, Pembahasan');
        $response->assertSee('Sebuah sistem mengalami kendala konektivitas.');
    }

    public function test_export_pdf_student_and_teacher_version(): void
    {
        $paket = PaketSoal::create([
            'user_id' => $this->guru->id,
            'mata_pelajaran_id' => $this->mapel->id,
            'fase_id' => $this->fase->id,
            'judul' => 'Paket Ujian Ekspor PDF',
            'bentuk_soal' => 'campuran',
            'total_soal_pg' => 1,
            'total_soal_isian' => 1,
            'alokasi_waktu_menit' => 45,
            'kisi_kisi_data' => [
                [
                    'nomor_urut' => 1,
                    'bentuk_soal' => 'PG',
                    'materi' => 'Materi Uji',
                    'indikator_soal' => 'Indikator uji ekspor.',
                    'level_kognitif' => 'L2',
                    'deep_learning' => 'Meaningful',
                ]
            ],
            'butir_soal_pg' => [
                [
                    'nomor' => 1,
                    'stimulus' => '',
                    'pertanyaan' => 'Pertanyaan uji coba?',
                    'pilihan' => ['A' => 'Opsi A', 'B' => 'Opsi B', 'C' => 'Opsi C', 'D' => 'Opsi D', 'E' => 'Opsi E'],
                    'kunci_jawaban' => 'A',
                    'pembahasan' => 'Pembahasan kunci.',
                    'level_kognitif' => 'L2',
                    'deep_learning' => 'Meaningful',
                ]
            ],
            'butir_soal_isian' => [
                [
                    'nomor' => 1,
                    'stimulus' => '',
                    'pertanyaan' => 'Jelaskan konsep berikut!',
                    'rubrik' => 'Rubrik penilaian...',
                    'pedoman_penskoran' => 'Skor 10 jika lengkap.',
                    'skor_maksimal' => 10,
                    'level_kognitif' => 'L2',
                    'deep_learning' => 'Meaningful',
                ]
            ],
        ]);

        // 1. Ekspor Lembar Siswa (Tanpa Kunci)
        $resSiswa = $this->actingAs($this->guru)->get(route('export.soal.siswa.pdf', $paket->id));
        $resSiswa->assertStatus(200);
        $this->assertEquals('application/pdf', $resSiswa->headers->get('Content-Type'));

        // 2. Ekspor Pegangan Guru (Dengan Kisi-kisi & Kunci)
        $resGuru = $this->actingAs($this->guru)->get(route('export.soal.guru.pdf', $paket->id));
        $resGuru->assertStatus(200);
        $this->assertEquals('application/pdf', $resGuru->headers->get('Content-Type'));
    }

    public function test_superadmin_can_bulk_delete_paket_soal(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        if (!$superadmin) {
            $this->markTestSkipped('Superadmin user not found.');
        }

        $paket = PaketSoal::create([
            'user_id' => $this->guru->id,
            'mata_pelajaran_id' => $this->mapel->id,
            'fase_id' => $this->fase->id,
            'judul' => 'Paket Soal to Delete',
            'bentuk_soal' => 'pg',
            'total_soal_pg' => 1,
            'total_soal_isian' => 0,
            'kisi_kisi_data' => [],
            'butir_soal_pg' => [],
            'butir_soal_isian' => [],
        ]);

        $this->assertDatabaseHas('paket_soals', ['id' => $paket->id]);

        $res = $this->actingAs($superadmin)->post(route('cms.perangkat.bulk-delete'), [
            'items' => ["paket_soal:{$paket->id}"],
        ]);

        $res->assertRedirect();
        $res->assertSessionHas('success');
        $this->assertDatabaseMissing('paket_soals', ['id' => $paket->id]);
    }
}
