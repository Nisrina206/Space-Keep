<div class="siswa-navbar">
    <div class="navbar-left">
        <h1 class="navbar-title">
            @yield('navbar-title', 'Dashboard')
        </h1>
    </div>

    <div class="navbar-icons">

        <div class="notif-wrapper">

            <img src="{{ asset('img/notif.png') }}" 
                 alt="Notifikasi"
                 id="notifButton"
                 class="notif-icon">

            <span id="notifBadge" class="notif-badge">0</span>

            <div id="notifDropdown" class="notif-dropdown">
                <div id="notifContainer">
                    <div class="notif-item">Memuat...</div>
                </div>
            </div>

        </div>

    </div>
</div>