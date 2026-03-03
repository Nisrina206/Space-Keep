<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Notifikasi; 
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function admin()
    {
        $data = Aspirasi::with('siswa')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'judul' => 'Aspirasi Baru',
                    'pesan' => 'Aspirasi baru dari ' . $item->nama_siswa
                ];
            });

        return response()->json($data);
    }

    public function siswa()
{
    $user = Auth::user();

    $data = Notifikasi::where('target_id', $user->id)
        ->where('role_penerima', 'siswa')
        ->latest('created_at')
        ->take(5)
        ->get()
        ->map(function ($item) {
            return [
                'judul' => 'Update Aspirasi',
                'pesan' => $item->pesan
            ];
        });

    return response()->json($data);
}
}