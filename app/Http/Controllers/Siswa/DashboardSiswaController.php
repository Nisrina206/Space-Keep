<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;


class DashboardSiswaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->siswa) {
            abort(403, 'Data siswa tidak ditemukan');
        }

        $siswaId = $user->siswa->id;

        $aspirasiMenunggu = Aspirasi::where('siswa_id', $siswaId)
            ->where('status', 'Menunggu')
            ->count();

        $aspirasiDiproses = Aspirasi::where('siswa_id', $siswaId)
            ->where('status', 'Diproses')
            ->count();

        $aspirasiSelesai = Aspirasi::where('siswa_id', $siswaId)
            ->where('status', 'Selesai')
            ->count();

        $aspirasiTerbaru = Aspirasi::where('siswa_id', $siswaId)
            ->latest()
            ->take(3)
            ->get();

        return view('siswa.dashboard', [
            'aspirasiMenunggu' => $aspirasiMenunggu,
            'aspirasiDiproses' => $aspirasiDiproses,
            'aspirasiSelesai'  => $aspirasiSelesai,
            'aspirasiTerbaru'  => $aspirasiTerbaru,
        ]);
    }

    public function detail($id)
    {
        $aspirasi = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);

        return view('admin.aspirasi-detail', compact('aspirasi'));
    }

    public function menunggu(Request $request)
{
    $user = Auth::user();

    if (!$user->siswa) {
        abort(403, 'Data siswa tidak ditemukan');
    }

    $sort = $request->sort === 'asc' ? 'asc' : 'desc';

    $query = Aspirasi::with(['siswa','kategori'])
        ->where('siswa_id', $user->siswa->id)
        ->where('status', 'Menunggu');

    /* ================= FILTER ================= */

    // FILTER KATEGORI
    if ($request->kategori) {
        $query->where('kategori_id', $request->kategori);
    }

    // FILTER TANGGAL
    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $data = $query
        ->orderBy('created_at', $sort)
        ->paginate(5)
        ->withQueryString();

    $kategoriList = Kategori::orderBy('ket_kategori')->get();

    return view('siswa.status.menunggu', compact('data','kategoriList'));
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


     public function diproses(Request $request)
{
    $user = Auth::user();

    if (!$user->siswa) {
        abort(403, 'Data siswa tidak ditemukan');
    }

    $sort = $request->sort === 'asc' ? 'asc' : 'desc';

    $query = Aspirasi::with(['siswa','kategori'])
        ->where('siswa_id', $user->siswa->id)
        ->where('status', 'Diproses');

    /* ================= FILTER ================= */

    // FILTER KATEGORI
    if ($request->kategori) {
        $query->where('kategori_id', $request->kategori);
    }

    // FILTER TANGGAL
    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $data = $query
        ->orderBy('created_at', $sort)
        ->paginate(5)
        ->withQueryString();

    $kategoriList = Kategori::orderBy('ket_kategori')->get();

    return view('siswa.status.diproses', compact('data','kategoriList'));
}

 /**
     * =============================
     * LIVE SEARCH (AJAX)
     * =============================
     */
    public function searchproses(Request $request): JsonResponse
    {
        $q      = $request->query('search');
        $status = $request->query('status', 'diproses');

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


    public function selesai(Request $request)
{
    $user = Auth::user();

    if (!$user->siswa) {
        abort(403, 'Data siswa tidak ditemukan');
    }

    $sort = $request->sort === 'asc' ? 'asc' : 'desc';

    $query = Aspirasi::with(['siswa','kategori'])
        ->where('siswa_id', $user->siswa->id)
        ->where('status', 'Selesai');

    /* ================= FILTER ================= */

    // FILTER KATEGORI
    if ($request->kategori) {
        $query->where('kategori_id', $request->kategori);
    }

    // FILTER TANGGAL
    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $data = $query
        ->orderBy('created_at', $sort)
        ->paginate(5)
        ->withQueryString();

    $kategoriList = Kategori::orderBy('ket_kategori')->get();

    return view('siswa.status.selesai', compact('data','kategoriList'));
}

 /**
     * =============================
     * LIVE SEARCH (AJAX)
     * =============================
     */
    public function searchselesai(Request $request): JsonResponse
    {
        $q      = $request->query('search');
        $status = $request->query('status', 'selesai');

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

}

