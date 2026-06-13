<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',         // 'tanah', 'rumah', 'kendaraan', 'tabungan', 'investasi', dll
        'description',
        'value',        // estimasi nilai aset
        'location',     // alamat/lokasi aset
        'latitude',
        'longitude',
        'document_id',  // dokumen terkait
        'is_active',
    ];

    protected $casts = [
        'value'     => 'float',
        'latitude'  => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
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