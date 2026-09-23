<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\PaketSoal;
use App\Models\TujuanPembelajaran;
use App\Services\SoalExpertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaketSoalController extends Controller
{
    protected SoalExpertService $soalExpertService;

    public function __construct(SoalExpertService $soalExpertService)
    {
        $this->soalExpertService = $soalExpertService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PaketSoal::with(['mataPelajaran', 'fase', 'user', 'modulAjar']);

        if ($user) {
            $query = $user->applyDeviceAccessScope($query);
        } else {
            $sessionId = session()->getId();
            $query->where(function ($q) use ($sessionId) {
                $q->where('guest_session_id', $sessionId)
                  ->orWhere('is_shared', true);
            });
        }

        // Filter Bentuk Soal
        if ($request->filled('bentuk_soal')) {
            $query->where('bentuk_soal', $request->bentuk_soal);
        }

        // Filter Mapel
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        // Search Keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('mataPelajaran', fn($m) => $m->where('nama', 'like', "%{$search}%"));
            });
        }

        $paketSoals = $query->latest()->paginate(10)->withQueryString();
        $mapels = MataPelajaran::where('is_active', true)->orderBy('nama')->get();

        return view('soal.index', compact('paketSoals', 'mapels'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $fases = Fase::all();
        $mapels = MataPelajaran::where('is_active', true)->orderBy('kelompok')->orderBy('nama')->get();

        // Ambil daftar modul ajar yang dapat dijadikan sumber
        $modulQuery = ModulAjar::with(['mataPelajaran', 'fase']);
        if ($user) {
            $modulQuery = $user->applyDeviceAccessScope($modulQuery);
        } else {
            $sessionId = session()->getId();
            $modulQuery->where(function ($q) use ($sessionId) {
                $q->where('guest_session_id', $sessionId)
                  ->orWhere('is_shared', true);
            });
        }
        $modulAjars = $modulQuery->latest()->get();

        // Cek jika ada modul_id dari parameter url
        $selectedModul = null;
        if ($request->filled('modul_id')) {
            $selectedModul = ModulAjar::with(['mataPelajaran', 'fase', 'tujuanPembelajaran'])->find($request->modul_id);
        }

        return view('soal.create', compact('fases', 'mapels', 'modulAjars', 'selectedModul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id'   => 'required|exists:mata_pelajarans,id',
            'fase_id'             => 'required|exists:fases,id',
            'bentuk_soal'         => 'required|in:pg,isian,campuran',
            'jenis_ujian'         => 'required|string|max:50',
            'total_soal_pg'       => 'nullable|integer|min:0|max:50',
            'total_soal_isian'    => 'nullable|integer|min:0|max:20',
            'alokasi_waktu_menit' => 'required|integer|min:15|max:240',
            'modul_ajar_id'       => 'nullable|exists:modul_ajars,id',
            'tujuan_pembelajaran_id' => 'nullable|exists:tujuan_pembelajarans,id',
            'judul'               => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();
        $sessionId = !Auth::check() ? session()->getId() : null;

        $params = [
            'user_id' => $userId,
            'guest_session_id' => $sessionId,
            'modul_ajar_id' => $request->modul_ajar_id,
            'tujuan_pembelajaran_id' => $request->tujuan_pembelajaran_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'fase_id' => $request->fase_id,
            'judul' => $request->judul,
            'jenis_ujian' => $request->jenis_ujian,
            'bentuk_soal' => $request->bentuk_soal,
            'total_soal_pg' => (int) $request->input('total_soal_pg', 10),
            'total_soal_isian' => (int) $request->input('total_soal_isian', 5),
            'alokasi_waktu_menit' => (int) $request->input('alokasi_waktu_menit', 60),
        ];

        $paketSoal = $this->soalExpertService->generatePaketSoal($params);

        return redirect()->route('paket-soal.show', $paketSoal->id)
            ->with('success', 'Paket Soal dan Kisi-Kisi Ujian berhasil disusun oleh Sistem Pakar (Zero Hallucination)!');
    }

    public function show(PaketSoal $paketSoal)
    {
        $user = Auth::user();
        if ($user) {
            if (!$user->canAccessDeviceOf($paketSoal->user_id, $paketSoal->guest_session_id) && !$paketSoal->is_shared) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat naskah soal ini.');
            }
        } else {
            $sessionId = session()->getId();
            if ($paketSoal->user_id !== null && $paketSoal->guest_session_id !== $sessionId && !$paketSoal->is_shared) {
                abort(403, 'Silakan login terlebih dahulu untuk mengakses naskah soal ini.');
            }
        }

        $paketSoal->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'tujuanPembelajaran']);

        return view('soal.show', compact('paketSoal'));
    }

    public function update(Request $request, PaketSoal $paketSoal)
    {
        $user = Auth::user();
        if ($user && !$user->canAccessDeviceOf($paketSoal->user_id, $paketSoal->guest_session_id)) {
            abort(403, 'Anda tidak berwenang memperbarui paket soal ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'petunjuk_umum' => 'nullable|string',
            'alokasi_waktu_menit' => 'required|integer|min:10|max:300',
        ]);

        $paketSoal->update([
            'judul' => $request->judul,
            'petunjuk_umum' => $request->petunjuk_umum,
            'alokasi_waktu_menit' => $request->alokasi_waktu_menit,
        ]);

        return redirect()->back()->with('success', 'Informasi naskah soal berhasil diperbarui.');
    }

    public function destroy(PaketSoal $paketSoal)
    {
        $user = Auth::user();
        if ($user && !$user->canAccessDeviceOf($paketSoal->user_id, $paketSoal->guest_session_id) && $user->role !== 'superadmin') {
            abort(403, 'Anda tidak berwenang menghapus paket soal ini.');
        }

        $paketSoal->delete();

        return redirect()->route('paket-soal.index')
            ->with('success', 'Paket soal berhasil dihapus dari sistem.');
    }
}
