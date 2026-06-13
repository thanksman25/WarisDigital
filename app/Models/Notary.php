<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'license_number',
        'specialization',
        'is_verified',
        'rating',
    ];

    protected $casts = [
        'is_verified'    => 'boolean',
        'rating'         => 'float',
    ];
}