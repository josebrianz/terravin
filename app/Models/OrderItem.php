<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'inventory_id',
        'item_name',
        'quantity',
        'unit_price',
        'item_name',
        'subtotal',
        'category',
        'total_price',
        
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
} 