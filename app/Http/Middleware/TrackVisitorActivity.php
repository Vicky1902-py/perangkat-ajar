<?php

namespace App\Http\Middleware;

use App\Models\TrafficLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Jangan catat jika request gagal total, redirect internal asset, atau AJAX polling live-data
        if ($this->shouldSkip($request)) {
            return $response;
        }

        try {
            $this->logActivity($request);
        } catch (\Throwable $e) {
            // Logging traffic tidak boleh menggagalkan respon aplikasi utama
            report($e);
        }

        return $response;
    }

    /**
     * Memeriksa apakah request perlu dilewati (tidak dicatat).
     */
    protected function shouldSkip(Request $request): bool
    {
        // 1. Abaikan seluruh aktivitas jika pengguna sedang login sebagai Superadmin atau Admin
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && in_array($user->role, ['superadmin', 'admin', 'admin_sekolah'])) {
                return true;
            }
        }

        $path = $request->path();

        // Abaikan health check, live polling traffic admin, debugbar, dan livewire
        if (
            $path === 'up' ||
            str_contains($path, 'cms/traffic/live') ||
            str_contains($path, '_debugbar') ||
            str_contains($path, 'telescope') ||
            str_contains($path, 'livewire')
        ) {
            return true;
        }

        // Abaikan file statis / asset
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'map', 'json'])) {
            return true;
        }

        return false;
    }

    /**
     * Menyimpan log aktivitas pengunjung.
     */
    protected function logActivity(Request $request): void
    {
        $user = Auth::user();

        // Pengamanan ganda: jangan pernah catat log untuk akun admin / superadmin
        if ($user && in_array($user->role, ['superadmin', 'admin', 'admin_sekolah'])) {
            return;
        }

        $sessionId = $request->session()->getId();
        $ip = $request->ip();
        $ua = $request->userAgent();
        $deviceInfo = TrafficLog::parseUserAgent($ua);
        $routeName = $request->route() ? $request->route()->getName() : null;
        $url = $request->fullUrl();
        $method = $request->method();

        // Tentukan Role & Nama Pengguna
        if ($user) {
            $userName = $user->name . ($user->mata_pelajaran_diampu ? ' (' . $user->mata_pelajaran_diampu . ')' : '');
            $role = $user->role;
        } else {
            $guestCount = (int) session('guest_generator_count', 0);
            $userName = 'Tamu / Pengunjung Publik' . ($guestCount > 0 ? " (Coba {$guestCount}x)" : '');
            $role = 'guest';
        }

        // Tentukan Deskripsi Aktivitas & Action Type
        [$actionType, $activityDesc] = $this->resolveActivityDescription($request, $routeName);

        TrafficLog::create([
            'session_id' => $sessionId,
            'ip_address' => $ip,
            'user_id' => $user?->id,
            'user_name' => $userName,
            'role' => $role,
            'device_type' => $deviceInfo['device_type'],
            'device_os' => $deviceInfo['device_os'],
            'browser' => $deviceInfo['browser'],
            'user_agent' => substr((string) $ua, 0, 500),
            'method' => $method,
            'url' => substr($url, 0, 500),
            'route_name' => $routeName,
            'action_type' => $actionType,
            'activity_description' => $activityDesc,
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Menentukan action_type dan teks ringkas aktivitas pengunjung.
     */
    protected function resolveActivityDescription(Request $request, ?string $routeName): array
    {
        $path = trim($request->path(), '/');

        if ($routeName === 'welcome' || $path === '') {
            return ['view', 'Mengunjungi Landing Page (Beranda 2026)'];
        }

        if ($routeName === 'login' || $path === 'login') {
            return ['auth', $request->isMethod('POST') ? 'Mencoba Masuk ke Sistem (Login)' : 'Membuka Form Masuk Akun'];
        }

        if ($routeName === 'register' || $path === 'register') {
            return ['auth', $request->isMethod('POST') ? 'Mendaftarkan Akun Guru Baru' : 'Membuka Form Pendaftaran Guru'];
        }

        if ($routeName === 'generator.index' || $path === 'generator') {
            return ['view', 'Membuka Generator Perangkat Ajar 1-Klik'];
        }

        if ($routeName === 'generator.generate') {
            return ['generate', 'Memproses Pembuatan Perangkat Ajar Lengkap'];
        }

        if ($routeName === 'generator.result' || str_contains($path, 'generator/result')) {
            return ['view', 'Melihat Hasil Perangkat Ajar Lengkap'];
        }

        if ($routeName === 'dashboard' || $path === 'dashboard') {
            return ['view', 'Melihat Dashboard Utama Guru'];
        }

        if (str_starts_with($routeName ?? '', 'legal.')) {
            $legalMap = [
                'legal.privacy' => 'Membaca Kebijakan Privasi (Privacy Policy)',
                'legal.terms' => 'Membaca Syarat & Ketentuan Layanan',
                'legal.about' => 'Membaca Profil Tentang Platform & Vicky Koroh',
                'legal.contact' => 'Membuka Halaman Kontak & Bantuan',
                'legal.disclaimer' => 'Membaca Penyangkalan (Disclaimer)',
            ];
            return ['view', $legalMap[$routeName] ?? 'Membaca Halaman Kepatuhan Hukum'];
        }

        if (str_contains($path, 'export') || str_contains($path, 'download')) {
            return ['export', 'Mengunduh / Mengekspor Dokumen Perangkat Ajar'];
        }

        if (str_starts_with($path, 'modul-ajar')) {
            return ['view', 'Mengakses Modul Ajar (PEDATTI)'];
        }

        if (str_starts_with($path, 'atp')) {
            return ['view', 'Mengakses Alur Tujuan Pembelajaran (ATP)'];
        }

        if (str_starts_with($path, 'lkpd')) {
            return ['view', 'Mengakses Lembar Kerja Peserta Didik (LKPD)'];
        }

        if (str_starts_with($path, 'prota') || str_starts_with($path, 'promes')) {
            return ['view', 'Mengakses Dokumen Prota & Promes'];
        }

        if (str_starts_with($path, 'asesmen')) {
            return ['view', 'Mengakses Instrumen Asesmen'];
        }

        if (str_starts_with($path, 'cms')) {
            return ['view', 'Mengakses Master Data CMS (' . $path . ')'];
        }

        return ['view', 'Mengakses laman /' . $path];
    }
}
