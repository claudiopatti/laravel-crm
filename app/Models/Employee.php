<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;


class Employee extends Model
{
    use AsSource;
    // use HasFactory;

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
