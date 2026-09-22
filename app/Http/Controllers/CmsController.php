<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ProfilLulusan;
use App\Models\ProgramKeahlian;
use App\Models\SatuanPendidikan;
use App\Models\TahunAjaran;
use App\Models\TemplatePedatti;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    // ================= CAPAIAN PEMBELAJARAN (CP) =================
    public function cpIndex()
    {
        $cps = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->latest()->get();
        return view('cms.cp.index', compact('cps'));
    }

    public function cpCreate()
    {
        $mapels = MataPelajaran::where('is_active', true)->get();
        $fases = Fase::all();
        return view('cms.cp.create', compact('mapels', 'fases'));
    }

    public function cpStore(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'deskripsi_cp' => 'required|string',
            'elemen_cp' => 'nullable|string',
        ]);

        // Convert key-value textarea to json if entered
        $elemenArr = [];
        if (!empty($request->elemen_names) && is_array($request->elemen_names)) {
            foreach ($request->elemen_names as $i => $name) {
                if (!empty($name)) {
                    $elemenArr[$name] = $request->elemen_descs[$i] ?? '';
                }
            }
        }

        $validated['elemen_cp'] = !empty($elemenArr) ? json_encode($elemenArr) : null;
        $validated['is_active'] = true;

        CapaianPembelajaran::create($validated);

        return redirect()->route('cms.cp.index')->with('success', 'Capaian Pembelajaran (CP) berhasil ditambahkan.');
    }

    public function cpEdit(CapaianPembelajaran $cp)
    {
        $mapels = MataPelajaran::where('is_active', true)->get();
        $fases = Fase::all();
        $elemenArr = json_decode($cp->elemen_cp, true) ?? [];
        return view('cms.cp.edit', compact('cp', 'mapels', 'fases', 'elemenArr'));
    }

    public function cpUpdate(Request $request, CapaianPembelajaran $cp)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'deskripsi_cp' => 'required|string',
        ]);

        $elemenArr = [];
        if (!empty($request->elemen_names) && is_array($request->elemen_names)) {
            foreach ($request->elemen_names as $i => $name) {
                if (!empty($name)) {
                    $elemenArr[$name] = $request->elemen_descs[$i] ?? '';
                }
            }
        }

        $validated['elemen_cp'] = !empty($elemenArr) ? json_encode($elemenArr) : null;

        $cp->update($validated);

        return redirect()->route('cms.cp.index')->with('success', 'Capaian Pembelajaran berhasil diperbarui.');
    }

    public function cpDestroy(CapaianPembelajaran $cp)
    {
        $cp->delete();
        return redirect()->route('cms.cp.index')->with('success', 'Capaian Pembelajaran berhasil dihapus.');
    }

    // ================= MATA PELAJARAN =================
    public function mapelIndex()
    {
        $mapels = MataPelajaran::with('programKeahlian.bidangKeahlian')->orderBy('kelompok')->orderBy('nama')->get();
        return view('cms.mapel.index', compact('mapels'));
    }

    public function mapelCreate()
    {
        $programs = ProgramKeahlian::where('is_active', true)->get();
        return view('cms.mapel.create', compact('programs'));
    }

    public function mapelStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:umum,kejuruan',
            'program_keahlian_id' => 'nullable|exists:program_keahlians,id',
            'jam_pelajaran_per_minggu' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['is_active'] = true;
        MataPelajaran::create($validated);

        return redirect()->route('cms.mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function mapelEdit(MataPelajaran $mapel)
    {
        $programs = ProgramKeahlian::where('is_active', true)->get();
        return view('cms.mapel.edit', compact('mapel', 'programs'));
    }

    public function mapelUpdate(Request $request, MataPelajaran $mapel)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:umum,kejuruan',
            'program_keahlian_id' => 'nullable|exists:program_keahlians,id',
            'jam_pelajaran_per_minggu' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $mapel->update($validated);

        return redirect()->route('cms.mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function mapelDestroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('cms.mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    // ================= BIDANG & PROGRAM KEAHLIAN SMK =================
    public function kejuruanIndex()
    {
        $bidangs = BidangKeahlian::with('programKeahlians')->get();
        return view('cms.kejuruan.index', compact('bidangs'));
    }

    // ================= PROFIL LULUSAN (8 DIMENSI) =================
    public function profilLulusanIndex()
    {
        $profils = ProfilLulusan::orderBy('urutan')->get();
        return view('cms.profil-lulusan.index', compact('profils'));
    }

    public function profilLulusanUpdate(Request $request, ProfilLulusan $profilLulusan)
    {
        $validated = $request->validate([
            'deskripsi' => 'required|string',
        ]);

        $profilLulusan->update($validated);

        return back()->with('success', 'Deskripsi dimensi profil lulusan berhasil diperbarui.');
    }

    // ================= TEMPLATE PEDATTI =================
    public function templatePedattiIndex()
    {
        $templates = TemplatePedatti::all();
        return view('cms.template-pedatti.index', compact('templates'));
    }

    public function templatePedattiUpdate(Request $request, TemplatePedatti $template)
    {
        $validated = $request->validate([
            'template_kegiatan' => 'required|string',
            'prinsip_deep_learning' => 'nullable|string',
            'olah' => 'nullable|string',
            'durasi_default_menit' => 'nullable|integer',
            'contoh_pertanyaan' => 'nullable|string',
        ]);

        $template->update($validated);

        return back()->with('success', 'Template tahap ' . ucfirst($template->tahap) . ' berhasil diperbarui.');
    }

    // ================= TAHUN AJARAN =================
    public function tahunAjaranIndex()
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->orderBy('semester', 'asc')->get();
        return view('cms.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function tahunAjaranStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama Tahun Ajaran wajib diisi (misal: 2026/2027).',
            'semester.required' => 'Semester wajib dipilih (1 atau 2).',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        $isActive = $request->boolean('is_active');

        if ($isActive) {
            TahunAjaran::query()->update(['is_active' => false]);
        }

        $tahunAjaran = TahunAjaran::updateOrCreate(
            ['nama' => trim($validated['nama']), 'semester' => (int) $validated['semester']],
            [
                'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
                'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
                'is_active' => $isActive,
            ]
        );

        return back()->with('success', 'Tahun Ajaran ' . $tahunAjaran->nama . ' Semester ' . $tahunAjaran->semester . ' berhasil ditambahkan.');
    }

    public function tahunAjaranUpdate(Request $request, TahunAjaran $tahunAjaran)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'nullable|boolean',
        ]);

        $isActive = $request->boolean('is_active');

        if ($isActive) {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)->update(['is_active' => false]);
        }

        $tahunAjaran->update([
            'nama' => trim($validated['nama']),
            'semester' => (int) $validated['semester'],
            'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
            'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            'is_active' => $isActive ? true : $tahunAjaran->is_active,
        ]);

        return back()->with('success', 'Data Tahun Ajaran ' . $tahunAjaran->nama . ' berhasil diperbarui.');
    }

    public function tahunAjaranDestroy(TahunAjaran $tahunAjaran)
    {
        // Cek jika sedang aktif dan menjadi satu-satunya
        if ($tahunAjaran->is_active && TahunAjaran::count() > 1) {
            // Aktifkan tahun ajaran lain sebelum menghapus
            $anotherTa = TahunAjaran::where('id', '!=', $tahunAjaran->id)->first();
            if ($anotherTa) {
                $anotherTa->update(['is_active' => true]);
            }
        }

        $nama = $tahunAjaran->nama . ' Semester ' . $tahunAjaran->semester;
        $tahunAjaran->delete();

        return back()->with('success', 'Tahun Ajaran ' . $nama . ' berhasil dihapus.');
    }

    public function tahunAjaranSetActive(TahunAjaran $tahunAjaran)
    {
        TahunAjaran::query()->update(['is_active' => false]);
        $tahunAjaran->update(['is_active' => true]);

        return back()->with('success', 'Tahun ajaran aktif berhasil diubah menjadi ' . $tahunAjaran->nama . ' Semester ' . $tahunAjaran->semester . '.');
    }

    public function tahunAjaranQuickGenerate(Request $request)
    {
        $quickList = [
            [
                'nama' => '2026/2027',
                'semester' => 1,
                'tanggal_mulai' => '2026-07-13',
                'tanggal_selesai' => '2026-12-18',
                'is_active' => true,
            ],
            [
                'nama' => '2026/2027',
                'semester' => 2,
                'tanggal_mulai' => '2027-01-04',
                'tanggal_selesai' => '2027-06-18',
                'is_active' => false,
            ],
            [
                'nama' => '2027/2028',
                'semester' => 1,
                'tanggal_mulai' => '2027-07-12',
                'tanggal_selesai' => '2027-12-17',
                'is_active' => false,
            ],
            [
                'nama' => '2027/2028',
                'semester' => 2,
                'tanggal_mulai' => '2028-01-03',
                'tanggal_selesai' => '2028-06-16',
                'is_active' => false,
            ],
        ];

        TahunAjaran::query()->update(['is_active' => false]);

        foreach ($quickList as $item) {
            TahunAjaran::updateOrCreate(
                ['nama' => $item['nama'], 'semester' => $item['semester']],
                $item
            );
        }

        return back()->with('success', '✨ Berhasil! Tahun Ajaran 2026/2027 & 2027/2028 (Ganjil & Genap) telah ditambahkan dan 2026/2027 Ganjil telah diaktifkan.');
    }

    // ================= SATUAN PENDIDIKAN (SEKOLAH) =================
    public function sekolahIndex()
    {
        $sekolahs = SatuanPendidikan::all();
        return view('cms.sekolah.index', compact('sekolahs'));
    }

    public function sekolahUpdate(Request $request, SatuanPendidikan $sekolah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'kepala_sekolah' => 'nullable|string|max:255',
        ]);

        $sekolah->update($validated);

        return back()->with('success', 'Data satuan pendidikan berhasil diperbarui.');
    }
}
