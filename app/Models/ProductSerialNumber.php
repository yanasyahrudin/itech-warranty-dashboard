<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSerialNumber extends Model
{
    protected $fillable = [
        'product_id',
        'serial_number',
        'status',
        'registered_to',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    /**
     * Get the product that owns the serial number
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the warranty registration
     */
    public function warrantyRegistration(): BelongsTo
    {
        return $this->belongsTo(WarrantyRegistration::class, 'registered_to');
    }

    /**
     * Check if serial number is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if serial number is registered
     */
    public function isRegistered(): bool
    {
        return $this->status === 'registered';
    }
}