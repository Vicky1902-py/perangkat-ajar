<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\ModulAjarKegiatan;
use App\Models\ProfilLulusan;
use App\Models\TahunAjaran;
use App\Models\TemplatePedatti;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModulAjarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = ModulAjar::with(['mataPelajaran', 'fase', 'tahunAjaran', 'user', 'tujuanPembelajaran']);

        $query = $user->applyDeviceAccessScope($query);

        $moduls = $query->latest()->get();

        return view('modul-ajar.index', compact('moduls'));
    }

    public function create()
    {
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $tahunAjarans = TahunAjaran::all();
        $tps = TujuanPembelajaran::where('user_id', Auth::id())->get();
        $profilLulusans = ProfilLulusan::orderBy('urutan')->get();
        $templatesPedatti = TemplatePedatti::where('is_active', true)->get();

        return view('modul-ajar.create', compact('fases', 'mapels', 'tahunAjarans', 'tps', 'profilLulusans', 'templatesPedatti'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
            'tujuan_pembelajaran_id' => 'nullable|exists:tujuan_pembelajarans,id',
            'judul' => 'required|string|max:255',
            'kompetensi_awal' => 'nullable|string',
            'profil_lulusan_target' => 'nullable|string',
            'sarana_prasarana' => 'nullable|string',
            'target_peserta_didik' => 'nullable|string',
            'pemahaman_bermakna' => 'nullable|string',
            'pertanyaan_pemantik' => 'nullable|string',
            'asesmen_awal' => 'nullable|string',
            'asesmen_formatif' => 'nullable|string',
            'asesmen_sumatif' => 'nullable|string',
            'refleksi_guru' => 'nullable|string',
            'refleksi_siswa' => 'nullable|string',
            'pengayaan' => 'nullable|string',
            'remedial' => 'nullable|string',
            'bahan_ajar' => 'nullable|string',
            'glosarium' => 'nullable|string',
            'daftar_pustaka' => 'nullable|string',
            'alokasi_waktu_jp' => 'nullable|integer',
            'jumlah_pertemuan' => 'nullable|integer',
            'profil_lulusan_ids' => 'nullable|array',
            'kegiatans' => 'nullable|array',
        ]);

        $validated['user_id'] = Auth::id();

        DB::transaction(function () use ($validated, $request) {
            $modul = ModulAjar::create($validated);

            if (!empty($validated['profil_lulusan_ids'])) {
                $modul->profilLulusans()->sync($validated['profil_lulusan_ids']);
            }

            if (!empty($validated['kegiatans'])) {
                foreach ($validated['kegiatans'] as $tahap => $keg) {
                    ModulAjarKegiatan::create([
                        'modul_ajar_id' => $modul->id,
                        'tahap_pedatti' => $tahap,
                        'deskripsi_kegiatan' => $keg['deskripsi'] ?? '-',
                        'durasi_menit' => $keg['durasi'] ?? 30,
                        'prinsip_deep_learning' => $keg['prinsip'] ?? 'Mindful & Meaningful',
                        'olah' => $keg['olah'] ?? 'Olah Pikir',
                        'urutan' => $keg['urutan'] ?? 1,
                    ]);
                }
            }
        });

        return redirect()->route('modul-ajar.index')->with('success', 'Modul Ajar Deep Learning berhasil disimpan.');
    }

    public function show(ModulAjar $modulAjar)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($modulAjar->user_id, $modulAjar->guest_session_id) && !$modulAjar->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat modul ajar ini.');
        }

        $modulAjar->load([
            'mataPelajaran.programKeahlian',
            'fase',
            'tahunAjaran',
            'user.satuanPendidikan',
            'tujuanPembelajaran',
            'kegiatans',
            'profilLulusans',
            'lkpds',
            'asesmens'
        ]);

        return view('modul-ajar.show', compact('modulAjar'));
    }

    public function edit(ModulAjar $modulAjar)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $modulAjar->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah modul ajar ini.');
        }

        $modulAjar->load(['kegiatans', 'profilLulusans']);
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $tahunAjarans = TahunAjaran::all();
        $tps = TujuanPembelajaran::where('user_id', Auth::id())->get();
        $profilLulusans = ProfilLulusan::orderBy('urutan')->get();

        return view('modul-ajar.edit', compact('modulAjar', 'fases', 'mapels', 'tahunAjarans', 'tps', 'profilLulusans'));
    }

    public function update(Request $request, ModulAjar $modulAjar)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $modulAjar->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah modul ajar ini.');
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
            'tujuan_pembelajaran_id' => 'nullable|exists:tujuan_pembelajarans,id',
            'judul' => 'required|string|max:255',
            'kompetensi_awal' => 'nullable|string',
            'profil_lulusan_target' => 'nullable|string',
            'sarana_prasarana' => 'nullable|string',
            'target_peserta_didik' => 'nullable|string',
            'pemahaman_bermakna' => 'nullable|string',
            'pertanyaan_pemantik' => 'nullable|string',
            'asesmen_awal' => 'nullable|string',
            'asesmen_formatif' => 'nullable|string',
            'asesmen_sumatif' => 'nullable|string',
            'refleksi_guru' => 'nullable|string',
            'refleksi_siswa' => 'nullable|string',
            'pengayaan' => 'nullable|string',
            'remedial' => 'nullable|string',
            'bahan_ajar' => 'nullable|string',
            'glosarium' => 'nullable|string',
            'daftar_pustaka' => 'nullable|string',
            'alokasi_waktu_jp' => 'nullable|integer',
            'jumlah_pertemuan' => 'nullable|integer',
        ]);

        $modulAjar->update($validated);

        if ($request->has('profil_lulusan_ids')) {
            $modulAjar->profilLulusans()->sync($request->profil_lulusan_ids);
        }

        return redirect()->route('modul-ajar.show', $modulAjar->id)->with('success', 'Modul Ajar berhasil diperbarui.');
    }

    public function destroy(ModulAjar $modulAjar)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $modulAjar->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus modul ajar ini.');
        }

        $modulAjar->delete();
        return redirect()->route('modul-ajar.index')->with('success', 'Modul Ajar berhasil dihapus.');
    }
}
