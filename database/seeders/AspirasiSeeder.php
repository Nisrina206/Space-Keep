<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspirasi;
use Carbon\Carbon;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        // MENUNGGU
        for ($i = 1; $i <= 7; $i++) {
            Aspirasi::create([
                'siswa_id'    => 1,
                'nama_siswa' => 'Desi Rachma Hanisti',
                'id_kategori' => 1,
                'lokasi' => 'Lab ' . $i,
                'ket_laporan' => 'AC tidak dingin di Lab ' . $i,
                'foto_bukti' => 'aspirasi/bukti.png',
                'status' => 'Menunggu',
                'created_at' => Carbon::now()->subDays($i),
            ]);
        }

        // DIPROSES
        for ($i = 1; $i <= 6; $i++) {
            Aspirasi::create([
                'siswa_id'    => 2,
                'nama_siswa' => 'Shiva Dewi',
                'id_kategori' => 1,
                'lokasi' => 'Kelas ' . $i,
                'ket_laporan' => 'Lampu mati di kelas ' . $i,
                'foto_bukti' => 'aspirasi/bukti.png',
                'status' => 'Diproses',
                'created_at' => Carbon::now()->subDays($i + 7),
            ]);
        }

        // SELESAI
        for ($i = 1; $i <= 6; $i++) {
            Aspirasi::create([
                'siswa_id'    => 2,
                'nama_siswa' => 'Shiva Dewi',
                'id_kategori' => 1,
                'lokasi' => 'Kelas ' . $i,
                'ket_laporan' => 'Lampu mati di kelas ' . $i,
                'foto_bukti' => 'aspirasi/bukti.png',
                'status' => 'Selesai',
                'created_at' => Carbon::now()->subDays($i + 7),
            ]);
        }
    }
}