<?php

namespace App\Http\Controllers;

use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\CapaianPembelajaran;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\TrafficLog;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Data telemetri model aaPanel untuk Superadmin
        $superadminData = null;
        if ($user->isSuperAdmin()) {
            $superadminData = $this->getSuperadminTelemetry();
        }

        return view('dashboard.index', compact('stats', 'recentAtp', 'recentModul', 'recentLkpd', 'superadminData'));
    }

    private function getSuperadminTelemetry(): array
    {
        // 1. DISK / SSD STORAGE TELEMETRY
        $diskPath = base_path();
        $diskTotal = @disk_total_space($diskPath) ?: (@disk_total_space('.') ?: (100 * 1024 * 1024 * 1024));
        $diskFree = @disk_free_space($diskPath) ?: (@disk_free_space('.') ?: (50 * 1024 * 1024 * 1024));
        $diskUsed = max(0, $diskTotal - $diskFree);
        $diskPercent = $diskTotal > 0 ? round(($diskUsed / $diskTotal) * 100, 1) : 0;
        $diskTotalGB = round($diskTotal / (1024 ** 3), 2);
        $diskFreeGB = round($diskFree / (1024 ** 3), 2);
        $diskUsedGB = round($diskUsed / (1024 ** 3), 2);

        // 2. DATABASE SIZE TELEMETRY
        $dbSizeMB = 0;
        try {
            $connection = config('database.default');
            if ($connection === 'mysql') {
                $dbName = config('database.connections.mysql.database');
                $dbSizeResult = DB::select("
                    SELECT SUM(data_length + index_length) AS size_bytes
                    FROM information_schema.TABLES
                    WHERE table_schema = ?
                ", [$dbName]);
                $dbBytes = $dbSizeResult[0]->size_bytes ?? 0;
                $dbSizeMB = round($dbBytes / (1024 * 1024), 2);
            }
        } catch (\Throwable $e) {
            $dbSizeMB = 0;
        }

        // 3. RAM / MEMORY TELEMETRY
        $memUsage = memory_get_usage(true);
        $memPeak = memory_get_peak_usage(true);
        $memUsageMB = round($memUsage / (1024 * 1024), 2);
        $memPeakMB = round($memPeak / (1024 * 1024), 2);
        $memoryLimit = ini_get('memory_limit') ?: '512M';
        
        $serverRamPercent = 0;
        $serverTotalRamGB = null;
        if (@is_readable('/proc/meminfo')) {
            $meminfo = @file_get_contents('/proc/meminfo');
            if ($meminfo && preg_match('/MemTotal:\s+(\d+)\s+kB/', $meminfo, $mTotal) && preg_match('/MemAvailable:\s+(\d+)\s+kB/', $meminfo, $mAvail)) {
                $totalMemKB = (float)$mTotal[1];
                $availMemKB = (float)$mAvail[1];
                $serverTotalRamGB = round($totalMemKB / (1024 * 1024), 2);
                $serverRamPercent = $totalMemKB > 0 ? round((($totalMemKB - $availMemKB) / $totalMemKB) * 100, 1) : 0;
            }
        }
        if ($serverRamPercent === 0) {
            $limitBytes = $this->parseMemoryLimit($memoryLimit);
            if ($limitBytes > 0) {
                $serverRamPercent = min(100, round(($memPeak / $limitBytes) * 100, 1));
            } else {
                $serverRamPercent = 18.5;
            }
        }

        // 4. CPU ESTIMATION / LOAD
        $cpuLoadPercent = 12.0;
        if (function_exists('sys_getloadavg')) {
            $loads = @sys_getloadavg();
            if (is_array($loads) && isset($loads[0])) {
                $cpuLoadPercent = min(100, round($loads[0] * 20, 1));
            }
        }

        // 5. REAL TRAFFIC STATS
        $activeMinutes = 15;
        $activeNow = TrafficLog::activeRecent($activeMinutes)->distinct('session_id')->count('session_id');
        $activeGuests = TrafficLog::activeRecent($activeMinutes)->where('role', 'guest')->distinct('session_id')->count('session_id');
        $activeUsers = TrafficLog::activeRecent($activeMinutes)->where('role', '!=', 'guest')->distinct('user_id')->count('user_id');
        $todayHits = TrafficLog::today()->count();
        $todayGenerates = TrafficLog::today()->generations()->count();

        // 6. USERS & FEEDBACKS
        $userCounts = [
            'total' => User::count(),
            'guru' => User::where('role', 'guru')->count(),
            'admin_sekolah' => User::where('role', 'admin_sekolah')->count(),
            'superadmin' => User::where('role', 'superadmin')->count(),
        ];
        $newFeedbacks = UserFeedback::where('status', 'baru')->count();
        $totalFeedbacks = UserFeedback::count();

        // 7. PERANGKAT AJAR COMPOSITION (For Donut & Space stats)
        $docDistribution = [
            'Modul Ajar' => ModulAjar::count(),
            'Tujuan Pembelajaran' => TujuanPembelajaran::count(),
            'Alur Tujuan (ATP)' => AlurTujuanPembelajaran::count(),
            'Lembar LKPD' => Lkpd::count(),
            'Prota' => ProgramTahunan::count(),
            'Promes' => ProgramSemester::count(),
            'Asesmen' => Asesmen::count(),
        ];
        $totalPerangkat = array_sum($docDistribution);

        // 8. 7-DAYS TREND CHART DATA
        $chartLabels = [];
        $chartVisits = [];
        $chartGenerates = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $dateStr = $d->format('Y-m-d');
            $chartLabels[] = $d->translatedFormat('d M');
            $chartVisits[] = TrafficLog::whereDate('created_at', $dateStr)->count();
            $chartGenerates[] = TrafficLog::whereDate('created_at', $dateStr)->generations()->count();
        }

        return [
            'disk' => [
                'total_gb' => $diskTotalGB,
                'used_gb' => $diskUsedGB,
                'free_gb' => $diskFreeGB,
                'percent' => $diskPercent,
            ],
            'database' => [
                'size_mb' => $dbSizeMB,
                'connection' => config('database.default'),
            ],
            'memory' => [
                'usage_mb' => $memUsageMB,
                'peak_mb' => $memPeakMB,
                'limit' => $memoryLimit,
                'percent' => $serverRamPercent,
                'server_total_gb' => $serverTotalRamGB,
            ],
            'cpu' => [
                'load_percent' => $cpuLoadPercent,
                'php_version' => PHP_VERSION,
                'os' => PHP_OS_FAMILY,
            ],
            'traffic' => [
                'active_now' => $activeNow,
                'active_guests' => $activeGuests,
                'active_users' => $activeUsers,
                'today_hits' => $todayHits,
                'today_generates' => $todayGenerates,
            ],
            'users' => $userCounts,
            'feedback' => [
                'total' => $totalFeedbacks,
                'baru' => $newFeedbacks,
            ],
            'documents' => [
                'total' => $totalPerangkat,
                'breakdown' => $docDistribution,
            ],
            'chart' => [
                'labels' => $chartLabels,
                'visits' => $chartVisits,
                'generates' => $chartGenerates,
            ],
        ];
    }

    private function parseMemoryLimit(string $limit): float
    {
        $limit = trim($limit);
        if ($limit === '-1') return 0;
        $last = strtolower($limit[strlen($limit) - 1]);
        $val = (float)$limit;
        switch ($last) {
            case 'g': $val *= 1024 * 1024 * 1024; break;
            case 'm': $val *= 1024 * 1024; break;
            case 'k': $val *= 1024; break;
        }
        return $val;
    }
}
