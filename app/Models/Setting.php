<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'app_settings';

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    const CACHE_KEY = 'app_settings_all';

    /**
     * Dapatkan nilai pengaturan berdasarkan key dengan sistem caching performa tinggi.
     */
    public static function get(string $key, $default = null)
    {
        $allSettings = Cache::rememberForever(self::CACHE_KEY, function () {
            return static::pluck('value', 'key')->toArray();
        });

        if (array_key_exists($key, $allSettings)) {
            $val = $allSettings[$key];
            return ($val !== null && $val !== '') ? $val : $default;
        }

        return $default;
    }

    /**
     * Simpan atau perbarui nilai pengaturan dan otomatis bersihkan cache.
     */
    public static function set(string $key, $value, ?string $group = null, ?string $type = null): self
    {
        $data = ['value' => $value];
        if ($group) $data['group'] = $group;
        if ($type) $data['type'] = $type;

        $setting = static::updateOrCreate(['key' => $key], $data);
        static::clearCache();

        return $setting;
    }

    /**
     * Bersihkan cache memori pengaturan.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Ambil seluruh pengaturan dalam satu grup.
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)->get()->keyBy('key');
    }
}
