<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketSoal extends Model
{
    use HasFactory;

    protected $table = 'paket_soals';

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'is_shared',
        'modul_ajar_id',
        'tujuan_pembelajaran_id',
        'mata_pelajaran_id',
        'fase_id',
        'tahun_ajaran_id',
        'judul',
        'jenis_ujian',
        'bentuk_soal',
        'total_soal_pg',
        'total_soal_isian',
        'alokasi_waktu_menit',
        'petunjuk_umum',
        'kisi_kisi_data',
        'butir_soal_pg',
        'butir_soal_isian',
        'bobot_pg_persen',
        'bobot_isian_persen',
    ];

    protected $casts = [
        'kisi_kisi_data' => 'array',
        'butir_soal_pg' => 'array',
        'butir_soal_isian' => 'array',
        'is_shared' => 'boolean',
        'total_soal_pg' => 'integer',
        'total_soal_isian' => 'integer',
        'alokasi_waktu_menit' => 'integer',
        'bobot_pg_persen' => 'integer',
        'bobot_isian_persen' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function modulAjar(): BelongsTo
    {
        return $this->belongsTo(ModulAjar::class);
    }

    public function tujuanPembelajaran(): BelongsTo
    {
        return $this->belongsTo(TujuanPembelajaran::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function fase(): BelongsTo
    {
        return $this->belongsTo(Fase::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function getJenisUjianLabelAttribute(): string
    {
        return match ($this->jenis_ujian) {
            'sumatif_lingkup_materi' => 'Sumatif Lingkup Materi',
            'sts' => 'Sumatif Tengah Semester (STS)',
            'sas' => 'Sumatif Akhir Semester (SAS)',
            'diagnostik' => 'Asesmen Diagnostik Awal',
            'kuis_harian' => 'Kuis Harian Vokasi',
            default => 'Ujian Sumatif',
        };
    }

    public function getBentukSoalLabelAttribute(): string
    {
        return match ($this->bentuk_soal) {
            'pg' => 'Pilihan Ganda (PG)',
            'isian' => 'Isian / Uraian (Essay)',
            'campuran' => 'Campuran (PG & Isian)',
            default => 'Pilihan Ganda & Isian',
        };
    }

    public function getTotalSoalAttribute(): int
    {
        return (int) ($this->total_soal_pg + $this->total_soal_isian);
    }

    public function getTipeSoalAttribute(): string
    {
        return $this->bentuk_soal ?? 'campuran';
    }
}
