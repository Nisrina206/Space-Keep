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
                            <div class="notif-item">
                                <div><b>${item.judul}</b></div>
                                <div>${item.pesan}</div>
                            </div>
                        `;
                    });
                }

                if (badge) badge.innerText = data.length;

            })
            .catch(err => console.log('Notif error:', err));
    }

    setInterval(loadNotifikasiSiswa, 3000);
    loadNotifikasiSiswa();
});
</script>

</body>
</html>