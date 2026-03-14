<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DashboardController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        // jumlah siswa
        $jumlahSiswa = Siswa::count();

        // jumlah aspirasi
        $aspirasiDiproses = Aspirasi::where('status', 'diproses')->count();
        $aspirasiSelesai  = Aspirasi::where('status', 'selesai')->count();

        // 3 aspirasi terbaru status MENUNGGU
        $aspirasiTerbaru = Aspirasi::with(['siswa','kategori'])
            ->where('status','menunggu')
            ->latest()
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'jumlahSiswa',
            'aspirasiDiproses',
            'aspirasiSelesai',
            'aspirasiTerbaru'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Aspirasi
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $aspirasi = Aspirasi::with(['siswa','kategori'])->findOrFail($id);

        return view('admin.aspirasi-detail', compact('aspirasi'));
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Sandi Siswa
    |--------------------------------------------------------------------------
    */

   public function resetSandi($id)
{
    $siswa = Siswa::findOrFail($id);

    $passwordBaru = Str::random(8);

    $siswa->password = Hash::make($passwordBaru);
    $siswa->save();

    return redirect()->back()->with('passwordBaru', $passwordBaru);
}

}