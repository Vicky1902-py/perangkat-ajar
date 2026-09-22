<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! $user->is_profile_completed) {
                // Rute yang diizinkan saat profil belum lengkap
                $allowedRoutes = ['profile.setup', 'profile.save', 'logout'];

                if (! $request->routeIs($allowedRoutes)) {
                    return redirect()->route('profile.setup')
                        ->with('warning', 'Selamat datang! Sebagai langkah awal penggunaan multi-sekolah, mohon lengkapi profil diri dan data sekolah Anda terlebih dahulu. Data ini wajib untuk mencetak Kop Surat resmi dan Form Tanda Tangan pada seluruh dokumen yang dihasilkan.');
                }
            }
        }

        return $next($request);
    }
}
