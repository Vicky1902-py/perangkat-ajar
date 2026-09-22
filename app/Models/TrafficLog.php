<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrafficLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_id',
        'user_name',
        'role',
        'device_type',
        'device_os',
        'browser',
        'user_agent',
        'method',
        'url',
        'route_name',
        'action_type',
        'activity_description',
        'perangkat_ajar_meta',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'perangkat_ajar_meta' => 'array',
            'last_activity_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk aktivitas pengunjung aktif dalam X menit terakhir (default 15 menit).
     */
    public function scopeActiveRecent($query, int $minutes = 15)
    {
        return $query->where('last_activity_at', '>=', now()->subMinutes($minutes));
    }

    /**
     * Scope untuk hari ini.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('last_activity_at', today());
    }

    /**
     * Scope untuk pembuatan perangkat ajar.
     */
    public function scopeGenerations($query)
    {
        return $query->where('action_type', 'generate');
    }

    /**
     * Parser cerdas User-Agent untuk mendeteksi Perangkat (Smartphone / Tablet / Desktop), OS, dan Browser.
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        $ua = $userAgent ?? '';

        // Deteksi Bot / Crawler
        if (preg_match('/(googlebot|adsbot|bingbot|slurp|duckduckbot|baiduspider|yandexbot|sogou|exabot|facebot|ia_archiver)/i', $ua)) {
            return [
                'device_type' => 'Bot/Crawler',
                'device_os' => 'Search Bot',
                'browser' => 'Web Crawler',
            ];
        }

        // 1. Deteksi Tipe Perangkat (Device Type)
        $isMobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $ua);
        $isTablet = preg_match('/android|ipad|playbook|silk/i', $ua) && !$isMobile;

        if ($isTablet) {
            $deviceType = 'Tablet';
        } elseif ($isMobile) {
            $deviceType = 'Smartphone';
        } else {
            $deviceType = 'Desktop / Laptop';
        }

        // 2. Deteksi Sistem Operasi (OS)
        $os = 'Tidak Diketahui';
        if (preg_match('/windows nt 10/i', $ua)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/windows nt 6\.3/i', $ua)) {
            $os = 'Windows 8.1';
        } elseif (preg_match('/windows nt 6\.2/i', $ua)) {
            $os = 'Windows 8';
        } elseif (preg_match('/windows nt 6\.1/i', $ua)) {
            $os = 'Windows 7';
        } elseif (preg_match('/windows/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/android (\d+(\.\d+)?)/i', $ua, $matches)) {
            $os = 'Android ' . ($matches[1] ?? '');
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/iphone os (\d+([_\.]\d+)?)/i', $ua, $matches)) {
            $os = 'iOS ' . str_replace('_', '.', $matches[1] ?? '');
        } elseif (preg_match('/ipad/i', $ua)) {
            $os = 'iPadOS';
        } elseif (preg_match('/mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        } elseif (preg_match('/cros/i', $ua)) {
            $os = 'ChromeOS';
        }

        // 3. Deteksi Peramban (Browser)
        $browser = 'Lainnya';
        if (preg_match('/edg\/([\d\.]+)/i', $ua, $matches)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/opr\/([\d\.]+)|opera/i', $ua, $matches)) {
            $browser = 'Opera';
        } elseif (preg_match('/samsungbrowser\/([\d\.]+)/i', $ua, $matches)) {
            $browser = 'Samsung Internet';
        } elseif (preg_match('/chrome\/([\d\.]+)/i', $ua, $matches)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/firefox\/([\d\.]+)/i', $ua, $matches)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/safari/i', $ua) && !preg_match('/(chrome|crios|android)/i', $ua)) {
            $browser = 'Apple Safari';
        }

        return [
            'device_type' => $deviceType,
            'device_os' => trim($os),
            'browser' => $browser,
        ];
    }
}
