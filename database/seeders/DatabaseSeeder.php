<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\Kategori;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        Admin::firstOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('admin123')]
        );

        // 2. Data Kategori Sarana
        $kategoris = [
            ['id_kategori' => 1, 'ket_kategori' => 'Ruang Kelas & Perabot'],
            ['id_kategori' => 2, 'ket_kategori' => 'Laboratorium Komputer'],
            ['id_kategori' => 3, 'ket_kategori' => 'Toilet & Sanitasi'],
            ['id_kategori' => 4, 'ket_kategori' => 'Kelistrikan & AC'],
            ['id_kategori' => 5, 'ket_kategori' => 'Sarana Olahraga'],
            ['id_kategori' => 6, 'ket_kategori' => 'Perpustakaan'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::firstOrCreate(['id_kategori' => $kat['id_kategori']], $kat);
        }

        // 3. Data Siswa
        $siswas = [
            ['nis' => 10231, 'kelas' => 'XII RPL 1'],
            ['nis' => 10232, 'kelas' => 'XII RPL 2'],
            ['nis' => 10233, 'kelas' => 'XI TKJ 1'],
            ['nis' => 10234, 'kelas' => 'X DKV 2'],
        ];

        foreach ($siswas as $s) {
            Siswa::firstOrCreate(['nis' => $s['nis']], $s);
        }

        // 4. Sample Pengaduan & Aspirasi
        if (InputAspirasi::count() === 0) {
            $laporan1 = InputAspirasi::create([
                'nis' => 10231,
                'id_kategori' => 1,
                'lokasi' => 'Ruang Teori XII RPL 1',
                'ket' => 'Kipas angin plafon mati dan proyektor LCD buram.',
                'created_at' => now()->subDays(3),
            ]);

            Aspirasi::create([
                'id_pelaporan' => $laporan1->id_pelaporan,
                'status' => 'Selesai',
                'id_kategori' => 1,
                'feedback' => 'Kipas angin telah diperbaiki oleh tim teknisi, kabel VGA proyektor telah diganti baru.',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDay(),
            ]);

            $laporan2 = InputAspirasi::create([
                'nis' => 10232,
                'id_kategori' => 2,
                'lokasi' => 'Lab Komputer 3',
                'ket' => 'PC nomor 12 tidak bisa konek ke LAN dan internet sekolah.',
                'created_at' => now()->subDays(2),
            ]);

            Aspirasi::create([
                'id_pelaporan' => $laporan2->id_pelaporan,
                'status' => 'Proses',
                'id_kategori' => 2,
                'feedback' => 'Sedang dilakukan pengecekan kabel crimping RJ-45 dan konfigurasi switch port.',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subHours(5),
            ]);

            $laporan3 = InputAspirasi::create([
                'nis' => 10233,
                'id_kategori' => 3,
                'lokasi' => 'Toilet Siswa Lantai 2 Gedung B',
                'ket' => 'Kran air wastafel patah sehingga air terus mengalir terbuang.',
                'created_at' => now()->subHours(4),
            ]);

            Aspirasi::create([
                'id_pelaporan' => $laporan3->id_pelaporan,
                'status' => 'Menunggu',
                'id_kategori' => 3,
                'feedback' => null,
                'created_at' => now()->subHours(4),
            ]);
        }
    }
}
