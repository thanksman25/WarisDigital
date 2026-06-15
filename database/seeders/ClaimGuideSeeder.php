<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClaimGuide;

class ClaimGuideSeeder extends Seeder
{
    public function run()
    {
        // BPJS
        ClaimGuide::create([
            'institution' => 'BPJS',
            'title' => 'Klaim Jaminan Kematian (JKM) BPJS Ketenagakerjaan',
            'description' => 'Panduan pengajuan klaim Jaminan Kematian bagi ahli waris dari peserta BPJS Ketenagakerjaan yang meninggal dunia.',
            'steps' => [
                'Siapkan seluruh dokumen persyaratan klaim JKM.',
                'Kunjungi kantor cabang BPJS Ketenagakerjaan terdekat.',
                'Ambil nomor antrean untuk pengurusan klaim kematian.',
                'Serahkan berkas dokumen kepada petugas untuk diverifikasi.',
                'Tunggu proses verifikasi dan pencairan dana ke rekening ahli waris (sekitar 7-14 hari kerja).'
            ],
            'documents_required' => [
                'Kartu Peserta BPJS Ketenagakerjaan (Asli)',
                'Surat Keterangan Kematian dari Kelurahan/RS (Kutipan Akta Kematian)',
                'Kartu Keluarga (KK) ahli waris',
                'KTP ahli waris',
                'Surat Keterangan Ahli Waris dari RT/RW/Kelurahan',
                'Buku Tabungan ahli waris (rekening aktif)'
            ],
            'estimated_time' => '7-14 Hari Kerja',
            'is_active' => true,
        ]);

        // Bank
        ClaimGuide::create([
            'institution' => 'Bank',
            'title' => 'Pencairan / Penutupan Rekening Tabungan Almarhum',
            'description' => 'Prosedur resmi untuk memindahkan saldo tabungan almarhum ke rekening ahli waris atau melakukan penutupan rekening.',
            'steps' => [
                'Melapor ke layanan pelanggan (Customer Service) kantor cabang bank asal rekening.',
                'Petugas akan memblokir rekening sementara untuk keamanan dana.',
                'Serahkan dokumen identitas ahli waris dan bukti hak waris.',
                'Semua ahli waris yang sah menandatangani surat persetujuan pencairan/penutupan di hadapan petugas bank.',
                'Bank mencairkan dana tunai atau mentransfer saldo ke rekening ahli waris yang ditunjuk.'
            ],
            'documents_required' => [
                'Buku Tabungan & Kartu ATM Almarhum',
                'Kutipan Akta Kematian asli & fotokopi',
                'Surat Keterangan Ahli Waris resmi (notaris/kecamatan)',
                'KTP asli seluruh ahli waris',
                'Kartu Keluarga (KK) almarhum & ahli waris',
                'Surat kuasa bermaterai (jika diwakilkan salah satu ahli waris)'
            ],
            'estimated_time' => '3-5 Hari Kerja',
            'is_active' => true,
        ]);

        // Asuransi
        ClaimGuide::create([
            'institution' => 'Asuransi',
            'title' => 'Klaim Uang Pertanggungan Asuransi Jiwa',
            'description' => 'Cara mengajukan klaim manfaat polis asuransi jiwa almarhum untuk dicairkan kepada penerima manfaat (beneficiary).',
            'steps' => [
                'Hubungi Agen Asuransi atau Call Center resmi perusahaan asuransi terkait.',
                'Unduh dan isi Formulir Pengajuan Klaim Meninggal Dunia.',
                'Lengkapi seluruh dokumen medis dan administrasi yang diminta.',
                'Kirim berkas fisik dokumen klaim ke kantor pusat asuransi.',
                'Proses analisis klaim oleh tim underwriter (memakan waktu 14-30 hari).',
                'Pencairan uang pertanggungan langsung ke rekening ahli waris.'
            ],
            'documents_required' => [
                'Polis Asuransi Jiwa (Asli)',
                'Formulir Klaim Meninggal Dunia yang sudah diisi',
                'Surat Keterangan Kematian dari Instansi Pemerintah',
                'Surat Keterangan Medis penyebab kematian dari RS',
                'KTP & Kartu Keluarga Pemegang Polis dan Penerima Manfaat',
                'Buku Tabungan Penerima Manfaat'
            ],
            'estimated_time' => '14-30 Hari Kerja',
            'is_active' => true,
        ]);

        // Properti
        ClaimGuide::create([
            'institution' => 'Properti',
            'title' => 'Turun Waris Sertifikat Tanah & Bangunan (BPN)',
            'description' => 'Langkah-langkah balik nama sertifikat properti (SHM/SHGB) atas nama almarhum menjadi atas nama para ahli waris.',
            'steps' => [
                'Membuat Surat Tanda Bukti Ahli Waris yang disahkan pejabat berwenang.',
                'Membayar Pajak Perolehan Hak atas Tanah dan Bangunan karena Warisan (BPHTB Waris).',
                'Mendatangi Kantor Pertanahan (BPN) setempat sesuai lokasi properti.',
                'Mengajukan permohonan pendaftaran peralihan hak karena warisan.',
                'BPN memproses pencatatan balik nama pada buku tanah sertifikat.'
            ],
            'documents_required' => [
                'Sertifikat Tanah Asli (SHM/SHGB)',
                'Surat Keterangan Kematian & Surat Keterangan Ahli Waris',
                'Bukti Bayar BPHTB Waris (SSPD BPHTB)',
                'KTP & KK seluruh ahli waris',
                'Fotokopi SPPT PBB tahun berjalan yang telah dilunasi',
                'Formulir permohonan balik nama dari BPN'
            ],
            'estimated_time' => '1-3 Bulan',
            'is_active' => true,
        ]);

        // Kendaraan
        ClaimGuide::create([
            'institution' => 'Kendaraan',
            'title' => 'Balik Nama BPKB & STNK Kendaraan Warisan',
            'description' => 'Prosedur balik nama kepemilikan mobil atau motor peninggalan almarhum di kantor Samsat terdekat.',
            'steps' => [
                'Lakukan cek fisik kendaraan di kantor Samsat tujuan.',
                'Lakukan pendaftaran balik nama STNK di loket Samsat.',
                'Membayar biaya balik nama kendaraan bermotor (BBNKB) dan pajak tahunan.',
                'Ambil STNK baru yang sudah atas nama ahli waris.',
                'Datangi Polda/Polres setempat untuk pengurusan pencetakan BPKB baru.'
            ],
            'documents_required' => [
                'BPKB & STNK Asli Kendaraan',
                'KTP Asli ahli waris penerima kendaraan',
                'Surat Keterangan Kematian & Surat Keterangan Ahli Waris',
                'Surat Persetujuan Bersama pembagian waris kendaraan',
                'Bukti Cek Fisik Kendaraan asli'
            ],
            'estimated_time' => '3-7 Hari Kerja',
            'is_active' => true,
        ]);
    }
}