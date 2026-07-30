<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    // Dompet dimiliki oleh seorang User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Satu dompet bisa memiliki banyak transaksi
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Transaksi transfer masuk ke dompet ini
    public function transferInTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'target_wallet_id');
    }
}
