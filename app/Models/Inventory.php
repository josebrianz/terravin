<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
    'item_name',
    'item_code',
    'quantity',
    'price',
    'location',
];

    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }
}
