<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter-tanggal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/history-admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

<div class="admin-wrapper">

    <x-sidebar-admin />

    <div class="admin-main">

        <x-navbar-admin />

        <div class="admin-content">
            @yield('content')
        </div>

    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/aspirasi-tab.js') }}" defer></script>
<script src="{{ asset('js/filter-tanggal.js') }}" defer></script>
<script src="{{ asset('js/aspirasi-live-search.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ================= PROFIL TOGGLE ================= */
    const profilToggle = document.getElementById('profilToggle');
    const adminPanel   = document.getElementById('adminPanel');

    if (profilToggle && adminPanel) {
        profilToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            adminPanel.classList.toggle('show');
        });

        document.addEventListener('click', function () {
            adminPanel.classList.remove('show');
        });
    }

    /* ================= NOTIF TOGGLE ================= */
    const notifToggle = document.getElementById('notifToggle');
    const notifPanel  = document.getElementById('notifPanel');

    if (notifToggle && notifPanel) {
        notifToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            notifPanel.classList.toggle('show');
        });

        document.addEventListener('click', function () {
            notifPanel.classList.remove('show');
        });
    }

    /* ================= SISTEM NOTIF REALTIME ================= */
    const panelBody = document.querySelector('.notif-body');
    let notifInterval = null;

    function loadNotifikasi() {
        fetch('/admin/notifikasi')
            .then(res => res.json())
            .then(data => {

                if (!panelBody) return;

                panelBody.innerHTML = '';

                if (data.length === 0) {
                    panelBody.innerHTML =
                        '<div class="notif-item">Tidak ada notifikasi</div>';
                } else {
                    data.forEach(item => {
                        panelBody.innerHTML += `
                            <div class="notif-item">
                                <b>${item.judul}</b>
                                <span>${item.pesan}</span>
                            </div>
                        `;
                    });
                }

            })
            .catch(err => console.log('Notif error:', err));
    }

    function startNotif() {
        loadNotifikasi();
        notifInterval = setInterval(loadNotifikasi, 5000);
    }

    /* ================= POPUP SUCCESS ================= */

    @if(session('success'))

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            startNotif(); // notif aktif setelah popup ditutup
        });

    @else
        startNotif(); // langsung aktif kalau tidak ada popup
    @endif

});
</script>



</body>
</html>