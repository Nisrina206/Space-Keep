<aside class="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
    </div>

    <!-- MENU -->
    <nav class="sidebar-menu">

        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <img src="{{ asset('img/dashboard.png') }}">
            <span>Dashboard</span>
        </a>

        {{-- ASPIRASI --}}
        <a href="{{ route('admin.aspirasi') }}"
           class="menu-item {{ request()->routeIs('admin.aspirasi') ? 'active' : '' }}">
            <img src="{{ asset('img/aspirasi.png') }}">
            <span>Aspirasi</span>
        </a>

        {{-- DATA SISWA --}}
        <a href="{{ route('admin.siswa') }}"
           class="menu-item {{ request()->routeIs('admin.siswa') ? 'active' : '' }}">
            <img src="{{ asset('img/siswa.png') }}">
            <span>Data Siswa</span>
        </a>

    </nav>

    <!-- FOOTER -->
    <div class="sidebar-footer">

        <!-- TOMBOL PROFIL -->
        <div class="menu-item profil-toggle" id="profilToggle">
            <img src="{{ asset('img/profil.png') }}">
            <span>Profil</span>
        </div>

        <!-- PANEL ADMIN -->
        <div class="admin-panel" id="adminPanel">
            <strong>ADMIN01</strong>
            <span>Sandi : admin123</span>

            <!-- FORM LOGOUT (POST - BENAR LARAVEL) -->
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
    @csrf

    <button type="button" class="logout-btn" id="btnLogout">
        Logout
    </button>
</form>
        </div>

    </div>
<script>
document.getElementById('btnLogout').addEventListener('click', function () {

    const yakin = confirm('Apakah yakin ingin keluar?');

    if (yakin) {
        document.getElementById('logoutForm').submit();
    }

});
</script>
</aside>
