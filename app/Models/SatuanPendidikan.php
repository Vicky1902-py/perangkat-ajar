<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SatuanPendidikan extends Model
{
    use HasFactory;

    protected $table = 'satuan_pendidikans';

    protected $fillable = [
        'nama',
        'npsn',
        'jenjang',
        'alamat',
        'kota',
        'provinsi',
        'telepon',
        'email',
        'website',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'dinas_pendidikan',
        'logo',
        'kop_baris_1',
        'kop_baris_2',
        'kop_baris_3',
        'kop_baris_4',
        'ukuran_kertas_default',
        'is_active',
    ];

    public function getLogoBase64Attribute(): ?string
    {
        if ($this->logo) {
            $path = storage_path('app/public/' . $this->logo);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
        return null;
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
