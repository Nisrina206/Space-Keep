<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    /**
     * =============================
     * INDEX (HISTORY - SELESAI)
     * =============================
     */
    public function index(Request $request)
    {
        // ================= PARAMETER =================
        $q    = $request->query('q');
        $from = $request->query('from');
        $to   = $request->query('to');
        $sort = $request->query('sort', 'desc');

        // ================= QUERY =================
        $histories = Aspirasi::with(['siswa', 'kategori'])
            ->where('status', 'selesai') // 🔥 KHUSUS SELESAI

            // 🔍 SEARCH
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

            // 📅 FILTER TANGGAL
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [
                    $from . ' 00:00:00',
                    $to   . ' 23:59:59',
                ]);
            })

            // 🔃 SORTING
            ->orderBy('created_at', $sort)

            // 📄 PAGINATION
            ->paginate(5)
            ->appends([
                'q'    => $q,
                'from' => $from,
                'to'   => $to,
                'sort' => $sort,
            ]);

        // ================= VIEW =================
        return view('admin.history.history', compact('histories'));
    }

    /**
     * =============================
     * LIVE SEARCH (AJAX) - HISTORY
     * =============================
     */
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('search');

        if (!$q) {
            return response()->json([]);
        }

        $data = Aspirasi::with(['siswa', 'kategori'])
            ->where('status', 'selesai')
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
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    /**
     * =============================
     * DETAIL HISTORY
     * =============================
     */
    public function show($id)
    {
        $histories = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);
        return view('admin.history.detail', compact('aspirasi'));
    }

    public function edit($id)
{
    $item = Aspirasi::findOrFail($id);

    return view('admin.history.edit', compact('item'));
}

public function cetakPerId($id)
{
    $row = Aspirasi::with(['siswa','kategori'])->findOrFail($id);

    $pdf = Pdf::loadView('pdf.cetak-per-id', compact('row'));

    return $pdf->download('aspirasi-'.$row->id_aspirasi.'.pdf');
}
}
