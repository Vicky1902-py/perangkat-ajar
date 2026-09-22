<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlurTujuanPembelajaran extends Model
{
    use HasFactory;

    protected $table = 'alur_tujuan_pembelajarans';

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'is_shared',
        'mata_pelajaran_id',
        'fase_id',
        'tahun_ajaran_id',
        'judul',
        'regulasi',
        'total_alokasi_jp',
        'deskripsi',
    ];

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

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function atpDetails(): HasMany
    {
        return $this->hasMany(AtpDetail::class, 'atp_id')->orderBy('urutan', 'asc');
    }
}
