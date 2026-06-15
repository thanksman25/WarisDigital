<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Notary::insert([
            [
                'name' => 'Dr. Hendra Wijaya, S.H., M.Kn.',
                'email' => 'hendra@notaris.id',
                'phone' => '0812-3456-7890',
                'address' => 'Jl. Sudirman No. 12',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'license_number' => 'NTR-12345',
                'specialization' => 'Waris & Properti',
                'is_verified' => true,
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahayu, S.H., M.Kn.',
                'email' => 'siti@notaris.id',
                'phone' => '0813-9876-5432',
                'address' => 'Jl. Merdeka No. 45',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'license_number' => 'NTR-67890',
                'specialization' => 'Balik Nama & Akta',
                'is_verified' => true,
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
