<?php

namespace App\Http\Controllers;

use App\Models\AlurTujuanPembelajaran;
use App\Models\AtpDetail;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ProfilLulusan;
use App\Models\TahunAjaran;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtpController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = AlurTujuanPembelajaran::with(['mataPelajaran', 'fase', 'tahunAjaran', 'user', 'atpDetails']);

        $query = $user->applyDeviceAccessScope($query);

        $atps = $query->latest()->get();

        return view('atp.index', compact('atps'));
    }

    public function create()
    {
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $tahunAjarans = TahunAjaran::all();
        $tps = TujuanPembelajaran::where('user_id', Auth::id())->get();
        $profilLulusans = ProfilLulusan::orderBy('urutan')->get();

        return view('atp.create', compact('fases', 'mapels', 'tahunAjarans', 'tps', 'profilLulusans'));
    }

    public function store(Request $request)
    {
        if ($request->input('tahun_ajaran_mode') === 'manual' || $request->input('tahun_ajaran_id') === 'manual' || $request->filled('tahun_ajaran_manual')) {
            $namaTa = trim($request->input('tahun_ajaran_manual'));
            $semesterTa = (int) $request->input('semester_manual', 1);
            if (!empty($namaTa)) {
                $ta = TahunAjaran::firstOrCreate(
                    ['nama' => $namaTa, 'semester' => $semesterTa],
                    ['is_active' => false]
                );
                $request->merge(['tahun_ajaran_id' => $ta->id]);
            } else {
                $request->merge(['tahun_ajaran_id' => null]);
            }
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'details' => 'nullable|array',
        ]);

        $validated['user_id'] = Auth::id();

        DB::transaction(function () use ($validated, $request) {
            $atp = AlurTujuanPembelajaran::create($validated);

            if ($request->has('details') && is_array($request->details)) {
                foreach ($request->details as $index => $detail) {
                    if (!empty($detail['tujuan_pembelajaran_id'])) {
                        AtpDetail::create([
                            'atp_id' => $atp->id,
                            'tujuan_pembelajaran_id' => $detail['tujuan_pembelajaran_id'],
                            'urutan' => $index + 1,
                            'materi_topik' => $detail['materi_topik'] ?? null,
                            'kegiatan_pembelajaran' => $detail['kegiatan_pembelajaran'] ?? null,
                            'asesmen' => $detail['asesmen'] ?? null,
                            'alokasi_waktu_jp' => $detail['alokasi_waktu_jp'] ?? 12,
                            'dimensi_profil_lulusan' => isset($detail['dimensi_profil_lulusan']) && is_array($detail['dimensi_profil_lulusan']) 
                                ? implode(', ', $detail['dimensi_profil_lulusan']) 
                                : ($detail['dimensi_profil_lulusan'] ?? null),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('atp.index')->with('success', 'Alur Tujuan Pembelajaran (ATP) berhasil disimpan.');
    }

    public function show(AlurTujuanPembelajaran $atp)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($atp->user_id, $atp->guest_session_id) && !$atp->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat perangkat ajar ini.');
        }

        $atp->load(['mataPelajaran.programKeahlian', 'fase', 'tahunAjaran', 'user.satuanPendidikan', 'atpDetails.tujuanPembelajaran']);
        return view('atp.show', compact('atp'));
    }

    public function edit(AlurTujuanPembelajaran $atp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $atp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah perangkat ajar ini.');
        }

        $atp->load(['atpDetails.tujuanPembelajaran']);
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->get();
        $tahunAjarans = TahunAjaran::all();
        $tps = TujuanPembelajaran::where('user_id', Auth::id())->get();
        $profilLulusans = ProfilLulusan::orderBy('urutan')->get();

        return view('atp.edit', compact('atp', 'fases', 'mapels', 'tahunAjarans', 'tps', 'profilLulusans'));
    }

    public function update(Request $request, AlurTujuanPembelajaran $atp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $atp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah perangkat ajar ini.');
        }

        if ($request->input('tahun_ajaran_mode') === 'manual' || $request->input('tahun_ajaran_id') === 'manual' || $request->filled('tahun_ajaran_manual')) {
            $namaTa = trim($request->input('tahun_ajaran_manual'));
            $semesterTa = (int) $request->input('semester_manual', 1);
            if (!empty($namaTa)) {
                $ta = TahunAjaran::firstOrCreate(
                    ['nama' => $namaTa, 'semester' => $semesterTa],
                    ['is_active' => false]
                );
                $request->merge(['tahun_ajaran_id' => $ta->id]);
            } else {
                $request->merge(['tahun_ajaran_id' => null]);
            }
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'fase_id' => 'required|exists:fases,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $atp->update($validated);

        return redirect()->route('atp.show', $atp->id)->with('success', 'Alur Tujuan Pembelajaran berhasil diperbarui.');
    }

    public function destroy(AlurTujuanPembelajaran $atp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $atp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus perangkat ajar ini.');
        }

        $atp->delete();
        return redirect()->route('atp.index')->with('success', 'Alur Tujuan Pembelajaran berhasil dihapus.');
    }
}
