<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtpDetail extends Model
{
    use HasFactory;

    protected $table = 'atp_details';

    protected $fillable = [
        'atp_id',
        'tujuan_pembelajaran_id',
        'urutan',
        'materi_topik',
        'kegiatan_pembelajaran',
        'asesmen',
        'indikator_asesmen',
        'sumber_belajar',
        'alokasi_waktu_jp',
        'dimensi_profil_lulusan',
    ];

    public function alurTujuanPembelajaran(): BelongsTo
    {
        return $this->belongsTo(AlurTujuanPembelajaran::class, 'atp_id');
    }

    public function tujuanPembelajaran(): BelongsTo
    {
        return $this->belongsTo(TujuanPembelajaran::class);
    }
}
