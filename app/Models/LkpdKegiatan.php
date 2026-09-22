<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LkpdKegiatan extends Model
{
    use HasFactory;

    protected $table = 'lkpd_kegiatans';

    protected $fillable = [
        'lkpd_id',
        'tahap',
        'instruksi',
        'pertanyaan',
        'ruang_jawaban',
        'urutan',
    ];

    public function lkpd(): BelongsTo
    {
        return $this->belongsTo(Lkpd::class);
    }
}
