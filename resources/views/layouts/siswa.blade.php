<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar-siswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter-tanggal.css') }}">
</head>
<body>

<div class="siswa-wrapper">

    {{-- SIDEBAR --}}
    <x-sidebar-siswa />

    <div class="siswa-main">

        {{-- NAVBAR --}}
        <x-navbar-siswa />

        {{-- CONTENT --}}
        <div class="siswa-content">
            @yield('content')
        </div>

    </div>
</div>

{{-- ================= STATUS SIDEBAR ================= --}}
<script>
    const toggle = document.getElementById('statusToggle');
    const submenu = document.getElementById('statusSubmenu');

    if (toggle) {
        toggle.addEventListener('click', () => {
            submenu.classList.toggle('show');
            toggle.classList.toggle('open');
        });
    }
</script>

<script src="{{ asset('js/filter-tanggal.js') }}" defer></script>

{{-- ================= NOTIFIKASI SISWA ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const notifButton   = document.getElementById('notifButton');
    const notifDropdown = document.getElementById('notifDropdown');

    if (notifButton && notifDropdown) {
        notifButton.addEventListener('click', () => {
            notifDropdown.style.display =
                notifDropdown.style.display === 'block' ? 'none' : 'block';
        });
    }

    function loadNotifikasiSiswa() {

        fetch('/notifikasi/siswa')
            .then(res => res.json())
            .then(data => {

                const container = document.getElementById('notifContainer');
                const badge     = document.getElementById('notifBadge');

                if (!container) return;

                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML =
                        '<div class="notif-item">Tidak ada notifikasi</div>';
                } else {
                   data.forEach(item => {
    container.innerHTML += `
        <a href="/siswa/status/menunggu#aspirasi-${item.id_aspirasi}" 
           style="text-decoration:none; color:inherit;">
            <div class="notif-item">
                <div><b>${item.judul}</b></div>
                <div>${item.pesan}</div>
            </div>
        </a>
    `;
});
                }

                if (badge) badge.innerText = data.length;

            })
            .catch(err => console.log('Notif error:', err));
    }

    let notifInterval = null;

    function startNotif() {
        loadNotifikasiSiswa();
        notifInterval = setInterval(loadNotifikasiSiswa, 3000);
    }

    // ===============================
    // HANDLE POPUP + NOTIF
    // ===============================

    @if(session('success'))

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            // Setelah popup ditutup baru notif jalan
            startNotif();
        });

    @else
        // Kalau tidak ada popup langsung jalan normal
        startNotif();
    @endif

});
</script>


</body>
</html>