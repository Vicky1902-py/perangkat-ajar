<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplatePedatti extends Model
{
    use HasFactory;

    protected $table = 'template_pedattis';

    protected $fillable = [
        'tahap',
        'template_kegiatan',
        'prinsip_deep_learning',
        'olah',
        'durasi_default_menit',
        'contoh_pertanyaan',
        'is_active',
    ];

    protected $casts = [
        'durasi_default_menit' => 'integer',
        'is_active' => 'boolean',
    ];
}
