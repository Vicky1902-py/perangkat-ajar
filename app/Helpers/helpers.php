<?php

use App\Models\Setting;

if (!function_exists('app_setting')) {
    /**
     * Dapatkan nilai pengaturan aplikasi dengan fallback default.
     */
    function app_setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('app_logo_url')) {
    /**
     * Dapatkan URL logo aplikasi resmi atau null jika menggunakan logo default SVG.
     */
    function app_logo_url(): ?string
    {
        $logo = Setting::get('app_logo');
        if (!$logo) {
            return null;
        }

        if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')) {
            return $logo;
        }

        return asset($logo);
    }
}

if (!function_exists('app_favicon_url')) {
    /**
     * Dapatkan URL favicon browser atau null jika default.
     */
    function app_favicon_url(): ?string
    {
        $favicon = Setting::get('app_favicon');
        if (!$favicon) {
            return null;
        }

        if (str_starts_with($favicon, 'http://') || str_starts_with($favicon, 'https://')) {
            return $favicon;
        }

        return asset($favicon);
    }
}

if (!function_exists('app_theme_colors')) {
    /**
     * Dapatkan konfigurasi warna tema aktif.
     */
    function app_theme_colors(): array
    {
        $preset = Setting::get('theme_preset', 'cosmic_sapphire');

        $presets = [
            'cosmic_sapphire' => [
                'name' => 'Cosmic Sapphire (Default)',
                'primary' => '#2563eb',
                'cyan' => '#38bdf8',
                'indigo' => '#6366f1',
                'bg_dark' => '#050b18',
            ],
            'emerald_aurora' => [
                'name' => 'Emerald Aurora (Vokasi Hijau)',
                'primary' => '#059669',
                'cyan' => '#14b8a6',
                'indigo' => '#10b981',
                'bg_dark' => '#03140e',
            ],
            'royal_amethyst' => [
                'name' => 'Royal Amethyst (Ungu Mewah)',
                'primary' => '#7c3aed',
                'cyan' => '#c084fc',
                'indigo' => '#9333ea',
                'bg_dark' => '#0c071e',
            ],
            'golden_sunset' => [
                'name' => 'Golden Sunset (Emas & Amber)',
                'primary' => '#d97706',
                'cyan' => '#fbbf24',
                'indigo' => '#ea580c',
                'bg_dark' => '#140c03',
            ],
            'midnight_obsidian' => [
                'name' => 'Midnight Obsidian (Dark Minimalis)',
                'primary' => '#475569',
                'cyan' => '#94a3b8',
                'indigo' => '#334155',
                'bg_dark' => '#020617',
            ],
        ];

        // Jika preset custom atau warna manual disetel
        $active = $presets[$preset] ?? $presets['cosmic_sapphire'];

        // Override jika ada warna spesifik yang disetel
        $customPrimary = Setting::get('theme_primary_color');
        if ($customPrimary) {
            $active['primary'] = $customPrimary;
        }

        $customCyan = Setting::get('theme_accent_cyan');
        if ($customCyan) {
            $active['cyan'] = $customCyan;
        }

        $customIndigo = Setting::get('theme_accent_indigo');
        if ($customIndigo) {
            $active['indigo'] = $customIndigo;
        }

        return $active;
    }
}
