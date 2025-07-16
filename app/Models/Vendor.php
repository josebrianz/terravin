<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person',
        'phone',
        'years_in_operation',
        'employees',
        'turnover',
        'material',
        'clients',
        'certification_organic',
        'certification_iso',
        'regulatory_compliance',
        'validation_status',
        'application_pdf',
    ];

    // Optional: define relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
