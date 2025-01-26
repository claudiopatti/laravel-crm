<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use AsSource;
    // use HasFactory;

    protected $fillable = [
        'name',
        'vat_number',
        'logo'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
