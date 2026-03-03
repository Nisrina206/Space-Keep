@extends('layouts.siswa')

@section('navbar-title', 'Dashboard')

@section('content')

{{-- ================= WELCOME CARD ================= --}}
<div class="welcome-card">
    <div class="welcome-text">
        <h2>
            Selamat Datang,
            {{ auth()->user()->siswa?->nama_lengkap ?? 'Siswa' }}!
        </h2>
        <p>Dashboard ini menampilkan ringkasan aspirasi dan status penanganan.</p>
    </div>

    <div class="welcome-image">
        <img src="{{ asset('img/siswa-banner.png') }}" alt="Welcome">
    </div>
</div>

{{-- ================= STATISTIK CARD ================= --}}
<div class="stat-grid">

    <a href="{{ route('siswa.status.menunggu') }}" class="stat-card blue card-link">
        <div class="stat-text">
            <span>Aspirasi Menunggu</span>
            <p>Total</p>
            <h3>{{ $aspirasiMenunggu }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/data.png') }}">
        </div>
    </a>

    <a href="{{ route('siswa.status.diproses') }}" class="stat-card yellow card-link">
        <div class="stat-text">
            <span>Aspirasi Diproses</span>
            <p>Total</p>
            <h3>{{ $aspirasiDiproses }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/proses.png') }}">
        </div>
    </a>

    <a href="{{ route('siswa.status.selesai') }}" class="stat-card green card-link">
        <div class="stat-text">
            <span>Aspirasi Selesai</span>
            <p>Total</p>
            <h3>{{ $aspirasiSelesai }}</h3>
        </div>
        <div class="stat-icon">
            <img src="{{ asset('img/selesai.png') }}">
        </div>
    </a>

</div>

{{-- ================= TABEL ASPIRASI ================= --}}
<div class="table-card">

    <div class="table-header">
        <h3>Status Aspirasi Terbaru Saya</h3>
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
                <th>Bukti</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($aspirasiTerbaru as $item)
            <tr
                 onclick="window.location='{{ route('siswa.status.menunggu') }}'"
                style="cursor:pointer"
            >
                <td>#{{ $item->id }}</td>

                <td>
                    {{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}
                </td>

                <td>{{ $item->siswa->nis ?? '-' }}</td>

                <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>

                <td>{{ $item->kategori->ket_kategori ?? '-' }}</td>

                <td>{{ $item->lokasi }}</td>

                <td>
                    {{ \Illuminate\Support\Str::limit($item->ket_laporan, 35) }}
                </td>

                {{-- ✅ BAGIAN YANG SUDAH DIPERBAIKI --}}
                <td>
                    @if ($item->foto_bukti)
                        <img
                            src="{{ Storage::url($item->foto_bukti) }}"
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
                <td colspan="9" class="empty-table">
                    Belum ada data aspirasi
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="table-footer">
        <span>Menampilkan {{ $aspirasiTerbaru->count() }} data</span>
    </div>

</div>

@endsection
