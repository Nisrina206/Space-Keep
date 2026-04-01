<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="login-wrapper">
    <div class="overlay"></div>

    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <img src="{{ asset('img/logo.png') }}" class="logo">
        </div>

        <h2>Login</h2>
        <p class="subtitle">Silakan lengkapi data berikut!</p>

        <!-- FORM -->
        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <!-- NIS / USERNAME -->
            <div class="form-group @error('login') error @enderror">
                <label>NIS / Username<span>*</span></label>

                <input
                    type="text"
                    name="login"
                    value="{{ old('login') }}"
                    placeholder="Masukkan NIS atau Username..."
                    required
                >

                @error('login')
                    <small class="error-text">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-group @error('password') error @enderror">
                <label>Sandi<span>*</span></label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan Password..."
                        required
                    >

                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>

                @error('password')
                    <small class="error-text">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <!-- REGISTER -->
        <p class="register-text">
            Belum punya akun?
            <a href="/register">Register!</a>
        </p>

    </div>
</div>

<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
