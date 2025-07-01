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
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unit_price' => 'decimal:2'
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
        return '$' . number_format($this->unit_price, 2);
    }
}
