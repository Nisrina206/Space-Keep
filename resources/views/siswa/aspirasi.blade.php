@extends('layouts.siswa')

@section('navbar-title', 'Aspirasi')

@section('content')

<div class="aspirasi-card">

    <div class="aspirasi-header">
        <h2>Tambah Aspirasi</h2>
        <p>Tambah data aspirasi baru</p>
    </div>

    <form action="{{ route('siswa.aspirasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">

            {{-- NIS AUTO --}}
            <div class="form-group">
                <label>NIS Siswa<span class="required">*</span></label>
                <input type="text" value="{{ auth()->user()->nis }}" readonly>
            </div>

            {{-- LOKASI --}}
            <div class="form-group">
                <label>Lokasi<span class="required">*</span></label>
                <input type="text" name="lokasi" placeholder="Masukkan Lokasi" required>
            </div>

            {{-- NAMA AUTO --}}
            <div class="form-group">
                <label>Nama Siswa<span class="required">*</span></label>
                <input type="text"
                       value="{{ auth()->user()->siswa?->nama_lengkap }}"
                       readonly>
            </div>

            {{-- KATEGORI --}}
            <div class="form-group">
                <label>Kategori<span class="required">*</span></label>
                <select name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id_kategori }}">
                            {{ $item->ket_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BUKTI --}}
            <div class="form-group">
                <label>Lampiran<span class="required">*</span></label>
                <input type="file" name="bukti" required>
            </div>

        </div>

        {{-- KETERANGAN --}}
        <div class="form-group full">
            <label>Keterangan<span class="required">*</span></label>
            <textarea name="keterangan" placeholder="Masukkan Keterangan" required></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="form-actions">
            <a href="{{ route('siswa.dashboard') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan</button>
        </div>

    </form>

</div>

@if (session('success'))
<div class="modal-overlay" id="successModal">
    <div class="success-modal">
        <h3>Berhasil! 🎉</h3>
        <p>Aspirasi Anda telah tersimpan dengan status <b>menunggu</b></p>
        <button onclick="closeModal()">OK</button>
    </div>
</div>
@endif

<script>
function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}
</script>

@endsection
