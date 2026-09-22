<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'telepon',
        'mata_pelajaran_diampu',
        'jurusan',
        'satuan_pendidikan_id',
        'is_profile_completed',
        'is_active',
        'can_view_all_devices',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_profile_completed' => 'boolean',
            'is_active' => 'boolean',
            'can_view_all_devices' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminSekolah(): bool
    {
        return $this->role === 'admin_sekolah';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function satuanPendidikan(): BelongsTo
    {
        return $this->belongsTo(SatuanPendidikan::class);
    }

    public function grantedDeviceUsers()
    {
        return $this->belongsToMany(User::class, 'user_device_accesses', 'user_id', 'granted_user_id')
            ->withTimestamps();
    }

    public function canAccessDeviceOf(?int $ownerUserId, ?string $guestSessionId = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($ownerUserId !== null && $ownerUserId === $this->id) {
            return true;
        }

        if ($ownerUserId === null) {
            return $guestSessionId !== null && $guestSessionId === session()->getId();
        }

        if ($this->can_view_all_devices) {
            return true;
        }

        return $this->grantedDeviceUsers()->where('granted_user_id', $ownerUserId)->exists();
    }

    /**
     * Scope query perangkat ajar agar Superadmin melihat semua,
     * sedangkan Guru melihat perangkat miliknya + yang diizinkan Superadmin + yang dibagikan.
     */
    public function applyDeviceAccessScope($query)
    {
        if ($this->isSuperAdmin() || $this->can_view_all_devices) {
            return $query;
        }

        $allowedUserIds = $this->grantedDeviceUsers()->pluck('granted_user_id')->push($this->id)->toArray();

        return $query->where(function ($q) use ($allowedUserIds) {
            $q->whereIn('user_id', $allowedUserIds)
              ->orWhere('is_shared', true);
        });
    }

    public function tujuanPembelajarans(): HasMany
    {
        return $this->hasMany(TujuanPembelajaran::class);
    }

    public function alurTujuanPembelajarans(): HasMany
    {
        return $this->hasMany(AlurTujuanPembelajaran::class);
    }

    public function modulAjars(): HasMany
    {
        return $this->hasMany(ModulAjar::class);
    }

    public function lkpds(): HasMany
    {
        return $this->hasMany(Lkpd::class);
    }

    public function programTahunans(): HasMany
    {
        return $this->hasMany(ProgramTahunan::class);
    }

    public function programSemesters(): HasMany
    {
        return $this->hasMany(ProgramSemester::class);
    }

    public function asesmens(): HasMany
    {
        return $this->hasMany(Asesmen::class);
    }
}
