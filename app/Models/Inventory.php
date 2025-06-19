<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->quantity < ($this->min_quantity ?? 10)) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    public function getStockStatusBadgeAttribute()
    {
        return match($this->stock_status) {
            'out_of_stock' => 'bg-danger',
            'low_stock' => 'bg-warning',
            'in_stock' => 'bg-success',
            default => 'bg-secondary',
        };
    }
}
