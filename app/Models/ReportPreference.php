<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPreference extends Model
{
    protected $fillable = ['stakeholder_id', 'frequency', 'format', 'report_types'];

    protected $casts = [
        'report_types' => 'array',
    ];

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class);
    }
}