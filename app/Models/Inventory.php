<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'quantity',
        'min_quantity',
        'unit_price',
        'category',
        'location',
        'is_active',
        'images' // Add images to fillable
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
}
