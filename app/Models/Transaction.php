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

    // Transaksi dikategorikan ke dalam suatu kategori (optional)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}