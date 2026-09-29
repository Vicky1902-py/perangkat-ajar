<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DetectMobileView
{
    /**
     * Handle an incoming request.
     * Prepend mobile views directory if the request is from a mobile/Android device.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (function_exists('is_mobile_device') && is_mobile_device()) {
            $mobileViewPath = resource_path('views/mobile');
            if (is_dir($mobileViewPath)) {
                View::getFinder()->prependLocation($mobileViewPath);
            }
        }

        return $next($request);
    }
}
