<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Barryvdh\DomPDF\Facade\Pdf;

class StatusController extends Controller
{
    public function cetak(Request $request)
{
    $data = collect();

    if ($request->opsi === 'all') {

        $data = Aspirasi::with('siswa','kategori')
            ->latest()
            ->get();
    }

    if ($request->opsi === 'range') {

        $mulai = \Carbon\Carbon::parse($request->mulai)->startOfDay();
        $akhir = \Carbon\Carbon::parse($request->akhir)->endOfDay();

        $data = Aspirasi::with('siswa','kategori')
            ->whereBetween('created_at', [$mulai, $akhir])
            ->latest()
            ->get();
    }

   $pdf = PDF::loadView('admin.aspirasi.cetak', compact('data'))
          ->setPaper('A4', 'landscape');

return $pdf->download('laporan.pdf');
}
}