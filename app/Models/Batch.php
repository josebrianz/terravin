<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'product_id',
        'quantity',
        'manufacture_date',
        'expiry_date',
    ];

    public function product()
    {
        return $this->belongsTo(Inventory::class, 'product_id');
    }
}
