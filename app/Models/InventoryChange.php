<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryChange extends Model
{
    protected $fillable = [
        'inventory_id',
        'user_id',
        'change_type',
        'quantity_before',
        'quantity_after',
    ];

    public function inventory()
    {
        return $this->belongsTo(\App\Models\Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
