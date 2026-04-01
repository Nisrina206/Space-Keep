<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="overlay"></div>

    <div class="auth-card"> 

        <!-- HEADER -->
        <div class="auth-header">
            <img src="{{ asset('img/logo.png') }}" class="logo">
        </div>

        <h2>Registrasi Akun</h2>
        <p class="subtitle">Silakan lengkapi data berikut!</p>

        <!-- FORM -->
        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <!-- NIS -->
            <div class="row">
                <div class="form-group {{ $errors->has('nis') ? 'error' : '' }}">
                    <label>NIS<span>*</span></label>
                    <input
                        type="text"
                        name="nis"
                        value="{{ old('nis') }}"
                        placeholder="Masukkan NIS..."
                    >
                    @error('nis')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <!-- NAMA LENGKAP -->
                <div class="form-group {{ $errors->has('nama_lengkap') ? 'error' : '' }}">
                    <label>Nama Lengkap<span>*</span></label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        placeholder="Masukkan Nama Lengkap..."
                    >
                    @error('nama_lengkap')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- KELAS -->
            <div class="form-group {{ $errors->has('kelas') ? 'error' : '' }}">
                <label>Kelas / Jurusan<span>*</span></label>
                <input
                    type="text"
                    name="kelas"
                    value="{{ old('kelas') }}"
                    placeholder="Contoh: XII RPL 1"
                >
                @error('kelas')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <!-- PASSWORD & KONFIRMASI -->
            <div class="row">
                <div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
                    <label>Sandi<span>*</span></label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan Sandi..."
                        >
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword(this)"></i>
                    </div>
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                    <label>Konfirmasi Sandi<span>*</span></label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Masukkan Konfirmasi..."
                        >
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword(this)"></i>
                    </div>
                    @error('password_confirmation')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-primary">Register</button>
        </form>

        <p class="switch">
            Sudah memiliki akun? <a href="/login">Login!</a>
        </p>

    </div>
</div>

<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
