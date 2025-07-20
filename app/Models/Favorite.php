<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['customer_id', 'inventory_id'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
} 