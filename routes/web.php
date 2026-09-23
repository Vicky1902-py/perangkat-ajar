<?php

use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\AtpController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\CreatorProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\LkpdController;
use App\Http\Controllers\ModulAjarController;
use App\Http\Controllers\PaketSoalController;
use App\Http\Controllers\PerangkatManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProtaPromesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrafficController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// LANDING / WELCOME PAGE (INFORMATIF, FITUR, FUNGSI, 3M, PEDATTI, CREATOR & HAK CIPTA)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// HALAMAN STANDAR KEPATUHAN GOOGLE ADSENSE (PUBLIK TANPA LOGIN)
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/about-us', [LegalController::class, 'about'])->name('legal.about');
Route::get('/contact', [LegalController::class, 'contact'])->name('legal.contact');
Route::get('/disclaimer', [LegalController::class, 'disclaimer'])->name('legal.disclaimer');

// GOOGLE ADSENSE ADS.TXT CRAWLER ENDPOINT
Route::get('/ads.txt', function () {
    $content = app_setting('ads_txt_content', "google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0\n");
    return response($content, 200, ['Content-Type' => 'text/plain']);
})->name('ads.txt');

// LANDING PROFIL PEMBUAT APLIKASI (PUBLIK)
Route::get('/profil-pembuat', [CreatorProfileController::class, 'index'])->name('creator.profile');

// FORMULIR USUL & SARAN (PUBLIK & GURU)
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// AUTHENTICATION
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ⚡ 1-CLICK GENERATOR (PUBLIC / GUEST SUPPORT WITH 2X TRIAL LIMIT)
Route::prefix('generator')->name('generator.')->group(function () {
    Route::get('/', [GeneratorController::class, 'index'])->name('index');
    Route::post('/process', [GeneratorController::class, 'generate'])->name('process');
    Route::get('/result', [GeneratorController::class, 'result'])->name('result');
    Route::get('/ajax-cp', [GeneratorController::class, 'getCpByMapelAndFase'])->name('ajax-cp');
});

// EXPORTS (PDF, EXCEL, DOCX - PUBLIC FOR GUEST RESULTS & PROTECTED FOR USER ARCHIVES)
Route::prefix('export')->name('export.')->group(function () {
    Route::get('/atp/{atp}/pdf', [ExportController::class, 'exportAtpPdf'])->name('atp.pdf');
    Route::get('/atp/{atp}/excel', [ExportController::class, 'exportAtpExcel'])->name('atp.excel');
    Route::get('/atp/{atp}/docx', [ExportController::class, 'exportAtpDocx'])->name('atp.docx');

    Route::get('/modul-ajar/{modulAjar}/pdf', [ExportController::class, 'exportModulAjarPdf'])->name('modul-ajar.pdf');
    Route::get('/modul-ajar/{modulAjar}/docx', [ExportController::class, 'exportModulAjarDocx'])->name('modul-ajar.docx');

    Route::get('/lkpd/{lkpd}/pdf', [ExportController::class, 'exportLkpdPdf'])->name('lkpd.pdf');
    Route::get('/lkpd/{lkpd}/docx', [ExportController::class, 'exportLkpdDocx'])->name('lkpd.docx');

    Route::get('/asesmen/{asesmen}/pdf', [ExportController::class, 'exportAsesmenPdf'])->name('asesmen.pdf');
    Route::get('/asesmen/{asesmen}/docx', [ExportController::class, 'exportAsesmenDocx'])->name('asesmen.docx');

    // EXPORT PROTA
    Route::get('/prota/{prota}/pdf', [ExportController::class, 'exportProtaPdf'])->name('prota.pdf');
    Route::get('/prota/{prota}/excel', [ExportController::class, 'exportProtaExcel'])->name('prota.excel');
    Route::get('/prota/{prota}/docx', [ExportController::class, 'exportProtaDocx'])->name('prota.docx');

    // EXPORT PROMES
    Route::get('/promes/{promes}/pdf', [ExportController::class, 'exportPromesPdf'])->name('promes.pdf');
    Route::get('/promes/{promes}/excel', [ExportController::class, 'exportPromesExcel'])->name('promes.excel');
    Route::get('/promes/{promes}/docx', [ExportController::class, 'exportPromesDocx'])->name('promes.docx');

    // EXPORT SOAL & KISI-KISI
    Route::get('/paket-soal/{paketSoal}/siswa/pdf', [ExportController::class, 'exportSoalSiswaPdf'])->name('soal.siswa.pdf');
    Route::get('/paket-soal/{paketSoal}/guru/pdf', [ExportController::class, 'exportSoalGuruPdf'])->name('soal.guru.pdf');
    Route::get('/paket-soal/{paketSoal}/docx', [ExportController::class, 'exportSoalDocx'])->name('soal.docx');
});

