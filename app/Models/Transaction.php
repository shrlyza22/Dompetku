<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'target_wallet_id',
        'category_id',
        'type',
        'title',
        'amount',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Tiap transaksi punya 1 pemilik
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi dicatat pada suatu dompet tertentu (optional)
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    // Dompet tujuan jika tipe transaksi adalah transfer
    public function targetWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'target_wallet_id');
    }

    // Transaksi dikategorikan ke dalam suatu kategori (optional)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Local scope untuk menyatukan logika filter pencarian & kategori/dompet/tanggal
     */
    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($sq) use ($search) {
                $sq->where('title', 'like', "%{$search}%")
                   ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type))
        ->when($filters['wallet_id'] ?? null, function ($q, $walletId) {
            $q->where(function ($sq) use ($walletId) {
                $sq->where('wallet_id', $walletId)
                   ->orWhere('target_wallet_id', $walletId);
            });
        })
        ->when($filters['category_id'] ?? null, fn($q, $categoryId) => $q->where('category_id', $categoryId))
        ->when($filters['start_date'] ?? null, fn($q, $startDate) => $q->whereDate('date', '>=', $startDate))
        ->when($filters['end_date'] ?? null, fn($q, $endDate) => $q->whereDate('date', '<=', $endDate));
    }
}