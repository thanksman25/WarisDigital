<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaimGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution',  // 'bank', 'BPN', 'asuransi', dll
        'title',
        'description',
        'steps',        // JSON array of steps
        'documents_required', // JSON array of required documents
        'estimated_time',
        'is_active',
    ];

    protected $casts = [
        'steps'               => 'array',
        'documents_required'  => 'array',
        'is_active'           => 'boolean',
    ];
}