<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramSemester extends Model
{
    use HasFactory;

    protected $table = 'program_semesters';

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'is_shared',
        'mata_pelajaran_id',
        'fase_id',
        'tahun_ajaran_id',
        'judul',
        'semester',
        'data_json',
    ];

    protected $casts = [
        'semester' => 'integer',
        'data_json' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
