<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inheritance;

class InheritanceSeeder extends Seeder
{
    public function run()
    {
        $simulations = [
            // User 1 - Budi Hermawan
            [
                'user_id' => 1,
                'title' => 'Simulasi Waris Keluarga Budi Utama',
                'total_assets' => 2500000000,
                'law_type' => 'islam',
                'heirs' => [
                    ['name' => 'Dewi Rahmawati', 'relation' => 'istri'],
                    ['name' => 'Fahri Hermawan', 'relation' => 'anak_laki'],
                    ['name' => 'Siti Hermawan', 'relation' => 'anak_perempuan'],
                ],
                'result' => [
                    ['name' => 'Dewi Rahmawati', 'relation' => 'istri', 'share' => 0.125, 'amount' => 312500000],
                    ['name' => 'Fahri Hermawan', 'relation' => 'anak_laki', 'share' => 0.5833, 'amount' => 1458333333],
                    ['name' => 'Siti Hermawan', 'relation' => 'anak_perempuan', 'share' => 0.2917, 'amount' => 729166667],
                ],
            ],

            // User 2 - Abdan Syakura Bin Yasir
            [
                'user_id' => 2,
                'title' => 'Simulasi Waris Utama Ruko & Sawah',
                'total_assets' => 2450000000,
                'law_type' => 'islam',
                'heirs' => [
                    ['name' => 'Sarah Rahmawati', 'relation' => 'istri'],
                    ['name' => 'Hasan Syakura', 'relation' => 'anak_laki'],
                    ['name' => 'Fatimah Syakura', 'relation' => 'anak_perempuan'],
                ],
                'result' => [
                    ['name' => 'Sarah Rahmawati', 'relation' => 'istri', 'share' => 0.125, 'amount' => 306250000],
                    ['name' => 'Hasan Syakura', 'relation' => 'anak_laki', 'share' => 0.5833, 'amount' => 1429166667],
                    ['name' => 'Fatimah Syakura', 'relation' => 'anak_perempuan', 'share' => 0.2917, 'amount' => 714583333],
                ],
            ],
            [
                'user_id' => 2,
                'title' => 'Simulasi Pembagian Rumah Dago Rata',
                'total_assets' => 1800000000,
                'law_type' => 'perdata',
                'heirs' => [
                    ['name' => 'Sarah Rahmawati', 'relation' => 'istri'],
                    ['name' => 'Hasan Syakura', 'relation' => 'anak_laki'],
                    ['name' => 'Fatimah Syakura', 'relation' => 'anak_perempuan'],
                ],
                'result' => [
                    ['name' => 'Sarah Rahmawati', 'relation' => 'istri', 'amount' => 600000000],
                    ['name' => 'Hasan Syakura', 'relation' => 'anak_laki', 'amount' => 600000000],
                    ['name' => 'Fatimah Syakura', 'relation' => 'anak_perempuan', 'amount' => 600000000],
                ],
            ],
        ];

        foreach ($simulations as $sim) {
            Inheritance::create($sim);
        }
    }
}