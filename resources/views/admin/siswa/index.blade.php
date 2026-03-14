@extends('layouts.admin')

@section('navbar-title', 'Data Siswa')

@section('content')

{{-- ================= WELCOME CARD ================= --}}
<div class="welcome-card">

    <div class="welcome-text">
        <h2>Selamat Datang, Admin!</h2>
        <p>Lihat dan kelola detail data siswa yang ditampilkan dalam tabel.</p>
    </div>

    <div class="welcome-image">
        <img src="{{ asset('img/admin.png') }}" alt="Welcome">
    </div>

</div>


{{-- ================= TABLE CARD ================= --}}
<div class="table-card">

    <div class="table-header">

        <h3>Detail Data Siswa</h3>

        <div class="table-search">
            <img src="{{ asset('img/cari.png') }}">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari berdasarkan NIS, Nama, Kelas"
                autocomplete="off"
            >
        </div>

    </div>


    {{-- TABLE --}}
    <table class="aspirasi-table">

        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="siswaTable">

            @forelse ($siswa as $item)

            <tr>

                <td>{{ $siswa->firstItem() + $loop->index }}</td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->kelas }}</td>

                <td class="aksi-cell">

                    <form id="resetForm{{ $item->id }}" action="{{ route('admin.siswa.reset', $item->id) }}" method="POST">
                        @csrf

                        <button
                            type="button"
                            class="btn-reset-sandi"
                            onclick="openConfirm({{ $item->id }})"
                        >
                            <img src="{{ asset('img/kunci.png') }}">
                            <span>Reset Sandi</span>
                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="empty-text">
                    Data siswa belum ada
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>


    {{-- PAGINATION --}}
    <div class="table-footer">

        <span>
            Menampilkan {{ $siswa->firstItem() ?? 0 }}
            – {{ $siswa->lastItem() ?? 0 }}
            dari {{ $siswa->total() }} data
        </span>

        {{ $siswa->links('vendor.pagination.admin') }}

    </div>

</div>



{{-- ================= MODAL KONFIRMASI RESET ================= --}}
<div class="modal-overlay" id="confirmResetModal" style="display:none;">

    <div class="modal-card">

        <div class="modal-icon danger">!</div>

        <h3>Reset Sandi</h3>
        <p>Yakin ingin reset sandi siswa ini?</p>

        <div class="modal-actions">

            <button class="btn-cancel" onclick="closeConfirm()">
                Batal
            </button>

            <button class="btn-danger" onclick="confirmReset()">
                Ya, Reset
            </button>

        </div>

    </div>

</div>



{{-- ================= MODAL SUKSES ================= --}}
<div
    class="modal-overlay"
    id="successResetModal"
    style="display:none;"
    onclick="closeSuccess()"
>

    <div
        class="modal-card success"
        onclick="event.stopPropagation()"
    >

        <div class="modal-icon success">✓</div>

        <h3>Reset Berhasil</h3>

        <p class="success-desc">
            Sandi baru untuk siswa ini:
        </p>

        <div class="password-box">

            <span id="newPasswordText"></span>

        </div>

        <div class="modal-actions">

            <button class="btn-copy" onclick="copyPassword()">
                Salin Password
            </button>

            <button class="btn-ccl" onclick="closeSuccess()">
                Tutup
            </button>

        </div>

    </div>

</div>



{{-- ================= SESSION PASSWORD ================= --}}
@if(session('passwordBaru'))

<script>

window.onload = function(){

    document.getElementById("newPasswordText").innerText = "{{ session('passwordBaru') }}";

    document.getElementById("successResetModal").style.display = "flex";

}

</script>

@endif



{{-- ================= JAVASCRIPT ================= --}}
<script>

let selectedId = null;

function openConfirm(id){
    selectedId = id;
    document.getElementById("confirmResetModal").style.display = "flex";
}

function closeConfirm(){
    document.getElementById("confirmResetModal").style.display = "none";
}

function confirmReset(){
    document.getElementById("resetForm"+selectedId).submit();
}

function closeSuccess(){
    document.getElementById("successResetModal").style.display = "none";
}

function copyPassword(){

    let password = document.getElementById("newPasswordText").innerText;

    navigator.clipboard.writeText(password);

}

</script>

@endsection