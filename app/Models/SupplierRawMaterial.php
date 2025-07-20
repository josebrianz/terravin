<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRawMaterial extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'typical_use',
        'stock_level',
        'unit_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
