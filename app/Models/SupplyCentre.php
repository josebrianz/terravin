<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyCentre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location',
    ];

    public function workforces()
    {
        return $this->belongsToMany(Workforce::class, 'supply_centre_workforce')->withTimestamps()->withPivot('assigned_at');
    }
} 