<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeCapsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'document_id',
        'unlock_at',
        'unlock_condition', // 'date', 'death', 'manual'
        'is_unlocked',
    ];

    protected $casts = [
        'unlock_at'  => 'datetime',
        'is_unlocked' => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Document
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}