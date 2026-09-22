<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModulAjar extends Model
{
    use HasFactory;

    protected $table = 'modul_ajars';

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'is_shared',
        'tujuan_pembelajaran_id',
        'mata_pelajaran_id',
        'fase_id',
        'tahun_ajaran_id',
        'judul',
        'kompetensi_awal',
        'profil_lulusan_target',
        'sarana_prasarana',
        'target_peserta_didik',
        'pemahaman_bermakna',
        'pertanyaan_pemantik',
        'asesmen_awal',
        'asesmen_formatif',
        'asesmen_sumatif',
        'refleksi_guru',
        'refleksi_siswa',
        'pengayaan',
        'remedial',
        'bahan_ajar',
        'glosarium',
        'daftar_pustaka',
        'alokasi_waktu_jp',
        'jumlah_pertemuan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tujuanPembelajaran(): BelongsTo
    {
        return $this->belongsTo(TujuanPembelajaran::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function fase(): BelongsTo
    {
        return $this->belongsTo(Fase::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(ModulAjarKegiatan::class)->orderBy('urutan', 'asc');
    }

    public function profilLulusans(): BelongsToMany
    {
        return $this->belongsToMany(ProfilLulusan::class, 'modul_ajar_profil_lulusan');
    }

    public function lkpds(): HasMany
    {
        return $this->hasMany(Lkpd::class);
    }

    public function asesmens(): HasMany
    {
        return $this->hasMany(Asesmen::class);
    }
}
