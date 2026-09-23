<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFeedback extends Model
{
    use HasFactory;

    protected $table = 'user_feedbacks';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_hp',
        'kategori',
        'rating',
        'judul',
        'pesan',
        'status',
        'catatan_admin',
        'ip_address',
        'device_type',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function scopeDitinjau($query)
    {
        return $query->where('status', 'ditinjau');
    }

    public function scopeDiterapkan($query)
    {
        return $query->where('status', 'diterapkan');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'usul_fitur' => 'Usul Fitur Baru',
            'perbaikan_kekurangan' => 'Perbaikan & Masukan',
            'laporan_bug' => 'Laporan Kendala / Bug',
            'pertanyaan' => 'Pertanyaan Teknis',
            'apresiasi' => 'Apresiasi & Testimoni',
            default => 'Lain-lain',
        };
    }

    public function getKategoriBadgeAttribute(): string
    {
        return match ($this->kategori) {
            'usul_fitur' => 'bg-primary',
            'perbaikan_kekurangan' => 'bg-warning text-dark',
            'laporan_bug' => 'bg-danger',
            'pertanyaan' => 'bg-info text-dark',
            'apresiasi' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'baru' => 'bg-danger',
            'ditinjau' => 'bg-warning text-dark',
            'diterapkan' => 'bg-success',
            'selesai' => 'bg-info text-dark',
            default => 'bg-secondary',
        };
    }
}
