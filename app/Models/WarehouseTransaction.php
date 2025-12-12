<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'destination',
        'notes',
        'transaction_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who made transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transaction_by');
    }

    /**
     * Check if transaction is received type
     */
    public function isReceived(): bool
    {
        return $this->type === 'received';
    }

    /**
     * Check if transaction is issued type
     */
    public function isIssued(): bool
    {
        return $this->type === 'issued';
    }

    /**
     * Scope for received transactions
     */
    public function scopeReceived($query)
    {
        return $query->where('type', 'received');
    }

    /**
     * Scope for issued transactions
     */
    public function scopeIssued($query)
    {
        return $query->where('type', 'issued');
    }
}