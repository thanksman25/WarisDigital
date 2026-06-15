<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run()
    {
        $assets = [
            // User 1 - Budi Hermawan
            [
                'user_id' => 1,
                'name' => 'Rumah Kebayoran Baru',
                'type' => 'rumah',
                'value' => 2500000000,
                'location' => 'Kebayoran Baru, Jakarta Selatan',
                'document_id' => 2,
                'is_active' => true,
            ],
            [
                'user_id' => 1,
                'name' => 'Toyota Avanza 2022',
                'type' => 'kendaraan',
                'value' => 230000000,
                'location' => 'Garasi Rumah Kebayoran',
                'document_id' => 3,
                'is_active' => true,
            ],
            [
                'user_id' => 1,
                'name' => 'Tabungan Dana Darurat Mandiri',
                'type' => 'tabungan',
                'value' => 150000000,
                'location' => 'Bank Mandiri KC Jakarta',
                'document_id' => 4,
                'is_active' => true,
            ],

            // User 2 - Abdan Syakura Bin Yasir
            [
                'user_id' => 2,
                'name' => 'Ruko Dago Bandung',
                'type' => 'rumah',
                'value' => 1800000000,
                'location' => 'Jl. Ir. H. Juanda No. 102, Dago, Bandung',
                'document_id' => 7,
                'is_active' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'Sawah Warisan Cianjur',
                'type' => 'tanah',
                'value' => 650000000,
                'location' => 'Cipanas, Cianjur, Jawa Barat',
                'document_id' => 8,
                'is_active' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'Honda Civic 1.5 Turbo Hatchback',
                'type' => 'kendaraan',
                'value' => 480000000,
                'location' => 'Garasi Ruko Dago',
                'document_id' => 9,
                'is_active' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'Tabungan Rencana BCA',
                'type' => 'tabungan',
                'value' => 320000000,
                'location' => 'BCA KCP Dago Bandung',
                'document_id' => 10,
                'is_active' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'Portofolio Saham BBRI & TLKM',
                'type' => 'investasi',
                'value' => 150000000,
                'location' => 'Aplikasi Ajaib Sekuritas',
                'document_id' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}