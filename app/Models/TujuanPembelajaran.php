<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TujuanPembelajaran extends Model
{
    use HasFactory;

    protected $table = 'tujuan_pembelajarans';

    protected $fillable = [
        'capaian_pembelajaran_id',
        'user_id',
        'guest_session_id',
        'is_shared',
        'kode_tp',
        'elemen',
        'deskripsi_tp',
        'konten_pengetahuan',
        'keterampilan',
        'sikap',
        'indikator_ketercapaian',
        'urutan',
    ];

    public function capaianPembelajaran(): BelongsTo
    {
        return $this->belongsTo(CapaianPembelajaran::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function atpDetails(): HasMany
    {
        return $this->hasMany(AtpDetail::class);
    }

    public function modulAjars(): HasMany
    {
        return $this->hasMany(ModulAjar::class);
    }
}
