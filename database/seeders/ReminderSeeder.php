<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reminder;

class ReminderSeeder extends Seeder
{
    public function run()
    {
        $reminders = [
            // User 1 - Budi Hermawan
            [
                'user_id' => 1,
                'document_id' => 1,
                'title' => 'Masa Berlaku KTP Kepala Keluarga',
                'message' => 'Segera perbarui KTP sebelum jatuh tempo',
                'remind_at' => now()->addDays(5),
                'is_sent' => false,
            ],
            [
                'user_id' => 1,
                'document_id' => 3,
                'title' => 'Perpanjang STNK Avanza',
                'message' => 'Siapkan dana untuk pembayaran pajak kendaraan bermotor tahunan',
                'remind_at' => now()->addDays(15),
                'is_sent' => false,
            ],

            // User 2 - Abdan Syakura Bin Yasir
            [
                'user_id' => 2,
                'document_id' => 5,
                'title' => 'Masa Berlaku Paspor Abdan',
                'message' => 'Paspor akan kedaluwarsa dalam 3 hari, segera jadwalkan pembuatan baru di kantor imigrasi.',
                'remind_at' => now()->addDays(3),
                'is_sent' => false,
            ],
            [
                'user_id' => 2,
                'document_id' => 9,
                'title' => 'Pajak STNK Tahunan Honda Civic',
                'message' => 'Pajak tahunan kendaraan sebesar Rp 4.500.000 harus dibayar di Samsat terdekat.',
                'remind_at' => now()->addDays(14),
                'is_sent' => false,
            ],
            [
                'user_id' => 2,
                'document_id' => 10,
                'title' => 'Jatuh Tempo Premi Asuransi Prudential',
                'message' => 'Pembayaran autodebet rekening untuk premi bulanan keluarga.',
                'remind_at' => now()->addDays(45),
                'is_sent' => false,
            ],
        ];

        foreach ($reminders as $reminder) {
            Reminder::create($reminder);
        }
    }
}