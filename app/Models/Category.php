<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'color',
    ];

    // Kategori dimiliki oleh seorang User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Satu kategori bisa digunakan di banyak transaksi
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Mengisi kategori bawaan/default untuk user baru
    public static function seedDefaultsForUser($userId)
    {
        $defaults = [
            // Pemasukan (income)
            ['name' => 'Gaji', 'type' => 'income', 'color' => '#10B981'], // Emerald
            ['name' => 'Investasi', 'type' => 'income', 'color' => '#3B82F6'], // Blue
            ['name' => 'Bonus', 'type' => 'income', 'color' => '#F59E0B'], // Amber
            ['name' => 'Lain-lain (Masuk)', 'type' => 'income', 'color' => '#6B7280'], // Gray

            // Pengeluaran (expense)
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#EF4444'], // Red
            ['name' => 'Transportasi', 'type' => 'expense', 'color' => '#EC4899'], // Pink
            ['name' => 'Belanja', 'type' => 'expense', 'color' => '#8B5CF6'], // Violet
            ['name' => 'Tagihan & Utilitas', 'type' => 'expense', 'color' => '#06B6D4'], // Cyan
            ['name' => 'Hiburan', 'type' => 'expense', 'color' => '#10B981'], // Emerald
        ];

        foreach ($defaults as $cat) {
            self::create([
                'user_id' => $userId,
                'name'    => $cat['name'],
                'type'    => $cat['type'],
                'color'   => $cat['color']
            ]);
        }
    }
}
