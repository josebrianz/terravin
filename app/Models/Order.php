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
    }
} 