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

            <div class="form-group">
                <label>NIS Siswa<span class="required">*</span></label>
                <input type="text" value="{{ auth()->user()->nis }}" readonly>
            </div>

            <div class="form-group">
                <label>Lokasi<span class="required">*</span></label>
                <input type="text" name="lokasi" placeholder="Masukkan Lokasi" required>
            </div>

            <div class="form-group">
                <label>Nama Siswa<span class="required">*</span></label>
                <input type="text"
                       value="{{ auth()->user()->siswa?->nama_lengkap }}"
                       readonly>
            </div>

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

            <div class="form-group">
                <label>Bukti<span class="required">*</span></label>
                <input type="file" name="bukti" accept="image/*" required>
            </div>

        </div>

        <div class="form-group full">
            <label>Keterangan<span class="required">*</span></label>
            <textarea name="keterangan" placeholder="Masukkan Keterangan" required></textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('siswa.dashboard') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan</button>
        </div>

    </form>

</div>


{{-- ✅ MODAL SUCCESS --}}
@if (session('success'))
<div class="modal-overlay" id="successModal">
    <div class="success-modal">
        <h3>Berhasil! 🎉</h3>
        <p>{{ session('success') }}</p>
        <button id="btnOk">OK</button>
    </div>
</div>
@endif

@endsection

{{-- ✅ SCRIPT DI LUAR CONTENT (lebih aman) --}}
@if (session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('successModal');
    const btnOk = document.getElementById('btnOk');

    if (modal && btnOk) {
        btnOk.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    // 🔥 FALLBACK (anti gagal total)
    console.log("Session success:", @json(session('success')));
});
</script>
@endif