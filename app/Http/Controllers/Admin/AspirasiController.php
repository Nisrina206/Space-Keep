<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Illuminate\Http\JsonResponse;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    /**
     * =============================
     * INDEX (PAGE UTAMA)
     * =============================
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'menunggu');
        $q      = $request->query('q');
        $from   = $request->query('from');
        $to     = $request->query('to');
        $sort   = $request->query('sort', 'desc');

        $aspirasi = Aspirasi::with(['siswa', 'kategori'])
            ->where('status', $status)

            // SEARCH
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->whereHas('siswa', function ($s) use ($q) {
                        $s->where('nis', 'like', "%{$q}%")
                          ->orWhere('nama_lengkap', 'like', "%{$q}%");
                    })
                    ->orWhereHas('kategori', function ($k) use ($q) {
                        $k->where('ket_kategori', 'like', "%{$q}%");
                    })
                    ->orWhere('lokasi', 'like', "%{$q}%");
                });
            })

            // FILTER TANGGAL
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [
                    $from . ' 00:00:00',
                    $to   . ' 23:59:59',
                ]);
            })

            // SORTING
            ->orderBy('created_at', $sort)

            // PAGINATION
            ->paginate(5)
            ->appends(compact('status', 'q', 'from', 'to', 'sort'));

        $menungguCount = Aspirasi::where('status', 'menunggu')->count();
        $diprosesCount = Aspirasi::where('status', 'diproses')->count();

        return view('admin.aspirasi.index', compact(
            'aspirasi',
            'status',
            'menungguCount',
            'diprosesCount'
        ));
    }

    /**
     * =============================
     * LIVE SEARCH (AJAX)
     * =============================
     */
    public function search(Request $request): JsonResponse
    {
        $q      = $request->query('search');
        $status = $request->query('status', 'menunggu');

        if (!$q) {
            return response()->json([]);
        }

        $data = Aspirasi::with(['siswa', 'kategori'])
            ->where('status', $status)
            ->where(function ($query) use ($q) {
                $query
                    ->whereHas('siswa', function ($s) use ($q) {
                        $s->where('nis', 'like', "%{$q}%")
                          ->orWhere('nama_lengkap', 'like', "%{$q}%");
                    })
                    ->orWhereHas('kategori', function ($k) use ($q) {
                        $k->where('ket_kategori', 'like', "%{$q}%");
                    })
                    ->orWhere('lokasi', 'like', "%{$q}%");
            })
            ->latest()
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    /**
     * =============================
     * DETAIL ASPIRASI
     * =============================
     */
    public function show($id)
    {
        $item = Aspirasi::findOrFail($id);

        return redirect()->route('admin.aspirasi', [
            'status' => $item->status,
            'highlight' => $item->id
        ]);
    }

    /**
     * =============================
     * EDIT ASPIRASI
     * =============================
     */
    public function edit($id)
    {
        $item = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);

        return view('admin.aspirasi.edit', compact('item'));
    }

    /**
     * =============================
     * UPDATE STATUS
     * =============================
     */
    public function update(Request $request, $id)
    {
        $item = Aspirasi::with('siswa')->findOrFail($id);

        // Update status
        $item->status = $request->status;
        $item->save();

        // ==========================
        // 🔔 BUAT NOTIF KE SISWA
        // ==========================
        // tentukan route link sesuai status
        $statusLower = strtolower($request->status);

        switch ($statusLower) {
            case 'menunggu':
                $link = route('siswa.status.menunggu');
                break;
            case 'diproses':
                $link = route('siswa.status.diproses');
                break;
            case 'selesai':
                $link = route('siswa.status.selesai');
                break;
            default:
                $link = route('siswa.aspirasi'); // fallback
        }

        Notifikasi::create([
            'pengirim_id'   => Auth::id(),
            'target_id'     => $item->siswa->user_id,
            'role_penerima' => 'siswa',
            'judul'         => 'Status Aspirasi Diperbarui',
            'pesan'         => 'Status aspirasi kamu sekarang: '.$request->status,
            'link'          => $link,
            'is_read'       => false
        ]);

        return redirect()->route('admin.aspirasi')
            ->with('success', 'Status berhasil diubah');
    }

    /**
     * =============================
     * HISTORY (STATUS SELESAI)
     * =============================
     */
    public function history()
    {
        $aspirasi = Aspirasi::with(['kategori', 'siswa'])
            ->where('status', 'Selesai')
            ->latest()
            ->paginate(10);

        return view('admin.aspirasi.index', [
            'aspirasi' => $aspirasi,
            'mode' => 'history',

            // cegah error blade
            'status' => 'history',
            'menungguCount' => 0,
            'diprosesCount' => 0
        ]);
    }
}