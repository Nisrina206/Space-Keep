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
            <img src="{{ request()->routeIs('admin.dashboard*') 
                ? asset('img/dashboard-active.png') 
                : asset('img/dashboard.png') }}">
            <span>Dashboard</span>
        </a>

        {{-- ASPIRASI --}}
        <a href="{{ route('admin.aspirasi') }}"
           class="menu-item {{ request()->routeIs('admin.aspirasi') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('admin.aspirasi*') 
                ? asset('img/aspirasi-active.png') 
                : asset('img/aspirasi.png') }}">
            <span>Aspirasi</span>
        </a>

        {{-- DATA SISWA --}}
        <a href="{{ route('admin.siswa') }}"
           class="menu-item {{ request()->routeIs('admin.siswa') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('admin.siswa*') 
                ? asset('img/siswa-active.png') 
                : asset('img/siswa.png') }}">
            <span>Data Siswa</span>
        </a>

    </nav>

    <!-- FOOTER -->
    <div class="sidebar-footer">

        <!-- TOMBOL PROFIL -->
        <div class="menu-item profil-toggle" id="profilToggle">
            <img src="{{ asset('img/profil.png') }}" 
                alt="Profile" 
                class="profile-icon" 
                id="profileImage">
                <script>
                    document.getElementById('profileImage').addEventListener('click', function() {
                        // Toggle class
                        this.classList.toggle('active');
                        
                        // Ganti gambar berdasarkan class
                        if (this.classList.contains('active')) {
                            this.src = "{{ asset('img/profil-active.png') }}"; // Gambar saat aktif/diklik
                        } else {
                            this.src = "{{ asset('img/profil.png') }}"; // Gambar default
                        }
                    });
                </script>
            <span>Profil</span>
        </div>

        <!-- PANEL ADMIN -->
        <div class="admin-panel" id="adminPanel">
            <strong>ADMIN01</strong>
            <span>Sandi : admin123</span>

            <!-- FORM LOGOUT (POST - BENAR LARAVEL) -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>

    </div>

</aside>