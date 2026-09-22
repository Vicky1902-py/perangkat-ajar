<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asesmen extends Model
{
    use HasFactory;

    protected $table = 'asesmens';

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'is_shared',
        'modul_ajar_id',
        'mata_pelajaran_id',
        'fase_id',
        'tujuan_pembelajaran_id',
        'judul',
        'jenis',
        'deskripsi',
        'instrumen',
        'rubrik',
        'pedoman_penskoran',
        'kktp_data',
        'tindak_lanjut_data',
        'vokasi_dudi_data',
        'deskripsi_rapor',
    ];

    protected $casts = [
        'kktp_data' => 'array',
        'tindak_lanjut_data' => 'array',
        'vokasi_dudi_data' => 'array',
        'deskripsi_rapor' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function modulAjar(): BelongsTo
    {
        return $this->belongsTo(ModulAjar::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function fase(): BelongsTo
    {
        return $this->belongsTo(Fase::class);
    }

    public function tujuanPembelajaran(): BelongsTo
    {
        return $this->belongsTo(TujuanPembelajaran::class);
    }
}
