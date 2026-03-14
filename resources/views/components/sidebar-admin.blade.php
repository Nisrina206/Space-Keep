<aside class="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
    </div>

    <!-- MENU -->
    <nav class="sidebar-menu">

        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <img src="{{ asset('img/dashboard.png') }}">
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.aspirasi') }}"
           class="menu-item {{ request()->routeIs('admin.aspirasi') ? 'active' : '' }}">
            <img src="{{ asset('img/aspirasi.png') }}">
            <span>Aspirasi</span>
        </a>

        <a href="{{ route('admin.siswa') }}"
           class="menu-item {{ request()->routeIs('admin.siswa') ? 'active' : '' }}">
            <img src="{{ asset('img/siswa.png') }}">
            <span>Data Siswa</span>
        </a>

    </nav>

    <!-- FOOTER -->
    <div class="sidebar-footer">

        <div class="menu-item profil-toggle" id="profilToggle">
            <img src="{{ asset('img/profil.png') }}">
            <span>Profil</span>
        </div>

        <div class="admin-panel" id="adminPanel">
            <strong>ADMIN01</strong>
            <span>Sandi : admin123</span>

            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf

                <button type="button" class="logout-btn" id="btnLogout">
                    Logout
                </button>

            </form>

        </div>

    </div>

</aside>


<!-- POPUP LOGOUT -->
<div class="modal-overlay" id="logoutModal" style="display:none;">

    <div class="logout-modal">

        <img src="{{ asset('img/konfirmasi.png') }}" class="logout-icon">

        <h3>Logout</h3>
        <p>Apakah yakin ingin keluar?</p>

        <div class="logout-buttons">
    <button id="cancelLogout" class="btn-cancel">
        Batal
    </button>

    <button id="confirmLogout" class="btn-logout-confirm">
        Ya Logout
    </button>
</div>

    </div>

</div>

<style>

.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    backdrop-filter:blur(3px);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

/* BOX MODAL */
.logout-modal{
    background:#ffffff;
    padding:32px 28px;
    border-radius:14px;
    text-align:center;
    width:330px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
    animation:modalShow .25s ease;
}

/* ICON */
.logout-icon{
    width:48px;
    margin-bottom:12px;
}

/* TITLE */
.logout-modal h3{
    font-size:20px;
    font-weight:600;
    margin-bottom:6px;
}

/* TEXT */
.logout-modal p{
    font-size:14px;
    color:#666;
    margin-bottom:20px;
}

/* BUTTON WRAPPER */
.logout-buttons{
    display:flex;
    gap:10px;
}

/* BATAL */
.btn-cancel{
    flex:1;
    background:#e5e5e5;
    border:none;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    cursor:pointer;
    transition:.2s;
}

.btn-cancel:hover{
    background:#d6d6d6;
}

/* LOGOUT */
.btn-logout-confirm{
    flex:1;
    background:#ef4444;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    cursor:pointer;
    transition:.2s;
}

.btn-logout-confirm:hover{
    background:#dc2626;
}

/* ANIMASI */
@keyframes modalShow{
    from{
        transform:scale(.9);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

</style>


<script>

const btnLogout = document.getElementById("btnLogout");
const modal = document.getElementById("logoutModal");
const cancel = document.getElementById("cancelLogout");
const confirmLogout = document.getElementById("confirmLogout");

btnLogout.onclick = function(){
    modal.style.display = "flex";
}

cancel.onclick = function(){
    modal.style.display = "none";
}

confirmLogout.onclick = function(){
    document.getElementById("logoutForm").submit();
}

</script>