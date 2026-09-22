<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use App\Models\Fase;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Asesmen::with(['mataPelajaran', 'fase', 'user', 'modulAjar']);

        $query = $user->applyDeviceAccessScope($query);

        $asesmens = $query->latest()->get();

        return view('asesmen.index', compact('asesmens'));
    }

    public function show(Asesmen $asesmen)
    {
        $user = Auth::user();
        if (!$user->canAccessDeviceOf($asesmen->user_id, $asesmen->guest_session_id) && !$asesmen->is_shared) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat instrumen asesmen ini.');
        }

        $asesmen->load(['mataPelajaran.programKeahlian', 'fase', 'user.satuanPendidikan', 'modulAjar', 'tujuanPembelajaran']);
        return view('asesmen.show', compact('asesmen'));
    }
}
