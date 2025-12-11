<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseLog extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'destination',
        'notes',
        'received_by',
        'issued_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the product associated with this log.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who received the stock.
     */
    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Get the user who issued the stock.
     */
    public function issuedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}