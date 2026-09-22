<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangKeahlian extends Model
{
    use HasFactory;

    protected $table = 'bidang_keahlians';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programKeahlians(): HasMany
    {
        return $this->hasMany(ProgramKeahlian::class);
    }
}
