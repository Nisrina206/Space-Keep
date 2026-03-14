<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * ============================
     * TAMPILKAN NOTIF UNTUK USER LOGIN
     * ============================
     */
    public function index()
    {
        $user = Auth::user();

        $notif = Notifikasi::where('target_id', $user->id)
            ->where('role_penerima', $user->role)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partials.notifikasi', compact('notif'));
    }

    /**
     * ============================
     * BACA SATU NOTIF
     * ============================
     */
    public function baca($id)
{
    $notif = Notifikasi::findOrFail($id);

    if (
        $notif->target_id == Auth::id() &&
        $notif->role_penerima == Auth::user()->role
    ) {
        $notif->update(['is_read' => true]);
        return redirect($notif->link); // link sudah sesuai role
    }

    return back();
}

    /**
     * ============================
     * BACA SEMUA NOTIF
     * ============================
     */
    public function bacaSemua()
    {
        Notifikasi::where('target_id', Auth::id())
            ->where('role_penerima', Auth::user()->role)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }

    /**
     * ============================
     * NOTIF UNTUK ADMIN (AJAX)
     * ============================
     */
    public function admin()
    {
        $user = Auth::user();

        return Notifikasi::where('target_id', $user->id)
            ->where('role_penerima', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * ============================
     * NOTIF UNTUK SISWA (AJAX)
     * ============================
     */
    public function siswa()
    {
        $user = Auth::user();

        return Notifikasi::where('target_id', $user->id)
            ->where('role_penerima', 'siswa')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}