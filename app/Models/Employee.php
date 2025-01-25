<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'company_you_belong_to',
        'phone',
        'email',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
        
    }
}
