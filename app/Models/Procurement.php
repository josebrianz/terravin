<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'item_name',
        'description',
        'wholesaler_name',
        'wholesaler_email',
        'wholesaler_phone',
        'quantity',
        'unit_price',
        'total_amount',
        'status',
        'order_date',
        'expected_delivery',
        'actual_delivery',
        'notes',
        'requested_by',
        'approved_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery' => 'date',
        'actual_delivery' => 'date',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeOrdered($query)
    {
        return $query->where('status', 'ordered');
    }

    public function scopeReceived($query)
    {
        return $query->where('status', 'received');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'approved' => 'bg-info',
            'ordered' => 'bg-primary',
            'received' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
