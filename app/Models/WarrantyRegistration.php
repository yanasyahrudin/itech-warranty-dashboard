<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyRegistration extends Model
{
    protected $fillable = [
        'product_id',
        'serial_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'purchase_date',
        'additional_info',
        'invoice_path',
        'status',
        'verified_by',
        'verified_at',
        'warranty_start_date',
        'warranty_end_date',
        'rejection_reason',
        'rejected_at',
        'rejected_by',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
    ];

    /**
     * Get the product associated with this warranty.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who verified this warranty.
     */
    public function verifiedByUser(): BelongsTo
    {
        // Support both verified_by and approved_by/rejected_by
        return $this->belongsTo(User::class, 'verified_by')
            ->orWhere('id', $this->approved_by)
            ->orWhere('id', $this->rejected_by);
    }

    /**
     * Get the user who approved this warranty.
     */
    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who rejected this warranty.
     */
    public function rejectedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get the user who created this registration.
     */
    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get verified by user (backwards compatible)
     */
    public function getVerifierAttribute()
    {
        if ($this->verified_by) {
            return User::find($this->verified_by);
        }
        
        if ($this->status === 'approved' && $this->approved_by) {
            return User::find($this->approved_by);
        }
        
        if ($this->status === 'rejected' && $this->rejected_by) {
            return User::find($this->rejected_by);
        }
        
        return null;
    }

    /**
     * Check if warranty is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'approved' 
            && $this->warranty_end_date 
            && $this->warranty_end_date >= now();
    }

    /**
     * Check if warranty is expired
     */
    public function isExpired(): bool
    {
        return $this->status === 'approved' 
            && $this->warranty_end_date 
            && $this->warranty_end_date < now();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status display text
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending Verification',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => 'Unknown',
        };
    }
}