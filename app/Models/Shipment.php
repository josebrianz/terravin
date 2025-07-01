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
        'shipping_cost',
        'estimated_delivery_date',
        'shipping_address',
    ];

    protected $dates = [
        'estimated_delivery_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'in_transit' => 'badge-info',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger',
        ];
        return $badges[$this->status] ?? 'badge-secondary';
    }
} 