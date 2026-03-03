<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // tampilkan halaman register
    public function index()
    {
        return view('auth.register');
    }

    // proses register siswa
    public function store(Request $request)
    {
        $request->validate([
            'nis'            => 'required|min:4|unique:users,nis',
            'nama_lengkap'   => 'required|min:3',
            'kelas'          => 'required',
            'password'       => 'required|min:6|confirmed',
        ], [
            'nis.required'          => 'NIS wajib diisi.',
            'nis.min'               => 'NIS minimal 4 karakter.',
            'nis.unique'            => 'NIS sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'kelas.required'        => 'Kelas wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi sandi tidak sama.',
        ]);

        // 1️⃣ SIMPAN KE USERS (LOGIN)
        $user = User::create([
            'nis'      => $request->nis,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        // 2️⃣ SIMPAN KE SISWA (DATA DETAIL)
        Siswa::create([
            'user_id'       => $user->id,
            'nis'          => $request->nis,  
            'nama_lengkap'  => $request->nama_lengkap,
            'kelas'         => $request->kelas,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }
}
