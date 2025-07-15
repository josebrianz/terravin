<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'items',
        'total_amount',
        'shipping_address',
        'notes',
        'status',

        'payment_method',

    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'items' => 'array'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment()
    {
        return $this->hasOne(\App\Models\Shipment::class);
    }

    public function getItemsAttribute($value)
    {
        if (is_array($value) || is_null($value)) {
            return $value ?: [];
        }
        return json_decode($value, true) ?: [];
    }

    public function getTotalAttribute()
    {

        return $this->total_amount;

        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'processing' => 'badge-info',
            'shipped' => 'badge-primary',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getItemsArrayAttribute()
    {
        return json_decode($this->items, true) ?? [];
    }

    public function hasShipment()
    {
        return $this->shipment()->exists();

    }
} 