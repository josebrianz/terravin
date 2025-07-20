<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'inventory_id', 'quantity'];

    public function inventory()
    {
        return $this->belongsTo(\App\Models\Inventory::class, 'inventory_id');
    }
}
