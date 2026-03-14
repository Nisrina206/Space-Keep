@extends('layouts.admin')

@section('navbar-title', 'Edit Aspirasi')

@section('content')
<div class="card">
    <h3>Edit Aspirasi</h3>
    <p>Edit status aspirasi siswa</p>

    <form action="{{ route('admin.aspirasi.update', ['id' => $item->id_aspirasi]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid">

            <div>
                <label>NIS Siswa</label>
                <input type="text" value="{{ $item->siswa?->nis }}" readonly>
            </div>

            <div>
                <label>Nama Siswa</label>
                <input type="text" value="{{ $item->nama_siswa }}" readonly>
            </div>

            <div>
                <label>Lokasi</label>
                <input type="text" value="{{ $item->lokasi }}" readonly>
            </div>

            <div>
                <label>Tanggal</label>
                <input type="text" value="{{ $item->created_at->format('d-m-Y') }}" readonly>
            </div>

            <div>
                <label>Kategori</label>
                <input type="text" value="{{ $item->kategori?->ket_kategori }}" readonly>
            </div>

            <div class="bukti">
    <label>Lampiran</label>
    <img src="{{ asset('storage/'.$item->foto_bukti) }}">
</div>

<div class="keterangan">
    <label>Keterangan</label>
    <textarea readonly>{{ $item->ket_laporan }}</textarea>
</div>



            <div>
                <label>Status</label>
                <select name="status" required>
                    <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

        </div>

        <div class="btn-area">
            <a href="{{ route('admin.aspirasi') }}" class="btn-cancel-edit">Batal</a>
<button type="submit" class="btn-save-edit">Simpan</button>
</div>
    </form>
</div>

<link rel="stylesheet" href="{{ asset('css/edit-aspirasi.css') }}">
@endsection
