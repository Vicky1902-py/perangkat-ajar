<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fase extends Model
{
    use HasFactory;

    protected $table = 'fases';

    protected $fillable = [
        'kode',
        'nama',
        'kelas_range',
        'deskripsi',
    ];

    public function capaianPembelajarans(): HasMany
    {
        return $this->hasMany(CapaianPembelajaran::class);
    }

    public function alurTujuanPembelajarans(): HasMany
    {
        return $this->hasMany(AlurTujuanPembelajaran::class);
    }

    public function modulAjars(): HasMany
    {
        return $this->hasMany(ModulAjar::class);
    }
}
