@extends('layouts.siswa')

@section('navbar-title', 'Profil')

@section('content')

{{-- ================= WELCOME CARD ================= --}}
<div class="welcome-card">
    <div class="welcome-text">
        <h2>Selamat Datang, {{ $siswa->nama_lengkap }}!</h2>
        <p>Kelola profil dan ubah kata sandi akunmu di halaman ini.</p>
    </div>

    <div class="welcome-image">
        <img src="{{ asset('img/siswa-banner.png') }}" alt="Banner">
    </div>
</div>

{{-- ================= PROFILE CARD ================= --}}
<div class="table-card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
        <h3>Profil Siswa</h3>

        <form method="POST" action="{{ route('siswa.logout') }}" id="logoutForm">
    @csrf
    <button type="button" class="btn-logout" id="btnLogout">
        <img src="{{ asset('img/logout.png') }}">
        Logout
    </button>
</form>
    </div>

    <hr style="margin-bottom:25px;">

    <div class="profil-row">
        <span>Nama Lengkap</span>
        <strong>{{ $siswa->nama_lengkap }}</strong>
    </div>

    <div class="profil-row">
        <span>NIS</span>
        <strong>{{ $siswa->nis }}</strong>
    </div>

</div>

{{-- ================= PASSWORD CARD ================= --}}
<div class="table-card">

    <h3>Ganti Kata Sandi</h3>
    <hr style="margin:15px 0 25px;">

    <form method="POST" action="{{ route('siswa.password.update') }}">
        @csrf

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Masukkan sandi baru">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" placeholder="Masukkan konfirmasi sandi baru">
        </div>

        <button class="btn-save">Simpan</button>
    </form>

</div>

{{-- ================= SUCCESS MODAL ================= --}}
@if(session('success'))
<div class="modal-overlay">
    <div class="success-modal">
        <img src="{{ asset('img/success.png') }}" class="success-icon">
        <h3>Password Berhasil Diperbarui</h3>
        <p>Kata sandi akunmu sudah berhasil diperbarui.</p>
        <button onclick="location.reload()">OK</button>
    </div>
</div>
@endif

<script>
document.getElementById('btnLogout').addEventListener('click', function () {

    const yakin = confirm('Apakah yakin ingin keluar?');

    if (yakin) {
        document.getElementById('logoutForm').submit();
    }

});
</script>
@endsection