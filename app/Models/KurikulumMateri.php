<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KurikulumMateri extends Model
{
    use HasFactory;

    protected $table = 'kurikulum_materis';

    protected $fillable = [
        'mata_pelajaran_id',
        'fase_id',
        'nama_mapel',
        'nama_elemen',
        'topik_utama',
        'sub_materi',
        'rangkuman_materi',
        'pemahaman_bermakna',
        'pertanyaan_pemantik',
        'kegiatan_pedatti',
        'kata_kunci',
        'bank_soal_pg',
        'bank_soal_essay',
        'is_active',
    ];

    protected $casts = [
        'sub_materi' => 'array',
        'kegiatan_pedatti' => 'array',
        'kata_kunci' => 'array',
        'bank_soal_pg' => 'array',
        'bank_soal_essay' => 'array',
        'is_active' => 'boolean',
    ];

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function fase(): BelongsTo
    {
        return $this->belongsTo(Fase::class);
    }
}