// PROTECTED ROUTES (AUTHENTICATED)
Route::middleware(['auth'])->group(function () {
    // ONBOARDING & PENGATURAN PROFIL
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'save'])->name('profile.save');

    // FITUR APLIKASI (WAJIB MELENGKAPI PROFIL & KOP SEKOLAH)
    Route::middleware(['ensure.profile'])->group(function () {
        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // TUJUAN PEMBELAJARAN (TP)
        Route::resource('tp', TujuanPembelajaranController::class);

        // ALUR TUJUAN PEMBELAJARAN (ATP)
        Route::resource('atp', AtpController::class);

        // MODUL AJAR (DEEP LEARNING / PEDATTI)
        Route::resource('modul-ajar', ModulAjarController::class);

        // LEMBAR KERJA PESERTA DIDIK (LKPD)
        Route::resource('lkpd', LkpdController::class);

        // PROTA & PROMES
        Route::get('/prota-promes', [ProtaPromesController::class, 'index'])->name('prota-promes.index');
        Route::get('/prota/{prota}', [ProtaPromesController::class, 'showProta'])->name('prota.show');
        Route::get('/promes/{promes}', [ProtaPromesController::class, 'showPromes'])->name('promes.show');

        // ASESMEN
        Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen.index');
        Route::get('/asesmen/{asesmen}', [AsesmenController::class, 'show'])->name('asesmen.show');

        // GENERATOR SOAL (BANK SOAL & KISI-KISI SISTEM PAKAR)
        Route::resource('paket-soal', PaketSoalController::class);

        // CMS MASTER DATA (SUPERADMIN & ADMIN SEKOLAH)
        Route::middleware(['role:superadmin,admin_sekolah'])->prefix('cms')->name('cms.')->group(function () {
            // Capaian Pembelajaran
            Route::get('/cp', [CmsController::class, 'cpIndex'])->name('cp.index');
            Route::get('/cp/create', [CmsController::class, 'cpCreate'])->name('cp.create');
            Route::post('/cp', [CmsController::class, 'cpStore'])->name('cp.store');
            Route::get('/cp/{cp}/edit', [CmsController::class, 'cpEdit'])->name('cp.edit');
            Route::put('/cp/{cp}', [CmsController::class, 'cpUpdate'])->name('cp.update');
            Route::delete('/cp/{cp}', [CmsController::class, 'cpDestroy'])->name('cp.destroy');

            // Mata Pelajaran
            Route::get('/mapel', [CmsController::class, 'mapelIndex'])->name('mapel.index');
            Route::get('/mapel/create', [CmsController::class, 'mapelCreate'])->name('mapel.create');
            Route::post('/mapel', [CmsController::class, 'mapelStore'])->name('mapel.store');
            Route::get('/mapel/{mapel}/edit', [CmsController::class, 'mapelEdit'])->name('mapel.edit');
            Route::put('/mapel/{mapel}', [CmsController::class, 'mapelUpdate'])->name('mapel.update');
            Route::delete('/mapel/{mapel}', [CmsController::class, 'mapelDestroy'])->name('mapel.destroy');

            // Kejuruan & Program Keahlian SMK
            Route::get('/kejuruan', [CmsController::class, 'kejuruanIndex'])->name('kejuruan.index');

            // 8 Dimensi Profil Lulusan
            Route::get('/profil-lulusan', [CmsController::class, 'profilLulusanIndex'])->name('profil-lulusan.index');
            Route::put('/profil-lulusan/{profilLulusan}', [CmsController::class, 'profilLulusanUpdate'])->name('profil-lulusan.update');

            // Template Alur Belajar PEDATTI
            Route::get('/template-pedatti', [CmsController::class, 'templatePedattiIndex'])->name('template-pedatti.index');
            Route::put('/template-pedatti/{template}', [CmsController::class, 'templatePedattiUpdate'])->name('template-pedatti.update');

            // Tahun Ajaran
            Route::get('/tahun-ajaran', [CmsController::class, 'tahunAjaranIndex'])->name('tahun-ajaran.index');
            Route::post('/tahun-ajaran', [CmsController::class, 'tahunAjaranStore'])->name('tahun-ajaran.store');
            Route::put('/tahun-ajaran/{tahunAjaran}', [CmsController::class, 'tahunAjaranUpdate'])->name('tahun-ajaran.update');
            Route::delete('/tahun-ajaran/{tahunAjaran}', [CmsController::class, 'tahunAjaranDestroy'])->name('tahun-ajaran.destroy');
            Route::post('/tahun-ajaran/{tahunAjaran}/activate', [CmsController::class, 'tahunAjaranSetActive'])->name('tahun-ajaran.activate');
            Route::post('/tahun-ajaran/quick-generate', [CmsController::class, 'tahunAjaranQuickGenerate'])->name('tahun-ajaran.quick-generate');

            // Satuan Pendidikan
            Route::get('/sekolah', [CmsController::class, 'sekolahIndex'])->name('sekolah.index');
            Route::put('/sekolah/{sekolah}', [CmsController::class, 'sekolahUpdate'])->name('sekolah.update');
        });

        // KONTROL PENGGUNA & PANTAU TRAFFIC (SUPERADMIN ONLY)
        Route::middleware(['role:superadmin'])->group(function () {
            Route::resource('users', UserController::class);
            Route::post('/users/{user}/device-access', [UserController::class, 'updateDeviceAccess'])->name('users.device-access');

            // Pantau Realtime Traffic & Perangkat Pengunjung
            Route::get('/cms/traffic', [TrafficController::class, 'index'])->name('cms.traffic.index');
            Route::get('/cms/traffic/live', [TrafficController::class, 'liveData'])->name('cms.traffic.live');
            Route::post('/cms/traffic/clear-old', [TrafficController::class, 'clearOldLogs'])->name('cms.traffic.clear-old');

            // Manajemen Ruang Hosting & Pembersih Perangkat Ajar (Bulk Delete)
            Route::get('/cms/perangkat', [PerangkatManagerController::class, 'index'])->name('cms.perangkat.index');
            Route::post('/cms/perangkat/bulk-delete', [PerangkatManagerController::class, 'bulkDelete'])->name('cms.perangkat.bulk-delete');
            Route::post('/cms/perangkat/quick-purge', [PerangkatManagerController::class, 'quickPurge'])->name('cms.perangkat.quick-purge');

            // Kotak Usul & Saran Pengguna
            Route::get('/cms/feedbacks', [FeedbackController::class, 'index'])->name('cms.feedbacks.index');
            Route::post('/cms/feedbacks/{id}/status', [FeedbackController::class, 'updateStatus'])->name('cms.feedbacks.update-status');
            Route::delete('/cms/feedbacks/{id}', [FeedbackController::class, 'destroy'])->name('cms.feedbacks.destroy');

            // Pengaturan Aplikasi (Logo, Favicon, Full CMS Landing, Tema, Backup DB, Regulasi)
            Route::get('/cms/settings', [SettingController::class, 'index'])->name('cms.settings.index');
            Route::post('/cms/settings', [SettingController::class, 'update'])->name('cms.settings.update');
            Route::post('/cms/settings/reset-theme', [SettingController::class, 'resetTheme'])->name('cms.settings.reset-theme');
            Route::post('/cms/settings/backup', [SettingController::class, 'backupCreate'])->name('cms.settings.backup.create');
            Route::get('/cms/settings/backup/download/{filename}', [SettingController::class, 'backupDownload'])->name('cms.settings.backup.download');
            Route::delete('/cms/settings/backup/{filename}', [SettingController::class, 'backupDelete'])->name('cms.settings.backup.delete');
            Route::post('/cms/settings/sync-regulation', [SettingController::class, 'syncRegulation'])->name('cms.settings.sync-regulation');
        });
    });
});
