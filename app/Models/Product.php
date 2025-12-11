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
}