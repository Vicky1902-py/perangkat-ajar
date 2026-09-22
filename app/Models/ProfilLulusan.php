<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProfilLulusan extends Model
{
    use HasFactory;

    protected $table = 'profil_lulusans';

    protected $fillable = [
        'dimensi',
        'deskripsi',
        'urutan',
    ];

    public function modulAjars(): BelongsToMany
    {
        return $this->belongsToMany(ModulAjar::class, 'modul_ajar_profil_lulusan');
    }
}
