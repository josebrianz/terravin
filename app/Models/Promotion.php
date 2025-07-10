<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title', 'message', 'start_date', 'end_date', 'is_active'
    ];
}
