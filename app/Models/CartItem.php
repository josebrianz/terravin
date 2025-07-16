<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'wine_id', 'quantity'];

    public function wine()
    {
        return $this->belongsTo(\App\Models\Inventory::class, 'wine_id');
    }
}
