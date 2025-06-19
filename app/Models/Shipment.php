<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'status',
        'carrier',
        'shipping_address',
        'estimated_delivery_date',
        'actual_delivery_date',
        'shipping_cost',
        'notes'
    ];

    protected $casts = [
        'estimated_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'shipping_cost' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'in_transit' => 'badge-info',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function isOverdue()
    {
        return $this->estimated_delivery_date && 
               $this->estimated_delivery_date->isPast() && 
               $this->status !== 'delivered';
    }
}
