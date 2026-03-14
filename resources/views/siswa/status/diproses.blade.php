@extends('layouts.siswa')

@section('navbar-title', 'Status Diproses')

@section('content')

{{-- ================= WELCOME CARD ================= --}}
<div class="welcome-card">
    <div class="welcome-text">
        <h2>
            Selamat Datang,
            {{ auth()->user()->siswa?->nama_lengkap ?? 'Siswa' }}!
        </h2>
        <p>Kelola data dan fitur website dengan mudah di sini.</p>
    </div>

    <div class="welcome-image">
        <img src="{{ asset('img/siswa-banner.png') }}" alt="Welcome">
    </div>
</div>

{{-- ================= TABLE CARD ================= --}}
<div class="table-card">

    {{-- ================= TOOLBAR ================= --}}
    <div class="table-header">

        {{-- SEARCH --}}
        <div class="table-search">
            <img src="{{ asset('img/cari.png') }}">
            <input
                type="text"
                id="searchDiproses"
                placeholder="Cari berdasarkan NIS, Nama, Lokasi"
                autocomplete="off">
        </div>

        <div style="display:flex; gap:12px; align-items:center;">

            {{-- FILTER TANGGAL --}}
            <x-filter-tanggal 
                :action="route('siswa.status.diproses')" 
                :preserve="request()->only('sort')" 
            />

            {{-- SORT --}}
            <form method="GET" action="{{ route('siswa.status.diproses') }}" class="sort-wrapper">
    <input type="hidden" name="status" value="{{ request('status') }}">

    <span class="sort-label">Sort By</span>

    <select name="sort" class="sort-select" onchange="this.form.submit()">
        <option value="desc" {{ request('sort','desc') === 'desc' ? 'selected' : '' }}>
            Terbaru - Lama
        </option>
        <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>
            Lama - Terbaru
        </option>
    </select>
</form>

        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <table class="aspirasi-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Keterangan</th>
            <th>Lampiran</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>

        <tbody id="diprosesTable">
        @forelse($data as $item)
            <tr>
                <td>{{ $data->firstItem() + $loop->index }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                <td>{{ $item->siswa->nis }}</td>
                <td>{{ $item->siswa->nama_lengkap }}</td>
                <td>{{ $item->kategori->ket_kategori }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ \Illuminate\Support\Str::limit($item->ket_laporan, 40) }}</td>
                <td>
                    @if($item->foto_bukti)
                        <img src="{{ asset('storage/'.$item->foto_bukti) }}" class="bukti-img">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="status-badge diproses">Diproses</span>
                </td>
               <td class="aksi-cell">
                     <button
                        class="btn-aksi btn-detail"
                        data-nis="{{ $item->siswa->nis }}"
                        data-nama="{{ $item->siswa->nama_lengkap }}"
                        data-kategori="{{ $item->kategori->ket_kategori }}"
                        data-lokasi="{{ $item->lokasi }}"
                        data-keterangan="{{ $item->ket_laporan }}"
                        data-bukti="{{ $item->foto_bukti ? asset('storage/'.$item->foto_bukti) : '' }}"
                        data-status="{{ $item->status }}"
                        data-tanggal="{{ $item->created_at->format('d/m/Y') }}"
                    >
                        <img src="{{ asset('img/detail.png') }}">
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="empty-table">
                    Tidak ada data
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- ================= FOOTER ================= --}}
    <div class="table-footer">
        <span>
            Menampilkan {{ $data->firstItem() ?? 0 }}
            – {{ $data->lastItem() ?? 0 }}
            dari {{ $data->total() }} data
        </span>

        {{ $data->links('vendor.pagination.admin') }}
    </div>

</div>

{{-- ================= MODAL + ASSET ================= --}}
@include('siswa.aspirasi.modal-detail')

<link rel="stylesheet" href="{{ asset('css/modal-detail.css') }}">
<script src="{{ asset('js/modal-detail.js') }}"></script>

{{-- ================= LIVE SEARCH ================= --}}
<script>
const searchInput = document.getElementById('searchDiproses');
const tableBody   = document.getElementById('diprosesTable');
const footer      = document.querySelector('.table-footer');

let timer = null;

searchInput.addEventListener('keyup', function () {

    clearTimeout(timer);

    timer = setTimeout(() => {

        const keyword = this.value.trim();

        if (keyword === '') {
            location.reload();
            return;
        }

        fetch(`/siswa/status/diproses/search?search=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {

                tableBody.innerHTML = '';
                footer.style.display = 'none';

                if (!data.length) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="10" class="empty-table">
                                Data tidak ditemukan
                            </td>
                        </tr>`;
                    return;
                }

                data.forEach((item, index) => {

                    const tanggal = item.created_at.substring(0,10);

                    tableBody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${tanggal}</td>
                            <td>${item.siswa?.nis ?? '-'}</td>
                            <td>${item.siswa?.nama_lengkap ?? '-'}</td>
                            <td>${item.kategori?.ket_kategori ?? '-'}</td>
                            <td>${item.lokasi}</td>
                            <td>${item.ket_laporan}</td>
                            <td>
                                ${item.foto_bukti 
                                    ? `<img src="/storage/${item.foto_bukti}" class="bukti-img">`
                                    : '-'}
                            </td>
                            <td>
                                <span class="status-badge diproses">Diproses</span>
                            </td>
                            <td>
                                <button class="btn-aksi btn-detail"
                                    data-nis="${item.siswa?.nis ?? '-'}"
                                    data-nama="${item.siswa?.nama_lengkap ?? '-'}"
                                    data-kategori="${item.kategori?.ket_kategori ?? '-'}"
                                    data-lokasi="${item.lokasi}"
                                    data-keterangan="${item.ket_laporan}"
                                    data-bukti="${item.foto_bukti ? '/storage/'+item.foto_bukti : ''}"
                                    data-status="${item.status}"
                                    data-tanggal="${tanggal}"
                                >
                                    <img src="/img/detail.png">
                                </button>
                            </td>
                        </tr>`;
                });
            });

    }, 300);
});
</script>

@endsection
