<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class AspirasiSiswaController extends Controller
{
    /**
     * =============================
     * INDEX ASPIRASI SISWA
     * =============================
     */
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $status   = $request->status;

        $query = Aspirasi::where('siswa_id', Auth::user()->siswa->id);

        if ($status) {
            $query->where('status', $status);
        }

        $aspirasi = $query->get();

        return view('siswa.aspirasi', compact('kategori','aspirasi','status'));
    }

    /**
     * =============================
     * STORE ASPIRASI BARU
     * =============================
     */
    public function store(Request $request)
    {
        try {

            // =========================
            // ✅ VALIDASI
            // =========================
            $request->validate([
                'kategori_id' => 'required',
                'lokasi'      => 'required',
                'keterangan'  => 'required',
                'bukti'       => 'required|image',
            ]);

            // =========================
            // ✅ UPLOAD FOTO
            // =========================
            $path = $request->file('bukti')->store('aspirasi', 'public');

            // =========================
            // ✅ INSERT DATABASE ASPIRASI
            // =========================
            $aspirasi = Aspirasi::create([
                'siswa_id'    => $request->user()->siswa->id,
                'nama_siswa'  => $request->user()->siswa->nama_lengkap,
                'id_kategori' => $request->kategori_id,
                'lokasi'      => $request->lokasi,
                'ket_laporan' => $request->keterangan,
                'foto_bukti'  => $path,
                'status'      => 'Menunggu',
            ]);

            // ===============================
            // 🔔 BUAT NOTIF KE ADMIN
            // ===============================
            $admin = User::where('role','admin')->first();

            if ($admin && $aspirasi) {

                Notifikasi::create([
                    'pengirim_id'   => Auth::id(),
                    'target_id'     => $admin->id,
                    'role_penerima' => 'admin',
                    'judul'         => 'Aspirasi Masuk',
                    'pesan'         => 'Aspirasi baru dari '.$request->user()->siswa->nama_lengkap,
                    'link'          => route('admin.aspirasi'), // admin tetap diarahkan ke menu admin
                    'is_read'       => false
                ]);
            }

            // ===============================
            // ✅ REDIRECT + SUCCESS
            // ===============================
            return redirect()
                ->route('siswa.aspirasi')
                ->with('success', 'Aspirasi berhasil disimpan');

        } catch (\Exception $e) {

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * =============================
     * BACA NOTIFIKASI SISWA
     * =============================
     */
    public function bacaNotif($id)
    {
        $notif = Notifikasi::findOrFail($id);

        // Pastikan notif milik user dan role sesuai
        if ($notif->target_id == Auth::id() && $notif->role_penerima == 'siswa') {
            $notif->update(['is_read' => true]);
        }

        // redirect ke link yang sudah tersimpan di database (status menunggu/diproses/selesai)
        return redirect($notif->link);
    }

    /**
     * =============================
     * BACA SEMUA NOTIF
     * =============================
     */
    public function bacaSemuaNotif()
    {
        Notifikasi::where('target_id', Auth::id())
            ->where('role_penerima', 'siswa')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }
}