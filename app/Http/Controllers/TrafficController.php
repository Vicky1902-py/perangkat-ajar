<?php

namespace App\Http\Controllers;

use App\Models\TrafficLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrafficController extends Controller
{
    /**
     * Tampilkan halaman dasbor pemantauan traffic real-time.
     */
    public function index(Request $request)
    {
        $activeMinutes = 15;
        $adminRoles = ['superadmin', 'admin', 'admin_sekolah'];

        // 1. Metrik Aktivitas Realtime (Hanya Guru & Tamu, Admin diabaikan)
        $activeNow = TrafficLog::activeRecent($activeMinutes)
            ->whereNotIn('role', $adminRoles)
            ->distinct('session_id')
            ->count('session_id');

        $activeGuests = TrafficLog::activeRecent($activeMinutes)
            ->where('role', 'guest')
            ->distinct('session_id')
            ->count('session_id');

        $activeUsers = TrafficLog::activeRecent($activeMinutes)
            ->where('role', 'guru')
            ->distinct('user_id')
            ->count('user_id');

        // 2. Metrik Hari Ini
        $todayTotalVisits = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->count();

        $todayGenerates = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->generations()
            ->count();

        // 3. Distribusi Perangkat (Smartphone vs Tablet vs Desktop) Hari Ini
        $deviceBreakdown = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->pluck('total', 'device_type')
            ->toArray();

        // 4. Distribusi Sistem Operasi & Browser
        $osBreakdown = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->select('device_os', DB::raw('count(*) as total'))
            ->whereNotNull('device_os')
            ->groupBy('device_os')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'device_os')
            ->toArray();

        $browserBreakdown = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->select('browser', DB::raw('count(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'browser')
            ->toArray();

        // 5. Daftar Log Aktivitas Terkini (dengan filter role & device)
        $query = TrafficLog::with('user')
            ->whereNotIn('role', $adminRoles)
            ->orderByDesc('id');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('device_type')) {
            $query->where('device_type', $request->device_type);
        }
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('cms.traffic.index', compact(
            'activeNow',
            'activeGuests',
            'activeUsers',
            'todayTotalVisits',
            'todayGenerates',
            'deviceBreakdown',
            'osBreakdown',
            'browserBreakdown',
            'logs'
        ));
    }

    /**
     * Endpoint API JSON untuk pembaruan polling otomatis (live refresh) tanpa memuat ulang seluruh halaman.
     */
    public function liveData(Request $request): JsonResponse
    {
        $activeMinutes = 15;
        $adminRoles = ['superadmin', 'admin', 'admin_sekolah'];

        $activeNow = TrafficLog::activeRecent($activeMinutes)
            ->whereNotIn('role', $adminRoles)
            ->distinct('session_id')
            ->count('session_id');

        $activeGuests = TrafficLog::activeRecent($activeMinutes)
            ->where('role', 'guest')
            ->distinct('session_id')
            ->count('session_id');

        $activeUsers = TrafficLog::activeRecent($activeMinutes)
            ->where('role', 'guru')
            ->distinct('user_id')
            ->count('user_id');

        $todayTotalVisits = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->count();

        $todayGenerates = TrafficLog::today()
            ->whereNotIn('role', $adminRoles)
            ->generations()
            ->count();

        // Ambil 20 aktivitas paling anyar (hanya pengunjung nyata)
        $latestLogs = TrafficLog::with('user')
            ->whereNotIn('role', $adminRoles)
            ->orderByDesc('id')
            ->take(20)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'user_name' => $log->user_name,
                    'role' => $log->role,
                    'role_label' => match ($log->role) {
                        'superadmin' => 'Superadmin',
                        'admin_sekolah' => 'Admin Sekolah',
                        'guru' => 'Guru SMK',
                        default => 'Tamu (Guest)',
                    },
                    'role_badge_class' => match ($log->role) {
                        'superadmin' => 'bg-danger',
                        'admin_sekolah' => 'bg-primary',
                        'guru' => 'bg-success',
                        default => 'bg-warning text-dark',
                    },
                    'ip_address' => $log->ip_address,
                    'device_type' => $log->device_type,
                    'device_icon' => match ($log->device_type) {
                        'Smartphone' => 'bi-phone',
                        'Tablet' => 'bi-tablet',
                        'Bot/Crawler' => 'bi-robot',
                        default => 'bi-laptop',
                    },
                    'device_os' => $log->device_os ?? '-',
                    'browser' => $log->browser ?? '-',
                    'action_type' => $log->action_type,
                    'activity_description' => $log->activity_description,
                    'perangkat_ajar_meta' => $log->perangkat_ajar_meta,
                    'created_time' => $log->created_at ? $log->created_at->format('H:i:s') : '-',
                    'time_ago' => $log->created_at ? $log->created_at->diffForHumans() : '-',
                ];
            });

        return response()->json([
            'status' => 'success',
            'timestamp' => now()->format('d/m/Y H:i:s'),
            'metrics' => [
                'active_now' => $activeNow,
                'active_guests' => $activeGuests,
                'active_users' => $activeUsers,
                'today_visits' => $todayTotalVisits,
                'today_generates' => $todayGenerates,
            ],
            'logs' => $latestLogs,
        ]);
    }

    /**
     * Bersihkan log lama (lebih dari 30 hari) untuk pemeliharaan database.
     */
    public function clearOldLogs()
    {
        $deleted = TrafficLog::where('created_at', '<', now()->subDays(30))->delete();

        return redirect()->route('cms.traffic.index')->with('success', "Pembersihan berhasil! {$deleted} data log lama telah dihapus.");
    }
}
