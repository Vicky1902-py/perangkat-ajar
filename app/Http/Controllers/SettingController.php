<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\CurriculumRegulationService;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman utama pengaturan sistem (Superadmin).
     */
    public function index(Request $request, DatabaseBackupService $backupService, CurriculumRegulationService $regService)
    {
        $allSettings = Setting::all()->keyBy('key');

        $themePresets = [
            'cosmic_sapphire' => [
                'name' => 'Cosmic Sapphire (Default 2026)',
                'desc' => 'Palet warna modern biru safir, indigo, dan cyan dengan efek glassmorphism.',
                'primary' => '#2563eb',
                'cyan' => '#38bdf8',
                'indigo' => '#6366f1',
                'bg' => '#050b18',
            ],
            'emerald_aurora' => [
                'name' => 'Emerald Aurora (Vokasi Hijau)',
                'desc' => 'Nuansa hijau zamrud, teal, dan mint yang melambangkan pertumbuhan vokasi.',
                'primary' => '#059669',
                'cyan' => '#14b8a6',
                'indigo' => '#10b981',
                'bg' => '#03140e',
            ],
            'royal_amethyst' => [
                'name' => 'Royal Amethyst (Ungu Mewah)',
                'desc' => 'Gradasi ungu violet dan magenta berkelas tinggi dengan pendaran futuristik.',
                'primary' => '#7c3aed',
                'cyan' => '#c084fc',
                'indigo' => '#9333ea',
                'bg' => '#0c071e',
            ],
            'golden_sunset' => [
                'name' => 'Golden Sunset (Emas & Amber)',
                'desc' => 'Aura hangat warna emas keemasan, amber, dan oranye mewah.',
                'primary' => '#d97706',
                'cyan' => '#fbbf24',
                'indigo' => '#ea580c',
                'bg' => '#140c03',
            ],
            'midnight_obsidian' => [
                'name' => 'Midnight Obsidian (Dark Minimalis)',
                'desc' => 'Gaya gelap pekat ultra-bersih dengan kontras aksen perak dan sky blue.',
                'primary' => '#475569',
                'cyan' => '#94a3b8',
                'indigo' => '#334155',
                'bg' => '#020617',
            ],
        ];

        $backups = $backupService->listBackups();
        $regulationInfo = $regService->getRegulationsSummary();

        return view('cms.settings.index', compact(
            'allSettings',
            'themePresets',
            'backups',
            'regulationInfo'
        ));
    }

    /**
     * Simpan pembaruan pengaturan aplikasi.
     */
    public function update(Request $request)
    {
        $uploadPath = public_path('uploads/settings');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // 1. Tangani Upload File Logo
        if ($request->hasFile('app_logo')) {
            $request->validate(['app_logo' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072']);
            $logoFile = $request->file('app_logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move($uploadPath, $logoName);
            Setting::set('app_logo', 'uploads/settings/' . $logoName, 'branding', 'image');
        } elseif ($request->filled('remove_app_logo')) {
            Setting::set('app_logo', null, 'branding', 'image');
        }

        // 2. Tangani Upload File Favicon
        if ($request->hasFile('app_favicon')) {
            $request->validate(['app_favicon' => 'mimes:ico,png,svg|max:1024']);
            $favFile = $request->file('app_favicon');
            $favName = 'favicon_' . time() . '.' . $favFile->getClientOriginalExtension();
            $favFile->move($uploadPath, $favName);
            Setting::set('app_favicon', 'uploads/settings/' . $favName, 'branding', 'image');
        } elseif ($request->filled('remove_app_favicon')) {
            Setting::set('app_favicon', null, 'branding', 'image');
        }

        // 3. Tangani Upload Foto Hero Mockup
        if ($request->hasFile('landing_hero_image_file')) {
            $request->validate(['landing_hero_image_file' => 'image|mimes:jpeg,png,jpg,webp|max:5120']);
            $heroFile = $request->file('landing_hero_image_file');
            $heroName = 'hero_' . time() . '.' . $heroFile->getClientOriginalExtension();
            $heroFile->move($uploadPath, $heroName);
            Setting::set('landing_hero_image', asset('uploads/settings/' . $heroName), 'landing_hero', 'image');
        } elseif ($request->filled('landing_hero_image_url')) {
            Setting::set('landing_hero_image', $request->input('landing_hero_image_url'), 'landing_hero', 'image');
        }

        // 4. Tangani Upload Foto 3 Pilar Deep Learning
        $pilars = ['mindful', 'meaningful', 'joyful'];
        foreach ($pilars as $p) {
            $fileKey = "landing_pilar_{$p}_img_file";
            $urlKey = "landing_pilar_{$p}_img_url";
            $targetKey = "landing_pilar_{$p}_img";

            if ($request->hasFile($fileKey)) {
                $pilarFile = $request->file($fileKey);
                $pilarName = "pilar_{$p}_" . time() . '.' . $pilarFile->getClientOriginalExtension();
                $pilarFile->move($uploadPath, $pilarName);
                Setting::set($targetKey, asset('uploads/settings/' . $pilarName), 'landing_pilar', 'image');
            } elseif ($request->filled($urlKey)) {
                Setting::set($targetKey, $request->input($urlKey), 'landing_pilar', 'image');
            }
        }

        // 5. Tangani Upload Avatar Profil Pembuat
        if ($request->hasFile('creator_avatar_file')) {
            $request->validate(['creator_avatar_file' => 'image|mimes:jpeg,png,jpg,webp|max:4096']);
            $avatarFile = $request->file('creator_avatar_file');
            $avatarName = 'avatar_' . time() . '.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->move($uploadPath, $avatarName);
            Setting::set('creator_avatar', asset('uploads/settings/' . $avatarName), 'creator_profile', 'image');
        } elseif ($request->filled('creator_avatar_url')) {
            Setting::set('creator_avatar', $request->input('creator_avatar_url'), 'creator_profile', 'image');
        }

        // 6. Tangani Seluruh Field Teks, Textarea, dan Warna
        $textFields = [
            'app_name' => 'branding',
            'app_tagline' => 'branding',
            'theme_preset' => 'theme',
            'theme_primary_color' => 'theme',
            'theme_accent_cyan' => 'theme',
            'theme_accent_indigo' => 'theme',
            'landing_hero_badge' => 'landing_hero',
            'landing_hero_title' => 'landing_hero',
            'landing_hero_subtitle' => 'landing_hero',
            'landing_hero_cta_primary' => 'landing_hero',
            'landing_pilar_mindful_title' => 'landing_pilar',
            'landing_pilar_mindful_subtitle' => 'landing_pilar',
            'landing_pilar_mindful_desc' => 'landing_pilar',
            'landing_pilar_meaningful_title' => 'landing_pilar',
            'landing_pilar_meaningful_subtitle' => 'landing_pilar',
            'landing_pilar_meaningful_desc' => 'landing_pilar',
            'landing_pilar_joyful_title' => 'landing_pilar',
            'landing_pilar_joyful_subtitle' => 'landing_pilar',
            'landing_pilar_joyful_desc' => 'landing_pilar',
            'landing_creator_name' => 'landing_creator',
            'landing_creator_role' => 'landing_creator',
            'landing_creator_desc' => 'landing_creator',
            'landing_copyright_year' => 'landing_creator',
            'creator_headline' => 'creator_profile',
            'creator_bio' => 'creator_profile',
            'creator_education' => 'creator_profile',
            'creator_skills' => 'creator_profile',
            'creator_whatsapp' => 'creator_profile',
            'creator_email' => 'creator_profile',
            'creator_github' => 'creator_profile',
            'creator_linkedin' => 'creator_profile',
            'creator_instagram' => 'creator_profile',
            'creator_website' => 'creator_profile',
        ];

        foreach ($textFields as $field => $grp) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field), $grp);
            }
        }

        return redirect()->route('cms.settings.index', ['tab' => $request->input('active_tab', 'branding')])
            ->with('success', 'Pengaturan aplikasi berhasil disimpan dan langsung diterapkan ke seluruh sistem!');
    }

    /**
     * Kembalikan tema ke preset bawaan Cosmic Sapphire 2026.
     */
    public function resetTheme(Request $request)
    {
        Setting::set('theme_preset', 'cosmic_sapphire', 'theme');
        Setting::set('theme_primary_color', '#2563eb', 'theme');
        Setting::set('theme_accent_cyan', '#38bdf8', 'theme');
        Setting::set('theme_accent_indigo', '#6366f1', 'theme');

        return redirect()->route('cms.settings.index', ['tab' => 'theme'])
            ->with('success', 'Tema visual telah dikembalikan ke standar bawaan resmi 2026.');
    }

    /**
     * Buat cadangan database baru (.sql) menggunakan Pure PHP PDO.
     */
    public function backupCreate(DatabaseBackupService $backupService)
    {
        try {
            $result = $backupService->createBackup();
            return redirect()->route('cms.settings.index', ['tab' => 'backup'])
                ->with('success', "🎉 Backup database berhasil dibuat! File: {$result['filename']} ({$result['size']})");
        } catch (\Throwable $e) {
            return redirect()->route('cms.settings.index', ['tab' => 'backup'])
                ->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }

    /**
     * Unduh file backup database (.sql).
     */
    public function backupDownload(string $filename, DatabaseBackupService $backupService): BinaryFileResponse
    {
        $path = $backupService->getBackupPath($filename);
        if (!$path) {
            abort(404, 'File backup tidak ditemukan atau tidak valid.');
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Hapus file backup database tertentu.
     */
    public function backupDelete(string $filename, DatabaseBackupService $backupService)
    {
        if ($backupService->deleteBackup($filename)) {
            return redirect()->route('cms.settings.index', ['tab' => 'backup'])
                ->with('success', "File backup {$filename} berhasil dihapus.");
        }

        return redirect()->route('cms.settings.index', ['tab' => 'backup'])
            ->with('error', 'Gagal menghapus file backup.');
    }

    /**
     * Sinkronisasi atau aktifkan regulasi kurikulum baru.
     */
    public function syncRegulation(Request $request, CurriculumRegulationService $regService)
    {
        if ($request->hasFile('regulation_package_file')) {
            $request->validate(['regulation_package_file' => 'required|file|mimes:json|max:10240']);
            $file = $request->file('regulation_package_file');
            $json = json_decode(file_get_contents($file->getRealPath()), true);

            if (!is_array($json)) {
                return redirect()->route('cms.settings.index', ['tab' => 'regulation'])
                    ->with('error', 'Format file JSON paket regulasi tidak valid.');
            }

            $regName = $request->input('regulation_name') ?: ('Regulasi Kurikulum ' . date('Y'));
            $res = $regService->importPackage($json, $regName);

            return redirect()->route('cms.settings.index', ['tab' => 'regulation'])
                ->with('success', "🎉 Berhasil mengimpor {$res['total']} data Capaian Pembelajaran untuk regulasi: {$res['regulation']}");
        }

        if ($request->filled('active_regulation')) {
            $regName = $request->input('active_regulation');
            $count = $regService->setActiveRegulation($regName);

            return redirect()->route('cms.settings.index', ['tab' => 'regulation'])
                ->with('success', "Regulasi '{$regName}' kini aktif sebagai standar kurikulum sistem ({$count} CP aktif).");
        }

        return redirect()->route('cms.settings.index', ['tab' => 'regulation'])
            ->with('warning', 'Tidak ada tindakan regulasi yang dipilih.');
    }
}
