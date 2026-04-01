<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Cegah duplicate berdasarkan role siswa
        if (User::where('role', 'siswa')->count() > 0) {
            return;
        }

        // SISWA 1
        $user1 = User::create([
            'nis' => 'SIS001',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $user1->id,
            'nama_lengkap' => 'Desi Rachma Hanisti',
            'kelas' => 'X-A',
        ]);

        // SISWA 2
        $user2 = User::create([
            'nis' => 'SIS002',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $user2->id,
            'nama_lengkap' => 'Shiva Dwi Putri',
            'kelas' => 'X-B',
        ]);
    }
}