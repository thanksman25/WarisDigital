<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inheritance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'total_assets',
        'law_type',      // 'islam', 'perdata', 'adat'
        'heirs',         // JSON array of heirs
        'result',        // JSON hasil pembagian
    ];

    protected $casts = [
        'total_assets' => 'float',
        'heirs'        => 'array',
        'result'       => 'array',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}