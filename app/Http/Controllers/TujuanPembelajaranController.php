<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TujuanPembelajaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = TujuanPembelajaran::with(['capaianPembelajaran.mataPelajaran', 'capaianPembelajaran.fase', 'user']);

        $query = $user->applyDeviceAccessScope($query);

        $tps = $query->latest()->get();

        return view('tp.index', compact('tps'));
    }

    public function create()
    {
        $cps = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->where('is_active', true)->get();
        return view('tp.create', compact('cps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'capaian_pembelajaran_id' => 'required|exists:capaian_pembelajarans,id',
            'kode_tp' => 'required|string|max:20',
            'deskripsi_tp' => 'required|string',
            'konten_pengetahuan' => 'nullable|string',
            'keterampilan' => 'nullable|string',
            'sikap' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['urutan'] = $validated['urutan'] ?? 1;

        TujuanPembelajaran::create($validated);

        return redirect()->route('tp.index')->with('success', 'Tujuan Pembelajaran (TP) berhasil ditambahkan.');
    }

    public function show(TujuanPembelajaran $tp)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($tp->user_id, $tp->guest_session_id) && !$tp->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Tujuan Pembelajaran ini.');
        }

        $tp->load(['capaianPembelajaran.mataPelajaran', 'capaianPembelajaran.fase', 'user']);
        return view('tp.show', compact('tp'));
    }

    public function edit(TujuanPembelajaran $tp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $tp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah Tujuan Pembelajaran ini.');
        }

        $cps = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->where('is_active', true)->get();
        return view('tp.edit', compact('tp', 'cps'));
    }

    public function update(Request $request, TujuanPembelajaran $tp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $tp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah Tujuan Pembelajaran ini.');
        }

        $validated = $request->validate([
            'capaian_pembelajaran_id' => 'required|exists:capaian_pembelajarans,id',
            'kode_tp' => 'required|string|max:20',
            'deskripsi_tp' => 'required|string',
            'konten_pengetahuan' => 'nullable|string',
            'keterampilan' => 'nullable|string',
            'sikap' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $tp->update($validated);

        return redirect()->route('tp.index')->with('success', 'Tujuan Pembelajaran berhasil diperbarui.');
    }

    public function destroy(TujuanPembelajaran $tp)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $tp->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus Tujuan Pembelajaran ini.');
        }

        $tp->delete();
        return redirect()->route('tp.index')->with('success', 'Tujuan Pembelajaran berhasil dihapus.');
    }
}
