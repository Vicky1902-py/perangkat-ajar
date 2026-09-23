<?php

namespace App\Http\Controllers;

use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\AtpDetail;
use App\Models\Lkpd;
use App\Models\LkpdKegiatan;
use App\Models\MataPelajaran;
use App\Models\ModulAjar;
use App\Models\ModulAjarKegiatan;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PerangkatManagerController extends Controller
{
    /**
     * Tampilkan halaman pengelolaan dan pembersihan perangkat ajar (Hosting Space Manager).
     */
    public function index(Request $request)
    {
        // 1. STATISTIK RUANG PENYIMPANAN & TOTAL DOKUMEN
        $counts = [
            'modul_ajar' => ModulAjar::count(),
            'atp'        => AlurTujuanPembelajaran::count(),
            'tp'         => TujuanPembelajaran::count(),
            'lkpd'       => Lkpd::count(),
            'prota'      => ProgramTahunan::count(),
            'promes'     => ProgramSemester::count(),
            'asesmen'    => Asesmen::count(),
        ];
        $totalPerangkat = array_sum($counts);

        // Hitung dokumen yang dibuat oleh sesi Tamu (Guest Trials)
        $guestCounts = ModulAjar::whereNotNull('guest_session_id')->count()
            + AlurTujuanPembelajaran::whereNotNull('guest_session_id')->count()
            + Lkpd::whereNotNull('guest_session_id')->count();

        // Metrik Disk Storage Hosting
        $diskTotalBytes = @disk_total_space('.') ?: (100 * 1024 * 1024 * 1024);
        $diskFreeBytes  = @disk_free_space('.') ?: (50 * 1024 * 1024 * 1024);
        $diskUsedBytes  = max(0, $diskTotalBytes - $diskFreeBytes);

        $diskTotalGB = round($diskTotalBytes / 1073741824, 2);
        $diskFreeGB  = round($diskFreeBytes / 1073741824, 2);
        $diskUsedGB  = round($diskUsedBytes / 1073741824, 2);
        $diskPercent = $diskTotalGB > 0 ? round(($diskUsedGB / $diskTotalGB) * 100, 1) : 0;

        // Estimasi Ukuran Database MySQL
        $dbName = config('database.connections.mysql.database', env('DB_DATABASE', 'laravel'));
        $dbSizeBytes = 0;
        try {
            $dbSizeResult = DB::select("
                SELECT SUM(data_length + index_length) AS size 
                FROM information_schema.TABLES 
                WHERE table_schema = ?
            ", [$dbName]);
            if (!empty($dbSizeResult) && isset($dbSizeResult[0]->size)) {
                $dbSizeBytes = (int) $dbSizeResult[0]->size;
            }
        } catch (\Throwable $e) {
            $dbSizeBytes = 5 * 1024 * 1024; // Fallback ~5 MB
        }
        $dbSizeMB = round($dbSizeBytes / 1048576, 2);

        // 2. QUERY DAFTAR PERANGKAT TERPADU DENGAN FILTER
        $filterType = $request->query('type', 'all');
        $filterUser = $request->query('user_id');
        $filterDate = $request->query('date_range');
        $search     = $request->query('search');

        $collection = collect();

        // Helper untuk filter tanggal
        $applyDateFilter = function ($q) use ($filterDate) {
            if ($filterDate === 'today') {
                $q->whereDate('created_at', today());
            } elseif ($filterDate === 'this_week') {
                $q->where('created_at', '>=', now()->startOfWeek());
            } elseif ($filterDate === 'this_month') {
                $q->where('created_at', '>=', now()->startOfMonth());
            } elseif ($filterDate === 'older_30') {
                $q->where('created_at', '<', now()->subDays(30));
            } elseif ($filterDate === 'older_90') {
                $q->where('created_at', '<', now()->subDays(90));
            }
        };

        // Helper untuk filter user
        $applyUserFilter = function ($q) use ($filterUser) {
            if ($filterUser === 'guest') {
                $q->whereNotNull('guest_session_id');
            } elseif (!empty($filterUser)) {
                $q->where('user_id', $filterUser);
            }
        };

        // Ambil Modul Ajar
        if ($filterType === 'all' || $filterType === 'modul_ajar') {
            $q = ModulAjar::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'modul_ajar',
                    'type_label' => 'Modul Ajar',
                    'badge'      => 'warning',
                    'id'         => $item->id,
                    'composite_id' => 'modul_ajar:' . $item->id,
                    'judul'      => $item->judul ?: 'Modul Ajar Tanpa Judul',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest Trial)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('modul-ajar.show', $item->id),
                ]);
            }
        }

        // Ambil ATP
        if ($filterType === 'all' || $filterType === 'atp') {
            $q = AlurTujuanPembelajaran::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'atp',
                    'type_label' => 'Alur TP (ATP)',
                    'badge'      => 'success',
                    'id'         => $item->id,
                    'composite_id' => 'atp:' . $item->id,
                    'judul'      => $item->judul ?: 'ATP Tanpa Judul',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest Trial)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('atp.show', $item->id),
                ]);
            }
        }

        // Ambil TP
        if ($filterType === 'all' || $filterType === 'tp') {
            $q = TujuanPembelajaran::with(['user', 'capaianPembelajaran.mataPelajaran', 'capaianPembelajaran.fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('deskripsi_tp', 'like', "%{$search}%")
                        ->orWhere('kode_tp', 'like', "%{$search}%");
                });
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'tp',
                    'type_label' => 'Tujuan Ajar (TP)',
                    'badge'      => 'primary',
                    'id'         => $item->id,
                    'composite_id' => 'tp:' . $item->id,
                    'judul'      => ($item->kode_tp ? $item->kode_tp . ' - ' : '') . \Illuminate\Support\Str::limit($item->deskripsi_tp, 60),
                    'mapel'      => $item->capaianPembelajaran->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->capaianPembelajaran->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('tp.index'),
                ]);
            }
        }

        // Ambil LKPD
        if ($filterType === 'all' || $filterType === 'lkpd') {
            $q = Lkpd::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'lkpd',
                    'type_label' => 'Lembar Kerja (LKPD)',
                    'badge'      => 'info',
                    'id'         => $item->id,
                    'composite_id' => 'lkpd:' . $item->id,
                    'judul'      => $item->judul ?: 'LKPD Siswa',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest Trial)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('lkpd.show', $item->id),
                ]);
            }
        }

        // Ambil Prota
        if ($filterType === 'all' || $filterType === 'prota') {
            $q = ProgramTahunan::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'prota',
                    'type_label' => 'Program Tahunan',
                    'badge'      => 'secondary',
                    'id'         => $item->id,
                    'composite_id' => 'prota:' . $item->id,
                    'judul'      => $item->judul ?: 'Program Tahunan',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('prota.show', $item->id),
                ]);
            }
        }

        // Ambil Promes
        if ($filterType === 'all' || $filterType === 'promes') {
            $q = ProgramSemester::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'promes',
                    'type_label' => 'Program Semester',
                    'badge'      => 'dark',
                    'id'         => $item->id,
                    'composite_id' => 'promes:' . $item->id,
                    'judul'      => $item->judul ?: 'Program Semester',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('promes.show', $item->id),
                ]);
            }
        }

        // Ambil Asesmen
        if ($filterType === 'all' || $filterType === 'asesmen') {
            $q = Asesmen::with(['user', 'mataPelajaran', 'fase'])->latest();
            $applyDateFilter($q);
            $applyUserFilter($q);
            if ($search) {
                $q->where('judul', 'like', "%{$search}%");
            }
            foreach ($q->get() as $item) {
                $collection->push([
                    'type_key'   => 'asesmen',
                    'type_label' => 'Instrumen Asesmen',
                    'badge'      => 'danger',
                    'id'         => $item->id,
                    'composite_id' => 'asesmen:' . $item->id,
                    'judul'      => $item->judul ?: 'Instrumen Asesmen',
                    'mapel'      => $item->mataPelajaran->nama ?? 'Umum',
                    'fase'       => $item->fase->nama ?? '-',
                    'author'     => $item->user ? $item->user->name : 'Tamu (Guest)',
                    'is_guest'   => empty($item->user_id),
                    'created_at' => $item->created_at,
                    'view_url'   => route('asesmen.show', $item->id),
                ]);
            }
        }

        // Urutkan berdasarkan tanggal terbaru
        $sortedCollection = $collection->sortByDesc('created_at')->values();

        // Manual Pagination
        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;
        $perPage = 20;
        $paginatedItems = new LengthAwarePaginator(
            $sortedCollection->forPage($page, $perPage),
            $sortedCollection->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        // Ambil daftar guru untuk dropdown filter
        $teachers = User::where('role', 'guru')->orderBy('name')->get();

        return view('cms.perangkat.index', compact(
            'counts',
            'totalPerangkat',
            'guestCounts',
            'diskTotalGB',
            'diskFreeGB',
            'diskUsedGB',
            'diskPercent',
            'dbSizeMB',
            'paginatedItems',
            'teachers',
            'filterType',
            'filterUser',
            'filterDate',
            'search'
        ));
    }

    /**
     * Hapus banyak perangkat ajar sekaligus (Bulk Delete) untuk mengosongkan space hosting.
     */
    public function bulkDelete(Request $request)
    {
        $selectedItems = $request->input('selected_items', $request->input('items', []));

        if (empty($selectedItems) || !is_array($selectedItems)) {
            return redirect()->back()->with('error', 'Silakan pilih setidaknya satu perangkat ajar yang ingin dihapus.');
        }

        $deletedCount = 0;

        DB::transaction(function () use ($selectedItems, &$deletedCount) {
            foreach ($selectedItems as $compositeId) {
                $parts = explode(':', $compositeId, 2);
                if (count($parts) !== 2) {
                    continue;
                }
                [$type, $id] = $parts;
                $normalizedType = strtolower(str_replace('_', '', $type));

                switch ($normalizedType) {
                    case 'modulajar':
                        $modul = ModulAjar::find($id);
                        if ($modul) {
                            ModulAjarKegiatan::where('modul_ajar_id', $modul->id)->delete();
                            $modul->profilLulusans()->detach();
                            $modul->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'atp':
                    case 'alurtujuanpembelajaran':
                        $atp = AlurTujuanPembelajaran::find($id);
                        if ($atp) {
                            AtpDetail::where('alur_tujuan_pembelajaran_id', $atp->id)->delete();
                            $atp->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'tp':
                    case 'tujuanpembelajaran':
                        $tp = TujuanPembelajaran::find($id);
                        if ($tp) {
                            $tp->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'lkpd':
                        $lkpd = Lkpd::find($id);
                        if ($lkpd) {
                            LkpdKegiatan::where('lkpd_id', $lkpd->id)->delete();
                            $lkpd->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'prota':
                    case 'programtahunan':
                        $prota = ProgramTahunan::find($id);
                        if ($prota) {
                            $prota->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'promes':
                    case 'programsemester':
                        $promes = ProgramSemester::find($id);
                        if ($promes) {
                            $promes->delete();
                            $deletedCount++;
                        }
                        break;

                    case 'asesmen':
                        $asesmen = Asesmen::find($id);
                        if ($asesmen) {
                            $asesmen->delete();
                            $deletedCount++;
                        }
                        break;
                }
            }
        });

        return redirect()->route('cms.perangkat.index')
            ->with('success', "Berhasil menghapus {$deletedCount} perangkat ajar terpilih dan mengosongkan kapasitas hosting.");
    }

    /**
     * Pembersihan Cepat (Quick Purge) untuk tamu / dokumen kedaluwarsa.
     */
    public function quickPurge(Request $request)
    {
        $purgeTarget = $request->input('purge_target');
        $deletedCount = 0;

        DB::transaction(function () use ($purgeTarget, &$deletedCount) {
            if ($purgeTarget === 'guest') {
                // Hapus seluruh dokumen tamu
                $guestModuls = ModulAjar::whereNotNull('guest_session_id')->pluck('id');
                ModulAjarKegiatan::whereIn('modul_ajar_id', $guestModuls)->delete();
                $deletedCount += ModulAjar::whereIn('id', $guestModuls)->delete();

                $guestAtps = AlurTujuanPembelajaran::whereNotNull('guest_session_id')->pluck('id');
                AtpDetail::whereIn('alur_tujuan_pembelajaran_id', $guestAtps)->delete();
                $deletedCount += AlurTujuanPembelajaran::whereIn('id', $guestAtps)->delete();

                $guestLkpd = Lkpd::whereNotNull('guest_session_id')->pluck('id');
                LkpdKegiatan::whereIn('lkpd_id', $guestLkpd)->delete();
                $deletedCount += Lkpd::whereIn('id', $guestLkpd)->delete();

            } elseif ($purgeTarget === 'older_30') {
                // Hapus dokumen > 30 hari
                $oldModuls = ModulAjar::where('created_at', '<', now()->subDays(30))->pluck('id');
                ModulAjarKegiatan::whereIn('modul_ajar_id', $oldModuls)->delete();
                $deletedCount += ModulAjar::whereIn('id', $oldModuls)->delete();

                $oldAtps = AlurTujuanPembelajaran::where('created_at', '<', now()->subDays(30))->pluck('id');
                AtpDetail::whereIn('alur_tujuan_pembelajaran_id', $oldAtps)->delete();
                $deletedCount += AlurTujuanPembelajaran::whereIn('id', $oldAtps)->delete();

                $oldLkpd = Lkpd::where('created_at', '<', now()->subDays(30))->pluck('id');
                LkpdKegiatan::whereIn('lkpd_id', $oldLkpd)->delete();
                $deletedCount += Lkpd::whereIn('id', $oldLkpd)->delete();

            } elseif ($purgeTarget === 'older_90') {
                // Hapus dokumen > 90 hari
                $oldModuls = ModulAjar::where('created_at', '<', now()->subDays(90))->pluck('id');
                ModulAjarKegiatan::whereIn('modul_ajar_id', $oldModuls)->delete();
                $deletedCount += ModulAjar::whereIn('id', $oldModuls)->delete();

                $oldAtps = AlurTujuanPembelajaran::where('created_at', '<', now()->subDays(90))->pluck('id');
                AtpDetail::whereIn('alur_tujuan_pembelajaran_id', $oldAtps)->delete();
                $deletedCount += AlurTujuanPembelajaran::whereIn('id', $oldAtps)->delete();

                $oldLkpd = Lkpd::where('created_at', '<', now()->subDays(90))->pluck('id');
                LkpdKegiatan::whereIn('lkpd_id', $oldLkpd)->delete();
                $deletedCount += Lkpd::whereIn('id', $oldLkpd)->delete();
            }
        });

        return redirect()->back()->with('success', "Pembersihan cepat selesai! {$deletedCount} dokumen kedaluwarsa berhasil dibersihkan dari server.");
    }
}
