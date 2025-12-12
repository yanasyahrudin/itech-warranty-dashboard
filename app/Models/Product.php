<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'name',
        'type',
        'warranty_period_months',
        'stock_quantity',
        'description',
    ];

    public function warrantyRegistrations(): HasMany
    {
        return $this->hasMany(WarrantyRegistration::class);
    }

    public function receivedLogs(): HasMany
    {
        return $this->hasMany(ProductReceivedLog::class);
    }

    public function incrementStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function decrementStock(int $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }

    /**
     * Get all serial numbers for this product
     */
    public function serialNumbers(): HasMany
    {
        return $this->hasMany(ProductSerialNumber::class);
    }

    /**
     * Get available serial numbers
     */
    public function availableSerialNumbers(): HasMany
    {
        return $this->hasMany(ProductSerialNumber::class)->where('status', 'available');
    }

    /**
     * Get registered serial numbers
     */
    public function registeredSerialNumbers(): HasMany
    {
        return $this->hasMany(ProductSerialNumber::class)->where('status', 'registered');
    }

    /**
     * Generate serial number for this product
     */
    public function generateSerialNumber(): string
    {
        // Get last serial number for this product
        $lastSerial = $this->serialNumbers()
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSerial) {
            // Extract number from last serial
            preg_match('/(\d+)$/', $lastSerial->serial_number, $matches);
            $lastNumber = isset($matches[1]) ? (int)$matches[1] : 0;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format: PART-NUMBER-00001
        return $this->part_number . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get warehouse transactions
     */
    public function warehouseTransactions(): HasMany
    {
        return $this->hasMany(WarehouseTransaction::class);
    }

    /**
     * Get received transactions
     */
    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(WarehouseTransaction::class)->where('type', 'received');
    }

    /**
     * Get issued transactions
     */
    public function issuedTransactions(): HasMany
    {
        return $this->hasMany(WarehouseTransaction::class)->where('type', 'issued');
    }
}