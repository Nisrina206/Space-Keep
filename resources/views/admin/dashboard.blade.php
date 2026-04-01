@extends('layouts.admin')

@section('navbar-title', 'Dashboard')

@section('content')

{{-- ================= WELCOME CARD ================= --}}
<div class="welcome-card">
    <div class="welcome-text">
        <h2>Selamat Datang, Admin!</h2>
        <p>Dashboard ini menampilkan ringkasan aspirasi dan status penanganan.</p>
    </div>

    <div class="welcome-image">
        <img src="{{ asset('img/admin.png') }}" alt="Welcome">
    </div>
</div>

{{-- ================= STATISTIK CARD ================= --}}
<div class="stat-grid">

    {{-- CARD DATA SISWA --}}
    <a href="{{ route('admin.siswa') }}" class="stat-card blue card-link">
        <div class="stat-text">
            <span>Data Siswa</span>
            <p>Total</p>
            <h3>{{ $jumlahSiswa }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/data.png') }}" alt="Data Siswa">
        </div>
    </a>

    {{-- CARD ASPIRASI DIPROSES --}}
    <a href="{{ route('admin.aspirasi', ['status' => 'diproses']) }}" class="stat-card yellow card-link">
        <div class="stat-text">
            <span>Aspirasi Diproses</span>
            <p>Total</p>
            <h3>{{ $aspirasiDiproses }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/proses.png') }}" alt="Diproses">
        </div>
    </a>

    {{-- CARD ASPIRASI SELESAI --}}
    <a href="{{ route('admin.history') }}" class="stat-card green card-link">
        <div class="stat-text">
            <span>Aspirasi Selesai</span>
            <p>Total</p>
            <h3>{{ $aspirasiSelesai }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/selesai.png') }}" alt="Selesai">
        </div>
    </a>

</div>

{{-- ================= TABEL ASPIRASI ================= --}}
<div class="table-card">

    <div class="table-header">
        <h3>Status Aspirasi Terbaru</h3>
    </div>

    <table class="aspirasi-table">
        <thead>
            <tr>
                <th>ID Pelaporan</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Lampiran</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($aspirasiTerbaru as $item)
            <tr
                onclick="window.location='{{ route('admin.aspirasi') }}'"
                style="cursor:pointer"
            >
                <td>
                    LP-{{ str_pad($loop->iteration, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                <td>{{ $item->siswa?->nis ?? '-' }}</td>
                <td>{{ $item->siswa?->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->kategori?->ket_kategori ?? '-' }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ Str::limit($item->ket_laporan ?? $item->keterangan, 30) }}</td>
                <td>
                    @if ($item->foto_bukti ?? $item->bukti)
                        <img
                            src="{{ asset('storage/' . ($item->foto_bukti ?? $item->bukti)) }}"
                            alt="Bukti"
                            class="bukti-img"
                        >
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="status-badge {{ strtolower($item->status) }}">
                        {{ $item->status }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="empty-table">
                    <a href="{{ route('admin.aspirasi') }}" class="empty-link">
                        Belum ada data aspirasi
                    </a>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="table-footer">
        <span>Menampilkan {{ $aspirasiTerbaru->count() }} data</span>

        <div class="pagination">
            <button disabled>&lt;</button>
            <button class="active">1</button>
            <button disabled>&gt;</button>
        </div>
    </div>

</div>

@endsection
