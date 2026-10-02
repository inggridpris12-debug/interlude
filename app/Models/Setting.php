<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $group
 */
class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Ambil seluruh pengaturan sebagai pasangan key => value.
     *
     * Dibuat tahan gagal supaya halaman tetap bisa dibuka walaupun
     * migration `settings` belum dijalankan.
     *
     * @return array<string, string|null>
     */
    public static function values(): array
    {
        try {
            return static::query()->pluck('value', 'key')->all();
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Ambil satu nilai pengaturan.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = static::values()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    /**
     * Ambil nilai pengaturan sebagai boolean.
     */
    public static function bool(string $key, bool $default = false): bool
    {
        $value = static::values()[$key] ?? null;

        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Simpan satu nilai pengaturan.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => static::normalize($value), 'group' => $group]
        );
    }

    /**
     * Simpan banyak nilai pengaturan sekaligus.
     *
     * @param  array<string, mixed>  $values
     */
    public static function setMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => static::normalize($value), 'group' => $group]
            );
        }
    }

    protected static function normalize(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }
}
