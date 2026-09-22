<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulAjarKegiatan extends Model
{
    use HasFactory;

    protected $table = 'modul_ajar_kegiatans';

    protected $fillable = [
        'modul_ajar_id',
        'tahap_pedatti',
        'deskripsi_kegiatan',
        'durasi_menit',
        'prinsip_deep_learning',
        'olah',
        'urutan',
    ];

    public function modulAjar(): BelongsTo
    {
        return $this->belongsTo(ModulAjar::class);
    }
}
