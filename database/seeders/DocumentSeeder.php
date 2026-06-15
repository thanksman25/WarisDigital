<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        $documents = [
            // User 1 - Budi Hermawan
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'KTP Kepala Keluarga Budi',
                'description' => 'Kartu Tanda Penduduk Utama',
                'file_path' => 'dummy',
                'file_type' => 'Identitas',
                'file_size' => 102400,
                'is_encrypted' => false,
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Sertifikat Rumah Kebayoran',
                'description' => 'Sertifikat Hak Milik SHM No. 4567',
                'file_path' => 'dummy',
                'file_type' => 'Properti',
                'file_size' => 2048576,
                'is_encrypted' => false,
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'BPKB Toyota Avanza',
                'description' => 'BPKB atas nama Budi Hermawan',
                'file_path' => 'dummy',
                'file_type' => 'Kendaraan',
                'file_size' => 512000,
                'is_encrypted' => false,
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'Buku Tabungan BCA Mandiri',
                'description' => 'Buku Rekening Utama Tabungan',
                'file_path' => 'dummy',
                'file_type' => 'Keuangan',
                'file_size' => 819200,
                'is_encrypted' => false,
            ],

            // User 2 - Abdan Syakura Bin Yasir
            [
                'id' => 5,
                'user_id' => 2,
                'title' => 'KTP Abdan Syakura',
                'description' => 'Kartu Tanda Penduduk Republik Indonesia',
                'file_path' => 'dummy',
                'file_type' => 'Identitas',
                'file_size' => 125000,
                'is_encrypted' => false,
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'title' => 'Kartu Keluarga Yasir',
                'description' => 'Kartu Keluarga Asli legalisir',
                'file_path' => 'dummy',
                'file_type' => 'Identitas',
                'file_size' => 450000,
                'is_encrypted' => false,
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'title' => 'Sertifikat Hak Milik Ruko Dago',
                'description' => 'SHM No. 9012 - Ruko 2 Lantai Bandung',
                'file_path' => 'dummy',
                'file_type' => 'Properti',
                'file_size' => 3150000,
                'is_encrypted' => false,
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'title' => 'Sertifikat Tanah Sawah Cianjur',
                'description' => 'Surat kepemilikan sawah warisan keluarga',
                'file_path' => 'dummy',
                'file_type' => 'Properti',
                'file_size' => 1800000,
                'is_encrypted' => false,
            ],
            [
                'id' => 9,
                'user_id' => 2,
                'title' => 'BPKB Honda Civic 1.5 Turbo',
                'description' => 'BPKB plat nomor B 1234 WDF',
                'file_path' => 'dummy',
                'file_type' => 'Kendaraan',
                'file_size' => 750000,
                'is_encrypted' => false,
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'title' => 'Polis Asuransi Prudential',
                'description' => 'Polis asuransi jiwa & kesehatan keluarga',
                'file_path' => 'dummy',
                'file_type' => 'Keuangan',
                'file_size' => 1500000,
                'is_encrypted' => false,
            ],
            [
                'id' => 11,
                'user_id' => 2,
                'title' => 'Deposito Bank Mandiri',
                'description' => 'Sertifikat deposito berjangka',
                'file_path' => 'dummy',
                'file_type' => 'Keuangan',
                'file_size' => 950000,
                'is_encrypted' => false,
            ],
            [
                'id' => 12,
                'user_id' => 2,
                'title' => 'Akte Kelahiran Anak Pertama',
                'description' => 'Akte kelahiran anak pertama dari catatan sipil',
                'file_path' => 'dummy',
                'file_type' => 'Lainnya',
                'file_size' => 600000,
                'is_encrypted' => false,
            ],
        ];

        foreach ($documents as $doc) {
            Document::create($doc);
        }
    }
}