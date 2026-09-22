<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKeahlian extends Model
{
    use HasFactory;

    protected $table = 'program_keahlians';

    protected $fillable = [
        'bidang_keahlian_id',
        'kode',
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function bidangKeahlian(): BelongsTo
    {
        return $this->belongsTo(BidangKeahlian::class);
    }

    public function konsentrasiKeahlians(): HasMany
    {
        return $this->hasMany(KonsentrasiKeahlian::class);
    }

    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
