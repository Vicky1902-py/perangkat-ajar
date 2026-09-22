<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtaPromesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $protaQuery = ProgramTahunan::with(['mataPelajaran', 'fase', 'tahunAjaran', 'user']);
        $promesQuery = ProgramSemester::with(['mataPelajaran', 'fase', 'tahunAjaran', 'user']);

        $protaQuery = $user->applyDeviceAccessScope($protaQuery);
        $promesQuery = $user->applyDeviceAccessScope($promesQuery);

        $protas = $protaQuery->latest()->get();
        $promeses = $promesQuery->latest()->get();

        return view('prota-promes.index', compact('protas', 'promeses'));
    }

    public function showProta(ProgramTahunan $prota)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($prota->user_id, $prota->guest_session_id) && !$prota->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Program Tahunan ini.');
        }

        $prota->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        return view('prota-promes.show-prota', compact('prota'));
    }

    public function showPromes(ProgramSemester $promes)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($promes->user_id, $promes->guest_session_id) && !$promes->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Program Semester ini.');
        }

        $promes->load(['mataPelajaran', 'fase', 'tahunAjaran', 'user.satuanPendidikan']);
        return view('prota-promes.show-promes', compact('promes'));
    }
}
