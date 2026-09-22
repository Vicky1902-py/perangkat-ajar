<?php

namespace App\Http\Controllers;

use App\Models\AlurTujuanPembelajaran;
use App\Models\CapaianPembelajaran;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Query dengan cakupan hak akses perangkat (Superadmin lihat semua, Guru lihat miliknya/yang diizinkan)
        $tpQuery = $user->applyDeviceAccessScope(TujuanPembelajaran::query());
        $atpQuery = $user->applyDeviceAccessScope(AlurTujuanPembelajaran::query());
        $modulQuery = $user->applyDeviceAccessScope(ModulAjar::query());
        $lkpdQuery = $user->applyDeviceAccessScope(Lkpd::query());

        $stats = [
            'total_tp' => $tpQuery->count(),
            'total_atp' => $atpQuery->count(),
            'total_modul' => $modulQuery->count(),
            'total_lkpd' => $lkpdQuery->count(),
            'total_mapel' => MataPelajaran::count(),
            'total_cp' => CapaianPembelajaran::count(),
            'total_guru' => User::where('role', 'guru')->count(),
        ];

        // Dokumen terbaru
        $recentAtp = (clone $atpQuery)->with(['mataPelajaran', 'fase'])->latest()->take(5)->get();
        $recentModul = (clone $modulQuery)->with(['mataPelajaran', 'fase'])->latest()->take(5)->get();
        $recentLkpd = (clone $lkpdQuery)->with(['mataPelajaran', 'fase'])->latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentAtp', 'recentModul', 'recentLkpd'));
    }
}
