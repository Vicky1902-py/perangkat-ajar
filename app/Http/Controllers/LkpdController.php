<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\Lkpd;
use App\Models\LkpdKegiatan;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LkpdController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Lkpd::with(['mataPelajaran', 'fase', 'user', 'modulAjar']);

        $query = $user->applyDeviceAccessScope($query);

        $lkpds = $query->latest()->get();

        return view('lkpd.index', compact('lkpds'));
    }

    public function create()
    {
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $moduls = ModulAjar::where('user_id', Auth::id())->get();

        return view('lkpd.create', compact('fases', 'mapels', 'moduls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'modul_ajar_id' => 'nullable|exists:modul_ajars,id',
            'judul' => 'required|string|max:255',
            'tujuan_pembelajaran' => 'nullable|string',
            'stimulus_otentik' => 'nullable|string',
            'petunjuk_belajar' => 'nullable|string',
            'alat_bahan' => 'nullable|string',
            'rubrik_penilaian' => 'nullable|string',
            'alokasi_waktu_menit' => 'nullable|integer',
            'kegiatans' => 'nullable|array',
        ]);

        $validated['user_id'] = Auth::id();

        DB::transaction(function () use ($validated) {
            $lkpd = Lkpd::create($validated);

            if (!empty($validated['kegiatans'])) {
                foreach ($validated['kegiatans'] as $tahap => $keg) {
                    LkpdKegiatan::create([
                        'lkpd_id' => $lkpd->id,
                        'tahap' => $tahap,
                        'instruksi' => $keg['instruksi'] ?? '-',
                        'pertanyaan' => $keg['pertanyaan'] ?? null,
                        'ruang_jawaban' => $keg['ruang_jawaban'] ?? '[Ruang Jawaban]',
                        'urutan' => $keg['urutan'] ?? 1,
                    ]);
                }
            }
        });

        return redirect()->route('lkpd.index')->with('success', 'Lembar Kerja Peserta Didik (LKPD) berhasil disimpan.');
    }

    public function show(Lkpd $lkpd)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($lkpd->user_id, $lkpd->guest_session_id) && !$lkpd->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat LKPD ini.');
        }

        $lkpd->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'kegiatans']);
        return view('lkpd.show', compact('lkpd'));
    }

    public function edit(Lkpd $lkpd)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $lkpd->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah LKPD ini.');
        }

        $lkpd->load(['kegiatans']);
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $moduls = ModulAjar::where('user_id', Auth::id())->get();

        return view('lkpd.edit', compact('lkpd', 'fases', 'mapels', 'moduls'));
    }

    public function update(Request $request, Lkpd $lkpd)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $lkpd->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah LKPD ini.');
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'modul_ajar_id' => 'nullable|exists:modul_ajars,id',
            'judul' => 'required|string|max:255',
            'tujuan_pembelajaran' => 'nullable|string',
            'stimulus_otentik' => 'nullable|string',
            'petunjuk_belajar' => 'nullable|string',
            'alat_bahan' => 'nullable|string',
            'rubrik_penilaian' => 'nullable|string',
            'alokasi_waktu_menit' => 'nullable|integer',
        ]);

        $lkpd->update($validated);

        return redirect()->route('lkpd.show', $lkpd->id)->with('success', 'LKPD berhasil diperbarui.');
    }

    public function destroy(Lkpd $lkpd)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $lkpd->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus LKPD ini.');
        }

        $lkpd->delete();
        return redirect()->route('lkpd.index')->with('success', 'LKPD berhasil dihapus.');
    }
}
