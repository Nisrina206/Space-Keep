<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 4 Bojonegoro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        /* 1. Global Reset & Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #003F3F; 
            overflow: hidden;
        }

        /* 2. Background Hero & Segitiga Pojok Perkecil */
        .hero-section {
            width: 100%;
            height: 100vh;
            background: 
                linear-gradient(225deg, #4EF5C6 0%, #4EF5C6 3%, rgba(78, 245, 198, 0.3) 8%, transparent 20%),
                linear-gradient(135deg, #003F3F 20%, #279A82 100%);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* 3. Navbar - Jarak Dekat ke Teks */
        .navbar {
            padding: 30px 80px 5px 80px; 
            z-index: 10;
        }

        .logo-container { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }

        .logo-img { 
            width: 180px; 
            height: auto; 
        }

        /* 4. Layout Konten */
        .content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 80px;
            height: 80vh; 
        }

        .text-side h1 {
            color: #ffffff;
            font-size: 4.8rem;
            font-weight: 650;
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .text-side h1 span {
            color: #4EF5C6;
        }

        .description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.05rem;
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        /* 5. Button Styling */
        .btn-start {
            display: inline-block;
            padding: 14px 45px;
            font-size: 1rem;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 30px; /* Dibuat lebih bulat/tidak kotak */
            background: linear-gradient(to right, #006060 0%, #279A82 45%, #4EF5C6 100%);
            border: 1.5px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            transition: 0.3s ease;
        }

        /* Tombol Daftar Sekarang - Border Putih & Lebih Bulat */
        .btn-register {
            display: inline-block;
            padding: 14px 45px;
            font-size: 1rem;
            color: #ffffff; 
            text-decoration: none;
            font-weight: 600;
            border-radius: 30px; /* Dibuat lebih bulat/tidak kotak */
            border: 2px solid #ffffff; /* Garis tepi menjadi PUTIH */
            margin-left: 15px;
            transition: 0.3s ease;
        }

        .btn-start:hover, .btn-register:hover {
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.1); 
        }

        /* 6. Image Side & Posisi Gambar Geser */
        .image-side {
            flex: 1.5; 
            display: flex;
            justify-content: flex-end; 
            align-items: center;
        }

        .hero-img {
            width: 200%;
            max-width: 700px; 
            filter: drop-shadow(-20px 20px 50px rgba(0,0,0,0.3));
            transform: translateX(140px); 
            animation: floating 6s ease-in-out infinite;
        }

        /* 7. Animasi Melayang */
        @keyframes floating {
            0%, 100% { transform: translate(140px, 0px); }
            50% { transform: translate(140px, -20px); }
        }

        /* 8. Responsive */
        @media (max-width: 992px) {
            .content { flex-direction: column; text-align: center; height: auto; padding: 40px; }
            .image-side { display: none; }
            .btn-register { margin-left: 0; margin-top: 15px; }
        }
    </style>

    <div class="hero-section">
        <nav class="navbar">
            <div class="logo-container">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img">
            </div>
        </nav>

        <main class="content">
            <div class="text-side">
                <h1>UBAH KELUHAN<br>MENJADI <span>PERUBAHAN</span></h1>
                
                <p class="description">
                    Membangun sinergi antara siswa dan sekolah. SpaceKeep hadir sebagai wadah pelaporan<br>
                    yang transparan, memudahkan siswa menyampaikan aspirasi sekaligus membantu<br>
                    admin mengelola pemeliharaan fasilitas secara terukur.
                </p>

                <div class="btn-group">
                    <a href="{{ route('login') }}" class="btn-start">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar Sekarang</a>
                </div>
            </div>
            
            <div class="image-side">
                <img src="{{ asset('img/Spacekeep.png') }}" alt="SpaceKeep Illustration" class="hero-img">
            </div>
        </main>
    </div>
</body>
</html>