<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workforce extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'role', 'status', 'contact',
    ];

    public function supplyCentres()
    {
        return $this->belongsToMany(SupplyCentre::class, 'supply_centre_workforce')->withTimestamps()->withPivot('assigned_at');
    }
} 