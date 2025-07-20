<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'item_code', // Added this line
        'quantity',
        'min_quantity',
        'unit_price',
        'category',
        'location',
        'is_active',
        'images', // Add images to fillable
        'user_id', // Add user_id for per-user inventory
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unit_price' => 'decimal:2',
        'images' => 'array' // Cast images as array
    ];

    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->min_quantity;
    }

    public function getStatusBadgeClass()
    {
        if ($this->isOutOfStock()) {
            return 'bg-danger';
        } elseif ($this->isLowStock()) {
            return 'bg-warning';
        } else {
            return 'bg-success';
        }
    }

    public function getFormattedPrice()
    {
        return '$' . number_format($this->unit_price, 0);
    }

    public function batches()
    {
        return $this->hasMany(\App\Models\Batch::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
