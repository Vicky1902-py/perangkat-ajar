<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecualian rute agar tidak loop atau nge-block asset
        $excludedRoutes = [
            'login',
            'login.post',
            'logout',
        ];

        if ($request->route() && in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Cek pengaturan mode maintenance dari database
        if (app_setting('maintenance_mode', '0') === '1') {
            // Jika user sudah login dan role-nya superadmin, izinkan lewat
            if (Auth::check() && Auth::user()->role === 'superadmin') {
                return $next($request);
            }

            // Jika bukan superadmin, tampilkan halaman maintenance (503 Service Unavailable)
            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}
