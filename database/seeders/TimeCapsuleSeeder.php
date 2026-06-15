<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeCapsule;

class TimeCapsuleSeeder extends Seeder
{
    public function run()
    {
        $capsules = [
            // User 1 - Budi Hermawan
            [
                'user_id' => 1,
                'title' => 'Surat Wasiat Pembagian Waris',
                'message' => 'Harap dibagi sesuai hasil simulasi yang sudah saya simpan.',
                'document_id' => 2,
                'unlock_condition' => 'death',
                'unlock_at' => null,
                'is_unlocked' => false,
            ],

            // User 2 - Abdan Syakura Bin Yasir
            [
                'user_id' => 2,
                'title' => 'Pesan Video Kelulusan Anak',
                'message' => 'Pesan ucapan selamat wisuda yang direkam di Bandung untuk dibuka tahun 2028.',
                'document_id' => 12,
                'unlock_condition' => 'date',
                'unlock_at' => now()->addYears(2),
                'is_unlocked' => false,
            ],
            [
                'user_id' => 2,
                'title' => 'Kunci Brankas Rahasia Logam Mulia',
                'message' => 'Brankas fisik berada di dalam lemari kamar utama dengan kode PIN 140698.',
                'document_id' => null,
                'unlock_condition' => 'manual',
                'unlock_at' => null,
                'is_unlocked' => false,
            ],
            [
                'user_id' => 2,
                'title' => 'Surat Wasiat & Legacy Keluarga',
                'message' => 'Semua amanah tertulis berada di sertifikat tanah dan ruko. Harap kelola dengan bijaksana.',
                'document_id' => 7,
                'unlock_condition' => 'death',
                'unlock_at' => null,
                'is_unlocked' => false,
            ],
        ];

        foreach ($capsules as $capsule) {
            TimeCapsule::create($capsule);
        }
    }
}