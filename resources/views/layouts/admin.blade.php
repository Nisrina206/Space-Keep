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

<script src="{{ asset('js/aspirasi-tab.js') }}" defer></script>
<script src="{{ asset('js/filter-tanggal.js') }}" defer></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/modal-reset-sandi.js') }}"></script>
<script src="{{ asset('js/aspirasi-live-search.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('profilToggle');
    const panel  = document.getElementById('adminPanel');

    if (!toggle || !panel) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        panel.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        panel.classList.remove('show');
    });

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('notifToggle');
    const panel  = document.getElementById('notifPanel');

    if (!toggle || !panel) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        panel.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        panel.classList.remove('show');
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const panelBody = document.querySelector('.notif-body');

    function loadNotifikasi() {
        fetch('/admin/notifikasi')
            .then(res => res.json())
            .then(data => {

                panelBody.innerHTML = '';

                data.forEach(item => {
                    panelBody.innerHTML += `
                        <div class="notif-item">
                            <b>${item.judul}</b>
                            <span>${item.pesan}</span>
                        </div>
                    `;
                });

            });
    }

    /* LOAD AWAL */
    loadNotifikasi();

    /* REALTIME LOOP */
    setInterval(loadNotifikasi, 5000); // tiap 5 detik

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function loadNotifAdmin() {
        fetch('/notifikasi/admin')
            .then(res => res.json())
            .then(data => {

                const body = document.querySelector('.notif-body');
                if (!body) return;

                body.innerHTML = '';

                data.forEach(item => {
                    body.innerHTML += `
                        <div class="notif-item">
                            <b>${item.judul}</b>
                            <span>${item.pesan}</span>
                        </div>
                    `;
                });

            });
    }

    loadNotifAdmin();
    setInterval(loadNotifAdmin, 5000);

});
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</body>
</html>