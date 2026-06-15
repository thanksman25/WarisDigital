<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessPermission;

class AccessPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Budi (User 1) memberikan akses ke Abdan (User 2)
            [
                'document_id' => 2, // Sertifikat Rumah Kebayoran
                'user_id' => 2,     // Abdan Syakura
                'permission' => 'view',
            ],
            [
                'document_id' => 3, // BPKB Toyota Avanza
                'user_id' => 2,     // Abdan Syakura
                'permission' => 'download',
            ],

            // Abdan (User 2) memberikan akses ke Dewi (User 3)
            [
                'document_id' => 7, // Sertifikat SHM Ruko Dago
                'user_id' => 3,     // Dewi Rahmawati
                'permission' => 'view',
            ],
            [
                'document_id' => 9, // BPKB Honda Civic
                'user_id' => 3,     // Dewi Rahmawati
                'permission' => 'download',
            ],
        ];

        foreach ($permissions as $perm) {
            AccessPermission::create($perm);
        }
    }
}