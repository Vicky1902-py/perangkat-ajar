<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lkpd extends Model
{
    use HasFactory;

    protected $table = 'lkpds';

    protected $fillable = [
        'modul_ajar_id',
        'user_id',
        'guest_session_id',
        'is_shared',
        'mata_pelajaran_id',
        'fase_id',
        'judul',
        'tujuan_pembelajaran',
        'stimulus_otentik',
        'petunjuk_belajar',
        'alat_bahan',
        'rubrik_penilaian',
        'alokasi_waktu_menit',
    ];

    public function modulAjar(): BelongsTo
    {
        return $this->belongsTo(ModulAjar::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function fase(): BelongsTo
    {
        return $this->belongsTo(Fase::class);
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(LkpdKegiatan::class)->orderBy('urutan', 'asc');
    }
}
