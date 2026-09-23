<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Fase;
use App\Models\GuestUsage;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\TrafficLog;
use App\Services\GeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneratorController extends Controller
{
    const GUEST_MAX_COUNT = 2;

    protected GeneratorService $generatorService;

    public function __construct(GeneratorService $generatorService)
    {
        $this->generatorService = $generatorService;
    }

    /**
     * Mendapatkan jumlah generate yang telah dilakukan tamu (guest).
     */
    private function getGuestUsageCount(Request $request): int
    {
        $sessionId = session()->getId();
        $ip = $request->ip();

        $guestUsage = GuestUsage::where('session_id', $sessionId)
            ->orWhere('ip_address', $ip)
            ->orderByDesc('device_count')
            ->first();

        $sessionCount = (int) session('guest_generator_count', 0);
        $dbCount = $guestUsage ? $guestUsage->device_count : 0;

        return max($sessionCount, $dbCount);
    }

    public function index(Request $request)
    {
        $fases = Fase::all();
        $mapels = MataPelajaran::with('programKeahlian')->where('is_active', true)->orderBy('kelompok')->orderBy('nama')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('is_active')->get();
        $cps = CapaianPembelajaran::with(['mataPelajaran', 'fase'])->where('is_active', true)->get();

        $isGuest = !Auth::check();
        $guestCount = $isGuest ? $this->getGuestUsageCount($request) : 0;
        $guestRemaining = $isGuest ? max(0, self::GUEST_MAX_COUNT - $guestCount) : null;
        $guestLimitReached = $isGuest && ($guestCount >= self::GUEST_MAX_COUNT);

        return view('generator.index', compact(
            'fases',
            'mapels',
            'tahunAjarans',
            'cps',
            'isGuest',
            'guestCount',
            'guestRemaining',
            'guestLimitReached'
        ));
    }

    public function generate(Request $request)
    {
        $isGuest = !Auth::check();
        $sessionId = $request->session()->getId();
        $ip = $request->ip();

        if ($isGuest) {
            $request->session()->put('guest_session_id', $sessionId);
            $guestCount = $this->getGuestUsageCount($request);
            if ($guestCount >= self::GUEST_MAX_COUNT) {
                return redirect()->route('register')->with('warning', 'Batas kuota gratis (2 kali pembuatan perangkat) tanpa login telah tercapai. Silakan daftar akun gratis sekarang untuk membuat dan mengelola perangkat ajar tanpa batas!');
            }
        }

        // Penanganan fleksibel Tahun Ajaran: bisa dari dropdown maupun input manual
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

        $request->validate([
            'capaian_pembelajaran_id' => ['required', 'exists:capaian_pembelajarans,id'],
            'tahun_ajaran_id' => ['nullable', 'exists:tahun_ajarans,id'],
        ], [
            'capaian_pembelajaran_id.required' => 'Silakan pilih Capaian Pembelajaran (CP) yang ingin di-generate.',
        ]);

        try {
            $currentUser = Auth::user();
            $params = $request->all();
            if ($isGuest) {
                $params['guest_session_id'] = $sessionId;
            }
            $result = $this->generatorService->generateAll($params, $currentUser);

            // Jika tamu, catat kuota pemakaian
            if ($isGuest) {
                $usage = GuestUsage::where('session_id', $sessionId)
                    ->orWhere('ip_address', $ip)
                    ->first();

                if ($usage) {
                    $usage->increment('device_count');
                    $usage->update([
                        'session_id' => $sessionId,
                        'ip_address' => $ip,
                        'last_generated_at' => now(),
                    ]);
                    $newCount = $usage->device_count;
                } else {
                    $usage = GuestUsage::create([
                        'ip_address' => $ip,
                        'session_id' => $sessionId,
                        'device_count' => 1,
                        'last_generated_at' => now(),
                    ]);
                    $newCount = 1;
                }

                session(['guest_generator_count' => $newCount]);
                $remaining = max(0, self::GUEST_MAX_COUNT - $newCount);
                $quotaMsg = $remaining > 0 
                    ? " (Sisa kuota tamu gratis Anda: {$remaining} kali)." 
                    : " (Kuota gratis 2x Anda telah habis. Daftar akun gratis agar perangkat tersimpan aman).";
            } else {
                $quotaMsg = '';
            }

            // Catat ke TrafficLog admin agar terpantau dokumen apa yang dibuat
            try {
                $deviceInfo = TrafficLog::parseUserAgent($request->userAgent());
                $mapelNama = $result['modul_ajar']->mataPelajaran->nama ?? ($result['atp']->mataPelajaran->nama ?? 'Mata Pelajaran SMK');
                $faseNama = $result['modul_ajar']->fase->nama ?? ($result['atp']->fase->nama ?? 'Fase');
                $userName = $currentUser ? $currentUser->name : ('Tamu Publik' . (isset($newCount) ? " (Paket Ke-{$newCount})" : ''));

                TrafficLog::create([
                    'session_id' => $sessionId,
                    'ip_address' => $ip,
                    'user_id' => $currentUser?->id,
                    'user_name' => $userName,
                    'role' => $currentUser ? $currentUser->role : 'guest',
                    'device_type' => $deviceInfo['device_type'],
                    'device_os' => $deviceInfo['device_os'],
                    'browser' => $deviceInfo['browser'],
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'method' => 'POST',
                    'url' => substr($request->fullUrl(), 0, 500),
                    'route_name' => 'generator.generate',
                    'action_type' => 'generate',
                    'activity_description' => "Membuat 1 Paket Lengkap Perangkat Ajar: {$mapelNama} ({$faseNama})",
                    'perangkat_ajar_meta' => [
                        'mapel' => $mapelNama,
                        'fase' => $faseNama,
                        'atp_id' => $result['atp']->id ?? null,
                        'modul_id' => $result['modul_ajar']->id ?? null,
                        'lkpd_id' => $result['lkpd']->id ?? null,
                        'prota_id' => $result['prota']->id ?? null,
                        'promes_id' => $result['promes']->id ?? null,
                        'asesmen_id' => $result['asesmen']->id ?? null,
                    ],
                    'last_activity_at' => now(),
                ]);
            } catch (\Throwable $te) {
                report($te);
            }

            return redirect()->route('generator.result', [
                'atp_id' => $result['atp']->id,
                'modul_id' => $result['modul_ajar']->id,
                'lkpd_id' => $result['lkpd']->id,
                'prota_id' => $result['prota']->id,
                'promes_id' => $result['promes']->id,
                'asesmen_id' => $result['asesmen']->id ?? null,
            ])->with('success', '🎉 Berhasil! Seluruh Perangkat Ajar Deep Learning (TP, ATP, Modul Ajar, LKPD, Prota, Promes, dan Asesmen) telah berhasil dibuat!' . $quotaMsg);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan generate perangkat ajar: ' . $e->getMessage())->withInput();
        }
    }

    public function result(Request $request)
    {
        $atpId = $request->query('atp_id');
        $modulId = $request->query('modul_id');
        $lkpdId = $request->query('lkpd_id');
        $protaId = $request->query('prota_id');
        $promesId = $request->query('promes_id');
        $asesmenId = $request->query('asesmen_id');

        $isGuest = !Auth::check();
        $guestCount = $isGuest ? $this->getGuestUsageCount($request) : 0;
        $guestRemaining = $isGuest ? max(0, self::GUEST_MAX_COUNT - $guestCount) : null;

        return view('generator.result', compact(
            'atpId',
            'modulId',
            'lkpdId',
            'protaId',
            'promesId',
            'asesmenId',
            'isGuest',
            'guestRemaining'
        ));
    }

    public function getCpByMapelAndFase(Request $request)
    {
        $mapelId = $request->get('mapel_id');
        $faseId = $request->get('fase_id');

        $cp = CapaianPembelajaran::where('mata_pelajaran_id', $mapelId)
            ->where('fase_id', $faseId)
            ->where('is_active', true)
            ->first();

        if (!$cp) {
            return response()->json(['success' => false, 'message' => 'Capaian Pembelajaran belum tersedia untuk kombinasi ini.']);
        }

        return response()->json([
            'success' => true,
            'id' => $cp->id,
            'deskripsi_cp' => $cp->deskripsi_cp,
            'elemen_cp' => json_decode($cp->elemen_cp, true),
        ]);
    }
}
