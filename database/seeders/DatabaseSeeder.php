<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User 1
        User::create([
            'id' => 1,
            'name' => 'Budi Hermawan',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // User 2
        User::create([
            'id' => 2,
            'name' => 'Abdan Syakura Bin Yasir',
            'email' => 'syakuraabdanby@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // User 3
        User::create([
            'id' => 3,
            'name' => 'Dewi Rahmawati',
            'email' => 'dewi@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            NotarySeeder::class,
            DocumentSeeder::class,
            AssetSeeder::class,
            ReminderSeeder::class,
            TimeCapsuleSeeder::class,
            ClaimGuideSeeder::class,
            InheritanceSeeder::class,
            AccessPermissionSeeder::class,
        ]);
    }
}
